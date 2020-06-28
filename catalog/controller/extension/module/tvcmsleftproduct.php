<?php

class ControllerExtensionModuletvcmsleftproduct extends Controller {
	public function index($setting) {

		if($this->config->get('theme_default_directory') == "opc_electronic_electron_2501"){
			if($setting['status']){
		
				$this->load->language('extension/module/tvcmscustomtext');
				
				$this->load->model('catalog/product');

				$this->load->model('tool/image');
				
				$module_data  				= $this->model_catalog_product->getmoduledetail('tvcmstabproducts');
				$setting_data 				= json_decode($module_data['setting'],1);
				$limit 						= 3;
				$language_id 				= (int)$this->config->get('config_language_id');

				$img = $this->model_tool_image->resize('placeholder.png', $this->config->get('tvcmscustomsetting_leftproduct_img_width'), $this->config->get('tvcmscustomsetting_leftproduct_img_height'));
						
				$data['status_left_feature'] 	=  	$setting['status_left_feature'];
			    $data['left_feature_title'] 	=  	$setting['left_feature_title'];
			    $data['status_left_new'] 		=  	$setting['status_left_new'];
			    $data['left_new_title'] 		=  	$setting['left_new_title'];
			    $data['status_left_best'] 		=  	$setting['status_left_best'];
			    $data['left_best_title'] 		=  	$setting['left_best_title'];
			    $data['status_left_special'] 	=  	$setting['status_left_special'];
			    $data['left_special_title'] 	=  	$setting['left_special_title'];
			    $data['status_right_feature'] 	=  	$setting['status_right_feature'];
			    $data['right_feature_title'] 	=  	$setting['right_feature_title'];
			    $data['status_right_new'] 		=  	$setting['status_right_new'];
			    $data['right_new_title'] 		=  	$setting['right_new_title'];
			    $data['status_right_best'] 		=  	$setting['status_right_best'];
			    $data['right_best_title'] 		=  	$setting['right_best_title'];
			    $data['status_right_special'] 	=  	$setting['status_right_special'];
			    $data['right_special_title'] 	=  	$setting['right_special_title'];
				$limit 							= 	3;



				if(!empty($data['status_left_feature'])){


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

					$feature_i = 1;
	
					foreach ($feature_product_info as $key => $id) {
						if($feature_i <= $limit ){
							$product_id = $id['product_id'];
							$product_info = $this->model_catalog_product->getProduct($product_id);
							if ($product_info) {
								if ($product_info['image']) {

									$image = $this->model_tool_image->resize($product_info['image'], $this->config->get('tvcmscustomsetting_leftproduct_img_width'), $this->config->get('tvcmscustomsetting_leftproduct_img_height'));
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


								if ($this->config->get('config_review_status')) {
									$rating = $product_info['rating'];
								} else {
									$rating = false;
								}

								
								$gethoverimage 	= $this->model_catalog_product->getproductimage($product_info['product_id']);
								if(!empty(current($gethoverimage))){
									$hoverimage = $this->model_tool_image->resize(current($gethoverimage)['image'], $this->config->get('tvcmscustomsetting_leftproduct_img_width'), $this->config->get('tvcmscustomsetting_leftproduct_img_height'));
								}else{
									$hoverimage = $image;
								}

								$data['feature_tab_products'][] = array(
									'product_id'  	=> $product_info['product_id'],
									'thumb'      	=> $image,
									'hoverimage'    => $hoverimage,
									'name'        	=> $product_info['name'],
									'price'       	=> $price,
									'special'     	=> $special,
									'rating'      	=> $rating,
									'href'        	=> $this->url->link('product/product', 'product_id=' . $product_info['product_id'])
								);							
							}
						}
						$feature_i++;
					}
				}
				if(!empty($data['status_left_new'])){
				
					$new_product_info 	= $this->model_catalog_product->getLatestProducts($limit);
					$new_i = 1;
					foreach ($new_product_info as $value) {
						if($new_i <= $limit ){
							if ($value['image']) {
								$image 		= $this->model_tool_image->resize($value['image'], $this->config->get('tvcmscustomsetting_leftproduct_img_width'), $this->config->get('tvcmscustomsetting_leftproduct_img_height'));
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
							
							if ($this->config->get('config_review_status')) {
								$rating = $value['rating'];
							} else {
								$rating = false;
							}
							

							$gethoverimage 	= $this->model_catalog_product->getproductimage($value['product_id']);
							if(!empty(current($gethoverimage))){
								$hoverimage = $this->model_tool_image->resize(current($gethoverimage)['image'], $this->config->get('tvcmscustomsetting_leftproduct_img_width'), $this->config->get('tvcmscustomsetting_leftproduct_img_height'));
							}else{
								$hoverimage = $image;
							}

							$data['new_products'][] = array(
								'product_id'  	=> $value['product_id'],
								'thumb'      	=> $image,
								'hoverimage'    => $hoverimage,
								'name'        	=> $value['name'],
								'price'       	=> $price,
								'special'     	=> $special,
								'rating'      	=> $rating,
								'href'        	=> $this->url->link('product/product', 'product_id=' . $value['product_id'])
							);
						}
						$new_i++;
					}
				}
				if(!empty($data['status_left_best'])){
				
					$best_product_info 	= $this->model_catalog_product->getBestSellerProducts($limit);
					$best_i = 1;

					foreach ($best_product_info as $value) {
						if($best_i <= $limit ){
						
							if ($value['image']) {
								$image 		= $this->model_tool_image->resize($value['image'], $this->config->get('tvcmscustomsetting_leftproduct_img_width'), $this->config->get('tvcmscustomsetting_leftproduct_img_height'));
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

							if ($this->config->get('config_review_status')) {
								$rating = $value['rating'];
							} else {
								$rating = false;
							}

							$gethoverimage 	= $this->model_catalog_product->getproductimage($value['product_id']);
							if(!empty(current($gethoverimage))){
								$hoverimage = $this->model_tool_image->resize(current($gethoverimage)['image'], $this->config->get('tvcmscustomsetting_leftproduct_img_width'), $this->config->get('tvcmscustomsetting_leftproduct_img_height'));
							}else{
								$hoverimage = $image;
							}
							$data['best_products'][] = array(
								'product_id'  	=> $value['product_id'],
								'thumb'      	=> $image,
								'hoverimage'    => $hoverimage,
								'name'        	=> $value['name'],
								'price'       	=> $price,
								'special'     	=> $special,
								'rating'      	=> $rating,
								'href'        	=> $this->url->link('product/product', 'product_id=' . $value['product_id'])
							);
						}
						$best_i++;
					}
				}
				if(!empty($data['status_left_special'])){
				
					$special_product_info 	= $this->model_catalog_product->getProductSpecials($limit);
					$special_i = 1;
					foreach ($special_product_info as $value) {
						if($special_i <= $limit ){

							if ($value['image']) {
								$image = $this->model_tool_image->resize($value['image'], $this->config->get('tvcmscustomsetting_leftproduct_img_width'), $this->config->get('tvcmscustomsetting_leftproduct_img_height'));
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

							if ($this->config->get('config_review_status')) {
								$rating = $value['rating'];
							} else {
								$rating = false;
							}

							$gethoverimage 	= $this->model_catalog_product->getproductimage($value['product_id']);
							if(!empty(current($gethoverimage))){
								$hoverimage = $this->model_tool_image->resize(current($gethoverimage)['image'], $this->config->get('tvcmscustomsetting_leftproduct_img_width'), $this->config->get('tvcmscustomsetting_leftproduct_img_height'));
							}else{
								$hoverimage = $image;
							}

			     			$data['special_products'][] = array(
								'product_id'  	=> $value['product_id'],
								'thumb'      	=> $image,
								'hoverimage'    => $hoverimage,
								'name'        	=> $value['name'],
								'price'       	=> $price,
								'special'     	=> $special,
								'rating'      	=> $rating,
								'href'        	=> $this->url->link('product/product', 'product_id=' . $value['product_id'])
							);
						}
						$special_i++;
					}
				}

				return $this->load->view('extension/module/tvcmsleftproduct', $data);
			}
		}
	}
}