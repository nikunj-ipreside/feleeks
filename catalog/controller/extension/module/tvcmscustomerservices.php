<?php
class ControllerExtensionModuleTvcmscustomerservices extends Controller {
	public function index($setting) {
		//echo "<pre>"; print_r($setting); echo "</pre>"; die;
    	if($this->config->get('theme_default_directory') == "opc_electronic_electron_2501"){

			$status		 							= $this->status();
		
			$data['status_main_form'] 				= $status['main_form'];
		    $data['status_main_title'] 				= $status['main_title'];
		    $data['status_main_short_description'] 	= $status['main_short_description'];
		    $data['status_main_description'] 		= $status['main_description'];
		    $data['status_main_image'] 				= $status['main_image'];
		    $data['status_record_form'] 			= $status['record_form'];
		    $data['status_num_services'] 			= $status['num_services'];
		    $data['status_image_upload'] 			= $status['image_upload'];
			$front_land_id 							= (int)$this->config->get('config_language_id');

			if(!empty($data['status_main_form'])){
				if(!empty($data['status_main_title'])){
					$data['tvcmscustomerservices_main_title'] 		= $setting['tvcmscustomerservices_main'][$front_land_id]['tvcmscustomerservices_main_title'];
				}
				if(!empty($data['status_main_short_description'])){
					$data['tvcmscustomerservices_main_short_des'] 	= $setting['tvcmscustomerservices_main'][$front_land_id]['tvcmscustomerservices_main_short_des'];
				}
				if(!empty($data['status_main_description'])){
					$data['tvcmscustomerservices_main_des'] 		= $setting['tvcmscustomerservices_main'][$front_land_id]['tvcmscustomerservices_main_des'];
				}
				if(!empty($data['status_main_image'])){
					$data['tvcmscustomerservices_main_img'] 		= $this->model_tool_image->resize($setting['tvcmscustomerservices_main'][$front_land_id]['tvcmscustomerservices_main_img'], $this->config->get('tvcmscustomsetting_customerservice_mainimg_width'),$this->config->get('tvcmscustomsetting_customerservice_mainimg_height'));
				}
			}
			if(!empty($data['status_record_form'])){
				if(!empty($setting['status'])){
					$this->load->model('tool/image');
					foreach ($setting['tvcmscustomerservices'] as $key => $value) {
						
						for ($i=1; $i <=$data['status_num_services']; $i++) { 
							if(!empty($value['tvcmscustomerservices_status_'.$i.''])){
								if(!empty( $data['image_upload'])){
									$data['tvcmscustomerservices_img_'.$i.''] = $this->model_tool_image->resize($value['tvcmscustomerservices_img_'.$i.''], $this->config->get('tvcmscustomsetting_customerservice_img_width'),$this->config->get('tvcmscustomsetting_customerservice_img_height'));
								}
								$data['tvcmscustomerservices_cap_'.$i.''] = $value['tvcmscustomerservices_cap_'.$i.''];
								$data['tvcmscustomerservices_des_'.$i.''] = $value['tvcmscustomerservices_des_'.$i.''];
							}
						}
					}
				}
			}
			return $this->load->view('extension/module/tvcmscustomerservices', $data);
		}
	}
	protected function status(){
		return $this->Tvcmsthemevoltystatus->customerservicestatus();
	}
}
