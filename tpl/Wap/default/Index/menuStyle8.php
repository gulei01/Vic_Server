<style type="text/css">
body { margin-bottom:60px !important; }
a, button, input { -webkit-tap-highlight-color:rgba(255, 0, 0, 0); }
ul, li { list-style:none; margin:0; padding:0 }
#plug-wrap { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.7); z-index:800; transition: all 100ms ease-out; -webkit-transition: all 100ms ease-out; }
.top_bar { position:fixed; bottom:0; right:0px; z-index:900; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); font-family: Helvetica, Tahoma, Arial, Microsoft YaHei, sans-serif; }
.plug-menu { -webkit-appearance:button; display:inline-block; width:36px; height:36px; border-radius:36px; position: absolute; bottom:17px; right: 17px; z-index:999; box-shadow: 0 0 0 4px #FFFFFF, 0 2px 5px 4px rgba(0, 0, 0, 0.25); background-color: #B70000; -webkit-transition: -webkit-transform 200ms; -webkit-transform:rotate(1deg); color:#fff; background-image:url('tpl/Wap/static/images/plug.png'); background-repeat: no-repeat; -webkit-background-size: 80% auto; background-size: 80% auto; background-position: center center; }
.plug-menu:before { font-size:20px; margin:9px 0 0 9px; }
.plug-menu:checked { -webkit-transform:rotate(135deg); }
.top_menu { margin-right: -260px; }
.top_menu>li { min-width: 86px; padding:0; height:32px; margin-bottom: 15px; margin-right: 15px; z-index:900; transition: all 200ms ease-out; -webkit-transition: all 200ms ease-out; }
.top_menu>li:last-child { margin-bottom: 80px; }
.top_menu>li a { color:#fff; font-size:20px; display: block; height: 100%; line-height: 33px; text-indent:32px; text-decoration:none; position:relative; font-size:16px; text-overflow:ellipsis; white-space:nowrap; text-align: right; }
.top_menu>li a label { border-radius:32px; padding:5px 8px; background:{pigcms{$homeInfo.plugmenucolor}; margin-right: 35px; }
.top_menu>li a img { display: block; width: 30px; height: 30px; text-indent: -999px; position: absolute; top: 50%; right: 0; margin-top: -13px; margin-left: -12px; }
 .top_menu>li.on:nth-last-child(6) {
-webkit-transform: translate(-30px, 0) rotate(-25deg);
transition: all 700ms ease-out;
-webkit-transition: all 700ms ease-out;
}
.top_menu>li.on:nth-last-child(5) {
-webkit-transform: translate(-20px, 0) rotate(-20deg);
transition: all 600ms ease-out;
-webkit-transition: all 600ms ease-out;
}
.top_menu>li.on:nth-last-child(4) {
-webkit-transform: translate(-10px, 0) rotate(-15deg);
transition: all 500ms ease-out;
-webkit-transition: all 500ms ease-out;
}
.top_menu>li.on:nth-last-child(3) {
-webkit-transform: translate(-5px, 0) rotate(-10deg);
transition: all 400ms ease-out;
-webkit-transition: all 400ms ease-out;
}
.top_menu>li.on:nth-last-child(2) {
-webkit-transform: translate(-2px, 0) rotate(-5deg);
transition: all 300ms ease-out;
-webkit-transition: all 300ms ease-out;
}
.top_menu>li.on:nth-last-child(1) {
-webkit-transform: translate(0, 0) rotate(0deg);
transition: all 200ms ease-out;
-webkit-transition: all 200ms ease-out;
}
 .top_menu>li.out:nth-of-type(1) {
-webkit-transform: translate(0, 280px) rotate(0deg);
transition: all 600ms ease-out;
-webkit-transition: all 600ms ease-out;
}
.top_menu>li.out:nth-of-type(2) {
-webkit-transform: translate(0, 235px) rotate(0deg);
transition: all 500ms ease-out;
-webkit-transition: all 500ms ease-out;
}
.top_menu>li.out:nth-of-type(3) {
-webkit-transform: translate(0, 190px) rotate(0deg);
transition: all 400ms ease-out;
-webkit-transition: all 400ms ease-out;
}
.top_menu>li.out:nth-of-type(4) {
-webkit-transform: translate(0, 145px) rotate(0deg);
transition: all 300ms ease-out;
-webkit-transition: all 300ms ease-out;
}
.top_menu>li.out:nth-of-type(5) {
-webkit-transform: translate(0, 100px) rotate(0deg);
transition: all 200ms ease-out;
-webkit-transition: all 200ms ease-out;
}
.top_menu>li.out:nth-of-type(6) {
-webkit-transform: translate(0, 55px) rotate(0deg);
transition: all 100ms ease-out;
-webkit-transition: all 100ms ease-out;
}
.top_menu>li.out { padding: 0; opacity: 0; }

#sharemcover { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.7); display: none; z-index: 20000; }
#sharemcover img { position: fixed; right: 18px; top: 5px; width: 260px; height: 180px; z-index: 20001; border:0; }
</style>
 
<div class="top_bar" style="-webkit-transform:translate3d(0,0,0)">
<nav>
     
    <ul id="top_menu" class="top_menu">
	 <input type="checkbox" id="plug-btn" class="plug-menu themeStyle" style="background-color:{pigcms{$homeInfo.plugmenucolor};background-image:url('tpl/Wap/static/images/plug.png');border:0px;">
    <volist name="catemenu" id="vo">
          <li class="themeStyle out" style=""> <a href="{pigcms{$vo.url}"><img src="{pigcms{$vo.picurl}"><label class="themeStyle">{pigcms{$vo.name}</label></a></li>
        </volist>  
</ul>
  </nav>
</div>
<div id="plug-wrap" style="display: none;" ></div>
<script>
$(function(){
        $(".plug-menu").click(function(){
        var li = $(this).parents('nav').find('ul').find('li');
        if(li.attr("class") == "themeStyle on"){
				$('.top_menu').css('margin-right','-260px');
                li.removeClass("themeStyle on");
                li.addClass("themeStyle out");
        }else{
				$('.top_menu').css('margin-right','0px');
                li.removeClass("themeStyle out");
                li.addClass("themeStyle on");

        }
        });
});
</script>