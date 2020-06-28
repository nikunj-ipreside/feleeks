<?php
class ControllerExtensionModuletvcmscategoryproduct extends Controller {

	private $error = array();

	public function index() {
		$this->load->language('extension/module/tvcmscategoryproduct');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/tvcmscategoryproduct');

		$this->getList();
	}
	public function install(){

		$main 			= array();
		$main['name'] 	= "Category Product";
		$main['status'] = 1;

		$this->load->model('setting/module');
		$this->load->model('localisation/language');
		$this->load->model('catalog/tvcmscategoryproduct');

		$languages = $this->model_localisation_language->getLanguages();
		$category 	 = $this->model_catalog_tvcmscategoryproduct->getCategories();

        foreach ($languages as $value) {
        	$main['tvcmscategoryproduct_main'][$value['language_id']] =  array('maintitle'=>"Our Categories Product",'main_subtitle'=>"Our Categories Product",'main_short_des'=>"This is Show Short Description",'main_des'=>"Description",'main_img'=>"catalog/themevolty/productcategory/demo_main_img.jpg");
		}

		$this->model_setting_module->addModule('tvcmscategoryproduct', $main);
		
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "tvcmscategoryproductmain` 
		(   `tvcmscategoryproductmain_id` int(11) AUTO_INCREMENT,
            `tvcmscategoryproductmain_pos` int(11),
            `tvcmscategoryproduct_status` int(11),
            `tvcmscategoryproduct_numberofproduct` int(11),
            `tvcmscategoryproduct_categoryselect` int(11),
            `tvcmscategoryproduct_img` VARCHAR(255),
        PRIMARY KEY (`tvcmscategoryproductmain_id`)) ENGINE = InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "tvcmscategoryproductsub` 
        (	`tvcmscategoryproductsub_id` INT NOT NULL AUTO_INCREMENT ,
            `tvcmscategoryproductmain_id` INT NOT NULL ,
            `tvcmscategoryproductsublang_id` INT NOT NULL ,
            `tvcmscategoryproduct_title` VARCHAR(255),
        PRIMARY KEY (`tvcmscategoryproductsub_id`)) ENGINE = InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;");

		$num_of_data = 9;
		$sub 		 = array();
	 	for ($i = 1; $i<=$num_of_data; $i++) {
            $this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmscategoryproductmain`
            	SET
						tvcmscategoryproduct_img 			= "catalog/themevolty/categoryproduct/demo_img_'.$i.'.png",
						tvcmscategoryproductmain_pos 	    = '.$i.',
						tvcmscategoryproduct_numberofproduct 	    = 10,
						tvcmscategoryproduct_categoryselect 	    = "'.$category[$i]['category_id'].'" ,
						tvcmscategoryproduct_status 		= 1;');	
	        foreach ($languages as $value) {
				$this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmscategoryproductsub`
				SET 
							tvcmscategoryproductmain_id 				= '.$i.',
							tvcmscategoryproduct_title 				= "Electronic",
							tvcmscategoryproductsublang_id 				= '.$value['language_id'].'');
			}
    	}
	}
	public function uninstall(){
		$pre = DB_PREFIX;
		$this->db->query("DROP TABLE `{$pre}tvcmscategoryproductmain`");
		$this->db->query("DROP TABLE `{$pre}tvcmscategoryproductsub`");
	}
	protected function status(){
		return $this->Tvcmsthemevoltystatus->categoryproduct();
	}
	public function ajax() {
		$this->load->model('catalog/tvcmscategoryproduct');
		$update_position 	= $this->request->get['action'];
		$position 			= $this->request->get['recordsArray'];
		$return_data 		= array();
		if ($update_position == 'update_position') {
		    $return_data['success'] = 'right';
		    $this->model_catalog_tvcmscategoryproduct->updatePosition($position);
		    echo $res = implode("##", $return_data);
		}
	}	
	public function add() {
		$this->load->language('extension/module/tvcmscategoryproduct');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/tvcmscategoryproduct');
		if ($this->request->server['REQUEST_METHOD'] == 'POST')  {
			$this->model_catalog_tvcmscategoryproduct->insertdata($this->request->post);

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
		$this->load->language('extension/module/tvcmscategoryproduct');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/tvcmscategoryproduct');

		if ($this->request->server['REQUEST_METHOD'] == 'POST')  {
			$this->model_catalog_tvcmscategoryproduct->edittestimonial($this->request->get['tvcmscategoryproductmain_id'], $this->request->post);

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
		$this->load->language('extension/module/tvcmscategoryproduct');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/tvcmscategoryproduct');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $tvcmscategoryproductmain_id) {
				$this->model_catalog_tvcmscategoryproduct->deletetestimonial($tvcmscategoryproductmain_id);
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
		$this->load->language('extension/module/tvcmscategoryproduct');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/tvcmscategoryproduct');

		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $tvcmscategoryproductmain_id) {
				$this->model_catalog_tvcmscategoryproduct->copytestimonial($tvcmscategoryproductmain_id);
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
		$this->load->model('catalog/tvcmscategoryproduct');
		$this->load->model('localisation/language');
		$this->load->model('tool/image');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validatesetting()) {

			if (!isset($this->request->get['module_id'])) {
				$this->model_setting_module->addModule('tvcmscategoryproduct', $this->request->post);
			} else {
				$this->model_setting_module->editModule($this->request->get['module_id'], $this->request->post);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}

		$this->load->language('extension/module/tvcmscategoryproduct');

		$data['column_main_title'] 		= $this->language->get('column_main_title');
		$data['column_main_short_des'] 	= $this->language->get('column_main_short_des');
		$data['column_action'] 			= $this->language->get('column_action');
		$data['column_link'] 			= $this->language->get('column_link');
		$data['column_title'] 			= $this->language->get('column_title');
		$data['column_desi'] 			= $this->language->get('column_desi');
		$data['column_des'] 			= $this->language->get('column_des');
		$data['column_status'] 			= $this->language->get('column_status');
		$data['entry_main_des'] 		= $this->language->get('entry_main_des');
		$data['entry_main_img'] 		= $this->language->get('entry_main_img');
		$data['entry_short_des'] 		= $this->language->get('entry_short_des');
		$data['entry_sing_img'] 		= $this->language->get('entry_sing_img');
		$data['entry_sing_text'] 		= $this->language->get('entry_sing_text');

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
				'href' => $this->url->link('extension/module/tvcmscategoryproduct', 'user_token=' . $this->session->data['user_token'] . $url, true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/tvcmscategoryproduct', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}

		if (!isset($this->request->get['module_id'])) {
			$data['mainaction'] = $this->url->link('extension/module/tvcmscategoryproduct/getList', 'user_token=' . $this->session->data['user_token'] . $url, true);
		} else {
			$data['mainaction'] = $this->url->link('extension/module/tvcmscategoryproduct/getList', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
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
    	$data['main_sub_title'] 		= $status['main_sub_title'];
    	$data['main_description'] 		= $status['main_description'];
    	$data['main_image']				= $status['main_image'];

    	$data['record_form'] 			= $status['record_form'];
    	$data['image'] 					= $status['image'];
    	$data['category_title'] 		= $status['category_title'];
    	$data['title'] 					= $status['title'];
    	

    	$default_image = $this->model_tool_image->resize('no_image.png', 100, 100);
		if(!empty($data['main_form'])){
			if (isset($this->request->post['tvcmscategoryproduct_main'])) {
				$data['tvcmscategoryproduct_main'] = $this->request->post['tvcmscategoryproduct_main'];
				foreach ($this->request->post['tvcmscategoryproduct_main'] as $key => $value) {
					if(!empty($value['main_img'])){
						$data['img'][$key] = $this->model_tool_image->resize($value['main_img'], 100, 100);				
					}else{
						$data['img'][$key] = $default_image;
					}
				}
			} elseif (!empty($module_info)) {
				$data['tvcmscategoryproduct_main'] = $module_info['tvcmscategoryproduct_main'];
				
				foreach ($data['tvcmscategoryproduct_main'] as $key => $value) {
					if(!empty($value['main_img'])){
						$data['img'][$key] = $this->model_tool_image->resize($value['main_img'], 100, 100);				
					}else{
						$data['img'][$key] = $default_image;
					}
				}
			} else {
				foreach ($data['languages'] as $key => $value) {
					$data['img'][$value['language_id']] = $default_image;
				}
				$data['tvcmscategoryproduct_main'] = array();
			}
		}
		$data['add'] 	= $this->url->link('extension/module/tvcmscategoryproduct/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['copy'] 	= $this->url->link('extension/module/tvcmscategoryproduct/copy', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['delete'] = $this->url->link('extension/module/tvcmscategoryproduct/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);

		$data['imagesliders'] = array();

		$filter_data = array(
			'filter_name'	  => $filter_name,
			'filter_status'   => $filter_status,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'           => $this->config->get('config_limit_admin')
		);

		$imageslider_total = $this->model_catalog_tvcmscategoryproduct->getTotaltestimonial($filter_data);

		$results = $this->model_catalog_tvcmscategoryproduct->gettestimonial($filter_data);
		foreach ($results as $result) {

			$cate_namme = $this->model_catalog_tvcmscategoryproduct->getcatename($result['tvcmscategoryproduct_categoryselect']);
			if(isset($cate_namme['name'])){
				$name = $cate_namme['name'];
			}else{
				$name ="";
			}


			$data['imagesliders'][] = array(
				'id' 				=> $result['tvcmscategoryproductmain_id'],
				'img1'    			=> $this->model_tool_image->resize($result['tvcmscategoryproduct_img'], 100, 100),
				'title'     		=> $result['tvcmscategoryproduct_title'],
				'totalproduct'     	=> $result['tvcmscategoryproduct_numberofproduct'],
				'categoryselect'    => $name,
				'status'    		=> $result['tvcmscategoryproduct_status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'lang_id'   		=> (int)$this->config->get('config_language_id'),
				'edit'      		=> $this->url->link('extension/module/tvcmscategoryproduct/edit', 'user_token=' . $this->session->data['user_token'] . '&tvcmscategoryproductmain_id=' . $result['tvcmscategoryproductmain_id'] . $url, true)
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



		$data['sort_tvcmscategoryproduct_title'] = $this->url->link('extension/module/tvcmscategoryproduct', 'user_token=' . $this->session->data['user_token'] . '&sort=pd.tvcmscategoryproduct_title' . $url, true);


		$data['sort_tvcmscategoryproductsub_description'] = $this->url->link('extension/module/tvcmscategoryproduct', 'user_token=' . $this->session->data['user_token'] . '&sort=pd.tvcmscategoryproductsub_description' . $url, true);

		$data['sort_tvcmscategoryproduct_status'] = $this->url->link('extension/module/tvcmscategoryproduct', 'user_token=' . $this->session->data['user_token'] . '&sort=p.tvcmscategoryproduct_status' . $url, true);

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
		$pagination->url 	= $this->url->link('extension/module/tvcmscategoryproduct', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($imageslider_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($imageslider_total - $this->config->get('config_limit_admin'))) ? $imageslider_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $imageslider_total, ceil($imageslider_total / $this->config->get('config_limit_admin')));

		$data['filter_name'] = $filter_name;
		
		$data['filter_status'] = $filter_status;

		$data['sort'] 			= $sort;
		$data['order'] 			= $order;

		$data['ajaxlink'] 		= $this->url->link('extension/module/tvcmscategoryproduct/ajax', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['header'] 		= $this->load->controller('common/header');
		$data['column_left'] 	= $this->load->controller('common/column_left');
		$data['footer'] 		= $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/tvcmscategoryproduct_list', $data));
	}

	protected function getForm() {

		$data['text_form'] = !isset($this->request->get['tvcmscategoryproductmain_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_form_main'] = !isset($this->request->get['tvcmscategoryproductmain_id']) ? $this->language->get('text_main_add') : $this->language->get('text_main_edit');
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
			'href' => $this->url->link('extension/module/tvcmscategoryproduct', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		if (!isset($this->request->get['tvcmscategoryproductmain_id'])) {
			$data['action'] = $this->url->link('extension/module/tvcmscategoryproduct/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('extension/module/tvcmscategoryproduct/edit', 'user_token=' . $this->session->data['user_token'] . '&tvcmscategoryproductmain_id=' . $this->request->get['tvcmscategoryproductmain_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('extension/module/tvcmscategoryproduct', 'user_token=' . $this->session->data['user_token'] . $url, true);

		if (isset($this->request->get['tvcmscategoryproductmain_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$imageslider_info = $this->model_catalog_tvcmscategoryproduct->gettestimonialsigle($this->request->get['tvcmscategoryproductmain_id']);
		}
		
		$data['user_token'] = $this->session->data['user_token'];

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$this->load->model('tool/image');

		$status = $this->status();



		$data['title'] 					= $status['title'];
    	$data['category_title'] 			= $status['category_title'];
    	$data['image'] 					= $status['image'];
    	$data['category'] 			= $this->model_catalog_tvcmscategoryproduct->getCategories();
		if (isset($this->request->post['tvcmscategoryproduct'])) {
			$data['tvcmscategoryproduct'] = $this->request->post['tvcmscategoryproduct'];
		} elseif (!empty($imageslider_info)) {
			$editdata = array();
			foreach ($imageslider_info as $key => $value) {
				$editdata[$value['tvcmscategoryproductsublang_id']] = $value;
			}
			$data['tvcmscategoryproduct'] = $editdata;
		} else {
			$data['tvcmscategoryproduct'] = array();
		}
		if (isset($this->request->post['tvcmscategoryproduct_status'])) {
			$data['tvcmscategoryproduct_status'] = $this->request->post['tvcmscategoryproduct_status'];
		} elseif (!empty($imageslider_info)) {
			$data['tvcmscategoryproduct_status'] = $imageslider_info[0]['tvcmscategoryproduct_status'];
		} else {
			$data['tvcmscategoryproduct_status'] = "";
		}

		if (isset($this->request->post['tvcmscategoryproduct_numberofproduct'])) {
			$data['tvcmscategoryproduct_numberofproduct'] = $this->request->post['tvcmscategoryproduct_numberofproduct'];
		} elseif (!empty($imageslider_info)) {
			$data['tvcmscategoryproduct_numberofproduct'] = $imageslider_info[0]['tvcmscategoryproduct_numberofproduct'];
		} else {
			$data['tvcmscategoryproduct_numberofproduct'] = "";
		}
		if (isset($this->request->post['tvcmscategoryproduct_numberofproduct'])) {
			$data['tvcmscategoryproduct_numberofproduct'] = $this->request->post['tvcmscategoryproduct_numberofproduct'];
		} elseif (!empty($imageslider_info)) {
			$data['tvcmscategoryproduct_numberofproduct'] = $imageslider_info[0]['tvcmscategoryproduct_numberofproduct'];
		} else {
			$data['tvcmscategoryproduct_numberofproduct'] = "";
		}

		if (isset($this->request->post['tvcmscategoryproduct_categoryselect'])) {
			$data['tvcmscategoryproduct_categoryselect'] = $this->request->post['tvcmscategoryproduct_categoryselect'];
		} elseif (!empty($imageslider_info)) {
			$data['tvcmscategoryproduct_categoryselect'] = $imageslider_info[0]['tvcmscategoryproduct_categoryselect'];
		} else {
			$data['tvcmscategoryproduct_categoryselect'] = "";
		}
		
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		if(isset($data['image'])){
			if (isset($this->request->post['tvcmscategoryproduct_img'])) {
				$data['tvcmscategoryproduct_img'] = $this->request->post['tvcmscategoryproduct_img'];
				if(!empty($data['tvcmscategoryproduct_img'])){
					$data['sub_img1'] = $this->model_tool_image->resize($data['tvcmscategoryproduct_img'], 100, 100);
				}else{
					$data['sub_img1'] = $data['placeholder'];
				}
			} elseif (!empty($imageslider_info)) {
				$data['tvcmscategoryproduct_img'] = $imageslider_info[0]['tvcmscategoryproduct_img'];
				if(!empty($imageslider_info[0]['tvcmscategoryproduct_img'])){
					$data['sub_img1'] = $this->model_tool_image->resize($imageslider_info[0]['tvcmscategoryproduct_img'], 100, 100);
				}else{
					$data['sub_img1'] = $data['placeholder'];
				}
			} else {
				$data['sub_img1'] = $data['placeholder'];
				$data['tvcmscategoryproduct_img'] = $data['placeholder'];
			}
		}

		
		$data['header'] 		= $this->load->controller('common/header');
		$data['column_left'] 	= $this->load->controller('common/column_left');
		$data['footer'] 		= $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/tvcmscategoryproduct_form', $data));
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'extension/module/tvcmscategoryproduct')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	protected function validateCopy() {
		if (!$this->user->hasPermission('modify', 'extension/module/tvcmscategoryproduct')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	protected function validatesetting() {
		$this->load->language('extension/module/tvcmscategoryproduct');

		if (!$this->user->hasPermission('modify', 'extension/module/tvcmscategoryproduct')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		return !$this->error;
	}
}
