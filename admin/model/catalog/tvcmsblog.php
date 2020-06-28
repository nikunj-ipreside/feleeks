<?php
class ModelCatalogtvcmsblog extends Model {
	
	public function updatePosition($position){
	    foreach ($position as $key => $value) {
	        $pos = $key + 1;
	        $this->db->query("UPDATE " . DB_PREFIX . "tvcmsblog_main SET tvcmsblog_main_pos = '" . (int)$pos . "' WHERE tvcmsblog_main_id = '" . (int)$value . "'");
	    }    
	}

	public function copyblogpost($tvcmsblog_main_id) {

		$query 		= $this->db->query("SELECT * FROM " . DB_PREFIX . "tvcmsblog_main WHERE tvcmsblog_main_id = '" . (int)$tvcmsblog_main_id . "'");
		$miandata 	= $query->row;
		$numcheck 	= $query->num_rows;

		if ($numcheck) {
			$dataa['tvcmsblog_main_posttype']       	= $miandata['tvcmsblog_main_posttype'];
			$dataa['tvcmsblog_main_featureimage']       = $miandata['tvcmsblog_main_featureimage'];
			$dataa['tvcmsblog_main_urlrewrite']         = $miandata['tvcmsblog_main_urlrewrite'];
			$dataa['tvcmsblog_main_deafultcategory']    = $miandata['tvcmsblog_main_deafultcategory'];
			$dataa['tvcmsblog_main_video']           	= $miandata['tvcmsblog_main_video'];
			$dataa['tvcmsblog_main_commentstatus']      = $miandata['tvcmsblog_main_commentstatus'];
			$dataa['tvcmsblog_main_adddate']      		= $miandata['tvcmsblog_main_adddate'];
			$dataa['tvcmsblog_main_status']           	= $miandata['tvcmsblog_main_status'];
			$dataa['tvcmsblogform'] 					= $this->getblogpostcopy($tvcmsblog_main_id);
			$dataa['gallery'] 							= $this->getgalleryImages($tvcmsblog_main_id);
			$this->insertdata($dataa);
		}
	}

	public function getblogpostcopy($tvcmsblog_main_id) {
		$image_slider_data = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tvcmsblog_sub WHERE tvcmsblog_main_id = '" . (int)$tvcmsblog_main_id . "'");
		foreach ($query->rows as $result) {
			$image_slider_data[$result['tvcmsblog_sublang_id']] = array(
				'tvcmsblog_sublang_id'       => $result['tvcmsblog_sublang_id'],
				'tvcmsblog_sub_title'        => $result['tvcmsblog_sub_title'],
				'tvcmsblog_sub_excerpt'      => $result['tvcmsblog_sub_excerpt'],
				'tvcmsblog_sub_content'      => $result['tvcmsblog_sub_content'],
				'tvcmsblog_sub_metatitle'    => $result['tvcmsblog_sub_metatitle'],
				'tvcmsblog_sub_metatag'      => $result['tvcmsblog_sub_metatag'],
				'tvcmsblog_sub_metades'    	 => $result['tvcmsblog_sub_metades'],
				'tvcmsblog_sub_metakeyword'  => $result['tvcmsblog_sub_metakeyword']
			);
		}
		return $image_slider_data;
	}

