<?php
class PayAction extends BaseAction{
	//支付接口
	public function check(){
		$app_version = I('app_version');
		if($app_version<80||empty($app_version)){
			$this->old_check();
		}else{
			$this->new_check();
		}
	}

	/**
	 * @return 版本小于80
	 */
	public function old_check(){
		$ticket = I('ticket', false);
		if ($ticket) {
			$info = ticket::get($ticket, $this->DEVICE_ID, true);
			$this->user_session['uid'] = $info['uid'];
		}
		if(empty($this->user_session)){
			$this->returnCode('20044010');
		}
		$_GET['type'] = I('type');
		$app_version = I('app_version');
		$app_type  = I('app_type');
		$_GET['order_id']   =   I('order_id');
		$_GET['card_id']    =   I('card_id');
		$_GET['coupon_type']    =   I('coupon_type');
		if(!in_array($_GET['type'],array('group','meal','weidian','takeout', 'food', 'foodPad','recharge','appoint','wxapp','shop','store','plat','balance-appoint'))){
			$this->returnCode('20045005');
		}

		$group_pay_offline = true;
		if($_GET['type'] == 'group'){
			$now_order = D('Group_order')->get_pay_order($this->user_session['uid'],intval($_GET['order_id']));
			if($now_order['order_info']['group_share_num']>0||$now_order['order_info']['pin_num']>0)$group_pay_offline=false;
		}else if($_GET['type'] == 'meal' || $_GET['type'] == 'takeout' || $_GET['type'] == 'food' || $_GET['type'] == 'foodPad'){
			$now_order = D('Meal_order')->get_pay_order($this->user_session['uid'],intval($_GET['order_id']), false, $_GET['type']);
		}else if($_GET['type'] == 'weidian'){
			$now_order = D('Weidian_order')->get_pay_order($this->user_session['uid'],intval($_GET['order_id']));
		}else if($_GET['type'] == 'recharge'){
			$now_order = D('User_recharge_order')->get_pay_order($this->user_session['uid'],intval($_GET['order_id']));
		}else if($_GET['type'] == 'appoint'){
			$now_order = D('Appoint_order')->get_pay_order($this->user_session['uid'],intval($_GET['order_id']));
		}else if($_GET['type'] == 'wxapp'){
			$_GET['notOffline'] = true;
			$now_order = D('Wxapp_order')->get_pay_order($_GET['uid'],intval($_GET['order_id']));
		}else if($_GET['type'] == 'shop'){
			$now_order = D('Shop_order')->get_pay_order($this->user_session['uid'], intval($_GET['order_id']),false,true);
		}else if($_GET['type'] == 'store'){
			$now_order = D('Store_order')->get_pay_order($this->user_session['uid'], intval($_GET['order_id']),false,true);
		}else if($_GET['type'] == 'plat'){
			$now_order = D('Plat_order')->get_pay_order($this->user_session['uid'], intval($_GET['order_id']));
		}else if($_GET['type'] == 'balance-appoint'){
			$now_order = D('Appoint_order')->get_pay_balace_order($this->user_session['uid'],intval($_GET['order_id']));
		}else{
			$this->returnCode('20045010');
		}
		if($now_order['error'] == 1){
			if($now_order['url']){
				$this->returnCode('20045010');
			}else{
				$this->returnCode('20045010');
			}
		}
		if(!$now_order['order_info']['order_txt_type']){
			$now_order['order_info']['order_txt_type']  =   0;
		}
		if(!$now_order['order_info']['order_num']){
			if($_GET['type'] == 'appoint'){
				$now_order['order_info']['order_num']   =   1;
			}else{
				$now_order['order_info']['order_num']   =   0;
			}
		}
		if(!$now_order['order_info']['order_price']){
			$now_order['order_info']['order_price']   =   0;
		}
		if(!$now_order['order_info']['delivery_comment']){
			$now_order['order_info']['delivery_comment']   =   0;
		}
		$arr['order_info'] = $order_info =   isset($now_order) ? $now_order['order_info'] : array();
		//得到微信优惠金额,判断用户能否购买此团购
		$cheap_info = array('can_buy'=>true,'can_cheap'=>false,'wx_cheap'=>0);
		if($_GET['type'] == 'group'){
			$now_user = D('User')->get_user($this->user_session['uid']);
			$cheap_info['wx_cheap'] = D('Group')->get_group_cheap($order_info['group_id']);
			$cheap_info['wx_cheap'] = $cheap_info['wx_cheap']*$order_info['order_num'];
			if($cheap_info['wx_cheap']){
				$cheap_info['can_cheap'] = true;
			}
		}
		$arr['cheap_info']    =   isset($cheap_info) ? $cheap_info : array();
		//用户信息
		$now_user = D('User')->get_user($this->user_session['uid']);
		if(empty($now_user)){
			$this->returnCode('20045011');
		}
		$now_user = array(
				'uid'=>$now_user['uid'],
				'nickname'=>$now_user['nickname'],
				'now_money'=>strval($now_user['now_money']),
				'score_count'=>$now_user['score_count']
		);
		$arr['now_user']    =   isset($now_user) ? $now_user : array();
		$arr['show_pay_info'] = $_GET['type'] != 'recharge' ? 1 : 0;
		if($_GET['type'] != 'recharge' && $_GET['type'] != 'weidian'&& $_GET['type'] != 'plat'){
			//优惠券
			if(!empty($_GET['card_id'])){
				$now_coupon = D('Member_card_coupon')->get_coupon_by_recordid($_GET['card_id'],$this->user_session['uid']);
				$now_coupon['type']='mer';
			}
			if(!empty($_GET['coupon_id'])){
				$now_coupon = D('System_coupon')->get_coupon_by_id($_GET['coupon_id']);
				$now_coupon['type']='system';
			}
			//商家会员卡余额
			$merchant_balance = D('Member_card')->get_balance($this->user_session['uid'],$order_info['mer_id']);
			$pay_money = $order_info['order_total_money'] - $now_coupon['price'] - $merchant_balance - $now_user['now_money'];
		}else{
			$pay_money = $order_info['order_total_money'];
		}
		//使用积分
		$score_can_use_count=0;
		$score_deducte=0;
		if ($_GET['type'] == 'group'||$_GET['type'] == 'meal'||$_GET['type'] == 'takeout'||$_GET['type'] == 'food'||$_GET['type'] == 'foodPad'||$_GET['type'] == 'plat') {
			$type_ = $_GET['type'];
//			if($order_info['business_type']=='foodshop'){
//				$type_ = 'meal';
//			}
			$score_config = D('Config')->field('name,value')->where('tab_id="user_score"')->getField('name,value');
			$user_score_use_condition=$score_config['user_score_use_condition'];
			//$user_score_max_use=D('Percent_rate')->get_max_core_use($order_info['mer_id'],$type_);
			$user_score_max_use=$score_config['user_score_max_use'];
			if($_GET['type']=='group'){
				$group_info = D('Group')->where(array('group_id'=>$order_info['group_id']))->find();
				if($group_info['score_use']){
					if($group_info['group_max_score_use']!=0){
						$user_score_max_use = $group_info['group_max_score_use'];
					}
				}else{
					$user_score_max_use = 0;
				}
			}
			$user_score_use_percent=(float)$score_config['user_score_use_percent'];
			$score_max_deducte=bcdiv($user_score_max_use,$user_score_use_percent,2);
			if($user_score_use_percent>0&&$score_max_deducte>0&&$user_score_use_condition>0&&$now_user['score_count']>0){   //如果设置没有错误
				$total_ = isset($now_coupon['price'])?$order_info['order_total_money']-$now_coupon['price']:$order_info['order_total_money'];
				if ($cheap_info['can_cheap']) {
					$total_-=$cheap_info['wx_cheap'];
				}
				if ($total_>=$user_score_use_condition) {             //判断是否够使用积分的条件，即这个订单的总额是否大于规定的金额
					if($total_>$score_max_deducte){                    //判断积分最大抵扣金额是否比这个订单的总额大
						$score_can_use_count = (int)($now_user['score_count']>$user_score_max_use?$user_score_max_use:$now_user['score_count']);//如果用户积分大于每个订单的积分可使用数 则按可使用数算
						$score_deducte =bcdiv($score_can_use_count,$user_score_use_percent,2);
						$score_deducte = $score_deducte>$total_?$total_:$score_deducte;

					}else{                                                                      //最大可抵扣的金额比总单金额大 只扣掉总单范围内的积分 扣除积分=总单*积分抵扣比例
						$score_can_use_count = ceil($total_*$user_score_use_percent)>(int)$now_user['score_count']?(int)$now_user['score_count']:ceil($total_*$user_score_use_percent);
						$score_deducte = bcdiv($score_can_use_count,$user_score_use_percent,2);
						$score_deducte = $score_deducte>$total_?$total_:$score_deducte;
					}
				}
			}
		}
		$arr['score']['user_score_use_condition'] = isset($score_config['user_score_use_condition'])?intval($score_config['user_score_use_condition']):0;    // 满一百块钱，可以使用积分
		$arr['score']['score_can_use_count'] = isset($score_can_use_count)?intval($score_can_use_count):0;    // 积分可兑换数量
		$arr['score']['score_deducte'] = isset($score_deducte)?rtrim(rtrim(number_format($score_deducte,2,'.',''),'0'),'.'):0;  //积分抵扣
		$arr['score']['score_count'] = isset($now_user['score_count'])?intval($now_user['score_count']):0;    //用户积分总数

		if($arr['cheap_info']['wx_cheap']){
			$pay_money  =   $pay_money  -   $arr['cheap_info']['wx_cheap'];
		}
		//需要支付的钱
		$arr['now_coupon']    =   isset($now_coupon) ? $now_coupon : 0;
		$arr['show_card']       =   in_array($_GET['type'],array('weidian','wxapp')) ? 0 : 1;
		$arr['merchant_balance']    =   isset($merchant_balance) ? $merchant_balance : 0;
		$arr['pay_money']    =   $pay_money > 0 ? rtrim(rtrim(number_format($pay_money,2,'.',''),'0'),'.') : 0;

		//调出支付方式
		$notOnline = intval($_GET['notOnline']);
		if($_GET['type'] != 'recharge' && $_GET['type'] != 'appoint'){
			$notOffline = intval($_GET['notOffline']);
		}else{
			$notOffline = 1;
		}

		//********************预定金不允许线下支付*************************//
		if (intval($_GET['isdeposit'])) $notOffline = 1;
		if($_GET['type'] == 'meal' || $_GET['type'] == 'takeout' || $_GET['type'] == 'food' || $_GET['type'] == 'foodPad'){
			$t_order = D('Meal_order')->get_order_by_id($this->user_session['uid'], intval($_GET['order_id']));
			$true_price = $t_order['total_price'] - $t_order['minus_price'];
			if ($t_order['price'] < $true_price) $notOffline = 1;
		}
		//********************预定金不允许线下支付*************************//


		$merchant = D('Merchant')->get_info($order_info['mer_id']);
		if ($merchant) {
			$notOffline = $merchant['is_close_offline'] == 0 && $merchant['is_offline'] == 1 ? 0 : 1;
		}

		if (isset($_GET['online']) && $_GET['type'] == 'foodPad') {
			$online = isset($_GET['online']) ? intval($_GET['online']) : 1;
			$notOnline = $online ? 0 : 1;
			$notOffline = $online ? 1 : $notOffline;
		}
		
		$pay_method = D('Config')->get_pay_method($notOnline,$notOffline,true);
		if($_GET['type'] == 'appoint'){
			unset($pay_method['offline']);
		}
		unset($pay_method['weixin']);
		
		
		if(C('config.pay_alipay_app_open')){
			if($app_type==1&&$app_version>=65){
				unset($pay_method['alipay']);
			}elseif($app_type==2&&$app_version>=60){
				unset($pay_method['alipay']);
			}
		}

		$pay_offline = D('Percent_rate')->pay_offline($order_info['mer_id'],$_GET['type']);
		if(!$pay_offline||!$group_pay_offline){
			unset($pay_method['offline']);
		}


		if(!empty($pay_method)){
			foreach($pay_method as $k => $v){
				$array[]  =   array(
						'name'  =>  $v['name'],
						'type'  =>  $k,
						'pic'   =>  $this->config['site_url'].'/upload/pay/'.$k.'.png',
				);
			}
		}

		if ($_GET['type'] == 'takeout' || $_GET['type'] == 'food' || $_GET['type'] == 'foodPad') {
			$order_table = 'Meal_order';
		}else if($_GET['type']=='recharge'){
			$order_table = 'User_recharge_order';
		}else{
			$order_table = ucfirst($_GET['type']).'_order';
		}

		$arr['order_info']['order_price']   =   rtrim(rtrim(number_format($arr['order_info']['order_price'],2,'.',''),'0'),'.');
		$arr['order_info']['order_total_money']   =   rtrim(rtrim(number_format($arr['order_info']['order_total_money'],2,'.',''),'0'),'.');
		$arr['pay_method']  =   isset($array)?$array:array();
		$arr['notOnline'] = $notOnline;
		$arr['notOffline'] = $notOffline;
		$this->returnCode(0,$arr);
	}

