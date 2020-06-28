<?php
class ControllerExtensionModuletvcmsverticalmenu extends Controller
{
    public function index($setting) {
        $this->load->language('extension/module/tvcmsverticalmenu');

        $this->load->model('extension/module/tvcmsverticalmenu');
        $this->load->model('tool/image');
        $this->load->model('localisation/language');
        $this->load->model('catalog/category');
        $this->load->model('catalog/product');

        $data = array();

        $data['warning'] = false;

        $module_id = rand(0, 10000);
        $data['module_id'] = $module_id;

        $data['items'] = array();

        $tvcms_menuid = $setting['menu'];

        $menu = $this->model_extension_module_tvcmsverticalmenu->getMenuById($tvcms_menuid);
        $data['tvcms_menutype'] = $menu['tvcms_menutype'];

        if($menu) {
            if($menu['status']) {
                $top_items = $this->model_extension_module_tvcmsverticalmenu->getTopItems($tvcms_menuid);

                $lang_code = $this->session->data['language'];

                $lang = $this->model_extension_module_tvcmsverticalmenu->getLanguageByCode($lang_code);

                foreach ($top_items as $top_item) {
                    $sub_items_lv2 = array();

                    $sub_items2 = $this->model_extension_module_tvcmsverticalmenu->getSubItems($top_item['tvcms_menuitem_id'], '2');

                    foreach ($sub_items2 as $sub_item2) {
                        $sub_items_lv3 = array();

                        $sub_items3 = $this->model_extension_module_tvcmsverticalmenu->getSubItems($sub_item2['sub_tvcms_menuitem_id'], '3');

                        foreach ($sub_items3 as $sub_item3) {
                            $third_title = $this->model_extension_module_tvcmsverticalmenu->getSubItemDescriptionById($sub_item3['sub_tvcms_menuitem_id']);

                            if($sub_item3['status']) {
                                $third_status = true;
                            } else {
                                $third_status = false;
                            }
                            
                            if(isset($third_title[$lang['language_id']])) {
                                $title = $third_title[$lang['language_id']];
                            } else {
                                $title = 'Third Level Item';
                            }

                            $sub_items_lv3[] = array(
                                'id'    => $sub_item3['sub_tvcms_menuitem_id'],
                                'level' => $sub_item3['level'],
                                'status' => $third_status,
                                'link' => $sub_item3['link'],
                                'position' => $sub_item3['position'],
                                'title' => $title,
                            );
                        }

                        $second_title = $this->model_extension_module_tvcmsverticalmenu->getSubItemDescriptionById($sub_item2['sub_tvcms_menuitem_id']);

                        if($sub_item2['status']) {
                            $second_status = true;
                        } else {
                            $second_status = false;
                        }

                        if(isset($second_title[$lang['language_id']])) {
                            $title = $second_title[$lang['language_id']];
                        } else {
                            $title = 'Second Level Item';
                        }

                        $sub_items_lv2[] = array(
                            'id'    => $sub_item2['sub_tvcms_menuitem_id'],
                            'level' => $sub_item2['level'],
                            'status' => $second_status,
                            'link' => $sub_item2['link'],
                            'position' => $sub_item2['position'],
                            'title' => $title,
                            'sub_items' => $sub_items_lv3
                        );
                    }

                    $top_item_title = $this->model_extension_module_tvcmsverticalmenu->getTopItemDescriptionById($top_item['tvcms_menuitem_id']);

                    if(isset($top_item_title[$lang['language_id']])) {
                        $top_level_title = $top_item_title[$lang['language_id']];
                    } else {
                        $top_level_title = 'Top Item';
                    }

                    if($top_item['status']) {
                        $top_item_status = true;
                    } else {
                        $top_item_status = false;
                    }

                    if($top_item['tvcms_has_title']) {
                        $top_item_tvcms_has_title = true;
                    } else {
                        $top_item_tvcms_has_title = false;
                    }

                    if($top_item['tvcms_has_link']) {
                        $top_item_tvcms_has_link = true;
                    } else {
                        $top_item_tvcms_has_link = false;
                    }

                    if($top_item['tvcms_has_child']) {
                        $top_item_tvcms_has_child = true;
                    } else {
                        $top_item_tvcms_has_child = false;
                    }

                    if($top_item['icon']) {
                        $icon = $this->model_tool_image->resize($top_item['icon'], 30, 30);
                    } else {
                        $icon = false;
                    }

                    if($top_item['sub_tvcms_menucontent']) {
                        $sub_content = json_decode($top_item['sub_tvcms_menucontent'], true);
                    } else {
                        $sub_content = false;
                    }

                    if($top_item['sub_tvcms_menucontent_columns']) {
                        $column = (int) $top_item['sub_tvcms_menucontent_columns'];
                        if($column == 5) {
                            $cols = false;
                        } else {
                            $cols = 12 / $column;
                        }

                    } else {
                        $cols = 12;
                    }

                    if($top_item['category_id']) {
                        $top_category_info = $this->model_catalog_category->getCategory($top_item['category_id']);

                        if($top_category_info && $top_item_status) {
                            $top_item_status = true;
                        } else {
                            $top_item_status = false;
                        }
                    }

                    $sub_tvcms_menucontent = array();

                    if($sub_content) {
                        foreach ($sub_content as $sub_type => $widgets) {
                            if($sub_type == "category") {
                                if($top_item_status) {
                                    if($widgets) {
                                        foreach ($widgets as $widget) {
                                            $category_id = $widget['category_id'];
                                            $category_info = $this->model_catalog_category->getCategory($category_id);

                                            if ($category_info) {
                                                $type = $widget['type'];
                                                $title = $category_info['name'];
                                                $link = $this->url->link('product/category', 'path=' . $top_item['category_id'] . '_' . $category_id);
                                                $w_cols = $widget['cols'];

                                                if($widget['show_image']) {
                                                    if ($category_info['image']) {
                                                        $image = $this->model_tool_image->resize($category_info['image'], 100, 100);
                                                    } else {
                                                        $image = false;
                                                    }
                                                } else {
                                                    $image = false;
                                                }

                                                $children = array();

                                                if($widget['show_child']) {
                                                    $results = $this->model_catalog_category->getCategories($category_id);

                                                    foreach ($results as $result) {
                                                        $children[] = array(
                                                            'title' => $result['name'],
                                                            'link' => $this->url->link('product/category', 'path=' . $top_item['category_id'] . '_' . $category_id . '_' . $result['category_id'])
                                                        );
                                                    }
                                                }

                                                $sub_tvcms_menucontent['category'][] = array(
                                                    'id'        => $category_id,
                                                    'title'     => $title,
                                                    'link'      => $link,
                                                    'cols'      => $w_cols,
                                                    'image'     => $image,
                                                    'children'  => $children
                                                );
                                            }
                                        }
                                    }
                                }
                            }

                            if($sub_type == "widget") {
                                if($top_item_status) {
                                    if($widgets) {
                                        foreach ($widgets as $widget) {
                                            if($widget['type'] == "category") {
                                                $category_id = $widget['category_id'];
                                                $category_info = $this->model_catalog_category->getCategory($category_id);

                                                if ($category_info) {
                                                    $title = $category_info['name'];
                                                    $link = $this->url->link('product/category', 'path=' . $category_id);
                                                    $w_cols = $widget['cols'];

                                                    if($widget['show_image']) {
                                                        if ($category_info['image']) {
                                                            $image = $this->model_tool_image->resize($category_info['image'], 100, 100);
                                                        } else {
                                                            $image = false;
                                                        }
                                                    } else {
                                                        $image = false;
                                                    }

                                                    $children = array();

                                                    if($widget['show_child']) {
                                                        $results = $this->model_catalog_category->getCategories($category_id);

                                                        foreach ($results as $result) {
                                                            $children[] = array(
                                                                'title' => $result['name'],
                                                                'link' => $this->url->link('product/category', 'path=' . $category_id . '_' . $result['category_id'])
                                                            );
                                                        }
                                                    }

                                                    $sub_tvcms_menucontent['widget'][] = array(
                                                        'type'      => $widget['type'],
                                                        'title'     => $title,
                                                        'link'      => $link,
                                                        'cols'      => $w_cols,
                                                        'image'     => $image,
                                                        'children'  => $children
                                                    );
                                                }
                                            }

                                            if($widget['type'] == 'html') {
                                                if($widget['show_title']) {
                                                    if(isset($widget['name'][$lang['language_id']])) {
                                                        $title = $widget['name'][$lang['language_id']];
                                                    } else {
                                                        $title = 'Widget HTML';
                                                    }
                                                } else {
                                                    $title = false;
                                                }

                                                $w_cols = $widget['cols'];

                                                if(isset($widget['content'][$lang['language_id']])) {
                                                    $html_content = html_entity_decode($widget['content'][$lang['language_id']], ENT_QUOTES, 'UTF-8');
                                                } else {
                                                    $html_content = '';
                                                }

                                                $sub_tvcms_menucontent['widget'][] = array(
                                                    'type'      => $widget['type'],
                                                    'title'     => $title,
                                                    'cols'      => $w_cols,
                                                    'content'   => $html_content
                                                );
                                            }

                                            if($widget['type'] == 'product') {
                                                $product_id = $widget['product_id'];
                                                $product_info = $this->model_catalog_product->getProduct($product_id);

                                                if($product_info) {
                                                    $w_cols = $widget['cols'];
                                                    $title = $product_info['name'];

                                                    if($widget['show_image']) {
                                                        if ($product_info['image']) {
                                                            $image = $this->model_tool_image->resize($product_info['image'], 600, 600);
                                                        } else {
                                                            $image = false;
                                                        }
                                                    }
													
													if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
														$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
													} else {
														$price = false;
													}

													if ((float)$product_info['special']) {
														$special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
													} else {
														$special = false;
													}

                                                    $link = $this->url->link('product/product', '&product_id=' . $product_id);

                                                    $sub_tvcms_menucontent['widget'][] = array(
                                                        'type'      => $widget['type'],
                                                        'title'     => $title,
                                                        'link'      => $link,
                                                        'cols'      => $w_cols,
														'price'       => $price,
														'special'     => $special,
                                                        'image'     => $image
                                                    );
                                                }
                                            }

                                            if($widget['type'] == 'link') {
                                                if(isset($widget['name'][$lang['language_id']])) {
                                                    $title = $widget['name'][$lang['language_id']];
                                                } else {
                                                    $title = "Widget Link";
                                                }

                                                $sub_tvcms_menucontent['widget'][] = array(
                                                    'type'      => $widget['type'],
                                                    'title'     => $title,
                                                    'cols'      => $widget['cols'],
                                                    'link'      => $widget['link']
                                                );
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }

                    if(isset($top_item['category_id']) && $top_item['sub_tvcms_menucontent_type'] == 'category') {
                        $top_link = $this->url->link('product/category', 'path=' . $top_item['category_id']);
                    } else {
                        $top_link = $top_item['link'];
                    }

                    $data['items'][] = array(
                        'id'    => $top_item['tvcms_menuitem_id'],
                        'sub_items' => $sub_items_lv2,
                        'status' => $top_item_status,
                        'tvcms_has_title'               => $top_item_tvcms_has_title,
                        'tvcms_has_link'                => $top_item_tvcms_has_link,
                        'tvcms_has_child'               => $top_item_tvcms_has_child,
                        'category_id'                   => $top_item['category_id'],
                        'link'                          => $top_link,
                        'icon'                          => $icon,
                        'item_align'                    => $top_item['item_align'],
                        'sub_tvcms_menutype'            => $top_item['sub_tvcms_menutype'],
                        'sub_tvcms_menucontent_type'    => $top_item['sub_tvcms_menucontent_type'],
                        'sub_tvcms_menucontent_columns' => $cols,
                        'sub_tvcms_menucontent'         => $sub_tvcms_menucontent,
                        'title'                         => $top_level_title
                    );
                }
            } else {
                $data['warning'] = true;
            }
        } else {
            $data['warning'] = true;
        }
        //$this->document->addScript('catalog/view/javascript/tvcmsverticalmenu/menu.js');
        return $this->load->view('extension/module/tvcmsverticalmenu', $data);
    }
}