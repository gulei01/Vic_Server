<?php
/*
 * wap端前台页面----用户相关
 *   Writers    hanlu
 *   BuildTime  2016/07/13 09:00
 */
class Scenic_userAction extends BaseAction{
	# 个人中心
	public function index(){
		$User	=	$this->user_sessions();
//		$User = M('User')->where(array('uid'=>$this->user_session['uid']))->find();
//		$user_session  =	$User;
		$user['user_id']	=	$User['uid'];
		$Scenic_aguide	=	D('Scenic_aguide')->city_get_one_aguide($user);
		if(empty($User['avatar'])){
            $User['avatar']   =   $this->config['site_url'] . '/static/images/user_avatar.jpg';
        }
		$this->assign('user',$User);
		$this->assign('aguide',$Scenic_aguide);
		$this->display();
	}
	# 订单列表
	public function ticket_order_list(){
		$this->user_sessions();
		$this->display();
	}
	public function ticket_order_list_json(){
		$where['user_id']	=	$this->user_session['uid'];
		$page	=	$_POST['page'];
		$user_order	=	D('Scenic_order')->get_user_order($where,$page);
		$date	=	date('Y-m-d',$_SERVER['REQUEST_TIME']);
		if($user_order){
			foreach($user_order as &$v){
				# 订单未支付，过期时间30分钟，默认关闭状态，订单状态改为5
				if($v['paid'] == 1){
					$branch	=	1800-($_SERVER['REQUEST_TIME']-$v['add_time']);
					if($branch < 0){
						$v['order_status']	=	5;
						D('Scenic_order')->save_order(array('order_id'=>$v['order_id']),array('order_status'=>5));
					}
				}
				# 购买门票了，到了时间未入园，默认关闭状态，订单状态改为6
				if($v['order_status'] == 1 && $v['paid'] == 2){
					$ticket_data	=	strtotime($v['ticket_time']);
					$ticket_data	=	$ticket_data+(60*60*24);
					if($_SERVER['REQUEST_TIME'] >= $ticket_data){
						$v['order_status']	=	6;
						D('Scenic_order')->save_order(array('order_id'=>$v['order_id']),array('order_status'=>6));
					}
				}
				$v['scenic_list']	=	D('Scenic_list')->get_one_list(array('scenic_id'=>$v['scenic_id']));
				$v['add_time']	=	date('Y-m-d H:i',$v['add_time']);
				$ticket_time	=	explode('-',$v['ticket_time']);
				if($ticket_time[1] < 10){
					$ticket_time[1]	=	'0'.$ticket_time[1];
				}
				if($ticket_time[2] < 10){
					$ticket_time[2]	=	'0'.$ticket_time[2];
				}
				$v['ticket_time']	=	$ticket_time[0].'-'.$ticket_time[1].'-'.$ticket_time[2];
				$v['pay_url']		=	$this->config['site_url'].U('Scenic_pay/index',array('order_id'=>$v['order_id']));
				$v['cancel_url']	=	$this->config['site_url'].U('Scenic_pay/cancel_order',array('order_id'=>$v['order_id']));
				$v['details_url']	=	$this->config['site_url'].U('ticket_order_details',array('order_id'=>$v['order_id']));
				$v['comment_url']	=	$this->config['site_url'].U('comment',array('order_id'=>$v['order_id'],'type'=>1));
			}
		}
		$url	=	$this->config['site_url'].U('ticket_order_details');
		$arr	=	array(
			'user_order'	=>	$user_order,
			'date'		=>	$date,
			'url'		=>	$url,
		);
		$this->returnCode(0,$arr);
	}
	# 取消订单
	public function cancel_order(){
		$this->user_sessions();
		$where['order_id']	=	$_POST['order_id'];
		$order = D('Scenic_order')->get_one_order($where);
		$now_ticket = M('Scenic_ticket')->where(array('ticket_id'=>$order['ticket_id']))->find();
		if(!$now_ticket['is_refund']||date('Y-m-d')>$order['ticket_time']){
			$this->returnCode('40000021');
		}
		if($order['order_status']!=1){
			$this->returnCode('40000018');
		}elseif($order['pay_type']=='weixin'){
			$import_result = import('@.ORG.pay.weixin');
			$pay_method = D('Config')->get_pay_method();
			$pay_class = new Weixin($order,$order['payment_money'],'weixin',$pay_method['weixin']['config'],$this->user_session,1);
			$go_refund_param = $pay_class->refund();
			if(empty($go_refund_param['error']) && $go_refund_param['type'] == 'ok'){
				$date['order_status']=4;
				if(!M('Scenic_order')->where($where)->save($date)){
					$this->returnCode('40000019');
				}
			}
		}else{
			$date['order_status']=4;
			$date['last_time']=$_SERVER['REQUEST_TIME'];
			$date['refund_fee']=$order['balance_pay']+$order['payment_money'];
			if(M('Scenic_order')->where($where)->save($date)){
				D('User')->add_money($order['user_id'],$date['refund_fee'],'景区门票退款');
			}else{
				$this->returnCode('40000019');
			}
		}
		$this->returnCode(0);
	}
	# 订单详情
	public function ticket_order_details(){
		$this->user_sessions();
		# 订单详情
		$where['order_id']	=	$_GET['order_id'];
		$user_order	=	D('Scenic_order')->get_one_order($where);
		# 订单未支付，过期时间30分钟，默认关闭状态，订单状态改为5
		if($user_order['paid'] == 1){
			$branch	=	1800-($_SERVER['REQUEST_TIME']-$user_order['add_time']);
			if($branch < 0){
				$user_order['order_status']	=	5;
				D('Scenic_order')->save_order(array('order_id'=>$user_order['order_id']),array('order_status'=>5));
			}
		}
		# 购买门票了，到了时间未入园，默认关闭状态，订单状态改为6
		if($user_order['order_status'] == 1 && $user_order['paid'] == 2){
			$ticket_data	=	strtotime($user_order['ticket_time']);
			$ticket_data	=	$ticket_data+(60*60*24);
			if($_SERVER['REQUEST_TIME'] >= $ticket_data){
				$user_order['order_status']	=	6;
				D('Scenic_order')->save_order(array('order_id'=>$user_order['order_id']),array('order_status'=>6));
			}
		}
		$user_order['user']	=	D('User')->get_user($user_order['user_id']);
		$user_order['order_total']	=	floor($user_order['order_total']);
		if(empty($user_order)){
			$this->error_tips('订单不存在');
		}
		# 订单商品
		$order_com	=	D('Scenic_order')->get_order_com($where);
		if(empty($order_com)){
			$this->error_tips('订单不存在');
		}
		$scenic_list	=	D('Scenic_list')->get_one_list(array('scenic_id'=>$user_order['scenic_id']));
		$ticket	=	array();
		$park	=	array();
		$guide	=	array();
		foreach($order_com as $v){
			if($v['type'] == 1){
				$v['price']	=	intval($v['price']);
				$ticket[]	=	$v;
			}else if($v['type'] == 2){
				$park[]		=	$v;
			}else if($v['type'] == 3){
				$guide[]	=	$v;
			}
		}
		# 门票信息
		if(empty($ticket)){
			$this->error_tips('订单不存在');
		}else{
			$ticket_id['ticket_id']	=	$user_order['ticket_id'];
			$scenic_ticket	=	D('Scenic_ticket')->get_scenic_one_ticket($ticket_id);
			$ticket_count	=	count($ticket);
		}
		# 车位信息
		if(!empty($park)){
			$park_id['parking_id']	=	$park[0]['type_id'];
			$scenic_prak	=	D('Scenic_park')->get_user_park($park_id);
			$prak_count		=	count($park);
		}
		$scenic_image_class = new scenic_image();
		# 向导信息
		if(!empty($guide)){
			$guide_id['guide_id']	=	$guide[0]['type_id'];
			$scenic_guide	=	D('Scenic_guide')->city_get_one_guide($guide_id);
			$scenic_guide['pic'] = $scenic_image_class->get_image_by_path($scenic_guide['guide_pig'],$this->config['site_url'],'guide','s');
			$guide_number	=	1;
		}else{
			$guide_number	=	0;
		}
		$scenic_ticket['ticket_cue'] = htmlspecialchars_decode($scenic_ticket['ticket_cue']);
		$scenic_ticket['park_intr'] = htmlspecialchars_decode($scenic_ticket['park_intr']);
		$arr	=	array(
			'prak_count'	=>	$prak_count,
			'ticket_count'	=>	$ticket_count,
			'prak_price'	=>	floor($park[0]['price']),
			'ticket_price'	=>	floor($scenic_ticket['price']),
			'total_price'	=>	floor($park[0]['price']*$prak_count)+floor($scenic_list['guide_price']*$guide_number)+floor($ticket[0]['price']*$ticket_count),
			'pay_url'		=>	$this->config['site_url'].U('Scenic_pay/index',array('order_id'=>$where['order_id'])),
			'comment_url'	=>	$this->config['site_url'].U('comment',array('order_id'=>$user_order['order_id'],'type'=>1)),
		);
		$family_id = explode(",",$user_order['family_id']);
		foreach($family_id as $v){
			$family[]	=	D('Scenic_family')->get_one(array('family_id'=>$v));
		}
		# 图片
		$tmp_pic_arr = explode(';',$scenic_list['scenic_pic']);
		$scenic_list['pic'] = $scenic_image_class->get_image_by_path($tmp_pic_arr[0],$this->config['site_url'],'config','s');
		$scenic_list['scenic_map_pic'] = $scenic_image_class->get_image_by_path($scenic_list['scenic_map_pic'],$this->config['site_url'],'config','s');
		# 是否显示景内游玩
		$action	=	M('Scenic_activity')->where(array('scenic_id'=>$user_order['scenic_id']))->count();
		$com_category	=	M('Scenic_com_category')->where(array('scenic_id'=>$user_order['scenic_id'],'status'=>1))->count();
		$map_category	=	M('Scenic_map_category')->where(array('scenic_id'=>$user_order['scenic_id'],'map_fid'=>0,'status'=>1))->count();
		if($action || $com_category || $map_category){
			$this->assign('inside',1);
		}
		$this->assign('com_category',$com_category);
		$this->assign('user_order',$user_order);
		$this->assign('scenic_list',$scenic_list);
		$this->assign('scenic_ticket',$scenic_ticket);
		$this->assign('scenic_prak',$scenic_prak);
		$this->assign('scenic_guide',$scenic_guide);
		$this->assign('ticket',$ticket);
		$this->assign('park',$park);
		$this->assign('arr',$arr);
		$this->assign('family',$family);
		$this->display();
	}
	# 景区位置地图
	public function addressinfo(){
		$long_lat = D('User_long_lat')->getLocation($_SESSION['openid']);
		$this->assign('long_lat',$long_lat);
		$where['scenic_id']	=	$_GET['scenic_id'];
		$scenic_list = D('Scenic_list')->get_one_list($where);
		if(empty($scenic_list)){
			$this->error_tips('该景区不存在！');
		}
		$this->assign('scenic_list',$scenic_list);
		$this->display();
	}
	# 景区查看路线
	public function get_route(){
		$long_lat = D('User_long_lat')->getLocation($_SESSION['openid']);
		$this->assign('long_lat',$long_lat);
		$where['scenic_id']	=	$_GET['scenic_id'];
		$scenic_list = D('Scenic_list')->get_one_list($where);
		if(empty($scenic_list)){
			$this->error_tips('该景区不存在！');
		}
		$this->assign('scenic_list',$scenic_list);
		$this->assign('no_gotop',true);
		$this->display();
	}
	# 向导订单
	public function aguide_order_list(){
		$this->user_sessions();
		$this->display();
	}
	# 向导订单
	public function aguide_order_list_json(){
		$this->user_sessions();
		$where['user_id']	=	$this->user_session['uid'];
		$page	=	$_POST['page'];
		$this->aguide_order_refresh($where['user_id'],'user_id');
		$user_order	=	D('Scenic_aguide')->get_aguide_order_list($where,$page);
		if($user_order){
			foreach($user_order as $k=>&$v){
				$aguide	=	D('Scenic_aguide')->get_one_aguide(array('guide_id'=>$v['guide_id']));
				$v['user']	=	D('User')->get_user($aguide['user_id']);
				$v['guide_user']	=	D('Scenic_aguide')->city_get_one_aguide(array('guide_id'=>$v['guide_id']));
				$v['add_time']	=	date('Y-m-d H:i',$v['create_time']);
				$v['total_price']	=	floor($v['total_price']);
				$v['comment_url']	=	$this->config['site_url'].U('comment',array('order_id'=>$v['order_id'],'type'=>2));
				if($v['pay_status'] == 2 && $v['rela_status'] == 1){
					$ticket_data	=	strtotime($v['end_time']);
					$ticket_data	=	$ticket_data+(60*60*24);
					if($_SERVER['REQUEST_TIME'] >= $ticket_data){
						$v['rela_status']	=	2;
						D('Scenic_order')->save_guide_order(array('order_id'=>$v['order_id']),array('rela_status'=>2));
					}
				}
				if($v['family_id']){
					$family_id = explode(",",$v['family_id']);
					foreach($family_id as $zzz){
						if($zzz!='') {
							$user_order[$k]['family'][] = D('Scenic_family')->get_one(array('family_id' => $zzz));
						}
					}
				}
			}
		}
		$this->returnCode(0,$user_order);
	}
	# 刷新向导订单
	public function aguide_order_refresh($guide_id,$where_id){
		$start_tiem	=	date('Y-m-d',$_SERVER['REQUEST_TIME']);
		$scenic_aguide	=	D('Scenic_aguide')->order_refresh($guide_id,$where_id,$start_tiem);
		//导游服务验证，验证后加钱
		$user_id	=	$this->user_session['uid'];
		$aguide_service_verify	=	D('Scenic_aguide')->verify($user_id);
	}
	# 实名认证
	public function add_guide(){
		$this->user_sessions();
		$uid	=	$this->user_session['uid'];
		$find	=	M('User_authentication')->field(true)->where(array('uid'=>$uid))->find();
		$this->assign('find',$find);
		$this->display();
	}
	# 实名认证提交
	public function add_guide_json(){
		$where['uid']	=	$this->user_session['uid'];
		$find	=	M('User_authentication')->where($where)->find();
		$auth_data	=	array(
			'user_truename'			=>	$_POST['user_truename'],
			'user_id_number'		=>	$_POST['user_id_number'],
			'authentication_img'	=>	$_POST['authentication_img'],
			'authentication_back_img'=>	$_POST['authentication_back_img'],
			'hand_authentication'	=>	$_POST['hand_authentication'],
			'authentication_time'	=>	$_SERVER['REQUEST_TIME'],
			'examine_time'			=>	0,
			'authentication_status'	=>	0,
		);
		if($find){
			$user_authentication	=	M('User_authentication')->where($where)->data($auth_data)->save();
		}else{
			$auth_data['uid']	=	$this->user_session['uid'];
			$user_authentication	=	M('User_authentication')->data($auth_data)->add();
		}
		if(empty($user_authentication)){
			$this->returnCode('40000031');
		}else{
			$data['truename']	=	$_POST['user_truename'];
			$data['real_name']	=	2;
			$save	=	D('User')->scenic_save_user($where,$data);
			if($save){
				$_SESSION['user']['real_name']	=	2;
				$_SESSION['user']['truename']	=	$data['truename'];
			}
		}
		$url	=	$this->config['site_url'].U('guide');
		$this->returnCode(0,$url);
	}
	# 实名认证页面展示页面
	public function guide(){
		$this->user_sessions();
		$authentication	=	D('User_authentication')->field(true)->order('authentication_time DESC')->where(array('uid'=>$this->user_session['uid']))->find();
		if($authentication){
			$store_image_class = new scenic_image();
			$a_img = strstr($authentication['authentication_img'], ',',true);
			$b_img = strstr($authentication['authentication_back_img'], ',',true);
			if($a_img){
				$authentication['authentication_img'] = $store_image_class->get_image_by_path($authentication['authentication_img'],$this->config['site_url'],'aguide','1');
			}
			if($b_img){
				$authentication['authentication_back_img'] = $store_image_class->get_image_by_path($authentication['authentication_back_img'],$this->config['site_url'],'aguide','1');
			}
		}else{
			redirect(U('add_guide'));
		}
		$scenic_aguide	=	D('Scenic_aguide')->field('guide_id')->where(array('user_id'=>$this->user_session['uid']))->find();
		$this->assign('scenic_aguide',$scenic_aguide);
		$this->assign('authentication',$authentication);
		$this->display();
	}
	# 申请导游（编辑导游）
	public function guide_release(){
		$this->user_sessions();
		$scenic_aguide	=	D('Scenic_aguide')->get_one_aguide(array('user_id'=>$this->user_session['uid']));
		if($scenic_aguide){
			$scenic_aguide['guide_price']	=	intval($scenic_aguide['guide_price']);
			$this->assign('scenic_aguide',$scenic_aguide);
			$this->assign('type',1);
		}else{
			$this->assign('type',2);
		}
		$where['is_open']	=	1;
		$where['area_type']	=	1;
		$scenic_area	=	D('Area')->scenic_get_area_list_pc($where);
		if($scenic_aguide){
			foreach($scenic_area as $k=>$v){
				if($v['area_id'] == $scenic_aguide['province_id']){
					$number	=	$k;
					break;
				}else{
				}
			}
		}
		if($number){
			$this->assign('number',$k);
		}else{
			$this->assign('number',0);
		}
		$this->assign('scenic_area',$scenic_area);
		$this->display();
	}
	# 申请导游（编辑导游）的提交
	public function guide_release_json(){
		$uid	=	$this->user_session['uid'];
		$User_authentication	=	M('User_authentication')->field(true)->order('authentication_time DESC')->where(array('uid'=>$uid))->find();
		if(empty($User_authentication)){
			$this->returnCode('40000014');
		}
		$arr	=	array(
			'user_id'		=>	$this->user_session['uid'],
			'guide_nickname'=>	$_POST['guide_nickname'],
			'guide_life'	=>	$_POST['guide_life'],
			'province_id'	=>	$_POST['province'],
			'city_id'		=>	$_POST['city'],
			'guide_autograph'=>	$_POST['guide_autograph'],
			'guide_intr'	=>	$_POST['guide_intr'],
			'guide_phone'	=>	$_POST['guide_phone'],
			'guide_life'	=>	$_POST['guide_life'],
			'guide_price'	=>	$_POST['guide_price'],
			'guide_sex'		=>	$_POST['guide_sex'],
			'date'			=>	$_POST['date'],
			'guide_pic'		=>	$_POST['image4'],
		);
		if($_POST['type'] == 2){
			$arr['guide_name']	=	$_POST['guide_name'];
			$arr['guide_card']	=	$_POST['guide_card'];
			$arr['guide_card_img']	=	$_POST['image1'];
			$arr['guide_card_back_img']	=	$_POST['image2'];
			$arr['create_time']	=	$_SERVER['REQUEST_TIME'];
			$add_scenic_aguide	=	D('Scenic_aguide')->add_aguide($arr);
		}else{
			$where['guide_id']	=	$_POST['guide_id'];
			$arr['update_time']	=	$_SERVER['REQUEST_TIME'];
			$add_scenic_aguide	=	D('Scenic_aguide')->edit_aguide($where,$arr);
		}
		if($add_scenic_aguide){
			$url	=	$this->config['site_url'].U('guide_service');
			$this->returnCode(0,$url);
		}else{
			$this->returnCode('40000006');
		}
	}
	# 向导从新审核
	public function again_guide_release(){
		$this->user_sessions();
		$scenic_aguide	=	D('Scenic_aguide')->get_one_aguide(array('user_id'=>$this->user_session['uid']));
		$this->assign('scenic_aguide',$scenic_aguide);
		$this->display();
	}
	# 向导从新审核
	public function again_guide_release_json(){
		$uid	=	$this->user_session['uid'];
		$User_authentication	=	M('User_authentication')->field(true)->order('authentication_time DESC')->where(array('uid'=>$uid))->find();
		if(empty($User_authentication)){
			$this->returnCode('40000014');
		}
		$arr['guide_name']	=	$_POST['guide_name'];
		$arr['guide_card']	=	$_POST['guide_card'];
		$arr['guide_card_img']		=	$_POST['image1'];
		$arr['guide_card_back_img']		=	$_POST['image2'];
		$arr['guide_status']=	2;
		$arr['update_time']	=	$_SERVER['REQUEST_TIME'];
		$where['guide_id']	=	$_POST['guide_id'];
		$add_scenic_aguide	=	D('Scenic_aguide')->edit_aguide($where,$arr);
		if($add_scenic_aguide){
			$url	=	$this->config['site_url'].U('guide_service');
			$this->returnCode(0,$url);
		}else{
			$this->returnCode('40000006');
		}
		$this->display();
	}
	# 获取市
	public function select_area(){
		$area_list = D('Area')->scenic_get_arealist_by_areaPid($_POST['pid']);
		if(!empty($area_list)){
			$return['error'] = 0;
			$return['list'] = $area_list;
		}else{
			$return['error'] = 1;
		}
		echo json_encode($return);
	}
	# 导游展示页面（包括订单）
	public function guide_service(){
		$this->user_sessions();
		$where['user_id']	=	$this->user_session['uid'];
		$scenic_aguide	=	D('Scenic_aguide')->get_one_aguide($where);
		$this->aguide_order_refresh($scenic_aguide['guide_id'],'guide_id');
		$scenic_aguide['guide_price']	=	intval($scenic_aguide['guide_price']);
		$scenic_aguide_order	=	D('Scenic_aguide')->get_aguide_order_list_me(array('guide_id'=>$scenic_aguide['guide_id'],'pay_status'=>2,'rela_status'=>array('between',array('1','3'))));
		if($scenic_aguide_order){
			foreach($scenic_aguide_order as $kk=>&$vv){
				if(empty($vv)){
					continue;
				}
				$vv['guide_price']	=	intval($vv['guide_price']);
				if($vv['family_id']){
					$family_id = explode(",",$vv['family_id']);
					foreach($family_id as $zzz){
						$scenic_aguide_order[$kk]['family'][]	=	D('Scenic_family')->get_one(array('family_id'=>$zzz));
					}
				}
			}
		}
		$store_image_class = new scenic_image();
		$tmp_pic_arr = explode(';',$scenic_aguide['guide_pic']);
		foreach($tmp_pic_arr as $k=>$v){
			if(empty($v)){
				continue;
			}
			$scenic_aguide['pic'][$k] = $store_image_class->get_image_by_path($v,$this->config['site_url'],'aguide','1');
		}
		$age	=	D('User')->age($scenic_aguide['date']);
		$this->assign('scenic_aguide',$scenic_aguide);
		$this->assign('scenic_aguide_order',$scenic_aguide_order);
		$this->assign('user',$this->user_session);
		$this->assign('age',$age);
		$this->display();
	}
	# 关闭向导
	public function close_guide(){
		$data['guide_status']	=	$_POST['guide_status'];
		$data['update_time']	=	$_SERVER['REQUEST_TIME'];
		$where['guide_id']	=	$_POST['guide_id'];
		if(empty($data) && empty($where)){
			$this->returnCode('40000007');
		}
		$scenic_aguide	=	D('Scenic_aguide')->save_aguide($where,$data);
		if($scenic_aguide){
			$this->returnCode(0);
		}else{
			$this->returnCode('40000007');
		}
	}
	# 我的结伴
	public function mate(){
		$this->user_sessions();
		$url	=	$this->config['site_url'].U('Scenic_user/mate_details');
		$this->assign('url',$url);
		$this->display();
	}
	# 我的结伴
	public function mate_json(){
		$city_ids	=	$this->config['scenic_city'];
		$start_tiem	=	date('Y-m-d',$_SERVER['REQUEST_TIME']);
		$page	=	$_POST['page'];
		$scenic_min_mate	=	D('Scenic_mate')->save_all_scenic_mate_time($city_ids,$start_tiem);
		$city_id['user_id']	=	$this->user_session['uid'];
		$city_id['is_mate']	=	1;
		$page	=	$_POST['page'];
		$scenic_mate_order	=	D('Scenic_mate')->get_all_scenic_mate_order($city_id,$page);
		foreach($scenic_mate_order as $v){
			$scenic_mate[]	=	D('Scenic_mate')->get_one_scenic_mate(array('mate_id'=>$v['mate_id']));
		}
		if($scenic_mate){
			foreach($scenic_mate as &$v){
				$v['scenic_mate']	=	D('Scenic_mate')->get_one_scenic_mate_order(array('mate_id'=>$v['mate_id'],'is_mate'=>1));
				$v['scenic_list']	=	D('Scenic_list')->get_one_list(array('scenic_id'=>$v['scenic_id']));
				$v['scenic_user']	=	D('User')->get_user($v['scenic_mate']['user_id']);
				$v['create_time']	=	date('Y-m-d H:i',$v['create_time']);
				$v['url']			=	$this->config['site_url'].U('Scenic_user/mate_details',array('mate_id'=>$v['mate_id']));
			}
		}else{
			$this->returnCode('40000008');
		}
		$this->returnCode(0,$scenic_mate);
	}
	# 我的参与结伴
	public function mate_partake(){
		$this->user_sessions();
		$url	=	$this->config['site_url'].U('Scenic_user/mate_details');
		$this->assign('url',$url);
		$this->display();
	}
	# 我的参与结伴
	public function mate_partake_json(){
		$city_ids	=	$this->config['scenic_city'];
		$start_tiem	=	date('Y-m-d',$_SERVER['REQUEST_TIME']);
		$page	=	$_POST['page'];
		$scenic_min_mate	=	D('Scenic_mate')->save_all_scenic_mate_time($city_ids,$start_tiem);
		$city_id['user_id']	=	$this->user_session['uid'];
		$city_id['is_mate']	=	2;
		$page	=	$_POST['page'];
		$scenic_mate_order	=	D('Scenic_mate')->get_all_scenic_mate_order($city_id,$page);
		foreach($scenic_mate_order as $k=>$v){
			$scenic_mate[]	=	D('Scenic_mate')->get_one_scenic_mate(array('mate_id'=>$v['mate_id']));
			$key[]	=	$k;
		}
		if($scenic_mate){
			foreach($scenic_mate as $k=>&$v){
				$v['scenic_mate']	=	D('Scenic_mate')->get_one_scenic_mate_order(array('mate_id'=>$v['mate_id'],'is_mate'=>1));
				$v['scenic_list']	=	D('Scenic_list')->get_one_list(array('scenic_id'=>$v['scenic_id']));
				$v['scenic_user']	=	D('User')->get_user($v['scenic_mate']['user_id']);
				$v['create_time']	=	date('Y-m-d H:i',$v['create_time']);
				$v['url']			=	$this->config['site_url'].U('Scenic_user/mate_details',array('mate_id'=>$v['mate_id']));
			}
		}else{
			$this->returnCode('40000008');
		}
		$this->returnCode(0,$scenic_mate);
	}
	# 我的结伴详情
	public function mate_details(){
//		$this->user_sessions();
		$where['mate_id']	=	$_GET['mate_id'];
		# 单个结伴详情
		$scenic_mate	=	D('Scenic_mate')->get_one_scenic_mate($where);
		# 结伴发起人
		$scenic_mate['scenic_mate']	=	D('Scenic_mate')->get_one_scenic_mate_order(array('mate_id'=>$scenic_mate['mate_id'],'is_mate'=>1));
		# 结伴响应人
		$scenic_mate['scenic_mates']	=	D('Scenic_mate')->get_all_scenic_mate_order(array('mate_id'=>$scenic_mate['mate_id']));
//		$scenic_mate['response_count']	=	D('Scenic_mate')->mate_count($scenic_mate['mate_id']);
		# 景区
		$scenic_title	=	D('Scenic_list')->get_one_list(array('scenic_id'=>$scenic_mate['scenic_id']),array('scenic_title'));
		$scenic_mate['scenic_title']	=	$scenic_title['scenic_title'];
		# 发起人详情
		$scenic_mate['scenic_user']	=	D('User')->get_user($scenic_mate['scenic_mate']['user_id']);
		if(empty($scenic_mate['scenic_user']['avatar'])){
			$scenic_mate['scenic_user']['avatar']	=	$this->config['site_url'] . '/static/images/user_avatar.jpg';
		}
		# 响应人详情
		foreach($scenic_mate['scenic_mates'] as $k=>&$v){
			$scenic_mate['scenic_mates'][$k]['user']	=	D('User')->get_user($v['user_id']);
			if(empty($scenic_mate['scenic_mates'][$k]['user']['avatar'])){
				$scenic_mate['scenic_mates'][$k]['user']['avatar']	=	$this->config['site_url'] . '/static/images/user_avatar.jpg';
			}
		}
		$scenic_mate['create_time']	=	date('Y-m-d H:i',$scenic_mate['create_time']);
		$words	=	array(
			'mate_id'	=>	$where['mate_id'],
			'words_sid'	=>	0,
		);
		$scenic_mate['words']	=	D('Scenic_mate')->get_scenic_mate_words($words,$scenic_mate['scenic_mate']['user_id']);
		# 相关游伴
		$mate_where['city_id']	=	$this->config['scenic_city'];
		$mate_where['mate_id']	=	array('neq',$scenic_mate['mate_id']);
		$scenic_mate['hot']	=	D('Scenic_mate')->get_hot_scenic_mate($mate_where,'start_time DESC');
		foreach($scenic_mate['hot'] as &$v){
			$v['scenic_mate']	=	D('Scenic_mate')->get_one_scenic_mate_order(array('mate_id'=>$v['mate_id'],'is_mate'=>1));
			$v['scenic_user']	=	D('User')->get_user($v['scenic_mate']['user_id']);
			if(empty($v['scenic_user']['avatar'])){
				$v['scenic_user']['avatar']	=	$this->config['site_url'] . '/static/images/user_avatar.jpg';
			}
			$title		=	D('Scenic_list')->get_one_list(array('scenic_id'=>$v['scenic_id']),array('scenic_title'));
			$v['scenic_list']	=	$title['scenic_title'];
			$v['create_time']	=	date('Y-m-d H:i',$v['create_time']);
			$v['url']	=	$this->config['site_url'].U('mate_details',array('mate_id'=>$v['mate_id']));
		}
		$scenic_mate['url']	=	$this->config['site_url'].U('sign_up',array('mate_id'=>$where['mate_id']));
		$this->assign('scenic_mate',$scenic_mate);
		$this->assign('user',$this->user_session);
		$this->assign('mate_id',$where['mate_id']);
		$this->display();
	}
	# 报名
	public function sign_up(){
		$this->user_sessions();
		$mate_id	=	$_GET['mate_id'];
		$this->assign('mate_id',$mate_id);
		$this->display();
	}
	# 报名接口
	public function sign_up_json(){
		$mate_id	=	$_POST['mate_id'];
		if(empty($mate_id)){
			$this->returnCode('40000009');
		}
		$where	=	array(
			'user_id'	=>	$this->user_session['uid'],
			'mate_id'	=>	$mate_id,
		);
		$mate_where	=	D('Scenic_mate')->get_one_scenic_mate_order($where);
		if($mate_where){
			$this->returnCode('40000010');
		}
		$arr	=	array(
			'mate_id'	=>	$mate_id,
			'phone'		=>	$_POST['phone'],
			'user_id'	=>	$this->user_session['uid'],
			'rela_status'	=>	1,
			'create_time'	=>	$_SERVER['REQUEST_TIME'],
			'is_mate'	=>	2,
		);
		$scenic_mate	=	D('Scenic_mate')->add_scenic_mate_order($arr);
		if($scenic_mate){
			M('Scenic_mate')->where(array('mate_id'=>$mate_id))->setInc('people_number');
			$url	=	U('mate_details',array('mate_id'=>$mate_id));
			$this->returnCode(0,$url);
		}else{
			$this->returnCode('40000009');
		}
	}
	# 回复结伴
	public function reply_json(){
		$data	=	array(
			'user_id'	=>	$this->user_session['uid'],
			'mate_id'	=>	$_POST['mate_id'],
			'words_sid'	=>	$_POST['words_id'],
			'words_content'	=>	$_POST['words_content'],
			'create_time'	=>	$_SERVER['REQUEST_TIME'],
		);
		$scenic_mate	=	D('Scenic_mate')->add_scenic_mate_words($data);
		if($scenic_mate){
			M('Scenic_mate')->where(array('mate_id'=>$_POST['mate_id']))->setInc('words_number');
			$url	=	$this->config['site_url'].U('mate_details',array('mate_id'=>$data['mate_id']));
			$this->returnCode(0,$url);
		}else{
			$this->returnCode('40000011');
		}
	}
	# 评论
	public function comment(){
		$this->user_sessions();
		$type	=	$_GET['type'];
		$order_id	=	$_GET['order_id'];
		$this->assign('type',$type);
		$this->assign('order_id',$order_id);
		$this->display();
	}
	# 评论
	public function comment_json(){
		$type			=	$_POST['type'];
		$order_id		=	$_POST['order_id'];
		$reply_content	=	$_POST['reply_content'];
		$reply_score	=	$_POST['reply_score'];
		if($type == 1){
			$scenic_order	=	D('Scenic_order')->one_order(array('order_id'=>$order_id));
		}else if($type == 2){
			$scenic_order	=	D('Scenic_aguide')->get_one_order(array('order_id'=>$order_id));
		}
		if($scenic_order){
			$arr	=	array(
				'order_id'	=>	$scenic_order['order_id'],
				'user_id'	=>	$this->user_session['uid'],
				'ticket_id'	=>	isset($scenic_order['ticket_id'])?$scenic_order['ticket_id']:0,
				'reply_content'	=>	$reply_content,
				'reply_score'	=>	$reply_score,
				'reply_type'	=>	$type,
				'reply_time'	=>	$_SERVER['REQUEST_TIME'],
				'reply_ip'	=>	get_client_ip(1),
				'status'	=>	0,
			);
			if($type == 1){
				$arr['scenic_id']	=	$scenic_order['scenic_id'];
			}else if($type == 2){
				$arr['scenic_id']	=	$scenic_order['guide_id'];
			}
			$add	=	D('Scenic_reply')->add_scenic_reply($arr);
			if($add){
				if($type == 1){
					D('Scenic_order')->save_order(array('order_id'=>$scenic_order['order_id']),array('order_status'=>3));
					$url	=	$this->config['site'].U('ticket_order_list');
					D('Scenic_reply')->get_ticket_reply_count(array('scenic_id'=>$scenic_order['scenic_id'],'reply_type'=>1));
				}else if($type == 2){
					D('Scenic_aguide')->save_guide_order(array('order_id'=>$scenic_order['order_id']),array('rela_status'=>3));
					$url	=	$this->config['site'].U('aguide_order_list');
					D('Scenic_reply')->get_aguide_reply_count(array('scenic_id'=>$scenic_order['scenic_id'],'reply_type'=>2));
				}
				$this->returnCode(0,$url);
			}else{
				$this->returnCode('40000013');
			}
		}else{
			$this->returnCode('40000012');
		}
	}
	# 我的收藏
	public function collection(){
		$this->user_sessions();
		$this->display();
	}
	public function collection_json(){
		$where['user_id']	=	$this->user_session['uid'];
		$scenic_collection	=	M('Scenic_collection')->field(array('scenic_id','collection_id'))->where($where)->page($_POST['page'],10)->select();
		if($scenic_collection){
			$scenic_image_class = new scenic_image();
			foreach($scenic_collection as &$v){
				$scenic_list	=	D('Scenic_list')->get_one_list(array('scenic_id'=>$v['scenic_id']));
				$v['scenic_title']	=	$scenic_list['scenic_title'];
				$v['money']	=	floatval($scenic_list['money']);
				$v['reply_count']	=	$scenic_list['reply_count'];
				$v['url']	=	$this->config['site_url'].U('Scenic_list/details',array('scenic_id'=>$v['scenic_id']));
				$tmp_pic_arr = explode(';',$scenic_list['scenic_pic']);
				$v['pic'] = $scenic_image_class->get_image_by_path($tmp_pic_arr[0],$this->config['site_url'],'config','s');
			}
		}
		$this->returnCode(0,$scenic_collection);
	}
	# 出行人列表
	public function travel_person(){
		$this->user_sessions();
		$this->display();
	}
	public function travel_person_json(){
		$scenic_family	=	D('Scenic_family')->get_all_list(array('user_id'=>$this->user_session['uid']),true,$_POST['page']);
		if($scenic_family){
			foreach($scenic_family as &$v){
				if($v['gender'] == 1){
					$v['gender']	=	'男';
				}else{
					$v['gender']	=	'女';
				}
				$v['url']	=	U('add_travel',array('family_id'=>$v['family_id']));
			}
		}else{
			$this->returnCode('40000030');
		}
		$this->returnCode(0,$scenic_family);
	}
	# 新增出行人
	public function add_travel(){
		$this->user_sessions();
		if($_GET['family_id']){
			$family	=	D('Scenic_family')->get_one(array('family_id'=>$_GET['family_id']));
			$this->assign('family',$family);
			$this->assign('title','修改出行人');
		}else{
			$this->assign('title','新增出行人');
		}
		$this->display();
	}
	public function add_travel_json(){
		if($_POST){
			$this->user_sessions_json();
			$is_repeat	=	D('Scenic_family')->is_repeat($_POST['certificates'],$_POST['family_id'],$this->user_session['uid']);
			if($is_repeat){
				$this->returnCode('40000033');
			}
			$arr	=	array(
				'family_name'	=>	$_POST['family_name'],
				'gender'	=>	$_POST['gender'],
				'phone'		=>	$_POST['phone'],
				'certificates'	=>	$_POST['certificates'],
			);
			if($_POST['family_id']){
				$add_family	=	D('Scenic_family')->edit_family(array('family_id'=>$_POST['family_id']),$arr);
			}else{
				$arr['user_id']		=	$this->user_session['uid'];
				$arr['add_time']	=	$_SERVER['REQUEST_TIME'];
				$add_family	=	D('Scenic_family')->add_family($arr);
			}
			if($add_family){
				$url	=	U('travel_person');
				$this->returnCode(0,$url);
			}else{
				$this->returnCode('40000029');
			}
		}else{
			$this->returnCode('40000028');
		}
	}
	# 退出登录
	public function logout(){
		session('user',null);
		session('openid',null);
		redirect(U('Scenic_index/index'));
	}
	# 公共接口
	public function user_sessions(){
		if(empty($this->user_session)){
			$location_param['referer'] = urlencode($_SERVER['REQUEST_URI']);
			redirect(U('Login/index',$location_param));
		}else{
			$User = M('User')->where(array('uid'=>$this->user_session['uid']))->find();
			if(empty($User)){
				$this->user_session	=	array();
				redirect(U('Login/index',$location_param));
			}
		}
		return $User;
	}
	public function user_sessions_json(){
		if(empty($this->user_session)){
			$this->returnCode('20020008');
		}
	}
}
?>