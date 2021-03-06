
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width"/>
<meta name="apple-mobile-web-app-capable" content="yes"/>
<meta name='apple-touch-fullscreen' content='yes'/>
<meta name="apple-mobile-web-app-status-bar-style" content="black"/>
<meta name="format-detection" content="telephone=no"/>
<meta name="format-detection" content="address=no"/>

<meta charset="utf-8">
<title>{pigcms{$now_merchant['name']}会员卡</title>
<link type="text/css" rel="stylesheet" href="{pigcms{$static_path}my_card/css/card_new.css"/>
<script type="text/javascript" src="{pigcms{:C('JQUERY_FILE_190')}" charset="utf-8"></script>
<script src="{pigcms{$static_path}js/qrcode.js"></script>
<!--[if lte IE 9]>
<script src="scripts/html5shiv.min.js"></script>
<![endif]-->

</head>
<body>
    <section class="Membership">
        <div class="Mcard" >
            <dl style="{pigcms{$card.style} ">
                <dd class="clr Mcard_top" >
                    <div class="fl">
                        <img src="{pigcms{$_SESSION['user']['avatar']}">
                        <span>{pigcms{$_SESSION['user']['nickname']}</span>
                    </div>
                    <div class="fr">
                        <img src="{pigcms{$static_path}my_card/images/ewmt_07.jpg">
                    </div>
                </dd>
                <dd class="clr Mcard_end">
                    <div class="fl" style="color:{pigcms{$card.numbercolor}">{pigcms{$card.id}</div>
                   <if condition="$card.discount neq 0 AND $card.discount neq 10"> <div class="fr">{pigcms{$card.discount}折</div></if>
                </dd>
            </dl>
        </div>
		<div class="code_bg"><p id="code"></p></div>
        <div class="Mlist">
            <ul>
			
				<li id="card_money">
					<h2><i></i>余额</h2>
					<p>{pigcms{$card['card_money']+$card['card_money_give']}元</p>
				</li>
			
				
                <li id="card_score">
                    <h2><i></i>{pigcms{$config['score_name']}</h2>
                    <p>{pigcms{$card.card_score}分</p>
                </li>
			
			
                <li id="card_coupon">
                    <h2><i></i>优惠券</h2>
                    <p>{pigcms{$card.coupon_num}张</p>
                </li>
			
            </ul>
        </div>
    </section>

     <section class="Membership">
        <div class="Mlist_end">
            <ul class="clr">
                <li>
                    <a  href="{pigcms{:U('merchant_right',array('mer_id'=>$now_merchant['mer_id']))}">
                        <img src="{pigcms{$static_path}my_card/images/hyk5.png">
                        <p>会员特权</p>
                    </a>    
                </li>
                <li>
                    <a href="{pigcms{:U('merchant_personal',array('mer_id'=>$now_merchant['mer_id']))}">
                        <img src="{pigcms{$static_path}my_card/images/hyk4.png">
                        <p>个人资料</p>
                    </a>    
                </li>
				<if condition="$card.is_physical_card eq 1">
                <li>
                    <a href="{pigcms{:U('merchant_boundcard',array('mer_id'=>$now_merchant['mer_id']))}">
                        <img src="{pigcms{$static_path}my_card/images/hyk6.png">
                        <p>绑定实体会员卡</p>
                    </a>   
                </li>
				</if>
                <li>
                    <a href="{pigcms{:U('merchant_transrecord',array('mer_id'=>$now_merchant['mer_id']))}">
                        <img src="{pigcms{$static_path}my_card/images/hyk7.png">
                        <p>交易记录</p>
                    </a>
                </li>
                <li>
                    <a href="{pigcms{:U('merchant_store',array('mer_id'=>$now_merchant['mer_id']))}">
                        <img src="{pigcms{$static_path}my_card/images/hyk8.png">
                        <p>门店及电话</p>
                    </a>    
                </li>
            </ul>
        </div>
		<div class="zhezhao" style="display:none"></div>
    </section>
</body>
<style>

.zhezhao{
    position: fixed;
    background: #000;
    z-index: 999999;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0.7;
    display: none;
}
.code_bg{    
    position: absolute;
    z-index: 9999999;
    width: 220px;
    background: #fff;
    border-radius: 5px;
    left: 50%;
    margin-left: -110px;
    box-shadow: 1px 1px 7px #666;
    display:none;
    padding-top: 10px;
}

.code_bg>p{
    width: 91%;
    margin: 0 auto;
    padding-bottom: 10px;
}

.code_bg>p canvas{display: none}
</style>
<script>
	$(function(){
		$('#card_money').click(function(){
			location.href="{pigcms{:U('merchant_prepay',array('mer_id'=>$now_merchant['mer_id']))}";
		});
		
		$('#card_score').click(function(){
			location.href="{pigcms{:U('My_card/merchant_point',array('mer_id'=>$now_merchant['mer_id'],'type'=>'score'))}";
		});
		$('#card_coupon').click(function(){
			location.href="{pigcms{:U('merchant_coupon',array('mer_id'=>$now_merchant['mer_id']))}";
		});
		$('.Mcard').on('click',function(){
			$('.zhezhao').show();
			$('.code_bg').fadeIn(300);
			new QRCode(document.getElementById('code'),$('.Mcard_end .fl').html());
		});
		// 点击遮罩层 取消二维码，遮罩层
		$('.zhezhao').on('click',function(){
			$('.zhezhao').hide();
			$('.code_bg').fadeOut(300);
			$('.code_bg p').html('');
		});
	})
</script>


</html>