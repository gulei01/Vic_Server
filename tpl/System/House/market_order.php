$
		<div class="mainbox">
			<div class="widget-header">
				<div class="mainnav_title">
					<form method="post" action="{pigcms{:U('House/market_order', array('village_id' => $village_id))}" >
					<font color="#000">时间段：</font>
					<input type="text" class="input-text" name="begin_time" style="width:120px;" id="d4311"  value="{pigcms{$begin_time}" onfocus="WdatePicker({isShowClear:false,readOnly:true,dateFmt:'yyyy-MM-dd'})"/>至
					<input type="text" class="input-text" name="end_time" style="width:120px;" id="d4311" value="{pigcms{$end_time}" onfocus="WdatePicker({isShowClear:false,readOnly:true,dateFmt:'yyyy-MM-dd'})"/>
					<input type="submit" value="提交" class="button">
					<input type="button" value="导出EXCEL" class="button" onclick="location.href='{pigcms{:U('market_export',$_REQUEST)}'"/>
					</form>
				</div>
			</div>
			<form name="myform" id="myform" action="" method="post">
				<div class="table-list">
					<table width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>订单编号</th>
								<th>下单人</th>
								<th>电话</th>
								<th>支付时间</th>
								<th>总价</th>
								<th>订单状态</th>
								<th>支付情况</th>
								<th class="textcenter">操作</th>
							</tr>
						</thead>
						<tbody>
							<php>$total_price = 0;</php>
							<if condition="is_array($order_list)">
								<volist name="order_list" id="vo">
									<php>$total_price += $vo['price'];</php>
									<tr>
										<td>{pigcms{$vo.real_orderid}</td>
										<td>{pigcms{$vo.username}</td>
										<td>{pigcms{$vo.userphone}</td>
										<td>{pigcms{$vo.pay_time|date="Y-m-d H:i:s",###}</td>
										<td>${pigcms{$vo.price|floatval}</td>
										<td>{pigcms{$vo.status_str}</td>
										<td><!-- {pigcms{$vo.pay_status} --><span style="color: green">{pigcms{$vo.pay_type_str}</span></td>
										<td class="textcenter">
											<a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Shop/order_detail',array('order_id'=>$vo['order_id'],'frame_show'=>true))}','查看{pigcms{$config.shop_alias_name}订单详情',720,520,true,false,false,false,'detail',true);">查看</a>
									  	</td>
									</tr>
								</volist>
								<tr><td colspan="8" class="red">本页总金额：${pigcms{$total_price} 元</td></tr>
									
								<tr><td class="textcenter pagebar" colspan="8">{pigcms{$pagebar}</td></tr>
							<else/>
								<tr><td class="textcenter red" colspan="8">列表为空！</td></tr>
							</if>
						</tbody>
					</table>
				</div>
			</form>
		</div>
<include file="Public:footer"/>