<?php

class ControllerExtensionModuletvcmsspecialproduct extends Controller {
	public function index($setting) {
		if($this->config->get('theme_default_directory') == "opc_electronic_electron_2501"){
			if($setting['status']){
				$this->load->language('extension/module/tvcmscustomtext');
				$this->load->model('catalog/product');
				$this->load->model('tool/image');
				$data['text_tax'] 							= $this->language->get('text_tax');
				$data['tv_lang_new_label'] 					= $this->language->get('tv_lang_new_label');
				$data['tv_lang_sale_label'] 				= $this->language->get('tv_lang_sale_label');
				$data['lang_id'] 							= $this->config->get('config_language_id');
				$status		 								= $this->status();
				$data['status_special_main_form'] 			= $status['special_prod']['main_form'];
				$data['status_special_home_title'] 			= $status['special_prod']['home_title'];
				$data['status_special_home_sub_title'] 		= $status['special_prod']['home_sub_title'];
				$data['status_special_home_description'] 	= $status['special_prod']['home_description'];
				$data['status_special_home_image'] 			= $status['special_prod']['home_image'];
				$data['lang_id'] 							= $this->config->get('config_language_id');
				$data['comparedisplay']   					= $this->config->get('tvcmscustomsetting_configuration')['comparedisplay'];
				$data['wishlistdisplay']   					= $this->config->get('tvcmscustomsetting_configuration')['wishlistdisplay'];
				if(!empty($data['status_special_main_form'])){
					$name		 	= "tvcmstabproducts";
					$status_info 	= $this->model_catalog_tvcmsmodule->getmoduelstatus($name);
					$data_info   	= json_decode($status_info['setting'],1);
					
					if(!empty($data['status_special_home_title'])){
						$data['special_hometitle'] = $data_info['tvcmstabproducts_pro_spe']['lang_text'][$data['lang_id']]['hometitle'];
					}
					if(!empty($data['status_special_home_sub_title'])){
						$data['special_homesubtitle'] = $data_info['tvcmstabproducts_pro_spe']['lang_text'][$data['lang_id']]['homesubtitle'];
					}
					if(!empty($data['status_special_home_description'])){
						$data['special_homedes'] = $data_info['tvcmstabproducts_pro_spe']['lang_text'][$data['lang_id']]['homedes'];
					}
					$data['bannerstatus'] = $data_info['tvcmstabproducts_pro_spe']['bannerstatus'];
					if(!empty($data['status_special_home_image'])){
						$data['special_img'] = $this->model_tool_image->resize($data_info['tvcmstabproducts_pro_spe']['lang_text'][$data['lang_id']]['img'], $this->config->get('tvcmscustomsetting_specialproduct_mainimg_width'), $this->config->get('tvcmscustomsetting_specialproduct_mainimg_height'));
						
					}	
				}
				if (!$data_info['tvcmstabproducts_pro_spe']['no_pro']) {
					$data_info['tvcmstabproducts_pro_spe']['no_pro'] = 4;
				}
				$img = $this->model_tool_image->resize('placeholder.png', $this->config->get('tvcmscustomsetting_special_img_width'), $this->config->get('tvcmscustomsetting_special_img_height'));

				$special_product_info 	= $this->model_catalog_product->getProductSpecials($data_info['tvcmstabproducts_pro_spe']['no_pro']);
				foreach ($special_product_info as $value) {
					if ($value['image']) {
						$image = $this->model_tool_image->resize($value['image'], $this->config->get('tvcmscustomsetting_special_img_width'), $this->config->get('tvcmscustomsetting_special_img_height'));
						$image1 = $this->model_tool_image->resize($value['image'], $this->config->get('tvcmscustomsetting_special_img_width'), $this->config->get('tvcmscustomsetting_special_img_height'));
					} else {
						$image = $img;
						$image1 = $this->model_tool_image->resize('placeholder.png', $this->config->get('tvcmscustomsetting_special_img_width'), $this->config->get('tvcmscustomsetting_special_img_height'));
					}

					if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
						$price = $this->currency->format($this->tax->calculate($value['price'], $value['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					} else {
						$price = false;
					}

					if ((float)$value['special']) {
						$special = $this->currency->format($this->tax->calculate($value['special'], $value['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					} else {
						$special = false;
					}

					if ($this->config->get('config_tax')) {
						$tax = $this->currency->format((float)$value['special'] ? $value['special'] : $value['price'], $this->session->data['currency']);
					} else {
						$tax = false;
					}

					if ($this->config->get('config_review_status')) {
						$rating = $value['rating'];
					} else {
						$rating = false;
					}

					$date = $this->model_catalog_product->getcustomProductSpecials($value['product_id']);
					if(isset($date['date_start'])){
						$sdate = $date['date_start'];
					}else{
						$sdate = "";
					}

					if(isset($date['date_end'])){
						$edate = $date['date_end'];
					}else{
						$edate = "";
					}
					$categoryid 	= $this->model_catalog_product->getcategoryid($value['product_id']);
					$category_name 	= $this->model_catalog_product->getcategoryname($categoryid);

					$gethoverimage 	= $this->model_catalog_product->getproductimage($value['product_id']);
					if(!empty(current($gethoverimage))){
						$hoverimage = $this->model_tool_image->resize(current($gethoverimage)['image'],  $this->config->get('tvcmscustomsetting_special_img_width'), $this->config->get('tvcmscustomsetting_special_img_height'));
					}else{
						$hoverimage = $image;
					}
	     			$data['special_products'][] = array(
						'product_id'  	=> $value['product_id'],
						'thumb'      	=> $image,
						'thumb1'     	=> $image1,
						'hoverimage'    => $hoverimage,
						'categoryname'  => $category_name,
						'name'        	=> $value['name'],
						'start_date'  	=> $sdate,
						'date_end'    	=> $edate,
						'description' 	=> utf8_substr(strip_tags(html_entity_decode($value['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('theme_' . $this->config->get('config_theme') . '_product_description_length')) . '..',
						'price'       	=> $price,
						'special'     	=> $special,
						'tax'         	=> $tax,
						'rating'      	=> $rating,
						'href'        	=> $this->url->link('product/product', 'product_id=' . $value['product_id'])
					);
				}
				return $this->load->view('extension/module/tvcmsspecialproduct', $data);
			}
		}
	}
	protected function status(){
		return $this->Tvcmsthemevoltystatus->tabproductstatus();
	}
}