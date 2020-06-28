<?php
class ControllerExtensionModuleTvcmsbanners extends Controller {
	private $error = array();

	public function index() {

		$this->load->language('extension/module/tvcmsbanners');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/module');
		$this->load->model('localisation/language');
		$this->load->model('tool/image');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			
			if (!isset($this->request->get['module_id'])) {
				$this->model_setting_module->addModule('tvcmsbanners', $this->request->post);
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
				'href' => $this->url->link('extension/module/tvcmsbanners', 'user_token=' . $this->session->data['user_token'], true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/tvcmsbanners', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}

		$data['text_main'] 			= $this->language->get('text_main');
		$data['text_submain'] 		= $this->language->get('text_submain');
		$data['entry_title']		= $this->language->get('entry_title');
		$data['entry_link']			= $this->language->get('entry_link');
		$data['entry_image']		= $this->language->get('entry_image');
		$data['entry_short']		= $this->language->get('entry_short');
		$data['entry_des']			= $this->language->get('entry_des');
		$data['entry_main_title']	= $this->language->get('entry_main_title');
		$data['entry_main_des']		= $this->language->get('entry_main_des');
		$data['entry_main_ban']		= $this->language->get('entry_main_ban');

		$data['user_token'] 		= $this->session->data['user_token'];
		$data['languages'] 			= $this->model_localisation_language->getLanguages();

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/tvcmsbanners', 'user_token=' . $this->session->data['user_token'], true);
		} else {
			$data['action'] = $this->url->link('extension/module/tvcmsbanners', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
		}

		$data['cancel']  = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_setting_module->getModule($this->request->get['module_id']);
		}
		$status = $this->status();
		$data['status_main_form'] 				= $status['main_form'];
    	$data['status_main_title'] 				= $status['main_title'];
    	$data['status_main_short_description'] 	= $status['main_short_description'];
    	$data['status_main_description'] 		= $status['main_description'];
    	$data['status_main_image'] 				= $status['main_image'];

    	$data['status_record_form'] 			= $status['record_form'];
    	$data['status_title'] 					= $status['title'];
    	$data['status_short_description'] 		= $status['short_description'];
    	$data['status_description'] 			= $status['description'];
    	$data['status_image'] 					= $status['image'];
    	$data['status_link'] 					= $status['link'];

		if (isset($this->error['tvcmsbanners_img'])) {
			$data['error'] = $this->error['tvcmsbanners_img'];
		} else {
			$data['error'] = "";
		}			

		if(!empty($data['status_main_form'] )){
			if (isset($this->request->post['tvcmsbanners_main'])) {
				$data['tvcmsbanners_main'] = $this->request->post['tvcmsbanners_main'];
				foreach ($this->request->post['tvcmsbanners_main'] as $key => $value) {
					if($value['img']){
						$data['img'][$key] = $this->model_tool_image->resize($value['img'], 100, 100);
					}else{
						$data['img'][$key] = $this->model_tool_image->resize('no_image.png', 100, 100);
					}
				}
			} elseif (!empty($module_info['tvcmsbanners_main'])) {
				foreach ($module_info['tvcmsbanners_main'] as $key => $value) {
					$data['img'][$key] = $this->model_tool_image->resize($value['img'], 100, 100);
				}
				$data['tvcmsbanners_main'] = $module_info['tvcmsbanners_main'];
			} else {
				foreach ($data['languages'] as $key => $value) {
					$data['img'][$value['language_id']] = $this->model_tool_image->resize('no_image.png', 100, 100);
				}
				$data['tvcmsbanners_main'] = '';
			}
		}

		if(!empty($data['status_record_form'] )){
			if (isset($this->request->post['tvcmsbanners_form'])) {
				$data['tvcmsbanners_form'] = $this->request->post['tvcmsbanners_form'];
				foreach ($this->request->post['tvcmsbanners_form'] as $key => $value) {
					if($value['tvcmsbanners_img']){
						$data['tvcmsbanners_form'][$key]['form_image'] = $this->model_tool_image->resize($value['tvcmsbanners_img'], 100, 100);
					}else{
						$data['tvcmsbanners_form'][$key]['form_image'] = $this->model_tool_image->resize('no_image.png', 100, 100);
					}
				}
			} elseif (!empty($module_info['tvcmsbanners_form'])) {
				$data['tvcmsbanners_form'] = $module_info['tvcmsbanners_form'];
				foreach ($module_info['tvcmsbanners_form'] as $key => $value) {
					if($value['tvcmsbanners_img']){
						$data['tvcmsbanners_form'][$key]['form_image'] = $this->model_tool_image->resize($value['tvcmsbanners_img'], 100, 100);
					}else{
						$data['tvcmsbanners_form'][$key]['form_image'] = $this->model_tool_image->resize('no_image.png', 100, 100);
					}
				}
			} else {
				$data['tvcmsbanners_form'] = array();
			}
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
		$data['placeholder'] 	= $this->model_tool_image->resize('no_image.png', 100, 100);
		$data['languages'] 		= $this->model_localisation_language->getLanguages();
		$data['header'] 		= $this->load->controller('common/header');
		$data['column_left'] 	= $this->load->controller('common/column_left');
		$data['footer'] 		= $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/tvcmsbanners', $data));
	}
	public function install(){
		$pre = DB_PREFIX;
		$main 			= array();
		$main['name'] 	= "Banners";
		$main['status'] = 1;

		$this->load->model('setting/module');
		$this->load->model('localisation/language');
		$languages 		= $this->model_localisation_language->getLanguages();

        foreach ($languages as $value) {
        	$main['tvcmsbanners_main'][$value['language_id']] =  array('title'=>"Best‑selling Camera",'des'=>"Up to $30,000 Off*",'short'=>"From $12.990",'img'=>"catalog/demo_main_img.png");
        	$language[$value['language_id']] = array('title'=>"Best-selling Camera",'des'=>"Up to $30,000 Off*",'short'=>"From $12.990");
		}
		

   		for ($i=1; $i <=1 ; $i++) { 
   			$main['tvcmsbanners_form'][$i] =array('language'=>$language,'title'=>"Best-selling Camera",'des'=>"From $12.990",'short'=>"Up To $30000 off*",'btncap'=>"ttv-banner-contant-right",'tvcmsbanners_img'=>"catalog/themevolty/banners/demo_img_1.jpg",'tvcmsbanners_link'=>"#",'tvcmsbanners_grid'=>"12",'tvcmsbanners_height'=>"400",'tvcmsbanners_width'=>"1328",'tvcmsbanners_status'=>"1",'tvcmsbanners_sort'=>"1");
   		}

		$this->model_setting_module->addModule('tvcmsbanners', $main);
	}
	protected function status(){
		return $this->Tvcmsthemevoltystatus->bannersstatus();
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/tvcmsbanners')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		foreach ($this->request->post['tvcmsbanners_form'] as $key => $value) {
			if ((utf8_strlen($value['tvcmsbanners_img']) < 1) || (utf8_strlen($value['tvcmsbanners_img']) > 255)) {
				$this->error['tvcmsbanners_img'][$key] = $this->language->get('error_image1');
			}
		}
		return !$this->error;
	}
}