<?php
class ControllerExtensionModuletvcmsverticalmenu extends Controller
{
    private $error = array();

    public function install() {
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

    public function uninstall() {
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "tvcms_menusub_item_description`;");
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "tvcms_menusub_item`;");
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "tvcms_menutop_item_description`;");
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "tvcms_menutop_item`;");
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "tvcmsmenu`;");
    }

    public function index() {
        $this->load->language('extension/module/tvcmsverticalmenu');

        $this->document->setTitle($this->language->get('page_title'));

        $this->load->model('setting/module');
        $this->load->model('extension/module/tvcmsverticalmenu');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            if (!isset($this->request->get['module_id'])) {
                $this->model_setting_module->addModule('tvcmsverticalmenu', $this->request->post);
            } else {
                $this->model_setting_module->editModule($this->request->get['module_id'], $this->request->post);
            }

            $this->cache->delete('product');

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
        }

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['name'])) {
            $data['error_name'] = $this->error['name'];
        } else {
            $data['error_name'] = '';
        }

        $data['menus'] = array();
        $menuList = $this->model_extension_module_tvcmsverticalmenu->getMenuList();
        foreach ($menuList as $menu) {
            $data['menus'][] = array(
                'id'    => $menu['tvcms_menuid'],
                'name'  => $menu['name']
            );
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
        );

        if (!isset($this->request->get['module_id'])) {
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('extension/module/tvcmsverticalmenu', 'user_token=' . $this->session->data['user_token'], true)
            );
        } else {
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('extension/module/tvcmsverticalmenu', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
            );
        }

        if (!isset($this->request->get['module_id'])) {
            $data['action'] = $this->url->link('extension/module/tvcmsverticalmenu', 'user_token=' . $this->session->data['user_token'], true);
        } else {
            $data['action'] = $this->url->link('extension/module/tvcmsverticalmenu', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
        }

        $data['tvcms_menueditor_link'] = $this->url->link('extension/module/tvcmsverticalmenu/menulist', 'user_token=' . $this->session->data['user_token'], true);
        $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

        if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $module_info = $this->model_setting_module->getModule($this->request->get['module_id']);
        }

        // General Settings
        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($module_info)) {
            $data['status'] = $module_info['status'];
        } else {
            $data['status'] = '';
        }

        if (isset($this->request->post['menu'])) {
            $data['menu'] = $this->request->post['menu'];
        } elseif (!empty($module_info)) {
            $data['menu'] = $module_info['menu'];
        } else {
            $data['menu'] = '';
        }

        if (isset($this->request->post['name'])) {
            $data['name'] = $this->request->post['name'];
        } elseif (!empty($module_info)) {
            $data['name'] = $module_info['name'];
        } else {
            $data['name'] = '';
        }

        $this->document->addStyle('view/stylesheet/tvcmsmenu.css');

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/tvcmsverticalmenu', $data));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/module/tvcmsverticalmenu')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
            $this->error['name'] = $this->language->get('error_name');
        }

        return !$this->error;
    }

    public function menuList() {
        $this->load->language('extension/module/tvcmsverticalmenu');

        $this->document->setTitle($this->language->get('page_title'));

        $this->load->model('extension/module/tvcmsverticalmenu');

        $this->getlist();
    }

    public function add() {
        $this->load->language('extension/module/tvcmsverticalmenu');

        $this->document->setTitle($this->language->get('page_title'));

        $this->load->model('extension/module/tvcmsverticalmenu');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_extension_module_tvcmsverticalmenu->addMenu($this->request->post);

            $post_data = $this->request->post;

            $top_position_data = $post_data['top_item_position'];

            foreach ($top_position_data as $tvcms_menuitem_id => $position) {
                $this->model_extension_module_tvcmsverticalmenu->editTopItemPosition($position, $tvcms_menuitem_id);
            }

            $sub2_position_data = $post_data['sub_item_position2'];

            foreach ($sub2_position_data as $sub_item_id => $position) {
                $this->model_extension_module_tvcmsverticalmenu->editSubItemPosition($position, $sub_item_id);
            }

            $sub3_position_data = $post_data['sub_item_position3'];

            foreach ($sub3_position_data as $sub_item_id => $position) {
                $this->model_extension_module_tvcmsverticalmenu->editSubItemPosition($position, $sub_item_id);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->response->redirect($this->url->link('extension/module/tvcmsverticalmenu/menuList', 'user_token=' . $this->session->data['user_token'] . $url, true));
        }

        $this->getForm();
    }

    public function edit() {
        $this->load->language('extension/module/tvcmsverticalmenu');

        $this->document->setTitle($this->language->get('page_title'));

        $this->load->model('extension/module/tvcmsverticalmenu');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $post_data = $this->request->post;

            $this->model_extension_module_tvcmsverticalmenu->editMenu($this->request->get['tvcms_menuid'], $this->request->post);

            $top_position_data = $post_data['top_item_position'];

            foreach ($top_position_data as $tvcms_menuitem_id => $position) {
                $this->model_extension_module_tvcmsverticalmenu->editTopItemPosition($position, $tvcms_menuitem_id);
            }

            $sub2_position_data = $post_data['sub_item_position2'];

            foreach ($sub2_position_data as $sub_item_id => $position) {
                $this->model_extension_module_tvcmsverticalmenu->editSubItemPosition($position, $sub_item_id);
            }

            $sub3_position_data = $post_data['sub_item_position3'];

            foreach ($sub3_position_data as $sub_item_id => $position) {
                $this->model_extension_module_tvcmsverticalmenu->editSubItemPosition($position, $sub_item_id);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->response->redirect($this->url->link('extension/module/tvcmsverticalmenu/menuList', 'user_token=' . $this->session->data['user_token'] . $url, true));
        }

        $this->getForm();
    }

    public function delete() {
        $this->load->language('extension/module/tvcmsverticalmenu');

        $this->document->setTitle($this->language->get('page_title'));

        $this->load->model('extension/module/tvcmsverticalmenu');

        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $tvcms_menuid) {
                $this->model_extension_module_tvcmsverticalmenu->deleteMenu($tvcms_menuid);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->response->redirect($this->url->link('extension/module/tvcmsverticalmenu/menuList', 'user_token=' . $this->session->data['user_token'] . $url, true));
        }

        $this->getlist();
    }

    public function getlist() {
        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $url = '';

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
        );

        if (!isset($this->request->get['module_id'])) {
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('extension/module/tvcmsverticalmenu', 'user_token=' . $this->session->data['user_token'], true)
            );
        } else {
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('extension/module/tvcmsverticalmenu', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
            );
        }

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_tvcms_menueditor'),
            'href' => $this->url->link('extension/module/tvcmsverticalmenu/menuList', 'user_token=' . $this->session->data['user_token'] . $url, true)
        );

        $data['add'] = $this->url->link('extension/module/tvcmsverticalmenu/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
        $data['delete'] = $this->url->link('extension/module/tvcmsverticalmenu/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);

        $filter_data = array(
            'start'           => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit'           => $this->config->get('config_limit_admin')
        );

        $data['tvcms_menulist'] = array();

        $menus_total = $this->model_extension_module_tvcmsverticalmenu->getMenuCount();

        $menus = $this->model_extension_module_tvcmsverticalmenu->getMenuList($filter_data);

        if($menus) {
            foreach ($menus as $menu) {
                $data['tvcms_menulist'][] = array(
                    'tvcms_menuid'   => $menu['tvcms_menuid'],
                    'name'      => $menu['name'],
                    'status'    => $menu['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
                    'url'       => $this->url->link('extension/module/tvcmsverticalmenu/edit', 'user_token=' . $this->session->data['user_token'] . '&tvcms_menuid=' . $menu['tvcms_menuid'] . $url, true)
                );
            }
        }

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        if (isset($this->request->post['selected'])) {
            $data['selected'] = (array)$this->request->post['selected'];
        } else {
            $data['selected'] = array();
        }

        $pagination = new Pagination();
        $pagination->total = $menus_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url = $this->url->link('extension/module/tvcmsverticalmenu/menuList', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($menus_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($menus_total - $this->config->get('config_limit_admin'))) ? $menus_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $menus_total, ceil($menus_total / $this->config->get('config_limit_admin')));

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/tvcmsverticalmenu/tvcmslist', $data));
    }

    public function getForm() {
        $data['text_form'] = !isset($this->request->get['tvcms_menuid']) ? $this->language->get('text_add') : $this->language->get('text_edit_menu');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['name'])) {
            $data['error_name'] = $this->error['name'];
        } else {
            $data['error_name'] = '';
        }

        $url = '';

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
        );

        if (!isset($this->request->get['module_id'])) {
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('extension/module/tvcmsverticalmenu', 'user_token=' . $this->session->data['user_token'], true)
            );
        } else {
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('extension/module/tvcmsverticalmenu', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
            );
        }

        if (!isset($this->request->get['tvcms_menuid'])) {
            $data['action'] = $this->url->link('extension/module/tvcmsverticalmenu/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
        } else {
            $data['action'] = $this->url->link('extension/module/tvcmsverticalmenu/edit', 'user_token=' . $this->session->data['user_token'] . '&tvcms_menuid=' . $this->request->get['tvcms_menuid'] . $url, true);
        }

        if (!isset($this->request->get['tvcms_menuid'])) {
            $this->model_extension_module_tvcmsverticalmenu->deleteTopItemByMenu('0');
            $data['cancel'] = $this->url->link('extension/module/tvcmsverticalmenu/menuList', 'user_token=' . $this->session->data['user_token'] . $url, true);
        } else {
            $data['cancel'] = $this->url->link('extension/module/tvcmsverticalmenu/menuList', 'user_token=' . $this->session->data['user_token'] . $url, true);
        }

        if (isset($this->request->get['tvcms_menuid']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $tvcms_menuinfo = $this->model_extension_module_tvcmsverticalmenu->getMenu($this->request->get['tvcms_menuid']);
        }

        $data['user_token'] = $this->session->data['user_token'];

        $this->load->model('localisation/language');

        $data['languages'] = $this->model_localisation_language->getLanguages();

        if (isset($this->request->post['name'])) {
            $data['name'] = $this->request->post['name'];
        } elseif (!empty($tvcms_menuinfo)) {
            $data['name'] = $tvcms_menuinfo['name'];
        } else {
            $data['name'] = '';
        }

        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($tvcms_menuinfo)) {
            $data['status'] = $tvcms_menuinfo['status'];
        } else {
            $data['status'] = 1;
        }

        if (isset($this->request->post['tvcms_menutype'])) {
            $data['tvcms_menutype'] = $this->request->post['tvcms_menutype'];
        } elseif (!empty($tvcms_menuinfo)) {
            $data['tvcms_menutype'] = $tvcms_menuinfo['tvcms_menutype'];
        } else {
            $data['tvcms_menutype'] = 'horizontal';
        }

        $data['top_items'] = array();
        if (isset($this->request->get['tvcms_menuid'])) {
            $results = $this->model_extension_module_tvcmsverticalmenu->getTopItems($this->request->get['tvcms_menuid']);

            foreach ($results as $result) {
                $sub_items_lv2 = $this->model_extension_module_tvcmsverticalmenu->getSubItems($result['tvcms_menuitem_id'], 2);

                $sub_items2 = array();

                if($sub_items_lv2) {
                    foreach ($sub_items_lv2 as $item) {
                        $sub_items_lv3 = $this->model_extension_module_tvcmsverticalmenu->getSubItems($item['sub_tvcms_menuitem_id'], 3);

                        $sub_items3 = array();

                        if($sub_items_lv3) {
                            foreach ($sub_items_lv3 as $s_item) {
                                $sub_items3[] = array(
                                    'item_id'   => $s_item['sub_tvcms_menuitem_id'],
                                    'name'      => $s_item['name'],
                                    'position'  => $s_item['position'],
                                    'url'           => $this->url->link('extension/module/tvcmsverticalmenu/editSubItem', 'user_token=' . $this->session->data['user_token'] . '&sub_tvcms_menuitem_id=' . $s_item['sub_tvcms_menuitem_id'] . '&tvcms_menuid=' . $this->request->get['tvcms_menuid'], true),
                                    'del_url'       => $this->url->link('extension/module/tvcmsverticalmenu/deleteSubItem', 'user_token=' . $this->session->data['user_token'] . '&sub_tvcms_menuitem_id=' . $s_item['sub_tvcms_menuitem_id'] . '&tvcms_menuid=' . $this->request->get['tvcms_menuid'], true)
                                );
                            }
                        }

                        $sub_items2[] = array(
                            'sub_items'     => $sub_items3,
                            'item_id'   => $item['sub_tvcms_menuitem_id'],
                            'name'      => $item['name'],
                            'position'  => $item['position'],
                            'url'           => $this->url->link('extension/module/tvcmsverticalmenu/editSubItem', 'user_token=' . $this->session->data['user_token'] . '&sub_tvcms_menuitem_id=' . $item['sub_tvcms_menuitem_id'] . '&tvcms_menuid=' . $this->request->get['tvcms_menuid'], true),
                            'del_url'       => $this->url->link('extension/module/tvcmsverticalmenu/deleteSubItem', 'user_token=' . $this->session->data['user_token'] . '&sub_tvcms_menuitem_id=' . $item['sub_tvcms_menuitem_id'] . '&tvcms_menuid=' . $this->request->get['tvcms_menuid'], true)
                        );
                    }
                }

                $data['top_items'][] = array(
                    'sub_items'     => $sub_items2,
                    'name'          => $result['name'],
                    'tvcms_menuitem_id'  => $result['tvcms_menuitem_id'],
                    'position'      => $result['position'],
                    'url'           => $this->url->link('extension/module/tvcmsverticalmenu/editTopItem', 'user_token=' . $this->session->data['user_token'] . '&tvcms_menuitem_id=' . $result['tvcms_menuitem_id'] . '&tvcms_menuid=' . $this->request->get['tvcms_menuid'], true),
                    'del_url'       => $this->url->link('extension/module/tvcmsverticalmenu/deleteTopItem', 'user_token=' . $this->session->data['user_token'] . '&tvcms_menuitem_id=' . $result['tvcms_menuitem_id'] . '&tvcms_menuid=' . $this->request->get['tvcms_menuid'], true)
                );
            }
        }

        if (isset($this->request->get['tvcms_menuid'])) {
            $data['top_items_form_url'] = $this->url->link('extension/module/tvcmsverticalmenu/addTopItem', 'user_token=' . $this->session->data['user_token'] . '&tvcms_menuid=' . $this->request->get['tvcms_menuid'], true);
            $data['sub_item_add_form_url'] = $this->url->link('extension/module/tvcmsverticalmenu/addSubItem', 'user_token=' . $this->session->data['user_token'] . '&tvcms_menuid=' . $this->request->get['tvcms_menuid'], true);
            $data['sub_item_edit_form_url'] = $this->url->link('extension/module/tvcmsverticalmenu/editSubItem', 'user_token=' . $this->session->data['user_token'] . '&tvcms_menuid=' . $this->request->get['tvcms_menuid'], true);
            $data['multiple_del_url'] = $this->url->link('extension/module/tvcmsverticalmenu/deleteMultipleItems', 'user_token=' . $this->session->data['user_token'] . '&tvcms_menuid=' . $this->request->get['tvcms_menuid'], true);
        } else {
            $data['top_items_form_url'] = $this->url->link('extension/module/tvcmsverticalmenu/addTopItem', 'user_token=' . $this->session->data['user_token'], true);
            $data['sub_item_add_form_url'] = $this->url->link('extension/module/tvcmsverticalmenu/addSubItem', 'user_token=' . $this->session->data['user_token'], true);
            $data['sub_item_edit_form_url'] = $this->url->link('extension/module/tvcmsverticalmenu/editSubItem', 'user_token=' . $this->session->data['user_token'], true);
            $data['multiple_del_url'] = $this->url->link('extension/module/tvcmsverticalmenu/deleteMultipleItems', 'user_token=' . $this->session->data['user_token'], true);
        }

        $data['get_top_items_url'] = $this->url->link('extension/module/tvcmsverticalmenu/getTopItemsByAjax', 'user_token=' . $this->session->data['user_token'], true);


        if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
            $data['loader_image'] = HTTPS_CATALOG . 'image/catalog/themevolty/verticlemenu/ajax_loader.gif';
        } else {
            $data['loader_image'] = HTTP_CATALOG . 'image/catalog/themevolty/verticlemenu/ajax_loader.gif';
        }

        $this->document->addScript('view/javascript/themewebvolty/tvcmsjscolor.js');
        $this->document->addScript('view/javascript/themewebvolty/tvcmsmenu.js');
        $this->document->addScript('view/javascript/jquery/jquery-ui/jquery-ui.js');
        $this->document->addStyle('view/javascript/jquery/jquery-ui/jquery-ui.css');
        $this->document->addStyle('view/stylesheet/tvcmsmenu.css');

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/tvcmsverticalmenu/tvcmsform', $data));
    }

    public function getTopItemsByAjax() {
        $this->load->language('extension/module/tvcmsverticalmenu');

        $this->load->model('extension/module/tvcmsverticalmenu');

        $json = array();

        $tvcms_menuid = $this->request->get['tvcms_menuid'];

        $results = $this->model_extension_module_tvcmsverticalmenu->getTopItems($tvcms_menuid);

        $json['top_items'] = false;

        if($results) {
            $json['top_items'] = array();

            foreach ($results as $result) {
                $sub_items_lv2 = $this->model_extension_module_tvcmsverticalmenu->getSubItems($result['tvcms_menuitem_id'], 2);

                $sub_items2 = array();

                if($sub_items_lv2) {
                    foreach ($sub_items_lv2 as $item) {
                        $sub_items_lv3 = $this->model_extension_module_tvcmsverticalmenu->getSubItems($item['sub_tvcms_menuitem_id'], 3);

                        $sub_items3 = array();

                        if($sub_items_lv3) {
                            foreach ($sub_items_lv3 as $s_item) {
                                $sub_items3[] = array(
                                    'item_id'   => $s_item['sub_tvcms_menuitem_id'],
                                    'name'      => $s_item['name'],
                                    'position'  => $s_item['position'],
                                    'url'           => $this->url->link('extension/module/tvcmsverticalmenu/editSubItem', 'user_token=' . $this->session->data['user_token'] . '&sub_tvcms_menuitem_id=' . $s_item['sub_tvcms_menuitem_id'] . '&tvcms_menuid=' . $this->request->get['tvcms_menuid'], true),
                                    'del_url'       => $this->url->link('extension/module/tvcmsverticalmenu/deleteSubItem', 'user_token=' . $this->session->data['user_token'] . '&sub_tvcms_menuitem_id=' . $s_item['sub_tvcms_menuitem_id'] . '&tvcms_menuid=' . $this->request->get['tvcms_menuid'], true)
                                );
                            }
                        }

                        $sub_items2[] = array(
                            'sub_items'     => $sub_items3,
                            'item_id'   => $item['sub_tvcms_menuitem_id'],
                            'name'      => $item['name'],
                            'position'  => $item['position'],
                            'url'           => $this->url->link('extension/module/tvcmsverticalmenu/editSubItem', 'user_token=' . $this->session->data['user_token'] . '&sub_tvcms_menuitem_id=' . $item['sub_tvcms_menuitem_id'] . '&tvcms_menuid=' . $tvcms_menuid, true),
                            'del_url'       => $this->url->link('extension/module/tvcmsverticalmenu/deleteSubItem', 'user_token=' . $this->session->data['user_token'] . '&sub_tvcms_menuitem_id=' . $item['sub_tvcms_menuitem_id'] . '&tvcms_menuid=' . $tvcms_menuid, true)
                        );
                    }
                }

                $json['top_items'][] = array(
                    'sub_items'     => $sub_items2,
                    'tvcms_menuitem_id'  => $result['tvcms_menuitem_id'],
                    'name'          => $result['name'],
                    'position'      => $result['position'],
                    'url'           => $this->url->link('extension/module/tvcmsverticalmenu/editTopItem', 'user_token=' . $this->session->data['user_token'] . '&tvcms_menuitem_id=' . $result['tvcms_menuitem_id'] . '&tvcms_menuid=' . $tvcms_menuid, true),
                    'del_url'       => $this->url->link('extension/module/tvcmsverticalmenu/deleteTopItem', 'user_token=' . $this->session->data['user_token'] . '&tvcms_menuitem_id=' . $result['tvcms_menuitem_id'] . '&tvcms_menuid=' . $tvcms_menuid, true)
                );
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function addTopItem() {
        $this->load->language('extension/module/tvcmsverticalmenu');

        $this->load->model('extension/module/tvcmsverticalmenu');

        $json = array();

        if (isset($this->request->get['tvcms_menuid'])) {
            $tvcms_menuid = $this->request->get['tvcms_menuid'];
        } else {
            $tvcms_menuid = 0;
        }

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateTopItemForm()) {
            $post_data = $this->request->post;

            $post_data['tvcms_menuid'] = $tvcms_menuid;

            if(isset($this->request->post['disable_title'])) {
                $post_data['tvcms_has_title'] = 0;
            } else {
                $post_data['tvcms_has_title'] = 1;
            }

            if(isset($this->request->post['disable_link'])) {
                $post_data['tvcms_has_link'] = 0;
            } else {
                $post_data['tvcms_has_link'] = 1;
            }

            if(isset($this->request->post['icon'])) {
                $post_data['icon'] = $this->request->post['icon'];
            } else {
                $post_data['icon'] = "";
            }

            if(isset($this->request->post['widget'])) {
                $post_data['sub_tvcms_menucontent'] = $this->request->post['widget'];
            } else {
                $post_data['sub_tvcms_menucontent'] = array();
            }
            
            $tvcms_menutop_item_id = $this->model_extension_module_tvcmsverticalmenu->addTopItem($post_data);

            if(!$json) {
                $json['submit'] = true;
                $json['last_tvcms_menutop_item'] = $tvcms_menutop_item_id;
            }

            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($json));
        } else {
            $this->getTopItemForm($tvcms_menuid);
        }
    }

    public function editTopItem() {
        $this->load->language('extension/module/tvcmsverticalmenu');

        $this->load->model('extension/module/tvcmsverticalmenu');

        $json = array();

        if (isset($this->request->get['tvcms_menuid'])) {
            $tvcms_menuid = $this->request->get['tvcms_menuid'];
        } else {
            $tvcms_menuid = 0;
        }

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateTopItemForm()) {
            $post_data = $this->request->post;

            $post_data['tvcms_menuid'] = $tvcms_menuid;

            if(isset($this->request->post['disable_title'])) {
                $post_data['tvcms_has_title'] = 0;
            } else {
                $post_data['tvcms_has_title'] = 1;
            }

            if(isset($this->request->post['disable_link'])) {
                $post_data['tvcms_has_link'] = 0;
            } else {
                $post_data['tvcms_has_link'] = 1;
            }

            if(isset($this->request->post['icon'])) {
                $post_data['icon'] = $this->request->post['icon'];
            } else {
                $post_data['icon'] = "";
            }

            if(isset($this->request->post['widget'])) {
                $post_data['sub_tvcms_menucontent'] = $this->request->post['widget'];
            } else {
                $post_data['sub_tvcms_menucontent'] = array();
            }

            $this->model_extension_module_tvcmsverticalmenu->editTopItem($post_data, $this->request->get['tvcms_menuitem_id']);

            if(!$json) {
                $json['submit'] = true;
            }

            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($json));
        } else {
            $this->getTopItemForm($tvcms_menuid);
        }
    }

    public function deleteTopItem() {
        $this->load->language('extension/module/tvcmsverticalmenu');

        $this->load->model('extension/module/tvcmsverticalmenu');

        if (isset($this->request->get['tvcms_menuid'])) {
            $tvcms_menuid = $this->request->get['tvcms_menuid'];
        } else {
            $tvcms_menuid = 0;
        }

        $json = array();

        $json['tvcms_menuid'] = $tvcms_menuid;

        if (isset($this->request->get['tvcms_menuitem_id'])) {
            $this->model_extension_module_tvcmsverticalmenu->deleteTopItem($this->request->get['tvcms_menuitem_id']);

            $json['result'] = true;
        } else {
            $json['result'] = false;
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
    
    public function deleteMultipleItems() {
        $this->load->language('extension/module/tvcmsverticalmenu');

        $this->load->model('extension/module/tvcmsverticalmenu');

        if (isset($this->request->get['tvcms_menuid'])) {
            $tvcms_menuid = $this->request->get['tvcms_menuid'];
        } else {
            $tvcms_menuid = 0;
        }

        $json = array();

        $json['tvcms_menuid'] = $tvcms_menuid;

        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            $post_data = $this->request->post;

            if(isset($post_data['top_items'])) {
                $top_items = $post_data['top_items'];

                foreach ($top_items as $top_item_id) {
                    $this->model_extension_module_tvcmsverticalmenu->deleteTopItem($top_item_id);
                }
            }

            if(isset($post_data['sub_items'])) {
                $sub_items = $post_data['sub_items'];

                foreach ($sub_items as $sub_item_id) {
                    $this->model_extension_module_tvcmsverticalmenu->deleteSubItem($sub_item_id);
                }
            }

            $json['result'] = true;
        } else {
            $json['result'] = false;
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function getTopItemForm($tvcms_menuid) {
        $json = array();

        $data = array();

        $data['tvcms_menuid'] = $tvcms_menuid;

        $data['user_token'] = $this->session->data['user_token'];

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['name'])) {
            $data['error_name'] = $this->error['name'];
        } else {
            $data['error_name'] = '';
        }

        if (isset($this->request->get['tvcms_menuitem_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $tvcms_menuitem_info = $this->model_extension_module_tvcmsverticalmenu->getTopItemById($this->request->get['tvcms_menuitem_id']);
        }
        
        if (isset($this->request->post['name'])) {
            $data['name'] = $this->request->post['name'];
        } elseif (!empty($tvcms_menuitem_info)) {
            $data['name'] = $tvcms_menuitem_info['name'];
        } else {
            $data['name'] = '';
        }

        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($tvcms_menuitem_info)) {
            $data['status'] = $tvcms_menuitem_info['status'];
        } else {
            $data['status'] = 0;
        }

        $this->load->model('localisation/language');

        $languages = $this->model_localisation_language->getLanguages();

        foreach ($languages as $language){
            if ($language['status']) {
                $data['languages'][] = array(
                    'name'  => $language['name'],
                    'language_id' => $language['language_id'],
                    'image' => $language['image'],
                    'code' => $language['code']
                );
            }
        }

        $lang_code = $this->config->get('config_admin_language');

        $lang = $this->model_extension_module_tvcmsverticalmenu->getLanguageByCode($lang_code);

        $data['lang_id'] = $lang['language_id'];

        if(isset($this->request->get['tvcms_menuitem_id'])) {
            $tvcms_menuitem_description = $this->model_extension_module_tvcmsverticalmenu->getTopItemDescriptionById($this->request->get['tvcms_menuitem_id']);
        } else {
            $tvcms_menuitem_description = array();
        }

        if (isset($this->request->post['title'])) {
            $data['title'] = $this->request->post['title'];
        } elseif (!empty($tvcms_menuitem_info) && $tvcms_menuitem_description) {
            $data['title'] = $tvcms_menuitem_description;
        } else {
            $data['title'] = array();
        }

        if (isset($this->request->post['disable_title'])) {
            $data['disable_title'] = true;
        } elseif (!empty($tvcms_menuitem_info)) {
            $data['disable_title'] = !$tvcms_menuitem_info['tvcms_has_title'];
        } else {
            $data['disable_title'] = false;
        }

        if (isset($this->request->post['tvcms_has_child'])) {
            $data['tvcms_has_child'] = 1;
        } elseif (!empty($tvcms_menuitem_info)) {
            $data['tvcms_has_child'] = $tvcms_menuitem_info['tvcms_has_child'] ? 1 : 0;
        } else {
            $data['tvcms_has_child'] = 0;
        }

        if (isset($this->request->post['link'])) {
            $data['link'] = $this->request->post['link'];
        } elseif (!empty($tvcms_menuitem_info)) {
            $data['link'] = $tvcms_menuitem_info['link'];
        } else {
            $data['link'] = '';
        }

        if (isset($this->request->post['disable_link'])) {
            $data['disable_link'] = true;
        } elseif (!empty($tvcms_menuitem_info)) {
            $data['disable_link'] = !$tvcms_menuitem_info['tvcms_has_link'];
        } else {
            $data['disable_link'] = false;
        }

        if (isset($this->request->post['sub_tvcms_menutype'])) {
            $data['sub_tvcms_menutype'] = $this->request->post['sub_tvcms_menutype'];
        } elseif (!empty($tvcms_menuitem_info)) {
            $data['sub_tvcms_menutype'] = $tvcms_menuitem_info['sub_tvcms_menutype'];
        } else {
            $data['sub_tvcms_menutype'] = 'mega';
        }

        if (isset($this->request->post['position'])) {
            $data['position'] = $this->request->post['position'];
        } elseif (!empty($tvcms_menuitem_info)) {
            $data['position'] = $tvcms_menuitem_info['position'];
        } else {
            $data['position'] = 0;
        }

        if (isset($this->request->post['item_align'])) {
            $data['item_align'] = $this->request->post['item_align'];
        } elseif (!empty($tvcms_menuitem_info)) {
            $data['item_align'] = $tvcms_menuitem_info['item_align'];
        } else {
            $data['item_align'] = 'left';
        }

        if (isset($this->request->post['sub_tvcms_menucontent_type'])) {
            $data['sub_tvcms_menucontent_type'] = $this->request->post['sub_tvcms_menucontent_type'];
        } elseif (!empty($tvcms_menuitem_info)) {
            $data['sub_tvcms_menucontent_type'] = $tvcms_menuitem_info['sub_tvcms_menucontent_type'];
        } else {
            $data['sub_tvcms_menucontent_type'] = '';
        }

        if (isset($this->request->post['sub_tvcms_menucontent_columns'])) {
            $data['sub_tvcms_menucontent_columns'] = $this->request->post['sub_tvcms_menucontent_columns'];
        } elseif (!empty($tvcms_menuitem_info)) {
            $data['sub_tvcms_menucontent_columns'] = $tvcms_menuitem_info['sub_tvcms_menucontent_columns'];
        } else {
            $data['sub_tvcms_menucontent_columns'] = 0;
        }

        if (isset($this->request->post['category_id'])) {
            $data['category_id'] = $this->request->post['category_id'];
        } elseif (!empty($tvcms_menuitem_info)) {
            $data['category_id'] = $tvcms_menuitem_info['category_id'];
        } else {
            $data['category_id'] = 0;
        }

        if (isset($this->request->post['widget'])) {
            $data['widget'] = $this->request->post['widget'];
        } elseif (!empty($tvcms_menuitem_info)) {
            $data['widget'] = json_decode($tvcms_menuitem_info['sub_tvcms_menucontent'], true);
        } else {
            $data['widget'] = array();
        }
        
        if (isset($this->request->post['icon'])) {
            $data['icon'] = $this->request->post['icon'];
        } elseif (!empty($tvcms_menuitem_info)) {
            $data['icon'] = $tvcms_menuitem_info['icon'];
        } else {
            $data['icon'] = '';
        }

        $this->load->model('tool/image');

        if (isset($this->request->post['icon']) && is_file(DIR_IMAGE . $this->request->post['icon'])) {
            $data['thumb'] = $this->model_tool_image->resize($this->request->post['icon'], 50, 50);
        } elseif (!empty($tvcms_menuitem_info) && is_file(DIR_IMAGE . $tvcms_menuitem_info['icon'])) {
            $data['thumb'] = $this->model_tool_image->resize($tvcms_menuitem_info['icon'], 50, 50);
        } else {
            $data['thumb'] = $this->model_tool_image->resize('no_image.png', 50, 50);
        }
        
        $data['placeholder'] = $this->model_tool_image->resize('no_image.png', 50, 50);
        
        // Categories
        $this->load->model('catalog/category');

        $categories = $this->model_extension_module_tvcmsverticalmenu->getTopCategories();

        $data['categories'] = array();

        foreach ($categories as $category_id) {
            $category_info = $this->model_catalog_category->getCategory($category_id);

            if ($category_info) {
                $data['categories'][] = array(
                    'category_id' => $category_info['category_id'],
                    'name'        => ($category_info['path']) ? $category_info['path'] . ' &gt; ' . $category_info['name'] : $category_info['name']
                );
            }
        }

        $data['append_categories_link'] = $this->url->link('extension/module/tvcmsverticalmenu/appendChildCategories', 'user_token=' . $this->session->data['user_token'], true);

        if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
            $data['loader_image'] = HTTPS_CATALOG . 'image/catalog/themevolty/verticlemenu/ajax_loader.gif';
        } else {
            $data['loader_image'] = HTTP_CATALOG . 'image/catalog/themevolty/verticlemenu/ajax_loader.gif';
        }

        if(!isset($this->request->get['tvcms_menuitem_id'])) {
            $data['action'] = $this->url->link('extension/module/tvcmsverticalmenu/addTopItem', 'user_token=' . $this->session->data['user_token'] . '&tvcms_menuid=' . $tvcms_menuid, true);
        } else {
            $data['action'] = $this->url->link('extension/module/tvcmsverticalmenu/editTopItem', 'user_token=' . $this->session->data['user_token'] . '&tvcms_menuitem_id=' . $this->request->get['tvcms_menuitem_id'] . '&tvcms_menuid=' . $tvcms_menuid, true);
        }

        if(!$json) {
            $json['html'] = $this->load->view('extension/module/tvcmsverticalmenu/tvcmstop_item_form', $data);
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function addSubItem() {
        $this->load->language('extension/module/tvcmsverticalmenu');

        $this->load->model('extension/module/tvcmsverticalmenu');

        if (isset($this->request->get['tvcms_menuid'])) {
            $tvcms_menuid = $this->request->get['tvcms_menuid'];
        } else {
            $tvcms_menuid = 0;
        }

        $json = array();

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateSubItemForm()) {
            $post_data = $this->request->post;

            $this->model_extension_module_tvcmsverticalmenu->addSubItem($post_data);

            if(!$json) {
                $json['submit'] = true;
            }

            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($json));
        } else {
            $this->getSubItemForm($tvcms_menuid);
        }
    }

    public function editSubItem() {
        $this->load->language('extension/module/tvcmsverticalmenu');

        $this->load->model('extension/module/tvcmsverticalmenu');

        if (isset($this->request->get['tvcms_menuid'])) {
            $tvcms_menuid = $this->request->get['tvcms_menuid'];
        } else {
            $tvcms_menuid = 0;
        }

        $json = array();

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateSubItemForm()) {
            $post_data = $this->request->post;

            $this->model_extension_module_tvcmsverticalmenu->editSubItem($post_data, $this->request->get['sub_item_id']);

            if(!$json) {
                $json['submit'] = true;
            }

            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($json));
        } else {
            $this->getSubItemForm($tvcms_menuid);
        }
    }

    public function deleteSubItem() {
        $this->load->language('extension/module/tvcmsverticalmenu');

        $this->load->model('extension/module/tvcmsverticalmenu');

        if (isset($this->request->get['tvcms_menuid'])) {
            $tvcms_menuid = $this->request->get['tvcms_menuid'];
        } else {
            $tvcms_menuid = 0;
        }

        $json = array();

        $json['tvcms_menuid'] = $tvcms_menuid;

        if (isset($this->request->get['sub_tvcms_menuitem_id'])) {
            $this->model_extension_module_tvcmsverticalmenu->deleteSubItem($this->request->get['sub_tvcms_menuitem_id']);

            $json['result'] = true;
        } else {
            $json['result'] = false;
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function getSubItemForm($tvcms_menuid) {
        $json = array();

        $data = array();

        $data['tvcms_menuid'] = $tvcms_menuid;

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['name'])) {
            $data['error_name'] = $this->error['name'];
        } else {
            $data['error_name'] = '';
        }

        if (isset($this->request->get['sub_item_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $sub_tvcms_menuitem_info = $this->model_extension_module_tvcmsverticalmenu->getSubItemById($this->request->get['sub_item_id']);
        }

        if (isset($this->request->post['name'])) {
            $data['name'] = $this->request->post['name'];
        } elseif (!empty($sub_tvcms_menuitem_info)) {
            $data['name'] = $sub_tvcms_menuitem_info['name'];
        } else {
            $data['name'] = '';
        }

        if(isset($this->request->get['parent_id'])) {
            $data['parent_tvcms_menuitem_id'] = $this->request->get['parent_id'];
        } elseif (isset($this->request->post['name'])) {
            $data['parent_tvcms_menuitem_id'] = $this->request->post['parent_tvcms_menuitem_id'];
        } elseif (!empty($sub_tvcms_menuitem_info)) {
            $data['parent_tvcms_menuitem_id'] = $sub_tvcms_menuitem_info['parent_tvcms_menuitem_id'];
        } else {
            $data['parent_tvcms_menuitem_id'] = 0;
        }

        if(isset($this->request->get['level'])) {
            $data['level'] = $this->request->get['level'];
        } elseif (isset($this->request->post['level'])) {
            $data['level'] = $this->request->post['level'];
        } elseif (!empty($sub_tvcms_menuitem_info)) {
            $data['level'] = $sub_tvcms_menuitem_info['level'];
        } else {
            $data['level'] = 0;
        }

        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($sub_tvcms_menuitem_info)) {
            $data['status'] = $sub_tvcms_menuitem_info['status'];
        } else {
            $data['status'] = 1;
        }

        if (isset($this->request->post['position'])) {
            $data['position'] = $this->request->post['position'];
        } elseif (!empty($sub_tvcms_menuitem_info)) {
            $data['position'] = $sub_tvcms_menuitem_info['position'];
        } else {
            $data['position'] = 0;
        }

        if (isset($this->request->post['link'])) {
            $data['link'] = $this->request->post['link'];
        } elseif (!empty($sub_tvcms_menuitem_info)) {
            $data['link'] = $sub_tvcms_menuitem_info['link'];
        } else {
            $data['link'] = '';
        }

        $this->load->model('localisation/language');

        $languages = $this->model_localisation_language->getLanguages();

        foreach ($languages as $language){
            if ($language['status']) {
                $data['languages'][] = array(
                    'name'  => $language['name'],
                    'language_id' => $language['language_id'],
                    'image' => $language['image'],
                    'code' => $language['code']
                );
            }
        }

        if(isset($this->request->get['sub_item_id'])) {
            $tvcms_menuitem_description = $this->model_extension_module_tvcmsverticalmenu->getSubItemDescriptionById($this->request->get['sub_item_id']);
        } else {
            $tvcms_menuitem_description = array();
        }

        if (isset($this->request->post['title'])) {
            $data['title'] = $this->request->post['title'];
        } elseif (!empty($sub_tvcms_menuitem_info) && $tvcms_menuitem_description) {
            $data['title'] = $tvcms_menuitem_description;
        } else {
            $data['title'] = array();
        }

        $data['user_token'] = $this->session->data['user_token'];

        if(!isset($this->request->get['sub_item_id'])) {
            $data['action'] = $this->url->link('extension/module/tvcmsverticalmenu/addSubItem', 'user_token=' . $this->session->data['user_token'] . '&parent_id=' . $this->request->get['parent_id'] . '&level=' . $this->request->get['level'], true);
        } else {
            $data['action'] = $this->url->link('extension/module/tvcmsverticalmenu/editSubItem', 'user_token=' . $this->session->data['user_token'] . '&sub_item_id=' . $this->request->get['sub_item_id'], true);
        }

        if(!$json) {
            $json['html'] = $this->load->view('extension/module/tvcmsverticalmenu/tvcmssub_item_form', $data);
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function appendChildCategories() {
        $this->load->model('extension/module/tvcmsverticalmenu');

        $json = array();

        $category_id = $this->request->get['category_id'];

        $json['category_link'] = 'index.php?route=product/category&path=' . $category_id;

        $childCategories = $this->model_extension_module_tvcmsverticalmenu->getCategories($category_id);

        if($childCategories) {
            foreach ($childCategories as $child_category) {
                $json['child_categories'][] = array(
                    'category_id' => $child_category['category_id'],
                    'name'        => $child_category['name']
                );
            }
        } else {
            $json['child_categories'] = false;
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    protected function validateTopItemForm() {
        if (!$this->user->hasPermission('modify', 'extension/module/tvcmsverticalmenu')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->language->get('error_warning');
        }

        if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
            $this->error['name'] = $this->language->get('error_item_name');
        }

        return !$this->error;
    }

    protected function validateSubItemForm() {
        if (!$this->user->hasPermission('modify', 'extension/module/tvcmsverticalmenu')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->language->get('error_warning');
        }

        if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
            $this->error['name'] = $this->language->get('error_item_name');
        }

        return !$this->error;
    }

    protected function validateForm() {
        if (!$this->user->hasPermission('modify', 'extension/module/tvcmsverticalmenu')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->language->get('error_warning');
        }

        if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
            $this->error['name'] = $this->language->get('error_tvcms_menuname');
        }

        return !$this->error;
    }

    protected function validateDelete() {
        if (!$this->user->hasPermission('modify', 'extension/module/tvcmsverticalmenu')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }

    protected function validateCopy() {
        if (!$this->user->hasPermission('modify', 'extension/module/tvcmsverticalmenu')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }

    protected function array_delete($array, $element) {
        return (is_array($element)) ? array_values(array_diff($array, $element)) : array_values(array_diff($array, array($element)));
    }

    public function autoCompleteCategory() {
        $json = array();

        if (isset($this->request->get['filter_name'])) {
            $this->load->model('extension/module/tvcmsverticalmenu');

            $filter_data = array(
                'filter_name' => $this->request->get['filter_name'],
                'sort'        => 'name',
                'order'       => 'ASC',
                'start'       => 0,
                'limit'       => 5
            );

            $results = $this->model_extension_module_tvcmsverticalmenu->getAllCategories($filter_data);

            foreach ($results as $result) {
                $json[] = array(
                    'category_id' => $result['category_id'],
                    'name'        => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
                );
            }
        }

        $sort_order = array();

        foreach ($json as $key => $value) {
            $sort_order[$key] = $value['name'];
        }

        array_multisort($sort_order, SORT_ASC, $json);

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function getLanguageData() {
        $this->load->model('localisation/language');

        $languages = $this->model_localisation_language->getLanguages();

        $json = array();

        foreach ($languages as $language){
            if ($language['status']) {
                $json['languages'][] = array(
                    'name'  => $language['name'],
                    'language_id' => $language['language_id'],
                    'image' => $language['image'],
                    'code' => $language['code']
                );
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
}