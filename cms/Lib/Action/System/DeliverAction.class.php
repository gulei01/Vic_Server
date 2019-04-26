<?php

/*
 * 用户中心
 *
 * @  Writers    yanleilei
 * @  BuildTime  2015/8/18 18:25
 * 
 */

class DeliverAction extends BaseAction {
	protected $deliver_user, $deliver_store, $deliver_location, $deliver_supply;
	
	protected function _initialize() {
		parent::_initialize();
		$this->deliver_user = D("Deliver_user");
		$this->deliver_store = D("Deliver_store");
		$this->deliver_location = D("Deliver_location");
		$this->deliver_supply = D("Deliver_supply");
	}
	/**
	 * 配送员列表
	 */
    public function user() {
        //搜索
        if (!empty($_GET['keyword'])) {
            if ($_GET['searchtype'] == 'uid') {
                $condition_user['uid'] = $_GET['keyword'];
            } else if ($_GET['searchtype'] == 'nickname') {
                $condition_user['name'] = array('like', '%' . $_GET['keyword'] . '%');
            } else if ($_GET['searchtype'] == 'phone') {
                $condition_user['phone'] = array('like', '%' . $_GET['keyword'] . '%');
            }
        }
        //garfunkel 判断城市管理员
        if($this->system_session['level'] == 3){
            $condition_user['city_id'] = $this->system_session['area_id'];
        }
        $condition_user['group'] = 1;
        $count_user = $this->deliver_user->where($condition_user)->count();
        import('@.ORG.system_page');
        $p = new Page($count_user, 15);
        $user_list = $this->deliver_user->field(true)->where($condition_user)->order('`uid` DESC')->limit($p->firstRow . ',' . $p->listRows)->select();
        
        $this->assign('user_list', $user_list);
        $pagebar = $p->show();
        $this->assign('pagebar', $pagebar);
        $this->display();
    }
    
    /**
     * 配送员添加
     */
    public function user_add() {
    	if($_POST){
    		$column['name'] = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
    		$column['phone'] = isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '';
    		$column['pwd'] = isset($_POST['pwd']) ? htmlspecialchars($_POST['pwd']) : '';
    		$column['store_id'] = 0;
    		$column['city_id'] = $_POST['city_id'];
            $area = D('Area')->where(array('area_id'=>$_POST['city_id']))->find();
            $column['province_id'] = $area ? $area['area_pid'] : 0;
    		//$column['province_id'] = $_POST['province_id'];
    		//$column['circle_id'] = $_POST['circle_id'];
            $column['circle_id'] = 0;
    		$column['area_id'] = 0;
    		$column['site'] = $_POST['adress'];
    		$long_lat = explode(',',$_POST['long_lat']);
    		$column['lng'] = $long_lat[0];
    		$column['lat'] = $long_lat[1];
    		$column['create_time'] = $_SERVER['REQUEST_TIME'];
    		$column['status'] = intval($_POST['status']);
    		$column['last_time'] = $_SERVER['REQUEST_TIME'];
    		$column['group'] = 1;
    		$column['range'] = intval($_POST['range']);

            $column['family_name'] = isset($_POST['family_name']) ? htmlspecialchars($_POST['family_name']) : '';
            $column['email'] = $_POST['email'];
            $column['language'] = intval($_POST['language']);

            $card['ahname'] = $_POST['ahname'];
            $card['transit'] = $_POST['transit'];
            $card['institution'] = $_POST['institution'];
            $card['account'] = $_POST['account'];

    		if (empty($column['name'])) {
    			$this->error('姓名不能为空');
    		}
    		if (empty($column['phone'])) {
    			$this->error('联系电话不能为空');
    		}
    		if (empty($column['pwd'])) {
    			$this->error('密码不能为空');
    		}
    		$column['pwd'] = md5($column['pwd']);
    		if (D('Deliver_user')->field(true)->where(array('phone' => $column['phone']))->find()) {
    			$this->error('该手机号已经是配送员账号了，不能重复申请');
    		}
    		$id = D('deliver_user')->data($column)->add();
    		if(!$id){
    			$this->error('保存失败，请重试');
    		}
    		//
    		$card['deliver_id'] = $id;
            D('Deliver_card')->data($card)->add();
    		$this->success('保存成功');
    	}
    	//garfunkel 判断城市管理员
        if($this->system_session['level'] == 3){
            $this->error('当前管理员没有此权限');
        }
    	$this->display();
    }
    
    /**
     * 配送员修改
     */
    public function user_edit() {
    	if($_POST){
    		$uid = intval($_POST['uid']);
    		$column['name'] = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
    		$column['phone'] = isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '';
    		$column['pwd'] = isset($_POST['pwd']) ? htmlspecialchars($_POST['pwd']) : '';
    		if($column['pwd']){
    			$column['pwd'] = md5($column['pwd']);
    		} else {
    			unset($column['pwd']);
    		}
    		$column['city_id'] = $_POST['city_id'];
            $area = D('Area')->where(array('area_id'=>$_POST['city_id']))->find();
            $column['province_id'] = $area ? $area['area_pid'] : 0;
    		//$column['province_id'] = $_POST['province_id'];
    		$column['circle_id'] = $_POST['circle_id'];
    		$column['area_id'] = 0;
    		$column['site'] = $_POST['adress'];
    		$long_lat = explode(',',$_POST['long_lat']);
    		$column['lng'] = $long_lat[0];
    		$column['lat'] = $long_lat[1];
    		$column['status'] = intval($_POST['status']);
    		$column['last_time'] = $_SERVER['REQUEST_TIME'];
    		$column['range'] = intval($_POST['range']);

            $column['family_name'] = isset($_POST['family_name']) ? htmlspecialchars($_POST['family_name']) : '';
            $column['email'] = $_POST['email'];
            $column['language'] = intval($_POST['language']);

            $card['ahname'] = $_POST['ahname'];
            $card['transit'] = $_POST['transit'];
            $card['institution'] = $_POST['institution'];
            $card['account'] = $_POST['account'];

    		if (empty($column['name'])) {
    			$this->error('姓名不能为空');
    		}
    		if (empty($column['phone'])) {
    			$this->error('联系电话不能为空');
    		}
    		$user = D('Deliver_user')->field(true)->where(array('phone' => $column['phone']))->find();
    		if ($user && $user['uid'] != $uid) {
    			$this->error('该手机号已经是配送员账号了，不能重复申请');
    		}
    		
    		if(D('deliver_user')->where(array('uid'=>$uid))->data($column)->save()){
    		    $card_id = D('Deliver_card')->field('id')->where(array('deliver_id'=>$uid))->find();
    		    if($card_id){
                    D('Deliver_card')->field(true)->where(array('deliver_id'=>$uid))->data($card)->save();
                }else{
    		        $card['deliver_id'] = $uid;
                    D('Deliver_card')->data($card)->add();
                }
    			$this->success('修改成功！');
    		}else{
    			$this->error('修改失败！请检查内容是否有过修改（必须修改）后重试~');
    		}
    	}else{
    		$uid = $_GET['uid'];
    		if(!$uid){
    			$this->error('非法操作');
    		}
    		$deliver = D('deliver_user')->where(array('uid'=>$uid))->find();
    		if(!$deliver){
    			$this->error('非法操作');
    		}
            $city = D('Area')->where(array('area_id'=>$deliver['city_id']))->find();
            $deliver['city_name'] = $city['area_name'];
    		$this->assign('now_user',$deliver);

    		$card = D('Deliver_card')->field(true)->where(array('deliver_id'=>$uid))->find();
    		$this->assign('card',$card);

            $deliver_img = D('Deliver_img')->field(true)->where(array('uid' => $uid))->find();
            $this->assign('img', $deliver_img);
    	}
    	$this->display();
    }

