<?php
class ModelExtensionModuletvcmsverticalmenu extends Model
{
    public function createMenuTable() {
        $this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "tvcmsmenu` (
			    `tvcms_menuid` INT(11) NOT NULL AUTO_INCREMENT,
	            `status` TINYINT(1) NOT NULL DEFAULT '0',
	            `name` VARCHAR(255) NOT NULL,
	            `tvcms_menutype` VARCHAR(255) NOT NULL,
	        PRIMARY KEY (`tvcms_menuid`)
		) DEFAULT COLLATE=utf8_general_ci;");

        $this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "tvcms_menutop_item` (
			    `tvcms_menuitem_id` INT(11) NOT NULL AUTO_INCREMENT,
			    `tvcms_menuid` INT(11) NOT NULL,
	            `status` TINYINT(1) NOT NULL DEFAULT '0',
	            `tvcms_has_title` TINYINT(1) NOT NULL DEFAULT '0',
	            `tvcms_has_link` TINYINT(1) NOT NULL DEFAULT '0',
	            `tvcms_has_child` TINYINT(1) NOT NULL DEFAULT '0',
                `category_id` INT(11),
                `position` INT(11) NOT NULL DEFAULT '0',
	            `name` VARCHAR(255) NOT NULL,
	            `link` VARCHAR(255),
	            `icon` VARCHAR(255),
	            `item_align` VARCHAR(255) NOT NULL,
	            `sub_tvcms_menutype` VARCHAR(255) NOT NULL,
	            `sub_tvcms_menucontent_type` VARCHAR(255) NOT NULL,
	            `sub_tvcms_menucontent_columns` INT(11),
	            `sub_tvcms_menucontent` text,
	        PRIMARY KEY (`tvcms_menuitem_id`)
		) DEFAULT COLLATE=utf8_general_ci;");

        $this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "tvcms_menutop_item_description` (
			    `tvcms_menuitem_id` INT(11) NOT NULL,
			    `language_id` int(11) NOT NULL,
	            `title` VARCHAR(255) NOT NULL,
	            PRIMARY KEY (`tvcms_menuitem_id`,`language_id`)
		) DEFAULT COLLATE=utf8_general_ci;");

        $this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "tvcms_menusub_item` (
			    `sub_tvcms_menuitem_id` INT(11) NOT NULL AUTO_INCREMENT,
			    `parent_tvcms_menuitem_id` INT(11) NOT NULL,
			    `level` INT(11) NOT NULL,
	            `status` TINYINT(1) NOT NULL DEFAULT '0',
	            `name` VARCHAR(255) NOT NULL,
	            `position` INT(11) NOT NULL,
	            `link` VARCHAR(255),
	        PRIMARY KEY (`sub_tvcms_menuitem_id`)
		) DEFAULT COLLATE=utf8_general_ci;");

        $this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "tvcms_menusub_item_description` (
			    `sub_tvcms_menuitem_id` INT(11) NOT NULL,
			    `language_id` int(11) NOT NULL,
	            `title` VARCHAR(255) NOT NULL,
	            PRIMARY KEY (`sub_tvcms_menuitem_id`,`language_id`)
		) DEFAULT COLLATE=utf8_general_ci;");
    }

    public function addMenu($data) {
        $sql = "INSERT INTO " . DB_PREFIX . "tvcmsmenu SET status = '" . (int)$data['status'] . "', name = '" . $this->db->escape($data['name']) . "', tvcms_menutype = '" . $this->db->escape($data['tvcms_menutype']) . "'";

        $this->db->query($sql);

        $tvcms_menuid = $this->db->getLastId();

        $top_items = $this->getTopItems(0);

        foreach($top_items as $top_item) {
            $sql_update = "UPDATE " . DB_PREFIX . "tvcms_menutop_item SET tvcms_menuid = '" . (int) $tvcms_menuid . "' WHERE tvcms_menuitem_id = '" . (int) $top_item['tvcms_menuitem_id'] . "'";

            $this->db->query($sql_update);
        }
    }

    public function editMenu($tvcms_menuid, $data) {
        $sql_update = "UPDATE " . DB_PREFIX . "tvcmsmenu SET status = '" . (int)$data['status'] . "', name = '". $this->db->escape($data['name']) ."', tvcms_menutype = '" . $this->db->escape($data['tvcms_menutype']) . "' WHERE tvcms_menuid = '" . (int) $tvcms_menuid . "'";

        $this->db->query($sql_update);
    }

    public function deleteMenu($tvcms_menuid) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "tvcms_menutop_item WHERE tvcms_menuid = '" . (int)$tvcms_menuid . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "tvcmsmenu WHERE tvcms_menuid = '" . (int)$tvcms_menuid . "'");
    }

    public function addTopItem($data) {
        $sql = "INSERT INTO ". DB_PREFIX . "tvcms_menutop_item SET status = '" . (int)$data['status'] . "', tvcms_menuid = '" . (int)$data['tvcms_menuid'] . "', tvcms_has_title = '" . (int)$data['tvcms_has_title'] . "', tvcms_has_link = '" . (int)$data['tvcms_has_link'] . "', tvcms_has_child = '" . (int)$data['tvcms_has_child'] . "', category_id = '" . (int)$data['category_id'] . "', position = '" . (int)$data['position'] . "', name = '" . $this->db->escape($data['name']) . "', link = '" . $this->db->escape($data['link']) . "', icon = '" . $this->db->escape($data['icon']) . "', item_align = '" . $this->db->escape($data['item_align']) . "', sub_tvcms_menutype = '" . $this->db->escape($data['sub_tvcms_menutype']) . "', sub_tvcms_menucontent_type = '" . $this->db->escape($data['sub_tvcms_menucontent_type']) . "', sub_tvcms_menucontent_columns = '" . (int)$data['sub_tvcms_menucontent_columns'] . "', sub_tvcms_menucontent = '" . $this->db->escape(json_encode($data['sub_tvcms_menucontent'])) . "'";

        $this->db->query($sql);

        $tvcms_menuitem_id = $this->db->getLastId();

        foreach ($data['title'] as $language_id => $title) {
            $sql_title = "INSERT INTO " . DB_PREFIX . "tvcms_menutop_item_description SET language_id = '" . (int) $language_id . "', tvcms_menuitem_id = '" . (int) $tvcms_menuitem_id . "', title = '" . $this->db->escape($title) . "'";

            $this->db->query($sql_title);
        }

        return $tvcms_menuitem_id;
    }

    public function editTopItem($data, $tvcms_menuitem_id) {
        $sql = "UPDATE ". DB_PREFIX . "tvcms_menutop_item SET status = '" . (int)$data['status'] . "', tvcms_menuid = '" . (int)$data['tvcms_menuid'] . "', tvcms_has_title = '" . (int)$data['tvcms_has_title'] . "', tvcms_has_link = '" . (int)$data['tvcms_has_link'] . "', tvcms_has_child = '" . (int)$data['tvcms_has_child'] . "', category_id = '" . (int)$data['category_id'] . "', position = '" . (int)$data['position'] . "', name = '" . $this->db->escape($data['name']) . "', link = '" . $this->db->escape($data['link']) . "', icon = '" . $this->db->escape($data['icon']) . "', item_align = '" . $this->db->escape($data['item_align']) . "', sub_tvcms_menutype = '" . $this->db->escape($data['sub_tvcms_menutype']) . "', sub_tvcms_menucontent_type = '" . $this->db->escape($data['sub_tvcms_menucontent_type']) . "', sub_tvcms_menucontent_columns = '" . (int)$data['sub_tvcms_menucontent_columns'] . "', sub_tvcms_menucontent = '" . $this->db->escape(json_encode($data['sub_tvcms_menucontent'])) . "' WHERE tvcms_menuitem_id = '". (int) $tvcms_menuitem_id."'";

        $this->db->query($sql);

        $sql_reset = "DELETE FROM " . DB_PREFIX . "tvcms_menutop_item_description WHERE tvcms_menuitem_id = '" . (int) $tvcms_menuitem_id . "'";

        $this->db->query($sql_reset);

        foreach ($data['title'] as $language_id => $title) {
            $sql_title = "INSERT INTO " . DB_PREFIX . "tvcms_menutop_item_description SET language_id = '" . (int) $language_id . "', tvcms_menuitem_id = '" . (int) $tvcms_menuitem_id . "', title = '" . $this->db->escape($title) . "'";

            $this->db->query($sql_title);
        }
    }

    public function editTopItemPosition($position, $tvcms_menuitem_id) {
        $sql = "UPDATE ". DB_PREFIX . "tvcms_menutop_item SET position = '" . (int) $position . "' WHERE tvcms_menuitem_id = '". (int) $tvcms_menuitem_id."'";

        $this->db->query($sql);
    }

    public function deleteTopItem($tvcms_menuitem_id) {
        $sql = "SELECT * FROM `" . DB_PREFIX . "tvcms_menusub_item` WHERE parent_tvcms_menuitem_id = '" . (int) $tvcms_menuitem_id . "'";

        $query = $this->db->query($sql);

        foreach($query->rows as $item) {
            $this->deleteSubItem($item['sub_tvcms_menuitem_id']);
        }

        $sql = "DELETE FROM `" . DB_PREFIX . "tvcms_menutop_item_description` WHERE tvcms_menuitem_id = '" . (int) $tvcms_menuitem_id . "'";

        $this->db->query($sql);

        $sql = "DELETE FROM `" . DB_PREFIX . "tvcms_menutop_item` WHERE tvcms_menuitem_id = '" . (int) $tvcms_menuitem_id . "'";

        $this->db->query($sql);
    }

    public function deleteTopItemByMenu($tvcms_menuid) {
        $sql = "SELECT * FROM `" . DB_PREFIX . "tvcms_menutop_item` WHERE tvcms_menuid = '" . (int) $tvcms_menuid . "'";

        $query = $this->db->query($sql);

        $top_items = $query->rows;

        foreach($top_items as $item) {
            $tvcms_menuitem_id = $item['tvcms_menuitem_id'];

            $this->deleteTopItem($tvcms_menuitem_id);
        }
    }

    public function addSubItem($data) {
        $sql = "INSERT INTO ". DB_PREFIX . "tvcms_menusub_item SET status = '" . (int) $data['status'] . "', parent_tvcms_menuitem_id = '" . (int) $data['parent_tvcms_menuitem_id'] . "', level = '" . (int)$data['level'] . "', position = '" . (int)$data['position'] . "', name = '" . $this->db->escape($data['name']) . "', link = '" . $this->db->escape($data['link']) . "'";

        $this->db->query($sql);

        $sub_item_id = $this->db->getLastId();

        foreach ($data['title'] as $language_id => $title) {
            $sql_title = "INSERT INTO " . DB_PREFIX . "tvcms_menusub_item_description SET language_id = '" . (int) $language_id . "', sub_tvcms_menuitem_id = '" . (int) $sub_item_id . "', title = '" . $this->db->escape($title) . "'";

            $this->db->query($sql_title);
        }

        $level = (int) $data['level'];

        if($level == 2) {
            $sqlTopChild = "UPDATE ". DB_PREFIX . "tvcms_menutop_item SET tvcms_has_child = '1' WHERE tvcms_menuitem_id = '" . (int) $data['parent_tvcms_menuitem_id'] . "'";

            $this->db->query($sqlTopChild);
        }

        return $sub_item_id;
    }

    public function editSubItem($data, $sub_item_id) {
        $sql = "UPDATE ". DB_PREFIX . "tvcms_menusub_item SET status = '" . (int)$data['status'] . "', parent_tvcms_menuitem_id = '" . (int)$data['parent_tvcms_menuitem_id'] . "', level = '" . (int)$data['level'] . "', position = '" . (int)$data['position'] . "', name = '" . $this->db->escape($data['name']) . "', link = '" . $this->db->escape($data['link']) . "' WHERE sub_tvcms_menuitem_id = '". (int) $sub_item_id."'";

        $this->db->query($sql);

        $sql = "DELETE FROM `" . DB_PREFIX . "tvcms_menusub_item_description` WHERE sub_tvcms_menuitem_id = '" . (int) $sub_item_id. "'";

        $this->db->query($sql);

        foreach ($data['title'] as $language_id => $title) {
            $sql_title = "INSERT INTO " . DB_PREFIX . "tvcms_menusub_item_description SET language_id = '" . (int) $language_id . "', sub_tvcms_menuitem_id = '" . (int) $sub_item_id . "', title = '" . $this->db->escape($title) . "'";

            $this->db->query($sql_title);
        }
    }

    public function editSubItemPosition($position, $sub_tvcms_menuid) {
        $sql = "UPDATE ". DB_PREFIX . "tvcms_menusub_item SET position = '" . (int) $position . "' WHERE sub_tvcms_menuitem_id = '". (int) $sub_tvcms_menuid."'";

        $this->db->query($sql);
    }

    public function deleteSubItem($sub_item_id) {
        $sql = "SELECT * FROM `" . DB_PREFIX . "tvcms_menusub_item` WHERE parent_tvcms_menuitem_id = '" . (int) $sub_item_id . "'";

        $query = $this->db->query($sql);

        foreach($query->rows as $item) {
            $sql = "DELETE FROM `" . DB_PREFIX . "tvcms_menusub_item_description` WHERE sub_tvcms_menuitem_id = '" . (int) $item['sub_tvcms_menuitem_id']. "'";

            $this->db->query($sql);

            $sql = "DELETE FROM `" . DB_PREFIX . "tvcms_menusub_item` WHERE sub_tvcms_menuitem_id = '" . (int) $item['sub_tvcms_menuitem_id'] . "'";

            $this->db->query($sql);
        }

        $sql = "DELETE FROM `" . DB_PREFIX . "tvcms_menusub_item_description` WHERE sub_tvcms_menuitem_id = '" . (int) $sub_item_id . "'";

        $this->db->query($sql);

        $sql = "DELETE FROM `" . DB_PREFIX . "tvcms_menusub_item` WHERE sub_tvcms_menuitem_id = '" . (int) $sub_item_id . "'";

        $this->db->query($sql);
    }

    public function getTopItems($tvcms_menuid) {
        $sql = "SELECT DISTINCT * FROM `" . DB_PREFIX . "tvcms_menutop_item` m WHERE m.tvcms_menuid = '". (int) $tvcms_menuid ."' ORDER BY m.position ASC";

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getTopItemById($tvcms_menuitem_id) {
        $sql = "SELECT DISTINCT * FROM `" . DB_PREFIX . "tvcms_menutop_item` m LEFT JOIN `" . DB_PREFIX . "tvcms_menutop_item_description` md ON (m.tvcms_menuitem_id = md.tvcms_menuitem_id) WHERE m.tvcms_menuitem_id = '". (int) $tvcms_menuitem_id ."' AND md.language_id = '" . (int)$this->config->get('config_language_id') . "'";

        $query = $this->db->query($sql);

        return $query->row;
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

    public function getSubItemById($sub_item_id) {
        $sql = "SELECT DISTINCT * FROM `" . DB_PREFIX . "tvcms_menusub_item` m LEFT JOIN `" . DB_PREFIX . "tvcms_menusub_item_description` md ON (m.sub_tvcms_menuitem_id = md.sub_tvcms_menuitem_id) WHERE m.sub_tvcms_menuitem_id = '". (int) $sub_item_id ."' AND md.language_id = '" . (int)$this->config->get('config_language_id') . "'";

        $query = $this->db->query($sql);

        return $query->row;
    }

    public function getSubItemDescriptionById($sub_item_id) {
        $tvcms_menudescription_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tvcms_menusub_item_description WHERE sub_tvcms_menuitem_id = '" . (int) $sub_item_id . "'");

        foreach ($query->rows as $result) {
            $tvcms_menudescription_data[$result['language_id']] = $result['title'];
        }

        return $tvcms_menudescription_data;
    }

    public function getMenu($tvcms_menuid) {
        $sql = "SELECT * FROM `" . DB_PREFIX . "tvcmsmenu` WHERE tvcms_menuid = '" . (int)$tvcms_menuid . "'";

        $query = $this->db->query($sql);

        return $query->row;
    }

    public function getMenuList($data = array()) {
        $sql = "SELECT * FROM `" . DB_PREFIX . "tvcmsmenu`";

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

    public function getMenuCount() {
        $sql = "SELECT COUNT(tvcms_menuid) AS total FROM `" . DB_PREFIX . "tvcmsmenu`";

        $query = $this->db->query($sql);

        return $query->row['total'];
    }

    public function getTopCategories() {
        $category_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category WHERE top = 1 AND parent_id = 0");

        foreach ($query->rows as $result) {
            $category_data[] = $result['category_id'];
        }

        return $category_data;
    }

    public function getCategories($parent_id = 0) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND c.status = '1' ORDER BY c.sort_order, LCASE(cd.name)");

        return $query->rows;
    }

    public function getAllCategories($data = array()) {
        $sql = "SELECT cp.category_id AS category_id, cd2.name AS name, c1.parent_id, c1.sort_order FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "category c1 ON (cp.category_id = c1.category_id) LEFT JOIN " . DB_PREFIX . "category c2 ON (cp.path_id = c2.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd1 ON (cp.path_id = cd1.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd2 ON (cp.category_id = cd2.category_id) WHERE cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'";

        if (!empty($data['filter_name'])) {
            $sql .= " AND cd2.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
        }

        $sql .= " GROUP BY cp.category_id";

        $sort_data = array(
            'name',
            'sort_order'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY sort_order";
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

    public function deleteMenuData() {
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "tvcms_menusub_item_description`;");
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "tvcms_menusub_item`;");
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "tvcms_menutop_item_description`;");
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "tvcms_menutop_item`;");
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "tvcmsmenu`;");
    }

    public function getLanguageByCode($language_code) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "language WHERE code = '" . $this->db->escape($language_code) . "'");

        return $query->row;
    }
}