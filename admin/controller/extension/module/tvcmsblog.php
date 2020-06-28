<?php
class ControllerExtensionModuletvcmsblog extends Controller {

	private $error = array();

	public function index() {
		$this->load->language('extension/module/tvcmsblog');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/tvcmsblog');

		$this->getList();
	}

	public function install(){
		$main 			= array();
		$main['name'] 	= "Blog Posts";
		$main['status'] = 1;
		
		$this->load->model('setting/module');
		$this->load->model('localisation/language');
		$this->load->model('catalog/tvcmsblog');

		$languages = $this->model_localisation_language->getLanguages();
        
        foreach ($languages as $value) {
			$main['tvcmsblog_main'][$value['language_id']] = array('title' => "Latest Blog",'subtitle' => "Mirum est notare quam littera gothica, quam nunc putamus parum claram anteposuerit litterarum formas.",'des' => "");
		}

		$this->model_setting_module->addModule('tvcmsblog', $main);

		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "tvcmsblog_comment` 
		(   `tvcmsblog_comment_id` int(11) AUTO_INCREMENT,
            `tvcmsblog_id` INT NOT NULL,
		    `tvcmsblog_comment_name` VARCHAR(255),
		    `tvcmsblog_comment_email` VARCHAR(255),
		    `tvcmsblog_comment_website_url` VARCHAR(255),
            `tvcmsblog_comment_subject` VARCHAR(255),
            `tvcmsblog_comment_comment` TEXT,
		    `tvcmsblog_comment_adddate` datetime,
            `tvcmsblog_comment_pos` int(11),
            `tvcmsblog_comment_status` INT NOT NULL ,
        PRIMARY KEY (`tvcmsblog_comment_id`)) ENGINE = InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "tvcmsblog_main` 
		(   `tvcmsblog_main_id` int(11) AUTO_INCREMENT,
            `tvcmsblog_main_status` INT  NOT NULL ,
            `tvcmsblog_main_pos` int(11),
            `tvcmsblog_main_posttype` VARCHAR(255),
            `tvcmsblog_main_featureimage` VARCHAR(255),
            `tvcmsblog_main_deafultcategory` int(11),
            `tvcmsblog_main_urlrewrite` VARCHAR(255),
            `tvcmsblog_main_video` VARCHAR(255),
            `tvcmsblog_main_commentstatus` int(11),
            `tvcmsblog_main_adddate` datetime,
        PRIMARY KEY (`tvcmsblog_main_id`)) ENGINE = InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "tvcmsblog_sub` 
        (	`tvcmsblog_sub_id` INT NOT NULL AUTO_INCREMENT,
            `tvcmsblog_sublang_id` INT NOT NULL,
            `tvcmsblog_main_id` INT NOT NULL,
            `tvcmsblog_sub_title` VARCHAR(255),
            `tvcmsblog_sub_excerpt` VARCHAR(255),
            `tvcmsblog_sub_content` VARCHAR(255),
            `tvcmsblog_sub_metatitle` TEXT,
            `tvcmsblog_sub_metatag` TEXT,
            `tvcmsblog_sub_metades` TEXT,
            `tvcmsblog_sub_metakeyword` TEXT,
        PRIMARY KEY (`tvcmsblog_sub_id`)) ENGINE = InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "tvcmsblog_gallery` 
		(   `tvcmsblog_gallery_id` int(11) AUTO_INCREMENT,
            `tvcmsblog_id` INT NOT NULL,
		    `image` VARCHAR(255),
        PRIMARY KEY (`tvcmsblog_gallery_id`)) ENGINE = InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;");

       
		$num_of_data = 5;
		$sub 		 = array();
	 	for ($i = 1; $i<=$num_of_data; $i++) {
			$this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmsblog_main`
			SET 
				tvcmsblog_main_status 			= 1,	
				tvcmsblog_main_posttype 		= "standrad",
				tvcmsblog_main_featureimage 	= "catalog/themevolty/blog/blogimage/demo_img_'.$i.'.jpg",
				tvcmsblog_main_deafultcategory 	= 1,
				tvcmsblog_main_urlrewrite 		= "this-is-secound-post-for-hrxcmsblog",
				tvcmsblog_main_video 			= "",
				tvcmsblog_main_commentstatus 	= 1,
				tvcmsblog_main_adddate 			= NOW(),
				tvcmsblog_main_pos 				= '.$i.'');
	        foreach ($languages as $value) {
	        	$this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmsblog_sub`
				SET 
					tvcmsblog_main_id			= '.$i.',
					tvcmsblog_sub_title 		= "This is Secound Post For Template",
					tvcmsblog_sub_excerpt 		= "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.",
					tvcmsblog_sub_content 		= "Lorem ipsum dolor sit amet, consectetur adipisicing elit, do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim adminim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip commodo consequat. Duis aute irure dolor in rep rehenderit. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiumod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipisicing elit, do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipisicing elit, do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim adminim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip commodo consequat. Duis aute irure dolor in rep rehenderit. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiumod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipisicing elit, do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipisicing elit, do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim adminim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip commodo consequat. Duis aute irure dolor in rep rehenderit. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiumod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipisicing elit, do eiusmod tempor cididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipisicing elit, do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim adminim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip commodo consequat. Duis aute irure dolor in rep rehenderit. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiumod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipisicing elit, do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipisicing elit, do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim adminim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip commodo consequat. Duis aute irure dolor in rep rehenderit. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiumod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipisicing elit, do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipisicing elit, do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim adminim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip commodo consequat. Duis aute irure dolor in rep rehenderit. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiumod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipisicing elit, do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
					tvcmsblog_sub_metatitle 	= "This is Secound Post For Template",
					tvcmsblog_sub_metatag 		= "",
					tvcmsblog_sub_metades 		= "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.",
					tvcmsblog_sub_metakeyword 	= "Lorem,Ipsum,simply,dummy",
					tvcmsblog_sublang_id 		= '.$value['language_id'].'');
			}
    	}
	}

	public function uninstall(){
		$pre = DB_PREFIX;
		$this->db->query("DROP TABLE `{$pre}tvcmsblog_comment`");
		$this->db->query("DROP TABLE `{$pre}tvcmsblog_main`");
		$this->db->query("DROP TABLE `{$pre}tvcmsblog_sub`");
		$this->db->query("DROP TABLE `{$pre}tvcmsblog_gallery`");
	}

	public function ajax() {
		$this->load->model('catalog/tvcmsblog');
		$update_position 	= $this->request->get['action'];
		$position 			= $this->request->get['recordsArray'];
		$return_data 		= array();
		if ($update_position == 'update_position') {
		    $return_data['success'] = 'right';
		    $this->model_catalog_tvcmsblog->updatePosition($position);
		    echo $res = implode("##", $return_data);
		}
	}	

	public function add() {
		$this->load->language('extension/module/tvcmsblog');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/tvcmsblog');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_tvcmsblog->insertdata($this->request->post);

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
		$this->load->language('extension/module/tvcmsblog');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/tvcmsblog');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$this->model_catalog_tvcmsblog->editblogpost($this->request->get['tvcmsblog_main_id'], $this->request->post);

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
		$this->load->language('extension/module/tvcmsblog');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/tvcmsblog');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {

			foreach ($this->request->post['selected'] as $tvcmsblogmain_id) {
				$this->model_catalog_tvcmsblog->deleteblogpost($tvcmsblogmain_id);
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
		$this->load->language('extension/module/tvcmsblog');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/tvcmsblog');

		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $tvcmsblogmain_id) {
				$this->model_catalog_tvcmsblog->copyblogpost($tvcmsblogmain_id);
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
		$this->load->model('catalog/tvcmsblog');
		$this->load->model('localisation/language');
		$this->load->model('tool/image');
		$this->load->language('extension/module/tvcmsblog');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validatesetting()) {

			if (!isset($this->request->get['module_id'])) {
				$this->model_setting_module->addModule('tvcmsblog', $this->request->post);
			} else {
				$this->model_setting_module->editModule($this->request->get['module_id'], $this->request->post);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}

		
		$data['setting_main_title'] 			= $this->language->get('setting_main_title');
		$data['setting_main_block'] 			= $this->language->get('setting_main_block');
		$data['text_list'] 						= $this->language->get('text_list');
		$data['text_add'] 						= $this->language->get('text_add');
		$data['text_edit'] 						= $this->language->get('text_edit');
		$data['text_extension'] 				= $this->language->get('text_extension');
		$data['entry_name'] 			        = $this->language->get('entry_name');
		$data['entry_main_title'] 				= $this->language->get('entry_main_title');
		$data['entry_main_short_des'] 			= $this->language->get('entry_main_short_des');
		$data['entry_main_des'] 				= $this->language->get('entry_main_des');
		$data['entry_main_image'] 				= $this->language->get('entry_main_image');
		$data['entry_main_block_title'] 		= $this->language->get('entry_main_block_title');
		$data['entry_main_block_short_des'] 	= $this->language->get('entry_main_block_short_des');
		$data['entry_main_block_des'] 			= $this->language->get('entry_main_block_des');
		$data['entry_main_block_btn_cap'] 		= $this->language->get('entry_main_block_btn_cap');
		$data['entry_main_block_link'] 			= $this->language->get('entry_main_block_link');
		$data['entry_main_block_link_des'] 		= $this->language->get('entry_main_block_link_des');
		$data['entry_main_block_image'] 		= $this->language->get('entry_main_block_image');
		$data['entry_main_block_image_des'] 	= $this->language->get('entry_main_block_image_des');
		$data['entry_title'] 					= $this->language->get('entry_title');
		$data['entry_image'] 					= $this->language->get('entry_image');
		$data['entry_status'] 					= $this->language->get('entry_status');
		$data['entry_status_des'] 				= $this->language->get('entry_status_des');
	
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
				'href' => $this->url->link('extension/module/tvcmsblog', 'user_token=' . $this->session->data['user_token'] . $url, true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/tvcmsblog', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}

		if (!isset($this->request->get['module_id'])) {
			$data['mainaction'] = $this->url->link('extension/module/tvcmsblog/getList', 'user_token=' . $this->session->data['user_token'] . $url, true);
		} else {
			$data['mainaction'] = $this->url->link('extension/module/tvcmsblog/getList', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
		}
		
		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_setting_module->getModule($this->request->get['module_id']);
		}

		$data['add'] 	= $this->url->link('extension/module/tvcmsblog/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['copy'] 	= $this->url->link('extension/module/tvcmsblog/copy', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['delete'] = $this->url->link('extension/module/tvcmsblog/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);

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

		

    	if (isset($this->request->post['tvcmsblog_main'])) {
			$data['tvcmsblog_main'] = $this->request->post['tvcmsblog_main'];
			
		} elseif (!empty($module_info['tvcmsblog_main'])) {
			$data['tvcmsblog_main'] = $module_info['tvcmsblog_main'];
			
		} else {
			$data['tvcmsblog_main'] = array();
			
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

		$blogpost_total = $this->model_catalog_tvcmsblog->getTotalblogpost($filter_data);

		$results = $this->model_catalog_tvcmsblog->getblogpost($filter_data);
		foreach ($results as $result) {
			
			$data['blogpostslist'][] = array(
				'id' 		=> $result['tvcmsblog_main_id'],
				'title'     => $result['tvcmsblog_sub_title'],
				'excerpt'  	=> $result['tvcmsblog_sub_excerpt'],
				'url'   	=> $result['tvcmsblog_main_urlrewrite'],
				'position'  => $result['tvcmsblog_main_pos'],
				'status'    => $result['tvcmsblog_main_status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'edit'      => $this->url->link('extension/module/tvcmsblog/edit', 'user_token=' . $this->session->data['user_token'] . '&tvcmsblog_main_id=' . $result['tvcmsblog_main_id'] . $url, true)
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


		$data['sort_tvcmsblog_sub_title'] = $this->url->link('extension/module/tvcmsblog', 'user_token=' . $this->session->data['user_token'] . '&sort=pd.tvcmsblog_sub_title' . $url, true);

		$data['sort_tvcmsblog_sub_excerpt'] = $this->url->link('extension/module/tvcmsblog', 'user_token=' . $this->session->data['user_token'] . '&sort=pd.tvcmsblog_sub_excerpt' . $url, true);

		$data['sort_tvcmsblog_main_urlrewrite'] = $this->url->link('extension/module/tvcmsblog', 'user_token=' . $this->session->data['user_token'] . '&sort=pd.tvcmsblog_main_urlrewrite' . $url, true);

		
		

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
		$data['ajaxlink'] = $this->url->link('extension/module/tvcmsblog/ajax', 'user_token=' . $this->session->data['user_token'] . $url, true);

		$pagination 		= new Pagination();
		$pagination->total 	= $blogpost_total;
		$pagination->page 	= $page;
		$pagination->limit 	= $this->config->get('config_limit_admin');
		$pagination->url 	= $this->url->link('extension/module/tvcmsblog', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

		$data['pagination'] 	= $pagination->render();

		$data['results'] 		= sprintf($this->language->get('text_pagination'), ($blogpost_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($blogpost_total - $this->config->get('config_limit_admin'))) ? $blogpost_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $blogpost_total, ceil($blogpost_total / $this->config->get('config_limit_admin')));

		$data['filter_name'] 	= $filter_name;
		$data['filter_status'] 	= $filter_status;
		$data['sort'] 			= $sort;
		$data['order'] 			= $order;
		$data['header'] 		= $this->load->controller('common/header');
		$data['column_left'] 	= $this->load->controller('common/column_left');
		$data['footer'] 		= $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/tvcmsblog_list', $data));
	}

	protected function getForm() {

		$data['text_form'] 				= !isset($this->request->get['tvcmsblog_main_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

		$data['entry_title'] 			= $this->language->get('entry_title');
		$data['entry_main_short_des'] 	= $this->language->get('entry_main_short_des');
		$data['entry_main_des'] 		= $this->language->get('entry_main_des');
		$data['entry_main_block_link'] 	= $this->language->get('entry_main_block_link');
		$data['entry_image'] 			= $this->language->get('entry_image');
		$data['entry_status'] 			= $this->language->get('entry_status');
		$data['entry_action'] 			= $this->language->get('entry_action');


		if (isset($this->error['warning'])) {
			$data['error_warning'] 	= $this->error['warning'];
		} else {
			$data['error_warning'] 	= '';
		}

		if (isset($this->error['tvcmsblog_sub_title'])) {
			$data['error_title'] 	= $this->error['tvcmsblog_sub_title'];
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
			'href' => $this->url->link('extension/module/tvcmsblog', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);


		if (!isset($this->request->get['tvcmsblog_main_id'])) {
			$data['action'] = $this->url->link('extension/module/tvcmsblog/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('extension/module/tvcmsblog/edit', 'user_token=' . $this->session->data['user_token'] . '&tvcmsblog_main_id=' . $this->request->get['tvcmsblog_main_id'] . $url, true);
		}

		$data['cancel'] 	= $this->url->link('extension/module/tvcmsblog', 'user_token=' . $this->session->data['user_token'] . $url, true);

		if (isset($this->request->get['tvcmsblog_main_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$blogpost_info  = $this->model_catalog_tvcmsblog->getblogpostsigle($this->request->get['tvcmsblog_main_id']);
		}
		
		$data['user_token'] = $this->session->data['user_token'];

		$this->load->model('localisation/language');
		$this->load->model('tool/image');

		$data['languages'] 		= $this->model_localisation_language->getLanguages();

		$data['placeholder'] 	= $this->model_tool_image->resize('no_image.png', 100, 100);

		
		if (isset($this->request->post['tvcmsblog_main_posttype'])) {
			$data['tvcmsblog_main_posttype'] = $this->request->post['tvcmsblog_main_posttype'];
		} elseif (!empty($blogpost_info[0]['tvcmsblog_main_posttype'])) {
			$data['tvcmsblog_main_posttype'] = $blogpost_info[0]['tvcmsblog_main_posttype'];
		} else {
			$data['tvcmsblog_main_posttype'] = "";
		}

		if (isset($this->request->post['tvcmsblog_main_featureimage'])) {
			$data['tvcmsblog_main_featureimage'] 	= $this->request->post['tvcmsblog_main_featureimage'];
			$data['featureimage']					= $this->model_tool_image->resize($data['tvcmsblog_main_featureimage'], 100, 100);				
		} elseif (!empty($blogpost_info[0]['tvcmsblog_main_featureimage'])) {
			$data['tvcmsblog_main_featureimage'] 	= $blogpost_info[0]['tvcmsblog_main_featureimage'];
			$data['featureimage'] 					= $this->model_tool_image->resize($blogpost_info[0]['tvcmsblog_main_featureimage'], 100, 100);		
		} else {
			$data['tvcmsblog_main_featureimage'] 	= "";
			$data['featureimage']					= $data['placeholder'];
		}
		if (isset($this->request->post['tvcmsblog_main_urlrewrite'])) {
			$data['tvcmsblog_main_urlrewrite'] = $this->request->post['tvcmsblog_main_urlrewrite'];
		} elseif (!empty($blogpost_info[0]['tvcmsblog_main_urlrewrite'])) {
			$data['tvcmsblog_main_urlrewrite'] = $blogpost_info[0]['tvcmsblog_main_urlrewrite'];
		} else {
			$data['tvcmsblog_main_urlrewrite'] = "";
		}

		$data['category_info']  = $this->model_catalog_tvcmsblog->getblogpostcategory();

		if (isset($this->request->post['tvcmsblog_main_deafultcategory'])) {
			$data['tvcmsblog_main_deafultcategory'] = $this->request->post['tvcmsblog_main_deafultcategory'];
		} elseif (!empty($blogpost_info[0]['tvcmsblog_main_deafultcategory'])) {
			$data['tvcmsblog_main_deafultcategory'] = $blogpost_info[0]['tvcmsblog_main_deafultcategory'];
		} else {
			$data['tvcmsblog_main_deafultcategory'] = "";
		}
		if (isset($this->request->post['tvcmsblog_main_video'])) {
			$data['tvcmsblog_main_video'] = $this->request->post['tvcmsblog_main_video'];
		} elseif (!empty($blogpost_info[0]['tvcmsblog_main_video'])) {
			$data['tvcmsblog_main_video'] = $blogpost_info[0]['tvcmsblog_main_video'];
		} else {
			$data['tvcmsblog_main_video'] = "";
		}
		if (isset($this->request->post['tvcmsblog_main_commentstatus'])) {
			$data['tvcmsblog_main_commentstatus'] = $this->request->post['tvcmsblog_main_commentstatus'];
		} elseif (!empty($blogpost_info[0]['tvcmsblog_main_commentstatus'])) {
			$data['tvcmsblog_main_commentstatus'] = $blogpost_info[0]['tvcmsblog_main_commentstatus'];
		} else {
			$data['tvcmsblog_main_commentstatus'] = "";
		}
		if (isset($this->request->post['tvcmsblog_main_status'])) {
			$data['tvcmsblog_main_status'] = $this->request->post['tvcmsblog_main_status'];
		} elseif (!empty($blogpost_info[0]['tvcmsblog_main_status'])) {
			$data['tvcmsblog_main_status'] = $blogpost_info[0]['tvcmsblog_main_status'];
		} else {
			$data['tvcmsblog_main_status'] = "";
		}
		if (isset($this->request->post['gallery'])) {
			$product_images = $this->request->post['gallery'];
		} elseif (isset($this->request->get['tvcmsblog_main_id'])) {
			$product_images = $this->model_catalog_tvcmsblog->getgalleryImages($this->request->get['tvcmsblog_main_id']);
		} else {
			$product_images = $data['gallery'] = array();
		}


		$data['gallerys'] = array();

		foreach ($product_images as $product_image) {
			if (is_file(DIR_IMAGE . $product_image['image'])) {
				$image = $product_image['image'];
				$thumb = $product_image['image'];
			} else {
				$image = '';
				$thumb = 'no_image.png';
			}

			$data['gallerys'][] = array(
				'image'      => $image,
				'thumb'      => $this->model_tool_image->resize($thumb, 100, 100)
			);
		}
		

		if (isset($this->request->post['tvcmsblogform'])) {
			$data['tvcmsblogform'] = $this->request->post['tvcmsblogform'];
		} elseif (!empty($blogpost_info)) {
			foreach ($blogpost_info as $key => $value) {
				$editdata[$value['tvcmsblog_sublang_id']] = $value;
				$data['tvcmsblogform'] = $editdata;
			}
		} else {
			$data['tvcmsblogform'] = array();
		}

		$data['header'] 		= $this->load->controller('common/header');
		$data['column_left'] 	= $this->load->controller('common/column_left');
		$data['footer'] 		= $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/tvcmsblog_form', $data));
	}

	protected function validateForm() {

		if (!$this->user->hasPermission('modify', 'extension/module/tvcmsblog')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		foreach ($this->request->post['tvcmsblogform'] as $language_id => $value) {
			if ((utf8_strlen($value['tvcmsblog_sub_title']) < 1) || (utf8_strlen($value['tvcmsblog_sub_title']) > 255)) {
				$this->error['tvcmsblog_sub_title'][$language_id] = $this->language->get('error_title');
			}	
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'extension/module/tvcmsblog')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}

	protected function validateCopy() {
		if (!$this->user->hasPermission('modify', 'extension/module/tvcmsblog')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	protected function validatesetting() {
		$this->load->language('extension/module/tvcmsblog');
		if (!$this->user->hasPermission('modify', 'extension/module/tvcmsblog')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		return !$this->error;
	}
}
