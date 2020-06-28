<?php
class ControllerExtensionModuleSpecial extends Controller {

                protected function status(){
                    return $this->Tvcmsthemevoltystatus->tabproductstatus();
                }            
            
	public function index($setting) {
		$this->load->language('extension/module/special');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		$data['products'] = array();

		$filter_data = array(
			'sort'  => 'pd.name',
			'order' => 'ASC',
			'start' => 0,
			'limit' => $setting['limit']
		);

		$results = $this->model_catalog_product->getProductSpecials($filter_data);


                if($this->config->get('theme_default_directory') == "opc_electronic_electron_2501"){
                    $this->load->model('catalog/tvcmsmodule');
                    $status                                         = $this->status();
                    $data['status_special_main_form']               = $status['special_prod']['main_form'];
                    $data['status_special_home_title']              = $status['special_prod']['home_title'];
                    $data['status_special_home_sub_title']          = $status['special_prod']['home_sub_title'];
                    $data['status_special_home_description']        = $status['special_prod']['home_description'];
                    $data['status_special_home_image']              = $status['special_prod']['home_image'];
                    $data['lang_id']                                = $this->config->get('config_language_id');
                    if(!empty($data['status_special_main_form'])){
                        $name           = "tvcmstabproducts";
                        $status_info    = $this->model_catalog_tvcmsmodule->getmoduelstatus($name);
                        $data_info      = json_decode($status_info['setting'],1);
                        
                        if(!empty($data['status_special_home_title'])){
                            $data['special_hometitle'] = $data_info['tvcmstabproducts_pro_special']['lang_text'][$data['lang_id']]['hometitle'];
                        }
                        if(!empty($data['status_special_home_sub_title'])){
                            $data['special_homesubtitle'] = $data_info['tvcmstabproducts_pro_special']['lang_text'][$data['lang_id']]['homesubtitle'];
                        }
                        if(!empty($data['status_special_home_description'])){
                            $data['special_homedes'] = $data_info['tvcmstabproducts_pro_special']['lang_text'][$data['lang_id']]['homedes'];
                        }
                        if(!empty($data['status_special_home_image'])){
                            $data['special_img'] = $data_info['tvcmstabproducts_pro_new']['lang_text'][$data['lang_id']]['img'];
                        }   
                    }
                }
                
		if ($results) {
			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']);
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
				}


                    $data['comparedisplay']     = $this->config->get('tvcmscustomsetting_configuration')['comparedisplay'];
                    $data['wishlistdisplay']    = $this->config->get('tvcmscustomsetting_configuration')['wishlistdisplay'];
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

                     $gethoverimage   = $this->model_catalog_product->getproductimage($result['product_id']);

                        if(!empty(current($gethoverimage))){
                            $hoverimage = $this->model_tool_image->resize(current($gethoverimage)['image'], $setting['width'], $setting['height']);

                            
                        }else{
                            $hoverimage = $image;
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
					$rating = $result['rating'];
				} else {
					$rating = false;
				}

				$data['products'][] = array(
					'product_id'  => $result['product_id'],

                                         'hoverimage'    => $hoverimage,
                                          'start_date'      => $sdate,
                        'date_end'      => $edate,
                
					'thumb'       => $image,
					'name'        => $result['name'],
					'description' => utf8_substr(trim(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'))), 0, $this->config->get('theme_' . $this->config->get('config_theme') . '_product_description_length')) . '..',
					'price'       => $price,
					'special'     => $special,
					'tax'         => $tax,
					'rating'      => $rating,
					'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id'])
				);
			}

			return $this->load->view('extension/module/special', $data);
		}
	}
}