	//配送列表
	public function deliver_List()
	{
		$selectStoreId = I("selectStoreId", 0, 'intval');
		$selectUserId = I("selectUserId", 0, 'intval');
		$phone = I("phone", 0);
		$orderNum = I("orderNum", 0);
		


		
		

		//获取商家的所有配送员
		$delivers = D("Deliver_user")->field(true)->where(array('mer_id'=>$mer_id))->order('status DESC')->select();
		foreach ($delivers as $key => $val) {
			if ($val['status'] == 0) {
				$delivers[$key]['name'] = $val['name'] . " (已禁用)";
			}
		}
//         $db_arr = array(C('DB_PREFIX').'deliver_supply'=>'s',C('DB_PREFIX').'deliver_user'=>'u',C('DB_PREFIX').'waimai_order'=>'o',C('DB_PREFIX').'merchant_store'=>'m');
//         $fields = "o.order_id, o.order_number, s.name as username, s.phone as userphone, m.name as storename, o.discount_price, u.name, u.phone, s.start_time, s.end_time, o.create_time, s.aim_site, o.pay_type, o.paid, o.order_status, u.group";
//         $where = 'm.store_id=s.store_id AND s.uid=u.uid AND o.order_id=s.order_id';
		
		$db_arr = array(C('DB_PREFIX').'deliver_supply'=>'s',C('DB_PREFIX').'deliver_user'=>'u',C('DB_PREFIX').'merchant_store'=>'m');//,C('DB_PREFIX').'waimai_order'=>'o'
		$fields = "s.order_id, s.item, s.name as username, s.phone as userphone, m.name as storename, s.money, u.name, u.phone, s.start_time, s.end_time, s.aim_site, s.pay_type, s.paid, s.status, u.group";
		$where = 'm.store_id=s.store_id AND s.uid=u.uid';
		if ($phone) {
			$where .= " AND s.phone=".$phone;
		}
//         if ($orderNum) {
//             $where .= " AND o.order_number=".$orderNum;
//         }
        if ($selectStoreId) {
            $where .= " AND s.store_id=".$selectStoreId;
        }
        if ($selectUserId) {
            $where .= "  AND s.uid=".$selectUserId;
        }
        
        import('@.ORG.system_page');
        $count_order = D()->table($db_arr)->where($where)->count();
        $p = new Page($count_order, 20);
        $supply_info = D()->table($db_arr)->field($fields)->where($where)->order('s.`supply_id` DESC')->limit($p->firstRow.','.$p->listRows)->select();
        foreach ($supply_info as $key => $value) {
            $supply_info[$key]['create_time'] = date("Y-m-d H:i:s", $value['create_time']);
            if ($value['start_time']) {
                $supply_info[$key]['start_time'] = date("Y-m-d H:i:s", $value['start_time']);
            } else {
                $supply_info[$key]['start_time'] = '-';
            }
            if ($value['end_time']) {
                $supply_info[$key]['end_time'] = date("Y-m-d H:i:s", $value['end_time']);
            } else {
                $supply_info[$key]['end_time'] = '-';
            }
            $supply_info[$key]['paid'] = $value['paid'] == 1? "已支付": "未支付";
            $supply_info[$key]['group'] = $value['group'] == 1? "平台配送员": "店铺配送员";
            $supply_info[$key]['pay_type'] = $value['pay_type'] == "offline"? "线下支付": "线上支付";
            //订单状态（0：订单失效，1:订单完成，2：商家未确认，3：商家已确认，4已取餐，5：正在配送，6：退单,7商家取消订单,8配送员已接单）
            //配送状态(0失败 1等待接单 2接单 3取货 4开始配送 5完成）

            switch ($value['status']) {
                case 1:
                    $supply_info[$key]['order_status'] = "等待接单";
                    break;
                case 2:
                    $supply_info[$key]['order_status'] = "已接单";
                    break;
                case 3:
                    $supply_info[$key]['order_status'] = "已取货";
                    break;
                case 4:
                    $supply_info[$key]['order_status'] = "开始配送";
                    break;
                case 5:
                    $supply_info[$key]['order_status'] = "已完成";
                    break;
//                 case 6:
//                     $supply_info[$key]['order_status'] = "已退单";
//                     break;
//                 case 7:
//                     $supply_info[$key]['order_status'] = "已取消";
//                     break;
//                 case 68:
//                     $supply_info[$key]['order_status'] = "已接单";
                default:
                    $supply_info[$key]['order_status'] = "订单失效";
                    break;
            }
        }
        $pagebar = $p->show();
        $this->assign('selectStoreId', $selectStoreId);
        $this->assign('phone', $phone);
        $this->assign('orderNum', $orderNum);
        $this->assign('selectUserId', $selectUserId);
        $this->assign('stores', $stores);
        $this->assign('delivers', $delivers);
        $this->assign('pagebar', $pagebar);
        $this->assign('supply_info', $supply_info);

        $this->display();
	}
	
	
	public function deliverList() 
	{
		$selectStoreId = I("selectStoreId", 0, "intval");
		$selectUserId = I("selectUserId", 0, "intval");
		$phone = I("phone", 0);
		$orderNum = I("orderNum", 0);

		$status = I('status', 0, 'intval');
		$day = I('day', 0, 'intval');
		$period = I('period', '', 'htmlspecialchars');
		$stime = $etime = 0;
		if ($day) {
			$stime = strtotime("-{$day} day");
			$etime = time();
		}
		if ($period) {
			$time_array = explode('-', $period);
			$stime = strtotime($time_array[0]);
			$etime = strtotime($time_array[1]);
		}

		$sql = "SELECT s.`supply_id`, s.order_id, s.item, s.name as username, s.phone as userphone, m.name as storename, s.money, u.name, u.phone, s.start_time, s.end_time, s.aim_site, s.pay_type, s.paid, s.status, s.deliver_cash, s.distance, s.from_lat, s.aim_lat, s.from_lnt, s.aim_lnt FROM " . C('DB_PREFIX') . "merchant_store AS m INNER JOIN " . C('DB_PREFIX') . "deliver_supply AS s ON m.store_id=s.store_id LEFT JOIN " . C('DB_PREFIX') . "deliver_user AS u ON s.uid=u.uid";
		$sql_count = "SELECT count(1) AS count FROM " . C('DB_PREFIX') . "merchant_store AS m INNER JOIN " . C('DB_PREFIX') . "deliver_supply AS s ON m.store_id=s.store_id LEFT JOIN " . C('DB_PREFIX') . "deliver_user AS u ON s.uid=u.uid";

		$sql .= ' WHERE s.type=0';
		$sql_count .= ' WHERE s.type=0';

        //garfunkel 判断城市管理员
        if($this->system_session['level'] == 3){
            $sql .= " AND m.city_id=".$this->system_session['area_id'];
            $sql_count .= " AND m.city_id=".$this->system_session['area_id'];
        }

		if ($phone) {
			$sql .= " AND s.phone=".$phone;
			$sql_count .= " AND s.phone=".$phone;
		}
		
		if ($stime && $etime) {
			$sql .= " AND s.start_time>'{$stime}' AND s.start_time<'{$etime}'";
			$sql_count .= " AND s.start_time>'{$stime}' AND s.start_time<'{$etime}'";
		}
		if ($status) {
			$sql .= " AND s.status=".$status;
			$sql_count .= " AND s.status=".$status;
		}

		if ($selectStoreId) {
			$sql .= " AND s.store_id=".$selectStoreId;
			$sql_count .= " AND s.store_id=".$selectStoreId;
		}

		if ($selectUserId) {
			$sql .= "  AND s.uid=".$selectUserId;
			$sql_count .= "  AND s.uid=".$selectUserId;
		}

		import('@.ORG.system_page');
		$res_count = D()->query($sql_count);
		$count_order = isset($res_count[0]['count']) ? $res_count[0]['count'] : 0;

		$p = new Page($count_order, 20);
		$sql .= ' ORDER BY s.`supply_id` DESC LIMIT ' . $p->firstRow . ',' . $p->listRows;
		$supply_info = D()->query($sql);
		foreach ($supply_info as &$value) {
			$value['create_time'] = date("Y-m-d H:i:s", $value['create_time']);
			$value['start_time'] = $value['start_time'] ? date("Y-m-d H:i:s", $value['start_time']) : '-';
			$value['end_time'] = $value['end_time'] ? date("Y-m-d H:i:s", $value['end_time']) : '-';
			$value['paid'] = $value['paid'] == 1? L('_BACK_PAID_'): L('_STATUS_LIST_100_');
			$value['pay_type'] = $value['pay_type'] == "offline" ? "线下支付" : "线上支付";
			$value['distance'] = $value['distance'] ? $value['distance'] . 'km' : getRange(getDistance($value['from_lat'], $value['from_lnt'], $value['aim_lat'], $value['aim_lnt']));
			//订单状态（0：订单失效，1:订单完成，2：商家未确认，3：商家已确认，4已取餐，5：正在配送，6：退单,7商家取消订单,8配送员已接单）
			//配送状态(0失败 1等待接单 2接单 3取货 4开始配送 5完成）
		    switch ($value['status']) {
				case 1:
					$value['order_status'] = '<font color="red">'.L('_BACK_AWAIT_').'</font>';
                    //garfunkel 判断拒单
                    $assign = D('deliver_assign')->field(true)->where(array('supply_id'=>$value['supply_id']))->find();
                    if ($assign) {
                        $record_assign = explode(',', $assign['record']);
                        //获取全部上班的送餐员
                        $user_list = D('Deliver_user')->field(true)->where(array('status' => 1, 'work_status' => 0))->order('uid asc')->select();
                        //是否有未拒单的 1 有 0 无
                        $is_refect = 0;
                        foreach ($user_list as $deliver) {
                            if (!in_array($deliver['uid'], $record_assign)) {
                                $is_refect = 1;
                            }
                        }
                        //$value['order_status'] = "等待接单" . count($record_assign);
                        if ($is_refect == 0) {
                            $value['order_status'] = '<font color="red">等待接单(全部送餐员拒单)</font>';
                        }
                    }
					break;
				case 2:
					$value['order_status'] = L('_BACK_CONFIRMED_');
					break;
				case 3:
					$value['order_status'] = L('_BACK_PICKED_');
					break;
				case 4:
					$value['order_status'] = L('_BACK_IN_TRANSIT_');
					break;
				case 5:
					$value['order_status'] = L('_BACK_COMPLETED_');
					break;
				default:
					$value['order_status'] = L('_BACK_ORDER_FILED_');
					break;
			}
		}

		$pagebar = $p->show();
		$this->assign(array('status' => $status, 'day' => $day, 'period' => $period, 'phone' => $phone));
		$this->assign('selectStoreId', $selectStoreId);
		$this->assign('orderNum', $orderNum);
		$this->assign('selectUserId', $selectUserId);
		$this->assign('stores', $stores);
		$this->assign('delivers', $delivers);
		$this->assign('pagebar', $pagebar);
		$this->assign('supply_info', $supply_info);
		$this->display();
	}
    
    
    public function appoint_deliver()
    {
    	$supply_id = isset($_GET['supply_id']) ? intval($_GET['supply_id']) : 0;
    	$supply = D('Deliver_supply')->field(true)->where(array('supply_id' => $supply_id, 'type' => 0))->find();
    	if (empty($supply)) $this->error('不存在的数据');
    	if (IS_POST) {
    		if ($supply['status'] > 4) $this->error('配送已完成，不能重新指派了');
    		$uid = isset($_POST['uid']) ? intval($_POST['uid']) : 0;
    		$user = D('Deliver_user')->field(true)->where(array('uid' => $uid, 'group' => 1, 'status' => 1))->find();
    		if (empty($user)) $this->error('配送员不存在');
    		$status = $supply['status'] == 1 ? 2 : $supply['status'];
    		$save_data = array('uid' => $uid, 'status' => $status);
			if ($status == 2) {
				$save_data['start_time'] = time();
			}
    		if ($supply['uid']) {
    			$save_data['get_type'] = 2;
    			$save_data['change_log'] = $supply['change_log'] ? $supply['change_log'] . ',' . $supply['uid'] : $supply['uid'];
    		} else {
    			$save_data['get_type'] = 1;
    		}
    		$result = D('Deliver_supply')->where(array('supply_id' => $supply_id))->save($save_data);
    		if ($status == 2) {
    			if ($supply['item'] == 0) {
    				$result = D("Meal_order")->where(array('order_id' => $supply['order_id']))->data(array('order_status' => 8))->save();
    			} elseif ($supply['item'] == 2) {
    				$deliver_info = serialize(array('uid' => $user['uid'], 'name' => $user['name'], 'phone' => $user['phone'], 'store_id' => $user['store_id']));
    				$result = D("Shop_order")->where(array('order_id' => $supply['order_id']))->data(array('order_status' => 2, 'deliver_info' => $deliver_info))->save();
    				D('Shop_order_log')->add_log(array('order_id' => $supply['order_id'], 'status' => 3, 'name' => $user['name'], 'phone' => $user['phone']));
    			}
    		}
    		if ($user['openid']) {
				$model = new templateNews(C('config.wechat_appid'), C('config.wechat_appsecret'));
				$href = C('config.site_url').'/wap.php?c=Deliver&a=pick';
				$model->sendTempMsg('OPENTM405486394', array('href' => $href, 'wecha_id' => $user['openid'], 'first' => $user['name'] . '您好！', 'keyword1' => '系统分配一个配送订单给您，请注意及时查收。', 'keyword2' => date('Y年m月d日 H:s'), 'keyword3' => '订单号：' . $supply['real_orderid'], 'remark' => '请您及时处理！'));
    		}
    		$this->success('指派成功');
    	} else {
    		$store = D('Merchant_store')->field(true)->where(array('store_id' => $supply['store_id']))->find();
    		if (empty($store)) $this->error('店铺不存在');
    		$users = D('Deliver_user')->field(true)->where(array('circle_id' => $store['circle_id'], 'group' => 1, 'status' => 1))->select();
			$users || $users = D('Deliver_user')->field(true)->where(array('city_id' => $store['city_id'], 'group' => 1, 'status' => 1))->select();
			$users || $users = D('Deliver_user')->field(true)->where(array('province_id' => $store['province_id'], 'group' => 1, 'status' => 1))->select();
			if (empty($users)) $this->error('没有合适的配送员');
			
			$uids = '';
			$pre = '';
			$data = array();
			foreach ($users as $user) {
				$user['range'] = getRange(getDistance($supply['from_lat'], $supply['from_lnt'], $user['lat'], $user['lng']));
				$user['now_range'] = getRange(getDistance($supply['from_lat'], $supply['from_lnt'], $user['lat'], $user['lng']));
				$data[$user['uid']] = $user;
				$uids .= $pre . $user['uid'];
				$pre = ',';
			}
			$sql = "SELECT a.pigcms_id, a.uid, a.lat, a.lng FROM " . C('DB_PREFIX') . "deliver_user_location_log AS a INNER JOIN (SELECT uid, MAX(pigcms_id) AS pigcms_id FROM " . C('DB_PREFIX') . "deliver_user_location_log GROUP BY uid) AS b ON a.uid = b.uid AND a.pigcms_id = b.pigcms_id WHERE a.uid IN ({$uids})";
			$now_users = D()->query($sql);
			foreach ($now_users as $v) {
				if (isset($data[$v['uid']])) {
					$data[$v['uid']]['now_range'] = getRange(getDistance($supply['from_lat'], $supply['from_lnt'], $v['lat'], $v['lng']));
				}
			}
			$this->assign('users', $data);
			$this->display();
    	}
    }
    public function count_log()
    {
    	$uid = isset($_GET['uid']) ? intval($_GET['uid']) : 0;
    	$condition_user = array('mer_id' => 0, 'uid' => $uid);
        $user = $this->deliver_user->field(true)->where($condition_user)->find();
        if (empty($user)) $this->error('不存在的配送员');
        $deliver_count_obj = D('Deliver_count');
        $count = $deliver_count_obj->field(true)->where(array('uid' => $uid))->order('`id` DESC')->count();
        import('@.ORG.system_page');
        $p = new Page($count, 15);
        $count_list = $deliver_count_obj->field(true)->where(array('uid' => $uid))->order('`id` DESC')->limit($p->firstRow . ',' . $p->listRows)->select();
        foreach ($count_list as &$row) {
        	$row['today'] = date('Y-m-d', strtotime($row['today'] . '000000'));
        }
        $this->assign('count_list', $count_list);
        $pagebar = $p->show();
        $this->assign('pagebar', $pagebar);
        $this->assign('user', $user);
        $this->display();
    }
    
