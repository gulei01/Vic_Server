<include file="Public:header"/>
		
		<div class="mainbox">
			<div id="nav" class="mainnav_title">
				<ul>
					<a href="{pigcms{:U('Percent/score')}" class="on">积分设置</a>
				
				</ul>
			</div>
			 <form id="myform" method="post" action="/admin.php?g=System&c=Config&a=amend" refresh="true"> 
			   <table cellpadding="0" cellspacing="0" class="table_form" width="100%"  id="tab_user_score">
				<tbody>
				<tr>
				  <th width="160">积分别名</th>
				  <td><input type="text" class="input-text" name="score_name" id="config_score_name" value="{pigcms{$config.score_name}" size="10" validate="required:true" tips="积分别名" /></td>
				 </tr>
				 <tr>
				  <th width="160">消费1元获得积分数：</th>
				  <td><input type="text" class="input-text" name="user_score_get" id="config_user_score_get" value="{pigcms{:C('config.user_score_get')}" size="10" validate="required:true,number:true,min:0" tips="消费1元获得的积分" /></td>
				 </tr>
				 
				  <tr>
				  <th width="160">开启积分获取百分比：</th>
				  <td>
				  
				  <span class="cb-enable">
						<label class="cb-enable  <php>if(C('config.open_score_get_percent')==1){</php>selected<php>}</php>">
							<span>开启</span>
							<input type="radio" name="open_score_get_percent" value="1" <php>if(C('config.open_score_get_percent')==1){</php>checked="checked"<php>}</php>/>
						</label>
					</span>			     
					<span class="cb-disable">
						<label class="cb-disable  <php>if(C('config.open_score_get_percent')==0){</php>selected<php>}</php>">
							<span>关闭</span>
							<input type="radio" name="open_score_get_percent" value="0" <php>if(C('config.open_score_get_percent')==0){</php>checked="checked"<php>}</php>/>
						</label>
					</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<em tips="开启后{pigcms{$config.score_name}获取将按消费1元获得积分百分比来计算，获取积分数= 实际支付*积分获取百分比" class="notice_tips"></em>
				  </td>
				  
				  <if condition="$config['open_score_fenrun']">
					 
					  <tr>
					  <th width="160">积分分润比例</th>
					  <td><input type="text" class="input-text" name="score_fenrun_percent" id="config_score_fenrun_percent" value="{pigcms{:C('config.score_fenrun_percent')}" size="10" validate="required:true,number:true,min:0" tips="积分分润比例" /></td>
					 </tr>
				 
				  </if>
				 
				 
				  <tr>
				  <th width="160">消费1元获得积分百分比：</th>
				  <td><input type="text" class="input-text" name="score_get_percent" id="config_score_get_percent" value="{pigcms{:C('config.score_get_percent')}" size="10" validate="required:true,number:true,min:0" tips="消费1元获得积分百分比" /></td>
				 </tr>
				 
				 <tr>
				  <th width="160">积分清零时间</th>
				  <td>
				  <input type="text" class="input-text" name="score_clean_time" id="config_score_clean_time" value="{pigcms{:C('config.score_clean_time')}" size="10"  tips="积分清理时间"  onfocus="WdatePicker({readOnly:true,dateFmt:'MM-dd'})"/>	</td>
				 </tr>
				 
				  <tr>
				  <th width="160">积分清零比例</th>
				  <td><input type="text" class="input-text" name="score_clean_percent" id="config_score_clean_percent" value="{pigcms{:C('config.score_clean_percent')}" size="10" validate="required:true,number:true,min:0,max:100" tips="积分清零比例，清除奖励积分,0 不清除  100 全部清除 80 清除 80%" /></td>
				 </tr>
				 
				 <tr>
				  <th width="160">是否开启积分兑换余额：</th>
				  <td>
					<span class="cb-enable">
						<label class="cb-enable <php>if(C('config.score_recharge')==1){</php>selected<php>}</php>"><span>开启</span>
						<input type="radio" name="score_recharge" value="1" <php>if(C('config.score_recharge')==1){</php>checked="checked"<php>}</php>/>
						</label>
					</span>
					<span class="cb-disable">
						<label class="cb-disable <php>if(C('config.score_recharge')==0){</php>selected<php>}</php>"><span>关闭</span>
						<input type="radio" name="score_recharge" value="0" <php>if(C('config.score_recharge')==0){</php>checked="checked"<php>}</php>/>
						</label>
					</span>
					<em tips="开启则可以使用积分充值，但是这部分余额不能提现，只允许用户消费" class="notice_tips"></em></td>
				 </tr>
				 <tr>
				  <th width="160">兑换 1元 余额所需积分数量：</th>
				  <td><input type="text" class="input-text" name="user_score_recharge_percent" id="config_user_score_recharge_percent" value="{pigcms{:C('config.user_score_recharge_percent')}" size="10" validate="required:true,number:true,min:0" tips="(1) 0 相当于不适用积分抵扣&lt;br/&gt;(2) 如30：相当于30积分抵扣一元人民币  " /></td>
				 </tr>
				 <tr>
				  <th width="160">积分使用条件：</th>
				  <td><input type="text" class="input-text" name="user_score_use_condition" id="config_user_score_use_condition" value="{pigcms{:C('config.user_score_use_condition')}" size="10" validate="required:true,number:true,min:0" tips="(1) 0 相当于不适用积分抵扣 &lt;br/&gt;(2)积分使用条件,如: 50 ,订单满50元才可以使用" /></td>
				 </tr>
				 <tr>
				  <th width="160">抵扣1元所需积分数量：</th>
				  <td><input type="text" class="input-text" name="user_score_use_percent" id="config_user_score_use_percent" value="{pigcms{:C('config.user_score_use_percent')}" size="10" validate="required:true,number:true,min:0" tips="(1) 0 相当于不适用积分抵扣&lt;br/&gt;(2) 如30：相当于30积分抵扣一元人民币  " /></td>
				 </tr>
				 <tr>
				  <th width="160">平台总体每单最大使用积分数：</th>
				  <td><input type="text" class="input-text" name="user_score_max_use" id="config_user_score_max_use" value="{pigcms{:C('config.user_score_max_use')}" size="10" validate="required:true,number:true,min:0" tips="(1) 0 相当于不适用积分抵扣&lt;br/&gt;(2)每单最大使用积分数, 如 50,每单最多可以使用50个积分" /></td>
				 </tr>
				 <tr class="score_max">
				  <th width="160">团购每单最大使用积分数：</th>
				  <td>
					<span class="cb-enable">
						<label class="cb-enable  <php>if(C('config.group_score_max')>=0&&C('config.group_score_max')!=""){</php>selected<php>}</php>">
							<span>设置</span>
							<input type="radio" name="open_rate" value="1" <php>if(C('config.group_score_max')>=0&&C('config.group_score_max')!=""){</php>checked="checked"<php>}</php>/>
						</label>
					</span>			     
					<span class="cb-disable">
						<label class="cb-disable  <php>if(C('config.group_score_max')<0||C('config.group_score_max')==""){</php>selected<php>}</php>">
							<span>跳过</span>
							<input type="radio" name="open_rate" value="0" <php>if(C('config.group_score_max')<0||C('config.group_score_max')==""){</php>checked="checked"<php>}</php>/>
						</label>
					</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				
					
					
				  
				  <input type="text" class="input-text" name="group_score_max" id="config_group_score_max" value="{pigcms{:C('config.group_score_max')}" size="10" validate="required:true,number:true" tips="(1)如果这里选择跳过，最大使用数量将按【平台总体每单使用积分数】算&lt;br/&gt;(2) 0 相当于不适用积分抵扣&lt;br/&gt;(3)每单最大使用积分数, 如 50,每单最多可以使用50个积分" <php>if(C('config.group_score_max')<0||C('config.group_score_max')==""){</php>style="display:none"<php>}</php>/></td>
				 </tr>
				 <tr class="score_max">
				  <th width="160">快店每单最大使用积分数：</th>
				  <td>
				  <span class="cb-enable">
						<label class="cb-enable  <php>if(C('config.shop_score_max')>=0&&C('config.shop_score_max')!=""){</php>selected<php>}</php>">
							<span>设置</span>
							<input type="radio" name="open_rate" value="1" <php>if(C('config.shop_score_max')>=0&&C('config.shop_score_max')!=""){</php>checked="checked"<php>}</php>/>
						</label>
					</span>			     
					<span class="cb-disable">
						<label class="cb-disable  <php>if(C('config.shop_score_max')<0||C('config.shop_score_max')==""){</php>selected<php>}</php>">
							<span>跳过</span>
							<input type="radio" name="open_rate" value="0" <php>if(C('config.shop_score_max')<0||C('config.shop_score_max')==""){</php>checked="checked"<php>}</php>/>
						</label>
					</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			
				  
				  <input type="text" class="input-text" name="shop_score_max" id="config_shop_score_max" value="{pigcms{:C('config.shop_score_max')}" size="10" validate="required:true,number:true" tips="(1)如果这里选择跳过，最大使用数量将按【平台总体每单使用积分数】算&lt;br/&gt;(2) 0 相当于不适用积分抵扣&lt;br/&gt;(3)每单最大使用积分数, 如 50,每单最多可以使用50个积分" <php>if(C('config.shop_score_max')<0||C('config.shop_score_max')==""){</php>style="display:none"<php>}</php>/></td>
				 </tr>
				 <tr class="score_max">
				  <th width="160">餐饮每单最大使用积分数：</th>
				  <td>
					<span class="cb-enable">
						<label class="cb-enable  <php>if(C('config.meal_score_max')>=0&&C('config.meal_score_max')!=""){</php>selected<php>}</php>">
							<span>设置</span>
							<input type="radio" name="open_rate" value="1" <php>if(C('config.meal_score_max')>=0&&C('config.meal_score_max')!=""){</php>checked="checked"<php>}</php>/>
						</label>
					</span>			     
					<span class="cb-disable">
						<label class="cb-disable  <php>if(C('config.meal_score_max')<0||C('config.meal_score_max')==""){</php>selected<php>}</php>">
							<span>跳过</span>
							<input type="radio" name="open_rate" value="0" <php>if(C('config.meal_score_max')<0||C('config.meal_score_max')==""){</php>checked="checked"<php>}</php>/>
						</label>
					</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					
				  <input type="text" class="input-text" name="meal_score_max" id="config_meal_score_max" value="{pigcms{:C('config.meal_score_max')}" size="10" validate="required:true,number:true" tips="(1)如果这里选择跳过，最大使用数量将按【平台总体每单使用积分数】算&lt;br/&gt;(2) 0 相当于不适用积分抵扣&lt;br/&gt;(3)每单最大使用积分数, 如 50,每单最多可以使用50个积分" <php>if(C('config.meal_score_max')<0||C('config.meal_score_max')==""){</php>style="display:none"<php>}</php>/></td>
				 </tr>
				 <tr class="score_max">
				  <th width="160">预约每单最大使用积分数：</th>
				  <td>
					<span class="cb-enable">
						<label class="cb-enable  <php>if(C('config.appoint_score_max')>=0&&C('config.appoint_score_max')!=""){</php>selected<php>}</php>">
							<span>设置</span>
							<input type="radio" name="open_rate" value="1" <php>if(C('config.appoint_score_max')>=0&&C('config.appoint_score_max')!=""){</php>checked="checked"<php>}</php>/>
						</label>
					</span>			     
					<span class="cb-disable">
						<label class="cb-disable  <php>if(C('config.appoint_score_max')<0||C('config.appoint_score_max')==""){</php>selected<php>}</php>">
							<span>跳过</span>
							<input type="radio" name="open_rate" value="0" <php>if(C('config.appoint_score_max')<0||C('config.appoint_score_max')==""){</php>checked="checked"<php>}</php>/>
						</label>
					</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					
					
				  <input type="text" class="input-text" name="appoint_score_max" id="config_appoint_score_max" value="{pigcms{:C('config.appoint_score_max')}" size="10" validate="required:true,number:true" tips="(1)如果这里选择跳过，最大使用数量将按【平台总体每单使用积分数】算&lt;br/&gt;(2) 0 相当于不适用积分抵扣&lt;br/&gt;(3)每单最大使用积分数, 如 50,每单最多可以使用50个积分" <php>if(C('config.appoint_score_max')<0||C('config.appoint_score_max')==""){</php>style="display:none"<php>}</php>/></td>
				 </tr>
				</tbody>
			   </table> 
			   <div class="btn" style="margin-top:20px;"> 
				<input type="submit" name="dosubmit" value="提交" class="button" /> 
				
			   </div> 
			</form> 
		</div>
		<script>
		
			$(function(){
				var data_rate_arr = [];
				var test = $('.input-text').each(function(index,val){
					var ids = $(val).attr('id');
					data_rate_arr[ids] = $(val).val()
					
				});
				
				
				$('.input-text').blur(function(){
					$('.input-text').each(function(index,val){
						var ids = $(val).attr('id');
						data_rate_arr[ids] = $(val).val()
						console.log(data_rate_arr)
					});
				})

				
				$('.score_max input:radio').click(function(){
					var percent = $(this).parents('td').find('input[type="text"]');
					var text_id = percent.attr('id');
					var	open_percent = data_rate_arr[text_id];
					if($(this).val()==1){
						if(open_percent<0){
							percent.val('');
						}else{
							percent.val(open_percent);
						}
						percent.show();
					}else{
						percent.hide();
						percent.val(-1);
						percent.hide();
					}
				});
				
			});

			function add(){
				var item = $('.plus:last');
				if($('.plus').length<=1&&$('.plus').css('display')=='none'){
					$('.plus').show();
				}else{
					var newitem = $(item).clone(true);
					var No = parseInt(item.find(".sort").html())+1;
					$(item).after(newitem);
					newitem.find('input').attr('value','');
					newitem.find(".sort").html(No);
				}
				// newitem.find('input[name="url[]"]').attr('id','url'+No);
			}
			
			function del(obj){
				if($('.plus').length<=1){
					$('.plus').hide();
				}else{
					$(obj).parents('.plus').remove();
					$.each($('.plus'), function(index, val) {
						var No =index+1;
						$(val).find('.sort').html(No);
						$(val).find('input[name="url[]"]').attr('id','url'+No);
						
					});
				}
			}
		</script>
		<style>
			.table_form{border:1px solid #ddd;}
			.tab_ul{margin-top:20px;border-color:#C5D0DC;margin-bottom:0!important;margin-left:0;position:relative;top:1px;border-bottom:1px solid #ddd;padding-left:0;list-style:none;}
			.tab_ul>li{position:relative;display:block;float:left;margin-bottom:-1px;}
			.tab_ul>li>a {
				position: relative;
				display: block;
				padding: 10px 15px;
				margin-right: 2px;
				line-height: 1.42857143;
				border: 1px solid transparent;
				border-radius: 4px 4px 0 0;
				padding: 7px 12px 8px;
				min-width: 100px;
				text-align: center;
				}
				.tab_ul>li>a, .tab_ul>li>a:focus {
				border-radius: 0!important;
				border-color: #c5d0dc;
				background-color: #F9F9F9;
				color: #999;
				margin-right: -1px;
				line-height: 18px;
				position: relative;
				}
				.tab_ul>li>a:focus, .tab_ul>li>a:hover {
				text-decoration: none;
				background-color: #eee;
				}
				.tab_ul>li>a:hover {
				border-color: #eee #eee #ddd;
				}
				.tab_ul>li.active>a, .tab_ul>li.active>a:focus, .tab_ul>li.active>a:hover {
				color: #555;
				background-color: #fff;
				border: 1px solid #ddd;
				border-bottom-color: transparent;
				cursor: default;
				}
				.tab_ul>li>a:hover {
				background-color: #FFF;
				color: #4c8fbd;
				border-color: #c5d0dc;
				}
				.tab_ul>li:first-child>a {
				margin-left: 0;
				}
				.tab_ul>li.active>a, .tab_ul>li.active>a:focus, .tab_ul>li.active>a:hover {
				color: #576373;
				border-color: #c5d0dc #c5d0dc transparent;
				border-top: 2px solid #4c8fbd;
				background-color: #FFF;
				z-index: 1;
				line-height: 18px;
				margin-top: -1px;
				box-shadow: 0 -2px 3px 0 rgba(0,0,0,.15);
				}
				.tab_ul>li.active>a, .tab_ul>li.active>a:focus, .tab_ul>li.active>a:hover {
				color: #555;
				background-color: #fff;
				border: 1px solid #ddd;
				border-bottom-color: transparent;
				cursor: default;
				}
				.tab_ul>li.active>a, .tab_ul>li.active>a:focus, .tab_ul>li.active>a:hover {
				color: #576373;
				border-color: #c5d0dc #c5d0dc transparent;
				border-top: 2px solid #4c8fbd;
				background-color: #FFF;
				z-index: 1;
				line-height: 18px;
				margin-top: -1px;
				box-shadow: 0 -2px 3px 0 rgba(0,0,0,.15);
				}
				.tab_ul:before,.tab_ul:after{
				content: " ";
				display: table;
				}
				.tab_ul:after{
				clear: both;
			}
		</style>
<include file="Public:footer"/>