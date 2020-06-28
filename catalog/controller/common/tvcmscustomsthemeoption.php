<?php
class ControllerCommontvcmscustomsthemeoption extends Controller {
	public function index() {
		if($this->config->get('theme_default_directory') == "opc_electronic_electron_2501"){
			$data = array();
			$this->load->language('extension/module/tvcmscustomtext');
			if ($this->request->server['HTTPS']) {
				$server = $this->config->get('config_ssl');
			} else {
				$server = $this->config->get('config_url');
			}

        	$data['dir_pattern'] = $server."image/catalog/themevolty/pattern/pattern";
			$theme_option_status = $this->config->get('tvcmscustomsetting_configuration')['themeoptionstatus'];
			if(!empty($theme_option_status)){
				return $this->load->view('extension/module/tvcmscustomsthemeoption', $data);
			}
		}
	}
}