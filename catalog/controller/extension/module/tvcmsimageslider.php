<?php
class ControllerExtensionModuleTvcmsimageslider extends Controller {
	public function index($setting) {
		if($this->config->get('theme_default_directory') == "opc_electronic_electron_2501"){
			
			if(!empty($setting['status'])){
				$this->load->model('catalog/tvcmsmodule');
				$this->load->model('tool/image');
				$data['speed']		 			= $setting['speed'];
				$data['hover'] 					= $setting['hover'];
				$data['loop'] 					= $setting['loop'];
				$data['slider'] 				= $setting['slider'];
				$imgsliderlist_info 			= $this->model_catalog_tvcmsmodule->gettvimageliderlist();
				$data['imagesliderlist_data'] 	= array();
				$data['sliderofferbanner']      = $this->load->controller('common/tvcmssliderofferbanner');

				$status = $this->status();
				$data['record_targeturl'] 		= $status['record_targeturl'];
				$data['record_title'] 			= $status['record_title'];
				$data['record_descriptionmain'] = $status['record_descriptionmain'];
				$data['record_descriptionsub'] 	= $status['record_descriptionsub'];
				$data['record_image'] 			= $status['record_image'];
				$data['record_textalignment'] 	= $status['record_textalignment'];
				$data['record_buttoncaption'] 	= $status['record_buttoncaption'];

				foreach ($imgsliderlist_info as $key => $value) {
					if(!empty($value['tvcmsimageslidersub_enable'])){
						$data['imagesliderlist_data'][] = array(
							'ttvcmsimageslidersub_link'			=> $value['tvcmsimageslidersub_link'],
							'ttvcmsimageslidersub_image' 		=> $this->model_tool_image->resize($value['tvcmsimageslidersub_image'], $this->config->get('tvcmscustomsetting_sliderimage_img_width'), $this->config->get('tvcmscustomsetting_sliderimage_img_height')),
							'ttvcmsimageslidersub_title'			=> $value['tvcmsimageslidersub_title'],
							'ttvcmsimageslidersub_textaligment'	=> $value['tvcmsimageslidersub_textaligment'],
							'ttvcmsimageslidersub_buttoncaption'	=> $value['tvcmsimageslidersub_buttoncaption'],
							'ttvcmsimageslidersub_des_main'		=> $value['tvcmsimageslidersub_des_main'],
							'ttvcmsimageslidersub_des_sub'		=> $value['tvcmsimageslidersub_des_sub'],
						);
					}
				}
				return $this->load->view('extension/module/tvcmsimageslider', $data);
			}
		}
	}
	protected function status(){
		return $this->Tvcmsthemevoltystatus->imageslider();
	}
}