<?php
class ControllerCommonTvcmstags extends Controller {
	public function index() { 
		if($this->config->get('theme_default_directory') == "opc_electronic_electron_2501"){
			$this->load->model('catalog/tvcmsmodule');
			$name		 								= "tvcmstags";
			$status_info 								= $this->model_catalog_tvcmsmodule->getmoduelstatus($name);
			if(!empty($status_info)){
				$data_info   							= json_decode($status_info['setting'],1);
				$language_id 							= $this->config->get('config_language_id');
				$status		 							= $this->status();
			 	$data['status_main_form'] 				= $status['main_form'];
			    $data['status_main_title'] 				= $status['main_title'];
			    $data['status_main_short_description'] 	= $status['main_short_description'];
			    $data['status_record_form'] 			= $status['record_form'];
			    $data['status_title'] 					= $status['title'];
			    $data['status_link'] 					= $status['link'];
		    	if(!empty($data['status_main_form'])){
		    		if(!empty($data['status_main_title'])){
		    			$data['tag_title']   	= $data_info['tvcmstags_main'][$language_id]['title'];
		    		}
		    		if(!empty($data['status_main_short_description'])){
		    			$data['tag_short_des'] 	= $data_info['tvcmstags_main'][$language_id]['short_des'];
				  	}
		    	}
				if(!empty($data['status_record_form'])){			
					$taglist_info 	  		= $this->model_catalog_tvcmsmodule->gettvtaglist();
					$data['tablink_data'] 	= array();
					$data['lang_id']		= $language_id;
					foreach ($taglist_info as $key => $value) {
						if(!empty($value['tvcmstags_status'])){
							$title = json_decode($value['tvcmstags_title'],1);
							$data['tablink_data'][] = array(
								'tvcmstags_title' => $title[$language_id]['title'],
								'tvcmstags_link'  => $this->url->link($value['tvcmstags_link'], '', true)
							);
						}
					}
				}
				return $this->load->view('extension/module/tvcmstags', $data);
			}
		}
	}
	protected function status(){
		return $this->Tvcmsthemevoltystatus->tagstatus();
	}
}
