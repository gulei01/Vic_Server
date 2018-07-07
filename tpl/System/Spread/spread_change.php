$
		<div class="mainbox">
			<div id="nav" class="mainnav_title">
				<ul>
					<a href="{pigcms{:U('Spread/spread_change')}" class="on">佣金过户用户列表</a>
				</ul>
			</div>
			<table class="search_table" width="100%">
				<tr>
					<td>
						<form action="{pigcms{:U('Spread/spread_change')}" method="get">
							<input type="hidden" name="c" value="Spread"/>
							<input type="hidden" name="a" value="spread_change"/>
							筛选: <input type="text" name="keyword" class="input-text" value="{pigcms{$_GET['keyword']}"/>
							<select name="searchtype">
								<option value="uid" <if condition="$_GET['searchtype'] eq 'uid'">selected="selected"</if>>用户ID</option>
								<option value="nickname" <if condition="$_GET['searchtype'] eq 'nickname'">selected="selected"</if>>昵称</option>
								<option value="phone" <if condition="$_GET['searchtype'] eq 'phone'">selected="selected"</if>>手机号</option>
							</select>
							<input type="submit" value="查询" class="button"/>
							
						</form>
					</td>
				</tr>
			</table>
			<form name="myform" id="myform" action="" method="post">
				<div class="table-list">
					<table width="100%" cellspacing="0">
						<colgroup>
							<col/>
							<col/>
							<col/>							<col/>
							<col/>
							<col/>
							<col width="180" align="center"/>
						</colgroup>
						<thead>
							<tr>
								<th style="color:blue">ID</th>
								<th>昵称</th>
								<th>手机号</th>
								<th>过户用户昵称</a></th>
								<th>过户用户手机号</th>
								<th class="textcenter">结算佣金</th>
								<th class="textcenter">操作</th>
							</tr>
						</thead>
						<tbody>
							<if condition="is_array($spread_user_list)">
								<volist name="spread_user_list" id="vo">
									<tr>
										<td>{pigcms{$vo.uid}</td>
										<td>{pigcms{$vo.nickname}</td>
										<td>{pigcms{$vo.phone}</td>
										<td>{pigcms{$vo.change_user.nickname}</td>
										<td>{pigcms{$vo.change_user.phone}</td>
										<td class="textcenter">${pigcms{$vo.spread_money|floatval=###}</td>
										
										<td class="textcenter"><a href="javascript:void(0);" class="delete_row"  parameter="uid={pigcms{$vo.uid}" url="{pigcms{:U('Spread/unbind_spread_change')}">解绑</a></td>
									</tr>
								</volist>
								<tr><td class="textcenter pagebar" colspan="9">{pigcms{$pagebar}</td></tr>
							<else/>
								<tr><td class="textcenter red" colspan="8">列表为空！</td></tr>
							</if>
						</tbody>
					</table>
				</div>
			</form>
		</div>
<include file="Public:footer"/>