<?php
class ModelCatalogtvcmsblogcategory extends Model {
	
	public function updatePosition($position){
	    foreach ($position as $key => $value) {
	        $pos = $key + 1;
	        $this->db->query("UPDATE " . DB_PREFIX . "tvcmsblogcategory_main SET tvcmsblogcategory_pos = '" . (int)$pos . "' WHERE tvcmsblogcategory_id = '" . (int)$value . "'");
	    }    
	}

	public function copyblogpost($tvcmsblogcategory_id) {

		$query 		= $this->db->query("SELECT * FROM " . DB_PREFIX . "tvcmsblogcategory_main WHERE tvcmsblogcategory_id = '" . (int)$tvcmsblogcategory_id . "'");
		$miandata 	= $query->row;
		$numcheck 	= $query->num_rows;

		if ($numcheck) {
			$dataa['tvcmsblogcategory_featureimage']       = $miandata['tvcmsblogcategory_featureimage'];
			$dataa['tvcmsblogcategory_urlrewrite']         = $miandata['tvcmsblogcategory_urlrewrite'];
			$dataa['tvcmsblogcategory_deafultcategory']    = $miandata['tvcmsblogcategory_deafultcategory'];
			$dataa['tvcmsblogcategory_status']           	= $miandata['tvcmsblogcategory_status'];
			$dataa['tvcmsblogcategoryform'] 					= $this->getblogpostcopy($tvcmsblogcategory_id);
			$this->insertdata($dataa);
		}
	}

	public function getblogpostcopy($tvcmsblogcategory_id) {
		$image_slider_data = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tvcmsblogcategory_sub WHERE tvcmsblogcategory_id = '" . (int)$tvcmsblogcategory_id . "'");
		foreach ($query->rows as $result) {
			$image_slider_data[$result['tvcmsblogcategory_sublang_id']] = array(
				'tvcmsblogcategory_sublang_id'       => $result['tvcmsblogcategory_sublang_id'],
				'tvcmsblogcategory_sub_title'        => $result['tvcmsblogcategory_sub_title'],
				'tvcmsblogcategory_sub_categorydes'      => $result['tvcmsblogcategory_sub_categorydes'],
				'tvcmsblogcategory_sub_metatitle'    => $result['tvcmsblogcategory_sub_metatitle'],
				'tvcmsblogcategory_sub_metades'    	 => $result['tvcmsblogcategory_sub_metades'],
				'tvcmsblogcategory_sub_metakeyword'  => $result['tvcmsblogcategory_sub_metakeyword']
			);
		}
		return $image_slider_data;
	}

