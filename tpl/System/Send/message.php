<include file="Public:header"/>		<div class="mainbox">			<div id="nav" class="mainnav_title">				<a href="{pigcms{:U('Send/message')}" class="on">无效对话列表</a>			</div>			<form name="myform" id="myform" action="" method="post">				<div class="table-list">					<table width="100%" cellspacing="0">						<colgroup><col> <col> <col> <col><col><col><col><col><col width="240" align="center"> </colgroup>						<thead>							<tr>								<th>用户名</th>								<th>用户头像</th>								<th>问题内容</th>								<th>回复内容</th>								<th>提问时间</th>								<th class="textcenter">操作</th>							</tr>						</thead>						<tbody>							<if condition="is_array($message_list)">								<volist name="message_list" id="vo">									<tr>										<td>{pigcms{$vo.nickname}</td>										<td><img src="{pigcms{$vo.avatar}" style="width:70px;height:70px"></td>										<td>{pigcms{$vo.question}</td>										<td>{pigcms{$vo.answer}</td>										<td><if condition="$vo['dateline']">{pigcms{$vo.dateline|date='Y-m-d H:i:s',###}<else/>无</if></td>										<td class="textcenter">											<a href="{pigcms{:U('Send/detail', array('openid' => $vo['openid']))}">查看详情</a>										</td>									</tr>								</volist>								<tr><td class="textcenter pagebar" colspan="12">{pigcms{$pagebar}</td></tr>							<else/>								<tr><td class="textcenter red" colspan="12">列表为空！</td></tr>							</if>						</tbody>					</table>				</div>			</form>		</div><include file="Public:footer"/>