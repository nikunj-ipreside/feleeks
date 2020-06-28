<?php

class ControllerExtensionModuletvcmsfooterproduct extends Controller {
	public function index($setting) {
		if($this->config->get('theme_default_directory') == "opc_electronic_electron_2501"){
			if($setting['status']){

				$this->load->language('extension/module/tvcmscustomtext');
				
				$this->load->model('catalog/product');

				$this->load->model('tool/image');
				
				$data['text_tax'] 			= $this->language->get('text_tax');
				$data['tv_lang_new_label'] 	= $this->language->get('tv_lang_new_label');
				$data['tv_lang_sale_label'] = $this->language->get('tv_lang_sale_label');
				$data['lang_id'] 			= $this->config->get('config_language_id');

				$module_data  				= $this->model_catalog_product->getmoduledetail('tvcmstabproducts');
				$setting_data 				= json_decode($module_data['setting'],1);
				$limit 						= 50;
				$data['setting'] 			= $setting_data;

				$data['title_newproduct'] 		= $setting['footerproducttitle'][$data['lang_id']]['new'];
				$data['title_featureproduct'] 	= $setting['footerproducttitle'][$data['lang_id']]['fea'];
				$data['title_bestproduct'] 		= $setting['footerproducttitle'][$data['lang_id']]['bes'];

				if (!$setting_data['tvcmstabproducts_pro_fea']['no_pro']) {
					$setting_data['tvcmstabproducts_pro_fea']['no_pro'] = 4;
				}
				if (!$setting_data['tvcmstabproducts_pro_new']['no_pro']) {
					$setting_data['tvcmstabproducts_pro_new']['no_pro'] = 4;
				}
				if (!$setting_data['tvcmstabproducts_pro_best']['no_pro']) {
					$setting_data['tvcmstabproducts_pro_best']['no_pro'] = 4;
				}
				
				$img = $this->model_tool_image->resize('placeholder.png', $this->config->get('tvcmscustomsetting_footerproduct_width'), $this->config->get('tvcmscustomsetting_footerproduct_height'));

				$category_ids 			= array_slice($setting_data['tvcmstabproducts_pro_fea']['cate_pro'], 0, (int)$setting_data['tvcmstabproducts_pro_fea']['no_pro']);

				$all_id 				= implode(",", $category_ids);
				$cateall_id 			= $this->model_catalog_product->getcateid($all_id);
				$all_id 				= array();

				foreach ($cateall_id as $cate_id) {
					$all_id[] 			=  $cate_id['category_id'];
				}
				
				$allcategoryid 			=  array_merge($category_ids,$all_id);
					$get 					= implode(",", $allcategoryid);

				$feature_product_info 	= $this->model_catalog_product->getProductid($get);
				$new_product_info 		= $this->model_catalog_product->getLatestProducts($limit);
				$best_product_info 		= $this->model_catalog_product->getBestSellerProducts($limit);
				
				foreach ($feature_product_info as $key => $id) {
					if($key < $limit){
						$product_id = $id['product_id'];
						$product_info = $this->model_catalog_product->getProduct($product_id);

						if ($product_info) {
							if ($product_info['image']) {

								$image = $this->model_tool_image->resize($product_info['image'], $this->config->get('tvcmscustomsetting_footerproduct_width'), $this->config->get('tvcmscustomsetting_footerproduct_height'));
								$smallimage = $this->model_tool_image->resize($product_info['image'], $this->config->get('tvcmscustomsetting_footerproduct_width'), $this->config->get('tvcmscustomsetting_footerproduct_height'));
							} else {
								$image = $img;
								$smallimage = $this->model_tool_image->resize('placeholder.png', $this->config->get('tvcmscustomsetting_footerproduct_width'), $this->config->get('tvcmscustomsetting_footerproduct_height'));
							}

							if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
								$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
							} else {
								$price = false;
							}

							if ((float)$product_info['special']) {
								$special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
							} else {
								$special = false;
							}

							if ($this->config->get('config_tax')) {
								$tax = $this->currency->format((float)$product_info['special'] ? $product_info['special'] : $product_info['price'], $this->session->data['currency']);
							} else {
								$tax = false;
							}

							if ($this->config->get('config_review_status')) {
								$rating = $product_info['rating'];
							} else {
								$rating = false;
							}

							$date = $this->model_catalog_product->getcustomProductSpecials($product_id);
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


							$categoryid 	= $this->model_catalog_product->getcategoryid($product_info['product_id']);
							$category_name 	= $this->model_catalog_product->getcategoryname($categoryid);

							$gethoverimage 	= $this->model_catalog_product->getproductimage($product_info['product_id']);
							if(!empty(current($gethoverimage))){
								$hoverimage = $this->model_tool_image->resize(current($gethoverimage)['image'], $this->config->get('tvcmscustomsetting_footerproduct_width'), $this->config->get('tvcmscustomsetting_footerproduct_height'));
							}else{
								$hoverimage = $image;
							}

							$data['feature_tab_products'][] = array(
								'product_id'  	=> $product_info['product_id'],
								'smallimage'  	=> $smallimage,
								'hoverimage'  	=> $hoverimage,
								'categoryname'  => $category_name,
								'start_date'  	=> $sdate,
							    'date_end'    	=> $edate,
								'name'        	=> $product_info['name'],
								'description' 	=> utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('theme_' . $this->config->get('config_theme') . '_product_description_length')) . '..',
								'price'       	=> $price,
								'special'     	=> $special,
								'tax'         	=> $tax,
								'rating'      	=> $rating,
								'href'        	=> $this->url->link('product/product', 'product_id=' . $product_info['product_id'])
							);
						}
					}
				}
				foreach ($new_product_info as $value) {
					if ($value['image']) {
						$image 		= $this->model_tool_image->resize($value['image'], $this->config->get('tvcmscustomsetting_footerproduct_width'), $this->config->get('tvcmscustomsetting_footerproduct_height'));
						$smallimage = $this->model_tool_image->resize($value['image'], $this->config->get('tvcmscustomsetting_footerproduct_width'), $this->config->get('tvcmscustomsetting_footerproduct_height'));
					} else {
						$image 		= $img;
						$smallimage = $this->model_tool_image->resize('placeholder.png', $this->config->get('tvcmscustomsetting_footerproduct_width'), $this->config->get('tvcmscustomsetting_footerproduct_height'));
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
						$hoverimage = $this->model_tool_image->resize(current($gethoverimage)['image'], $this->config->get('tvcmscustomsetting_footerproduct_width'), $this->config->get('tvcmscustomsetting_footerproduct_height'));
					}else{
						$hoverimage = $image;
					}
					$data['new_products'][] = array(
						'product_id'  	=> $value['product_id'],
						'categoryname'  => $category_name,
						'smallimage' 	=> $smallimage,
						'hoverimage'    => $hoverimage,
						'name'       	=> $value['name'],
						'start_date' 	=> $sdate,
						'date_end'   	=> $edate,
						'description'	=> utf8_substr(strip_tags(html_entity_decode($value['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('theme_' . $this->config->get('config_theme') . '_product_description_length')) . '..',
						'price'       	=> $price,
						'special'     	=> $special,
						'tax'         	=> $tax,
						'rating'      	=> $rating,
						'href'        	=> $this->url->link('product/product', 'product_id=' . $value['product_id'])
					);
				}
				foreach ($best_product_info as $value) {
					
					if ($value['image']) {
						$image 		= $this->model_tool_image->resize($value['image'], $this->config->get('tvcmscustomsetting_footerproduct_width'), $this->config->get('tvcmscustomsetting_footerproduct_height'));
						$smallimage = $this->model_tool_image->resize($value['image'], $this->config->get('tvcmscustomsetting_footerproduct_width'), $this->config->get('tvcmscustomsetting_footerproduct_height'));
					} else {
						$image 		= $img;
						$smallimage = $img;
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
						$hoverimage = $this->model_tool_image->resize(current($gethoverimage)['image'], $this->config->get('tvcmscustomsetting_footerproduct_width'), $this->config->get('tvcmscustomsetting_footerproduct_height'));
					}else{
						$hoverimage = $image;
					}

					$data['best_products'][] = array(
						'product_id'  	=> $value['product_id'],
						'smallimage'  	=> $smallimage,
						'hoverimage'  	=> $hoverimage,
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
				
				return $this->load->view('extension/module/tvcmsfooterproduct', $data);
			}
		}
	}
}