	public function insertdata($data) {
		$query = "SELECT MAX(tvcmsblogcategory_id) as id FROM `" . DB_PREFIX . "tvcmsblogcategory_main`";
		$query = $this->db->query($query);
		$data['id'] = $query->row['id'] + 1;

		$this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmsblogcategory_main`
			SET 
						tvcmsblogcategory_id 				= '.$data["id"].',
						tvcmsblogcategory_pos 				= '.$data["id"].',
						tvcmsblogcategory_status 			= '.$data["tvcmsblogcategory_status"].',
						tvcmsblogcategory_featureimage 	= "'.$data["tvcmsblogcategory_featureimage"].'",
						tvcmsblogcategory_deafultcategory 	= '.$data["tvcmsblogcategory_deafultcategory"].',
						tvcmsblogcategory_urlrewrite 		= "'.$data["tvcmsblogcategory_urlrewrite"].'"');

		foreach ($data['tvcmsblogcategoryform'] as $language_id => $value) {
			$this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmsblogcategory_sub`
						SET 
							tvcmsblogcategory_id 			= '.$data["id"].',
							tvcmsblogcategory_sub_title 		= "'.$value['tvcmsblogcategory_sub_title'].'",
							tvcmsblogcategory_sub_categorydes 		= "'.$value['tvcmsblogcategory_sub_categorydes'].'",
							tvcmsblogcategory_sub_metatitle 	= "'.$value['tvcmsblogcategory_sub_metatitle'].'",
							tvcmsblogcategory_sub_metades 		= "'.$value['tvcmsblogcategory_sub_metades'].'",
							tvcmsblogcategory_sub_metakeyword 	= "'.$value['tvcmsblogcategory_sub_metakeyword'].'",
							tvcmsblogcategory_sublang_id 		= '.$value['tvcmsblogcategory_sublang_id'].'');
		}
		
	}

	public function gettottaldata() {
		$sql  = "SELECT COUNT(DISTINCT tvcmsblogcategory_id) AS total FROM `" . DB_PREFIX . "tvcmsblogcategory_main`";
		$query = $this->db->query($sql);
		return $query->row['total'];
	}

	public function editblogpost($tvcmsblogcategory_id, $data) {
	    
		$this->db->query('UPDATE `' . DB_PREFIX . 'tvcmsblogcategory_main`
			SET 
						tvcmsblogcategory_pos 				= '.$tvcmsblogcategory_id.',
						tvcmsblogcategory_status 			= '.$data["tvcmsblogcategory_status"].',
						tvcmsblogcategory_featureimage 		= "'.$data["tvcmsblogcategory_featureimage"].'",
						tvcmsblogcategory_deafultcategory 	= '.$data["tvcmsblogcategory_deafultcategory"].',
						tvcmsblogcategory_urlrewrite 		= "'.$data["tvcmsblogcategory_urlrewrite"].'"
			WHERE
						tvcmsblogcategory_id 				= '.$tvcmsblogcategory_id.'');
		$this->db->query("DELETE FROM " . DB_PREFIX . "tvcmsblogcategory_sub WHERE tvcmsblogcategory_id = '" . (int)$tvcmsblogcategory_id . "'");
		foreach ($data['tvcmsblogcategoryform'] as $language_id => $value) {
			$this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmsblogcategory_sub`
						SET 
							tvcmsblogcategory_id 				= '.$tvcmsblogcategory_id.',
							tvcmsblogcategory_sub_title 	= "'.$value['tvcmsblogcategory_sub_title'].'",
							tvcmsblogcategory_sub_categorydes 	= "'.$value['tvcmsblogcategory_sub_categorydes'].'",
							tvcmsblogcategory_sub_metatitle 	= "'.$value['tvcmsblogcategory_sub_metatitle'].'",
							tvcmsblogcategory_sub_metades 		= "'.$value['tvcmsblogcategory_sub_metades'].'",
							tvcmsblogcategory_sub_metakeyword 	= "'.$value['tvcmsblogcategory_sub_metakeyword'].'",
							tvcmsblogcategory_sublang_id 		= '.$value['tvcmsblogcategory_sublang_id'].'');
		}
		
	}
	
	public function deleteblogpost($tvcmsblogcategory_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "tvcmsblogcategory_main WHERE tvcmsblogcategory_id = '" . (int)$tvcmsblogcategory_id . "' ");
		$this->db->query("DELETE FROM " . DB_PREFIX . "tvcmsblogcategory_sub  WHERE tvcmsblogcategory_id  = '" . (int)$tvcmsblogcategory_id . "' ");
	

		$this->cache->delete('tvcmsblogcategory_main');
		$this->cache->delete('tvcmsblogcategory_sub');
	}

	public function getblogpostsigle($tvcmsblogcategory_id) {
		
		$query = $this->db->query("SELECT  " . DB_PREFIX . "tvcmsblogcategory_sub.*, " . DB_PREFIX . "tvcmsblogcategory_main.* FROM  " . DB_PREFIX . "tvcmsblogcategory_sub
			INNER JOIN " . DB_PREFIX . "tvcmsblogcategory_main ON  
			" . DB_PREFIX . "tvcmsblogcategory_sub.tvcmsblogcategory_id = " . DB_PREFIX . "tvcmsblogcategory_main.tvcmsblogcategory_id
			WHERE " . DB_PREFIX . "tvcmsblogcategory_sub.tvcmsblogcategory_id = '" . (int)$tvcmsblogcategory_id . "'");

		return  $query->rows;
	}

	public function getblogpost($data = array()) {

		$sql = "SELECT * FROM " . DB_PREFIX . "tvcmsblogcategory_main p LEFT JOIN " . DB_PREFIX . "tvcmsblogcategory_sub pd ON (p.tvcmsblogcategory_id = pd.tvcmsblogcategory_id) WHERE pd.tvcmsblogcategory_sublang_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.tvcmsblogcategory_sub_title LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$sql .= " AND p.tvcmsblogcategory_status = '" . (int)$data['filter_status'] . "'";
		}

		$sql .= " GROUP BY p.tvcmsblogcategory_id";

		$sort_data = array(
			'pd.tvcmsblogcategory_sub_title',
			'pd.tvcmsblogcategory_sub_categorydes',
			'p.tvcmsblogcategory_urlrewrite',
			'pd.tvcmsblogcategory_des_sub'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY p.tvcmsblogcategory_pos";
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

	public function getTotalblogpost($data = array()) {

		$sql = "SELECT * FROM " . DB_PREFIX . "tvcmsblogcategory_main p LEFT JOIN " . DB_PREFIX . "tvcmsblogcategory_sub pd ON (p.tvcmsblogcategory_id = pd.tvcmsblogcategory_id) WHERE pd.tvcmsblogcategory_sublang_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.tvcmsblogcategory_sub_title LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$sql .= " AND p.tvcmsblogcategory_status = '" . (int)$data['filter_status'] . "'";
		}
		$query = $this->db->query($sql);
		return $query->num_rows;
	}

	

}
