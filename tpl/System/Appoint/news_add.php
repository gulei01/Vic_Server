<include file="Public:header"/>
	<form id="myform" method="post" action="__SELF__" enctype="multipart/form-data" onSubmit="return chk_submit()">
		<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
			<tr>
				<th width="80">标题</th>
				<td><input type="text" class="input fl" name="title" id="title" size="25" placeholder="" validate="maxlength:50,required:true" tips=""/></td>
			</tr>
            <tr>
            
            <tr>
				<th width="80">发表时间</th>
				<td>
					<input type="text" class="input-text input fl" name="publish_time" size="25" validate="required:true" onfocus="WdatePicker({isShowClear:false,readOnly:true,dateFmt:'yyyy-MM-dd HH:mm:ss'})" value="{pigcms{:date('Y-m-d H:i:s')}" readonly>
				</td>
			</tr>
            
				<th width="80">排序</th>
				<td><input type="text" class="input fl" name="sort" size="10" value="0" validate="maxlength:6,required:true,number:true" tips="默认添加时间排序！手动排序数值越大，排序越前。"/></td>
			</tr>

			<tr>
				<th width="80">状态</th>
				<td>
					<span class="cb-enable"><label class="cb-enable selected"><span>启用</span><input type="radio" name="status" value="1" checked="checked" /></label></span>
					<span class="cb-disable"><label class="cb-disable"><span>关闭</span><input type="radio" name="status" value="0" /></label></span>
				</td>
			</tr>
            
            
                
                <tr>
                    <th width="80">描述</th>
                    <td><textarea name="desc" cols="140" rows="4" validate="required:true"></textarea></td>
			</tr>
           <tr>
                    <th width="80">内容</th>
                    <td><textarea  style="width:200px;height:60px" class="input" name="content" id="content"></textarea></td>
			</tr>
		</table>
		<div class="btn hidden">
			<input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
			<input type="reset" value="取消" class="button" />
		</div>
	</form>
    

<script src="{pigcms{$static_public}kindeditor/kindeditor.js"></script>
<script src="{pigcms{$static_public}kindeditor/lang/zh_CN.js"></script>
<script type="text/javascript" src="./static/js/artdialog/jquery.artDialog.js"></script>
<script type="text/javascript" src="./static/js/artdialog/iframeTools.js"></script>
<script type="text/javascript" src="./static/js/upyun.js"></script>    
<script type="text/javascript">
var diyTool = "{pigcms{:U('Home/diytool')}";
var editor;
KindEditor.ready(function(K) {
	editor = K.create('#content', {
		height:'300px',
		width:'750px',
		resizeType : 1,
		allowPreviewEmoticons : false,
		allowImageUpload : true,
		uploadJson : '/admin.php?g=System&c=Upyun&a=kindedtiropic',
		items : ['fontname', 'fontsize','subscript','superscript','indent','outdent','|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline','hr',
		 '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist', 'insertunorderedlist','link', 'unlink','image','diyTool']
	});
});


function chk_submit(){
	if($('#title').val()==''){
		alert('标题不能为空！');
		return false;
	}
	
	if($('input[name="publish_time"]').val()==''){
		alert('发表时间不能为空！');
		return false;
	}
	
	if($('input[name="sort"]').val()==''){
		alert('排序值不能为空！')
		return false;
	}
	
	if($('input[name="desc"]').val()==''){
		alert('描述不能为空！');
		return false;
	}
}
</script>
<include file="Public:footer"/>