	public function insertdata($data) {
		$query = "SELECT MAX(tvcmsblog_main_id) as id FROM `" . DB_PREFIX . "tvcmsblog_main`";
		$query = $this->db->query($query);
		$data['id'] = $query->row['id'] + 1;

		$this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmsblog_main`
			SET 
						tvcmsblog_main_id 				= '.$data["id"].',
						tvcmsblog_main_pos 				= '.$data["id"].',
						tvcmsblog_main_status 			= '.$data["tvcmsblog_main_status"].',
						tvcmsblog_main_posttype 		= "'.$data["tvcmsblog_main_posttype"].'",
						tvcmsblog_main_featureimage 	= "'.$data["tvcmsblog_main_featureimage"].'",
						tvcmsblog_main_deafultcategory 	= '.$data["tvcmsblog_main_deafultcategory"].',
						tvcmsblog_main_urlrewrite 		= "'.$data["tvcmsblog_main_urlrewrite"].'",
						tvcmsblog_main_video 			= "'.$data["tvcmsblog_main_video"].'",
						tvcmsblog_main_adddate 			= NOW(),
						tvcmsblog_main_commentstatus 	= '.$data["tvcmsblog_main_commentstatus"].'');

		foreach ($data['tvcmsblogform'] as $language_id => $value) {
			$this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmsblog_sub`
						SET 
							tvcmsblog_main_id 			= '.$data["id"].',
							tvcmsblog_sub_title 		= "'.$value['tvcmsblog_sub_title'].'",
							tvcmsblog_sub_excerpt 		= "'.$value['tvcmsblog_sub_excerpt'].'",
							tvcmsblog_sub_content 		= "'.$value['tvcmsblog_sub_content'].'",
							tvcmsblog_sub_metatitle 	= "'.$value['tvcmsblog_sub_metatitle'].'",
							tvcmsblog_sub_metatag 		= "'.$value['tvcmsblog_sub_metatag'].'",
							tvcmsblog_sub_metades 		= "'.$value['tvcmsblog_sub_metades'].'",
							tvcmsblog_sub_metakeyword 	= "'.$value['tvcmsblog_sub_metakeyword'].'",
							tvcmsblog_sublang_id 		= '.$value['tvcmsblog_sublang_id'].'');
		}
		foreach ($data['gallery'] as $value) {
			$this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmsblog_gallery`
				SET 
					tvcmsblog_id 			= '.$data["id"].',
					image = "'.$value['image'].'"');
		}
	}

	public function gettottaldata() {
		$sql  = "SELECT COUNT(DISTINCT tvcmsblog_main_id) AS total FROM `" . DB_PREFIX . "tvcmsblog_main`";
		$query = $this->db->query($sql);
		return $query->row['total'];
	}

	public function editblogpost($tvcmsblog_main_id, $data) {
	    
		$this->db->query('UPDATE `' . DB_PREFIX . 'tvcmsblog_main`
			SET 
						tvcmsblog_main_pos 				= '.$tvcmsblog_main_id.',
						tvcmsblog_main_status 			= '.$data["tvcmsblog_main_status"].',
						tvcmsblog_main_posttype 		= "'.$data["tvcmsblog_main_posttype"].'",
						tvcmsblog_main_featureimage 	= "'.$data["tvcmsblog_main_featureimage"].'",
						tvcmsblog_main_deafultcategory 	= '.$data["tvcmsblog_main_deafultcategory"].',
						tvcmsblog_main_urlrewrite 		= "'.$data["tvcmsblog_main_urlrewrite"].'",
						tvcmsblog_main_video 			= "'.$data["tvcmsblog_main_video"].'",
						tvcmsblog_main_commentstatus 	= '.$data["tvcmsblog_main_commentstatus"].'
			WHERE
						tvcmsblog_main_id 				= '.$tvcmsblog_main_id.'');
		$this->db->query("DELETE FROM " . DB_PREFIX . "tvcmsblog_sub WHERE tvcmsblog_main_id = '" . (int)$tvcmsblog_main_id . "'");
		foreach ($data['tvcmsblogform'] as $language_id => $value) {
			$this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmsblog_sub`
						SET 
							tvcmsblog_main_id 		= '.$tvcmsblog_main_id.',
							tvcmsblog_sub_title 		= "'.$value['tvcmsblog_sub_title'].'",
							tvcmsblog_sub_excerpt 		= "'.$value['tvcmsblog_sub_excerpt'].'",
							tvcmsblog_sub_content 		= "'.$value['tvcmsblog_sub_content'].'",
							tvcmsblog_sub_metatitle 	= "'.$value['tvcmsblog_sub_metatitle'].'",
							tvcmsblog_sub_metatag 		= "'.$value['tvcmsblog_sub_metatag'].'",
							tvcmsblog_sub_metades 		= "'.$value['tvcmsblog_sub_metades'].'",
							tvcmsblog_sub_metakeyword 	= "'.$value['tvcmsblog_sub_metakeyword'].'",
							tvcmsblog_sublang_id 		= '.$value['tvcmsblog_sublang_id'].'');
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "tvcmsblog_gallery WHERE tvcmsblog_id = '" . (int)$tvcmsblog_main_id . "'");
		foreach ($data['gallery'] as $value) {
			$this->db->query('INSERT INTO `' . DB_PREFIX . 'tvcmsblog_gallery`
				SET 
					tvcmsblog_id 	= '.$tvcmsblog_main_id.',
					image  			= "'.$value['image'].'"');
		}	
	}
	
