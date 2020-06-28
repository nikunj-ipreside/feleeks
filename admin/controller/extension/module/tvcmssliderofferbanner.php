<?php
class ControllerExtensionModuletvcmssliderofferbanner extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/tvcmssliderofferbanner');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/module');
		$this->load->model('tool/image');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			
			if (!isset($this->request->get['module_id'])) {
				$this->model_setting_module->addModule('tvcmssliderofferbanner', $this->request->post);
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
				'href' => $this->url->link('extension/module/tvcmssliderofferbanner', 'user_token=' . $this->session->data['user_token'], true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/tvcmssliderofferbanner', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/tvcmssliderofferbanner', 'user_token=' . $this->session->data['user_token'], true);
		} else {
			$data['action'] = $this->url->link('extension/module/tvcmssliderofferbanner', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
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

		$status		 						= $this->status();
		$data['link'] 						= $status['link'];
		$data['image'] 						= $status['image'];
		$data['title'] 						= $status['title'];
		$data['shortdescription'] 			= $status['shortdescription'];
		$data['description'] 				= $status['description'];
		$data['buttoncaption'] 				= $status['buttoncaption'];
		$data['main_image'] 				= $status['main_image'];
		$data['main_title'] 				= $status['main_title'];
		$data['main_shortdescription'] 		= $status['main_sub_title'];
		$data['main_description'] 			= $status['main_description'];

		if(!empty($data['link'])){
			if (isset($this->request->post['tvcmssliderofferbanner_link'])) {
				$data['tvcmssliderofferbanner_link'] = $this->request->post['tvcmssliderofferbanner_link'];
			} elseif (!empty($module_info)) {
				$data['tvcmssliderofferbanner_link'] = $module_info['tvcmssliderofferbanner_link'];
			} else {
				$data['tvcmssliderofferbanner_link'] = '';
			}
		}
		
		$no_image = $this->model_tool_image->resize('no_image.png', 100, 100);
		if (isset($this->request->post['tvcmssliderofferbanner'])) {
			$data['tvcmssliderofferbanner'] = $this->request->post['tvcmssliderofferbanner'];
			foreach ($data['tvcmssliderofferbanner'] as $key => $value) {
				if(!empty($value['image'])){
					$data['record_img'][$key] = $this->model_tool_image->resize($value['image'], 100, 100);
				}else{
					$data['record_img'][$key] = $no_image;
				}
				if(!empty($value['main_image'])){
					$data['main_img'][$key] = $this->model_tool_image->resize($value['main_image'], 100, 100);
				}else{
					$data['main_img'][$key] = $no_image;
				}
			}
		} elseif (!empty($module_info['tvcmssliderofferbanner'])) {
			$data['tvcmssliderofferbanner'] = $module_info['tvcmssliderofferbanner'];
			foreach ($data['tvcmssliderofferbanner'] as $key => $value) {
				if(!empty($value['image'])){
					$data['record_img'][$key] = $this->model_tool_image->resize($value['image'], 100, 100);
				}else{
					$data['record_img'][$key] = $no_image;
				}
				if(!empty($value['main_image'])){
					$data['main_img'][$key] = $this->model_tool_image->resize($value['main_image'], 100, 100);
				}else{
					$data['main_img'][$key] = $no_image;
				}
			}
		} else {
			$data['tvcmssliderofferbanner'] = array();
			foreach ($data['languages'] as $key => $value) {
				$data['record_img'][$value['language_id']] = $no_image;
				$data['main_img'][$value['language_id']] = $no_image;
			}
		}
	
		$data['header'] 		= $this->load->controller('common/header');
		$data['column_left'] 	= $this->load->controller('common/column_left');
		$data['footer']	 		= $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/tvcmssliderofferbanner', $data));
	}
	public function install(){

		$main 			= array();
		$main['name'] 	= "Slider Offer Banner";
		$main['status'] = 1;

		$this->load->model('setting/module');
		$this->load->model('localisation/language');

		$languages = $this->model_localisation_language->getLanguages();

        foreach ($languages as $value) {
        	$main['tvcmssliderofferbanner_link'] = "#";
        	$main['tvcmssliderofferbanner'][$value['language_id']] = array('image'=>'catalog/themevolty/sliderofferbanner/Slider_Banner.jpg','title'=>'Fashion Collection','short_description'=>'Get 10% off your purchase, exclusive news + giveaways!','description'=>'We are a global housewares product design company. We bring thought and creativity to everyday items through original design.','button_caption'=>'Shop Now','alignment'=>'center','main_image'=>'catalog/themevolty/sliderofferbanner/Slider_Banner.jpg','main_title'=>'Main Title','main_short_description'=>'Get 10% off your purchase, exclusive news + giveaways!','main_description'=>'We are a global housewares product design company. We bring thought and creativity to everyday items through original design.Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.');
		}

		$this->model_setting_module->addModule('tvcmssliderofferbanner', $main);
	
	}
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/tvcmssliderofferbanner')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		return !$this->error;
	}
	protected function status(){
		return $this->Tvcmsthemevoltystatus->sliderofferbanner();
	}
}
