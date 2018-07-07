<html>
<head>
<meta charset="utf-8" />

<script type="text/javascript" src="./static/js/jquery.min.js"></script>
<link type="text/css" href="{pigcms{$static_path}css/style.css" rel="stylesheet"/>
<link type="text/css" href="./static/tmpls/css/style.css" rel="stylesheet"/>
<script type="text/javascript" src="./static/tmpls/js/jquery.tools.min.js"></script> 
<script type="text/javascript" src="./static/tmpls/js/jquery.mixitup.min.js"></script>
<link rel="stylesheet" type="text/css" href="{pigcms{$static_path}css/tplSilder.css" media="all"/>
<script type="text/javascript" src="{pigcms{$static_path}js/tplSilder.js"></script>
<link type="text/css" href="{pigcms{$static_path}css/cymain.css" rel="stylesheet"/>
<script type="text/javascript" src="./static/js/artdialog/jquery.artDialog.js"></script>
<script type="text/javascript" src="./static/js/artdialog/iframeTools.js"></script>
<link type="text/css" href="./static/tmpls/css/product.css" rel="stylesheet"/>

<style>
.tplinfo{
	color:black;
	font:12px/1.5 Microsoft YaHei,Helvitica,Verdana,Arial,san-serif
}
.cateradio li {margin:0px;}
.filterBtn li p {
	background:#ECEFFC;
}

</style>
</head>
<body>
<if condition="$_GET['type'] eq 1 || $_GET['type'] eq 5">
	<div style="background:#fefbe4;border:1px solid #f3ecb9;color:#993300;padding:10px;margin-bottom:5px;font-size:13px;">
	使用方法：点击两侧的箭头可以翻页浏览更多的模板，直接点击对应的模板既可选中
	</div>
			<fieldset id="select_filter_wrap">
                <div class="g filterBox">
                  <h1>按级别选择:</h1>
                  <ul class="filterBtn">	 					
                  	
                    <li class="filter" data-filter="all"><p>全部模版</p><i></i></li>
                    <li class="filter" data-filter="sub"><p>可显示两级分类</p><i></i></li>
                    <li class="filter" data-filter="focu"><p>支持幻灯片</p><i></i></li>
                    <li class="filter" data-filter="bg"><p>支持自定义背景</p><i></i></li>
                    <li class="filter" data-filter="thumb"><p>带缩略图</p><i></i></li>
					<li class="filter" data-filter="filt"><p>半透明版块</p><i></i></li>
					<li class="filter" data-filter="bgs"><p>支持背景音乐</p><i></i></li>
                    <li class="filter" data-filter="slip"><p>支持横向滑动</p><i></i></li>
                  </ul>
                  <h1>按行业选择:</h1>
                  <ul class="filterBtn">
                    <li class="filter" data-filter="mix"><p>常用模板</p><i></i></li>
                    <li class="filter" data-filter="hotel"><p>酒店</p><i></i></li>
                    <li class="filter" data-filter="car"><p>汽车</p><i></i></li>
                    <li class="filter" data-filter="tour"><p>旅游</p><i></i></li>
					<li class="filter" data-filter="restaurant"><p>餐饮</p><i></i></li>
                    <li class="filter" data-filter="estate"><p>房地产</p><i></i></li>
                    <li class="filter" data-filter="health"><p>医疗保健</p><i></i></li>
					<li class="filter" data-filter="edu"><p>教育培训</p><i></i></li>
					<li class="filter" data-filter="beauty"><p>健身美容</p><i></i></li>
                    <li class="filter" data-filter="wedding"><p>婚纱摄影</p><i></i></li>
                    <li class="filter" data-filter="other"><p>其他行业</p><i></i></li>

                  </ul>

                </div>
			</fieldset>
				

	<div class="list_carousel2">
 		<div class="caroufredsel_wrapper2" style="display: block; text-align: start; float: none; position: relative; top: auto; right: auto; bottom: auto; left: auto; z-index: auto; width: 960px; height: 383px; margin: 0px; overflow: hidden;"> 

			<ul class="cateradio g grid" id="foo3">
														
				<volist name="tpl" id="tpl">			
				<li class="mix {pigcms{$tpl.attr}">
					<a style="margin-bottom:5px;" href="javascript:void(0);" onclick="returnHomepage({pigcms{$tpl.tpltypeid})" title="模板 {pigcms{$tpl.tpltypeid}     {pigcms{$tpl.tpldesinfo}">
						<img src="/static/images/site/{pigcms{$tpl.tplview}" />
					</a>
					<span class="tplinfo">模板 {pigcms{$tpl.tpltypeid}</span>
				</li>
				
				</volist>

			</ul>
		
		</div> 
		
		<div class="clearfix2"></div>
		<a id="prev3" class="prev2" href="#" style="display: block;_margin-left:20px;"></a>
		<a id="next3" class="next2" href="#" style="display: block;"></a>
	</div>
		<script type="text/javascript">

			$(document).ready(function(){
				$('#foo3').carouFredSel({
					auto: false,
					prev: '#prev3',
					next: '#next3',
					pagination: "#pager3",
					mousewheel: false,
					swipe: {
						onMouse: true,
						onTouch: true
					}
				
				});

			//	$('.caroufredsel_wrapper2').css({'height':'383px'});
			
			
			$("li[data-filter={pigcms{$_GET['filter']}]").addClass('active');
			

			});

			
			

			var domid=art.dialog.data('domid');
			var domid2=art.dialog.data('domid2');
			// 返回数据到主页面
			function returnHomepage(url){
				var origin = artDialog.open.origin;
				var dom = origin.document.getElementById(domid);
				var dom2 = origin.document.getElementById(domid2);
			<if condition="$_GET['type'] eq 5">
				var strs = new Array();
				strs = domid.split('_');
				var cid = strs[1];
				var tid = url;
				$.ajax({
                    type:"post",
                    url:"index.php?g=Merchant&c=Classify&a=changeClassifyTpl",
                    data:{"cid":cid,"tid":tid},
					success:function(da){
						
					}
                });
			</if>

				dom.value=url;
				dom2.value='已选择模板 '+url;
				setTimeout("art.dialog.close()", 100 );
			}

		</script>

<!--选择首页模板-->
<script>
$(function(){

//列表hover效果
$(".grid li").hover(
function(){
$(this).addClass("hover");
},
function(){
$(this).removeClass("hover");
}
);
$(".prdInfo").click(function(){
return false;
});




var allObj = $('.mix');

$('#foo3').mixitup({
	layoutMode: 'grid',
	onMixEnd: function(){
	
	var filterC = $('.active').attr('data-filter');
	this.location = "{pigcms{:U('Classify/chooseTpl',array('type'=>intval($_GET['type'])))}&filter="+filterC;
	/*	
	//	
	//	if(filterC == 'all') filterC = 'mix_all';
		
	//	var tpl = allObj.filter('.'+filterC);
	//	allObj.css({"display":"none"});
	//	allObj.remove();
		
	//	$('#foo3').prepend(tpl);
	//	//tpl.css({'display':'none'});
		//$('#foo3').prepend(tpl);
	//	tpl.css({'display':'block'});

	
		var tpl = $('.mix').filter('.'+filterC);
		$('.mix').css({'display':'none'});
		tpl.css({'display':'block'});
		var tplobj = tpl;
		tpl.remove();
		$('#foo3').prepend(tplobj);
		*/

		}
	});
	
});

</script> 
		
<elseif condition="$_GET['type'] eq 2" />
	<style>
			#viewTpl {
				width:170px;
				height:353px;		
				background:url(/static/images/radio_iphone.png) no-repeat;
				margin:auto;
			}

	</style>

	<div id="viewTpl"><img src="/static/images/site/{pigcms{$info.tplview}" /></div>

	
