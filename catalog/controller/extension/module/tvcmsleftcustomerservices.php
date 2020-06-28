<?php
class ControllerExtensionModuletvcmsleftcustomerservices extends Controller {
	public function index($setting) {
		if($this->config->get('theme_default_directory') == "opc_electronic_electron_2501"){
			if(!empty($setting['status'])){
			
				$status		 							= $this->status();

			    $data['status_record_form'] 			= $status['record_form'];
			    $data['status_num_services'] 			= $status['num_services'];
			    $data['status_image_upload'] 			= $status['image_upload'];
				$front_land_id 							= (int)$this->config->get('config_language_id');
				$data['title'] 							= $setting['title'][$front_land_id];

				if(!empty($data['status_record_form'])){
					$this->load->model('tool/image');
					$this->load->model('catalog/tvcmsmodule');
					$name		 						= "tvcmscustomerservices";
					$status_info 						= $this->model_catalog_tvcmsmodule->getmoduelstatus($name);
					$data_info  	 				= json_decode($status_info['setting'],1);

					foreach ($data_info['tvcmscustomerservices'] as $key => $value) {
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
				return $this->load->view('extension/module/tvcmsleftcustomerservices', $data);
			}
		}
	}
	protected function status(){
		return $this->Tvcmsthemevoltystatus->customerservicestatus();
	}
}