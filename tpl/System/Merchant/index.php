<include file="Public:header"/>		<div class="mainbox">			<div id="nav" class="mainnav_title">				<ul>					<a href="{pigcms{:U('Merchant/index')}" class="on">{pigcms{:L('_BACK_MER_LIST_')}</a>                    <if condition="$system_session['level'] neq 3">					<a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Merchant/add')}','添加商户',800,560,true,false,false,addbtn,'add',true);">添加商户</a>                    </if>				</ul>			</div>			<table class="search_table" width="100%">				<tr>					<td style="width:50%;">						<form action="{pigcms{:U('Merchant/index')}" method="get">							<input type="hidden" name="c" value="Merchant"/>							<input type="hidden" name="a" value="index"/>							{pigcms{:L('_BACK_SEARCH_')}: <input type="text" name="keyword" class="input-text" value="{pigcms{$_GET['keyword']}"/>							<select name="searchtype">								<option value="name" <if condition="$_GET['searchtype'] eq 'name'">selected="selected"</if>>{pigcms{:L('_BACK_MER_NAME_')}</option>								<option value="account" <if condition="$_GET['searchtype'] eq 'account'">selected="selected"</if>>{pigcms{:L('_BACK_MER_ACC_')}</option>								<option value="phone" <if condition="$_GET['searchtype'] eq 'phone'">selected="selected"</if>>{pigcms{:L('_BACK_MER_PHONE_')}</option>								<option value="mer_id" <if condition="$_GET['searchtype'] eq 'mer_id'">selected="selected"</if>>{pigcms{:L('_BACK_CODE_')}</option>							</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;							{pigcms{:L('_BACK_MER_STATUS_')}: <select name="searchstatus">								<option value="0" <if condition="$_GET['searchstatus'] eq 0">selected="selected"</if>>{pigcms{:L('_BACK_NORMAL_')}</option>								<option value="1" <if condition="$_GET['searchstatus'] eq '1'">selected="selected"</if>>{pigcms{:L('_BACK_PENDING_')}</option>								<option value="2" <if condition="$_GET['searchstatus'] eq '2'">selected="selected"</if>>{pigcms{:L('_BACK_CLOSED_')}</option>								<option value="3" <if condition="$_GET['searchstatus'] eq '3'">selected="selected"</if>>{pigcms{:L('_BACK_ALL_')}</option>							</select>							{pigcms{:L('_BACK_SORT_ORDER_')}: <select name="searchorder">								<option value="0" <if condition="$_GET['searchorder'] eq 0">selected="selected"</if>>{pigcms{:L('_BACK_CODE_')}</option>								<option value="1" <if condition="$_GET['searchorder'] eq '1'">selected="selected"</if>>{pigcms{:L('_BACK_MER_BALANCE_')}</option>													</select>							<input type="submit" value="{pigcms{:L('_BACK_SEARCH_')}" class="button"/>						</form>					</td>                    <if condition="$system_session['level'] neq 3">					<td>						<b>{pigcms{:L('_BACK_TOTAL_MER_BA_')}：{pigcms{$all_money}</b>					</td>                    </if>				</tr>			</table>			<form name="myform" id="myform" action="" method="post">				<div class="table-list">					<table width="100%" cellspacing="0">						<colgroup><col> <col> <col> <col><col><col><col>                            <if condition="$system_session['level'] neq 3">                            <col>                            </if>                            <col width="240" align="center"> </colgroup>						<thead>							<tr>								<th>{pigcms{:L('_BACK_CODE_')}</th>								<th>{pigcms{:L('_BACK_MER_NAME_')}</th>								<th>{pigcms{:L('_BACK_MER_PHONE_')}</th>								<th>{pigcms{:L('_BACK_LAST_TIME_')}</th>								<th class="textcenter">{pigcms{:L('_BACK_VISIT_')}</th>								<!--th class="textcenter">{pigcms{:L('_BACK_CLICK_RATE_')}</th>								<th class="textcenter">{pigcms{:L('_BACK_FOLLOWER_NUM_')}</th-->								<th class="textcenter">{pigcms{:L('_BACK_ACC_BALANCE_')}</th>								<th width="5%">{pigcms{:L('_BACK_STATUS_')}</th>								<if condition="C('config.open_extra_price') eq 1">									<th>{pigcms{:C('config.extra_price_alias_name')}结算</th>								</if>                                <if condition="$system_session['level'] neq 3">								<th class="textcenter">{pigcms{:L('_BACK_MER_INVOICE_')}</th>                                </if>								<!--th class="textcenter">微店账单</th-->								<th class="textcenter">{pigcms{:L('_BACK_CZ_')}</th>							</tr>						</thead>						<tbody>							<if condition="is_array($merchant_list)">								<volist name="merchant_list" id="vo">									<tr>										<td>{pigcms{$vo.mer_id}</td>										<td>{pigcms{$vo.name}</td>										<td>{pigcms{$vo.phone}</td>										<td><if condition="$vo['last_time']">{pigcms{$vo.last_time|date='Y-m-d H:i:s',###}<else/>N/A</if></td>										<td class="textcenter"><if condition="$vo['status'] eq 1 OR $vo['status'] eq 3"><a href="{pigcms{:U('Merchant/merchant_login',array('mer_id'=>$vo['mer_id']))}" class="__full_screen_link" target="_blank">{pigcms{:L('_BACK_VISIT_')}</a><else/><a href="javascript:alert('商户状态不正常，无法访问！请先修改商户状态。');" class="__full_screen_link">访问</a></if></td>										<!--td class="textcenter">{pigcms{$vo.hits}</td>										<td class="textcenter">{pigcms{$vo.fans_count}</td-->										<td class="textcenter">{pigcms{$vo.money}</td>										<td><if condition="$vo['status'] eq 1"><font color="green">{pigcms{:L('_BACK_ACTIVE_')}</font><elseif condition="$vo['status'] eq 2"/><font color="red">{pigcms{:L('_BACK_PENDING_')}</font><elseif condition="$vo['status'] eq 3"/><font color="red">欠款</font><else/><font color="red">关闭</font></if></td>										<if condition="C('config.open_extra_price') eq 1">											<td> 商家欠平台{pigcms{$vo.extra_price_pay_for_system}个{pigcms{:C('config.extra_price_alias_name')},即{pigcms{:sprintf("%.2f",$vo['extra_price_pay_for_system']*$vo['extra_price_percent']/100)}元</td>										</if>                                        <if condition="$system_session['level'] neq 3">										<td class="textcenter"><a href="{pigcms{:U('Bill/merchant_money_list',array('mer_id'=>$vo['mer_id']))}">{pigcms{:L('_BACK_INVOICE_')}</a></td>                                        </if>										<!--td class="textcenter"><a href="{pigcms{:U('Merchant/weidian_order',array('mer_id'=>$vo['mer_id']))}">微店账单</a></td-->										<td class="textcenter">										<a href="{pigcms{:U('Merchant/store',array('mer_id'=>$vo['mer_id']))}">{pigcms{:L('_BACK_STORE_LIST_')}</a> |										<!--<a href="javascript:void(0);" onclick="window.top.show_other_frame('Group','product','mer_id={pigcms{$vo.mer_id}')">{pigcms{$config.group_alias_name}列表</a> | -->										<!--<a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Merchant/edit',array('mer_id'=>$vo['mer_id'],'frame_show'=>true))}','查看详细信息',520,370,true,false,false,false,'detail',true);">查看</a> | -->										<a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Merchant/edit',array('mer_id'=>$vo['mer_id']))}','{pigcms{:L(\'_BACK_EDIT_MER_INFO_\')}',800,560,true,false,false,editbtn,'edit',true);">{pigcms{:L('_BACK_EDIT_')}</a> |																				<a href="javascript:void(0);" class="delete_row" parameter="mer_id={pigcms{$vo.mer_id}" url="{pigcms{:U('Merchant/del')}">{pigcms{:L('_BACK_DEL_')}</a>										</td>									</tr>								</volist>                                <tr><td class="textcenter pagebar" <if condition="$system_session['level'] neq 3">colspan="9"<else />colspan="8"</if>>{pigcms{$pagebar}</td></tr>							<else/>								<tr><td class="textcenter red" <if condition="$system_session['level'] neq 3">colspan="9"<else />colspan="8"</if>>{pigcms{:L('_BACK_EMPTY_')}</td></tr>							</if>						</tbody>					</table>				</div>			</form>		</div><include file="Public:footer"/>