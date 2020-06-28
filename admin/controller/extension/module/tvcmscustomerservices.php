<?php
class ControllerExtensionModuleTvcmscustomerservices extends Controller {
	private $error = array();
	public function index() {
		$this->load->language('extension/module/tvcmscustomerservices');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/module');

		$this->load->model('tool/image');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_setting_module->addModule('tvcmscustomerservices', $this->request->post);
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

		for ($i=1; $i <= $data['num_services']; $i++) { 
			if (!empty($this->error['tvcmscustomerservices_img_'.$i.''])) {
				$data['error'][$i] = $this->error['tvcmscustomerservices_img_'.$i.''];
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
				'href' => $this->url->link('extension/module/tvcmscustomerservices', 'user_token=' . $this->session->data['user_token'], true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/tvcmscustomerservices', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
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
			$data['action'] = $this->url->link('extension/module/tvcmscustomerservices', 'user_token=' . $this->session->data['user_token'], true);
		} else {
			$data['action'] = $this->url->link('extension/module/tvcmscustomerservices', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
		}
		

		$data['cancel'] 	= $this->url->link('extension/module/tvcmscustomerservices', 'user_token=' . $this->session->data['user_token'] . $url, true);

		$data['user_token'] = $this->session->data['user_token'];

		$this->load->model('localisation/language');

		$data['languages'] 	= $this->model_localisation_language->getLanguages();


		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_setting_module->getModule($this->request->get['module_id']);
		}

		//echo "<pre>"; print_r($module_info); echo "</pre>"; die;
		
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

		if(!empty($data['record_form'])){
			if (!empty($this->request->post['tvcmscustomerservices'])) {
				$data['tvcmscustomerservices'] = $this->request->post['tvcmscustomerservices'];
				foreach ($this->request->post['tvcmscustomerservices'] as $key => $value) {
					for ($i=1; $i <= $data['num_services']; $i++) { 
						if($value['tvcmscustomerservices_img_'.$i.'']){
							$data['aa'][$key]['img_'.$i.''] =  $this->model_tool_image->resize($value['tvcmscustomerservices_img_'.$i.''], 100, 100);				
						}else{
							$data['aa'][$key]['img_'.$i.''] =  $this->model_tool_image->resize('no_image.png', 100, 100);				
						}		
					}
				}
			} elseif (!empty($module_info['tvcmscustomerservices'])) {
				$data['tvcmscustomerservices'] = $module_info['tvcmscustomerservices'];
				foreach ($data['tvcmscustomerservices'] as $key => $value) {
					for ($i=1; $i <= $data['num_services']; $i++) {
						if(!empty($value['tvcmscustomerservices_img_'.$i.''])){
							$data['aa'][$key]['img_'.$i.''] =  $this->model_tool_image->resize($value['tvcmscustomerservices_img_'.$i.''], 100, 100);				
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
				$data['tvcmscustomerservices'] = array();
			}
		}
		if(!empty($data['main_form'])){
			if (!empty($this->request->post['tvcmscustomerservices_main'])) {
				$data['tvcmscustomerservices_main'] = $this->request->post['tvcmscustomerservices_main'];
				foreach ($this->request->post['tvcmscustomerservices_main'] as $key => $value) {
					if($value['tvcmscustomerservices_main_img']){
						$data['img_1'][$key] = $this->model_tool_image->resize($value['tvcmscustomerservices_main_img'], 100, 100);				
					}else{
						$data['img_1'][$key] = $this->model_tool_image->resize('no_image.png', 100, 100);				
					}
				}
			} elseif (!empty($module_info['tvcmscustomerservices_main'])) {
				$data['tvcmscustomerservices_main'] = $module_info['tvcmscustomerservices_main'];
				foreach ($data['tvcmscustomerservices_main'] as $key => $value) {
					$data['img_1'][$key] = $this->model_tool_image->resize($value['tvcmscustomerservices_main_img'], 100, 100);		
				}
			} else{
				foreach ($data['languages'] as $key => $value) {
					$data['img_1'][$value['language_id']] = $this->model_tool_image->resize('no_image.png', 100, 100);
				}
				$data['tvcmscustomerservices_main'] = array();
			}
		}
		
		$data['placeholder'] 	= $this->model_tool_image->resize('no_image.png', 100, 100);
		$data['header'] 		= $this->load->controller('common/header');
		$data['column_left'] 	= $this->load->controller('common/column_left');
		$data['footer'] 		= $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/tvcmscustomerservices_form', $data));
	}
	public function install(){

		$main 			= array();
		$main['status'] = 1;
		$main['name'] 	= "Customer Services";

		$this->load->model('setting/module');
		$this->load->model('localisation/language');

		$languages = $this->model_localisation_language->getLanguages();

        foreach ($languages as $value) {
        	$main['tvcmscustomerservices_main'][$value['language_id']] = array('tvcmscustomerservices_main_title'=>"Main Title",'tvcmscustomerservices_main_short_des'=> "Short Description",'tvcmscustomerservices_main_des'=>"Description",'tvcmscustomerservices_main_img'=>"catalog/themevolty/customerservices/demo_main_img.jpg");
        	$main['tvcmscustomerservices'][$value['language_id']] = array('tvcmscustomerservices_img_1'=>"catalog/themevolty/customerservices/demo_img_1.png",'lang_id'=>"'".$value['language_id']."'",'tvcmscustomerservices_cap_1'=>"100% Secure Payment",'tvcmscustomerservices_des_1'=>"Moving Your Card Details to a much more secured place",'tvcmscustomerservices_status_1'=>"1",'tvcmscustomerservices_img_2'=>"catalog/themevolty/customerservices/demo_img_2.png",'lang_id'=>"'".$value['language_id']."'",'tvcmscustomerservices_cap_2'=>"Trustpay",'tvcmscustomerservices_des_2'=>"100% Payment Protection. Easy Return policy",'tvcmscustomerservices_status_2'=>"1",'tvcmscustomerservices_img_3'=>"catalog/themevolty/customerservices/demo_img_3.png",'lang_id'=>"'".$value['language_id']."'",'tvcmscustomerservices_cap_3'=>"Support 24/7",'tvcmscustomerservices_des_3'=>"Got a question? Look no further.Browse our FAQs or Submit yor query here.",'tvcmscustomerservices_status_3'=>"1",'tvcmscustomerservices_img_4'=>"catalog/themevolty/customerservices/demo_img_4.png",'lang_id'=>"'".$value['language_id']."'",'tvcmscustomerservices_cap_4'=>"Shop on The Go",'tvcmscustomerservices_des_4'=>"Download the app and get exciting app only offers at your fingertips",'tvcmscustomerservices_status_4'=>"1");
		}

		$this->model_setting_module->addModule('tvcmscustomerservices', $main);
		
	}
	protected function status(){
		return $this->Tvcmsthemevoltystatus->customerservicestatus();
	}
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/tvcmscustomerservices')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		$status = $this->status();
	
		$data['num_services'] = $status['num_services'];
		$data['image_upload'] = $status['image_upload'];
		if(!empty($data['image_upload'])){
			foreach ($this->request->post['tvcmscustomerservices'] as $language_id => $value) {
				for ($i=1; $i <= $data['num_services']; $i++) { 
					if ((utf8_strlen($value['tvcmscustomerservices_img_'.$i.'']) < 1) || (utf8_strlen($value['tvcmscustomerservices_img_'.$i.'']) > 255)) {
						$this->error['tvcmscustomerservices_img_'.$i.''][$language_id] = $this->language->get('error_image1')." ".$i;
					}
				}	
			}
		}

		if ($this->error && !empty($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}	
}
