<?php
class ControllerExtensionModuletvcmsstorelocation extends Controller {
	public function index($setting) {
		if($this->config->get('theme_default_directory') == "themevolty_fashion_101"){
			$this->load->language('extension/module/tvcmscustomtext');
			$data['store'] 				= $this->config->get('config_name');
			$data['address'] 			= nl2br($this->config->get('config_address'));
			$data['telephone'] 			= $this->config->get('config_telephone');
			$data['store_email'] 		= $this->config->get('config_email');
			return $this->load->view('extension/module/tvcmsstorelocation',$data);
		}
	}
}