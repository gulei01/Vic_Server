<include file="Public:header"/>
	<form id="myform" method="post" action="{pigcms{:U('Scenic/edit_reason')}" frame="true" refresh="true">
		
		<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
			
			<tr>
				<th width="80">驳回理由</th>
				<input type="hidden" name="id" value="{pigcms{$id}" />
				<input type="hidden" name="scenic_id" value="{pigcms{$scenic_id}" />
				<td>
					<textarea  rows="6" cols="40" name="reason" id="reason" ></textarea>
				</td>
			</tr>
		
		</table>
		<div class="btn">
			
			<input type="submit" style="float:right;" name="dosubmit" id="dosubmit" value="提交" class="button" />
		</div>
	</form>
	<script src="{pigcms{$static_public}kindeditor/kindeditor.js"></script>
	<script type="text/javascript">
		KindEditor.ready(function(K){
			
			kind_editor = K.create("#content",{
				width:'402px',
				height:'320px',
				resizeType : 1,
				<if condition="$_GET['frame_show']">readonlyMode : true,</if>
				allowPreviewEmoticons:false,
				allowImageUpload : true,
				filterMode: true,
				items : [
					'source', 'fullscreen', '|', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
					'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
					'insertunorderedlist', '|', 'emoticons', 'image', 'link'
				],
				emoticonsPath : './static/emoticons/',
				uploadJson : "{pigcms{$config.site_url}/index.php?g=Index&c=Upload&a=editor_ajax_upload&upload_dir=system/news"
			});
			
		});
	</script>
<include file="Public:footer"/>