<include file="Public:header"/>
<div class="main-content">
	<!-- 内容头部 -->
	<div class="breadcrumbs" id="breadcrumbs">
		<ul class="breadcrumb">
			<li>
				<i class="ace-icon fa fa-gear gear-icon"></i>
				<a href="{pigcms{:U('Appoint/index')}">预约管理</a>
			</li>
			<li class="active">添加工作人员</li>
		</ul>
	</div>
	<!-- 内容头部 -->
	<div class="page-content">
		<div class="page-content-area">
			<style>
				.ace-file-input a {display:none;}
				#levelcoupon select {width:150px;margin-right: 20px;}
			</style>
			<div class="row">
				<div class="col-xs-12">
					<div class="tabbable">
						<ul class="nav nav-tabs" id="myTab">				
							<li class="active">
								<a data-toggle="tab" href="#basicinfo">基本信息</a>
							</li>
							<li>
								<a data-toggle="tab" href="#txtstore">选择店铺</a>
							</li>
							<li>
								<a data-toggle="tab" href="#txtaccount">帐号信息</a>
							</li>
						</ul>
					</div>
					<form enctype="multipart/form-data" class="form-horizontal" method="post" id="add_form">
						<div class="tab-content">				
							<div id="basicinfo" class="tab-pane active">
								<div class="form-group">
									<label class="col-sm-1">姓名：</label>
									<input class="col-sm-3" maxlength="30" name="worker_name" type="text" value="" />
								</div>
	
								<div class="form-group">
									<label class="col-sm-1">是否开启</label>
									<label style="padding-left:0px;padding-right:20px;"><input type="radio" name="status" checked="checked" value="1" class="ace"><span class="lbl" style="z-index: 1">开启</span></label>
									<label style="padding-left:0px;"><input type="radio" name="status" value="0" class="ace"><span class="lbl" style="z-index: 1">关闭</span></label>
								</div>
								<div class="form-group">
									<label class="col-sm-1">性别</label>
									<label style="padding-left:0px;padding-right:20px;"><input type="radio" name="sex" checked="checked" value="1" class="ace"><span class="lbl" style="z-index: 1">&nbsp;&nbsp;男</span></label>
									<label style="padding-left:0px;"><input type="radio" name="sex" value="0" class="ace"><span class="lbl" style="z-index: 1">&nbsp;&nbsp;女</span></label>
								</div>
								
                                <div class="form-group">
									<label class="col-sm-1">上传头像</label>
									<a href="javascript:void(0)" class="btn btn-sm btn-success" id="J_selectImage">上传头像</a>
                                    <span class="form_tips red">&nbsp;*&nbsp;建议头像大小：200&nbsp;*&nbsp;200</span>
								</div>
                                
								<div class="form-group">
									<div id="upload_pic_box">
										<ul id="upload_pic_ul"></ul>
									</div>
								</div>
                                
                               
                               <div class="form-group">
									<label class="col-sm-1"><label for="phone">联系电话</label></label>
									<input class="col-sm-2" size="20" name="mobile" id="mobile" type="mobile"/>
								</div>
                               
								<div class="form-group">
									<label class="col-sm-1">简介：</label>
									<textarea name="desc" id="content" style="width:702px;"></textarea>
								</div>
                               
                               <div class="form-group">
									<label class="col-sm-1">服务类别：</label>
									<select name="appoint_type" class="col-sm-2">
										<option value="0">到店</option>
										<option value="1">上门</option>
                                        <option value="2">两者都支持</option>
									</select>
								</div>
                               
								<div class="tabbable">
									<ul class="nav nav-tabs" id="myTab">
										<li class="active">
											<a data-toggle="tab" href="#shop_time_1">
												营业时间段
											</a>
										</li>
									</ul>
									<div class="tab-content">
										<div id="shop_time_1" class="tab-pane in active">
											<div>
												<input id="Config_shop_start_time" type="text" value="08:00" name="office_start_time" />	至
												<input id="Config_shop_stop_time" type="text" value="20:00" name="office_stop_time" />
												<div class="errorMessage" id="Config_shop_start_time_em_" style="display:none"></div>
												<div class="errorMessage" id="Config_shop_stop_time_em_" style="display:none"></div>
												<span class="form_tips red">&nbsp;*&nbsp;如果营业时间段设置为00:00-00:00，则表示24小时营业</span>
											</div>
										</div>
										
                                            <div class="form-group"></div>
									</div>
                                    <div class="form-group"></div>
                                    <!--div class="form-group">
											<label class="col-sm-1">限定人数：</label>
											<input class="col-sm-1" maxlength="100" name="appoint_people" type="text" value="0" /><span class="form_tips red">&nbsp;*&nbsp;限制每个时间点的预约人数，0为不限制</span>
										</div-->
										<div class="form-group">
											<label class="col-sm-1">时间间隔：</label>
											<input class="col-sm-1" maxlength="100" name="time_gap" type="text" value="30" /><span class="form_tips red">&nbsp;*&nbsp;预约时间间隔，单位分钟，必须是10的倍数，填写-1则显示为天数预约。</span>
										</div>
								</div>
							</div>
							<div id="txtstore" class="tab-pane">
								<div class="form-group">
									<volist name="store_list" id="vo" key="k">
										<div class="radio">
											<label>
												<input class="paycheck ace" type="radio" name="store_id" value="{pigcms{$vo.store_id}" id="store{pigcms{$vo.store_id}" />
												<span class="lbl"><label for="store{pigcms{$vo.store_id}">{pigcms{$vo.name} - {pigcms{$vo.area_name}-{pigcms{$vo.adress}</label></span>
											</label>
										</div>
									</volist>
								</div>
							</div>
							
							<div id="txtaccount" class="tab-pane">
								<div class="form-group">
									<label class="col-sm-1"><label for="username">帐号</label></label>
									<input class="col-sm-2" name="username" id="username" value="" type="text">
								</div>
								
								<div class="form-group">
									<label class="col-sm-1"><label for="password">密码</label></label>
									<input class="col-sm-2" name="password" id="password" type="password">
								</div>
							</div>
							
							<div class="clearfix form-actions">
								<div class="col-md-offset-3 col-md-9">
									<button class="btn btn-info" type="submit" id="save_btn">
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
<style>
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
#upload_pic_box .upload_pic_li{list-style:none;}
#upload_pic_box img{width:200px;height:200px;}
</style>
<script type="text/javascript" src="{pigcms{$static_public}js/date/WdatePicker.js"></script>
<script src="{pigcms{$static_public}kindeditor/kindeditor.js"></script>
<script type="text/javascript">
$(function($){
	$('#Config_shop_start_time').timepicker($.extend($.datepicker.regional['zh-cn'], {'timeFormat':'hh:mm','hour':'10','minute':'52','second':'25'}));
	$('#Config_shop_stop_time').timepicker($.extend($.datepicker.regional['zh-cn'], {'timeFormat':'hh:mm','hour':'10','minute':'52','second':'25'}));
	$('#Config_shop_start_time_2').timepicker($.extend($.datepicker.regional['zh-cn'], {'timeFormat':'hh:mm','hour':'10','minute':'52','second':'25'}));
	$('#Config_shop_stop_time_2').timepicker($.extend($.datepicker.regional['zh-cn'], {'timeFormat':'hh:mm','hour':'10','minute':'52','second':'25'}));
	$('#Config_shop_start_time_3').timepicker($.extend($.datepicker.regional['zh-cn'], {'timeFormat':'hh:mm','hour':'10','minute':'52','second':'25'}));
	$('#Config_shop_stop_time_3').timepicker($.extend($.datepicker.regional['zh-cn'], {'timeFormat':'hh:mm','hour':'10','minute':'52','second':'25'}));
});
</script>
<script type="text/javascript">
KindEditor.ready(function(K) {
	var content_editor = K.create("#content",{
		width:'702px',
		height:'260px',
		resizeType : 1,
		allowPreviewEmoticons:false,
		allowImageUpload : true,
		filterMode: true,
		autoHeightMode : true,
		afterCreate : function() {
			this.loadPlugin('autoheight');
		},
		items : [
			'fullscreen', '|', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
			'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
			'insertunorderedlist', '|', 'emoticons', 'image', 'link', 'table'
		],
		emoticonsPath : './static/emoticons/',
		uploadJson : "{pigcms{$config.site_url}/index.php?g=Index&c=Upload&a=editor_ajax_upload&upload_dir=appoint/content",
		cssPath : "{pigcms{$static_path}css/group_editor.css"
	});
	
	var editor = K.editor({
		allowFileManager : true
	});
	K('#J_selectImage').click(function(){
		if($('.upload_pic_li').size() >= 1){
			alert('最多上传1个图片！');
			return false;
		}
		editor.uploadJson = "{pigcms{:U('Appoint/ajax_upload_pic')}";
		editor.loadPlugin('image', function(){
			editor.plugin.imageDialog({
				showRemote : false,
				imageUrl : K('#course_pic').val(),
				clickFn : function(url, title, width, height, border, align) {
					$('#upload_pic_ul').append('<li class="upload_pic_li"><img src="'+url+'"/><input type="hidden" name="pic" value="'+title+'"/><br/><a href="#" onclick="deleteImg(\''+title+'\',this);return false;">[ 删除 ]</a></li>');
					editor.hideDialog();
				}
			});
		});
	});


	$('#add_form').submit(function(){
		content_editor.sync();
		$('#save_btn').prop('disabled',true);
		$.post("{pigcms{:U('Appoint/worker_add')}",$('#add_form').serialize(),function(result){
			if(result.status == 1){
				alert(result.info);
				window.location.href = "{pigcms{:U('Appoint/worker_list')}";
			}else{
				alert(result.info);
			}
			$('#save_btn').prop('disabled',false);
		})
		return false;
	});

});	
	function deleteImg(path,obj){
		$.post("{pigcms{:U('Appoint/ajax_del_pic')}",{path:path});
		$(obj).closest('.upload_pic_li').remove();
	}
</script>
<include file="Public:footer"/>