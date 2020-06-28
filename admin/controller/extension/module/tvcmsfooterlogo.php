<?php
class ControllerExtensionModuletvcmsfooterlogo extends Controller {
	private $error = array();
	public function index() {
		$this->load->language('extension/module/tvcmsfooterlogo');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/module');
		$this->load->model('tool/image');
		$this->load->model('localisation/language');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			
			if (!isset($this->request->get['module_id'])) {
				$this->model_setting_module->addModule('tvcmsfooterlogo', $this->request->post);
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

		$data['breadcrumbs'] 		= array();

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
				'href' => $this->url->link('extension/module/tvcmsfooterlogo', 'user_token=' . $this->session->data['user_token'], true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/tvcmsfooterlogo', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}

		$status = $this->status();


		$data['main_form'] 				= $status['main_form'];
		$data['main_title'] 			= $status['main_title'];
		$data['main_short_description'] = $status['main_short_description'];
		$data['main_description'] 		= $status['main_description'];
		$data['main_image'] 			= $status['main_image'];


		$data['languages'] 	= $this->model_localisation_language->getLanguages();

		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_short_des'] = $this->language->get('entry_short_des');
		$data['entry_des'] = $this->language->get('entry_des');
		$data['entry_img'] = $this->language->get('entry_img');
		$data['entry_logo_img'] = $this->language->get('entry_logo_img');
		$data['entry_btn_title'] = $this->language->get('entry_btn_title');
		$data['entry_api_key'] = $this->language->get('entry_api_key');
		$data['entry_map_type'] = $this->language->get('entry_map_type');
		$data['entry_let'] = $this->language->get('entry_let');
		$data['entry_lon'] = $this->language->get('entry_lon');
		$data['entry_zoom'] = $this->language->get('entry_zoom');
		$data['entry_main_des'] = $this->language->get('entry_main_des');
		$data['entry_sub_title'] = $this->language->get('entry_sub_title');

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/tvcmsfooterlogo', 'user_token=' . $this->session->data['user_token'], true);
		} else {
			$data['action'] = $this->url->link('extension/module/tvcmsfooterlogo', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
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

		if(isset($data['main_form'])){
			if (isset($this->request->post['tvcmsfooterlogo_des'])) {
				$data['tvcmsfooterlogo_des'] = $this->request->post['tvcmsfooterlogo_des'];
				foreach ($this->request->post['tvcmsfooterlogo_des'] as $key => $value) {
					if($value['main_img']){
						$data['main_img'][$key] =  $this->model_tool_image->resize($value['main_img'], 100, 100);				
					}else{
						$data['main_img'][$key] =  $this->model_tool_image->resize('no_image.png', 100, 100);
					}
				}
			} elseif (!empty($module_info)) {
				$data['tvcmsfooterlogo_des'] = $module_info['tvcmsfooterlogo_des'];
				foreach ($module_info['tvcmsfooterlogo_des'] as $key => $value) {
					$data['main_img'][$key] =  $this->model_tool_image->resize($value['main_img'], 100, 100);				
				}
			} else {
				foreach ($data['languages'] as $key => $value) {
					$data['main_img'][$value['language_id']] =  $this->model_tool_image->resize('no_image.png', 100, 100);				
				}
				$data['tvcmsfooterlogo_des'] = array();
			}
		}
		$data['header'] 		= $this->load->controller('common/header');
		$data['column_left'] 	= $this->load->controller('common/column_left');
		$data['footer']	 		= $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/tvcmsfooterlogo', $data));
	}
	public function install(){

		$main 			= array();
		$main['name'] 	= "Footer Logo";
		$main['status'] = 1;

		$this->load->model('setting/module');
		$this->load->model('localisation/language');

		$languages = $this->model_localisation_language->getLanguages();

        foreach ($languages as $value) {
        	$main['tvcmsfooterlogo_des'][$value['language_id']] = array('main_img'=>'catalog/themevolty/footerlogo/demo_img_1.png','main_title'=>'themevolty','main_des'=>'Description','Lorem Ipsum is simply dummy text of the printing and typesetting industry.'=>'Lorem Ipsum is simply dummy text of the printing and typesetting industry.','main_short_des'=>'Lorem Ipsum is simply dummy text of the printing and typesetting industry.');
		}

		$this->model_setting_module->addModule('tvcmsfooterlogo', $main);
	
	}

	protected function status(){
		return $this->Tvcmsthemevoltystatus->footerstatus();
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/tvcmsfooterlogo')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		return !$this->error;
	}
}
