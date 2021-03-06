<include file="Public:header"/>
<div class="main-content">
    <!-- 内容头部 -->
    <div class="breadcrumbs" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-user"></i>
                <a href="{pigcms{:U('import_village')}">物业管理</a>
            </li>
            <li class="active">导入房间</li>
        </ul>
    </div>
    <!-- 内容头部 -->
    <div class="page-content">
        <div class="page-content-area">
        	<button class="btn btn-success" onclick="importAdd()">导入数据</button>
            <style>
                .ace-file-input a {display:none;}
            </style>
            <div class="row">
                <div class="col-xs-12">
                    <div id="shopList" class="grid-view">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="10%">楼层编号</th>
                                    <th width="10%">楼号</th>
                                    <th width="20%">单元名称</th>
									<th width="10%">层号</th>
									<th width="10%">房间号</th>
                                    <th width="10%">添加时间</th>
                                    <th width="10%">状态</th>
                                    <th class="button-column" width="20%">操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <if condition="$result['list']">
                                    <volist name="result['list']" id="vo">
                                        <tr class="<if condition="$i%2 eq 0">odd<else/>even</if>">
                                            <td><div class="tagDiv">{pigcms{$vo.pigcms_id}</div></td>
                                            <td><div class="tagDiv">{pigcms{$vo.floor_layer}</div></td>
                                            <td><div class="tagDiv">{pigcms{$vo.floor_name}</div></td>
											<td><div class="tagDiv">{pigcms{$vo.layer}</div></td>
											<td><div class="tagDiv">{pigcms{$vo.room}</div></td>
                                            <td><div class="tagDiv">{pigcms{$vo.add_time|date='Y-m-d H:i:s',###}</div></td>
                                            <td><div class="tagDiv">
												<if condition='$vo["status"] eq 1'>
													<span class="green">空置</span>
												<elseif condition='$vo["status"] eq 2' />
													 <span class="green">审核中</span>
												<elseif condition='$vo["status"] eq 3' />
													 <span class="green">已绑定业主</span>
												<else />
													<span class="red">关闭</span>
												</if>
											</div></td>
                                            <td class="button-column">
											
											
											 <a style="width: 60px;" class="label label-sm label-info" title="编辑" href="{pigcms{:U('import_village_edit',array('id'=>$vo['pigcms_id']))}">编辑</a> 
											<a style="width: 60px;" class="label label-sm label-info" title="删除" href="javascript:void(0)" onClick="if(confirm('确认删除该条信息？')){location.href='{pigcms{:U('import_village_del',array('id'=>$vo['pigcms_id']))}'}">删除</a>
                                           </td>
                                        </tr>
                                    </volist>
                                <else/>
                                    <tr class="odd"><td class="button-column" colspan="12" >没有任何信息。</td></tr>
                                </if>
                            </tbody>
                        </table>
                        {pigcms{$result.pagebar}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{pigcms{$static_public}js/artdialog/jquery.artDialog.js"></script>
<script type="text/javascript" src="{pigcms{$static_public}js/artdialog/iframeTools.js"></script>
<script>

$(".transfrom-room").on('click' , function(){
	
	if(confirm("您确定将当前小区业主的房间信息导入进来吗？")){
		
		
			
			art.dialog.open("{pigcms{:U('updata_old_village_room_info',array('is_true_old_user'=>$is_old_data))}",{lock:true,title:'导入房间',width:760,height:500,yesText:'关闭',background: '#000',opacity: 0.45});
	

		
		//location.href="{pigcms{:U('updata_old_village_room_info',array('is_true_old_user'=>$is_old_data))}";
		
	}else{
		return flse;	
	}
		
});

function importAdd(){
	window.location.href = "{pigcms{:U('import_village_add')}";
}
function importUserDetail(){
	window.location.href = "{pigcms{:U('User/detail_import')}";
}
</script>
<include file="Public:footer"/>
