<?php
	class VerifyAction extends BaseAction{
		public function verify(){
			if(IS_POST){
				if($_POST['type']==1){
					$verify_limit = D('Verify_limit');
					if(empty($_POST['code'])){
						echo json_encode(array('error_code'=>true,'msg'=>'密码不能为空'));die;
					}
					$res = D('User')->checkin($this->user_session['phone'],$_POST['code'],0);

					$times = $verify_limit->check_false_times($this->user_session['uid']);
					if($times['error_code']&&$res['error_code']){
						echo json_encode($times);die;
					}
					if($res['error_code']){
						echo json_encode(array('error_code'=>true,'msg'=>'验证错误'));die;
					}else{
						$verify_limit->where(array('uid'=>$this->user_session['uid']))->delete();
					}
					unset($res['user']);
					if($times['end_time']>time()){
						echo json_encode($times);die;
					}else{
						echo  json_encode($res);die;
					}
				}else{
					if (isset($_POST['code']) && !empty($_POST['code'])) {
						$sms_verify_result = D('Smscodeverify')->verify($_POST['code'], $this->user_session['uid']['phone']);
						if ($sms_verify_result['error_code']) {
							echo  json_encode(array('error_code'=>true,'msg'=>$sms_verify_result['msg']));
						} else {
							$modifypwd = $sms_verify_result['modifypwd'];
							echo  json_encode(array('error_code'=>false,'msg'=>$sms_verify_result['msg']));exit;
						}
					}else{
						echo  json_encode(array('error_code'=>true));die;
					}
					
				}
			}
		}
	}