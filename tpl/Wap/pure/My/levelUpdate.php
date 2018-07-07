
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
	<title>等级升级</title>
    <meta name="viewport" content="initial-scale=1, width=device-width, maximum-scale=1, user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name='apple-touch-fullscreen' content='yes'>
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="format-detection" content="telephone=no">
	<meta name="format-detection" content="address=no">
    <link href="{pigcms{$static_path}css/eve.7c92a906.css" rel="stylesheet"/>
	<script type="text/javascript" src="{pigcms{$static_path}layer/layer.m.js" charset="utf-8"></script>
    <style>
	    #pg-account .text-icon {
	        font-size: .44rem;
	        color: #666;
	        width: .44rem;
	        text-align: center;
	        margin-right: .1rem;
	    }
	#pg-account strong{
	   color: #f76120;
	}
	.react{margin-left: 20px;}
	.leveldesc p{line-height: 25px;}
	.list-top{ height:3rem; background:#51d4d0;}
	.list-top-content{line-height:2rem; padding-top:.5rem; margin-left:.25rem}
	.list-top-content p{color:#fff; line-height:1rem}
	.list-top-content p span{ font-weight:bold;}
	.list-top-content p .current_two,.list dd .more-weak .current_two{ font-weight:normal; border:1px solid #fff; padding:.15rem; border-radius:4px}
	.list dd .more-weak .current_two{ border:1px solid #e2e2e2}
	.more-level{ font-weight:bold}
	.list{ color:#6b6b6b}
	.btn{ background:#06c1bb; height:1.25rem; }
	.btn:last-child{ background:#fff; color:#000; border:1px solid #C5C0C0}
	.btn span{ display:block; font-weight:normal}
	#pwd_verify .pwd_menu{ border-bottom:none}
	.verify_pwd p{ text-align:center; line-height:36px; height:36px}
	dl.list dd{ border-bottom:1px dashed #e5e5e5}
	.react{ margin-left:0}
	.foot-btn{ text-align:center}
	</style>
</head>

<body id="index" data-com="pagecommon">
                	<div id="tips" class="tips"></div>
					<div id="pg-account">
						<div class="list-top">
								<div class="list-top-content">
									<p>当前等级：<span>
									<php>if(isset($levelarr[$now_user['level']])){ echo $now_level = $levelarr[$now_user['level']]['lname'];}else{ if(!isset($_GET['nextlevel'])){$nextlevel=1;} echo $now_level = '暂无等级';}</php> (VIP{pigcms{$now_user['level']})</span></p>
									<p>当前享受：<span class="current_two" id="current_two"><if condition="$levelarr[$now_user['level']]['type'] eq 1">购买商品优惠{pigcms{$levelarr[$now_user['level']]['boon']}%<elseif condition="$levelarr[$now_user['level']]['type'] eq 2" />商品价格立减{pigcms{$levelarr[$now_user['level']]['boon']}元<else />无</if><img src="{pigcms{$static_path}images/u806.png" width="15px" height="15px" style="padding-left:.1rem" /></span></p>
								</div>
						</div>
						<if condition="isset($levelarr[$nextlevel])">
					<dl class="list">
						<dd>
						<dl>
						<dd>
							<div class="react  more-weak">下一等级详情：</div>
				        </dd>
						<dd>
						{pigcms{$config.level_balance}
				        	<div class="react  more-weak">等级名称：
								<span class="more-level">	
								<if condition="$config.level_balance eq 1">
									<select name="level" style="width:100px;">
										<volist name="levelarr" id="vo">
											<if condition="$vo.level gt $now_user['level']">
											<option value="{pigcms{$vo.level}" <php>if($_GET['nextlevel']==$vo['level']){</php>selected="selected"<php>}</php>>{pigcms{$vo.lname}</option>
											</if>
										</volist>
									</select>
								<else />
									{pigcms{$levelarr[$nextlevel]['lname']}(VIP{pigcms{$now_user['level']+1})
								</if>
								</span>
							</div>
							
				        </dd>
						
				        <dd>
				        	<div class="react  more-weak">可享优惠：<span class="current_two current_three" id="current_three"><if condition="$levelarr[$nextlevel]['type'] eq 1">购买商品优惠{pigcms{$levelarr[$nextlevel]['boon']}%<elseif condition="$levelarr[$nextlevel]['type'] eq 2" />商品价格立减{pigcms{$levelarr[$nextlevel]['boon']}元<else />无</if><img src="{pigcms{$static_path}images/u806_2.png" width="15px" height="15px" /></span></div>
				        </dd>
						
						<dd>
				        	<div class="react  more-weak">所需{pigcms{$config['score_name']}：<span>{pigcms{$levelarr[$nextlevel]['integral']}</span></div>
				        </dd>						<dd>
				        	<div class="react  more-weak">所需余额：<span>${pigcms{$levelarr[$nextlevel]['use_money']}</span></div>
				        </dd>
						<dd>
				        	<div class="react more-weak foot-btn">
								<a href="javascript:void(0);" class="btn" onclick="levelToupdate({pigcms{$now_user.score_count},{pigcms{$levelarr[$nextlevel]['integral']},$(this))" style="color:#FFF;">
									当前{pigcms{$config['score_name']}{pigcms{$now_user.score_count}
									<span>用{pigcms{$config['score_name']}去升级</span>
								</a>
								
								<if condition="$levelarr[$nextlevel]['use_money'] gt 0 OR $levelarr[$nextlevel]['integral'] gt 0">
								<a href="javascript:void(0);" class="btn" onclick="levelBuyupdate({pigcms{$now_user.now_money},{pigcms{$levelarr[$nextlevel]['use_money']},$(this))">
									当前余额${pigcms{$now_user.now_money}
									<span>用余额去升级</span>
								</a>
								<else />
								<dd>
						<div class="react  more-weak">没有更高的等级了！</div>
						</dd>
								</if>
							</div>
				        </dd>
							</dl>
						</dd></dl>
						</if>
		</div>
    	<script src="{pigcms{:C('JQUERY_FILE')}"></script>

	<script type="text/javascript">
		/*****等级升级******/
		var levelToupdateUrl="{pigcms{$config['site_url']}/index.php?g=User&c=Level&a=levelUpdate"
		function levelToupdate(currentscore,needscore,obj){
		currentscore=parseInt(currentscore);
		needscore=parseInt(needscore);
		if(currentscore==0){
			layer.open({
				content:"您当前没有{pigcms{$config['score_name']}！",
			});
			return false;
		}
		if(currentscore>0 && needscore>0){
			
		   if(currentscore<needscore){
			layer.open({
				content:"您当前的{pigcms{$config['score_name']}不够升级！",
			});
			  return false;
		   }
		   
		   
		   layer.open({
				content:"升级会扣除您"+needscore+"{pigcms{$config['score_name']}\n您确认要升级吗？",
				btn: ['确定','取消'],
				yes:function(){
                    obj.attr('onclick','return false');
			
					  $.post(levelToupdateUrl,{use_score:true,nextlevel:$('select').val()},function(ret){
						  window.location.reload();
					  },'JSON');
					  return false;
				}
			});
		   
		}
		}
		
		function levelBuyupdate(now_money,need_money,obj){
		if(now_money==0){
			layer.open({
				content:"您当前没有余额！请充值！",
			});
			return false;
		}
		if(now_money>0&&need_money>0){
			if(now_money<need_money){
			layer.open({
				content:"您当前余额不够升级！",
			});
			  return false;
			}
			
			layer.open({
				content:"升级会扣除您"+need_money+"元余额\n您确认要升级吗？",
				btn: ['确定','取消'],
				yes:function(){
                    obj.attr('onclick','return false');
					  $.post(levelToupdateUrl,{use_money:true,nextlevel:$('select').val()},function(ret){
						  window.location.reload();
					  },'JSON');
					  return false;
				}
			});
		}
		}
		
		$('#current_two').on('click',function(){
			var now_level = "<php>echo $now_level</php>";
			var shtml = '<p style=" text-align:center; font-weight:bold; margin-bottom:10px">'+now_level+'</p>';
			shtml +='<p style=" text-align:center;">{pigcms{$levelarr[$now_user['level']]['description']|htmlspecialchars_decode=ENT_QUOTES}</p>';
			layer.open({
				content:shtml,
				style:' height:200px; width:200px; '
			});
		})
		
		$('#current_three').on('click',function(){
			var next_level = "{pigcms{$levelarr[$nextlevel]['lname']}";
			shtml = '<p class="tips" id="tips_content"></p><p style=" text-align:center; font-weight:bold; margin-bottom:10px">'+next_level+'</p>';
			 shtml +="{pigcms{$levelarr[$nextlevel]['description']|htmlspecialchars_decode=ENT_QUOTES}";
			layer.open({
				content:shtml,
			});
		})
		
		$('select').change(function(){
			window.location.href="{pigcms{:U('My/levelUpdate')}&nextlevel="+$(this).val();
		});
</script>

{pigcms{$hideScript}
</body>
</html>