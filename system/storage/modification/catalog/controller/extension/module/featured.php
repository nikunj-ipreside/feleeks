<?php
class ControllerExtensionModuleFeatured extends Controller {

                protected function status(){
                    return $this->Tvcmsthemevoltystatus->tabproductstatus();
                }            
            
	public function index($setting) {

                if($this->config->get('theme_default_directory') == "opc_electronic_electron_2501"){
                    $this->load->model('catalog/tvcmsmodule');
                    $status                                         = $this->status();
                    $data['status_featured_main_form']              = $status['featured_prod']['main_form'];
                    $data['status_featured_display_in_tab']         = $status['featured_prod']['display_in_tab'];
                    $data['status_featured_home_title']             = $status['featured_prod']['home_title'];
                    $data['status_featured_home_sub_title']         = $status['featured_prod']['home_sub_title'];
                    $data['status_featured_home_description']       = $status['featured_prod']['home_description'];
                    $data['status_featured_home_image']             = $status['featured_prod']['home_image'];
                    $data['lang_id']                                = $this->config->get('config_language_id');
                    $name                                           = "tvcmstabproducts";
                    $status_info                                    = $this->model_catalog_tvcmsmodule->getmoduelstatus($name);
                    $data_info                                      = json_decode($status_info['setting'],1);

                    if(!empty($data['status_featured_main_form'])){
                        if(!empty($data['status_featured_home_title'])){
                            $data['featured_home_title'] = $data_info['tvcmstabproducts_pro_fea']['lang_text'][$data['lang_id']]['hometitle'];
                        }
                        if(!empty($data['status_featured_home_sub_title'])){
                            $data['featured_home_sub_title'] = $data_info['tvcmstabproducts_pro_fea']['lang_text'][$data['lang_id']]['homesubtitle'];
                        }
                        if(!empty($data['status_featured_home_description'])){
                            $data['featured_home_description'] = $data_info['tvcmstabproducts_pro_fea']['lang_text'][$data['lang_id']]['homedes'];
                        }
                        if(!empty($data['status_featured_home_image'])){
                            $data['featured_home_image'] = $data_info['tvcmstabproducts_pro_fea']['lang_text'][$data['lang_id']]['img'];
                        }
                    }
                }
                
		$this->load->language('extension/module/featured');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		$data['products'] = array();

		if (!$setting['limit']) {
			$setting['limit'] = 4;
		}

		if (!empty($setting['product'])) {
			$products = array_slice($setting['product'], 0, (int)$setting['limit']);

			foreach ($products as $product_id) {
				$product_info = $this->model_catalog_product->getProduct($product_id);

				if ($product_info) {
					if ($product_info['image']) {
						$image = $this->model_tool_image->resize($product_info['image'], $setting['width'], $setting['height']);
					} else {
						$image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
					}


                    $data['comparedisplay']   = $this->config->get('tvcmscustomsetting_configuration')['comparedisplay'];
                    $data['wishlistdisplay']   = $this->config->get('tvcmscustomsetting_configuration')['wishlistdisplay'];
                    $date = $this->model_catalog_product->getcustomProductSpecials($product_info['product_id']);
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

                     $gethoverimage   = $this->model_catalog_product->getproductimage($product_info['product_id']);

                        if(!empty(current($gethoverimage))){
                            $hoverimage = $this->model_tool_image->resize(current($gethoverimage)['image'], $setting['width'], $setting['height']);

                            
                        }else{
                            $hoverimage = $image;
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

					$data['products'][] = array(
						'product_id'  => $product_info['product_id'],

                                         'hoverimage'    => $hoverimage,
                                         'start_date'   => $sdate,
                        'date_end'      => $edate,
                
						'thumb'       => $image,
						'name'        => $product_info['name'],
						'description' => utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('theme_' . $this->config->get('config_theme') . '_product_description_length')) . '..',
						'price'       => $price,
						'special'     => $special,
						'tax'         => $tax,
						'rating'      => $rating,
						'href'        => $this->url->link('product/product', 'product_id=' . $product_info['product_id'])
					);
				}
			}
		}

		if ($data['products']) {
			return $this->load->view('extension/module/featured', $data);
		}
	}
}