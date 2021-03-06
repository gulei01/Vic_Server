//显示省份
function show_provincess(){
	$.post(choose_provincess,function(result){
		result = $.parseJSON(result);
		console.log(result);
		if(result.error == 0){
			var area_dom = '<select id="choose_provincess" name="province_idss" class="col-sm-1" style="margin-right:10px;">';
			$.each(result.list,function(i,item){
				area_dom+= '<option value="'+item.id+'" '+(item.id==$('#choose_cityareass').attr('province_idss') ? 'selected="selected"' : '')+'>'+item.name+'</option>';
			});
			area_dom+= '</select>';
			$('#choose_cityareass').prepend(area_dom);
			show_cityss($('#choose_provincess').find('option:selected').attr('value'),$('#choose_provincess').find('option:selected').html(),1);
			$('#choose_provincess').change(function(){
				show_cityss($(this).find('option:selected').attr('value'),$(this).find('option:selected').html(),1);
			});
		}else if(result.error == 2){
			var area_dom = '<select id="choose_province_hide" name="province_idss" style="display:none;">';
			area_dom += '<option value="'+result.id+'">'+result.name+'</option>';
			area_dom += '</select>';
			$('#choose_cityareass').prepend(area_dom);
			show_cityss(result.id,result.name,0);
		}else{
			window.top.msg(0,result.info,true);
			window.top.closeiframe();
		}
	});
}
//显示城市
function show_cityss(id,name,type){
	$.post(choose_cityss,{id:id,name:name,type:type},function(result){
		result = $.parseJSON(result);
		if(result.error == 0){
			var area_dom = '<select id="choose_cityss" name="city_idss" class="col-sm-1" style="margin-right:10px;">';
			$.each(result.list,function(i,item){
				area_dom+= '<option value="'+item.id+'" '+(item.id==$('#choose_cityareass').attr('city_idss') ? 'selected="selected"' : '')+'>'+item.name+'</option>';
			});
			area_dom+= '</select>';
			if(document.getElementById('choose_cityss')){
				$('#choose_cityss').replaceWith(area_dom);
			}else if(document.getElementById('choose_provincess')){
				$('#choose_provincess').after(area_dom);
			}else{
				$('#choose_cityareass').prepend(area_dom);
			}
		}else if(result.error == 2){
			var area_dom = '<select id="choose_city_hide" name="city_idss" style="display:none;">';
			area_dom += '<option value="'+result.id+'">'+result.name+'</option>';
			area_dom += '</select>';
			$('#choose_cityareass').prepend(area_dom);
		}else{
			window.top.msg(0,result.info,true,5);
			window.top.closeiframe();
		}
	});
}
$(function(){
	//检测是否需要显示城市
	if(document.getElementById('choose_cityareass')){
		show_provincess();
	}
});