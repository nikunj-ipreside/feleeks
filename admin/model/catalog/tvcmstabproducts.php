<?php

class ModelCatalogTvcmstabproducts extends Model {
	
	public function updatePosition($position){
	    foreach ($position as $key => $value) {
	        $pos = $key + 1;
	        $this->db->query("UPDATE " . DB_PREFIX . "tvcmstabproductsmain SET tvcmstabproductsmain_pos = '" . (int)$pos . "' WHERE tvcmstabproductsmain_id = '" . (int)$value . "'");
	    }    
	}

	public function copyimageslider($tvcmstabproductsmain_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "tvcmstabproductsmain p WHERE p.tvcmstabproductsmain_id = '" . (int)$tvcmstabproductsmain_id . "'");

		if ($query->num_rows) {
			$data = $query->row;
		
			$data['tvcmstabproducts'] 		= $this->getimageslidercopy($tvcmstabproductsmain_id);
			$data['tvcmstabproducts_link'] 	= $data['tvcmstabproductsmain_link'];
		

			$this->insertdata($data);
		}
	}

	public function getimageslidercopy($tvcmstabproductsmain_id) {
		$image_slider_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tvcmstabproductssub WHERE tvcmstabproductsmain_id = '" . (int)$tvcmstabproductsmain_id . "'");

		foreach ($query->rows as $result) {
			$image_slider_data[$result['tvcmstabproductssublang_id']] = array(
				'tvcmstabproductssub_image'             => $result['tvcmstabproductssub_image'],
				'tvcmstabproductssub_title'      		=> $result['tvcmstabproductssub_title'],
				'tvcmstabproductssub_textaligment'      => $result['tvcmstabproductssub_textaligment'],
				'tvcmstabproductssub_buttoncaption' 	=> $result['tvcmstabproductssub_buttoncaption'],
				'tvcmstabproductssub_des'     			=> $result['tvcmstabproductssub_des'],
				'tvcmstabproductssub_enable'     		=> $result['tvcmstabproductssub_enable'],
				'lang'            						=> $result['tvcmstabproductssublang_id']
			);
		}

		return $image_slider_data;
	}

	public function insertdata($data) {

		$query = "SELECT MAX(tvcmstabproductsmain_id) as id FROM `" . DB_PREFIX . "tvcmstabproductsmain`";
		$query = $this->db->query($query);
		$data['id'] = $query->row['id'] + 1;
		
		$this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmstabproductsmain`
			SET 
						tvcmstabproductsmain_id = '.$data["id"].',
						tvcmstabproductsmain_link = "'.$data['tvcmstabproducts_link'].'" ,
						tvcmstabproductsmain_pos = '.$data['id'].';');

		foreach ($data['tvcmstabproducts'] as $language_id => $value) {
			$this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmstabproductssub`
						SET 
							tvcmstabproductsmain_id = '.$data["id"].',
							tvcmstabproductssub_image = "'.$value['tvcmstabproductssub_image'].'",
							tvcmstabproductssub_title = "'.$value['tvcmstabproductssub_title'].'",
							tvcmstabproductssub_textaligment = "'.$value['tvcmstabproductssub_textaligment'].'",
							tvcmstabproductssub_buttoncaption = "'.$value['tvcmstabproductssub_buttoncaption'].'",
							tvcmstabproductssub_des = "'.$value['tvcmstabproductssub_des'].'",
							tvcmstabproductssub_enable = '.$value['tvcmstabproductssub_enable'].',
							tvcmstabproductssublang_id = '.$value['lang'].'');
		}
	}

	public function gettottaldata(){
		$sql  = "SELECT COUNT(DISTINCT tvcmstabproductsmain_id) AS total FROM `" . DB_PREFIX . "tvcmstabproductsmain`";
		$query = $this->db->query($sql);
		return $query->row['total'];
	}

	public function editimageslider($tvcmstabproductsmain_id, $data) {

		$this->db->query('UPDATE `' . DB_PREFIX . 'tvcmstabproductsmain`
			SET 
						tvcmstabproductsmain_link = "'.$data['tvcmstabproducts_link'].'" WHERE tvcmstabproductsmain_id = "' . (int)$tvcmstabproductsmain_id . '" ');
		$this->db->query("DELETE FROM " . DB_PREFIX . "tvcmstabproductssub WHERE tvcmstabproductsmain_id = '" . (int)$tvcmstabproductsmain_id . "'");
		
		foreach ($data['tvcmstabproducts'] as $language_id => $value) {
			$this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmstabproductssub`
						SET 
							tvcmstabproductsmain_id = '.$tvcmstabproductsmain_id.',
							tvcmstabproductssub_image = "'.$value['tvcmstabproductssub_image'].'",
							tvcmstabproductssub_title = "'.$value['tvcmstabproductssub_title'].'",
							tvcmstabproductssub_textaligment = "'.$value['tvcmstabproductssub_textaligment'].'",
							tvcmstabproductssub_buttoncaption = "'.$value['tvcmstabproductssub_buttoncaption'].'",
							tvcmstabproductssub_des = "'.$value['tvcmstabproductssub_des'].'",
							tvcmstabproductssub_enable = '.$value['tvcmstabproductssub_enable'].',
							tvcmstabproductssublang_id = '.$value['lang'].'');
		}
	}
	
	public function deleteimageslider($tvcmstabproductsmain_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "tvcmstabproductsmain WHERE tvcmstabproductsmain_id = '" . (int)$tvcmstabproductsmain_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "tvcmstabproductssub WHERE tvcmstabproductsmain_id = '" . (int)$tvcmstabproductsmain_id . "'");
	
		$this->cache->delete('tvcmstabproductsmain');
		$this->cache->delete('tvcmstabproductssub');
	}

	public function getimageslidesigle($tvcmstabproductsmain_id) {
		
		$query = $this->db->query("SELECT  " . DB_PREFIX . "tvcmstabproductssub.*, " . DB_PREFIX . "tvcmstabproductsmain.* FROM  " . DB_PREFIX . "tvcmstabproductssub
			INNER JOIN " . DB_PREFIX . "tvcmstabproductsmain ON  
			" . DB_PREFIX . "tvcmstabproductssub.tvcmstabproductsmain_id = " . DB_PREFIX . "tvcmstabproductsmain.tvcmstabproductsmain_id
			WHERE " . DB_PREFIX . "tvcmstabproductssub.tvcmstabproductsmain_id = '" . (int)$tvcmstabproductsmain_id . "'");

		return  $query->rows;
	}

	public function getsliderimage($data = array()) {

		$sql = "SELECT * FROM " . DB_PREFIX . "tvcmstabproductsmain p LEFT JOIN " . DB_PREFIX . "tvcmstabproductssub pd ON (p.tvcmstabproductsmain_id = pd.tvcmstabproductsmain_id) WHERE pd.tvcmstabproductssublang_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.tvcmstabproductssub_title LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$sql .= " AND pd.tvcmstabproductssub_enable = '" . (int)$data['filter_status'] . "'";
		}

		$sql .= " GROUP BY p.tvcmstabproductsmain_id";

		$sort_data = array(
			'pd.tvcmstabproductssub_title',
			'pd.tvcmstabproductsmain_link',
			'pd.tvcmstabproductssub_des',
			'pd.tvcmstabproductssub_textaligment',
			'pd.tvcmstabproductssub_buttoncaption',
			'pd.tvcmstabproductssub_enable'			
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY p.tvcmstabproductsmain_pos";
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

	public function getTotalsliderimage($data = array()) {
		$sql  = "SELECT COUNT(DISTINCT tvcmstabproductssub_id) AS total FROM `" . DB_PREFIX . "tvcmstabproductssub`";

		$sql .= " WHERE tvcmstabproductssublang_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND tvcmstabproductssub_title LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$sql .= " AND tvcmstabproductssub_enable = '" . (int)$data['filter_status'] . "'";
		}

		$query = $this->db->query($sql);
		return $query->row['total'];
	}
}
