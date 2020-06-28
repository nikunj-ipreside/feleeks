<?php
class ControllerExtensionModuletvcmsmultibanner extends Controller {

	private $error = array();

	public function index() {
				
		$this->load->language('extension/module/tvcmsmultibanner');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/module');

		$this->load->model('tool/image');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			if (!isset($this->request->get['module_id'])) {
				$this->model_setting_module->addModule('tvcmsmultibanner', $this->request->post);
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

		$status = $this->status();
		
		$data['main_form'] 				= $status['main_form'];
		$data['main_title'] 			= $status['main_title'];
		$data['main_short_description'] = $status['main_short_description'];
		$data['main_description'] 		= $status['main_description'];
		$data['main_image'] 			= $status['main_image'];
		$data['record_form'] 			= $status['record_form'];
		$data['num_services'] 			= $status['num_services'];
		$data['image_upload'] 			= $status['image_upload'];

		$data['title'] 					= $status['title'];
		$data['subtitle'] 				= $status['subtitle'];
		$data['description'] 			= $status['description'];
		$data['btncaption'] 			= $status['btncaption'];

		for ($i=1; $i <= $data['num_services']; $i++) { 
			if (isset($this->error['tvcmsmultibanner_img_'.$i.''])) {
				$data['error'][$i] = $this->error['tvcmsmultibanner_img_'.$i.''];
			} else {
				$data['error'][$i] = "";
			}			
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
				'href' => $this->url->link('extension/module/tvcmsmultibanner', 'user_token=' . $this->session->data['user_token'], true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/tvcmsmultibanner', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}

		$data['entry_name'] 	    = $this->language->get('entry_name');
		$data['entry_status'] 	    = $this->language->get('entry_status');
		$data['entry_cservices1'] 	= $this->language->get('entry_cservices1');
		$data['entry_cservices2'] 	= $this->language->get('entry_cservices2');
		$data['entry_cservices3'] 	= $this->language->get('entry_cservices3');
		$data['column_status1'] 	= $this->language->get('column_status1');
		$data['column_status_des1'] = $this->language->get('column_status_des1');
		$data['column_image1'] 		= $this->language->get('column_image1');
		$data['column_image1_des'] 	= $this->language->get('column_image1_des');
		$data['column_cap1'] 		= $this->language->get('column_cap1');
		$data['column_cap1_des'] 	= $this->language->get('column_cap1_des');
		$data['column_des1'] 		= $this->language->get('column_des1');
		$data['column_des1_des'] 	= $this->language->get('column_des1_des');
		$data['entry_title'] 		= $this->language->get('entry_title');
		$data['entry_short_des'] 	= $this->language->get('entry_short_des');
		$data['entry_des'] 			= $this->language->get('entry_des');
		$data['entry_img'] 			= $this->language->get('entry_img');

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/tvcmsmultibanner', 'user_token=' . $this->session->data['user_token'], true);
		} else {
			$data['action'] = $this->url->link('extension/module/tvcmsmultibanner', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
		}

		$data['cancel'] 	= $this->url->link('extension/module/tvcmsmultibanner', 'user_token=' . $this->session->data['user_token'] . $url, true);

		$data['user_token'] = $this->session->data['user_token'];

		$this->load->model('localisation/language');

		$data['languages'] 	= $this->model_localisation_language->getLanguages();

		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info  = $this->model_setting_module->getModule($this->request->get['module_id']);
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

		if(isset($data['record_form'])){
			if (isset($this->request->post['tvcmsmultibanner'])) {
				$data['tvcmsmultibanner'] = $this->request->post['tvcmsmultibanner'];
				foreach ($this->request->post['tvcmsmultibanner'] as $key => $value) {
					for ($i=1; $i <= $data['num_services']; $i++) { 
						if($value['tvcmsmultibanner_img_'.$i.'']){
							$data['aa'][$key]['img_'.$i.''] =  $this->model_tool_image->resize($value['tvcmsmultibanner_img_'.$i.''], 100, 100);				
						}else{
							$data['aa'][$key]['img_'.$i.''] =  $this->model_tool_image->resize('no_image.png', 100, 100);				
						}		
					}
				}
			} elseif (!empty($module_info['tvcmsmultibanner'])) {
				$data['tvcmsmultibanner'] = $module_info['tvcmsmultibanner'];
				foreach ($data['tvcmsmultibanner'] as $key => $value) {
					for ($i=1; $i <= $data['num_services']; $i++) {
						if(!empty($value['tvcmsmultibanner_img_'.$i.''])){
							$data['aa'][$key]['img_'.$i.''] =  $this->model_tool_image->resize($value['tvcmsmultibanner_img_'.$i.''], 100, 100);				
						}else{
							$data['aa'][$key]['img_'.$i.''] =  $this->model_tool_image->resize('no_image.png', 100, 100);
						}
						
					}
				}
			} else{
				foreach ($data['languages'] as $key => $value) {
					for ($i=1; $i <= $data['num_services']; $i++) { 
						$data['aa'][$value['language_id']]['img_'.$i.''] =  $this->model_tool_image->resize('no_image.png', 100, 100);
					}
				}
				$data['tvcmsmultibanner'] = array();
			}
		}

		if(isset($data['main_form'])){
			if (isset($this->request->post['tvcmsmultibanner_main'])) {
				$data['tvcmsmultibanner_main'] = $this->request->post['tvcmsmultibanner_main'];
				foreach ($this->request->post['tvcmsmultibanner_main'] as $key => $value) {
					if($value['tvcmsmultibanner_main_img']){
						$data['img_1'][$key] = $this->model_tool_image->resize($value['tvcmsmultibanner_main_img'], 100, 100);				
					}else{
						$data['img_1'][$key] = $this->model_tool_image->resize('no_image.png', 100, 100);				
					}
				}
			} elseif (!empty($module_info['tvcmsmultibanner_main'])) {
				$data['tvcmsmultibanner_main'] = $module_info['tvcmsmultibanner_main'];
				foreach ($data['tvcmsmultibanner_main'] as $key => $value) {
					$data['img_1'][$key] = $this->model_tool_image->resize($value['tvcmsmultibanner_main_img'], 100, 100);		
				}
			} else{
				foreach ($data['languages'] as $key => $value) {
					$data['img_1'][$value['language_id']] = $this->model_tool_image->resize('no_image.png', 100, 100);
				}
				$data['tvcmsmultibanner_main'] = array();
			}
		}
		
		$data['placeholder'] 	= $this->model_tool_image->resize('no_image.png', 100, 100);
		$data['header'] 		= $this->load->controller('common/header');
		$data['column_left'] 	= $this->load->controller('common/column_left');
		$data['footer'] 		= $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/tvcmsmultibanner_form', $data));
	}
	public function install(){

		$main 			= array();
		$main['status'] = 1;
		$main['name'] 	= "Multi Banner";

		$this->load->model('setting/module');
		$this->load->model('localisation/language');

		$languages = $this->model_localisation_language->getLanguages();

        foreach ($languages as $value) {
        	$main['tvcmsmultibanner_main'][$value['language_id']] = array('tvcmsmultibanner_main_title'=>"Main Title",'tvcmsmultibanner_main_short_des'=> "Short Description",'tvcmsmultibanner_main_des'=>"Description",'tvcmsmultibanner_main_img'=>"catalog/themevolty/multibanner/demo_main_img.jpg");

        	$main['tvcmsmultibanner'][$value['language_id']] = array(

        		'tvcmsmultibanner_img_1'=>"catalog/themevolty/multibanner/demo_img_1.jpg",
        		'lang_id'=>"'".$value['language_id']."'",'tvcmsmultibanner_cap_1'=>"#","tvcmsmultibanner_title_1"=>"Laptops & Acessories","tvcmsmultibanner_subtitle_1"=>"Upto 80% Off","tvcmsmultibanner_btncap_1"=>"Shop now","tvcmsmultibanner_align_1"=>"ttv-banner-contant-left",'tvcmsmultibanner_status_1'=>"1",'tvcmsmultibanner_width_1'=>"432",'tvcmsmultibanner_height_1'=>"250",'tvcmsmultibanner_img_2'=>"catalog/themevolty/multibanner/demo_img_2.jpg",'lang_id'=>"'".$value['language_id']."'",'tvcmsmultibanner_cap_2'=>"#",'tvcmsmultibanner_status_2'=>"1","tvcmsmultibanner_title_2"=>"Mobile Accessories","tvcmsmultibanner_subtitle_2"=>"Upto 30% Off","tvcmsmultibanner_btncap_2"=>"Shop now","tvcmsmultibanner_align_2"=>"ttv-banner-contant-center",'tvcmsmultibanner_width_2'=>"432",'tvcmsmultibanner_height_2'=>"250",'tvcmsmultibanner_img_3'=>"catalog/themevolty/multibanner/demo_img_3.jpg",'lang_id'=>"'".$value['language_id']."'",'tvcmsmultibanner_cap_3'=>"#",'tvcmsmultibanner_status_3'=>"1","tvcmsmultibanner_title_3"=>"Best Selling Mobiles","tvcmsmultibanner_subtitle_3"=>"Upto 40% Off","tvcmsmultibanner_btncap_3"=>"Shop now","tvcmsmultibanner_align_3"=>"ttv-banner-contant-right",'tvcmsmultibanner_width_3'=>"432",'tvcmsmultibanner_height_3'=>"250");
		}

		$this->model_setting_module->addModule('tvcmsmultibanner', $main);
		
	}
	protected function status(){
		return $this->Tvcmsthemevoltystatus->multibannertatus();
	}
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/tvcmsmultibanner')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		$status = $this->status();
	
		$data['num_services'] = $status['num_services'];

		foreach ($this->request->post['tvcmsmultibanner'] as $language_id => $value) {
			for ($i=1; $i <= $data['num_services']; $i++) { 
				if ((utf8_strlen($value['tvcmsmultibanner_img_'.$i.'']) < 1) || (utf8_strlen($value['tvcmsmultibanner_img_'.$i.'']) > 255)) {
					$this->error['tvcmsmultibanner_img_'.$i.''][$language_id] = $this->language->get('error_image1')." ".$i;
				}
			}	
		}
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}	
}
