<?php if(!defined('PigCms_VERSION')){ exit('deny access!');} ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>首页</title>
		<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width"/>
		<meta name="apple-mobile-web-app-capable" content="yes"/>
		<meta name='apple-touch-fullscreen' content='yes'/>
		<meta name="apple-mobile-web-app-status-bar-style" content="black"/>
		<meta name="format-detection" content="telephone=no"/>
		<meta name="format-detection" content="address=no"/>
		<link rel="stylesheet" type="text/css" href="{pigcms{$static_path}css/common.css?21923"/>
		<link rel="stylesheet" type="text/css" href="{pigcms{$static_path}css/index.css?216"/>
		<script type="text/javascript" src="{pigcms{:C('JQUERY_FILE_190')}" charset="utf-8"></script>
		<script type="text/javascript" src="{pigcms{$static_path}js/iscroll.js?444" charset="utf-8"></script>
		<script type="text/javascript" src="{pigcms{$static_path}js/idangerous.swiper.min.js" charset="utf-8"></script>
		<script type="text/javascript" src="{pigcms{$static_path}js/fastclick.js" charset="utf-8"></script>
		<script type="text/javascript" src="{pigcms{$static_path}layer/layer.m.js" charset="utf-8"></script>
		<script type="text/javascript" src="{pigcms{$static_path}js/common.js?2112222" charset="utf-8"></script>
		<script type="text/javascript">var group_index_sort_url="{pigcms{:U('Home/group_index_sort')}";<if condition="$user_long_lat">var user_long = "{pigcms{$user_long_lat.long}",user_lat = "{pigcms{$user_long_lat.lat}";<else/>var user_long = '0',user_lat  = '0';</if>var app_version="{pigcms{$_REQUEST['app_version']}"</script>
		<script type="text/javascript" src="{pigcms{$static_path}js/index.js?210" charset="utf-8"></script>
		<if condition="$config.guess_content_type eq 'shop'">
			<link rel="stylesheet" type="text/css" href="{pigcms{$static_path}shop/css/home_shop.css?216"/>
		<elseif condition="$config.guess_content_type eq 'meal'" />
			<link rel="stylesheet" type="text/css" href="{pigcms{$static_path}css/home_meal.css?216"/>
		</if>
		<script>
			$(function(){
				$(document).on('click','.hasMore',function(){
					$(this).toggleClass('showMore');
					myScroll.refresh();
					return false;
				});
			});
		</script>
		<style>
			.index_house{
				position:relative;
			}
			.index_house:after {
				display: block;
				content: "";
				border-top: 1px solid #BFBFBF;
				border-left: 1px solid #BFBFBF;
				width: 8px;
				height: 8px;
				-webkit-transform: rotate(135deg);
				background-color: transparent;
				position: absolute;
				top: 50%;
				right: 15px;
				margin-top: -5px;
			}
		</style>
	</head>
	<body>
		<header <if condition="$config['many_city']">class="hasManyCity"</if> style="z-index:111;">
			<if condition="$config['many_city']">
				<div id="cityBtn" class="link-url" data-url="{pigcms{:U('Changecity/index')}">{pigcms{$config.now_select_city.area_name}</div>
			</if>
			<div id="locaitonBtn" class="link-url" data-url="{pigcms{:U('Merchant/around')}"></div>
			<div id="searchBox">
				<a href="{pigcms{:U('Search/index')}">
					<i class="icon-search"></i>
					<span>请输入您想找的内容</span>
				</a>
			</div>
			<div id="qrcodeBtn"></div>
		</header>
		<div id="container" style="top:50px;-webkit-transform:translate3d(0,0,0)">
			<div id="scroller">
				<div id="pullDown">
					<span class="pullDownIcon"></span><span class="pullDownLabel">下拉可以刷新</span>
				</div>
				<if condition="$wap_index_top_adver">
					<section class="banner">
						<div class="swiper-container swiper-container1">
							<div class="swiper-wrapper">
								<volist name="wap_index_top_adver" id="vo">
									<div class="swiper-slide">
										<a href="{pigcms{$vo.url}">
											<img src="{pigcms{$vo.pic}"/>
										</a>
									</div>
								</volist>
							</div>
							<div class="swiper-pagination swiper-pagination1"></div>
						</div>
					</section>
				</if>
				<if condition="$config['house_open']">
					<section class="invote index_house" style="margin-top:10px;">
						<a href="{pigcms{:U('House/village_list')}">
							<img src="{pigcms{$config.wechat_share_img}"/>
							我的社区服务
						</a>
					</section>
				</if>
				<if condition="$wap_index_slider">
					<section class="slider">
						<div class="swiper-container swiper-container2" style="height:168px;">
							<div class="swiper-wrapper">
								<volist name="wap_index_slider" id="vo">
									<div class="swiper-slide">
										<ul class="icon-list">
											<volist name="vo" id="voo">
												<li class="icon">
													<a href="{pigcms{$voo.url}">
														<span class="icon-circle">
															<img src="{pigcms{$voo.pic}">
														</span>
														<span class="icon-desc">{pigcms{$voo.name}</span>
													</a>
												</li>
											</volist>
										</ul>
									</div>
								</volist>
							</div>
							<div class="swiper-pagination swiper-pagination2"></div>
						</div>
						<if condition="$news_list">
							<div class="platformNews clearfix link-url" data-url="{pigcms{:U('Systemnews/index')}">
								<div class="left ico"></div>
								<div class="left list">
									<ul>
										<volist name="news_list" id="vo">
											<li class="num-{pigcms{$i}" <if condition="$i gt 2">style="display:none;"</if>>[{pigcms{$vo.name}] {pigcms{$vo.title}</li>
										</volist>
									</ul>
								</div>
							</div>
						</if>
					</section>
				</if>
				<if condition="$invote_array">
					<section class="invote">
						<a href="{pigcms{$invote_array.url}">
							<img src="{pigcms{$invote_array.avatar}"/>
							{pigcms{$invote_array.txt}
							<button>关注我们</button>
						</a>
					</section>
				<elseif condition="$share"/>
					<section class="invote">
						<a href="{pigcms{$share.a_href}">
							<img src="{pigcms{$share.image}"/>
							{pigcms{$share.title}
							<button>{pigcms{$share['a_name']}</button>
						</a>
					</section>
				</if>
				<if condition="$activity_list">
					<section class="activity">
						<div class="activityBox">
							<div class="swiper-container swiper-container4">
								<div class="swiper-wrapper">
									<volist name="activity_list" id="vo">
										<div class="swiper-slide">
											<a href="{pigcms{:U('Wapactivity/detail',array('id'=>$vo['pigcms_id']))}">
												<label>
													<span class="title">参与</span>
													<span class="number">{pigcms{$vo.part_count}</span>
												</label>
												<div class="clock"><span class="time_d">{pigcms{$time_array['d']}</span>天 <span class="timerBox"><span class="timer time_h">{pigcms{$time_array['h']}</span>:<span class="timer time_m">{pigcms{$time_array['m']}</span>:<span class="timer time_s">{pigcms{$time_array['s']}</span></span></div>
												<div class="icon">
													<img src="{pigcms{$vo.list_pic}" alt="{pigcms{$vo.name}"/>
												</div>
												<div class="desc">
													<div class="name">{pigcms{$vo.name}</div>
													<div class="price">
														<if condition="$vo['type'] eq 1">
															<strong class="yuan">剩{pigcms{$vo['all_count']-$vo['part_count']}</strong>
														<else/>
															<if condition="$vo['mer_score']">
																<strong>{pigcms{$vo.mer_score}积分</strong>
															<else/>
																<strong>${pigcms{$vo.money}</strong>
															</if>
														</if>
													</div>
												</div>
											</a>
										</div>
									</volist>
								</div>
							</div>
						</div>
					</section>
				</if>
				<section class="recommend" <if condition="!$wap_index_center_adver">style="height:85px;"</if>>
					<if condition="$wap_index_center_adver">
						<div class="recommendBox">
							<div class="recommendLeft link-url" data-url="{pigcms{$wap_index_center_adver.2.url}">
								<img src="{pigcms{$wap_index_center_adver.2.pic}" alt="{pigcms{$wap_index_center_adver.2.name}"/>
							</div>
							<div class="recommendRight">
								<div class="recommendRightTop link-url" data-url="{pigcms{$wap_index_center_adver.1.url}">
									<img src="{pigcms{$wap_index_center_adver.1.pic}" alt="{pigcms{$wap_index_center_adver.1.name}"/>
								</div>
								<div class="recommendRightBottom link-url" data-url="{pigcms{$wap_index_center_adver.0.url}">
									<img src="{pigcms{$wap_index_center_adver.0.pic}" alt="{pigcms{$wap_index_center_adver.0.name}"/>
								</div>
							</div>
						</div>
					</if>
					<div class="nearBox">
						<ul>
							<li>
								<div class="nearBoxDiv merchant link-url" data-url="{pigcms{:U('Merchant/around')}">
									<div class="title">附近商家</div>
									<div class="desc">快速找到商家</div>
									<div class="icon"></div>
								</div>
							</li>
							<li>
								<div class="nearBoxDiv group link-url" data-url="{pigcms{:U('Group/index')}">
									<div class="title">附近{pigcms{$config.group_alias_name}</div>
									<div class="desc">看得到的便宜</div>
									<div class="icon"></div>
								</div>
							</li>
							<li>
								<div class="nearBoxDiv store link-url" data-url="{pigcms{:U('Shop/index')}">
									<div class="title">附近{pigcms{$config.shop_alias_name}</div>
									<div class="desc">购物无需等待</div>
									<div class="icon"></div>
								</div>
							</li>
						</ul>
					</div>
				</section>
				<if condition="$classify_Zcategorys">
					<section class="classify">
						<div class="headBox">分类信息</div>
						<div class="classifyBox">
							<div class="swiper-container swiper-container3">
								<div class="swiper-wrapper">
									<volist name="classify_Zcategorys" id="vo">
										<if condition="$vo['cat_pic']">
											<div class="swiper-slide">
												<a href="{pigcms{:U('Classify/index',array('cid'=>$vo['cid'],'ctname'=>urlencode($vo['cat_name'])))}#ct_item_{pigcms{$vo['cid']}">
													<span class="icon">
														<img src="{pigcms{$vo.cat_pic}"/>
													</span>
													<span class="desc">{pigcms{$vo.cat_name}</span>
												</a>
											</div>
										</if>
									</volist>
								</div>
							</div>
						</div>
					</section>
				</if>
				<section class="youlike hide">
					<div class="headBox">猜你喜欢</div>
					<dl class="likeBox dealcard"></dl>
				</section>
				<script id="indexRecommendBoxTpl" type="text/html">
					<if condition="$config.guess_content_type eq 'group'">
					{{# for(var i = 0, len = d.length; i < len; i++){ }}
						<dd class="recommend-link-url" data-group_id="{{ d[i].group_id }}" data-url="{{ d[i].url }}">
							{{# if(d[i].pin_num > 0){ }}<div class="pin_style"></div>{{# } }}
							<div class="dealcard-img imgbox">
								<img src="{pigcms{$config.site_url}/index.php?c=Image&a=thumb&width=276&height=168&url={{ encodeURIComponent(d[i].list_pic) }}" alt="{{ d[i].s_name }}"/>
							</div>
							<div class="dealcard-block-right">
								<div class="brand">{{# if(d[i].tuan_type != 2){ }} {{ d[i].merchant_name }}  {{# if(d[i].range){ }}<span class="location-right">{{ d[i].range }}</span>{{# } }}   {{# }else{ }} {{ d[i].s_name }} {{# } }}</div>
								<div class="title">{{ d[i].group_name }}</div>
								<div class="price">
									<strong>{{ d[i].price }}</strong><span class="strong-color">元</span>{{# if(d[i].wx_cheap){ }}<span class="tag">微信再减{{ d[i].wx_cheap }}元</span>{{# }else{ }}<del>{{ d[i].old_price }}</del>{{# } }} <span class="line-right">已售{{ parseInt(d[i].sale_count)+parseInt(d[i].virtual_num) }}</span>
								</div>
							</div>
						</dd>
					{{# } }}
					<elseif condition="$config.guess_content_type eq 'shop'"/>
					{{#　console.log(d.length)}}
						{{# for(var i = 0, len = d.length; i < len; i++){ }}
							<dd class="recommend-link-url" data-url="./wap.php?g=Wap&c=Shop&a=index#shop-{{ d[i].id }}" data-url-type="openRightFloatWindow" {{# if(d[i].is_close){ }}style="opacity:0.6;"{{# } }}>
								<div class="dealcard-img imgbox">
									<img style="margin-left: 0px;"  src="{{ d[i].image }}" alt="{{ d[i].name }}">
									{{# if(d[i].is_close){ }}<div class="closeTip">休息中</div>{{# } }}
								</div>
								<div class="dealcard-block-right">
									<div class="brand">{{ d[i].name }}<em class="location-right">{{# if(user_long != '0'){ }}{{ d[i].range }}{{# } }}</em></div>
									<div class="title {{# if(!d[i].delivery){ }}pick{{# } }}" style="margin-bottom:0px;">
										<span class="star">
											{{#
												var tmpScore = parseFloat(d[i].star);
												if(tmpScore>0){
													for(var tmpI=0;tmpI<5;tmpI++){ if(tmpScore >= tmpI+1){ }}<i class="full"></i>{{# }else if(tmpScore > tmpI){ }}<i class="half"></i>{{# }else{ }}<i></i>{{# } }
												}else{
											}}
												<i class="full"></i><i class="full"></i><i class="full"></i><i class="half"></i><i></i>
											{{#
												}
											}}
										</span>
										<span>月售{{ d[i].month_sale_count }}单</span>
										{{# if(d[i].delivery){ }}
											<em class="location-right">{{ d[i].delivery_time }}分钟</em>
										{{# }else{ }}
											<em class="location-right">门店自提</em>
										{{# } }}
									</div>
									{{# if(d[i].delivery){ }}
										<div class="price">
											<span>起送价 ${{ d[i].delivery_price }}</span><span class="delivery">配送费 ${{ d[i].delivery_money }}</span>
											{{# if(d[i].delivery_system){ }}
												<em class="location-right">平台配送</em>
											{{# }else{ }}
												<em class="location-right">商家配送</em>
											{{# } }}
										</div>
									{{# } }}
									
								</div>
								{{# if(d[i].coupon_count > 0){ }}
										<div class="coupon {{# if(d[i].coupon_count > 2){ }}hasMore{{# } }}">
											<ul>
												{{# var tmpCouponList = parseCoupon(d[i].coupon_list,'array');  }}
												{{# if(tmpCouponList['invoice']){ }}
													<li><em class="merchant_invoice"></em>{{ tmpCouponList['invoice'] }}</li>
												{{# } }}
												{{# if(tmpCouponList['discount']){ }}
													<li><em class="merchant_discount"></em>{{ tmpCouponList['discount'] }}</li>
												{{# } }}
												{{# if(tmpCouponList['minus']){ }}
													<li><em class="merchant_minus"></em>{{ tmpCouponList['minus'] }}</li>
												{{# } }}
												{{# if(tmpCouponList['newuser']){ }}
													<li><em class="newuser"></em>{{ tmpCouponList['newuser'] }}</li>
												{{# } }}
												{{# if(tmpCouponList['delivery']){ }}
													<li><em class="delivery"></em>{{ tmpCouponList['delivery'] }}</li>
												{{# } }}
												{{# if(tmpCouponList['system_minus']){ }}
												<li><em class="system_minus"></em>{{ tmpCouponList['system_minus'] }}</li>
												{{# } }}
												{{# if(tmpCouponList['system_newuser']){ }}
													<li><em class="system_newuser"></em>{{ tmpCouponList['system_newuser'] }}</li>
												{{# } }}
											</ul>
											{{# if(d[i].coupon_count > 2){ }}
												<div class="more">{{ d[i].coupon_count }}个活动</div>
											{{# } }}
										</div>
									{{# } }}
							</dd>
						{{# } }}
					<elseif condition="$config.guess_content_type eq 'meal'"/>
						{{# for(var i = 0, len = d.store_list.length; i < len; i++){ }}
							{{# if(d.store_list[i].state == 0){ }}
							<dl class="on">
								<dt>
									<div class="navLtop clr recommend-link-url" data-url="{{ d.store_list[i].url }}">
										<h2 class="fl1">{{ d.store_list[i].name }}</h2>
										<div class="navLtop_right fr">
											{{# if(d.store_list[i].is_book == 1){ }}
											<span class="ln">订</span>
											{{# } }}
											{{# if(d.store_list[i].is_queue == 1){ }}
											<span class="zi">排</span>
											{{# } }}
											{{# if(d.store_list[i].is_takeout == 1){ }}
											<span class="lv">外</span>
											{{# } }}
										</div>
									</div>
									<div class="navLBt clr">
										<ul class="navLBt_ul fl show_number clr">  
											<li>
												<div class="atar_Show">
													<p tip="{{ d.store_list[i].score_mean }}" ></p>
												</div>
											</li>
										</ul>
										<div class="Notopen fl">未营业</div>
										<div class="distance fr">{{ d.store_list[i].range }}</div>
									</div>
								</dt>
							</dl>
							{{# } else { }}
							<dl>
								<dt>
									<div class="navLtop clr recommend-link-url" data-url="{{ d.store_list[i].url }}">
										<h2 class="fl1">{{ d.store_list[i].name }}</h2>
										<div class="navLtop_right fr">
											{{# if(d.store_list[i].is_book == 1){ }}
											<span class="ln">订</span>
											{{# } }}
											{{# if(d.store_list[i].is_queue == 1){ }}
											<span class="zi">排</span>
											{{# } }}
											{{# if(d.store_list[i].is_takeout == 1){ }}
											<span class="lv">外</span>
											{{# } }}
										</div>
									</div>
									<div class="navLBt clr">
										<ul class="navLBt_ul fl show_number clr">  
											<li>
												<div class="atar_Show fl">
													<p tip="{{ d.store_list[i].score_mean }}" ></p>
												</div>
											</li>
										</ul>
										<div class="distance fr">{{ d.store_list[i].range }}</div>
									</div>
								</dt>
								{{# if(d.store_list[i].pay_in_store == 1 && d.store_list[i].discount_txt != null){ }}
								<dd class="navlink clr">
									<a href="{{ d.store_list[i].store_pay }}">
										<span class="link_Pay">到店付</span>
										{{# if(d.store_list[i].discount_txt.discount_type == 1){ }}
											<span>{{ d.store_list[i].discount_txt.discount_percent }}折</span>
										{{# } else { }}
											<span>每满{{ d.store_list[i].discount_txt.condition_price }}减{{ d.store_list[i].discount_txt.minus_price }}元</span>
										{{# } }}
										<span class="link_jt fr"></span>
									</a>
								</dd>
								{{# } }}
								{{# for(var j = 0, jlen = d.store_list[i].group_list.length; j < jlen; j++){ }}
								<dd class="Menulink clr">
									<a href="{{ d.store_list[i].group_list[j].url }}">
										<div class="Menulink_img fl">
											<img class="on" src="{{ d.store_list[i].group_list[j].list_pic }}">
											<span class="MenuGroup"></span>
										</div>
										<div class="Menulink_right">
											<h2>{{ d.store_list[i].group_list[j].name }}</h2>
											<div class="MenuPrice">
												<span class="PriceF"><i>$</i><em>{{ d.store_list[i].group_list[j].price }}</em></span>
												<span class="PriceT">门市价:${{ d.store_list[i].group_list[j].old_price }}</span>
												<span class="PriceS">已售{{ d.store_list[i].group_list[j].sale_count }}</span>
											</div>
										</div>
									</a>
								</dd>
								{{# } }}
							</dl>
							{{# } }}
						{{# } }}
					</if>
				</script>
				<div id="pullUp" style="bottom:-60px;">
					<img src="{pigcms{$config.site_logo}" style="width:130px;height:40px;margin-top:10px"/>
				</div>
			</div>
		</div>
		<include file="Public:footer"/>
		<script type="text/javascript">
			window.shareData = {
				"moduleName":"Home",
				"moduleID":"0",
				"imgUrl": "<if condition="$config['wechat_share_img']">{pigcms{$config.wechat_share_img}<else/>{pigcms{$config.site_logo}</if>",
				"sendFriendLink": "{pigcms{$config.site_url}{pigcms{:U('Home/index')}",
				"tTitle": "{pigcms{$config.site_name}",
				"tContent": "{pigcms{$config.seo_description}"
			};
		</script>
		{pigcms{$shareScript}
	</body>
</html>