    public function log_list() 
    {
    	$uid = isset($_GET['uid']) ? intval($_GET['uid']) : 0;
		$begin_time = isset($_GET['begin_time']) ? htmlspecialchars($_GET['begin_time']) : '';
		$end_time = isset($_GET['end_time']) ? htmlspecialchars($_GET['end_time']) : '';
    	$condition_user = array('mer_id' => 0, 'uid' => $uid);
        $user = $this->deliver_user->field(true)->where($condition_user)->find();
        if (empty($user)) $this->error('不存在的配送员');
        $sql = "SELECT s.`supply_id`, s.order_id, s.item, s.name as username, s.phone as userphone, m.name as storename, s.money, s.start_time, s.end_time, s.aim_site, s.pay_type, s.paid, s.status, s.deliver_cash FROM " . C('DB_PREFIX') . "merchant_store AS m INNER JOIN " . C('DB_PREFIX') . "deliver_supply AS s ON m.store_id=s.store_id";
        $sql_count = "SELECT count(1) AS count FROM " . C('DB_PREFIX') . "merchant_store AS m INNER JOIN " . C('DB_PREFIX') . "deliver_supply AS s ON m.store_id=s.store_id";
        
        $sql .= ' WHERE s.type=0 AND s.uid=' . $uid;
        $sql_count .= ' WHERE s.type=0 AND s.uid=' . $uid;
        
		if ($begin_time && $end_time) {
			$sql .= ' AND s.start_time>' . strtotime($begin_time) . ' AND s.start_time<' . strtotime($end_time);
			$sql_count .= ' AND s.start_time>' . strtotime($begin_time) . ' AND s.start_time<' . strtotime($end_time);
		}
		
        
        import('@.ORG.system_page');
        
        $res_count = D()->query($sql_count);
        $count_order = isset($res_count[0]['count']) ? $res_count[0]['count'] : 0;

        
        $p = new Page($count_order, 20);
        $sql .= ' ORDER BY s.`supply_id` DESC LIMIT ' . $p->firstRow . ',' . $p->listRows;
        $supply_info = D()->query($sql);

        foreach ($supply_info as &$value) {
            $value['create_time'] = date("Y-m-d H:i:s", $value['create_time']);
			$value['start_time'] = $value['start_time'] ? date("Y-m-d H:i:s", $value['start_time']) : '-';
			$value['end_time'] = $value['end_time'] ? date("Y-m-d H:i:s", $value['end_time']) : '-';
            $value['paid'] = $value['paid'] == 1 ? "已支付" : "未支付";
            $value['pay_type'] = $value['pay_type'] == "offline" ? "线下支付" : "线上支付";
            //订单状态（0：订单失效，1:订单完成，2：商家未确认，3：商家已确认，4已取餐，5：正在配送，6：退单,7商家取消订单,8配送员已接单）
            //配送状态(0失败 1等待接单 2接单 3取货 4开始配送 5完成）
            switch ($value['status']) {
                case 1:
                    $value['order_status'] = '<font color="red">等待接单</font>';
                    break;
                case 2:
                    $value['order_status'] = "接单";
                    break;
                case 3:
                    $value['order_status'] = "取货";
                    break;
                case 4:
                    $value['order_status'] = "开始配送";
                    break;
                case 5:
                    $value['order_status'] = "完成";
                    break;
                default:
                    $value['order_status'] = "订单失效";
                    break;
            }
        }

        $this->assign('supply_info', $supply_info);
        $this->assign('pagebar', $p->show());
        $this->assign('user', $user);
		$this->assign(array('begin_time' => $begin_time, 'end_time' => $end_time));
        $this->display();
    }
    
    
    public function change()
    {
    	$supply_id = isset($_GET['supply_id']) ? intval($_GET['supply_id']) : 0;
    	$supply = D('Deliver_supply')->field(true)->where(array('supply_id' => $supply_id, 'type' => 0))->find();
    	if (empty($supply)) exit(json_encode(array('error_code' => true, 'msg' => '不存在的数据')));
    	if ($supply['status'] == 5 || $supply['status'] == 0) exit(json_encode(array('error_code' => false, 'msg' => '修改成功')));
    	if ($supply['status'] == 1) exit(json_encode(array('error_code' => true, 'msg' => '配送员还未接单，不能修改成已完成')));
    	
    	$columns = array();
    	$columns['status'] = 5;
    	$columns['end_time'] = time();
    	
    	$database_deliver_user = D('Deliver_user');
    	$date = 0;
    	if ($now_deliver_user = $database_deliver_user->field(true)->where(array('uid' => $supply['uid']))->find()) {
    		$today = date('Ymd');
    		$num = 0;
    		if ($now_deliver_user['today'] != $today) {
    			$date = $now_deliver_user['today'];
    			$num = $now_deliver_user['today_num'];
    			$deliver_user_data['today'] = $today;
    			$deliver_user_data['today_num'] = 1;
    			$deliver_user_data['num'] = $now_deliver_user['num'] + 1;
    		} else {
    			$deliver_user_data['today_num'] = $now_deliver_user['today_num'] + 1;
    			$deliver_user_data['num'] = $now_deliver_user['num'] + 1;
    		}
    		$database_deliver_user->where(array('uid' => $supply['uid']))->save($deliver_user_data);
    	}
    	
    	if (D('Deliver_supply')->where(array("supply_id" => $supply_id))->save($columns)) {
	  		if ($supply['item'] == 0) {
	    		if ($order = D("Meal_order")->field(true)->where(array('order_id' => $supply['order_id']))->find()) {
	    			$data = array('order_status' => 1, 'status' => 1);//配送状态更改成已完成，订单状态改成已消费
	    			if ($order['paid'] == 0) {
	    				$data['paid'] = 1;
	    				if (empty($data['pay_type']) && empty($data['pay_time'])) $data['pay_type'] = 'offline';
	    			}
	    			if (empty($order['pay_time'])) $data['pay_time'] = time();
	    			if (empty($order['use_time'])) $data['use_time'] = time();
	    			if (empty($order['third_id'])) $data['third_id'] = $order['order_id'];
	    			if ($result = D("Meal_order")->where(array('order_id' => $supply['order_id']))->data($data)->save()) {
	    				$this->meal_notice($order);
	    			} else {
	    				exit(json_encode(array('error_code' => true, 'msg' => "更新订单信息错误")));
	    			}
	    		} else {
	    			exit(json_encode(array('error_code' => true, 'msg' => "订单信息错误")));
	    		}
	    	} elseif ($supply['item'] == 2) {//快店的配送
	    		if ($order = D("Shop_order")->field(true)->where(array('order_id' => $supply['order_id']))->find()) {
	    			$data = array('order_status' => 5, 'status' => 2);
	    			if ($order['is_pick_in_store'] == 0) {//平台配送
	    				if ($order['paid'] == 0 || ($order['pay_type'] == 'offline' && empty($order['third_id']))) {
	    					$data['paid'] = $order['paid'] == 0 ? 1 : $order['paid'];
	    					$data['pay_type'] = '';
	    					$data['balance_pay'] = $supply['deliver_cash'];
	    				}
	    			} else {
	    				if ($order['paid'] == 0) {
	    					$data['paid'] = 1;
	    					if (empty($order['pay_type']) && empty($order['pay_time'])) $data['pay_type'] = 'offline';
	    				}
	    			}
	    			if (empty($order['pay_time'])) $data['pay_time'] = time();
	    			if (empty($order['use_time'])) $data['use_time'] = time();
	    			if (empty($order['third_id'])) $data['third_id'] = $order['order_id'];
	    			if ($result = D("Shop_order")->where(array('order_id' => $order['order_id']))->data($data)->save()) {
	    				if ($order['is_pick_in_store'] == 0) {//平台配送
	    					if ($order['paid'] == 0 || ($order['pay_type'] == 'offline' && empty($order['third_id']))) {
	    						D('User_money_list')->add_row($order['uid'], 1, $supply['deliver_cash'], '用户充值用于购买快店产品');
	    						D('User_money_list')->add_row($order['uid'], 2, $supply['deliver_cash'], '用户购买快店产品');
	    					}
	    				}
	    				D('Pick_order')->where(array('store_id' => $order['store_id'], 'order_id' => $order['order_id']))->save(array('status' => 4));
	    				$this->shop_notice($order);
	    				D('Shop_order_log')->add_log(array('order_id' => $order['order_id'], 'status' => 6, 'name' => '系统管理员：' . $this->system_session['realname'], 'phone' => $this->system_session['phone']));
	    			} else {
	    				exit(json_encode(array('error_code' => true, 'msg' => "更新订单信息错误")));
	    			}
	    		} else {
	    			exit(json_encode(array('error_code' => true, 'msg' => "订单信息错误")));
	    		}
	    	}
	    	//统计每日配送订单量
	    	if ($date) {
	    		$deliver_count = D('Deliver_count')->field(true)->where(array('uid' => $supply['uid'], 'today' => $date))->find();
	    		if (empty($deliver_count)) {
	    			D('Deliver_count')->add(array('uid' => $supply['uid'], 'today' => $date, 'num' => $num));
	    		}
	    	}
	    	exit(json_encode(array('error_code' => false, 'msg' => "更新状态成功")));
    	} else {
    		exit(json_encode(array('error_code' => true, 'msg' => "更新状态失败")));
    	}
    }

