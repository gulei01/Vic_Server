$
		<div class="mainbox">
			<div id="nav" class="mainnav_title">
				<ul>
					<a href="{pigcms{:U('Activity/index')}" class="on">活动列表</a>
				</ul>
			</div>
			<form action="{pigcms{:U('Activity/yydb_order_list')}" method="get">
				<input type="hidden" name="c" value="Activity"/>
				<input type="hidden" name="a" value="yydb_order_list"/>
				<input type="hidden" name="activity_id" value="{pigcms{$activity_id}"/>
				<font color="#000">日期筛选：</font>
				<input type="text" class="input-text" name="begin_time" style="width:120px;" id="d4311"  value="{pigcms{$_GET.begin_time}" onfocus="WdatePicker({readOnly:true,dateFmt:'yyyy-MM-dd'})"/>			   
				<input type="text" class="input-text" name="end_time" style="width:120px;" id="d4311" value="{pigcms{$_GET.end_time}" onfocus="WdatePicker({readOnly:true,dateFmt:'yyyy-MM-dd'})"/>
				<input type="submit" value="查询" class="button"/>　
				
				<a href="{pigcms{:U('Activity/export',$_GET)}" class="button" style="float:right;margin-right: 10px;">导出订单</a>
					　
			</form>
				<div class="table-list">
					<table width="100%" cellspacing="0">
						<colgroup>
							<col/>
							<col/>
							<col/>
							<col/>
							<col/>
							<col/>
						</colgroup>
						<thead>
							<tr>
								<th>编号</th>
								<th>用户姓名</th>
								<th>用户手机</th>
								<th>数量</th>
								<th>金额</th>
								<th>购买时间</th>
							</tr>
						</thead>
						<tbody>
							<if condition="!empty($list)">
								<volist name="list" id="vo">
									<tr>
										<td>{pigcms{$vo.pigcms_id}</td>
										<td>{pigcms{$vo.nickname}</td>
										<td title="{pigcms{$vo.title}">{pigcms{$vo.phone}</td>
										<td>{pigcms{$vo.part_count}</td>
										<td>${pigcms{$vo.part_count}</td>
										
										<td>
										{pigcms{$vo.time|date='Y-m-d H:i:s',###}
										</td>
									</tr>
								</volist>
								<tr><td class="textcenter pagebar" colspan="6">{pigcms{$pagebar}</td></tr>
							<else/>
								<tr><td class="textcenter red" colspan="6">列表为空！</td></tr>
							</if>
						</tbody>
					</table>
				</div>
			
		</div>
<include file="Public:footer"/>