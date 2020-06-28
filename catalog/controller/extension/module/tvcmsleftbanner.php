<?php

class ControllerExtensionModuletvcmsleftbanner extends Controller {
	public function index($setting) {
		if($this->config->get('theme_default_directory') == "opc_electronic_electron_2501"){
			if($setting['status']){
				$language_id = (int)$this->config->get('config_language_id');
				$image = $setting['image'][$language_id];
				$this->load->model('tool/image');
				$data['image'] = $this->model_tool_image->resize($image,$this->config->get('tvcmscustomsetting_leftbanner_img_width'),$this->config->get('tvcmscustomsetting_leftbanner_img_height'));
				return $this->load->view('extension/module/tvcmsleftbanner', $data);
			}
		}
	}
}