<?php
class ControllerExtensionModuletvcmsapplication extends Controller {
	
	public function index($setting) {

		if($this->config->get('theme_default_directory') == "opc_electronic_electron_2501"){
			
			$status      							= $this->status();
			$data['status_main_form'] 				= $status['main_form'];
		    $data['status_main_title'] 				= $status['main_title'];
		    $data['status_main_short_description'] 	= $status['main_short_description'];
		    $data['status_main_description'] 		= $status['main_description'];
		    $data['status_main_image'] 				= $status['main_image'];
		    $language_id 							= $this->config->get('config_language_id');

			if(!empty($data['status_main_form'])){
				if(!empty($setting['status'])){
					if(!empty($data['status_main_image'])){
						$this->load->model('tool/image');
					}
					if(!empty($data['status_main_short_description'])){
					}
					if(!empty($data['status_main_description'])){
						$data['main_application_main_des'] 	 	= $setting['tvcmsapplication_des'][$language_id]['main_des'];
					}
					if(!empty($data['status_main_title'])){
						$data['main_application_main_title'] 	= $setting['tvcmsapplication_des'][$language_id]['main_title'];
					}
					
					
					
						$data['main_application_short_des'] 	 	= $setting['tvcmsapplication_des'][$language_id]['main_short_des'];
						$data['main_application_img'] 			= $this->model_tool_image->resize($setting['tvcmsapplication_des'][$language_id]['main_img'], 250,275);
						$data['image1'] 	= $this->model_tool_image->resize($setting['tvcmsapplication_des'][$language_id]['image1'], 150,44);
						$data['link1'] 		= $setting['tvcmsapplication_des'][$language_id]['link1'];
						$data['image2'] 	= $this->model_tool_image->resize($setting['tvcmsapplication_des'][$language_id]['image2'], 150,44);
						$data['link2'] 		= $setting['tvcmsapplication_des'][$language_id]['link2'];
						$data['image3'] 	= $this->model_tool_image->resize($setting['tvcmsapplication_des'][$language_id]['image3'], 150,44);
						$data['link3'] 		= $setting['tvcmsapplication_des'][$language_id]['link3'];

					return $this->load->view('extension/module/tvcmsapplication', $data);
				}
			}
		}
	}
	protected function status(){
		return $this->Tvcmsthemevoltystatus->applicationtatus();
	}
}
