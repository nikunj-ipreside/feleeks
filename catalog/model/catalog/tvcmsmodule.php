<?php
class ModelCatalogtvcmsmodule extends Model {
	public function gettvbrandlist() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tvcmsbrandlist ORDER BY tvcmsbrandlist_pos");
		return $query->rows;
	}
	public function gettvcategorysliderlist() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tvcmscategoryslidermain p LEFT JOIN " . DB_PREFIX . "tvcmscategoryslidersub pd ON (p.tvcmscategoryslidermain_id = pd.tvcmscategoryslidermain_id) WHERE pd.tvcmscategoryslidersublang_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY tvcmscategoryslidermain_pos");
		return $query->rows;
	}
	public function gettvcategoryproductsliderlist() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tvcmscategoryproductmain p LEFT JOIN " . DB_PREFIX . "tvcmscategoryproductsub pd ON (p.tvcmscategoryproductmain_id = pd.tvcmscategoryproductmain_id) WHERE pd.tvcmscategoryproductsublang_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY tvcmscategoryproductmain_pos");
		return $query->rows;
	}
	public function gettvcustomlinnklist() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tvcustomlink ORDER BY tvcustomlink_pos");
		return $query->rows;
	}
	public function gettvimageliderlist() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tvcmsimageslidermain p LEFT JOIN " . DB_PREFIX . "tvcmsimageslidersub pd ON (p.tvcmsimageslidermain_id = pd.tvcmsimageslidermain_id) WHERE pd.tvcmsimageslidersublang_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY tvcmsimageslidermain_pos ");
		return $query->rows;
	}
	public function gettvtestimoniallist() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tvcmstestimonialmain p LEFT JOIN " . DB_PREFIX . "tvcmstestimonialsub pd ON (p.tvcmstestimonialmain_id = pd.tvcmstestimonialmain_id) WHERE pd.tvcmstestimonialsublang_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY tvcmstestimonialmain_pos ");
		return $query->rows;
	}
	public function gettvtaglist() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tvcmstags ORDER BY tvcmstags_pos");
		return $query->rows;
	}
	public function gettvsocialiconlist() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tvcmssocialiconmain p LEFT JOIN " . DB_PREFIX . "tvcmssocialiconsub pd ON (p.tvcmssocialiconmain_id = pd.tvcmssocialiconmain_id) WHERE pd.tvcmssocialiconsublang_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY tvcmssocialiconmain_pos ");
		return $query->rows;
	}
	public function gettvpaymentlist() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tvcmspaymenticonmain p LEFT JOIN " . DB_PREFIX . "tvcmspaymenticonsub pd ON (p.tvcmspaymenticonmain_id = pd.tvcmspaymenticonmain_id) WHERE pd.tvcmspaymenticonsublang_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY tvcmspaymenticonmain_pos ");
		return $query->rows;
	}
	public function gettvimagegallerylist() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tvcmsimagegallerymain p LEFT JOIN " . DB_PREFIX . "tvcmsimagegallerysub pd ON (p.tvcmsimagegallerymain_id = pd.tvcmsimagegallerymain_id) WHERE pd.tvcmsimagegallerysublang_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY tvcmsimagegallerymain_pos ");
		return $query->rows;
	}
	public function getmoduelstatus($name) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "module WHERE code = '" . $name . "' ");
		return $query->row;
	}
	public function getmoduelallstatus($name) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "module WHERE code = '" . $name . "' ");
		return $query->rows;
	}
	public function getadvanceblocklist() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tvcmsadvanceblockmain p LEFT JOIN " . DB_PREFIX . "tvcmsadvanceblocksub pd ON (p.tvcmsadvanceblockmain_id = pd.tvcmsadvanceblockmain_id) WHERE pd.tvcmsadvanceblocksublang_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY tvcmsadvanceblockmain_pos ");
		return $query->rows;
	}
	public function getbannerslist() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tvcmsbanners ORDER BY tvcmsbanners_pos ");
		return $query->rows;
	}
	public function getProducts($data = array()) {
		if (!empty($data['filter_name'])) {
			$sql = "SELECT ps.price as special,p.*,pd.* FROM 
				" . DB_PREFIX . "product p 
				LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)
				LEFT JOIN " . DB_PREFIX . "product_special ps ON (p.product_id = ps.product_id)
				WHERE 
				pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

			$sql .= "AND pd.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";

			$sql .= "GROUP BY p.product_id";

			$sort_data = array(
				'pd.name',
				'p.sort_order'
			);

			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];
			} else {
				$sql .= " ORDER BY pd.name";
			}

			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}
			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}

				if ($data['limit'] < 1) {
					$data['limit'] = 5;
				}

				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}

			$query = $this->db->query($sql);
			//$query->num_rows;
			return $query;
		}
	}
	public function getproductquantity($customer_id,$product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "cart WHERE customer_id = '" . $customer_id . "' and product_id = '" . $product_id . "'");
		return $query->row;
	}
	public function getblogpostlist($limit) {
		if(!empty($limit)){
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tvcmsblog_main p LEFT JOIN " . DB_PREFIX . "tvcmsblog_sub pd ON (p.tvcmsblog_main_id = pd.tvcmsblog_main_id) WHERE pd.tvcmsblog_sublang_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY tvcmsblog_main_pos limit ".$limit."");
		}else{
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tvcmsblog_main p LEFT JOIN " . DB_PREFIX . "tvcmsblog_sub pd ON (p.tvcmsblog_main_id = pd.tvcmsblog_main_id) WHERE pd.tvcmsblog_sublang_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY tvcmsblog_main_pos");
		}
		return $query->rows;
	}
	public function getblogpostlistpage($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "tvcmsblog_main p LEFT JOIN " . DB_PREFIX . "tvcmsblog_sub pd ON (p.tvcmsblog_main_id = pd.tvcmsblog_main_id) WHERE pd.tvcmsblog_sublang_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY tvcmsblog_main_pos";

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
		$query = $this->db->query($sql);

		return $query->rows;
	}
	public function getTotalgetblogpostlistpage() {
		
		$sql = "SELECT * FROM " . DB_PREFIX . "tvcmsblog_main p LEFT JOIN " . DB_PREFIX . "tvcmsblog_sub pd ON (p.tvcmsblog_main_id = pd.tvcmsblog_main_id) WHERE pd.tvcmsblog_sublang_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY tvcmsblog_main_pos";

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);


		return $query->num_rows;
	}
	public function getblogpostsingle($tvcmsblog_main_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tvcmsblog_main p LEFT JOIN " . DB_PREFIX . "tvcmsblog_sub pd ON (p.tvcmsblog_main_id = pd.tvcmsblog_main_id) WHERE pd.tvcmsblog_sublang_id = '" . (int)$this->config->get('config_language_id') . "' and p.tvcmsblog_main_id = '" . (int)$tvcmsblog_main_id . "'");

		return $query->row;
	}
	public function getblogpostcategorysigle($tvcmsblogcategory_id) {
		
		$query = $this->db->query("SELECT  " . DB_PREFIX . "tvcmsblogcategory_sub.*, " . DB_PREFIX . "tvcmsblogcategory_main.* FROM  " . DB_PREFIX . "tvcmsblogcategory_sub
			INNER JOIN " . DB_PREFIX . "tvcmsblogcategory_main ON  
			" . DB_PREFIX . "tvcmsblogcategory_sub.tvcmsblogcategory_id = " . DB_PREFIX . "tvcmsblogcategory_main.tvcmsblogcategory_id
			WHERE " . DB_PREFIX . "tvcmsblogcategory_sub.tvcmsblogcategory_id = '" . (int)$tvcmsblogcategory_id . "'");

		return  $query->row;
	}
	public function getblogpostgallery($tvcmsblogcategory_id) {
		$query = $this->db->query("SELECT * FROM  " . DB_PREFIX . "tvcmsblog_gallery	WHERE tvcmsblog_id = '" . (int)$tvcmsblogcategory_id . "'");
		return  $query;
	}
	public function getblogpostcomment($tvcmsblogcategory_id) {
		$query = $this->db->query("SELECT * FROM  " . DB_PREFIX . "tvcmsblog_comment	WHERE tvcmsblog_id = '" . (int)$tvcmsblogcategory_id . "'");
		return  $query->rows;
	}
	public function getblogpostaddcomment($data){
		$query = "SELECT MAX(tvcmsblog_comment_id) as id FROM `" . DB_PREFIX . "tvcmsblog_comment`";
		$query = $this->db->query($query);
		$data['id'] = $query->row['id'] + 1;

		$this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmsblog_comment`
			SET 
						tvcmsblog_comment_id 			= '.$data["id"].',
						tvcmsblog_id 					= '.$data["tvcmsblog_main_id"].',
						tvcmsblog_comment_name 			= "'.$data["tvcmsblog_comment_name"].'",
						tvcmsblog_comment_email 		= "'.$data["tvcmsblog_comment_email"].'",
						tvcmsblog_comment_website_url 	= "'.$data["tvcmsblog_comment_website_url"].'",
						tvcmsblog_comment_subject 		= "'.$data["tvcmsblog_comment_subject"].'",
						tvcmsblog_comment_comment 		= "'.$data["tvcmsblog_comment_comment"].'",
						tvcmsblog_comment_pos 			= "'.$data["id"].'",
						tvcmsblog_comment_adddate = NOW()');
	}
	public function addemailsubcribe($data){
		
		$this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmsnewsletter`
			SET 
						tvcmsnewsletter_email 			= "'.$data.'",
						tvcmsnewsletter_adddate 		= NOW()');
	}
	public function checkemailsubcribe($data){
		
		$query = $this->db->query("SELECT * FROM  " . DB_PREFIX . "tvcmsnewsletter	WHERE tvcmsnewsletter_email = '" . $data . "'");
		return  $query->num_rows;
	}
}

	