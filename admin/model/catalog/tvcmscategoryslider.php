<?php

class ModelCatalogtvcmscategoryslider extends Model {
	
	public function updatePosition($position){
	    foreach ($position as $key => $value) {
	        $pos = $key + 1;
	        $this->db->query("UPDATE " . DB_PREFIX . "tvcmscategoryslidermain SET tvcmscategoryslidermain_pos = '" . (int)$pos . "' WHERE tvcmscategoryslidermain_id = '" . (int)$value . "'");
	    }    
	}

	public function copycateimageslider($tvcmscategoryslidermain_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "tvcmscategoryslidermain p WHERE p.tvcmscategoryslidermain_id = '" . (int)$tvcmscategoryslidermain_id . "'");
		if ($query->num_rows) {
			
			$data = $query->row;
		 	$dataa['tvcmscategoryslidermain_image'] 		= $data['tvcmscategoryslidermain_image'];
    		$dataa['tvcmscategoryslidermain_category_id'] 	= $data['tvcmscategoryslidermain_category_id'];
    		$dataa['tvcmscategoryslidermain_status'] 		= $data['tvcmscategoryslidermain_status'];
			$dataa['tvcmscategoryslider'] 					= $this->getcateimageslidercopy($tvcmscategoryslidermain_id);

			$this->insertdata($dataa);
		}
	}

	public function getcatename($cate_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int)$cate_id . "'");

		return $query->row;
	}

	public function getcateimageslidercopy($tvcmscategoryslidermain_id) {
		$image_slider_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tvcmscategoryslidersub WHERE tvcmscategoryslidermain_id = '" . (int)$tvcmscategoryslidermain_id . "'");

		foreach ($query->rows as $result) {
			$image_slider_data[$result['tvcmscategoryslidersublang_id']] = array(
				'tvcmscategoryslidersub_name'             => $result['tvcmscategoryslidersub_name'],
				'lang'            						=> $result['tvcmscategoryslidersublang_id'],
				'tvcmscategoryslidersub_des'             => $result['tvcmscategoryslidersub_des']
			);
		}

		return $image_slider_data;
	}

	public function insertdata($data) {
		$query = "SELECT MAX(tvcmscategoryslidermain_id) as id FROM `" . DB_PREFIX . "tvcmscategoryslidermain`";
		$query = $this->db->query($query);
		$data['id'] = $query->row['id'] + 1;
		
		$this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmscategoryslidermain`
			SET 
						tvcmscategoryslidermain_id 			= '.$data["id"].',
						tvcmscategoryslidermain_category_id = "'.$data['tvcmscategoryslidermain_category_id'].'" ,
						tvcmscategoryslidermain_image 		= "'.$data['tvcmscategoryslidermain_image'].'",
						tvcmscategoryslidermain_pos 		= '.$data["id"].',
						tvcmscategoryslidermain_status 		= '.$data['tvcmscategoryslidermain_status'].';');

		foreach ($data['tvcmscategoryslider'] as $language_id => $value) {
			$this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmscategoryslidersub`
						SET 
							tvcmscategoryslidermain_id 		= '.$data["id"].',
							tvcmscategoryslidersub_name 	= "'.$value['tvcmscategoryslidersub_name'].'",
							tvcmscategoryslidersub_des 		= "'.$value['tvcmscategoryslidersub_des'].'",
							tvcmscategoryslidersublang_id 	= '.$value['lang'].'');
		}
	}

	public function gettottaldata(){
		$sql  = "SELECT COUNT(DISTINCT tvcmscategoryslidermain_id) AS total FROM `" . DB_PREFIX . "tvcmscategoryslidermain`";
		$query = $this->db->query($sql);
		return $query->row['total'];
	}

	public function editcatimageslider($tvcmscategoryslidermain_id, $data) {

		$this->db->query('UPDATE `' . DB_PREFIX . 'tvcmscategoryslidermain`
			SET 
						tvcmscategoryslidermain_category_id = "'.$data['tvcmscategoryslidermain_category_id'].'",
						tvcmscategoryslidermain_image 		= "'.$data['tvcmscategoryslidermain_image'].'",
						tvcmscategoryslidermain_status 		= '.$data['tvcmscategoryslidermain_status'].'
						WHERE tvcmscategoryslidermain_id = "' . (int)$tvcmscategoryslidermain_id . '" ');
		

		$this->db->query("DELETE FROM " . DB_PREFIX . "tvcmscategoryslidersub WHERE tvcmscategoryslidermain_id = '" . (int)$tvcmscategoryslidermain_id . "'");		
		foreach ($data['tvcmscategoryslider'] as $language_id => $value) {
			$this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmscategoryslidersub`
						SET 
							tvcmscategoryslidermain_id 		= '.$tvcmscategoryslidermain_id.',
							tvcmscategoryslidersub_name 	= "'.$value['tvcmscategoryslidersub_name'].'",
							tvcmscategoryslidersub_des 		= "'.$value['tvcmscategoryslidersub_des'].'",
							tvcmscategoryslidersublang_id 	= '.$value['lang'].'');
		}
	}
	
	public function deletecateimageslider($tvcmscategoryslidermain_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "tvcmscategoryslidermain WHERE tvcmscategoryslidermain_id = '" . (int)$tvcmscategoryslidermain_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "tvcmscategoryslidersub WHERE tvcmscategoryslidermain_id = '" . (int)$tvcmscategoryslidermain_id . "'");
	
		$this->cache->delete('tvcmscategoryslidermain');
		$this->cache->delete('tvcmscategoryslidersub');
	}

	public function getcateimageslidesigle($tvcmscategoryslidermain_id) {
		
		$query = $this->db->query("SELECT  " . DB_PREFIX . "tvcmscategoryslidersub.*, " . DB_PREFIX . "tvcmscategoryslidermain.* FROM  " . DB_PREFIX . "tvcmscategoryslidersub
			INNER JOIN " . DB_PREFIX . "tvcmscategoryslidermain ON  
			" . DB_PREFIX . "tvcmscategoryslidersub.tvcmscategoryslidermain_id = " . DB_PREFIX . "tvcmscategoryslidermain.tvcmscategoryslidermain_id
			WHERE " . DB_PREFIX . "tvcmscategoryslidersub.tvcmscategoryslidermain_id = '" . (int)$tvcmscategoryslidermain_id . "'");

		return  $query->rows;
	}

	public function getcateimageslider($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "tvcmscategoryslidermain p LEFT JOIN " . DB_PREFIX . "tvcmscategoryslidersub pd ON (p.tvcmscategoryslidermain_id = pd.tvcmscategoryslidermain_id) WHERE pd.tvcmscategoryslidersublang_id = '" . (int)$this->config->get('config_language_id') . "'";


		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.tvcmscategoryslidersub_name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$sql .= " AND p.tvcmscategoryslidermain_status = '" . (int)$data['filter_status'] . "'";
		}

		$sql .= " GROUP BY p.tvcmscategoryslidermain_id";

		$sort_data = array(
			'pd.tvcmscategoryslidersub_name',
			'pd.tvcmscategoryslidersub_des',
			'p.tvcmscategoryslidermain_status'			
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY p.tvcmscategoryslidermain_pos";
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

	public function getcateTotalsliderimage($data = array()) {
		$sql = "SELECT COUNT(DISTINCT tvcmscategoryslidersub_id) AS total FROM " . DB_PREFIX . "tvcmscategoryslidermain p LEFT JOIN " . DB_PREFIX . "tvcmscategoryslidersub pd ON (p.tvcmscategoryslidermain_id = pd.tvcmscategoryslidermain_id) WHERE pd.tvcmscategoryslidersublang_id = '" . (int)$this->config->get('config_language_id') . "'";


		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.tvcmscategoryslidersub_name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$sql .= " AND p.tvcmscategoryslidermain_status = '" . (int)$data['filter_status'] . "'";
		}

		$query = $this->db->query($sql);
		return $query->row['total'];
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
