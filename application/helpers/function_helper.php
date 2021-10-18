<?php

function e($str, $exit = true)
{
    echo "<pre>";
    print_r($str);

    if ($exit)
        exit;
}

function createUrl($url)
{
    return base_url() . $url;
}

function latestBlog($limit = FALSE)
{
    $CI = &get_instance();
    if ($limit) {
        $CI->db->limit($limit);
    }
    $rs = $CI->db->get('blog');
    return $rs->result_array();
}

function allBrands($limit = FALSE)
{
    $CI = &get_instance();
    if ($limit) {
        $CI->db->limit($limit);
    }
    $rs = $CI->db->get('brand');
    return $rs->result_array();
}

function getAllReviews($limit = FALSE)
{
    $CI = &get_instance();
    if ($limit) {
        $CI->db->limit($limit);
    }
    $CI->db->select('name, summery, review, rate, addedon');
    $CI->db->where('status', 1);
    return $CI->db->get('review')->result_array();
}

function getReviews($pid)
{
    $CI = &get_instance();
    $CI->db->select('name, summery, review, rate, addedon');
    $CI->db->where('product_id', $pid);
    $CI->db->where('status', 1);
    return $CI->db->get('review')->result_array();
}

function getRelatedProduct($pid)
{
    $CI = &get_instance();
    $CI->db->select('cid');
    $CI->db->where('pid', $pid);
    $rs = $CI->db->get('cat_prod');
    if ($rs->num_rows() == 1) {
        $result = $rs->row_array();
        $user_id = $CI->session->userdata('CUSTOMER_ID');
        if ($user_id) {
            $CI->db->select('product.*, prod_img.img, prod_img.imgalt,product_assignment.discount, product_assignment.special_price');
        } else {
            $CI->db->select('product.*, prod_img.img, prod_img.imgalt');
        }
        $CI->db->from('product');
        $CI->db->join('cat_prod', 'product.id = cat_prod.pid AND br_cat_prod.pid !=' . $pid);
        $CI->db->join('prod_img', 'product.id = prod_img.pid AND br_prod_img.main = 1', 'left');
        if ($user_id) {
            $CI->db->join('product_assignment', "product_assignment.product_id = product.id AND br_product_assignment.user_id = $user_id", 'left');
        }
        $CI->db->where('cat_prod.cid', $result['cid']);
        $CI->db->order_by('product.id', 'RANDOM');

        $CI->db->limit('10');

        $qu = "product.id NOT IN (select pf.child_id from br_product_configurable_link as pf)";
        $CI->db->where($qu);
        $rs1 = $CI->db->get();
        //        echo $CI->db->last_query(); exit();
        return $rs1->result_array();
    }
}

