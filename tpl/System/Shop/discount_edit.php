<include file="Public:header"/>
	<form id="myform" method="post" action="{pigcms{:U('Shop/discount_amend')}" frame="true" refresh="true">
		<input type="hidden" name="id" value="{pigcms{$now_discount.id}"/>
		<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
			<tr>
				<th width="90">优惠条件</th>
				<td><input type="text" class="input fl" name="full_money" value="{pigcms{$now_discount.full_money}" id="full_money" size="25" placeholder="0表示任意金额都可" validate="maxlength:20" tips="满足该条件才能有相应的优惠"/></td>
			</tr>
			<tr>
				<th width="90">优惠的金额</th>
				<td><input type="text" class="input fl" name="reduce_money" value="{pigcms{$now_discount.reduce_money}" id="reduce_money" size="25" placeholder="优惠金额大于0" validate="maxlength:20,required:true" tips="减免的金额"/></td>
			</tr>
			<tr>
				<th width="90">分类状态</th>
				<td>
					<span class="cb-enable"><label class="cb-enable <if condition="$now_discount['status'] eq 1">selected</if>"><span>启用</span><input type="radio" name="status" value="1" <if condition="$now_discount['status'] eq 1">checked="checked"</if> /></label></span>
					<span class="cb-disable"><label class="cb-disable <if condition="$now_discount['status'] eq 0">selected</if>"><span>关闭</span><input type="radio" name="status" value="0" <if condition="$now_discount['status'] eq 0">checked="checked"</if>/></label></span>
				</td>
			</tr>
			<tr>
				<th width="90">优惠类型</th>
				<td>
					<select name="type" class="valid" tips="新单：就是用户在平台的新快店第一次下单享受的优惠；满减：就是用户一次下单的金额满足了条件得到相应的优惠；配送：指用户一次下单满足多少钱后减免指定金额的配送费，最多减至配送费是0">
					<option value="0" <if condition="$now_discount['type'] eq 0">selected</if>>新单</option>
					<option value="1" <if condition="$now_discount['type'] eq 1">selected</if>>满减</option>
					<option value="2" <if condition="$now_discount['type'] eq 2">selected</if>>配送</option>
					</select>
				</td>
			</tr>
		</table>
		<div class="btn hidden">
			<input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
			<input type="reset" value="取消" class="button" />
		</div>
	</form>
<include file="Public:footer"/>