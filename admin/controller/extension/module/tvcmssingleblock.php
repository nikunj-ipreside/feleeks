<?php
class ControllerExtensionModuletvcmssingleblock extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/tvcmssingleblock');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/module');
		$this->load->model('tool/image');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			
			if (!isset($this->request->get['module_id'])) {
				$this->model_setting_module->addModule('tvcmssingleblock', $this->request->post);
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
				'href' => $this->url->link('extension/module/tvcmssingleblock', 'user_token=' . $this->session->data['user_token'], true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/tvcmssingleblock', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/tvcmssingleblock', 'user_token=' . $this->session->data['user_token'], true);
		} else {
			$data['action'] = $this->url->link('extension/module/tvcmssingleblock', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
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
			if (isset($this->request->post['tvcmssingleblock_link'])) {
				$data['tvcmssingleblock_link'] = $this->request->post['tvcmssingleblock_link'];
			} elseif (!empty($module_info)) {
				$data['tvcmssingleblock_link'] = $module_info['tvcmssingleblock_link'];
			} else {
				$data['tvcmssingleblock_link'] = '';
			}
		}
		
		$no_image = $this->model_tool_image->resize('no_image.png', 100, 100);
		if (isset($this->request->post['tvcmssingleblock'])) {
			$data['tvcmssingleblock'] = $this->request->post['tvcmssingleblock'];
			foreach ($data['tvcmssingleblock'] as $key => $value) {
				if(!empty($value['image'])){
					$data['record_img1'][$key] = $this->model_tool_image->resize($value['image1'], 100, 100);
					$data['record_img2'][$key] = $this->model_tool_image->resize($value['image2'], 100, 100);
					$data['record_img3'][$key] = $this->model_tool_image->resize($value['image3'], 100, 100);
					$data['record_img'][$key] = $this->model_tool_image->resize($value['image'], 100, 100);
				}else{
					$data['record_img1'][$key] = $no_image;
					$data['record_img2'][$key] = $no_image;
					$data['record_img3'][$key] = $no_image;
					$data['record_img'][$key] = $no_image;
				}
				if(!empty($value['main_image'])){
					$data['main_img'][$key] = $this->model_tool_image->resize($value['main_image'], 100, 100);
				}else{
					$data['main_img'][$key] = $no_image;
				}
			}
		} elseif (!empty($module_info['tvcmssingleblock'])) {
			$data['tvcmssingleblock'] = $module_info['tvcmssingleblock'];
			foreach ($data['tvcmssingleblock'] as $key => $value) {
				if(!empty($value['image'])){
					$data['record_img1'][$key] = $this->model_tool_image->resize($value['image1'], 100, 100);
					$data['record_img2'][$key] = $this->model_tool_image->resize($value['image2'], 100, 100);
					$data['record_img3'][$key] = $this->model_tool_image->resize($value['image3'], 100, 100);
					$data['record_img'][$key] = $this->model_tool_image->resize($value['image'], 100, 100);
				}else{
					$data['record_img1'][$key] = $no_image;
					$data['record_img2'][$key] = $no_image;
					$data['record_img3'][$key] = $no_image;
					$data['record_img'][$key] = $no_image;
				}
				if(!empty($value['main_image'])){
					$data['main_img'][$key] = $this->model_tool_image->resize($value['main_image'], 100, 100);
				}else{
					$data['main_img'][$key] = $no_image;
				}
			}
		} else {
			$data['tvcmssingleblock'] = array();
			foreach ($data['languages'] as $key => $value) {
				$data['record_img1'][$value['language_id']] = $no_image;
				$data['record_img2'][$value['language_id']] = $no_image;
				$data['record_img3'][$value['language_id']] = $no_image;
				$data['record_img'][$value['language_id']] = $no_image;
				$data['main_img'][$value['language_id']] = $no_image;
			}
		}
	
		$data['header'] 		= $this->load->controller('common/header');
		$data['column_left'] 	= $this->load->controller('common/column_left');
		$data['footer']	 		= $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/tvcmssingleblock', $data));
	}
	public function install(){

		$main 			= array();
		$main['name'] 	= "Single blocks";
		$main['status'] = 1;

		$this->load->model('setting/module');
		$this->load->model('localisation/language');

		$languages = $this->model_localisation_language->getLanguages();

        foreach ($languages as $value) {
        	$main['tvcmssingleblock_link'] = "#";
        	$main['tvcmssingleblock'][$value['language_id']] = array('image1'=>'catalog/themevolty/singleblock/demo_img_1.png','image2'=>'catalog/themevolty/singleblock/demo_img_2.png','image3'=>'catalog/themevolty/singleblock/demo_img_3.png','image'=>'catalog/themevolty/singleblock/icon.png','title'=>'Get Upto 20% off','short_description'=>'SHOP ABOVE $500 & GET','description'=>'FOR YOUR NEXT PURCHASE','button_caption'=>'Explore More','main_image'=>'catalog/themevolty/singleblock/main_About-us.jpg','main_title'=>'Main Title','main_short_description'=>'Get 10% off your purchase, exclusive news + giveaways!','main_description'=>'We are a global housewares product design company. We bring thought and creativity to everyday items through original design.Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.');
		}

		$this->model_setting_module->addModule('tvcmssingleblock', $main);
	
	}
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/tvcmssingleblock')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		return !$this->error;
	}
	protected function status(){
		return $this->Tvcmsthemevoltystatus->singleblock();
	}
}
