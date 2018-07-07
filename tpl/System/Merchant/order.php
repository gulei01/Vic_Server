$

		<div class="mainbox">
			<div id="nav" class="mainnav_title">
				<ul>
					<a href="{pigcms{:U('Merchant/index')}">商户列表</a>
					<a href="{pigcms{:U('Merchant/order',array('mer_id'=>$mer_id, 'type' => 'meal'))}" <if condition="$type eq 'meal'">class="on"</if>>{pigcms{$config.meal_alias_name}账单</a>
					<a href="{pigcms{:U('Merchant/order',array('mer_id'=>$mer_id, 'type' => 'group'))}" <if condition="$type eq 'group'">class="on"</if>>{pigcms{$config.group_alias_name}账单</a>
					<if condition="$config['is_open_weidian']">
						<a href="{pigcms{:U('Merchant/order',array('mer_id'=>$mer_id, 'type' => 'weidian'))}" <if condition="$type eq 'weidian'">class="on"</if>>微店账单</a>
					</if>
					<if condition="$config['appoint_page_row'] gt 0">
					<a href="{pigcms{:U('Merchant/order',array('mer_id'=>$mer_id, 'type' => 'appoint'))}" <if condition="$type eq 'appoint'">class="on"</if>>{pigcms{$config.appoint_alias_name}账单</a>
					</if>
					<if condition="$config['wxapp_url']">
						<a href="{pigcms{:U('Merchant/order',array('mer_id'=>$mer_id, 'type' => 'wxapp'))}" <if condition="$type eq 'wxapp'">class="on"</if>>营销账单</a>
					</if>
					<if condition="$config['is_cashier'] OR $config['pay_in_store']">
					<a href="{pigcms{:U('Merchant/order',array('mer_id'=>$mer_id, 'type' => 'store'))}" <if condition="$type eq 'store'">class="on"</if>>到店付账单</a>
					</if>
					<if condition="$config['waimai_alias_name']">
						<a href="{pigcms{:U('Merchant/order',array('mer_id'=>$mer_id, 'type' => 'waimai'))}" <if condition="$type eq 'waimai'">class="on"</if>>{pigcms{$config.waimai_alias_name}账单</a>
					</if>
					<a href="{pigcms{:U('Merchant/order',array('mer_id'=>$mer_id, 'type' => 'shop'))}" <if condition="$type eq 'shop'">class="on"</if>>{pigcms{$config.shop_alias_name}账单</a>
				</ul>
			</div>
			<div style="margin:15px 0;">
				<b>商家ID：</b>{pigcms{$now_merchant.mer_id}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>商家名称：</b>{pigcms{$now_merchant.name}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>联系电话：</b>{pigcms{$now_merchant.phone}<br/><br/>
			</div>
			<notempty name="start_year">
                        <div class="widget-header">
                            <div class="year"></div>
                            <div class="month"></div>
						
                        
                        <!--时间筛选-->
						<div class="mainnav_title">
                        <form  method="get" action="{pigcms{:U('Merchant/order')}" >
                            <input type="hidden" name="c" value="Merchant">
                            <input type="hidden" name="a" value="order">
                            <input type="hidden" name="mer_id" value="{pigcms{$mer_id}">
                            <input type="hidden" name="type" value="{pigcms{$type}">
                            <font color="#000">时间段：</font>
                            <input type="text" class="input-text" name="begin_time" style="width:120px;" id="d4311"  value="{pigcms{$_GET['begin_time']}" onfocus="WdatePicker({isShowClear:false,readOnly:true,dateFmt:'yyyy-MM-dd'})"/>
                           
                            <input type="text" class="input-text" name="end_time" style="width:120px;" id="d4311" value="{pigcms{$_GET['end_time']}" onfocus="WdatePicker({isShowClear:false,readOnly:true,dateFmt:'yyyy-MM-dd'})"/>
                            <input type="submit" value="提交" class="button">
                        </form>
						</div>
						</div>
			</notempty>
			<div class="mainnav_title">
			<form action="{pigcms{:U('Merchant/order')}" method="get">
				<input type="hidden" name="c" value="Merchant"/>
				<input type="hidden" name="a" value="order"/>
				<input type="hidden" name="mer_id" value="{pigcms{$mer_id}"/>
				<input type="hidden" name="type" value="{pigcms{$type}"/>
				<font color="#000">筛选：&nbsp;&nbsp;&nbsp;</font> <!--<input type="text" name="keyword" class="input-text" value="{pigcms{$_GET['keyword']}"/>-->
				<select name="is_pay_bill">
					<option value="1" <if condition="$_GET['is_pay_bill'] eq '1'">selected="selected"</if>>已对账</option>
					<option value="2" <if condition="$_GET['is_pay_bill'] eq '2'">selected="selected"</if>>未对账</option>
					<!--<option value="status" <if condition="$_GET['searchtype'] eq 'status'">selected="selected"</if>>状态</option>--->
				</select>
				<input type="submit" value="查询" class="button"/>
			</form>
			</div>
			<table class="search_table" width="100%">
				<tr>
					<td class="mainnav_title">
						<input type="button" value="确认对账" class="button" style="margin-left: -4px;">
						<a href="{pigcms{:U('Merchant/export',array('mer_id'=>$mer_id, 'type' => $type))}" class="on">导出未对账的账单</a>
						<span style="color:#000;">未对账订单数量：<font color="red">{pigcms{$un_bill_count}</font></span>
					</td>
				</tr>
			</table>
			<form name="myform" id="myform" action="{pigcms{:U(\'Merchant/companypay\')}" method="post" onsubmit="return sumbit_sure()">
				<input type="hidden" id="com_pay_money"name="money" value="">
				<input type="hidden" name="mer_id" value="{pigcms{$mer_id}">
				<input type="hidden" name="pay_type" value="{pigcms{$type}">
				<div class="table-list">
					<style>
					.table-list td{line-height:22px;padding-top:5px;padding-bottom:5px;}
					</style>
					<table width="100%" cellspacing="0">
						<colgroup>
							<col/>
							<col/>
							<col/>
							<col/>
							<col/>
							<col/>
							<col/>
							<col/>
							<col/>
							<col/>
							<col/>
							<col/>
							<col/>
							<col/>
							<col/>
							<col width="100" align="center"/>
						</colgroup>
						<thead>
							<if condition="($type eq 'shop')">
							<tr>
								<th colspan="15">{pigcms{$config.shop_alias_name}的对账公式：应对金额 = 订单总额 - 商家优惠的金额 - 商家余额支付的金额 - 平台配送的配送费 (各个金额请点击查看订单详情)</th>
							</tr>
							</if>
							<tr>
								<th><input type="checkbox" id="all_select"/></th>
								<th>门店名称</th>
								<th>订单号</th>
								<th>订单详情</th>
								<th>数量</th>
								<th>金额</th>
								<th>余额支付金额</th>
								<th>在线支付金额</th>
								<th>商家会员卡余额支付金额</th>
								<th>平台优惠金额</th>
								<if condition="($type eq 'group')">
									<th>已退款金额</th>
									<th>退款手续费</th>
								</if>
								<th>优惠券</th>
								<if condition="($type neq 'group')"><th>下单时间</th></if>
								<th>支付时间</th>
								<th>支付类型</th>
								<if condition="($type eq 'meal') or ($type eq 'group')"><th>状态</th></if>
								<th>对账状态</th>
							</tr>
						</thead>
						<tbody>
								<if condition="$order_list">
									<volist name="order_list" id="vo">
										<tr>
											<td><if condition="($vo['is_pay_bill'] eq 0) AND ($start_year neq '')"><input type="checkbox" name="orderid[]" value="{pigcms{$vo.order_id}" class="select" data-price="{pigcms{$vo.order_price}"  <if condition="($type eq 'meal') or ($type eq 'group') or ($type eq 'appoint')">system_pay="{pigcms{$vo['score_deducte']+$vo['coupon_price']}"<elseif condition="$type eq 'shop'" />system_pay="{pigcms{$vo['score_deducte']+$vo['coupon_price']-$vo['no_bill_money']}"<else />system_pay="0"</if><if condition="$type eq 'group'">refund-fee="{pigcms{$vo.refund_fee}" refund-money="{pigcms{$vo.refund_money}"</if> payment_money="{pigcms{$vo.payment_money}" balance_pay="{pigcms{$vo.balance_pay}"/></if></td>
											<td>{pigcms{$vo.store_name}</td>
											<td><if condition="$type eq 'group' OR $type eq 'shop'">{pigcms{$vo.real_orderid}<else />{pigcms{$vo.order_id}</if></td>
											<td>
											
											<if condition="$type eq 'meal'">
												<volist name="vo['order_name']" id="menu" key='k'>
												<if condition="$k lt 3">
												{pigcms{$menu['name']}:{pigcms{$menu['price']}*{pigcms{$menu['num']}</br>
												</if>
												</volist>
												<if condition="count($vo['order_name']) gt 2">
												<a class='js-alert' orderid='{pigcms{$vo.order_id}' href="javascript:;" style="color: red">查看更多</a></if>
												<span style="display:none" id="js-alert-{pigcms{$vo.order_id}">
												<volist name="vo['order_name']" id="menu" key='k'>
												{pigcms{$menu['name']}:{pigcms{$menu['price']}*{pigcms{$menu['num']}</br>
												</volist>
												</span>
											<elseif condition="$type eq 'shop'" />
											<a href="javascript:void(0);" style="color: red" onclick="window.top.artiframe('{pigcms{:U('Shop/order_detail',array('order_id'=>$vo['order_id'],'frame_show'=>true))}','查看{pigcms{$config.shop_alias_name}订单详情',720,520,true,false,false,false,'detail',true);">查看</a>
											<else />
											{pigcms{$vo.order_name}
											</if>
											</td>
											<td>{pigcms{$vo.total}</td>
											<td>{pigcms{$vo.order_price}</td>
											<td>{pigcms{$vo.balance_pay}</td>
											<td>{pigcms{$vo.payment_money}</td>
											<td>{pigcms{$vo.merchant_balance}</td>
											<td>{pigcms{:sprintf("%.2f",$vo['score_deducte']+$vo['coupon_price'],2)}</td>
											<if condition="$type eq 'group'">
												<td>{pigcms{$vo.refund_money}</td>
												<td>{pigcms{$vo.refund_fee}</td>
											</if>
											<td><if condition="$vo['card_id'] eq 0">未使用<else/>已使用</if></td>
											<if condition="($type neq 'group')"><td>{pigcms{$vo.dateline|date="Y-m-d H:i:s",###}</td></if>
											<td><if condition="$vo['pay_time'] gt 0">{pigcms{$vo.pay_time|date="Y-m-d H:i:s",###}</if></td>
											<td>{pigcms{$vo.pay_type_show}</td>
											<if condition="($type eq 'meal') or ($type eq 'group')">
												<td>
													<if condition="$vo['paid'] eq 0">
														未付款
													<elseif condition="$vo['status'] eq 6" />
														部分退款
													<else />
														<if condition="$vo['pay_type'] eq 'offline' AND empty($vo['third_id'])">线下未支付
														<elseif condition="$vo['status'] eq 0" />未消费
														<elseif condition="$vo['status'] eq 1" />未评价
														<elseif condition="$vo['status'] eq 2" />已完成
														</if>
													</if>
												</td>
											</if>
											<td><if condition="$vo['is_pay_bill'] eq 0"><strong style="color: red">未对账</strong><else /><strong style="color: green"><strong type="color:green">已对账</strong></if></td>
										</tr>
									</volist>
									<input type="hidden" id="percent" value="{pigcms{$percent}" />
									<tr class="even" style="display:none">
										<td colspan="<if condition="$type eq 'group'">17<elseif condition="$type eq 'meal'" />16<else/>15</if>">
										<if condition="$percent">
										平台的抽成比例：<strong style="color: green">{pigcms{$percent}%</strong> <br/>
										本页总金额：<strong style="color: green">{pigcms{$total}</strong>　本页已出账金额：<strong style="color: red">{pigcms{$finshtotal} * {pigcms{$percent}%</strong><br/> 
										总金额：<strong style="color: green">{pigcms{$alltotal+$alltotalfinsh}</strong>　总已出账金额：<strong style="color: red">{pigcms{$alltotalfinsh} * {pigcms{$percent}%</strong><br/>
										<strong>本页平台支付金额：</strong><strong style="color: green">{pigcms{$system_pay}</strong><br/>
										<strong>本页平台应获取的抽成金额：</strong><strong style="color: green">{pigcms{$total_percent}</strong><br/>
										<strong>平台应获取的总抽成金额：</strong><strong style="color: red">{pigcms{$all_total_percent}</strong><br/>
										<strong>本页应获取的金额：</strong><strong style="color: red">{pigcms{$total-$total_percent}</strong><br/>
										<strong>应获取的总金额：</strong><strong style="color: red">{pigcms{$alltotal+$alltotalfinsh-$all_total_percent}</strong><br/>
										<else />
											本页总金额：<strong style="color: green">{pigcms{$total}</strong>　本页已出账金额：<strong style="color: red">{pigcms{$finshtotal}</strong><br/> 
											总金额：<strong style="color: green">{pigcms{$alltotal+$alltotalfinsh}</strong>　总已出账金额：<strong style="color: red">{pigcms{$alltotalfinsh}</strong><br/>
										
										</if>
										<!--本页总金额：<strong style="color: green">{pigcms{$total}</strong> 本页已出账金额：<strong style="color: red">{pigcms{$finshtotal}</strong><br/> 总金额：<strong style="color: green">{pigcms{$alltotal+$alltotalfinsh}</strong> 总已出账金额：<strong style="color: red">{pigcms{$alltotalfinsh}</strong-->
										</td>
									</tr>
									<tr class="odd">
										<td colspan="<if condition="$type eq 'group'">17<elseif condition="$type eq 'meal'" />16<else/>15</if>" id="show_count"></td>
									</tr>
									<tr><td class="textcenter pagebar" colspan="<if condition="$type eq 'group'">17<elseif condition="$type eq 'meal'" />16<else/>15</if>">{pigcms{$pagebar}</td></tr>	
								<else/>
									<tr class="odd"><td class="textcenter red" colspan="<if condition="$type eq 'group'">17<elseif condition="$type eq 'meal'" />16<else/>15</if>" >该的店铺暂时还没有订单。</td></tr>
								</if>
						</tbody>
					</table>
				</div>
			</form>
		</div>
<script type="text/javascript" src="{pigcms{$static_public}js/artdialog/jquery.artDialog.js"></script>
<script type="text/javascript" src="{pigcms{$static_public}js/artdialog/iframeTools.js"></script>
<script type="text/javascript">
var selected_year = {pigcms{$selected_year};
var selected_month = {pigcms{$selected_month};
$(document).ready(function(){
	<if condition="$start_year neq ''">
		getyear();
	</if>
	
	$('#all_select').click(function(){
		if ($(this).attr('checked')){
			$('.select').attr('checked', true);
		} else {
			$('.select').attr('checked', false);
		}
		total_price();
	});
	$('.select').click(function(){total_price();});
	$('.button').click(function(){
		var strids = '';
		var pre = '', type = $('input[name=pay_type]').val();
		$('.select').each(function(){
			if ($(this).attr('checked')) {
				strids += pre + $(this).val();
				pre = ',';
			}
		});
		if (strids.length > 0) {
			$.get("{pigcms{:U('Merchant/change',array('mer_id'=>$mer_id))}", {strids:strids, 'type':type}, function(data){
				if (data.error_code == 0) {
					location.reload();
				}
			}, 'json');
		}
	});

	$('.js-alert').click(function(){
		var now_dom = $(this);
		var jshtml = $('#js-alert-'+$(this).attr('orderid')).html();
		window.top.art.dialog({
			icon: '',
			title: '详情',
			id: 'msg' + Math.random(),
			lock: true,
			fixed: true,
			opacity:'0.4',
			resize: false,
			content: jshtml,
			cancel:true
		});
		return false;
	});
});
function sumbit_sure(){
	var gnl=confirm("确定要提交?");
	if (gnl==true){
		return true;
	}else{
		return false;
	}
}
function change_money(domid){
	art.dialog.data('domid', domid);
	art.dialog.data('money', $('#com_pay_money').val());
	art.dialog.open("{pigcms{:U('Merchant/change_money')}",{lock:true,title:'改变金额',width:600,height:160,yesText:'关闭',background: '#000',opacity: 0.45});
}
function total_price()
{
	var total = 0;
	var system_pay = 0;
	$('.select').each(function(){
		if ($(this).attr('checked')) {
			if(parseFloat($(this).attr('refund-fee'))>0||parseFloat($(this).attr('refund-money'))>0){
				total += parseFloat($(this).attr('data-price'))-parseFloat($(this).attr('refund-money'));
				system_pay +=parseFloat($(this).attr('system_pay')) + parseFloat($(this).attr('balance_pay')) + parseFloat($(this).attr('payment_money'))-parseFloat($(this).attr('refund-money'));
			}else{
				total += parseFloat($(this).attr('data-price'));
				system_pay += parseFloat($(this).attr('system_pay')) + parseFloat($(this).attr('balance_pay')) + parseFloat($(this).attr('payment_money'));
			}
		}
	});
	total = Math.round(total * 100)/100;
	system_pay = Math.round(system_pay * 100)/100;
	var percent = $('#percent').val();
	if (total > 0) {
		$('#show_count').html('选中账单总计金额：<strong style=\'color:red\'>$' + total + '</strong>, 平台对该商家的抽成比例是：<strong style=\'color:green\'>' + percent + '%</strong>, 平台抽成金额：<strong style=\'color:green\'>$' + Math.round(system_pay * percent) /100 + '</strong>, 平台支付金额：<strong style=\'color:green\'>$' + Math.round(system_pay*100)/100+ '</strong>,商家应得金额:<strong style=\'color:red\' id="mer_desert">$' + Math.round((system_pay - Math.round(system_pay * percent) /100) * 100)/100 + '</strong><if condition="$config['company_pay_open']"><input type="button" class="button" onclick="change_money(com_pay_money)"value="改变商家应得金额">  <input type="submit" class="button" value="确认对帐并在线提现"></if>');
		$('#com_pay_money').val(Math.round((system_pay - Math.round(system_pay * percent) /100) * 100));
	} else {
		$('#show_count').html('');
	}
}
<if condition="$start_year neq ''">
function getyear(){
        var now = new Date();
        var now_year = now.getFullYear();
        $('.year').empty();
        var year_list='<div id="nav" class="mainnav_title"><ul>';
        year_list+='<font color="#000">年 :</font>' ;
        for(var year={pigcms{$start_year};year<=now_year;year++){
            if(selected_year!=''&&year==selected_year){
                year_list+='<a  href="{pigcms{:U(\'Merchant/order\',array(\'mer_id\'=>$mer_id,\'type\'=>$type))}&year='+year+'" class="on">'+year+'</a>  ';
            }else{
                year_list+='<a  href="{pigcms{:U(\'Merchant/order\',array(\'mer_id\'=>$mer_id,\'type\'=>$type))}&year='+year+'">'+year+'</a>  ';
            }
               
        }
        year_list+='</ul></div>'
        $('.year').append(year_list);
        var month = $('.year .on').length>0?$('.year .on').html():now_year;
        getmonth(month);
}
function getmonth(year){
        var now=Date();
        $('.month').empty();
        var now = new Date();
        
        var month_list = '<div id="nav" class="mainnav_title"><ul>';
        month_list+='<font color="#000">月 :</font>' ;
        var month_end = year<now.getFullYear()?12:now.getMonth()+1;
        for (var m = 1; m <= month_end; m++) {
            if (m==selected_month) {
                month_list +='<a href="{pigcms{:U(\'Merchant/order\',array(\'mer_id\'=>$mer_id,\'type\'=>$type))}&year='+year+'&month='+m+'"  class="on">'+m+'月 '+'</a>';
            }else{
                month_list +='<a href="{pigcms{:U(\'Merchant/order\',array(\'mer_id\'=>$mer_id,\'type\'=>$type))}&year='+year+'&month='+m+'" >'+m+'月 '+'</a>';
            }
        }
        month_list+='</ul></div>';
        $('.month').empty();
        $('.month').append(month_list);
}
</if>
</script>
<include file="Public:footer"/>