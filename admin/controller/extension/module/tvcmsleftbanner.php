<?php
class ControllerExtensionModuletvcmsleftbanner extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/tvcmsleftbanner');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/module');
		$this->load->model('localisation/language');
		$this->load->model('tool/image');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			if (!isset($this->request->get['module_id'])) {
				$this->model_setting_module->addModule('tvcmsleftbanner', $this->request->post);
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
		if (isset($this->error['image'])) {
			$data['error_image'] = $this->error['image'];
		} else {
			$data['error_image'] = array();
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
				'href' => $this->url->link('extension/module/tvcmsleftbanner', 'user_token=' . $this->session->data['user_token'], true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/tvcmsleftbanner', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}
		$data['entry_image'] 	= $this->language->get('entry_image');
		
		if (!isset($this->request->get['module_id'])) {
			$data['action'] 	= $this->url->link('extension/module/tvcmsleftbanner', 'user_token=' . $this->session->data['user_token'], true);
		} else {
			$data['action'] 	= $this->url->link('extension/module/tvcmsleftbanner', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
		}

		$data['cancel'] 		= $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);
		$data['languages'] 		= $this->model_localisation_language->getLanguages();

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
		
		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
			foreach ($data['image'] as $key => $value) {
				if(!empty($value)){
					$data['img'][$key] 	= $this->model_tool_image->resize($value, 100, 100);
				}else{
					$data['img'][$key]  = $this->model_tool_image->resize('no_image.png', 100, 100);
				}
			}
		} elseif (!empty($module_info)) {
			$data['image'] = $module_info['image'];
			foreach ($module_info['image'] as $key => $value) {
				if(!empty($value)){
					$data['img'][$key] 	= $this->model_tool_image->resize($value, 100, 100);
				}else{
					$data['img'][$key]  = $this->model_tool_image->resize('no_image.png', 100, 100);
				}
			}
		} else {
			foreach ($data['languages'] as $key => $value) {
				$data['img'][$value['language_id']]        = $this->model_tool_image->resize('no_image.png', 100, 100);
			}
			$data['image'] = array();
		}

		$data['header'] 		= $this->load->controller('common/header');
		$data['column_left'] 	= $this->load->controller('common/column_left');
		$data['footer'] 		= $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/tvcmsleftbanner', $data));
	}

	public function install(){
		$main 						= array();
		$main['name'] 				= "Left Banner";
		$main['status'] 			= "1";

		$this->load->model('localisation/language');
		$language = $this->model_localisation_language->getLanguages();
		foreach ($language as $key => $value) {
			$main['image'][$value['language_id']] = "catalog/themevolty/leftbanner/Left_Penal_Banner.jpg";
		}

		$this->load->model('setting/module');
		
		$this->model_setting_module->addModule('tvcmsleftbanner', $main);
		
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/tvcmsleftbanner')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		
		foreach ($this->request->post['image'] as $language_id => $value) {
			if ((utf8_strlen($value) < 1) || (utf8_strlen($value) > 255)) {
				$this->error['image'][$language_id] = $this->language->get('error_image');
			}
		}

		return !$this->error;
	}
}
