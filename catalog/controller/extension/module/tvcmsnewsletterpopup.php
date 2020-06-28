<?php
class ControllerExtensionModuletvcmsnewsletterpopup extends Controller {
	public function index($setting) {
		if($this->config->get('theme_default_directory') == "opc_electronic_electron_2501"){
			$this->load->language('extension/module/tvcmscustomtext');
			if(!empty($setting['status'])){
				$this->load->model('tool/image');
				$languages_id 				= $this->config->get('config_language_id');
				$data['bgimage_status'] 	= $setting['tvcmsnewsletterpopup']['bgimg_status'];
				if(!empty($setting['tvcmsnewsletterpopup']['img_status'])){
					$data['image'] 			= $this->model_tool_image->resize($setting['tvcmsnewsletterpopup']['lang_text'][$languages_id]['img'], $this->config->get('tvcmscustomsetting_tvcmsnewsletterpoimg_img_width'), $this->config->get('tvcmscustomsetting_tvcmsnewsletterpoimg_img_height'));
				}
				if(!empty($setting['tvcmsnewsletterpopup']['bgimg_status'])){
					$data['bgimage'] 		= $this->model_tool_image->resize($setting['tvcmsnewsletterpopup']['lang_text'][$languages_id]['bgimg'], $this->config->get('tvcmscustomsetting_tvcmsnewsletterpobgimg_img_width'), $this->config->get('tvcmscustomsetting_tvcmsnewsletterpobgimg_img_height'));
				}
				$data['title'] 				= $setting['tvcmsnewsletterpopup']['lang_text'][$languages_id]['title'];
				$data['sub_title'] 			= $setting['tvcmsnewsletterpopup']['lang_text'][$languages_id]['subtitle'];
				$data['socialicon']         = $this->load->controller('common/tvcmssocialicon');
				return $this->load->view('extension/module/tvcmsnewsletterpopup', $data);
			}
		}
	}
	public function ajaxdata() {
        $json = array();

            $this->load->model('catalog/tvcmsmodule');
           	$this->load->language('extension/module/tvcmscustomtext');


            if (!empty($this->request->get['email'])) {
                $email = $this->request->get['email'];
                
            	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					$json['text_error_email'] = $this->language->get('text_error_email');
				}else{
	            	$checkemail = $this->model_catalog_tvcmsmodule->checkemailsubcribe($email);
	            	if(empty($checkemail)){
	            		$alldataget = $this->model_catalog_tvcmsmodule->addemailsubcribe($email);
	            			$json['text_success_email'] = $this->language->get('text_success_email');
	            	}else{
	            		$json['text_repeat_email'] = $this->language->get('text_repeat_email');
	            	}
				}
            } else {
               $json['text_enter_email'] = $this->language->get('text_enter_email');
            }

            




        $this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
    }
}