    private function meal_notice($order)
    {
    	if ($store = D('Merchant_store')->field(true)->where(array('store_id' => $order['store_id']))->find()) {
			//增加商户余额
			$order['order_type']='meal';
			$info = unserialize($order['info']);
			$info_str = '';
			foreach($info as $v){
				$info_str.=$v['name'].':'.$v['price'].'*'.$v['num'].'</br>';
			}
			D('Merchant_money_list')->add_money($this->store['mer_id'],'用户购买'.$info_str.'记入收入',$order);

            //商家推广分佣
            $now_user = M('User')->where(array('uid' => $order['uid']))->find();
            D('Merchant_spread')->add_spread_list($order, $now_user, 'meal', $now_user['nickname'] . '用户购买餐饮商品获得佣金');

	    	//积分
			D('User')->add_score($order['uid'], floor(($order['payment_money'] + $order['balance_pay']) * $this->config['score_get']), '在 ' . $store['name'] . ' 中消费' . floatval($order['price']) . '元 获得'.$this->config['score_name']);
			D('Scroll_msg')->add_msg('meal',$now_user['uid'],'用户'.$now_user['nickname'].'于'.date('Y-m-d H:i',$_SERVER['REQUEST_TIME']).'在'. $store['name'] . ' 中消费获得'.$this->config['score_name']);
			D('Userinfo')->add_score($order['uid'], $order['mer_id'], $order['price'], '在 ' . $store['name'] . ' 中消费' . floatval($order['price']) . '元 获得积分');
			
			//短信
			$sms_data = array('mer_id' => $store['mer_id'], 'store_id' => $store['store_id'], 'type' => 'food');
			if ($this->config['sms_finish_order'] == 1 || $this->config['sms_finish_order'] == 3) {
				if (empty($order['phone'])) {
					$user = D('User')->field(true)->where(array('uid' => $order['uid']))->find();
					$order['phone'] = $user['phone'];
				}
				$sms_data['uid'] = $order['uid'];
				$sms_data['mobile'] = $order['phone'];
				$sms_data['sendto'] = 'user';
				$sms_data['content'] = '您在 ' . $store['name'] . '店中下的订单(订单号：' . $order['order_id'] . '),已经完成了消费，如有任何疑意，请您及时联系本店，欢迎再次光临！';
				Sms::sendSms($sms_data);
			}
			if ($this->config['sms_finish_order'] == 2 || $this->config['sms_finish_order'] == 3) {
				$sms_data['uid'] = 0;
				$sms_data['mobile'] = $store['phone'];
				$sms_data['sendto'] = 'merchant';
				$sms_data['content'] = '顾客购买的' . $order['name'] . '的订单(订单号：' . $order['order_id'] . '),已经完成了消费！';
				Sms::sendSms($sms_data);
			}
			
			//小票打印 主打印
// 			$msg = ArrayToStr::array_to_str($order['order_id']);
// 			$op = new orderPrint($this->config['print_server_key'], $this->config['print_server_topdomain']);
// 			$op->printit($store['mer_id'], $order['store_id'], $msg, 2);
// 			//分单打印
// 			$str_format = ArrayToStr::print_format($order['order_id']);
// 			foreach ($str_format as $print_id => $print_msg) {
// 				$print_id && $op->printit($store['mer_id'], $order['store_id'], $print_msg, 2, $print_id);
// 			}
    	}
    }


