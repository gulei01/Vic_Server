<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
       <if condition="$zd['status'] eq 1">
            {pigcms{$zd['code']}
        </if>
<title>{pigcms{$tpl.wxname}</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<link href="{pigcms{$static_path}tpl/com/css/iscroll.css" rel="stylesheet" type="text/css" />
<link href="{pigcms{$static_path}tpl/1270/css/cate.css" rel="stylesheet" type="text/css" />


<style>

 
</style>
<script src="{pigcms{$static_path}tpl/com/js/iscroll.js" type="text/javascript"></script>
<script type="text/javascript">
var myScroll;

function loaded() {
myScroll = new iScroll('wrapper', {
snap: true,
momentum: false,
hScrollbar: false,
onScrollEnd: function () {
document.querySelector('#indicator > li.active').className = '';
document.querySelector('#indicator > li:nth-child(' + (this.currPageX+1) + ')').className = 'active';
}
 });
 
 
}

document.addEventListener('DOMContentLoaded', loaded, false);
</script>
</head>

<body id="cate14">

<div class="banner">
<div id="wrapper">
<div id="scroller">
<ul id="thelist">
               
               
		<volist name="flashbg" id="so">        
			<li style="background-image:url('{pigcms{$so.img}');background-attachment: inherit;background-repeat:no-repeat;background-size:cover;-moz-background-size:cover;-webkit-background-size:cover; background-position: center center " ></li>
		</volist>
 

</ul>
</div>
</div>
    <div class="clr"></div>
</div>

<div class="mainmenu">
<ul><div id="insert1" ></div>
  <volist name="info" id="vo"> 
<li>
<div class="menubtn">
<a href="<if condition="$vo['url'] eq ''">{pigcms{:U('Wap/Index/lists',array('classid'=>$vo['id'],'token'=>$vo['token']))}<else/>{pigcms{$vo.url|htmlspecialchars_decode}</if>">{pigcms{$vo.name}</a>
</div>

</li>
 </volist>

 	

        <div id="insert2" ></div>
        
        <div class="clr"></div>
</ul>
</div>

 
<div style="display:none"> </div>

<script>
var count = document.getElementById("thelist").getElementsByTagName("li").length;	

var count2 = document.getElementsByClassName("menuimg").length;
for(i=0;i<count;i++){
 document.getElementById("thelist").getElementsByTagName("li").item(i).style.width = document.documentElement.clientWidth+"px";
  document.getElementById("thelist").getElementsByTagName("li").item(i).style.height = document.documentElement.clientHeight+"px";
  //document.getElementById("thelist").getElementsByTagName("img").item(i).style.width = document.documentElement.clientWidth+"px";
  //document.getElementById("thelist").getElementsByTagName("img").item(i).style.height = document.documentElement.clientHeight+"px";
}
document.getElementById("scroller").style.cssText = " width:"+document.documentElement.clientWidth*count+"px";

   setInterval(function(){
myScroll.scrollToPage('next', 0,400,count);
},3500 );
window.onresize = function(){ 
for(i=0;i<count;i++){
document.getElementById("thelist").getElementsByTagName("li").item(i).style.width = document.documentElement.clientWidth+"px";
  document.getElementById("thelist").getElementsByTagName("li").item(i).style.height = document.documentElement.clientHeight+"px";
  //document.getElementById("thelist").getElementsByTagName("img").item(i).style.width = document.documentElement.clientWidth+"px";
  //document.getElementById("thelist").getElementsByTagName("img").item(i).style.height = document.documentElement.clientHeight+"px";
}
 document.getElementById("scroller").style.cssText = " width:"+document.documentElement.clientWidth*count+"px";
} 


</script>
<if condition="$homeInfo['copyright']">
<div class="copyright">{pigcms{$homeInfo.copyright}</div> 
</if> 
<include file="Index:styleInclude"/>
<include file="$cateMenuFileName"/> 
<!-- share -->
<include file="Index:share" />


</body>
</html>