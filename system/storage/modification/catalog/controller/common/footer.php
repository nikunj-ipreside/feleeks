<?php
class ControllerCommonFooter extends Controller {
	public function index() {
		$this->load->language('common/footer');

		$this->load->model('catalog/information');

		$data['informations'] = array();

		foreach ($this->model_catalog_information->getInformations() as $result) {
			if ($result['bottom']) {
				$data['informations'][] = array(
					'title' => $result['title'],
					'href'  => $this->url->link('information/information', 'information_id=' . $result['information_id'])
				);
			}
		}


                if($this->config->get('theme_default_directory') == "opc_electronic_electron_2501"){

                    $this->load->language('extension/module/tvcmscustomtext');
                                        $data['footerlogo']                 = $this->load->controller('common/tvcmsfooterlogo');

                    $data['newsletterdata']                 = $this->load->controller('common/tvcmsnewsletter');
                    $data['store']                          = $this->config->get('config_name');
                    $data['address']                        = nl2br($this->config->get('config_address'));
                    $data['telephone']                      = $this->config->get('config_telephone');
                    $data['fax']                            = $this->config->get('config_fax');
                    $data['email']                          = $this->config->get('config_email');
                    $data['tvtags']                         = $this->load->controller('common/tvcmstags');
                    $sql                                    = $this->db->query("SELECT * FROM " . DB_PREFIX . "country WHERE country_id = '" . $this->config->get('config_country_id') . "' ");
                    $data['country_name']                   = $sql->row['name'];

                    $data['socialicon']                     = $this->load->controller('common/tvcmssocialicon');
                    $data['paymenticon']                    = $this->load->controller('common/tvcmspaymenticon');
                    $store_time                             = $this->load->controller('common/tvcmsstoretime');

                    $data['tvcmsstoretime_status']          = $store_time['tvcmsstoretime_status'];
                    $data['tvcmsstoretime_monday_friday']   = $store_time['tvcmsstoretime_monday_friday'];
                    $data['tvcmsstoretime_saterday']        = $store_time['tvcmsstoretime_saterday'];
                    $data['tvcmsstoretime_sunday']          = $store_time['tvcmsstoretime_sunday'];
                    $data['tvcmsstoretime_title']           = $store_time['tvcmsstoretime_title'];
                    $data['tvcmsstoretime_information']     = $store_time['tvcmsstoretime_information'];
                     $data['tvcmscustomsetting_theme_css_path']     = $this->config->get('tvcmscustomsetting_theme_css_path');
                    $data['theme_option_status']            = $this->config->get('tvcmscustomsetting_configuration')['themeoptionstatus'];
                    $customsetting                          = $this->load->controller('common/tvcmscustomsetting');
                    $data['customsetting_status']           = $customsetting['status'];
                    $data['customsetting_customtext']       = $customsetting['customsub_text'];
                    $data['customsetting_customtextlink']   = $customsetting['customsub_textlink'];
                    

                    if ($this->customer->isLogged()) {
                        $this->load->model('account/wishlist');

                        $data['text_wishlist_tv']   = sprintf($this->model_account_wishlist->getTotalWishlist());
                    } else {
                        $data['text_wishlist_tv']   = sprintf((isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
                    }

                    $data['ttvcpmpare']             = $this->url->link('product/compare', '', true);

                    if(!empty($this->session->data['compare'])){
                        $data['ttvcpmpare_count']   = count($this->session->data['compare']);
                    }else{
                        $data['ttvcpmpare_count']   = 0;
                    }

                    $data['text_compare']       = $this->language->get('text_compare');
                    $data['text_wishlist']      = $this->language->get('text_wishlist');
                    $data['text_mycart']        = $this->language->get('text_mycart');
                    $data['text_myaccount']     = $this->language->get('text_myaccount');
                    $data['text_scrolltop']     = $this->language->get('text_scrolltop');
                    $data['text_storeinfo']     = $this->language->get('text_storeinfo');
                    $data['text_youraccount']   = $this->language->get('text_youraccount');
                    $data['text_ourcompany']    = $this->language->get('text_ourcompany');

                    $data['link_wishlist']      = $this->url->link('account/wishlist', '', true);
                    $data['link_compare']       = $this->url->link('product/compare', '', true);
                    $data['link_account']       = $this->url->link('account/account', '', true);
                    $data['link_addcart']       = $this->url->link('checkout/cart', '', true);
                }
                
		$data['contact'] = $this->url->link('information/contact');
		$data['return'] = $this->url->link('account/return/add', '', true);
		$data['sitemap'] = $this->url->link('information/sitemap');
		$data['tracking'] = $this->url->link('information/tracking');
		$data['manufacturer'] = $this->url->link('product/manufacturer');
		$data['voucher'] = $this->url->link('account/voucher', '', true);
		$data['affiliate'] = $this->url->link('affiliate/login', '', true);
		$data['special'] = $this->url->link('product/special');
		$data['account'] = $this->url->link('account/account', '', true);
		$data['order'] = $this->url->link('account/order', '', true);
		$data['wishlist'] = $this->url->link('account/wishlist', '', true);
		$data['newsletter'] = $this->url->link('account/newsletter', '', true);

		$data['powered'] = sprintf($this->language->get('text_powered'), $this->config->get('config_name'), date('Y', time()));

		// Whos Online
		if ($this->config->get('config_customer_online')) {
			$this->load->model('tool/online');

			if (isset($this->request->server['REMOTE_ADDR'])) {
				$ip = $this->request->server['REMOTE_ADDR'];
			} else {
				$ip = '';
			}

			if (isset($this->request->server['HTTP_HOST']) && isset($this->request->server['REQUEST_URI'])) {
				$url = ($this->request->server['HTTPS'] ? 'https://' : 'http://') . $this->request->server['HTTP_HOST'] . $this->request->server['REQUEST_URI'];
			} else {
				$url = '';
			}

			if (isset($this->request->server['HTTP_REFERER'])) {
				$referer = $this->request->server['HTTP_REFERER'];
			} else {
				$referer = '';
			}

			$this->model_tool_online->addOnline($ip, $this->customer->getId(), $url, $referer);
		}

		$data['scripts'] = $this->document->getScripts('footer');
		
		return $this->load->view('common/footer', $data);
	}
}
