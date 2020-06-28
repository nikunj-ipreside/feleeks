<?php
class ControllerExtensionModuleTvcmstwoofferbanner extends Controller {

	private $error = array();

	public function index() {
		
		$this->load->language('extension/module/tvcmstwoofferbanner');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/module');

		$status		 						= $this->status();
		$data['status_title'] 				= $status['title'];
		$data['status_short_description'] 	= $status['short_description'];
		$data['status_description'] 		= $status['description'];
		$data['status_btncaption'] 			= $status['btncaption'];
		$data['status_link'] 				= $status['link'];
		

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			if (!isset($this->request->get['module_id'])) {
				$this->model_setting_module->addModule('tvcmstwoofferbanner', $this->request->post);
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

		if (isset($this->error['tvcmstwoofferbannersub_image_1'])) {
			$data['error_tvcmstwoofferbannersub_image_1'] = $this->error['tvcmstwoofferbannersub_image_1'];
		} else {
			$data['error_tvcmstwoofferbannersub_image_1'] = array();
		}
		if (isset($this->error['tvcmstwoofferbannersub_image_2'])) {
			$data['error_tvcmstwoofferbannersub_image_2'] = $this->error['tvcmstwoofferbannersub_image_2'];
		} else {
			$data['error_tvcmstwoofferbannersub_image_2'] = array();
		}
		if (isset($this->error['tvcmstwoofferbannersub_imgwidth1'])) {
			$data['error_tvcmstwoofferbannersub_imgwidth1'] = $this->error['tvcmstwoofferbannersub_imgwidth1'];
		} else {
			$data['error_tvcmstwoofferbannersub_imgwidth1'] = array();
		}
		if (isset($this->error['tvcmstwoofferbannersub_imgwidth2'])) {
			$data['error_tvcmstwoofferbannersub_imgwidth2'] = $this->error['tvcmstwoofferbannersub_imgwidth2'];
		} else {
			$data['error_tvcmstwoofferbannersub_imgwidth2'] = array();
		}

		$url = '';

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
				'href' => $this->url->link('extension/module/tvcmstwoofferbanner', 'user_token=' . $this->session->data['user_token'], true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/tvcmstwoofferbanner', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/tvcmstwoofferbanner', 'user_token=' . $this->session->data['user_token'], true);
		} else {
			$data['action'] = $this->url->link('extension/module/tvcmstwoofferbanner', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
		}
	
		$data['cancel'] = $this->url->link('extension/module/tvcmstwoofferbanner', 'user_token=' . $this->session->data['user_token'] . $url, true);

		$data['user_token'] = $this->session->data['user_token'];

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();


		$this->load->model('tool/image');

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

		if (isset($this->request->post['tvcmstwoofferbanner'])) {
			$data['tvcmstwoofferbanner'] = $this->request->post['tvcmstwoofferbanner'];
			foreach ($this->request->post['tvcmstwoofferbanner'] as $key => $value) {
				if($value['tvcmstwoofferbannersub_image_1']){
					$data['img_1'][$key] =  $this->model_tool_image->resize($value['tvcmstwoofferbannersub_image_1'], 100, 100);				
				}else{
					$data['img_1'][$key] =  $this->model_tool_image->resize('no_image.png', 100, 100);				
				}
				if($value['tvcmstwoofferbannersub_image_2']){
					$data['img_2'][$key] =  $this->model_tool_image->resize($value['tvcmstwoofferbannersub_image_2'], 100, 100);
				}else{
					$data['img_2'][$key] =  $this->model_tool_image->resize('no_image.png', 100, 100);
				}				
			}
		} elseif (!empty($module_info)) {
			$data['tvcmstwoofferbanner'] = $module_info['tvcmstwoofferbanner'];
			foreach ($data['tvcmstwoofferbanner'] as $key => $value) {
				$data['img_1'][$key] 	 =  $this->model_tool_image->resize($value['tvcmstwoofferbannersub_image_1'], 100, 100);				
				$data['img_2'][$key] 	 =  $this->model_tool_image->resize($value['tvcmstwoofferbannersub_image_2'], 100, 100);				
			}
		} else {
			foreach ($data['languages'] as $key => $value) {
				$data['img_1'][$value['language_id']] =  $this->model_tool_image->resize('no_image.png', 100, 100);				
				$data['img_2'][$value['language_id']] =  $this->model_tool_image->resize('no_image.png', 100, 100);
			}
			$data['tvcmstwoofferbanner'] = array();
		} 
		
		
		$data['placeholder'] 	= $this->model_tool_image->resize('no_image.png', 100, 100);
		
		$data['header'] 		= $this->load->controller('common/header');
		$data['column_left'] 	= $this->load->controller('common/column_left');
		$data['footer'] 		= $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/tvcmstwoofferbanner_form', $data));
	}

	public function install(){
		$this->load->model('setting/module');
		$this->load->model('localisation/language');
		$this->load->model('catalog/tvcmscategoryslider');

		$main 			= array();
		$main['name'] 	= "Two Banner";
		$main['status'] = 1;
		
		$languages      = $this->model_localisation_language->getLanguages();
        foreach ($languages as $value) {
        	$main['tvcmstwoofferbanner'][$value['language_id']] =  array(
        		'tvcmstwoofferbannersub_image_1'=>"catalog/themevolty/twobannar/demo_img_1.jpg",'tvcmstwoofferbannersub_img_btn_1'=>"Shop now",'tvcmstwoofferbannersub_link_1'=>"#","tvcmstwoofferbannersub_img_title_1" => "motoz3","tvcmstwoofferbannersub_img_subtitle_1" => "World's First 5G-upgradable","tvcmstwoofferbannersub_img_description_1" => "description","tvcmstwoofferbannersub_img_align_1" => "ttv-banner-contant-left",'tvcmstwoofferbannersub_width_1'=>"880",'tvcmstwoofferbannersub_height_1'=>"400",'tvcmstwoofferbannersub_image_2'=>"catalog/themevolty/twobannar/demo_img_2.jpg",'tvcmstwoofferbannersub_img_btn_2'=>"Shop now",'tvcmstwoofferbannersub_link_2'=>"#","tvcmstwoofferbannersub_img_title_2" => "Wireless. Effortless. Magical.","tvcmstwoofferbannersub_img_subtitle_2" => "Airpods","tvcmstwoofferbannersub_img_description_2" => "description","tvcmstwoofferbannersub_img_align_2" => "ttv-banner-contant-center",'tvcmstwoofferbannersub_width_2'=>"433",'tvcmstwoofferbannersub_height_2'=>"400"
        		);
		}
		$this->model_setting_module->addModule('tvcmstwoofferbanner', $main);
	}

	protected function validate() {

		if (!$this->user->hasPermission('modify', 'extension/module/tvcmstwoofferbanner')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		foreach ($this->request->post['tvcmstwoofferbanner'] as $language_id => $value) {
			if ((utf8_strlen($value['tvcmstwoofferbannersub_image_1']) < 1) || (utf8_strlen($value['tvcmstwoofferbannersub_image_1']) > 255)) {
				$this->error['tvcmstwoofferbannersub_image_1'][$language_id] = $this->language->get('error_image1');
			}
			if ((utf8_strlen($value['tvcmstwoofferbannersub_image_2']) < 1) || (utf8_strlen($value['tvcmstwoofferbannersub_image_2']) > 255)) {
				$this->error['tvcmstwoofferbannersub_image_2'][$language_id] = $this->language->get('error_image2');
			}	
			if (empty($value['tvcmstwoofferbannersub_width_1']) || !is_numeric($value['tvcmstwoofferbannersub_width_1']) || empty($value['tvcmstwoofferbannersub_height_1']) || !is_numeric($value['tvcmstwoofferbannersub_height_1'])) {
				$this->error['tvcmstwoofferbannersub_imgwidth1'][$language_id] = $this->language->get('error_width1');
			}
			if (empty($value['tvcmstwoofferbannersub_width_2']) || !is_numeric($value['tvcmstwoofferbannersub_width_2']) || empty($value['tvcmstwoofferbannersub_height_2']) || !is_numeric($value['tvcmstwoofferbannersub_height_2'])) {
				$this->error['tvcmstwoofferbannersub_imgwidth2'][$language_id] = $this->language->get('error_width2');
			}			
		}



		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}
	protected function status(){
		return $this->Tvcmsthemevoltystatus->twobannersstatus();
	}
	
}
