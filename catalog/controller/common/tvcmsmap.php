<?php
class ControllerCommonTvcmsmap extends Controller {
	public function index() {
		if($this->config->get('theme_default_directory') == "opc_electronic_electron_2501"){
			$this->load->model('catalog/tvcmsmodule');
			$name		 							= "tvcmsmap";
			$status      							= $this->status();
			$status_info 							= $this->model_catalog_tvcmsmodule->getmoduelstatus($name);
			if(!empty($status_info)){
				$data_info   							= json_decode($status_info['setting'],1);
				$data['status_main_form'] 				= $status['main_form'];
				$data['status_main_title'] 				= $status['main_title'];
				$data['status_main_short_description'] 	= $status['main_short_description'];
				$data['status_main_description'] 		= $status['main_description'];
				$data['status_main_image'] 				= $status['main_image'];
				$data['status_image'] 					= $status['image'];
				$data['status_short_description'] 		= $status['short_description'];
				$data['status_description'] 			= $status['description'];
				$data['status_btn_title'] 				= $status['btn_title'];
				$data['status_api_key'] 				= $status['api_key'];
				$data['status_map_type'] 				= $status['map_type'];
				$data['status_zoom'] 					= $status['zoom'];
				$data['status_letitude'] 				= $status['letitude'];
				$data['status_longitude'] 				= $status['longitude'];
				$language_id 							= $this->config->get('config_language_id');
				if(!empty($data['status_main_form'])){
						if(!empty($data['status_main_title'])){ 
							$data['main_title'] = $data_info['tvcmsmap_des'][$language_id]['main_title']; 
						}
						if(!empty($data['status_main_short_description'])){ 
							$data['main_short_description'] = $data_info['tvcmsmap_des'][$language_id]['main_short_des']; 
						}
						if(!empty($data['status_main_description'])){
							$data['main_description'] = $data_info['tvcmsmap_des'][$language_id]['main_des'];
						}
						if(!empty($data['status_main_image'])){ 
							$data['main_image'] = $data_info['tvcmsmap_des'][$language_id]['main_img'];
						}
						if(!empty($data['status_image'])){ 
							$data['sub_logo_img'] = $data_info['tvcmsmap_des'][$language_id]['sub_logo_img']; 
						}
						if(!empty($data['status_short_description'])){
							$data['sub_short_description'] = $data_info['tvcmsmap_des'][$language_id]['sub_short_des']; 
						}
						if(!empty($data['status_description'])){ 
							$data['sub_second_description'] = $data_info['tvcmsmap_des'][$language_id]['sub_des1']; 
						}
				}
				if(!empty($data_info['status'])){
		    		if(!empty($data['status_btn_title'])){  $data['main_map_btn_title'] 	= $data_info['tvcmsmap_des'][$language_id]['sub_btn_title']; }
		    		if(!empty($data['status_map_type'])){  $data['maptype'] 	= $data_info['map']; }
		    		if(!empty($data['status_zoom'])){  $data['zoom'] 		= $data_info['zoom']; }
		    		if(!empty($data['status_letitude'])){  $data['letitude'] 	= $data_info['let']; }
		    		if(!empty($data['status_api_key'])){  $data['apikey'] 	= $data_info['api_key']; }
		    	}	if(!empty($data['status_main_title'])){  $data['longitude'] 	= $data_info['lon']; }
				return $this->load->view('extension/module/tvcmsmap', $data);
			}
		}
	}
	protected function status(){
		return $this->Tvcmsthemevoltystatus->mapstatus();
	}
}