<include file="Public:header"/>
<div class="main-content">
	<!-- 内容头部 -->
	<div class="breadcrumbs" id="breadcrumbs">
		<ul class="breadcrumb">
			<li>
				<i class="ace-icon fa fa-tablet"></i>
				<a href="{pigcms{:U('Bbs/index')}">社区论坛</a>
			</li>
			<li class="active">论坛配置</li>
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
					<form  class="form-horizontal" method="post" id="edit_form" action="{pigcms{:U('Bbs/modify_img')}" enctype="multipart/form-data"  onSubmit="return check_submit()">
						<div class="tab-content">
							<div id="basicinfo" class="tab-pane active">
								<div class="form-group">
									<label class="col-xs-2 col-sm-2 col-md-1 col-lg-1"><label for="cat_name">名&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;称</label></label>
									<input class="col-xs-4 col-sm-4 col-md-2" size="20" name="cat_name" id="cat_name" type="text" placeholder="输入五个字以内的分类名称" value="{pigcms{$aBbs.index_name}"/>
								</div>
								<div class="form-group">
									<label class="col-xs-2 col-sm-2 col-md-1 col-lg-1"><label for="auto_verify_post" style="font-size:13px;">审核帖子</label></label>
									<label><input name="auto_verify_post" type="radio" value="1" <if condition="$aBbs.auto_verify_post eq 1">checked</if> />&nbsp;&nbsp;自动审核</label>
									&nbsp;&nbsp;&nbsp;
									<label><input name="auto_verify_post" type="radio" value="2" <if condition="$aBbs.auto_verify_post eq 2">checked</if> />&nbsp;&nbsp;手动审核</label>
								</div>
								<div class="form-group">
									<label class="col-xs-2 col-sm-2 col-md-1 col-lg-1"><label for="auto_verify_reply" style="font-size:13px;">审核评论</label></label>
									<label><input name="auto_verify_reply" type="radio" value="1" <if condition="$aBbs.auto_verify_reply eq 1">checked</if> />&nbsp;&nbsp;自动审核</label>
									&nbsp;&nbsp;&nbsp;
									<label><input name="auto_verify_reply" type="radio" value="2" <if condition="$aBbs.auto_verify_reply eq 2">checked</if> />&nbsp;&nbsp;手动审核</label>
								</div>
								<div class="form-group" style="display:none" >
									<textarea id="content"></textarea>
								</div>
								<div id="txtimage" class="tab-pane">
									<div class="form-group">
										<label class="col-sm-1">上传图片</label>
										<a href="javascript:void(0)" class="btn btn-sm btn-success" id="J_selectImage">上传图片</a>
										图片宽度建议为：100px，高度建议为：100px
									</div>
									<div class="form-group">
										<label class="col-sm-1">图片预览</label>
										<div id="upload_pic_box">
											<ul id="upload_pic_ul">
												<li class="upload_pic_li"><img style="width:100px;height:100px;" src="{pigcms{$aBbs['index_icon']}"/><input type="hidden" name="pic" value="{pigcms{$aBbs['index_icon']}"/><br/><a href="#" onclick="deleteImg(1,this);return false;">[ 删除 ]</a></li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="space"></div>
						<div class="clearfix form-actions">
							<div class="col-md-offset-3 col-md-9">
								<button class="btn btn-info" type="submit">
									<i class="ace-icon fa fa-check bigger-110"></i>
									保存
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
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
<script src="{pigcms{$static_public}kindeditor/kindeditor.js"></script>
<script>
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
			uploadJson : "{pigcms{$config.site_url}/index.php?g=Index&c=Upload&a=editor_ajax_upload&upload_dir=bbs/category",
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
			editor.uploadJson = "{pigcms{:U('ajax_upload_pic')}";
			editor.loadPlugin('image', function(){
				editor.plugin.imageDialog({
					showRemote : false,
					imageUrl : K('#course_pic').val(),
					clickFn : function(url, title, width, height, border, align) {
						$('#upload_pic_ul').append('<li class="upload_pic_li"><img src="'+url+'"/><input type="hidden" name="pic" value="'+url+'"/><br/><a href="#" onclick="deleteImg(\''+title+'\',this);return false;">[ 删除 ]</a></li>');
						editor.hideDialog();
					}
				});
			});
		});
	})
	function deleteImg(path,obj){
		$.post("{pigcms{:U('ajax_del_pic')}",{path:path});
		$(obj).closest('.upload_pic_li').remove();
	}

function check_submit(){
	if($('#cat_name').val() == ''){
		alert('分类名称不能为空');
		return false;
	}
}
</script>
<include file="Public:footer"/>