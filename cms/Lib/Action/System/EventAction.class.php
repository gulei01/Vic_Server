<?php
/**
 * Created by PhpStorm.
 * User: Garfunkel
 * Date: 2019/8/20
 * Time: 20:00
 */

class EventAction extends BaseAction
{
    public function index(){
        $event_list = D('New_event')->getEventList(-1);
        $this->assign('event_list',$event_list);
        $this->display();
    }

    public function add(){
        $this->display();
    }

    public function edit(){
        $event = D('New_event')->where(array('id'=>$_GET['id']))->find();
        $event['type_name'] = D('New_event')->getTypeName($event['type']);
        $this->assign('event',$event);
        $this->display('add');
    }

    public function modify(){
        $data['name'] = $_POST['name'];
        $data['desc'] = $_POST['desc'];
        $data['type'] = $_POST['type'];

        if($_POST['begin_time'])
            $data['begin_time'] = strtotime($_POST['begin_time']);
        else
            $data['begin_time'] = 0;

        if($_POST['end_time'])
            $data['end_time'] = strtotime($_POST['end_time']);
        else
            $data['end_time'] = 0;

        if($_POST){
            if($_POST['event_id'] && $_POST['event_id'] != 0){
                if(D('New_event')->checkEventType($data['type'],$_POST['event_id'])) {
                    $where['id'] = $_POST['event_id'];
                    D('New_event')->where($where)->save($data);
                    $this->frame_submit_tips(1, 'Success！');
                }
                $this->frame_submit_tips(0,'此活动类型已存在！');
            }else{
                if(D('New_event')->checkEventType($data['type'])){
                    D('New_event')->add($data);
                    $this->frame_submit_tips(1, 'Success！');
                }else{
                    $this->frame_submit_tips(0,'此活动类型已存在！');
                }
            }
        }
    }

    public function coupon_list(){
        $event_id = $_GET['id'];
        if($event_id){
            $event = D('New_event')->where(array('id'=>$event_id))->find();
            $this->assign('event',$event);

            $coupon_list = D('New_event_coupon')->where(array('event_id'=>$event_id))->select();
            foreach ($coupon_list as &$v){
                $v = D('New_event')->getCouponUserNum($v);
            }
            $this->assign('coupon_list',$coupon_list);

            $this->display();
        }else{
            $this->error('未定义活动~');
        }
    }



    public function add_coupon(){
        if($_GET['event_id']){
            $event_id = $_GET['event_id'];
            $this->assign('event_id',$event_id);
            $this->display();
        }else{
            $this->frame_submit_tips(0,'请先选择活动！');
        }
    }

    public function edit_coupon(){
        if($_GET['id']) {
            $coupon = D('New_event_coupon')->where(array('id'=>$_GET['id']))->find();
            $this->assign('coupon',$coupon);
            $this->assign('event_id',$coupon['event_id']);
            $this->display('add_coupon');
        }else{
            $this->frame_submit_tips(0,'请先选择优惠券！');
        }
    }

    public function coupon_modify(){
        if ($_POST){
            $data['event_id'] = $_POST['event_id'];
            $data['name'] = $_POST['name'];
            $data['desc'] = $_POST['desc'];
            $data['use_price'] = $_POST['use_price'];
            $data['discount'] = $_POST['discount'];
            $data['limit_day'] = $_POST['limit_day'];
            $data['type'] = $_POST['type'];

            if($_POST['coupon_id'] != 0){
                D('New_event_coupon')->where(array('id'=>$_POST['coupon_id']))->save($data);
            }else{
                D('New_event_coupon')->add($data);
            }

            $this->frame_submit_tips(1, 'Success！');
        }
    }
}