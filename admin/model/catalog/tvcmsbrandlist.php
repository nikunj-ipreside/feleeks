<?php
class ModelCatalogTvcmsbrandlist extends Model {
	
	public function updatePosition($position){
	    foreach ($position as $key => $value) {
	        $pos = $key + 1;
	        $this->db->query("UPDATE " . DB_PREFIX . "tvcmsbrandlist SET tvcmsbrandlist_pos = '" . (int)$pos . "' WHERE tvcmsbrandlist_id = '" . (int)$value . "'");
	    }    
	}
	public function addbrandlink($data) {
		if (isset($data)) {
			$this->db->query("TRUNCATE TABLE " . DB_PREFIX . "tvcmsbrandlist");
			if(!empty($data)){
				foreach ($data as $datas) {
					$query = "SELECT MAX(tvcmsbrandlist_id) as id FROM `" . DB_PREFIX . "tvcmsbrandlist`";
					$query = $this->db->query($query);
					$id    = $query->row['id'] + 1;
					
					$this->db->query("INSERT INTO " . DB_PREFIX . "tvcmsbrandlist SET tvcmsbrandlist_link = '" .  $this->db->escape($datas['tvcmsbrandlist_link']) . "',tvcmsbrandlist_img = '" .  $this->db->escape($datas['tvcmsbrandlist_img']) . "',tvcmsbrandlist_pos = '" . (int)$id . "',tvcmsbrandlist_lang = '" . json_encode($datas['language']) . "', tvcmsbrandlist_status = '" . (int)$datas['tvcmsbrandlist_status'] . "'");
				}
			}
		}
	}
	public function checkdata() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tvcmsbrandlist ORDER BY tvcmsbrandlist_pos");
		return $query;
	}
	public function getmodulename() {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "module` WHERE `code` like 'tv%' ORDER BY name");
		return $query->rows;
	}
}
