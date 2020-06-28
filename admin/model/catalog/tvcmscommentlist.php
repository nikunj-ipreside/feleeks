<?php
class ModelCatalogtvcmscommentlist extends Model {
	
	public function getlist($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "tvcmsblog_comment";

		$sort_data = array(
			'tvcmsblog_comment_email'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY tvcmsblog_comment_id";
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

	public function getTotallist($data = array()) {

		$sql = "SELECT * FROM " . DB_PREFIX . "tvcmsblog_comment";

		$query = $this->db->query($sql);
		return $query->num_rows;
	}
	public function editcomment($tvcmsblog_comment_id, $data) {

		$data = $this->db->query("SELECT tvcmsblog_comment_status FROM " . DB_PREFIX . "tvcmsblog_comment WHERE tvcmsblog_comment_id = '" . (int)$tvcmsblog_comment_id . "'");
		$old = $data->row['tvcmsblog_comment_status'];
		if($old == 1){
			$new = 0;
		}else{
			$new = 1;
		}
		$this->db->query("UPDATE " . DB_PREFIX . "tvcmsblog_comment SET tvcmsblog_comment_status = '" . (int)$new . "' WHERE tvcmsblog_comment_id = '" . (int)$tvcmsblog_comment_id . "'");
	}

}
