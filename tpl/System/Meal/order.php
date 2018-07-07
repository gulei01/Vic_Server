$
		<div class="mainbox">
			<div id="nav" class="mainnav_title">
				<ul>
					<a href="{pigcms{:U('Meal/order')}" class="on">订单列表</a>
				</ul>
			</div>
			<table class="search_table" width="100%">
				<tr>
					<td>
						<form action="{pigcms{:U('Meal/order')}" method="get">
							<input type="hidden" name="c" value="Meal"/>
							<input type="hidden" name="a" value="order"/>
							
							
							筛选: <input type="text" name="keyword" class="input-text" value="{pigcms{$_GET['keyword']}"/>
							<select name="searchtype">
								<option value="orderid" <if condition="$_GET['searchtype'] eq 'orderid'">selected="selected"</if>>订单流水号</option>
								<option value="s_name" <if condition="$_GET['searchtype'] eq 's_name'">selected="selected"</if>>店铺名称</option>
								<option value="name" <if condition="$_GET['searchtype'] eq 'name'">selected="selected"</if>>客户名称</option>
								<option value="phone" <if condition="$_GET['searchtype'] eq 'phone'">selected="selected"</if>>客户电话</option>
							</select>
							<input type="submit" value="查询" class="button"/>　　
							订单状态筛选: 
							<select id="status" name="status">
								<volist name="status_list" id="vo">
									<option value="{pigcms{$key}" <if condition="$key eq $status">selected="selected"</if>>{pigcms{$vo}</option>
								</volist>
							</select>
							
							<input type="submit" value="查询" class="button"/>　
						</form>
					</td>
							
				</tr>
			</table>
			<form name="myform" id="myform" action="" method="post">
				<div class="table-list">
					<table width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>订单流水号</th>
								<th>商家名称</th>
								<th>店铺名称</th>
								<th>{pigcms{$config.meal_alias_name}人</th>
								<th>电话</th>
								
								<th>实际总价</th>
								<th>优惠金额</th>
								<th>
								<if condition="$type eq 'price'">
									<if condition="$sort eq 'ASC'">
										<a href="{pigcms{:U('Meal/order', array('type' => 'price', 'sort' => 'DESC', 'status' => $status))}" style="color:blue;">应付总价↓ </a>
									<elseif condition="$sort eq 'DESC'" />
										<a href="{pigcms{:U('Meal/order', array('type' => 'price', 'sort' => 'ASC', 'status' => $status))}" style="color:blue;">应付总价↑</a>
									<else />
										<a href="{pigcms{:U('Meal/order', array('type' => 'price', 'sort' => 'DESC', 'status' => $status))}" style="color:blue;">应付总价<i class="menu-icon fa fa-sort"></i></a>
									</if>
								<else />
									<a href="{pigcms{:U('Meal/order', array('type' => 'price', 'sort' => 'DESC', 'status' => $status))}" style="color:blue;">应付总价<i class="menu-icon fa fa-sort"></i></a>
								</if>
								</th>
								<!--th>平台余额支付金额</th>
								<th>商家会员卡余额支付金额</th>
								<th>在线支付金额</th>
								<th>平台优惠券金额</th>
								<th>商户优惠券金额</th>
								<th>{pigcms{$config['score_name']}抵扣金额</th>
								<th>店员需收现</th-->
								<th>下单时间</th>
								<th>
								<if condition="$type eq 'pay_time'">
									<if condition="$sort eq 'ASC'">
										<a href="{pigcms{:U('Meal/order', array('type' => 'pay_time', 'sort' => 'DESC', 'status' => $status))}" style="color:blue;">支付时间↓</a>
									<elseif condition="$sort eq 'DESC'" />
										<a href="{pigcms{:U('Meal/order', array('type' => 'pay_time', 'sort' => 'ASC', 'status' => $status))}" style="color:blue;">支付时间↑</a>
									<else />
										<a href="{pigcms{:U('Meal/order', array('type' => 'pay_time', 'sort' => 'DESC', 'status' => $status))}" style="color:blue;">支付时间</a>
									</if>
								<else />
									<a href="{pigcms{:U('Meal/order', array('type' => 'pay_time', 'sort' => 'DESC', 'status' => $status))}" style="color:blue;">支付时间</a>
								</if>
								</th>
								<th>订单状态</th>
								<th>支付状态</th>
								<th class="textcenter">操作</th>
							</tr>
						</thead>
						<tbody>
							<if condition="is_array($order_list)">
								<volist name="order_list" id="vo">
									<tr>
										<td>{pigcms{$vo.order_id}</td>
										<td>{pigcms{$vo.merchant_name}</td>
										<td>{pigcms{$vo.store_name}</td>
										<td>{pigcms{$vo.name}</td>
										<td>{pigcms{$vo.phone}</td>
										
										
										<td><if condition="$vo['total_price'] gt 0">{pigcms{$vo['total_price']|floatval}<else />{pigcms{$vo.price|floatval}</if></td>
										<td>{pigcms{$vo.minus_price|floatval}</td>
										<td>{pigcms{$vo['price']|floatval}</td>
										<!--td>{pigcms{$vo['balance_pay']|floatval}</td>
										<td>{pigcms{$vo['merchant_balance']|floatval}</td>
										<td>{pigcms{$vo['payment_money']|floatval}</td>
										<td>{pigcms{$vo['coupon_price']|floatval}</td>
										<td>{pigcms{$vo['card_price']|floatval}</td>
										<td>{pigcms{$vo['score_deducte']|floatval}</td>
										<td><strong style="color: red">{pigcms{$vo['offline_money']|floatval}</strong></td-->
										<td>{pigcms{$vo.dateline|date="Y-m-d H:i:s",###}</td>
										<td><if condition="$vo['pay_time']">{pigcms{$vo['pay_time']|date="Y-m-d H:i:s",###}</if></td>
										<td>
										<if condition="$vo['status'] eq 0"><span style="color:red">未使用</span>
										<elseif condition="$vo['status'] eq 1" /><span style="color:green">已使用</span>
										<elseif condition="$vo['status'] eq 2" /><span style="color:green">已评价</span>
										<elseif condition="$vo['status'] eq 3" /><span style="color:red"><del>已退款</del></span>
										<elseif condition="$vo['status'] eq 4" /><span style="color:red"><del>已取消</del></span>
										</if>
										</td>
										<td>
										<if condition="$vo['paid'] eq 0">
										<span style="color:red">未支付</span>
										<elseif condition="$vo['pay_type'] eq 'offline' AND empty($vo['third_id'])" />
										<span style="color:red">线下未付款</span>
										<elseif condition="$vo['paid'] eq 2"  />
										<span style="color:green">已付${pigcms{$vo['pay_money']}</span>，<span style="color:red">未付${pigcms{$vo['price'] - $vo['pay_money']}</span>
										<else />
										<span style="color:green">已支付</span>
										</if>
										</td>
										<td class="textcenter">
											<a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Meal/order_detail',array('order_id'=>$vo['order_id'],'frame_show'=>true))}','查看{pigcms{$config.meal_alias_name}订单详情',480,380,true,false,false,false,'detail',true);">查看</a>
									  	</td>
									</tr>
								</volist>
								<tr><td class="textcenter pagebar" colspan="19">{pigcms{$pagebar}</td></tr>
							<else/>
								<tr><td class="textcenter red" colspan="19">列表为空！</td></tr>
							</if>
						</tbody>
					</table>
				</div>
			</form>
		</div>
<script>
$(function(){
	$('#status').change(function(){
		location.href = "{pigcms{:U('Meal/order', array('type' => $type, 'sort' => $sort))}&status=" + $(this).val();
	});	
	
});
</script>
<include file="Public:footer"/>