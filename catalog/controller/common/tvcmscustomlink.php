<?php

class ControllerCommonTvcmscustomlink extends Controller {
	public function index() {
		if($this->config->get('theme_default_directory') == "opc_electronic_electron_2501"){
			$data = array();
			$this->load->model('catalog/tvcmsmodule');
			$name		 							= "tvcmscustomlink";
			$status_info 							= $this->model_catalog_tvcmsmodule->getmoduelstatus($name);
			if(!empty($status_info)){
				$data_info   							= json_decode($status_info['setting'],1);
				$status 								= $this->status();
				$data['status_main_form'] 				= $status['main_form'];
				$data['status_main_title'] 				= $status['main_title'];
				$data['status_main_short_description'] 	= $status['main_short_description'];
				$data['status_record_form'] 			= $status['record_form'];
				$data['status_title'] 					= $status['title'];
				$data['status_link'] 					= $status['link'];
				$language_id 							= $this->config->get('config_language_id');	
				if(!empty($data['status_main_form'])){
					if(!empty($data['status_main_title'])){
						$data['main_title'] = $data_info['tvcmscustomlink_main'][$language_id]['tvcmscustomlink_main_title'];
					}
					if(!empty($data['status_main_short_description'])){
						$data['main_short_description'] = $data_info['tvcmscustomlink_main'][$language_id]['tvcmscustomlink_main_short'];
					}
				}
				if(isset($data_info['status'])){
					$this->load->model('tool/image');
					$customlinklist_info   = $this->model_catalog_tvcmsmodule->gettvcustomlinnklist();
					$data['custlink_data'] = array();
					foreach ($customlinklist_info as $key => $value) {
						if(!empty($value['tvcustomlink_status'])){
							$title = json_decode($value['tvcustomlink_title'],1);
							$last  = $title[$language_id]['title'];
							$data['custlink_data'][] = array(
								'tvcustomlink_id'	  	=> $value['tvcustomlink_id'],
								'tvcustomlink_title'	=> $last,
								'tvcustomlink_link'	  	=> $this->url->link($value['tvcustomlink_link'], '', true)
							);
						}
					}
				}
				return $this->load->view('extension/module/tvcmscustomlink', $data);
			}
		}
	}
	protected function status(){
		return $this->Tvcmsthemevoltystatus->customlinkstatus();
	}

	public function quickview(){
		$product_id = $this->request->get['product_id'];
		$this->load->language('product/product');

		$this->load->model('catalog/product');

		$product_info = $this->model_catalog_product->getProduct($product_id);

		if ($product_info) {
			$url = '';

			if (isset($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['manufacturer_id'])) {
				$url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
			}

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . $this->request->get['search'];
			}

			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . $this->request->get['tag'];
			}

			if (isset($this->request->get['description'])) {
				$url .= '&description=' . $this->request->get['description'];
			}

			if (isset($this->request->get['category_id'])) {
				$url .= '&category_id=' . $this->request->get['category_id'];
			}

			if (isset($this->request->get['sub_category'])) {
				$url .= '&sub_category=' . $this->request->get['sub_category'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['breadcrumbs'][] = array(
				'text' => $product_info['name'],
				'href' => $this->url->link('product/product', $url . '&product_id=' . $product_id)
			);

			$this->document->setTitle($product_info['meta_title']);
			$this->document->setDescription($product_info['meta_description']);
			$this->document->setKeywords($product_info['meta_keyword']);
			$this->document->addLink($this->url->link('product/product', 'product_id=' . $product_id), 'canonical');

			$data['heading_title'] = $product_info['name'];

			$data['text_minimum'] = sprintf($this->language->get('text_minimum'), $product_info['minimum']);
			
			$this->load->model('catalog/review');

			$data['tab_review'] = sprintf($this->language->get('tab_review'), $product_info['reviews']);

			$data['product_id'] = (int)$product_id;
			$data['manufacturer'] = $product_info['manufacturer'];
			$data['manufacturers'] = $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $product_info['manufacturer_id']);
			$data['model'] = $product_info['model'];
			$data['reward'] = $product_info['reward'];

			if ($product_info['quantity'] <= 0) {
				$data['stock'] = $product_info['stock_status'];
			} elseif ($this->config->get('config_stock_display')) {
				$data['stock'] = $product_info['quantity'];
			} else {
				$data['stock'] = $this->language->get('text_instock');
			}

			$this->load->model('tool/image');

			if ($product_info['image']) {
				$data['popup'] = $this->model_tool_image->resize($product_info['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_popup_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_popup_height'));
			} else {
				$data['popup'] = '';
			}

			if ($product_info['image']) {
				$data['thumb'] = $this->model_tool_image->resize($product_info['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_thumb_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_thumb_height'));
			} else {
				$data['thumb'] = '';
			}

			$data['images'] = array();

			$results = $this->model_catalog_product->getProductImages($product_id);

			foreach ($results as $result) {
				$data['images'][] = array(
					'popup' => $this->model_tool_image->resize($result['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_popup_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_popup_height')),
					'thumb' => $this->model_tool_image->resize($result['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_additional_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_additional_height'))
				);
			}

			if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
				$data['price'] = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
			} else {
				$data['price'] = false;
			}