function checkReviewedUser($userid, $productid)
{
    $CI = &get_instance();
    $CI->db->where('user_id', $userid);
    $CI->db->where('product_id', $productid);
    $res = $CI->db->get('review');
    if ($res->num_rows() > 0) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function isLogged()
{
    $CI = &get_instance();
    $user_id = $CI->session->userdata('CUSTOMER_ID');
    if (intval($user_id)) {
        return true;
    } else {
        return false;
    }
}

function unique_multidim_array($array, $key)
{
    $temp_array = array();
    $i = 0;
    $key_array = array();

    foreach ($array as $val) {
        if (!in_array($val[$key], $key_array)) {
            $key_array[$i] = $val[$key];
            $temp_array[$i] = $val;
        }
        $i++;
    }
    return $temp_array;
}

function getEmailTemplate($alias = FALSE)
{
    $CI = &get_instance();
    $CI->db->where('template_alias', $alias);
    $res = $CI->db->get('email_templates');
    if ($res->num_rows() == 1) {
        return $res->row_array();
    } else {
        return FALSE;
    }
}

function parentMenu()
{
    $CI = &get_instance();
    $CI->db->where('parent_id', 0);
    $CI->db->where('active', 1);
    $rs = $CI->db->get('category');
    return $rs->result_array();
}
function parentCategoryMenu($parent_id, $cat_ids)
{

    $cat_ids_arr = explode(',', $cat_ids);
    $CI = &get_instance();
    $data = [];
    foreach ($cat_ids_arr as $item) {
        $CI->db->where('parent_id', $parent_id);
        $CI->db->where('id', $item);
        $CI->db->where('active', 1);
        $rs = $CI->db->get('category')->row_array();
        array_push($data, $rs);
    }
    return $data;
}
function getThis()
{
    $CI = &get_instance();
    return $CI;
}

function lQ($exit = true)
{
    e(getThis()->db->last_query(), $exit);
}

function findCombinations($test)
{
    $combination = [];
    if (count($test) == 1) {
        foreach ($test as $k1 => $v1) {
            foreach ($v1 as $v1) {
                $tmp = [];
                $tmp[$k1] = $v1;
                $combination[] = $tmp;
            }
        }
    } elseif (count($test) == 2) {
        $first = array_slice($test, 0, 1, true);
        $second = array_slice($test, 1, 2, true);
        foreach ($first as $k1 => $v1) {
            foreach ($v1 as $v1) {
                foreach ($second as $k2 => $v2) {
                    foreach ($v2 as $v2) {
                        $tmp = [
                            $k1 => $v1,
                            $k2 => $v2
                        ];
                        $combination[] = $tmp;
                    }
                }
            }
        }
    } elseif (count($test) == 3) {
        $first = array_slice($test, 0, 1, true);
        $second = array_slice($test, 1, 2, true);
        $third = array_slice($test, 2, 3, true);
        foreach ($first as $k1 => $v1) {
            foreach ($v1 as $v1) {
                foreach ($second as $k2 => $v2) {
                    foreach ($v2 as $v2) {
                        foreach ($third as $k3 => $v3) {
                            foreach ($v3 as $v3) {
                                $tmp = [
                                    $k1 => $v1,
                                    $k2 => $v2,
                                    $k3 => $v3,
                                ];
                                if (count($tmp) == 3) {
                                    $combination[] = $tmp;
                                }
                            }
                        }
                    }
                }
            }
        }
    } elseif (count($test) == 4) {
        $first = array_slice($test, 0, 1, true);
        $second = array_slice($test, 1, 2, true);
        $third = array_slice($test, 2, 3, true);
        $fourth = array_slice($test, 3, 4, true);
        foreach ($first as $k1 => $v1) {
            foreach ($v1 as $v1) {
                foreach ($second as $k2 => $v2) {
                    foreach ($v2 as $v2) {
                        foreach ($third as $k3 => $v3) {
                            foreach ($v3 as $v3) {
                                foreach ($fourth as $k4 => $v4) {
                                    foreach ($v4 as $v4) {
                                        $tmp = [
                                            $k1 => $v1,
                                            $k2 => $v2,
                                            $k3 => $v3,
                                            $k4 => $v4,
                                        ];
                                        if (count($tmp) == 4) {
                                            $combination[] = $tmp;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    return $combination;
}

function breadcrumbs()
{
    $str = '';
    $ci = &get_instance();

    // $target = str_replace('/', '', $ci->uri->uri_string());

    $target = $ci->uri->uri_string();

    $product = fetchProductAlias($target);
    if ($product) {
        productBredcrumbs($product);
        return;
    }
    e($product);

    $sql = "SELECT id, parent_id, name, uri FROM br_category WHERE uri = '$target'";
    $rs = $ci->db->query($sql);

    if ($rs->num_rows() == 1) {
        $r = $rs->first_row('array');
        $link = str_replace(':', '/', $r['uri']);
        $str = "<li>" . $r['name'] . "</li>";
        $parent_id = $r['parent_id'];

        while ($parent_id) {
            $sql = "SELECT id, parent_id, name, uri FROM br_category WHERE id = '$parent_id'";
            $rs = $ci->db->query($sql);

            if ($rs->num_rows() == 1) {
                $r = $rs->first_row('array');
                $link = str_replace(':', '/', $r['uri']);
                $str = "<li><a href='$link'>" . $r['name'] . "</a></li>" . $str;
                $parent_id = $r['parent_id'];
            } else {
                return FALSE;
            }
        }
    }
    $base = base_url();

    echo "<ul class='breadcrumb'><li><a href='$base'>Home</a></li> " . strtolower($str) . "</ul>";
}

function productBredcrumbs($product)
{

    $CI = &get_instance();
    $CI->db->select('name as category_name ,uri as category_uri');
    $CI->db->from('category t1');
    $CI->db->where('parent_id', $product['cid']);
    $query = $CI->db->get()->result_array();
    e($query);
    $data = '<ul>';
    $data .= '<li><a href=' . base_url() . '>Home</a></li>';
    $data .= '<li><a href=' . base_url() . $product['category_uri'] . '>' . $product['cname'] . '</a></li>';
    $data .= '<li>';
    $data .= $product["name"];
    $data .= '<li>';

    $data .= '</ul>';

    echo $data;
}
function fetchProductAlias($alias)
{
    $CI = &get_instance();
    $CI->db->select('t1.*,  t4.cid,t1.id as product_id, t9.name as cname ,t9.uri as category_uri');
    $CI->db->from('product t1');
    $CI->db->join('cat_prod t4', 't1.id = t4.pid', 'left');
    $CI->db->join('category t9', 't9.id = t4.cid', 'LEFT');
    $CI->db->where('t1.is_active', 1);
    $CI->db->where('t1.uri', $alias)->limit(1);
    $query = $CI->db->get();

    if ($query->num_rows() == 1) {
        return $query->row_array();
    }
    return false;
}



function arrIndex($stack, $ind, $def = '')
{
    if (isset($stack[$ind])) {
        $def = $stack[$ind];
    }
    return $def;
}

// My Functions
function uri_by_sku($sku)
{
    $CI = &get_instance();

    $rs = $CI->db->where('sku', $sku)->get('product');

    if ($rs->num_rows() == 1) {
        $r = $rs->first_row('array');
        return $r['uri'];
    }

    return FALSE;
}

function get_least_child_price($config_id)
{
    $CI = &get_instance();

    $rs = $CI->db->select_min('price')
        ->from('product')
        ->join('product_configurable_link', 'product_configurable_link.child_id = product.id')
        ->where("product_configurable_link.parent_id", $config_id)
        ->get();

    if ($rs->num_rows()) {
        $r = $rs->first_row('array');
        return $r['price'];
    }

    return 0;
}

function breadcrumb_nav($uri)
{
    $arr = array();
    $arr = explode('/', $uri);
    $str = '';

    if ($arr) {
        $prev_uri = '';

        foreach ($arr as $k => $v) {
            $str .= '<i class="fa fa-angle-right" aria-hidden="true"></i>';
            $str .= '<a href="' . $prev_uri . $v . '">' . ucwords(str_replace('-', ' ', $v)) . '</a>';
            $prev_uri = $v . '/';
        }
    }

    return $str;
}

function attribute_label_by_id($attribute_id)
{
    $CI = &get_instance();

    $rs = array();

    $rs = $CI->db->select('label')
        ->from('attribute')
        ->where('id', $attribute_id)
        ->get();

    if ($rs->num_rows() == 1) {
        $r = $rs->first_row('array');
        return $r['label'];
    }

    return FALSE;
}

function attribute_option_by_id($option_id)
{
    $CI = &get_instance();

    $rs = array();

    $rs = $CI->db->select('option')
        ->from('attribute_option')
        ->where('id', $option_id)
        ->get();

    if ($rs->num_rows() == 1) {
        $r = $rs->first_row('array');
        return $r['option'];
    }

    return FALSE;
}

function review_rate($product_id)
{
    //    $CI = & get_instance();
    //    $rs = $CI->db->select('rate')
    //            ->from('review')
    //            ->where('status', 1)
    //            ->where('product_id', $product_id)
    //            ->get();
    //
    //    $rate = 0;
    //    $count = $rs->num_rows();
    //
    //    if ($rs->num_rows()) {
    //        $rs = $rs->result_array();
    //        foreach ($rs as $item) {
    //            $rate += $item['rate'];
    //        }
    //
    //        return $rate / $count;
    //    }
    //
    //    return 0;
    $CI = &get_instance();
    $CI->db->select('avg(rate) as avgrate');
    $CI->db->from('review');
    $CI->db->where('status', 1);
    $CI->db->where('product_id', $product_id);
    $r = $CI->db->get()->first_row('array');
    return number_format($r['avgrate']);
}

function is_config_empty($config_id)
{
    $CI = &get_instance();
    $rs = array();

    $rs = $CI->db->select('*')
        ->from('product_configurable_link')
        ->where('parent_id', $config_id)
        ->get();

    if ($rs->num_rows() > 0) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function get_accessories($id)
{
    $CI = &get_instance();
    $rs = array();

    $rs = $CI->db->select('accessories.*, product.name as name')
        ->from('accessories')
        ->join('product', 'product.id = accessories.product_id')
        ->where('accessories.config_product_id', $id)
        ->get();

    if ($rs->num_rows()) {
        return $rs->result_array();
    } else {
        return FALSE;
    }
}

function brand_name_by_id($id)
{
    $CI = &get_instance();

    $rs = array();
    $rs = $CI->db->select('name')
        ->from('brand')
        ->where('id', $id)
        ->get();

    if ($rs->num_rows() == 1) {
        $r = $rs->first_row('array');
        return $r['name'];
    }

    return FALSE;
}

function child_stock($config_id)
{
    $CI = &get_instance();
    $rs = array();
    $rs = $CI->db->select(' sum(quantity) as qty')
        ->from('product')
        ->join('product_configurable_link', 'product_configurable_link.child_id = product.id')
        ->where('product.is_active', 1)
        ->where('product_configurable_link.parent_id', $config_id)
        ->get()->row_array();
    $qty = 0;
    if ($rs) {
        $qty = $rs['qty'];
    }
    return $qty;
}

function mobile_menu()
{
    $arr = array();

    $CI = &get_instance();
    $rs = array();
    $rs = $CI->db->select('menu_item.*')
        ->from('menu')
        ->join('menu_item', 'menu_item.menu_id = menu.menu_id')
        ->where('menu.menu_alias', 'main_menu')
        ->order_by('menu_item.menu_sort_order')
        ->get();

    if ($rs->num_rows()) {
        $rs = $rs->result_array();
        foreach ($rs as $k => $v) {
            $temp = array();
            $temp['id'] = $v['menu_item_id'];
            $temp['name'] = $v['menu_item_name'];
            $temp['url'] = $v['url'];
            $temp['megamenu'] = get_mobile_megamenu($v['menu_item_id']);
            array_push($arr, $temp);
        }

        return $arr;
    }

    return FALSE;
}

function get_mobile_megamenu($menu_item_id)
{
    $CI = &get_instance();
    $rs = $CI->db->where('menu_item_id', $menu_item_id)->get('megamenu');

    if ($rs->num_rows() == 1) {
        $r = $rs->first_row('array');
        $category_id = $r['category_id'];
        $rs2 = $CI->db->where('id', $category_id)->where('active', 1)->get('category');
        if ($rs2->num_rows() == 1) {
            $rs3 = $CI->db->select('id, name, uri, icon, image, image_alt')
                ->where('parent_id', $category_id)
                ->where('show_in_menu', 1)
                ->where('active', 1)
                ->get('category');
            if ($rs3->num_rows()) {
                return $rs3->result_array();
            }
        }
    }

    return FALSE;
}

function wishlisted_products($customer_id)
{
    $CI = &get_instance();
    $rs = array();
    $rs = $CI->db->select('product_id')
        ->from('wishlist')
        ->where('customer_id', $customer_id)
        ->get();

    if ($rs->num_rows()) {
        $rs = $rs->result_array();
        return array_column($rs, 'product_id');
    }

    return FALSE;
}

function image_by_id($id)
{
    if ($id) {
        $CI = &get_instance();

        $rs = array();
        $rs = $CI->db->select('img, imgalt')
            ->from('prod_img')
            ->where('pid', $id)
            ->where('main', 1)
            ->get();

        if ($rs->num_rows() == 1) {
            return $rs->first_row('array');
        }
    }

    return FALSE;
}

function child_having_price_more_or_greater_than($config_id, $min_price)
{
    $CI = &get_instance();

    $rs = array();
    $rs = $CI->db->select('product.id, product.price')
        ->from('product_configurable_link')
        ->join('product', 'product.id = product_configurable_link.child_id')
        ->where('product_configurable_link.parent_id', $config_id)
        ->get();

    if ($rs->num_rows()) {
        $rs = $rs->result_array();
        asort($rs);

        foreach ($rs as $item) {
            if ($item['price'] >= $min_price) {
                return $item['price'];
            }
        }
    }
}

function productAllPdfByID($pid)
{
    $CI = &get_instance();
    $CI->db->where('product_id', $pid);
    $rs = $CI->db->get('product_pdf');
    return $rs->result_array();
}
function testimonial()
{
    $CI = &get_instance();
    $CI->db->where('active', 1);
    $CI->db->order_by('sort_order', 'DESC');
    $rs = $CI->db->get('testimonial');
    return $rs->result_array();
}
function gallery()
{
    $CI = &get_instance();
    $CI->db->where('active', 1);
    $CI->db->order_by('id', 'DESC');
    $CI->db->where('show_in_homepage', 1);
    $CI->db->limit(5);
    $rs = $CI->db->get('gallery');
    return $rs->result_array();
}

function testimonialbanner()
{
    $CI = &get_instance();
    $CI->db->where('page_uri', 'testimonial');
    $rs = $CI->db->get('page');
    return $rs->row_array();
}


function previous($blog_id, $blog_date)
{
    $CI = &get_instance();
    return $CI->db->select('*')
        ->from('news')
        ->where('news_date <', $blog_date)
        ->order_by('news_date', 'DESC')
        ->limit(1)
        ->get()->row_array();
}

function forward($blog_id, $blog_date)
{
    $CI = &get_instance();
    return $CI->db->select('*')
        ->from('news')
        ->where('news_date >', $blog_date)
        ->get()->row_array();
}



function newscategoryCount($id)
{

    $CI = &get_instance();

    $rs = $CI->db->select('*')
        ->from('news')
        ->join('newscategory', 'newscategory.id = news.newscategory')
        ->where('news.newscategory', $id)
        ->get()->result_array();

    return $rs;
}
function servicescategoryCount()
{

    $CI = &get_instance();

    $rs = $CI->db->select('*')
        ->from('servicescategory')
        ->get()->result_array();

    return $rs;
}
function listAllServices()
{

    $CI = &get_instance();

    $rs = $CI->db->select('*')
        ->where('active', 1)
        ->from('services')
        ->get()->result_array();

    return $rs;
}

function listLatestNews()
{

    $CI = &get_instance();

    $rs = $CI->db->select('*')
        ->order_by('added_on', 'DESC')
        ->where('active', 1)
        ->limit(5)
        ->from('news')
        ->get()->result_array();

    return $rs;
}

function getPageContent($pid)
{

    $CI = &get_instance();

    $rs = $CI->db->select('*')
        ->where('page_id', $pid)
        ->from('page_block')
        ->get()->row_array();

    return $rs;
}

function getModuleData($moduleConfig, $relation = '')
{

    $CI = &get_instance();
    $data = [];
    if ($relation == '') {
        // $data = $CI->db->select('*')
        //     ->from($moduleConfig['element_table'])
        //     ->where('active', 1)
        //     ->get()->result_array();
        $CI->db->select('*');
        $CI->db->from($moduleConfig['element_table']);
        $CI->db->where('active', 1);
        if ($moduleConfig['element_table'] == 'services') {
            $CI->db->order_by('sort_order', 'ASC');
        }
        if ($moduleConfig['element_table'] == 'slideshow_image') {
            $CI->db->where('slideshow_id', $moduleConfig['slider_id']);
        }
        if ($moduleConfig['element_table'] == 'category') {
            $CI->db->where('active', 1);
            $CI->db->where_in('id', $moduleConfig['moduledata']);
        }
        if ($moduleConfig['element_table'] == 'projects') {
            $CI->db->where_in('projects_id', $moduleConfig['moduledata']);
        }
        if ($moduleConfig['element_table'] == 'product') {
            $CI->db->where('is_active', 1);
            $CI->db->where_in('id', $moduleConfig['moduledata']);
        }
        $data = $CI->db->get()->result_array();
    } else {
        $relations = $CI->db->select('*')
            ->from($relation)
            ->where('active', 1)
            ->get()->result_array();
        $sub_items = [];
        if ($relations) {
            foreach ($relations as $row) {
                $query = $CI->db->where('portfolio_category', $row['id'])->where('active', 1)->get($moduleConfig['element_table'])->result_array();
                $sub_items[$row['id']] = $row;
                $sub_items[$row['id']]['sub_items'] = $query;
            }
            $data = $sub_items;
        }
    }
    return $data;
}

function getModuleDatacategory($moduleConfig)
{
    // e($moduleConfig);
    $CI = &get_instance();
    $data = [];
    foreach ($moduleConfig['moduledata'] as $item) {
        $CI->db->select('*');
        $CI->db->from($moduleConfig['element_table']);
        $CI->db->where('active', 1);
        $CI->db->where('id', $item);
        $result = $CI->db->get()->row_array();
        array_push($data, $result);
    }
    return $data;
}

function getPageFormById($form_id)
{
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

function getSwatchAttribute()
{
    $CI = &get_instance();
    $CI->db->select('*');
    $CI->db->where('for_swatches', 1);
    $rs = $CI->db->get('attribute');
    if ($rs->num_rows() > 0) {
        return $rs->row_array();
    }
    return false;
}

function getProductAttrOptionSwatches($pid)
{
    $attr_id = getSwatchAttribute();
    $CI = &get_instance();
    $CI->db->select('t3.*');
    $CI->db->from('attribute_varchar t1');
    $CI->db->join('attribute t2', 't2.id = t1.attr_id');
    $CI->db->join('attribute_option t3', 't1.value = t3.id');
    $CI->db->where('t1.pid', $pid);
    $CI->db->where('t1.attr_id', $attr_id['id']);
    $CI->db->group_by('t3.option');
    $query = $CI->db->get();
    return $query->result_array();
}

function getProductAttrOptionSwatches_fromCategory($cid)
{
    $attr_id = getSwatchAttribute();
    $CI = &get_instance();
    $category_pids = $CI->db->select('pid')->where('cid', $cid)->get('cat_prod')->result_array();
    $category_pids = array_column($category_pids, 'pid');
    if ($category_pids) {
        $CI->db->select('t3.*');
        $CI->db->from('attribute_varchar t1');
        $CI->db->join('attribute t2', 't2.id = t1.attr_id');
        $CI->db->join('attribute_option t3', 't1.value = t3.id');
        $CI->db->join('product t4', 't4.id = t1.pid');
        $CI->db->where_in('t1.pid', $category_pids);
        $CI->db->where('t1.attr_id', $attr_id['id']);
        $CI->db->where('t4.is_active', 1);
        $CI->db->group_by('t3.option');
        $query = $CI->db->get();
        return $query->result_array();
    } else {
        return false;
    }
}

function certification()
{
    $CI = &get_instance();
    return $CI->db->select('*')
        ->from('certification')
        ->where('active', 1)
        ->order_by('id', 'desc')
        ->get()->result_array();
}
function getMainImage($id)
{
    $CI = &get_instance();
    $data = $CI->db->select('*')
        ->where('projects_id', $id)
        ->from('projects_img')
        ->get()->row_array();
    return $data;
}
function getproductMainImage($id)
{
    $CI = &get_instance();
    $data = $CI->db->select('*')
        ->where('pid', $id)
        ->from('prod_img')
        ->get()->row_array();
    return $data;
}
function getNewArrivalsSelectedProduct($selectProductArray)
{
    $CI = &get_instance();
    $product_data = [];
    foreach ($selectProductArray['productdata'] as $key => $item) {
        $CI->db->select('t1.*,t3.name as category_name,t3.uri as category_uri');
        $CI->db->from('product t1');
        $CI->db->join('cat_prod t2', 't2.pid = t1.id');
        $CI->db->join('category t3', 't3.id = t2.cid');
        $CI->db->where('t1.id', $item);
        $product = $CI->db->get()->row_array();
        if ($product) {
            $product_data[$key] = $product;
        }
    }
    return $product_data;
}
function listAllProjects()
{
    $CI = &get_instance();

    $CI->db->where('active', '1');
    $query = $CI->db->get('projecttype');
    $results =  $query->result_array();

    $project_data = [];
    foreach ($results as $key => $item) {
        $CI->db->select('*');
        $CI->db->from('projects');
        $CI->db->where('active', '1');
        $CI->db->where('project_cat', $item['id']);
        $project = $CI->db->get()->result_array();
        if ($project) {
            $project_data[$key] =  $item;
            $project_data[$key]['project'] = $project;
        }
    }
    return $project_data;
}
function listAllLatestProjects()
{
    $CI = &get_instance();

    $CI->db->where('active', '1');
    $CI->db->where('homepage_active', '1');
    $query = $CI->db->get('projects');
    $results =  $query->result_array();

    return $results;
}
function getsitecolor()
{
    $CI = &get_instance();
    $data = $CI->db->select('*')
        ->where('element', 'site-color')
        ->from('design_config')
        ->get()->row_array();
    return $data;
}


function previousProjct($project_id, $project_cat_id)
{
    $CI = &get_instance();
    return $CI->db->select('*')
        ->from('projects')
        ->where('projects_id <', $project_id)
        ->where('project_cat', $project_cat_id)
        ->where('active', 1)
        ->order_by('projects_id', 'DESC')
        ->limit(1)
        ->get()->row_array();
}

function forwardProject($project_id, $project_cat_id)
{
    $CI = &get_instance();
    return $CI->db->select('*')
        ->from('projects')
        ->where('projects_id >', $project_id)
        ->where('project_cat', $project_cat_id)
        ->where('active', 1)
        ->get()->row_array();
}

function getProductBulletPoints($id)
{
    $CI = &get_instance();

    $CI->db->where('pid', $id);
    $query = $CI->db->get('bullet_points');
    $results =  $query->result_array();

    return $results;
}

function getProductAssigned($id)
{
    $CI = &get_instance();
    $data = $CI->db->select('t1.*')
        ->from('product t1')
        ->join('product_assign t2', 't2.productadd = t1.id')
        ->where('t2.pid', $id)
        ->get()->result_array();

    return $data;
}

function breadcrumb_navigation($void_last = 1)
{
    $CI = &get_instance();
    $uri = $CI->uri->uri_string();
    $uri = preg_replace('/~.*$/', '', $uri);

    $str = '';

    $page = getPageDetails($uri);
    if ($page) {
        $str .= '<li class="active"><a href="javascript:void()">' . $page['title'] . '</a></li>';
        return $str;
    }
    $arr = array();
    array_push($arr, $uri);

    $ancestors = count(explode('/', $uri)) - 1;

    while ($ancestors--) {
        $uri = parent_uri($uri);
        if ($uri) {
            array_push($arr, $uri);
        }
    }


    $divider_flag = FALSE;

    for ($i = (count($arr) - 1); $i >= 0; $i--) {
        if ($divider_flag == TRUE) {
            $str .= '&nbsp;&nbsp;<i class="fa fa-angle-double-right" aria-hidden="true"></i>&nbsp;&nbsp;';
        }

        if ($void_last == 1) {
            if ($i == 0) {
                $str .= '<li class="active"><a href="javascript:void()">' . category_name_by_uri($arr[$i]) . '</a></li>';
            } else {
                $str .= '<li><a href="' . base_url() . $arr[$i] . '">' . category_name_by_uri($arr[$i]) . '</a></li>';
            }
        } else {
            $str .= '<li><a href="' . base_url() . $arr[$i] . '">' . category_name_by_uri($arr[$i]) . '</a></li>';
        }

        $divider_flag = TRUE;
    }

    return $str;
}
function category_name_by_uri($uri)
{
    $CI = &get_instance();

    $rs = array();
    $rs = $CI->db->select('name')
        ->from('category')
        ->where('uri', $uri)
        ->get();

    if ($rs->num_rows() == 1) {
        $r = array();
        $r = $rs->first_row('array');
        return $r['name'];
    }
}
function parent_uri($uri)
{
    $CI = &get_instance();

    $rs = array();
    $rs = $CI->db->select('parent_id')
        ->from('category')
        ->where('uri', $uri)
        ->get();

    if ($rs->num_rows() == 1) {
        $r = array();
        $r = $rs->first_row('array');

        $rs2 = array();
        $rs2 = $CI->db->select('uri')
            ->from('category')
            ->where('id', $r['parent_id'])
            ->get();

        if ($rs2->num_rows() == 1) {
            $r = array();
            $r = $rs2->first_row('array');
            return $r['uri'];
        }
    }
}
function getPageDetails($alias, $lang = 'en')
{
    $CI = &get_instance();
    $CI->db->from('page');
    $CI->db->join('page_template', 'page_template.page_template_id = page.page_template_id');
    $CI->db->where('page_uri', $alias);
    $CI->db->where('language_code', $lang);
    $CI->db->where('active', 1);
    $rs = $CI->db->get();
    if ($rs->num_rows() != 1) {
        return false;
        if ($lang != 'en') {
            $CI->db->from('page');
            $CI->db->where('page_uri', $alias);
            $CI->db->where('language_code', 'en');
            $CI->db->where('active', 1);
            $rs = $CI->db->get();
            if ($rs->num_rows() != 1) {
                return false;
            }
        } else {
            return false;
        }
    }

    $page = $rs->row_array();

    return $page;
}
function assigned_template($template_id)
{
    $CI = &get_instance();
    $data = [];
    $CI->db->where('template_id', $template_id);
    $CI->db->order_by('sort_order', 'ASC');
    $query = $CI->db->get('pagebuilder_template_rows');
    $blocks = $query->result_array();
    foreach ($blocks as $key => $item) {
        $CI->db->where('template_id', $item['template_id']);
        $CI->db->where('row_id', $item['id']);
        $query = $CI->db->get('pagebuilder_template_columns');
        $blobkElement = $query->result_array();

        $data[$item['id']] =  $item;
        $data[$item['id']]['blockElement'] =  $blobkElement;
    }
    return $data;
    // e($data);
}
function getProductDetails($productId)
{
    $CI = &get_instance();
    $CI->db->from('product');
    $CI->db->where('is_active', 1);
    $CI->db->where('id', $productId);
    $rs = $CI->db->get()->row_array();

    return $rs;
}

function projectDynamicFieldsInc($pid)
{

    $CI = &get_instance();
    $CI->db->select('*');
    $CI->db->from('project_dynamic_fields');
    $CI->db->where('project_id', $pid);
    $CI->db->order_by("id", "ASC");
    $res = $CI->db->get();
    $result = $res->result_array();
    return $result;
}