	/**
	 * @return 版本大于80
	 */
	public function new_check(){
			$ticket = I('ticket', false);
			if ($ticket) {
				$info = ticket::get($ticket, $this->DEVICE_ID, true);
				$this->user_session['uid'] = $info['uid'];
			}
			if(empty($this->user_session)){
				$this->returnCode('20044010');
			}
			$order_type = I('type');
			$app_version = I('app_version');
			$app_type  = I('app_type');
			$_GET['order_id']   =   I('order_id');
			$merchant_coupon_id    =   I('merchant_coupon_id');
			$system_coupon_id    =   I('system_coupon_id');
			$use_score    =   I('use_score');
			$use_merchant_money    =   I('use_merchant_money');
			$use_balance_money    =   I('use_balance_money');
			$use_sys_coupon    =   I('use_sys_coupon');
			$use_mer_coupon    =   I('use_mer_coupon');

			if(!in_array($order_type,array('group','meal','weidian','takeout', 'food', 'foodPad','recharge','appoint','wxapp','shop','store','plat','balance-appoint'))){
				$this->returnCode('20045005');
			}

			$group_pay_offline = true;
			if($order_type == 'group'){
				$now_order = D('Group_order')->get_pay_order($this->user_session['uid'],intval($_GET['order_id']));
				if($now_order['order_info']['group_share_num']>0||$now_order['order_info']['pin_num']>0)$group_pay_offline=false;
			}else if($order_type == 'meal' || $order_type == 'takeout' || $order_type == 'food' || $order_type == 'foodPad'){
				$now_order = D('Meal_order')->get_pay_order($this->user_session['uid'],intval($_GET['order_id']), false, $order_type);
			}else if($order_type == 'weidian'){
				$now_order = D('Weidian_order')->get_pay_order($this->user_session['uid'],intval($_GET['order_id']));
			}else if($order_type == 'recharge'){
				$now_order = D('User_recharge_order')->get_pay_order($this->user_session['uid'],intval($_GET['order_id']));
			}else if($order_type == 'appoint'){
				$now_order = D('Appoint_order')->get_pay_order($this->user_session['uid'],intval($_GET['order_id']));
			}else if($order_type == 'wxapp'){
				$_GET['notOffline'] = true;
				$now_order = D('Wxapp_order')->get_pay_order($_GET['uid'],intval($_GET['order_id']));
			}else if($order_type == 'shop'){
				$now_order = D('Shop_order')->get_pay_order($this->user_session['uid'], intval($_GET['order_id']),false,true);
			}else if($order_type == 'store'){
				$now_order = D('Store_order')->get_pay_order($this->user_session['uid'], intval($_GET['order_id']),false,true);
			}else if($order_type == 'plat'){
				$now_order = D('Plat_order')->get_pay_order($this->user_session['uid'], intval($_GET['order_id']));
			}else if($order_type == 'balance-appoint'){
				$now_order = D('Appoint_order')->get_pay_balace_order($this->user_session['uid'],intval($_GET['order_id']));
			}else{
				$this->returnCode('20045010');
			}

			if($now_order['error'] == 1){
				if($now_order['url']){
					$this->returnCode('20045010');
				}else{
					$this->returnCode('20045010');
				}
			}
			if(!$now_order['order_info']['order_txt_type']){
				$now_order['order_info']['order_txt_type']  =   0;
			}
			if(!$now_order['order_info']['order_num']){
				if($order_type == 'appoint'){
					$now_order['order_info']['order_num']   =   1;
				}else{
					$now_order['order_info']['order_num']   =   0;
				}
			}
			if(!$now_order['order_info']['order_price']){
				$now_order['order_info']['order_price']   =   0;
			}
			if(!$now_order['order_info']['delivery_comment']){
				$now_order['order_info']['delivery_comment']   =   0;
			}
			$arr['order_info'] = $order_info =   isset($now_order) ? $now_order['order_info'] : array();
			$arr['pay_config']['is_recharge'] = 0 ;
			if($order_info['business_type']=='card_new_recharge'||$order_type=='recharge'){
				$arr['pay_config']['is_recharge']  =1;
			}

			//得到微信优惠金额,判断用户能否购买此团购
			$cheap_info = array('can_buy'=>true,'can_cheap'=>false,'wx_cheap'=>0);
			if($order_type == 'group'){
				$now_user = D('User')->get_user($this->user_session['uid']);
				$cheap_info['wx_cheap'] = D('Group')->get_group_cheap($order_info['group_id']);
				$cheap_info['wx_cheap'] = $cheap_info['wx_cheap']*$order_info['order_num'];
				if($cheap_info['wx_cheap']){
					$cheap_info['can_cheap'] = true;
				}
			}
			$arr['cheap_info']    =   isset($cheap_info) ? $cheap_info : array();
			//用户信息
			$now_user = D('User')->get_user($this->user_session['uid']);

			if(empty($now_user)){
				$this->returnCode('20045011');
			}
			$now_user = array(
					'uid'=>$now_user['uid'],
					'nickname'=>$now_user['nickname'],
					'now_money'=>strval($now_user['now_money']),
					'score_count'=>$now_user['score_count']
			);
			$arr['now_user']    =   isset($now_user) ? $now_user : array();
			//$arr['show_pay_info'] = $order_type != 'recharge'&& $order_type != 'card_new_recharge' ? 1 : 0;

			$order_info['total_money'] = $order_info['order_total_money'];
			$tmp_order = $order_info;
			$pay_infact = 0;
			//不同版本使用不同优惠券规则

			if($order_type != 'recharge' && $order_type != 'weidian' && (empty($order_info['business_type'])||$order_info['business_type']!='card_new_recharge')) {
				//商家优惠券
				$platform = 'app';

				$merchant_balance = 0 ;
				$card_info = D('Card_new')->get_card_by_uid_and_mer_id($this->user_session['uid'], $order_info['mer_id']);

				if($card_info['status']) {
					$merchant_balance = $card_info['card_money'] + $card_info['card_money_give'];

					if (isset($order_info['discount_status']) && !$order_info['discount_status'] || empty($card_info)||empty($card_info['discount'])) {
						$card_info['discount'] = 10;
					}
					$tmp_order['uid'] = $this->user_session['uid'];
					if($order_type=='shop'){
						$tmp_order['total_money'] = ($tmp_order['total_money']-$tmp_order['freight_charge']) * $card_info['discount'] / 10 - $cheap_info['wx_cheap']+$tmp_order['freight_charge'];
					}else{
						$tmp_order['total_money'] = $tmp_order['total_money'] * $card_info['discount'] / 10 - $cheap_info['wx_cheap'];
					}


					if ((!isset($order_info['discount_status']) || $order_info['discount_status'])&&$use_mer_coupon) {
						if (!empty($merchant_coupon_id)) {
							$tmp_coupon = D('Card_new_coupon')->get_coupon_info($merchant_coupon_id);
						}else{
							if (!empty($order_info['business_type'])) {
								$card_coupon_list = D('Card_new_coupon')->get_noworder_coupon_list($tmp_order, $order_type, $platform, $order_info['business_type']);
							} else {
								$card_coupon_list = D('Card_new_coupon')->get_noworder_coupon_list($tmp_order, $order_type, $platform);
							}
							$tmp_coupon = reset($card_coupon_list);
						}
						if(!empty($tmp_coupon)){

							$mer_coupon['had_id'] = $tmp_coupon['id'];
							//$mer_coupon['coupon_id'] = $tmp_coupon['coupon_id'];
							$mer_coupon['order_money'] = $tmp_coupon['order_money'];
							$mer_coupon['discount'] = $tmp_coupon['discount'];
						}else{
							$mer_coupon =array();

						}
					}else{
						$mer_coupon = array();
					}
				}else{
					if ($cheap_info['can_cheap']) {
						$tmp_order['total_money'] -= $cheap_info['wx_cheap'];
					}
					$mer_coupon = array();

				}

				$tmp_order['total_money'] -= empty($mer_coupon['discount']) ? 0 : $mer_coupon['discount'];

				//平台优惠券
				if (($tmp_order['total_money'] > $mer_coupon['discount'] || empty($mer_coupon))&&$use_sys_coupon&&(!isset($order_info['discount_status']) || $order_info['discount_status'])) {

					if(!empty($system_coupon_id)){
						$tmp_coupon = D('System_coupon')->get_coupon_info($system_coupon_id);
					}else{
						if (!empty($order_info['business_type'])) {
							$now_coupon = D('System_coupon')->get_noworder_coupon_list($tmp_order, $order_type, $this->user_session['phone'], $this->user_session['uid'], $platform, $order_info['business_type']);
						} else {
							$now_coupon = D('System_coupon')->get_noworder_coupon_list($tmp_order, $order_type, $this->user_session['phone'], $this->user_session['uid'], $platform);
						}
						$tmp_coupon = reset($now_coupon);

					}

					if($tmp_coupon){
						$system_coupon['had_id'] = $tmp_coupon['id'];
					//	$system_coupon['coupon_id'] = $tmp_coupon['coupon_id'];
						$system_coupon['order_money'] = $tmp_coupon['order_money'];
						$system_coupon['discount'] = $tmp_coupon['discount'];
					}else{
						$system_coupon =array();
					}
				}else{
					$system_coupon = array();
				}

				if (isset($order_info['discount_status']) && !$order_info['discount_status']) {
					$card_info['discount'] = 10;
				}
				$tmp_order['total_money'] -=$system_coupon['discount'];
			}else{
				$tmp_order['total_money'] = $tmp_order['total_money'] - $cheap_info['wx_cheap'];
				//$score_can_use_count=0;
				//使用积分
			}
			$score_can_use_count=0;
			$score_deducte=0;
			if ($order_type != 'recharge' &&  (empty($order_info['business_type'])||$order_info['business_type']!='card_new_recharge')) {
				$type_ =$order_type;
				if($order_info['business_type']=='foodshop'){
					$type_ = 'meal';
				}

				$user_score_use_condition=$this->config['user_score_use_condition'];
				$user_score_max_use=D('Percent_rate')->get_max_core_use($order_info['mer_id'],$type_);

				//$user_score_max_use=$score_config['user_score_max_use'];
				if($order_type=='group'){
					$group_info = D('Group')->where(array('group_id'=>$order_info['group_id']))->find();
					if($group_info['score_use']){
						if($group_info['group_max_score_use']!=0){
							$user_score_max_use = $group_info['group_max_score_use'];
						}
					}else{
						$user_score_max_use = 0;
					}
				}
				$user_score_use_percent=$this->config['user_score_use_percent'];
				$score_max_deducte=bcdiv($user_score_max_use,$user_score_use_percent,2);

				if($user_score_use_percent>0&&$score_max_deducte>0&&$user_score_use_condition>0&&$now_user['score_count']>0){   //如果设置没有错误
					$total_ = $tmp_order['total_money'];

					if ($total_>=$user_score_use_condition) {             //判断是否够使用积分的条件，即这个订单的总额是否大于规定的金额
						if($total_>$score_max_deducte){                    //判断积分最大抵扣金额是否比这个订单的总额大
							$score_can_use_count = (int)($now_user['score_count']>$user_score_max_use?$user_score_max_use:$now_user['score_count']);//如果用户积分大于每个订单的积分可使用数 则按可使用数算
							$score_deducte =bcdiv($score_can_use_count,$user_score_use_percent,2);
							$score_deducte = $score_deducte>$total_?$total_:$score_deducte;
						}else{                                                                      //最大可抵扣的金额比总单金额大 只扣掉总单范围内的积分 扣除积分=总单*积分抵扣比例
							$score_can_use_count = ceil($total_*$user_score_use_percent)>(int)$now_user['score_count']?(int)$now_user['score_count']:ceil($total_*$user_score_use_percent);
							$score_deducte = bcdiv($score_can_use_count,$user_score_use_percent,2);
							$score_deducte = $score_deducte>$total_?$total_:$score_deducte;
						}
					}
				}
			}

			//调出支付方式
			$notOnline = intval($_GET['notOnline']);
			if($order_type!= 'recharge' && $order_type != 'appoint'){
				$notOffline = intval($_GET['notOffline']);
			}else{
				$notOffline = 1;
			}

			//********************预定金不允许线下支付*************************//
			if (intval($_GET['isdeposit'])) $notOffline = 1;
			if($order_type == 'meal' || $order_type == 'takeout' || $order_type == 'food' || $order_type == 'foodPad'){
				$t_order = D('Meal_order')->get_order_by_id($this->user_session['uid'], intval($_GET['order_id']));
				$true_price = $t_order['total_price'] - $t_order['minus_price'];
				if ($t_order['price'] < $true_price) $notOffline = 1;
			}
			//********************预定金不允许线下支付*************************//

			$pay_offline = D('Percent_rate')->pay_offline($order_info['mer_id'],$order_type);
			$merchant = D('Merchant')->get_info($order_info['mer_id']);
			if ($merchant) {
				$notOffline = $pay_offline && $merchant['is_offline'] == 1 ? 0 : 1;
			}

			if (isset($_GET['online']) && $order_type == 'foodPad') {
				$online = isset($_GET['online']) ? intval($_GET['online']) : 1;
				$notOnline = $online ? 0 : 1;
				$notOffline = $online ? 1 : $notOffline;
			}

			$pay_method = D('Config')->get_pay_method($notOnline,$notOffline,true);
			if($order_type == 'appoint'){
				unset($pay_method['offline']);
			}
//			unset($pay_method['weixin']);
//
//			if(C('config.pay_alipay_app_open')){
//				if($app_type==1&&$app_version>=65){
//					unset($pay_method['alipay']);
//				}elseif($app_type==2&&$app_version>=60){
//					unset($pay_method['alipay']);
//				}
//			}

			
			if(!$pay_offline||!$group_pay_offline){
				unset($pay_method['offline']);
			}

			if(!empty($pay_method)){
				foreach($pay_method as $k => $v){
					$array[]  =   array(
							'name'  =>  $v['name'],
							'type'  =>  $k,
							'pic'   =>  $this->config['site_url'].'/upload/pay/'.$k.'.png',
					);
				}
			}
		if($order_type=='group'){

			$arr['order_info']['order_price']   =   rtrim(rtrim(number_format($arr['order_info']['order_price'],2,'.',''),'0'),'.');
		}else{
			$arr['order_info']['order_price']   =   rtrim(rtrim(number_format($arr['order_info']['order_total_money'],2,'.',''),'0'),'.');
		}

		if($order_type=='store'||$order_type=='recharge'||$order_info['business_type']=='card_new_recharge'){
			$arr['order_info']['order_num']   =   1;
		}
		$arr['order_info']['order_total_money']   =   rtrim(rtrim(number_format($arr['order_info']['order_total_money'],2,'.',''),'0'),'.');
		$arr['pay_method']  =   isset($array)?$array:array();

		//$arr['merchant_balance'] = $merchant_balance;
		if(empty($mer_coupon)){
			$mer_coupon['had_id'] = "";
		//	$mer_coupon['coupon_id'] = "";
			$mer_coupon['order_money'] = "";
			$mer_coupon['discount'] = "";
			$arr['mer_coupon'] = $mer_coupon;
		}else{
			$arr['mer_coupon'] = $mer_coupon;
		}

		if(empty($system_coupon)){
			$system_coupon['had_id'] = "";
		//	$system_coupon['coupon_id'] = "";
			$system_coupon['order_money'] = "";
			$system_coupon['discount'] = "";
			$arr['system_coupon'] = $system_coupon;
		}else{
			$arr['system_coupon'] = $system_coupon;
		}


		$arr['pay_config']['balance_money'] = empty($now_user['now_money'])?"0":strval($now_user['now_money']);//余额
		$arr['pay_config']['merchant_money'] = empty($merchant_balance)?"0":strval($merchant_balance); //商家余额


		$arr['pay_config']['total_money'] = strval(floatval($order_info['order_total_money']));
		$arr['pay_config']['order_id'] = $tmp_order['order_id'];
		if(!empty($card_info['discount'])){
			$arr['pay_config']['card_discount'] = $card_info['discount']==10?0:strval(floatval($card_info['discount']));
		}else{
			$arr['pay_config']['card_discount'] = 0;
		}

		$arr['pay_config']['wx_cheap'] = strval($cheap_info['wx_cheap']);
		$arr['pay_config']['merchant_coupon_discount'] = strval($mer_coupon['discount']);
		$arr['pay_config']['system_coupon_discount'] = strval($system_coupon['discount']);
		$arr['pay_config']['score_money'] = strval($score_deducte);
		$arr['pay_config']['score_count'] = strval($score_can_use_count);

		if($tmp_order['total_money']>0&&$use_score){
			$tmp_order['total_money'] -= $score_deducte;
			if($tmp_order['total_money']>=0){
				$pay_infact += $score_deducte;
			}else{
				$pay_infact += $score_deducte+$tmp_order['total_money'];
			}
		}
		if($tmp_order['total_money']>0&&$use_merchant_money){
			$tmp_order['total_money'] -= $merchant_balance;
			if($tmp_order['total_money']>=0){
				$pay_infact += $merchant_balance;
			}else{
				$pay_infact += $merchant_balance+$tmp_order['total_money'];
			}
		}

		if($tmp_order['total_money']>0&&$use_balance_money){
			$tmp_order['total_money'] -= $now_user['now_money'];
			if($tmp_order['total_money']>=0){
				$pay_infact += $now_user['now_money'];
			}else{
				$pay_infact += $now_user['now_money']+$tmp_order['total_money'];
			}
		}

		$tmp_order['total_money'] = $tmp_order['total_money']<0?0:$tmp_order['total_money'];
		$arr['pay_config']['online_pay'] = strval(sprintf("%.2f",$tmp_order['total_money']))<0.01?0:strval(sprintf("%.2f",$tmp_order['total_money']));
		$arr['pay_config']['pay_infact'] = strval(sprintf("%.2f",$pay_infact+$tmp_order['total_money']))<0.01?0:strval(sprintf("%.2f",$pay_infact+$tmp_order['total_money']));
		$this->returnCode(0,$arr);
	}