	public function deleteblogpost($tvcmsblog_main_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "tvcmsblog_main WHERE tvcmsblog_main_id = '" . (int)$tvcmsblog_main_id . "' ");
		$this->db->query("DELETE FROM " . DB_PREFIX . "tvcmsblog_sub  WHERE tvcmsblog_main_id  = '" . (int)$tvcmsblog_main_id . "' ");
	

		$this->cache->delete('tvcmsblog_main');
		$this->cache->delete('tvcmsblog_sub');
	}

	public function getblogpostsigle($tvcmsblog_main_id) {
		
		$query = $this->db->query("SELECT  " . DB_PREFIX . "tvcmsblog_sub.*, " . DB_PREFIX . "tvcmsblog_main.* FROM  " . DB_PREFIX . "tvcmsblog_sub
			INNER JOIN " . DB_PREFIX . "tvcmsblog_main ON  
			" . DB_PREFIX . "tvcmsblog_sub.tvcmsblog_main_id = " . DB_PREFIX . "tvcmsblog_main.tvcmsblog_main_id
			WHERE " . DB_PREFIX . "tvcmsblog_sub.tvcmsblog_main_id = '" . (int)$tvcmsblog_main_id . "'");

		return  $query->rows;
	}

	public function getblogpost($data = array()) {

		$sql = "SELECT * FROM " . DB_PREFIX . "tvcmsblog_main p LEFT JOIN " . DB_PREFIX . "tvcmsblog_sub pd ON (p.tvcmsblog_main_id = pd.tvcmsblog_main_id) WHERE pd.tvcmsblog_sublang_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.tvcmsblog_sub_title LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$sql .= " AND p.tvcmsblog_main_status = '" . (int)$data['filter_status'] . "'";
		}

		$sql .= " GROUP BY p.tvcmsblog_main_id";

		$sort_data = array(
			'pd.tvcmsblog_sub_title',
			'pd.tvcmsblog_sub_excerpt',
			'p.tvcmsblog_main_urlrewrite',
			'pd.tvcmsblog_des_sub'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY p.tvcmsblog_main_pos";
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

		$sql = "SELECT * FROM " . DB_PREFIX . "tvcmsblog_main p LEFT JOIN " . DB_PREFIX . "tvcmsblog_sub pd ON (p.tvcmsblog_main_id = pd.tvcmsblog_main_id) WHERE pd.tvcmsblog_sublang_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.tvcmsblog_sub_title LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$sql .= " AND p.tvcmsblog_main_status = '" . (int)$data['filter_status'] . "'";
		}
		$query = $this->db->query($sql);
		return $query->num_rows;
	}

	public function getgalleryImages($tvcmsblog_main_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tvcmsblog_gallery WHERE tvcmsblog_id = '" . (int)$tvcmsblog_main_id . "'");

		return $query->rows;
	}
	public function getblogpostcategory($data = array()) {

		$sql = "SELECT * FROM " . DB_PREFIX . "tvcmsblogcategory_main p LEFT JOIN " . DB_PREFIX . "tvcmsblogcategory_sub pd ON (p.tvcmsblogcategory_id = pd.tvcmsblogcategory_id) WHERE pd.tvcmsblogcategory_sublang_id = '" . (int)$this->config->get('config_language_id') . "'";


		$sql .= " GROUP BY p.tvcmsblogcategory_id";



		$query = $this->db->query($sql);
		return $query->rows;
	}

}
