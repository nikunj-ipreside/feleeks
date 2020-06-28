<?php
class ControllerExtensionModuleTvcmsfooterproduct extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/tvcmsfooterproduct');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/module');
		$this->load->model('localisation/language');
		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_setting_module->addModule('tvcmsfooterproduct', $this->request->post);
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
				'href' => $this->url->link('extension/module/tvcmsfooterproduct', 'user_token=' . $this->session->data['user_token'], true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/tvcmsfooterproduct', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}

		$data['entry_pro_no'] = $this->language->get('entry_pro_no');

		$data[' '] = $this->language->get('entry_new_pro_title');
		$data['entry_fea_pro_title'] = $this->language->get('entry_fea_pro_title');
		$data['entry_bes_pro_title'] = $this->language->get('entry_bes_pro_title');

		if (!isset($this->request->get['module_id'])) {
			$data['action'] 	= $this->url->link('extension/module/tvcmsfooterproduct', 'user_token=' . $this->session->data['user_token'], true);
		} else {
			$data['action'] 	= $this->url->link('extension/module/tvcmsfooterproduct', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
		}

		$data['cancel'] 		= $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

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
		if (isset($this->request->post['no_product'])) {
			$data['no_product'] = $this->request->post['no_product'];
		} elseif (!empty($module_info)) {
			$data['no_product'] = $module_info['no_product'];
		} else {
			$data['no_product'] = '';
		}

		if (isset($this->request->post['status'])) {
			$data['status'] 	= $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] 	= $module_info['status'];
		} else {
			$data['status']	 	= "";
		}

		if (isset($this->request->post['footerproducttitle'])) {
			$data['footerproducttitle'] = $this->request->post['footerproducttitle'];
		} elseif (!empty($module_info)) {
			$data['footerproducttitle'] = $module_info['footerproducttitle'];
		} else {
			$data['footerproducttitle'] = array();
		}
		
		$data['header'] 		= $this->load->controller('common/header');
		$data['column_left'] 	= $this->load->controller('common/column_left');
		$data['footer'] 		= $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/tvcmsfooterproduct', $data));
	}

	public function install(){
		$main 				= array();
		$main['name'] 		= "Footer Product";
		$main['status'] 	= 1;
		$main['no_product'] = 4;

		$this->load->model('localisation/language');
		$languages = $this->model_localisation_language->getLanguages();
        foreach ($languages as $value) {
        	$main['footerproducttitle'][$value['language_id']] =  array('new'=>"New Product",'fea'=>"Featured Product",'bes'=>"Best Product");
		}

		$this->load->model('setting/module');

		$this->model_setting_module->addModule('tvcmsfooterproduct', $main);
		
	}
	

	protected function status(){
		return $this->Tvcmsthemevoltystatus->tagstatus();
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/tvcmsfooterproduct')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		
		return !$this->error;
	}
}