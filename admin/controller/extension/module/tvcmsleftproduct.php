<?php
class ControllerExtensionModuletvcmsleftproduct extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/tvcmsleftproduct');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/module');
		$this->load->model('localisation/language');


		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			if (!isset($this->request->get['module_id'])) {
				$this->model_setting_module->addModule('tvcmsleftproduct', $this->request->post);
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
				'href' => $this->url->link('extension/module/tvcmsleftproduct', 'user_token=' . $this->session->data['user_token'], true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/tvcmsleftproduct', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}
		$data['entry_featured'] 	= $this->language->get('entry_featured');
		$data['entry_new'] 			= $this->language->get('entry_new');
		$data['entry_best'] 		= $this->language->get('entry_best');
		$data['entry_special'] 		= $this->language->get('entry_special');
		
		if (!isset($this->request->get['module_id'])) {
			$data['action'] 	= $this->url->link('extension/module/tvcmsleftproduct', 'user_token=' . $this->session->data['user_token'], true);
		} else {
			$data['action'] 	= $this->url->link('extension/module/tvcmsleftproduct', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
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
		
		if (isset($this->request->post['status'])) {
			$data['status'] 	= $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] 	= $module_info['status'];
		} else {
			$data['status']	 	= "";
		}
		if (isset($this->request->post['status_left_feature'])) {
			$data['status_left_feature'] 	= $this->request->post['status_left_feature'];
		} elseif (!empty($module_info)) {
			$data['status_left_feature'] 	= $module_info['status_left_feature'];
		} else {
			$data['status_left_feature']	 	= "";
		}
		if (isset($this->request->post['left_feature_title'])) {
			$data['left_feature_title'] 	= $this->request->post['left_feature_title'];
		} elseif (!empty($module_info)) {
			$data['left_feature_title'] 	= $module_info['left_feature_title'];
		} else {
			$data['left_feature_title']	 	= "";
		}
		if (isset($this->request->post['status_left_new'])) {
			$data['status_left_new'] 		= $this->request->post['status_left_new'];
		} elseif (!empty($module_info)) {
			$data['status_left_new'] 		= $module_info['status_left_new'];
		} else {
			$data['status_left_new']	 		= "";
		}
		if (isset($this->request->post['left_new_title'])) {
			$data['left_new_title'] 	= $this->request->post['left_new_title'];
		} elseif (!empty($module_info)) {
			$data['left_new_title'] 	= $module_info['left_new_title'];
		} else {
			$data['left_new_title']	 	= "";
		}
		if (isset($this->request->post['status_left_best'])) {
			$data['status_left_best'] 		= $this->request->post['status_left_best'];
		} elseif (!empty($module_info)) {
			$data['status_left_best'] 		= $module_info['status_left_best'];
		} else {
			$data['status_left_best']	 	= "";
		}
		if (isset($this->request->post['left_best_title'])) {
			$data['left_best_title'] 	= $this->request->post['left_best_title'];
		} elseif (!empty($module_info)) {
			$data['left_best_title'] 	= $module_info['left_best_title'];
		} else {
			$data['left_best_title']	 	= "";
		}
		if (isset($this->request->post['status_left_special'])) {
			$data['status_left_special'] 	= $this->request->post['status_left_special'];
		} elseif (!empty($module_info)) {
			$data['status_left_special'] 	= $module_info['status_left_special'];
		} else {
			$data['status_left_special']	 	= "";
		}
		if (isset($this->request->post['left_special_title'])) {
			$data['left_special_title'] 	= $this->request->post['left_special_title'];
		} elseif (!empty($module_info)) {
			$data['left_special_title'] 	= $module_info['left_special_title'];
		} else {
			$data['left_special_title']	 	= "";
		}



		if (isset($this->request->post['status_right_feature'])) {
			$data['status_right_feature'] 	= $this->request->post['status_right_feature'];
		} elseif (!empty($module_info)) {
			$data['status_right_feature'] 	= $module_info['status_right_feature'];
		} else {
			$data['status_right_feature']	 	= "";
		}
		if (isset($this->request->post['right_feature_title'])) {
			$data['right_feature_title'] 	= $this->request->post['right_feature_title'];
		} elseif (!empty($module_info)) {
			$data['right_feature_title'] 	= $module_info['right_feature_title'];
		} else {
			$data['right_feature_title']	 	= "";
		}
		if (isset($this->request->post['status_right_new'])) {
			$data['status_right_new'] 		= $this->request->post['status_right_new'];
		} elseif (!empty($module_info)) {
			$data['status_right_new'] 		= $module_info['status_right_new'];
		} else {
			$data['status_right_new']	 		= "";
		}
		if (isset($this->request->post['right_new_title'])) {
			$data['right_new_title'] 	= $this->request->post['right_new_title'];
		} elseif (!empty($module_info)) {
			$data['right_new_title'] 	= $module_info['right_new_title'];
		} else {
			$data['right_new_title']	 	= "";
		}
		if (isset($this->request->post['status_right_best'])) {
			$data['status_right_best'] 		= $this->request->post['status_right_best'];
		} elseif (!empty($module_info)) {
			$data['status_right_best'] 		= $module_info['status_right_best'];
		} else {
			$data['status_right_best']	 	= "";
		}
		if (isset($this->request->post['right_best_title'])) {
			$data['right_best_title'] 	= $this->request->post['right_best_title'];
		} elseif (!empty($module_info)) {
			$data['right_best_title'] 	= $module_info['right_best_title'];
		} else {
			$data['right_best_title']	 	= "";
		}
		if (isset($this->request->post['status_right_special'])) {
			$data['status_right_special'] 	= $this->request->post['status_right_special'];
		} elseif (!empty($module_info)) {
			$data['status_right_special'] 	= $module_info['status_right_special'];
		} else {
			$data['status_right_special']	 	= "";
		}
		if (isset($this->request->post['right_special_title'])) {
			$data['right_special_title'] 	= $this->request->post['right_special_title'];
		} elseif (!empty($module_info)) {
			$data['right_special_title'] 	= $module_info['right_special_title'];
		} else {
			$data['right_special_title']	 	= "";
		}

		$data['header'] 		= $this->load->controller('common/header');
		$data['column_left'] 	= $this->load->controller('common/column_left');
		$data['footer'] 		= $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/tvcmsleftproduct', $data));
	}

	public function install(){
		$main 						= array();
		$main['name'] 					= "Left Right Product";
		$main['status'] 				= "1";
		$main['status_left_feature'] 	= "0";
		$main['left_feature_title'] 	= "Feature Products";
		$main['status_left_new'] 		= "0";
		$main['left_new_title'] 	   	= "New Products";
		$main['status_left_best'] 		= "1";
		$main['left_best_title']    	= "Best Products";
		$main['status_left_special'] 	= "0";
		$main['left_special_title']    	= "Special Products";

		$main['status_right_feature'] 	= "0";
		$main['right_feature_title'] 	= "Feature Products";
		$main['status_right_new'] 		= "0";
		$main['right_new_title'] 	   	= "New Products";
		$main['status_right_best'] 		= "0";
		$main['right_best_title']    	= "Best Products";
		$main['status_right_special'] 	= "0";
		$main['right_special_title']    = "Special Products";

		$this->load->model('setting/module');

		$this->model_setting_module->addModule('tvcmsleftproduct', $main);
		
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/tvcmsleftproduct')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		
		return !$this->error;
	}
}
