<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
	<title>Server Center</title>
    <meta name="viewport" content="initial-scale=1, width=device-width, maximum-scale=1, user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name='apple-touch-fullscreen' content='yes'>
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="format-detection" content="telephone=no">
	<meta name="format-detection" content="address=no">
    <link href="{pigcms{$static_path}css/eve.7c92a906.css" rel="stylesheet"/>
    <link href="{pigcms{$static_path}css/wap_pay_check.css" rel="stylesheet"/>
	<style>
    .btn-wrapper {
        margin: .28rem .2rem;
    }
    .hotel-price {
        color: #ff8c00;
        font-size: 12px;
        display: block;
    }
    .dealcard .line-right {
        display: none;
    }
    .agreement li {
        display: inline-block;
        width: 50%;
        box-sizing: border-box;
        color: #666;
    }

    .agreement li:nth-child(2n) {
        padding-left: .14rem;
    }

    .agreement li:nth-child(1n) {
        padding-right: .14rem;
    }

    .agreement ul.agree li {
        height: .32rem;
        line-height: .32rem;
    }

    .agreement ul.btn-line li {
        vertical-align: middle;
        margin-top: .06rem;
        margin-bottom: 0;
    }

    .agreement .text-icon {
        margin-right: .14rem;
        vertical-align: top;
        height: 100%;
    }

    .agreement .agree .text-icon {
        font-size: .4rem;
        margin-right: .2rem;
    }


    #deal-details .detail-title {
        background-color: #F8F9FA;
        padding: .2rem;
        font-size: .3rem;
        color: #000;
        border-bottom: 1px solid #ccc;
    }

    #deal-details .detail-title p {
        text-align: center;
    }

    #deal-details .detail-group {
        font-size: .3rem;
        display: -webkit-box;
        display: -ms-flexbox;
    }

    .detail-group .left {
        -webkit-box-flex: 1;
        -ms-flex: 1;
        display: block;
        padding: .28rem 0;
        padding-right: .2rem;
    }

    .detail-group .right {
        display: -webkit-box;
        display: -ms-flexbox;
        -webkit-box-align: center;
        -ms-box-align: center;
        width: 1.2rem;
        padding: .28rem .2rem;
        border-left: 1px solid #ccc;
    }

    .detail-group .middle {
        display: -webkit-box;
        display: -ms-flexbox;
        -webkit-box-align: center;
        -ms-box-align: center;
        width: 1.7rem;
        padding: .28rem .2rem;
        border-left: 1px solid #ccc;
    }

    ul.ul {
        list-style-type: initial;
        padding-left: .4rem;
        margin: .2rem 0;
    }

    ul.ul li {
        font-size: .3rem;
        margin: .1rem 0;
        line-height: 1.5;
    }
    .coupons small{
        float: right;
        font-size: .28rem;
    }
    strong {
        color: #FDB338;
    }
    .coupons-code {
        color: #666;
        text-indent: .2rem;
    }
    .voice-info {
        font-size: .3rem;
        color: #eb8706;
    }
