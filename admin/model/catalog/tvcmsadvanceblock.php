<?php
class ModelCatalogtvcmsadvanceblock extends Model {
	
	public function updatePosition($position){
	    foreach ($position as $key => $value) {
	        $pos = $key + 1;
	        $this->db->query("UPDATE " . DB_PREFIX . "tvcmsadvanceblockmain SET tvcmsadvanceblockmain_pos = '" . (int)$pos . "' WHERE tvcmsadvanceblockmain_id = '" . (int)$value . "'");
	    }    
	}

	public function copyadvanceblock($tvcmsadvanceblockmain_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "tvcmsadvanceblockmain p WHERE p.tvcmsadvanceblockmain_id = '" . (int)$tvcmsadvanceblockmain_id . "'");
		if ($query->num_rows) {
			$data 							= $query->row;
			$dataa['tvcmsadvanceblockform'] 	= $this->getadvanceblockcopy($tvcmsadvanceblockmain_id);

			$this->insertdata($dataa);
		}
	}

	public function getadvanceblockcopy($tvcmsadvanceblockmain_id) {
		$image_slider_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tvcmsadvanceblocksub WHERE tvcmsadvanceblockmain_id = '" . (int)$tvcmsadvanceblockmain_id . "'");
		foreach ($query->rows as $result) {
			$image_slider_data[$result['tvcmsadvanceblocksublang_id']] = array(

				'tvcmsadvanceblocksub_link'             => $result['tvcmsadvanceblocksub_link'],
				'tvcmsadvanceblocksub_image'            => $result['tvcmsadvanceblocksub_image'],
				'tvcmsadvanceblocksub_title'      		=> $result['tvcmsadvanceblocksub_title'],
				'tvcmsadvanceblocksub_des'      		=> $result['tvcmsadvanceblocksub_des'],
				'tvcmsadvanceblocksub_sub_des'     		=> $result['tvcmsadvanceblocksub_sub_des'],
				'tvcmsadvanceblocksub_status'     		=> $result['tvcmsadvanceblocksub_status'],
				'tvcmsadvanceblocksublang_id'           => $result['tvcmsadvanceblocksublang_id']
			);
		}

		return $image_slider_data;
	}

	public function insertdata($data) {
		$query = "SELECT MAX(tvcmsadvanceblockmain_id) as id FROM `" . DB_PREFIX . "tvcmsadvanceblockmain`";
		$query = $this->db->query($query);
		$data['id'] = $query->row['id'] + 1;
		
		$this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmsadvanceblockmain`
			SET 
						tvcmsadvanceblockmain_id = '.$data["id"].',
						tvcmsadvanceblockmain_pos = '.$data['id'].';');

		foreach ($data['tvcmsadvanceblockform'] as $language_id => $value) {
			$this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmsadvanceblocksub`
						SET 
							tvcmsadvanceblockmain_id 		= '.$data["id"].',
							tvcmsadvanceblocksub_link 		= "'.$value['tvcmsadvanceblocksub_link'].'",
							tvcmsadvanceblocksub_image 		= "'.$value['tvcmsadvanceblocksub_image'].'",
							tvcmsadvanceblocksub_title 		= "'.$value['tvcmsadvanceblocksub_title'].'",
							tvcmsadvanceblocksub_des 	    = "'.$value['tvcmsadvanceblocksub_des'].'",
							tvcmsadvanceblocksub_sub_des 	= "'.$value['tvcmsadvanceblocksub_sub_des'].'",
							tvcmsadvanceblocksub_status 	= '.$value['tvcmsadvanceblocksub_status'].',
							tvcmsadvanceblocksublang_id 	= '.$value['tvcmsadvanceblocksublang_id'].'');
		}
	}

	public function gettottaldata() {
		$sql  = "SELECT COUNT(DISTINCT tvcmsadvanceblockmain_id) AS total FROM `" . DB_PREFIX . "tvcmsadvanceblockmain`";
		$query = $this->db->query($sql);
		return $query->row['total'];
	}

	public function editadvanceblock($tvcmsadvanceblockmain_id, $data) {
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "tvcmsadvanceblocksub WHERE tvcmsadvanceblockmain_id = '" . (int)$tvcmsadvanceblockmain_id . "'");
		
		foreach ($data['tvcmsadvanceblockform'] as $language_id => $value) {
			$this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmsadvanceblocksub`
						SET 
							tvcmsadvanceblockmain_id 		= '.$tvcmsadvanceblockmain_id.',
							tvcmsadvanceblocksub_link 		= "'.$value['tvcmsadvanceblocksub_link'].'",
							tvcmsadvanceblocksub_image 		= "'.$value['tvcmsadvanceblocksub_image'].'",
							tvcmsadvanceblocksub_title 		= "'.$value['tvcmsadvanceblocksub_title'].'",
							tvcmsadvanceblocksub_des 		= "'.$value['tvcmsadvanceblocksub_des'].'",
							tvcmsadvanceblocksub_sub_des 	= "'.$value['tvcmsadvanceblocksub_sub_des'].'",
							tvcmsadvanceblocksub_status 	= '.$value['tvcmsadvanceblocksub_status'].',
							tvcmsadvanceblocksublang_id 	= '.$value['tvcmsadvanceblocksublang_id'].'');
		}
	}
	
	public function deleteadvanceblock($tvcmsadvanceblockmain_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "tvcmsadvanceblockmain WHERE tvcmsadvanceblockmain_id = '" . (int)$tvcmsadvanceblockmain_id . "' ");
		$this->db->query("DELETE FROM " . DB_PREFIX . "tvcmsadvanceblocksub  WHERE tvcmsadvanceblockmain_id  = '" . (int)$tvcmsadvanceblockmain_id . "' ");
	

		$this->cache->delete('tvcmsadvanceblockmain');
		$this->cache->delete('tvcmsadvanceblocksub');
	}

	public function getadvanceblocksigle($tvcmsadvanceblockmain_id) {
		
		$query = $this->db->query("SELECT  " . DB_PREFIX . "tvcmsadvanceblocksub.*, " . DB_PREFIX . "tvcmsadvanceblockmain.* FROM  " . DB_PREFIX . "tvcmsadvanceblocksub
			INNER JOIN " . DB_PREFIX . "tvcmsadvanceblockmain ON  
			" . DB_PREFIX . "tvcmsadvanceblocksub.tvcmsadvanceblockmain_id = " . DB_PREFIX . "tvcmsadvanceblockmain.tvcmsadvanceblockmain_id
			WHERE " . DB_PREFIX . "tvcmsadvanceblocksub.tvcmsadvanceblockmain_id = '" . (int)$tvcmsadvanceblockmain_id . "'");

		return  $query->rows;
	}

	public function getsliderimage($data = array()) {

		$sql = "SELECT * FROM " . DB_PREFIX . "tvcmsadvanceblockmain p LEFT JOIN " . DB_PREFIX . "tvcmsadvanceblocksub pd ON (p.tvcmsadvanceblockmain_id = pd.tvcmsadvanceblockmain_id) WHERE pd.tvcmsadvanceblocksublang_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.tvcmsadvanceblocksub_title LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$sql .= " AND pd.tvcmsadvanceblocksub_status = '" . (int)$data['filter_status'] . "'";
		}

		$sql .= " GROUP BY p.tvcmsadvanceblockmain_id";

		$sort_data = array(
			'pd.tvcmsadvanceblocksub_title',
			'pd.tvcmsadvanceblocksub_link',
			'pd.tvcmsadvanceblocksub_des_main',
			'pd.tvcmsadvanceblocksub_des_sub',
			'pd.tvcmsadvanceblocksub_status'			
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY p.tvcmsadvanceblockmain_pos";
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
		$sql  = "SELECT COUNT(DISTINCT tvcmsadvanceblocksub_id) AS total FROM `" . DB_PREFIX . "tvcmsadvanceblocksub`";

		$sql .= " WHERE tvcmsadvanceblocksublang_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND tvcmsadvanceblocksub_title LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$sql .= " AND tvcmsadvanceblocksub_status = '" . (int)$data['filter_status'] . "'";
		}

		$query = $this->db->query($sql);
		return $query->row['total'];
	}
}
