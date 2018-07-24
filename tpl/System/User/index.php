$
		<div class="mainbox">
			<div id="nav" class="mainnav_title">
				<ul>
					<a href="{pigcms{:U('User/index')}" class="on">用户列表</a>
				</ul>
			</div>
			<table class="search_table" width="100%">
				<tr>
					<td>
						<form action="{pigcms{:U('User/index')}" method="get">
							<input type="hidden" name="c" value="User"/>
							<input type="hidden" name="a" value="index"/>
							筛选: <input type="text" name="keyword" class="input-text" value="{pigcms{$_GET['keyword']}"/>
							<select name="searchtype">
								<option value="uid" <if condition="$_GET['searchtype'] eq 'uid'">selected="selected"</if>>用户ID</option>
								<option value="nickname" <if condition="$_GET['searchtype'] eq 'nickname'">selected="selected"</if>>昵称</option>
								<option value="phone" <if condition="$_GET['searchtype'] eq 'phone'">selected="selected"</if>>手机号</option>
							</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<font color="#000">注册日期筛选：</font>
							<input type="text" class="input-text" name="begin_time" style="width:120px;" id="d4311"  value="{pigcms{$_GET.begin_time}" onfocus="WdatePicker({readOnly:true,dateFmt:'yyyy-MM-dd'})"/>			   
							<input type="text" class="input-text" name="end_time" style="width:120px;" id="d4311" value="{pigcms{$_GET.end_time}" onfocus="WdatePicker({readOnly:true,dateFmt:'yyyy-MM-dd'})"/>
							状态:
							<select name="status">
								<option value="" <if condition="$_GET['status'] eq ' '">selected="selected"</if>>全部</option>
								<option value="1" <if condition="$_GET['status'] eq '1'">selected="selected"</if>>正常</option>
								<option value="0" <if condition="$_GET['status'] eq '0'">selected="selected"</if>>禁用</option>
							</select>
							<input type="submit" style="margin-right:20px;" value="查询" class="button"/>
							用户总余额：<if condition="$user_balance['count']">{pigcms{$user_balance['count']}<else/>0</if>元&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							正常用户总余额：<if condition="$user_balance['open']">{pigcms{$user_balance['open']}<else/>0</if>元&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							禁止用户总余额：<if condition="$user_balance['close']">{pigcms{$user_balance['close']}<else/>0</if>元
							<a href="{pigcms{:U('User/export')}" class="button" style="float:right;margin-right: 10px;">导出用户</a>
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
							<col/>
							<col/>
							<col/>
							<col/>
							<col/>
							<col/>
							<col width="180" align="center"/>
						</colgroup>
						<thead>
							<tr>
								<th><a href="{pigcms{:U('User/index',array('sort'=>'uid'))}" style="color:blue;">ID</a></th>
								<th>昵称</th>
								<th>手机号</th>
								<th><a href="{pigcms{:U('User/index',array('sort'=>'lastTime'))}" style="color:blue;">最后登录时间</a></th>
								<th>最后登录地址</th>
								<th class="textcenter"><a href="{pigcms{:U('User/index',array('sort'=>'money'))}" style="color:blue;">余额</a></th>
								<th class="textcenter"><a href="{pigcms{:U('User/index',array('sort'=>'score'))}" style="color:blue;">{pigcms{$config['score_name']}</a></th>
								<th class="textcenter">来源</th>
								<th class="textcenter">状态</th>
								<th class="textcenter">操作</th>
							</tr>
						</thead>
						<tbody>
							<if condition="is_array($user_list)">
								<volist name="user_list" id="vo">
									<tr>
										<td>{pigcms{$vo.uid}</td>
										<td>{pigcms{$vo.nickname}</td>
										<td>{pigcms{$vo.phone}</td>
										<td>{pigcms{$vo.last_time|date='Y-m-d H:i:s',###}</td>
										<td>{pigcms{$vo.last_ip_txt}</td>
										<td class="textcenter">${pigcms{$vo.now_money|floatval=###}</td>
										<td class="textcenter">{pigcms{$vo.score_count}</td>
										<td class="textcenter"><php>if(strpos($vo['source'],'weixin')===1){</php>
										{pigcms{$client.5}
										<php>}elseif(strpos($vo['source'],'wxapp')===1){</php>
										{pigcms{$client.4}
										<php>}else{</php>
										{pigcms{$client[$vo['client']]}
										<php>}</php></td>
										<td class="textcenter"><if condition="$vo['status'] eq 1"><font color="green">正常</font><elseif condition="$vo['status'] eq 2" /><font color="red">未审核</font><else /><font color="red">禁用</font></if></td>
										<td class="textcenter"><a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('User/edit',array('uid'=>$vo['uid']))}','编辑用户信息',680,560,true,false,false,editbtn,'edit',true);"><if condition="$vo['status'] eq 2">审核<else />编辑</if></a></td>
									</tr>
								</volist>
								<tr><td class="textcenter pagebar" colspan="10">{pigcms{$pagebar}</td></tr>
							<else/>
								<tr><td class="textcenter red" colspan="10">列表为空！</td></tr>
							</if>
						</tbody>
					</table>
				</div>
			</form>
		</div>
<include file="Public:footer"/>