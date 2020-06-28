<?php
class ControllerExtensionModuleTvcmstabproducts extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/tvcmstabproducts');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('localisation/language');
		$this->load->model('setting/module');
		$this->load->model('catalog/product');
		$this->load->model('tool/image');
		$this->load->model('catalog/category');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validatesetting()) {

			if (!isset($this->request->get['module_id'])) {
				$this->model_setting_module->addModule('tvcmstabproducts', $this->request->post);
			} else {
				$this->model_setting_module->editModule($this->request->get['module_id'], $this->request->post);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
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
				'href' => $this->url->link('extension/module/tvcmstabproducts', 'user_token=' . $this->session->data['user_token'] , true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/tvcmstabproducts', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}

		$data['entry_name']					= $this->language->get('entry_name');
		$data['tab_fea']					= $this->language->get('tab_fea');
		$data['tab_new']					= $this->language->get('tab_new');
		$data['tab_bes']					= $this->language->get('tab_bes');
		$data['tab_spe']					= $this->language->get('tab_spe');
		$data['tab_cus']					= $this->language->get('tab_cus');
		$data['text_tab_main']				= $this->language->get('text_tab_main');
		$data['text_tab_sub']				= $this->language->get('text_tab_sub');
		$data['text_tab_hdes']				= $this->language->get('text_tab_hdes');
		$data['text_tab_title']				= $this->language->get('text_tab_title');
		$data['text_tab_htitle']			= $this->language->get('text_tab_htitle');
		$data['text_tab_hstitle']			= $this->language->get('text_tab_hstitle');
		$data['text_tab_nopro']				= $this->language->get('text_tab_nopro');
		$data['text_tab_cateprodis']		= $this->language->get('text_tab_cateprodis');
		$data['text_tab_disradpro']			= $this->language->get('text_tab_disradpro');
		$data['text_tab_distab']			= $this->language->get('text_tab_distab');
		$data['text_tab_new_nopro']			= $this->language->get('text_tab_new_nopro');
		$data['text_tab_new_cateprodis']	= $this->language->get('text_tab_new_cateprodis');
		$data['text_tab_cust_hdes']			= $this->language->get('text_tab_cust_hdes');

		$data['entry_cust_des']				= $this->language->get('entry_cust_des');
		$data['entry_cust_main']			= $this->language->get('entry_cust_main');
		$data['entry_cust_dis']				= $this->language->get('entry_cust_dis');
		$data['entry_fea_bans']				= $this->language->get('entry_fea_bans');
		$data['entry_new_ban']				= $this->language->get('entry_new_ban');
		$data['entry_best_ban']				= $this->language->get('entry_best_ban');

		$data['languages'] 					= $this->model_localisation_language->getLanguages();
		$data['user_token']					= $this->session->data['user_token'];

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/tvcmstabproducts', 'user_token=' . $this->session->data['user_token'] , true);
		} else {
			$data['action'] = $this->url->link('extension/module/tvcmstabproducts', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
		}
		
		$data['cancel'] 	= $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info 	= $this->model_setting_module->getModule($this->request->get['module_id']);
		}
		
		if (isset($this->request->post['name'])) {
			$data['name'] 	= $this->request->post['name'];
		} elseif (!empty($module_info)) {
			$data['name'] 	= $module_info['name'];
		} else {
			$data['name'] 	= '';
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = "";
		}

		$data['products'] 	= array();

		if (!empty($this->request->post['tvcmstabproducts_pro_fea']['cate_pro'])) {
			$products = $this->request->post['tvcmstabproducts_pro_fea']['cate_pro'];
		} elseif (!empty($module_info['tvcmstabproducts_pro_fea']['cate_pro'])) {
			$products = $module_info['tvcmstabproducts_pro_fea']['cate_pro'];
		} else {
			$products = array();
		}

		foreach ($products as $product_id) {
			$product_info =  $this->model_catalog_category->getCategory($product_id);
			if ($product_info) {
				$data['products'][] = array(
					'product_id' => $product_info['category_id'],
					'name'       => $product_info['name']
				);
			}
		}
		$status = $this->status();
		
		$data['featured_prod']['main_form'] 				= $status['featured_prod']['main_form'];
		$data['featured_prod']['home_image_status'] 		= $status['featured_prod']['home_image_status'];
		$data['featured_prod']['num_of_prod'] 				= $status['featured_prod']['num_of_prod'];
		$data['featured_prod']['prod_cat'] 					= $status['featured_prod']['prod_cat'];
		$data['featured_prod']['random_prod']				= $status['featured_prod']['random_prod'];
		$data['featured_prod']['display_in_tab'] 			= $status['featured_prod']['display_in_tab'];
		$data['featured_prod']['tab_title'] 				= $status['featured_prod']['tab_title'];
		$data['featured_prod']['home_title'] 				= $status['featured_prod']['home_title'];
		$data['featured_prod']['home_sub_title'] 			= $status['featured_prod']['home_sub_title'];
		$data['featured_prod']['home_description'] 			= $status['featured_prod']['home_description'];
		$data['featured_prod']['home_image'] 				= $status['featured_prod']['home_image'];

		$data['new_prod']['main_form'] 						= $status['new_prod']['main_form'];
		$data['new_prod']['home_image_status'] 				= $status['new_prod']['home_image_status'];
		$data['new_prod']['num_of_prod'] 					= $status['new_prod']['num_of_prod'];
		$data['new_prod']['num_of_days'] 					= $status['new_prod']['num_of_days'];
		$data['new_prod']['display_in_tab']					= $status['new_prod']['display_in_tab'];
		$data['new_prod']['tab_title'] 						= $status['new_prod']['tab_title'];
		$data['new_prod']['home_title'] 					= $status['new_prod']['home_title'];
		$data['new_prod']['home_sub_title'] 				= $status['new_prod']['home_sub_title'];
		$data['new_prod']['home_description'] 				= $status['new_prod']['home_description'];
		$data['new_prod']['home_image'] 					= $status['new_prod']['home_image'];

		$data['best_seller_prod']['main_form'] 				= $status['best_seller_prod']['main_form'];
		$data['best_seller_prod']['home_image_status'] 		= $status['best_seller_prod']['home_image_status'];
		$data['best_seller_prod']['num_of_prod'] 			= $status['best_seller_prod']['num_of_prod'];
		$data['best_seller_prod']['display_in_tab'] 		= $status['best_seller_prod']['display_in_tab'];
		$data['best_seller_prod']['tab_title'] 				= $status['best_seller_prod']['tab_title'];
		$data['best_seller_prod']['home_title'] 			= $status['best_seller_prod']['home_title'];
		$data['best_seller_prod']['home_sub_title'] 		= $status['best_seller_prod']['home_sub_title'];
		$data['best_seller_prod']['home_description'] 		= $status['best_seller_prod']['home_description'];
		$data['best_seller_prod']['home_image'] 			= $status['best_seller_prod']['home_image'];

		$data['special_prod']['main_form'] 					= $status['special_prod']['main_form'];
		$data['special_prod']['home_image_status'] 			= $status['special_prod']['home_image_status'];
		$data['special_prod']['num_of_prod'] 				= $status['special_prod']['num_of_prod'];
		$data['special_prod']['display_in_tab'] 			= $status['special_prod']['display_in_tab'];
		$data['special_prod']['tab_title']					= $status['special_prod']['tab_title'];
		$data['special_prod']['home_title'] 				= $status['special_prod']['home_title'];
		$data['special_prod']['home_sub_title'] 			= $status['special_prod']['home_sub_title'];
		$data['special_prod']['home_description'] 			= $status['special_prod']['home_description'];
		$data['special_prod']['home_image'] 				= $status['special_prod']['home_image'];

		$data['cust_prod']['main_form']                     = $status['cust_prod']['main_form'];
        $data['cust_prod']['main_image_status']             = $status['cust_prod']['main_image_status'];
        $data['cust_prod']['main_title']                    = $status['cust_prod']['main_title'];
        $data['cust_prod']['main_sub_title']                = $status['cust_prod']['main_sub_title'];
        $data['cust_prod']['main_description']              = $status['cust_prod']['main_description'];
        $data['cust_prod']['main_image']                    = $status['cust_prod']['main_image'];

        $default_image = $this->model_tool_image->resize('no_image.png', 100, 100);

        if($data['cust_prod']['main_form']){
			if(!empty($this->request->post['tvcmstabproducts_pro_cus'])) {
				$data['tvcmstabproducts_pro_cus'] 	= $this->request->post['tvcmstabproducts_pro_cus'];
				foreach ($this->request->post['tvcmstabproducts_pro_cus']['lang_text'] as $key => $value) {
					if(!empty($value['img'])){
						$data['img_1'][$key] = $this->model_tool_image->resize($value['img'], 100, 100);				
					}else{
						$data['img_1'][$key] = $default_image;				
					}
				}

			} elseif (!empty($module_info)) {
				foreach ($module_info['tvcmstabproducts_pro_cus']['lang_text'] as $key => $value) {
					if(!empty($value['img'])){
						$data['img_1'][$key] 			=  $this->model_tool_image->resize($value['img'], 100, 100);						
					}else{
						$data['img_1'][$key] = $default_image;				
					}
				}
				$data['tvcmstabproducts_pro_cus'] 	= $module_info['tvcmstabproducts_pro_cus'];
			} else {
				foreach ($data['languages'] as $key => $value) {
					$data['img_1'][$value['language_id']] = $default_image;
				}
				$data['tvcmstabproducts_pro_cus']   = array();
			}
		}

		if (isset($this->request->post['tvcmstabproducts_pro_fea'])) {
			$data['tvcmstabproducts_pro_fea'] 	= $this->request->post['tvcmstabproducts_pro_fea'];
			foreach ($this->request->post['tvcmstabproducts_pro_fea']['lang_text'] as $key => $value) {
				if(!empty($value['img'])){
					$data['img_2'][$key] = $this->model_tool_image->resize($value['img'], 100, 100);				
				}else{
					$data['img_2'][$key] = $default_image;				
				}
			}
		} elseif (!empty($module_info)) {
			foreach ($module_info['tvcmstabproducts_pro_fea']['lang_text'] as $key => $value) {
				if(!empty($value['img'])){
					$data['img_2'][$key] = $this->model_tool_image->resize($value['img'], 100, 100);				
				}else{
					$data['img_2'][$key] = $default_image;				
				}
			}
			$data['tvcmstabproducts_pro_fea'] 	= $module_info['tvcmstabproducts_pro_fea'];
		} else {
			foreach ($data['languages'] as $key => $value) {
				$data['img_2'][$value['language_id']] = $default_image;
			}
			$data['tvcmstabproducts_pro_fea']   = array();
		}

		if (isset($this->request->post['tvcmstabproducts_pro_new'])) {
			$data['tvcmstabproducts_pro_new'] 	= $this->request->post['tvcmstabproducts_pro_new'];
			foreach ($this->request->post['tvcmstabproducts_pro_new']['lang_text'] as $key => $value) {
				if(!empty($value['img'])){
					$data['img_3'][$key] = $this->model_tool_image->resize($value['img'], 100, 100);				
				}else{
					$data['img_3'][$key] = $default_image;				
				}
			}
		} elseif (!empty($module_info)) {
			foreach ($module_info['tvcmstabproducts_pro_new']['lang_text'] as $key => $value) {
				if(!empty($value['img'])){
					$data['img_3'][$key] = $this->model_tool_image->resize($value['img'], 100, 100);				
				}else{
					$data['img_3'][$key] = $default_image;				
				}				
			}
			$data['tvcmstabproducts_pro_new'] 	= $module_info['tvcmstabproducts_pro_new'];
		} else {
			foreach ($data['languages'] as $key => $value) {
				$data['img_3'][$value['language_id']] = $default_image;
			}
			$data['tvcmstabproducts_pro_new']   = array();
		}

		if (isset($this->request->post['tvcmstabproducts_pro_best'])) {
			$data['tvcmstabproducts_pro_best'] 	= $this->request->post['tvcmstabproducts_pro_best'];
			foreach ($this->request->post['tvcmstabproducts_pro_best']['lang_text'] as $key => $value) {
				if(!empty($value['img'])){
					$data['img_4'][$key] = $this->model_tool_image->resize($value['img'], 100, 100);				
				}else{
					$data['img_4'][$key] = $default_image;				
				}
			}
		} elseif (!empty($module_info)) {
			foreach ($module_info['tvcmstabproducts_pro_best']['lang_text'] as $key => $value) {
				if(!empty($value['img'])){
					$data['img_4'][$key] = $this->model_tool_image->resize($value['img'], 100, 100);				
				}else{
					$data['img_4'][$key] = $default_image;				
				}
			}
			$data['tvcmstabproducts_pro_best'] 	= $module_info['tvcmstabproducts_pro_best'];
		} else {
			foreach ($data['languages'] as $key => $value) {
				$data['img_4'][$value['language_id']] = $default_image;
			}
			$data['tvcmstabproducts_pro_best']  = array();
		}

		if (isset($this->request->post['tvcmstabproducts_pro_spe'])) {
			$data['tvcmstabproducts_pro_spe'] 	= $this->request->post['tvcmstabproducts_pro_spe'];
			foreach ($this->request->post['tvcmstabproducts_pro_spe']['lang_text'] as $key => $value) {
				if(!empty($value['img'])){
					$data['img_5'][$key] 		= $this->model_tool_image->resize($value['img'], 100, 100);				
				}else{
					$data['img_5'][$key] 		= $default_image;				
				}
			}
		} elseif (!empty($module_info)) {
			foreach ($module_info['tvcmstabproducts_pro_spe']['lang_text'] as $key => $value) {
				if(!empty($value['img'])){
					$data['img_5'][$key] 		= $this->model_tool_image->resize($value['img'], 100, 100);				
				}else{
					$data['img_5'][$key] 		= $default_image;				
				}				
			}
			$data['tvcmstabproducts_pro_spe'] 			= $module_info['tvcmstabproducts_pro_spe'];
		} else {
			foreach ($data['languages'] as $key => $value) {
				$data['img_5'][$value['language_id']] 	= $default_image;
			}
			$data['tvcmstabproducts_pro_spe']   		= array();
		}
		
		$data['header'] 		= $this->load->controller('common/header');
		$data['column_left'] 	= $this->load->controller('common/column_left');
		$data['footer'] 		= $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/tvcmstabproducts', $data));
	}

	public function install(){
		$this->load->model('setting/module');
		$this->load->model('localisation/language');
		$this->load->model('catalog/tvcmscategoryslider');

		$main 			= array();
		$main['name'] 	= "Tab Product";
		$main['status'] = 1;

		$main['tvcmstabproducts_pro_fea']['status'] = 1;
		$main['tvcmstabproducts_pro_fea']['no_pro'] = 11;
		$cat_id = $this->db->query("SELECT * from " . DB_PREFIX . "category where parent_id = '0'");
		$id = array();
		foreach ($cat_id->rows as $key => $value) {
			array_push($id, $value['category_id']);
		}
		$main['tvcmstabproducts_pro_fea']['cate_pro'] 		= $id;
		$main['tvcmstabproducts_pro_fea']['dis_rand'] 		= 1;
		$main['tvcmstabproducts_pro_fea']['dis_tap']  		= 1;
		$main['tvcmstabproducts_pro_fea']['bannerside']  	= "left";
		$main['tvcmstabproducts_pro_fea']['bannerstatus']  	= 0;
		$main['tvcmstabproducts_pro_new']['status'] 		= 1;
		$main['tvcmstabproducts_pro_new']['no_pro'] 		= 11;
		$main['tvcmstabproducts_pro_new']['cate_pro'] 		= 4;
		$main['tvcmstabproducts_pro_new']['dis_tap'] 		= 1;
		$main['tvcmstabproducts_pro_new']['bannerside']  	= "left";
		$main['tvcmstabproducts_pro_new']['bannerstatus']  	= 0;
		$main['tvcmstabproducts_pro_best']['status'] 		= 1;
		$main['tvcmstabproducts_pro_best']['no_pro'] 		= 11;
		$main['tvcmstabproducts_pro_best']['dis_tap'] 		= 1;
		$main['tvcmstabproducts_pro_best']['bannerside']  	= "left";
		$main['tvcmstabproducts_pro_best']['bannerstatus']  = 0;
		$main['tvcmstabproducts_pro_spe']['status'] 		= 0;
		$main['tvcmstabproducts_pro_spe']['no_pro'] 		= 11;
		$main['tvcmstabproducts_pro_spe']['dis_tap'] 		= 1;
		$main['tvcmstabproducts_pro_spe']['bannerside']  	= "left";
		$main['tvcmstabproducts_pro_spe']['bannerstatus']  	= 1;
		$main['tvcmstabproducts_pro_cus']['status'] 		= 1;
		$main['tvcmstabproducts_pro_cus']['bannerside']  	= "left";
		$main['tvcmstabproducts_pro_cus']['bannerstatus']  	= 0;

		$languages = $this->model_localisation_language->getLanguages();
        foreach ($languages as $value) {
        	$main['tvcmstabproducts_pro_fea']['lang_text'][$value['language_id']] =  array('tabtitle'=>"Featured",'hometitle'=>"Featured",'homesubtitle'=>"Our Featured product",'homedes'=>"our Featured product",'img'=>"catalog/themevolty/tabproducts/best_seller_offer_img_1.jpg");
        	$main['tvcmstabproducts_pro_new']['lang_text'][$value['language_id']] =  array('tabtitle'=>"New Product",'hometitle'=>"New Product",'homesubtitle'=>"Our New Product",'homedes'=>"our New Product",'img'=>"catalog/themevolty/tabproducts/featured_offer_img_1.jpg");
        	$main['tvcmstabproducts_pro_best']['lang_text'][$value['language_id']] =  array('tabtitle'=>"Best Seller",'hometitle'=>"Best Product",'homesubtitle'=>"Our best product",'homedes'=>"our Best Product",'img'=>"catalog/themevolty/tabproducts/main_offer_img_1.jpg");
        	$main['tvcmstabproducts_pro_spe']['lang_text'][$value['language_id']] =  array('tabtitle'=>"special",'hometitle'=>"Special Trand Products",'homesubtitle'=>"Our special product",'homedes'=>"our special Product",'img'=>"catalog/themevolty/tabproducts/Special_Trend_Banner.jpg");
        	$main['tvcmstabproducts_pro_cus']['lang_text'][$value['language_id']] =  array('maintitle'=>"We love Trend",'subtitle'=>"Lorem Ipsum is simply dummy text of the printing",'des'=>"Our product",'img'=>"catalog/themevolty/tabproducts/main_offer_img_1.jpg");
		}

		$this->model_setting_module->addModule('tvcmstabproducts', $main);
	
	}

	protected function status(){
		return $this->Tvcmsthemevoltystatus->tabproductstatus();
	}
	
	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('catalog/category');

			$filter_data = array(
				'filter_name' => $this->request->get['filter_name'],
				'sort'        => 'name',
				'order'       => 'ASC',
				'start'       => 0,
				'limit'       => 5
			);

			$results = $this->model_catalog_category->getparentCategories($filter_data);

			foreach ($results as $result) {
				$json[] = array(
					'category_id' => $result['category_id'],
					'name'        => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	protected function validatesetting() {
		$this->load->language('extension/module/tvcmsimageslider');

		if (!$this->user->hasPermission('modify', 'extension/module/tvcmstabproducts')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		return !$this->error;
	}
}