	//微信同步回调页面
	public function app_weixin_back(){
		$ticket = I('ticket', false);
		$sPayStatus =   I('pay_status',1);
		if ($ticket) {
			$info = ticket::get($ticket, $this->DEVICE_ID, true);
			$this->user_session['uid'] = $info['uid'];
		}
		$_GET['order_id']   =   I('order_id');
		$_GET['order_type']   =   I('order_type');
	
		switch($_GET['order_type']){
			case 'group':
				// $now_order = D('Group_order')->where(array('order_id'=>$_GET['order_id']))->find();
				$now_order =$this->get_orderid('Group_order',$_GET['order_id']);
				break;
			case 'meal':
				// $now_order = D('Meal_order')->where(array('order_id'=>$_GET['order_id']))->find();
				$now_order =$this->get_orderid('Meal_order',$_GET['order_id']);
				break;
			case 'takeout':
			case 'food':
			case 'foodPad':
				// $now_order = D('Meal_order')->where(array('order_id'=>$_GET['order_id']))->find();
				$now_order =$this->get_orderid('Meal_order',$_GET['order_id']);
				break;
			case 'weidian':
				// $now_order = D('Weidian_order')->get_order_by_id(intval($_GET['order_id']));
				$now_order =$this->get_orderid('Weidian_order',$_GET['order_id']);
				break;
			case 'recharge':
				// $now_order = D('User_recharge_order')->get_order_by_id(intval($_GET['order_id']));
				$now_order =$this->get_orderid('User_recharge_order',$_GET['order_id']);
				break;
			case 'appoint':
				// $now_order = D('Appoint_order')->get_order_by_id(intval($_GET['order_id']));
				$now_order =$this->get_orderid('Appoint_order',$_GET['order_id']);
				break;
			case 'waimai':
				// $now_order = D('Waimai_order')->get_order_by_id(intval($_GET['order_id']));
				$now_order =$this->get_orderid('Waimai_order',$_GET['order_id']);
				break;
			case 'wxapp':
				// $now_order = D('Wxapp_order')->get_order_by_id(intval($_GET['order_id']));
				$now_order =$this->get_orderid('Wxapp_order',$_GET['order_id']);
				break;
			case 'shop':
				// $now_order = D('Shop_order')->where(array('order_id'=>$_GET['order_id']))->find();
				$now_order =$this->get_orderid('Shop_order',$_GET['order_id']);
				break;
			case 'store':
				$now_order =$this->get_orderid('Store_order',$_GET['order_id']);
                break;
			case 'plat':
				$now_order =$this->get_orderid('Plat_order',$_GET['order_id']);
				break;
			case 'balance-appoint':
				$now_order = $this->get_orderid('Appoint_order', $_GET['order_id']);
				break;
			default:
				$this->returnCode('20045010');
		}
	
		if(empty($now_order)){
			$this->returnCode('20046002');
		}
		$now_order['order_type'] = $_GET['order_type'];
		if($now_order['paid']&&$now_order['order_type']!='balance-appoint'){
			switch($_GET['order_type']){
				case 'group':
					$redirctUrl = C('config.site_url').'/wap.php?c=My&a=group_order&order_id='.$now_order['order_id'];
					break;
				case 'meal':
					$redirctUrl = C('config.site_url').'/wap.php?c=Meal&a=detail&orderid='.$now_order['order_id'].'&mer_id='.$now_order['mer_id'].'&store_id='.$now_order['store_id'];
					break;
				case 'takeout':
					$redirctUrl = C('config.site_url').'/wap.php?c=Takeout&a=order_detail&order_id='.$now_order['order_id'].'&mer_id='.$now_order['mer_id'].'&store_id='.$now_order['store_id'];
					break;
				case 'food':
				case 'foodPad':
					$redirctUrl = C('config.site_url').'/wap.php?c=Food&a=order_detail&order_id='.$now_order['order_id'].'&mer_id='.$now_order['mer_id'].'&store_id='.$now_order['store_id'];
					break;
				case 'weidian':
					$redirctUrl = D('Weidian_order')->get_weidian_url(array('wecha_id'=>$now_order['uid'],'order_no'=>$now_order['weidian_order_id'],'pay_money'=>$now_order['money'],'third_id'=>$now_order['third_id'],'payment_method'=>$now_order['pay_type']));
					$this->NoticeWDAsyn($now_order['orderid']);
					break;
				case 'appoint':
					$redirctUrl = C('config.site_url').'/wap.php?c=My&a=appoint_order&order_id='.$now_order['order_id'];
					break;
				case 'waimai':
					$redirctUrl = C('config.site_url').'/index.php?g=Waimaiwap&c=Index&a=order&order_id='.$now_order['order_id'];
					break;
				case 'recharge':
					$redirctUrl = C('config.site_url').str_replace('/appapi.php?g=Appapi&','/wap.php?',D('User_recharge_order')->get_pay_after_url($now_order['label'],$now_order['is_mobile_pay']));
					// $redirctUrl = C('config.site_url').'/wap.php?c=My&a=index';
					break;
				case 'wxapp':
					$redirctUrl = C('config.site_url').'/wap.php?c=Wxapp&a=pay_back&order_id='.$now_order['order_id'];
				case 'shop':
					$redirctUrl = C('config.site_url').'/wap.php?c=My&a=shop_order_list';
					break;
				case 'store':
                    $redirctUrl = C('config.site_url').'/wap.php?c=My&a=store_order_list';
                    break;
				case 'plat':
					$redirctUrl = D('Plat_order')->get_order_url($now_order['order_id'],true);
					break;
				case 'balance-appoint':
					$redirctUrl = C('config.site_url').'/wap.php?c=My&a=appoint_order&order_id='.$now_order['order_id'];
					break;
			}
			$this->returnCode(0,$redirctUrl);
			exit;
		}
		$now_order['order_id']  =   $now_order['orderid'];
		$import_result = import('@.ORG.pay.Weixin');
		$pay_method = D('Config')->get_pay_method();
		if(empty($pay_method)){
			$this->returnCode('20045012');
		}
		$is_mobile  = 2;
		if($this->DEVICE_ID=='wxapp'){
			$this->config['pay_weixinapp_appid']=   $this->config['pay_wxapp_appid']  ;
			$this->config['pay_weixinapp_mchid']=$this->config['pay_wxapp_mchid'];
			$this->config['pay_weixinapp_key']=$this->config['pay_wxapp_key'];
			$this->config['pay_weixinapp_appsecret']=$this->config['pay_wxapp_appsecret'];
			$is_mobile  = 3;
		}
		$pay_class = new Weixin($now_order,0,'weixin',array('pay_weixin_appid'=>$this->config['pay_weixinapp_appid'],'pay_weixin_mchid'=>$this->config['pay_weixinapp_mchid'],'pay_weixin_key'=>$this->config['pay_weixinapp_key'],'pay_weixin_appsecret'=>$this->config['pay_weixinapp_appsecret']),$this->user_session,$is_mobile);
		$go_query_param = $pay_class->query_order();
		
		if($go_query_param['error'] === 0){
			$go_query_param['order_param']['return']=1;
			switch($_GET['order_type']){
				case 'group':
					D('Group_order')->after_pay($go_query_param['order_param']);
					break;
				case 'meal':
				case 'takeout':
				case 'food':
				case 'foodPad':
					$go_query_param['order_param']['orderid'] = $go_query_param['order_param']['order_id'];
					//unset($go_query_param['order_param']['order_id']);
					D('Meal_order')->after_pay($go_query_param['order_param'], $_GET['order_type']);
					break;
				case 'weidian':
					$pay_info = D('Weidian_order')->after_pay($go_query_param['order_param']);
					if(($pay_info['error']==0) && isset($pay_info['url'])){  /***异步通知***/
					  $this->NoticeWDAsyn($now_order['orderid']);
					}
					break;
				case 'recharge':
					D('User_recharge_order')->after_pay($go_query_param['order_param']);
					break;
				case 'waimai':
					D('Waimai_order')->after_pay($go_query_param['order_param']);
					break;
				case 'appoint':

						D('Appoint_order')->after_pay($go_query_param['order_param']);

					//D('Appoint_order')->after_pay($go_query_param['order_param']);
					break;
				case 'wxapp':
					D('Wxapp_order')->after_pay($go_query_param['order_param']);
					break;
				case 'shop':
					D('Shop_order')->after_pay($go_query_param['order_param']);
					break;
				case 'store':
                    D('Store_order')->after_pay($go_query_param['order_param']);
                    break;
				case 'plat':
					D('Plat_order')->after_pay($go_query_param['order_param']);
					break;
				case 'balance-appoint':
					D('Appoint_order')->balance_after_pay($go_query_param['order_param']);
					break;
			}
		}
		switch($_GET['order_type']){
			case 'group':
				$redirctUrl = C('config.site_url').'/wap.php?g=Wap&c=My&a=group_order&order_id='.$_GET['order_id'];
				break;
			case 'meal':
				$redirctUrl = C('config.site_url').'/wap.php?g=Wap&c=Meal&a=detail&orderid='.$_GET['order_id'].'&mer_id='.$now_order['mer_id'].'&store_id='.$now_order['store_id'];
				break;
			case 'takeout':
				$redirctUrl = C('config.site_url').'/wap.php?g=Wap&c=Takeout&a=order_detail&order_id='.$_GET['order_id'].'&mer_id='.$now_order['mer_id'].'&store_id='.$now_order['store_id'];
				break;
			case 'food':
			case 'foodPad':
				$redirctUrl = C('config.site_url').'/wap.php?g=Wap&c=Food&a=order_detail&order_id='.$_GET['order_id'].'&mer_id='.$now_order['mer_id'].'&store_id='.$now_order['store_id'];
				break;
			case 'weidian':
				$redirctUrl = D('Weidian_order')->get_weidian_url(array('wecha_id'=>$now_order['uid'],'order_no'=>$now_order['weidian_order_id'],'pay_money'=>$now_order['money'],'third_id'=>$go_query_param['order_param']['third_id'],'payment_method'=>$go_query_param['order_param']['pay_type']));
				$this->NoticeWDAsyn($now_order['orderid']);
				break;
			case 'appoint':
			case 'balance-appoint':
				$redirctUrl = C('config.site_url').'/wap.php?g=Wap&c=My&a=appoint_order&order_id='.$_GET['order_id'];
				break;
			case 'waimai':
				$redirctUrl = C('config.site_url').'/index.php?g=Waimaiwap&c=Index&a=order&order_id='.$_GET['order_id'];
				break;
			case 'recharge':
				$redirctUrl = C('config.site_url').str_replace('/appapi.php?g=Appapi&','/wap.php?',D('User_recharge_order')->get_pay_after_url($now_order['label'],$now_order['is_mobile_pay']));
				break;
			case 'wxapp':
				$redirctUrl = C('config.site_url').'/wap.php?c=Wxapp&a=pay_back&order_id='.$_GET['order_id'];
				break;
			case 'shop':
				$redirctUrl = C('config.site_url').'/wap.php?c=My&a=shop_order_list';
				break;
			case 'store':
                $redirctUrl = C('config.site_url').'/wap.php?c=My&a=store_order_list';
                break;
			case 'plat':
				$redirctUrl = D('Plat_order')->get_order_url($now_order['order_id'],true);
				break;
		}
		$this->returnCode(0,$redirctUrl);
	}
	/***异步通知*微店**/
    public function NoticeWDAsyn($order_id){
        $now_order = M('Weidian_order')->field(true)->where(array('orderid'=>trim($order_id)))->find();
        if(!empty($now_order) && ($now_order['pay_type']=='weixin' || $now_order['pay_type']=='alipay')){
            $wdAsynarr=array('order_no'=>$now_order['weidian_order_id'],'pay_money'=>$now_order['money'],'third_id'=>$now_order['third_id'],'payment_method'=>$now_order['pay_type']);
            $wdAsynarr['salt'] = 'pigcms';
            ksort($wdAsynarr);
            $wdAsynarr['sign_key'] = sha1(http_build_query($wdAsynarr));
            $wdAsynarr['request_time'] = time();
            $returnarr=httpRequest($this->config['weidian_url'].'/api/pay_notify.php','POST',$wdAsynarr);
            if(empty($returnarr['1'])){
                $returnarr=httpRequest($this->config['weidian_url'].'/api/pay_notify.php','POST',$wdAsynarr);
            }
        }
    }
	public function go_pay(){
		$ticket = I('ticket', false);
		if ($ticket) {
			$info = ticket::get($ticket, $this->DEVICE_ID, true);
			$this->user_session['uid'] = $info['uid'];
		}
		if(empty($this->user_session)){
			$this->returnCode('20044010');
		}
		$_POST['order_type']    =   I('order_type');
		$_POST['order_id']    =   I('order_id');
		$_POST['pay_type']    =   I('pay_type');
		$_POST['card_id']    =   I('card_id');
		$app_version = I('app_version');
		$merchant_coupon_id    =  	$_POST['card_id'] ;
		$system_coupon_id    =   I('coupon_id');
		$use_score    =   I('use_score');
		$use_merchant_money    =   I('use_merchant_money');
		$use_balance_money    =   I('use_balance_money');
		$use_sys_coupon    =   I('use_sys_coupon')?I('use_sys_coupon'):0;
		$use_mer_coupon    =   I('use_mer_coupon')?I('use_mer_coupon'):0;
		if(!in_array($_POST['order_type'],array('group','meal','weidian','takeout','food','foodPad','recharge','appoint','waimai','wxapp','store','shop','plat','balance-appoint'))){
			$this->returnCode('20045005');
		}
		if (strtolower($_POST['pay_type']) == 'alipay'&&!$this->config['pay_alipay_app_open']) {
			$url = U('Pay/alipay', $_POST);
			$arr['alipay']  =   $url;
			die;
		}

		switch($_POST['order_type']){
			case 'group':
				$now_order = D('Group_order')->get_pay_order($this->user_session['uid'],intval($_POST['order_id']));
				break;
			case 'meal':
			case 'takeout':
			case 'food':
			case 'foodPad':
				$now_order = D('Meal_order')->get_pay_order($this->user_session['uid'], intval($_POST['order_id']), false,  $_POST['order_type']);
				break;
			case 'weidian':
				$now_order = D('Weidian_order')->get_pay_order($this->user_session['uid'],intval($_POST['order_id']));
				break;
			case 'recharge':
				$now_order = D('User_recharge_order')->get_pay_order($this->user_session['uid'],intval($_POST['order_id']));
				break;
			case 'appoint':
				$now_order = D('Appoint_order')->get_pay_order($this->user_session['uid'],intval($_POST['order_id']));
				break;
			case 'waimai':
				$now_order = D('Waimai_order')->get_pay_order($this->user_session['uid'],intval($_POST['order_id']),false,$_POST['order_type']);
				if ($now_order['order_info']['pay_type'] !== $_POST['pay_type']) {
					$this->returnCode('20045010');
				}
				break;
			case 'wxapp':
				$now_order = D('Wxapp_order')->get_pay_order(0,intval($_POST['order_id']));
				break;
			case 'store':
				$now_order = D('Store_order')->get_pay_order($this->user_session['uid'], intval($_POST['order_id']));
				break;
			case 'shop':
				$now_order = D('Shop_order')->get_pay_order($this->user_session['uid'],intval($_POST['order_id']));
				break;
			case 'plat':
				$now_order = D('Plat_order')->get_pay_order($this->user_session['uid'], intval($_POST['order_id']));
				break;
			case 'balance-appoint':
				$now_order = D('Appoint_order')->get_pay_balace_order($this->user_session['uid'],intval($_POST['order_id']));
				break;
			default:
				$this->returnCode('20045010');
		}
		if($now_order['paid']==1){
			$this->returnCode('20130037');
		}

		if($now_order['error'] == 1){
			$this->returnCode($now_order['msg'],$now_order['url']);
		}
		$order_info = $now_order['order_info'];

		if($_POST['order_type'] != 'recharge' && $_POST['order_type'] != 'weidian' && (empty($order_info['business_type'])||$order_info['business_type']!='card_new_recharge')) {
			if($app_version<80||empty($app_version)){
				if(!empty($_POST['card_id'])){
					$now_coupon = D('Member_card_coupon')->get_coupon_by_recordid($_POST['card_id'],$this->user_session['uid']);
					if(empty($now_coupon)){
						$this->returnCode('20031001');
					}
					$now_coupon['type']='mer';
				}

				if(!empty($_POST['coupon_id'])){
					$now_coupon = D('System_coupon')->get_coupon_by_id($_POST['coupon_id']);
					if(empty($now_coupon)){
						$this->returnCode('20031001');
					}
					$now_coupon['type']='system';
				}
				//商家会员卡余额
				$merchant_balance = D('Member_card')->get_balance($this->user_session['uid'],$order_info['mer_id']);
			}else {
				if (!isset($order_info['discount_status']) || $order_info['discount_status']) {
					if (!empty($merchant_coupon_id)&&$use_mer_coupon) {
						$mer_coupon = D('Card_new_coupon')->get_coupon_info($merchant_coupon_id);
						if (empty($mer_coupon)) {
							$this->returnCode('20031001');
						}
						$now_coupon['card_price'] = $mer_coupon['discount'];
						$now_coupon['merc_id'] = $mer_coupon['id'];
					}

					if (!empty($system_coupon_id) && $use_sys_coupon ) {
						$system_coupon = D('System_coupon')->get_coupon_info($system_coupon_id);
						if (empty($system_coupon)) {
							$this->returnCode('20031001');
						}
						$now_coupon['coupon_price'] = $system_coupon['discount'];
						$now_coupon['sysc_id'] = $system_coupon['id'];
					}
				}


				$card_info = D('Card_new')->get_card_by_uid_and_mer_id($this->user_session['uid'], $order_info['mer_id']);
				if (empty($card_info)) {
					$merchant_balance['card_money'] = 0;
					$merchant_balance['card_give_money'] = 0;
					$merchant_balance['card_discount'] = 10;
				} else {
					$merchant_balance['card_money'] = $card_info['card_money'];
					$merchant_balance['card_give_money'] = $card_info['card_money_give'];
					$merchant_balance['card_discount'] = empty($card_info['discount']) || (isset($order_info['discount_status']) && !$order_info['discount_status']) ? 10 : $card_info['discount'];
				}


				$cheap_info = array('can_buy'=>true,'can_cheap'=>false,'wx_cheap'=>0);
				//if($_POST['order_type'] == 'group'){
					$now_user = D('User')->get_user($this->user_session['uid']);
					$cheap_info['wx_cheap'] = D('Group')->get_group_cheap($order_info['group_id']);
					$cheap_info['wx_cheap'] = $cheap_info['wx_cheap']*$order_info['order_num'];
					if($cheap_info['wx_cheap']){
						$cheap_info['can_cheap'] = true;
					}
				//}
				$order_info['total_money'] = $order_info['order_total_money'];
				$tmp_order = $order_info;
				$tmp_order['total_money'] = $tmp_order['total_money'] * $merchant_balance['card_discount'] / 10 - $cheap_info['wx_cheap'];

				$order_info['use_score'] = $use_score?1:0;

				$score_deducte=0;
				if($use_score) {
					$type_ = $_POST['order_type'];
					if ($order_info['business_type'] == 'foodshop') {
						$type_ = 'meal';
					}

					$user_score_use_condition = $this->config['user_score_use_condition'];
					$user_score_max_use = D('Percent_rate')->get_max_core_use($order_info['mer_id'], $type_);
					if ($_POST['order_type'] == 'group') {
						$group_info = D('Group')->where(array('group_id' => $order_info['group_id']))->find();
						if ($group_info['score_use']) {
							if ($group_info['group_max_score_use'] != 0) {
								$user_score_max_use = $group_info['group_max_score_use'];
							}
						} else {
							$user_score_max_use = 0;
						}
					}
					$user_score_use_percent = $this->config['user_score_use_percent'];
					$score_max_deducte = bcdiv($user_score_max_use, $user_score_use_percent, 2);
					if ($user_score_use_percent > 0 && $score_max_deducte > 0 && $user_score_use_condition > 0 && $now_user['score_count'] > 0) {   //如果设置没有错误
						$total_ = $tmp_order['total_money'];

						if ($total_ >= $user_score_use_condition) {             //判断是否够使用积分的条件，即这个订单的总额是否大于规定的金额
							if ($total_ > $score_max_deducte) {                    //判断积分最大抵扣金额是否比这个订单的总额大
								$score_can_use_count = (int)($now_user['score_count'] > $user_score_max_use ? $user_score_max_use : $now_user['score_count']);//如果用户积分大于每个订单的积分可使用数 则按可使用数算
								$score_deducte = bcdiv($score_can_use_count, $user_score_use_percent, 2);
								$score_deducte = $score_deducte > $total_ ? $total_ : $score_deducte;

							} else {                                                                      //最大可抵扣的金额比总单金额大 只扣掉总单范围内的积分 扣除积分=总单*积分抵扣比例
								$score_can_use_count = ceil($total_ * $user_score_use_percent) > (int)$now_user['score_count'] ? (int)$now_user['score_count'] : ceil($total_ * $user_score_use_percent);
								$score_deducte = bcdiv($score_can_use_count, $user_score_use_percent, 2);
								$score_deducte = $score_deducte > $total_ ? $total_ : $score_deducte;
							}
						}
					}
				}
				$order_info['score_deducte'] = $score_deducte;
				$order_info['use_merchant_balance'] = $use_merchant_money?1:0;
				$order_info['use_balance'] = $use_balance_money?1:0;
				$order_info['score_used_count'] =$score_can_use_count;
			}
		}else{
			$merchant_balance['card_money'] = 0;
			$merchant_balance['card_give_money'] = 0;
			$merchant_balance['card_discount'] = 10;
		}

		//用户信息
		$now_user = D('User')->get_user($this->user_session['uid']);

		if(empty($now_user)){
			$this->returnCode('20045011');
		}
		if($app_version<80||empty($app_version)) {
			$_POST['use_score'] = I('use_score');
			$_POST['score_deducte'] = I('score_deducte');
			$_POST['score_used_count'] = I('score_used_count');
			if ($_POST['use_score']) {
				if ($now_user['score_count'] < $_POST['score_used_count']) {
					$this->returnCode('20031003');
				}
				$order_info['score_used_count'] = $_POST['score_used_count'];
				$order_info['score_deducte'] = $_POST['score_deducte'];
			} else {
				$order_info['score_used_count'] = 0;
				$order_info['score_deducte'] = 0;
			}

			$order_info['use_balance'] = 1;
			$order_info['use_merchant_balance'] = 1;
			$merchant_balance = array();
			$merchant_balance['card_discount'] = 10;
		}


		//print_r($wx_cheap);
		//如果用户存在余额或使用了优惠券，则保存至订单信息。如果金额满足订单总价，则实时扣除并返回支付成功！若不够则不实时扣除，防止用户在付款过程中取消支付
		$wx_cheap = 0;
		if($order_info['order_type'] == 'group'){
			$now_group = M('Group')->field('`group_id`,`wx_cheap`')->where(array('group_id'=>$order_info['group_id']))->find();
			$wx_cheap = $order_info['order_num'] * $now_group['wx_cheap'];
			$save_result = D('Group_order')->wap_befor_pay($order_info,$now_coupon,$merchant_balance,$now_user,$wx_cheap);
		}else if($order_info['order_type'] == 'meal' || $order_info['order_type'] == 'takeout' || $order_info['order_type'] == 'food' || $order_info['order_type'] == 'foodPad'){
			$save_result = D('Meal_order')->wap_befor_pay($order_info,$now_coupon,$merchant_balance,$now_user, $order_info['order_type']);
		}else if($order_info['order_type'] == 'weidian'){
			$save_result = D('Weidian_order')->wap_befor_pay($order_info,$now_coupon,$merchant_balance,$now_user);
		}else if($order_info['order_type'] == 'recharge'){
			$save_result = D('User_recharge_order')->wap_befor_pay($order_info,$now_user);
		}else if($order_info['order_type'] == 'appoint'){
			$save_result = D('Appoint_order')->wap_befor_pay($order_info,$now_coupon,$merchant_balance,$now_user);
		}else if($order_info['order_type'] == 'waimai'){
			$save_result = D('Waimai_order')->wap_befor_pay($order_info,$merchant_balance,$now_user);
		}else if($order_info['order_type'] == 'wxapp'){
			$save_result = D('Wxapp_order')->wap_befor_pay($order_info,$now_coupon,$merchant_balance,$now_user);
		}else if($order_info['order_type'] == 'store'){
			$save_result = D('Store_order')->wap_befor_pay($order_info,$now_coupon,$merchant_balance,$now_user);
		}else if($order_info['order_type'] == 'shop'){
			$save_result = D('Shop_order')->wap_befor_pay($order_info,$now_coupon,$merchant_balance,$now_user);
		}else if($order_info['order_type'] == 'plat'){
			$save_result = D('Plat_order')->wap_befor_pay($order_info,$now_coupon,$merchant_balance,$now_user);
		}else if($order_info['order_type'] == 'balance-appoint'){
			$save_result = D('Appoint_order')->wap_balace_befor_pay($order_info,$now_coupon,$merchant_balance,$now_user);
		}

		if($save_result['error_code']){
			$this->returnCode(1,array(),$save_result['msg']);
		}else if($save_result['url']){
			$this->returnCode(1,array(),$save_result['msg']);
		}

		$order_id = $order_info['order_id'];
		if ($_POST['order_type'] == 'takeout' || $_POST['order_type'] == 'food' || $_POST['order_type'] == 'foodPad') {
			$order_table = 'Meal_order';
		}else if($_POST['order_type']=='recharge'){
			$order_table = 'User_recharge_order';
		}else if($_POST['order_type']=='balance-appoint'){
			$order_table = 'Appoint_order';
		}else{
			$order_table = ucfirst($_POST['order_type']).'_order';
		}

		$nowtime = date("ymdHis");
		if($_POST['order_type']=='balance-appoint'){
			$nowtime = date("mdHis");
			$orderid = $nowtime.sprintf("%06d",$this->user_session['uid']);;
		}else{
			$orderid = $nowtime.rand(10,99).sprintf("%08d",$this->user_session['uid']);
		}
		$data_tmp['pay_type'] = $_POST['pay_type'];
		$data_tmp['order_type'] = $_POST['order_type'];
		$data_tmp['order_id'] = $order_id;
		$data_tmp['orderid'] = $orderid;
		$data_tmp['addtime'] = $nowtime;
		if(!D('Tmp_orderid')->add($data_tmp)){
			fdump(D('Tmp_orderid'),'tmp_orderid_table_error',1);
			$this->returnCode('20046008');
		}
		$save_pay_id = D($order_table)->where(array("order_id"=>$order_id))->setField('orderid',$orderid);
		if(!$save_pay_id){
			$this->returnCode('20046008');
		}else{
			$order_info['order_id']=$orderid;
		}
		$pay_money = round($save_result['pay_money']*100)/100;
		if($_POST['pay_type']&&$this->DEVICE_ID=='wxapp'){
			$_SESSION['openid'] = $now_user['wxapp_openid'];
			$pay_method = array(
					'pay_weixin_appid'=>$this->config['pay_wxapp_appid'],
					'pay_weixin_key'=>$this->config['pay_wxapp_key'],
					'pay_weixin_mchid'=>$this->config['pay_wxapp_mchid'],
					'pay_weixin_appsecret'=>$this->config['pay_wxapp_appsecret'],
			);
			$import_result = import('@.ORG.pay.Weixin');
			$pay_class = new Weixin($order_info,$pay_money,'weixin',$pay_method,$now_user,3);
			$go_pay_param = $pay_class->pay();
			$arr['pay_money'] = $pay_money;
			$arr['weixin_param'] = json_decode($go_pay_param['weixin_param']);
			$arr['error'] = 0;
			$arr['orderid'] = $orderid;

			$this->returnCode(0,$arr);
		}else{
			$this->returnCode(0,$orderid);
		}
	}


