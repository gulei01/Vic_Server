<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
	<if condition="$is_wexin_browser">
		<title>计算结果</title>
	<else/>
		<title>计算结果-{pigcms{$config.site_name}</title>
	</if>
    <meta name="viewport" content="initial-scale=1, width=device-width, maximum-scale=1, user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name='apple-touch-fullscreen' content='yes'>
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="format-detection" content="telephone=no">
	<meta name="format-detection" content="address=no">
	<link rel="shortcut icon" href="{pigcms{$config.site_url}/favicon.ico">
    <link href="{pigcms{$static_path}css/eve.7c92a906.css" rel="stylesheet"/>
	<link href="{pigcms{$static_path}css/group_detail_wap.css" rel="stylesheet"/>
	<link href="{pigcms{$static_path}css/idangerous.swiper.css" rel="stylesheet"/>
	<style>
		.swiper-slide{
			display: -webkit-box;
			display: -ms-flexbox;
			overflow: hidden;
			-webkit-box-align: center;
			-webkit-box-pack: center;
			-ms-box-align: center;
			-ms-flex-pack: justify;
		}
		.swiper-slide img{
			width:auto;
			height:auto;
			max-width:100%;
			max-height:90%;
		}
		.swiper-pagination{
			left: 0;
			top: 10px;
			text-align: center;
			bottom:auto;
			right:auto;
			width:100%;
		}
		.swiper-close{
			right:10px;
			top:5px;
			text-align:right;
			position:absolute;
			z-index:21;
			color:white;
			font-size:.7rem;
		}
		span.tag{
			background: #fdb338;
			color: #fff;
			line-height: 1.5;
			display: inline-block;
			padding: 0 .06rem;
			font-size: .24rem;
			border-radius: .06rem;
		}
		
		
		#enter_im_div {
		  bottom: 60px;
		  left:10px;
		  z-index: 11;
		  position: fixed;
		  width: 94px;
		  height:31px;
		}
		#enter_im {
		  width: 94px;
		  position: relative;
		  display: block;
		}
		a {
		  color: #323232;
		  outline-style: none;
		  text-decoration: none;
		}
		#to_user_list {
		  height: 16px;
		  padding: 7px 6px 8px 8px;
		  background-color: #00bc06;
		  border-radius: 25px;
		  /* box-shadow: 0 0 2px 0 rgba(0,0,0,.4); */
		}
		#to_user_list_icon_div {
		  width: 20px;
		  height: 16px;
		  background-color: #fff;
		  border-radius: 10px;
		}
		
		.rel {
		  position: relative;
		}
		.left {
		  float: left;
		}
		.to_user_list_icon_em_a {
		  left: 4px;
		}
		#to_user_list_icon_em_num {
		  background-color: #f00;
		}
		#to_user_list_icon_em_num {
		  width: 14px;
		  height: 14px;
		  border-radius: 7px;
		  text-align: center;
		  font-size: 12px;
		  line-height: 14px;
		  color: #fff;
		  top: -14px;
		  left: 68px;
		}
		.hide {
		  display: none;
		}
		.abs {
		  position: absolute;
		}
		.to_user_list_icon_em_a, .to_user_list_icon_em_b, .to_user_list_icon_em_c {
		  width: 2px;
		  height: 2px;
		  border-radius: 1px;
		  top: 7px;
		  background-color: #00ba0a;
		}
		.to_user_list_icon_em_a {
		  left: 4px;
		}
		.to_user_list_icon_em_b {
		  left: 9px;
		}
		.to_user_list_icon_em_c {
		  right: 4px;
		}
		.to_user_list_icon_em_d {
		  width: 0;
		  height: 0;
		  border-style: solid;
		  border-width: 4px;
		  top: 14px;
		  left: 6px;
		  border-color: #fff transparent transparent transparent;
		}
		#to_user_list_txt {
		  color: #fff;
		  font-size: 13px;
		  line-height: 16px;
		  padding: 1px 3px 0 5px;
		}
				.w-goods-price{
			color: #9E9E9E;
			font-size: .26rem;
			  height: .46rem;
		}
		/*.w-progressBar {
  margin-right: 50px;
}*/
		.w-progressBar .wrap {
  position: relative;
  margin-bottom: 8px;
  height: 5px;
  border-radius: 5px;
  background-color: #efeeee;
  overflow: hidden;
}
.w-progressBar .bar, .w-progressBar .color {
  display: block;
  height: 100%;
  border-radius: 4px;
}
.w-progressBar .bar {
  overflow: hidden;
}
.w-progressBar .color {
  width: 100%;
  background: #FFA538;
  background: -webkit-gradient(linear,left top,right top,from(#FFCB3D),to(#FF8533));
  background: -moz-linear-gradient(left,#FFCB3D,#FF8533);
  background: -o-linear-gradient(left,#FFCB3D,#FF8533);
  background: -ms-linear-gradient(left,#FFCB3D,#FF8533);
}
.w-progressBar .txt {
  overflow: hidden;
}
.w-progressBar li {
  float: left;
  color: #9E9E9E;
			font-size: .26rem;
}
.w-progressBar .txt b {
  font-weight: normal;
}
.w-progressBar .txt-r {
  float: right;
  border: 0;
  text-align: right;
}
.finish_tip {
  display: inline-block;
  margin-left: 30px;
  color: red;
}
.txt-blue {
  color: #0079fe;
}
dl.list{
	padding-top:15px;
}
.m-detail-userCodes {
  background: #f4f4f4;
  color: #999999;
}
.m-detail-userCodes-blank {
  text-align: center;
  color: #8f8f8f;
}
.w-bar {
  display: block;
  overflow: hidden;
  position: relative;
  color: #525252;
  background: #fff;
}
.w-bar-hint {
    font-size: .28em;
  color: #8f8f8f;
}
dl.list .dd-padding.group_content{
	padding:.28rem 0rem;
}
.group_content img{
	width:100%;
	margin:0px;
}
.m-calc-rule {
  margin: 0 10px 15px;
  padding: 5px 8px;
  background: #db3652;
  border-radius: 4px;
  color: #fff;
  line-height: 22px;
}
.m-calc-rule h2 {
   font-size: .30rem;
  line-height: .46rem;
  font-weight: bold;
  margin:0;
}
.m-calc-A, .m-calc-B {
  padding: 10px;
  border-top: 1px solid #e2e2e2;
  line-height: 20px;
  background: #fff;
  position: relative;
}
.m-calc-A-title, .m-calc-B-title {
  color: #525252;
}
.txt-red {
  color: #db3652;
}
.m-calc-resultList {
  width: 100%;
  border-top: 1px solid #d5d5d5;
  border-bottom: 1px solid #d5d5d5;
}
.m-calc-resultList th, .m-calc-resultList td {
  padding-left: 10px;
  line-height: 22px;
  border-bottom: 1px solid #d5d5d5;
}
.m-calc-resultList th {
  background: #f8f8f8;
  text-align: left;
    font-weight: normal;
}
/* .m-calc-resultList th.time {
  width: 218px;
} */
.ico-arrow-transfer {
  width: 10px;
  height: 6px;
  position: relative;
  background: none;
    display: inline-block;
  vertical-align: middle;
}
.ico-arrow-transfer:before, .ico-arrow-transfer:after {
  content: "";
  position: absolute;
  display: block;
}
.ico-arrow-transfer:before {
  left: 0;
  top: 2px;
  border-top: 2px solid #db3625;
  width: 5px;
  height: 0;
}
.ico-arrow-transfer:after {
  top: 1px;
  right: 0;
  width: 0;
  height: 0;
  border-width: 4px;
  border-top: 0;
  border-style: solid;
  border-color: transparent;
  border-bottom-color: #db3625;
  transform: rotate(90deg);
  -webkit-transform: rotate(90deg);
  -moz-transform: rotate(90deg);
}
.m-calc-result {
  margin-top: 10px;
  padding: 10px 10px 15px;
  background: #fff;
  color: #525252;
  border-top: 1px solid #e2e2e2;
  border-bottom: 1px solid #e2e2e2;
}
.m-calc-result-code {
  text-align: center;
}

	</style>
	<style>.msg-bg{background:rgba(0,0,0,.4);position:absolute;top:0;left:0;width:100%;z-index:998}.msg-doc{position:fixed;left:.16rem;right:.16rem;bottom:15%;border-radius:.06rem;background:#fff;overflow:hidden;z-index:999}.msg-hd{background:#f0efed;color:#333;text-align:center;padding:.28rem 0;overflow:hidden;font-size:.4rem;border-bottom:1px solid #ddd8ce}.msg-bd{font-size:.34rem;padding:.28rem;border-bottom:1px solid #ddd8ce}.msg-toast{background:rgba(0,0,0,.8);font-size:.4rem;color:#fff;border:0;text-align:center;padding:.4rem;-webkit-animation-name:pop-hide;-webkit-animation-duration:5s;border-radius:.12rem;bottom:60%;opacity:0;pointer-events:none}.msg-confirm,.msg-alert{-webkit-animation-name:pop;-webkit-animation-duration:.3s}.msg-option{-webkit-animation-name:slideup;-webkit-animation-duration:.3s}@-webkit-keyframes pop-hide{0%{-webkit-transform:scale(0.8);opacity:0}2%{-webkit-transform:scale(1.1);opacity:1}6%{-webkit-transform:scale(1)}90%{-webkit-transform:scale(1);opacity:1}100%{-webkit-transform:scale(0.9);opacity:0}}@-webkit-keyframes pop{0%{-webkit-transform:scale(0.8);opacity:0}40%{-webkit-transform:scale(1.1);opacity:1}100%{-webkit-transform:scale(1)}}@-webkit-keyframes slideup{0%{-webkit-transform:translateY(100%)}40%{-webkit-transform:translateY(-10%)}100%{-webkit-transform:translateY(0)}}.msg-ft{display:-webkit-box;display:-ms-flexbox;font-size:.34rem}.msg-ft .msg-btn{display:block;-webkit-box-flex:1;-ms-flex:1;margin-right:-1px;border-right:1px solid #ddd8ce;height:.88rem;line-height:.88rem;text-align:center;color:#2bb2a3}.msg-btn:last-child{border-right:0}.msg-option{background:0;bottom:55px;}.msg-option div:first-child,.msg-option .msg-option-btns:first-child .btn:first-child{border-radius:.06rem .06rem 0 0;border-top:0}.msg-option .btn{width:100%;background:#fff;border:0;color:#FF658E;border-radius:0}.msg-option .msg-bd{background:#fff;border-bottom:0}.msg-option .btn{height:.8rem;line-height:.8rem;border-top:1px solid #ccc}.msg-option-btns .btn:last-child{border-radius:0 0 .06rem .06rem;border-bottom:1px solid #ccc}.msg-option .msg-btn-cancel{padding:0;margin-top:.14rem;color:#FF658E;border-radius:.06rem}.msg-dialog .msg-hd{background-color:#fff}.msg-dialog .msg-bd{background-color:#f0efed}.msg-slide{background:0;bottom:0;left:0;right:0;border-radius:0;-webkit-animation-name:slideup;-webkit-animation-duration:.3s}</style>
</head>
<body id="index">
		<div id="deal" class="deal">
			<dl id="deal-details" class="list">
			    <div class="m-calc-rule">
					<h2>计算公式</h2>
					<p>[ 数值 ÷ 奖品所需人次 ] 取余数 + 10000000</p>
				</div>
				<div class="m-calc-A">
					<p class="m-calc-A-title">数值A</p>
					<p>= 该奖品最后50条参与记录</p>
					<p>= <b class="txt-red">{pigcms{$allCount}</b></p>
				</div>
				<div class="m-calc-list" style="height: auto;">
					<table class="m-calc-resultList" cellpadding="0" cellspacing="0">
						<thead>
							<tr>
								<th class="time">夺宝时间</th>
								<th class="user">用户帐号</th>
							</tr>
						</thead>
						<tbody>
							<volist name="activity_record_list" id="vo">
								<tr class="calcRow">
									<td class="time">{pigcms{$vo.time|date='Y-m-d H:i:s',###}.{pigcms{$vo.msec} <i class="ico ico-arrow-transfer"></i> <b class="txt-red">{pigcms{$vo.time|date='His',###}{pigcms{$vo.msec}</b></td>
									<td class="user"><div class="f-breakword"><a class="goUserPage" data-uid="27978701" title="yys***@163.com(ID:27978701)" href="javascript:void(0)">{pigcms{$vo.nickname}</a></div></td>
								</tr>
							</volist>
						</tbody>
					</table>
				</div>
				<div class="m-calc-result">
					<p class="m-calc-result-title">计算结果</p>
					<p class="m-calc-result-code">幸运号码：<b class="txt-red">{pigcms{$now_activity['lottery_number']+10000000}</b></p>
				</div>
			</dl>
		</div>
		<php>$no_footer = true;</php>
    	<include file="Public:footer"/>
<script type="text/javascript">
window.shareData = {  
            "moduleName":"Wapactivity",
            "moduleID":"0",
            "imgUrl": "{pigcms{$now_activity.all_pic.0.m_image}", 
            "sendFriendLink": "{pigcms{$config.site_url}{pigcms{:U('Wapactivity/detail', array('id' => $now_activity['pigcms_id']))}",
            "tTitle": "【{pigcms{$now_merchant.merchant_name}】{pigcms{$now_activity.name}",
            "tContent": ""
};
</script>
{pigcms{$shareScript}
</body>
</html>