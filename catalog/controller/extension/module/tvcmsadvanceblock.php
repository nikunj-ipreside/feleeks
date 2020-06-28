<?php
class ControllerExtensionModuletvcmsadvanceblock extends Controller {
	public function index($setting) {
		
		if($this->config->get('theme_default_directory') == "opc_electronic_electron_2501"){
			if(!empty($setting['status'])){
				$this->load->model('catalog/tvcmsmodule');
				$this->load->model('tool/image');
				$languages_id 									= $this->config->get('config_language_id');

				$status 										= $this->status();
			    $data['status_record_form'] 					= $status['record_form'];
			    $data['status_title'] 							= $status['title'];
			    $data['status_link'] 							= $status['link'];
			    $data['status_description'] 					= $status['description'];
			    $data['status_short_description'] 				= $status['short_description'];
			    $data['status_image'] 							= $status['image'];

			    $data['status_main_form'] 						= $status['main_form'];
			    $data['status_main_title'] 						= $status['main_title'];
			    $data['status_main_short_description'] 			= $status['main_short_description'];
			    $data['status_main_description'] 				= $status['main_description'];
			    $data['status_main_image'] 						= $status['main_image'];
			    $data['status_main_block_form'] 				= $status['main_block_form'];
			    $data['status_main_block_title'] 				= $status['main_block_title'];
			    $data['status_main_block_short_description'] 	= $status['main_block_short_description'];
			    $data['status_main_block_description'] 			= $status['main_block_description'];
			    $data['status_main_block_btn_caption'] 			= $status['main_block_btn_caption'];
			    $data['status_main_block_link'] 				= $status['main_block_link'];
			    $data['status_main_block_image'] 				= $status['main_block_image'];

			    
			    if(!empty($data['status_main_form'])){
					if(!empty($data['status_main_title'])){
						$data['main_title'] 						= $setting['advanceblock_main'][$languages_id]['name'];
					}
					if(!empty($data['status_main_short_description'])){
						$data['main_shortdescription'] 					= $setting['advanceblock_main'][$languages_id]['shortdes'];
					}
					if(!empty($data['status_main_description'])){
						$data['main_description'] 						= $setting['advanceblock_main'][$languages_id]['des'];
					}
					if(!empty($data['status_main_image'])){
						$data['main_image'] 					= $this->model_tool_image->resize($setting['advanceblock_main'][$languages_id]['image'], $this->config->get('tvcmscustomsetting_advanceblock_mainimg_width'), $this->config->get('tvcmscustomsetting_advanceblock_mainimg_height'));
					}
				}
			    if(!empty($data['status_main_block_form'])){
					if(!empty($data['status_main_block_title'])){
						$data['main_block_title'] 				= $setting['advanceblock_block'][$languages_id]['title'];
					}
					if(!empty($data['status_main_block_short_description'])){
						$data['main_block_shortdescription'] 			= $setting['advanceblock_block'][$languages_id]['shortdes'];
					}
					if(!empty($data['status_main_block_description'])){
						$data['main_block_description'] 				= $setting['advanceblock_block'][$languages_id]['des'];
					}
					if(!empty($data['status_main_block_btn_caption'])){
						$data['main_block_btncaption'] 				= $setting['advanceblock_block'][$languages_id]['btncap'];
					}
					if(!empty($data['status_main_block_link'])){
						$data['main_block_link'] 				= $setting['advanceblock_block'][$languages_id]['link'];
					}
					if(!empty($data['status_main_block_image'])){
						$data['main_block_image'] 				= $this->model_tool_image->resize($setting['advanceblock_block'][$languages_id]['image'], $this->config->get('tvcmscustomsetting_advanceblock_sub_mainimg_width'), $this->config->get('tvcmscustomsetting_advanceblock_sub_mainimg_height'));
					}
				}
			    if($data['status_record_form']){
					$advanblock_info 			= $this->model_catalog_tvcmsmodule->getadvanceblocklist();
					$data['advanblock_data'] 	= array();
					foreach ($advanblock_info as $key => $value) {
						if(!empty($value['tvcmsadvanceblocksub_status'])){
							$data['advanblock_data'][] = array(
								'tvcmsadvanceblocksub_link'			=> $value['tvcmsadvanceblocksub_link'],
								'tvcmsadvanceblocksub_image' 		=> $this->model_tool_image->resize($value['tvcmsadvanceblocksub_image'], $this->config->get('tvcmscustomsetting_advanceblock_img_width'), $this->config->get('tvcmscustomsetting_advanceblock_img_height')),
								'tvcmsadvanceblocksub_title'		=> $value['tvcmsadvanceblocksub_title'],
								'tvcmsadvanceblocksub_des'			=> $value['tvcmsadvanceblocksub_des'],
								'tvcmsadvanceblocksub_sub_des'		=> $value['tvcmsadvanceblocksub_sub_des'],
							);
						}
					}
				}

			    
			   
							

				return $this->load->view('extension/module/tvcmsadvanceblock', $data);
			}
		}
	}
	protected function status(){
		return $this->Tvcmsthemevoltystatus->advanceblock();
	}
}
