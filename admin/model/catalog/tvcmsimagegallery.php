<?php

class ModelCatalogTvcmsimagegallery extends Model {
	public function updatePosition($position){
	    foreach ($position as $key => $value) {
	        $pos = $key + 1;
	        $this->db->query("UPDATE " . DB_PREFIX . "tvcmsimagegallerymain SET tvcmsimagegallerymain_pos = '" . (int)$pos . "' WHERE tvcmsimagegallerymain_id = '" . (int)$value . "'");
	    }    
	}

	public function copytestimonial($tvcmsimagegallerymain_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "tvcmsimagegallerymain p WHERE p.tvcmsimagegallerymain_id = '" . (int)$tvcmsimagegallerymain_id . "'");
		
		if ($query->num_rows) {
			$data 									= $query->row;
			$datas['tvcmsimagegallery'] 				= $this->getimageslidercopy($tvcmsimagegallerymain_id);
			$datas['tvcmsimagegallerymain_link'] 	= $data['tvcmsimagegallerymain_link'];
			$datas['tvcmsimagegallerymain_img'] 		= $query->row['tvcmsimagegallerymain_image'];
			$datas['tvcmsimagegallery_status'] 		= $query->row['tvcmsimagegallery_status'];

			$this->insertdata($datas);
		}
	}


	public function getimageslidercopy($tvcmsimagegallerymain_id) {
		$image_slider_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tvcmsimagegallerysub WHERE tvcmsimagegallerymain_id = '" . (int)$tvcmsimagegallerymain_id . "'");

		foreach ($query->rows as $result) {
			$image_slider_data[$result['tvcmsimagegallerysublang_id']] = array(
				'tvcmsimagegallerysub_title'      	=> $result['tvcmsimagegallerysub_title'],
				'tvcmsimagegallerysub_designation'   => $result['tvcmsimagegallerysub_designation'],
				'tvcmsimagegallerysub_description' 	=> $result['tvcmsimagegallerysub_description'],
				'lang'            					=> $result['tvcmsimagegallerysublang_id']
			);
		}

		return $image_slider_data;
	}

	public function insertdata($data) {
		$query = "SELECT MAX(tvcmsimagegallerymain_id) as id FROM `" . DB_PREFIX . "tvcmsimagegallerymain`";
		$query = $this->db->query($query);

		$data['id'] = $query->row['id'] + 1;

		$this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmsimagegallerymain`
			SET
						tvcmsimagegallerymain_id 			= '.$data["id"].',
						tvcmsimagegallerymain_link 			= "'.$data['tvcmsimagegallerymain_link'].'" ,
						tvcmsimagegallerymain_image 			= "'.$data['tvcmsimagegallerymain_image'].'" ,
						tvcmsimagegallery_status 			= "'.$data['tvcmsimagegallery_status'].'" ,
						tvcmsimagegallerymain_pos 			= '.$data['id'].';');
		foreach ($data['tvcmsimagegallery'] as $language_id => $value) {
			$this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmsimagegallerysub`
						SET
							tvcmsimagegallerymain_id 		= '.$data["id"].',
							`tvcmsimagegallerysublang_id` 	= '.$language_id.',
							tvcmsimagegallerysub_title 		= "'.$value['tvcmsimagegallerysub_title'].'"');
		}

	}

	public function gettottaldata(){
		$sql  = "SELECT COUNT(DISTINCT tvcmsimagegallerymain_id) AS total FROM `" . DB_PREFIX . "tvcmsimagegallerymain`";
		$query = $this->db->query($sql);
		return $query->row['total'];
	}

	public function edittestimonial($tvcmsimagegallerymain_id, $data) {
		$this->db->query('UPDATE `' . DB_PREFIX . 'tvcmsimagegallerymain`
			SET 
			tvcmsimagegallery_status 			= '.$data['tvcmsimagegallery_status'].',
			tvcmsimagegallerymain_link		= "'.$data['tvcmsimagegallerymain_link'].'" WHERE tvcmsimagegallerymain_id = ' . (int)$tvcmsimagegallerymain_id . '');

		$this->db->query("DELETE FROM " . DB_PREFIX . "tvcmsimagegallerysub WHERE tvcmsimagegallerymain_id = '" . (int)$tvcmsimagegallerymain_id . "'");
		
		foreach ($data['tvcmsimagegallery'] as $language_id => $value) {
			$this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmsimagegallerysub`
						SET 
							tvcmsimagegallerymain_id 			= '.$tvcmsimagegallerymain_id.',
							tvcmsimagegallerysub_title 			= "'.$value['tvcmsimagegallerysub_title'].'",
							tvcmsimagegallerysublang_id 			= '.$value['lang'].'');
		}
	}
	
	public function deletetestimonial($tvcmsimagegallerymain_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "tvcmsimagegallerymain WHERE tvcmsimagegallerymain_id = '" . (int)$tvcmsimagegallerymain_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "tvcmsimagegallerysub WHERE tvcmsimagegallerymain_id = '" . (int)$tvcmsimagegallerymain_id . "'");
	
		$this->cache->delete('tvcmsimagegallerymain');
		$this->cache->delete('tvcmsimagegallerysub');
	}

	public function gettestimonialsigle($tvcmsimagegallerymain_id) {
		
		$query = $this->db->query("SELECT  " . DB_PREFIX . "tvcmsimagegallerysub.*, " . DB_PREFIX . "tvcmsimagegallerymain.* FROM  " . DB_PREFIX . "tvcmsimagegallerysub
			INNER JOIN " . DB_PREFIX . "tvcmsimagegallerymain ON  
			" . DB_PREFIX . "tvcmsimagegallerysub.tvcmsimagegallerymain_id = " . DB_PREFIX . "tvcmsimagegallerymain.tvcmsimagegallerymain_id
			WHERE " . DB_PREFIX . "tvcmsimagegallerysub.tvcmsimagegallerymain_id = '" . (int)$tvcmsimagegallerymain_id . "'");

		return  $query->rows;
	}

	public function gettestimonial($data = array()) {

		$sql = "SELECT * FROM " . DB_PREFIX . "tvcmsimagegallerymain p LEFT JOIN " . DB_PREFIX . "tvcmsimagegallerysub pd ON (p.tvcmsimagegallerymain_id = pd.tvcmsimagegallerymain_id) WHERE pd.tvcmsimagegallerysublang_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.tvcmsimagegallerysub_title LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$sql .= " AND p.tvcmsimagegallery_status = '" . (int)$data['filter_status'] . "'";
		}

		$sql .= " GROUP BY p.tvcmsimagegallerymain_id";

		$sort_data = array(
			'pd.tvcmsimagegallerysub_title',
			'p.tvcmsimagegallerymain_link',
			'pd.tvcmsimagegallerysub_designation',
			'pd.tvcmsimagegallerysub_description',
			'p.tvcmsimagegallery_status'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY p.tvcmsimagegallerymain_pos";
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

		$sql = "SELECT COUNT(DISTINCT tvcmsimagegallerysub_id) AS total FROM " . DB_PREFIX . "tvcmsimagegallerymain p LEFT JOIN " . DB_PREFIX . "tvcmsimagegallerysub pd ON (p.tvcmsimagegallerymain_id = pd.tvcmsimagegallerymain_id) WHERE pd.tvcmsimagegallerysublang_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.tvcmsimagegallerysub_title LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$sql .= " AND p.tvcmsimagegallery_status = '" . (int)$data['filter_status'] . "'";
		}

		$query = $this->db->query($sql);
		return $query->row['total'];
	}
}
