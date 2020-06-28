<?php
class ModelExtensionModuletvcmsverticalmenu extends Model
{
    public function getMenuById($tvcms_menuid) {
        $sql = "SELECT * FROM `" . DB_PREFIX . "tvcmsmenu` WHERE tvcms_menuid = '" . (int)$tvcms_menuid . "'";

        $query = $this->db->query($sql);

        return $query->row;
    }

    public function getTopItems($tvcms_menuid) {
        $sql = "SELECT DISTINCT * FROM `" . DB_PREFIX . "tvcms_menutop_item` m WHERE m.tvcms_menuid = '". (int) $tvcms_menuid ."' ORDER BY m.position ASC";

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getTopItemDescriptionById($tvcms_menuitem_id) {
        $tvcms_menudescription_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tvcms_menutop_item_description WHERE tvcms_menuitem_id = '" . (int)$tvcms_menuitem_id . "'");

        foreach ($query->rows as $result) {
            $tvcms_menudescription_data[$result['language_id']] = $result['title'];
        }

        return $tvcms_menudescription_data;
    }

    public function getSubItems($parent_item_id, $level) {
        $sql = "SELECT DISTINCT * FROM `" . DB_PREFIX . "tvcms_menusub_item` m WHERE m.parent_tvcms_menuitem_id = '". (int) $parent_item_id ."' AND m.level = '" . (int) $level . "' ORDER BY m.position ASC";

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getSubItemDescriptionById($sub_item_id) {
        $tvcms_menudescription_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tvcms_menusub_item_description WHERE sub_tvcms_menuitem_id = '" . (int) $sub_item_id . "'");

        foreach ($query->rows as $result) {
            $tvcms_menudescription_data[$result['language_id']] = $result['title'];
        }

        return $tvcms_menudescription_data;
    }

    public function getLanguageByCode($language_code) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "language WHERE code = '" . $this->db->escape($language_code) . "'");

        return $query->row;
    }
}