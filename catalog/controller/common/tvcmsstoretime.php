<?php

class ControllerCommontvcmsstoretime extends Controller {
	public function index() {
		if($this->config->get('theme_default_directory') == "opc_electronic_electron_2501"){
			$this->load->model('catalog/tvcmsmodule');
			$name		 = "tvcmsstoretime";
			$status_info = $this->model_catalog_tvcmsmodule->getmoduelstatus($name);
			if(!empty($status_info)){
				$data_info   = json_decode($status_info['setting'],1);
				$language_id = $this->config->get('config_language_id');
				if(!empty($data_info['status'])){
					$data['tvcmsstoretime_status'] 			= $data_info['status'];
					$data['tvcmsstoretime_monday_friday'] 	= $data_info['tvcmsstoretime_monday_friday'];
					$data['tvcmsstoretime_saterday'] 	 	= $data_info['tvcmsstoretime_saterday'];
					$data['tvcmsstoretime_sunday'] 			= $data_info['tvcmsstoretime_sunday'];
					$data['tvcmsstoretime_title'] 			= $data_info['tvcmsstoretime'][$language_id]['title'];
					$data['tvcmsstoretime_information'] 	= $data_info['tvcmsstoretime'][$language_id]['information'];

				}
				return $data;
			}
		}
	}
}