	private function shop_notice($order)
	{
		if ($store = D('Merchant_store')->field(true)->where(array('store_id' => $order['store_id']))->find()) {
			//增加商家余额
			$order['order_type']='shop';
			D('Merchant_money_list')->add_money($store['mer_id'],'用户购买快店订单记入收入',$order);

            //商家推广分佣
            $now_user = M('User')->where(array('uid' => $order['uid']))->find();
            D('Merchant_spread')->add_spread_list($order, $now_user, 'shop', $now_user['nickname'] . '用户购买快店商品获得佣金');

			//积分
			D('User')->add_score($order['uid'], round(($order['payment_money'] + $order['balance_pay']) * $this->config['score_get']), '在 ' . $store['name'] . ' 中消费' . floatval($order['price']) . '元 获得'.$this->config['score_name']);
			D('Scroll_msg')->add_msg('shop',$now_user['uid'],'用户'.$now_user['nickname'].'于'.date('Y-m-d H:i',$_SERVER['REQUEST_TIME']).'在'. $store['name'] . ' 中消费获得'.$this->config['score_name']);

			D('Userinfo')->add_score($order['uid'], $order['mer_id'], $order['price'], '在 ' . $store['name'] . ' 中消费' . floatval($order['price']) . '元 获得积分');
		
			//短信
			$sms_data = array('mer_id' => $store['mer_id'], 'store_id' => $store['store_id'], 'type' => 'shop');
			if ($this->config['sms_shop_finish_order'] == 1 || $this->config['sms_shop_finish_order'] == 3) {
				if (empty($order['phone'])) {
					$user = D('User')->field(true)->where(array('uid' => $order['uid']))->find();
					$order['phone'] = $user['phone'];
				}
				$sms_data['uid'] = $order['uid'];
				$sms_data['mobile'] = $order['userphone'];
				$sms_data['sendto'] = 'user';
				$sms_data['content'] = '您在 ' . $store['name'] . '店中下的订单(订单号：' . $order['order_id'] . '),已经完成了消费，如有任何疑意，请您及时联系本店，欢迎再次光临！';
				Sms::sendSms($sms_data);
			}
			if ($this->config['sms_shop_finish_order'] == 2 || $this->config['sms_shop_finish_order'] == 3) {
				$sms_data['uid'] = 0;
				$sms_data['mobile'] = $store['phone'];
				$sms_data['sendto'] = 'merchant';
				$sms_data['content'] = '顾客购买的' . $order['name'] . '的订单(订单号：' . $order['order_id'] . '),已经完成了消费！';
				Sms::sendSms($sms_data);
			}
		
// 			//小票打印 主打印
// 			$msg = ArrayToStr::array_to_str($order['order_id'], 'shop_order');
// 			$op = new orderPrint($this->config['print_server_key'], $this->config['print_server_topdomain']);
// 			$op->printit($store['mer_id'], $order['store_id'], $msg, 2);
		
// 			//分单打印
// 			$str_format = ArrayToStr::print_format($order['order_id'], 'shop_order');
// 			foreach ($str_format as $print_id => $print_msg) {
// 				$print_id && $op->printit($store['mer_id'], $order['store_id'], $print_msg, 2, $print_id);
// 			}
		}
	}

