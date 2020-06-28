<?php
class ControllerExtensionModuletvcmsblogcategory extends Controller {

	private $error = array();

	public function index() {
		$this->load->language('extension/module/tvcmsblogcategory');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/tvcmsblogcategory');

		$this->getList();
	}

	public function install(){
		$main 			= array();
		$main['name'] 	= "Blog Category";
		$main['status'] = 1;
		
		$this->load->model('setting/module');
		$this->load->model('localisation/language');
		$this->load->model('catalog/tvcmsblogcategory');

		$languages = $this->model_localisation_language->getLanguages();
        

		$this->model_setting_module->addModule('tvcmsblogcategory', $main);


        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "tvcmsblogcategory_main` 
		(   `tvcmsblogcategory_id` int(11) AUTO_INCREMENT,
            `tvcmsblogcategory_status` INT  NOT NULL ,
            `tvcmsblogcategory_pos` int(11),
            `tvcmsblogcategory_urlrewrite` VARCHAR(255),
            `tvcmsblogcategory_featureimage` VARCHAR(255),
            `tvcmsblogcategory_deafultcategory` int(11),
        PRIMARY KEY (`tvcmsblogcategory_id`)) ENGINE = InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "tvcmsblogcategory_sub` 
        (	`tvcmsblogcategory_sub_id` INT NOT NULL AUTO_INCREMENT,
            `tvcmsblogcategory_sublang_id` INT NOT NULL,
            `tvcmsblogcategory_id` INT NOT NULL,
            `tvcmsblogcategory_sub_title` VARCHAR(255),
            `tvcmsblogcategory_sub_categorydes` VARCHAR(255),
            `tvcmsblogcategory_sub_metatitle` TEXT,
            `tvcmsblogcategory_sub_metades` TEXT,
            `tvcmsblogcategory_sub_metakeyword` TEXT,
        PRIMARY KEY (`tvcmsblogcategory_sub_id`)) ENGINE = InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;");
       
		$num_of_data = 4;
		$sub 		 = array();
	 	for ($i = 1; $i<=$num_of_data; $i++) {
			$this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmsblogcategory_main`
			SET 
				tvcmsblogcategory_status 			= 1,	
				tvcmsblogcategory_featureimage 		= "catalog/themevolty/blog/blogimage/demo_img_'.$i.'.png",
				tvcmsblogcategory_deafultcategory 	= 1,
				tvcmsblogcategory_urlrewrite 		= "#",
				tvcmsblogcategory_pos 				= '.$i.'');
	        foreach ($languages as $value) {
	        	$this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmsblogcategory_sub`
				SET 
					tvcmsblogcategory_id					= '.$i.',
					tvcmsblogcategory_sub_title 		= "Fashion",
					tvcmsblogcategory_sub_categorydes 		= "",
					tvcmsblogcategory_sub_metatitle 		= "",
					tvcmsblogcategory_sub_metades 			= "",
					tvcmsblogcategory_sub_metakeyword 		= "",
					tvcmsblogcategory_sublang_id 			= '.$value['language_id'].'');
			}
    	}
	}

	public function uninstall(){
		$pre = DB_PREFIX;
		$this->db->query("DROP TABLE `{$pre}tvcmsblogcategory_main`");
		$this->db->query("DROP TABLE `{$pre}tvcmsblogcategory_sub`");
	}

	public function ajax() {
		$this->load->model('catalog/tvcmsblogcategory');
		$update_position 	= $this->request->get['action'];
		$position 			= $this->request->get['recordsArray'];
		$return_data 		= array();
		if ($update_position == 'update_position') {
		    $return_data['success'] = 'right';
		    $this->model_catalog_tvcmsblogcategory->updatePosition($position);
		    echo $res = implode("##", $return_data);
		}
	}	

	public function add() {
		$this->load->language('extension/module/tvcmsblogcategory');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/tvcmsblogcategory');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_tvcmsblogcategory->insertdata($this->request->post);

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
		$this->load->language('extension/module/tvcmsblogcategory');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/tvcmsblogcategory');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$this->model_catalog_tvcmsblogcategory->editblogpost($this->request->get['tvcmsblogcategory_id'], $this->request->post);

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
		$this->load->language('extension/module/tvcmsblogcategory');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/tvcmsblogcategory');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {

			foreach ($this->request->post['selected'] as $tvcmsblogcategorymain_id) {
				$this->model_catalog_tvcmsblogcategory->deleteblogpost($tvcmsblogcategorymain_id);
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
		$this->load->language('extension/module/tvcmsblogcategory');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/tvcmsblogcategory');

		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $tvcmsblogcategorymain_id) {
				$this->model_catalog_tvcmsblogcategory->copyblogpost($tvcmsblogcategorymain_id);
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

	public function getList() {
		
		$this->load->model('setting/module');
		$this->load->model('catalog/tvcmsblogcategory');
		$this->load->model('localisation/language');
		$this->load->model('tool/image');
		$this->load->language('extension/module/tvcmsblogcategory');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validatesetting()) {

			if (!isset($this->request->get['module_id'])) {
				$this->model_setting_module->addModule('tvcmsblogcategory', $this->request->post);
			} else {
				$this->model_setting_module->editModule($this->request->get['module_id'], $this->request->post);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}

		
		$data['setting_title'] 			= $this->language->get('setting_title');
		$data['setting_block'] 			= $this->language->get('setting_block');
		$data['text_list'] 				= $this->language->get('text_list');
		$data['text_add'] 				= $this->language->get('text_add');
		$data['text_edit'] 				= $this->language->get('text_edit');
		$data['text_extension'] 		= $this->language->get('text_extension');
		$data['entry_name'] 			= $this->language->get('entry_name');
		$data['entry_title'] 			= $this->language->get('entry_title');
		$data['entry_short_des'] 		= $this->language->get('entry_short_des');
		$data['entry_des'] 				= $this->language->get('entry_des');
		$data['entry_image'] 			= $this->language->get('entry_image');
		$data['entry_block_title'] 		= $this->language->get('entry_block_title');
		$data['entry_block_short_des'] 	= $this->language->get('entry_block_short_des');
		$data['entry_block_btn_cap'] 	= $this->language->get('entry_block_btn_cap');
		$data['entry_block_des'] 		= $this->language->get('entry_block_des');
		$data['entry_block_link'] 		= $this->language->get('entry_block_link');
		$data['entry_block_link_des'] 	= $this->language->get('entry_block_link_des');
		$data['entry_block_image'] 		= $this->language->get('entry_block_image');
		$data['entry_block_image_des'] 	= $this->language->get('entry_block_image_des');
		$data['entry_title'] 			= $this->language->get('entry_title');
		$data['entry_image'] 			= $this->language->get('entry_image');
		$data['entry_status'] 			= $this->language->get('entry_status');
		$data['entry_status_des'] 		= $this->language->get('entry_status_des');
	
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
				'href' => $this->url->link('extension/module/tvcmsblogcategory', 'user_token=' . $this->session->data['user_token'] . $url, true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/tvcmsblogcategory', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}

		if (!isset($this->request->get['module_id'])) {
			$data['mainaction'] = $this->url->link('extension/module/tvcmsblogcategory/getList', 'user_token=' . $this->session->data['user_token'] . $url, true);
		} else {
			$data['mainaction'] = $this->url->link('extension/module/tvcmsblogcategory/getList', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
		}
		
		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_setting_module->getModule($this->request->get['module_id']);
		}

		$data['add'] 	= $this->url->link('extension/module/tvcmsblogcategory/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['copy'] 	= $this->url->link('extension/module/tvcmsblogcategory/copy', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['delete'] = $this->url->link('extension/module/tvcmsblogcategory/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);

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

		$no_image 			= $this->model_tool_image->resize('no_image.png', 100, 100);
		$data['languages'] 	= $this->model_localisation_language->getLanguages();

		

    	if (isset($this->request->post['tvcmsblogcategory_main'])) {
			$data['tvcmsblogcategory_main'] = $this->request->post['tvcmsblogcategory_main'];
			
		} elseif (!empty($module_info['tvcmsblogcategory_main'])) {
			$data['tvcmsblogcategory_main'] = $module_info['tvcmsblogcategory_main'];
			
		} else {
			$data['tvcmsblogcategory_main'] = array();
			
		}
		
		$filter_data = array(
			'filter_name'	  => $filter_name,
			'filter_status'   => $filter_status,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'           => $this->config->get('config_limit_admin')
		);

		$this->load->model('tool/image');

		$blogpost_total = $this->model_catalog_tvcmsblogcategory->getTotalblogpost($filter_data);

		$results = $this->model_catalog_tvcmsblogcategory->getblogpost($filter_data);
		foreach ($results as $result) {
			
			$data['blogpostslist'][] = array(
				'id' 		=> $result['tvcmsblogcategory_id'],
				'title'     => $result['tvcmsblogcategory_sub_title'],
				'excerpt'  	=> $result['tvcmsblogcategory_sub_categorydes'],
				'url'   	=> $result['tvcmsblogcategory_urlrewrite'],
				'position'  => $result['tvcmsblogcategory_pos'],
				'status'    => $result['tvcmsblogcategory_status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'edit'      => $this->url->link('extension/module/tvcmsblogcategory/edit', 'user_token=' . $this->session->data['user_token'] . '&tvcmsblogcategory_id=' . $result['tvcmsblogcategory_id'] . $url, true)
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


		$data['sort_tvcmsblogcategory_sub_title'] = $this->url->link('extension/module/tvcmsblogcategory', 'user_token=' . $this->session->data['user_token'] . '&sort=pd.tvcmsblogcategory_sub_title' . $url, true);

		$data['sort_tvcmsblogcategory_sub_categorydes'] = $this->url->link('extension/module/tvcmsblogcategory', 'user_token=' . $this->session->data['user_token'] . '&sort=pd.tvcmsblogcategory_sub_categorydes' . $url, true);

		$data['sort_tvcmsblogcategory_urlrewrite'] = $this->url->link('extension/module/tvcmsblogcategory', 'user_token=' . $this->session->data['user_token'] . '&sort=pd.tvcmsblogcategory_urlrewrite' . $url, true);

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
		$data['ajaxlink'] = $this->url->link('extension/module/tvcmsblogcategory/ajax', 'user_token=' . $this->session->data['user_token'] . $url, true);

		$pagination 			= new Pagination();
		$pagination->total 		= $blogpost_total;
		$pagination->page 		= $page;
		$pagination->limit 		= $this->config->get('config_limit_admin');
		$pagination->url 		= $this->url->link('extension/module/tvcmsblogcategory', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

		$data['pagination'] 	= $pagination->render();

		$data['results'] 		= sprintf($this->language->get('text_pagination'), ($blogpost_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($blogpost_total - $this->config->get('config_limit_admin'))) ? $blogpost_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $blogpost_total, ceil($blogpost_total / $this->config->get('config_limit_admin')));

		$data['filter_name'] 	= $filter_name;
		$data['filter_status'] 	= $filter_status;
		$data['sort'] 			= $sort;
		$data['order'] 			= $order;
		$data['header'] 		= $this->load->controller('common/header');
		$data['column_left'] 	= $this->load->controller('common/column_left');
		$data['footer'] 		= $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/tvcmsblogcategory_list', $data));
	}

	protected function getForm() {

		$data['text_form'] 				= !isset($this->request->get['tvcmsblogcategory_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

		$data['entry_title'] 			= $this->language->get('entry_title');
		$data['entry_short_des'] 		= $this->language->get('entry_short_des');
		$data['entry_des'] 				= $this->language->get('entry_des');
		$data['entry_block_link'] 		= $this->language->get('entry_block_link');
		$data['entry_image'] 			= $this->language->get('entry_image');
		$data['entry_status'] 			= $this->language->get('entry_status');
		$data['entry_action'] 			= $this->language->get('entry_action');


		if (isset($this->error['warning'])) {
			$data['error_warning'] 	= $this->error['warning'];
		} else {
			$data['error_warning'] 	= '';
		}

		if (isset($this->error['tvcmsblogcategory_sub_title'])) {
			$data['error_title'] 	= $this->error['tvcmsblogcategory_sub_title'];
		} else {
			$data['error_title'] 	= array();
		}
		


		$url 						= '';

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

		$data['breadcrumbs']   = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/tvcmsblogcategory', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);


		if (!isset($this->request->get['tvcmsblogcategory_id'])) {
			$data['action'] = $this->url->link('extension/module/tvcmsblogcategory/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('extension/module/tvcmsblogcategory/edit', 'user_token=' . $this->session->data['user_token'] . '&tvcmsblogcategory_id=' . $this->request->get['tvcmsblogcategory_id'] . $url, true);
		}

		$data['cancel'] 	= $this->url->link('extension/module/tvcmsblogcategory', 'user_token=' . $this->session->data['user_token'] . $url, true);

		if (isset($this->request->get['tvcmsblogcategory_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$blogpost_info  = $this->model_catalog_tvcmsblogcategory->getblogpostsigle($this->request->get['tvcmsblogcategory_id']);
		}
		
		$data['user_token'] = $this->session->data['user_token'];

		$this->load->model('localisation/language');
		$this->load->model('tool/image');

		$data['languages'] 		= $this->model_localisation_language->getLanguages();

		$data['placeholder'] 	= $this->model_tool_image->resize('no_image.png', 100, 100);

		
		

		if (isset($this->request->post['tvcmsblogcategory_featureimage'])) {
			$data['tvcmsblogcategory_featureimage'] 	= $this->request->post['tvcmsblogcategory_featureimage'];
			$data['featureimage']					= $this->model_tool_image->resize($data['tvcmsblogcategory_featureimage'], 100, 100);				
		} elseif (!empty($blogpost_info[0]['tvcmsblogcategory_featureimage'])) {
			$data['featureimage'] = $this->model_tool_image->resize($blogpost_info[0]['tvcmsblogcategory_featureimage'], 100, 100);				
			$data['tvcmsblogcategory_featureimage'] 	= $blogpost_info[0]['tvcmsblogcategory_featureimage'];
		} else {
			$data['tvcmsblogcategory_featureimage'] 	= "";
			$data['featureimage']					= $data['placeholder'];
		}
		if (isset($this->request->post['tvcmsblogcategory_urlrewrite'])) {
			$data['tvcmsblogcategory_urlrewrite'] = $this->request->post['tvcmsblogcategory_urlrewrite'];
		} elseif (!empty($blogpost_info[0]['tvcmsblogcategory_urlrewrite'])) {
			$data['tvcmsblogcategory_urlrewrite'] = $blogpost_info[0]['tvcmsblogcategory_urlrewrite'];
		} else {
			$data['tvcmsblogcategory_urlrewrite'] = "";
		}

		$data['category_info']  = $this->model_catalog_tvcmsblogcategory->getblogpost();
		if (isset($this->request->post['tvcmsblogcategory_deafultcategory'])) {
			$data['tvcmsblogcategory_deafultcategory'] = $this->request->post['tvcmsblogcategory_deafultcategory'];
		} elseif (!empty($blogpost_info[0]['tvcmsblogcategory_deafultcategory'])) {
			$data['tvcmsblogcategory_deafultcategory'] = $blogpost_info[0]['tvcmsblogcategory_deafultcategory'];
		} else {
			$data['tvcmsblogcategory_deafultcategory'] = "";
		}
		
		
		if (isset($this->request->post['tvcmsblogcategory_status'])) {
			$data['tvcmsblogcategory_status'] = $this->request->post['tvcmsblogcategory_status'];
		} elseif (!empty($blogpost_info[0]['tvcmsblogcategory_status'])) {
			$data['tvcmsblogcategory_status'] = $blogpost_info[0]['tvcmsblogcategory_status'];
		} else {
			$data['tvcmsblogcategory_status'] = "";
		}
		


		if (isset($this->request->post['tvcmsblogcategoryform'])) {
			$data['tvcmsblogcategoryform'] = $this->request->post['tvcmsblogcategoryform'];
		} elseif (!empty($blogpost_info)) {
			foreach ($blogpost_info as $key => $value) {
				$editdata[$value['tvcmsblogcategory_sublang_id']] = $value;
				$data['tvcmsblogcategoryform'] = $editdata;
			}
		} else {
			$data['tvcmsblogcategoryform'] = array();
		}

		$data['header'] 		= $this->load->controller('common/header');
		$data['column_left'] 	= $this->load->controller('common/column_left');
		$data['footer'] 		= $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/tvcmsblogcategory_form', $data));
	}

	protected function validateForm() {

		if (!$this->user->hasPermission('modify', 'extension/module/tvcmsblogcategory')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		foreach ($this->request->post['tvcmsblogcategoryform'] as $language_id => $value) {
			if ((utf8_strlen($value['tvcmsblogcategory_sub_title']) < 1) || (utf8_strlen($value['tvcmsblogcategory_sub_title']) > 255)) {
				$this->error['tvcmsblogcategory_sub_title'][$language_id] = $this->language->get('error_title');
			}	
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'extension/module/tvcmsblogcategory')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}

	protected function validateCopy() {
		if (!$this->user->hasPermission('modify', 'extension/module/tvcmsblogcategory')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	protected function validatesetting() {
		$this->load->language('extension/module/tvcmsblogcategory');
		if (!$this->user->hasPermission('modify', 'extension/module/tvcmsblogcategory')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		return !$this->error;
	}
}
