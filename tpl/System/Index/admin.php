<include file="Public:header"/>
	<form id="myform" method="post" action="{pigcms{:U('Index/saveAdmin')}" frame="true" refresh="true">
		<input type="hidden" name="id" value="{pigcms{$_GET['id']}"/>
		<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
			<tr>
				<th width="80">账号</th>
				<td><input type="text" class="input fl" name="account" id="account" size="20" placeholder="请输入账号" validate="maxlength:30,required:true" value="{pigcms{$admin['account']}"/></td>
			</tr>
			<tr>
				<th width="80">密码</th>
				<td><input type="password" class="input fl" name="pwd" id="pwd" size="20" placeholder=""  tips="添加时候必填，在修改时候不填写证明不修改密码"/></td>
			</tr>
			<tr>
				<th width="80">真实姓名</th>
				<td><input type="text" class="input fl" name="realname" id="realname" size="20" placeholder="" tips="填写该账号使用者的真实姓名" value="{pigcms{$admin['realname']}"/></td>
			</tr>
			<tr>
				<th width="80">电话</th>
				<td><input type="text" class="input fl" name="phone" size="20" placeholder=""  value="{pigcms{$admin['phone']}"/></td>
			</tr>
			<tr>
				<th width="80">EMAIL</th>
				<td><input type="text" class="input fl" name="email" size="20" value="{pigcms{$admin['email']}"/></td>
			</tr>
			<!--tr>
				<th width="80">QQ</th>
				<td><input type="text" class="input fl" name="qq" size="20" value="{pigcms{$admin['qq']}"/></td>
			</tr-->
			<if condition="$config.open_extra_price  eq 1">
			<tr>
				<th width="80">区域管理员{pigcms{$config.score_name}结算比例</th>
				<td><input type="text" class="input fl" name="score_percent" size="20"  validate="required:true,min:0,max:100" value="{pigcms{$admin['score_percent']|floatval}"/></td>
			</tr>
			</if>
            <if condition="$admin['level'] eq 3">
            <tr>
                <th width="80">城市</th>
                <td>
                    <select name="area_id">
                        <option value="0" <if condition="$admin['area_id'] eq 0">selected="selected"</if>>None</option>
                    <volist name="city" id="vo">
                        <option value="{pigcms{$vo.area_id}" <if condition="$admin['area_id'] eq $vo['area_id']">selected="selected"</if>>{pigcms{$vo.area_name}</option>
                    </volist>
                    </select>
                    <select name="level">
                        <option value="0">普通管理员</option>
                        <option value="3" selected="selected">城市管理员</option>
                    </select>
                </td>
            </tr>
                <else />
                <tr>
                    <th width="80">类型</th>
                    <td>
                        <if condition="$admin['level'] eq 2">
                            超级管理员
                            <else />
                            <select name="level">
                                <option value="0" selected="selected">普通管理员</option>
                                <option value="3">城市管理员</option>
                            </select>
                        </if>
                    </td>
                </tr>
            </if>
			<tr>
				<th width="80">状态</th>
				<td>
					<span class="cb-enable"><label class="cb-enable <if condition="$admin['status'] eq 1">selected</if>"><span>显示</span><input type="radio" name="status" value="1" <if condition="$admin['status'] eq 1">checked="checked"</if> /></label></span>
					<span class="cb-disable"><label class="cb-disable  <if condition="$admin['status'] eq 0">selected</if>"><span>隐藏</span><input type="radio" name="status" value="0" <if condition="$admin['status'] eq 0">checked="checked"</if> /></label></span>
				</td>
			</tr>
		</table>
		<div class="btn hidden">
			<input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
			<input type="reset" value="取消" class="button" />
		</div>
	</form>
	<script type="text/javascript">
		get_first_word('area_name','area_url','first_pinyin');
	</script>
<include file="Public:footer"/>