	public function new_export(){
        $b_date = $_GET['begin'].' 00:00:00';
        $e_date = $_GET['end'].' 24:00:00';

        $b_time = strtotime($b_date);
        $e_time = strtotime($e_date);

        $sql = "SELECT s.order_id, s.create_time,s.uid,s.freight_charge, u.name, u.phone,o.tip_charge,o.price,o.pay_type,o.coupon_price FROM " . C('DB_PREFIX') . "merchant_store AS m INNER JOIN " . C('DB_PREFIX') . "deliver_supply AS s ON m.store_id=s.store_id LEFT JOIN " . C('DB_PREFIX') . "deliver_user AS u ON s.uid=u.uid LEFT JOIN " . C('DB_PREFIX') . "shop_order AS o ON s.order_id=o.order_id";

        $sql .= ' where s.status = 5 and s.create_time >='.$b_time.' and s.create_time <='.$e_time.' and o.is_del = 0';
        $sql .= ' order by s.uid';

        $list = D()->query($sql);

        $show_list = array();

        foreach ($list as $k=>$v){
            //$show_list[$v['uid']] = array();
            $show_list[$v['uid']]['name'] = $v['name'];
            $show_list[$v['uid']]['phone'] = $v['phone'];
            $show_list[$v['uid']]['order_num'] = $show_list[$v['uid']]['order_num'] ? $show_list[$v['uid']]['order_num']+ 1 : 1;
            $show_list[$v['uid']]['tip'] = $show_list[$v['uid']]['tip'] ? $show_list[$v['uid']]['tip'] + $v['tip_charge'] : $v['tip_charge'];
            $show_list[$v['uid']]['freight'] = $show_list[$v['uid']]['freight'] ? $show_list[$v['uid']]['freight'] + $v['freight_charge'] : $v['freight_charge'];
            if($v['pay_type'] == 'offline' || $v['pay_type'] == 'Cash'){//统计现金
                if($v['coupon_price'] > 0) $v['price'] = $v['price'] - $v['coupon_price'];
                $show_list[$v['uid']]['cash'] = $show_list[$v['uid']]['cash'] ? $show_list[$v['uid']]['cash'] + $v['price'] : $v['price'];
            }
        }

        require_once APP_PATH . 'Lib/ORG/phpexcel/PHPExcel.php';
        $title = '配送统计';
        $objExcel = new PHPExcel();
        $objProps = $objExcel->getProperties();
        // 设置文档基本属性
        $objProps->setCreator($title);
        $objProps->setTitle($title);
        $objProps->setSubject($title);
        $objProps->setDescription($title);

        $objExcel->createSheet();
        $objExcel->setActiveSheetIndex(0);

        $objExcel->getActiveSheet()->setTitle($title);
        $objActSheet = $objExcel->getActiveSheet();

        $objActSheet->setCellValue('A1', '配送员姓名');
        $objActSheet->setCellValue('B1', '配送员电话');
        $objActSheet->setCellValue('C1', '送单数量');
        $objActSheet->setCellValue('D1', '小费总计');
        $objActSheet->setCellValue('E1', '送餐费总计');
        $objActSheet->setCellValue('F1', '收入现金');
        $objActSheet->setCellValue('G1', '总计');

        $index = 2;
        foreach ($show_list as $k=>$v){
//            $show_list[$k]['total'] = $v['tip'] + $v['freight'] - $v['cash'];
            $objActSheet->setCellValueExplicit('A'.$index,$v['name']);
            $objActSheet->setCellValueExplicit('B'.$index,$v['phone']);
            $objActSheet->setCellValueExplicit('C'.$index,$v['order_num']);
            $objActSheet->setCellValueExplicit('D'.$index,sprintf("%.2f", $v['tip']));
            $objActSheet->setCellValueExplicit('E'.$index,sprintf("%.2f", $v['freight']));
            $objActSheet->setCellValueExplicit('F'.$index,sprintf("%.2f", $v['cash']));
            $objActSheet->setCellValueExplicit('G'.$index,sprintf("%.2f",$v['tip'] + $v['freight'] - $v['cash']));
            $index++;
        }


        $objWriter = new PHPExcel_Writer_Excel5($objExcel);
        ob_end_clean();
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");
        header('Content-Disposition:attachment;filename="'.$title.'_' . date("Y-m-d h:i:s", time()) . '.xls"');
        header("Content-Transfer-Encoding:binary");
        $objWriter->save('php://output');
        exit();
    }

