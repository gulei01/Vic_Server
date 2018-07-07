$
<style>
.mainnav_title ul a {
    padding: 15px 20px;
}
ul, ol {
    margin-bottom: 15px;
}
.mainnav_title div{
	color:#7EBAEF;
	float:right;
}
.mainnav_title a.on div{
	color:#C1BEBE;
}
.info{
	line-height:30px;
}
button{
	    margin: 5px;
	padding: 4px;
	background-color: rgba(255, 255, 255, 0);
	box-sizing: border-box;
	border-width: 1px;
	border-style: solid;
	border-color: rgba(121, 121, 121, 1);
	border-radius: 2px;
	-moz-box-shadow: none;
	-webkit-box-shadow: none;
	box-shadow: none;
	font-size: 14px;
	color: #666666;
	cursor: pointer ;

}
.all{
	border-collapse:collapse;
	border:none;
}
.all td{
	border:solid #000 1px;
	border-color:"#cccc99";
	height: 20px;
	text-align: center;
}
.all th{
	border:solid #000 1px;
	border-color:"#cccc99";
	height: 20px;
}
</style>
		<div class="mainbox">
			
			
				<div id="nav" class="mainnav_title" style="margin-top: 12px;">
					<a href="{pigcms{:U('Bill/billed_list',array('mer_id'=>$mer_id))}">上一页</a>
				</div>
				<div class="widget-header" style="margin-left:70px;">
					<div class="info" style="font-size:16px;font-family: 'Arial Negreta','Arial';font-weight: 700;">餐饮对账单明细  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="{pigcms{:U('Merchant/export',array('mer_id'=>$mer_id, 'type' => $type,'bill_id'=>$bill_info['id']))}" class="on"><button>导出EXCEL</button></a></div> 
					<div class="info">对账时间：{pigcms{$bill_info.bill_time|date="Y/m/d H:i",###}</div>
					<div class="info">对账关系：<font color="#C3BEBE">平台>{pigcms{$now_merchant['name']}</font></div>
					<div class="info">已对账订单总数:{pigcms{$bill_info.count}</div>
					<!--时间筛选-->
					<table class="all">
						<thead>
							<tr>
								<th>平台总支付金额</th>
								<th>平台抽成商家比例</th>
								<th>平台抽成金额</th>
								<th>商家应得金额</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>{pigcms{$order_list.total}元</td>
								<td>{pigcms{$percent}%</td>
								<td>{pigcms{$order_list['total']*$percent/100}</td>
								<td>{pigcms{$bill_info['money']/100}元</td>
							</tr>
						</tbody>
					</table>
				</div>
				<br>
			<div class="mainnav_title">
			
			</div>
			
				<input type="hidden" id="com_pay_money"name="money" value="">
				<input type="hidden" name="mer_id" value="{pigcms{$mer_id}">
				<input type="hidden" name="pay_type" value="{pigcms{$type}">
				<div class="table-list">
					<style>
					.table-list td{line-height:22px;padding-top:5px;padding-bottom:5px;}
					</style>
					<table width="100%" cellspacing="0">
						<colgroup>
							<col width="200"/>
							<col width="200"/>
							<col width="200"/>
							<col/>
							<col/>
							<col/>
							<col/>
							<col/>
						
						</colgroup>
						<thead>
							<tr>
								<th>店铺名称</th>
								<th>订单编号</th>
								<th>订单详情</th>
								<th>订单数量</th>
								<th>总额</th>
								<th>应对账金额</th>
								<th>支付时间</th>	
								<if condition="($type eq 'group')">
									<th>已退款金额</th>
									<th>退款手续费</th>
								</if>
								<if condition="($type eq 'meal') or ($type eq 'group')"><th>状态</th></if>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
								<if condition="$order_list.order_list">
									<volist name="order_list.order_list" id="vo">
										<tr>
											<td>{pigcms{$vo.store_name}</td>
											<td>{pigcms{$vo.real_orderid}</td>
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
											<else />
											{pigcms{$vo.order_name}
											</if>
											</td>
											<td>{pigcms{$vo.total}</td>
											<td>{pigcms{$vo.order_price}</td>
											<if condition="$type eq 'group'">
											<td>{pigcms{$vo['score_deducte']+$vo['coupon_price']+$vo['balance_pay']+$vo['payment_money']-$vo['refund_money']+$vo['refund_fee']}</td>
											<else />
											<td>{pigcms{$vo['score_deducte']+$vo['coupon_price']+$vo['balance_pay']+$vo['payment_money']}</td>
											</if>
											<td><if condition="$vo['pay_time'] gt 0">{pigcms{$vo.pay_time|date="Y-m-d H:i:s",###}</if></td>
											
											<if condition="$type eq 'group'">
												<td>{pigcms{$vo.refund_money}</td>
												<td>{pigcms{$vo.refund_fee}</td>
											</if>
										
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
											<td>
												<if condition="$type eq 'group'">
													<a href="javascript:void(0);" onclick="window.top.artiframe('/admin.php?g=System&c=Group&a=order_detail&order_id={pigcms{$vo.order_id}','查看订单详情',600,460,true,false,false,false,'order_edit',true);"><button>查看详情</button></a>
												<elseif condition="$type eq 'meal'" />
													<a href="javascript:void(0);" onclick="window.top.artiframe('/admin.php?g=System&c=Meal&a=order_detail&order_id={pigcms{$vo.order_id}','查看订单详情',600,460,true,false,false,false,'order_edit',true);"><button>查看详情</button></a>
												<elseif condition="$type eq 'appoint'" />
													<a href="javascript:void(0);" onclick="window.top.artiframe('/admin.php?g=System&c=Appoint&a=order_detail&order_id={pigcms{$vo.order_id}','查看订单详情',600,460,true,false,false,false,'order_edit',true);"><button>查看详情</button></a>
												<elseif condition="$type eq 'weidian'" />
													<a href="javascript:void(0);" onclick="window.top.artiframe('/admin.php?g=System&c=Weidian&a=order_detail&order_id={pigcms{$vo.order_id}','查看订单详情',600,460,true,false,false,false,'order_edit',true);"><button>查看详情</button></a>
												<elseif condition="$type eq 'waimai'" />
													<a href="javascript:void(0);" onclick="window.top.artiframe('/admin.php?g=System&c=Waimai&a=order_detail&order_id={pigcms{$vo.order_id}','查看订单详情',600,460,true,false,false,false,'order_edit',true);"><button>查看详情</button></a>
												<elseif condition="$type eq 'wxapp'" />
													<a href="javascript:void(0);" onclick="window.top.artiframe('/admin.php?g=System&c=Wxapp&a=order_detail&order_id={pigcms{$vo.order_id}','查看订单详情',600,460,true,false,false,false,'order_edit',true);"><button>查看详情</button></a>
												<elseif condition="$type eq 'shop'" />
													<a href="javascript:void(0);" onclick="window.top.artiframe('/admin.php?g=System&c=Shop&a=order_detail&order_id={pigcms{$vo.order_id}','查看订单详情',600,460,true,false,false,false,'order_edit',true);"><button>查看详情</button></a>
												<elseif condition="$type eq 'store'" />
													<a href="javascript:void(0);" onclick="window.top.artiframe('/admin.php?g=System&c=Store&a=order_detail&order_id={pigcms{$vo.order_id}','查看订单详情',600,460,true,false,false,false,'order_edit',true);"><button>查看详情</button></a>
												</if>
											</td>
										</tr>
									</volist>
									<input type="hidden" id="percent" value="{pigcms{$percent}" />
									
									<tr class="odd">
										<td colspan="7" id="show_count"></td>
									</tr>
									<tr><td class="textcenter pagebar" colspan="16">{pigcms{$pagebar}</td></tr>	
								<else/>
									<tr class="odd"><td class="textcenter red" colspan="17" >该的店铺暂时还没有订单。</td></tr>
								</if>
						</tbody>
					</table>
				</div>
		</div>
<script type="text/javascript" src="{pigcms{$static_public}js/artdialog/jquery.artDialog.js"></script>
<script type="text/javascript" src="{pigcms{$static_public}js/artdialog/iframeTools.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	 $.ajax({
		url:'{pigcms{:U('Bill/get_un_bill_count')}',
		type:"post",
		dataType:"JSON",
		data: {mer_id:{pigcms{$mer_id}},
		beforeSend: function(){
			$('.mainnav_title a.on div').html('(数据加载中)');
		},
		success:function(date){
			$.each(date, function(index, val) {
				$('#'+index).html('(待对账：'+val+')');
			});

		}
	 });
	
	
	$('.mainnav_title a').hover(function(){
		$(".mainnav_title .on div").css('color','#7EBAEF');
		$(this).children('div').css('color','#C1BEBE');
	}, function(event){
		$(this).children('div').css('color','#7EBAEF');
	});
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
		var money=Math.round((system_pay - Math.round(system_pay * percent) /100) * 100)/100;
		
		if (strids.length > 0) {
			$.get("{pigcms{:U('Merchant/change',array('mer_id'=>$mer_id))}", {strids:strids, 'type':type,money:money}, function(data){
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


</script>
<include file="Public:footer"/>