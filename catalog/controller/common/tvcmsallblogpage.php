<?php
class ControllerCommonTvcmsallblogpage extends Controller {
	private $error = array();

	public function index() {
		if($this->config->get('theme_default_directory') == "opc_electronic_electron_2501"){

			$this->load->language('extension/module/tvcmscustomtext');
			$this->load->model('catalog/tvcmsmodule');
			$this->load->model('tool/image');

			if (isset($this->request->get['page'])) {
				$page = $this->request->get['page'];
			} else {
				$page = 1;
			}

			if (isset($this->request->get['limit'])) {
				$limit = (int)$this->request->get['limit'];
			} else {
				$limit = 3;
			}
			$data['breadcrumbs'] = array();

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/home')
			);
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_blogspagetitle'),
				'href' => $this->url->link('common/tvcmsallblogpage')
			);


			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
			$filter_data = array(
				'start'               => ($page - 1) * $limit,
				'limit'               => $limit
			);

			

			$this->load->model('catalog/category');
			$data['store_owner'] 	= $this->config->get('config_owner');
			$blog_total 			= $this->model_catalog_tvcmsmodule->getTotalgetblogpostlistpage($filter_data);
			$blogpost_info 			= $this->model_catalog_tvcmsmodule->getblogpostlistpage($filter_data);
			$data['blogpost_data'] 	= array();
			foreach ($blogpost_info as $key => $value) {
				if(!empty($value['tvcmsblog_main_status'])){
					$gallery 	= $this->model_catalog_tvcmsmodule->getblogpostgallery($value['tvcmsblog_main_id']);
					 if(!empty($gallery->num_rows)){
					 	foreach ($gallery->rows as $key => $vv) {
					 		if(!empty($vv['image'])){
					 			$vvv = $vv['image'];
					 		}else{
					 			$vvv = 'no_image.png';
					 		}
							$gallery_info[] = $this->model_tool_image->resize($vvv, $this->config->get('tvcmscustomsetting_tvcmsbloggallall_img_width'), $this->config->get('tvcmscustomsetting_tvcmsbloggallhome_img_height'));
					 	}
					 }else{
					 	$gallery_info = array();
					 }
					$category_info 	= $this->model_catalog_tvcmsmodule->getblogpostcategorysigle($value['tvcmsblog_main_id']);

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
						'tvcmsblog_main_link'				=> $this->url->link('common/tvcmsallblogpage/singleblog','&tvcmsblog_main_id='.$value['tvcmsblog_main_id'].''),
						'gallery'							=> $gallery_info,
						'category_title'					=> $category_info['tvcmsblogcategory_sub_title'],
						'tvcmsblog_main_id'					=> $value['tvcmsblog_main_id'],
						'tvcmsblog_main_adddate'			=> date('M d, Y', strtotime($value['tvcmsblog_main_adddate'])),
						'tvcmsblog_main_posttype'			=> $value['tvcmsblog_main_posttype'],
						'tvcmsblog_main_deafultcategory'	=> $value['tvcmsblog_main_deafultcategory'],
						'tvcmsblog_main_urlrewrite'			=> $value['tvcmsblog_main_urlrewrite'],
						'tvcmsblog_main_video'				=> $value['tvcmsblog_main_video'],
						'youtube_id'						=> $youtube_id,
						'tvcmsblog_main_featureimage' 		=> $this->model_tool_image->resize($tvcmsblog_main_featureimage, $this->config->get('tvcmscustomsetting_tvcmsblogfeaall_img_width'), $this->config->get('tvcmscustomsetting_tvcmsblogfeaall_img_height')),
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
			$pagination 		= new Tvcmspagination();
			$pagination->total 	= $blog_total;
			$pagination->page 	= $page;
			$pagination->limit 	= $limit;
			$pagination->url 	= $this->url->link('common/tvcmsallblogpage', '&page={page}');
			$data['pagination'] = $pagination->render();

			$data['results'] 	= sprintf($this->language->get('text_pagination'), ($blog_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($blog_total - $limit)) ? $blog_total : ((($page - 1) * $limit) + $limit), $blog_total, ceil($blog_total / $limit));


			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');
			$this->response->setOutput($this->load->view('common/tvcmsallblogpage', $data));
		}
	}
	
