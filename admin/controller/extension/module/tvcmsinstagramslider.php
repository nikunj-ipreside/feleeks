<?php
class ControllerExtensionModuletvcmsinstagramslider extends Controller {
	private $error = array();
	public function index() {
		$this->load->language('extension/module/tvcmsinstagramslider');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/module');
		$this->load->model('tool/image');
		$this->load->model('localisation/language');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			
			if (!isset($this->request->get['module_id'])) {
				$this->model_setting_module->addModule('tvcmsinstagramslider', $this->request->post);
			} else {
				$this->model_setting_module->editModule($this->request->get['module_id'], $this->request->post);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] 	= $this->error['warning'];
		} else {
			$data['error_warning'] 	= '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] 	= $this->error['name'];
		} else {
			$data['error_name'] 	= '';
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
				'href' => $this->url->link('extension/module/tvcmsinstagramslider', 'user_token=' . $this->session->data['user_token'], true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/tvcmsinstagramslider', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}


		$data['languages'] 	= $this->model_localisation_language->getLanguages();


		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/tvcmsinstagramslider', 'user_token=' . $this->session->data['user_token'], true);
		} else {
			$data['action'] = $this->url->link('extension/module/tvcmsinstagramslider', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
		}

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_setting_module->getModule($this->request->get['module_id']);
		}

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$data['user_token'] = $this->session->data['user_token'];

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

		if (isset($this->request->post['tvcmsinstagramslider_username'])) {
			$data['tvcmsinstagramslider_username'] = $this->request->post['tvcmsinstagramslider_username'];
		} elseif (!empty($module_info)) {
			$data['tvcmsinstagramslider_username'] = $module_info['tvcmsinstagramslider_username'];
		} else {
			$data['tvcmsinstagramslider_username'] = "";
		}
		if (isset($this->request->post['tvcmsinstagramslider_clientid'])) {
			$data['tvcmsinstagramslider_clientid'] = $this->request->post['tvcmsinstagramslider_clientid'];
		} elseif (!empty($module_info)) {
			$data['tvcmsinstagramslider_clientid'] = $module_info['tvcmsinstagramslider_clientid'];
		} else {
			$data['tvcmsinstagramslider_clientid'] = "";
		}
		if (isset($this->request->post['tvcmsinstagramslider_clientsecret'])) {
			$data['tvcmsinstagramslider_clientsecret'] = $this->request->post['tvcmsinstagramslider_clientsecret'];
		} elseif (!empty($module_info)) {
			$data['tvcmsinstagramslider_clientsecret'] = $module_info['tvcmsinstagramslider_clientsecret'];
		} else {
			$data['tvcmsinstagramslider_clientsecret'] = "";
		}
		if (isset($this->request->post['tvcmsinstagramslider_imagenumber'])) {
			$data['tvcmsinstagramslider_imagenumber'] = $this->request->post['tvcmsinstagramslider_imagenumber'];
		} elseif (!empty($module_info)) {
			$data['tvcmsinstagramslider_imagenumber'] = $module_info['tvcmsinstagramslider_imagenumber'];
		} else {
			$data['tvcmsinstagramslider_imagenumber'] = "";
		}
		if (isset($this->request->post['tvcmsinstagramslider_accesstoken'])) {
			$data['tvcmsinstagramslider_accesstoken'] = $this->request->post['tvcmsinstagramslider_accesstoken'];
		} elseif (!empty($module_info)) {
			$data['tvcmsinstagramslider_accesstoken'] = $module_info['tvcmsinstagramslider_accesstoken'];
		} else {
			$data['tvcmsinstagramslider_accesstoken'] = "";
		}
		if (isset($this->request->post['tvcmsinstagramslider_refresh'])) {
			$data['tvcmsinstagramslider_refresh'] = $this->request->post['tvcmsinstagramslider_refresh'];
		} elseif (!empty($module_info)) {
			$data['tvcmsinstagramslider_refresh'] = $module_info['tvcmsinstagramslider_refresh'];
		} else {
			$data['tvcmsinstagramslider_refresh'] = "";
		}
		if (isset($this->request->post['tvcmsinstagramslider_imageformat'])) {
			$data['tvcmsinstagramslider_imageformat'] = $this->request->post['tvcmsinstagramslider_imageformat'];
		} elseif (!empty($module_info)) {
			$data['tvcmsinstagramslider_imageformat'] = $module_info['tvcmsinstagramslider_imageformat'];
		} else {
			$data['tvcmsinstagramslider_imageformat'] = "";
		}
		if (isset($this->request->post['tvcmsinstagramslider_rezise'])) {
			$data['tvcmsinstagramslider_rezise'] = $this->request->post['tvcmsinstagramslider_rezise'];
		} elseif (!empty($module_info)) {
			$data['tvcmsinstagramslider_rezise'] = $module_info['tvcmsinstagramslider_rezise'];
		} else {
			$data['tvcmsinstagramslider_rezise'] = "";
		}
		if (isset($this->request->post['tvcmsinstagramslider_des'])) {
			$data['tvcmsinstagramslider_des'] = $this->request->post['tvcmsinstagramslider_des'];
		} elseif (!empty($module_info)) {
			$data['tvcmsinstagramslider_des'] = $module_info['tvcmsinstagramslider_des'];
		} else {
			$data['tvcmsinstagramslider_des'] = array();
		}

		$data['header'] 		= $this->load->controller('common/header');
		$data['column_left'] 	= $this->load->controller('common/column_left');
		$data['footer']	 		= $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/tvcmsinstagramslider', $data));
	}
	public function install(){

		$this->load->model('setting/module');
		$this->load->model('localisation/language');
		$main 											= array();
		$main['name'] 									= "Instagram Slider";
		$main['status'] 								= 1;
		$main['tvcmsinstagramslider_username'] 			= "EnvatoTemplate";
		$main['tvcmsinstagramslider_clientid'] 			= "XXX";
		$main['tvcmsinstagramslider_clientsecret'] 		= "XXX";
		$main['tvcmsinstagramslider_imagenumber'] 		= "20";
		$main['tvcmsinstagramslider_accesstoken'] 		= "XXX";
		$main['tvcmsinstagramslider_refresh'] 			= "day";
		$main['tvcmsinstagramslider_imageformat']		= "thumbnail";
		$main['tvcmsinstagramslider_rezise']            = "650";
		$languages 										= $this->model_localisation_language->getLanguages();

        foreach ($languages as $value) {
        	$main['tvcmsinstagramslider_des'][$value['language_id']] = array('main_title'=>'Themevolty');
		}

		$this->model_setting_module->addModule('tvcmsinstagramslider', $main);	
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/tvcmsinstagramslider')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		return !$this->error;
	}
}
