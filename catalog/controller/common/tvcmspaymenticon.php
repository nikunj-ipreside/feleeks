<?php
class ControllerCommontvcmspaymenticon extends Controller {
	public function index() {
		if($this->config->get('theme_default_directory') == "opc_electronic_electron_2501"){
			$status 								= $this->status();
			$data['status_main_form'] 				= $status['main_form'];
		    $data['status_main_title'] 				= $status['main_title'];
		    $data['status_main_short_description'] 	= $status['main_short_description'];
		    $data['status_main_description'] 		= $status['main_description'];
		    $data['status_main_image'] 				= $status['main_image'];
		    $data['status_record_form'] 			= $status['record_form'];
		    $data['status_title'] 					= $status['title'];
		    $data['status_image'] 					= $status['image'];
		    $data['status_link'] 					= $status['link'];
			$this->load->model('catalog/tvcmsmodule');
			$name		 							= "tvcmspaymenticon";
			$setting_info 							= $this->model_catalog_tvcmsmodule->getmoduelstatus($name);
			if(!empty($setting_info)){
				$data_info   						= json_decode($setting_info['setting'],1);
		 		$data['lang_id'] 					= $this->config->get('config_language_id');
				if(!empty($data['status_main_form'])){
					if(!empty($data['status_main_image'])){ 
						$data['main_image'] 			= $this->model_tool_image->resize($data_info['tvcmspaymenticon_main'][$data['lang_id']]['main_img'], $this->config->get('tvcmscustomsetting_payment_mainimg_width'),$this->config->get('tvcmscustomsetting_payment_mainimg_height'));
					}
					if(!empty($data['status_main_title'])){ 
						$data['main_title'] 			= $data_info['tvcmspaymenticon_main'][$data['lang_id']]['maintitle'];
					}
					if(!empty($data['status_main_short_description'])){ 
						$data['main_short_description'] = $data_info['tvcmspaymenticon_main'][$data['lang_id']]['main_short_des'];
					}
					if(!empty($data['status_main_description'])){ 
						$data['main_description'] 		= $data_info['tvcmspaymenticon_main'][$data['lang_id']]['main_des'];
					}
				}
				if(!empty($data['status_record_form'])){
					if(!empty($data_info['status'])){
						$this->load->model('tool/image');
						$paymenticonlist_info  		= $this->model_catalog_tvcmsmodule->gettvpaymentlist();
						$data['paymenticon_data'] 	= array();
						foreach ($paymenticonlist_info as $key => $value) {
							if(!empty($value['tvcmspaymenticon_status'])){
								$data['paymenticon_data'][] = array(
									'tvcmspaymenticonmain_image'	=> $this->model_tool_image->resize($value['tvcmspaymenticonmain_image'], $this->config->get('tvcmscustomsetting_payment_img_width'),$this->config->get('tvcmscustomsetting_payment_img_height')),
									'tvcmspaymenticonmain_link'	  	=> $value['tvcmspaymenticonmain_link'],
									'tvcmspaymenticonsub_title'	  	=> $value['tvcmspaymenticonsub_title']
								);
							}
						}
					}
				}
				return $this->load->view('extension/module/tvcmspaymenticon', $data);
			}
		}
	}
	protected function status(){
		return $this->Tvcmsthemevoltystatus->paymenticonsatus();
	}
}

