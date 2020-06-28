<?php

class ModelCatalogTvcmscategoryproduct extends Model {
	public function updatePosition($position){
	    foreach ($position as $key => $value) {
	        $pos = $key + 1;
	        $this->db->query("UPDATE " . DB_PREFIX . "tvcmscategoryproductmain SET tvcmscategoryproductmain_pos = '" . (int)$pos . "' WHERE tvcmscategoryproductmain_id = '" . (int)$value . "'");
	    }    
	}

	public function copytestimonial($tvcmscategoryproductmain_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "tvcmscategoryproductmain p WHERE p.tvcmscategoryproductmain_id = '" . (int)$tvcmscategoryproductmain_id . "'");

		if ($query->num_rows) {
			$data 								= $query->row;
			$data['tvcmscategoryproduct'] 			= $this->getimageslidercopy($tvcmscategoryproductmain_id);

			$this->insertdata($data);
		}
	}

	public function getimageslidercopy($tvcmscategoryproductmain_id) {
		$image_slider_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tvcmscategoryproductsub WHERE tvcmscategoryproductmain_id = '" . (int)$tvcmscategoryproductmain_id . "'");

		foreach ($query->rows as $result) {
			$image_slider_data[$result['tvcmscategoryproductsublang_id']] = array(
				'tvcmscategoryproduct_title'      	=> $result['tvcmscategoryproduct_title'],
				'lang'            					=> $result['tvcmscategoryproductsublang_id']
			);
		}

		return $image_slider_data;
	}

	public function insertdata($data) {
		$query = "SELECT MAX(tvcmscategoryproductmain_id) as id FROM `" . DB_PREFIX . "tvcmscategoryproductmain`";
		$query = $this->db->query($query);

		$data['id'] = $query->row['id'] + 1;

		$this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmscategoryproductmain`
			SET
						tvcmscategoryproductmain_id 			= '.$data["id"].',
						tvcmscategoryproduct_status 			= "'.$data['tvcmscategoryproduct_status'].'" ,
						tvcmscategoryproduct_img 				= "'.$data['tvcmscategoryproduct_img'].'" ,
						tvcmscategoryproduct_numberofproduct 	= "'.$data['tvcmscategoryproduct_numberofproduct'].'" ,
						tvcmscategoryproduct_categoryselect 	= "'.$data['tvcmscategoryproduct_categoryselect'].'" ,
						tvcmscategoryproductmain_pos 			= '.$data['id'].';');

		foreach ($data['tvcmscategoryproduct'] as $language_id => $value) {
			if(empty($value['tvcmscategoryproduct_title'])){
				$value['tvcmscategoryproduct_title'] = "title";
			}

			$this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmscategoryproductsub`
						SET
							tvcmscategoryproductmain_id 			= '.$data["id"].',
							tvcmscategoryproduct_title 			= "'.$value['tvcmscategoryproduct_title'].'",
							tvcmscategoryproductsublang_id 			= '.$value['lang'].'');
		}

	}

	public function gettottaldata(){
		$sql  = "SELECT COUNT(DISTINCT tvcmscategoryproductmain_id) AS total FROM `" . DB_PREFIX . "tvcmscategoryproductmain`";
		$query = $this->db->query($sql);
		return $query->row['total'];
	}

	public function edittestimonial($tvcmscategoryproductmain_id, $data) {
		
		$this->db->query('UPDATE `' . DB_PREFIX . 'tvcmscategoryproductmain`
			SET 
			tvcmscategoryproduct_status 	= '.$data['tvcmscategoryproduct_status'].',
			tvcmscategoryproduct_numberofproduct 	= '.$data['tvcmscategoryproduct_numberofproduct'].',
			tvcmscategoryproduct_categoryselect 	= '.$data['tvcmscategoryproduct_categoryselect'].',
			tvcmscategoryproduct_img 		= "'.$data['tvcmscategoryproduct_img'].'"  WHERE tvcmscategoryproductmain_id = "' . (int)$tvcmscategoryproductmain_id . '" ');
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "tvcmscategoryproductsub WHERE tvcmscategoryproductmain_id = '" . (int)$tvcmscategoryproductmain_id . "'");
		
		foreach ($data['tvcmscategoryproduct'] as $language_id => $value) {
			if(empty($value['tvcmscategoryproduct_title'])){
				$value['tvcmscategoryproduct_title'] = "title";
			}
		
			$this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmscategoryproductsub`
						SET 
							tvcmscategoryproductmain_id 				= '.$tvcmscategoryproductmain_id.',
							tvcmscategoryproduct_title 				= "'.$value['tvcmscategoryproduct_title'].'",
							tvcmscategoryproductsublang_id 				= '.$value['lang'].'');
		}
	}
	
	public function deletetestimonial($tvcmscategoryproductmain_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "tvcmscategoryproductmain WHERE tvcmscategoryproductmain_id = '" . (int)$tvcmscategoryproductmain_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "tvcmscategoryproductsub WHERE tvcmscategoryproductmain_id = '" . (int)$tvcmscategoryproductmain_id . "'");
	
		$this->cache->delete('tvcmscategoryproductmain');
		$this->cache->delete('tvcmscategoryproductsub');
	}

	public function gettestimonialsigle($tvcmscategoryproductmain_id) {
		
		$query = $this->db->query("SELECT  " . DB_PREFIX . "tvcmscategoryproductsub.*, " . DB_PREFIX . "tvcmscategoryproductmain.* FROM  " . DB_PREFIX . "tvcmscategoryproductsub
			INNER JOIN " . DB_PREFIX . "tvcmscategoryproductmain ON  
			" . DB_PREFIX . "tvcmscategoryproductsub.tvcmscategoryproductmain_id = " . DB_PREFIX . "tvcmscategoryproductmain.tvcmscategoryproductmain_id
			WHERE " . DB_PREFIX . "tvcmscategoryproductsub.tvcmscategoryproductmain_id = '" . (int)$tvcmscategoryproductmain_id . "'");

		return  $query->rows;
	}

	public function gettestimonial($data = array()) {

		$sql = "SELECT * FROM " . DB_PREFIX . "tvcmscategoryproductmain p LEFT JOIN " . DB_PREFIX . "tvcmscategoryproductsub pd ON (p.tvcmscategoryproductmain_id = pd.tvcmscategoryproductmain_id) WHERE pd.tvcmscategoryproductsublang_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.tvcmscategoryproduct_title LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$sql .= " AND p.tvcmscategoryproduct_status = '" . (int)$data['filter_status'] . "'";
		}

		$sql .= " GROUP BY p.tvcmscategoryproductmain_id";

		$sort_data = array(
			'pd.tvcmscategoryproduct_title'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY p.tvcmscategoryproductmain_pos";
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
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTotaltestimonial($data = array()) {

		$sql = "SELECT COUNT(DISTINCT tvcmscategoryproductsub_id) AS total FROM " . DB_PREFIX . "tvcmscategoryproductmain p LEFT JOIN " . DB_PREFIX . "tvcmscategoryproductsub pd ON (p.tvcmscategoryproductmain_id = pd.tvcmscategoryproductmain_id) WHERE pd.tvcmscategoryproductsublang_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.tvcmscategoryproduct_title LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$sql .= " AND p.tvcmscategoryproduct_status = '" . (int)$data['filter_status'] . "'";
		}

		$query = $this->db->query($sql);
		return $query->row['total'];
	}
	public function getcatename($cate_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int)$cate_id . "'");

		return $query->row;
	}
	public function getCategories($data = array()) {
		$sql = "SELECT cp.category_id AS category_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') AS name, c1.parent_id, c1.sort_order FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "category c1 ON (cp.category_id = c1.category_id) LEFT JOIN " . DB_PREFIX . "category c2 ON (cp.path_id = c2.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd1 ON (cp.path_id = cd1.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd2 ON (cp.category_id = cd2.category_id) WHERE cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c1.status = '1'";
		
		$sql .= " GROUP BY cp.category_id";

		$sort_data = array(
			'name',
			'sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY sort_order";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " ASC";
		} else {
			$sql .= " DESC";
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}
}
