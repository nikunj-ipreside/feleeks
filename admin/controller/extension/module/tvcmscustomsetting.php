<?php
class ControllerExtensionModuletvcmscustomsetting extends Controller {
	private $error = array();

	public function index() {

		$this->load->language('extension/module/tvcmscustomsetting');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('localisation/language');

		$this->load->model('catalog/product');
		$this->load->model('tool/image');
		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validatesetting()) {
			$this->makeInslineStyleSheet();
			$this->model_setting_setting->editSetting('tvcmscustomsetting', $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}
		

        $data['dir_pattern'] = HTTP_CATALOG."image/catalog/themevolty/pattern/pattern";
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['main'])) {
			$data['error_main'] = $this->error['main'];
		} else {
			$data['error_main'] = '';
		}
		if (isset($this->error['tvcmscustomsetting_categoryslider_mainimg'])) {
			$data['error_categoryslider_mainimg'] 	= $this->error['tvcmscustomsetting_categoryslider_mainimg'];
		} else {
			$data['error_categoryslider_mainimg'] 	= array();
		}
		if (isset($this->error['tvcmscustomsetting_categoryslider_img'])) {
			$data['error_categoryslider_img'] 		= $this->error['tvcmscustomsetting_categoryslider_img'];
		} else {
			$data['error_categoryslider_img'] 		= array();
		}
		if (isset($this->error['tvcmscustomsetting_customerservice_mainimg'])) {
			$data['error_customerservice_mainimg'] 	= $this->error['tvcmscustomsetting_customerservice_mainimg'];
		} else {
			$data['error_customerservice_mainimg'] 	= array();
		}
		if (isset($this->error['tvcmscustomsetting_customerservice_img'])) {
			$data['error_customerservice_img'] 		= $this->error['tvcmscustomsetting_customerservice_img'];
		} else {
			$data['error_customerservice_img'] 		= array();
		}
		if (isset($this->error['tvcmscustomsetting_tabproduct_mainimg'])) {
			$data['error_tabproduct_mainimg'] 		= $this->error['tvcmscustomsetting_tabproduct_mainimg'];
		} else {
			$data['error_tabproduct_mainimg'] 		= array();
		}
		if (isset($this->error['tvcmscustomsetting_tabproduct_img'])) {
			$data['error_tabproduct_img'] 			= $this->error['tvcmscustomsetting_tabproduct_img'];
		} else {
			$data['error_tabproduct_img'] 			= array();
		}
		if (isset($this->error['tvcmscustomsetting_featureproduct_mainimg'])) {
			$data['error_featureproduct_mainimg'] 	= $this->error['tvcmscustomsetting_featureproduct_mainimg'];
		} else {
			$data['error_featureproduct_mainimg'] 	= array();
		}
		if (isset($this->error['tvcmscustomsetting_newproduct_mainimg'])) {
			$data['error_newproduct_mainimg'] 		= $this->error['tvcmscustomsetting_newproduct_mainimg'];
		} else {
			$data['error_newproduct_mainimg'] 		= array();
		}
		if (isset($this->error['tvcmscustomsetting_bestproduct_mainimg'])) {
			$data['error_bestproduct_mainimg'] 		= $this->error['tvcmscustomsetting_bestproduct_mainimg'];
		} else {
			$data['error_bestproduct_mainimg'] 		= array();
		}
		if (isset($this->error['tvcmscustomsetting_specialproduct_mainimg'])) {
			$data['error_specialproduct_mainimg'] 	= $this->error['tvcmscustomsetting_specialproduct_mainimg'];
		} else {
			$data['error_specialproduct_mainimg'] 	= array();
		}
		if (isset($this->error['tvcmscustomsetting_brand_mainimg'])) {
			$data['error_brand_mainimg'] 			= $this->error['tvcmscustomsetting_brand_mainimg'];
		} else {
			$data['error_brand_mainimg'] 			= array();
		}
		if (isset($this->error['tvcmscustomsetting_brand_img'])) {
			$data['error_brand_img'] 	= $this->error['tvcmscustomsetting_brand_img'];
		} else {
			$data['error_brand_img'] 	= array();
		}
		if (isset($this->error['tvcmscustomsetting_testimonial_mainimg'])) {
			$data['error_testimonial_mainimg'] 	= $this->error['tvcmscustomsetting_testimonial_mainimg'];
		} else {
			$data['error_testimonial_mainimg'] 	= array();
		}
		if (isset($this->error['tvcmscustomsetting_testimonial_img'])) {
			$data['error_testimonial_img'] 	= $this->error['tvcmscustomsetting_testimonial_img'];
		} else {
			$data['error_testimonial_img'] 	= array();
		}
		if (isset($this->error['tvcmscustomsetting_testimonial_sing_img'])) {
			$data['error_testimonial_sing_img'] = $this->error['tvcmscustomsetting_testimonial_sing_img'];
		} else {
			$data['error_testimonial_sing_img'] = array();
		}
		if (isset($this->error['tvcmscustomsetting_payment_mainimg'])) {
			$data['error_payment_mainimg'] 	= $this->error['tvcmscustomsetting_payment_mainimg'];
		} else {
			$data['error_payment_mainimg'] 	= array();
		}
		if (isset($this->error['tvcmscustomsetting_payment_img'])) {
			$data['error_payment_img'] 	= $this->error['tvcmscustomsetting_payment_img'];
		} else {
			$data['error_payment_img'] 	= array();
		}
		if (isset($this->error['tvcmscustomsetting_social_img'])) {
			$data['error_social_img'] 	= $this->error['tvcmscustomsetting_social_img'];
		} else {
			$data['error_social_img'] 	= array();
		}
		if (isset($this->error['tvcmscustomsetting_footerlogo_img'])) {
			$data['error_footerlogo_img'] 	= $this->error['tvcmscustomsetting_footerlogo_img'];
		} else {
			$data['error_footerlogo_img'] 	= array();
		}
		if (isset($this->error['tvcmscustomsetting_offerbanner_img'])) {
			$data['error_offerbanner_img'] 	= $this->error['tvcmscustomsetting_offerbanner_img'];
		} else {
			$data['error_offerbanner_img'] 	= array();
		}
		
		if (isset($this->error['tvcmscustomsetting_advanceblock_mainimg'])) {
			$data['error_advanceblock_mainimg'] 	= $this->error['tvcmscustomsetting_advanceblock_mainimg'];
		} else {
			$data['error_advanceblock_mainimg'] 	= array();
		}
		if (isset($this->error['tvcmscustomsetting_advanceblock_sub_mainimg'])) {
			$data['error_advanceblock_sub_mainimg'] 	= $this->error['tvcmscustomsetting_advanceblock_sub_mainimg'];
		} else {
			$data['error_advanceblock_sub_mainimg'] 	= array();
		}
		if (isset($this->error['tvcmscustomsetting_advanceblock_img'])) {
			$data['error_advanceblock_img'] 	= $this->error['tvcmscustomsetting_advanceblock_img'];
		} else {
			$data['error_advanceblock_img'] 	= array();
		}
		if (isset($this->error['tvcmscustomsetting_leftbanner_img'])) {
			$data['error_leftbanner_img'] 	= $this->error['tvcmscustomsetting_leftbanner_img'];
		} else {
			$data['error_leftbanner_img'] 	= array();
		}
		if (isset($this->error['tvcmscustomsetting_leftproduct_img'])) {
			$data['error_leftproduct_img'] 	= $this->error['tvcmscustomsetting_leftproduct_img'];
		} else {
			$data['error_leftproduct_img'] 	= array();
		}
		if (isset($this->error['tvcmscustomsetting_lefttestimonial_img'])) {
			$data['error_lefttestimonial_img'] 	= $this->error['tvcmscustomsetting_lefttestimonial_img'];
		} else {
			$data['error_lefttestimonial_img'] 	= array();
		}
		if (isset($this->error['tvcmscustomsetting_tvcmssingleblock_img'])) {
			$data['error_tvcmssingleblock_img'] 	= $this->error['tvcmscustomsetting_tvcmssingleblock_img'];
		} else {
			$data['error_tvcmssingleblock_img'] 	= array();
		}
		if (isset($this->error['tvcmscustomsetting_tvcmsblogfeahome_img'])) {
			$data['error_tvcmsblogfeahome_img'] 	= $this->error['tvcmscustomsetting_tvcmsblogfeahome_img'];
		} else {
			$data['error_tvcmsblogfeahome_img'] 	= array();
		}
		if (isset($this->error['tvcmscustomsetting_tvcmsblogfeaall_img'])) {
			$data['error_tvcmsblogfeaall_img'] 	= $this->error['tvcmscustomsetting_tvcmsblogfeaall_img'];
		} else {
			$data['error_tvcmsblogfeaall_img'] 	= array();
		}
		if (isset($this->error['tvcmscustomsetting_tvcmsblogfeasin_img'])) {
			$data['error_tvcmsblogfeasin_img'] 	= $this->error['tvcmscustomsetting_tvcmsblogfeasin_img'];
		} else {
			$data['error_tvcmsblogfeasin_img'] 	= array();
		}

		if (isset($this->error['tvcmscustomsetting_tvcmsbloggallhome_img'])) {
			$data['error_tvcmsbloggallhome_img'] 	= $this->error['tvcmscustomsetting_tvcmsbloggallhome_img'];
		} else {
			$data['error_tvcmsbloggallhome_img'] 	= array();
		}
		if (isset($this->error['tvcmscustomsetting_tvcmsbloggallall_img'])) {
			$data['error_tvcmsbloggallall_img'] 	= $this->error['tvcmscustomsetting_tvcmsbloggallall_img'];
		} else {
			$data['error_tvcmsbloggallall_img'] 	= array();
		}
		if (isset($this->error['tvcmscustomsetting_tvcmsbloggallsin_img'])) {
			$data['error_tvcmsbloggallsin_img'] 	= $this->error['tvcmscustomsetting_tvcmsbloggallsin_img'];
		} else {
			$data['error_tvcmsbloggallsin_img'] 	= array();
		}
		if (isset($this->error['tvcmscustomsetting_tvcmsnewsletterpoimg_img'])) {
			$data['error_tvcmsnewsletterpoimg_img'] 	= $this->error['tvcmscustomsetting_tvcmsnewsletterpoimg_img'];
		} else {
			$data['error_tvcmsnewsletterpoimg_img'] 	= array();
		}
		if (isset($this->error['tvcmscustomsetting_tvcmsnewsletterpobgimg_img'])) {
			$data['error_tvcmsnewsletterpobgimg_img'] 	= $this->error['tvcmscustomsetting_tvcmsnewsletterpobgimg_img'];
		} else {
			$data['error_tvcmsnewsletterpobgimg_img'] 	= array();
		}
		if (isset($this->error['tvcmscustomsetting_tvcmsproductgridimg_img'])) {
			$data['error_tvcmsproductgridimg_img'] 	= $this->error['tvcmscustomsetting_tvcmsproductgridimg_img'];
		} else {
			$data['error_tvcmsproductgridimg_img'] 	= array();
		}
		if (isset($this->error['tvcmscustomsetting_special_img'])) {
			$data['error_special_img'] 	= $this->error['tvcmscustomsetting_special_img'];
		} else {
			$data['error_special_img'] 	= array();
		}
		if (isset($this->error['tvcmscustomsetting_footerproduct_img'])) {
			$data['error_footerproduct_img'] 	= $this->error['tvcmscustomsetting_footerproduct_img'];
		} else {
			$data['error_footerproduct_img'] 	= array();
		}
		if (isset($this->error['tvcmscustomsetting_sliderimage_img'])) {
			$data['error_sliderimage_img'] 	= $this->error['tvcmscustomsetting_sliderimage_img'];
		} else {
			$data['error_sliderimage_img'] 	= array();
		}
		$data['breadcrumbs'] 	= array();

		$data['breadcrumbs'][] 	= array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] 	= array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/tvcmscustomsetting', 'user_token=' . $this->session->data['user_token'] , true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/tvcmscustomsetting', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}

		$data['tab_confi']	= $this->language->get('tab_confi');
		$data['tab_offer']	= $this->language->get('tab_offer');
		$data['tab_app']	= $this->language->get('tab_app');
		$data['tab_cust']	= $this->language->get('tab_cust');
		$data['entry_yes']	= $this->language->get('entry_yes');
		$data['entry_no']	= $this->language->get('entry_no');
		$data['languages'] 	= $this->model_localisation_language->getLanguages();
		$data['user_token']	= $this->session->data['user_token'];

		$data['action'] 	= $this->url->link('extension/module/tvcmscustomsetting', 'user_token=' . $this->session->data['user_token'] , true);
		$data['cancel'] 	= $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		$status = $this->status();
		
		$data['form_1'] 							= $status['form_1'];
    	$data['all_theme_option_info'] 				= $status['all_theme_option_info'];
    	$data['page_loader'] 						= $status['page_loader'];
    	$data['wow_js'] 							= $status['wow_js'];
    	$data['mouse_hover_image'] 					= $status['mouse_hover_image'];
    	$data['tab_product_double_row'] 			= $status['tab_product_double_row'];
    	$data['product_color'] 						= $status['product_color'];
    	$data['main_menu_sticky'] 					= $status['main_menu_sticky'];
    	$data['bottom_sticky'] 						= $status['bottom_sticky'];
    	$data['vertical_menu_open'] 				= $status['vertical_menu_open'];
    	$data['form_2'] 							= $status['form_2'];
    	$data['top_offer_banner_status'] 			= $status['top_offer_banner_status'];
    	$data['top_offer_banner']	 				= $status['top_offer_banner'];
    	$data['form_3'] 							= $status['form_3'];
    	$data['app_link_status'] 					= $status['app_link_status'];
    	$data['apple_app_link'] 					= $status['apple_app_link'];
    	$data['google_app_link'] 					= $status['google_app_link'];
    	$data['microsoft_app_link'] 				= $status['microsoft_app_link'];
    	$data['form_4'] 							= $status['form_4'];
    	$data['copy_right_text_status'] 			= $status['copy_right_text_status'];
    	$data['footer_tab_prod_status'] 			= $status['footer_tab_prod_status'];
    	$data['copy_right_text'] 					= $status['copy_right_text'];
    	$data['copy_right_link'] 					= $status['copy_right_link'];
    	$data['status_custom_text'] 				= $status['custom_text'];
    	$data['footer_tab_product_info'] 			= $status['footer_tab_product_info'];
    	$data['copy_right_info'] 					= $status['copy_right_info'];
    	$data['news_letter_title'] 					= $status['news_letter_title'];
    	$data['news_letter_short_desc'] 			= $status['news_letter_short_desc'];

		if (isset($this->request->post['tvcmscustomsetting_status'])) {
			$data['tvcmscustomsetting_status'] = $this->request->post['tvcmscustomsetting_status'];
		} else {
			$data['tvcmscustomsetting_status'] = $this->config->get('tvcmscustomsetting_status');
		}

		if(!empty($data['form_1'])){
			if (isset($this->request->post['tvcmscustomsetting_configuration'])) {
				$data['tvcmscustomsetting_configuration'] = $this->request->post['tvcmscustomsetting_configuration'];
			} else {
				$data['tvcmscustomsetting_configuration'] = $this->config->get('tvcmscustomsetting_configuration');
			}
		}
		if(!empty($data['form_2'])){
			if (isset($this->request->post['tvcmscustomsetting_offerbannarmain'])) {
				$data['tvcmscustomsetting_offerbannarmain'] = $this->request->post['tvcmscustomsetting_offerbannarmain'];
			} else {
				$data['tvcmscustomsetting_offerbannarmain'] = $this->config->get('tvcmscustomsetting_offerbannarmain');
			} 
			if (isset($this->request->post['tvcmscustomsetting_offerbannarsub'])) {
				$data['tvcmscustomsetting_offerbannarsub'] = $this->request->post['tvcmscustomsetting_offerbannarsub'];
				foreach ($this->request->post['tvcmscustomsetting_offerbannarsub']['lang_text'] as $key => $value) {
					if(!empty($value['topimg'])){
						$data['top'][$key] 	=  $this->model_tool_image->resize($value['topimg'], 100, 100);				
					}else{
						$data['top'][$key] 	=  $this->model_tool_image->resize('no_image.png', 100, 100);				
					}
					if(!empty($value['leftimg'])){
						$data['left'][$key] =  $this->model_tool_image->resize($value['leftimg'], 100, 100);						
					}else{
						$data['left'][$key] =  $this->model_tool_image->resize('no_image.png', 100, 100);
					}
				}
			} else {
				$data['tvcmscustomsetting_offerbannarsub'] = $this->config->get('tvcmscustomsetting_offerbannarsub');
				foreach ($data['tvcmscustomsetting_offerbannarsub']['lang_text'] as $key => $value) {
					$data['top'][$key] 	=  $this->model_tool_image->resize($value['topimg'], 100, 100);
					if(!empty($value['leftimg'])){
						$data['left'][$key] =  $this->model_tool_image->resize($value['leftimg'], 100, 100);						
					}else{
						$data['left'][$key] = $this->model_tool_image->resize('no_image.png', 100, 100);
					}				
				}
			}
		}
		if(!empty($data['form_3'])){
			if (isset($this->request->post['tvcmscustomsetting_appmain'])) {
				$data['tvcmscustomsetting_appmain'] = $this->request->post['tvcmscustomsetting_appmain'];
			} else {
				$data['tvcmscustomsetting_appmain'] = $this->config->get('tvcmscustomsetting_appmain');
			}
			if (isset($this->request->post['tvcmscustomsetting_appsub'])) {
				$data['tvcmscustomsetting_appsub'] = $this->request->post['tvcmscustomsetting_appsub'];
				foreach ($this->request->post['tvcmscustomsetting_appsub']['lang_text'] as $key => $value) {
					if($value['topimg1']){
						$data['top1'][$key] 	=  $this->model_tool_image->resize($value['topimg1'], 100, 100);				
					}else{
						$data['top1'][$key] 	=  $this->model_tool_image->resize('no_image.png', 100, 100);				
					}
					if($value['topimg2']){
						$data['top2'][$key] 	=  $this->model_tool_image->resize($value['topimg2'], 100, 100);				
					}else{
						$data['top2'][$key] 	=  $this->model_tool_image->resize('no_image.png', 100, 100);				
					}
					if($value['topimg3']){
						$data['top3'][$key] 	=  $this->model_tool_image->resize($value['topimg3'], 100, 100);				
					}else{
						$data['top3'][$key] 	=  $this->model_tool_image->resize('no_image.png', 100, 100);				
					}	
				}	
			} else {
				$data['tvcmscustomsetting_appsub'] = $this->config->get('tvcmscustomsetting_appsub');
				foreach ($data['tvcmscustomsetting_appsub']['lang_text'] as $key => $value) {
					$data['top1'][$key] 	=  $this->model_tool_image->resize($value['topimg1'], 100, 100);						
					$data['top2'][$key] 	=  $this->model_tool_image->resize($value['topimg2'], 100, 100);						
					$data['top3'][$key] 	=  $this->model_tool_image->resize($value['topimg3'], 100, 100);						
				}
			} 
		}
		if(!empty($data['form_4'])){
			if (isset($this->request->post['tvcmscustomsetting_custommain'])) {
				$data['tvcmscustomsetting_custommain'] = $this->request->post['tvcmscustomsetting_custommain'];
			} else {
				$data['tvcmscustomsetting_custommain'] = $this->config->get('tvcmscustomsetting_custommain');
			} 
			if (isset($this->request->post['tvcmscustomsetting_customsub'])) {
				$data['tvcmscustomsetting_customsub'] = $this->request->post['tvcmscustomsetting_customsub'];
			} else {
				$data['tvcmscustomsetting_customsub'] = $this->config->get('tvcmscustomsetting_customsub');
			} 
		}

		/*themevoltyimage*/
			 	if (isset($this->request->post['tvcmscustomsetting_categoryslider_mainimg_width'])) {
                    $data['tvcmscustomsetting_categoryslider_mainimg_width'] = $this->request->post['tvcmscustomsetting_categoryslider_mainimg_width'];
                } else {
                    $data['tvcmscustomsetting_categoryslider_mainimg_width'] = $this->config->get('tvcmscustomsetting_categoryslider_mainimg_width');
                }
                if (isset($this->request->post['tvcmscustomsetting_categoryslider_img_width'])) {
                    $data['tvcmscustomsetting_categoryslider_img_width'] = $this->request->post['tvcmscustomsetting_categoryslider_img_width'];
                } else {
                    $data['tvcmscustomsetting_categoryslider_img_width'] = $this->config->get('tvcmscustomsetting_categoryslider_img_width');
                }
                if (isset($this->request->post['tvcmscustomsetting_customerservice_mainimg_width'])) {
                    $data['tvcmscustomsetting_customerservice_mainimg_width'] = $this->request->post['tvcmscustomsetting_customerservice_mainimg_width'];
                } else {
                    $data['tvcmscustomsetting_customerservice_mainimg_width'] = $this->config->get('tvcmscustomsetting_customerservice_mainimg_width');
                }
                if (isset($this->request->post['tvcmscustomsetting_customerservice_img_width'])) {
                    $data['tvcmscustomsetting_customerservice_img_width'] = $this->request->post['tvcmscustomsetting_customerservice_img_width'];
                } else {
                    $data['tvcmscustomsetting_customerservice_img_width'] = $this->config->get('tvcmscustomsetting_customerservice_img_width');
                }
                if (isset($this->request->post['tvcmscustomsetting_tabproduct_mainimg_width'])) {
                    $data['tvcmscustomsetting_tabproduct_mainimg_width'] = $this->request->post['tvcmscustomsetting_tabproduct_mainimg_width'];
                } else {
                    $data['tvcmscustomsetting_tabproduct_mainimg_width'] = $this->config->get('tvcmscustomsetting_tabproduct_mainimg_width');
                }
                if (isset($this->request->post['tvcmscustomsetting_tabproduct_img_width'])) {
                    $data['tvcmscustomsetting_tabproduct_img_width'] = $this->request->post['tvcmscustomsetting_tabproduct_img_width'];
                } else {
                    $data['tvcmscustomsetting_tabproduct_img_width'] = $this->config->get('tvcmscustomsetting_tabproduct_img_width');
                }

                if (isset($this->request->post['tvcmscustomsetting_featureproduct_mainimg_width'])) {
                    $data['tvcmscustomsetting_featureproduct_mainimg_width'] = $this->request->post['tvcmscustomsetting_featureproduct_mainimg_width'];
                } else {
                    $data['tvcmscustomsetting_featureproduct_mainimg_width'] = $this->config->get('tvcmscustomsetting_featureproduct_mainimg_width');
                }
                if (isset($this->request->post['tvcmscustomsetting_newproduct_mainimg_width'])) {
                    $data['tvcmscustomsetting_newproduct_mainimg_width'] = $this->request->post['tvcmscustomsetting_newproduct_mainimg_width'];
                } else {
                    $data['tvcmscustomsetting_newproduct_mainimg_width'] = $this->config->get('tvcmscustomsetting_newproduct_mainimg_width');
                }
                if (isset($this->request->post['tvcmscustomsetting_bestproduct_mainimg_width'])) {
                    $data['tvcmscustomsetting_bestproduct_mainimg_width'] = $this->request->post['tvcmscustomsetting_bestproduct_mainimg_width'];
                } else {
                    $data['tvcmscustomsetting_bestproduct_mainimg_width'] = $this->config->get('tvcmscustomsetting_bestproduct_mainimg_width');
                }
                if (isset($this->request->post['tvcmscustomsetting_specialproduct_mainimg_width'])) {
                    $data['tvcmscustomsetting_specialproduct_mainimg_width'] = $this->request->post['tvcmscustomsetting_specialproduct_mainimg_width'];
                } else {
                    $data['tvcmscustomsetting_specialproduct_mainimg_width'] = $this->config->get('tvcmscustomsetting_specialproduct_mainimg_width');
                }
                if (isset($this->request->post['tvcmscustomsetting_brand_mainimg_width'])) {
                    $data['tvcmscustomsetting_brand_mainimg_width'] = $this->request->post['tvcmscustomsetting_brand_mainimg_width'];
                } else {
                    $data['tvcmscustomsetting_brand_mainimg_width'] = $this->config->get('tvcmscustomsetting_brand_mainimg_width');
                }
                if (isset($this->request->post['tvcmscustomsetting_brand_img_width'])) {
                    $data['tvcmscustomsetting_brand_img_width'] = $this->request->post['tvcmscustomsetting_brand_img_width'];
                } else {
                    $data['tvcmscustomsetting_brand_img_width'] = $this->config->get('tvcmscustomsetting_brand_img_width');
                }
                if (isset($this->request->post['tvcmscustomsetting_testimonial_mainimg_width'])) {
                    $data['tvcmscustomsetting_testimonial_mainimg_width'] = $this->request->post['tvcmscustomsetting_testimonial_mainimg_width'];
                } else {
                    $data['tvcmscustomsetting_testimonial_mainimg_width'] = $this->config->get('tvcmscustomsetting_testimonial_mainimg_width');
                }
                if (isset($this->request->post['tvcmscustomsetting_testimonial_img_width'])) {
                    $data['tvcmscustomsetting_testimonial_img_width'] = $this->request->post['tvcmscustomsetting_testimonial_img_width'];
                } else {
                    $data['tvcmscustomsetting_testimonial_img_width'] = $this->config->get('tvcmscustomsetting_testimonial_img_width');
                }
                if (isset($this->request->post['tvcmscustomsetting_testimonial_sing_img_width'])) {
                    $data['tvcmscustomsetting_testimonial_sing_img_width'] = $this->request->post['tvcmscustomsetting_testimonial_sing_img_width'];
                } else {
                    $data['tvcmscustomsetting_testimonial_sing_img_width'] = $this->config->get('tvcmscustomsetting_testimonial_sing_img_width');
                }

                if (isset($this->request->post['tvcmscustomsetting_payment_mainimg_width'])) {
                    $data['tvcmscustomsetting_payment_mainimg_width'] = $this->request->post['tvcmscustomsetting_payment_mainimg_width'];
                } else {
                    $data['tvcmscustomsetting_payment_mainimg_width'] = $this->config->get('tvcmscustomsetting_payment_mainimg_width');
                }
                if (isset($this->request->post['tvcmscustomsetting_payment_img_width'])) {
                    $data['tvcmscustomsetting_payment_img_width'] = $this->request->post['tvcmscustomsetting_payment_img_width'];
                } else {
                    $data['tvcmscustomsetting_payment_img_width'] = $this->config->get('tvcmscustomsetting_payment_img_width');
                }

                if (isset($this->request->post['tvcmscustomsetting_social_img_width'])) {
                    $data['tvcmscustomsetting_social_img_width'] = $this->request->post['tvcmscustomsetting_social_img_width'];
                } else {
                    $data['tvcmscustomsetting_social_img_width'] = $this->config->get('tvcmscustomsetting_social_img_width');
                }

                if (isset($this->request->post['tvcmscustomsetting_footerlogo_img_width'])) {
                    $data['tvcmscustomsetting_footerlogo_img_width'] = $this->request->post['tvcmscustomsetting_footerlogo_img_width'];
                } else {
                    $data['tvcmscustomsetting_footerlogo_img_width'] = $this->config->get('tvcmscustomsetting_footerlogo_img_width');
                }

                if (isset($this->request->post['tvcmscustomsetting_offerbanner_img_width'])) {
                    $data['tvcmscustomsetting_offerbanner_img_width'] = $this->request->post['tvcmscustomsetting_offerbanner_img_width'];
                } else {
                    $data['tvcmscustomsetting_offerbanner_img_width'] = $this->config->get('tvcmscustomsetting_offerbanner_img_width');
                }

                
                if (isset($this->request->post['tvcmscustomsetting_advanceblock_mainimg_width'])) {
                    $data['tvcmscustomsetting_advanceblock_mainimg_width'] = $this->request->post['tvcmscustomsetting_advanceblock_mainimg_width'];
                } else {
                    $data['tvcmscustomsetting_advanceblock_mainimg_width'] = $this->config->get('tvcmscustomsetting_advanceblock_mainimg_width');
                }
                if (isset($this->request->post['tvcmscustomsetting_advanceblock_sub_mainimg_width'])) {
                    $data['tvcmscustomsetting_advanceblock_sub_mainimg_width'] = $this->request->post['tvcmscustomsetting_advanceblock_sub_mainimg_width'];
                } else {
                    $data['tvcmscustomsetting_advanceblock_sub_mainimg_width'] = $this->config->get('tvcmscustomsetting_advanceblock_sub_mainimg_width');
                }
                if (isset($this->request->post['tvcmscustomsetting_leftbanner_img_width'])) {
                    $data['tvcmscustomsetting_advanceblock_img_width'] = $this->request->post['tvcmscustomsetting_advanceblock_img_width'];
                } else {
                    $data['tvcmscustomsetting_advanceblock_img_width'] = $this->config->get('tvcmscustomsetting_advanceblock_img_width');
                }

                if (isset($this->request->post['tvcmscustomsetting_multibanner_mainimg_width'])) {
                    $data['tvcmscustomsetting_multibanner_mainimg_width'] = $this->request->post['tvcmscustomsetting_multibanner_mainimg_width'];
                } else {
                    $data['tvcmscustomsetting_multibanner_mainimg_width'] = $this->config->get('tvcmscustomsetting_multibanner_mainimg_width');
                }
                if (isset($this->request->post['tvcmscustomsetting_multibanner_img_width'])) {
                    $data['tvcmscustomsetting_multibanner_img_width'] = $this->request->post['tvcmscustomsetting_multibanner_img_width'];
                } else {
                    $data['tvcmscustomsetting_multibanner_img_width'] = $this->config->get('tvcmscustomsetting_multibanner_img_width');
                }

                if (isset($this->request->post['tvcmscustomsetting_footerproduct_img_width'])) {
                    $data['tvcmscustomsetting_footerproduct_img_width'] = $this->request->post['tvcmscustomsetting_footerproduct_img_width'];
                } else {
                    $data['tvcmscustomsetting_footerproduct_img_width'] = $this->config->get('tvcmscustomsetting_footerproduct_img_width');
                }
                if (isset($this->request->post['tvcmscustomsetting_leftbanner_img_width'])) {
                    $data['tvcmscustomsetting_leftbanner_img_width'] = $this->request->post['tvcmscustomsetting_leftbanner_img_width'];
                } else {
                    $data['tvcmscustomsetting_leftbanner_img_width'] = $this->config->get('tvcmscustomsetting_leftbanner_img_width');
                }

                if (isset($this->request->post['tvcmscustomsetting_leftproduct_img_width'])) {
                    $data['tvcmscustomsetting_leftproduct_img_width'] = $this->request->post['tvcmscustomsetting_leftproduct_img_width'];
                } else {
                    $data['tvcmscustomsetting_leftproduct_img_width'] = $this->config->get('tvcmscustomsetting_leftproduct_img_width');
                }
                if (isset($this->request->post['tvcmscustomsetting_lefttestimonial_img_width'])) {
                    $data['tvcmscustomsetting_lefttestimonial_img_width'] = $this->request->post['tvcmscustomsetting_lefttestimonial_img_width'];
                } else {
                    $data['tvcmscustomsetting_lefttestimonial_img_width'] = $this->config->get('tvcmscustomsetting_lefttestimonial_img_width');
                }
                if (isset($this->request->post['tvcmscustomsetting_tvcmssingleblock_img_width'])) {
                    $data['tvcmscustomsetting_tvcmssingleblock_img_width'] = $this->request->post['tvcmscustomsetting_tvcmssingleblock_img_width'];
                } else {
                    $data['tvcmscustomsetting_tvcmssingleblock_img_width'] = $this->config->get('tvcmscustomsetting_tvcmssingleblock_img_width');
                }
                if (isset($this->request->post['tvcmscustomsetting_tvcmsblogfeahome_img_width'])) {
                    $data['tvcmscustomsetting_tvcmsblogfeahome_img_width'] = $this->request->post['tvcmscustomsetting_tvcmsblogfeahome_img_width'];
                } else {
                    $data['tvcmscustomsetting_tvcmsblogfeahome_img_width'] = $this->config->get('tvcmscustomsetting_tvcmsblogfeahome_img_width');
                }
                if (isset($this->request->post['tvcmscustomsetting_tvcmsblogfeaall_img_width'])) {
                    $data['tvcmscustomsetting_tvcmsblogfeaall_img_width'] = $this->request->post['tvcmscustomsetting_tvcmsblogfeaall_img_width'];
                } else {
                    $data['tvcmscustomsetting_tvcmsblogfeaall_img_width'] = $this->config->get('tvcmscustomsetting_tvcmsblogfeaall_img_width');
                }
                if (isset($this->request->post['tvcmscustomsetting_tvcmsblogfeasin_img_width'])) {
                    $data['tvcmscustomsetting_tvcmsblogfeasin_img_width'] = $this->request->post['tvcmscustomsetting_tvcmsblogfeasin_img_width'];
                } else {
                    $data['tvcmscustomsetting_tvcmsblogfeasin_img_width'] = $this->config->get('tvcmscustomsetting_tvcmsblogfeasin_img_width');
                }

                if (isset($this->request->post['tvcmscustomsetting_tvcmsbloggallhome_img_width'])) {
                    $data['tvcmscustomsetting_tvcmsbloggallhome_img_width'] = $this->request->post['tvcmscustomsetting_tvcmsbloggallhome_img_width'];
                } else {
                    $data['tvcmscustomsetting_tvcmsbloggallhome_img_width'] = $this->config->get('tvcmscustomsetting_tvcmsbloggallhome_img_width');
                }
                if (isset($this->request->post['tvcmscustomsetting_tvcmsbloggallall_img_width'])) {
                    $data['tvcmscustomsetting_tvcmsbloggallall_img_width'] = $this->request->post['tvcmscustomsetting_tvcmsbloggallall_img_width'];
                } else {
                    $data['tvcmscustomsetting_tvcmsbloggallall_img_width'] = $this->config->get('tvcmscustomsetting_tvcmsbloggallall_img_width');
                }
                if (isset($this->request->post['tvcmscustomsetting_tvcmsbloggallsin_img_width'])) {
                    $data['tvcmscustomsetting_tvcmsbloggallsin_img_width'] = $this->request->post['tvcmscustomsetting_tvcmsbloggallsin_img_width'];
                } else {
                    $data['tvcmscustomsetting_tvcmsbloggallsin_img_width'] = $this->config->get('tvcmscustomsetting_tvcmsbloggallsin_img_width');
                }
                if (isset($this->request->post['tvcmscustomsetting_tvcmsnewsletterpoimg_img_width'])) {
                    $data['tvcmscustomsetting_tvcmsnewsletterpoimg_img_width'] = $this->request->post['tvcmscustomsetting_tvcmsnewsletterpoimg_img_width'];
                } else {
                    $data['tvcmscustomsetting_tvcmsnewsletterpoimg_img_width'] = $this->config->get('tvcmscustomsetting_tvcmsnewsletterpoimg_img_width');
                }
                if (isset($this->request->post['tvcmscustomsetting_tvcmsnewsletterpobgimg_img_width'])) {
                    $data['tvcmscustomsetting_tvcmsnewsletterpobgimg_img_width'] = $this->request->post['tvcmscustomsetting_tvcmsnewsletterpobgimg_img_width'];
                } else {
                    $data['tvcmscustomsetting_tvcmsnewsletterpobgimg_img_width'] = $this->config->get('tvcmscustomsetting_tvcmsnewsletterpobgimg_img_width');
                }
                if (isset($this->request->post['tvcmscustomsetting_tvcmsproductgridimg_img_width'])) {
                    $data['tvcmscustomsetting_tvcmsproductgridimg_img_width'] = $this->request->post['tvcmscustomsetting_tvcmsproductgridimg_img_width'];
                } else {
                    $data['tvcmscustomsetting_tvcmsproductgridimg_img_width'] = $this->config->get('tvcmscustomsetting_tvcmsproductgridimg_img_width');
                }
                if (isset($this->request->post['tvcmscustomsetting_special_img_width'])) {
                    $data['tvcmscustomsetting_special_img_width'] = $this->request->post['tvcmscustomsetting_special_img_width'];
                } else {
                    $data['tvcmscustomsetting_special_img_width'] = $this->config->get('tvcmscustomsetting_special_img_width');
                }
                
                if (isset($this->request->post['tvcmscustomsetting_footerproduct_width'])) {
                    $data['tvcmscustomsetting_footerproduct_width'] = $this->request->post['tvcmscustomsetting_footerproduct_width'];
                } else {
                    $data['tvcmscustomsetting_footerproduct_width'] = $this->config->get('tvcmscustomsetting_footerproduct_width');
                }
                 if (isset($this->request->post['tvcmscustomsetting_footerproduct_height'])) {
                    $data['tvcmscustomsetting_footerproduct_height'] = $this->request->post['tvcmscustomsetting_footerproduct_height'];
                } else {
                    $data['tvcmscustomsetting_footerproduct_height'] = $this->config->get('tvcmscustomsetting_footerproduct_height');
                }

                if (isset($this->request->post['tvcmscustomsetting_sliderimage_img_width'])) {
                    $data['tvcmscustomsetting_sliderimage_img_width'] = $this->request->post['tvcmscustomsetting_sliderimage_img_width'];
                } else {
                    $data['tvcmscustomsetting_sliderimage_img_width'] = $this->config->get('tvcmscustomsetting_sliderimage_img_width');
                }

                if (isset($this->request->post['tvcmscustomsetting_sliderimage_img_height'])) {
                    $data['tvcmscustomsetting_sliderimage_img_height'] = $this->request->post['tvcmscustomsetting_sliderimage_img_height'];
                } else {
                    $data['tvcmscustomsetting_sliderimage_img_height'] = $this->config->get('tvcmscustomsetting_sliderimage_img_height');
                }

                if (isset($this->request->post['tvcmscustomsetting_testimonial_sing_img_height'])) {
                    $data['tvcmscustomsetting_testimonial_sing_img_height'] = $this->request->post['tvcmscustomsetting_testimonial_sing_img_height'];
                } else {
                    $data['tvcmscustomsetting_testimonial_sing_img_height'] = $this->config->get('tvcmscustomsetting_testimonial_sing_img_height');
                }
                if (isset($this->request->post['tvcmscustomsetting_categoryslider_mainimg_height'])) {
                    $data['tvcmscustomsetting_categoryslider_mainimg_height'] = $this->request->post['tvcmscustomsetting_categoryslider_mainimg_height'];
                } else {
                    $data['tvcmscustomsetting_categoryslider_mainimg_height'] = $this->config->get('tvcmscustomsetting_categoryslider_mainimg_height');
                }
                if (isset($this->request->post['tvcmscustomsetting_categoryslider_img_height'])) {
                    $data['tvcmscustomsetting_categoryslider_img_height'] = $this->request->post['tvcmscustomsetting_categoryslider_img_height'];
                } else {
                    $data['tvcmscustomsetting_categoryslider_img_height'] = $this->config->get('tvcmscustomsetting_categoryslider_img_height');
                }
                if (isset($this->request->post['tvcmscustomsetting_customerservice_mainimg_height'])) {
                    $data['tvcmscustomsetting_customerservice_mainimg_height'] = $this->request->post['tvcmscustomsetting_customerservice_mainimg_height'];
                } else {
                    $data['tvcmscustomsetting_customerservice_mainimg_height'] = $this->config->get('tvcmscustomsetting_customerservice_mainimg_height');
                }
                if (isset($this->request->post['tvcmscustomsetting_customerservice_img_height'])) {
                    $data['tvcmscustomsetting_customerservice_img_height'] = $this->request->post['tvcmscustomsetting_customerservice_img_height'];
                } else {
                    $data['tvcmscustomsetting_customerservice_img_height'] = $this->config->get('tvcmscustomsetting_customerservice_img_height');
                }
                if (isset($this->request->post['tvcmscustomsetting_tabproduct_mainimg_height'])) {
                    $data['tvcmscustomsetting_tabproduct_mainimg_height'] = $this->request->post['tvcmscustomsetting_tabproduct_mainimg_height'];
                } else {
                    $data['tvcmscustomsetting_tabproduct_mainimg_height'] = $this->config->get('tvcmscustomsetting_tabproduct_mainimg_height');
                }
                if (isset($this->request->post['tvcmscustomsetting_featureproduct_mainimg_height'])) {
                    $data['tvcmscustomsetting_featureproduct_mainimg_height'] = $this->request->post['tvcmscustomsetting_featureproduct_mainimg_height'];
                } else {
                    $data['tvcmscustomsetting_featureproduct_mainimg_height'] = $this->config->get('tvcmscustomsetting_featureproduct_mainimg_height');
                }
                if (isset($this->request->post['tvcmscustomsetting_newproduct_mainimg_height'])) {
                    $data['tvcmscustomsetting_newproduct_mainimg_height'] = $this->request->post['tvcmscustomsetting_newproduct_mainimg_height'];
                } else {
                    $data['tvcmscustomsetting_newproduct_mainimg_height'] = $this->config->get('tvcmscustomsetting_newproduct_mainimg_height');
                }
                if (isset($this->request->post['tvcmscustomsetting_bestproduct_mainimg_height'])) {
                    $data['tvcmscustomsetting_bestproduct_mainimg_height'] = $this->request->post['tvcmscustomsetting_bestproduct_mainimg_height'];
                } else {
                    $data['tvcmscustomsetting_bestproduct_mainimg_height'] = $this->config->get('tvcmscustomsetting_bestproduct_mainimg_height');
                }
                if (isset($this->request->post['tvcmscustomsetting_specialproduct_mainimg_height'])) {
                    $data['tvcmscustomsetting_specialproduct_mainimg_height'] = $this->request->post['tvcmscustomsetting_specialproduct_mainimg_height'];
                } else {
                    $data['tvcmscustomsetting_specialproduct_mainimg_height'] = $this->config->get('tvcmscustomsetting_specialproduct_mainimg_height');
                }
                if (isset($this->request->post['tvcmscustomsetting_brand_mainimg_height'])) {
                    $data['tvcmscustomsetting_brand_mainimg_height'] = $this->request->post['tvcmscustomsetting_brand_mainimg_height'];
                } else {
                    $data['tvcmscustomsetting_brand_mainimg_height'] = $this->config->get('tvcmscustomsetting_brand_mainimg_height');
                }
                if (isset($this->request->post['tvcmscustomsetting_brand_img_height'])) {
                    $data['tvcmscustomsetting_brand_img_height'] = $this->request->post['tvcmscustomsetting_brand_img_height'];
                } else {
                    $data['tvcmscustomsetting_brand_img_height'] = $this->config->get('tvcmscustomsetting_brand_img_height');
                }
                if (isset($this->request->post['tvcmscustomsetting_testimonial_mainimg_height'])) {
                    $data['tvcmscustomsetting_testimonial_mainimg_height'] = $this->request->post['tvcmscustomsetting_testimonial_mainimg_height'];
                } else {
                    $data['tvcmscustomsetting_testimonial_mainimg_height'] = $this->config->get('tvcmscustomsetting_testimonial_mainimg_height');
                }
                if (isset($this->request->post['tvcmscustomsetting_testimonial_img_height'])) {
                    $data['tvcmscustomsetting_testimonial_img_height'] = $this->request->post['tvcmscustomsetting_testimonial_img_height'];
                } else {
                    $data['tvcmscustomsetting_testimonial_img_height'] = $this->config->get('tvcmscustomsetting_testimonial_img_height');
                }

                if (isset($this->request->post['tvcmscustomsetting_payment_mainimg_height'])) {
                    $data['tvcmscustomsetting_payment_mainimg_height'] = $this->request->post['tvcmscustomsetting_payment_mainimg_height'];
                } else {
                    $data['tvcmscustomsetting_payment_mainimg_height'] = $this->config->get('tvcmscustomsetting_payment_mainimg_height');
                }
                if (isset($this->request->post['tvcmscustomsetting_payment_img_height'])) {
                    $data['tvcmscustomsetting_payment_img_height'] = $this->request->post['tvcmscustomsetting_payment_img_height'];
                } else {
                    $data['tvcmscustomsetting_payment_img_height'] = $this->config->get('tvcmscustomsetting_payment_img_height');
                }

                if (isset($this->request->post['tvcmscustomsetting_social_img_height'])) {
                    $data['tvcmscustomsetting_social_img_height'] = $this->request->post['tvcmscustomsetting_social_img_height'];
                } else {
                    $data['tvcmscustomsetting_social_img_height'] = $this->config->get('tvcmscustomsetting_social_img_height');
                }

                if (isset($this->request->post['tvcmscustomsetting_footerlogo_img_height'])) {
                    $data['tvcmscustomsetting_footerlogo_img_height'] = $this->request->post['tvcmscustomsetting_footerlogo_img_height'];
                } else {
                    $data['tvcmscustomsetting_footerlogo_img_height'] = $this->config->get('tvcmscustomsetting_footerlogo_img_height');
                }

                if (isset($this->request->post['tvcmscustomsetting_offerbanner_img_height'])) {
                    $data['tvcmscustomsetting_offerbanner_img_height'] = $this->request->post['tvcmscustomsetting_offerbanner_img_height'];
                } else {
                    $data['tvcmscustomsetting_offerbanner_img_height'] = $this->config->get('tvcmscustomsetting_offerbanner_img_height');
                }

                if (isset($this->request->post['tvcmscustomsetting_app_img_height'])) {
                    $data['tvcmscustomsetting_app_img_height'] = $this->request->post['tvcmscustomsetting_app_img_height'];
                } else {
                    $data['tvcmscustomsetting_app_img_height'] = $this->config->get('tvcmscustomsetting_app_img_height');
                }
                if (isset($this->request->post['tvcmscustomsetting_advanceblock_mainimg_height'])) {
                    $data['tvcmscustomsetting_advanceblock_mainimg_height'] = $this->request->post['tvcmscustomsetting_advanceblock_mainimg_height'];
                } else {
                    $data['tvcmscustomsetting_advanceblock_mainimg_height'] = $this->config->get('tvcmscustomsetting_advanceblock_mainimg_height');
                }
                if (isset($this->request->post['tvcmscustomsetting_advanceblock_sub_mainimg_height'])) {
                    $data['tvcmscustomsetting_advanceblock_sub_mainimg_height'] = $this->request->post['tvcmscustomsetting_advanceblock_sub_mainimg_height'];
                } else {
                    $data['tvcmscustomsetting_advanceblock_sub_mainimg_height'] = $this->config->get('tvcmscustomsetting_advanceblock_sub_mainimg_height');
                }
                if (isset($this->request->post['tvcmscustomsetting_advanceblock_img_height'])) {
                    $data['tvcmscustomsetting_advanceblock_img_height'] = $this->request->post['tvcmscustomsetting_advanceblock_img_height'];
                } else {
                    $data['tvcmscustomsetting_advanceblock_img_height'] = $this->config->get('tvcmscustomsetting_advanceblock_img_height');
                }
                if (isset($this->request->post['tvcmscustomsetting_tabproduct_img_height'])) {
                    $data['tvcmscustomsetting_tabproduct_img_height'] = $this->request->post['tvcmscustomsetting_tabproduct_img_height'];
                } else {
                    $data['tvcmscustomsetting_tabproduct_img_height'] = $this->config->get('tvcmscustomsetting_tabproduct_img_height');
                }


                if (isset($this->request->post['tvcmscustomsetting_footerproduct_img_height'])) {
                    $data['tvcmscustomsetting_footerproduct_img_height'] = $this->request->post['tvcmscustomsetting_footerproduct_img_height'];
                } else {
                    $data['tvcmscustomsetting_footerproduct_img_height'] = $this->config->get('tvcmscustomsetting_footerproduct_img_height');
                }
                if (isset($this->request->post['tvcmscustomsetting_leftbanner_img_height'])) {
                    $data['tvcmscustomsetting_leftbanner_img_height'] = $this->request->post['tvcmscustomsetting_leftbanner_img_height'];
                } else {
                    $data['tvcmscustomsetting_leftbanner_img_height'] = $this->config->get('tvcmscustomsetting_leftbanner_img_height');
                }

                if (isset($this->request->post['tvcmscustomsetting_leftproduct_img_height'])) {
                    $data['tvcmscustomsetting_leftproduct_img_height'] = $this->request->post['tvcmscustomsetting_leftproduct_img_height'];
                } else {
                    $data['tvcmscustomsetting_leftproduct_img_height'] = $this->config->get('tvcmscustomsetting_leftproduct_img_height');
                }
                if (isset($this->request->post['tvcmscustomsetting_lefttestimonial_img_height'])) {
                    $data['tvcmscustomsetting_lefttestimonial_img_height'] = $this->request->post['tvcmscustomsetting_lefttestimonial_img_height'];
                } else {
                    $data['tvcmscustomsetting_lefttestimonial_img_height'] = $this->config->get('tvcmscustomsetting_lefttestimonial_img_height');
                }
                if (isset($this->request->post['tvcmscustomsetting_tvcmssingleblock_img_height'])) {
                    $data['tvcmscustomsetting_tvcmssingleblock_img_height'] = $this->request->post['tvcmscustomsetting_tvcmssingleblock_img_height'];
                } else {
                    $data['tvcmscustomsetting_tvcmssingleblock_img_height'] = $this->config->get('tvcmscustomsetting_tvcmssingleblock_img_height');
                }
                if (isset($this->request->post['tvcmscustomsetting_tvcmsblogfeahome_img_height'])) {
                    $data['tvcmscustomsetting_tvcmsblogfeahome_img_height'] = $this->request->post['tvcmscustomsetting_tvcmsblogfeahome_img_height'];
                } else {
                    $data['tvcmscustomsetting_tvcmsblogfeahome_img_height'] = $this->config->get('tvcmscustomsetting_tvcmsblogfeahome_img_height');
                }
                if (isset($this->request->post['tvcmscustomsetting_tvcmsblogfeaall_img_height'])) {
                    $data['tvcmscustomsetting_tvcmsblogfeaall_img_height'] = $this->request->post['tvcmscustomsetting_tvcmsblogfeaall_img_height'];
                } else {
                    $data['tvcmscustomsetting_tvcmsblogfeaall_img_height'] = $this->config->get('tvcmscustomsetting_tvcmsblogfeaall_img_height');
                }
                if (isset($this->request->post['tvcmscustomsetting_tvcmsblogfeasin_img_height'])) {
                    $data['tvcmscustomsetting_tvcmsblogfeasin_img_height'] = $this->request->post['tvcmscustomsetting_tvcmsblogfeasin_img_height'];
                } else {
                    $data['tvcmscustomsetting_tvcmsblogfeasin_img_height'] = $this->config->get('tvcmscustomsetting_tvcmsblogfeasin_img_height');
                }

                if (isset($this->request->post['tvcmscustomsetting_tvcmsbloggallhome_img_height'])) {
                    $data['tvcmscustomsetting_tvcmsbloggallhome_img_height'] = $this->request->post['tvcmscustomsetting_tvcmsbloggallhome_img_height'];
                } else {
                    $data['tvcmscustomsetting_tvcmsbloggallhome_img_height'] = $this->config->get('tvcmscustomsetting_tvcmsbloggallhome_img_height');
                }
                if (isset($this->request->post['tvcmscustomsetting_tvcmsbloggallall_img_height'])) {
                    $data['tvcmscustomsetting_tvcmsbloggallall_img_height'] = $this->request->post['tvcmscustomsetting_tvcmsbloggallall_img_height'];
                } else {
                    $data['tvcmscustomsetting_tvcmsbloggallall_img_height'] = $this->config->get('tvcmscustomsetting_tvcmsbloggallall_img_height');
                }
                if (isset($this->request->post['tvcmscustomsetting_tvcmsbloggallsin_img_height'])) {
                    $data['tvcmscustomsetting_tvcmsbloggallsin_img_height'] = $this->request->post['tvcmscustomsetting_tvcmsbloggallsin_img_height'];
                } else {
                    $data['tvcmscustomsetting_tvcmsbloggallsin_img_height'] = $this->config->get('tvcmscustomsetting_tvcmsbloggallsin_img_height');
                }
                if (isset($this->request->post['tvcmscustomsetting_tvcmsnewsletterpoimg_img_height'])) {
                    $data['tvcmscustomsetting_tvcmsnewsletterpoimg_img_height'] = $this->request->post['tvcmscustomsetting_tvcmsnewsletterpoimg_img_height'];
                } else {
                    $data['tvcmscustomsetting_tvcmsnewsletterpoimg_img_height'] = $this->config->get('tvcmscustomsetting_tvcmsnewsletterpoimg_img_height');
                }
                if (isset($this->request->post['tvcmscustomsetting_tvcmsnewsletterpobgimg_img_height'])) {
                    $data['tvcmscustomsetting_tvcmsnewsletterpobgimg_img_height'] = $this->request->post['tvcmscustomsetting_tvcmsnewsletterpobgimg_img_height'];
                } else {
                    $data['tvcmscustomsetting_tvcmsnewsletterpobgimg_img_height'] = $this->config->get('tvcmscustomsetting_tvcmsnewsletterpobgimg_img_height');
                }
                if (isset($this->request->post['tvcmscustomsetting_tvcmsproductgridimg_img_height'])) {
                    $data['tvcmscustomsetting_tvcmsproductgridimg_img_height'] = $this->request->post['tvcmscustomsetting_tvcmsproductgridimg_img_height'];
                } else {
                    $data['tvcmscustomsetting_tvcmsproductgridimg_img_height'] = $this->config->get('tvcmscustomsetting_tvcmsproductgridimg_img_height');
                }
                if (isset($this->request->post['tvcmscustomsetting_special_img_height'])) {
                    $data['tvcmscustomsetting_special_img_height'] = $this->request->post['tvcmscustomsetting_special_img_height'];
                } else {
                    $data['tvcmscustomsetting_special_img_height'] = $this->config->get('tvcmscustomsetting_special_img_height');
                }
                
		/*themevoltyimage*/

		$data['header'] 		= $this->load->controller('common/header');
		$data['column_left'] 	= $this->load->controller('common/column_left');
		$data['footer'] 		= $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/tvcmscustomsetting', $data));
	}

	public function install(){

		$this->load->model('localisation/language');
		$this->load->model('catalog/tvcmscategoryslider');
		$this->load->model('setting/setting');

		$main 																= array();
		$main['tvcmscustomsetting_status'] 									= 1;
		$main['tvcmscustomsetting_configuration']['themeoption'] 			= 'theme1';
        $main['tvcmscustomsetting_configuration']['customthemecolor'] 		= 'Black';
        $main['tvcmscustomsetting_configuration']['boxlayout'] 				= '0';
        $main['tvcmscustomsetting_configuration']['backgroundtheme'] 		= '1';
        $main['tvcmscustomsetting_configuration']['backgroundthemecolor'] 	= 'Black';
        $main['tvcmscustomsetting_configuration']['backgroundpattern'] 		= 'pattern14.png';
        $main['tvcmscustomsetting_configuration']['themeoptionstatus'] 		= '1';
        $main['tvcmscustomsetting_configuration']['pageloader'] 			= '1';
        $main['tvcmscustomsetting_configuration']['wowjs'] 					= '1';
        $main['tvcmscustomsetting_configuration']['mousehoverimage'] 		= '1';
        $main['tvcmscustomsetting_configuration']['tabproductdoublerow'] 	= '1'; 
        $main['tvcmscustomsetting_configuration']['productcolor'] 			= '1';
        $main['tvcmscustomsetting_configuration']['mainmenustickystatus'] 	= '1';
        $main['tvcmscustomsetting_configuration']['bottomoption']			= '1';
        $main['tvcmscustomsetting_configuration']['doublerow']				= '1';
        $main['tvcmscustomsetting_configuration']['verticalmenuopen'] 		= '1';
        $main['tvcmscustomsetting_configuration']['bloglimit'] 				= '3';
        $main['tvcmscustomsetting_configuration']['searchlimit'] 			= '5';
        $main['tvcmscustomsetting_configuration']['htmlminify'] 			= 1;
        $main['tvcmscustomsetting_configuration']['comparedisplay'] 		= 1;
        $main['tvcmscustomsetting_configuration']['wishlistdisplay'] 		= 1;
        $main['tvcmscustomsetting_offerbannarmain']['top'] 					= 1;
        $main['tvcmscustomsetting_offerbannarmain']['left'] 				= 1;
        $main['tvcmscustomsetting_appmain']['status'] 						= 1;
        $main['tvcmscustomsetting_custommain']['copyrighttextstatus'] 		= 1;
        $main['tvcmscustomsetting_custommain']['customtextstatus'] 			= 1;

		$main['tvcmscustomsetting_advanceblock_mainimg_width'] 				= 200;
		$main['tvcmscustomsetting_advanceblock_mainimg_height'] 			= 200;
		$main['tvcmscustomsetting_advanceblock_sub_mainimg_width'] 			= 375;
		$main['tvcmscustomsetting_advanceblock_sub_mainimg_height'] 		= 350;
		$main['tvcmscustomsetting_advanceblock_img_width'] 					= 73;
		$main['tvcmscustomsetting_advanceblock_img_height'] 				= 72;
		$main['tvcmscustomsetting_brand_mainimg_width'] 					= 200;
		$main['tvcmscustomsetting_brand_mainimg_height'] 					= 200;
		$main['tvcmscustomsetting_brand_img_width'] 						= 170;
		$main['tvcmscustomsetting_brand_img_height'] 						= 75;
		$main['tvcmscustomsetting_bestproduct_mainimg_width'] 				= 200;
		$main['tvcmscustomsetting_bestproduct_mainimg_height'] 				= 200;
		$main['tvcmscustomsetting_tvcmsbloggallhome_img_width'] 			= 956;
		$main['tvcmscustomsetting_tvcmsbloggallhome_img_height'] 			= 1000;
		$main['tvcmscustomsetting_tvcmsbloggallall_img_width'] 				= 956;
		$main['tvcmscustomsetting_tvcmsbloggallall_img_height'] 			= 1000;
		$main['tvcmscustomsetting_tvcmsbloggallsin_img_width'] 				= 956;
		$main['tvcmscustomsetting_tvcmsbloggallsin_img_height'] 			= 1000;
		$main['tvcmscustomsetting_tvcmsblogfeahome_img_width'] 				= 956;
		$main['tvcmscustomsetting_tvcmsblogfeahome_img_height'] 			= 1000;
		$main['tvcmscustomsetting_tvcmsblogfeaall_img_width'] 				= 956;
		$main['tvcmscustomsetting_tvcmsblogfeaall_img_height'] 				= 1000;
		$main['tvcmscustomsetting_tvcmsblogfeasin_img_width'] 				= 956;
		$main['tvcmscustomsetting_tvcmsblogfeasin_img_height'] 				= 1000;
		$main['tvcmscustomsetting_categoryslider_mainimg_width'] 			= 200;
		$main['tvcmscustomsetting_categoryslider_mainimg_height'] 			= 200;
		$main['tvcmscustomsetting_categoryslider_img_width'] 				= 100;
		$main['tvcmscustomsetting_categoryslider_img_height'] 				= 100;
		$main['tvcmscustomsetting_customerservice_mainimg_width'] 			= 200;
		$main['tvcmscustomsetting_customerservice_mainimg_height'] 			= 200;
		$main['tvcmscustomsetting_customerservice_img_width'] 				= 38;
		$main['tvcmscustomsetting_customerservice_img_height'] 				= 33;
		$main['tvcmscustomsetting_featureproduct_mainimg_width'] 			= 200;
		$main['tvcmscustomsetting_featureproduct_mainimg_height'] 			= 200;
		$main['tvcmscustomsetting_footerlogo_img_width'] 					= 189;
		$main['tvcmscustomsetting_footerlogo_img_height']					= 52;
		$main['tvcmscustomsetting_footerproduct_width'] 					= 125;
		$main['tvcmscustomsetting_footerproduct_height'] 					= 131;
		$main['tvcmscustomsetting_newproduct_mainimg_width'] 				= 200;
		$main['tvcmscustomsetting_newproduct_mainimg_height'] 				= 200;
		$main['tvcmscustomsetting_tvcmsnewsletterpoimg_img_width'] 			= 306;
		$main['tvcmscustomsetting_tvcmsnewsletterpoimg_img_height'] 		= 444;
		$main['tvcmscustomsetting_tvcmsnewsletterpobgimg_img_width'] 		= 306;
		$main['tvcmscustomsetting_tvcmsnewsletterpobgimg_img_height'] 		= 444;
		$main['tvcmscustomsetting_leftbanner_img_width'] 					= 241;
		$main['tvcmscustomsetting_leftbanner_img_height'] 					= 400;
		$main['tvcmscustomsetting_leftproduct_img_width'] 					= 100;
		$main['tvcmscustomsetting_leftproduct_img_height'] 					= 105;
		$main['tvcmscustomsetting_lefttestimonial_img_width'] 				= 50;
		$main['tvcmscustomsetting_lefttestimonial_img_height'] 				= 50;
		$main['tvcmscustomsetting_offerbanner_img_width'] 					= 1328;
		$main['tvcmscustomsetting_offerbanner_img_height'] 					= 400;
		$main['tvcmscustomsetting_payment_mainimg_width'] 					= 200;
		$main['tvcmscustomsetting_payment_mainimg_height'] 					= 200;
		$main['tvcmscustomsetting_payment_img_width'] 						= 60;
		$main['tvcmscustomsetting_payment_img_height'] 						= 30;
		$main['tvcmscustomsetting_tvcmsproductgridimg_img_width'] 			= 800;
		$main['tvcmscustomsetting_tvcmsproductgridimg_img_height'] 			= 928;
		$main['tvcmscustomsetting_social_img_width'] 						= 200;
		$main['tvcmscustomsetting_social_img_height'] 						= 200;
		$main['tvcmscustomsetting_specialproduct_mainimg_width'] 			= 265;
		$main['tvcmscustomsetting_specialproduct_mainimg_height'] 			= 384;
		$main['tvcmscustomsetting_special_img_width'] 						= 235;
		$main['tvcmscustomsetting_special_img_height'] 						= 235;
		$main['tvcmscustomsetting_sliderimage_img_width'] 					= 1056;
		$main['tvcmscustomsetting_sliderimage_img_height'] 					= 450;
		$main['tvcmscustomsetting_tvcmssingleblock_img_width'] 				= 69;
		$main['tvcmscustomsetting_tvcmssingleblock_img_height'] 			= 68;

		$main['tvcmscustomsetting_tabproduct_mainimg_width'] 				= 200;
		$main['tvcmscustomsetting_tabproduct_mainimg_height'] 				= 200;
		$main['tvcmscustomsetting_tabproduct_img_width'] 					= 380;
		$main['tvcmscustomsetting_tabproduct_img_height'] 					= 430;
		$main['tvcmscustomsetting_testimonial_mainimg_width'] 				= 200;
		$main['tvcmscustomsetting_testimonial_mainimg_height'] 				= 200;
		$main['tvcmscustomsetting_testimonial_img_width'] 					= 50;
		$main['tvcmscustomsetting_testimonial_img_height'] 					= 50;

		$main['tvcmscustomsetting_testimonial_sing_img_width'] 				= 200;
		$main['tvcmscustomsetting_testimonial_sing_img_height'] 			= 200;
		
		$main['tvcmscustomsetting_app_img_width'] 							= 150;
		$main['tvcmscustomsetting_app_img_height'] 							= 44;

        /*image_setting*/
		$languages = $this->model_localisation_language->getLanguages();
        foreach ($languages as $value) {
        	$main['tvcmscustomsetting_offerbannarsub']['lang_text'][$value['language_id']] =  array('topimg'=>"catalog/themevolty/customsetting/demo_img_1.jpg",'leftimg'=>"catalog/themevolty/customsetting/demo_img_2.jpg");
        	$main['tvcmscustomsetting_appsub']['lang_text'][$value['language_id']]   =  array('topimg1_width'=>"150",'topimg1_height'=>"44",'topimg1'=>"catalog/themevolty/applicationphoto/App-logo-1.png",'topimg2_width'=>"150",'topimg2_height'=>"44",'topimg2'=>"catalog/themevolty/applicationphoto/App-logo-2.png",'link'=>"#",'topimg3_width'=>"122",'topimg3_height'=>"44",'topimg3'=>"catalog/themevolty/applicationphoto/App-logo-3.png",'google'=>"#",'micro'=>"#");
        	$main['tvcmscustomsetting_customsub']['lang_text'][$value['language_id']] =  array('text'=>"© 2019 - Ecommerce software by Opencart™",'link'=>"#",'nopro'=>"10",'newslettertitle'=>"newsletter","newslettersubtitle"=>"Register now to get updates on promotions and coupons.",'customtextstatus'=>"1",'customtext'=>"India's Fastest Online Shopping Destination");

		}
		$this->model_setting_setting->editSetting('tvcmscustomsetting', $main);
	}

	protected function status(){
		return $this->Tvcmsthemevoltystatus->customsetting();
	}
	
	protected function validatesetting() {
		$this->load->language('extension/module/tvcmsimageslider');

		if (!$this->user->hasPermission('modify', 'extension/module/tvcmscustomsetting')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (empty($this->request->post['tvcmscustomsetting_categoryslider_mainimg_width']) || !is_numeric($this->request->post['tvcmscustomsetting_categoryslider_mainimg_width']) || empty($this->request->post['tvcmscustomsetting_categoryslider_mainimg_height']) || !is_numeric($this->request->post['tvcmscustomsetting_categoryslider_mainimg_height'])) {
			$this->error['tvcmscustomsetting_categoryslider_mainimg'] = $this->language->get('error_categoryslider_mainimg');
			$this->error['main'] = "Image Setting > ".$this->language->get('error_categoryslider_mainimg');
		}
		if (empty($this->request->post['tvcmscustomsetting_categoryslider_img_width']) || !is_numeric($this->request->post['tvcmscustomsetting_categoryslider_img_width']) || empty($this->request->post['tvcmscustomsetting_categoryslider_img_height']) || !is_numeric($this->request->post['tvcmscustomsetting_categoryslider_img_height'])) {
			$this->error['tvcmscustomsetting_categoryslider_img'] = $this->language->get('error_categoryslider_img');
			$this->error['main'] = "Image Setting > ".$this->language->get('error_categoryslider_img');
		}
		if (empty($this->request->post['tvcmscustomsetting_customerservice_mainimg_width']) || !is_numeric($this->request->post['tvcmscustomsetting_customerservice_mainimg_width']) || empty($this->request->post['tvcmscustomsetting_customerservice_mainimg_height']) || !is_numeric($this->request->post['tvcmscustomsetting_customerservice_mainimg_height'])) {
			$this->error['tvcmscustomsetting_customerservice_mainimg'] = $this->language->get('error_customerservice_mainimg');
			$this->error['main'] = "Image Setting > ".$this->language->get('error_customerservice_mainimg');
		}
		if (empty($this->request->post['tvcmscustomsetting_customerservice_img_width']) || !is_numeric($this->request->post['tvcmscustomsetting_customerservice_img_width']) || empty($this->request->post['tvcmscustomsetting_customerservice_img_height']) || !is_numeric($this->request->post['tvcmscustomsetting_customerservice_img_height'])) {
			$this->error['tvcmscustomsetting_customerservice_img'] = $this->language->get('error_customerservice_img');
			$this->error['main'] = "Image Setting > ".$this->language->get('error_customerservice_img');
		}
		if (empty($this->request->post['tvcmscustomsetting_tabproduct_mainimg_width']) || !is_numeric($this->request->post['tvcmscustomsetting_tabproduct_mainimg_width']) || empty($this->request->post['tvcmscustomsetting_tabproduct_mainimg_height']) || !is_numeric($this->request->post['tvcmscustomsetting_tabproduct_mainimg_height'])) {
			$this->error['tvcmscustomsetting_tabproduct_mainimg'] = $this->language->get('error_tabproduct_mainimg');
			$this->error['main'] = "Image Setting > ".$this->language->get('error_tabproduct_mainimg');
		}
		if (empty($this->request->post['tvcmscustomsetting_tabproduct_img_width']) || !is_numeric($this->request->post['tvcmscustomsetting_tabproduct_img_width']) || empty($this->request->post['tvcmscustomsetting_tabproduct_img_height']) || !is_numeric($this->request->post['tvcmscustomsetting_tabproduct_img_height'])) {
			$this->error['tvcmscustomsetting_tabproduct_img'] = $this->language->get('error_tabproduct_img');
			$this->error['main'] = "Image Setting > ".$this->language->get('error_tabproduct_img');
		}
		if (empty($this->request->post['tvcmscustomsetting_featureproduct_mainimg_width']) || !is_numeric($this->request->post['tvcmscustomsetting_featureproduct_mainimg_width']) || empty($this->request->post['tvcmscustomsetting_featureproduct_mainimg_height']) || !is_numeric($this->request->post['tvcmscustomsetting_featureproduct_mainimg_height'])) {
			$this->error['tvcmscustomsetting_featureproduct_mainimg'] = $this->language->get('error_featureproduct_mainimg');
			$this->error['main'] = "Image Setting > ".$this->language->get('error_featureproduct_mainimg');
		}
		if (empty($this->request->post['tvcmscustomsetting_newproduct_mainimg_width']) || !is_numeric($this->request->post['tvcmscustomsetting_newproduct_mainimg_width']) || empty($this->request->post['tvcmscustomsetting_newproduct_mainimg_height']) || !is_numeric($this->request->post['tvcmscustomsetting_newproduct_mainimg_height'])) {
					$this->error['tvcmscustomsetting_newproduct_mainimg'] = $this->language->get('error_newproduct_mainimg');
					$this->error['main'] = "Image Setting > ".$this->language->get('error_newproduct_mainimg');
		}
		if (empty($this->request->post['tvcmscustomsetting_bestproduct_mainimg_width']) || !is_numeric($this->request->post['tvcmscustomsetting_bestproduct_mainimg_width']) || empty($this->request->post['tvcmscustomsetting_bestproduct_mainimg_height']) || !is_numeric($this->request->post['tvcmscustomsetting_bestproduct_mainimg_height'])) {
					$this->error['tvcmscustomsetting_bestproduct_mainimg'] = $this->language->get('error_bestproduct_mainimg');
					$this->error['main'] = "Image Setting > ".$this->language->get('error_bestproduct_mainimg');
		}
		if (empty($this->request->post['tvcmscustomsetting_specialproduct_mainimg_width']) || !is_numeric($this->request->post['tvcmscustomsetting_specialproduct_mainimg_width']) || empty($this->request->post['tvcmscustomsetting_specialproduct_mainimg_height']) || !is_numeric($this->request->post['tvcmscustomsetting_specialproduct_mainimg_height'])) {
					$this->error['tvcmscustomsetting_specialproduct_mainimg'] = $this->language->get('error_specialproduct_mainimg');
					$this->error['main'] = "Image Setting > ".$this->language->get('error_specialproduct_mainimg');
		}
		if (empty($this->request->post['tvcmscustomsetting_brand_mainimg_width']) || !is_numeric($this->request->post['tvcmscustomsetting_brand_mainimg_width']) || empty($this->request->post['tvcmscustomsetting_brand_mainimg_height']) || !is_numeric($this->request->post['tvcmscustomsetting_brand_mainimg_height'])) {
					$this->error['tvcmscustomsetting_brand_mainimg'] = $this->language->get('error_brand_mainimg');
					$this->error['main'] = "Image Setting > ".$this->language->get('error_brand_mainimg');
		}
		if (empty($this->request->post['tvcmscustomsetting_brand_img_width']) || !is_numeric($this->request->post['tvcmscustomsetting_brand_img_width']) || empty($this->request->post['tvcmscustomsetting_brand_img_height']) || !is_numeric($this->request->post['tvcmscustomsetting_brand_img_height'])) {
					$this->error['tvcmscustomsetting_brand_img'] = $this->language->get('error_brand_img');
					$this->error['main'] = "Image Setting > ".$this->language->get('error_brand_img');
		}
		if (empty($this->request->post['tvcmscustomsetting_testimonial_mainimg_width']) || !is_numeric($this->request->post['tvcmscustomsetting_testimonial_mainimg_width']) || empty($this->request->post['tvcmscustomsetting_testimonial_mainimg_height']) || !is_numeric($this->request->post['tvcmscustomsetting_testimonial_mainimg_height'])) {
					$this->error['tvcmscustomsetting_testimonial_mainimg'] = $this->language->get('error_testimonial_mainimg');
					$this->error['main'] = "Image Setting > ".$this->language->get('error_testimonial_mainimg');
		}
		if (empty($this->request->post['tvcmscustomsetting_testimonial_img_width']) || !is_numeric($this->request->post['tvcmscustomsetting_testimonial_img_width']) || empty($this->request->post['tvcmscustomsetting_testimonial_img_height']) || !is_numeric($this->request->post['tvcmscustomsetting_testimonial_img_height'])) {
					$this->error['tvcmscustomsetting_testimonial_img'] = $this->language->get('error_testimonial_img');
					$this->error['main'] = "Image Setting > ".$this->language->get('error_testimonial_img');
		}
		if (empty($this->request->post['tvcmscustomsetting_testimonial_sing_img_width']) || !is_numeric($this->request->post['tvcmscustomsetting_testimonial_sing_img_width']) || empty($this->request->post['tvcmscustomsetting_testimonial_sing_img_height']) || !is_numeric($this->request->post['tvcmscustomsetting_testimonial_sing_img_height'])) {
							$this->error['tvcmscustomsetting_testimonial_sing_img'] = $this->language->get('error_testimonial_sing_img');
							$this->error['main'] = "Image Setting > ".$this->language->get('error_testimonial_sing_img');
		}
		if (empty($this->request->post['tvcmscustomsetting_payment_mainimg_width']) || !is_numeric($this->request->post['tvcmscustomsetting_payment_mainimg_width']) || empty($this->request->post['tvcmscustomsetting_payment_mainimg_height']) || !is_numeric($this->request->post['tvcmscustomsetting_payment_mainimg_height'])) {
							$this->error['tvcmscustomsetting_payment_mainimg'] = $this->language->get('error_payment_mainimg');
							$this->error['main'] = "Image Setting > ".$this->language->get('error_payment_mainimg');
		}
		if (empty($this->request->post['tvcmscustomsetting_payment_img_width']) || !is_numeric($this->request->post['tvcmscustomsetting_payment_img_width']) || empty($this->request->post['tvcmscustomsetting_payment_img_height']) || !is_numeric($this->request->post['tvcmscustomsetting_payment_img_height'])) {
							$this->error['tvcmscustomsetting_payment_img'] = $this->language->get('error_payment_img');
							$this->error['main'] = "Image Setting > ".$this->language->get('error_payment_img');
		}
		if (empty($this->request->post['tvcmscustomsetting_social_img_width']) || !is_numeric($this->request->post['tvcmscustomsetting_social_img_width']) || empty($this->request->post['tvcmscustomsetting_social_img_height']) || !is_numeric($this->request->post['tvcmscustomsetting_social_img_height'])) {
							$this->error['tvcmscustomsetting_social_img'] = $this->language->get('error_social_img');
							$this->error['main'] = "Image Setting > ".$this->language->get('error_social_img');
		}
		if (empty($this->request->post['tvcmscustomsetting_footerlogo_img_width']) || !is_numeric($this->request->post['tvcmscustomsetting_footerlogo_img_width']) || empty($this->request->post['tvcmscustomsetting_footerlogo_img_height']) || !is_numeric($this->request->post['tvcmscustomsetting_footerlogo_img_height'])) {
							$this->error['tvcmscustomsetting_footerlogo_img'] = $this->language->get('error_footerlogo_img');
							$this->error['main'] = "Image Setting > ".$this->language->get('error_footerlogo_img');
		}
		if (empty($this->request->post['tvcmscustomsetting_offerbanner_img_width']) || !is_numeric($this->request->post['tvcmscustomsetting_offerbanner_img_width']) || empty($this->request->post['tvcmscustomsetting_offerbanner_img_height']) || !is_numeric($this->request->post['tvcmscustomsetting_offerbanner_img_height'])) {
							$this->error['tvcmscustomsetting_offerbanner_img'] = $this->language->get('error_offerbanner_img');
							$this->error['main'] = "Image Setting > ".$this->language->get('error_offerbanner_img');
		}
		
		if (empty($this->request->post['tvcmscustomsetting_advanceblock_mainimg_width']) || !is_numeric($this->request->post['tvcmscustomsetting_advanceblock_mainimg_width']) || empty($this->request->post['tvcmscustomsetting_advanceblock_mainimg_height']) || !is_numeric($this->request->post['tvcmscustomsetting_advanceblock_mainimg_height'])) {
							$this->error['tvcmscustomsetting_advanceblock_mainimg'] = $this->language->get('error_advanceblock_mainimg');
							$this->error['main'] = "Image Setting > ".$this->language->get('error_advanceblock_mainimg');
		}
		if (empty($this->request->post['tvcmscustomsetting_advanceblock_sub_mainimg_width']) || !is_numeric($this->request->post['tvcmscustomsetting_advanceblock_sub_mainimg_width']) || empty($this->request->post['tvcmscustomsetting_advanceblock_sub_mainimg_height']) || !is_numeric($this->request->post['tvcmscustomsetting_advanceblock_sub_mainimg_height'])) {
							$this->error['tvcmscustomsetting_advanceblock_sub_mainimg'] = $this->language->get('error_advanceblock_sub_mainimg');
							$this->error['main'] = "Image Setting > ".$this->language->get('error_advanceblock_sub_mainimg');
		}
		if (empty($this->request->post['tvcmscustomsetting_advanceblock_img_width']) || !is_numeric($this->request->post['tvcmscustomsetting_advanceblock_img_width']) || empty($this->request->post['tvcmscustomsetting_advanceblock_img_height']) || !is_numeric($this->request->post['tvcmscustomsetting_advanceblock_img_height'])) {
							$this->error['tvcmscustomsetting_advanceblock_img'] = $this->language->get('error_advanceblock_img');
							$this->error['main'] = "Image Setting > ".$this->language->get('error_advanceblock_img');
		}
		if (empty($this->request->post['tvcmscustomsetting_leftbanner_img_width']) || !is_numeric($this->request->post['tvcmscustomsetting_leftbanner_img_width']) || empty($this->request->post['tvcmscustomsetting_leftbanner_img_height']) || !is_numeric($this->request->post['tvcmscustomsetting_leftbanner_img_height'])) {
							$this->error['tvcmscustomsetting_leftbanner_img'] = $this->language->get('error_leftbanner_img');
							$this->error['main'] = "Image Setting > ".$this->language->get('error_leftbanner_img');
		}
		if (empty($this->request->post['tvcmscustomsetting_leftproduct_img_width']) || !is_numeric($this->request->post['tvcmscustomsetting_leftproduct_img_width']) || empty($this->request->post['tvcmscustomsetting_leftproduct_img_height']) || !is_numeric($this->request->post['tvcmscustomsetting_leftproduct_img_height'])) {
							$this->error['tvcmscustomsetting_leftproduct_img'] = $this->language->get('error_leftproduct_img');
							$this->error['main'] = "Image Setting > ".$this->language->get('error_leftproduct_img');
		}
		if (empty($this->request->post['tvcmscustomsetting_lefttestimonial_img_width']) || !is_numeric($this->request->post['tvcmscustomsetting_lefttestimonial_img_width']) || empty($this->request->post['tvcmscustomsetting_lefttestimonial_img_height']) || !is_numeric($this->request->post['tvcmscustomsetting_lefttestimonial_img_height'])) {
							$this->error['tvcmscustomsetting_lefttestimonial_img'] = $this->language->get('error_lefttestimonial_img');
							$this->error['main'] = "Image Setting > ".$this->language->get('error_lefttestimonial_img');
		}
		if (empty($this->request->post['tvcmscustomsetting_tvcmssingleblock_img_width']) || !is_numeric($this->request->post['tvcmscustomsetting_tvcmssingleblock_img_width']) || empty($this->request->post['tvcmscustomsetting_tvcmssingleblock_img_height']) || !is_numeric($this->request->post['tvcmscustomsetting_tvcmssingleblock_img_height'])) {
							$this->error['tvcmscustomsetting_tvcmssingleblock_img'] = $this->language->get('error_tvcmssingleblock_img');
							$this->error['main'] = "Image Setting > ".$this->language->get('error_tvcmssingleblock_img');
		}
		if (empty($this->request->post['tvcmscustomsetting_tvcmsblogfeahome_img_width']) || !is_numeric($this->request->post['tvcmscustomsetting_tvcmsblogfeahome_img_width']) || empty($this->request->post['tvcmscustomsetting_tvcmsblogfeahome_img_height']) || !is_numeric($this->request->post['tvcmscustomsetting_tvcmsblogfeahome_img_height'])) {
							$this->error['tvcmscustomsetting_tvcmsblogfeahome_img'] = $this->language->get('error_tvcmsblogfeahome_img');
							$this->error['main'] = "Image Setting > ".$this->language->get('error_tvcmsblogfeahome_img');
		}
		if (empty($this->request->post['tvcmscustomsetting_tvcmsblogfeaall_img_width']) || !is_numeric($this->request->post['tvcmscustomsetting_tvcmsblogfeaall_img_width']) || empty($this->request->post['tvcmscustomsetting_tvcmsblogfeaall_img_height']) || !is_numeric($this->request->post['tvcmscustomsetting_tvcmsblogfeaall_img_height'])) {
							$this->error['tvcmscustomsetting_tvcmsblogfeaall_img'] = $this->language->get('error_tvcmsblogfeaall_img');
							$this->error['main'] = "Image Setting > ".$this->language->get('error_tvcmsblogfeaall_img');
		}
		if (empty($this->request->post['tvcmscustomsetting_tvcmsblogfeasin_img_width']) || !is_numeric($this->request->post['tvcmscustomsetting_tvcmsblogfeasin_img_width']) || empty($this->request->post['tvcmscustomsetting_tvcmsblogfeasin_img_height']) || !is_numeric($this->request->post['tvcmscustomsetting_tvcmsblogfeasin_img_height'])) {
							$this->error['tvcmscustomsetting_tvcmsblogfeasin_img'] = $this->language->get('error_tvcmsblogfeasin_img');
							$this->error['main'] = "Image Setting > ".$this->language->get('error_tvcmsblogfeasin_img');
		}

		if (empty($this->request->post['tvcmscustomsetting_tvcmsbloggallhome_img_width']) || !is_numeric($this->request->post['tvcmscustomsetting_tvcmsbloggallhome_img_width']) || empty($this->request->post['tvcmscustomsetting_tvcmsbloggallhome_img_height']) || !is_numeric($this->request->post['tvcmscustomsetting_tvcmsbloggallhome_img_height'])) {
							$this->error['tvcmscustomsetting_tvcmsbloggallhome_img'] = $this->language->get('error_tvcmsbloggallhome_img');
							$this->error['main'] = "Image Setting > ".$this->language->get('error_tvcmsbloggallhome_img');
		}
		if (empty($this->request->post['tvcmscustomsetting_tvcmsbloggallall_img_width']) || !is_numeric($this->request->post['tvcmscustomsetting_tvcmsbloggallall_img_width']) || empty($this->request->post['tvcmscustomsetting_tvcmsbloggallall_img_height']) || !is_numeric($this->request->post['tvcmscustomsetting_tvcmsbloggallall_img_height'])) {
							$this->error['tvcmscustomsetting_tvcmsbloggallall_img'] = $this->language->get('error_tvcmsbloggallall_img');
							$this->error['main'] = "Image Setting > ".$this->language->get('error_tvcmsbloggallall_img');
		}
		if (empty($this->request->post['tvcmscustomsetting_tvcmsbloggallsin_img_width']) || !is_numeric($this->request->post['tvcmscustomsetting_tvcmsbloggallsin_img_width']) || empty($this->request->post['tvcmscustomsetting_tvcmsbloggallsin_img_height']) || !is_numeric($this->request->post['tvcmscustomsetting_tvcmsbloggallsin_img_height'])) {
							$this->error['tvcmscustomsetting_tvcmsbloggallsin_img'] = $this->language->get('error_tvcmsbloggallsin_img');
							$this->error['main'] = "Image Setting > ".$this->language->get('error_tvcmsbloggallsin_img');
		}
		if (empty($this->request->post['tvcmscustomsetting_tvcmsnewsletterpoimg_img_width']) || !is_numeric($this->request->post['tvcmscustomsetting_tvcmsnewsletterpoimg_img_width']) || empty($this->request->post['tvcmscustomsetting_tvcmsnewsletterpoimg_img_height']) || !is_numeric($this->request->post['tvcmscustomsetting_tvcmsnewsletterpoimg_img_height'])) {
							$this->error['tvcmscustomsetting_tvcmsnewsletterpoimg_img'] = $this->language->get('error_tvcmsnewsletterpoimg_img');
							$this->error['main'] = "Image Setting > ".$this->language->get('error_tvcmsnewsletterpoimg_img');
		}
		if (empty($this->request->post['tvcmscustomsetting_tvcmsnewsletterpobgimg_img_width']) || !is_numeric($this->request->post['tvcmscustomsetting_tvcmsnewsletterpobgimg_img_width']) || empty($this->request->post['tvcmscustomsetting_tvcmsnewsletterpobgimg_img_height']) || !is_numeric($this->request->post['tvcmscustomsetting_tvcmsnewsletterpobgimg_img_height'])) {
							$this->error['tvcmscustomsetting_tvcmsnewsletterpobgimg_img'] = $this->language->get('error_tvcmsnewsletterpobgimg_img');
							$this->error['main'] = "Image Setting > ".$this->language->get('error_tvcmsnewsletterpobgimg_img');
		}
		if (empty($this->request->post['tvcmscustomsetting_tvcmsproductgridimg_img_width']) || !is_numeric($this->request->post['tvcmscustomsetting_tvcmsproductgridimg_img_width']) || empty($this->request->post['tvcmscustomsetting_tvcmsproductgridimg_img_height']) || !is_numeric($this->request->post['tvcmscustomsetting_tvcmsproductgridimg_img_height'])) {
							$this->error['tvcmscustomsetting_tvcmsproductgridimg_img'] = $this->language->get('error_tvcmsproductgrid_img');
							$this->error['main'] = "Image Setting > ".$this->language->get('error_tvcmsproductgrid_img');
		}
		if (empty($this->request->post['tvcmscustomsetting_special_img_width']) || !is_numeric($this->request->post['tvcmscustomsetting_special_img_width']) || empty($this->request->post['tvcmscustomsetting_special_img_height']) || !is_numeric($this->request->post['tvcmscustomsetting_special_img_height'])) {
				$this->error['tvcmscustomsetting_special_img'] = $this->language->get('error_special_img');
				$this->error['main'] = "Image Setting > ".$this->language->get('error_special_img');
		}
		if (empty($this->request->post['tvcmscustomsetting_footerproduct_width']) || !is_numeric($this->request->post['tvcmscustomsetting_footerproduct_width']) || empty($this->request->post['tvcmscustomsetting_footerproduct_height']) || !is_numeric($this->request->post['tvcmscustomsetting_footerproduct_height'])) {
				$this->error['tvcmscustomsetting_footerproduct_img'] = $this->language->get('error_footerproduct_img');
				$this->error['main'] = "Image Setting > ".$this->language->get('error_footerproduct_img');
		}
		if (empty($this->request->post['tvcmscustomsetting_sliderimage_img_width']) || !is_numeric($this->request->post['tvcmscustomsetting_sliderimage_img_width']) || empty($this->request->post['tvcmscustomsetting_sliderimage_img_height']) || !is_numeric($this->request->post['tvcmscustomsetting_sliderimage_img_height'])) {
			$this->error['tvcmscustomsetting_sliderimage_img'] 	= $this->language->get('error_sliderimage_img');
			$this->error['main'] 								= "Image Setting > ".$this->language->get('error_sliderimage_img');
		}

				

		return !$this->error;
	}

	public function makeInslineStyleSheet(){
    	$themeoptionstatus 		= $this->request->post['tvcmscustomsetting_configuration']['themeoptionstatus'];
		$themeoptions 			= $this->request->post['tvcmscustomsetting_configuration']['themeoption'];
        $style 					= '';
		$boxlayout 				= $this->request->post['tvcmscustomsetting_configuration']['boxlayout'];
		if($boxlayout == "1"){
			$backgroundtheme 	= $this->request->post['tvcmscustomsetting_configuration']['backgroundtheme'];
			if ($backgroundtheme == "bgcolor"){
				$style 			= 'background-color:'.$this->request->post['tvcmscustomsetting_configuration']['backgroundthemecolor'];
			}else{
				$data['backgroundthemepattern'] =$this->request->post['tvcmscustomsetting_configuration']['backgroundpattern'];
				$path 			= HTTP_CATALOG."image/catalog/themevolty/pattern/".$data['backgroundthemepattern'].".png";
				
                $style 			= 'background-image:url('.$path.');background-attachment: fixed;';
			}
		}
		$this->request->post['tvcmscustomsetting_background_style_sheet'] = $style;
        if ($themeoptions == 'theme_custom') {
            // this is Color
            
            $color_replace_1 	= "#maincolor1";
            $custom_theme_color =$this->request->post['tvcmscustomsetting_configuration']['customthemecolor'];

            $color_1 			= $custom_theme_color;

            // This is Gredeant Color
            $color_replace_2 	= "#MainColorNew1";
            $color_new_2 		= $this->colorLuminance("#ffffff", 0.40);
            $ftpThemeDir = DIR_CATALOG."view/theme/HRX_oc_furniture_furniture_702/assets/css";
            $filename = $ftpThemeDir."/theme-custom.css";
            $themeCssPath = '/theme_custom.css';
            $newfilename= $ftpThemeDir.$themeCssPath;
            $this->createCustomThemeCss(
                $filename,
                $newfilename,
                $color_replace_1,
                $color_1,
                $color_replace_2,
                $color_new_2
            );
            $this->request->post['tvcmscustomsetting_theme_css_path'] = $themeCssPath;
        }
    }

    public function colorLuminance($hex, $percent){
        $hex = preg_replace('/[^0-9a-f]/i', '', $hex);
        $new_hex = '#';
        if (strlen($hex) < 6) {
            $hex = $hex[0] + $hex[0] + $hex[1] + $hex[1] + $hex[2] + $hex[2];
        }
        
        // convert to decimal and change luminosity
        for ($i = 0; $i < 3; $i++) {
            $dec = hexdec(substr($hex, $i*2, 2));
            $dec = min(max(0, $dec + $dec * $percent), 255);
            $new_hex .= str_pad(dechex($dec), 2, 0, STR_PAD_LEFT);
        }
        
        return $new_hex;
    }


    public function createCustomThemeCss($filename, $newfilename, $string_to_replace1, $replace_with1, $string_to_replace2, $replace_with2) {
        $content= file_get_contents($filename);
        
        $content_chunks=explode($string_to_replace1, $content);
        $content=implode($replace_with1, $content_chunks);

        $content_chunks=explode($string_to_replace2, $content);
        $content=implode($replace_with2, $content_chunks);
         

        file_put_contents($newfilename, $content);
        // echo "<pre>"; print_r($newfilename); echo "</pre>";
        // echo "<pre>"; print_r($content); echo "</pre>"; die;
    }
}