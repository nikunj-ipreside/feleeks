<?php
class ControllerExtensionModuletvcmsleftblogpost extends Controller {
	public function index($setting) {
		if($this->config->get('theme_default_directory') == "opc_electronic_electron_2501" && $setting['status']){
			$this->load->model('catalog/tvcmsmodule');
			$name		 = "tvcmsblog";
			$status_info = $this->model_catalog_tvcmsmodule->getmoduelstatus($name);
			$setting_data = json_decode($status_info['setting'],1);
			$this->load->language('extension/module/tvcmscustomtext');
			$this->load->model('tool/image');
			$languages_id 					= $this->config->get('config_language_id');
			$data['main_title'] 			= $setting_data['tvcmsblog_main'][$languages_id]['title'];
			$data['main_shortdescription'] 	= $setting_data['tvcmsblog_main'][$languages_id]['subtitle'];
			$data['main_description'] 		= $setting_data['tvcmsblog_main'][$languages_id]['des'];
		   	$data['allbloglink'] 			= $this->url->link('common/tvcmsallblogpage',  true);
		   	$limit							= false;
			$blogpost_info 					= $this->model_catalog_tvcmsmodule->getblogpostlist($limit);
			$data['blogpost_data'] 			= array();
			foreach ($blogpost_info as $key => $value) {
				if(!empty($value['tvcmsblog_main_status'])){

					if($value['tvcmsblog_main_posttype'] == "gallery"){
						$gallery 	= $this->model_catalog_tvcmsmodule->getblogpostgallery($value['tvcmsblog_main_id']);
						if(!empty($gallery->num_rows)){
						 	foreach ($gallery->rows as $key => $vv) {
						 		if(!empty($vv['image'])){
						 			$vvv = $vv['image'];
						 		}else{
						 			$vvv = 'no_image.png';
						 		}
						 						 		
								$gallery_info[] = $this->model_tool_image->resize($vvv, $this->config->get('tvcmscustomsetting_tvcmsbloggallhome_img_width'), $this->config->get('tvcmscustomsetting_tvcmsbloggallhome_img_height'));
						 	}
						 	$gallery_img = current($gallery_info);
						}
					}
					if(empty($gallery_img)){
						$gallery_img = 'no_image.png';
					}
					 if($value['tvcmsblog_main_posttype'] == "video"){
							$youtube = preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $value['tvcmsblog_main_video'], $match);
							$youtube_id = $match[1];
						}else{
							$youtube_id = 1;
 						}
 					if(!empty($value['tvcmsblog_main_featureimage'])){
 						$tvcmsblog_main_featureimage = $value['tvcmsblog_main_featureimage'];
 					}else{
 						$tvcmsblog_main_featureimage = 'no_image.png';
 					}

					$data['blogpost_data'][] = array(
						'comment_count'						=> count($this->model_catalog_tvcmsmodule->getblogpostcomment($value['tvcmsblog_main_id'])),
						'gallery'							=> $gallery_img,
						'tvcmsblog_main_link'				=> $this->url->link('common/tvcmsallblogpage/singleblog','&tvcmsblog_main_id='.$value['tvcmsblog_main_id'].''),
						'tvcmsblog_main_id'					=> $value['tvcmsblog_main_id'],
						'youtube_id'						=> $youtube_id,
						'tvcmsblog_main_posttype'			=> $value['tvcmsblog_main_posttype'],
						'tvcmsblog_main_deafultcategory'	=> $value['tvcmsblog_main_deafultcategory'],
						'tvcmsblog_main_urlrewrite'			=> $value['tvcmsblog_main_urlrewrite'],
						'tvcmsblog_main_video'				=> $value['tvcmsblog_main_video'],
						'tvcmsblog_main_adddate'			=> date('M d, Y', strtotime($value['tvcmsblog_main_adddate'])),
						'tvcmsblog_main_featureimage' 		=> $this->model_tool_image->resize($tvcmsblog_main_featureimage, $this->config->get('tvcmscustomsetting_tvcmsblogfeahome_img_width'), $this->config->get('tvcmscustomsetting_tvcmsblogfeahome_img_height')),
						'tvcmsblog_sub_title'				=> $value['tvcmsblog_sub_title'],
						'tvcmsblog_sub_excerpt'				=> $value['tvcmsblog_sub_excerpt'],
						'tvcmsblog_sub_content'				=> $value['tvcmsblog_sub_content'],
						'tvcmsblog_sub_metatitle'			=> $value['tvcmsblog_sub_metatitle'],
						'tvcmsblog_sub_metatag'				=> $value['tvcmsblog_sub_metatag'],
						'tvcmsblog_sub_metades'				=> $value['tvcmsblog_sub_metades'],
						'tvcmsblog_sub_metakeyword'			=> $value['tvcmsblog_sub_metakeyword'],
					);
					
				}
			}
			return $this->load->view('extension/module/tvcmsleftblogpost', $data);
		}
	}
}
