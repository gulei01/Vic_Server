<include file="Public:header"/>		<div class="mainbox">			<div id="nav" class="mainnav_title">				<ul>					<a href="{pigcms{:U('Event/index')}" class="on">活动列表</a>|					<a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Event/add_coupon',array('event_id'=>$event['id']))}','创建优惠券',480,300,true,false,false,addbtn,'add',true);">创建优惠券</a>|				</ul>			</div>			<form name="myform" id="myform" action="" method="post">                <div style="font-size: 14px;padding: 5px 2px;">{pigcms{$event.name}</div>				<div class="table-list">					<table width="100%" cellspacing="0">						<colgroup>							<col/>							<col/>							<col/>							<col/>							<col/>							<col/>							<if condition="$system_session['level'] eq 2 || $system_session['level'] eq 0">								<col width="180" align="center"/>							</if>						</colgroup>						<thead>							<tr>								<th>编号</th>								<th>名称</th>								<th>消费金额</th>								<th>优惠金额</th>								<th>限制天数</th>                                <th>领取数</th>                                <th>使用数</th>                                <th>过期数</th>                                <th>优惠券类型</th>								<if condition="$system_session['level'] eq 2 || $system_session['level'] eq 0">									<th class="textcenter">操作</th>								</if>							</tr>						</thead>						<tbody>							<if condition="is_array($coupon_list)">								<volist name="coupon_list" id="vo">									<tr>										<td>{pigcms{$vo.id}</td>										<td>{pigcms{$vo.name}</td>										<td>{pigcms{$vo.use_price}</td>                                        <td>{pigcms{$vo.discount}</td>                                        <td>{pigcms{$vo.limit_day}</td>                                        <td>{pigcms{$vo.all_num}</td>                                        <td>{pigcms{$vo.use_num}</td>                                        <td>{pigcms{$vo.expiry_num}</td>                                        <td>                                            <if condition="$vo['type'] eq 0">                                                本人                                                <else />                                                邀请人                                            </if>                                        </td>										<if condition="$system_session['level'] eq 2 || $system_session['level'] eq 0">											<td class="textcenter"><a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Event/edit_coupon',array('id'=>$vo['id']))}','编辑活动分类',480,370,true,false,false,editbtn,'add',true);">编辑</a> <!--| <a href="javascript:void(0);" class="delete_row" parameter="id={pigcms{$vo.activity_id}" url="{pigcms{:U('Activity/del')}">删除</a--></td>										</if>									</tr>								</volist>							<else/>								<tr><td class="textcenter red" colspan="8">列表为空！</td></tr>							</if>						</tbody>					</table>				</div>			</form>		</div><include file="Public:footer"/>