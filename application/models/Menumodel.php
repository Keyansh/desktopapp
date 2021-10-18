<?php

class Menumodel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getDetails($mid)
    {
        $this->db->where('menu_id', intval($mid));
        $rs = $this->db->get('menu');
        if ($rs->num_rows() == 1) {
            return $rs->row_array();
        }

        return false;
    }

    public function getDetailsByAlias($alias)
    {
        $this->db->where('menu_alias', $alias);
        $rs = $this->db->get('menu');
        if ($rs->num_rows() == 1) {
            return $rs->row_array();
        }

        return false;
    }

    public function getMenuByAlias($alias)
    {
        $this->db->from('menu');
        $this->db->join('menu_item', 'menu_item.menu_id = menu.menu_id');
        $this->db->join('page', 'page.page_id = menu_item.page_id', 'LEFT OUTER');
        $this->db->order_by('menu_sort_order', 'ASC');
        $this->db->where('menu_alias', $alias);
        $rs = $this->db->get();
        return $rs->result_array();
    }

    public function menu($params)
    {
        if (!isset($params['menu_alias'])) {
            return false;
        }

        $menu = $this->getDetailsByAlias($params['menu_alias']);

        if (!$menu) {
            return false;
        }

        $params['menu_id'] = $menu['menu_id'];

        //Fetch root menu items
        $this->db->from('menu_item');
        $this->db->join('page', 'page.page_id = menu_item.page_id', 'LEFT OUTER');
        $this->db->where('menu_item.parent_id', 0);
        $this->db->where('menu_item.menu_id', $params['menu_id']);
        $this->db->order_by('menu_sort_order', 'ASC');
        $rs = $this->db->get();
        if ($rs->num_rows() == 0) {
            return false;
        }

        $rows = $rs->result_array();

        $params['first_menu_id'] = $rows[0]['menu_item_id'];
        $tmp = array_pop($rows);
        $params['last_menu_id'] = $tmp['menu_item_id'];

        $output = $this->_menu($params);

        $output = str_replace('{MENU}', $output, $params['ul_format']);
        $output = str_replace('{MENU_TITLE}', $menu['menu_title'] . "&nbsp;", $output);
        return $output;
    }

    public function _menu($params, $parent_id = 0, $output = '')
    {
        $this->db->from('menu_item');
        $this->db->join('menu', 'menu_item.menu_id = menu.menu_id');
        $this->db->join('page', 'page.page_id = menu_item.page_id', 'LEFT OUTER');
        $this->db->where('menu_item.parent_id', $parent_id);
        $this->db->where('menu_item.menu_id', $params['menu_id']);
        $this->db->order_by('menu_sort_order', 'ASC');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            if ($parent_id == 0) {
                //$output .= '<ul class="'.$params['ul_class'].'">' . "\r\n";
            } else {
                $output .= "<ul class=' catmenu-menu'>\r\n";
            }
            foreach ($query->result_array() as $key => $row) {
                $li_class_arr = array();
                $li_class = '';
                if ($row['menu_item_id'] == $params['first_menu_id']) {
                    $li_class_arr[] = "first";
                }
                if ($row['menu_item_id'] == $params['last_menu_id']) {
                    $li_class_arr[] = "last";
                }
                if (isset($params['list_class'])) {
                    $li_class_arr[] = $params['list_class'];
                }
                if ($parent_id == 0) {
                    $li_class_arr[] = "root_menu  ";
                }
                if ($row['page_id'] != 0) {
                    $cpage = $this->core->getPage();
                    if ($cpage && $row['page_id'] == $cpage['page_id']) {
                        $li_class_arr[] = "current_disable";
                    }
                }
                $li_class = trim(join(' ', $li_class_arr));

                //anchor tag class
                $a_class_arr = array();
                $a_class = '';
                if (isset($params['anchor_class'])) {
                    $a_class_arr[] = $params['anchor_class'];
                }
                if ($row['page_id'] != 0) {
                    $cpage = $this->core->getPage();
                    if ($cpage && $row['page_id'] == $cpage['page_id']) {
                        $a_class_arr[] = "current";
                    }
                }

                $href = '';
                $additional_attr = '';
                if ($row['is_placeholder'] == 1) {
                    $href = 'javascript:void(0)';
                } elseif ($row['url'] != '') {
                    $href = $row['url'];
                    if ($row['new_window'] == 1) {
                        $additional_attr = ' target="_blank"';
                    }
                } elseif ($row['category_id']) {
                    $href = $this->category_link($row['category_id']);
                } else {
                    if (CMS_USE_PAGE_URI) {
                        $href .= $row['page_uri'];
                    } else {
                        $href .= $row['page_alias'];
                    }
                }

                $base_url = $this->http->baseURL();
                $base_url = str_ireplace(array('http://', 'https://', 'http://www', 'https://www'), '', $base_url);
                $current_url = str_ireplace(array('http://', 'https://', 'http://www', 'https://www'), '', current_url());
                $href_path = str_ireplace($base_url, '', $current_url);

                if (rtrim($href, '/') == rtrim($href_path, '/')) {
                    $a_class_arr[] = "current";
                }

                $a_class = trim(join(' ', $a_class_arr));

                if ($parent_id == 0) {
                    $link = $params['level_1_format'];
                } else {
                    $link = $params['level_2_format'];
                }

                $match = array('{HREF}', '{CLASSES}', '{LINK_NAME}', '{ATTRIBUTES}');
                $replace = array($href, $a_class, $row['menu_item_name'], $additional_attr);
                if ($key == 0) {
                    if (base_url() != base_url(uri_string())) {
                        $menu_class = 'menu-item dropdown';
                    } else {
                        $menu_class = 'menu-item dropdown active-menu';
                    }
                } else {
                    $menu_class = 'menu-item dropdown';
                }
                $classP = "";

                $output .= '<li class="' . $li_class . ' ' . $menu_class . ' ' . $classP . '" style="">';
                $output .= str_replace($match, $replace, $link);
                $output .= "\r\n";
                $output = $this->_menu($params, $row['menu_item_id'], $output);
                // Megamenu html start

                if ($row['category_id']) {
                    $megamenu = parentCategoryMenu($row['category_id'], $row['sub_category']);
                    $megamenuClass = '';
                    count($megamenu) > 10 ? $megamenuClass = "megamenuClass" : $megamenuClass = '';
                    $output .= "<ul class='catmenu-menu " . $megamenuClass . "'>";

                    foreach ($megamenu as $child_cat_menu) {
                        $output .= "<li class='jk'>";
                        $output .= "<a href='{$child_cat_menu['uri']}' class=''>{$child_cat_menu['name']}</a>";
                        $output .= "</li>";
                    }
                    $output .= "</ul>";
                }
                $output .= "</li>\r\n";
                // Megamenu html end
            }
            if ($parent_id > 0) {
                $output .= "</ul>\r\n";
            }
        }

        return $output;
    }

    public function bottom_menus($params)
    {
        if (!isset($params['menu_alias'])) {
            return false;
        }

        $menu = $this->getDetailsByAlias($params['menu_alias']);

        if (!$menu) {
            return false;
        }

        $params['menu_id'] = $menu['menu_id'];

        //Fetch root menu items
        $this->db->from('menu_item');
        $this->db->join('page', 'page.page_id = menu_item.page_id', 'LEFT OUTER');
        $this->db->where('menu_item.parent_id', 0);
        $this->db->where('menu_item.menu_id', $params['menu_id']);
        $this->db->order_by('menu_sort_order', 'ASC');
        $rs = $this->db->get();
        if ($rs->num_rows() == 0) {
            return false;
        }

        $rows = $rs->result_array();

        $params['first_menu_id'] = $rows[0]['menu_item_id'];
        $tmp = array_pop($rows);
        $params['last_menu_id'] = $tmp['menu_item_id'];

        $output = $this->_bottom_menus($params);
        //print_R($output); exit();

        $output = str_replace('{MENU}', $output, $params['ul_format']);
        $output = str_replace('{MENU_TITLE}', $menu['menu_title'] . "&nbsp;", $output);
        return $output;
    }

    public function _bottom_menus($params, $parent_id = 0, $output = '')
    {
        $this->db->from('menu_item');
        $this->db->join('menu', 'menu_item.menu_id = menu.menu_id');
        $this->db->join('page', 'page.page_id = menu_item.page_id', 'LEFT OUTER');
        $this->db->where('menu_item.parent_id', $parent_id);
        $this->db->where('menu_item.menu_id', $params['menu_id']);
        $this->db->order_by('menu_sort_order', 'ASC');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            if ($parent_id == 0) {
                //$output .= '<ul class="'.$params['ul_class'].'">' . "\r\n";
            } else {
                $output .= "<ul>\r\n";
            }

            foreach ($query->result_array() as $row) {
                //li tag class
                $li_class_arr = array();
                $li_class = '';
                if ($row['menu_item_id'] == $params['first_menu_id']) {
                    $li_class_arr[] = "first";
                }
                if ($row['menu_item_id'] == $params['last_menu_id']) {
                    $li_class_arr[] = "last";
                }
                if (isset($params['list_class'])) {
                    $li_class_arr[] = $params['list_class'];
                }
                if ($parent_id == 0) {
                    $li_class_arr[] = "root_menu";
                }
                if ($row['page_id'] != 0) {
                    $cpage = $this->core->getPage();
                    if ($cpage && $row['page_id'] == $cpage['page_id']) {
                        $li_class_arr[] = "current_disable";
                    }
                }
                $li_class = trim(join(' ', $li_class_arr));

                //anchor tag class
                $a_class_arr = array();
                $a_class = '';
                if (isset($params['anchor_class'])) {
                    $a_class_arr[] = $params['anchor_class'];
                }
                if ($row['page_id'] != 0) {
                    $cpage = $this->core->getPage();
                    if ($cpage && $row['page_id'] == $cpage['page_id']) {
                        $a_class_arr[] = "current";
                    }
                }

                $href = '';
                $additional_attr = '';
                if ($row['is_placeholder'] == 1) {
                    $href = 'javascript:void(0)';
                } elseif ($row['url'] != '') {
                    $href = $row['url'];
                    if ($row['new_window'] == 1) {
                        $additional_attr = ' target="_blank"';
                    }
                } else {
                    if (CMS_USE_PAGE_URI) {
                        $href .= $row['page_uri'];
                    } else {
                        $href .= $row['page_alias'];
                    }
                }

                $base_url = $this->http->baseURL();
                $base_url = str_ireplace(array('http://', 'https://', 'http://www', 'https://www'), '', $base_url);
                $current_url = str_ireplace(array('http://', 'https://', 'http://www', 'https://www'), '', current_url());
                $href_path = str_ireplace($base_url, '', $current_url);

                if (rtrim($href, '/') == rtrim($href_path, '/')) {
                    $a_class_arr[] = "current";
                }

                $a_class = trim(join(' ', $a_class_arr));

                if ($parent_id == 0) {
                    $link = $params['level_1_format'];
                } else {
                    $link = $params['level_2_format'];
                }

                $match = array('{HREF}', '{CLASSES}', '{LINK_NAME}', '{ATTRIBUTES}');
                $replace = array($href, $a_class, $row['menu_item_name'], $additional_attr);

                //$output .= '<li class="' . $li_class . '">';
                $output .= str_replace($match, $replace, $link);
                $output .= " | ";

                $output = $this->_bottom_menus($params, $row['menu_item_id'], $output);

                //$output .= "</li>\r\n";
            }

            if ($parent_id > 0) {
                $output .= "</ul> |";
            }
        }

        return $output;
    }

    public function get_megamenu($sub_category)
    {
        if (!$sub_category) {
            return [];
        }
        $explode_sub_cat = explode(',', $sub_category);
        return $this->db->select('t1.id,t1.name,t1.uri')
            ->from('category t1')
            ->where('t1.active', 1)
            ->where_in('t1.id', $explode_sub_cat)
            ->where('t1.show_in_menu', 1)
            ->Limit(8)
            ->get()->result_array();
    }

    function category_link($cat_id)
    {
        $data = $this->db->select('uri')
            ->from('category')
            ->where('id', $cat_id)
            ->get()->row_array();
        return $data['uri'];
    }
}
