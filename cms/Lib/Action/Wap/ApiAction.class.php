<?php
/*
 * IM聊天
 *
 */
class ApiAction extends CommonAction{
	/* IM聊天通知接口 */
	public function index(){
		$data['app_id'] = $_POST['app_id'];
		$data['from_openid'] = $_POST['from_openid'];
		$data['from_nickname'] = $_POST['from_nickname'];
		$data['from_avatar'] = $_POST['from_avatar'];
		$data['to_openid'] = $_POST['to_openid'];
		$data['msg'] = $_POST['msg'];
		$data['time'] = $_POST['time'];
		$data['url'] = htmlspecialchars_decode($_POST['url']);
		$post_key = $_POST['key'];	//传递过来的签名
		
		$create_key = $this->get_im_encrypt_key($data, $this->config['im_appkey']);	//使用本地的密钥产生的签名
		if ($post_key == $create_key) {
			if($this->config['im_url']){
				$data['url'] = str_replace('http://im-link.weihubao.com',$this->config['im_url'],$data['url']);
			}
			$model = new templateNews($this->config['wechat_appid'], $this->config['wechat_appsecret']);
			$tempmsg = D('Tempmsg')->field(true)->where(array('tempkey' => 'TM204601671'))->find();
			if ($tempmsg && $tempmsg['status'] && $tempmsg['tempid']) {
				$model->sendTempMsg('TM204601671', array('href' => $data['url'], 'wecha_id' => $data['to_openid'], 'first' => '您好，您收到了新消息', 'keynote1' => $data['from_nickname'], 'keynote2' => date('H时i分',$_SERVER['REQUEST_TIME']), 'remark' => '\n请点击详情打开会话页面，立即查看并回复消息。'));
			} else {
				$model->sendTempMsg('OPENTM203574543', array('href' => $data['url'], 'wecha_id' => $data['to_openid'], 'first' => '您好，您收到了新消息', 'keyword1' => $data['from_nickname'], 'keyword2' => date('H时i分',$_SERVER['REQUEST_TIME']), 'keyword3' => '点击查看', 'remark' => '\n请点击详情打开会话页面，立即查看并回复消息。'));
			}
			echo 'success';
		}else{
			$html = '';
			foreach($data as $key=>$value){
				$html.= $key.'=>'.$value;
			}
			// 签名验证错误！
			echo 'error';
		}
	}
	/* 跳转到IM聊天系统 */
	public function go_im(){
		$key = $this->get_encrypt_key(array('app_id'=>$this->config['im_appid'],'openid' => $_SESSION['openid']), $this->config['im_appkey']);
		$url = ($this->config['im_url'] ? $this->config['im_url'] : 'http://im-link.weihubao.com').'/?app_id=' . $this->config['im_appid'] . '&openid=' . $_SESSION['openid'] . '&key=' . $key .($_GET['title'] ? '&title='.$_GET['title'] : ''). '#'.$_GET['hash'];
		redirect($url);
	}
	/* IM聊天系统 我的，数据获取接口 */
	public function my(){
		$activity_arr = array();
		//一行
		$activity_arr[] = array(
			'title'=>'ucenter',
			'intro'=>'ucenter',
			'image'=> '', /*图片暂定为 26*26的像素 */
			'url'=> $this->config['site_url'] .  '/wap.php?c=My&a=myinfo',
		);
		//一行
		if($this->user_session){
			$now_user = D('User')->get_user($this->user_session['uid']);
			if(!empty($now_user)){
				$activity_arr[] = array(
					'title'=>'ucenterDesc',
					'intro'=>'余额:<span style="color:#FF9712;">$'.floatval($now_user['now_money']).'</span>&nbsp;&nbsp;积分: <span style="color:#666;">'.floatval($now_user['score_count']).'</span>',
					'image'=> '',
					'url'=> '',
				);
			}
		}
		
		//多行
		$order_array = array(
			array(
				'title'=>$this->config['group_alias_name'].'订单',
				'intro'=>$this->config['group_alias_name'].'订单',
				'image'=> $this->config['site_url'] . '/static/images/im/tubaio1_03.png', /*图片暂定为 26*26的像素 */
				'url'=> $this->config['site_url'] .  '/wap.php?g=Wap&c=My&a=group_order_list',
			),
			array(
				'title'=>$this->config['meal_alias_name'].'订单',
				'intro'=>$this->config['meal_alias_name'].'订单',
				'image'=> $this->config['site_url'] . '/static/images/im/tubiao_13.png', /*图片暂定为 26*26的像素 */
				'url'=> $this->config['site_url'] .  '/wap.php?g=Wap&c=My&a=meal_order_list',
			),
			array(
				'title'=>'预约订单',
				'intro'=>'预约订单',
				'image'=> $this->config['site_url'] . '/static/images/im/tubiao_33.png', /*图片暂定为 26*26的像素 */
				'url'=> $this->config['site_url'] .  '/wap.php?g=Wap&c=My&a=appoint_order_list',
			),
		);
		if(isset($this->config['specificfield'])){
			array_unshift($order_array,array(
				'title'=>'完善信息',
				'intro'=>'完善信息',
				'image'=> $this->config['site_url'] . '/static/images/im/tubiao_19.png', /*图片暂定为 26*26的像素 */
				'url'=> $this->config['site_url'] .  '/wap.php?g=Wap&c=My&a=inputinfo',
			));
		}
		if($this->config['live_service_appid']){
			$order_array[] = array(
				'title'=>'生活缴费订单',
				'intro'=>'生活缴费订单',
				'image'=> $this->config['site_url'] . '/static/images/im/tubiao_14.png', /*图片暂定为 26*26的像素 */
				'url'=> $this->config['site_url'] .  '/wap.php?g=Wap&c=My&a=lifeservice',
			);
		}
		$activity_arr[] = $order_array;

		//多行
		$activity_arr[] = array(
			array(
					'title'=>'我的收藏',
					'intro'=>'我的收藏',
					'image'=> $this->config['site_url'] . '/static/images/im/tubaio1_06.png', /*图片暂定为 26*26的像素 */
					'url' => $this->config['site_url'] . '/wap.php?g=Wap&c=My&a=group_collect',
			),
			array(
				'title'=>'我关注的商家',
				'intro'=>'我关注的商家',
				'image'=> $this->config['site_url'] . '/static/images/im/tubiao_15.png', /*图片暂定为 26*26的像素 */
				'url'=> $this->config['site_url'] .  '/wap.php?g=Wap&c=My&a=follow_merchant',
			),
			array(
				'title'=>'我参与的活动',
				'intro'=>'我参与的活动',
				'image'=> $this->config['site_url'] . '/static/images/im/tubiao_16.png', /*图片暂定为 26*26的像素 */
				'url'=> $this->config['site_url'] .  '/wap.php?g=Wap&c=My&a=join_lottery',
			),
		);
		//多行
		$activity_arr[] = array(
			array(
					'title'=>'我的优惠券',
					'intro'=>'我的优惠券',
					'image'=> $this->config['site_url'] . '/static/images/im/tubaio1_10.png', /*图片暂定为 26*26的像素 */
					'url' => $this->config['site_url'] . '/wap.php?g=Wap&c=My&a=card_list',
			),
			array(
				'title'=>'我的会员卡',
				'intro'=>'我的会员卡',
				'image'=> $this->config['site_url'] . '/static/images/im/tubiao_17.png', /*图片暂定为 26*26的像素 */
				'url'=> $this->config['site_url'] .  '/wap.php?g=Wap&c=My&a=cards',
			),
		);

		//多行
		$activity_arr[] = array(
				array(
						'title'=>'我的推广',
						'intro'=>'我的推广',
						'image'=> $this->config['site_url'] . '/static/images/im/tubiao_34.png', /*图片暂定为 26*26的像素 */
						'url'=> $this->config['site_url'] .  '/wap.php?g=Wap&c=My&a=spread_list',
				),
				array(
						'title'=>'我的推广二维码',
						'intro'=>'我的推广二维码',
						'image'=> $this->config['site_url'] . '/static/images/im/tubiao_35.png', /*图片暂定为 26*26的像素 */
						'url'=> $this->config['site_url'] .  '/wap.php?g=Wap&c=My&a=my_spread_qrcode',
				),
		);

		//检测是否有分类信息
		if(isset($this->config['wap_home_show_classify'])){
			//一行
			$activity_arr[] = array(
					'title'=>'我的发布',
					'intro'=>'我的发布',
					'image'=> $this->config['site_url'] . '/static/images/im/tubiao_19.png', /*图片暂定为 26*26的像素 */
					'url'=> $this->config['site_url'] .  '/wap.php?c=Classify&a=myCenter',
			);
		}
		//一行
			$activity_arr[] = array(
					'title'=>'重新登录',
					'intro'=>'重新登录',
					'image'=> $this->config['site_url'] . '/static/images/im/tubiao_21.png', /*图片暂定为 26*26的像素 */
					'url'=> $this->config['site_url'] .  '/wap.php?c=Login&a=logout',
			);
		$this->ok_jsonp_return(array('data'=>$activity_arr));
	}
	/* IM聊天系统 发现，数据获取接口*/
	public function activity(){
		$activity_arr = array();
		
		$activity_arr[1] = array(
			array(
				'title'=>'平台首页',
				'intro'=>'平台首页',
				'image'=> $this->config['site_url'] . '/static/images/im/tubiao_12.png', /*图片暂定为 26*26的像素 */
				'url'=> $this->config['site_url'] .  '/wap.php?c=Home&a=index',
			),
			array(
				'title'=>$this->config['group_alias_name'].'导航',
				'intro'=>$this->config['group_alias_name'].'导航',
				'image'=> $this->config['site_url'] . '/static/images/im/tubiao_19.png', /*图片暂定为 26*26的像素 */
				'url'=> $this->config['site_url'] .  '/wap.php?c=Group&a=navigation',
			),
		);
		if($this->config['live_service_type']){
			$activity_arr[1][] = array(
				'title'=>'生活缴费',
				'intro'=>'生活缴费',
				'image'=> $this->config['site_url'] . '/static/images/im/tubiao_20.png', /*图片暂定为 26*26的像素 */
				'url'=> $this->config['site_url'] .  '/wap.php?c=Lifeservice&a=index',
			);
		}
		//多行
		$activity_arr[] = array(
			array(
				'title'=>'附近商家',
				'intro'=>'附近商家',
				'image'=> $this->config['site_url'] . '/static/images/im/tubiao_18.png', /*图片暂定为 26*26的像素 */
				'url'=> $this->config['site_url'] .  '/wap.php?c=Merchant&a=around',
			),
			array(
				'title'=>'附近'.$this->config['group_alias_name'],
				'intro'=>'附近'.$this->config['group_alias_name'],
				'image'=> $this->config['site_url'] . '/static/images/im/tubiao_03.png', /*图片暂定为 26*26的像素 */
				'url'=> $this->config['site_url'] .  '/wap.php?c=Group&a=index',
			),
			array(
				'title'=>'附近'.$this->config['meal_alias_name'],
				'intro'=>'附近'.$this->config['meal_alias_name'],
				'image'=> $this->config['site_url'] . '/static/images/im/tubiao_06.png', /*图片暂定为 26*26的像素 */
				'url'=> $this->config['site_url'] .  '/wap.php?c=Meal_list&a=index',
			),
		);
		//两行
		$activity_arr[] = array(
				array(
						'title'=>'找活动',
						'intro'=>'找活动',
						'image'=> $this->config['site_url'] . '/static/images/im/tubiao_08.png', /*图片暂定为 26*26的像素 */
						'url' => $this->config['site_url'] . '/wap.php?c=Activity&a=index',
				),
		);
		
		$this->ok_jsonp_return(array('data'=>$activity_arr));
	}
	
	public function test()
	{
		$xml = file_get_contents("php://input");
// 		$config_file = CONF_PATH . 't.php';
// 	 	$fp = fopen($config_file, 'a+');
// 		fwrite($fp, $xml . "\n");
// 		fclose($fp);
		$xml = new SimpleXMLElement($xml);
		$xml || exit;
		foreach ($xml as $key => $value) {
			$data[$key] = strval($value);
		}
		
		$wechat = new Wetest($data);
		$t = array('test', 'text');
		list($content, $type) = $t;
		if ($content) {
			exit($wechat->response($content, $type));
		} else {
			exit();
		}
	}
}