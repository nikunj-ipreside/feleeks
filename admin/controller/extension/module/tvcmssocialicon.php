<?php
class ControllerExtensionModuleTvcmssocialicon extends Controller {

	private $error = array();

	public function index() {
		$this->load->language('extension/module/tvcmssocialicon');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/tvcmssocialicon');
		
		$this->getList();
	}
	public function install(){

		$main 			= array();
		$main['name'] 	= "Social Icon";
		$main['status'] = 1;

		$this->load->model('setting/module');
		$this->load->model('localisation/language');
		$this->load->model('catalog/tvcmspaymenticon');

		$languages = $this->model_localisation_language->getLanguages();

        foreach ($languages as $value) {
        	$main['tvcmssocialicon_main'][$value['language_id']] =  array('main_img'=>"catalog/themevolty/socialicon/demo_img_1.jpg",'maintitle'=>"Visit Our Social Media :",'main_short_des'=>"Sub Descriptio",'main_des'=>"Description");
		}

		$this->model_setting_module->addModule('tvcmssocialicon', $main);
		
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "tvcmssocialiconmain` 
		(   `tvcmssocialiconmain_id` int(11) AUTO_INCREMENT,
            `tvcmssocialiconmain_pos` int(11),
            `tvcmssocialiconmain_class_name` VARCHAR(255),
            `tvcmssocialiconmain_link` VARCHAR(255),
            `tvcmssocialicon_status` int(11),
        PRIMARY KEY (`tvcmssocialiconmain_id`)) ENGINE = InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "tvcmssocialiconsub` 
        (	`tvcmssocialiconsub_id` INT NOT NULL AUTO_INCREMENT ,
            `tvcmssocialiconmain_id` INT NOT NULL ,
            `tvcmssocialiconsublang_id` INT NOT NULL ,
            `tvcmssocialiconsub_title` VARCHAR(255),
        PRIMARY KEY (`tvcmssocialiconsub_id`)) ENGINE = InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;");

		$num_of_data = 7;
		$sub 		 = array();

	 	for ($i = 1; $i<=$num_of_data; $i++) {
            $this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmssocialiconmain`
			SET      	tvcmssocialiconmain_link 		= "#",
						tvcmssocialiconmain_class_name 	= "youtube",
						tvcmssocialiconmain_pos 		= '.$i.',
						tvcmssocialicon_status 		= 1;');	
	        foreach ($languages as $value) {
				$this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmssocialiconsub`
				SET 
							tvcmssocialiconmain_id 		= '.$i.',
							tvcmssocialiconsub_title 		= "Title'.$i.'",
							tvcmssocialiconsublang_id 		= '.$value['language_id'].'');
			}
    	}
    	
   	}
	public function uninstall(){
		$pre = DB_PREFIX;
		$this->db->query("DROP TABLE `{$pre}tvcmssocialiconmain`");
		$this->db->query("DROP TABLE `{$pre}tvcmssocialiconsub`");
	}
	protected function status(){
		return $this->Tvcmsthemevoltystatus->socialiconstatus();
	}
	public function ajax() {
		$this->load->model('catalog/tvcmssocialicon');
		$update_position 	= $this->request->get['action'];
		$position 			= $this->request->get['recordsArray'];
		$return_data 		= array();
		if ($update_position == 'update_position') {
		    $return_data['success'] = 'right';
		    $this->model_catalog_tvcmssocialicon->updatePosition($position);
		    echo $res = implode("##", $return_data);
		}
	}	

	public function add() {
		$this->load->language('extension/module/tvcmssocialicon');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/tvcmssocialicon');
		if ($this->request->server['REQUEST_METHOD'] == 'POST')  {
			$this->model_catalog_tvcmssocialicon->insertdata($this->request->post);

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
		$this->load->language('extension/module/tvcmssocialicon');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/tvcmssocialicon');

		if ($this->request->server['REQUEST_METHOD'] == 'POST')  {
			
			$this->model_catalog_tvcmssocialicon->edittestimonial($this->request->get['tvcmssocialiconmain_id'], $this->request->post);

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
		$this->load->language('extension/module/tvcmssocialicon');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/tvcmssocialicon');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $tvcmssocialiconmain_id) {
				$this->model_catalog_tvcmssocialicon->deletetestimonial($tvcmssocialiconmain_id);
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
		$this->load->language('extension/module/tvcmssocialicon');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/tvcmssocialicon');

		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $tvcmssocialiconmain_id) {
				$this->model_catalog_tvcmssocialicon->copytestimonial($tvcmssocialiconmain_id);
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
		$this->load->model('catalog/tvcmssocialicon');
		$this->load->model('localisation/language');
		$this->load->model('tool/image');
		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validatesetting()) {

			if (!isset($this->request->get['module_id'])) {
				$this->model_setting_module->addModule('tvcmssocialicon', $this->request->post);
			} else {
				$this->model_setting_module->editModule($this->request->get['module_id'], $this->request->post);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}

		$this->load->language('extension/module/tvcmssocialicon');

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
				'href' => $this->url->link('extension/module/tvcmssocialicon', 'user_token=' . $this->session->data['user_token'] . $url, true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/tvcmssocialicon', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}

		if (!isset($this->request->get['module_id'])) {
			$data['mainaction'] = $this->url->link('extension/module/tvcmssocialicon/getList', 'user_token=' . $this->session->data['user_token'] . $url, true);
		} else {
			$data['mainaction'] = $this->url->link('extension/module/tvcmssocialicon/getList', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
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

		$status 						= $this->status();

		$data['main_form'] 				= $status['main_form'];
    	$data['main_title'] 			= $status['main_title'];
    	$data['main_short_description'] = $status['main_short_description'];
    	$data['main_description'] 		= $status['main_description'];
    	$data['main_image']				= $status['main_image'];
    	$data['record_form'] 			= $status['record_form'];

    	$data['title'] 					= $status['title'];
    	$data['link'] 					= $status['link'];
    	$data['class_name'] 			= $status['class_name'];

    	//echo "<pre>"; print_r($data); echo "</pre>"; die;
		if(!empty($data['main_form'])){
			if (isset($this->request->post['tvcmssocialicon_main'])) {
				$data['tvcmssocialicon_main'] = $this->request->post['tvcmssocialicon_main'];
				foreach ($this->request->post['tvcmssocialicon_main'] as $key => $value) {
					$data['img'][$key] =  $this->model_tool_image->resize($value['main_img'], 100, 100);				
				}
			} elseif (!empty($module_info)) {
				$data['tvcmssocialicon_main'] = $module_info['tvcmssocialicon_main'];
				foreach ($data['tvcmssocialicon_main'] as $key => $value) {
					$data['img'][$key] =  $this->model_tool_image->resize($value['main_img'], 100, 100);				
				}
			} else {
				$data['tvcmssocialicon_main'] = array();
				foreach ($data['languages'] as $key => $value) {
					$data['img'][$value['language_id']] =  $this->model_tool_image->resize('no_image.png', 100, 100);
				}
			}
		}
		$data['add'] 	= $this->url->link('extension/module/tvcmssocialicon/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['copy'] 	= $this->url->link('extension/module/tvcmssocialicon/copy', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['delete'] = $this->url->link('extension/module/tvcmssocialicon/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);

		$data['imagesliders'] = array();

		$filter_data = array(
			'filter_name'	  => $filter_name,
			'filter_status'   => $filter_status,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'           => $this->config->get('config_limit_admin')
		);

		$imageslider_total = $this->model_catalog_tvcmssocialicon->getTotaltestimonial($filter_data);

		$results = $this->model_catalog_tvcmssocialicon->gettestimonial($filter_data);
		foreach ($results as $result) {
			
			$data['imagesliders'][] = array(
				'id' 			=> $result['tvcmssocialiconmain_id'],
				'lang_id'   	=> (int)$this->config->get('config_language_id'),
				'title'     	=> $result['tvcmssocialiconsub_title'],
				'class_name'	=> $result['tvcmssocialiconmain_class_name'],
				'link'    		=> $result['tvcmssocialiconmain_link'],
				'status'    	=> $result['tvcmssocialicon_status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'edit'     		=> $this->url->link('extension/module/tvcmssocialicon/edit', 'user_token=' . $this->session->data['user_token'] . '&tvcmssocialiconmain_id=' . $result['tvcmssocialiconmain_id'] . $url, true)
			);
			 
		}

		//echo "<pre>"; print_r($data['imagesliders']); echo "</pre>"; die;
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

		$data['sort_tvcmssocialiconsub_title'] = $this->url->link('extension/module/tvcmssocialicon', 'user_token=' . $this->session->data['user_token'] . '&sort=pd.tvcmssocialiconsub_title' . $url, true);

		$data['sort_tvcmssocialiconmain_link'] = $this->url->link('extension/module/tvcmssocialicon', 'user_token=' . $this->session->data['user_token'] . '&sort=p.tvcmssocialiconmain_link' . $url, true);

		$data['sort_tvcmssocialiconmain_class_name'] = $this->url->link('extension/module/tvcmssocialicon', 'user_token=' . $this->session->data['user_token'] . '&sort=p.tvcmssocialiconmain_class_name' . $url, true);

		$data['sort_tvcmssocialicon_status'] = $this->url->link('extension/module/tvcmssocialicon', 'user_token=' . $this->session->data['user_token'] . '&sort=p.tvcmssocialicon_status' . $url, true);

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
		$pagination->url 	= $this->url->link('extension/module/tvcmssocialicon', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($imageslider_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($imageslider_total - $this->config->get('config_limit_admin'))) ? $imageslider_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $imageslider_total, ceil($imageslider_total / $this->config->get('config_limit_admin')));

		$data['filter_name'] 	= $filter_name;
		$data['filter_status'] 	= $filter_status;
		$data['sort'] 			= $sort;
		$data['order'] 			= $order;
		$data['ajaxlink'] 		= $this->url->link('extension/module/tvcmssocialicon/ajax', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['header'] 		= $this->load->controller('common/header');
		$data['column_left'] 	= $this->load->controller('common/column_left');
		$data['footer'] 		= $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/tvcmssocialicon_list', $data));
	}

	protected function getForm() {

		$data['text_form'] = !isset($this->request->get['tvcmssocialiconmain_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_form_main'] = !isset($this->request->get['tvcmssocialiconmain_id']) ? $this->language->get('text_main_add') : $this->language->get('text_main_edit');
		$data['text_left'] = $this->language->get('text_left');
		$data['text_center'] = $this->language->get('text_center');
		$data['text_right'] = $this->language->get('text_right');
		$data['text_hide'] = $this->language->get('text_hide');

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
			'href' => $this->url->link('extension/module/tvcmssocialicon', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		if (!isset($this->request->get['tvcmssocialiconmain_id'])) {
			$data['action'] = $this->url->link('extension/module/tvcmssocialicon/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('extension/module/tvcmssocialicon/edit', 'user_token=' . $this->session->data['user_token'] . '&tvcmssocialiconmain_id=' . $this->request->get['tvcmssocialiconmain_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('extension/module/tvcmssocialicon', 'user_token=' . $this->session->data['user_token'] . $url, true);

		if (isset($this->request->get['tvcmssocialiconmain_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$imageslider_info = $this->model_catalog_tvcmssocialicon->gettestimonialsigle($this->request->get['tvcmssocialiconmain_id']);
		}
		
		$data['user_token'] = $this->session->data['user_token'];

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$this->load->model('tool/image');

		$status 			= $this->status();

		$data['record_form'] 	= $status['record_form'];
		$data['title'] 			= $status['title'];
    	$data['class_name'] 	= $status['class_name'];
    	$data['link']			= $status['link'];

    	if(isset($data['title'])){
			if (isset($this->request->post['tvcmssocialicon'])) {
				$data['tvcmssocialicon'] = $this->request->post['tvcmssocialicon'];
			} elseif (!empty($imageslider_info)) {
				$editdata = array();
				foreach ($imageslider_info as $key => $value) {
					$editdata[$value['tvcmssocialiconsublang_id']] = $value;
				}
				$data['tvcmssocialicon'] = $editdata;
			} else {
				$data['tvcmssocialicon'] = array();
			}
		}

		if (isset($this->request->post['tvcmssocialicon_status'])) {
			$data['tvcmssocialicon_status'] = $this->request->post['tvcmssocialicon_status'];
		} elseif (!empty($imageslider_info)) {
			$data['tvcmssocialicon_status'] = $imageslider_info[0]['tvcmssocialicon_status'];
		} else {
			$data['tvcmssocialicon_status'] = array();
		}


		if(isset($data['link'])){
			if (isset($this->request->post['tvcmssocialiconmain_link'])) {
				$data['tvcmssocialiconmain_link'] = $this->request->post['tvcmssocialiconmain_link'];
			} elseif (!empty($imageslider_info)) {
				$data['tvcmssocialiconmain_link'] = $imageslider_info[0]['tvcmssocialiconmain_link'];
			} else {
				$data['tvcmssocialiconmain_link'] = "";
			}
		}
	
		if(isset($data['class_name'])){
			if (isset($this->request->post['tvcmssocialiconmain_class_name'])) {
				$data['tvcmssocialiconmain_class_name'] = $this->request->post['tvcmssocialiconmain_class_name'];
			} elseif (!empty($imageslider_info)) {
				$data['tvcmssocialiconmain_class_name'] = $imageslider_info[0]['tvcmssocialiconmain_class_name'];
			} else {
				$data['tvcmssocialiconmain_class_name'] = "";
			}
		}

		$data['placeholder'] 	= $this->model_tool_image->resize('no_image.png', 100, 100);
		
		$data['header'] 		= $this->load->controller('common/header');
		$data['column_left'] 	= $this->load->controller('common/column_left');
		$data['footer'] 		= $this->load->controller('common/footer');


		$this->response->setOutput($this->load->view('extension/module/tvcmssocialicon_form', $data));
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'extension/module/tvcmssocialicon')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	protected function validateCopy() {
		if (!$this->user->hasPermission('modify', 'extension/module/tvcmssocialicon')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
	protected function validatesetting() {
		$this->load->language('extension/module/tvcmssocialicon');

		if (!$this->user->hasPermission('modify', 'extension/module/tvcmssocialicon')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		return !$this->error;
	}
}
