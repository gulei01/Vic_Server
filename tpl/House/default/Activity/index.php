<include file="Public:header"/>
<div class="main-content">
	<!-- 内容头部 -->
	<div class="breadcrumbs" id="breadcrumbs">
		<ul class="breadcrumb">
			<li>
				<i class="ace-icon fa fa-gear gear-icon"></i>
				<a href="{pigcms{:U('Activity/index')}">功能库</a>
			</li>
			<li class="active">社区活动列表</li>
		</ul>
	</div>
	<!-- 内容头部 -->
	<div class="page-content">
        <div class="page-content-area">
        	
            <style>
                .ace-file-input a {display:none;}
            </style>
            <div class="row">
                <div class="col-xs-12">
                
                <if condition='!$has_activity'>
                    <div style="margin-top:10px; cursor:pointer" class="alert alert-danger" onClick="window.open('{pigcms{:U('Index/index')}')">
                        <button data-dismiss="alert" class="close" type="button"><i class="ace-icon fa fa-times"></i></button>
                        还未开启&nbsp;&nbsp;<span style="font-weight:bold">首页社区活动</span>&nbsp;&nbsp;功能，请先到&nbsp;&nbsp;<span style="font-weight:bold">基本信息管理 - 基本信息设置 - 功能库配置&nbsp;&nbsp;</span>开启相应配置。
                    </div>
                <else />
                	<button class="btn btn-success" onclick="activity_add()">添加社区活动</button>
            	</if>
                
                    <div id="shopList" class="grid-view">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="20%">标题</th>
                                    <th width="15%">添加时间</th>
									<th width="15%">最后修改时间</th>
									<th width="15%">总名额&nbsp;/&nbsp;剩余名额</th>
									<th width="10%">排序</th>
									<th width="5%">状态</th>
                                    <th class="button-column" width="15%">操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <if condition="$list['list']">
                                    <volist name="list['list']" id="vo">
                                        <tr class="<if condition="$i%2 eq 0">odd<else/>even</if>">
                                            <td><div class="tagDiv">{pigcms{$vo.id}</div></td>
                                            <td><div class="tagDiv"><a target="_blank" href="{pigcms{$vo['url']}">{pigcms{$vo.title}</a></div></td>
                                           
                                            
                                           
                                            
                                            <td>
												<div class="tagDiv">{pigcms{$vo.add_time|date="Y-m-d H:i:s",###}</div>
											</td>
											
											<td>
												<if condition='$vo["last_time"]'><div class="tagDiv">{pigcms{$vo.last_time|date="Y-m-d H:i:s",###}</div></if>
											</td>
											
											<if condition='$vo["apply_now_num"]'>
												<td>
													<div class="tagDiv">{pigcms{$vo.apply_now_num}&nbsp;/&nbsp;{pigcms{$vo.remain_num}</div>
												</td>
											<elseif condition='$vo["apply_limit_num"]' />
												<td>
													<div class="tagDiv">{pigcms{$vo.apply_limit_num}&nbsp;/&nbsp;{pigcms{$vo.remain_num}</div>
												</td>
											<else />
												<td>
													<div class="tagDiv">不限</div>
												</td>
											</if>
                                             <td>
												<div class="tagDiv">{pigcms{$vo.sort}</div>
											</td>
											 <td><div class="tagDiv">
                                            <if condition='$vo["status"] eq 0'>
                                            	<span class="red">禁止</span>
                                            <else />
                                            	<span class="green">开启</span>
                                            </if>
                                            </div></td>
                                            <td class="button-column">
											<a style="width: 60px;" class="label label-sm label-info" title="报名列表" href="{pigcms{:U('apply_list',array('activity_id'=>$vo['id']))}">报名列表</a>
                                                <a style="width: 60px;" class="label label-sm label-info" title="编辑" href="{pigcms{:U('activity_edit',array('id'=>$vo['id']))}">编辑</a>
                                                <a style="width: 60px;" class="label label-sm label-info" title="删除" href="javascript:void(0)" onClick="if(confirm('确认删除该条信息？')){location.href='{pigcms{:U('activity_del',array('id'=>$vo['id']))}'}">删除</a>
                                           </td>
                                        </tr>
                                    </volist>
                                <else/>
                                    <tr class="odd"><td class="button-column" colspan="8" >没有任何社区活动。</td></tr>
                                </if>
                            </tbody>
                        </table>
                        {pigcms{$list.pagebar}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
function activity_add(){
	window.location.href = "/shequ.php?g=House&c=Activity&a=activity_add";
}
</script>

<script type="text/javascript">
var static_public="{pigcms{$static_public}",static_path="{pigcms{$static_path}",merchant_index="{pigcms{:U('Index/index')}",choose_province="{pigcms{:U('Area/ajax_province')}",choose_city="{pigcms{:U('Area/ajax_city')}",choose_area="{pigcms{:U('Area/ajax_area')}",choose_circle="{pigcms{:U('Area/ajax_circle')}";
</script>
<script type="text/javascript" src="{pigcms{$static_path}js/area.js"></script>
<script type="text/javascript" src="{pigcms{$static_path}js/map.js"></script>

<include file="Public:footer"/>