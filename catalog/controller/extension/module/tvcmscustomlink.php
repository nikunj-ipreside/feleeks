<?php
class ControllerExtensionModuletvcmscustomlink extends Controller {
	public function index($setting) {
		if($this->config->get('theme_default_directory') == "opc_electronic_electron_2501"){
			if(!empty($setting['status'])){
				$this->load->model('catalog/tvcmsmodule');
				$status 								= $this->status();
				$data['status_main_form'] 				= $status['main_form'];
				$data['status_main_title'] 				= $status['main_title'];
				$data['status_main_short_description'] 	= $status['main_short_description'];
				$data['status_record_form'] 			= $status['record_form'];
				$data['status_title'] 					= $status['title'];
				$data['status_link'] 					= $status['link'];
				$lang_id								= $this->config->get('config_language_id');
				if(!empty($data['status_main_form'])){
					if(!empty($data['status_main_title'])){
						$data['main_title'] = $setting['tvcmscustomlink_main'][$lang_id]['tvcmscustomlink_main_title'];
					}
					if(!empty($data['status_main_short_description'])){
						$data['main_short_description'] = $setting['tvcmscustomlink_main'][$lang_id]['tvcmscustomlink_main_short'];
					}
				}
				$customlinklist_info 					= $this->model_catalog_tvcmsmodule->gettvcustomlinnklist();
				$data['custlink_data'] 					= array();
				foreach ($customlinklist_info as $key => $value) {
					if(!empty($value['tvcustomlink_status'])){
						$data['custlink_data'][] = array(
							'tvcustomlink_id'	  	=> $value['tvcustomlink_id'],
							'tvcustomlink_title'	=> json_decode($value['tvcustomlink_title'],1),
							'tvcustomlink_link'	  	=> $this->url->link($value['tvcustomlink_link'], '', true)
						);
					}
				}
				return $this->load->view('extension/module/tvcmscustomlink', $data);
			}
		}
	}
	protected function status(){
		return $this->Tvcmsthemevoltystatus->customlinkstatus();
	}
}
