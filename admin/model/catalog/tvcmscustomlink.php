<?php
class ModelCatalogTvcmscustomlink extends Model {

	public function updatePosition($position){
	    foreach ($position as $key => $value) {
	        $pos = $key + 1;
	        $this->db->query("UPDATE " . DB_PREFIX . "tvcustomlink SET tvcustomlink_pos = '" . (int)$pos . "' WHERE tvcustomlink_id = '" . (int)$value . "'");
	    }
	}

	public function addcustomlink($data) {
		if (isset($data)) {
			$this->db->query("TRUNCATE TABLE " . DB_PREFIX . "tvcustomlink");
			if(!empty($data)){
				$i = 1;
				foreach ($data as $datas) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "tvcustomlink SET tvcustomlink_title = '" . json_encode($datas['language']) . "', tvcustomlink_link = '" .  $this->db->escape($datas['link']) . "', tvcustomlink_pos = '" . (int)$i . "', tvcustomlink_status = '" . (int)$datas['status'] . "'");
				$i++;
				}
			}
		}
	}

	public function checkdata() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tvcustomlink ORDER BY tvcustomlink_pos");
		return $query;
	}	
}
