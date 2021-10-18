<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

if (!function_exists('cms_meta_tags')) {

    function cms_meta_tags()
    {
        $CI = &get_instance();
        return $CI->getMeta();
    }

    function cms_head()
    {
        $CI = &get_instance();
        return $CI->loadHead();
    }

    function cms_footer()
    {
        $CI = &get_instance();
        return $CI->loadFooter();
    }

    function cms_css()
    {
        $CI = &get_instance();
        return $CI->getCSS();
    }

    function cms_js()
    {
        $CI = &get_instance();
        return $CI->getJS();
    }

    function cms_base_url()
    {
        $CI = &get_instance();
        return $CI->baseURL();
    }

    function cms_base_url_nossl()
    {
        $CI = &get_instance();
        return $CI->baseURLNoSSL();
    }

    function cms_base_url_ssl()
    {
        $CI = &get_instance();
        return $CI->baseURLSSL();
    }

    function getCountries()
    {
        $CI = &get_instance();
        return $CI->db->get('country')->result_array();
    }

    function e($str, $flag = 0)
    {
        echo '<pre>';
        print_r($str);

        if (!$flag) {
            exit;
        }
    }

    function categories()
    {
        $CI = &get_instance();
        return $CI->db->select('id,name,uri')
            ->from('category')
            ->where('parent_id', 0)
            ->get()->result_array();
    }

    function cat_child($id)
    {
        $CI = &get_instance();
        return $CI->db->select('id,name,uri')
            ->from('category')
            ->where('parent_id', $id)
            ->get()->result_array();
    }

    function all_brands()
    {
        $CI = &get_instance();
        $attr_id = $CI->db->select('id')
            ->from('attribute')
            ->where('code', DWS_BRANDS)
            ->get()->row_array();
        if ($attr_id) {
            $brands_attr = $CI->db->select('attribute_option.*,page.page_uri,page.title')
                ->from('attribute_option')
                ->join('page', 'page.brand_id=attribute_option.id', 'left')
                ->where_in('attr_id', $attr_id)
                ->get()->result_array();
            return $brands_attr;
        } else {
            return [];
        }
    }

    function if_checked_cat_id($cat_id, $user_id)
    {
        $CI = &get_instance();
        return $CI->db->select('cat_id,category_discount,user_id')
            ->from('category_price_list')
            ->where('cat_id', $cat_id)
            ->where('user_id', $user_id)
            ->get()->row_array();
    }

    function countryes()
    {
        $CI = &get_instance();
        return $CI->db->select('id,name,phonecode')
            ->from('country')
            ->get()->result_array();
    }

    function exist_customer_table($user_id)
    {
        if (!$user_id) {
            return [];
        }
        $CI = &get_instance();
        return $CI->db->select('company_email')
            ->from('customer')
            ->where('user_id', $user_id)
            ->get()->row_array();
    }

    function is_passwd_exists($user_id)
    {
        if (!$user_id) {
            return [];
        }
        $CI = &get_instance();
        return $CI->db->select('passwd')
            ->from('user')
            ->where('user_id', $user_id)
            ->get()->row_array();
    }

    function get_prod_img($pid)
    {
        $CI = &get_instance();
        return $CI->db->select('img,imgalt')
            ->from('prod_img')
            ->where('pid', $pid)
            ->where('main', 1)
            ->get()->row_array();
    }

    function get_customer_group()
    {
        $CI = &get_instance();
        return $CI->db->select('*')
            ->from('customer_group')
            ->get()->result_array();
    }

    function customer_group_name($group_id)
    {
        $CI = &get_instance();
        $data = $CI->db->select('group')
            ->from('customer_group')
            ->where('id', $group_id)
            ->get()->row_array();
        return $data['group'];
    }

    function product_quantity_group_by_group_id($pid)
    {
        $CI = &get_instance();
        return $CI->db->select('*')
            ->from('quantity_range')
            ->where('pid', $pid)
            ->group_by('group_id')
            ->get()->result_array();
    }

    function quantity_range_value_by_group($pid, $group_id)
    {
        $CI = &get_instance();
        return $CI->db->select('*')
            ->from('quantity_range')
            ->where('pid', $pid)
            ->where('group_id', $group_id)
            ->get()->result_array();
    }

    function jquery_array($pid)
    {
        $return = array();
        $qty = array();
        $CI = &get_instance();
        $group_id = $CI->db->select('*')
            ->from('quantity_range')
            ->where('pid', $pid)
            ->group_by('group_id')
            ->get()->result_array();
        foreach ($group_id as $ids) {
            $qty_rate = $CI->db->select('*')
                ->from('quantity_range')
                ->where('pid', $pid)
                ->where('group_id', $ids['group_id'])
                ->get()->result_array();
            foreach ($qty_rate as $rate) {
                if ($rate['qty_from'] && $rate['qty_to']) {
                    $qty[str_replace(' ', '', $rate['qty_from'] . '-' . $rate['qty_to'])] = $rate['qty_range_val'];
                } else {
                    $qty[str_replace(' ', '', $rate['qty_from'])] = $rate['qty_range_val'];
                }
            }
            $return[$ids['group_id']] = $qty;
        }
        if (!empty($return)) {
            return $return;
        } else {
            return false;
        }
    }

    function menu_sub_categories($sub_cat_ids)
    {
        if (!$sub_cat_ids) {
            return [];
        }
        $explode = explode(',', $sub_cat_ids);
        $array = implode("','",$explode);
        $CI = &get_instance();

        return $CI->db->select('id,name,uri')
            ->from('category')
            ->where("id IN ('$array') ORDER BY FIELD(id, '$array')")
            ->get()->result_array();
    }

    function product_details_fields_by_id($pid, $field_name)
    {
        $CI = &get_instance();

        $data = $CI->db->select($field_name)
            ->from('product')
            ->where('id', $pid)
            ->get()->row_array();

        return $data[$field_name];
    }

    function onpageloadCheck($pid)
    {
        $CI = &get_instance();

        $CI->db->where('page_id', $pid);
        $CI->db->where('is_publish', 0);
        $CI->db->delete('pagebuilder_page_rows');

        $CI->db->where('page_id', $pid);
        $CI->db->where('is_publish', 0);
        $CI->db->delete('pagebuilder_columns');
    }

    function getAllsliders()
    {
        $CI = &get_instance();
        $query = $CI->db->where('active',1)->get('slideshow');
        return $query->result_array();
    }
    function getAllForms()
    {
        $CI = &get_instance();
        $query = $CI->db->get('forms');
        return $query->result_array();
    }

    function getSideMenuById($sideMenuID){
        $CI = &get_instance();
        $query = $CI->db->where('menu_id',$sideMenuID)->get('sidebar_menu');
        return $query->row_array();
    }

    function cms_sidebar_menu($params) {
        $CI = &get_instance();
        return menuSidebar($params);
    }

    function getSidebarDetailsByAlias($alias) {
        $CI = &get_instance();
        $CI->db->where('menu_alias', $alias);
        $rs = $CI->db->get('sidebar_menu');
        if ($rs->num_rows() == 1) {
            return $rs->row_array();
        }
        return false;
    }

    function category_link($cat_id) {
        $CI = &get_instance();
        $data = $CI->db->select('uri')
                        ->from('category')
                        ->where('id', $cat_id)
                        ->get()->row_array();
        return $data['uri'];
    }

    function parentCategoryMenu($parent_id, $cat_ids)
    {
        $cat_ids_arr = explode(',', $cat_ids);
        $CI = &get_instance();
        $CI->db->where('parent_id', $parent_id);
        $CI->db->where_in('id', $cat_ids_arr);
        $CI->db->where('active', 1);
        $CI->db->order_by('sort_order', 'ASC');
        $rs = $CI->db->get('category');
        return $rs->result_array();
    }

    function _sidebar_menu($params, $parent_id = 0, $output = '') {
        $CI = &get_instance();
        $CI->db->from('sidebar_menu_item');
        $CI->db->join('sidebar_menu', 'sidebar_menu_item.menu_id = sidebar_menu.menu_id');
        $CI->db->join('page', 'page.page_id = sidebar_menu_item.page_id', 'LEFT OUTER');
        $CI->db->where('sidebar_menu_item.parent_id', $parent_id);
        $CI->db->where('sidebar_menu_item.menu_id', $params['menu_id']);
        $CI->db->order_by('menu_sort_order', 'ASC');
        $query = $CI->db->get();

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
                    // $cpage = $CI->core->getPage();
                    $cpage = [];
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
                    // $cpage = $CI->core->getPage();
                    $cpage = [];
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
                    $href = category_link($row['category_id']);
                } else {
                    if (CMS_USE_PAGE_URI) {
                        $href .= $row['page_uri'];
                    } else {
                        $href .= $row['page_alias'];
                    }
                }

                // $base_url = $CI->http->baseURL();
                $base_url = site_url();
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
                // if ($row['menu_item_name'] == 'Product Range') {
                //     $classP = "hovermenu";
                // }
                $output .= '<li class="' . $li_class . ' ' . $menu_class .' '. $classP. '" style="background-color:#' . $row['menu_item_color'] . '">';
                $output .= str_replace($match, $replace, $link);
                $output .= "\r\n";
                $output = _sidebar_menu($params, $row['menu_item_id'], $output);
                // Megamenu html start
                
                if ($row['category_id']) {
                    $output .= "<ul class=' catmenu-menu'>";
                    $megamenu = parentCategoryMenu($row['category_id'],$row['sub_category']);
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

    function menuSidebar($params) {
        $CI = &get_instance();
        if (!isset($params['menu_alias'])) {
            return false;
        }

        $menu = getSidebarDetailsByAlias($params['menu_alias']);

        if (!$menu) {
            return false;
        }

        $params['menu_id'] = $menu['menu_id'];

        //Fetch root menu items
        $CI->db->from('sidebar_menu_item');
        $CI->db->join('page', 'page.page_id = sidebar_menu_item.page_id', 'LEFT OUTER');
        $CI->db->where('sidebar_menu_item.parent_id', 0);
        $CI->db->where('sidebar_menu_item.menu_id', $params['menu_id']);
        $CI->db->order_by('menu_sort_order', 'ASC');
        $rs = $CI->db->get();
        if ($rs->num_rows() == 0) {
            return false;
        }

        $rows = $rs->result_array();

        $params['first_menu_id'] = $rows[0]['menu_item_id'];
        $tmp = array_pop($rows);
        $params['last_menu_id'] = $tmp['menu_item_id'];

        $output = _sidebar_menu($params);

        $output = str_replace('{MENU}', $output, $params['ul_format']);
        $output = str_replace('{MENU_TITLE}', $menu['menu_title'] . "&nbsp;", $output);
        return $output;
    }

    function getPageFormById($form_id){
        $data = [];
        $CI = &get_instance();
        $CI->db->select('t1.*');
        $CI->db->from('forms t1');
        $CI->db->where('t1.id', $form_id);
        $data['form'] = $CI->db->get()->row_array();
    
        $CI->db->select('t1.*');
        $CI->db->from('form_field_assignment t1');
        $CI->db->where('t1.form_id', $form_id);
        $CI->db->order_by('sort_order', 'ASC');
        $data['form']['fields'] = $CI->db->get()->result_array();
        return $data;
    }
}

/* End of file cms_helper.php */
/* Location: ./system/helpers/number_helper.php */
