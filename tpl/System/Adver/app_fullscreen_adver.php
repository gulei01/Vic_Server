<include file="Public:header"/><style>	img{		width:100px;		height:50px;	}</style>		<div class="mainbox">			<div id="nav" class="mainnav_title">				<ul>					<a href="{pigcms{:U('Adver/app_fullscreen_adver')}" class="on">全屏广告列表</a>|					<a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Adver/app_fullscreen_add')}','添加广告',600,400,true,false,false,addbtn,'add',true);">添加广告</a>				</ul>			</div>			<form name="myform" id="myform" action="" method="post">				<div class="table-list">					<table width="100%" cellspacing="0">						<colgroup><col> <col> <col><col><col><col><col><col width="180" align="center"> </colgroup>						<thead>							<tr>								<th>编号</th>								<th>广告名称</th>								<th>日期</th>								<th>广告图片</th>								<th>链接</th>								<th>点击数</th>								<th>跳过数</th>								<th>收到数</th>								<th class="textcenter">操作</th>							</tr>						</thead>						<tbody>							<if condition="is_array($adver_list)">								<volist name="adver_list" id="vo">									<tr>										<td>{pigcms{$vo.id}</td>										<td>{pigcms{$vo.name}</td>										<td>{pigcms{$vo.add_time|date='Y-m-d H:i:s',###}</td>										<td><img src="{pigcms{$vo.ios_pic_s}" class="view_msg"  ></td>										<td><a target="_blank" href="{pigcms{$vo.url}" >链接</a></td>										<td>{pigcms{$vo.click_num}</td>										<td>{pigcms{$vo.jump_num}</td>										<td>{pigcms{$vo.recieve_num}</td>																				<td class="textcenter"><a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Adver/app_fullscreen_edit',array('id'=>$vo['id'],'frame_show'=>true))}','查看广告详情',600,400,true,false,false,false,'add',true);">查看</a> | <a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Adver/app_fullscreen_edit',array('id'=>$vo['id']))}','编辑广告详情',600,400,true,false,false,editbtn,'add',true);">编辑</a> | <a href="javascript:void(0);" class="delete_row" parameter="id={pigcms{$vo.id}" url="{pigcms{:U('Adver/app_fullscreen_del')}">删除</a></td>									</tr>								</volist>							<else/>								<tr><td class="textcenter red" colspan="9">列表为空！</td></tr>							</if>						</tbody>					</table>				</div>			</form>		</div><include file="Public:footer"/>