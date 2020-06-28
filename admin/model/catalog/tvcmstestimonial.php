<?php

class ModelCatalogTvcmstestimonial extends Model {
	public function updatePosition($position){
	    foreach ($position as $key => $value) {
	        $pos = $key + 1;
	        $this->db->query("UPDATE " . DB_PREFIX . "tvcmstestimonialmain SET tvcmstestimonialmain_pos = '" . (int)$pos . "' WHERE tvcmstestimonialmain_id = '" . (int)$value . "'");
	    }    
	}

	public function copytestimonial($tvcmstestimonialmain_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "tvcmstestimonialmain p WHERE p.tvcmstestimonialmain_id = '" . (int)$tvcmstestimonialmain_id . "'");

		if ($query->num_rows) {
			$data 								= $query->row;
			$data['tvcmstestimonial'] 			= $this->getimageslidercopy($tvcmstestimonialmain_id);
			$data['tvcmstestimonialmain_link'] 	= $data['tvcmstestimonialmain_link'];

			$this->insertdata($data);
		}
	}

	public function getimageslidercopy($tvcmstestimonialmain_id) {
		$image_slider_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tvcmstestimonialsub WHERE tvcmstestimonialmain_id = '" . (int)$tvcmstestimonialmain_id . "'");

		foreach ($query->rows as $result) {
			$image_slider_data[$result['tvcmstestimonialsublang_id']] = array(
				'tvcmstestimonialsub_title'      	=> $result['tvcmstestimonialsub_title'],
				'tvcmstestimonialsub_designation'   => $result['tvcmstestimonialsub_designation'],
				'tvcmstestimonialsub_description' 	=> $result['tvcmstestimonialsub_description'],
				'lang'            					=> $result['tvcmstestimonialsublang_id']
			);
		}

		return $image_slider_data;
	}

	public function insertdata($data) {
		$query = "SELECT MAX(tvcmstestimonialmain_id) as id FROM `" . DB_PREFIX . "tvcmstestimonialmain`";
		$query = $this->db->query($query);

		$data['id'] = $query->row['id'] + 1;

		$this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmstestimonialmain`
			SET
						tvcmstestimonialmain_id 		= '.$data["id"].',
						tvcmstestimonialmain_link 		= "'.$data['tvcmstestimonialmain_link'].'" ,
						tvcmstestimonial_status 		= "'.$data['tvcmstestimonial_status'].'" ,
						tvcmstestimonial_img 			= "'.$data['tvcmstestimonial_img'].'" ,
						tvcmstestimonial_sing_img 		= "'.$data['tvcmstestimonial_sing_img'].'" ,
						tvcmstestimonial_sing_text 	    = "'.$data['tvcmstestimonialmain_sing_text'].'" ,
						tvcmstestimonialmain_pos 		= '.$data['id'].';');

		foreach ($data['tvcmstestimonial'] as $language_id => $value) {
			if(empty($value['tvcmstestimonialsub_title'])){
				$value['tvcmstestimonialsub_title'] = "title";
			}
			if(empty($value['tvcmstestimonialsub_designation'])){
				$value['tvcmstestimonialsub_designation'] = "description";
			}
			if(empty($value['tvcmstestimonialsub_short_description'])){
				$value['tvcmstestimonialsub_short_description'] = "short desciption";
			}
			if(empty($value['tvcmstestimonialsub_description'])){
				$value['tvcmstestimonialsub_description'] = "sub description";
			}
			$this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmstestimonialsub`
						SET
							tvcmstestimonialmain_id 			= '.$data["id"].',
							tvcmstestimonialsub_title 			= "'.$value['tvcmstestimonialsub_title'].'",
							tvcmstestimonialsub_designation 	= "'.$value['tvcmstestimonialsub_designation'].'",
							tvcmstestimonialsub_short_description 	= "'.$value['tvcmstestimonialsub_short_description'].'",
							tvcmstestimonialsub_description 	= "'.$value['tvcmstestimonialsub_description'].'",
							tvcmstestimonialsublang_id 			= '.$value['lang'].'');
		}

	}

	public function gettottaldata(){
		$sql  = "SELECT COUNT(DISTINCT tvcmstestimonialmain_id) AS total FROM `" . DB_PREFIX . "tvcmstestimonialmain`";
		$query = $this->db->query($sql);
		return $query->row['total'];
	}

	public function edittestimonial($tvcmstestimonialmain_id, $data) {
		
		$this->db->query('UPDATE `' . DB_PREFIX . 'tvcmstestimonialmain`
			SET 
			tvcmstestimonial_status 	= '.$data['tvcmstestimonial_status'].',
			tvcmstestimonial_img 		= "'.$data['tvcmstestimonial_img'].'" ,
			tvcmstestimonial_sing_img 	= "'.$data['tvcmstestimonial_sing_img'].'" ,
			tvcmstestimonial_sing_text 	= "'.$data['tvcmstestimonialmain_sing_text'].'" ,
			tvcmstestimonialmain_link	= "'.$data['tvcmstestimonialmain_link'].'" WHERE tvcmstestimonialmain_id = "' . (int)$tvcmstestimonialmain_id . '" ');
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "tvcmstestimonialsub WHERE tvcmstestimonialmain_id = '" . (int)$tvcmstestimonialmain_id . "'");
		
		foreach ($data['tvcmstestimonial'] as $language_id => $value) {
			if(empty($value['tvcmstestimonialsub_title'])){
				$value['tvcmstestimonialsub_title'] = "title";
			}
			if(empty($value['tvcmstestimonialsub_designation'])){
				$value['tvcmstestimonialsub_designation'] = "description";
			}
			if(empty($value['tvcmstestimonialsub_short_description'])){
				$value['tvcmstestimonialsub_short_description'] = "short desciption";
			}
			if(empty($value['tvcmstestimonialsub_description'])){
				$value['tvcmstestimonialsub_description'] = "sub description";
			}
			$this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmstestimonialsub`
						SET 
							tvcmstestimonialmain_id 				= '.$tvcmstestimonialmain_id.',
							tvcmstestimonialsub_title 				= "'.$value['tvcmstestimonialsub_title'].'",
							tvcmstestimonialsub_designation 		= "'.$value['tvcmstestimonialsub_designation'].'",
							tvcmstestimonialsub_short_description 	= "'.$value['tvcmstestimonialsub_short_description'].'",
							tvcmstestimonialsub_description 		= "'.$value['tvcmstestimonialsub_description'].'",
							tvcmstestimonialsublang_id 				= '.$value['lang'].'');
		}
	}
	
	public function deletetestimonial($tvcmstestimonialmain_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "tvcmstestimonialmain WHERE tvcmstestimonialmain_id = '" . (int)$tvcmstestimonialmain_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "tvcmstestimonialsub WHERE tvcmstestimonialmain_id = '" . (int)$tvcmstestimonialmain_id . "'");
	
		$this->cache->delete('tvcmstestimonialmain');
		$this->cache->delete('tvcmstestimonialsub');
	}

	public function gettestimonialsigle($tvcmstestimonialmain_id) {
		
		$query = $this->db->query("SELECT  " . DB_PREFIX . "tvcmstestimonialsub.*, " . DB_PREFIX . "tvcmstestimonialmain.* FROM  " . DB_PREFIX . "tvcmstestimonialsub
			INNER JOIN " . DB_PREFIX . "tvcmstestimonialmain ON  
			" . DB_PREFIX . "tvcmstestimonialsub.tvcmstestimonialmain_id = " . DB_PREFIX . "tvcmstestimonialmain.tvcmstestimonialmain_id
			WHERE " . DB_PREFIX . "tvcmstestimonialsub.tvcmstestimonialmain_id = '" . (int)$tvcmstestimonialmain_id . "'");

		return  $query->rows;
	}

	public function gettestimonial($data = array()) {

		$sql = "SELECT * FROM " . DB_PREFIX . "tvcmstestimonialmain p LEFT JOIN " . DB_PREFIX . "tvcmstestimonialsub pd ON (p.tvcmstestimonialmain_id = pd.tvcmstestimonialmain_id) WHERE pd.tvcmstestimonialsublang_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.tvcmstestimonialsub_title LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$sql .= " AND p.tvcmstestimonial_status = '" . (int)$data['filter_status'] . "'";
		}

		$sql .= " GROUP BY p.tvcmstestimonialmain_id";

		$sort_data = array(
			'pd.tvcmstestimonialsub_title',
			'p.tvcmstestimonialmain_link',
			'pd.tvcmstestimonialsub_designation',
			'pd.tvcmstestimonialsub_description',
			'p.tvcmstestimonial_status'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY p.tvcmstestimonialmain_pos";
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

		$sql = "SELECT COUNT(DISTINCT tvcmstestimonialsub_id) AS total FROM " . DB_PREFIX . "tvcmstestimonialmain p LEFT JOIN " . DB_PREFIX . "tvcmstestimonialsub pd ON (p.tvcmstestimonialmain_id = pd.tvcmstestimonialmain_id) WHERE pd.tvcmstestimonialsublang_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.tvcmstestimonialsub_title LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$sql .= " AND p.tvcmstestimonial_status = '" . (int)$data['filter_status'] . "'";
		}

		$query = $this->db->query($sql);
		return $query->row['total'];
	}
}
