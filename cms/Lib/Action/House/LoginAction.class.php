<?php
/*
 * 社区中心-登录
 *
 */

class LoginAction extends BaseAction{
    public function index(){
		$this->display();
    }
	public function check(){
		if($this->isAjax()){
			if(md5($_POST['verify']) != $_SESSION['house_login_verify']){
				exit(json_encode(array('error'=>'1','msg'=>'验证码不正确！','dom_id'=>'verify')));
			}
			
			$database_house = D('House_village');
			$condition_house['account'] = trim($_POST['account']);
			if($_POST['village_id']){
				$condition_house['village_id'] = trim($_POST['village_id']);
			}
			$now_house = $database_house->field(true)->where($condition_house)->find();
			if(empty($now_house)){
				exit(json_encode(array('error'=>'2','msg'=>'用户名不存在！','dom_id'=>'account')));
			}
			$pwd = md5($_POST['pwd']);
			if($pwd != $now_house['pwd']){
				exit(json_encode(array('error'=>'3','msg'=>'密码错误！','dom_id'=>'pwd')));
			}
			if(empty($_POST['village_id'])){
				$house_list = $database_house->field('`village_id`,`village_name`,`status`')->where(array('account'=>$now_house['account'],'pwd'=>$now_house['pwd'],'status'=>array('neq','2')))->order('`village_id` ASC')->select();
				if(is_array($house_list) && count($house_list) > 1){
					exit(json_encode(array('error'=>'7','house_list'=>$house_list)));
				}
			}
			if($now_house['status'] == 2){
				exit(json_encode(array('error'=>'5','msg'=>'您被禁止登录！请联系工作人员获得详细帮助。','dom_id'=>'account')));
			}
			
			$data_house['village_id'] = $now_house['village_id'];
			$data_house['last_time'] = $_SERVER['REQUEST_TIME'];
			if($database_house->data($data_house)->save()){
				session('house',$now_house);
				exit(json_encode(array('error'=>'0','msg'=>'登录成功,现在跳转~','dom_id'=>'account')));
			}else{
				exit(json_encode(array('error'=>'6','msg'=>'登录信息保存失败,请重试！','dom_id'=>'account')));
			}
		}else{
			exit('deney Access !');
		}
	}
	
	public function logout(){
		session('house',null);
		header('Location: '.U('Login/index'));
	}
	public function verify(){
		$verify_type = $_GET['type'];
		if(empty($verify_type)){exit;}
		import('ORG.Util.Image');
		Image::buildImageVerify(4,1,'jpeg',53,26,'house_'.$verify_type.'_verify');
	}
}