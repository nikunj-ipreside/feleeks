<?php

class ModelCatalogTvcmspaymenticon extends Model {
	public function updatePosition($position){
	    foreach ($position as $key => $value) {
	        $pos = $key + 1;
	        $this->db->query("UPDATE " . DB_PREFIX . "tvcmspaymenticonmain SET tvcmspaymenticonmain_pos = '" . (int)$pos . "' WHERE tvcmspaymenticonmain_id = '" . (int)$value . "'");
	    }    
	}

	public function copytestimonial($tvcmspaymenticonmain_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "tvcmspaymenticonmain p WHERE p.tvcmspaymenticonmain_id = '" . (int)$tvcmspaymenticonmain_id . "'");
		
		if ($query->num_rows) {
			$data 									= $query->row;
			$datas['tvcmspaymenticon'] 				= $this->getimageslidercopy($tvcmspaymenticonmain_id);
			$datas['tvcmspaymenticonmain_link'] 	= $data['tvcmspaymenticonmain_link'];
			$datas['tvcmspaymenticonmain_img'] 		= $query->row['tvcmspaymenticonmain_image'];
			$datas['tvcmspaymenticon_status'] 		= $query->row['tvcmspaymenticon_status'];

			$this->insertdata($datas);
		}
	}


	public function getimageslidercopy($tvcmspaymenticonmain_id) {
		$image_slider_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tvcmspaymenticonsub WHERE tvcmspaymenticonmain_id = '" . (int)$tvcmspaymenticonmain_id . "'");

		foreach ($query->rows as $result) {
			$image_slider_data[$result['tvcmspaymenticonsublang_id']] = array(
				'tvcmspaymenticonsub_title'      	=> $result['tvcmspaymenticonsub_title'],
				'tvcmspaymenticonsub_designation'   => $result['tvcmspaymenticonsub_designation'],
				'tvcmspaymenticonsub_description' 	=> $result['tvcmspaymenticonsub_description'],
				'lang'            					=> $result['tvcmspaymenticonsublang_id']
			);
		}

		return $image_slider_data;
	}

	public function insertdata($data) {
		$query = "SELECT MAX(tvcmspaymenticonmain_id) as id FROM `" . DB_PREFIX . "tvcmspaymenticonmain`";
		$query = $this->db->query($query);

		$data['id'] = $query->row['id'] + 1;

		$this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmspaymenticonmain`
			SET
						tvcmspaymenticonmain_id 			= '.$data["id"].',
						tvcmspaymenticonmain_link 			= "'.$data['tvcmspaymenticonmain_link'].'" ,
						tvcmspaymenticonmain_image 			= "'.$data['tvcmspaymenticonmain_image'].'" ,
						tvcmspaymenticon_status 			= "'.$data['tvcmspaymenticon_status'].'" ,
						tvcmspaymenticonmain_pos 			= '.$data['id'].';');
		foreach ($data['tvcmspaymenticon'] as $language_id => $value) {
			$this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmspaymenticonsub`
						SET
							tvcmspaymenticonmain_id 		= '.$data["id"].',
							`tvcmspaymenticonsublang_id` 	= '.$language_id.',
							tvcmspaymenticonsub_title 		= "'.$value['tvcmspaymenticonsub_title'].'"');
		}

	}

	public function gettottaldata(){
		$sql  = "SELECT COUNT(DISTINCT tvcmspaymenticonmain_id) AS total FROM `" . DB_PREFIX . "tvcmspaymenticonmain`";
		$query = $this->db->query($sql);
		return $query->row['total'];
	}

	public function edittestimonial($tvcmspaymenticonmain_id, $data) {
		$this->db->query('UPDATE `' . DB_PREFIX . 'tvcmspaymenticonmain`
			SET 
			tvcmspaymenticon_status 			= '.$data['tvcmspaymenticon_status'].',
			tvcmspaymenticonmain_link		= "'.$data['tvcmspaymenticonmain_link'].'" WHERE tvcmspaymenticonmain_id = ' . (int)$tvcmspaymenticonmain_id . '');

		$this->db->query("DELETE FROM " . DB_PREFIX . "tvcmspaymenticonsub WHERE tvcmspaymenticonmain_id = '" . (int)$tvcmspaymenticonmain_id . "'");
		
		foreach ($data['tvcmspaymenticon'] as $language_id => $value) {
			$this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmspaymenticonsub`
						SET 
							tvcmspaymenticonmain_id 			= '.$tvcmspaymenticonmain_id.',
							tvcmspaymenticonsub_title 			= "'.$value['tvcmspaymenticonsub_title'].'",
							tvcmspaymenticonsublang_id 			= '.$value['lang'].'');
		}
	}
	
	public function deletetestimonial($tvcmspaymenticonmain_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "tvcmspaymenticonmain WHERE tvcmspaymenticonmain_id = '" . (int)$tvcmspaymenticonmain_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "tvcmspaymenticonsub WHERE tvcmspaymenticonmain_id = '" . (int)$tvcmspaymenticonmain_id . "'");
	
		$this->cache->delete('tvcmspaymenticonmain');
		$this->cache->delete('tvcmspaymenticonsub');
	}

	public function gettestimonialsigle($tvcmspaymenticonmain_id) {
		
		$query = $this->db->query("SELECT  " . DB_PREFIX . "tvcmspaymenticonsub.*, " . DB_PREFIX . "tvcmspaymenticonmain.* FROM  " . DB_PREFIX . "tvcmspaymenticonsub
			INNER JOIN " . DB_PREFIX . "tvcmspaymenticonmain ON  
			" . DB_PREFIX . "tvcmspaymenticonsub.tvcmspaymenticonmain_id = " . DB_PREFIX . "tvcmspaymenticonmain.tvcmspaymenticonmain_id
			WHERE " . DB_PREFIX . "tvcmspaymenticonsub.tvcmspaymenticonmain_id = '" . (int)$tvcmspaymenticonmain_id . "'");

		return  $query->rows;
	}

	public function gettestimonial($data = array()) {

		$sql = "SELECT * FROM " . DB_PREFIX . "tvcmspaymenticonmain p LEFT JOIN " . DB_PREFIX . "tvcmspaymenticonsub pd ON (p.tvcmspaymenticonmain_id = pd.tvcmspaymenticonmain_id) WHERE pd.tvcmspaymenticonsublang_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.tvcmspaymenticonsub_title LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$sql .= " AND p.tvcmspaymenticon_status = '" . (int)$data['filter_status'] . "'";
		}

		$sql .= " GROUP BY p.tvcmspaymenticonmain_id";

		$sort_data = array(
			'pd.tvcmspaymenticonsub_title',
			'p.tvcmspaymenticonmain_link',
			'pd.tvcmspaymenticonsub_designation',
			'pd.tvcmspaymenticonsub_description',
			'p.tvcmspaymenticon_status'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY p.tvcmspaymenticonmain_pos";
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

		$sql = "SELECT COUNT(DISTINCT tvcmspaymenticonsub_id) AS total FROM " . DB_PREFIX . "tvcmspaymenticonmain p LEFT JOIN " . DB_PREFIX . "tvcmspaymenticonsub pd ON (p.tvcmspaymenticonmain_id = pd.tvcmspaymenticonmain_id) WHERE pd.tvcmspaymenticonsublang_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.tvcmspaymenticonsub_title LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$sql .= " AND p.tvcmspaymenticon_status = '" . (int)$data['filter_status'] . "'";
		}

		$query = $this->db->query($sql);
		return $query->row['total'];
	}
}
