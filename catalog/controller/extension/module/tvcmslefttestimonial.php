<?php

class ControllerExtensionModuletvcmslefttestimonial extends Controller {
	public function index($setting) {
		if($this->config->get('theme_default_directory') == "opc_electronic_electron_2501"){
			if($setting['status']){
				$this->load->model('catalog/tvcmsmodule');
				$this->load->model('tool/image');
				$language_id 	= (int)$this->config->get('config_language_id');
				$data['title'] 	= $setting['title'][$language_id];


				$testimoniallist_info 	= $this->model_catalog_tvcmsmodule->gettvtestimoniallist();

				foreach ($testimoniallist_info as $key => $value) {
					if(!empty($value['tvcmstestimonial_status'])){
						$data['testimoniallist_data'][] = array(
							'tvcmstestimonial_img'					=> $this->model_tool_image->resize($value['tvcmstestimonial_img'],$this->config->get('tvcmscustomsetting_lefttestimonial_img_width'),$this->config->get('tvcmscustomsetting_lefttestimonial_img_height')),
							'tvcmstestimonialmain_link'				=> $value['tvcmstestimonialmain_link'],
							'tvcmstestimonial_sing_text'			=> $value['tvcmstestimonial_sing_text'],
							'tvcmstestimonialsub_short_description'	=> $value['tvcmstestimonialsub_short_description'],
							'tvcmstestimonialsub_title'				=> $value['tvcmstestimonialsub_title'],
							'tvcmstestimonialsub_designation'		=> $value['tvcmstestimonialsub_designation'],
							'tvcmstestimonialsub_description'		=> $value['tvcmstestimonialsub_description']
						);
					}
				}
				return $this->load->view('extension/module/tvcmslefttestimonial', $data);
			}
		}
	}
}