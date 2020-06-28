<?php
class ControllerExtensionModuletvcmscategoryproduct extends Controller {
	public function index($setting) {
		if($this->config->get('theme_default_directory') == "opc_electronic_electron_2501"){
			if(!empty($setting['status'])){
				$this->load->model('catalog/tvcmsmodule');
				$this->load->model('tool/image');
				$lang_id 								= $this->config->get('config_language_id');
				$status		 							= $this->status();
				$status 								= $this->status();
		    	$data['status_main_form']				= $status['main_form'];
		    	$data['status_main_title']				= $status['main_title'];
		    	$data['status_main_sub_title']			= $status['main_sub_title'];
		    	$data['status_main_description']		= $status['main_description'];
		    	$data['status_main_image']				= $status['main_image'];
		    	$data['status_record_form']				= $status['record_form'];
		    	$data['status_category_title']			= $status['category_title'];
		    	$data['status_image']					= $status['image'];
		    	$data['status_title']					= $status['title'];
	    	

	    		if(!empty($data['status_main_form'])){
		    		if(!empty($data['status_main_title'])){
		    			$data['maintitle'] = $setting['tvcmscategoryproduct_main'][$lang_id]['maintitle'];
		    		}
		    		if(!empty($data['status_main_sub_title'])){
		    			$data['main_subtitle'] = $setting['tvcmscategoryproduct_main'][$lang_id]['main_subtitle'];
		    		}
		    		if(!empty($data['status_main_description'])){
		    			$data['main_des'] = $setting['tvcmscategoryproduct_main'][$lang_id]['main_des'];
		    		}
		    		if(!empty($data['status_main_image'])){
		    			$data['main_img'] = $this->model_tool_image->resize($setting['tvcmscategoryproduct_main'][$lang_id]['main_img'], $this->config->get('tvcmscustomsetting_categoryslider_mainimg_width'), $this->config->get('tvcmscustomsetting_categoryslider_mainimg_height'));
		    		}
				}

				if($data['status_record_form']){
					$categorysliderlist_info = $this->model_catalog_tvcmsmodule->gettvcategoryproductsliderlist();
					$data['categoryproduct_data'] = array();
					foreach ($categorysliderlist_info as $key => $value) {
						if(!empty($value['tvcmscategoryproduct_status'])){
							$data['categoryproduct_data'][] = array(
								'title'			=> $value['tvcmscategoryproduct_title'],
								'id_category' 	=> $value['tvcmscategoryproduct_categoryselect'],
								'num_of_prod' 	=> $value['tvcmscategoryproduct_numberofproduct'],
							    'image' 		=> $this->model_tool_image->resize($value['tvcmscategoryproduct_img'], $this->config->get('tvcmscustomsetting_categoryslider_img_width'), $this->config->get('tvcmscustomsetting_categoryslider_img_height'))
							);
						}
					}
				}

				return $this->load->view('extension/module/tvcmscategoryproduct', $data);
			}
		}
	}
	protected function status(){
		return $this->Tvcmsthemevoltystatus->categoryproduct();
	}
	public function autocomplete() {
		$this->load->language('extension/module/tvcmscustomtext');
        if (isset($this->request->post['category_id'])) {
        	$this->load->model('catalog/category');
        	$this->load->model('catalog/product');
        	$this->load->model('tool/image');
            $category_id = $this->request->post['category_id'];
			$category_info = $this->model_catalog_category->getCategory($category_id);
			if ($category_info) {


				$data['products'] = array();
				$limit = $this->request->post['num_of_prod'];
				$filter_data = array(
				'filter_category_id' => $category_id,
				'filter_filter'      => "",
				'sort'               => "p.sort_order",
				'order'              => "ASC",
				'start'              => "0",
				'limit'              => $limit
			);


				$product_total = $this->model_catalog_product->getTotalProducts($filter_data);
				$results = $this->model_catalog_product->getProducts($filter_data);
				if(!empty($product_total)){
					foreach ($results as $result) {
						if ($result['image']) {
							$image = $this->model_tool_image->resize($result['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
						} else {
							$image = $this->model_tool_image->resize('placeholder.png', $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
						}


	                    $data['comparedisplay']   = $this->config->get('tvcmscustomsetting_configuration')['comparedisplay'];
	                    $data['wishlistdisplay']   = $this->config->get('tvcmscustomsetting_configuration')['wishlistdisplay'];
	                    $date = $this->model_catalog_product->getcustomProductSpecials($result['product_id']);
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
	                    if ($result['image']) {
	                        $gridimage = $this->model_tool_image->resize($result['image'], $this->config->get('tvcmscustomsetting_tvcmsproductgridimg_img_width'), $this->config->get('tvcmscustomsetting_tvcmsproductgridimg_img_height'));
	                    } else {
	                        $gridimage = $this->model_tool_image->resize('placeholder.png', $this->config->get('tvcmscustomsetting_tvcmsproductgridimg_img_width'), $this->config->get('tvcmscustomsetting_tvcmsproductgridimg_img_height'));
	                    }

	                    $gethoverimage   = $this->model_catalog_product->getproductimage($result['product_id']);

	                    if(!empty(current($gethoverimage))){
	                        $hoverimage = $this->model_tool_image->resize(current($gethoverimage)['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
	                        $gridhoverimage = $this->model_tool_image->resize(current($gethoverimage)['image'], $this->config->get('tvcmscustomsetting_tvcmsproductgridimg_img_width'), $this->config->get('tvcmscustomsetting_tvcmsproductgridimg_img_height'));

	                    }else{
	                        $hoverimage = $image;
	                        $gridhoverimage = $gridimage;
	                    }
		                
						if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
							$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
						} else {
							$price = false;
						}

						if ((float)$result['special']) {
							$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
						} else {
							$special = false;
						}

						if ($this->config->get('config_tax')) {
							$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
						} else {
							$tax = false;
						}

						if ($this->config->get('config_review_status')) {
							$rating = (int)$result['rating'];
						} else {
							$rating = false;
						}

						$data['products'][] = array(
							'product_id'  		=> $result['product_id'],
		                	'start_date' 		=> $sdate,
		                	'date_end'   		=> $edate,
		                	'hoverimage' 		=> $hoverimage,
		                	'gridimage' 		=> $gridimage,
		                	'gridhoverimage' 	=> $gridhoverimage,
							'thumb'       		=> $image,
							'name'        		=> $result['name'],
							'description' 		=> utf8_substr(trim(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'))), 0, $this->config->get('theme_' . $this->config->get('config_theme') . '_product_description_length')) . '..',
							'price'       		=> $price,
							'special'     		=> $special,
							'tax'         		=> $tax,
							'minimum'     		=> $result['minimum'] > 0 ? $result['minimum'] : 1,
							'rating'      		=> $result['rating'],
							'href'        		=> $this->url->link('product/product', '&product_id=' . $result['product_id'])
						);
					}
				}else{
					$data['empty'] = "No Data Found";
				}

				return $this->response->setOutput($this->load->view('product/tvcmcategoryproduct', $data));
			}
        }
    }

}