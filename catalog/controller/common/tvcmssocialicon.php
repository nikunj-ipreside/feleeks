<?php
class ControllerCommontvcmssocialicon extends Controller {

	public function index() {
		if($this->config->get('theme_default_directory') == "opc_electronic_electron_2501"){

			$status 								= $this->status();
			$data['status_main_form'] 				= $status['main_form'];
			$data['status_main_image'] 				= $status['main_image'];
			$data['status_main_title'] 				= $status['main_title'];
			$data['status_main_short_description'] 	= $status['main_short_description'];
			$data['status_main_description'] 		= $status['main_description'];
			$data['status_record_form'] 			= $status['record_form'];
			$data['status_title'] 					= $status['title'];
			$data['status_link'] 					= $status['link'];
			$data['status_class_name'] 				= $status['class_name'];
			$this->load->model('catalog/tvcmsmodule');
			$this->load->model('tool/image');
			$name		 = "tvcmssocialicon";
			$status_info = $this->model_catalog_tvcmsmodule->getmoduelstatus($name);
			if(!empty($status_info)){
				$data_info   = json_decode($status_info['setting'],1);
				$language_id = $this->config->get('config_language_id');
				if(!empty($data['status_main_form'])){
					if(!empty($data['status_main_image'])){
						$data['main_image'] 			= $this->model_tool_image->resize($data_info['tvcmssocialicon_main'][$language_id]['main_img'], $this->config->get('tvcmscustomsetting_social_img_width'),$this->config->get('tvcmscustomsetting_social_img_height'));
					}
					if(!empty($data['status_main_title'])){
						$data['main_title'] 			= $data_info['tvcmssocialicon_main'][$language_id]['maintitle'];
					}
					if(!empty($data['status_main_short_description'])){
						$data['main_short_description'] = $data_info['tvcmssocialicon_main'][$language_id]['main_short_des'];
					}
					if(!empty($data['status_main_description'])){
						$data['main_description'] 		= $data_info['tvcmssocialicon_main'][$language_id]['main_des'];
					}
				}
				if(!empty($data['status_record_form'])){
					if(!empty($data_info['status'])){
						$socialllist_info 	= $this->model_catalog_tvcmsmodule->gettvsocialiconlist();
						$data['socialllist_data'] 	= array(); 		
						foreach ($socialllist_info as $key => $value) {
							if(!empty($value['tvcmssocialicon_status'])){
								$data['socialllist_data'][] = array(
									'tvcmssocialiconmain_class_name'	=> $value['tvcmssocialiconmain_class_name'],
									'tvcmssocialiconmain_link'			=> $value['tvcmssocialiconmain_link'],
									'tvcmssocialiconsub_title'			=> $value['tvcmssocialiconsub_title']
								);
							}
						}
					}
				}
				return $this->load->view('extension/module/tvcmssocialicon', $data);
			}
		}
	}
	protected function status(){
		return $this->Tvcmsthemevoltystatus->socialiconstatus();
	}
}


       