	public function export() 
	{
	    //if(!$_POST && !$_GET){
	        $this->display();
	        die();
        //}
		set_time_limit(0);	
		require_once APP_PATH . 'Lib/ORG/phpexcel/PHPExcel.php';
		$title = '配送列表';
		$objExcel = new PHPExcel();
		$objProps = $objExcel->getProperties();
		// 设置文档基本属性
		$objProps->setCreator($title);
		$objProps->setTitle($title);
		$objProps->setSubject($title);
		$objProps->setDescription($title);
		
		// 设置当前的sheet

		$phone = I("phone", 0);
		
		$status = I('status', 0, 'intval');
		$day = I('day', 0, 'intval');
		$period = I('period', '', 'htmlspecialchars');
		$stime = $etime = 0;
		if ($day) {
			$stime = strtotime("-{$day} day");
			$etime = time();
		}
		if ($period) {
			$time_array = explode('-', $period);
			$stime = strtotime($time_array[0]);
			$etime = strtotime($time_array[1]);
		}
		
		$database_supply = D('Deliver_supply');
		$count = $database_supply->where(array('type' => 0, 'status' => 5))->count();
		
		$length = ceil($count / 1000);
		for ($i = 0; $i < $length; $i++) { 
			$i && $objExcel->createSheet();
			$objExcel->setActiveSheetIndex($i);
	
			$objExcel->getActiveSheet()->setTitle('第' . ($i+1) . '个一千配送订单');
			$objActSheet = $objExcel->getActiveSheet();
			
			$objActSheet->setCellValue('A1', '配送ID');
			$objActSheet->setCellValue('B1', '订单来源');
			$objActSheet->setCellValue('C1', '店铺名称');
			$objActSheet->setCellValue('D1', '客户名称');
			$objActSheet->setCellValue('E1', '客户手机');
			$objActSheet->setCellValue('F1', '客户地址');
			$objActSheet->setCellValue('G1', '支付状态');
			$objActSheet->setCellValue('H1', '订单价格');
			$objActSheet->setCellValue('I1', '应收现金');
			$objActSheet->setCellValue('J1', '配送员昵称');
			$objActSheet->setCellValue('K1', '配送员手机号');
			$objActSheet->setCellValue('L1', '开始时间');
			$objActSheet->setCellValue('M1', '送达时间');
			
			$sql = "SELECT s.`supply_id`, s.order_id, s.item, s.name as username, s.phone as userphone, m.name as storename, s.money, u.name, u.phone, s.start_time, s.end_time, s.aim_site, s.pay_type, s.paid, s.status, s.deliver_cash FROM " . C('DB_PREFIX') . "merchant_store AS m INNER JOIN " . C('DB_PREFIX') . "deliver_supply AS s ON m.store_id=s.store_id LEFT JOIN " . C('DB_PREFIX') . "deliver_user AS u ON s.uid=u.uid";
			$sql .= ' WHERE s.type=0';
			if ($phone) {
				$sql .= " AND s.phone='{$phone}'";
			}
			
			if ($stime && $etime) {
				$sql .= " AND s.start_time>'{$stime}' AND s.start_time<'{$etime}'";
			}
			if ($status) {
				$sql .= " AND s.status='{$status}'";
			}
			
			$sql .= ' ORDER BY s.`supply_id` DESC LIMIT ' . $i * 1000 . ', 1000';
			$supply_list = D()->query($sql);
			
// 			$supply_list = $database_supply->field(true)->where(array('type' => 0, 'status' => 5))->limit($i * 1000 . ',1000')->select();
			if (!empty($supply_list)) {
				import('ORG.Net.IpLocation');
				$IpLocation = new IpLocation();
				$index = 2;
				foreach ($supply_list as $value) {
					
					$objActSheet->setCellValueExplicit('A' . $index, $value['supply_id']);
					if ($value['item'] == 0) {
						$objActSheet->setCellValueExplicit('B' . $index, $this->config['meal_alias_name']);
					} elseif ($value['item'] == 1) {
						$objActSheet->setCellValueExplicit('B' . $index, $this->config['waimai_alias_name']);
					} elseif ($value['item'] == 2) {
						$objActSheet->setCellValueExplicit('B' . $index, $this->config['shop_alias_name']);
					}
					$objActSheet->setCellValueExplicit('C' . $index, $value['storename']);
					$objActSheet->setCellValueExplicit('D' . $index, $value['username']);
					$objActSheet->setCellValueExplicit('E' . $index, $value['userphone'] . ' ');
					$objActSheet->setCellValueExplicit('F' . $index, $value['aim_site']);
					if ($value['paid'] == 1) {
						$objActSheet->setCellValueExplicit('G' . $index, '已支付');
					} else {
						$objActSheet->setCellValueExplicit('G' . $index, '未支付');
					}
					
					$objActSheet->setCellValueExplicit('H' . $index, floatval($value['money']));
					$objActSheet->setCellValueExplicit('I' . $index, floatval($value['deliver_cash']));
					
					
					$objActSheet->setCellValueExplicit('J' . $index, $value['name']);
					$objActSheet->setCellValueExplicit('K' . $index, $value['phone'] . ' ');
					$objActSheet->setCellValueExplicit('L' . $index, date('Y-m-d H:i:s', $value['start_time']));
					$objActSheet->setCellValueExplicit('M' . $index, date('Y-m-d H:i:s', $value['end_time']));
					
					$index++;
				}
			}
			sleep(2);
		}
		//输出
		$objWriter = new PHPExcel_Writer_Excel5($objExcel);
		ob_end_clean();
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
		header("Content-Type:application/force-download");
		header("Content-Type:application/vnd.ms-execl");
		header("Content-Type:application/octet-stream");
		header("Content-Type:application/download");
		header('Content-Disposition:attachment;filename="'.$title.'_' . date("Y-m-d h:i:s", time()) . '.xls"');
		header("Content-Transfer-Encoding:binary");
		$objWriter->save('php://output');
		exit();
		
	}
	
	public function export_user()
	{
		set_time_limit(0);
		
		$uid = isset($_GET['uid']) ? intval($_GET['uid']) : 0;
		$begin_time = isset($_GET['begin_time']) ? htmlspecialchars($_GET['begin_time']) : '';
		$end_time = isset($_GET['end_time']) ? htmlspecialchars($_GET['end_time']) : '';
		$condition_user = array('mer_id' => 0, 'uid' => $uid);
		$user = $this->deliver_user->field(true)->where($condition_user)->find();
		if (empty($user)) $this->error('不存在的配送员');
		
		
		require_once APP_PATH . 'Lib/ORG/phpexcel/PHPExcel.php';
		
		if ($begin_time && $end_time) {
			$title = '【' . $user['name'] . '】在' . $begin_time . '至' . $end_time . '时间段的配送记录列表';
		} else {
			$title = '【' . $user['name'] . '】的配送记录列表';
		}
		$objExcel = new PHPExcel();
		$objProps = $objExcel->getProperties();
		// 设置文档基本属性
		$objProps->setCreator($title);
		$objProps->setTitle($title);
		$objProps->setSubject($title);
		$objProps->setDescription($title);
		
		// 设置当前的sheet
		$sql_count = "SELECT count(1) AS count FROM " . C('DB_PREFIX') . "merchant_store AS m INNER JOIN " . C('DB_PREFIX') . "deliver_supply AS s ON m.store_id=s.store_id";
		$sql_count .= ' WHERE s.type=0 AND s.uid=' . $uid;
		if ($begin_time && $end_time) {
			$sql_count .= ' AND s.start_time>' . strtotime($begin_time) . ' AND s.start_time<' . strtotime($end_time);
		}
		
		$res_count = D()->query($sql_count);
		$count_order = isset($res_count[0]['count']) ? $res_count[0]['count'] : 0;
		
		$length = ceil($count_order / 1000);
		for ($i = 0; $i < $length; $i++) {
			$i && $objExcel->createSheet();
			$objExcel->setActiveSheetIndex($i);
		
			$objExcel->getActiveSheet()->setTitle('第' . ($i+1) . '个一千配送订单');
			$objActSheet = $objExcel->getActiveSheet();
				
			$objActSheet->setCellValue('A1', '配送ID');
			$objActSheet->setCellValue('B1', '订单来源');
			$objActSheet->setCellValue('C1', '店铺名称');
			$objActSheet->setCellValue('D1', '客户名称');
			$objActSheet->setCellValue('E1', '客户手机');
			$objActSheet->setCellValue('F1', '客户地址');
			$objActSheet->setCellValue('G1', '支付状态');
			$objActSheet->setCellValue('H1', '订单价格');
			$objActSheet->setCellValue('I1', '应收现金');
			$objActSheet->setCellValue('J1', '配送状态');
			$objActSheet->setCellValue('K1', '开始时间');
			$objActSheet->setCellValue('L1', '送达时间');
			
			
			$sql = "SELECT s.`supply_id`, s.order_id, s.item, s.name as username, s.phone as userphone, m.name as storename, s.money, s.start_time, s.end_time, s.aim_site, s.pay_type, s.paid, s.status, s.deliver_cash FROM " . C('DB_PREFIX') . "merchant_store AS m INNER JOIN " . C('DB_PREFIX') . "deliver_supply AS s ON m.store_id=s.store_id";
			$sql .= ' WHERE s.type=0 AND s.uid=' . $uid;
			if ($begin_time && $end_time) {
				$sql .= ' AND s.start_time>' . strtotime($begin_time) . ' AND s.start_time<' . strtotime($end_time);
			}
			
			$sql .= ' ORDER BY s.`supply_id` DESC LIMIT ' . $i * 1000 . ', 1000';
			
			$supply_list = D()->query($sql);
				
			if (!empty($supply_list)) {
				import('ORG.Net.IpLocation');
				$IpLocation = new IpLocation();
				$index = 2;
				foreach ($supply_list as $value) {
						
					$objActSheet->setCellValueExplicit('A' . $index, $value['supply_id']);
					if ($value['item'] == 0) {
						$objActSheet->setCellValueExplicit('B' . $index, $this->config['meal_alias_name']);
					} elseif ($value['item'] == 1) {
						$objActSheet->setCellValueExplicit('B' . $index, $this->config['waimai_alias_name']);
					} elseif ($value['item'] == 2) {
						$objActSheet->setCellValueExplicit('B' . $index, $this->config['shop_alias_name']);
					}
					$objActSheet->setCellValueExplicit('C' . $index, $value['storename']);
					$objActSheet->setCellValueExplicit('D' . $index, $value['username']);
					$objActSheet->setCellValueExplicit('E' . $index, $value['userphone'] . ' ');
					$objActSheet->setCellValueExplicit('F' . $index, $value['aim_site']);
					if ($value['paid'] == 1) {
						$objActSheet->setCellValueExplicit('G' . $index, '已支付');
					} else {
						$objActSheet->setCellValueExplicit('G' . $index, '未支付');
					}
						
					$objActSheet->setCellValueExplicit('H' . $index, floatval($value['money']));
					$objActSheet->setCellValueExplicit('I' . $index, floatval($value['deliver_cash']));
					switch ($value['status']) {
						case 1:
							$value['order_status'] = '<font color="red">等待接单</font>';
							break;
						case 2:
							$value['order_status'] = "接单";
							break;
						case 3:
							$value['order_status'] = "取货";
							break;
						case 4:
							$value['order_status'] = "开始配送";
							break;
						case 5:
							$value['order_status'] = "完成";
							break;
						default:
							$value['order_status'] = "订单失效";
							break;
					}	
					$objActSheet->setCellValueExplicit('J' . $index, $value['order_status']);
					$objActSheet->setCellValueExplicit('K' . $index, $value['start_time'] ? date('Y-m-d H:i:s', $value['start_time']) : '--');
					$objActSheet->setCellValueExplicit('L' . $index, $value['end_time'] ? date('Y-m-d H:i:s', $value['end_time']) : '--');
						
					$index++;
				}
			}
			sleep(2);
		}
		//输出
		$objWriter = new PHPExcel_Writer_Excel5($objExcel);
		ob_end_clean();
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
		header("Content-Type:application/force-download");
		header("Content-Type:application/vnd.ms-execl");
		header("Content-Type:application/octet-stream");
		header("Content-Type:application/download");
		header('Content-Disposition:attachment;filename="' . $title . '.xls"');
		header("Content-Transfer-Encoding:binary");
		$objWriter->save('php://output');
		exit();
	}

