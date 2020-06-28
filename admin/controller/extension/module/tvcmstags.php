<?php
class ControllerExtensionModuleTvcmstags extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/tvcmstags');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/module');
		$this->load->model('localisation/language');
		$this->load->model('catalog/tvcmstags');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			
			if(isset($this->request->post['tvcmstags']) && !empty($this->request->post['tvcmstags'])){
				$post_data = $this->request->post['tvcmstags'];
			}else{
				$post_data = array();
			}
			$this->model_catalog_tvcmstags->addcustomlink($post_data);
			unset($this->request->post['tvcmstags']);

			if (!isset($this->request->get['module_id'])) {
				$this->model_setting_module->addModule('tvcmstags', $this->request->post);
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
				'href' => $this->url->link('extension/module/tvcmstags', 'user_token=' . $this->session->data['user_token'], true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/tvcmstags', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}
		$data['user_token']			= $this->session->data['user_token'];
		$data['entry_title']		= $this->language->get('entry_title');
		$data['entry_link']			= $this->language->get('entry_link');
		$data['entry_pos']			= $this->language->get('entry_pos');
		$data['entry_main_title']	= $this->language->get('entry_main_title');
		$data['entry_shortdes']		= $this->language->get('entry_shortdes');
		$data['text_main']		    = $this->language->get('text_main');
		$data['text_submain']		= $this->language->get('text_submain');

		if (!isset($this->request->get['module_id'])) {
			$data['action'] 	= $this->url->link('extension/module/tvcmstags', 'user_token=' . $this->session->data['user_token'], true);
		} else {
			$data['action'] 	= $this->url->link('extension/module/tvcmstags', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
		}

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info 		= $this->model_setting_module->getModule($this->request->get['module_id']);
		}

		if (isset($this->request->post['name'])) {
			$data['name'] 		= $this->request->post['name'];
		} elseif (!empty($module_info)) {
			$data['name'] 		= $module_info['name'];
		} else {
			$data['name'] 		= '';
		}
		if (isset($this->request->post['status'])) {
			$data['status'] 	= $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] 	= $module_info['status'];
		} else {
			$data['status']	 	= "";
		}

		$status = $this->status();
	
		$data['main_form'] 				= $status['main_form'];
		$data['main_title'] 			= $status['main_title'];
		$data['main_short_description'] = $status['main_short_description'];

		$data['record_form'] 			= $status['record_form'];
		$data['title'] 					= $status['title'];
		$data['link'] 					= $status['link'];


		if(!empty($data['main_form'] )){
			if (isset($this->request->post['tvcmstags_main'])) {
				$data['tvcmstags_main'] = $this->request->post['tvcmstags_main'];
			} elseif (!empty($module_info)) {
				$data['tvcmstags_main'] = $module_info['tvcmstags_main'];
			} else {
				$data['tvcmstags_main'] = array();
			}
		}

		if(!empty($data['record_form'] )){
			$checkrecord   = $this->model_catalog_tvcmstags->checkdata();
			if (isset($this->request->post['tvcmstags'])) {
				$tvcmstags = $this->request->post['tvcmstags'];
			} elseif ($checkrecord->num_rows) {
				$tvcmstags = $checkrecord->rows;
			} else {
				$tvcmstags = array();
			}

			$data['tvcmstagss'] = array();

			foreach ($tvcmstags as $tvcmstags_s) {
				$data['tvcmstagss'][] = array(
					'tvcmstags_title' 	 => json_decode($tvcmstags_s['tvcmstags_title'],1),
					'tvcmstags_link'     => $tvcmstags_s['tvcmstags_link'],
					'tvcmstags_id'     	 => $tvcmstags_s['tvcmstags_id'],
					'tvcmstags_status'   => $tvcmstags_s['tvcmstags_status']
				);
			}
		}

		$data['languages'] 	= $this->model_localisation_language->getLanguages();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/tvcmstags', $data));
	}

	public function install(){

		$main 			= array();
		$main['name'] 	= "Tag";
		$main['status'] = 1;

		$this->load->model('setting/module');
		$this->load->model('localisation/language');
		$this->load->model('catalog/tvcmstags');

		$languages = $this->model_localisation_language->getLanguages();

        foreach ($languages as $value) {
        	$main['tvcmstags_main'][$value['language_id']] =  array('title'=>"Populer Tags :",'short_des'=>"Short Description");
		}

		$this->model_setting_module->addModule('tvcmstags', $main);
		
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "tvcmstags` 
		(   `tvcmstags_id` int(11) AUTO_INCREMENT,
            `tvcmstags_title` VARCHAR(255),
            `tvcmstags_link` VARCHAR(255),
            `tvcmstags_pos` int(11),
            `tvcmstags_status` int(11),
        PRIMARY KEY (`tvcmstags_id`)) ENGINE = InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;");
      
		$num_of_data = 4;
		$sub 		 = array();

	 	for ($i = 1; $i<=$num_of_data; $i++) {  	
	        foreach ($languages as $value) {
	        	$langdata['language'][$value['language_id']] = array('title' => 'tags');
			}
			$this->db->query("INSERT INTO " . DB_PREFIX . "tvcmstags SET tvcmstags_title = '" . json_encode($langdata['language']) . "', tvcmstags_link = '#', tvcmstags_pos = '" . (int)$i . "', tvcmstags_status = '1'");
    	}
	}

	public function uninstall(){
		$pre = DB_PREFIX;
		$this->db->query("DROP TABLE `{$pre}tvcmstags`");
	}

	public function ajax() {
		$this->load->model('catalog/tvcmstags');
		$update_position 	= $this->request->get['action'];
		$position 			= $this->request->get['recordsArray'];
		$return_data 		= array();
		if ($update_position == 'update_position') {
		    $return_data['success'] = 'right';
		    $this->model_catalog_tvcmstags->updatePosition($position);
		    echo $res = implode("##", $return_data);
		}
	}

	protected function status(){
		return $this->Tvcmsthemevoltystatus->tagstatus();
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/tvcmstags')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		
		return !$this->error;
	}
	
}