<?php
class ControllerCommonMenu extends Controller {
	public function index() {
		$this->load->language('common/menu');

		// Menu
		$this->load->model('catalog/category');


                $this->load->language('extension/module/tvcmscustomtext');
                if (isset($this->request->get['path'])) {
                    $parts = explode('_', (string)$this->request->get['path']);
                } else {
                    $parts = array();
                }

                if (isset($parts[0])) {
                    $data['category_id'] = $parts[0];
                } else {
                    $data['category_id'] = 0;
                }
                if(empty($_SERVER['QUERY_STRING']) || $_SERVER['QUERY_STRING'] == "route=common/home"){
                    $data['menuhomeactive'] = "current";
                }else{
                    $data['menuhomeactive'] = "";
                }
                $this->load->model('account/wishlist');
                if ($this->customer->isLogged()) {
                    $this->load->model('account/wishlist');

                    $data['text_wishlist_tv']   = sprintf($this->model_account_wishlist->getTotalWishlist());
                } else {
                    $data['text_wishlist_tv']   = sprintf((isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
                }

                $data['ttvcpmpare']             = $this->url->link('product/compare', '', true);

                if(!empty($this->session->data['compare'])){
                    $data['ttvcpmpare_count']   = count($this->session->data['compare']);
                }else{
                    $data['ttvcpmpare_count']   = 0;
                }
                
		$this->load->model('catalog/product');

		$data['categories'] = array();

		$categories = $this->model_catalog_category->getCategories(0);

		foreach ($categories as $category) {
			if ($category['top']) {
				// Level 2
				$children_data = array();

				$children = $this->model_catalog_category->getCategories($category['category_id']);

				foreach ($children as $child) {
					$filter_data = array(
						'filter_category_id'  => $child['category_id'],
						'filter_sub_category' => true
					);

					$children_data[] = array(
						'name'  => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
						'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
					);
				}

				// Level 1
				$data['categories'][] = array(
					'name'     => $category['name'],

                'category_id'     => $category['category_id'],
                
					'children' => $children_data,
					'column'   => $category['column'] ? $category['column'] : 1,
					'href'     => $this->url->link('product/category', 'path=' . $category['category_id'])
				);
			}
		}

		return $this->load->view('common/menu', $data);
	}
}
