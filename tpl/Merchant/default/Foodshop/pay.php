<include file="Public:header"/>
<div class="main-content">
	<!-- 内容头部 -->
	<div class="breadcrumbs" id="breadcrumbs">
		<ul class="breadcrumb">
			<li>
				<i class="ace-icon fa fa-cubes"></i>
				<a href="{pigcms{:U('Foodshop/index')}">{pigcms{$config.meal_alias_name}管理</a>
			</li>
			<li class="active">{pigcms{$now_store.name}</li>
			<li class="active">自定义支付列表</li>
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
					<a class="btn btn-success" href="{pigcms{:U('Foodshop/pay_add', array('store_id' => $now_store['store_id']))}">新建自定义支付</a>
					<div id="shopList" class="grid-view">
						<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th>编号</th>
									<th>支付方式名称</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
								<if condition="$pay_list">
									<volist name="pay_list" id="vo">
										<tr class="<if condition="$i%2 eq 0">odd<else/>even</if>">
											<td>{pigcms{$vo.id}</td>
											<td>{pigcms{$vo.name}</td>
											<td>
												<a title="修改" class="green" style="padding-right:8px;" href="{pigcms{:U('Foodshop/pay_edit', array('store_id' => $vo['store_id'], 'id' => $vo['id']))}">
													<i class="ace-icon fa fa-pencil bigger-130"></i>
												</a>　　
												<a title="删除" class="red" style="padding-right:8px;" href="{pigcms{:U('Foodshop/pay_del', array('store_id' => $vo['store_id'], 'id' => $vo['id']))}">
													<i class="ace-icon fa fa-trash-o bigger-130"></i>
												</a>
											</td>
										</tr>
									</volist>
								<else/>
									<tr class="odd"><td class="button-column" colspan="3" >无内容</td></tr>
								</if>
							</tbody>
						</table>
						{pigcms{$pagebar}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(function(){
	$(document).on('click','#shopList a.red',function(){
		if(!confirm('确定要删除这条数据吗?不可恢复。')) return false;
	});
});
</script>
<include file="Public:footer"/>