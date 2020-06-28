<?php

class ModelCatalogTvcmssocialicon extends Model {
	public function updatePosition($position){
	    foreach ($position as $key => $value) {
	        $pos = $key + 1;
	        $this->db->query("UPDATE " . DB_PREFIX . "tvcmssocialiconmain SET tvcmssocialiconmain_pos = '" . (int)$pos . "' WHERE tvcmssocialiconmain_id = '" . (int)$value . "'");
	    }    
	}

	public function copytestimonial($tvcmssocialiconmain_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "tvcmssocialiconmain p WHERE p.tvcmssocialiconmain_id = '" . (int)$tvcmssocialiconmain_id . "'");

		if ($query->num_rows) {
			$data 								= $query->row;
			$data['tvcmssocialicon'] 			= $this->getimageslidercopy($tvcmssocialiconmain_id);
			$data['tvcmssocialiconmain_link'] 	= $data['tvcmssocialiconmain_link'];

			$this->insertdata($data);
		}
	}

	public function getimageslidercopy($tvcmssocialiconmain_id) {
		$image_slider_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tvcmssocialiconsub WHERE tvcmssocialiconmain_id = '" . (int)$tvcmssocialiconmain_id . "'");

		foreach ($query->rows as $result) {
			$image_slider_data[$result['tvcmssocialiconsublang_id']] = array(
				'tvcmssocialiconsub_title'      	=> $result['tvcmssocialiconsub_title'],
				'tvcmssocialiconsub_designation'   => $result['tvcmssocialiconsub_designation'],
				'tvcmssocialiconsub_description' 	=> $result['tvcmssocialiconsub_description'],
				'lang'            					=> $result['tvcmssocialiconsublang_id']
			);
		}

		return $image_slider_data;
	}

	public function insertdata($data) {

		$query = "SELECT MAX(tvcmssocialiconmain_id) as id FROM `" . DB_PREFIX . "tvcmssocialiconmain`";
		$query = $this->db->query($query);

		$data['id'] = $query->row['id'] + 1;

		$this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmssocialiconmain`
			SET
						tvcmssocialiconmain_id 			= '.$data["id"].',
						tvcmssocialiconmain_link 		= "'.$data['tvcmssocialiconmain_link'].'" ,
						tvcmssocialiconmain_class_name 	= "'.$data['tvcmssocialiconmain_class_name'].'" ,
						tvcmssocialicon_status 			= "'.$data['tvcmssocialicon_status'].'" ,
						tvcmssocialiconmain_pos 		= '.$data['id'].';');
		foreach ($data['tvcmssocialicon'] as $language_id => $value) {
			$this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmssocialiconsub`
						SET
							tvcmssocialiconmain_id 				= '.$data["id"].',
							`tvcmssocialiconsublang_id` 		= '.$language_id.',
							tvcmssocialiconsub_title 			= "'.$value['tvcmssocialiconsub_title'].'"');
		}

	}

	public function gettottaldata(){
		$sql  = "SELECT COUNT(DISTINCT tvcmssocialiconmain_id) AS total FROM `" . DB_PREFIX . "tvcmssocialiconmain`";
		$query = $this->db->query($sql);
		return $query->row['total'];
	}

	public function edittestimonial($tvcmssocialiconmain_id, $data) {
	
		$this->db->query('UPDATE `' . DB_PREFIX . 'tvcmssocialiconmain`
			SET 
			tvcmssocialicon_status 			= '.$data['tvcmssocialicon_status'].',
			tvcmssocialiconmain_class_name 	= "'.$data['tvcmssocialiconmain_class_name'].'",
			tvcmssocialiconmain_link		= "'.$data['tvcmssocialiconmain_link'].'" WHERE tvcmssocialiconmain_id = ' . (int)$tvcmssocialiconmain_id . '');

		$this->db->query("DELETE FROM " . DB_PREFIX . "tvcmssocialiconsub WHERE tvcmssocialiconmain_id = '" . (int)$tvcmssocialiconmain_id . "'");
		
		foreach ($data['tvcmssocialicon'] as $language_id => $value) {
			$this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmssocialiconsub`
						SET 
							tvcmssocialiconmain_id 			= '.$tvcmssocialiconmain_id.',
							tvcmssocialiconsub_title 			= "'.$value['tvcmssocialiconsub_title'].'",
							tvcmssocialiconsublang_id 			= '.$value['lang'].'');
		}
	}
	
	public function deletetestimonial($tvcmssocialiconmain_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "tvcmssocialiconmain WHERE tvcmssocialiconmain_id = '" . (int)$tvcmssocialiconmain_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "tvcmssocialiconsub WHERE tvcmssocialiconmain_id = '" . (int)$tvcmssocialiconmain_id . "'");
	
		$this->cache->delete('tvcmssocialiconmain');
		$this->cache->delete('tvcmssocialiconsub');
	}

	public function gettestimonialsigle($tvcmssocialiconmain_id) {
		
		$query = $this->db->query("SELECT  " . DB_PREFIX . "tvcmssocialiconsub.*, " . DB_PREFIX . "tvcmssocialiconmain.* FROM  " . DB_PREFIX . "tvcmssocialiconsub
			INNER JOIN " . DB_PREFIX . "tvcmssocialiconmain ON  
			" . DB_PREFIX . "tvcmssocialiconsub.tvcmssocialiconmain_id = " . DB_PREFIX . "tvcmssocialiconmain.tvcmssocialiconmain_id
			WHERE " . DB_PREFIX . "tvcmssocialiconsub.tvcmssocialiconmain_id = '" . (int)$tvcmssocialiconmain_id . "'");

		return  $query->rows;
	}

	public function gettestimonial($data = array()) {

		$sql = "SELECT * FROM " . DB_PREFIX . "tvcmssocialiconmain p LEFT JOIN " . DB_PREFIX . "tvcmssocialiconsub pd ON (p.tvcmssocialiconmain_id = pd.tvcmssocialiconmain_id) WHERE pd.tvcmssocialiconsublang_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.tvcmssocialiconsub_title LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$sql .= " AND p.tvcmssocialicon_status = '" . (int)$data['filter_status'] . "'";
		}

		$sql .= " GROUP BY p.tvcmssocialiconmain_id";

		$sort_data = array(
			'pd.tvcmssocialiconsub_title',
			'p.tvcmssocialiconmain_link',
			'pd.tvcmssocialiconsub_designation',
			'pd.tvcmssocialiconsub_description',
			'p.tvcmssocialicon_status'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY p.tvcmssocialiconmain_pos";
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

		$sql = "SELECT COUNT(DISTINCT tvcmssocialiconsub_id) AS total FROM " . DB_PREFIX . "tvcmssocialiconmain p LEFT JOIN " . DB_PREFIX . "tvcmssocialiconsub pd ON (p.tvcmssocialiconmain_id = pd.tvcmssocialiconmain_id) WHERE pd.tvcmssocialiconsublang_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.tvcmssocialiconsub_title LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$sql .= " AND p.tvcmssocialicon_status = '" . (int)$data['filter_status'] . "'";
		}

		$query = $this->db->query($sql);
		return $query->row['total'];
	}
}
