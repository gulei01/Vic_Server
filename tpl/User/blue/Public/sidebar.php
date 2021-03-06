<div class="component-order-nav mt-component--booted">
	<div class="side-nav J-order-nav">
		<div class="J-side-nav__user side-nav__user cf">
			<a href="javascript:void(0);" title="{pigcms{:L('_ACC_SETTING_')}" class="J-user item user">
				<img src="<if condition="$now_user['avatar']">{pigcms{$now_user.avatar}<else/>{pigcms{$static_path}images/user-default-avatar.png</if>" width="30" height="30" alt="{pigcms{$now_user.nickname}"/>
			</a>
			<div class="item info_nickname">
				<div class="info__name" style="height:36px;line-height:36px;">{pigcms{$now_user.nickname}</div>
			</div>
			<div>{pigcms{:L('_B_PURE_MY_41_')}：<!--a href="{pigcms{:U('Level/index')}"-->
				<php>if(isset($levelarr[$now_user['level']])){ 
				$imgstr='';
				if(!empty($levelarr[$now_user['level']]['icon'])) $imgstr='<img src="'.$config['site_url'].$levelarr[$now_user['level']]['icon'].'" width="15" height="15">';
				echo $imgstr.' '.$levelarr[$now_user['level']]['lname'];
				}else{echo L('_NOT_LEVEL_');}</php><!--/a-->
			</div>
			<div <if condition="$config.sign_get_score eq 0">style="display:none"</if>>
				<a class="btn-white js-btn-sign sign_in" data-bk="sy_qd" href="javascript:void(0);" id="sign_today"> {pigcms{:L('_B_PURE_MY_36_')}</a>
			</div>
		</div>
		<div class="side-nav__account cf">
			<a class="item item--first" href="{pigcms{:U('Credit/index')}" title="{pigcms{$now_user.now_money}">{pigcms{$now_user.now_money}<span>{pigcms{:L('_B_PURE_MY_40_')}</span></a>
			<a class="item" href="{pigcms{:U('Point/index')}" title="{pigcms{$now_user.score_count}">{pigcms{$now_user.score_count}<span>{pigcms{:L('_TICKET_TXT_')}</span></a>
		</div>
		<dl class="side-nav__list">
			<dt class="first-item"><strong>{pigcms{:L('_MY_ORDER_')}</strong></dt>
			<dd>
				<ul class="item-list">
                    <!--<li <if condition="in_array(MODULE_NAME,array('Index')) && in_array(ACTION_NAME,array('index'))">class="current"</if>><a href="{pigcms{:U('Index/index')}">{pigcms{$config.group_alias_name}订单</a></li>
                    <if condition="isset($config['appoint_alias_name'])">
                    <li <if condition="in_array(MODULE_NAME,array('Index')) && in_array(ACTION_NAME,array('appoint_order'))">class="current"</if>><a href="{pigcms{:U('Index/appoint_order')}">{pigcms{$config.appoint_alias_name}订单</a></li>
                    </if>
                     <li <if condition="in_array(MODULE_NAME,array('Index')) && in_array(ACTION_NAME,array('meal_list'))">class="current"</if>><a href="{pigcms{:U('Index/meal_list')}">{pigcms{$config.meal_alias_name}订单</a></li> -->
					<li <if condition="in_array(MODULE_NAME,array('Index')) && in_array(ACTION_NAME,array('shop_list'))">class="current"</if>><a href="{pigcms{:U('Index/shop_list')}">{pigcms{:L('_MY_OUT_ORDER_')}</a></li>
                    <!--<if condition="isset($config['gift_alias_name'])">
                    <li <if condition="in_array(MODULE_NAME,array('Index')) && in_array(ACTION_NAME,array('gift_list'))">class="current"</if>><a href="{pigcms{:U('Index/gift_list')}">{pigcms{$config.gift_alias_name}订单</a></li>
                    </if>
                    <li <if condition="in_array(MODULE_NAME,array('Index')) && in_array(ACTION_NAME,array('lifeservice'))">class="current"</if>><a href="{pigcms{:U('Index/lifeservice')}">缴费订单</a></li>
                    <li <if condition="in_array(MODULE_NAME,array('Collect'))">class="current"</if>><a href="{pigcms{:U('Collect/index')}">我的收藏</a></li>
                    -->
				</ul>
			</dd>
			<!--<dt><strong>我的评价</strong></dt>
			<dd>
				<ul class="item-list">
					<li <if condition="in_array(MODULE_NAME,array('Rates')) && in_array(ACTION_NAME,array('index','meal','shop'))">class="current"</if>><a href="{pigcms{:U('Rates/index')}">待评价</a></li>
					<li <if condition="in_array(MODULE_NAME,array('Rates')) && in_array(ACTION_NAME,array('rated','meal_rated','shop_rated'))">class="current"</if>><a href="{pigcms{:U('Rates/rated')}">已评价</a></li>
				</ul>
			</dd-->
			<dt><strong>{pigcms{:L('_MY_ADDRESS_')}</strong></dt>
			<dd class="last">
				<ul class="item-list">
					<!--li <if condition="in_array(MODULE_NAME,array('Spread'))">class="current"</if>><a href="{pigcms{:U('Spread/index')}">我的推广</a></li>
					<if condition="isset($config['specificfield'])">
					<li <if condition="MODULE_NAME eq 'Index' AND ACTION_NAME eq 'myinfo'">class="current"</if>><a href="{pigcms{:U('Index/myinfo')}">完善信息</a></li>
					</if>
					<li <if condition="in_array(MODULE_NAME,array('Point'))">class="current"</if>><a href="{pigcms{:U('Point/index')}">我的{pigcms{$config['score_name']}</a></li>
					<li <if condition="in_array(MODULE_NAME,array('Credit'))">class="current"</if>><a href="{pigcms{:U('Credit/index')}">我的余额</a></li>
					<li <if condition="in_array(MODULE_NAME,array('Level'))">class="current"</if>><a href="{pigcms{:U('Level/index')}">我的等级</a></li-->
					<li <if condition="in_array(MODULE_NAME,array('Adress'))">class="current"</if>><a href="{pigcms{:U('Adress/index')}">{pigcms{:L('_B_PURE_MY_58_')}</a></li>
				</ul>
			</dd>
            <dt><strong>{pigcms{:L('_MY_CREDIT_CARD_')}</strong></dt>
            <dd class="last">
                <ul class="item-list">
                    <li <if condition="in_array(MODULE_NAME,array('Card'))">class="current"</if>><a href="{pigcms{:U('Card/index')}">{pigcms{:L('_CREDIT_CARD_')}</a></li>
                </ul>
            </dd>
            <dt><strong>{pigcms{:L('_B_PURE_MY_46_')}</strong></dt>
            <dd>
                <ul class="item-list">
                    <li <if condition="MODULE_NAME eq 'Coupon' AND ACTION_NAME eq 'index'">class="current"</if>>
                        <a href="{pigcms{:U('Coupon/index')}">{pigcms{:L('_PLATFORM_COUP_')}</a>
                    </li>
                    <li <if condition="MODULE_NAME eq 'Coupon' AND ACTION_NAME eq 'exchange'">class="current"</if>>
                        <a href="{pigcms{:U('Coupon/exchange')}">{pigcms{:L('_EXCHANGE_COUPON_')}</a>
                    </li>
                </ul>
            </dd>
            <!--
			<if condition="$config['portal_switch'] eq 1">
				<dt><strong>我的门户</strong></dt>
				<dd class="last">
					<ul class="item-list">
						<li <if condition="in_array(MODULE_NAME,array('Portal')) && in_array(ACTION_NAME,array('tieba'))">class="current"</if>><a href="{pigcms{:U('Portal/tieba')}">我的帖子</a></li>
					<li <if condition="in_array(MODULE_NAME,array('Yellow'))">class="current"</if>><a href="{pigcms{:U('Yellow/index')}">黄页申请</a></li>
				</ul>
			</dd>
			</if>
			-->
		</dl>
	</div>
</div>
<script>

</script>
<script>

$('#sign_today').click(function(){
	<if condition="$config.pc_sign_url neq ''">
		var pc_url = '{pigcms{$config.pc_sign_url}';
		pc_url = pc_url.substr(0,4).toLowerCase() == "http" ? pc_url : "http://" + pc_url;;
	
		window.location.href= pc_url;
	<else />
	$.post('{pigcms{:U('Index/sign')}','', function(data, textStatus, xhr) {
		artDialog({	
            content:data.msg,
            lock:true,
            style:'succeed noClose'
        });

	});
	</if>

});


</script>