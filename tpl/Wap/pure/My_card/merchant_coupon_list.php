<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta http-equiv="Expires" content="-1">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Pragma" content="no-cache">
<meta charset="utf-8">
<title>{pigcms{$now_merchant.name}的优惠券</title>
<link href="{pigcms{$static_path}css/swiper.min.css" rel="stylesheet"/>
<link type="text/css" rel="stylesheet" href="{pigcms{$static_path}my_card/css/card_new.css"/>
<script type="text/javascript" src="{pigcms{:C('JQUERY_FILE_190')}" charset="utf-8"></script>
<script type="text/javascript" src="{pigcms{$static_path}js/swiper-3.3.1.jquery.min.js" charset="utf-8"></script>
<script src="{pigcms{$static_path}layer/layer.m.js"></script>
<!--[if lte IE 9]>
<script src="scripts/html5shiv.min.js"></script>
<![endif]-->

</head>
<body>
    <section class="Coupons">
        <div id="slideBox" class="slideBox">
            <div class="swiper-container bd" id="swiper-container3" >
                <div class="swiper-wrapper">
				<volist name="category_tmp" id="c"  key="k">
                    <div class="swiper-slide" <if condition="$key eq $max_category">style="display:block;"</if>>
                        <ul class="end_ul">
                            <li>
                                <dl class="Receive">
								<volist name="coupon_list[$key]" id="vv">
								
                                    <dd >
                                        <a href="#" class="clr" date-type="{pigcms{$vv.coupon_id}" data-wxcardid="{pigcms{$vv.wx_cardid}" data-tickettime="{pigcms{$vv.wx_ticket_addtime}" data-sign="{pigcms{$vv.cardsign}" data-status="{pigcms{$vv.status}" data-allow_new="{pigcms{$vv.allow_new}">
                                            <div class="left">
                                                <div class="top">
                                                    <img src="{pigcms{$vv.img}" class="fl">
                                                    <div class="p60">
                                                        <h2>
                                                            <span>$<i>{pigcms{$vv.discount}</i></span>
                                                            <div class="Buytext">{pigcms{$vv.name}</div>
                                                        </h2>
                                                        <p>· 满<em>{pigcms{$vv.order_money}</em>元使用</p>
                                                    </div>    
                                                </div>
                                                <div class="end">
                                                    <p>{pigcms{$vv.start_time|date='Y年m月d日',###}至{pigcms{$vv.end_time|date='Y年m月d日',###}</p>
                                                    <p>使用平台：{pigcms{$vv.platform}</p>
                                                </div>
                                            </div>
                                            <div class="right <if condition="$vv.status eq 3">rightEnd<elseif condition ="$vv.selected eq 1" />rightAl</if>">
                                                <div class="rob">
													<if condition="$vv.status eq 3">
													<div class="Already Alreadyon"></div>
													<elseif condition ="$vv.selected eq 1"/>
													<div class="Already"></div>
													<else/>
                                                    <div class="bio-chart">
                                                        <div class="circle">
                                                            <div class="pie_left">
                                                                <div class="bf_left"></div>
                                                            </div>
                                                            <div class="pie_right">
                                                                <div class="bf_right"></div>
                                                            </div>
                                                            <div class="mask1">
                                                                <span style="display: none;">{pigcms{$vv.had_pull}</span>
                                                                <P>已领</P>
                                                                <i class="zs">{pigcms{$vv.had_pull}</i>张
                                                                <span1 style="display: none;">{pigcms{$vv.num}</span1>
                                                            </div>
                                                        </div>   
                                                    </div>    
													</if>
                                                </div>
												<if condition="$vv.status eq 3">
												<div class="collar">已抢光</div>
												<elseif condition ="$vv.selected eq 1"/>
                                                <div class="collar">已领取</div>
												<else />
                                                <div class="collar">立即领取</div>
												</if>
                                            </div>
                                            <if condition="$vv.allow_new eq 1"><div class="newuser"></div></if>
                                        </a>
                                        <div class="Coupon_sm Coupon_smon">
                                            <span class="on">使用说明</span>
                                            <div class="Coupon_text overflow">{pigcms{$vv.des}</div>
                                        </div>  
                                    </dd>
                                    </volist>
                                </dl>                        
                            </li>
                        </ul>
                    </div>
					</volist>
                   
                </div>
            </div>
            

            <div class="swiper-container hd" id="swiper-container2" >
                <div class="swiper-wrapper">
					<volist name="category_tmp" id="vc">
                    <div class="swiper-slide <if condition="$key eq $max_category">active-nav</if>">
						{pigcms{$category[$key]}
                    </div>
					</volist>
                </div>
            </div>
        </div> 
    </section>

</body>
{pigcms{$hideScript}
<script>
	<if condition="!$is_wexin_browser">
		var is_wexin_browser = false;
	<else />
		var is_wexin_browser = true;
	</if>
</script>
<script type="text/javascript">
	var is_new =Number("{pigcms{$isnew}");
	
	$(function(){
		$('dd a').click(function(event) { 
			var tmp= $(this);
			if($(this).data('wxcardid')!=''&&tmp.data('status')==1 && is_wexin_browser){	
				 layer.open({
					title:[
						'是否同步到微信优惠券',
						'background-color:#8DCE16; color:#fff;'
					],
					content: '同步微信优惠券，您可以在微信卡包中查看'
					,btn: ['是', '否']
					,yes: function(index){
						var cardlist = [];
						var i = 0;
						$('dd a').each(function(index,val){
							var wxcardid = $(val).data('wxcardid');
							var sign = $(val).data('sign');
							var tickettime = $(val).data('tickettime');
							var status = $(val).data('status');
							var allow_new = Number($(val).data('allow_new'));
							if(wxcardid!=''&&status==1&&(is_new&&allow_new||!allow_new)){
								cardlist.push({'cardId':wxcardid,'cardExt':'{"code": "", "openid": "", "timestamp":"'+tickettime+'","signature":"'+sign+'"}'});
							}
						});
						if(cardlist){
							wx.addCard({
							  cardList: 
								cardlist
							 ,
							  success: function (res) {
									layer.open({
										content: '已成功同步到微信卡包'
										,btn: ['我知道了']
									  });
								
								window.location.reload();
							  }
							});
						}
					}
					,no:function(index){
						ajax_had_pull(tmp)
					}
				});
				
			}else{
				ajax_had_pull(tmp)
			}
		});
				
	});
	
	
	function ajax_had_pull(tmp){
		$.ajax({
			url: "{pigcms{:U('My_card/had_pull')}",
			type: 'POST',
			dataType: 'json',
			data: {coupon_id:tmp.attr('date-type')},
			success:function(data){
				if(data.error_code){
					if(data.error_code == 1 || data.error_code==2){
						 layer.open({
						content: data.msg
						,btn: ['我知道了']
					  });
						 window.location.reload();
					}else if(data.error_code==3){
						 layer.open({
						content: data.msg
						,btn: ['我知道了']
					  });
						tmp.find('.rob').html('<div class="Already Alreadyon"></div>');
						tmp.find('.right').addClass('rightEnd');
						tmp.find('.collar').html('已抢光');
					}else {
						 layer.open({
						content: data.msg
						,btn: ['我知道了']
					  });
						
					}
				}else{
					tmp.find('.rob').html('<div class="Already"></div>');
					tmp.find('.right').addClass('rightAl');
					tmp.find('.collar').html('已领取');
					
					 layer.open({
						content: data.msg
						,btn: ['我知道了']
					  });
				}
			}
		});
	}
    //圆角效果  
    $(".circle").each(function(index) {
            var span1=$(this).find("span1").text();
            var num = $(this).find("span").text() * 360/span1;
            if(num<=180){
                $(this).find(".bf_right").css("transform","rotate("+num+"deg)");
                }else{
                    $(this).find(".bf_right").css("transform","rotate(180deg)");
                    $(this).find(".bf_left").css("transform","rotate("+(num-180)+"deg)");
                    }
            var b=$(this).find(".mask1 span").text();
            var c=$(this).find(".mask1 span1").text();
            var e=(b/c*100).toFixed(1)       
            $(this).find(".mask1").find("i").text(e) 
            $(this).find("i.zs").text(b);    
        });

    // 展开
    $(".Coupon_sm").each(function(){
        $(this).find("span").click(function(){
            if($(this).hasClass("on")){
                $(this).removeClass("on")
                $(this).siblings(".Coupon_text").removeClass("overflow"); 
                $(this).parents("dd").siblings().find(".Coupon_sm span").addClass("on");
                $(this).parents("dd").siblings().find(".Coupon_sm .Coupon_text").addClass("overflow"); 
            }else{
                $(this).addClass("on")
                $(this).siblings(".Coupon_text").addClass("overflow"); 
            }
            
        })
    })


    // 标题影藏超出
    $(".Buytext").each(function(){
        var w=$(this).siblings("span").width();
        $(this).width($(this).parents("h2").width()-w-82).css("left",w);
    })
   
</script>

<script> 
     var mySwiper2 = new Swiper('#swiper-container2',{
        direction : 'horizontal',
        freeMode:true,
        slidesPerView: 4.5
    })
    $(".Coupons .hd .swiper-slide").click(function(){
    $(this).addClass("active-nav").siblings(".swiper-slide").removeClass("active-nav");
    var index = $(this).index();
    $(".Coupons .bd .swiper-slide").eq(index).show().siblings(".swiper-slide").hide();
    })
</script>

</html>

 
   
  


 

 