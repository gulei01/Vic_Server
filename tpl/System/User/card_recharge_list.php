$
		<div class="mainbox">
			<div id="nav" class="mainnav_title">
				<ul>
					<a href="{pigcms{:U('User/card_recharge_list')}" class="on">商家下线充值订单列表</a>
					<a href="{pigcms{:U('User/online_recharge_list')}" >用户线上充值订单列表</a>
					
				</ul>
			</div>
			<table class="search_table" width="100%">
				<tr>
					<td>
						<form action="{pigcms{:U('card_recharge_list')}" method="get">
							<input type="hidden" name="c" value="User"/>
							<input type="hidden" name="a" value="card_recharge_list"/>
							筛选: <input type="text" name="keyword" class="input-text" value="{pigcms{$_GET['keyword']}"/>
							<select name="searchtype">
								<option value="id" <if condition="$_GET['searchtype'] eq 'id'">selected="selected"</if>>订单id</option>
								<option value="card_id" <if condition="$_GET['searchtype'] eq 'card_id'">selected="selected"</if>>卡号</option>
								<option value="m_name" <if condition="$_GET['searchtype'] eq 'm_name'">selected="selected"</if>>商家名称</option>
								<option value="name" <if condition="$_GET['searchtype'] eq 'name'">selected="selected"</if>>客户名称</option>
								<option value="phone" <if condition="$_GET['searchtype'] eq 'phone'">selected="selected"</if>>客户电话</option>
							</select>
							<font color="#000">日期筛选：</font>
							<input type="text" class="input-text" name="begin_time" style="width:120px;" id="d4311"  value="{pigcms{$_GET.begin_time}" onfocus="WdatePicker({readOnly:true,dateFmt:'yyyy-MM-dd'})"/>			   
							<input type="text" class="input-text" name="end_time" style="width:120px;" id="d4311" value="{pigcms{$_GET.end_time}" onfocus="WdatePicker({readOnly:true,dateFmt:'yyyy-MM-dd'})"/>
							
							<input type="submit" value="查询" class="button"/>　　
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
								<th>会员卡号</th>
								<th>金额</th>
								<th>{pigcms{$config['score_name']}</th>
								<th>描述</th>
								<th>充值时间</th>
								<th>商家名称</th>
								<th>订单用户</th>
								<th>查看用户信息</th>
								<th>订单手机</th>
							
							</tr>
						</thead>
						<tbody>
							<if condition="is_array($list)">
								<volist name="list" id="vo">
									<tr>
										<td>{pigcms{$vo.id}</td>
										<td>{pigcms{$vo.cardid}</td>
										<td><if condition="$vo.card_money_give gt 0">${pigcms{$vo.card_money_give}<else />0</if></td>
										<td>{pigcms{$vo.score_add}</td>
										<td>{pigcms{$vo.desc}</td>
										<td>{pigcms{$vo['time']|date='Y-m-d H:i:s',###}</td>

										<td>{pigcms{$vo.name}</td>
										<td>{pigcms{$vo.nickname}</td>
										<td>
											<a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('User/edit',array('uid'=>$vo['uid']))}','编辑用户信息',680,560,true,false,false,editbtn,'edit',true);">查看用户信息</a>
										</td>
										<td>{pigcms{$vo.phone}</td>
									
										
									</tr>
								</volist>
								<tr><td class="textcenter pagebar" colspan="6">{pigcms{$pagebar}</td></tr>
							<else/>
								<tr><td class="textcenter red" colspan="6">列表为空！</td></tr>
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