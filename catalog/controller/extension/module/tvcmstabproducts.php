<?php

class ControllerExtensionModuleTvcmstabproducts extends Controller {
	public function index($setting) {
		if($this->config->get('theme_default_directory') == "opc_electronic_electron_2501"){
			$data['lang_id'] = $this->config->get('config_language_id');
			$status		 									= $this->status();
			$data['status_cust_main_form'] 					= $status['cust_prod']['main_form'];
			$data['status_cust_main_title'] 				= $status['cust_prod']['main_title'];
			$data['status_cust_main_sub_title'] 			= $status['cust_prod']['main_sub_title'];
			$data['status_cust_main_description'] 			= $status['cust_prod']['main_description'];
			$data['status_cust_main_image'] 				= $status['cust_prod']['main_image'];
			$data['status_cust_main_image_status'] 			= $status['cust_prod']['main_image_status'];

			$data['status_featured_main_form'] 				= $status['featured_prod']['main_form'];
			$data['status_featured_tab_title'] 				= $status['featured_prod']['tab_title'];
			$data['status_featured_home_image_status'] 		= $status['featured_prod']['home_image_status'];
			$data['status_featured_num_of_prod'] 			= $status['featured_prod']['num_of_prod'];
			$data['status_featured_prod_cat'] 				= $status['featured_prod']['prod_cat'];
			$data['status_featured_random_prod'] 			= $status['featured_prod']['random_prod'];
			$data['status_featured_display_in_tab'] 		= $status['featured_prod']['display_in_tab'];
			$data['status_featured_home_title'] 			= $status['featured_prod']['home_title'];
			$data['status_featured_home_sub_title'] 		= $status['featured_prod']['home_sub_title'];
			$data['status_featured_home_description'] 		= $status['featured_prod']['home_description'];
			$data['status_featured_home_image'] 			= $status['featured_prod']['home_image'];

			$data['status_new_main_form'] 					= $status['new_prod']['main_form'];
			$data['status_new_tab_title'] 					= $status['new_prod']['tab_title'];
			$data['status_new_home_image_status'] 			= $status['new_prod']['home_image_status'];
			$data['status_new_num_of_prod'] 				= $status['new_prod']['num_of_prod'];
			$data['status_new_num_of_days'] 				= $status['new_prod']['num_of_days'];
			$data['status_new_display_in_tab'] 				= $status['new_prod']['display_in_tab'];
			$data['status_new_home_title'] 					= $status['new_prod']['home_title'];
			$data['status_new_home_sub_title'] 				= $status['new_prod']['home_sub_title'];
			$data['status_new_home_description'] 			= $status['new_prod']['home_description'];
			$data['status_new_home_image'] 					= $status['new_prod']['home_image'];

			$data['status_best_main_form'] 					= $status['best_seller_prod']['main_form'];
			$data['status_best_tab_title'] 					= $status['best_seller_prod']['tab_title'];
			$data['status_best_home_image_status'] 			= $status['best_seller_prod']['home_image_status'];
			$data['status_best_num_of_prod'] 				= $status['best_seller_prod']['num_of_prod'];
			$data['status_best_display_in_tab'] 			= $status['best_seller_prod']['display_in_tab'];
			$data['status_best_home_title'] 				= $status['best_seller_prod']['home_title'];
			$data['status_best_home_sub_title'] 			= $status['best_seller_prod']['home_sub_title'];
			$data['status_best_home_description'] 			= $status['best_seller_prod']['home_description'];
			$data['status_best_home_image'] 				= $status['best_seller_prod']['home_image'];

			$data['status_special_main_form'] 				= $status['special_prod']['main_form'];
			$data['status_special_tab_title'] 				= $status['special_prod']['tab_title'];
			$data['status_special_home_title'] 				= $status['special_prod']['home_title'];
			$data['status_special_home_image_status'] 		= $status['special_prod']['home_image_status'];
			$data['status_special_num_of_prod'] 			= $status['special_prod']['num_of_prod'];
			$data['status_special_display_in_tab'] 			= $status['special_prod']['display_in_tab'];
			$data['status_special_home_sub_title'] 			= $status['special_prod']['home_sub_title'];
			$data['status_special_home_description'] 		= $status['special_prod']['home_description'];
			$data['special_home_image'] 					= $status['special_prod']['home_image'];
			$data['doublerow']				        		= $this->config->get('tvcmscustomsetting_configuration')['doublerow'];
			$data['comparedisplay']   						= $this->config->get('tvcmscustomsetting_configuration')['comparedisplay'];
			$data['wishlistdisplay']   						= $this->config->get('tvcmscustomsetting_configuration')['wishlistdisplay'];

			if(!empty($data['status_cust_main_form'])){
				if(!empty($data['status_cust_main_title'])){
					$data['cust_pro_info_maintitle'] 	= $setting['tvcmstabproducts_pro_cus']['lang_text'][$data['lang_id']]['maintitle'];
				}
				if(!empty($data['status_cust_main_sub_title'])){
					$data['cust_pro_info_subtitle'] 	= $setting['tvcmstabproducts_pro_cus']['lang_text'][$data['lang_id']]['subtitle'];
				}
				if(!empty($data['status_cust_main_description'])){
					$data['cust_pro_info_description'] 	= $setting['tvcmstabproducts_pro_cus']['lang_text'][$data['lang_id']]['des'];
				}
				if(!empty($data['status_cust_main_image'])){
					$data['cust_pro_info_img'] 			= $setting['tvcmstabproducts_pro_cus']['lang_text'][$data['lang_id']]['img'];
				}
				$data['cust_pro_info_status'] 			= $setting['tvcmstabproducts_pro_cus']['status'];
				$data['cust_pro_info_bannerside'] 		= $setting['tvcmstabproducts_pro_cus']['bannerside'];
				$data['cust_pro_info_bannerstatus'] 	= $setting['tvcmstabproducts_pro_cus']['bannerstatus'];
			}
			if(!empty($data['status_featured_main_form'])){
				$data['featured_tab_status'] = $setting['tvcmstabproducts_pro_fea']['status'];

				if(!empty($data['status_featured_tab_title'])){
					$data['featured_tab_title'] = $setting['tvcmstabproducts_pro_fea']['lang_text'][$data['lang_id']]['tabtitle'];
				}
				if(!empty($data['status_featured_num_of_prod'])){
					$data['featured_num_of_prod'] = $setting['tvcmstabproducts_pro_fea']['no_pro'];
				}
				if(!empty($data['status_featured_prod_cat'])){
					$data['featured_prod_cat'] = $setting['tvcmstabproducts_pro_fea']['cate_pro'];
				}
				if(!empty($data['status_featured_random_prod'])){
					$data['featured_random_prod'] = $setting['tvcmstabproducts_pro_fea']['dis_rand'];
				}
				if(!empty($data['status_featured_display_in_tab'])){
					$data['featured_display_in_tab'] = $setting['tvcmstabproducts_pro_fea']['dis_tap'];
				}
				if(!empty($data['status_featured_home_title'])){
					$data['featured_home_title'] = $setting['tvcmstabproducts_pro_fea']['lang_text'][$data['lang_id']]['hometitle'];
				}
				if(!empty($data['status_featured_home_sub_title'])){
					$data['featured_home_sub_title'] = $setting['tvcmstabproducts_pro_fea']['lang_text'][$data['lang_id']]['homesubtitle'];
				}
				if(!empty($data['status_featured_home_description'])){
					$data['featured_home_description'] = $setting['tvcmstabproducts_pro_fea']['lang_text'][$data['lang_id']]['homedes'];
				}
				if(!empty($data['status_featured_home_image'])){
					$data['featured_home_image'] = $setting['tvcmstabproducts_pro_fea']['lang_text'][$data['lang_id']]['img'];
				}
				$data['featured_bannerside'] 	= $setting['tvcmstabproducts_pro_fea']['bannerside'];
				$data['featured_bannerstatus'] 	= $setting['tvcmstabproducts_pro_fea']['bannerstatus'];
			}		
			if(!empty($data['status_new_main_form'])){
				$data['new_tab_status'] = $setting['tvcmstabproducts_pro_new']['status'];

				if(!empty($data['status_new_tab_title'])){
					$data['new_tabtitle'] = $setting['tvcmstabproducts_pro_new']['lang_text'][$data['lang_id']]['tabtitle'];
				}
				if(!empty($data['status_new_num_of_prod'])){
					$data['new_no_pro'] = $setting['tvcmstabproducts_pro_new']['no_pro'];
				}
				if(!empty($data['status_new_num_of_days'])){
					$data['new_cate_pro'] = $setting['tvcmstabproducts_pro_new']['cate_pro'];
				}
				if(!empty($data['status_new_display_in_tab'])){
					$data['new_dis_tap'] = $setting['tvcmstabproducts_pro_new']['dis_tap'];
				}
				if(!empty($data['status_new_home_title'])){
					$data['new_hometitle'] = $setting['tvcmstabproducts_pro_new']['lang_text'][$data['lang_id']]['hometitle'];
				}
				if(!empty($data['status_new_home_sub_title'])){
					$data['new_homesubtitle'] = $setting['tvcmstabproducts_pro_new']['lang_text'][$data['lang_id']]['homesubtitle'];
				}
				if(!empty($data['status_new_home_description'])){
					$data['new_homedes'] = $setting['tvcmstabproducts_pro_new']['lang_text'][$data['lang_id']]['homedes'];
				}
				if(!empty($data['status_new_home_image'])){
					$data['new_img'] = $setting['tvcmstabproducts_pro_new']['lang_text'][$data['lang_id']]['img'];
				}
				$data['new_bannerside'] 	= $setting['tvcmstabproducts_pro_new']['bannerside'];
				$data['new_bannerstatus'] 	= $setting['tvcmstabproducts_pro_new']['bannerstatus'];
			}
			if(!empty($data['status_best_main_form'])){
				$data['best_tab_status'] = $setting['tvcmstabproducts_pro_best']['status'];

				if(!empty($data['status_best_tab_title'])){
					$data['best_tabtitle'] = $setting['tvcmstabproducts_pro_best']['lang_text'][$data['lang_id']]['tabtitle'];
				}
				if(!empty($data['status_best_num_of_prod'])){
					$data['best_no_pro'] = $setting['tvcmstabproducts_pro_best']['no_pro'];
				}
				if(!empty($data['status_best_display_in_tab'])){
					$data['best_dis_tap'] = $setting['tvcmstabproducts_pro_best']['dis_tap'];
				}
				if(!empty($data['status_best_home_title'])){
					$data['best_hometitle'] = $setting['tvcmstabproducts_pro_best']['lang_text'][$data['lang_id']]['hometitle'];
				}
				if(!empty($data['status_best_home_sub_title'])){
					$data['best_homesubtitle'] = $setting['tvcmstabproducts_pro_best']['lang_text'][$data['lang_id']]['homesubtitle'];
				}
				if(!empty($data['status_best_home_description'])){
					$data['best_homedes'] = $setting['tvcmstabproducts_pro_best']['lang_text'][$data['lang_id']]['homedes'];
				}
				if(!empty($data['status_best_home_image'])){
					$data['best_img'] = $setting['tvcmstabproducts_pro_best']['lang_text'][$data['lang_id']]['img'];
				}
				$data['best_bannerside'] 	= $setting['tvcmstabproducts_pro_best']['bannerside'];
				$data['best_bannerstatus'] 	= $setting['tvcmstabproducts_pro_best']['bannerstatus'];
			}
			if(!empty($data['status_special_main_form'])){
				$data['special_tab_status'] = $setting['tvcmstabproducts_pro_spe']['status'];

				if(!empty($data['status_special_tab_title'])){
					$data['special_tabtitle'] = $setting['tvcmstabproducts_pro_spe']['lang_text'][$data['lang_id']]['tabtitle'];
				}
				if(!empty($data['status_special_home_title'])){
					$data['special_hometitle'] = $setting['tvcmstabproducts_pro_spe']['lang_text'][$data['lang_id']]['hometitle'];
				}
				
				if(!empty($data['status_special_num_of_prod'])){
					$data['special_no_pro'] = $setting['tvcmstabproducts_pro_spe']['no_pro'];
				}
				if(!empty($data['status_special_display_in_tab'])){
					$data['special_dis_tap'] = $setting['tvcmstabproducts_pro_spe']['dis_tap'];
				}
				if(!empty($data['status_special_home_sub_title'])){
					$data['special_homesubtitle'] = $setting['tvcmstabproducts_pro_spe']['lang_text'][$data['lang_id']]['homesubtitle'];
				}
				if(!empty($data['status_special_home_description'])){
					$data['special_homedes'] = $setting['tvcmstabproducts_pro_spe']['lang_text'][$data['lang_id']]['homedes'];
				}
				$data['special_bannerside'] 	= $setting['tvcmstabproducts_pro_spe']['bannerside'];
				$data['special_bannerstatus'] 	= $setting['tvcmstabproducts_pro_spe']['bannerstatus'];
			}
			if($setting['status']){
				$this->load->language('extension/module/tvcmscustomtext');
				$this->load->model('catalog/product');
				$this->load->model('tool/image');
				
				$data['text_tax'] 			= $this->language->get('text_tax');
				$data['tv_lang_new_label'] 	= $this->language->get('tv_lang_new_label');
				$data['tv_lang_sale_label'] = $this->language->get('tv_lang_sale_label');
				$data['setting']			= $setting;

				if (!$data['featured_num_of_prod']) {
					$data['featured_num_of_prod'] = 4;
				}
				if (!$data['new_no_pro']) {
					$data['new_no_pro'] = 4;
				}
				if (!$data['best_no_pro']) {
					$data['best_no_pro'] = 4;
				}
				if (!$data['special_no_pro']) {
					$data['special_no_pro'] = 4;
				}
				$img = $this->model_tool_image->resize('placeholder.png', $this->config->get('tvcmscustomsetting_tabproduct_img_width'), $this->config->get('tvcmscustomsetting_tabproduct_img_height'));
				if(!empty($data['status_featured_main_form'])){
					if(!empty($data['featured_display_in_tab'])){
						$category_ids 			= array_slice($data['featured_prod_cat'], 0, (int)$data['featured_num_of_prod']);
						$all_id 				= implode(",", $category_ids);
						$cateall_id 			= $this->model_catalog_product->getcateid($all_id);
						$all_id 				= array();
						foreach ($cateall_id as $cate_id) {
							$all_id[] 			=  $cate_id['category_id'];
						}
						$allcategoryid 			=  array_merge($category_ids,$all_id);
						$get 					= implode(",", $allcategoryid);

						$feature_product_info 	= $this->model_catalog_product->getProductid($get);
						foreach ($feature_product_info as $key => $id) {

							$product_id 		= $id['product_id'];
							$product_info 		= $this->model_catalog_product->getProduct($product_id);

							if ($product_info) {
								if ($product_info['image']) {

									$image = $this->model_tool_image->resize($product_info['image'] ,$this->config->get('tvcmscustomsetting_tabproduct_img_width'), $this->config->get('tvcmscustomsetting_tabproduct_img_height'));
								} else {
									$image = $img;
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
									$hoverimage = $this->model_tool_image->resize(current($gethoverimage)['image'], $this->config->get('tvcmscustomsetting_tabproduct_img_width'), $this->config->get('tvcmscustomsetting_tabproduct_img_height'));
								}else{
									$hoverimage = $image;
								}

								$data['feature_tab_products'][] = array(
									'product_id'  	=> $product_info['product_id'],
									'thumb'       	=> $image,
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
				}
				if(!empty($data['status_special_main_form'])){
					if(!empty($data['special_dis_tap'])){
						$special_product_info 	= $this->model_catalog_product->getProductSpecials($data['special_no_pro']);
						foreach ($special_product_info as $value) {
							if ($value['image']) {
								$image = $this->model_tool_image->resize($value['image'], $this->config->get('tvcmscustomsetting_tabproduct_img_width'), $this->config->get('tvcmscustomsetting_tabproduct_img_height'));
							} else {
								$image = $img;
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
								$hoverimage = $this->model_tool_image->resize(current($gethoverimage)['image'], $this->config->get('tvcmscustomsetting_tabproduct_img_width'), $this->config->get('tvcmscustomsetting_tabproduct_img_height'));
							}else{
								$hoverimage = $image;
							}
			     			$data['special_products'][] = array(
								'product_id'  	=> $value['product_id'],
								'thumb'      	=> $image,
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
					}
				}
				if(!empty($data['status_new_main_form'])){
					if(!empty($data['new_dis_tap'])){
						$new_product_info 		= $this->model_catalog_product->getLatestProducts($data['new_no_pro']);
						foreach ($new_product_info as $value) {
							if ($value['image']) {
								$image 		= $this->model_tool_image->resize($value['image'], $this->config->get('tvcmscustomsetting_tabproduct_img_width'), $this->config->get('tvcmscustomsetting_tabproduct_img_height'));
							} else {
								$image 		= $img;
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
								$hoverimage = $this->model_tool_image->resize(current($gethoverimage)['image'], $this->config->get('tvcmscustomsetting_tabproduct_img_width'), $this->config->get('tvcmscustomsetting_tabproduct_img_height'));
							}else{
								$hoverimage = $image;
							}

							$data['new_products'][] = array(
								'product_id'  	=> $value['product_id'],
								'categoryname'  => $category_name,
								'thumb'      	=> $image,
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
					}
				}
				if(!empty($data['status_best_main_form'])){
					if(!empty($data['best_dis_tap'])){
						$best_product_info 		= $this->model_catalog_product->getBestSellerProducts($data['best_no_pro']);
						foreach ($best_product_info as $value) {
							
							if ($value['image']) {
								$image 		= $this->model_tool_image->resize($value['image'], $this->config->get('tvcmscustomsetting_tabproduct_img_width'), $this->config->get('tvcmscustomsetting_tabproduct_img_height'));
							} else {
								$image 		= $img;
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
								$hoverimage = $this->model_tool_image->resize(current($gethoverimage)['image'], $this->config->get('tvcmscustomsetting_tabproduct_img_width'), $this->config->get('tvcmscustomsetting_tabproduct_img_height'));
							}else{
								$hoverimage = $image;
							}

							$data['best_products'][] = array(
								'product_id'  	=> $value['product_id'],
								'thumb'       	=> $image,
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
					}
				}

				return $this->load->view('extension/module/tvcmstabproducts', $data);
			}
		}
	}
	protected function status(){
		return $this->Tvcmsthemevoltystatus->tabproductstatus();
	}
}