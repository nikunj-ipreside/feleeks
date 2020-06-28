<?php
class ControllerExtensionModuleTvcmstestimonial extends Controller {
	public function index($setting) {
		if($this->config->get('theme_default_directory') == "opc_electronic_electron_2501"){

			if(!empty($setting['status'])){
				$status									= $this->status();
				$data['status_main_form']				= $status['main_form'];
	   			$data['status_main_title'] 				= $status['main_title'];
	   			$data['status_main_short_descrition'] 	= $status['main_short_description'];
	   			$data['status_main_descrition'] 		= $status['main_description'];
	   			$data['status_main_image'] 				= $status['main_image'];
	   			$data['status_record_form'] 			= $status['record_form'];
	   			$data['status_description'] 			= $status['description'];
	   			$data['status_title'] 					= $status['title'];
	   			$data['status_designation'] 			= $status['designation'];
	   			$data['status_signature_text'] 			= $status['signature_text'];
	   			$data['status_short_description'] 		= $status['short_description'];
	   			$data['status_image'] 					= $status['image'];
	   			$data['status_signature_image'] 		= $status['signature_image'];
	   			$data['status_link'] 					= $status['link'];

	 			$data['lang_id'] 						= $this->config->get('config_language_id');


	 			if(!empty($data['status_main_form'])){
	 				if(!empty($data['status_main_title'])){
						$data['main_title'] 	= $setting['tvcmstestimonial_main'][$data['lang_id']]['maintitle'];
					}
					if(!empty($data['status_main_short_descrition'])){
						$data['main_short_des']	= $setting['tvcmstestimonial_main'][$data['lang_id']]['main_short_des'];
					}
					if(!empty($data['status_main_descrition'])){
						$data['main_des'] 	 	= $setting['tvcmstestimonial_main'][$data['lang_id']]['main_des'];                    
					}
					if(!empty($data['status_main_image'])){	
						$data['main_img'] 		= $this->model_tool_image->resize($setting['tvcmstestimonial_main'][$data['lang_id']]['main_img'], $this->config->get('tvcmscustomsetting_testimonial_mainimg_width'), $this->config->get('tvcmscustomsetting_testimonial_mainimg_height'));
					}
	 			}
	 			if(!empty($data['status_record_form'])){

					$this->load->model('catalog/tvcmsmodule');
					$this->load->model('tool/image');
					$testimoniallist_info 	= $this->model_catalog_tvcmsmodule->gettvtestimoniallist();

					foreach ($testimoniallist_info as $key => $value) {
						if(!empty($value['tvcmstestimonial_status'])){
							$data['testimoniallist_data'][] = array(
								'tvcmstestimonialmain_link'				=> $value['tvcmstestimonialmain_link'],
								'tvcmstestimonial_img'					=> $this->model_tool_image->resize($value['tvcmstestimonial_img'], $this->config->get('tvcmscustomsetting_testimonial_img_width'), $this->config->get('tvcmscustomsetting_testimonial_img_height')),
								'tvcmstestimonial_sing_img'				=> $this->model_tool_image->resize($value['tvcmstestimonial_sing_img'], $this->config->get('tvcmscustomsetting_testimonial_sing_img_width'), $this->config->get('tvcmscustomsetting_testimonial_sing_img_height')),
								'tvcmstestimonial_sing_text'			=> $value['tvcmstestimonial_sing_text'],
								'tvcmstestimonialsub_short_description'	=> $value['tvcmstestimonialsub_short_description'],
								'tvcmstestimonialsub_title'				=> $value['tvcmstestimonialsub_title'],
								'tvcmstestimonialsub_designation'		=> $value['tvcmstestimonialsub_designation'],
								'tvcmstestimonialsub_description'		=> $value['tvcmstestimonialsub_description']
							);
						}
					}
				}
				return $this->load->view('extension/module/tvcmstestimonial', $data);
			}
		}
	}
	protected function status(){
		return $this->Tvcmsthemevoltystatus->testimonialstatus();
	}
}