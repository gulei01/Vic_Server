<include file="Public:header"/>
		<div class="mainbox">
			<div id="nav" class="mainnav_title">
				<ul>
					<a href="{pigcms{:U('category_field',array('cat_id'=>$now_category['cat_id']))}" class="on">字段列表</a>|
					<a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('category_field_add',array('cat_id'=>$now_category['cat_id']))}','添加字段',480,360,true,false,false,addbtn,'add',true);">添加字段</a>
				</ul>
			</div>
			<form name="myform" id="myform" action="" method="post">
				<div class="table-list">
					<table width="100%" cellspacing="0">
						<colgroup>
							<!--col/-->
							<col/>
							<col/>
							<col/>
							<!--col/-->
							<!--col width="180" align="center"/-->
						</colgroup>
						<thead>
							<tr>
								<!--th>排序</th-->
								<th>名称</th>
								<th>短标记(url)</th>
								<th>类型</th>
								<!--th>状态</th-->
								<!--th class="textcenter">操作</th-->
							</tr>
						</thead>
						<tbody>
							<if condition="is_array($now_category['cat_field'])">
								<volist name="now_category['cat_field']" id="vo">
									<tr>
										<!--td>{pigcms{$vo.sort}</td-->
										<td>{pigcms{$vo.name}</td>
										<td>{pigcms{$vo.url}</td>
										<td><if condition="$vo['type'] eq 1">多选<else/>单选</if></td>
										<!--td><if condition="$vo['status'] eq 1"><font color="green">显示</font><else/><font color="red">隐藏</font></if></td-->
										<!--td class="textcenter"><a href="javascript:void(0);" class="delete_row" parameter="cat_id={pigcms{$vo.cat_id}" url="{pigcms{:U('category_del')}">删除</a></td-->
									</tr>
								</volist>
							<else/>
								<tr><td class="textcenter red" colspan="5">商品属性字段 列表为空！</td></tr>
							</if>
						</tbody>
					</table>
				</div>
			</form>
		</div>
<include file="Public:footer"/>