<?php
class ControllerExtensionModuletvcmsnewsletterpopup extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/tvcmsnewsletterpopup');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('localisation/language');
		$this->load->model('setting/module');
		$this->load->model('catalog/product');
		$this->load->model('tool/image');
		$this->load->model('catalog/category');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validatesetting()) {

			if (!isset($this->request->get['module_id'])) {
				$this->model_setting_module->addModule('tvcmsnewsletterpopup', $this->request->post);
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

		$data['breadcrumbs'] 	= array();

		$data['breadcrumbs'][] 	= array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] 	= array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/tvcmsnewsletterpopup', 'user_token=' . $this->session->data['user_token'] , true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/tvcmsnewsletterpopup', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}

		$data['languages'] 					= $this->model_localisation_language->getLanguages();
		$data['user_token']					= $this->session->data['user_token'];

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/tvcmsnewsletterpopup', 'user_token=' . $this->session->data['user_token'] , true);
		} else {
			$data['action'] = $this->url->link('extension/module/tvcmsnewsletterpopup', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
		}
		
		$data['cancel'] 	= $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info 	= $this->model_setting_module->getModule($this->request->get['module_id']);
		}
		
		if (isset($this->request->post['name'])) {
			$data['name'] 	= $this->request->post['name'];
		} elseif (!empty($module_info)) {
			$data['name'] 	= $module_info['name'];
		} else {
			$data['name'] 	= '';
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = "";
		}

		$data['products'] 	= array();

		

		
		

        $default_image = $this->model_tool_image->resize('no_image.png', 100, 100);

        

		

		if (isset($this->request->post['tvcmsnewsletterpopup'])) {
			$data['tvcmsnewsletterpopup'] 	= $this->request->post['tvcmsnewsletterpopup'];
			foreach ($this->request->post['tvcmsnewsletterpopup']['lang_text'] as $key => $value) {
				if(isset($value['img'])){
					$data['img_3'][$key] = $this->model_tool_image->resize($value['img'], 100, 100);				
				}else{
					$data['img_3'][$key] = $default_image;				
				}
				if(isset($value['bgimg'])){
					$data['img_4'][$key] = $this->model_tool_image->resize($value['bgimg'], 100, 100);				
				}else{
					$data['img_4'][$key] = $default_image;				
				}
			}
		} elseif (isset($module_info)) {
			foreach ($module_info['tvcmsnewsletterpopup']['lang_text'] as $key => $value) {
				if(isset($value['img'])){
					$data['img_3'][$key] = $this->model_tool_image->resize($value['img'], 100, 100);				
				}else{
					$data['img_3'][$key] = $default_image;				
				}	
				if(isset($value['bgimg'])){
					$data['img_4'][$key] = $this->model_tool_image->resize($value['bgimg'], 100, 100);				
				}else{
					$data['img_4'][$key] = $default_image;				
				}			
			}
			$data['tvcmsnewsletterpopup'] 	= $module_info['tvcmsnewsletterpopup'];
		} else {
			foreach ($data['languages'] as $key => $value) {
				$data['img_3'][$value['language_id']] = $default_image;
				$data['img_4'][$value['language_id']] = $default_image;
			}
			$data['tvcmsnewsletterpopup']   = array();
		}

		
		
		
		$data['header'] 		= $this->load->controller('common/header');
		$data['column_left'] 	= $this->load->controller('common/column_left');
		$data['footer'] 		= $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/tvcmsnewsletterpopup', $data));
	}

	public function install(){
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "tvcmsnewsletter` 
		(   `tvcmsnewsletter_id` int(11) AUTO_INCREMENT,
		    `tvcmsnewsletter_email` VARCHAR(255),
		    `tvcmsnewsletter_adddate` datetime,
        PRIMARY KEY (`tvcmsnewsletter_id`)) ENGINE = InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;");

		$this->load->model('setting/module');
		$this->load->model('localisation/language');
		$this->load->model('catalog/tvcmscategoryslider');

		$main 											= array();
		$main['name'] 									= "News Letter Popup";
		$main['status'] 								= 1;
		$main['tvcmsnewsletterpopup']['img_status'] 	= 1;
		$main['tvcmsnewsletterpopup']['bgimg_status']  	= 0;

		$languages = $this->model_localisation_language->getLanguages();
        foreach ($languages as $value) {
        	$main['tvcmsnewsletterpopup']['lang_text'][$value['language_id']] =  array('title'=>"Subscribe To Our Newsletter",'subtitle'=>"Subscribe to our email newsletter today to receive update on the latest news",'img'=>"catalog/themevolty/newsletter/demo_img.png",'bgimg'=>"catalog/themevolty/newsletter/featured_offer_img_1.jpg");
		}

		$this->model_setting_module->addModule('tvcmsnewsletterpopup', $main);
	}
	
	public function uninstall(){
		$pre = DB_PREFIX;
		$this->db->query("DROP TABLE `{$pre}tvcmsnewsletter`");
	}

	protected function validatesetting() {
		$this->load->language('extension/module/tvcmsimageslider');

		if (!$this->user->hasPermission('modify', 'extension/module/tvcmsnewsletterpopup')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		return !$this->error;
	}
}