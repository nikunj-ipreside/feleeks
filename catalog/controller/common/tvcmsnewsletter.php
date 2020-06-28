<?php

class ControllerCommonTvcmsnewsletter extends Controller {
	public function index() {
		if($this->config->get('theme_default_directory') == "opc_electronic_electron_2501"){
			$data = array();
			$this->load->model('catalog/tvcmsmodule');
			$name		 							= "tvcmsnewsletter";
			$status_info 							= $this->model_catalog_tvcmsmodule->getmoduelstatus($name);
			if(!empty($status_info )){
				$data_info   		        		= json_decode($status_info['setting'],1);
				if(isset($data_info['status'])){
					$language_id 			= $this->config->get('config_language_id');	
					$data['title'] 			= $this->config->get('tvcmscustomsetting_customsub')['lang_text'][$language_id]['newslettertitle'];
					$data['subtitle'] 		= $this->config->get('tvcmscustomsetting_customsub')['lang_text'][$language_id]['newslettersubtitle'];
				}
				return $this->load->view('extension/module/tvcmsnewsletter', $data);
			}
		}
	}
}

			