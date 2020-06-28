<?php
class ControllerCommonSearch extends Controller {

                    public function autocomplete() {
                        $json = array();

                        if (isset($this->request->get['filter_name'])) {

                            $this->load->model('catalog/tvcmsmodule');
                            $this->load->model('tool/image');
                            
                            if (isset($this->request->get['filter_name'])) {
                                $filter_name = $this->request->get['filter_name'];
                            } else {
                                $filter_name = '';
                            }

                            $limit = $this->config->get('tvcmscustomsetting_configuration')['searchlimit'];

                            $filter_data = array(
                                'filter_name'  => $filter_name,
                                'start'        => 0,
                                'limit'        => $limit
                            );
                            $html       = '';
                            $alldataget = $this->model_catalog_tvcmsmodule->getProducts($filter_data);
                            $results = $alldataget->rows;
                            $html .=    '<div class=\'ttvcmssearch-dropdown\'>';

                            $html .=    '<div class=\'ttvsearch-dropdown-close-wrapper\'>
                                            <div class=\'ttvsearch-dropdown-close\'>Close</div>
                                        </div>';
                            if (!empty($results)) {
                                
                                foreach ($results as $result) {                            
                                    $prod_price      = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                                    
                                    $special    = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                                    
                                    $tax        = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);

                                    $prod_link = $this->url->link('product/product', 'product_id=' . $result['product_id']);
                                    $prod_img = $this->model_tool_image->resize($result['image'],98,98);
                                    $prod_name = strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'));

                                    $html .= '
                                            <div class=\'ttvsearch-all-dropdown-wrapper\'>
                                                <div class=\'ttvsearch-dropdown-wrapper\'>
                                                    <a href=\''.$prod_link.'\'>
                                                        <div class=\'ttvsearch-dropdown-img-block\'>
                                                            <img src=\''.$prod_img.'\' alt=\''.$prod_name.'\' />
                                                        </div>
                                                        <div class=\'ttvsearch-dropdown-content-box\'>
                                                            <div class=\'ttvsearch-dropdown-title\'>'.$prod_name.'</div>
                                                            <div class=\'product-price-and-shipping\'>
                                                                <span class=\'regular-price\'>$18.90</span>
                                                                <span class=\'price\'>'.$prod_price.'</span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            ';  
                                }
                                $html .=    '<div class=\'ttvsearch-more-search-wrapper\'>
                                                <div class=\'ttvsearch-more-search\'>More Result</div>
                                            </div>';
                            }else{
                                $html .= '<div class=\'ttvsearch-dropdown-wrapper\'>No product Found</div>';
                            }
                            $html .= '</div>';
                        }

                        if (!empty($html)) {
                            print_r($html);
                        }
                    }
                
	public function index() {
		$this->load->language('common/search');

		$data['text_search'] = $this->language->get('text_search');

		if (isset($this->request->get['search'])) {
			$data['search'] = $this->request->get['search'];
		} else {
			$data['search'] = '';
		}

		return $this->load->view('common/search', $data);
	}
}