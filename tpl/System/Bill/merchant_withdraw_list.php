<include file="Public:header"/><style>	.mainnav_title a.on div{	color:#C1BEBE;}</style>		<div class="mainbox">			<div id="nav" class="mainnav_title">				<ul>					<a href="{pigcms{:U('Bill/merchant_withdraw')}">商家余额存入记录</a>					<a href="{pigcms{:U('Bill/merchant_withdraw',array('withdraw_status'=>1))}" >待提现商家</a>					<a href="{pigcms{:U('Bill/merchant_withdraw_list')}" class="on">已提现记录</a>				</ul>			</div>			<table class="search_table" width="100%">				<tr>					<td class="mainnav_title">						<form action="{pigcms{:U('Bill/merchant_withdraw')}" method="get">							<input type="hidden" name="c" value="Bill"/>							<input type="hidden" name="a" value="merchant_withdraw_list"/>							筛选: <input type="text" name="keyword" class="input-text" value="{pigcms{$_GET['keyword']}"/>							<select name="searchtype">								<option value="name" <if condition="$_GET['searchtype'] eq 'name'">selected="selected"</if>>商户名称</option>																<option value="phone" <if condition="$_GET['searchtype'] eq 'phone'">selected="selected"</if>>联系电话</option>								<option value="mer_id" <if condition="$_GET['searchtype'] eq 'mer_id'">selected="selected"</if>>商家编号</option>							</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;							<font color="#000">日期筛选：</font>							<input type="text" class="input-text" name="begin_time" style="width:120px;" id="d4311"  value="{pigcms{$begin_time}" onfocus="WdatePicker({readOnly:true,dateFmt:'yyyy-MM-dd'})"/>			   							<input type="text" class="input-text" name="end_time" style="width:120px;" id="d4311" value="{pigcms{$end_time}" onfocus="WdatePicker({readOnly:true,dateFmt:'yyyy-MM-dd'})"/>							<input type="submit" value="筛选" class="button">							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>提现总余额：{pigcms{$all_money}</b>						&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" onclick="exports();" >导出EXCEL</a>						</form>					</td>				</tr>			</table>						<form name="myform" id="myform" action="" method="post">				<div class="table-list">					<style>					.table-list td{line-height:22px;padding-top:5px;padding-bottom:5px;}					</style>					<table width="100%" cellspacing="0">						<colgroup>							<col/>							<col/>							<col/>							<col/>							<col width="200" align="center"/>						</colgroup>						<thead>							<tr>								<th>编号</th>								<th>商户名称</th>								<th>联系电话</th>								<th>提现金额</th>								<th>提现时间</th>							</tr>						</thead>						<tbody>							<if condition="$withdraw_list">								<volist name="withdraw_list" id="vo">									<tr>										<td>{pigcms{$vo.mer_id}</td>										<td>{pigcms{$vo.name}</td>										<td>{pigcms{$vo.phone}</td>										<td>{pigcms{$vo['money']/100}元</td>										<td>{pigcms{$vo['withdraw_time']|date="Y-m-d H:i:s",###}</td>									</tr>								</volist>								<tr><td class="textcenter pagebar" colspan="11">{pigcms{$pagebar}</td></tr>							<else/>								<tr><td class="textcenter red" colspan="11">列表为空！</td></tr>							</if>						</tbody>					</table>				</div>			</form>		</div><script>	function exports(){		var keyword = $('select[name="keyword"]').val();		var searchtype = $('input[name="searchtype"]').val();		var begin_time = $('input[name="begin_time"]').val();		var end_time = $('input[name="end_time"]').val();		var export_url ="{pigcms{:U('Bill/export_withdraw')}&keyword="+keyword+'&searchtype='+searchtype+'&begin_time='+begin_time+'&end_time='+end_time;		window.location.href = export_url;			}</script><include file="Public:footer"/>