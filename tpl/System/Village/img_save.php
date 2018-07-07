<include file="Public:header"/>
<link rel="stylesheet" href="{pigcms{$static_public}kindeditor/themes/default/default.css">
<script src="{pigcms{$static_public}kindeditor/kindeditor.js"></script>
<script src="{pigcms{$static_public}kindeditor/lang/zh_CN.js"></script>
<style>
	.station{width: 80px;  float: left;}
</style>
<form id="myform" method="post" action="{pigcms{:U('Village/img_save_data')}" >
	<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
		<tr>
			<td width="80">图片标题</td>
			<td><input type="text" class="input fl" name="title" value="{pigcms{$imgInfo.title}" placeholder="请输入图片标题" validate="required:true"></td>
		</tr>

		<tr>
			<td width="80">排序</td>
			<td><input type="text" class="input fl" style="width: 50px;" name="sort" value="{pigcms{$imgInfo.sort}" placeholder="排序"></td>
		</tr>

		<tr class="" id="stationHidden">
			<td width="80">图片类型</td>
			<td id="stationVal">
				<volist id="img_type" name="img_type">
					<div class='station'>
						<input type="radio" <if condition="$imgInfo['img_type'] eq $key"> checked="checked"</if> name="img_type" value="{pigcms{$key}">{pigcms{$img_type}&nbsp;&nbsp;
					</div>
				</volist>
			</td>
		</tr>

		<tr>
			<td width="80">图片</td>
			<td><input type="text" name="url" id="imgUrl" class="input fl" value="{pigcms{$imgInfo.url}"><a href="javascript:void(0)" class="button" id="image3">浏览</a></td>
		</tr>

	</table>

	<div class="btn hidden">
		<input type="hidden" name="img_id" value="{pigcms{$imgInfo.img_id}">
		<input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
		<input type="reset" value="取消" class="button" />
	</div>
</form>
<include file="Public:footer"/>

<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <script src="{pigcms{$static_public}js/layer/layer.js"></script>
    <script>
        KindEditor.ready(function(K) {
            var editor = K.editor({
                allowFileManager : true
            });
            K('#image3').click(function() {
                editor.uploadJson = "{pigcms{:U('Village/ajax_upload_pic')}";
                editor.loadPlugin('image', function() {
                    editor.plugin.imageDialog({
                        showRemote : false,
                        imageUrl : K('#url3').val(),
                        clickFn : function(url, title, width, height, border, align) {
                            // var img = K('#houseImg');
                            // img.attr("src",url);
                            K('#imgUrl').val(url);
                            editor.hideDialog();
                        }
                    });
                });
            });
        });
    </script>