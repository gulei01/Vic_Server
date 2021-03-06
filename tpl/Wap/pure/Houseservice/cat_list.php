<?php if(!defined('PigCms_VERSION')){ exit('deny access!');} ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
        <title>{pigcms{$now_village.village_name}</title>
		<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width"/>
		<meta name="apple-mobile-web-app-capable" content="yes"/>
		<meta name='apple-touch-fullscreen' content='yes'/>
		<meta name="apple-mobile-web-app-status-bar-style" content="black"/>
		<meta name="format-detection" content="telephone=no"/>
		<meta name="format-detection" content="address=no"/>
		<link rel="stylesheet" type="text/css" href="{pigcms{$static_path}css/common.css?210"/>
		<link rel="stylesheet" type="text/css" href="{pigcms{$static_path}css/village.css?212"/>
		<script type="text/javascript" src="{pigcms{:C('JQUERY_FILE_190')}" charset="utf-8"></script>
		<script type="text/javascript" src="{pigcms{$static_path}js/iscroll.js?444" charset="utf-8"></script>
		<script type="text/javascript" src="{pigcms{$static_path}js/fastclick.js" charset="utf-8"></script>
		<script type="text/javascript" src="{pigcms{$static_path}layer/layer.m.js" charset="utf-8"></script>
		<script type="text/javascript" src="{pigcms{$static_path}js/common.js?210" charset="utf-8"></script>
		<script type="text/javascript">
			var location_url = "{pigcms{:U('Houseservice/ajax_service',array('id'=>$now_category['id']))}";
			var backUrl = "{pigcms{:U('Houseservice/index',array('village_id'=>$now_village['village_id']))}";
			<if condition="$long_lat">var user_long = "{pigcms{$long_lat.long}",user_lat = "{pigcms{$long_lat.lat}";<else/>var user_long = '0',user_lat  = '0';</if>
		</script>
		<script type="text/javascript" src="{pigcms{$static_path}js/villageservicecatlist.js?210" charset="utf-8"></script>
	</head>
	<body>
		<if condition="!$is_app_browser">
			<header class="pageSliderHide"><div id="backBtn"></div>{pigcms{$now_category.cat_name}</header>
		</if>
		<div id="container">
			<div id="scroller" style="min-height:666666px;">
				<div id="pullDown">
					<span class="pullDownIcon"></span><span class="pullDownLabel">下拉可以刷新</span>
				</div>
				<script id="listBoxTpl" type="text/html">
					{{# for(var i = 0, len = d.list.length; i < len; i++){ }}
						<dd class="link-url" data-url="{{ d.list[i].url }}">
							{{# if(d.list[i].img_path){ }}
								<div class="imgbox">
									<img src="{{ d.list[i].img_path }}" alt="{{ d.list[i].title }}"/>
								</div>
							{{# } }}
							<div class="block-right">									
								<div class="brand">{{ d.list[i].title }}</div>
								<div class="desc">
									{{# if(d.list[i].phone){ }}<span class="phone" data-phone="{{ d.list[i].phone }}" data-phonetip="{{ d.list[i].title }}">拨打电话</span>{{# } }}{{# if(d.list[i].range){ }}<span class="line-right">{{ d.list[i].range }}</span>{{# } }}
								</div>
							</div>
						</dd>
					{{# } }}
				</script>
				<section class="serviceListBox listBox">
					<dl></dl>
					<div class="shade hide"></div>
					<div class="no-deals hide">暂无此类信息，请查看其他分类</div>
				</section>
				<div id="pullUp">
					<span class="pullUpIcon"></span><span class="pullUpLabel">上拉加载更多</span>
				</div>
			</div>
		</div>
		<php>$no_footer=true;</php>
		<include file="House:footer"/>
		{pigcms{$shareScript}
	</body>
</html>