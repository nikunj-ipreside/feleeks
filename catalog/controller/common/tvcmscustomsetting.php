<?php

class ControllerCommontvcmscustomsetting extends Controller {
	public function index() {
		if($this->config->get('theme_default_directory') == "opc_electronic_electron_2501"){
			
			$status     								= $this->status();

			$data['status_form_1'] 						= $status['form_1'];
			$data['status_all_theme_option_info'] 		= $status['all_theme_option_info'];
			$data['status_wow_js'] 						= $status['wow_js'];
			$data['status_product_color'] 				= $status['product_color'];
			$data['status_vertical_menu_open'] 			= $status['vertical_menu_open'];
			$data['status_page_loader'] 				= $status['page_loader'];
			$data['status_mouse_hover_image'] 			= $status['mouse_hover_image'];
			$data['status_tab_product_double_row'] 		= $status['tab_product_double_row'];
			$data['status_main_menu_sticky'] 			= $status['main_menu_sticky'];
			$data['status_bottom_sticky'] 				= $status['bottom_sticky'];

			$data['status_form_2'] 						= $status['form_2'];
			$data['status_top_offer_banner'] 			= $status['top_offer_banner'];
			$data['status_top_offer_banner_status'] 	= $status['top_offer_banner_status'];

			$data['status_form_3'] 						= $status['form_3'];
			$data['status_apple_app_link'] 				= $status['apple_app_link'];
			$data['status_google_app_link'] 			= $status['google_app_link'];
			$data['status_microsoft_app_link'] 			= $status['microsoft_app_link'];
			$data['status_app_link_status'] 			= $status['app_link_status'];
			$data['status_copy_right_info'] 			= $status['copy_right_info'];

			$data['status_form_4'] 						= $status['form_4'];
			$data['status_copy_right_text'] 			= $status['copy_right_text'];
			$data['status_copy_right_link'] 			= $status['copy_right_link'];
			$data['status_copy_right_text_status'] 		= $status['copy_right_text_status'];
			$data['status_footer_tab_product_info'] 	= $status['footer_tab_product_info'];
			$data['status_footer_tab_prod_status'] 		= $status['footer_tab_prod_status'];
			$data['status_news_letter_title'] 			= $status['news_letter_title'];
			$data['status_news_letter_short_desc'] 		= $status['news_letter_short_desc'];
			
			$data['status'] = $this->config->get('tvcmscustomsetting_status');
			if(!empty($data['status'])){
				$this->load->model('catalog/tvcmsmodule');
				$this->load->model('tool/image');
				$language_id = $this->config->get('config_language_id');

				if(!empty($data['status_form_1'])){
					if(!empty($data['status_all_theme_option_info'])){}
					if(!empty($data['status_wow_js'])){}
					if(!empty($data['status_product_color'])){}
					if(!empty($data['status_vertical_menu_open'])){}
					if(!empty($data['status_page_loader'])){
						$data['pageloader'] 			= $this->config->get('tvcmscustomsetting_configuration')['pageloader'];
					}
					if(!empty($data['status_mouse_hover_image'])){
						$data['mousehoverimage']		= $this->config->get('tvcmscustomsetting_configuration')['mousehoverimage'];
					}
					if(!empty($data['status_tab_product_double_row'])){
						$data['doublerowstatus'] 	= $this->config->get('tvcmscustomsetting_configuration')['doublerow'];
					}
					if(!empty($data['status_main_menu_sticky'])){
						$data['mainmenustickystatus'] 	= $this->config->get('tvcmscustomsetting_configuration')['mainmenustickystatus'];
					}
					if(!empty($data['status_bottom_sticky'])){
						$data['bottomoption'] 			= $this->config->get('tvcmscustomsetting_configuration')['bottomoption'];
					}
				}
				if(!empty($data['status_form_2'])){
					if(!empty($data['status_top_offer_banner'])){
						$data['offer_banner'] 	= $this->config->get('tvcmscustomsetting_offerbannarmain')['top'];
					}
					if(!empty($data['status_top_offer_banner_status'])){
						$data['offer_banner_status'] 		= $this->config->get('tvcmscustomsetting_offerbannarsub')['lang_text'][$language_id]['topimg'];
					}
				}
				if(!empty($data['status_form_3'])){
					if(!empty($data['status_apple_app_link'])){
						$data['apple_link'] = $this->config->get('tvcmscustomsetting_appsub')['lang_text'][$language_id]['link'];
					}
					if(!empty($data['status_google_app_link'])){
						$data['google_link'] = $this->config->get('tvcmscustomsetting_appsub')['lang_text'][$language_id]['google'];
					}
					if(!empty($data['status_microsoft_app_link'])){
						$data['micro_link'] = $this->config->get('tvcmscustomsetting_appsub')['lang_text'][$language_id]['micro'];
					}
					$data['appsub_img1']    		= $this->model_tool_image->resize($this->config->get('tvcmscustomsetting_appsub')['lang_text'][$language_id]['topimg1'],$this->config->get('tvcmscustomsetting_appsub')['lang_text'][$language_id]['topimg1_width'],$this->config->get('tvcmscustomsetting_appsub')['lang_text'][$language_id]['topimg1_height']);
					$data['appsub_img2']    		= $this->model_tool_image->resize($this->config->get('tvcmscustomsetting_appsub')['lang_text'][$language_id]['topimg2'],$this->config->get('tvcmscustomsetting_appsub')['lang_text'][$language_id]['topimg2_width'],$this->config->get('tvcmscustomsetting_appsub')['lang_text'][$language_id]['topimg2_height']);
					$data['appsub_img3']    		= $this->model_tool_image->resize($this->config->get('tvcmscustomsetting_appsub')['lang_text'][$language_id]['topimg3'],$this->config->get('tvcmscustomsetting_appsub')['lang_text'][$language_id]['topimg3_width'],$this->config->get('tvcmscustomsetting_appsub')['lang_text'][$language_id]['topimg3_height']);
				}
				if(!empty($data['status_form_4'])){
					if(!empty($data['status_copy_right_text'])){
						$data['customsub_text'] 		= $this->config->get('tvcmscustomsetting_customsub')['lang_text'][$language_id]['text'];
					}
					if(!empty($data['status_copy_right_link'])){
						$data['customsub_textlink'] 	= $this->config->get('tvcmscustomsetting_customsub')['lang_text'][$language_id]['link'];
					}
					$data['custom_text'] 		= $this->config->get('tvcmscustomsetting_customsub')['lang_text'][$language_id]['customtext'];

				}

				return $data;
			}
		}
	}
	protected function status(){
		return $this->Tvcmsthemevoltystatus->customsetting();
	}
}


