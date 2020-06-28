<?php
class ControllerExtensionModuleTvcmsbrandlist extends Controller {
	public function index($setting) {
		if($this->config->get('theme_default_directory') == "opc_electronic_electron_2501"){
			if(!empty($setting['status'])){
				$this->load->model('catalog/tvcmsmodule');
				$this->load->model('tool/image');

				$status		 								= $this->status();
				$data['status_main_form'] 					= $status['main_form'];
	    		$data['status_main_title'] 					= $status['main_title'];
	    		$data['status_main_description'] 			= $status['main_description'];
	    		$data['status_main_short_description'] 		= $status['main_short_description'];
	    		$data['status_main_image'] 					= $status['main_image'];
	    		$data['status_record_form'] 				= $status['record_form'];
	    		$data['status_title'] 						= $status['title'];
	    		$data['status_short_description'] 			= $status['short_description'];
	    		$data['status_description'] 				= $status['description'];
	    		$data['status_image'] 						= $status['image'];
	    		$data['status_link'] 						= $status['link'];
	    		$lang_id 									= $this->config->get('config_language_id');

	    		if(!empty($data['status_main_form'])){
		    		if(!empty($data['status_main_title'])){
						$data['main_title'] 					= $setting['tvcmsbrandlist_main'][$lang_id]['title'];
		    		}
		    		if(!empty($data['status_main_description'])){
						$data['main_description']	 			= $setting['tvcmsbrandlist_main'][$lang_id]['des'];
					}
					if(!empty($data['status_main_short_description'])){
						$data['main_short_description'] 		= $setting['tvcmsbrandlist_main'][$lang_id]['short'];
					}
					if(!empty($data['status_main_image'])){
						$data['main_img'] 						= $setting['tvcmsbrandlist_main'][$lang_id]['img'];
					}
	            }
	    		if(!empty($data['status_record_form'])){
					$brandlist_info 		= $this->model_catalog_tvcmsmodule->gettvbrandlist();
					$data['brandlist_data'] = array();

		 			foreach ($brandlist_info as $key => $value) {
						if($value['tvcmsbrandlist_status']){
							
							$data['brandlist_data'][] = array(
								'tvcmsbrandlist_link'	=> $value['tvcmsbrandlist_link'],
								'tvcmsbrandlist_lang'	=> json_decode($value['tvcmsbrandlist_lang'],1)[$lang_id],
								'tvcmsbrandlist_img' 	=> $this->model_tool_image->resize($value['tvcmsbrandlist_img'], $this->config->get('tvcmscustomsetting_brand_img_width'), $this->config->get('tvcmscustomsetting_brand_img_height'))
							);
						}
					}
				}
				return $this->load->view('extension/module/tvcmsbrandlist', $data);
			}
		}
	}
	protected function status(){
		return $this->Tvcmsthemevoltystatus->brandstatus();
	}

}
