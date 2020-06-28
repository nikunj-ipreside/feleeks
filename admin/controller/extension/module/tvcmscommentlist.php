<?php
class ControllerExtensionModuletvcmscommentlist extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/tvcmscommentlist');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/tvcmscommentlist');

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'tvcmsnewsletter_email';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
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

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/tvcmscommentlist', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);
		$url = '';
		
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		

		
		$filter_data = array(
			
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'           => $this->config->get('config_limit_admin')
		);
		$list_total = $this->model_catalog_tvcmscommentlist->getTotallist($filter_data);
		$results = $this->model_catalog_tvcmscommentlist->getlist($filter_data);
		foreach ($results as $result) {
			
			$data['list'][] = array(
				'edit'            => $this->url->link('extension/module/tvcmscommentlist/edit', 'user_token=' . $this->session->data['user_token'] . '&tvcmsblog_comment_id=' . $result['tvcmsblog_comment_id'] . $url, true),
				'id' 		=> $result['tvcmsblog_id'],
				'name' 		=> $result['tvcmsblog_comment_name'],
				'email'     => $result['tvcmsblog_comment_email'],
				'url'     	=> $result['tvcmsblog_comment_website_url'],
				'subject'   => $result['tvcmsblog_comment_subject'],
				'comment'   => $result['tvcmsblog_comment_comment'],
				'status'  	=> $result['tvcmsblog_comment_status'],
				'date'  	=> $result['tvcmsblog_comment_adddate']
			);
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$data['sort_tvcmsnewsletter_email'] = $this->url->link('extension/module/tvcmscommentlist', 'user_token=' . $this->session->data['user_token'] . '&sort=tvcmsnewsletter_email' . $url, true);
		$pagination 		= new Pagination();
		$pagination->total 	= $list_total;
		$pagination->page 	= $page;
		$pagination->limit 	= $this->config->get('config_limit_admin');
		$pagination->url 	= $this->url->link('extension/module/tvcmscommentlist', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

		$data['pagination'] 	= $pagination->render();

		$data['results'] 		= sprintf($this->language->get('text_pagination'), ($list_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($list_total - $this->config->get('config_limit_admin'))) ? $list_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $list_total, ceil($list_total / $this->config->get('config_limit_admin')));
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/tvcmscommentlist', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/tvcmscommentlist')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
	public function edit() {
		$this->load->model('catalog/tvcmscommentlist');

		$this->model_catalog_tvcmscommentlist->editcomment($this->request->get['tvcmsblog_comment_id'], $this->request->post);
		$this->response->redirect($this->url->link('extension/module/tvcmscommentlist', 'user_token=' . $this->session->data['user_token'] . $url, true));
	}

}