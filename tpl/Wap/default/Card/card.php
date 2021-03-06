<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>{pigcms{$thisCard.cardname}</title>
<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<link href="{pigcms{$static_path}css/style.css" rel="stylesheet" type="text/css">
<script src="/static/js/jquery.min.js" type="text/javascript"></script>
</head>
<if condition="$error lt 0">
<body id="cardunion" class="mode_webapp2">
<else/>
<body id="card" class="mode_webapp">
</if>
<if condition="$error lt 0">
<div class="error" style="margin:50px auto 20px auto;text-align:center"><img src="/static/images/card/error.jpg" /></div>
<div style="font-size:14px;text-align:center"><php>if($error==-1){</php>会员卡暂时缺货<php>}elseif($error==-2){</php>您的{pigcms{$config['score_name']}不够<php>}elseif($error==-3){</php>领取此会员卡需要{pigcms{$thisCard.miniscore}{pigcms{$config['score_name']}，而您只有{pigcms{$userScore}{pigcms{$config['score_name']}<php>}elseif($error==-4){</php>还没领取会员卡，现正在跳转<php>}</php></div>
<include file="Card:bottom"/>
<else/>
<div id="overlay"></div>
<div class="cardcenter">
<div class="card"><img src="<?php if($thisCard['diybg']!=''){?>{pigcms{$thisCard.diybg}<?php }else{?>{pigcms{$thisCard.bg}<?php }?>" class="cardbg" />
<if condition="$card.logo"><img id="cardlogo" class="logo" src="{pigcms{$thisCard.logo}"></if>
<h1 style="color:{pigcms{$card.vipnamecolor}">{pigcms{$thisCard.cardname}</h1>
<strong class="pdo verify" style="color:{pigcms{$card.numbercolor}"><span id="cdnb" ><em>会员卡号</em>{pigcms{$thisMember.number}</span></strong> </div>
<p class="explain"><span>{pigcms{$thisCard.msg}</span></p>
<div class="window" id="windowcenter">
<div id="title" class="wtitle">领卡信息<span class="close" id="alertclose"></span></div>
<div class="content">
<div id="txt"></div>
<p>
<input name="truename" value=""  class="px" id="truename"  type="text" placeholder="请输入您的姓名">
</p>
<p>
<input name="tel"  class="px" id="tel"  value=""  type="number"  placeholder="请输入您的电话">
</p>
<input type="button" value="确 定" name="确 定" class="txtbtn" id="windowclosebutton">
</div>
</div>
</div>


<div class="cardexplain" >
<style>
		.button{width:100%;margin-bottom:10px;}
		.button .b1,.button .b2{width:49%;text-align:center;font-weight:bold;text-align:center;line-height:40px;background:#1cc200; border: 1px solid #179f00;border-radius: 5px;color:#fff;}
		.button a:hover{background:#179f00}
		.button .b1{margin-right:2px;float:left;}
		.button .b2{float:right;}
</style>

<!--div class="button">
	<a href="{pigcms{:U('Card/topay', array('token' => $token,'cardid'=>$card['id']))}" class="b1">充值</a>
	<a href="{pigcms{:U('Card/consume', array('token' => $token,'cardid'=>$card['id']))}" class="b2">消费</a>
	<div class="clr"></div>
</div-->

<ul class="round" id="notice">
<li><a href="/wap.php?g=Wap&c=Card&a=my_coupon&token={pigcms{$token}&cardid={pigcms{$card.id}"><span>会员优惠<?php if ($couponCount>0){echo '<em class="ok">'.$couponCount.'</em>';}else{echo '<em class="error">0</em>';}?></span></a></li>
<!--li><a href="/wap.php?g=Wap&c=Card&a=previlege&token={pigcms{$token}&cardid={pigcms{$card.id}"><span>会员特权<?php if ($previlegeCount>0){echo '<em class="ok">'.$previlegeCount.'</em>';}else{echo '<em class="error">0</em>';}?></span></a></li-->

<if condition="$openCount gt 0">
<li><a href="/wap.php?g=Wap&c=Card&a=gifts&token={pigcms{$token}&cardid={pigcms{$card.id}"><span>开卡即赠<?php if ($openCount>0){echo '<em class="ok">'.$openCount.'</em>';}?></span></a></li>
</if>
<li><a href="/wap.php?g=Wap&c=Card&a=notice&token={pigcms{$token}&cardid={pigcms{$card.id}"><span>最新通知<?php if ($noticeCount>0){echo '<em class="ok">'.$noticeCount.'</em>';}else{echo '<em class="error">0</em>';}?></span></a></li>
<li><a href="{pigcms{:U('Userinfo/index',array('token' => $token,'cardid' => (int)$_GET['cardid'],'redirect'=>'Card/card|cardid:'.(int)$_GET['cardid']))}"><span>个人资料</span></a></li>
</ul>


<ul class="round">
<li><a href="/wap.php?g=Wap&c=Card&a=cardIntro&token={pigcms{$token}&cardid={pigcms{$card.id}"><span>会员卡说明</span></a></li>
<li><a href="/wap.php?g=Wap&c=Card&a=companyDetail&token={pigcms{$token}"><span>商家电话及地址</span></a></li>
</ul>

      </div>

<include file="Card:cardFooter"/>
<include file="Card:share"/>
</if>

</body>
</html>
