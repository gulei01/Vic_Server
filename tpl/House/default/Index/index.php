<include file="Public:header"/>
<div class="main-content">
	<!-- 内容头部 -->
	<div class="breadcrumbs" id="breadcrumbs">
		<ul class="breadcrumb">
			<li>
				<i class="ace-icon fa fa-gear gear-icon"></i>
				<a href="{pigcms{:U('Index/index')}">社区管理</a>
			</li>
			<li class="active">基本信息设置</li>
		</ul>
	</div>
	<!-- 内容头部 -->
	<div class="page-content">
		<div class="page-content-area">
			<style>
				.ace-file-input a {display:none;}
			</style>
			<div class="row">
				<div class="col-xs-12">
					<div class="tabbable">
						<ul id="myTab" class="nav nav-tabs">
							<li class="active">
								<a href="#basicinfo" data-toggle="tab">基本设置</a>
							</li>
							<li>
								<a href="#txtstore" data-toggle="tab">缴费配置</a>
							</li>
							<li>
								<a href="#txtpwd" data-toggle="tab">功能库配置</a>
							</li>
                            <!--li>
								<a href="#txtservice" data-toggle="tab">便民配置</a>
							</li-->
                            <li>
								<a href="#bindweixin" data-toggle="tab">绑定管理微信号</a>
							</li>
						</ul>
					</div>
					<form id="edit_form" method="post" class="form-horizontal" action="{pigcms{:U('Index/village_edit')}" enctype="multipart/form-data">
						<div class="tab-content">
							<div class="tab-pane active" id="basicinfo">
								<div class="form-group">
									<label class="col-sm-1"><label for="name">物业名称</label></label>
									<input class="col-sm-2" size="20" value="{pigcms{$village_info.property_name}" type="text" style="border:none;background:white!important;" readonly/>
								</div>
								<div class="form-group">
									<label class="col-sm-1"><label for="village_name">小区名称</label></label>
									<input class="col-sm-2" size="20" value="{pigcms{$village_info.village_name}" id="village_name" type="text" style="border:none;background:white!important;" readonly/>
								</div>
								<div class="form-group">
									<label class="col-sm-1"><label for="property_phone">物业联系方式</label></label>
									<input class="col-sm-2" size="20" name="property_phone" id="property_phone" type="text" value="{pigcms{$village_info.property_phone}"/>
									<span class="form_tips">多个电话号码以空格分开</span>
								</div>
								<div class="form-group">
									<label class="col-sm-1"><label for="property_address">物业联系地址</label></label>
									<input class="col-sm-2" size="20" name="property_address" id="property_address" type="text" value="{pigcms{$village_info.property_address}"/>
								</div>
								<div class="form-group">
									<label class="col-sm-1"><label for="long_lat">小区经纬度</label></label>
									<input class="col-sm-2" size="10" name="long_lat" id="long_lat" type="text" readonly value="<if condition="$village_info['long']">{pigcms{$village_info.long},{pigcms{$village_info.lat}</if>"/>
									&nbsp;&nbsp;&nbsp;&nbsp;<a href="#modal-table" class="btn btn-sm btn-success" id="show_map_frame" data-toggle="modal">点击选取经纬度</a>
								</div>
								<div class="form-group">
									<label class="col-sm-1"><label>小区地址</label></label>
									<fieldset id="choose_cityarea" province_id="{pigcms{$village_info.province_id}" city_id="{pigcms{$village_info.city_id}" area_id="{pigcms{$village_info.area_id}" circle_id="{pigcms{$village_info.circle_id}"></fieldset>
								</div>
								<div class="form-group">
									<label class="col-sm-1"><label for="village_address">小区地址</label></label>
									<input class="col-sm-2" size="20" name="village_address" id="adress" type="text" value="{pigcms{$village_info.village_address}"/>
									<span class="form_tips">地址不能带有上面所在地选择的省/市/区/商圈信息。</span>
								</div>
								
								<div class="form-group">
									<label class="col-sm-1"><label for="handle_type">接任务类型</label></label>
									<label style="padding-left:0px;padding-right:20px;"><input name="handle_type" value="1" type="radio" class="ace" <if condition="$village_info.handle_type eq 1">checked</if>/><span class="lbl" style="z-index: 1">自行抢单</span></label>
									<label style="padding-left:0px;"><input name="handle_type" value="0" type="radio" class="ace" <if condition="$village_info.handle_type eq 0">checked</if>/><span class="lbl" style="z-index: 1">分配指定</span></label>
									<span class="form_tips">自行抢单：业主发布了投诉或报修时，工作人员自行抢接这个任务；分配指定：业主发布了投诉或报修时，由平台直接分发给某个特定的工作人员</span>
								</div>
								<div class="form-group hour" <if condition="$village_info.handle_type eq 0">style="display:none"</if>>
									<label class="col-sm-1"><label for="hour">超时指定的时间</label></label>
									<input class="col-sm-1" size="20" name="hour" id="hour" type="text" value="{pigcms{$village_info.hour|default=4}"/>
									<span class="form_tips">小时　(业主发布了投诉或报修后多少小时没有工作人员接任务，由平台指定给特定的工作人员)</span>
								</div>	

								<div class="form-group">
									<label class="col-sm-1"><label for="has_index_nav">首页自定义导航</label></label>
									
										<label style="padding-left:0px;padding-right:20px;"><input name="has_index_nav" value="1" type="radio" class="ace" <if condition="$village_info.has_index_nav eq 1">checked</if>/><span class="lbl" style="z-index: 1">开启</span></label>
										<label style="padding-left:0px;"><input name="has_index_nav" value="0" type="radio" class="ace" <if condition="$village_info.has_index_nav eq 0">checked</if>/><span class="lbl" style="z-index: 1">关闭</span></label>
								</div>	
                                <div class="form-group">
									<label class="col-sm-1"><label for="has_index_nav">首页小区商家</label></label>
									
										<label style="padding-left:0px;padding-right:20px;"><input name="has_index_store" value="0" type="radio" class="ace" <if condition="$village_info.has_index_store eq 0">checked</if>/><span class="lbl" style="z-index: 1">开启</span></label>
										<label style="padding-left:0px;"><input name="has_index_store" value="1" type="radio" class="ace" <if condition="$village_info.has_index_store eq 1">checked</if>/><span class="lbl" style="z-index: 1">关闭</span></label>
								</div>								
							</div>
							<div class="tab-pane" id="txtstore">
								<div class="form-group">
									<label class="col-sm-1"><label for="property_price">物业费单价</label></label>
									<input class="col-sm-1" size="10" name="property_price" id="property_price" type="text" value="{pigcms{$village_info.property_price|floatval=###}"/>
									<span class="form_tips">元/平方米/月 （支持两位小数，设置为0表示不支持）</span>
								</div>
								<div class="form-group">
									<label class="col-sm-1"><label for="water_price">水费单价</label></label>
									<input class="col-sm-1" size="10" name="water_price" id="water_price" type="text" value="{pigcms{$village_info.water_price|floatval=###}" />
									<span class="form_tips">元/立方米 （支持两位小数，设置为0表示不支持）</span>
								</div>
								<div class="form-group">
									<label class="col-sm-1"><label for="electric_price">电费单价</label></label>
									<input class="col-sm-1" size="10" name="electric_price" id="electric_price" type="text" value="{pigcms{$village_info.electric_price|floatval=###}" />
									<span class="form_tips">元/千瓦时(度) （支持两位小数，设置为0表示不支持）</span>
								</div>
								<div class="form-group">
									<label class="col-sm-1"><label for="gas_price">燃气费单价</label></label>
									<input class="col-sm-1" size="10" name="gas_price" id="gas_price" type="text" value="{pigcms{$village_info.gas_price|floatval=###}"  />
									<span class="form_tips">元/立方米 （支持两位小数，设置为0表示不支持）</span>
								</div>
								<div class="form-group">
									<label class="col-sm-1"><label for="park_price">停车位单价</label></label>
									<input class="col-sm-1" size="10" name="park_price" id="park_price" type="text" value="{pigcms{$village_info.park_price|floatval=###}" />
									<span class="form_tips">元/月 （支持两位小数，设置为0表示不支持）</span>
								</div>
								
								<div class="form-group" style="display:none">
									<label class="col-sm-1"><label for="express_collection_price">快递代送价格</label></label>
									<input class="col-sm-1" size="10" name="express_collection_price" id="express_collection_price" type="text" value="{pigcms{$village_info.express_collection_price|floatval=###}" />
									<span class="form_tips">元 （不支持小数。）</span>
								</div>
								
								
								<div class="form-group">
									<label class="col-sm-1"><label for="property_warn_day">物业提醒时间</label></label>
									<input class="col-sm-1" size="10" name="property_warn_day" id="property_warn_day" type="text" value="{pigcms{$village_info.property_warn_day|floatval=###}" />
									<span class="form_tips">天 （不支持小数。开通后，即可向业主手动提前相应天数进行提醒发送模板消息。）</span>
								</div>
								
								
								<div class="form-group">
									<label class="col-sm-1"><label for="has_property_pay">自定义物业缴费</label></label>
									<div class="radio">
										<label style="padding-left:0px;padding-right:20px;"><input name="has_property_pay" value="1" type="radio" class="ace" <if condition="$village_info.has_property_pay eq 1">checked</if>/><span class="lbl" style="z-index: 1">开启</span></label>
										<label style="padding-left:0px;"><input name="has_property_pay" value="0" type="radio" class="ace" <if condition="$village_info.has_property_pay eq 0">checked</if>/><span class="lbl" style="z-index: 1">关闭</span></label>
										<span class="form_tips">开通后，物业费可自定义上缴月份</span>
									</div>
								</div>
								
								
								<div class="form-group">
									<label class="col-sm-1"><label for="has_custom_pay">自定义缴费</label></label>
									<div class="radio">
										<label style="padding-left:0px;padding-right:20px;"><input name="has_custom_pay" value="1" type="radio" class="ace" <if condition="$village_info.has_custom_pay eq 1">checked</if>/><span class="lbl" style="z-index: 1">支持</span></label>
										<label style="padding-left:0px;"><input name="has_custom_pay" value="0" type="radio" class="ace" <if condition="$village_info.has_custom_pay eq 0">checked</if>/><span class="lbl" style="z-index: 1">不支持</span></label>
										<span class="form_tips">开通后，用户可以自定义名称、费用向物业发起缴费！方便物业上门维修等自定义收取费用</span>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="txtpwd">
								<div class="form-group">
									<label class="col-sm-1"><label for="has_custom_pay">快递代收</label></label>
									
										<label style="padding-left:0px;padding-right:20px;"><input name="has_express_service" value="1" type="radio" class="ace" <if condition="$village_info.has_express_service eq 1">checked</if>/><span class="lbl" style="z-index: 1">开启</span></label>
										<label style="padding-left:0px;"><input name="has_express_service" value="0" type="radio" class="ace" <if condition="$village_info.has_express_service eq 0">checked</if>/><span class="lbl" style="z-index: 1">关闭</span></label>
										<span class="form_tips">开通后，功能库中的<font class="green">&nbsp;快递代收&nbsp;</font>功能可正常使用</span>
									
								</div>
								<div class="form-group">
									<label class="col-sm-1"><label for="has_visitor">访客登记</label></label>
									
										<label style="padding-left:0px;padding-right:20px;"><input name="has_visitor" value="1" type="radio" class="ace" <if condition="$village_info.has_visitor eq 1">checked</if>/><span class="lbl" style="z-index: 1">开启</span></label>
										<label style="padding-left:0px;"><input name="has_visitor" value="0" type="radio" class="ace" <if condition="$village_info.has_visitor eq 0">checked</if>/><span class="lbl" style="z-index: 1">关闭</span></label>
										<span class="form_tips">开通后，功能库中的<font class="green">&nbsp;访客登记&nbsp;</font>功能可正常使用</span>
									
								</div><div class="form-group">
									<label class="col-sm-1"><label for="has_slide">首页幻灯片</label></label>
									
										<label style="padding-left:0px;padding-right:20px;"><input name="has_slide" value="1" type="radio" class="ace" <if condition="$village_info.has_slide eq 1">checked</if>/><span class="lbl" style="z-index: 1">开启</span></label>
										<label style="padding-left:0px;"><input name="has_slide" value="0" type="radio" class="ace" <if condition="$village_info.has_slide eq 0">checked</if>/><span class="lbl" style="z-index: 1">关闭</span></label>
										<span class="form_tips">开通后，功能库中的<font class="green">&nbsp;首页幻灯片&nbsp;</font>功能可正常使用</span>
									</div>
								
								<div class="form-group">
									<label class="col-sm-1"><label for="has_activity">社区活动</label></label>
									
										<label style="padding-left:0px;padding-right:20px;"><input name="has_activity" value="1" type="radio" class="ace" <if condition="$village_info.has_activity eq 1">checked</if>/><span class="lbl" style="z-index: 1">开启</span></label>
										<label style="padding-left:0px;"><input name="has_activity" value="0" type="radio" class="ace" <if condition="$village_info.has_activity eq 0">checked</if>/><span class="lbl" style="z-index: 1">关闭</span></label>
										<span class="form_tips">开通后，功能库中的<font class="green">&nbsp;社区活动&nbsp;</font>功能可正常使用</span>
									</div>
							</div>
                            
                            
                            <!--div class="tab-pane" id="txtservice">
								<div class="form-group">
									<label class="col-sm-1"><label for="has_custom_pay">便民页面幻灯片</label></label>
									
										<label style="padding-left:0px;padding-right:20px;"><input name="has_service_slide" value="1" type="radio" class="ace" <if condition="$village_info.has_service_slide eq 1">checked</if>/><span class="lbl" style="z-index: 1">开启</span></label>
										<label style="padding-left:0px;"><input name="has_service_slide" value="0" type="radio" class="ace" <if condition="$village_info.has_service_slide eq 0">checked</if>/><span class="lbl" style="z-index: 1">关闭</span></label>
										<span class="form_tips">开通后，便民服务中的<font class="green">&nbsp;便民页面幻灯片&nbsp;</font>功能可正常使用</span>
									
								</div>
							</div-->
                            
                            
                            <div class="tab-pane" id="bindweixin">
                            	
                            	<div id="weixin_info" <if condition="empty($village_info['openid'])">style="display:none"</if>>
								<div class="form-group">
									<label class="col-sm-1"><label for="village_name">微信昵称</label></label>
									<input class="col-sm-1" value="{pigcms{$village_info.nickname}" type="text" id="nickname" style="border:none;background:white!important;" readonly/>
									<a class="btn btn-sm btn-warning" id="cancel">取消绑定</a>
								</div>
								<div class="form-group">
									<label class="col-sm-1"><label>微信头像</label></label>
									<div id="upload_pic_box"><img width="100" height="100" src="{pigcms{$village_info.avatar}" id="avatar"/></div>
								</div>
								</div>
								<div class="form-group" id="weixin_bind" <if condition="$village_info['openid']">style="display:none"</if>>
									<label class="col-sm-1">扫描二维码</label>
									<div style="padding-top:4px;line-height:24px;"><a href="{pigcms{$config.site_url}/index.php?g=Index&c=Recognition&a=see_tmp_qrcode&qrcode_id={pigcms{$village_info['village_id'] + 3950000000}&img=1" class="see_qrcode">查看二维码</a></div>
								</div>
							</div>
                            
							<div class="clearfix form-actions">
								<div class="col-md-offset-3 col-md-9">
									<button type="submit" class="btn btn-info">
										<i class="ace-icon fa fa-check bigger-110"></i>
										保存
									</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
			</div>
		</div>
	</div>
