$
		<div class="mainbox">
			<div id="nav" class="mainnav_title">
				<ul>
					<a href="{pigcms{:U('Store/buy_order')}" class="on">{pigcms{$config.cash_alias_name}订单列表</a>
				</ul>
			</div>
			<form name="myform" id="myform" action="" method="post">
				<div class="table-list">
					<table width="100%" cellspacing="0">
						<colgroup>
							<col/>
							<col/>
							<col/>
							<col/>
							<col/>
							<col width="180" align="center"/>
						</colgroup>
						<thead>
							<tr>
								<th>订单编号</th>
								<th>商家名称</th>
								<th>店铺名称</th>
								<th>下单人</th>
								<th>电话</th>
								<th>订单金额</th>
								<th>优惠金额</th>
								<th>获得{pigcms{$config.score_name}数</th>
								<th>使用{pigcms{$config.score_name}数</th>
								<th>实付金额</th>
								<th>支付时间</th>
								<th>支付类型</th>
							</tr>
						</thead>
						<tbody>
							<if condition="is_array($order_list)">
								<volist name="order_list" id="vo">
									<tr>
										<td>{pigcms{$vo.order_id}</td>
										<td>{pigcms{$vo.merchant_name}</td>
										<td>{pigcms{$vo.store_name}</td>
										<td>{pigcms{$vo.nickname}</td>
										<td>{pigcms{$vo.phone}</td>
										<td>${pigcms{$vo['total_price']|floatval}</td>
										<td>${pigcms{$vo.discount_price|floatval}</td>
										<td>{pigcms{$vo.score_give|floatval}</td>
										<td>{pigcms{$vo.score_used_count|floatval}</td>
										<td>${pigcms{$vo.price|floatval}</td>
										<td>{pigcms{$vo['pay_time']|date="Y-m-d H:i:s",###}</td>
										<td>{pigcms{$vo.pay_type_show}</td>
									</tr>
								</volist>
								<tr><td class="textcenter pagebar" colspan="14">{pigcms{$pagebar}</td></tr>
							<else/>
								<tr><td class="textcenter red" colspan="14">列表为空！</td></tr>
							</if>
						</tbody>
					</table>
				</div>
			</form>
		</div>
<script>
$(function(){
	$('#status').change(function(){
		location.href = "{pigcms{:U('Shop/order', array('type' => $type, 'sort' => $sort))}&status=" + $(this).val();
	});	
});


</script>
<include file="Public:footer"/>