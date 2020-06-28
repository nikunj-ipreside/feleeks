<?php
class ControllerExtensionModuletvcmscategoryslider extends Controller {
	public function index($setting) {
		if($this->config->get('theme_default_directory') == "opc_electronic_electron_2501"){
			if(!empty($setting['status'])){
				$this->load->model('catalog/tvcmsmodule');
				$this->load->model('tool/image');

				$lang_id 							= $this->config->get('config_language_id');
				$status		 						= $this->status();

				$status = $this->status();

		    	$data['status_main_form']				= $status['main_form'];
		    	$data['status_main_title']				= $status['main_title'];
		    	$data['status_main_short_description']	= $status['main_short_description'];
		    	$data['status_main_description']		= $status['main_description'];
		    	$data['status_main_image']				= $status['main_image'];

		    	$data['status_record_form']				= $status['record_form'];
		    	$data['status_category_title']			= $status['category_title'];
		    	$data['status_image']					= $status['image'];
		    	$data['status_title']					= $status['title'];
		    	$data['status_short_description']		= $status['short_description'];
	    		
	    		//echo "<pre>"; print_r($setting); echo "</pre>"; die;
	    		if(!empty($data['status_main_title'])){
	    			$data['tvcmscategoryslider_main_title'] 			= $setting['tvcmscategoryslider_main'][$lang_id]['tvcmscategoryslider_main_cat'];
	    		}
	    		if(!empty($data['status_main_short_description'])){
	    			$data['tvcmscategoryslider_main_shortdescription'] 	= $setting['tvcmscategoryslider_main'][$lang_id]['tvcmscategoryslider_main_short'];
	    		}
	    		if(!empty($data['status_main_description'])){
	    			$data['tvcmscategoryslider_main_description'] 		= $setting['tvcmscategoryslider_main'][$lang_id]['tvcmscategoryslider_main_des'];
	    		}
	    		if(!empty($data['status_main_image'])){
	    			$data['tvcmscategoryslider_main_img'] 				= $this->model_tool_image->resize($setting['tvcmscategoryslider_main'][$lang_id]['tvcmscategoryslider_main_img'], $this->config->get('tvcmscustomsetting_categoryslider_mainimg_width'), $this->config->get('tvcmscustomsetting_categoryslider_mainimg_height'));
	    		}
				

				if($data['status_record_form']){
					$categorysliderlist_info 	= $this->model_catalog_tvcmsmodule->gettvcategorysliderlist();

					$data['brandlist_data'] 	= array();
					foreach ($categorysliderlist_info as $key => $value) {
						if(!empty($value['tvcmscategoryslidermain_status'])){
							$data['categoryimg_data'][] = array(
								'tvcmscategoryslidersub_name'	=> $value['tvcmscategoryslidersub_name'],
								'tvcmscategoryslidersub_des'	=> html_entity_decode($value['tvcmscategoryslidersub_des']),
							    'tvcmscategoryslidermain_image' => $this->model_tool_image->resize($value['tvcmscategoryslidermain_image'], $this->config->get('tvcmscustomsetting_categoryslider_img_width'), $this->config->get('tvcmscustomsetting_categoryslider_img_height'))
							);
						}
					}
				}

				return $this->load->view('extension/module/tvcmscategoryslider', $data);
			}
		}
	}
	protected function status(){
		return $this->Tvcmsthemevoltystatus->categorysliderstatus();
	}

}