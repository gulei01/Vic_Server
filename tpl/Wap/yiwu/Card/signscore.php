<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>{pigcms{$thisCard.cardname}</title>
<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<link href="{pigcms{$static_path}card/style/style.css" rel="stylesheet" type="text/css">
<script src="/static/js/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript"> 
$(document).ready(function () { 
$("#qiandao").click(function () { 
var btn = $(this);
var submitData = {
};
$.post('/wap.php?g=Wap&c=Card&a=addSign&token={pigcms{$token}&cardid={pigcms{$thisCard.id}', submitData,
function(data) {
	alert(data.success)
if (data.success == true) {
$("#qiandao").html("今天你已经签到了!");
 alert(data.msg);
 setTimeout('dourl(12)',2000);
return
} 
},
"json");

}); 
}); 

</script>
<style type="text/css">
.window {
width:240px;
position:absolute;
display:none;
margin:-50px auto 0 -120px;
padding:2px;
top:0;
left:50%;
border-radius:0.6em;
-webkit-border-radius:0.6em;
-moz-border-radius:0.6em;
background-color: rgba(255, 0, 0, 0.5);
-webkit-box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
-moz-box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
-o-box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
font:14px/1.5 Microsoft YaHei,Helvitica,Verdana,Arial,san-serif;
z-index:10;
bottom: auto;
}
.window .content {
overflow:auto;
padding:10px;
    color: #222222;
    text-shadow: 0 1px 0 #FFFFFF;
border-radius: 0 0 0.6em 0.6em;
-webkit-border-radius: 0 0 0.6em 0.6em;
-moz-border-radius: 0 0 0.6em 0.6em;
}
.window #txt {
min-height:30px;font-size:20px; line-height:22px; color:#FFF; text-align:center;
}
</style>
</head>
<body id="cardintegral" class="mode_webapp">
<div class="qiandaobanner"><a href="javascript:history.go(-1);"><img src="{pigcms{$thisCard.qiandao}" ></a> </div>
<div class="cardexplain">
<a class="receive"  id="qiandao"><if condition="$todaySigned eq 0"><span class="red">点击这里签到赚{pigcms{$config['score_name']}</span><else/><span style="color:#666">今天您已经签到过了</span></if><span style=" display:none"></span></a>
</div>
<div class="jifen-box">
<ul class="zongjifen">
<li><a href="/wap.php?g=Wap&c=Card&a=expense&token={pigcms{$token}&cardid={pigcms{$thisCard.id}">
<div class="fengexian">
<p>消费记录</p>
<span>{pigcms{$userInfo['expensetotal']}元</span></div>
</a></li>
<li><a href="/wap.php?g=Wap&c=Card&a=signscore&token={pigcms{$token}&cardid={pigcms{$thisCard.id}">
<div class="fengexian">
<p>剩余{pigcms{$config['score_name']}</p>
<span>{pigcms{$userScore}分</span></div>
</a></li>
<li><a href="/wap.php?g=Wap&c=Card&a=signscore&token={pigcms{$token}&cardid={pigcms{$thisCard.id}">
<p>签到{pigcms{$config['score_name']}</p>
<span>{pigcms{$userInfo['sign_score']}分</span></a></li>
</ul>
<div class="clr"></div>
</div>

<div class="jifen-box header_highlight">
<div class="tab month_sel"> <span class="title">查看每月签到及{pigcms{$config['score_name']}详情
<p>点击这里选择其他月份</p>
</span> </div>
<select onChange="dourl2(this.value)" class="month">
<option  value="1">1月</option>
<option value="2">2月</option>
<option value="3">3月</option>
<option value="4">4月</option>
<option value="5">5月</option>
<option value="6">6月</option>
<option value="7">7月</option>
<option value="8">8月</option>
<option value="9">9月</option>
<option value="10">10月</option>
<option value="11">11月</option>
<option value="12">12月</option>
</select>
<div class="accordion_child">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="integral_table">
<thead>
<tr>
<th>日期</th>
<th>签到情况</th>
<th>{pigcms{$config['score_name']}</th>
</tr>
</thead>
<tbody>
<volist name="signRecords" id="c">                 
<tr>
<td>{pigcms{$c.sign_time|date='m月d日',###}</td>
<td><span class="wqian">已签到</span></td>
<td>+{pigcms{$c.expense}</td>
</tr>
</volist>
</tbody>
</table>
</div>
</div>

<div class="window" id="windowcenter" style="margin-top:50px;">
<div class="content">
 <div id="txt"></div>
</div>

</div>
</div>

<script>
function dourl(m){
	location.reload();
}
function dourl2(m){
	location.href= '/wap.php?g=Wap&c=Card&a=signscore&token={pigcms{$token}&cardid={pigcms{$thisCard.id}&month='+m;
}
</script>

<script type="text/javascript"> 

function alert(title){ 
$("#windowcenter").slideToggle("slow"); 
$("#txt").html(title);
setTimeout('$("#windowcenter").slideUp(500)',2000);
} 

</script>
<include file="Card:cardFooter"/>
<include file="Card:share"/>
</body>
</html>
