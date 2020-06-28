<?php
class ModelCatalogTvcmstags extends Model {

	public function updatePosition($position){
	    foreach ($position as $key => $value) {
	        $pos = $key + 1;
	        $this->db->query("UPDATE " . DB_PREFIX . "tvcmstags SET tvcmstags_pos = '" . (int)$pos . "' WHERE tvcmstags_id = '" . (int)$value . "'");
	    }
	}
	public function addcustomlink($data) {
		if (isset($data)) {
			$this->db->query("TRUNCATE TABLE " . DB_PREFIX . "tvcmstags");
			if(!empty($data)){
				foreach ($data as $datas) {
					$query = "SELECT MAX(tvcmstags_id) as id FROM `" . DB_PREFIX . "tvcmstags`";
					$query = $this->db->query($query);
					$data['id'] = $query->row['id'] + 1;
					$this->db->query("INSERT INTO " . DB_PREFIX . "tvcmstags SET tvcmstags_title = '" . json_encode($datas['language']) . "', tvcmstags_link = '" .  $this->db->escape($datas['link']) . "', tvcmstags_pos = '" . (int)$data['id'] . "', tvcmstags_status = '" . (int)$datas['status'] . "'");
				}
			}
		}
	}
	public function checkdata() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tvcmstags ORDER BY tvcmstags_pos");
		return $query;
	}	
	
}
