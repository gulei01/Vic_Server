<include file="Public:header"/>	<div class="mainbox">		<div id="nav" class="mainnav_title">			<ul>				<if condition="!C('butt_open')">					<a href="{pigcms{:U('Adver/index')}">广告分类列表</a>|					<a href="{pigcms{:U('Adver/adver_list',array('cat_id'=>$now_category['cat_id']))}" class="on">{pigcms{$now_category.cat_name} - 广告列表</a>|				<else/>					<a href="{pigcms{:U('Adver/adver_list',array('cat_id'=>$now_category['cat_id']))}" class="on">{pigcms{$now_category.cat_name}</a>|				</if>				<a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Adver/adver_add',array('cat_id'=>$now_category['cat_id']))}','添加广告',600,420,true,false,false,addbtn,'add',true);">添加广告</a>			</ul>		</div>		<form name="myform" id="myform" action="" method="post">			<div class="table-list">				<table width="100%" cellspacing="0">					<colgroup>						<col/>						<col/>						<if condition="$many_city eq 1">							<col/>						</if>						<col/>						<col/>						<col width="180" align="center"/>						<col width="180" align="center"/>					</colgroup>					<thead>						<tr>							<th>编号</th>							<th>名称</th>							<if condition="$many_city eq 1">								<th>城市</th>							</if>							<th>补齐</th>							<th>链接地址</th>							<th>图片(以下为强制小图，点击图片查看大图)</th>							<th class="textcenter">最后操作时间</th>							<th>状态</th>							<th class="textcenter">操作</th>						</tr>					</thead>					<tbody>						<if condition="is_array($adver_list)">							<volist name="adver_list" id="vo">								<tr>									<td>{pigcms{$vo.id}</td>									<td>{pigcms{$vo.name}</td>									<if condition="$many_city eq 1">										<if condition="$vo['city_id'] eq '通用'">											<td style="color:red;">{pigcms{$vo.city_id}</td>										<else/>											<td>{pigcms{$vo.city_id}</td>										</if>									</if>									<td><if condition="$vo.complete eq 1"><span style="color:red;">是</span><else/>否</if></td>									<td><a href="{pigcms{$vo.url}" target="_blank">访问链接</a></td>									<td>										<img src="{pigcms{$config.site_url}/upload/adver/{pigcms{$vo.pic}" style="width:300px;height:80px;" class="view_msg"/>									</td>									<td class="textcenter">{pigcms{$vo.last_time|date='Y-m-d H:i:s',###}</td>									<td>									<if condition="$vo['status'] eq 1">										<font color="green">正常</font>									<elseif condition="$vo['status'] eq 0"/>										<font color="red">关闭</font>									</if></td>									<td class="textcenter"><a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Adver/adver_edit',array('id'=>$vo['id'],'frame_show'=>true))}','查看广告信息',600,420,true,false,false,false,'add',true);">查看</a> | <a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Adver/adver_edit',array('id'=>$vo['id']))}','编辑广告信息',600,420,true,false,false,editbtn,'add',true);">编辑</a> | <a href="javascript:void(0);" class="delete_row" parameter="id={pigcms{$vo.id}" url="{pigcms{:U('Adver/adver_del')}">删除</a></td>								</tr>							</volist>						<else/>							<tr><td class="textcenter red" colspan="8">列表为空！</td></tr>						</if>					</tbody>				</table>			</div>		</form>	</div><include file="Public:footer"/>