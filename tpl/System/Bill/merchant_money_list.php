<include file="Public:header"/>
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
.table-list thead th {
    text-align: center;
}
.table-list tbody td {
    text-align: center;
	white-space: nowrap;
　　overflow: hidden;
　　text-overflow: ellipsis;
}
button{
	    margin: 5px;
	padding: 6px;
	background-color: rgba(255, 255, 255, 0);
	box-sizing: border-box;
	border-width: 1px;
	border-style: solid;
	border-color: rgba(121, 121, 121, 1);
	border-radius: 2px;
	-moz-box-shadow: none;
	-webkit-box-shadow: none;
	box-shadow: none;
	font-size: 16px;
	color: #666666;
	cursor: pointer ;

}
</style>
		<div class="mainbox">
		<div id="nav" class="mainnav_title" style="margin-top: 12px;">
			<a href="{pigcms{:U('Bill/merchant_withdraw')}">上一页</a>
		</div>
			<div style="margin:15px 0;">
				<b>商家ID：</b>{pigcms{$now_merchant.mer_id}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>商家名称：</b>{pigcms{$now_merchant.name}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>联系电话：</b>{pigcms{$now_merchant.phone}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;商家余额：</b>{pigcms{$now_merchant.money}<br/><br/>
			</div>
			<div id="nav" class="mainnav_title" style="margin-top:5px;">
				<ul>
					<a href="{pigcms{:U('Bill/merchant_money_list',array('mer_id'=>$mer_id))}" class="on">商家余额存入记录</a>
					<a href="{pigcms{:U('Bill/withdraw_info',array('mer_id'=>$mer_id,'status'=>0))}" >待兑现记录</a>
					<a href="{pigcms{:U('Bill/withdraw_info',array('mer_id'=>$mer_id,'status'=>1))}" >已兑现记录</a>
				</ul>
			</div>
			<div class="mainnav_title">
					<form id="date" method="post" action="{pigcms{:U('Bill/merchant_money_list')}" >
						
							<font color="#000">业务类型： </font>
							<select name="order_type">
								<volist name="alias_name" id="vo">
									<option value="{pigcms{$key}" <if condition="$order_type eq $key">selected=selected</if>>{pigcms{$vo}</option>
								</volist>
							</select>
							<font color="#000">订单：<input type="text" name="order_id" value="{pigcms{$order_id}" placeholder="输入订单号" style="    line-height: 18px;height: 18px;">
						
							<input type="hidden" name="mer_id" value="{pigcms{$mer_id}">
						
							<font color="#000">日期筛选：</font>
							<input type="text" class="input-text" name="begin_time" style="width:120px;" id="d4311"  value="{pigcms{$begin_time}" onfocus="WdatePicker({readOnly:true,dateFmt:'yyyy-MM-dd'})"/>			   
							<input type="text" class="input-text" name="end_time" style="width:120px;" id="d4311" value="{pigcms{$end_time}" onfocus="WdatePicker({readOnly:true,dateFmt:'yyyy-MM-dd'})"/>
							<input type="submit" value="筛选" class="button">
						
					</form>
					&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" onclick="exports();" >导出EXCEL</a>
				
			</div>
			
				<input type="hidden" id="com_pay_money"name="money" value="">
				<input type="hidden" name="mer_id" value="{pigcms{$mer_id}">
				<div class="table-list">
					<style>
					.table-list td{line-height:22px;padding-top:5px;padding-bottom:5px;}
					</style>
					<table width="100%" cellspacing="0">
						<colgroup>
							<col width="200"/>
							<col />
							<col/>
						</colgroup>
						<thead>
							<tr>
								<th>店铺名称</th>
								<th>订单号</th>
								<th>订单类型</th>
								<th>订单详情</th>
								<th>数量</th>
								<th>总额</th>
								<th>送出{pigcms{$config.score_name}数</th>
								<th>用户消费{pigcms{$config.score_name}数</th>
								<th>平台佣金<font color="red" size="1">(提现代表手续费)</font></th>
								<th>支付时间</th>
								<th>当前商家余额</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
								<if condition="$income_list">
								<volist name="income_list" id="vo">
									<tr>
										<td>{pigcms{$vo.store_name}</td>
										<td><if condition="$vo.type eq 'withdraw'">w_{pigcms{$vo.id}<else />{pigcms{$vo.order_id}</if></td>
										<td><?php echo $alias_name[$vo['type']];?></td>
										<td>
											{pigcms{:msubstr($vo['desc'],0,50,true,'utf-8')}
										</td>
										<td>{pigcms{$vo.num}</td>
										<td><if condition="$vo.income eq 1"><font color="#2bb8aa">+{pigcms{$vo.money|floatval}</font><elseif condition="$vo.income eq 2" /><font color="#f76120">-{pigcms{$vo.money|floatval}</font></if></td>
										<td>{pigcms{$vo.score|floatval}</td>
										<td>{pigcms{$vo.score_count|floatval}</td>
										<td><font color="#5167de">{pigcms{$vo.system_take}<if condition="$vo['type'] eq 'withdraw' AND $vo['percent'] gt 0"> （提现比例 {pigcms{$vo.percent} %）<elseif condition="$vo['system_take'] gt 0" />（抽成比例 {pigcms{$vo.percent} %）</if></font></td>
										<td><if condition="$vo['use_time'] gt 0">{pigcms{$vo.use_time|date="Y-m-d H:i:s",###}</if></td>
										<td><font color="#5167de">{pigcms{$vo.now_mer_money}</font></td>
										<td>
											<if condition="$vo.type eq 'group'">
												<a href="javascript:void(0);" onclick="window.top.artiframe('/admin.php?g=System&c=Group&a=order_detail&order_id={pigcms{$vo.order_id}','查看订单详情',600,460,true,false,false,false,'order_edit',true);"><button>查看详情</button></a>
											<elseif condition="$vo.type eq 'meal'" />
												<a href="javascript:void(0);" onclick="window.top.artiframe('/admin.php?g=System&c=Foodshop&a=order_detail&order_id={pigcms{$vo.order_id}','查看订单详情',600,460,true,false,false,false,'order_edit',true);"><button>查看详情</button></a>
										
											<elseif condition="$vo.type eq 'appoint'" />
												<a href="javascript:void(0);" onclick="window.top.artiframe('/admin.php?g=System&c=Appoint&a=order_detail&order_id={pigcms{$vo.order_id}','查看订单详情',600,460,true,false,false,false,'order_edit',true);"><button>查看详情</button></a>
											<elseif condition="$vo.type eq 'weidian'" />
												<a href="javascript:void(0);" onclick="window.top.artiframe('/admin.php?g=System&c=Orderdetail&a=weidian_detail&order_id={pigcms{$vo.order_id}','查看订单详情',600,460,true,false,false,false,'order_edit',true);"><button>查看详情</button></a>
											<elseif condition="$vo.type eq 'waimai'" />
												<a href="javascript:void(0);" onclick="window.top.artiframe('/admin.php?g=System&c=Waimai&a=order_detail&order_id={pigcms{$vo.order_id}','查看订单详情',600,460,true,false,false,false,'order_edit',true);"><button>查看详情</button></a>
											<elseif condition="$vo.type eq 'wxapp'" />
												<a href="javascript:void(0);" onclick="window.top.artiframe('/admin.php?g=System&c=Orderdetail&a=wxapp_detail&order_id={pigcms{$vo.order_id}','查看订单详情',600,460,true,false,false,false,'order_edit',true);"><button>查看详情</button></a>
											<elseif condition="$vo.type eq 'shop'" />
												<a href="javascript:void(0);" onclick="window.top.artiframe('/admin.php?g=System&c=Shop&a=order_detail&order_id={pigcms{$vo.order_id}','查看订单详情',600,460,true,false,false,false,'order_edit',true);"><button>查看详情</button></a>
											<elseif condition="$vo.type eq 'store'" />
												<a href="javascript:void(0);" onclick="window.top.artiframe('/admin.php?g=System&c=Orderdetail&a=store_detail&order_id={pigcms{$vo.order_id}','查看订单详情',600,460,true,false,false,false,'order_edit',true);"><button>查看详情</button></a>
											<elseif condition="$vo.type eq 'withdraw'" />
												<a href="javascript:void(0);" onclick="window.top.artiframe('/admin.php?g=System&c=Bill&a=withdraw_order_info&id={pigcms{$vo.order_id}','查看订单详情',600,460,true,false,false,false,'order_edit',true);"><button>查看详情</button></a>
											<elseif condition="$vo.type eq 'yydb'" />
												<a href="javascript:void(0);" onclick="window.top.artiframe('/admin.php?g=System&c=Orderdetail&a=yydb_detail&order_id={pigcms{$vo.order_id}','查看订单详情',600,460,true,false,false,false,'order_edit',true);"><button>查看详情</button></a>
											<elseif condition="$vo.type eq 'coupon'" />
												<a href="javascript:void(0);" onclick="window.top.artiframe('/admin.php?g=System&c=Orderdetail&a=coupon_detail&order_id={pigcms{$vo.order_id}&mer_id={pigcms{$mer_id}','查看订单详情',600,460,true,false,false,false,'order_edit',true);"><button>查看详情</button></a>
											</if>
										</td>
									</tr>
								</volist>
								
									<tr><td class="textcenter pagebar" colspan="12">{pigcms{$pagebar}</td></tr>	
								<else/>
									<tr class="odd"><td class="textcenter red" colspan="12" >该的店铺暂时还没有提现记录。</td></tr>
								</if>
						</tbody>
					</table>
				</div>
		
		</div>
<script type="text/javascript" src="{pigcms{$static_public}js/artdialog/jquery.artDialog.js"></script>
<script type="text/javascript" src="{pigcms{$static_public}js/artdialog/iframeTools.js"></script>
<script>
	function exports(){
		var order_type = $('select[name="order_type"]').val();
		var order_id = $('input[name="order_id"]').val();
		var begin_time = $('input[name="begin_time"]').val();
		var end_time = $('input[name="end_time"]').val();
		if(order_type=='all'&&order_id!=''){
			alert('该分类下没有不能填订单ID');
		}else{
			var export_url ="{pigcms{:U('Merchant/export',array('mer_id'=>$mer_id, 'type' => 'income'))}&order_type="+order_type+'&order_id='+order_id+'&begin_time='+begin_time+'&end_time='+end_time;
			window.location.href = export_url;
		}
	}
</script>
<include file="Public:footer"/>