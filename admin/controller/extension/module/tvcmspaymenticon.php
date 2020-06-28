<?php
class ControllerExtensionModuletvcmspaymenticon extends Controller {

	private $error = array();

	public function index() {
		$this->load->language('extension/module/tvcmspaymenticon');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/tvcmspaymenticon');
		
		$this->getList();
	}
	public function install(){

		$main 			= array();
		$main['name'] 	= "Payment Icon";
		$main['status'] = 1;

		$this->load->model('setting/module');
		$this->load->model('localisation/language');
		$this->load->model('catalog/tvcmspaymenticon');

		$languages = $this->model_localisation_language->getLanguages();

        foreach ($languages as $value) {
        	$main['tvcmspaymenticon_main'][$value['language_id']] =  array('main_img'=>"catalog/themevolty/paymenticon/demo_main_img.jpg",'maintitle'=>"Main Title",'main_short_des' => "Short Description",'main_des' => "Description");
		}

		$this->model_setting_module->addModule('tvcmspaymenticon', $main);
		
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "tvcmspaymenticonmain` 
		(   `tvcmspaymenticonmain_id` int(11) AUTO_INCREMENT,
            `tvcmspaymenticonmain_pos` int(11),
            `tvcmspaymenticonmain_image` VARCHAR(255),
            `tvcmspaymenticonmain_link` VARCHAR(255),
            `tvcmspaymenticon_status` int(11),
        PRIMARY KEY (`tvcmspaymenticonmain_id`)) ENGINE = InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "tvcmspaymenticonsub` 
        (	`tvcmspaymenticonsub_id` INT NOT NULL AUTO_INCREMENT ,
            `tvcmspaymenticonmain_id` INT NOT NULL ,
            `tvcmspaymenticonsublang_id` INT NOT NULL ,
            `tvcmspaymenticonsub_title` VARCHAR(255),
        PRIMARY KEY (`tvcmspaymenticonsub_id`)) ENGINE = InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;");

		$num_of_data = 4;
		$sub 		 = array();

	 	for ($i = 1; $i<=$num_of_data; $i++) {
	            $this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmspaymenticonmain`
				SET  
				     tvcmspaymenticonmain_id 	= '.$i.',
					tvcmspaymenticonmain_link 	= "#",
					tvcmspaymenticonmain_image 	= "catalog/themevolty/paymenticon/demo_img_'.$i.'.png",
					tvcmspaymenticonmain_pos 	= '.$i.',
					tvcmspaymenticon_status 	= 1;');	
	        foreach ($languages as $value) {
				$this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmspaymenticonsub`
				SET 
						tvcmspaymenticonmain_id 	= '.$i.',
						tvcmspaymenticonsub_title 	= "Sub title'.$i.'",
						tvcmspaymenticonsublang_id 	= '.$value['language_id'].'');
			}
    	}
   	}
	public function uninstall(){
		$pre = DB_PREFIX;
		$this->db->query("DROP TABLE `{$pre}tvcmspaymenticonmain`");
		$this->db->query("DROP TABLE `{$pre}tvcmspaymenticonsub`");
	}
	protected function status(){
		return $this->Tvcmsthemevoltystatus->paymenticonsatus();
	}

	public function ajax() {
		$this->load->model('catalog/tvcmspaymenticon');
		$update_position 	= $this->request->get['action'];
		$position 			= $this->request->get['recordsArray'];
		$return_data 		= array();
		if ($update_position == 'update_position') {
		    $return_data['success'] = 'right';
		    $this->model_catalog_tvcmspaymenticon->updatePosition($position);
		    echo $res = implode("##", $return_data);
		}
	}	

	public function add() {
		$this->load->language('extension/module/tvcmspaymenticon');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/tvcmspaymenticon');
		if ($this->request->server['REQUEST_METHOD'] == 'POST')  {
			$this->model_catalog_tvcmspaymenticon->insertdata($this->request->post);

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
		$this->load->language('extension/module/tvcmspaymenticon');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/tvcmspaymenticon');

		if ($this->request->server['REQUEST_METHOD'] == 'POST')  {
			
			$this->model_catalog_tvcmspaymenticon->edittestimonial($this->request->get['tvcmspaymenticonmain_id'], $this->request->post);

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
		$this->load->language('extension/module/tvcmspaymenticon');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/tvcmspaymenticon');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $tvcmspaymenticonmain_id) {
				$this->model_catalog_tvcmspaymenticon->deletetestimonial($tvcmspaymenticonmain_id);
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
		$this->load->language('extension/module/tvcmspaymenticon');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/tvcmspaymenticon');

		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $tvcmspaymenticonmain_id) {
				$this->model_catalog_tvcmspaymenticon->copytestimonial($tvcmspaymenticonmain_id);
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
		$this->load->model('catalog/tvcmspaymenticon');
		$this->load->model('localisation/language');
		$this->load->model('tool/image');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validatesetting()) {

			if (!isset($this->request->get['module_id'])) {
				$this->model_setting_module->addModule('tvcmspaymenticon', $this->request->post);
			} else {
				$this->model_setting_module->editModule($this->request->get['module_id'], $this->request->post);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}

		$this->load->language('extension/module/tvcmspaymenticon');

		$data['column_main_title'] 		= $this->language->get('column_main_title');
		$data['column_main_short_des'] 	= $this->language->get('column_main_short_des');
		$data['column_action'] 			= $this->language->get('column_action');
		$data['column_link'] 			= $this->language->get('column_link');
		$data['column_title'] 			= $this->language->get('column_title');
		$data['column_des'] 			= $this->language->get('column_des');
		$data['entry_namee'] 			= $this->language->get('entry_namee');
		$data['column_status'] 			= $this->language->get('column_status');
		$data['entry_main_img'] 		= $this->language->get('entry_main_img');
		$data['entry_short_des'] 		= $this->language->get('entry_short_des');


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
				'href' => $this->url->link('extension/module/tvcmspaymenticon', 'user_token=' . $this->session->data['user_token'] . $url, true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/tvcmspaymenticon', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}

		if (!isset($this->request->get['module_id'])) {
			$data['mainaction'] = $this->url->link('extension/module/tvcmspaymenticon/getList', 'user_token=' . $this->session->data['user_token'] . $url, true);
		} else {
			$data['mainaction'] = $this->url->link('extension/module/tvcmspaymenticon/getList', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
		}

		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_setting_module->getModule($this->request->get['module_id']);
		}
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

		$status = $this->status();

		$data['main_form'] 				= $status['main_form'];
    	$data['main_title'] 			= $status['main_title'];
    	$data['main_short_description'] = $status['main_short_description'];
    	$data['main_description'] 		= $status['main_description'];
    	$data['main_image']				= $status['main_image'];
    	$data['record_form'] 			= $status['record_form'];
    	$data['title'] 					= $status['title'];
    	$data['image'] 					= $status['image'];
    	$data['link'] 					= $status['link'];
		if(!empty($data['main_form'])){
			if (isset($this->request->post['tvcmspaymenticon_main'])) {
				$data['tvcmspaymenticon_main'] = $this->request->post['tvcmspaymenticon_main'];
				foreach ($this->request->post['tvcmspaymenticon_main'] as $key => $value) {
					if($value['main_img']){
						$data['img'][$key] =  $this->model_tool_image->resize($value['main_img'], 100, 100);				
					}else{
						$data['img'][$key] =  $this->model_tool_image->resize('no_image.png', 100, 100);
					}
				}
			} elseif (!empty($module_info)) {
				$data['tvcmspaymenticon_main'] = $module_info['tvcmspaymenticon_main'];
				foreach ($data['tvcmspaymenticon_main'] as $key => $value) {
					$data['img'][$key] =  $this->model_tool_image->resize($value['main_img'], 100, 100);				
				}
			} else {
				$data['tvcmspaymenticon_main'] = array();
				foreach ($data['languages'] as $key => $value) {
					$data['img'][$value['language_id']] =  $this->model_tool_image->resize('no_image.png', 100, 100);
				}
			}
		}
		$data['add'] 	= $this->url->link('extension/module/tvcmspaymenticon/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['copy'] 	= $this->url->link('extension/module/tvcmspaymenticon/copy', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['delete'] = $this->url->link('extension/module/tvcmspaymenticon/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);

		$data['imagesliders'] = array();

		$filter_data = array(
			'filter_name'	  => $filter_name,
			'filter_status'   => $filter_status,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'           => $this->config->get('config_limit_admin')
		);

		$imageslider_total = $this->model_catalog_tvcmspaymenticon->getTotaltestimonial($filter_data);

		$results = $this->model_catalog_tvcmspaymenticon->gettestimonial($filter_data);

		foreach ($results as $result) {
			
			$data['imagesliders'][] = array(
				'id' 			=> $result['tvcmspaymenticonmain_id'],
				'lang_id'   	=> (int)$this->config->get('config_language_id'),
				'title'     	=> $result['tvcmspaymenticonsub_title'],
				'image'			=> $this->model_tool_image->resize($result['tvcmspaymenticonmain_image'], 100, 100),
				'link'    		=> $result['tvcmspaymenticonmain_link'],
				'status'    	=> $result['tvcmspaymenticon_status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'edit'     		=> $this->url->link('extension/module/tvcmspaymenticon/edit', 'user_token=' . $this->session->data['user_token'] . '&tvcmspaymenticonmain_id=' . $result['tvcmspaymenticonmain_id'] . $url, true)
			);
			 
		}
		
		$data['user_token'] 		= $this->session->data['user_token'];

		if (isset($this->error['warning'])) {
			$data['error_warning'] 	= $this->error['warning'];
		} else {
			$data['error_warning'] 	= '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] 		= $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] 		= '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] 		= (array)$this->request->post['selected'];
		} else {
			$data['selected'] 		= array();
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

		$data['sort_tvcmspaymenticonsub_title'] = $this->url->link('extension/module/tvcmspaymenticon', 'user_token=' . $this->session->data['user_token'] . '&sort=pd.tvcmspaymenticonsub_title' . $url, true);

		$data['sort_tvcmspaymenticonmain_link'] = $this->url->link('extension/module/tvcmspaymenticon', 'user_token=' . $this->session->data['user_token'] . '&sort=p.tvcmspaymenticonmain_link' . $url, true);

		$data['sort_tvcmspaymenticonmain_class_name'] = $this->url->link('extension/module/tvcmspaymenticon', 'user_token=' . $this->session->data['user_token'] . '&sort=p.tvcmspaymenticonmain_class_name' . $url, true);

		$data['sort_tvcmspaymenticon_status'] = $this->url->link('extension/module/tvcmspaymenticon', 'user_token=' . $this->session->data['user_token'] . '&sort=p.tvcmspaymenticon_status' . $url, true);

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
		$pagination->url 	= $this->url->link('extension/module/tvcmspaymenticon', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($imageslider_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($imageslider_total - $this->config->get('config_limit_admin'))) ? $imageslider_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $imageslider_total, ceil($imageslider_total / $this->config->get('config_limit_admin')));

		$data['filter_name'] 	= $filter_name;
		$data['filter_status'] 	= $filter_status;
		$data['sort'] 			= $sort;
		$data['order'] 			= $order;
		$data['ajaxlink'] 		= $this->url->link('extension/module/tvcmspaymenticon/ajax', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['header'] 		= $this->load->controller('common/header');
		$data['column_left'] 	= $this->load->controller('common/column_left');
		$data['footer'] 		= $this->load->controller('common/footer');


		$this->response->setOutput($this->load->view('extension/module/tvcmspaymenticon_list', $data));
	}

	protected function getForm() {

		$data['text_form'] 		= !isset($this->request->get['tvcmspaymenticonmain_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_form_main'] = !isset($this->request->get['tvcmspaymenticonmain_id']) ? $this->language->get('text_main_add') : $this->language->get('text_main_edit');
		$data['text_left'] 		= $this->language->get('text_left');
		$data['text_center'] 	= $this->language->get('text_center');
		$data['text_right'] 	= $this->language->get('text_right');
		$data['text_hide'] 		= $this->language->get('text_hide');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
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

		$data['breadcrumbs'] = array();

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
			'href' => $this->url->link('extension/module/tvcmspaymenticon', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		if (!isset($this->request->get['tvcmspaymenticonmain_id'])) {
			$data['action'] = $this->url->link('extension/module/tvcmspaymenticon/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('extension/module/tvcmspaymenticon/edit', 'user_token=' . $this->session->data['user_token'] . '&tvcmspaymenticonmain_id=' . $this->request->get['tvcmspaymenticonmain_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('extension/module/tvcmspaymenticon', 'user_token=' . $this->session->data['user_token'] . $url, true);

		if (isset($this->request->get['tvcmspaymenticonmain_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$imageslider_info = $this->model_catalog_tvcmspaymenticon->gettestimonialsigle($this->request->get['tvcmspaymenticonmain_id']);
		}
		
		$data['user_token'] = $this->session->data['user_token'];

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$this->load->model('tool/image');

		$status = $this->status();
    	$data['link'] 			= $status['link'];
    	$data['image']			= $status['image'];
		$data['record_form'] 	= $status['record_form'];
    	$data['title'] 			= $status['title'];

    	if(isset($data['record_form'])){

			if (isset($this->request->post['tvcmspaymenticon'])) {
				$data['tvcmspaymenticon'] = $this->request->post['tvcmspaymenticon'];
			} elseif (!empty($imageslider_info)) {
				$editdata = array();
				foreach ($imageslider_info as $key => $value) {
					$editdata[$value['tvcmspaymenticonsublang_id']] = $value;
				}
				$data['tvcmspaymenticon'] = $editdata;
			} else {
				$data['tvcmspaymenticon'] = array();
			}

			if (isset($this->request->post['tvcmspaymenticon_status'])) {
				$data['tvcmspaymenticon_status'] = $this->request->post['tvcmspaymenticon_status'];
			} elseif (!empty($imageslider_info)) {
				$data['tvcmspaymenticon_status'] = $imageslider_info[0]['tvcmspaymenticon_status'];
			} else {
				$data['tvcmspaymenticon_status'] = array();
			}
			if(isset($data['link'])){
				if (isset($this->request->post['tvcmspaymenticonmain_link'])) {
					$data['tvcmspaymenticonmain_link'] = $this->request->post['tvcmspaymenticonmain_link'];
				} elseif (!empty($imageslider_info)) {
					$data['tvcmspaymenticonmain_link'] = $imageslider_info[0]['tvcmspaymenticonmain_link'];
				} else {
					$data['tvcmspaymenticonmain_link'] = "";
				}
			}
			if(isset($data['image'])){
				if (isset($this->request->post['tvcmspaymenticonmain_image'])) {
					$data['img'] =  $this->model_tool_image->resize($this->request->post['tvcmspaymenticonmain_image']);
					$data['tvcmspaymenticonmain_image'] = $this->request->post['tvcmspaymenticonmain_image'];
				} elseif (!empty($imageslider_info)) {
					if(isset($imageslider_info[0]['tvcmspaymenticonmain_image'])){
						$data['img'] =  $this->model_tool_image->resize($imageslider_info[0]['tvcmspaymenticonmain_image'], 100, 100);
						$data['tvcmspaymenticonmain_image'] = $imageslider_info[0]['tvcmspaymenticonmain_image'];
					}else{
						$data['img'] = $this->model_tool_image->resize('no_image.png', 100, 100);
						$data['tvcmspaymenticonmain_image'] = "";
					}
				} else {
					$data['img'] =  $this->model_tool_image->resize('no_image.png', 100, 100);
					$data['tvcmspaymenticonmain_image'] = "";
				}
			}
		}

		$data['placeholder'] 	= $this->model_tool_image->resize('no_image.png', 100, 100);
		$data['header'] 		= $this->load->controller('common/header');
		$data['column_left'] 	= $this->load->controller('common/column_left');
		$data['footer'] 		= $this->load->controller('common/footer');


		$this->response->setOutput($this->load->view('extension/module/tvcmspaymenticon_form', $data));
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'extension/module/tvcmspaymenticon')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	protected function validateCopy() {
		if (!$this->user->hasPermission('modify', 'extension/module/tvcmspaymenticon')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
	protected function validatesetting() {
		$this->load->language('extension/module/tvcmspaymenticon');

		if (!$this->user->hasPermission('modify', 'extension/module/tvcmspaymenticon')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		return !$this->error;
	}
}
