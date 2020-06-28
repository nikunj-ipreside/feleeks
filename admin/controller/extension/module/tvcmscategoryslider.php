<?php
class ControllerExtensionModuleTvcmscategoryslider extends Controller {

	private $error = array();

	public function index() {
		$this->load->language('extension/module/tvcmscategoryslider');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/tvcmscategoryslider');

		$this->getList();
	}
	public function install(){

		$main 			= array();
		$main['name'] 	= "Category Slider";
		$main['status'] = 1;

		$this->load->model('setting/module');
		$this->load->model('localisation/language');
		$this->load->model('catalog/tvcmscategoryslider');

		$languages = $this->model_localisation_language->getLanguages();

        foreach ($languages as $value) {
        	$main['tvcmscategoryslider_main'][$value['language_id']] =  array('tvcmscategoryslider_main_cat'=>"Our Category",'lang_id'=>"'".$value['language_id']."'",'tvcmscategoryslider_main_short'=>"Short Description1",'tvcmscategoryslider_main_des'=>"Description",'tvcmscategoryslider_main_img'=>"catalog/themevolty/categoryslider/demo_main_img.jpg");
		}

		$this->model_setting_module->addModule('tvcmscategoryslider', $main);
		
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "tvcmscategoryslidermain` 
		(   `tvcmscategoryslidermain_id` int(11) AUTO_INCREMENT,
            `tvcmscategoryslidermain_category_id` int(11),
            `tvcmscategoryslidermain_pos` int(11),
            `tvcmscategoryslidermain_image` VARCHAR(100),
            `tvcmscategoryslidermain_status` int(11),
        PRIMARY KEY (`tvcmscategoryslidermain_id`)) ENGINE = InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "tvcmscategoryslidersub` 
        (	`tvcmscategoryslidersub_id` INT NOT NULL AUTO_INCREMENT ,
            `tvcmscategoryslidermain_id` INT NOT NULL ,
            `tvcmscategoryslidersublang_id` INT NOT NULL ,
            `tvcmscategoryslidersub_name` VARCHAR(255),
            `tvcmscategoryslidersub_des` TEXT ,
        PRIMARY KEY (`tvcmscategoryslidersub_id`)) ENGINE = InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;");

		$num_of_data = 8;
		$sub 		 = array();
		$category 	 = $this->model_catalog_tvcmscategoryslider->getCategories();

	 	for ($i = 1; $i<=$num_of_data; $i++) {
            $this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmscategoryslidermain`
			SET      	tvcmscategoryslidermain_category_id = "'.$category[$i]['category_id'].'" ,
						tvcmscategoryslidermain_image 		= "catalog/themevolty/categoryslider/demo_img_'.$i.'.png",
						tvcmscategoryslidermain_pos 		= '.$i.',
						tvcmscategoryslidermain_status 		= 1;');	

	        foreach ($languages as $value) {
				$this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmscategoryslidersub`
				SET 
							tvcmscategoryslidermain_id 		= '.$i.',
							tvcmscategoryslidersub_name 	= "Mobile",
							tvcmscategoryslidersub_des 		= "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.'.$i.'",
							tvcmscategoryslidersublang_id 	= '.$value['language_id'].'');
			}
    	}

	}
	public function uninstall(){
		$pre = DB_PREFIX;
		$this->db->query("DROP TABLE `{$pre}tvcmscategoryslidermain`");
		$this->db->query("DROP TABLE `{$pre}tvcmscategoryslidersub`");
	}
	public function ajax() {
		$this->load->model('catalog/tvcmscategoryslider');
		$update_position 	= $this->request->get['action'];
		$position 			= $this->request->get['recordsArray'];
		$return_data 		= array();
		if ($update_position == 'update_position') {
		    $return_data['success'] = 'right';
		    $this->model_catalog_tvcmscategoryslider->updatePosition($position);
		    echo $res = implode("##", $return_data);
		}
	}
	public function add() {
		$this->load->language('extension/module/tvcmscategoryslider');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/tvcmscategoryslider');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_tvcmscategoryslider->insertdata($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}


			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
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

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}

		$this->getForm();
	}
	public function edit() {
		$this->load->language('extension/module/tvcmscategoryslider');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/tvcmscategoryslider');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			
			$this->model_catalog_tvcmscategoryslider->editcatimageslider($this->request->get['tvcmscategoryslidermain_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}


			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
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

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}

		$this->getForm();
	}
	public function delete() {
		$this->load->language('extension/module/tvcmscategoryslider');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/tvcmscategoryslider');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $tvcmscategoryslidermain_id) {
				$this->model_catalog_tvcmscategoryslider->deletecateimageslider($tvcmscategoryslidermain_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}


			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
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

			$this->getList();
		}
		$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));

	}
	public function copy() {
		$this->load->language('extension/module/tvcmscategoryslider');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/tvcmscategoryslider');

		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $tvcmscategoryslidermain_id) {
				$this->model_catalog_tvcmscategoryslider->copycateimageslider($tvcmscategoryslidermain_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
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

			$this->getList();
		}
		$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));

	}
	protected function status(){
		return $this->Tvcmsthemevoltystatus->categorysliderstatus();
	}
	public function getList() {

		$this->load->model('setting/module');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validatesetting()) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_setting_module->addModule('tvcmscategoryslider', $this->request->post);
			} else {
				$this->model_setting_module->editModule($this->request->get['module_id'], $this->request->post);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}
		$this->load->model('localisation/language');

		$data['languages'] 	= $this->model_localisation_language->getLanguages();

		$this->load->language('extension/module/tvcmscategoryslider');

		$data['text_left'] 			= $this->language->get('text_left');
		$data['text_center'] 		= $this->language->get('text_center');
		$data['text_right'] 		= $this->language->get('text_right');
		$data['text_hide'] 			= $this->language->get('text_hide');
		$data['text_setting'] 		= $this->language->get('text_setting');
		$data['entry_name'] 		= $this->language->get('entry_name');
		$data['entry_status'] 		= $this->language->get('entry_status');
		$data['entry_catimg'] 		= $this->language->get('entry_catimg');
		$data['entry_cat'] 			= $this->language->get('entry_cat');
		$data['entry_cat_name'] 	= $this->language->get('entry_cat_name');
		$data['entry_des']	 		= $this->language->get('entry_des');
		$data['entry_main_cate']	= $this->language->get('entry_main_cate');
		$data['entry_main_short']	= $this->language->get('entry_main_short');
		$data['entry_main_des']	 	= $this->language->get('entry_main_des');
		$data['entry_main_tit']	 	= $this->language->get('entry_main_tit');
		$data['text_extension']	 	= $this->language->get('text_extension');

		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = '';
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = '';
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'pd.name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);
		
		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/tvcmscategoryslider', 'user_token=' . $this->session->data['user_token'] . $url, true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/tvcmscategoryslider', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}


		if (!isset($this->request->get['module_id'])) {
			$data['mainaction'] = $this->url->link('extension/module/tvcmscategoryslider/getList', 'user_token=' . $this->session->data['user_token'] . $url, true);
		} else {
			$data['mainaction'] = $this->url->link('extension/module/tvcmscategoryslider/getList', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
		}
		
		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_setting_module->getModule($this->request->get['module_id']);
		}

		$data['add'] 		= $this->url->link('extension/module/tvcmscategoryslider/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['copy'] 		= $this->url->link('extension/module/tvcmscategoryslider/copy', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['delete'] 	= $this->url->link('extension/module/tvcmscategoryslider/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($module_info)) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = "";
		}

		$this->load->model('tool/image');

		$status = $this->status();

    	$data['status_main_form']				= $status['main_form'];
    	$data['status_main_title']				= $status['main_title'];
    	$data['status_main_short_description']	= $status['main_short_description'];
    	$data['status_main_description']		= $status['main_description'];
    	$data['status_main_image']				= $status['main_image'];

    	$data['status_record_form']				= $status['record_form'];
    	$data['status_category_title']			= $status['category_title'];
    	$data['status_image']					= $status['image'];
    	$data['status_title']					= $status['title'];
    	$data['status_short_description']		= $status['short_description'];

    	$default_image = $this->model_tool_image->resize('no_image.png', 100, 100);
		if (isset($this->request->post['tvcmscategoryslider_main'])) {
			$data['tvcmscategoryslider_main'] = $this->request->post['tvcmscategoryslider_main'];
					
		} elseif (!empty($module_info['tvcmscategoryslider_main'])) {
				
			$data['tvcmscategoryslider_main'] = $module_info['tvcmscategoryslider_main'];
		} else {
				
			$data['tvcmscategoryslider_main'] = array();
		}
		$data['cateimagesliders'] = array();

		$filter_data = array(
			'filter_name'	  => $filter_name,
			'filter_status'   => $filter_status,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'           => $this->config->get('config_limit_admin')
		);

		$this->load->model('tool/image');
		$this->load->model('catalog/tvcmscategoryslider');

		$imageslider_total = $this->model_catalog_tvcmscategoryslider->getcateTotalsliderimage($filter_data);

		$results = $this->model_catalog_tvcmscategoryslider->getcateimageslider($filter_data);

			
		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['tvcmscategoryslidermain_image'])) {
				$image = $this->model_tool_image->resize($result['tvcmscategoryslidermain_image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.png', 40, 40);
			}
			$cate_namme = $this->model_catalog_tvcmscategoryslider->getcatename($result['tvcmscategoryslidermain_category_id']);
			if(isset($cate_namme['name'])){
				$name = $cate_namme['name'];
			}else{
				$name ="";
			}
			$data['cateimagesliders'][] = array(
				'id' 		=> $result['tvcmscategoryslidermain_id'],
				'image'     => $image,
				'title'     => $name,
				'aling'     => $result['tvcmscategoryslidersub_name'],
				'des'    	=> html_entity_decode($result['tvcmscategoryslidersub_des']),
				'status'    => $result['tvcmscategoryslidermain_status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'edit'      => $this->url->link('extension/module/tvcmscategoryslider/edit', 'user_token=' . $this->session->data['user_token'] . '&tvcmscategoryslidermain_id=' . $result['tvcmscategoryslidermain_id'] . $url, true)
			);
		}

		$data['user_token'] = $this->session->data['user_token'];

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}


		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}


		$data['sort_tvcmscategoryslidersub_name'] 	= $this->url->link('extension/module/tvcmscategoryslider', 'user_token=' . $this->session->data['user_token'] . '&sort=pd.tvcmscategoryslidersub_name' . $url, true);

		$data['sort_tvcmscategoryslidersub_des'] 	= $this->url->link('extension/module/tvcmscategoryslider', 'user_token=' . $this->session->data['user_token'] . '&sort=pd.tvcmscategoryslidersub_des' . $url, true);

		$data['sort_tvcmscategoryslidermain_status'] = $this->url->link('extension/module/tvcmscategoryslider', 'user_token=' . $this->session->data['user_token'] . '&sort=p.tvcmscategoryslidermain_status' . $url, true);

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}


		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination 		= new Pagination();
		$pagination->total 	= $imageslider_total;
		$pagination->page 	= $page;
		$pagination->limit 	= $this->config->get('config_limit_admin');
		$pagination->url 	= $this->url->link('extension/module/tvcmscategoryslider', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($imageslider_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($imageslider_total - $this->config->get('config_limit_admin'))) ? $imageslider_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $imageslider_total, ceil($imageslider_total / $this->config->get('config_limit_admin')));

		$data['filter_name'] = $filter_name;
		
		$data['filter_status'] = $filter_status;

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['ajaxlink'] = $this->url->link('extension/module/tvcmscategoryslider/ajax', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/tvcmscategoryslider_list', $data));
	}
	protected function getForm() {

		$data['text_form'] 		= !isset($this->request->get['tvcmscategoryslidermain_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

		$data['text_left'] 		= $this->language->get('text_left');
		$data['text_center'] 	= $this->language->get('text_center');
		$data['text_right'] 	= $this->language->get('text_right');
		$data['text_hide'] 		= $this->language->get('text_hide');
		$data['text_setting'] 	= $this->language->get('text_setting');
		$data['entry_name'] 	= $this->language->get('entry_name');
		$data['entry_status'] 	= $this->language->get('entry_status');
		$data['entry_catimg'] 	= $this->language->get('entry_catimg');
		$data['entry_cat'] 		= $this->language->get('entry_cat');
		$data['entry_cat_name'] = $this->language->get('entry_cat_name');
		$data['entry_des']	 	= $this->language->get('entry_des');

		$data['category'] 		= $this->model_catalog_tvcmscategoryslider->getCategories();


		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['tvcmscategoryslidermain_image'])) {
			$data['error_tvcmscategoryslidermain_image'] = $this->error['tvcmscategoryslidermain_image'];
		} else {
			$data['error_tvcmscategoryslidermain_image'] = array();
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
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

		$data['breadcrumbs'] 	= array();

		$data['breadcrumbs'][] 	= array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/tvcmscategoryslider', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		if (!isset($this->request->get['tvcmscategoryslidermain_id'])) {
			$data['action'] = $this->url->link('extension/module/tvcmscategoryslider/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('extension/module/tvcmscategoryslider/edit', 'user_token=' . $this->session->data['user_token'] . '&tvcmscategoryslidermain_id=' . $this->request->get['tvcmscategoryslidermain_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('extension/module/tvcmscategoryslider', 'user_token=' . $this->session->data['user_token'] . $url, true);

		if (isset($this->request->get['tvcmscategoryslidermain_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$imageslider_info = $this->model_catalog_tvcmscategoryslider->getcateimageslidesigle($this->request->get['tvcmscategoryslidermain_id']);
		}
		
		$data['user_token'] = $this->session->data['user_token'];

		$this->load->model('localisation/language');

		$data['languages'] 	= $this->model_localisation_language->getLanguages();

		$this->load->model('tool/image');


		$status = $this->status();

		$data['status_record_form']				= $status['record_form'];
    	$data['status_category_title']			= $status['category_title'];
    	$data['status_image']					= $status['image'];
    	$data['status_title']					= $status['title'];
    	$data['status_short_description']		= $status['short_description'];

		
		if(!empty($data['status_record_form'])){
			if(isset($data['status_category_title'])){
				if (isset($this->request->post['tvcmscategoryslidermain_category_id'])) {
					$data['tvcmscategoryslidermain_category_id'] = $this->request->post['tvcmscategoryslidermain_category_id'];
				} elseif (!empty($imageslider_info)) {
					$data['tvcmscategoryslidermain_category_id'] = $imageslider_info[0]['tvcmscategoryslidermain_category_id'];
				} else {
					$data['tvcmscategoryslidermain_category_id'] = "";
				}
			}	
			if(isset($data['status_image'])){
				if (isset($this->request->post['tvcmscategoryslidermain_image'])) {
					$data['tvcmscategoryslidermain_image'] 		= $this->request->post['tvcmscategoryslidermain_image'];
				} elseif (!empty($imageslider_info)) {
					$data['tvcmscategoryslidermain_image'] 		= $imageslider_info[0]['tvcmscategoryslidermain_image'];
				} else {
					$data['tvcmscategoryslidermain_image'] 		= '';
				}
			}
			if(isset($data['status_title']) or isset($data['status_short_description'])){
				if (isset($this->request->post['tvcmscategoryslider'])) {
					$data['tvcmscategoryslider'] = $this->request->post['tvcmscategoryslider'];
				} elseif (!empty($imageslider_info)) {
					$editdata = array();
					foreach ($imageslider_info as $key => $value) {
						$editdata[$value['tvcmscategoryslidersublang_id']] = $value;
					}
					$data['tvcmscategoryslider'] = $editdata;
					$img = array();
					foreach ($editdata as $key => $value) {
						$data['img'][$key] =  $this->model_tool_image->resize($value['tvcmscategoryslidermain_image'], 100, 100);				
					}

				} else {
					$data['tvcmscategoryslider'] = array();
				}
			}
			if (isset($this->request->post['tvcmscategoryslidermain_status'])) {
				$data['tvcmscategoryslidermain_status'] 		= $this->request->post['tvcmscategoryslidermain_status'];
			} elseif (!empty($imageslider_info)) {
				$data['tvcmscategoryslidermain_status'] 		= $imageslider_info[0]['tvcmscategoryslidermain_status'];
			} else {
				$data['tvcmscategoryslidermain_status'] 		= "";
			}
			$default_image = $this->model_tool_image->resize('no_image.png', 100, 100);

			if (isset($this->request->post['tvcmscategoryslidermain_image']) && is_file(DIR_IMAGE . $this->request->post['tvcmscategoryslidermain_image'])) {
				$data['thumb'] = $this->model_tool_image->resize($this->request->post['tvcmscategoryslidermain_image'], 100, 100);
			} elseif (!empty($imageslider_info) && is_file(DIR_IMAGE . $imageslider_info[0]['tvcmscategoryslidermain_image'])) {
				$data['thumb'] = $this->model_tool_image->resize($imageslider_info[0]['tvcmscategoryslidermain_image'], 100, 100);
			} else {
				$data['thumb'] = $default_image;
			}

			$data['placeholder'] = $default_image;
		}	

		$data['header'] 		= $this->load->controller('common/header');
		$data['column_left'] 	= $this->load->controller('common/column_left');
		$data['footer'] 		= $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/tvcmscategoryslider_form', $data));
	}
	protected function validateForm() {

		if (!$this->user->hasPermission('modify', 'extension/module/tvcmscategoryslider')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		$status		 				= $this->status();
		$image 						= $status['image'];
		$record_form 				= $status['record_form'];

		if(!empty($image) && !empty($record_form)){
			if ((utf8_strlen($this->request->post['tvcmscategoryslidermain_image']) < 1) || (utf8_strlen($this->request->post['tvcmscategoryslidermain_image']) > 255)) {
				$this->error['tvcmscategoryslidermain_image'] = $this->language->get('error_image');
			}		
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}
	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'extension/module/tvcmscategoryslider')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
	protected function validateCopy() {
		if (!$this->user->hasPermission('modify', 'extension/module/tvcmscategoryslider')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
	protected function validatesetting() {
		$this->load->language('extension/module/tvcmscategoryslider');

		if (!$this->user->hasPermission('modify', 'extension/module/tvcmscategoryslider')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		return !$this->error;
	}

}