	public function map(){
        //获取当前所有上班状态的配送员 包含现在手中订单数量及状态
        $where['status'] = 1;
        $where['work_status'] = 0;
        //garfunkel 判断城市管理员
        if($this->system_session['level'] == 3){
            $where['city_id'] = $this->system_session['area_id'];
        }
        $user_list = D('Deliver_user')->field(true)->where($where)->order('uid asc')->select();
        foreach ($user_list as &$deliver){
            $orders = D('Deliver_supply')->field(true)->where(array('uid'=>$deliver['uid'],'status' => array(array('gt', 1), array('lt', 5))))->order('supply_id asc')->select();
            $deliver['order_count'] = count($orders);
        }

        $this->assign('list',$user_list);
        $this->display();
    }

    public function e_call(){
        $user_list = D('Deliver_user')->field(true)->where(array('status'=>1,'work_status'=>1))->order('uid asc')->select();
        foreach ($user_list as $deliver){
            if($deliver['device_id'] && $deliver['device_id'] != ''){
                $message = 'Tutti are short on hands now! Please log in to your account and start to Accept Order! Tutti thanks your help!';
                Sms::sendMessageToGoogle($deliver['device_id'],$message,3);
            }else {
                $sms_data['uid'] = 0;
                $sms_data['mobile'] = $deliver['phone'];
                $sms_data['sendto'] = 'deliver';
                $sms_data['tplid'] = 247163;
                $sms_data['params'] = [];
                Sms::sendSms2($sms_data);
            }
        }

        exit(json_encode(array('error' => 0, 'msg' => 'Success！', 'dom_id' => 'account')));
    }

    public function review(){
        //搜索
        if (!empty($_GET['keyword'])) {
            if ($_GET['searchtype'] == 'uid') {
                $condition_user['uid'] = $_GET['keyword'];
            } else if ($_GET['searchtype'] == 'nickname') {
                $condition_user['name'] = array('like', '%' . $_GET['keyword'] . '%');
            } else if ($_GET['searchtype'] == 'phone') {
                $condition_user['phone'] = array('like', '%' . $_GET['keyword'] . '%');
            }
        }
        //未审核的
        $condition_user['group'] = 0;
        $condition_user['reg_status'] = array('neq',0);
        //garfunkel 判断城市管理员
        if($this->system_session['level'] == 3){
            $condition_user['city_id'] = $this->system_session['area_id'];
        }
        $count_user = $this->deliver_user->where($condition_user)->count();
        import('@.ORG.system_page');
        $p = new Page($count_user, 15);
        $user_list = $this->deliver_user->field(true)->where($condition_user)->order('`uid` DESC')->limit($p->firstRow . ',' . $p->listRows)->select();
        $this->assign('user_list', $user_list);
        $pagebar = $p->show();
        $this->assign('pagebar', $pagebar);
        $this->display();
    }

    public function user_view(){
        if($_POST) {
            $uid = $_POST['uid'];
            $deliver = D('deliver_user')->where(array('uid' => $uid))->find();
            if ($deliver['reg_status'] == 2) {
                $review_status = $_POST['review'];
                if ($review_status == 1) {//通过
                    $data['reg_status'] = 3;

                    $sms_data['uid'] = $uid;
                    $sms_data['mobile'] = $deliver['phone'];
                    $sms_data['sendto'] = 'deliver';
                    $sms_data['tplid'] = 275882;
                    $sms_data['params'] = [];
                    Sms::sendSms2($sms_data);
                } else {//未通过
                    $data['reg_status'] = 1;
                    $data_img['review_desc'] = $_POST['review_desc'];
                    D('Deliver_img')->where(array('uid' => $uid))->save($data_img);
                }
                D('deliver_user')->where(array('uid' => $uid))->save($data);

                $this->success('修改成功！');
            }elseif ($deliver['reg_status'] == 4){
                if($_POST['receive'] == 1){
                    $data['reg_status'] = 0;
                    $data['group'] = 1;
                    $data['status'] = 1;
                    D('deliver_user')->where(array('uid' => $uid))->save($data);
                }
                $this->user_edit();
            }else{
                $this->user_edit();
            }
        }else {
            $uid = $_GET['uid'];
            if (!$uid) {
                $this->error('非法操作');
            }
            $deliver = D('deliver_user')->where(array('uid' => $uid))->find();
            if (!$deliver) {
                $this->error('非法操作');
            }
            $city = D('Area')->where(array('area_id'=>$deliver['city_id']))->find();
            $deliver['city_name'] = $city['area_name'];

            $deliver_img = D('Deliver_img')->field(true)->where(array('uid' => $uid))->find();
            $this->assign('now_user', $deliver);
            $this->assign('img', $deliver_img);

            $card = D('Deliver_card')->field(true)->where(array('deliver_id'=>$uid))->find();
            $this->assign('card',$card);

            $this->display();
        }
    }
}