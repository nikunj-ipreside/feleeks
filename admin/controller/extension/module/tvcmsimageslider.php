<?php
class ControllerExtensionModuleTvcmsimageslider extends Controller {

	private $error = array();

	public function index() {
		$this->load->language('extension/module/tvcmsimageslider');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/tvcmsimageslider');

		$this->getList();
	}
	public function install(){
		$main 			= array();
		$main['name'] 	= "Image Slider";
		$main['status'] = 1;
		$main['speed'] 	= 5000;
		$main['hover'] 	= 1;
		$main['loop'] 	= 1;
		$main['slider'] = 1;

		$this->load->model('setting/module');
		$this->load->model('localisation/language');
		$this->load->model('catalog/tvcmsimageslider');

		$languages = $this->model_localisation_language->getLanguages();

		$this->model_setting_module->addModule('tvcmsimageslider', $main);
		
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "tvcmsimageslidermain` 
		(   `tvcmsimageslidermain_id` int(11) AUTO_INCREMENT,
            `tvcmsimageslidermain_pos` int(11),
        PRIMARY KEY (`tvcmsimageslidermain_id`)) ENGINE = InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "tvcmsimageslidersub` 
        (	`tvcmsimageslidersub_id` INT NOT NULL AUTO_INCREMENT ,
            `tvcmsimageslidermain_id` INT NOT NULL ,
            `tvcmsimageslidersub_link` VARCHAR(255),
            `tvcmsimageslidersub_image` VARCHAR(255),
            `tvcmsimageslidersub_title` VARCHAR(255),
            `tvcmsimageslidersub_textaligment` VARCHAR(255),
            `tvcmsimageslidersub_buttoncaption` VARCHAR(255),
            `tvcmsimageslidersub_des_main` TEXT,
            `tvcmsimageslidersub_des_sub` TEXT,
            `tvcmsimageslidersub_enable` INT NOT NULL ,
            `tvcmsimageslidersublang_id` INT NOT NULL ,
        PRIMARY KEY (`tvcmsimageslidersub_id`)) ENGINE = InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;");

		$num_of_data = 5;
		$sub 		 = array();

	 	for ($i = 1; $i<=$num_of_data; $i++) {
            $this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmsimageslidermain`
			SET      
				tvcmsimageslidermain_pos 		= '.$i.'');	
	        foreach ($languages as $value) {
				$this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmsimageslidersub`
				SET 
							tvcmsimageslidermain_id 			= '.$i.',
							tvcmsimageslidersub_link 		    = "#",
							tvcmsimageslidersub_des_main		= "Up to 30% off New Products",
							tvcmsimageslidersub_des_sub			= "High quality of product at the competitive prices",
							tvcmsimageslidersub_image 			= "catalog/themevolty/slider/demo_img_'.$i.'.jpg",
							tvcmsimageslidersub_title 			= "Sale Live Now!",
							tvcmsimageslidersub_textaligment 	= "ttvmain-slider-contant-center",
							tvcmsimageslidersub_buttoncaption 	= "shop now",
							tvcmsimageslidersub_enable 			= "1",
							tvcmsimageslidersublang_id 			= '.$value['language_id'].'');
			}
    	}
	}
	public function uninstall(){
		$pre = DB_PREFIX;
		$this->db->query("DROP TABLE `{$pre}tvcmsimageslidermain`");
		$this->db->query("DROP TABLE `{$pre}tvcmsimageslidersub`");
	}
	public function ajax() {
		$this->load->model('catalog/tvcmsimageslider');
		$update_position 	= $this->request->get['action'];
		$position 			= $this->request->get['recordsArray'];
		$return_data 		= array();
		if ($update_position == 'update_position') {
		    $return_data['success'] = 'right';
		    $this->model_catalog_tvcmsimageslider->updatePosition($position);
		    echo $res = implode("##", $return_data);
		}
	}
	public function add() {
		$this->load->language('extension/module/tvcmsimageslider');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/tvcmsimageslider');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_tvcmsimageslider->insertdata($this->request->post);

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

			$this->response->redirect($this->url->link('extension/module/tvcmsimageslider', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}
	public function edit() {
		$this->load->language('extension/module/tvcmsimageslider');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/tvcmsimageslider');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			
			$this->model_catalog_tvcmsimageslider->editimageslider($this->request->get['tvcmsimageslidermain_id'], $this->request->post);

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

			$this->response->redirect($this->url->link('extension/module/tvcmsimageslider', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}
	public function delete() {
		$this->load->language('extension/module/tvcmsimageslider');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/tvcmsimageslider');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {

			foreach ($this->request->post['selected'] as $tvcmsimageslidermain_id) {
				$this->model_catalog_tvcmsimageslider->deleteimageslider($tvcmsimageslidermain_id);
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
		$this->response->redirect($this->url->link('extension/module/tvcmsimageslider', 'user_token=' . $this->session->data['user_token'] . $url, true));
	}
	public function copy() {
		$this->load->language('extension/module/tvcmsimageslider');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/tvcmsimageslider');

		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $tvcmsimageslidermain_id) {
				$this->model_catalog_tvcmsimageslider->copyimageslider($tvcmsimageslidermain_id);
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
		$this->load->model('catalog/tvcmsimageslider');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validatesetting()) {

			if (!isset($this->request->get['module_id'])) {
				$this->model_setting_module->addModule('tvcmsimageslider', $this->request->post);
			} else {
				$this->model_setting_module->editModule($this->request->get['module_id'], $this->request->post);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}

		$this->load->language('extension/module/tvcmsimageslider');
		$status = $this->status();
		$data['record_targeturl'] 			= $status['record_targeturl'];
		$data['record_title'] 				= $status['record_title'];
		$data['record_descriptionmain'] 	= $status['record_descriptionmain'];
		$data['record_descriptionsub'] 		= $status['record_descriptionsub'];
		$data['record_image'] 				= $status['record_image'];
		$data['record_textalignment'] 		= $status['record_textalignment'];
		$data['record_buttoncaption'] 		= $status['record_buttoncaption'];
		$data['column_image'] 				= $this->language->get('column_image');
		$data['column_title'] 				= $this->language->get('column_title');
		$data['column_des_main'] 			= $this->language->get('column_des_main');
		$data['column_des_sub'] 			= $this->language->get('column_des_sub');
		$data['column_image'] 				= $this->language->get('column_image');
		$data['column_link'] 				= $this->language->get('column_link');
		$data['column_txtali'] 				= $this->language->get('column_txtali');
		$data['column_btncap'] 				= $this->language->get('column_btncap');
		$data['column_sort_order'] 			= $this->language->get('column_sort_order');
		$data['column_status'] 				= $this->language->get('column_status');
		$data['entry_main_speed'] 			= $this->language->get('entry_main_speed');
		$data['entry_main_speed_des'] 		= $this->language->get('entry_main_speed_des');
		$data['entry_main_hover'] 			= $this->language->get('entry_main_hover');
		$data['entry_main_hover_des'] 		= $this->language->get('entry_main_hover_des');
		$data['entry_main_loop'] 			= $this->language->get('entry_main_loop');
		$data['entry_main_loop_des'] 		= $this->language->get('entry_main_loop_des');
		$data['entry_main_slider'] 			= $this->language->get('entry_main_slider');
		$data['entry_main_slider_des'] 		= $this->language->get('entry_main_slider_des');

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
				'href' => $this->url->link('extension/module/tvcmsimageslider', 'user_token=' . $this->session->data['user_token'] . $url, true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/tvcmsimageslider', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}

		if (!isset($this->request->get['module_id'])) {
			$data['mainaction'] = $this->url->link('extension/module/tvcmsimageslider/getList', 'user_token=' . $this->session->data['user_token'] . $url, true);
		} else {
			$data['mainaction'] = $this->url->link('extension/module/tvcmsimageslider/getList', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
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

		if (isset($this->request->post['speed'])) {
			$data['speed'] = $this->request->post['speed'];
		} elseif (!empty($module_info)) {
			$data['speed'] = $module_info['speed'];
		} else {
			$data['speed'] = "";
		}
		if (isset($this->request->post['hover'])) {
			$data['hover'] = $this->request->post['hover'];
		} elseif (!empty($module_info)) {
			$data['hover'] = $module_info['hover'];
		} else {
			$data['hover'] = "";
		}
		if (isset($this->request->post['loop'])) {
			$data['loop'] = $this->request->post['loop'];
		} elseif (!empty($module_info)) {
			$data['loop'] = $module_info['loop'];
		} else {
			$data['loop'] = "";
		}
		if (isset($this->request->post['slider'])) {
			$data['slider'] = $this->request->post['slider'];
		} elseif (!empty($module_info)) {
			$data['slider'] = $module_info['slider'];
		} else {
			$data['slider'] = "";
		}
		$data['add'] 	= $this->url->link('extension/module/tvcmsimageslider/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['copy'] 	= $this->url->link('extension/module/tvcmsimageslider/copy', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['delete'] = $this->url->link('extension/module/tvcmsimageslider/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);

		$data['imagesliders'] = array();

		$filter_data = array(
			'filter_name'	  => $filter_name,
			'filter_status'   => $filter_status,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'           => $this->config->get('config_limit_admin')
		);

		$this->load->model('tool/image');

		$imageslider_total = $this->model_catalog_tvcmsimageslider->getTotalsliderimage($filter_data);

		$results = $this->model_catalog_tvcmsimageslider->getsliderimage($filter_data);

		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['tvcmsimageslidersub_image'])) {
				$image = $this->model_tool_image->resize($result['tvcmsimageslidersub_image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.png', 40, 40);
			}
			$data['imagesliders'][] = array(
				'id' 		=> $result['tvcmsimageslidermain_id'],
				'image'     => $image,
				'title'     => $result['tvcmsimageslidersub_title'],
				'aling'     => $result['tvcmsimageslidersub_textaligment'],
				'btncap'    => $result['tvcmsimageslidersub_buttoncaption'],
				'des_main'  => $result['tvcmsimageslidersub_des_main'],
				'des_sub'   => $result['tvcmsimageslidersub_des_sub'],
				'link'    	=> $result['tvcmsimageslidersub_link'],
				'status'    => $result['tvcmsimageslidersub_enable'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'edit'      => $this->url->link('extension/module/tvcmsimageslider/edit', 'user_token=' . $this->session->data['user_token'] . '&tvcmsimageslidermain_id=' . $result['tvcmsimageslidermain_id'] . $url, true)
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

		$data['sort_tvcmsimageslider_title'] = $this->url->link('extension/module/tvcmsimageslider', 'user_token=' . $this->session->data['user_token'] . '&sort=pd.tvcmsimageslidersub_title' . $url, true);

		$data['sort_tvcmsimageslider_textaligment'] = $this->url->link('extension/module/tvcmsimageslider', 'user_token=' . $this->session->data['user_token'] . '&sort=pd.tvcmsimageslider_textaligment' . $url, true);

		$data['sort_tvcmsimageslider_buttoncaption'] = $this->url->link('extension/module/tvcmsimageslider', 'user_token=' . $this->session->data['user_token'] . '&sort=pd.tvcmsimageslider_buttoncaption' . $url, true);

		$data['sort_tvcmsimageslider_des_main'] = $this->url->link('extension/module/tvcmsimageslider', 'user_token=' . $this->session->data['user_token'] . '&sort=pd.tvcmsimageslider_des_main' . $url, true);
		
		$data['sort_tvcmsimageslider_des_sub'] = $this->url->link('extension/module/tvcmsimageslider', 'user_token=' . $this->session->data['user_token'] . '&sort=pd.tvcmsimageslider_des_sub' . $url, true);

		$data['sort_tvcmsimageslider_enable'] = $this->url->link('extension/module/tvcmsimageslider', 'user_token=' . $this->session->data['user_token'] . '&sort=pd.tvcmsimageslider_enable' . $url, true);

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
		$data['ajaxlink'] = $this->url->link('extension/module/tvcmsimageslider/ajax', 'user_token=' . $this->session->data['user_token'] . $url, true);

		$pagination 			= new Pagination();
		$pagination->total 		= $imageslider_total;
		$pagination->page 		= $page;
		$pagination->limit 		= $this->config->get('config_limit_admin');
		$pagination->url 		= $this->url->link('extension/module/tvcmsimageslider', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);
		$data['pagination'] 	= $pagination->render();
		$data['results'] 		= sprintf($this->language->get('text_pagination'), ($imageslider_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($imageslider_total - $this->config->get('config_limit_admin'))) ? $imageslider_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $imageslider_total, ceil($imageslider_total / $this->config->get('config_limit_admin')));
		$data['filter_name'] 	= $filter_name;
		$data['filter_status'] 	= $filter_status;
		$data['sort'] 			= $sort;
		$data['order'] 			= $order;	
		$data['header'] 		= $this->load->controller('common/header');
		$data['column_left'] 	= $this->load->controller('common/column_left');
		$data['footer'] 		= $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/tvcmsimageslider_list', $data));
	}
	protected function getForm() {
		$status = $this->status();
		$data['record_targeturl'] 			= $status['record_targeturl'];
		$data['record_title'] 				= $status['record_title'];
		$data['record_descriptionmain'] 	= $status['record_descriptionmain'];
		$data['record_descriptionsub'] 		= $status['record_descriptionsub'];
		$data['record_image'] 				= $status['record_image'];
		$data['record_textalignment'] 		= $status['record_textalignment'];
		$data['record_buttoncaption'] 		= $status['record_buttoncaption'];

		$data['text_form'] 	= !isset($this->request->get['tvcmsimageslidermain_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_left'] 	= $this->language->get('text_left');
		$data['text_center'] = $this->language->get('text_center');
		$data['text_right'] = $this->language->get('text_right');
		$data['text_hide'] = $this->language->get('text_hide');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['tvcmsimageslidersub_title'])) {
			$data['error_title'] = $this->error['tvcmsimageslidersub_title'];
		} else {
			$data['error_title'] = array();
		}
		if (isset($this->error['tvcmsimageslidersub_image'])) {
			$data['error_image'] = $this->error['tvcmsimageslidersub_image'];
		} else {
			$data['error_image'] = array();
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
			'href' => $this->url->link('extension/module/tvcmsimageslider', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);


		if (!isset($this->request->get['tvcmsimageslidermain_id'])) {
			$data['action'] = $this->url->link('extension/module/tvcmsimageslider/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('extension/module/tvcmsimageslider/edit', 'user_token=' . $this->session->data['user_token'] . '&tvcmsimageslidermain_id=' . $this->request->get['tvcmsimageslidermain_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('extension/module/tvcmsimageslider', 'user_token=' . $this->session->data['user_token'] . $url, true);

		if (isset($this->request->get['tvcmsimageslidermain_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$imageslider_info = $this->model_catalog_tvcmsimageslider->getimageslidesigle($this->request->get['tvcmsimageslidermain_id']);
		}
		
		$data['user_token'] = $this->session->data['user_token'];

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$this->load->model('tool/image');

		if (isset($this->request->post['tvcmsimageslider'])) {
			$data['tvcmsimageslider'] = $this->request->post['tvcmsimageslider'];
			foreach ($this->request->post['tvcmsimageslider'] as $key => $value) {
				if($value['tvcmsimageslidersub_image']){
					$data['img'][$key] = $this->model_tool_image->resize($value['tvcmsimageslidersub_image'], 100, 100);				
				}else{
					$data['img'][$key] = $this->model_tool_image->resize('no_image.png', 100, 100); 
				}
			}
		} elseif (!empty($imageslider_info)) {
			$editdata = array();
			foreach ($imageslider_info as $key => $value) {
				$editdata[$value['tvcmsimageslidersublang_id']] = $value;
			}
			$data['tvcmsimageslider'] = $editdata;
			foreach ($editdata as $key => $value) {
				$data['img'][$key] =  $this->model_tool_image->resize($value['tvcmsimageslidersub_image'], 100, 100);				
			}
		} else {
			foreach ($data['languages'] as $key => $value) {
				$data['img'][$value['language_id']] = $this->model_tool_image->resize('no_image.png', 100, 100);
			}
			$data['tvcmsimageslider'] = array();
		}
		
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/tvcmsimageslider_form', $data));
	}
	protected function validateForm() {

		if (!$this->user->hasPermission('modify', 'extension/module/tvcmsimageslider')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		$status = $this->status();
	
		foreach ($this->request->post['tvcmsimageslider'] as $language_id => $value) {
			if(!empty($status['record_title'])){
				if ((utf8_strlen($value['tvcmsimageslidersub_title']) < 1) || (utf8_strlen($value['tvcmsimageslidersub_title']) > 255)) {
					$this->error['tvcmsimageslidersub_title'][$language_id] = $this->language->get('error_title');
				}
			}
			if(!empty($status['record_image'])){
				if ((utf8_strlen($value['tvcmsimageslidersub_image']) < 1) || (utf8_strlen($value['tvcmsimageslidersub_image']) > 255)) {
					$this->error['tvcmsimageslidersub_image'][$language_id] = $this->language->get('error_image');
				}
			}			
		}


		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}
	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'extension/module/tvcmsimageslider')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}
	protected function validateCopy() {
		if (!$this->user->hasPermission('modify', 'extension/module/tvcmsimageslider')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}
	protected function validatesetting() {
		$this->load->language('extension/module/tvcmsimageslider');
		if (!$this->user->hasPermission('modify', 'extension/module/tvcmsimageslider')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		return !$this->error;
	}
	protected function status(){
		return $this->Tvcmsthemevoltystatus->imageslider();
	}
}
