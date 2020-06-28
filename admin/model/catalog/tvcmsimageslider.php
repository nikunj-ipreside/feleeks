<?php

class ModelCatalogTvcmsimageslider extends Model {
	protected function status(){
		return $this->Tvcmsthemevoltystatus->imageslider();
	}
	public function updatePosition($position){
	    foreach ($position as $key => $value) {
	        $pos = $key + 1;
	        $this->db->query("UPDATE " . DB_PREFIX . "tvcmsimageslidermain SET tvcmsimageslidermain_pos = '" . (int)$pos . "' WHERE tvcmsimageslidermain_id = '" . (int)$value . "'");
	    }    
	}

	public function copyimageslider($tvcmsimageslidermain_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "tvcmsimageslidermain p WHERE p.tvcmsimageslidermain_id = '" . (int)$tvcmsimageslidermain_id . "'");
		if ($query->num_rows) {
			$data 							= $query->row;
			$data['tvcmsimageslider'] 		= $this->getimageslidercopy($tvcmsimageslidermain_id);
			$this->insertdata($data);
		}
	}

	public function getimageslidercopy($tvcmsimageslidermain_id) {
		$image_slider_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tvcmsimageslidersub WHERE tvcmsimageslidermain_id = '" . (int)$tvcmsimageslidermain_id . "'");

		foreach ($query->rows as $result) {
			$image_slider_data[$result['tvcmsimageslidersublang_id']] = array(
				'tvcmsimageslidersub_link'              => $result['tvcmsimageslidersub_link'],
				'tvcmsimageslidersub_image'             => $result['tvcmsimageslidersub_image'],
				'tvcmsimageslidersub_title'      		=> $result['tvcmsimageslidersub_title'],
				'tvcmsimageslidersub_textaligment'      => $result['tvcmsimageslidersub_textaligment'],
				'tvcmsimageslidersub_buttoncaption' 	=> $result['tvcmsimageslidersub_buttoncaption'],
				'tvcmsimageslidersub_des_main'     		=> $result['tvcmsimageslidersub_des_main'],
				'tvcmsimageslidersub_des_sub'     		=> $result['tvcmsimageslidersub_des_sub'],
				'tvcmsimageslidersub_enable'     		=> $result['tvcmsimageslidersub_enable'],
				'lang'            						=> $result['tvcmsimageslidersublang_id']
			);
		}

		return $image_slider_data;
	}

	public function insertdata($data) {

		$query = "SELECT MAX(tvcmsimageslidermain_id) as id FROM `" . DB_PREFIX . "tvcmsimageslidermain`";
		$query = $this->db->query($query);
		$data['id'] = $query->row['id'] + 1;
		
		$this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmsimageslidermain`
			SET 
				tvcmsimageslidermain_id = '.$data["id"].',
				tvcmsimageslidermain_pos = '.$data['id'].';');

		foreach ($data['tvcmsimageslider'] as $language_id => $value) {

			if(!empty($value['tvcmsimageslidersub_title'])){
				$title = $value['tvcmsimageslidersub_title'];
			}else{
				$title = "";
			}
			if(!empty($value['tvcmsimageslidersub_image'])){
				$image = $value['tvcmsimageslidersub_image'];
			}else{
				$image = "";
			}
			if(!empty($value['tvcmsimageslidersub_link'])){
				$link = $value['tvcmsimageslidersub_link'];
			}else{
				$link = "";
			}
			if(!empty($value['tvcmsimageslidersub_textaligment'])){
				$aligment = $value['tvcmsimageslidersub_textaligment'];
			}else{
				$aligment = "";
			}
			if(!empty($value['tvcmsimageslidersub_buttoncaption'])){
				$btncaption = $value['tvcmsimageslidersub_buttoncaption'];
			}else{
				$btncaption = "";
			}
			if(!empty($value['tvcmsimageslidersub_des_main'])){
				$des_main = $value['tvcmsimageslidersub_des_main'];
			}else{
				$des_main = "";
			}
			if(!empty($value['tvcmsimageslidersub_des_sub'])){
				$des_sub = $value['tvcmsimageslidersub_des_sub'];
			}else{
				$des_sub = "";
			}
			$this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmsimageslidersub`
						SET 
							tvcmsimageslidermain_id = '.$data["id"].',
							tvcmsimageslidersub_image 			= "'.$image.'",
							tvcmsimageslidersub_link 			= "'.$link.'",
							tvcmsimageslidersub_title 			= "'.$title.'",
							tvcmsimageslidersub_textaligment 	= "'.$aligment.'",
							tvcmsimageslidersub_buttoncaption 	= "'.$btncaption.'",
							tvcmsimageslidersub_des_main 		= "'.$des_main.'",
							tvcmsimageslidersub_des_sub 		= "'.$des_sub.'",
							tvcmsimageslidersub_enable 			= '.$value['tvcmsimageslidersub_enable'].',
							tvcmsimageslidersublang_id 			= '.$value['lang'].'');
		}
	}

	public function gettottaldata(){
		$sql  = "SELECT COUNT(DISTINCT tvcmsimageslidermain_id) AS total FROM `" . DB_PREFIX . "tvcmsimageslidermain`";
		$query = $this->db->query($sql);
		return $query->row['total'];
	}

	public function editimageslider($tvcmsimageslidermain_id, $data) {

		$this->db->query("DELETE FROM " . DB_PREFIX . "tvcmsimageslidersub WHERE tvcmsimageslidermain_id = '" . (int)$tvcmsimageslidermain_id . "'");
		
		foreach ($data['tvcmsimageslider'] as $language_id => $value) {


			if(!empty($value['tvcmsimageslidersub_title'])){
				$title = $value['tvcmsimageslidersub_title'];
			}else{
				$title = "";
			}
			if(!empty($value['tvcmsimageslidersub_image'])){
				$image = $value['tvcmsimageslidersub_image'];
			}else{
				$image = "";
			}
			if(!empty($value['tvcmsimageslidersub_link'])){
				$link = $value['tvcmsimageslidersub_link'];
			}else{
				$link = "";
			}
			if(!empty($value['tvcmsimageslidersub_textaligment'])){
				$aligment = $value['tvcmsimageslidersub_textaligment'];
			}else{
				$aligment = "";
			}
			if(!empty($value['tvcmsimageslidersub_buttoncaption'])){
				$btncaption = $value['tvcmsimageslidersub_buttoncaption'];
			}else{
				$btncaption = "";
			}
			if(!empty($value['tvcmsimageslidersub_des_main'])){
				$des_main = $value['tvcmsimageslidersub_des_main'];
			}else{
				$des_main = "";
			}
			if(!empty($value['tvcmsimageslidersub_des_sub'])){
				$des_sub = $value['tvcmsimageslidersub_des_sub'];
			}else{
				$des_sub = "";
			}
			$this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmsimageslidersub`
						SET 
							tvcmsimageslidermain_id 			= '.$tvcmsimageslidermain_id.',
							tvcmsimageslidersub_image 			= "'.$image.'",
							tvcmsimageslidersub_link 			= "'.$link.'",
							tvcmsimageslidersub_title 			= "'.$title.'",
							tvcmsimageslidersub_textaligment 	= "'.$aligment.'",
							tvcmsimageslidersub_buttoncaption 	= "'.$btncaption.'",
							tvcmsimageslidersub_des_main 		= "'.$des_main.'",
							tvcmsimageslidersub_des_sub 		= "'.$des_sub.'",
							tvcmsimageslidersub_enable 			= '.$value['tvcmsimageslidersub_enable'].',
							tvcmsimageslidersublang_id 			= '.$value['lang'].'');
		}
	}
	
	public function deleteimageslider($tvcmsimageslidermain_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "tvcmsimageslidermain WHERE tvcmsimageslidermain_id = '" . (int)$tvcmsimageslidermain_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "tvcmsimageslidersub WHERE tvcmsimageslidermain_id = '" . (int)$tvcmsimageslidermain_id . "'");
	
		$this->cache->delete('tvcmsimageslidermain');
		$this->cache->delete('tvcmsimageslidersub');
	}

	public function getimageslidesigle($tvcmsimageslidermain_id) {
		
		$query = $this->db->query("SELECT  " . DB_PREFIX . "tvcmsimageslidersub.*, " . DB_PREFIX . "tvcmsimageslidermain.* FROM  " . DB_PREFIX . "tvcmsimageslidersub
			INNER JOIN " . DB_PREFIX . "tvcmsimageslidermain ON  
			" . DB_PREFIX . "tvcmsimageslidersub.tvcmsimageslidermain_id = " . DB_PREFIX . "tvcmsimageslidermain.tvcmsimageslidermain_id
			WHERE " . DB_PREFIX . "tvcmsimageslidersub.tvcmsimageslidermain_id = '" . (int)$tvcmsimageslidermain_id . "'");

		return  $query->rows;
	}

	public function getsliderimage($data = array()) {

		$sql = "SELECT * FROM " . DB_PREFIX . "tvcmsimageslidermain p LEFT JOIN " . DB_PREFIX . "tvcmsimageslidersub pd ON (p.tvcmsimageslidermain_id = pd.tvcmsimageslidermain_id) WHERE pd.tvcmsimageslidersublang_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.tvcmsimageslidersub_title LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$sql .= " AND pd.tvcmsimageslidersub_enable = '" . (int)$data['filter_status'] . "'";
		}

		$sql .= " GROUP BY p.tvcmsimageslidermain_id";

		$sort_data = array(
			'pd.tvcmsimageslidersub_title',
			'pd.tvcmsimageslidersub_link',
			'pd.tvcmsimageslidersub_des_main',
			'pd.tvcmsimageslidersub_des_sub',
			'pd.tvcmsimageslidersub_textaligment',
			'pd.tvcmsimageslidersub_buttoncaption',
			'pd.tvcmsimageslidersub_enable'			
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY p.tvcmsimageslidermain_pos";
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
		$sql  = "SELECT COUNT(DISTINCT tvcmsimageslidersub_id) AS total FROM `" . DB_PREFIX . "tvcmsimageslidersub`";

		$sql .= " WHERE tvcmsimageslidersublang_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND tvcmsimageslidersub_title LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$sql .= " AND tvcmsimageslidersub_enable = '" . (int)$data['filter_status'] . "'";
		}

		$query = $this->db->query($sql);
		return $query->row['total'];
	}
}
