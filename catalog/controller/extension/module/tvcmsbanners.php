<?php
class ControllerExtensionModuletvcmsbanners extends Controller {
	public function index($setting) {
		if($this->config->get('theme_default_directory') == "opc_electronic_electron_2501"){
			if(!empty($setting['status'])){
				$this->load->model('catalog/tvcmsmodule');
				$this->load->model('tool/image');
				$status		 							= 	$this->status();
				$data['status_main_form'] 				= 	$status['main_form'];
			    $data['status_main_title'] 				= 	$status['main_title'];
			    $data['status_main_short_description'] 	= 	$status['main_short_description'];
			    $data['status_main_description'] 		= 	$status['main_description'];
			    $data['status_main_image'] 				= 	$status['main_image'];
			    $data['status_record_form'] 			= 	$status['record_form'];
			    $data['status_title'] 					=  	$status['title'];
				$data['status_short_description'] 		=  	$status['short_description'];
				$data['status_description'] 			=  	$status['description'];
				$data['status_image'] 					=  	$status['image'];
				$data['status_link'] 					=  	$status['link'];
				$land_id 								= (int)$this->config->get('config_language_id');

				if(!empty($data['status_main_form'])){
					if(!empty($data['status_main_title'])){
						$data['main_title'] = $setting['tvcmsbanners_main'][$land_id]['title']; 
					}
					if(!empty($data['status_main_short_description'])){
						$data['main_short_description'] = $setting['tvcmsbanners_main'][$land_id]['short']; 
					}
					if(!empty($data['status_main_description'])){
						$data['main_description'] = $setting['tvcmsbanners_main'][$land_id]['des']; 
					}
					if(!empty($data['status_main_image'])){
						$data['main_image'] = $setting['tvcmsbanners_main'][$land_id]['img']; 
					}
				}
				
				if(!empty($data['status_record_form'])){

					foreach ($setting['tvcmsbanners_form'] as $key => $value) {
						if(!empty($value['tvcmsbanners_status'])){
							if(!empty($data['status_title'])){
								$title 				= $value['language'][$land_id]['title'];
							}else{
								$title 				= null;
							}
							if(!empty($data['status_short_description'])){
								$descriptionshort 	= $value['language'][$land_id]['short'];
							}else{
								$descriptionshort 	= null;
							}
							if(!empty($data['status_description'])){
								$description 		= $value['language'][$land_id]['des'];
							}else{
								$description 		= null;
							}

							$img = $this->model_tool_image->resize($value['tvcmsbanners_img'], $value['tvcmsbanners_width'], $value['tvcmsbanners_height']);
							$data['banners_data'][] = array(
								'tvcmsbanners_title'				=> $title,
								'tvcmsbanners_descriptionshort'		=> $descriptionshort,
								'tvcmsbanners_description'			=> $description,
								'tvcmsbanners_align'				=> $value['btncap'],
								'tvcmsbanners_link'					=> $value['tvcmsbanners_link'],
								'tvcmsbanners_img' 					=> $img,
								'tvcmsbanners_grid'					=> $value['tvcmsbanners_grid'],
							);
						}
					}
				}
				return $this->load->view('extension/module/tvcmsbanners', $data);
			}
		}
	}
	protected function status(){
		return $this->Tvcmsthemevoltystatus->bannersstatus();
	}

}
