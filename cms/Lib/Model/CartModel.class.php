<?php
/**
 * Created by PhpStorm.
 * User: Garfunkel
 * Date: 2018/8/31
 * Time: 16:08
 */

class CartModel extends Model
{
    public function add_cart($uid,$fid,$num=1,$spec = "",$proper = ""){
        $data['uid'] = $uid;
        $data['fid'] = $fid;

        $good = D('Shop_goods')->field(true)->where(array('goods_id' => $fid))->find();
        $data['sid'] = $good['store_id'];

        $data['num'] = $num;
        $data['spec'] = $spec;
        $data['proper'] = $proper;
        $data['time'] = date("Y-m-d H:i:s");

        $item = $this->field(true)->where(array('uid'=>$uid,'fid'=>$fid,'spec'=>$spec,'proper'=>$proper))->find();

        if(empty($item)){
            $id = $this->data($data)->add();
        }else{
            $item['num'] += $num;
            $item['time'] = $data['time'];
            if ($item['num']<=0)
                $this->field(true)->where(array('itemId'=>$item['itemId']))->delete();
            else
                $this->field(true)->data($item)->where(array('itemId'=>$item['itemId']))->save();
        }

        return true;
    }

    public function get_cart($uid){
        $where['uid'] = $uid;

        $cartList = $this->field(true)->where($where)->order('itemId asc')->select();
        $result = array();

        $allnum = 0;
        $allmoney = 0;

        $resid = 0;

        $goodList = array();
        foreach($cartList as $v){
            $allnum += $v['num'];
            $good = D('Shop_goods')->field(true)->where(array('goods_id' => $v['fid']))->find();
            //获取规格价格
            $specData = D('Shop_goods')->format_spec_value($good['spec_value'], $good['goods_id'], $good['is_properties']);
            if($specData['list'] != "" && $v['spec'] != ""){
                foreach ($specData['list'] as $kk=>$vv){
                    if($v['spec'] == $kk){
                        $good['price'] = $vv['price'];
                    }
                }
            }

            $allmoney += $good['price']*$v['num'];
            if ($resid != $good['store_id']){
                $store = D('Store')->get_store_by_id($good['store_id']);

                $resid = $good['store_id'];

                if(!in_array($store,$result['info']))
                    $result['info'][] = $store;
            }
            $good['quantity'] = $v['num'];
            $good['spec'] = $v['spec'];
            $good['proper'] = $v['proper'];
            $goodList[] = $good;
        }
        $goodList = D('Store')->arrange_goods_for_goods($goodList);
        foreach($goodList as $v){
            //$good = D('Shop_goods')->field(true)->where(array('goods_id' => $v['fid']))->find();
            foreach($result['info'] as $kk => $vv){
                if ($vv['site_id'] == $v['sid']){
                    $result['info'][$kk]['foods'][] = $v;
                }
            }
        }


        $result['allnum'] = $allnum;
        $result['allmoney'] = $allmoney;

        return $result;
    }

    public function getCartList($uid,$cartList){
        $list = array();
        $total_price = 0;
        $total_market_price = 0;
        $total_pay_price = 0;

        foreach ($cartList as $v){
            $good = D('Shop_goods')->field(true)->where(array('goods_id' => $v['fid']))->find();
            $t_good['fname'] = lang_substr($good['name'],C('DEFAULT_LANG'));
            $t_good['stock'] = $v['stock'];

            //处理商品规格
            $t_good['spec'] = $v['spec'];
            $t_good['proper'] = $v['proper'];
            $specData = D('Shop_goods')->format_spec_value($good['spec_value'], $good['goods_id'], $good['is_properties']);
            if($specData['list'] != "" && $v['spec'] != ""){
                foreach ($specData['list'] as $kk=>$vv){
                    if($v['spec'] == $kk){
                        $good['price'] = $vv['price'];
                    }
                }
            }

            $spec_desc = "";
            if($t_good['spec'] != ""){
                $spec_list = explode("_",$t_good['spec']);
                foreach($spec_list as $vv){
                    $spec = D('Shop_goods_spec_value')->field(true)->where(array('id'=>$vv))->find();
                    $spec_desc = $spec_desc == '' ? lang_substr($spec['name'],C('DEFAULT_LANG')) : $spec_desc.','.lang_substr($spec['name'],C('DEFAULT_LANG'));
                }
            }
            $t_good['spec_desc'] = $spec_desc;

            $proper_desc = "";
            if($t_good['proper'] != ""){
                $pro_list = explode("_",$t_good['proper']);
                foreach ($pro_list as $vv){
                    $ids = explode(',',$vv);
                    $proId = $ids[0];
                    $sId = $ids[1];

                    $pro = D('Shop_goods_properties')->field(true)->where(array('id'=>$proId))->find();
                    $nameList = explode(',',$pro['val']);
                    $name = lang_substr($nameList[$sId],C('DEFAULT_LANG'));

                    $proper_desc = $proper_desc == '' ? $name : $proper_desc.','.$name;
                }
            }
            $t_good['proper_desc'] = $proper_desc;

            $t_good['attr'] = $spec_desc . " " .$proper_desc;
            $t_good['price'] = $good['price'];

            $total_price += $good['price'];
            $total_pay_price += $good['price'];
            $total_market_price += $good['old_price'];

            $list[] = $t_good;
        }

        $result['info'] = $list;

        $sid = $this->field(true)->where(array('uid'=>$uid,'fid'=>$cartList[0]['fid']))->find()['sid'];
        $store = D('Store')->get_store_by_id($sid);
        $result['packing_fee'] = $store['pack_fee'];
        $total_pay_price += $store['pack_fee'];
        //获取配送费
        $delivey_fee = D('Store')->CalculationDeliveryFee($uid,$sid);
        $result['ship_fee'] = $delivey_fee;
        $total_pay_price += $delivey_fee;
        //获取预计到达时间
        $delivery_time = D('Store')->get_store_delivery_time($sid);

        $result['expect_time'] = date('Y-m-d H:i',$delivery_time);
        $result['hongbao'] = array();
        $result['total_market_price'] = $total_market_price;
        $result['food_total_price'] = $total_price;
        $result['total_pay_price'] = $total_pay_price * 1.05;

        $result['full_discount'] = '0';

        return $result;
    }

    public function delCart($uid,$cartList){
        foreach($cartList as $v){
            $this->field(true)->where(array('uid'=>$uid,'fid'=>$v['fid']))->delete();
        }
    }
}