	public function get_orderid($table,$order_id,$offline=0){
		if(strlen($order_id) < 12){
			$orderStr = 'order_id';
		}else{
			$orderStr = 'orderid';
		}
		$order =  D($table);
		$tmp_orderid = D('Tmp_orderid');
		if($offline){
			$now_order = $order->where(array($orderStr=>$order_id))->find();
		}else{
			$now_order = $order->where(array($orderStr=>$order_id))->find();
			if(empty($now_order)){
				$res = $tmp_orderid->where(array('orderid'=>$order_id))->find();
				$now_order = $order->where(array('order_id'=>$res['order_id']))->find();
				$order->where(array('order_id'=>$res['order_id']))->setField('orderid',$order_id);
				$now_order['orderid']=$order_id;
			}
		}
		if(empty($now_order)){
			$this->returnCode('20045010');
		}

		return $now_order;
	}
	//跳转通知
	public function return_url(){

		$pay_type = $_GET['pay_type'];
		$pay_method = D('Config')->get_pay_method();
		if(empty($pay_method)){
			$this->returnCode('20070003');
		}
		if(empty($pay_method[$pay_type])){
			$this->returnCode('20070004');
		}
		$pay_class_name = ucfirst($pay_type);
		$import_result = import('@.ORG.pay.'.$pay_class_name);
		if(empty($import_result)){
			$this->returnCode('20070005');
		}
		$is_mobile = 2;
		if($pay_type == 'weixin'){
			$pay_method[$pay_type]['config'] = array(
					'pay_weixin_appid'=>$this->config['pay_weixinapp_appid'],
					'pay_weixin_mchid'=>$this->config['pay_weixinapp_mchid'],
					'pay_weixin_key'=>$this->config['pay_weixinapp_key'],
					'pay_weixin_appsecret'=>$this->config['pay_weixinapp_appsecret']
			);
		}
		if($_GET['Device-Id'] == 'wxapp'){
			$pay_method[$pay_type]['config'] = array(
					'pay_weixin_appid'=>$this->config['pay_wxapp_appid'],
					'pay_weixin_mchid'=>$this->config['pay_wxapp_mchid'],
					'pay_weixin_key'=>$this->config['pay_wxapp_key'],
					'pay_weixin_appsecret'=>$this->config['pay_wxapp_appsecret']
			);
			$is_mobile = 3;
		}

		$pay_class = new $pay_class_name('','',$pay_type,$pay_method[$pay_type]['config'],$this->user_session,$is_mobile);
		$get_pay_param = $pay_class->return_url();
		// file_put_contents('./weixinpay_test/'.$_SERVER['HTTP_HOST'].'_'.date('Y-m-d').'.php',var_export($get_pay_param,true).PHP_EOL.PHP_EOL.file_get_contents('./weixinpay_test/'.$_SERVER['HTTP_HOST'].'_'.date('Y-m-d').'.php'));
		if ($get_pay_param['order_param']['order_type'] == 'takeout' || $get_pay_param['order_param']['order_type'] == 'food' || $get_pay_param['order_param']['order_type'] == 'foodPad') {
			$order_table = 'Meal_order';
		}else if($get_pay_param['order_param']['order_type']=='recharge'){
			$order_table = 'User_recharge_order';
		}else{
			$order_table = ucfirst($get_pay_param['order_param']['order_type']).'_order';
		}
		
		$now_order = $this->get_orderid($order_table,$get_pay_param['order_param']['order_id']);
		$get_pay_param['order_param']['order_id'] = $now_order['orderid'];
		
	
		if(empty($get_pay_param['error'])){

			if($get_pay_param['order_param']['order_type'] == 'group'){
				$pay_info = D('Group_order')->after_pay($get_pay_param['order_param']);
			}else if($get_pay_param['order_param']['order_type'] == 'meal' || $get_pay_param['order_param']['order_type'] == 'takeout'){
				$pay_info = D('Meal_order')->after_pay($get_pay_param['order_param']);
			}else if($get_pay_param['order_param']['order_type'] == 'shop'){
				$pay_info = D('Shop_order')->after_pay($get_pay_param['order_param']);
			}else if($get_pay_param['order_param']['order_type'] == 'recharge'){
				$pay_info = D('User_recharge_order')->after_pay($get_pay_param['order_param']);
			}else if($get_pay_param['order_param']['order_type'] == 'store'){
				$pay_info = D('Store_order')->after_pay($get_pay_param['order_param']);
			}else if($get_pay_param['order_param']['order_type'] == 'weidian'){
				$pay_info = D('Weidian_order')->after_pay($get_pay_param['order_param']);
				if(($pay_info['error']==0) && isset($pay_info['url'])){  /***异步通知***/
					$this->NoticeWDAsyn($now_order['orderid']);
				}
			}else if($get_pay_param['order_param']['order_type'] == 'plat'){
				$pay_info = D('Plat_order')->after_pay($get_pay_param['order_param']);
			}else if($get_pay_param['order_param']['order_type'] == 'appoint'){
				if($now_order['is_initiative']==2){
					$pay_info = D('Appoint_order')->balance_after_pay($get_pay_param['order_param']);
				}else{
					$pay_info = D('Appoint_order')->after_pay($get_pay_param['order_param']);
				}
			}else if($get_pay_param['order_param']['order_type'] == 'balance-appoint'){
				$pay_info = D('Appoint_order')->balance_after_pay($get_pay_param['order_param']);
			}
			if(empty($pay_info['error'])){
				if($get_pay_param['order_param']['pay_type'] == 'weixin'){
					exit('<xml><return_code><![CDATA[SUCCESS]]></return_code></xml>');
				}
				$pay_info['msg'] = '订单付款成功！';
				$this->returnCode(0);
			}
			$this->returnCode('20070007');
		} else {
			$this->returnCode(0, $get_pay_param['msg']);
		}
	}

