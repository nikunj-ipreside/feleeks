<?php
class ControllerExtensionModuletvcmsnewsletter extends Controller {
	public function index($setting) {

		if($this->config->get('theme_default_directory') == "opc_electronic_electron_2501"){
			if(!empty($setting['status'])){
				$this->load->language('extension/module/tvcmsblog');
				$data['telephone']                 = $this->config->get('config_telephone');
				$data['footerlogo']                     = $this->load->controller('common/tvcmsfooterlogo');
				$data['socialicon']                     = $this->load->controller('common/tvcmssocialicon');
				$language_id 							= $this->config->get('config_language_id');
				$status 								= $this->status();
				$data['status_news_letter_title']		= $status['news_letter_title'];
				$data['title'] 							= $this->config->get('tvcmscustomsetting_customsub')['lang_text'][$language_id]['newslettertitle'];
				return $this->load->view('extension/module/tvcmsnewsletter', $data);
			}
		}
	}
	protected function status(){
		return $this->Tvcmsthemevoltystatus->customsetting();
	}
}