</div>
<div id="modal-table" class="modal fade" tabindex="-1" style="display:block;">
	<div class="modal-dialog" style="width:80%;">
		<div class="modal-content" style="width:100%;">
			<div class="modal-header no-padding" style="width:100%;">
				<div class="table-header">
					<button id="close_button" type="button" class="close" data-dismiss="modal" aria-hidden="true">
						<span class="white">&times;</span>
					</button>
					(用鼠标滚轮可以缩放地图)    拖动红色图标，经纬度框内将自动填充经纬度。
				</div>
			</div>
			<div class="modal-body no-padding" style="width:100%;">
				<form id="map-search" style="margin:10px;">
					<input id="map-keyword" type="textbox" style="width:500px;" placeholder="尽量填写城市、区域、街道名"/>
					<input type="submit" value="搜索"/>
				</form>
				<div style="width:100%;height:600px;min-height:600px;" id="cmmap"></div>
			</div>
			<div class="modal-footer no-margin-top">
				<button class="btn btn-sm btn-success pull-right" data-dismiss="modal">
					<i class="ace-icon fa fa-times"></i>
					关闭
				</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
var static_public="{pigcms{$static_public}",static_path="{pigcms{$static_path}",merchant_index="{pigcms{:U('Index/index')}",choose_province="{pigcms{:U('Area/ajax_province')}",choose_city="{pigcms{:U('Area/ajax_city')}",choose_area="{pigcms{:U('Area/ajax_area')}",choose_circle="{pigcms{:U('Area/ajax_circle')}";
</script>
<script type="text/javascript" src="{pigcms{$static_path}js/area.js"></script>
<script type="text/javascript" src="https://api.map.baidu.com/api?ak=4c1bb2055e24296bbaef36574877b4e2&v=2.0&s=1" charset="utf-8"></script>
<script type="text/javascript" src="{pigcms{$static_path}js/map.js"></script>

