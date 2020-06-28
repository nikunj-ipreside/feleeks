<?php
class ControllerCommontvcmssliderofferbanner extends Controller {
	public function index() { 
			$this->load->model('catalog/tvcmsmodule');
      if($this->config->get('theme_default_directory') == "opc_electronic_electron_2501"){
			$this->load->model('tool/image');
			$name		 								= "tvcmssliderofferbanner";
			$status_info 								= $this->model_catalog_tvcmsmodule->getmoduelstatus($name);
			if(!empty($status_info)){
				$setting_info   							= json_decode($status_info['setting'],1);
				$language_id 							= $this->config->get('config_language_id');
				$status		 							= $this->status();
				$data['status_title'] 					= $status['title'];
				$data['status_shortdescription'] 		= $status['shortdescription'];
				$data['status_description'] 			= $status['description'];
				$data['status_buttoncaption'] 			= $status['buttoncaption'];
				$data['status_main_image'] 				= $status['main_image'];
				$data['status_main_title'] 				= $status['main_title'];
				$data['status_main_shortdescription'] 	= $status['main_sub_title'];
				$data['status_main_description'] 		= $status['main_description'];

	    		if(!empty($setting_info['status'])){
	    			$data['tvcmssliderofferbanner_link'] 	= $setting_info['tvcmssliderofferbanner_link'];
   					$data['image'] = $this->model_tool_image->resize($setting_info['tvcmssliderofferbanner'][$language_id]['image'], 241,515);

   					if(!empty($data['status_title'])){
   						$data['title'] = $setting_info['tvcmssliderofferbanner'][$language_id]['title'];
   					}

   					if(!empty($data['status_shortdescription'])){
   						$data['short_description'] = $setting_info['tvcmssliderofferbanner'][$language_id]['short_description'];
   					}
   					if(!empty($data['status_description'])){
   						$data['description'] = $setting_info['tvcmssliderofferbanner'][$language_id]['description'];
   					}
   					if(!empty($data['status_buttoncaption'])){
   						$data['button_caption'] = $setting_info['tvcmssliderofferbanner'][$language_id]['button_caption'];
   					}
   					$data['alignment'] = $setting_info['tvcmssliderofferbanner'][$language_id]['alignment'];

   					if(!empty($data['status_main_image'])){
   						$data['main_image'] = $setting_info['tvcmssliderofferbanner'][$language_id]['main_image'];
   					}
   					if(!empty($data['status_main_title'])){
   						$data['main_title'] = $setting_info['tvcmssliderofferbanner'][$language_id]['main_title'];
   					}
   					if(!empty($data['status_main_shortdescription'])){
   						$data['main_short_description'] = $setting_info['tvcmssliderofferbanner'][$language_id]['main_short_description'];
   					}
   					if(!empty($data['status_main_description'])){
   						$data['main_description'] = $setting_info['tvcmssliderofferbanner'][$language_id]['main_description'];
   					}
   				}
				return $this->load->view('extension/module/tvcmssliderofferbanner', $data);
   					
			}
		}
	}
	protected function status(){
		return $this->Tvcmsthemevoltystatus->sliderofferbanner();
	}
}
