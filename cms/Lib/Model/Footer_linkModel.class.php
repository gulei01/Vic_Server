<?php
class Footer_linkModel extends Model{
	/*得到底部导航*/
	public function get_list(){
		$footer_link_list = $this->field(true)->order('`id` ASC')->select();
		if($footer_link_list){
			foreach($footer_link_list as $k=>&$value){
                //modify garfunkel
			    $footer_link_list[$k]['name'] = lang_substr($value['name']);

				if(empty($value['url'])){
					$value['url'] = C('config.config_site_url').'/intro/'.$value['id'].'.html';
					$value['out_link'] = false;
				}else{
					$value['out_link'] = true;
				}
			}
		}
		if(C('config.many_city')){
			foreach($footer_link_list as &$value){
				if($value['out_link'] && substr($value['url'],-6) == 'nocity'){
					$value['url'] = substr($value['url'],0,strlen($value['url'])-6);
				}else{
					$value['url'] = str_replace(C('config.config_site_url'),C('config.now_site_url'),$value['url']);
				}
			}
		}
		return $footer_link_list;
	}
	/*得到单个底部导航*/
	public function get_link($id){
		$footer_link = $this->field(true)->where(array('id'=>$id))->find();
		if($footer_link){
		    //modify garfunkel
            $footer_link['name'] = lang_substr($footer_link['name']);
            $footer_link['content'] = lang_substr($footer_link['content']);
			if(empty($footer_link['url'])){
				$footer_link['url'] = C('config.config_site_url').'/intro/'.$footer_link['id'].'.html';
				$footer_link['out_link'] = false;
			}else{
				$footer_link['out_link'] = true;
			}
			if(empty($footer_link['title'])){
				$footer_link['title'] = $footer_link['name'];
			}
		}
		return $footer_link;
	}
}

?>