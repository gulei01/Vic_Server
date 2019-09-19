<include file="Public:header"/>
		<div class="mainbox">
			<div id="nav" class="mainnav_title">
				<ul>
					<a href="{pigcms{:U('User/recharge_list')}" >订单列表</a>
					<a href="{pigcms{:U('User/admin_recharge_list')}" class="on">管理员充值列表</a>
				</ul>
			</div>
			<table class="search_table" width="100%">
				<tr>
					<td>
						<form action="{pigcms{:U('admin_recharge_list')}" method="get">
							<input type="hidden" name="c" value="User"/>
							<input type="hidden" name="a" value="admin_recharge_list"/>
							管理员筛选: 
							<select name="admin_id">
								<option value="0">所有管理员</option>
								<volist name="admin_list" id="vo">
									<option value="{pigcms{$vo.id}">{pigcms{$vo.realname}</option>
								</volist>
							</select>
							<font color="#000">日期筛选：</font>
							<input type="text" class="input-text" name="begin_time" style="width:120px;" id="d4311"  value="{pigcms{$_GET.begin_time}" onfocus="WdatePicker({readOnly:true,dateFmt:'yyyy-MM-dd'})"/>			   
							<input type="text" class="input-text" name="end_time" style="width:120px;" id="d4311" value="{pigcms{$_GET.end_time}" onfocus="WdatePicker({readOnly:true,dateFmt:'yyyy-MM-dd'})"/>
							<input type="submit" value="查询" class="button"/>　　

							<!--支付状态：
							<select name="status" id="status">
								<option value="-1" <if condition="$_GET['status'] eq -1">selected="selected"</if>>全部</option>
								<option value="1" <if condition="$_GET['status'] eq 1">selected="selected"</if>>已支付</option>
								<option value="0" <if condition="$_GET['status'] eq 0">selected="selected"</if>>未支付</option>
							</select>-->
						</form>
					</td>
				</tr>
			</table>

			<form name="myform" id="myform" action="" method="post">
				<div class="table-list">
					<style>
					.table-list td{line-height:22px;padding-top:5px;padding-bottom:5px;}
					</style>
					<table width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>订单编号</th>
								<th>订单信息</th>
								<th>订单用户</th>
								<th>操作管理员</th>
								<th>查看用户信息</th>
								<th>时间</th>
								<th class="textcenter">操作</th>
							</tr>
						</thead>
						<tbody>
							<if condition="is_array($recharge_list)">
								<volist name="recharge_list" id="vo">
									<tr>
										<td>{pigcms{$vo.pigcms_id}</td>
										<td><if condition="$vo.type eq 1">充值<else />减少</if>：${pigcms{$vo.money}</td>

										<td><if condition="$vo.nickname">{pigcms{$vo.nickname}<else />{pigcms{$vo.phone}</if></td>
										<td>{pigcms{$vo.realname}</td>
										<td>
											<a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('User/edit',array('uid'=>$vo['uid']))}','编辑用户信息',680,560,true,false,false,editbtn,'edit',true);">查看用户信息</a>
										</td>
										<td>
											{pigcms{$vo['time']|date='Y-m-d H:i:s',###}<br/>
											
										</td>
										<td class="textcenter">{pigcms{$vo.desc}</td>
									</tr>
								</volist>
								<tr><td class="textcenter pagebar" colspan="7">{pigcms{$pagebar}</td></tr>
							<else/>
								<tr><td class="textcenter red" colspan="7">列表为空！</td></tr>
							</if>
						</tbody>
					</table>
				</div>
			</form>
		</div>
<script>
$(function(){
	$('#status').change(function(){
		location.href = "{pigcms{:U('User/recharge_list')}&status=" + $(this).val();
	});
});

</script>
<include file="Public:footer"/>