<!DOCTYPE html>
<html>    <head>
       <if condition="$zd['status'] eq 1">
            {pigcms{$zd['code']}
        </if>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>{pigcms{$tpl.wxname}</title>
        <base href="." />
        <meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black" />
        <meta name="format-detection" content="telephone=no" />
<link href="{pigcms{$static_path}css/allcss/cate33_{pigcms{$tpl.color_id}.css" rel="stylesheet" type="text/css" />
<!-- <link href="{pigcms{$static_path}css/133/cate20_.css" rel="stylesheet" type="text/css"> -->
<link href="{pigcms{$static_path}css/133/iscroll.css" rel="stylesheet" type="text/css">

<script src="{pigcms{$static_path}css/133/jquery.min.js" type="text/javascript"></script>
<script src="{pigcms{$static_path}css/133/idangerous.swiper.js" type="text/javascript"></script>
<script src="{pigcms{$static_path}css/133/iscroll.js" type="text/javascript"></script>
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

<body id="cate20">
<!--背景音乐-->
<if condition="$homeInfo['musicurl'] neq false">
<include file="Index:music"/>
</if>
<div id="insert1" style="z-index:10000; position:fixed; top:20px;"></div>


<div class="banner">
<div id="wrapper" style="overflow: hidden;">
<div id="scroller" style="width: 4047px; -webkit-transition: -webkit-transform 0ms; transition: -webkit-transform 0ms; -webkit-transform-origin: 0px 0px; -webkit-transform: translate3d(-2698px, 0px, 0px) scale(1);">
<ul id="thelist">
<volist name="flash" id="so">               
<li><p>{pigcms{$so.info}</p>
<a href="{pigcms{$so.url}">
<img src="{pigcms{$so.img}" style="width: 1349px;">
</a>
</li>
</volist>
</ul>
</div>
</div>
      <div id="nav">
<div id="prev" onclick="myScroll.scrollToPage(&#39;prev&#39;, 0,400,3);return false">← prev</div>
<ul id="indicator">
            
<volist name="flash" id="so">
    <li <if condition="$i eq 1">class="active"</if>></li>
</volist>
 
</ul>
<div id="next" onclick="myScroll.scrollToPage(&#39;next&#39;, 0,400,3);return false">next →</div>
</div>
    <div class="clr"></div>
</div>

 
 <div id="insert1"></div>


                           
<volist name="info" id="vo"> 
<div class="catemenu">
<a href="<if condition="$vo['url'] eq ''">{pigcms{:U('Wap/Index/lists',array('classid'=>$vo['id'],'token'=>$vo['token']))}<else/>{pigcms{$vo.url|htmlspecialchars_decode}</if>"><div class="cname"><img src="{pigcms{$vo.img}">{pigcms{$vo.name}</div></a>
<ul>
<?php
$i=1;
$lastItem=end($vo['sub']);
foreach ($vo['sub'] as $item){
	if ($i%4==1){
		echo '<li>';
	}
	$url=$item['url']?htmlspecialchars_decode($item['url']):U('Wap/Index/lists',array('classid'=>$item['id'],'token'=>$item['token']));
	echo '<a href="'.$url.'">'.$item['name'].'</a>';
	if ($i%4==0||$lastItem['id']==$item['id']){
		echo '</li>';
	}
	$i++;
}
?>  

</ul>
</div>
</volist>   
          
<script>
var count = document.getElementById("thelist").getElementsByTagName("img").length;  


for(i=0;i<count;i++){
 document.getElementById("thelist").getElementsByTagName("img").item(i).style.cssText = " width:"+document.body.clientWidth+"px";

}

document.getElementById("scroller").style.cssText = " width:"+document.body.clientWidth*count+"px";


 setInterval(function(){
myScroll.scrollToPage('next', 0,400,count);
},3500 );

window.onresize = function(){ 
for(i=0;i<count;i++){
document.getElementById("thelist").getElementsByTagName("img").item(i).style.cssText = " width:"+document.body.clientWidth+"px";

}

 document.getElementById("scroller").style.cssText = " width:"+document.body.clientWidth*count+"px";
} 

</script>

 <div id="insert2"></div>
<if condition="$homeInfo['copyright']">
<div class="copyright">{pigcms{$homeInfo.copyright}</div> 
</if>
<div style="display:none"></div>
<include file="Index:styleInclude"/>
<include file="$cateMenuFileName"/>
<!-- share -->
<include file="Index:share" />
</body></html>