<style>
.BMap_cpyCtrl{display:none;}
input.ke-input-text {
background-color: #FFFFFF;
background-color: #FFFFFF!important;
font-family: "sans serif",tahoma,verdana,helvetica;
font-size: 12px;
line-height: 24px;
height: 24px;
padding: 2px 4px;
border-color: #848484 #E0E0E0 #E0E0E0 #848484;
border-style: solid;
border-width: 1px;
display: -moz-inline-stack;
display: inline-block;
vertical-align: middle;
zoom: 1;
}
.form-group>label{font-size:12px;line-height:24px;}
#upload_pic_box{margin-top:20px;height:150px;}
#upload_pic_box .upload_pic_li{width:130px;float:left;list-style:none;}
#upload_pic_box img{width:100px;height:70px;border:1px solid #ccc;}
</style>
<link rel="stylesheet" href="{pigcms{$static_public}kindeditor/themes/default/default.css">
<script src="{pigcms{$static_public}kindeditor/kindeditor.js"></script>
<script src="{pigcms{$static_public}kindeditor/lang/zh_CN.js"></script>
<script type="text/javascript" src="./static/js/artdialog/jquery.artDialog.js"></script>
<script type="text/javascript" src="./static/js/artdialog/iframeTools.js"></script>
<script type="text/javascript">
var lock = 0, test;
KindEditor.ready(function(K){
	$('#edit_form').submit(function(){
		$('#edit_form button[type="submit"]').prop('disabled',true).html('保存中...');
		if (lock = 1) {
			return;
		}
		lock = 1;
		$.post("{pigcms{:U('Index/village_edit')}",$('#edit_form').serialize(),function(result){
			lock = 0;
			if(result.status == 1){
				window.location.href = "{pigcms{:U('Index/index')}";
			}else{
				$('#edit_form button[type="submit"]').prop('disabled',false).html('<i class="ace-icon fa fa-check bigger-110"></i>保存');
				alert(result.info);
			}
		})
		return false;
	});
});
$(document).ready(function(){
	$('input[name=handle_type]').click(function(){
		if ($(this).val() == 1) {
			$('.hour').show();
		} else {
			$('.hour').hide();
		}
	});
	$('.see_qrcode').click(function(){
		test = art.dialog.open($(this).attr('href'),{
			init: function(){
				var iframe = this.iframe.contentWindow;
				window.top.art.dialog.data('iframe_handle',iframe);
			},
			id: 'handle',
			title:'扫描二维码绑定微信号',
			padding: 0,
			width: 430,
			height: 433,
			lock: true,
			resize: false,
			background:'black',
			button: null,
			fixed: false,
			close: function(){clearInterval(t);},
			left: '50%',
			top: '38.2%',
			opacity:'0.4'
		});
		var t = window.setInterval(function(){
			$.get("{pigcms{:U('Index/check_bind')}", function(result){
				if (result.error_code == 0) {
					$('#nickname').val(result.nickname);
					$('#avatar').attr('src', result.avatar);
					clearInterval(t);
					test.close();
					$('#weixin_bind').hide();
					$('#weixin_info').show();
				}
			}, 'json');
		},3000);
		return false;
	});
	$('#cancel').click(function(){
		var obj = $(this);
		obj.attr('disabled', true);
		$.post("{pigcms{:U('Index/cancel')}", function(result){
			obj.attr('disabled', false);
			if (result.error_code == 1) {
				alert(result.msg);
			} else {
				$('#weixin_bind').show();
				$('#weixin_info').hide();
			}
		}, 'json');
	});
});
</script>

<include file="Public:footer"/>