<elseif condition="$_GET['type'] eq 3 || $_GET['type'] eq 6" />

	<div style="background:#fefbe4;border:1px solid #f3ecb9;color:#993300;padding:10px;margin-bottom:5px;font-size:13px;">
	使用方法：点击两侧的箭头可以翻页浏览更多的模板，直接点击对应的模板既可选中
	</div>
	<div class="list_carousel2">
		<div class="caroufredsel_wrapper2" style="display: block; text-align: start; float: none; position: relative; top: auto; right: auto; bottom: auto; left: auto; z-index: auto; width: 960px; height: 383px; margin: 0px; overflow: hidden;">
			<ul id="foo3" style="text-align: left; float: none; position: absolute; top: 0px; right: auto; bottom: auto; left: 0px; margin: 0px; width: 11040px; height: 383px; z-index: auto;">
														
				<volist name="contTpl" id="contTpl">			
				<li>
					<a style="margin-bottom:5px;" href="javascript:void(0);" onclick="returnHomepage({pigcms{$contTpl.tpltypeid})" title="模板 {pigcms{$contTpl.tpltypeid}     {pigcms{$contTpl.tpldesinfo}">
						<img src="/static/images/site/{pigcms{$contTpl.tplview}" />
					</a>
					<span class="tplinfo">模板 {pigcms{$contTpl.tpltypeid}</span>
				</li>
				</volist>

			</ul>
				
		</div>
		
		<div class="clearfix2"></div>
		<a id="prev3" class="prev2" href="#" style="display: block;_margin-left:20px;"></a>
		<a id="next3" class="next2" href="#" style="display: block;"></a>

	</div>
	
			<script type="text/javascript">
			$(document).ready(function(){
				$('#foo3').carouFredSel({
					auto: false,
					prev: '#prev3',
					next: '#next3',
					pagination: "#pager3",
					mousewheel: true,
					swipe: {
						onMouse: true,
						onTouch: true
					}		
				
				});	

			});
			
			
			var domid=art.dialog.data('domid');
			var domid2=art.dialog.data('domid2');
			// 返回数据到主页面
			function returnHomepage(url){
				var origin = artDialog.open.origin;
				var dom = origin.document.getElementById(domid);
				var dom2 = origin.document.getElementById(domid2);
			<if condition="$_GET['type'] eq 6">
				var strs = new Array();
				strs = domid.split('_');
				var cid = strs[1];
				var tid = url;
				$.ajax({
                    type:"post",
                    url:"index.php?g=Merchant&c=Classify&a=changeClassifyContTpl",
                    data:{"cid":cid,"tid":tid},
					success:function(da){
						
					}
                });
			</if>
				dom.value=url;
				dom2.value='已选择模板 '+url;
				setTimeout("art.dialog.close()", 100 );
			}

			</script>
			
			
<else />
	<style>
			#viewTpl2 {
				width:170px;
				height:353px;		
				background:url(/static/images/radio_iphone.png) no-repeat;
				margin:auto;
			}

	</style>

	<div id="viewTpl2"><img src="/static/images/site/{pigcms{$info.tplview2}" /></div>
		
</if>

</body>
</html>