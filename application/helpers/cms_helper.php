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

    function cms_browser_title()
    {
        $CI = &get_instance();
        //return $CI->getBrowserTitle();
    }

    function cms_meta_description()
    {
        $CI = &get_instance();
        //return $CI->getMetaDescription();
    }

    function cms_meta_keywords()
    {
        $CI = &get_instance();
        //return $CI->getMetaKeywords();
    }

    function cms_before_head_close()
    {
        $CI = &get_instance();

        return $CI->getBeforeHeadClose();
    }

    function cms_before_body_close()
    {
        $CI = &get_instance();

        return $CI->getBeforeBodyClose();
    }

    function cms_head()
    {
        $CI = &get_instance();

        return $CI->loadHeaders();
    }

    function cms_css($css = false)
    {
        $CI = &get_instance();

        return $CI->getCSS();
    }

    function cms_js($js = false)
    {
        $CI = &get_instance();

        return $CI->getJS($js);
    }

    function cms_base_url()
    {
        $CI = &get_instance();

        return $CI->baseURL();
    }

    function cms_base_url_ssl()
    {
        $CI = &get_instance();

        return $CI->baseURLSSL();
    }

    function cms_base_url_nossl()
    {
        $CI = &get_instance();

        return $CI->baseURLNoSSL();
    }

    function cms_footer()
    {
        $CI = &get_instance();

        return $CI->footer();
    }

    function cms_menu($params)
    {
        $CI = &get_instance();
        //return false;
        return $CI->menu($params);
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

    function home_blogs()
    {
        $CI = &get_instance();
        return $CI->db->select('*')
            ->from('blog')
            ->limit(2)
            ->order_by('blog_id', 'desc')
            ->get()->result_array();
    }

    function child_cat($child_cat_id)
    {
        $CI = &get_instance();
        $menu_child = $CI->db->select('t1.id as id, t1.name as name, t1.uri as uri')
            ->from('category t1')
            ->join('cat_prod t2', 't2.cid=t1.id')
            ->where('t1.parent_id', $child_cat_id)
            ->where('t1.active', 1)
            ->where('t1.show_in_menu', 1)
            ->order_by("t1.id", 'asc')
            ->group_by('t2.cid')
            ->get()->result_array();
        return $menu_child;
    }

    function level_two($cids)
    {
        $CI = &get_instance();
        $menu_child = $CI->db->select('id, name, uri')
            ->from('category')
            ->where_in('parent_id', $cids)
            ->where('active', 1)
            ->where('show_in_menu', 1)
            ->order_by("id", 'desc')
            ->get()->result_array();
        return $menu_child;
    }

    function top_rated_products()
    {
        $CI = &get_instance();
        $user_id = $CI->session->userdata('CUSTOMER_ID');
        if ($user_id) {
            $CI->db->select('distinct t1.id, t1.name,t1.sku,t1.uri,t1.price,t1.is_new,t2.*,t1.type, t1.inc_or_exl_tax, t1.quantity, t3.discount, t3.special_price,t1.srp_price,t1.description,t1.is_offer,t1.is_offer_discount, t1.id as product_id', false);
        } else {
            $CI->db->select('distinct t1.id,t1.name,t1.sku,t1.uri,t1.price,t1.is_new,t2.*,t1.type, t1.quantity, t1.inc_or_exl_tax,t1.srp_price,t1.description,t1.is_offer,t1.is_offer_discount, t1.id as product_id', false);
        }
        $dbprefix = $CI->db->dbprefix;
        $subquery = "(select price from " . $dbprefix . "product where id in (
        select child_id from " . $dbprefix . "product_configurable_link where parent_id = t1.id
        ) order by price limit 1) as least_price";
        $CI->db->select($subquery, false);

        $subwherequery = "IF(t1.type='config',(select quantity from " . $dbprefix . "product where id in (
        select child_id from " . $dbprefix . "product_configurable_link where parent_id = t1.id
        ) ORDER BY quantity DESC limit 1),t1.quantity) as heighest_qty";
        $CI->db->select($subwherequery, false);

        $CI->db->from('product t1');
        //$this->db->join('prod_img t2', 't1.id = t2.pid', 'left');
        $CI->db->join('prod_img t2', 't1.id = t2.pid AND t2.main = 1', 'left');
        if ($user_id) {
            $CI->db->join('product_assignment t3', "t3.product_id = t1.id AND t3.user_id = $user_id", 'left');
        }
        $CI->db->join('review t4', 't4.product_id=t1.id');
        $qu = "t4.rate > 3 AND t1.id NOT IN (select pf.child_id from br_product_configurable_link as pf)";
        $CI->db->where($qu);
        $CI->db->where('t1.is_active = 1');
        $CI->db->limit(50);
        $CI->db->group_by('t4.product_id');
        if (DWS_SHOW_OUT_STOCK != 1) {
            $CI->db->having('heighest_qty >', 0);
        }
        $rs = $CI->db->get();
        //         die($this->db->last_query());
        if ($rs->num_rows() > 0) {
            return $rs->result_array();
        } else {
            return false;
        }
    }

    function check_pro_wishlist($pid, $CUSTOMER_ID)
    {
        $CI = &get_instance();
        return $CI->db->select('*')
            ->from('wishlist')
            ->where('product_id', $pid)
            ->where('customer_id', $CUSTOMER_ID)
            ->get()->result_array();
    }

    function getCurUserDiscountConfig()
    {
        $CI = &get_instance();
        $customer_id = $CI->session->userdata('CUSTOMER_ID');
        return $CI->db->from('customer')
            ->where('user_id', $customer_id)
            ->get()->row_array();
    }

    function img_in_wishlist($pid)
    {
        $CI = &get_instance();
        return $CI->db->select('img')
            ->from('wishlist')
            ->where('product_id', $pid)
            ->get()->row_array();
    }

    function customer($customer)
    {
        $CI = &get_instance();
        return $CI->db->select('cash_credit')
            ->from('customer')
            ->where('user_id', $customer['user_id'])
            ->get()->row_array();
    }

    function check_page_exists_in_brands($url)
    {
        $CI = &get_instance();
        $data = $CI->db->select('brand_id as attribute_option_id')
            ->from('page')
            ->where('page_uri', $url)
            ->get()->row_array();
        if ($data['attribute_option_id']) {
            return $data;
        } else {
            return [];
        }
    }

    function product_pack($pid)
    {
        if (!$pid) {
            return [];
        }
        $CI = &get_instance();
        $parent_id = $CI->db->select('parent_id')
            ->from('product_configurable_link')
            ->where('child_id', $pid)
            ->get()->row_array();
        if ($parent_id) {
            $quantity_per_pack = $CI->db->select('quantity_per_pack,id')
                ->from('product')
                ->where('id', $parent_id['parent_id'])
                ->get()->row_array();
            return $quantity_per_pack;
        } else {
            $standard_per_pack = $CI->db->select('quantity_per_pack,id')
                ->from('product')
                ->where('id', $pid)
                ->get()->row_array();
            return $standard_per_pack;
        }
    }

    function set_role_id_session($user_id)
    {
        if (!$user_id) {
            return [];
        }
        $CI = &get_instance();
        return $CI->db->select('role_id')
            ->from('user')
            ->where('user_id', $user_id)
            ->get()->row_array();
    }

    function get_parent_child_price($id)
    {
        if (!$id) {
            return [];
        }
        $CI = &get_instance();
        return $CI->db->select('price')
            ->from('product')
            ->where('id', $id)
            ->get()->row_array();
    }

    function parent_category()
    {
        $CI = &get_instance();
        return $CI->db->select('t1.id, t1.name, t1.uri')
            ->from('category t1')
            ->join('cat_prod t2', 't2.cid=t1.id')
            ->where('t1.parent_id', 0)
            ->group_by('t2.cid')
            ->get()->result_array();
    }

    function group_by_prices($pid, $group_id)
    {
        $CI = &get_instance();
        $result = $CI->db->select('*')
            ->from('quantity_range')
            ->where('pid', $pid)
            ->where('group_id', $group_id)
            ->get()->result_array();
        return $result;
    }

    function user_group_id($user_id)
    {
        if (!$user_id) {
            return [];
        }
        $CI = &get_instance();
        $data = $CI->db->select('customer_group')
            ->from('user')
            ->where('user_id', $user_id)
            ->get()->row_array();
        return $data['customer_group'];
    }

    function last_group_value($qty, $pid, $grp_id)
    {
        $CI = &get_instance();
        $data = $CI->db->select('*')
            ->from('quantity_range')
            ->where('qty_from >', $qty)
            ->where('pid', $pid)
            ->where('group_id', $grp_id)
            ->get()->row_array();
        if ($data['qty_from'] && empty($data['qty_to'])) {
            $result = $CI->db->select('*')
                ->from('quantity_range')
                ->where('qty_from <', $data['qty_from'])
                ->where('pid', $pid)
                ->where('group_id', $grp_id)
                ->order_by('id', 'desc')
                ->get()->row_array();
            return $result;
        } else {
            return [];
        }
    }

    function display_group_prices_acc_to_category($user_id, $pid)
    {
        $CI = &get_instance();
        $category_price_list = $CI->db->select('cat_id')
            ->from('category_price_list')
            ->where('user_id', $user_id)
            ->get()->result_array();
        if ($category_price_list) {
            $array_cid = array_column($category_price_list, 'cat_id');
            $cat_pids = $CI->db->select('pid')
                ->from('cat_prod')
                ->where_in('cid', $array_cid)
                ->group_by('pid')
                ->get()->result_array();
            if ($cat_pids) {
                $array_pids = array_column($cat_pids, 'pid');
                if (in_array($pid, $array_pids)) {
                    return 1;
                } else {
                    return 0;
                }
            } else {
                return 0;
            }
        } else {
            return [];
        }
    }

    function check_ooffer($pid)
    {
        $CI = &get_instance();
        $data = $CI->db->select('is_offer_discount')
            ->from('product')
            ->where('id', $pid)
            ->get()->row_array();
        return $data['is_offer_discount'];
    }

    function offer_and_latest_and_new_products($type)
    {
        $CI = &get_instance();
        $user_id = $CI->session->userdata('CUSTOMER_ID');
        if ($user_id) {
            $CI->db->select('distinct t1.id, t1.name,t1.sku,t1.uri,t1.price,t1.is_new,t1.is_taxable,t2.*,t1.type, t1.inc_or_exl_tax, t1.quantity, t3.discount, t3.special_price,t1.srp_price,t1.description,t1.is_offer,t1.is_offer_discount,t1.brief_description, t1.id as product_id, t1.product_stock_status', false);
        } else {
            $CI->db->select('distinct t1.id,t1.name,t1.sku,t1.uri,t1.price,t1.is_new,t1.is_taxable,t2.*,t1.type, t1.quantity, t1.inc_or_exl_tax,t1.srp_price,t1.description,t1.is_offer,t1.is_offer_discount,t1.brief_description, t1.id as product_id, t1.product_stock_status', false);
        }
        $dbprefix = $CI->db->dbprefix;
        $subquery = "(select price from " . $dbprefix . "product where id in (
        select child_id from " . $dbprefix . "product_configurable_link where parent_id = t1.id
        ) order by price limit 1) as least_price";
        $CI->db->select($subquery, false);

        $subwherequery = "IF(t1.type='config',(select quantity from " . $dbprefix . "product where id in (
        select child_id from " . $dbprefix . "product_configurable_link where parent_id = t1.id
        ) ORDER BY quantity DESC limit 1),t1.quantity) as heighest_qty";
        $CI->db->select($subwherequery, false);

        $CI->db->from('product t1');
        $CI->db->join('prod_img t2', 't1.id = t2.pid AND t2.main = 1', 'left');
        if ($user_id) {
            $CI->db->join('product_assignment t3', "t3.product_id = t1.id AND t3.user_id = $user_id", 'left');
        }
        if ($type == 'new') {
            $qu = "t1.is_new = 1 AND t1.id NOT IN (select pf.child_id from br_product_configurable_link as pf)";
        } elseif ($type == 'offer') {
            $qu = "t1.is_offer = 1 AND t1.id NOT IN (select pf.child_id from br_product_configurable_link as pf)";
        } elseif ($type == 'featured') {
            $qu = "t1.is_featured = 1 AND t1.id NOT IN (select pf.child_id from br_product_configurable_link as pf)";
        } else {
            $qu = "t1.id NOT IN (select pf.child_id from br_product_configurable_link as pf)";
        }
        $CI->db->where($qu);
        $CI->db->where('t1.is_active = 1');
        $CI->db->order_by('t1.prd_sort_order', 'ASC');
        if ($type == 'latest') {
            $CI->db->limit(12);
        } else {
            $CI->db->limit(12);
        }
        if ($type != 'offer') {
            $CI->db->order_by('t1.id', 'desc');
        }
        if (DWS_SHOW_OUT_STOCK != 1) {
            $CI->db->having('heighest_qty >', 0);
        }
        $rs = $CI->db->get();
        if ($rs->num_rows() > 0) {
            return $rs->result_array();
        } else {
            return false;
        }
    }

    function featured_category()
    {
        $data = array();
        $CI = &get_instance();
        $category = $CI->db->select('t1.id,t1.name,t1.uri,t1.image,t1.image_alt')
            ->from('category t1')
            ->join('cat_prod t2', 't2.cid=t1.id')
            ->where('t1.parent_id', 0)
            ->where('t1.featured', 1)
            ->order_by('t1.id', 'desc')
            ->get()->row_array();
        if ($category) {
            $qu = "cat_prod.pid NOT IN (select pf.child_id from br_product_configurable_link as pf)";
            $data['category'] = $category;
            $pids = $CI->db->select('pid')
                ->from('cat_prod')
                ->where('cid', $category['id'])
                ->where($qu)
                ->limit(2)
                ->get()->result_array();
            if ($pids) {
                $array_column = array_column($pids, 'pid');
                $cat_products = products_by_id($array_column);
                $data['product'] = $cat_products;
            } else {
                $data['product'] = '';
            }
        } else {
            $data['category'] = '';
            $data['product'] = '';
        }
        return $data;
    }

    function products_by_id($pids)
    {
        $CI = &get_instance();
        $user_id = $CI->session->userdata('CUSTOMER_ID');
        if ($user_id) {
            $CI->db->select('distinct t1.id, t1.name,t1.sku,t1.uri,t1.price,t1.is_new,t2.*,t1.type, t1.inc_or_exl_tax, t1.quantity, t3.discount, t3.special_price,t1.srp_price,t1.description,t1.is_offer,t1.is_offer_discount,t1.brief_description, t1.id as product_id', false);
        } else {
            $CI->db->select('distinct t1.id,t1.name,t1.sku,t1.uri,t1.price,t1.is_new,t2.*,t1.type, t1.quantity, t1.inc_or_exl_tax,t1.srp_price,t1.description,t1.is_offer,t1.is_offer_discount,t1.brief_description, t1.id as product_id', false);
        }
        $dbprefix = $CI->db->dbprefix;
        $subquery = "(select price from " . $dbprefix . "product where id in (
        select child_id from " . $dbprefix . "product_configurable_link where parent_id = t1.id
        ) order by price limit 1) as least_price";
        $CI->db->select($subquery, false);

        $subwherequery = "IF(t1.type='config',(select quantity from " . $dbprefix . "product where id in (
        select child_id from " . $dbprefix . "product_configurable_link where parent_id = t1.id
        ) ORDER BY quantity DESC limit 1),t1.quantity) as heighest_qty";
        $CI->db->select($subwherequery, false);

        $CI->db->from('product t1');
        $CI->db->join('prod_img t2', 't1.id = t2.pid AND t2.main = 1', 'left');
        if ($user_id) {
            $CI->db->join('product_assignment t3', "t3.product_id = t1.id AND t3.user_id = $user_id", 'left');
        }
        $qu = "t1.id NOT IN (select pf.child_id from br_product_configurable_link as pf)";
        $CI->db->where($qu);
        $CI->db->where('t1.is_active = 1');
        $CI->db->where_in('t1.id', $pids);
        $CI->db->limit(50);
        if (DWS_SHOW_OUT_STOCK != 1) {
            $CI->db->having('heighest_qty >', 0);
        }
        $rs = $CI->db->get();
        if ($rs->num_rows() > 0) {
            return $rs->result_array();
        } else {
            return false;
        }
    }

    function brands()
    {
        $CI = &get_instance();
        return $CI->db->select('*')
            ->from('brand')
            ->where('active', 1)
            ->order_by('id', 'desc')
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

    function OptionLable($pid)
    {
        $CI = &get_instance();

        $data = $CI->db->select('*')
            ->from('attribute')
            ->where('id', $pid)
            ->get()->row_array();

        return $data;
    }
    function Distributerdistance($lat1, $lon1, $lat2, $lon2, $unit)
    {

        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
        } else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);

            if ($unit == "K") {
                return ($miles * 1.609344);
            } else if ($unit == "N") {
                return ($miles * 0.8684);
            } else {
                return $miles;
            }
        }
    }

    function GetAllTestimonials()
    {
        $CI = &get_instance();

        $data = $CI->db->select('*')
            ->from('testimonial')
            ->where('active', 1)
            ->get()->result_array();

        return $data;
    }

    function header_and_footer()
    {
        $CI = &get_instance();

        $data = $CI->db->select('*')
            ->from('header_and_footer')
            ->get()->row_array();

        return $data;
    }

    function createElementHtml1($page_id, $row_id, $element_id, $content)
    {
        $CI = &get_instance();
        $content = json_decode($content, true);
        $element_template = $CI->db->select('element_template')->where('id', $element_id)->get('pagebuilder_elements')->row_array();
        $columnData = $CI->db->select('id')->where('page_id', $page_id)->where('row_id', $row_id)->where('element_id', $element_id)->get('pagebuilder_columns')->row_array();

        $filename = "page_block_{$columnData['id']}.php";

        $contentArr = [];
        foreach ($content as $key => $value) {
            $contentArr[$key] = $value;
        }
        $inner['block'] = $contentArr;
        $view = $CI->load->view("themes/" . THEME . "/compiled/page_blocks/$filename", $inner);
        return $view;
    }

    function getSidebarDetailsByAlias($alias)
    {
        $CI = &get_instance();
        $CI->db->where('menu_alias', $alias);
        $rs = $CI->db->get('sidebar_menu');
        if ($rs->num_rows() == 1) {
            return $rs->row_array();
        }
        return false;
    }

    function category_link($cat_id)
    {
        $CI = &get_instance();
        $data = $CI->db->select('uri')
            ->from('category')
            ->where('id', $cat_id)
            ->get()->row_array();
        return $data['uri'];
    }

    function _sidebar_menu($params, $parent_id = 0, $output = '')
    {
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
                    $cpage = $CI->core->getPage();
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
                    $cpage = $CI->core->getPage();
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

                $base_url = $CI->http->baseURL();
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
                $output .= '<li class="' . $li_class . ' ' . $menu_class . ' ' . $classP . '" style="background-color:#' . $row['menu_item_color'] . '">';
                $output .= str_replace($match, $replace, $link);
                $output .= "\r\n";
                $output = _sidebar_menu($params, $row['menu_item_id'], $output);
                // Megamenu html start

                if ($row['category_id']) {
                    $output .= "<ul class=' catmenu-menu'>";
                    $megamenu = parentCategoryMenu($row['category_id'], $row['sub_category']);
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

    function menuSidebar($params)
    {
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

    function getSideMenuById($sideMenuID)
    {
        $CI = &get_instance();
        $query = $CI->db->where('menu_id', $sideMenuID)->get('sidebar_menu');
        return $query->row_array();
    }
    function custom_array_coloum($array, $key, $value, $default =''){
        if($default): @array_unshift($array, array($key =>'', $value => $default)); endif;
        return @array_combine(array_column($array,$key), array_column( $array,$value));
    }
}

/* End of file cms_helper.php */
/* Location: ./system/helpers/number_helper.php */
