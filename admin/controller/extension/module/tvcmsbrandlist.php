<?php
class ControllerExtensionModuleTvcmsbrandlist extends Controller {
	private $error = array();

	public function index() {

		$this->load->language('extension/module/tvcmsbrandlist');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/module');
		$this->load->model('localisation/language');
		$this->load->model('catalog/tvcmsbrandlist');
		$this->load->model('tool/image');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			if(isset($this->request->post['tvcmsbrandlist']) && !empty($this->request->post['tvcmsbrandlist'])){
				$post_data = $this->request->post['tvcmsbrandlist'];
			}else{
				$post_data = array();
			}
			$this->model_catalog_tvcmsbrandlist->addbrandlink($post_data);
			unset($this->request->post['tvcmsbrandlist']);
			
			if (!isset($this->request->get['module_id'])) {
				$this->model_setting_module->addModule('tvcmsbrandlist', $this->request->post);
			} else {
				$this->model_setting_module->editModule($this->request->get['module_id'], $this->request->post);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}

		$checkrecord = $this->model_catalog_tvcmsbrandlist->checkdata();
		
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
				'href' => $this->url->link('extension/module/tvcmsbrandlist', 'user_token=' . $this->session->data['user_token'], true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/tvcmsbrandlist', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}

		$data['text_main'] 			= $this->language->get('text_main');
		$data['text_submain'] 		= $this->language->get('text_submain');
		$data['entry_title']		= $this->language->get('entry_title');
		$data['entry_link']			= $this->language->get('entry_link');
		$data['entry_image']		= $this->language->get('entry_image');
		$data['entry_short']		= $this->language->get('entry_short');
		$data['entry_des']			= $this->language->get('entry_des');
		$data['entry_main_title']	= $this->language->get('entry_main_title');
		$data['entry_main_des']		= $this->language->get('entry_main_des');
		$data['entry_main_ban']		= $this->language->get('entry_main_ban');

		$data['user_token'] 		= $this->session->data['user_token'];
		$data['languages'] 			= $this->model_localisation_language->getLanguages();

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/tvcmsbrandlist', 'user_token=' . $this->session->data['user_token'], true);
		} else {
			$data['action'] = $this->url->link('extension/module/tvcmsbrandlist', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
		}

		$data['cancel']  = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_setting_module->getModule($this->request->get['module_id']);
		}
		$status = $this->status();
		$data['status_main_form'] 				= $status['main_form'];
    	$data['status_main_title'] 				= $status['main_title'];
    	$data['status_main_short_description'] 	= $status['main_short_description'];
    	$data['status_main_description'] 		= $status['main_description'];
    	$data['status_main_image'] 				= $status['main_image'];
    	
    	$data['status_record_form'] 			= $status['record_form'];
    	$data['status_title'] 					= $status['title'];
    	$data['status_short_description'] 		= $status['short_description'];
    	$data['status_description'] 			= $status['description'];
    	$data['status_image'] 					= $status['image'];
    	$data['status_link'] 					= $status['link'];

		if(!empty($data['status_main_form'] )){
			if (isset($this->request->post['tvcmsbrandlist_main'])) {
				$data['tvcmsbrandlist_main'] = $this->request->post['tvcmsbrandlist_main'];
				foreach ($this->request->post['tvcmsbrandlist_main'] as $key => $value) {
					if($value['img']){
						$data['img'][$key] = $this->model_tool_image->resize($value['img'], 100, 100);
					}else{
						$data['img'][$key] = $this->model_tool_image->resize('no_image.png', 100, 100);
					}
				}
			} elseif (!empty($module_info['tvcmsbrandlist_main'])) {
				foreach ($module_info['tvcmsbrandlist_main'] as $key => $value) {
					$data['img'][$key] = $this->model_tool_image->resize($value['img'], 100, 100);
				}
				$data['tvcmsbrandlist_main'] = $module_info['tvcmsbrandlist_main'];
			} else {
				foreach ($data['languages'] as $key => $value) {
					$data['img'][$value['language_id']] = $this->model_tool_image->resize('no_image.png', 100, 100);
				}
				$data['tvcmsbrandlist_main'] = '';
			}
		}

		if(!empty($data['status_record_form'])){
			if (isset($this->request->post['tvcmsbrandlist'])) {
				$tvcmsbrandlist = $this->request->post['tvcmsbrandlist'];
			} elseif ($checkrecord->num_rows) {
				$tvcmsbrandlist = $checkrecord->rows;
			} else {
				$tvcmsbrandlist = array();
			}
		
			$data['tvcmsbrandlists'] = array();
			if (!empty($tvcmsbrandlist))  {
				foreach ($tvcmsbrandlist as $tvcustom_link) {
				
					$lang  	= ( isset($tvcustom_link['tvcmsbrandlist_lang']) ? json_decode($tvcustom_link['tvcmsbrandlist_lang'],1):array() );

					$link 	= ( isset($tvcustom_link['tvcmsbrandlist_link']) ? $tvcustom_link['tvcmsbrandlist_link']:'' );

					$img 	= ( isset($tvcustom_link['tvcmsbrandlist_img']) ? $tvcustom_link['tvcmsbrandlist_img']:'' );

					$pos 	= ( isset($tvcustom_link['tvcmsbrandlist_pos']) ? $tvcustom_link['tvcmsbrandlist_pos']:'' );

					$status = ( isset($tvcustom_link['tvcmsbrandlist_status']) ? $tvcustom_link['tvcmsbrandlist_status']:'' );

					$id 	= ( isset($tvcustom_link['tvcmsbrandlist_id']) ? $tvcustom_link['tvcmsbrandlist_id']:'' );
					
					$data['tvcmsbrandlists'][] = array(
						'tvcmsbrandlist_id' 		=> $id,
						'tvcmsbrandlist_link'     	=> $link,
						'tvcmsbrandlist_img'     	=> $img,
						'tvcmsbrandlist_pos'      	=> $pos,
						'language'					=> $lang,
						'tvcmsbrandlist_thumb'      => $this->model_tool_image->resize($img, 100, 100),
						'tvcmsbrandlist_status'   	=> $status
					);
				}
			}
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
		$data['placeholder'] 	= $this->model_tool_image->resize('no_image.png', 100, 100);
		$data['languages'] 		= $this->model_localisation_language->getLanguages();
		$data['header'] 		= $this->load->controller('common/header');
		$data['column_left'] 	= $this->load->controller('common/column_left');
		$data['footer'] 		= $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/tvcmsbrandlist', $data));
	}
	public function install(){
		$pre = DB_PREFIX;
		$main 			= array();
		$main['name'] 	= "Brand List";
		$main['status'] = 1;

		$this->load->model('setting/module');
		$this->load->model('localisation/language');
		$languages 		= $this->model_localisation_language->getLanguages();

        foreach ($languages as $value) {
        	$main['tvcmsbrandlist_main'][$value['language_id']] =  array('title'=>"test",'des'=>"test",'short'=>"test",'img'=>"catalog/demo_main_img.png");
		}
		
		$this->model_setting_module->addModule('tvcmsbrandlist', $main);

		$this->db->query("CREATE TABLE IF NOT EXISTS `{$pre}tvcmsbrandlist` 
		(  `tvcmsbrandlist_id` INT NOT NULL AUTO_INCREMENT ,
		   `tvcmsbrandlist_link` VARCHAR(255) NOT NULL , 
		   `tvcmsbrandlist_img` VARCHAR(255) NOT NULL ,
		   `tvcmsbrandlist_status` INT NOT NULL , 
		   `tvcmsbrandlist_pos` INT NOT NULL , 
		   `tvcmsbrandlist_lang` text NOT NULL ,
		PRIMARY KEY (`tvcmsbrandlist_id`)) ENGINE = InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;" );

		$this->load->model('localisation/language');

		$languages 		= $this->model_localisation_language->getLanguages();
		$num_of_data 	= 8;

        foreach ($languages as $value) {
        	$data['language'][$value['language_id']] =  array('title'=>"test",'des'=>"test",'short'=>"test");
		}
		
	 	for ($i = 1; $i<=$num_of_data; $i++) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "tvcmsbrandlist SET tvcmsbrandlist_link = '#',tvcmsbrandlist_img = 'catalog/themevolty/brand/demo_img_".$i.".png',tvcmsbrandlist_pos = '" . (int)$i . "',tvcmsbrandlist_lang = '" . json_encode($data['language']) . "', tvcmsbrandlist_status = '" . (int)1 . "'");
    	}
	}
	public function uninstall(){
		$pre = DB_PREFIX;
		$this->db->query("DROP TABLE `{$pre}tvcmsbrandlist`");
	}
	protected function status(){
		return $this->Tvcmsthemevoltystatus->brandstatus();
	}
	public function ajax() {
		$this->load->model('catalog/tvcmsbrandlist');
		$update_position 	= $this->request->get['action'];
		$position 			= $this->request->get['recordsArray'];
		$return_data 		= array();
		if ($update_position == 'update_position') {
		    $return_data['success'] = 'right';

		    $this->model_catalog_tvcmsbrandlist->updatePosition($position);

		    echo $res = implode("##", $return_data);
		}
	}
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/tvcmsbrandlist')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		return !$this->error;
	}
}