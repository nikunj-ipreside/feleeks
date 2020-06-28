<?php
class ControllerCommonTvcmsfooterlogo extends Controller {
	public function index() {
		if($this->config->get('theme_default_directory') == "opc_electronic_electron_2501"){
			$this->load->model('catalog/tvcmsmodule');
			$status     							= $this->status();
			$data['status_main_form'] 				= $status['main_form'];
		    $data['status_main_title'] 				= $status['main_title'];
		    $data['status_main_short_description'] 	= $status['main_short_description'];
		    $data['status_main_description'] 		= $status['main_description'];
		    $data['status_main_image'] 				= $status['main_image'];
			if(!empty($data['status_main_form'])){
				$name		 						= "tvcmsfooterlogo";
				$status_info 						= $this->model_catalog_tvcmsmodule->getmoduelstatus($name);
				if(!empty($status_info)){
					$data_info  	 				= json_decode($status_info['setting'],1);
					$language_id 					= $this->config->get('config_language_id');
					if(!empty($data_info['status'])){
						if(!empty($data['status_main_image'])){
							$this->load->model('tool/image');
							
							$data['main_footer_img'] 			= $this->model_tool_image->resize($data_info['tvcmsfooterlogo_des'][$language_id]['main_img'], $this->config->get('tvcmscustomsetting_footerlogo_img_width'),$this->config->get('tvcmscustomsetting_footerlogo_img_height'));
						}
						if(!empty($data['status_main_short_description'])){
							$data['main_footer_short_des'] 	 	= $data_info['tvcmsfooterlogo_des'][$language_id]['main_short_des'];
						}
						if(!empty($data['status_main_description'])){
							$data['main_footer_main_des'] 	 	= $data_info['tvcmsfooterlogo_des'][$language_id]['main_des'];
						}
						if(!empty($data['status_main_title'])){
							$data['main_footer_main_title'] 	= $data_info['tvcmsfooterlogo_des'][$language_id]['main_title'];
						}

						return $this->load->view('extension/module/tvcmsfooterlogo', $data);
					}
				}
			}
		}
	}
	protected function status(){
		return $this->Tvcmsthemevoltystatus->footerstatus();
	}
}