			if ((float)$product_info['special']) {
				$data['special'] = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
			} else {
				$data['special'] = false;
			}

			if ($this->config->get('config_tax')) {
				$data['tax'] = $this->currency->format((float)$product_info['special'] ? $product_info['special'] : $product_info['price'], $this->session->data['currency']);
			} else {
				$data['tax'] = false;
			}

			$discounts = $this->model_catalog_product->getProductDiscounts($product_id);

			$data['discounts'] = array();

			foreach ($discounts as $discount) {
				$data['discounts'][] = array(
					'quantity' => $discount['quantity'],
					'price'    => $this->currency->format($this->tax->calculate($discount['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency'])
				);
			}

			$data['options'] = array();

			foreach ($this->model_catalog_product->getProductOptions($product_id) as $option) {
				$product_option_value_data = array();

				foreach ($option['product_option_value'] as $option_value) {
					if (!$option_value['subtract'] || ($option_value['quantity'] > 0)) {
						if ((($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) && (float)$option_value['price']) {
							$price = $this->currency->format($this->tax->calculate($option_value['price'], $product_info['tax_class_id'], $this->config->get('config_tax') ? 'P' : false), $this->session->data['currency']);
						} else {
							$price = false;
						}

						$product_option_value_data[] = array(
							'product_option_value_id' => $option_value['product_option_value_id'],
							'option_value_id'         => $option_value['option_value_id'],
							'name'                    => $option_value['name'],
							'image'                   => $this->model_tool_image->resize($option_value['image'], 50, 50),
							'price'                   => $price,
							'price_prefix'            => $option_value['price_prefix']
						);
					}
				}

				$data['options'][] = array(
					'product_option_id'    => $option['product_option_id'],
					'product_option_value' => $product_option_value_data,
					'option_id'            => $option['option_id'],
					'name'                 => $option['name'],
					'type'                 => $option['type'],
					'value'                => $option['value'],
					'required'             => $option['required']
				);
			}

			if ($product_info['minimum']) {
				$data['minimum'] = $product_info['minimum'];
			} else {
				$data['minimum'] = 1;
			}
						$data['review_status'] = $this->config->get('config_review_status');

			$data['reviews'] = sprintf($this->language->get('text_reviews'), (int)$product_info['reviews']);
			$data['rating'] = (int)$product_info['rating'];
			
			$data['share'] = $this->url->link('product/product', 'product_id=' . (int)$product_id);

			$data['recurrings'] = $this->model_catalog_product->getProfiles($product_id);

			
			

			return $this->response->setOutput($this->load->view('product/tvcmsproductquickview', $data));
		}
	}
	public function autocomplete() {
				$this->load->language('extension/module/tvcmscustomtext');

        if (isset($this->request->get['filter_name'])) {
            $this->load->model('catalog/tvcmsmodule');
            $this->load->model('tool/image');
            if (isset($this->request->get['filter_name'])) {
                $filter_name = $this->request->get['filter_name'];
            } else {
                $filter_name = '';
            }
            $limit = $this->config->get('tvcmscustomsetting_configuration')['searchlimit'];
            $filter_data = array(
                'filter_name'  => $filter_name,
                'start'        => 0,
                'limit'        => $limit
            );
            $results 		= $this->model_catalog_tvcmsmodule->getProducts($filter_data);
            $data['product_total'] 		= $results->num_rows;
            $data['products'] 	= array();
            if (!empty($data['product_total'])) {
                foreach ($results->rows as $result) {  
                	if(!empty($result['price'])){
                    $price      = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                	} else {
                        $price = false;
                    }                 
                    if ((float)$result['special']) {
                        $special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                    } else {
                        $special = false;
                    }
                    $tax        = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
                    $prod_link 	= $this->url->link('product/product', 'product_id=' . $result['product_id']);
                    $prod_img 	= $this->model_tool_image->resize($result['image'],98,98);
                    $prod_name 	= strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'));
                    $data['products'][] = array(
						'link'  	  => $prod_link,
						'image'       => $prod_img,
						'name'        => $prod_name,
						'price'       => $price,
						'special'     => $special
					);
                }
            }
        }
       return $this->response->setOutput($this->load->view('product/tvcmsliveproductsearch', $data));
    }
}