	protected function validate() {

		if ((utf8_strlen($this->request->post['tvcmsblog_comment_name']) < 3) || (utf8_strlen($this->request->post['tvcmsblog_comment_name']) > 32)) {
			$this->error['name'] = $this->language->get('error_name');

		}

		if (!filter_var($this->request->post['tvcmsblog_comment_email'], FILTER_VALIDATE_EMAIL)) {
			$this->error['email'] = $this->language->get('error_email');
		}

		if ((utf8_strlen($this->request->post['tvcmsblog_comment_comment']) < 10) || (utf8_strlen($this->request->post['tvcmsblog_comment_comment']) > 3000)) {
			$this->error['enquiry'] = $this->language->get('error_enquiry');
		}

		return !$this->error;
	}
	public function singleblog(){
		if (isset($this->request->get['tvcmsblog_main_id'])) {
			$tvcmsblog_main_id = (int)$this->request->get['tvcmsblog_main_id'];
		} else if (!empty($this->request->post['tvcmsblog_main_id'])) {
			$tvcmsblog_main_id = (int)$this->request->post['tvcmsblog_main_id'];
		} else {
			$tvcmsblog_main_id = 1;
		}
		$this->load->language('extension/module/tvcmscustomtext');
		$this->load->model('catalog/tvcmsmodule');
		$this->load->model('tool/image');
		$this->load->model('catalog/category');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_catalog_tvcmsmodule->getblogpostaddcomment($this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
		}
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		} 
		$data['store_owner'] = $this->config->get('config_owner');
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_blogspagetitle'),
			'href' => $this->url->link('common/tvcmsallblogpage')
		);

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		if (isset($this->error['email'])) {
			$data['error_email'] = $this->error['email'];
		} else {
			$data['error_email'] = '';
		}

		if (isset($this->error['enquiry'])) {
			$data['error_enquiry'] = $this->error['enquiry'];
		} else {
			$data['error_enquiry'] = '';
		}

		if (isset($this->request->post['tvcmsblog_comment_name'])) {
			$data['tvcmsblog_comment_name'] = $this->request->post['tvcmsblog_comment_name'];
		} else {
			$data['tvcmsblog_comment_name'] = '';
		}
		if (isset($this->request->post['tvcmsblog_comment_email'])) {
			$data['tvcmsblog_comment_email'] = $this->request->post['tvcmsblog_comment_email'];
		} else {
			$data['tvcmsblog_comment_email'] = '';
		}
		if (isset($this->request->post['tvcmsblog_comment_website_url'])) {
			$data['tvcmsblog_comment_website_url'] = $this->request->post['tvcmsblog_comment_website_url'];
		} else {
			$data['tvcmsblog_comment_website_url'] = '';
		}
		if (isset($this->request->post['tvcmsblog_comment_subject'])) {
			$data['tvcmsblog_comment_subject'] = $this->request->post['tvcmsblog_comment_subject'];
		} else {
			$data['tvcmsblog_comment_subject'] = '';
		}
		if (isset($this->request->post['tvcmsblog_comment_comment'])) {
			$data['tvcmsblog_comment_comment'] = $this->request->post['tvcmsblog_comment_comment'];
		} else {
			$data['tvcmsblog_comment_comment'] = '';
		}

		$data['action'] = $this->url->link('common/tvcmsallblogpage/singleblog',  true);
		if ($this->request->server['HTTPS']) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}
        $data['comment_image'] = $server."image/catalog/themevolty/blog/comment.png";
		$data['comment_info'] 	= $this->model_catalog_tvcmsmodule->getblogpostcomment($tvcmsblog_main_id);
		$blogpost_info 			= $this->model_catalog_tvcmsmodule->getblogpostsingle($tvcmsblog_main_id);
		$category_info 			= $this->model_catalog_tvcmsmodule->getblogpostcategorysigle($blogpost_info['tvcmsblog_main_id']);
		if ($blogpost_info) {			

			$data['breadcrumbs'][] = array(
				'text' => $blogpost_info['tvcmsblog_sub_title'],
				'href' => $this->url->link('common/tvcmsallblogpage/singleblog','&tvcmsblog_main_id=' . $tvcmsblog_main_id)
			);
			$this->document->setTitle($blogpost_info['tvcmsblog_sub_metatitle']);
			$this->document->setDescription($blogpost_info['tvcmsblog_sub_metades']);
			$this->document->setKeywords($blogpost_info['tvcmsblog_sub_metakeyword']);
			$this->document->addLink($this->url->link('common/tvcmsallblogpage/singleblog', 'tvcmsblog_main_id=' . $tvcmsblog_main_id), 'canonical');
			$gallery = $this->model_catalog_tvcmsmodule->getblogpostgallery($tvcmsblog_main_id);
			$gallery_info = array();
			foreach ($gallery->rows as $key => $vv) {
				if(!empty($vv['image'])){
					$vv1 = $vv['image'];
				}else{
					$vv1 = 'no_image.png';
				}
				$gallery_info[] = $this->model_tool_image->resize($vv1, $this->config->get('tvcmscustomsetting_tvcmsbloggallsin_img_width'), $this->config->get('tvcmscustomsetting_tvcmsbloggallsin_img_height'));
		 	}
			$data['gallery']							= $gallery_info;

			$data['tvcmsblog_main_id'] 					= $tvcmsblog_main_id;
			if($blogpost_info['tvcmsblog_main_posttype'] == "video"){
					$youtube = preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $blogpost_info['tvcmsblog_main_video'], $match);
					$youtube_id = $match[1];
			}else{
					$youtube_id = 1;
			}
			if(!empty($blogpost_info['tvcmsblog_main_featureimage'])){
				$tvcmsblog_main_featureimage = $blogpost_info['tvcmsblog_main_featureimage'];
			}else{
				$tvcmsblog_main_featureimage = 'no_image.png';
			}
			$data['youtube_id']							= $youtube_id;
			$data['category_title'] 					= $category_info['tvcmsblogcategory_sub_title'];
			$data['heading_title'] 						= $blogpost_info['tvcmsblog_sub_title'];
			$data['tvcmsblog_main_link'] 				= $this->url->link('common/tvcmsallblogpage/singleblog','&tvcmsblog_main_id='.$blogpost_info['tvcmsblog_main_id'].'');
			$data['tvcmsblog_main_id']					= $blogpost_info['tvcmsblog_main_id'];
			$data['tvcmsblog_main_adddate']				= date('M d, Y', strtotime($blogpost_info['tvcmsblog_main_adddate']));
			$data['tvcmsblog_main_posttype']			= $blogpost_info['tvcmsblog_main_posttype'];
			$data['tvcmsblog_main_deafultcategory']		= $blogpost_info['tvcmsblog_main_deafultcategory'];
			$data['tvcmsblog_main_urlrewrite']			= $blogpost_info['tvcmsblog_main_urlrewrite'];
			$data['tvcmsblog_main_video']				= $blogpost_info['tvcmsblog_main_video'];
			$data['tvcmsblog_main_featureimage'] 		= $this->model_tool_image->resize($tvcmsblog_main_featureimage, $this->config->get('tvcmscustomsetting_tvcmsblogfeasin_img_width'), $this->config->get('tvcmscustomsetting_tvcmsblogfeasin_img_height'));
			$data['tvcmsblog_sub_title']				= $blogpost_info['tvcmsblog_sub_title'];
			$data['tvcmsblog_sub_excerpt']				= $blogpost_info['tvcmsblog_sub_excerpt'];
			$data['tvcmsblog_sub_content']				= $blogpost_info['tvcmsblog_sub_content'];
			$data['tvcmsblog_sub_metatitle']			= $blogpost_info['tvcmsblog_sub_metatitle'];
			$data['tvcmsblog_sub_metatag']				= $blogpost_info['tvcmsblog_sub_metatag'];
			$data['tvcmsblog_sub_metades']				= $blogpost_info['tvcmsblog_sub_metades'];
			$data['tvcmsblog_sub_metakeyword']			= $blogpost_info['tvcmsblog_sub_metakeyword'];
			$data['tvcmsblog_main_commentstatus']		= $blogpost_info['tvcmsblog_main_commentstatus'];
			$data['footer'] 							= $this->load->controller('common/footer');
			$data['header'] 							= $this->load->controller('common/header');
			$this->response->setOutput($this->load->view('common/tvcmssingleblog', $data));
		} else {
			
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_error'),
				'href' => $this->url->link('common/tvcmsallblogpage/singleblog', $url . '&tvcmsblog_main_id=' . $tvcmsblog_main_id)
			);

			$this->document->setTitle($this->language->get('text_error'));

			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('error/not_found', $data));
		}
	}
}