</style>
</head>
<body id="index" data-com="pagecommon">
        <div id="tips" class="tips"></div>
        <div class="wrapper-list" style="padding-bottom: 10px;">
			<h4 style="margin-top:.3rem;">{pigcms{$now_order.s_name} </h4>
			<a class="btn" style="float:right;margin-right: 12px;margin-right: 15px;top:-.7rem;;position: relative;" href="{pigcms{:U('Storestaff/group_list')}">back</a>
			<if condition="$now_order['is_pick_in_store'] AND $now_order['status'] eq 0"><a class="btn" style="float:right;margin-right: 12px;margin-right: 15px;top:-.7rem;;position: relative;background-color:#0C8642;" href="javascript:void(0);" onclick="pick_click();">Picked up</a></if>

			<dl class="list coupons">
				<dd style="overflow:visible;">
					<dl>
						<dt style="overflow:visible;">order details</dt>
						<dd class="dd-padding coupons-code">
							order number: <span>{pigcms{$now_order.real_orderid}</span>
						</dd>
						<if condition="$now_order.orderid neq 0">
						<dd class="dd-padding coupons-code">
							serial number: <span>{pigcms{$now_order.orderid}</span>
						</dd>
						</if>
						<dd class="dd-padding coupons-code">
							{pigcms{$config.group_alias_name}item: <span><a href="{pigcms{:U('Group/detail',array('group_id'=>$now_order['group_id']))}" target="_blank">{pigcms{$now_order.s_name}</a></span>
						</dd>
						<dd class="dd-padding coupons-code">
							order type: <span><if condition="$now_order['tuan_type'] eq '0'">{pigcms{$config.group_alias_name}Voucher<elseif condition="$now_order['tuan_type'] eq '1'"/>vouchers<else/>goods</if></span>
						</dd>
						<dd class="dd-padding coupons-code">
							order status: <span>
							<if condition="$now_order['status'] eq 3">
								<font color="red">cancelled</font>
							<elseif condition="$now_order['paid'] eq '1'" />
								<if condition="$now_order['third_id'] eq '0' AND $now_order['pay_type'] eq 'offline' AND $now_order['status'] eq '0'">
									<font color="red">Unpaid</font>
								<elseif condition="$now_order['status'] eq '0'"/>
									<font color="green">paid</font>&nbsp;
									<if condition="$now_order['tuan_type'] neq '2'">
									<php>if($now_order['tuan_type'] != 2){</php>
										<font color="red">Not consumed</font>
									<php>}else{</php>
										
										<php>if($now_order['is_pick_in_store']){</php>
											<font color="red">Not picking up</font>
										<php>}else{</php>
											<font color="red">Not shipped</font>
										<php>}</php>
									<php>}</php>
								<elseif condition="$now_order['status'] eq '1'"/>
									<php>if($now_order['tuan_type'] != 2){</php>
										<font color="green">consumed</font>
									<php>}else{</php>
										<php>if($now_order['is_pick_in_store']){</php>
											<font color="green">picked up</font>
										<php>}else{</php>
											<font color="green">Shipped</font>
										<php>}</php>
									<php>}</php>&nbsp;
									<font color="red">To be evaluated</font>
								<else/>
									<font color="green">completed</font>
								</if>
							<else/>
								<font color="red">Unpaid</font>
							</if>

							</span>
						</dd>
						<if condition="$now_order['pass_array']">
							<dd class="dd-padding coupons-code">
								operating:<span><a  href="{pigcms{:U('Storestaff/group_pass_array',array('order_id'=>$now_order['order_id']))}" class="group_verify_btn">View the details of the consumer code</a></span>
							</dd>
						<else />
							<dd class="dd-padding coupons-code">
								operating:<span><a  href="{pigcms{:U('Storestaff/group_verify',array('order_id'=>$now_order['order_id']))}" class="group_verify_btn">Verify consumption</a></span>
							</dd>
						</if>
						<dd class="dd-padding coupons-code">
							qty.: <span>{pigcms{$now_order.num}</span>
						</dd>
						<dd class="dd-padding coupons-code">
							price: <span>{pigcms{$now_order.price}CAD<if condition="$config.open_extra_price eq 1 AND $vo.extra_price gt 0">+{pigcms{$now_order.extra_price}{pigcms{$config.extra_price_alias_name}</if></span>
						</dd>
						<dd class="dd-padding coupons-code">
							order time: <span>{pigcms{$now_order.add_time|date='Y-m-d H:i',###}</span>
						</dd>
						<dd class="dd-padding coupons-code">
							payment time:<span>{pigcms{$now_order.pay_time|date='Y-m-d H:i:s',###}</span>
						</dd>
						<if condition="$now_order['status'] gt 0 && $now_order['status'] lt 3">
							<dd class="dd-padding coupons-code">
								<if condition="$now_order['tuan_type'] neq 2">consumption<else/>Ship</if> time: <span>{pigcms{$now_order.use_time|date='Y-m-d H:i:s',###}</span>
							</dd>
						 <dd class="dd-padding coupons-code">Operating clerk:{pigcms{$now_order.last_staff}
						</dd>
						</if>
						<dd class="dd-padding coupons-code">
						payment type:<span>{pigcms{$now_order.paytypestr}</span>
					    </dd>
					    <if condition="$now_order['third_id'] eq '0' AND $now_order['pay_type'] eq 'offline'">
							 <dd class="dd-padding coupons-code">total amount: ${pigcms{$now_order['total_money']} </dd>
							 <dd class="dd-padding coupons-code">Platform balance payment:{pigcms{$now_order.balance_pay}  </dd>
							 <dd class="dd-padding coupons-code">Merchant membership card balance payment:{pigcms{$now_order.merchant_balance} </dd>
							 <if condition="$now_order['wx_cheap'] neq '0.00'"><dd class="dd-padding coupons-code">	WeChat offer:${pigcms{$now_order['wx_cheap']} </dd></if>
							 <dd class="dd-padding coupons-code">Line to the business to pay the amount:<font color="red">${pigcms{$now_order['total_money']-$now_order['wx_cheap']-$now_order['merchant_balance']-$now_order['balance_pay']-$now_order['score_deducte']-$now_order['coupon_price']}CAD</font>
						<else/>
							 <dd class="dd-padding coupons-code">Platform Balance Payment:{pigcms{$now_order.balance_pay} </dd>
							 <dd class="dd-padding coupons-code">Merchant membership card balance payment:{pigcms{$now_order.merchant_balance} </dd>
							 <dd class="dd-padding coupons-code">Online payment amount{pigcms{$now_order.payment_money} </dd>
						</if>

						<dd class="dd-padding coupons-code">
							Buyer message: <span style="color:red"><b>{pigcms{$now_order.delivery_comment}</b</span>
						</dd>
					</dl>
				</dd>
			</dl>
			<if condition="$now_order['paid'] eq '1'">
				<dl class="list coupons">
					<dd>
						<dl>
							<dt>User Info</dt>
							<dd class="dd-padding coupons-code">
								User ID: <span>{pigcms{$now_order.uid}</span>
							</dd>
							<dd class="dd-padding coupons-code">
								User name: <span>{pigcms{$now_order.nickname}</span>
							</dd>
							<dd class="dd-padding coupons-code">
								Order phone number: <span><a href="tel:{pigcms{$now_order.phone}" style="color:blue;">{pigcms{$now_order.phone}</a></span>
							</dd>
							<dd class="dd-padding coupons-code">
								User phone number:<span><a href="tel:{pigcms{$now_order.user_phone}" style="color:blue;">{pigcms{$now_order.user_phone}</a></span>
							</dd>
						</dl>
					</dd>
				</dl>
				<if condition="$now_order['tuan_type'] eq 2">
				<dl class="list">
					<dd>
						<dl>
							<dt><?php if(!$now_order['is_pick_in_store']){?>Distribution information<?php }else{?>Self-access information<?php } ?></dt>
							<?php if(!$now_order['is_pick_in_store']){?>
							<dd class="dd-padding coupons-code">
								Receiver:<span>{pigcms{$now_order.contact_name}</span>
							</dd>
							<dd class="dd-padding coupons-code">
								phone number:<span>{pigcms{$now_order.phone}</span>
							</dd>
							<dd class="dd-padding coupons-code">
								Delivery requirements:<span><switch name="now_order['delivery_type']">
								<case value="1">Weekdays and holidays can be delivered</case>
								<case value="2">Workday delivery only</case>
								<case value="3">Only weekend, holiday delivery</case>
								<case value="4">No one during the day, other time delivery</case>
							</switch></span>
							</dd>
							<dd class="dd-padding coupons-code">
								Zip:<span>{pigcms{$now_order.zipcode}</span>
							</dd>
							<?php }?>
							<dd class="dd-padding coupons-code">
								<?php if(!$now_order['is_pick_in_store']){?>Shipping address:<?php }else{?>Pick up address:<?php } ?><span>{pigcms{$now_order.adress}</span>
							</dd>
							<?php if($now_order['paid'] == 1): ?>
							<?php if(!$now_order['is_pick_in_store']){?>
							<dd class="dd-padding coupons-code">
							<p style="margin-left: -9px;margin-bottom: 10px;font-size: 15px;color: #333;">Express information:</p>
							<select id="express_type"><volist name="express_list" id="vo"><option value="{pigcms{$vo.id}">{pigcms{$vo.name}</option></volist></select>&nbsp; <input type="text" class="input" id="express_id" value="{pigcms{$now_order.express_id}" style="width:45%;height: 25px;"/> <button id="express_id_btn" class="btn">fill in</button>
							</dd>
							<?php }?>
							<?php endif; ?>
						</dl>
					</dd>
				</dl>
				</if>
				<if condition="$now_order['paid'] eq '1'">
					<dl class="list coupons">
						<dd>
							<dl>
								<dt>extra information</dt>
								<dd class="dd-padding coupons-code">
								 mark: <span><input type="text" class="input" id="merchant_remark" value="{pigcms{$now_order.merchant_remark}" style="width:45%;height: 25px;"/>&nbsp;&nbsp;<button id="merchant_remark_btn" class="btn">modify</button></span>
								</dd>
							</dl>
						</dd>
					</dl>
				</if>
			</if>
		</div>
    	<script src="{pigcms{:C('JQUERY_FILE')}"></script>
		<!---<include file="Storestaff:footer"/>--->
		<script type="text/javascript">
			$(function(){
				<if condition="$now_order['paid'] eq 1 && $now_order['status'] eq 0">var fahuo=1;<else/>var fahuo=0;</if>
				$('#express_id_btn').click(function(){
					if(fahuo == 1){
						if(confirm("Are you sure you want to submit courier information? The order status will be modified to be shipped.")){
							express_post();
						}
					}else{
						express_post();
					}
				});
				$('#merchant_remark_btn').click(function(){
					$(this).prop('disabled',true);
					$.post("{pigcms{:U('Storestaff/group_remark',array('order_id'=>$now_order['order_id']))}",{merchant_remark:$('#merchant_remark').val()},function(result){
						if(result.status == 0){
							$('#merchant_remark_btn').prop('disabled',false);
							alert(result.info);
						}else{
							window.location.href = window.location.href;
						}
					});
				});
				function express_post(){
					$('#express_id_btn').prop('disabled',true);
					$.post("{pigcms{:U('Storestaff/group_express',array('order_id'=>$now_order['order_id']))}",{express_type:$('#express_type').val(),express_id:$('#express_id').val()},function(result){
						if(result.status == 1){
							fahuo=0;
							window.location.href = window.location.href;
						}else{
							$('#express_id_btn').prop('disabled',false);
							alert(result.info);
						}
					});
				}
			});
			
			function pick_click(){
				if(confirm("Are you sure that the user has already picked up the store? Please ensure that the user information, payment information is correct, after the order status will be modified to have been self-made.")){	
					$.post("{pigcms{:U('Storestaff/group_pick',array('order_id'=>$now_order['order_id']))}",'',function(result){
						if(result.status == 1){
							alert(result.info);
							window.location.href = window.location.href;
						}else{
							alert(result.info);
						}
					});
				}
			}
		</script>
</body>
</html>