	//支付异步通知
	public function alipay_notice(){
		$import_result = import('@.ORG.pay.Alipay');
		//↓↓↓↓↓↓↓↓↓↓请在这里配置您的基本信息↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
		//合作身份者id，以2088开头的16位纯数字
		$alipay_config['partner']		= $this->config['pay_alipay_app_pid'];

		//商户的私钥（后缀是.pen）文件相对路径
		if($_POST['body']==2){
			$alipay_config['private_key_path']	= $this->config['pay_alipay_app_private_key_android'];
		}else{
			$alipay_config['private_key_path']	= $this->config['pay_alipay_app_private_key_ios'];
		}

		//支付宝公钥（后缀是.pen）文件相对路径
		$alipay_config['ali_public_key_path']=$this->config['pay_alipay_app_public_key'];


		$pay_class = new Alipay();
		$verify_result = $pay_class->app_notice($alipay_config);
		if($verify_result) {//验证成功
			$out_trade_no = $_POST['out_trade_no'];
			$trade_no = $_POST['trade_no'];
			$trade_status = $_POST['trade_status'];
			$trade_no = explode('_',$out_trade_no);
			//订单类型
			$order_type = $trade_no[0];
			//长id
			$orderid= $trade_no[1];
			$order_param = array(
					'order_id' => $orderid,
					'pay_type' => 'alipay',
					'third_id' => $_POST['trade_no'],
					'pay_money' => $_POST['price'],
					'is_mobile' => 2,
					'is_own'=>0,
			);

			if($_POST['trade_status'] == 'TRADE_FINISHED') {
				$this->returnCode('10070008');
			}
			else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
				// 支付成功

				if ($order_type == 'takeout' || $order_type == 'food' || $order_type == 'foodPad') {
					$order_table = 'Meal_order';
				}else if($order_type=='recharge'){
					$order_table = 'User_recharge_order';
				}else{
					$order_table = ucfirst($order_type).'_order';
				}

				$now_order = $this->get_orderid($order_table,$orderid);
				$order_param['order_id'] = $now_order['orderid'];
				if($order_type == 'group'){
					$pay_info = D('Group_order')->after_pay($order_param);
				}else if($order_type == 'meal' || $order_type == 'takeout' || $order_type == 'food' || $order_type == 'foodPad'){
					$pay_info = D('Meal_order')->after_pay($order_param);
				}else if($order_type == 'shop'){
					$pay_info = D('Shop_order')->after_pay($order_param);
				}else if($order_type == 'store'){
					$pay_info = D('Store_order')->after_pay($order_param);
				}else if($order_type == 'recharge'){
					$pay_info = D('User_recharge_order')->after_pay($order_param);
				}else if($order_type == 'weidian'){
					$pay_info = D('Weidian_order')->after_pay($order_param);
					if(($pay_info['error']==0) && isset($pay_info['url'])){  /***异步通知***/
						$this->NoticeWDAsyn($now_order['orderid']);
					}
				}else if($order_type == 'plat'){
					$pay_info = D('Plat_order')->after_pay($order_param);
				}else if($order_type == 'appoint'){
					$pay_info = D('Appoint_order')->after_pay($order_param);
				}else if($order_type  == 'balance-appoint'){
					$pay_info = D('Appoint_order')->balance_after_pay($order_param);
				}
				if(empty($pay_info['error'])){
					$arr['url']= $pay_info['url'];
					$this->returnCode(0,$arr);
				}
				$this->returnCode('10070007');

			}

		}else {
			$this->returnCode('10070009');
		}


	}


	//支付宝同步回调页面
	public function app_alipay_back(){
		$ticket = I('ticket', false);
		$sPayStatus =   I('pay_status',1);
		if ($ticket) {
			$info = ticket::get($ticket, $this->DEVICE_ID, true);
			$this->user_session['uid'] = $info['uid'];
		}
		if(empty($this->user_session)){
			$this->returnCode('20044010');
		}
		$_GET['order_id']   =   $_POST['order_id'];
		$_GET['order_type']   =  $_POST['order_type'];

		$post_arr = explode('&amp;',$_POST['alipay_return']);

		$_POST=array();
		foreach($post_arr as $v){
			$tmp = explode('&quot;',$v);
			$_POST[str_replace('=','',$tmp[0])] = '"'.str_replace('&quot;','',$tmp[1]).'"';
		}

		switch($_GET['order_type']){
			case 'group':
				// $now_order = D('Group_order')->where(array('order_id'=>$_GET['order_id']))->find();
				$now_order =$this->get_orderid('Group_order',$_GET['order_id']);
				break;
			case 'meal':
				// $now_order = D('Meal_order')->where(array('order_id'=>$_GET['order_id']))->find();
				$now_order =$this->get_orderid('Meal_order',$_GET['order_id']);
				break;
			case 'takeout':
			case 'food':
			case 'foodPad':
				// $now_order = D('Meal_order')->where(array('order_id'=>$_GET['order_id']))->find();
				$now_order =$this->get_orderid('Meal_order',$_GET['order_id']);
				break;
			case 'weidian':
				// $now_order = D('Weidian_order')->get_order_by_id(intval($_GET['order_id']));
				$now_order =$this->get_orderid('Weidian_order',$_GET['order_id']);
				break;
			case 'recharge':
				// $now_order = D('User_recharge_order')->get_order_by_id(intval($_GET['order_id']));
				$now_order =$this->get_orderid('User_recharge_order',$_GET['order_id']);
				break;
			case 'appoint':
			case 'balance-appoint':
				// $now_order = D('Appoint_order')->get_order_by_id(intval($_GET['order_id']));
				$now_order =$this->get_orderid('Appoint_order',$_GET['order_id']);
				break;
			case 'waimai':
				// $now_order = D('Waimai_order')->get_order_by_id(intval($_GET['order_id']));
				$now_order =$this->get_orderid('Waimai_order',$_GET['order_id']);
				break;
			case 'wxapp':
				// $now_order = D('Wxapp_order')->get_order_by_id(intval($_GET['order_id']));
				$now_order =$this->get_orderid('Wxapp_order',$_GET['order_id']);
				break;
			case 'shop':
				// $now_order = D('Shop_order')->where(array('order_id'=>$_GET['order_id']))->find();
				$now_order =$this->get_orderid('Shop_order',$_GET['order_id']);
				break;
			case 'plat':
				$now_order =$this->get_orderid('Plat_order',$_GET['order_id']);
				break;
			case 'store':
				$now_order =$this->get_orderid('Store_order',$_GET['order_id']);
				break;
			case 'balance-appoint':
				// $now_order = D('Appoint_order')->get_order_by_id(intval($_GET['order_id']));
				$now_order =$this->get_orderid('Appoint_order',$_GET['order_id']);
				break;
			default:
				$this->returnCode('20045010');
		}
		if(empty($now_order)){
			$this->returnCode('20046002');
		}
		$now_order['order_type'] = $_GET['order_type'];
		if($now_order['paid']&&$now_order['order_type']!='balance-appoint'){
			switch($_GET['order_type']){
				case 'group':
					$redirctUrl = C('config.site_url').'/wap.php?c=My&a=group_order&order_id='.$now_order['order_id'];
					break;
				case 'meal':
					$redirctUrl = C('config.site_url').'/wap.php?c=Meal&a=detail&orderid='.$now_order['order_id'].'&mer_id='.$now_order['mer_id'].'&store_id='.$now_order['store_id'];
					break;
				case 'takeout':
					$redirctUrl = C('config.site_url').'/wap.php?c=Takeout&a=order_detail&order_id='.$now_order['order_id'].'&mer_id='.$now_order['mer_id'].'&store_id='.$now_order['store_id'];
					break;
				case 'food':
				case 'foodPad':
					$redirctUrl = C('config.site_url').'/wap.php?c=Food&a=order_detail&order_id='.$now_order['order_id'].'&mer_id='.$now_order['mer_id'].'&store_id='.$now_order['store_id'];
					break;
				case 'weidian':
					$redirctUrl = D('Weidian_order')->get_weidian_url(array('wecha_id'=>$now_order['uid'],'order_no'=>$now_order['weidian_order_id'],'pay_money'=>$now_order['money'],'third_id'=>$now_order['third_id'],'payment_method'=>$now_order['pay_type']));
					$this->NoticeWDAsyn($now_order['orderid']);
					break;
				case 'appoint':
				case 'balance-appoint':
					$redirctUrl = C('config.site_url').'/wap.php?c=My&a=appoint_order&order_id='.$now_order['order_id'];
					break;
				case 'waimai':
					$redirctUrl = C('config.site_url').'/index.php?g=Waimaiwap&c=Index&a=order&order_id='.$now_order['order_id'];
					break;
				case 'recharge':
					//$redirctUrl = C('config.site_url').D('User_recharge_order')->get_pay_after_url($now_order['label'],$now_order['is_mobile_pay']);
					$redirctUrl = C('config.site_url').'/wap.php?c=My&a=index';
					break;
				case 'wxapp':
					$redirctUrl = C('config.site_url').'/wap.php?c=Wxapp&a=pay_back&order_id='.$now_order['order_id'];
				case 'shop':
					$redirctUrl = C('config.site_url').'/wap.php?c=My&a=shop_order_list';
					break;
				case 'store':
					$redirctUrl = C('config.site_url').'/wap.php?c=My&a=store_order_list';
					break;
				case 'plat':
					$redirctUrl = D('Plat_order')->get_order_url($now_order['order_id'],true);
					break;
			}
			$arr['url']=$redirctUrl;
			$this->returnCode(0,$arr);
			exit;
		}
		$now_order['order_id']  =   $now_order['orderid'];
		$alipay_config['partner']		= $this->config['pay_alipay_app_pid'];

		//商户的私钥（后缀是.pen）文件相对路径
		if($_POST['body']==2){
			$alipay_config['private_key_path']	= $this->config['pay_alipay_app_private_key_android'];
		}else{
			$alipay_config['private_key_path']	= $this->config['pay_alipay_app_private_key_ios'];
		}
		//支付宝公钥（后缀是.pen）文件相对路径
		$alipay_config['ali_public_key_path']=$this->config['pay_alipay_app_public_key'];


		//$_POST['trade_no'] = $_GET['order_type'].'_'.$_GET['order_id'];
		$import_result = import('@.ORG.pay.Alipay');
		$pay_class = new Alipay();
		$result = $pay_class->app_return_url($alipay_config);

		$order_param = array(
				'order_id' => $now_order['orderid'],
				'pay_type' => 'alipay',
				'third_id' => $_POST['trade_no'],
				'pay_money' => $_POST['price'],
				'is_mobile' => 2,
				'is_own'=>0,
		);

		if($result){
			switch($_GET['order_type']){
				case 'group':
					D('Group_order')->after_pay($order_param);
					break;
				case 'meal':
				case 'takeout':
				case 'food':
				case 'foodPad':
					$go_query_param['order_param']['orderid'] = $order_param['order_id'];
					//unset($go_query_param['order_param']['order_id']);
					D('Meal_order')->after_pay($order_param, $_GET['order_type']);
					break;
				case 'weidian':
					$pay_info = D('Weidian_order')->after_pay($order_param);
					if(($pay_info['error']==0) && isset($pay_info['url'])){  /***异步通知***/
						$this->NoticeWDAsyn($now_order['orderid']);
					}
					break;
				case 'recharge':
					D('User_recharge_order')->after_pay($order_param);
					break;
				case 'waimai':
					D('Waimai_order')->after_pay($order_param);
					break;
				case 'appoint':
					D('Appoint_order')->after_pay($order_param);
					break;
				case 'wxapp':
					D('Wxapp_order')->after_pay($order_param);
					break;
				case 'shop':
					D('Shop_order')->after_pay($order_param);
					break;
				case 'store':
					D('Store_order')->after_pay($order_param);
				case 'plat':
					D('Plat_order')->after_pay($order_param);
					break;
				case 'balance-appoint':
					D('Appoint_order')->balance_after_pay($order_param);
					break;
			}
		}else{
			$this->returnCode('10070007');
		}
		switch($_GET['order_type']){
			case 'group':
				$redirctUrl = C('config.site_url').'/wap.php?g=Wap&c=My&a=group_order&order_id='.$_GET['order_id'];
				break;
			case 'meal':
				$redirctUrl = C('config.site_url').'/wap.php?g=Wap&c=Meal&a=detail&orderid='.$_GET['order_id'].'&mer_id='.$now_order['mer_id'].'&store_id='.$now_order['store_id'];
				break;
			case 'takeout':
				$redirctUrl = C('config.site_url').'/wap.php?g=Wap&c=Takeout&a=order_detail&order_id='.$_GET['order_id'].'&mer_id='.$now_order['mer_id'].'&store_id='.$now_order['store_id'];
				break;
			case 'food':
			case 'foodPad':
				$redirctUrl = C('config.site_url').'/wap.php?g=Wap&c=Food&a=order_detail&order_id='.$_GET['order_id'].'&mer_id='.$now_order['mer_id'].'&store_id='.$now_order['store_id'];
				break;
			case 'weidian':
				$redirctUrl = D('Weidian_order')->get_weidian_url(array('wecha_id'=>$now_order['uid'],'order_no'=>$now_order['weidian_order_id'],'pay_money'=>$now_order['money'],'third_id'=>$go_query_param['order_param']['third_id'],'payment_method'=>$go_query_param['order_param']['pay_type']));
				break;
			case 'appoint':
			case 'balance-appoint':
				$redirctUrl = C('config.site_url').'/wap.php?g=Wap&c=My&a=appoint_order&order_id='.$_GET['order_id'];
				break;
			case 'waimai':
				$redirctUrl = C('config.site_url').'/index.php?g=Waimaiwap&c=Index&a=order&order_id='.$_GET['order_id'];
				break;
			case 'recharge':
				$redirctUrl = C('config.site_url').'/wap.php?c=My&a=index';
				break;
			case 'wxapp':
				$redirctUrl = C('config.site_url').'/wap.php?c=Wxapp&a=pay_back&order_id='.$_GET['order_id'];
				break;
			case 'shop':
				$redirctUrl = C('config.site_url').'/wap.php?c=My&a=shop_order_list';
			case 'store':
				$redirctUrl = C('config.site_url').'/wap.php?c=My&a=store_order_list';
				break;
			case 'plat':
				$redirctUrl = D('Plat_order')->get_order_url($now_order['order_id'],true);
				break;
		}
		$arr['url']=$redirctUrl;
		$this->returnCode(0,$arr);
	}


}
?>