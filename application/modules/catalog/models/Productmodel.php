<?php

class Productmodel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    //function getDetails($pid) {
    //  $this->db->where('id', intval($pid));
    //  $rs = $this->db->get('product');
    //  return $rs->row_array();
    //}
    public function getparentconfig($id)
    {
        $this->db->select("t3.img");
        $this->db->from("br_product_configurable_link t1");
        $this->db->join("product t2", "t1.parent_id = t2.id");
        $this->db->join("br_prod_img t3", "t2.id = t3.pid");
        $this->db->where("t1.child_id", $id);
        $this->db->where("t3.main", 1);
        return $this->db->get()->result_array();
    }

    public function custom_options($config, $pid)
    {
        $result = $this->db
            ->where('pid', $pid)
            ->where('config', $config)
            ->get('custom_table')
            ->result_array();
        return $result;
    }

    public function getDetails($pid)
    {
        $user_id = $this->session->userdata('CUSTOMER_ID');
        if ($user_id) {
            $this->db->select('t1.*, t2.img, t2.imgalt,t3.discount, t3.special_price');
        } else {
            $this->db->select('t1.*, t2.img, t2.imgalt');
        }

        //$this->db->select('product_image.product_id AS p1, product_image.*, product.*, leadlabel');
        $this->db->from('product t1');
        $this->db->join('prod_img t2', 't1.id = t2.pid AND t2.main = 1', 'left');
        if ($user_id) {
            $this->db->join('product_assignment t3', "t3.product_id = t1.id AND t3.user_id = $user_id", 'left');
        }
        //$this->db->join('review t4', 't1.id = t4.product_id AND t4.status = 1', 'left');
        //$this->db->join('leadtime', 'product.product_id = leadtime.product_id AND selected = 1', 'left');
        $this->db->where('t1.is_active', 1);
        $this->db->where('t1.id', $pid)->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row_array();
        }
        return false;
    }

    public function fetchByAlias($alias, $ignoreChild = false)
    {
        $user_id = $this->session->userdata('CUSTOMER_ID');
        if ($user_id) {
            $this->db->select('t1.*, t2.img, t2.imgalt,t3.discount, t3.special_price, t4.cid,t1.id as product_id, t8.name as bname, t9.name as cname');
        } else {

            $this->db->select('t1.*, t2.img, t2.imgalt, t4.cid,t1.id as product_id, t8.name as bname, t9.name as cname');
        }

        //$this->db->select('product_image.product_id AS p1, product_image.*, product.*, leadlabel');
        $this->db->from('product t1');
        $this->db->join('prod_img t2', 't1.id = t2.pid AND t2.main = 1', 'left');
        $this->db->join('cat_prod t4', 't1.id = t4.pid', 'left');
        if ($user_id) {
            $this->db->join('product_assignment t3', "t3.product_id = t1.id AND t3.user_id = $user_id", 'left');
        }
        //$this->db->join('review t4', 't1.id = t4.product_id AND t4.status = 1', 'left');
        //$this->db->join('leadtime', 'product.product_id = leadtime.product_id AND selected = 1', 'left');

        $this->db->join('brand t8', 't8.id = t1.bid', 'LEFT');
        $this->db->join('category t9', 't9.id = t4.cid', 'LEFT');

        if (!$ignoreChild) {
            $qu = "t1.id NOT IN (select pf.child_id from br_product_configurable_link as pf where pf.child_id != pf.parent_id)";
            $this->db->where($qu);
        }
        $this->db->where('t1.is_active', 1);
        $this->db->where('t1.uri', $alias)->limit(1);
        //echo $this->db->last_query();
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->row_array();
        }
        return false;
    }

    public function getCategories($pid, $findMainOnly = false)
    {
        // e("$pid , $findMainOnly");
        $this->db->select('t2.*,t1.main');
        $this->db->from('cat_prod t1');
        $this->db->join('category t2', 't2.id=t1.cid');
        $this->db->where('t1.pid', $pid);
        if ($findMainOnly) {
            $this->db->where('t1.main', 1);
            $result = $this->db->get()->row_array();
        } else {
            $result = $this->db->get()->result_array();
        }
        return $result;
    }

    public function getFeaturedProducts()
    {
        $this->db->from('product');
        $this->db->select('product_image.product_id AS p1, product_image.*, product.*');
        $this->db->join('product_image', 'product.product_id = product_image.product_id AND tb_product_image.is_main_image = 1', 'left');
        $this->db->where('is_featured', 1);
        $rs = $this->db->get();
        return $rs->result_array();
    }

    public function getTierPrices($id, $profile_id = null)
    {
        $this->db->from('tier_price');
        $this->db->where_in('tier_product_id', $id);
        if (!is_null($profile_id)) {
            $this->db->where('tier_profile_id', $profile_id);
        }
        $res = $this->db->get();
        //        e($this->db->last_query());
        if ($res->num_rows() > 0) {
            return ($res->result_array());
        } else {
            return false;
        }
    }

    public function getProducts($cid)
    {
        //print_r($cid); exit();
        $this->db->from('product_category');
        $this->db->join('product', 'product.product_id = product_category.product_id');
        $this->db->join('product_image', 'product.product_id = product_image.product_id AND tb_product_image.is_main_image = 1', 'left');
        $this->db->where_in('category_id', $cid);
        $this->db->group_by('product_category.product_id');
        $rs = $this->db->get();
        //echo $this->db->last_query(); exit();
        return $rs->result_array();
    }

    public function getProductAttribute($Pid)
    {
        //print_r($cid); exit();
        $this->db->from('product_attribute');
        $this->db->join('attribute', 'attribute.attribute_id = product_attribute.attribute_id', 'LEFT');
        $this->db->where('product_id', $Pid);
        $rs = $this->db->get();
        //echo $this->db->last_query(); exit();
        return $rs->result_array();
    }

    public function getProductOption($pid)
    {

        //print_r($cid); exit();
        $this->db->from('options');
        //$this->db->join('option_rows', 'option_rows.option_id = options.option_id');
        $this->db->where('options.product_id', $pid)
            ->where('options.is_visible', '0');
        $rs = $this->db->get();
        return $rs->result_array();
    }

    public function listOptionsValue($pid)
    {

        $this->db->select('*');
        $this->db->from('option_rows');
        $this->db->where('product_id', $pid);

        $query = $this->db->get();
        return $query->result_array();
    }

    public function getRelatedProducts($pid)
    {
        $this->db->select('cid');
        $this->db->where('pid', $pid);
        $rs = $this->db->get('cat_prod');
        if ($rs->num_rows() > 0) {
            $result = $rs->result_array();
            $result = array_column($result, 'cid');

            $user_id = $this->session->userdata('CUSTOMER_ID');
            if ($user_id) {
                $this->db->select('product.id, product.sku, product.name, product.uri, product.type, product.price, prod_img.img, prod_img.imgalt,product_assignment.discount, product_assignment.special_price');
            } else {
                $this->db->select('product.id, product.sku, product.description, product.name, product.uri, product.type, product.price, prod_img.img, prod_img.imgalt');
            }
            //            $this->db->select("IF(min(t7.price),min(t7.price),product.price) as least_price", false);
            $this->db->from('product');
            $this->db->join('cat_prod', 'product.id = cat_prod.pid AND br_cat_prod.pid !=' . $pid);
            $this->db->join('prod_img', 'product.id = prod_img.pid AND br_prod_img.main = 1', 'left');
            if ($user_id) {
                $this->db->join('product_assignment', "product_assignment.product_id = product.id AND br_product_assignment.user_id = $user_id", 'left');
            }
            $this->db->join('product_configurable_link t6', 't6.parent_id = product.id', 'left');
            $this->db->join('product t7', 't7.id = t6.child_id', 'left');
            $this->db->where_in('cat_prod.cid', $result);
            $this->db->order_by('product.id', 'RANDOM');

            $this->db->limit('10');

            $qu = "product.id NOT IN (select pf.child_id from br_product_configurable_link as pf)";
            $this->db->where($qu);
            $this->db->where('product.is_active', 1);
            $this->db->group_by('product.id');
            $rs1 = $this->db->get();
            //        e($this->db->last_query());
            return $rs1->result_array();
        }
    }

    public function getImages($pid)
    {
        $this->db->where_in('pid', $pid);
        $this->db->order_by('main', 'desc');
        $rs = $this->db->get('prod_img');
        return $rs->result_array();
    }

    public function getParentCategories($cid)
    {
        $this->db->select('parent_id, depth');
        $this->db->where('category_id', $cid);
        $query = $this->db->get('category');
        return $query->row_array();
    }

    public function getPDF($cid)
    {
        $this->db->where('category_id', $cid);
        $rs = $this->db->get('download');
        $pdf = $rs->result_array();
        if (!empty($pdf)) {
            return $pdf;
        } else {
            $subcid = $this->getParentCategories($cid);
            if (!empty($subcid)) {
                $varpdf = $this->getPDF($subcid['parent_id']);
                return $varpdf;
            }
        }
    }

    //list all products count
    public function listByCategoryCount($cid, $filteredProductIds = false)
    {
        $user_id = $this->session->userdata('CUSTOMER_ID');
        if ($user_id) {
            $this->db->select('t1.*,t1.id as product_id, IF(max(t7.quantity) > 0,max(t7.quantity),t1.quantity) as current_quantity, t3.*,t4.discount, t4.special_price, avg(t5.rate) as avgrate,count(t5.id) as reviewnumber,wishlist.product_id as in_wishlist', false);
        } else {
            $this->db->select('t1.*, t1.id as product_id,IF(max(t7.quantity) > 0,max(t7.quantity),t1.quantity) as current_quantity, t3.*, avg(t5.rate) as avgrate,count(t5.id) as reviewnumber', false);
        }

        $this->db->select("IF(min(t7.price),min(t7.price),t1.price) as least_price", false);
        $this->db->select("(select COUNT(t8.parent_sku) from br_order_item t8 where t8.parent_sku = t1.sku) as salecount", false);
        $this->db->from('product t1');
        $this->db->join('cat_prod t2', 't2.pid = t1.id');
        $this->db->join('prod_img t3', 't1.id = t3.pid AND t3.main = 1', 'left');
        $this->db->join('review t5', 't1.id = t5.product_id AND t5.status = 1', 'left');
        if ($user_id) {
            $this->db->join('product_assignment t4', "t4.product_id = t1.id AND t4.user_id = $user_id", 'left');
            $this->db->join('br_wishlist', "br_wishlist.product_id = t1.id AND br_wishlist.customer_id = $user_id", 'left');
        }
        $this->db->join('product_configurable_link t6', 't6.parent_id = t1.id', 'left');
        $this->db->join('product t7', 't7.id = t6.child_id', 'left');

        if ($filteredProductIds) {
            //            $filteredProductIds = implode(',', $filteredProductIds);
            //            $this->db->where("( t6.child_id IN ($filteredProductIds) OR t6.parent_id IN ($filteredProductIds) )", null);
            $this->db->where_in('t1.id', $filteredProductIds);
        }
        $qu = "t2.cid = " . intval($cid) . " AND t1.is_active = 1 AND t1.id NOT IN (select pf.child_id from br_product_configurable_link as pf)";
        $this->db->where($qu);
        $this->db->where('t1.is_active', 1);
        if (DWS_SHOW_OUT_STOCK != 1) {
            $this->db->having('current_quantity >', 0);
        }
        $this->db->group_by('t1.id');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function listByBrandCount($bid, $filteredProductIds = false)
    {
        $user_id = $this->session->userdata('CUSTOMER_ID');
        if ($user_id) {
            $this->db->select('t1.*,t1.id as product_id, IF(max(t7.quantity) > 0,max(t7.quantity),t1.quantity) as current_quantity, t3.*,t4.discount, t4.special_price, avg(t5.rate) as avgrate,count(t5.id) as reviewnumber,wishlist.product_id as in_wishlist', false);
        } else {
            $this->db->select('t1.*, t1.id as product_id,IF(max(t7.quantity) > 0,max(t7.quantity),t1.quantity) as current_quantity, t3.*, avg(t5.rate) as avgrate,count(t5.id) as reviewnumber', false);
        }

        $this->db->select("IF(min(t7.price),min(t7.price),t1.price) as least_price", false);
        $this->db->select("(select COUNT(t8.parent_sku) from br_order_item t8 where t8.parent_sku = t1.sku) as salecount", false);
        $this->db->from('product t1');
        $this->db->join('brand t2', 't2.id=t1.bid');
        $this->db->join('prod_img t3', 't1.id = t3.pid AND t3.main = 1', 'left');
        $this->db->join('review t5', 't1.id = t5.product_id AND t5.status = 1', 'left');
        if ($user_id) {
            $this->db->join('product_assignment t4', "t4.product_id = t1.id AND t4.user_id = $user_id", 'left');
            $this->db->join('br_wishlist', "br_wishlist.product_id = t1.id AND br_wishlist.customer_id = $user_id", 'left');
        }
        $this->db->join('product_configurable_link t6', 't6.parent_id = t1.id', 'left');
        $this->db->join('product t7', 't7.id = t6.child_id', 'left');

        if ($filteredProductIds) {
            //            $filteredProductIds = implode(',', $filteredProductIds);
            //            $this->db->where("( t6.child_id IN ($filteredProductIds) OR t6.parent_id IN ($filteredProductIds) )", null);
            $this->db->where_in('t1.id', $filteredProductIds);
        }
        $qu = "t2.id = " . intval($bid) . " AND t1.is_active = 1 AND t1.id NOT IN (select pf.child_id from br_product_configurable_link as pf)";
        $this->db->where($qu);
        $this->db->where('t1.is_active', 1);
        if (DWS_SHOW_OUT_STOCK != 1) {
            $this->db->having('current_quantity >', 0);
        }
        $this->db->group_by('t1.id');
        $query = $this->db->get();
        return $query->num_rows();
    }

    //list all products
    public function listByCategory($cid, $offset = false, $limit = false, $filteredProductIds = false, $order = false)
    {
        if ($this->input->post('no_offset') != 'no-offset') {
            if ($offset) {
                $this->db->offset($offset);
            }
        }
        if ($limit) {
            $this->db->limit($limit);
        }

        $user_id = $this->session->userdata('CUSTOMER_ID');
        if ($user_id) {
            $this->db->select('t1.*,t1.id as product_id, IF(max(t7.quantity) > 0,max(t7.quantity),t1.quantity) as current_quantity, t3.*,t4.discount, t4.special_price, avg(t5.rate) as avgrate,count(t5.id) as reviewnumber,wishlist.product_id as in_wishlist, t8.name as bname, t9.name as cname', false);
        } else {
            $this->db->select('t1.*, t1.id as product_id,IF(max(t7.quantity) > 0,max(t7.quantity),t1.quantity) as current_quantity, t3.*, avg(t5.rate) as avgrate,count(t5.id) as reviewnumber, t8.name as bname, t9.name as cname', false);
        }

        $this->db->select("IF(min(t7.price),min(t7.price),t1.price) as least_price", false);
        $this->db->select("(select COUNT(t8.parent_sku) from br_order_item t8 where t8.parent_sku = t1.sku) as salecount", false);
        $this->db->from('product t1');
        $this->db->join('cat_prod t2', 't2.pid = t1.id');
        $this->db->join('prod_img t3', 't1.id = t3.pid AND t3.main = 1', 'left');
        $this->db->join('review t5', 't1.id = t5.product_id AND t5.status = 1', 'left');
        if ($user_id) {
            $this->db->join('product_assignment t4', "t4.product_id = t1.id AND t4.user_id = $user_id", 'left');
            $this->db->join('br_wishlist', "br_wishlist.product_id = t1.id AND br_wishlist.customer_id = $user_id", 'left');
        }
        $this->db->join('product_configurable_link t6', 't6.parent_id = t1.id', 'left');
        $this->db->join('product t7', 't7.id = t6.child_id', 'left');
        $this->db->join('brand t8', 't8.id = t1.bid', 'LEFT');
        $this->db->join('category t9', 't9.id = t2.cid', 'LEFT');

        if ($filteredProductIds) {
            //            $filteredProductIds = implode(',', $filteredProductIds);
            //            $this->db->where("( t6.child_id IN ($filteredProductIds) OR t6.parent_id IN ($filteredProductIds) OR t6.parent_id IS NULL )", null);
            $this->db->where_in('t1.id', $filteredProductIds);
        }
        $qu = "t2.cid = " . intval($cid) . " AND t1.is_active = 1 AND t1.id NOT IN (select pf.child_id from br_product_configurable_link as pf)";
        $this->db->where($qu);
        if ($order == 'ASC') {
            //            $this->db->order_by('least_price', 'ASC');
        } else if ($order == 'DESC') {
            //            $this->db->order_by('least_price', 'DESC');
        } else {
            //            $this->db->order_by('least_price', 'ASC');
        }
        if (DWS_SHOW_OUT_STOCK != 1) {
            $this->db->having('current_quantity >', 0);
        }
        $this->db->group_by('t1.id');
        $this->db->order_by('t1.prd_sort_order', 'ASC');
        // $this->db->order_by('t1.quantity', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getProductAttributeSet($cid)
    {
        $this->db->select("t1.attr_set_id");
        $this->db->from("product t1");
        $this->db->join("cat_prod t2", "t1.id = t2.pid");
        $this->db->where("t2.cid", $cid);
        //        $this->db->where("t1.quantity > ",0);
        $this->db->where("t1.is_active ", 1);
        $this->db->group_by("t1.attr_set_id");
        return $this->db->get()->result_array();
    }

    public function getProductCatAttributeSet($cid)
    {
        $this->db->select("t2.id,t2.attr_set_id");
        $this->db->from("cat_prod t1");
        $this->db->join("product t2", "t2.id = t1.pid");
        $this->db->where("t1.cid", $cid);
        //$this->db->where("t2.quantity > ",0);
        $this->db->group_by("t2.attr_set_id");
        return $this->db->get()->result_array();
    }

    public function listByBrand($bid, $offset = false, $limit = false, $filteredProductIds = false, $order = false)
    {
        if ($this->input->post('no_offset') != '') {
            if ($offset) {
                $this->db->offset($offset);
            }
        }
        if ($limit) {
            $this->db->limit($limit);
        }

        $user_id = $this->session->userdata('CUSTOMER_ID');
        if ($user_id) {
            $this->db->select('t1.*,t3.*,t4.discount, t4.special_price, avg(t5.rate) as avgrate,count(t5.id) as reviewnumber,t1.id as product_id');
        } else {
            $this->db->select('t1.*,t3.*, avg(t5.rate) as avgrate,count(t5.id) as reviewnumber,t1.id as product_id');
        }

        $dbprefix = $this->db->dbprefix;
        $subquery = "(select price from " . $dbprefix . "product where id in (
        select child_id from " . $dbprefix . "product_configurable_link where parent_id = t1.id
        ) order by price limit 1) as least_price";
        $this->db->select($subquery, false);
        //        code
        $subwherequery = "IF(t1.type='config',(select quantity from " . $dbprefix . "product where id in (
        select child_id from " . $dbprefix . "product_configurable_link where parent_id = t1.id
        ) ORDER BY quantity DESC limit 1),t1.quantity) as current_quantity";
        $this->db->select($subwherequery, false);
        //        code
        $this->db->from('product t1');
        $this->db->join('brand t2', 't2.id = t1.bid');
        $this->db->join('prod_img t3', 't1.id = t3.pid AND t3.main = 1', 'left');
        $this->db->join('review t5', 't1.id = t5.product_id AND t5.status = 1', 'left');
        if ($user_id) {
            $this->db->join('product_assignment t4', "t4.product_id = t1.id AND t4.user_id = $user_id", 'left');
        }
        if ($filteredProductIds) {
            $this->db->where_in('t1.id', $filteredProductIds);
        }
        $qu = "t2.id = " . intval($bid) . " AND t1.is_active = 1 AND t1.id NOT IN (select pf.child_id from br_product_configurable_link as pf)";
        $this->db->where($qu);
        if (DWS_SHOW_OUT_STOCK != 1) {
            $this->db->having('current_quantity >', 0);
        }

        if ($order == 'low') {
            $this->db->order_by('t1.price');
        } else if ($order == 'high') {
            $this->db->order_by('t1.price', 'desc');
        } else {
            $this->db->order_by('t1.type');
        }

        $this->db->group_by('t1.id');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function listByCategory_asc_price($cid, $offset = false, $limit = false, $filteredProductIds)
    {
        if ($offset) {
            $this->db->offset($offset);
        }

        if ($limit) {
            $this->db->limit($limit);
        }

        $user_id = $this->session->userdata('CUSTOMER_ID');
        if ($user_id) {
            $this->db->select('t1.*,t3.*,t4.discount, t4.special_price, avg(t5.rate) as avgrate,count(t5.id) as reviewnumber');
        } else {
            $this->db->select('t1.*,t3.*, avg(t5.rate) as avgrate,count(t5.id) as reviewnumber');
        }

        $dbprefix = $this->db->dbprefix;
        $subquery = "(select price from " . $dbprefix . "product where id in (
        select child_id from " . $dbprefix . "product_configurable_link where parent_id = t1.id
        ) order by price limit 1) as least_price";

        $this->db->select($subquery, false);
        $this->db->from('product t1');
        $this->db->join('cat_prod t2', 't2.pid = t1.id');
        $this->db->join('prod_img t3', 't1.id = t3.pid AND t3.main = 1', 'left');
        $this->db->join('review t5', 't1.id = t5.product_id AND t5.status = 1', 'left');
        $this->db->order_by('t1.price');
        if ($user_id) {
            $this->db->join('product_assignment t4', "t4.product_id = t1.id AND t4.user_id = $user_id", 'left');
        }
        // if (!empty($attrIDs)) {
        //     $this->db->join('attribute_varchar t5', "t5.pid = t1.id AND t5.value IN (" . implode(',', $attrIDs) . ")");
        //     $this->db->group_by('t1.id');
        // }
        if ($filteredProductIds) {
            $this->db->where_in('t1.id', $filteredProductIds);
        }
        $qu = "t2.cid = " . intval($cid) . " AND t1.is_active = 1 AND t1.id NOT IN (select pf.child_id from br_product_configurable_link as pf)";
        $this->db->where($qu);
        $this->db->order_by('t1.type');
        $this->db->group_by('t1.id');

        $query = $this->db->get();
        // echo $this->db->last_query();
        return $query->result_array();
    }

    public function listByCategory_desc_price($cid, $offset = false, $limit = false, $filteredProductIds)
    {
        if ($offset) {
            $this->db->offset($offset);
        }

        if ($limit) {
            $this->db->limit($limit);
        }

        $user_id = $this->session->userdata('CUSTOMER_ID');
        if ($user_id) {
            $this->db->select('t1.*,t3.*,t4.discount, t4.special_price, avg(t5.rate) as avgrate,count(t5.id) as reviewnumber');
        } else {
            $this->db->select('t1.*,t3.*, avg(t5.rate) as avgrate,count(t5.id) as reviewnumber');
        }

        $dbprefix = $this->db->dbprefix;
        $subquery = "(select price from " . $dbprefix . "product where id in (
        select child_id from " . $dbprefix . "product_configurable_link where parent_id = t1.id
        ) order by price limit 1) as least_price";

        $this->db->select($subquery, false);
        $this->db->from('product t1');
        $this->db->join('cat_prod t2', 't2.pid = t1.id');
        $this->db->join('prod_img t3', 't1.id = t3.pid AND t3.main = 1', 'left');
        $this->db->join('review t5', 't1.id = t5.product_id AND t5.status = 1', 'left');
        $this->db->order_by('t1.price', 'DESC');
        if ($user_id) {
            $this->db->join('product_assignment t4', "t4.product_id = t1.id AND t4.user_id = $user_id", 'left');
        }
        // if (!empty($attrIDs)) {
        //     $this->db->join('attribute_varchar t5', "t5.pid = t1.id AND t5.value IN (" . implode(',', $attrIDs) . ")");
        //     $this->db->group_by('t1.id');
        // }
        if ($filteredProductIds) {
            $this->db->where_in('t1.id', $filteredProductIds);
        }
        $qu = "t2.cid = " . intval($cid) . " AND t1.is_active = 1 AND t1.id NOT IN (select pf.child_id from br_product_configurable_link as pf)";
        $this->db->where($qu);
        $this->db->order_by('t1.type');
        $this->db->group_by('t1.id');

        $query = $this->db->get();
        // echo $this->db->last_query();
        return $query->result_array();
    }

    public function countByCategory($cid, $filteredProductIds = [])
    {
        $user_id = $this->session->userdata('CUSTOMER_ID');
        if ($user_id) {
            $this->db->select('t1.*,t1.id as product_id, IF(max(t7.quantity) > 0,max(t7.quantity),t1.quantity) as current_quantity, t3.*,t4.discount, t4.special_price, avg(t5.rate) as avgrate,count(t5.id) as reviewnumber,wishlist.product_id as in_wishlist', false);
        } else {
            $this->db->select('t1.*, t1.id as product_id,IF(max(t7.quantity) > 0,max(t7.quantity),t1.quantity) as current_quantity, t3.*, avg(t5.rate) as avgrate,count(t5.id) as reviewnumber', false);
        }

        $this->db->select("IF(min(t7.price),min(t7.price),t1.price) as least_price", false);
        $this->db->from('product t1');
        $this->db->join('cat_prod t2', 't2.pid = t1.id');
        $this->db->join('prod_img t3', 't1.id = t3.pid AND t3.main = 1', 'left');
        $this->db->join('review t5', 't1.id = t5.product_id AND t5.status = 1', 'left');
        if ($user_id) {
            $this->db->join('product_assignment t4', "t4.product_id = t1.id AND t4.user_id = $user_id", 'left');
            $this->db->join('br_wishlist', "br_wishlist.product_id = t1.id AND br_wishlist.customer_id = $user_id", 'left');
        }
        $this->db->join('product_configurable_link t6', 't6.parent_id = t1.id', 'left');
        $this->db->join('product t7', 't7.id = t6.child_id', 'left');

        if ($filteredProductIds) {
            $this->db->where_in('t1.id', $filteredProductIds);
        }
        $qu = "t2.cid = " . intval($cid) . " AND t1.is_active = 1 AND t1.id NOT IN (select pf.child_id from br_product_configurable_link as pf)";
        $this->db->where($qu);
        $this->db->where('t1.is_active', 1);
        //        $this->db->having('current_quantity >', 0);
        if (DWS_SHOW_OUT_STOCK != 1) {
            $this->db->having('current_quantity >', 0);
        }
        $this->db->group_by('t1.id');
        $query = $this->db->get();
        //e($this->db->last_query());
        return $query->num_rows();
    }

    //    function countByCategory($cid, $filteredProductIds = []) {
    //        // $this->db->select('*');
    //        // $this->db->from('product t1');
    //        // $this->db->join('cat_prod t2', 't2.pid = t1.id');
    //        // $this->db->where('t2.cid', intval($cid));
    //        // $this->db->where('t1.is_active', 1);
    //        // if($filteredProductIds) {
    //        //     $this->db->where_in('t1.id',$filteredProductIds);
    //        // }
    //        // return $this->db->count_all_results();
    //        $user_id = $this->session->userdata('CUSTOMER_ID');
    //        $dbprefix = $this->db->dbprefix;
    //        $this->db->select('count(*) as total', false);
    //        $this->db->from('product t1');
    //        $this->db->join('cat_prod t2', 't2.pid = t1.id');
    //        $this->db->join('prod_img t3', 't1.id = t3.pid AND t3.main = 1', 'left');
    //        if ($user_id) {
    //            $this->db->join('product_assignment t4', "t4.product_id = t1.id AND t4.user_id = $user_id", 'left');
    //        }
    //        if ($filteredProductIds) {
    //            $this->db->where_in('t1.id', $filteredProductIds);
    //        }
    //        $qu = "t2.cid = " . intval($cid) . " AND t1.is_active = 1 AND t1.id NOT IN (select pf.child_id from br_product_configurable_link as pf)";
    //        $this->db->where($qu);
    //        $this->db->order_by('t1.type');
    //        $query = $this->db->get();
    //        $data = $query->row_array();
    //        return $data['total'];
    //    }

    public function ChildProducts($pid)
    {
        $this->db->select('t1.*');
        $this->db->from('product t1');
        $this->db->join('product_configurable_link t2', 't2.child_id = t1.id');
        $this->db->where('t2.parent_id', intval($pid));
        $this->db->where('t1.is_active', 1);
        $rs = $this->db->get();
        return $rs->result_array();
    }

    public function ChildProductsWithAttributes($pid)
    {
        $this->db->select('t1.attr_id,t1.custom_name');
        $this->db->from('product_configurable_attr t1');
        $this->db->join('cat_prod c1', 'c1.pid = t1.parent_id', 'LEFT');
        $this->db->where('t1.parent_id', $pid);
        $this->db->group_by('t1.attr_id');
        // $this->db->where('t1.cid',$catid);
        $query = $this->db->get();
        $outputArr = array();
        $attrCustomNames = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $arr) {
                $outputArr[] = $arr['attr_id'];
                if (!empty($arr['custom_name'])) {
                    $attrCustomNames[$arr['attr_id']] = $arr['custom_name'];
                }
            }
        }

        $this->db->select('t1.id');
        $this->db->from('product t1');
        $this->db->join('product_configurable_link t2', 't2.child_id = t1.id');
        $this->db->join('attribute_varchar t3', 't3.pid = t1.id');
        $this->db->where('t2.parent_id', intval($pid));
        if ($outputArr) {
            $this->db->where_in('t3.attr_id', $outputArr);
        }

        $this->db->where('t1.is_active', 1);
        $this->db->where('t1.quantity >', 0);
        $this->db->where("LOWER(t1.type) = 'standard'");
        $this->db->group_by("t1.id");
        $this->db->where("LOWER(t3.value) != 'select'");
        $this->db->where('t3.value !=', 0);
        $this->db->where('t3.value !=', '');
        $this->db->having('COUNT(*) >=' . count($outputArr), false);
        $rs2 = $this->db->get();
        $productsTemp = $rs2->result_array();
        $tempArray = array();
        foreach ($productsTemp as $tid) {
            $tempArray[] = $tid['id'];
        }
        if (empty($tempArray)) {
            return array("products" => array(), "attributes" => array(), "mainAttrID" => 0, 'attrCustomNames' => array());
        }

        $this->db->select('t1.uri,t1.type,t1.price,t1.name,t1.sku,t1.id,t1.id product_id,t3.attr_id,t3.value');
        $this->db->from('product t1');
        $this->db->join('product_configurable_link t2', 't2.child_id = t1.id');
        $this->db->join('attribute_varchar t3', 't3.pid = t1.id');
        $this->db->where('t2.parent_id', intval($pid));
        if ($outputArr) {
            $this->db->where_in('t3.attr_id', $outputArr);
        }

        $this->db->where('t1.is_active', 1);
        $this->db->where("LOWER(t1.type) = 'standard'");
        // temp fix for old data;
        $this->db->where_in('t1.id', $tempArray);
        // temp fix for old data;
        $rs = $this->db->get();
        $products = $rs->result_array();
        $productsKeyBy = array();
        $prodArray = array();
        $pids = array();
        if ($rs->num_rows() > 0) {
            foreach ($rs->result_array() as $key => $product) {
                if (!isset($prodArray[$product['id']])) {
                    $prodArray[$product['id']] = array($product['attr_id'] . "_" . $product['value']);
                } else {
                    $prodArray[$product['id']][] = $product['attr_id'] . "_" . $product['value'];
                }
                if (!in_array($product['id'], $pids)) {
                    $pids[] = $product['id'];
                    $products[$key]['images'] = $this->fetchMultiImages($product['id']);
                    $products[$key]['name'] = str_replace('"', "", str_replace("'", "", $products[$key]['name']));
                    $productsKeyBy[$product['id']] = $products[$key];
                }
            }
        } else {
            return null;
        }
        //        e($productsKeyBy,0);
        //        $productsKeyBy = calculateDynamicPricing($productsKeyBy);
        //        e($productsKeyBy);
        $prodArray = array_map("unserialize", array_unique(array_map("serialize", $prodArray)));
        $pids = array_keys($prodArray);

        $attributesArray = $this->attributesByPids($pids, $outputArr);
        $attributes = array();

        foreach ($attributesArray as $atrr) {
            if (!isset($attributes[$atrr['attr_id']])) {
                $attributes[$atrr['attr_id']] = array(
                    "attr_id" => $atrr['attr_id'],
                    "code" => $atrr['code'],
                    "label" => $atrr['label'],
                    "type" => $atrr['type'],
                    "options" => array(
                        $atrr['id'] => array(
                            "id" => $atrr['id'],
                            "value" => $atrr['value'],
                            "icon" => $atrr['icon'],
                            "products" => array($atrr['pid']),
                            "pPrice" => array($atrr['pid'] => $productsKeyBy[$atrr['pid']]['price']),
                        ),
                    ),
                );
            } else {
                $ab = $attributes[$atrr['attr_id']];
                if (isset($ab['options'][$atrr['id']])) {
                    if (!in_array($atrr['pid'], $ab['options'][$atrr['id']]['products'])) {
                        $ab['options'][$atrr['id']]['products'][] = $atrr['pid'];
                        $ab['options'][$atrr['id']]['pPrice'][$atrr['pid']] = $productsKeyBy[$atrr['pid']]['price'];
                    }
                } else {
                    $ab['options'][$atrr['id']] = array(
                        "id" => $atrr['id'],
                        "value" => $atrr['value'],
                        "icon" => $atrr['icon'],
                        "products" => array($atrr['pid']),
                        "pPrice" => array($atrr['pid'] => $productsKeyBy[$atrr['pid']]['price']),
                    );
                }
                $attributes[$atrr['attr_id']] = $ab;
            }
        }
        $this->db->select('t3.attr_id');
        $this->db->from('product_configurable_attr t3');
        $this->db->where('t3.parent_id', $pid);
        $this->db->where('t3.is_main', 1);
        $rsAt = $this->db->get()->row_array();
        $mainID = 0;
        if (!empty($rsAt)) {
            $mainID = $rsAt['attr_id'];
            $mainAttrArr = $attributes[$mainID];
            unset($attributes[$mainID]);
            $attributes = array($mainID => $mainAttrArr) + $attributes;
        }
        return array("products" => $productsKeyBy, "attributes" => $attributes, "mainAttrID" => $mainID, 'attrCustomNames' => $attrCustomNames);
    }

    public function childIDs($pid)
    {
        $id = array();
        $this->db->select('t1.id as pid');
        $this->db->from('product t1');
        $this->db->join('product_configurable_link t2', 't2.child_id = t1.id');
        $this->db->where('t2.parent_id', intval($pid));
        $this->db->where('t1.is_active', 1);
        $rs = $this->db->get();
        if ($rs->num_rows() > 0) {

            foreach ($rs->result_array() as $childIDs) {
                $id[] = $childIDs['pid'];
            }

            return $id;
        }
        return false;
    }

    public function GroupProducts($pid)
    {
        $attributes = $attrArray = array();
        $this->db->select('t1.*');
        $this->db->from('product t1');
        $this->db->join('product_configurable_link t2', 't2.child_id = t1.id');
        $this->db->where('t2.parent_id', intval($pid));
        $this->db->where('t1.is_active', 1);
        $rs = $this->db->get();
        if ($rs->num_rows() > 0) {
            foreach ($rs->result_array() as $produtc) {
                $attributes[] = self::fetchByProductID($produtc['id']);
                foreach ($attributes as $productA) {
                    foreach ($productA as $valA) {
                        if (!isset($attrArray[$valA['label']]) || !in_array($valA['option'], $attrArray[$valA['label']])) {
                            $attrArray['attributes'][$valA['label']] = $valA['option'];
                        }
                    }
                }
                $combination[] = $produtc + $attrArray;
            }
            return $combination;
        }
        return false;
    }

    public function fetchByProductID($product_id = false)
    {
        $this->db->select('tatt.label, tatt.type, taop.option');
        $this->db->from('attribute_varchar tvar');
        $this->db->join('attribute tatt', 'tvar.attr_id = tatt.id');
        $this->db->join('attribute_option taop', 'taop.id = tvar.value');
        $this->db->where('tvar.pid', $product_id);
        $query = $this->db->get();
        // e($this->db->last_query());
        return $query->result_array();
    }

    public function getProductList()
    {
        $this->db->select('*, GROUP_CONCAT(p3.img) as pictures');
        $this->db->from('product p1');
        $this->db->join('cat_prod p2', 'p2.pid = p1.id');
        $this->db->join('prod_img p3', 'p1.id = p3.pid', 'INNER');
        $this->db->join('category p4', 'p4.id = p2.cid', 'INNER');
        $this->db->where('p4.name', 'T-shirts');
        $this->db->group_by('p3.pid');
        // $this->db->join('prod_img p3', 'p1.id = p3.pid AND p3.main = 1', 'INNER');
        $query = $this->db->get();
        // die($this->db->last_query());
        return $query->result_array();
    }

    public function fetchprice($prodid, $attrid, $value)
    {
        $this->db->select('p1.price');
        $this->db->from('product p1');
        $this->db->join('attribute_varchar var', 'var.pid = p1.id');
        $this->db->where_in('var.pid', $prodid);
        $this->db->where_in('var.attr_id', $attrid);
        $this->db->where_in('var.value', $value);
        $this->db->group_by('var.pid');
        $query = $this->db->get();
        //die($this->db->last_query());
        return $query->result_array();
    }

    public function attributeIDs($parent_id)
    {
        $this->db->select('proatt.*, attr.label, LOWER(attr.label) as clas,proatt.is_main,attr.for_layered,attr.for_details,attr.type');
        $this->db->from('product_configurable_attr as proatt');
        $this->db->join('attribute attr', 'attr.id = proatt.attr_id', 'INNER');
        $this->db->where('proatt.parent_id', $parent_id);
        $this->db->where('for_details', 1);
        $this->db->order_by('proatt.is_main', 'DESC');
        $this->db->order_by('attr.added_on');
        $rs = $this->db->get();

        $result = [];
        foreach ($rs->result_array() as $attrId) {
            $attrId['clas'] = str_replace(' ', '-', $attrId['clas']);
            $result[$attrId['attr_id']] = $attrId;
        }
        return $result;
    }

    public function getChildPrice($pid, $parentID)
    {
        if (!empty($pid)) {
            $this->db->select('min(p1.price) as price,');
            $this->db->from('product p1');
            $this->db->join('br_product_configurable_link t3', 't3.child_id = p1.id', 'INNER');
            $this->db->where_in('p1.id', $pid);
            $this->db->where('t3.parent_id', $parentID);
            $this->db->group_by('p1.price');

            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->row_array();
            }
        }
        return false;
    }

    // get child products
    public function getChildProducts($select = '*', $pid)
    {
        $this->db->select($select);
        $this->db->from('product p1');
        $this->db->join('br_product_configurable_link t3', 't3.parent_id = p1.id');
        $this->db->where('p1.id', $pid);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function fetchMultiImages($id)
    {
        $this->db->select('p2.img,p2.sort_order,p2.desc,p2.imgalt');
        $this->db->from('product as p1');
        $this->db->join('prod_img as p2', 'p2.pid = p1.id', 'INNER');
        $this->db->where('p2.pid', $id);
        $this->db->order_by('p2.main', 'desc');
        $this->db->order_by('p2.sort_order', "ASC");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            //            e($query->result_array());
            return $query->result_array();
        }
        return false;
    }

    public function fetchProductVideos($id)
    {
        $this->db->select('p2.video');
        $this->db->from('product as p1');
        $this->db->join('prod_videos as p2', 'p2.pid = p1.id', 'INNER');
        $this->db->where('p2.pid', $id);
        $this->db->order_by('p2.id', "DESC");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            //            e($query->result_array());
            return $query->result_array();
        }
        return false;
    }

    /* function getChildImages($ids){
      $this->db->select('p2.img');
      $this->db->from('product as p1');
      $this->db->join('prod_img as p2','p2.pid = p1.id AND p2.main = 1','INNER');
      $this->db->where_in('p2.pid', $ids);
      $query = $this->db->get();
      if ($query->num_rows() > 0) {
      return $query->result_array();
      }
      return false;

      } */

    public function getAttrDetail($pid)
    {
        $this->db->select('t3.id,t3.option as value, t2.label,t2.code');
        $this->db->from('attribute_varchar t1');
        $this->db->join('attribute t2', 't2.id = t1.attr_id');
        $this->db->join('attribute_option t3', 't3.id = t1.value');
        $this->db->where_in('t1.pid', $pid);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function attributeIDsBypro($pids)
    {
        $this->db->select('t1.*, t2.label,t2.is_main');
        $this->db->from('attribute_varchar as t1');
        $this->db->join('attribute t2', 't2.id = t1.attr_id', 'INNER');
        $this->db->where_in('pid', $pids);
        $this->db->where('t2.for_layered', 1);
        $rs = $this->db->get();
        $result = [];
        foreach ($rs->result_array() as $attrId) {
            $result[$attrId['attr_id']] = $attrId;
        }
        return $result;
    }

    public function attributesByPids($pids, $attributes = array())
    {
        $this->db->select('t3.id,t1.attr_id,t3.option as value,t3.icon,t2.label,t2.type,t2.code,t1.pid');
        $this->db->from('attribute_varchar t1');
        $this->db->join('attribute t2', 't2.id = t1.attr_id');
        $this->db->join('attribute_option t3', 't3.id = t1.value');
        //$this->db->group_by('t1.attr_id');
        $this->db->where_in('t1.pid', $pids);
        if (!empty($attributes)) {
            $this->db->where_in('t2.id', $attributes);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function fetchAtrrValuesBypro($pids, $att_id = [])
    {
        $this->db->select('tvar.value, count(tvar.pid) as pidnums, opt.option, opt.attr_id, opt.icon, opt.additional_info');
        $this->db->from('attribute_varchar tvar');
        $this->db->join('attribute_option opt', 'opt.id = tvar.value', 'INNER');
        $this->db->where_in('tvar.pid', $pids);
        if ($att_id) {
            $this->db->where_in('tvar.attr_id', $att_id);
        }
        $this->db->group_by('tvar.value');
        $query2 = $this->db->get();
        //        die($this->db->last_query());
        return $query2->result_array();
    }

    public function fetchProductsByCategory($select = "*", $category, $filterPera = false)
    {
        $this->db->select($select);
        $this->db->from('product t1');
        $this->db->join('cat_prod t2', "t1.id=t2.pid AND t2.cid=$category");
        if ($filterPera) {
            $this->db->join('attribute_varchar t3', "t3.pid = t1.id AND t3.value IN (" . implode(',', $filterPera) . ")");
            $this->db->group_by('t1.id');
        }
        $data = $this->db->get()->result_array();
        //        e($this->db->last_query());
        return $data;
    }

    public function fetchProductsByBrand($select = "*", $bid)
    {
        $this->db->select($select);
        $this->db->from('product t1');
        $this->db->join('brand t2', "t1.bid=t2.id AND t2.id=$bid");
        $data = $this->db->get()->result_array();
        return $data;
    }

    public function attributeIDsByCat($catAttr, $pids)
    {
        $this->db->select('t1.*,t2.name, t2.code');
        $this->db->from('attribute_option t1');
        $this->db->join('attribute t2', 't2.id = t1.attr_id');
        $this->db->join('attr_attrset t3', 't3.attr_id = t1.attr_id');
        $this->db->join('attribute_varchar t4', "t4.value = t1.id AND t4.pid IN (" . implode(',', $pids) . ")");
        $this->db->where('t3.set_id', $catAttr);
        $this->db->group_by('t1.id');
        $rs = $this->db->get();
        //        e($this->db->last_query());
        if ($rs->num_rows() > 0) {
            //            return $rs->result_array();
            foreach ($rs->result_array() as $attrs) {
                $attrsCat[$attrs['name']][] = $attrs;
            }
            return $attrsCat;
        }
    }

    public function getProductIdsFromAttributes($select = '*', $attribute_id, $values = false, $ids = [])
    {
        $this->db->select($select)
            ->from('attribute_varchar');
        if ($attribute_id) {
            $this->db->where('attr_id', $attribute_id);
        }
        if ($values) {
            $this->db->where_in('value', $values);
        }
        if ($ids) {
            $this->db->where_in('pid', $ids);
        }
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function findProductByCombination($combination = [], $ids = [])
    {
        foreach ($combination as $key => $value) {
            $this->db
                ->select('distinct pid', false)
                ->from('attribute_varchar')
                ->where('attr_id', $key)
                ->where('value', $value);
            if ($ids) {
                $this->db->where_in('pid', $ids);
            }
            $result = $this->db->get()->result_array();
            $tmp = array_column($result, 'pid');
            $ids = $tmp;
        }
        return $ids;
    }

    public function getProductPrice($id, $user_id = 0, $profile_id = 0, $quantity = 1, $select = "*")
    {
        $is_logged_in = $this->session->userdata('CUSTOMER_ID');
        if ($is_logged_in) {
            $result = $this->priceCallback($id, $user_id, $profile_id, $quantity, $select);
        } else {
            $result = $this->priceCallback($id, $user_id, 0, $quantity, $select);
        }
        if (empty($result['tier_price'])) {
            $result = $this->priceCallback($id, $user_id, $profile_id, $quantity, $select);
        }
        return $result;
    }

    public function priceCallback($id, $user_id = 0, $profile_id = 0, $quantity = 1, $select = "*")
    {
        $actual_prod_id = $id;
        $return = [];
        //        code
        $get_parent_pro = product_pack($id);
        $id = $get_parent_pro['id'];

        if ($select == '*') {
            $this->db
                ->select("t1.price,t1.inc_or_exl_tax,t3.discount d1,t3.special_price s1,t3.assign_type,t4.discount d2,t4.special_price s2,t1.id as product_id,t1.type,t1.is_offer_discount");
        } else {
            $this->db
                ->select("$select,t1.price,t1.inc_or_exl_tax,t3.discount d1,t3.special_price s1,t3.assign_type,t4.discount d2,t4.special_price s2,t1.id as product_id,t1.type,t1.is_offer_discount");
        }
        $result = $this->db
            ->from('product t1')
            ->join('cat_prod t2', 't2.pid=t1.id AND t2.main=1', 'left')
            ->join('category_assignment t3', 't3.catid=t2.cid AND t3.user_id=' . $user_id, 'left')
            ->join('product_assignment t4', 't4.product_id=t1.id AND t4.active=1 AND t4.user_id=' . $user_id, 'left')
            ->where('t1.id', $id)
            ->get()->row_array();

        $return = $result;
        $return['price'] = $result['price'];
        $return['actual_price'] = $result['price'];
        $return['discounting_type'] = $result['assign_type'];
        $return['tier_price'] = $return['special_price'] = $return['special_price_type'] = '';

        // get tier prices starts
        if ($this->session->userdata('CUSTOMER_ID')) {
            $user_group_id = user_group_id($this->session->userdata('CUSTOMER_ID'));
        } else {
            $user_group_id = 0;
        }

        $tier_price = $this->db->select('*')
            ->from('quantity_range')
            ->where('pid', $id)
            ->where('group_id', $user_group_id)
            ->where('qty_from <=', $quantity)
            ->where('qty_to >=', $quantity)
            ->order_by('qty_range_val', 'desc')
            ->limit(1)
            ->get()->row_array();
        // get tier prices ends
        $let_group_price = display_group_prices_acc_to_category($this->session->userdata('CUSTOMER_ID'), $id);
        if ($tier_price && $let_group_price != 0) {
            $return['tier_price'] = $tier_price['qty_range_val'];
            $return['price'] = $tier_price['qty_range_val'];
        } else {
            if ($let_group_price != 0) {
                $last_group_value = last_group_value($quantity, $id, $user_group_id);
            } else {
                $last_group_value = array();
            }
            if ($last_group_value) {
                $return['tier_price'] = $last_group_value['qty_range_val'];
                $return['price'] = $last_group_value['qty_range_val'];
            } else {
                $check_ooffer = check_ooffer($this->input->post('pid'));
                if ($check_ooffer) {
                    $return['tier_price'] = $check_ooffer;
                    $return['price'] = $check_ooffer;
                } else {
                    $get_parent_child_price = get_parent_child_price($actual_prod_id);
                    $return['tier_price'] = $get_parent_child_price['price'];
                    $return['price'] = $get_parent_child_price['price'];
                }
            }
        }

        return $return;
    }

    public function getAttributeFromName($code)
    {
        $row = $this->db
            ->where('code', $code)
            ->get('attribute')
            ->row_array();
        return $row;
    }

    public function getConfigProducts($ids = [])
    {
        $ids = $this->db
            ->select('distinct parent_id as pid', false)
            ->from('product_configurable_link')
            ->where_in('child_id', $ids)
            ->get()->result_array();
        $ids = array_column($ids, 'pid');
        return $ids;
    }

    public function is_wishlisted($product_id)
    {
        $rs = $this->db->select('id')
            ->where('product_id', $product_id)
            ->where('customer_id', $this->session->userdata('CUSTOMER_ID'))
            ->get('wishlist');

        if ($rs->num_rows() == 1) {
            return true;
        }

        return false;
    }

    public function array_column1(array $input, $columnKey, $indexKey = null)
    {
        $array = array();
        foreach ($input as $value) {
            if (!array_key_exists($columnKey, $value)) {
                trigger_error("Key \"$columnKey\" does not exist in array");
                return false;
            }
            if (is_null($indexKey)) {
                $array[] = $value[$columnKey];
            } else {
                if (!array_key_exists($indexKey, $value)) {
                    trigger_error("Key \"$indexKey\" does not exist in array");
                    return false;
                }
                if (!is_scalar($value[$indexKey])) {
                    trigger_error("Key \"$indexKey\" does not contain scalar value");
                    return false;
                }
                $array[$value[$indexKey]] = $value[$columnKey];
            }
        }
        return $array;
    }

    public function config_ids($products)
    {
        $arr = array();

        if ($products) {
            foreach ($products as $item) {
                if ($item['type'] == 'config') {
                    array_push($arr, $item['pid']);
                }
            }

            if ($arr) {
                $rs = $this->db->distinct()
                    ->select('parent_id')
                    ->where_in('parent_id', $arr)
                    ->get('product_configurable_link');

                if ($rs->num_rows()) {
                    $rs = $rs->result_array();
                    $result = array();

                    foreach ($rs as $item) {
                        array_push($result, $item['parent_id']);
                    }

                    return $result;
                }
            }
        }

        return false;
    }

    // This is copy of above function as some products have id and not pid
    public function config_ids_2($products)
    {
        $arr = array();

        if ($products) {
            foreach ($products as $item) {
                if ($item['type'] == 'config') {
                    array_push($arr, $item['id']);
                }
            }

            if ($arr) {
                $rs = $this->db->distinct()
                    ->select('parent_id')
                    ->where_in('parent_id', $arr)
                    ->get('product_configurable_link');

                if ($rs->num_rows()) {
                    $rs = $rs->result_array();
                    $result = array();

                    foreach ($rs as $item) {
                        array_push($result, $item['parent_id']);
                    }

                    return $result;
                }
            }
        }

        return false;
    }

    public function child_count($product_id)
    {
        $rs = $this->db->select('child_id')
            ->where('parent_id', $product_id)
            ->get('product_configurable_link');

        return $rs->num_rows();
    }

    public function category_price_range($cid)
    {
        $result = $this->db
            ->select('max(t1.price) max_price,min(t1.price) min_price')
            ->from('product t1')
            ->join('cat_prod t2', 't2.pid = t1.id')
            ->where('t1.is_active', 1)
            ->where('t1.quantity >', 0)
            ->where('t2.cid', $cid)
            ->where('t1.type <>', 'config')
            ->get()->row_array();
        return $result;
    }

    public function brand_price_range($bid)
    {
        $result = $this->db
            ->select('max(t1.price) max_price,min(t1.price) min_price')
            ->from('product t1')
            ->join('brand t2', 't2.id = t1.bid')
            ->where('t1.is_active', 1)
            ->where('t2.id', $bid)
            ->where('t1.type <>', 'config')
            ->get()->row_array();
        return $result;
    }

    public function get_accessories($product_id)
    {
        $rs = array();
        $rs = $this->db->select('accessories.*, product.name as name')
            ->from('accessories')
            ->join('product', 'product.id = accessories.product_id')
            ->where('accessories.config_product_id', $product_id)
            ->get();

        if ($rs->num_rows()) {
            return $rs->result_array();
        }

        return false;
    }

    public function filter_products($out = false, $order = false, $opt = false, $perpage = false, $offset = false)
    {

        $config_products = array();
        $children = array();
        $non_children = array();
        $result = array();
        $finalAllChilds = [];

        // Get id of config product for all children in $out.
        $rs = array();
        $rs = $this->db->distinct()
            ->select('parent_id')
            ->from('product_configurable_link')
            ->where_in('child_id', $out)
            ->get();

        if ($rs->num_rows()) {
            $rs = $rs->result_array();
            $config_products = array_column($rs, 'parent_id');
        }

        // Get id of all child products in general.
        $rs = array();
        $rs = $this->db->distinct()
            ->select('child_id')
            ->from('product_configurable_link')
            ->get();

        if ($rs->num_rows()) {
            $rs = $rs->result_array();
            $children = array_column($rs, 'child_id');
        }
        // Get id of all non-child products in $out.
        foreach ($out as $k => $v) {
            if (!in_array($v, $children)) {
                array_push($non_children, $v);
            }
        }

        // Put config and standard products in an array
        $result = $configids = $config_products;

        foreach ($non_children as $k => $v) {
            if (!in_array($v, $result)) {
                array_push($result, $v);
            }
        }

        /*
          $onlyChilds = $this->db->select('child_id')
          ->where_in('parent_id', $configids)
          ->get('product_configurable_link')->result_array();

          $childIdsArr = [];
          if($onlyChilds){
          $childIdsArr = array_column($onlyChilds,'child_id');
          }
          //e( $childIdsArr );
          $aa = $opt;
          $this->db->select('attribute_varchar.*');
          $this->db->where_in('attribute_varchar.pid', $childIdsArr);
          $this->db->where_in('attribute_varchar.value', $aa);
          $res = $this->db->get('attribute_varchar')->result_array();

          //e( $this->db->last_query() );

          $pidsArr = [];
          if($res){
          $pidsArr = array_column($res, 'pid');
          }
          //e( $pidsArr );
          $this->db->select('product_configurable_link.parent_id');
          $this->db->where_in('product_configurable_link.child_id', $pidsArr);
          $this->db->group_by('parent_id');
          $queryResult = $this->db->get('product_configurable_link')->result_array();
          e( $this->db->last_query() );
          $finalConfigIds = array_column($queryResult,'parent_id');

          e( $finalConfigIds );

          $result = [];
          $result = array_merge($finalConfigIds,$non_children);
          //e( $result );

         */

        //if ($offset)
        //            $this->db->offset($offset);
        //        if ($limit)
        //            $this->db->limit($limit);
        //        $user_id = $this->session->userdata('CUSTOMER_ID');
        //        if ($user_id) {
        //            $this->db->select('t1.*,t1.id as product_id, IF(max(t7.quantity) > 0,max(t7.quantity),t1.quantity) as current_quantity, t3.*,t4.discount, t4.special_price, avg(t5.rate) as avgrate,count(t5.id) as reviewnumber,wishlist.product_id as in_wishlist', FALSE);
        //        } else {
        //            $this->db->select('t1.*, t1.id as product_id,IF(max(t7.quantity) > 0,max(t7.quantity),t1.quantity) as current_quantity, t3.*, avg(t5.rate) as avgrate,count(t5.id) as reviewnumber', FALSE);
        //        }
        //
        //        $this->db->select("IF(min(t7.price),min(t7.price),t1.price) as least_price", false);
        //        $this->db->from('product t1');
        //        $this->db->join('cat_prod t2', 't2.pid = t1.id');
        //        $this->db->join('prod_img t3', 't1.id = t3.pid AND t3.main = 1', 'left');
        //        $this->db->join('review t5', 't1.id = t5.product_id AND t5.status = 1', 'left');
        //        if ($user_id) {
        //            $this->db->join('product_assignment t4', "t4.product_id = t1.id AND t4.user_id = $user_id", 'left');
        //            $this->db->join('br_wishlist', "br_wishlist.product_id = t1.id AND br_wishlist.customer_id = $user_id", 'left');
        //        }
        //        $this->db->join('product_configurable_link t6', 't6.parent_id = t1.id', 'left');
        //        $this->db->join('product t7', 't7.id = t6.child_id', 'left');
        //
        //        if ($filteredProductIds) {
        //            $this->db->where_in('t1.id', $filteredProductIds);
        //        }
        //        $qu = "t2.cid = " . intval($cid) . " AND t1.is_active = 1 AND t1.id NOT IN (select pf.child_id from br_product_configurable_link as pf)";
        //        $this->db->where($qu);
        //        $this->db->where('t1.is_active', 1);
        ////        $this->db->where('t1.quantity >', 0);
        ////        $this->db->order_by('t1.quantity', 'DESC');
        //
        //        if ($order == 'DESC') {
        //            $this->db->order_by('t1.price', 'DESC');
        //        } else {
        ////            e(4);
        //            $this->db->order_by('t1.price','asc');
        //            $this->db->order_by('t1.price','asc');
        //        }
        //        $this->db->having('current_quantity >', 0);
        ////        $this->db->having('least_price ', "asc");
        //        $this->db->group_by('t1.id');
        //        $query = $this->db->get();
        //
        //        return $query->result_array();
        //        $this->db->select('parent.id as product_id, parent.*, min(child.price) as least_price ,IF(max(child.quantity) > 0,max(child.quantity),parent.quantity) as current_quantity');
        //        $this->db->from('product as parent');
        //        $this->db->join('product_configurable_link as rel', 'rel.parent_id = parent.id', 'left');
        //        $this->db->join('product as child', 'child.id = rel.child_id', 'left');
        //        $this->db->where_in('parent.id', $result);
        //
        //        if ($order == 'ASC') {
        //            $this->db->order_by('least_price', 'ASC');
        //        } else if ($order == 'DESC') {
        //            $this->db->order_by('least_price', 'DESC');
        //        }
        //        if ($offset) {
        //            $this->db->offset($offset);
        //        }
        //        if ($perpage) {
        //            $this->db->limit($perpage);
        //        }
        //        $this->db->group_by('product_id');
        //
        //        $rs = array();
        //        $rs = $this->db->get();
        //
        //        if ($rs->num_rows()) {
        //            return $rs->result_array();
        //        }
        $cid = $this->input->post("category_id");
        $rre = $this->listByCategory($cid, $offset, $perpage, $result, $order);
        return $rre;
    }

    public function count_filter_products($out = false, $order = false)
    {
        $config_products = array();
        $children = array();
        $non_children = array();
        $result = array();

        // Get id of config product for all children in $out.
        $rs = array();
        $rs = $this->db->distinct()
            ->select('parent_id')
            ->from('product_configurable_link')
            ->where_in('child_id', $out)
            ->get();

        if ($rs->num_rows()) {
            $rs = $rs->result_array();
            $config_products = array_column($rs, 'parent_id');
        }

        // Get id of all child products in general.
        $rs = array();
        $rs = $this->db->distinct()
            ->select('child_id')
            ->from('product_configurable_link')
            ->get();

        if ($rs->num_rows()) {
            $rs = $rs->result_array();
            $children = array_column($rs, 'child_id');
        }

        // Get id of all non-child products in $out.
        foreach ($out as $k => $v) {
            if (!in_array($v, $children)) {
                array_push($non_children, $v);
            }
        }

        // Put config and standard products in an array
        $result = $config_products;

        foreach ($non_children as $k => $v) {
            if (!in_array($v, $result)) {
                array_push($result, $v);
            }
        }

        $this->db->select('parent.id as pid, parent.*, min(child.price) as least_price');
        $this->db->from('product as parent');
        $this->db->join('product_configurable_link as rel', 'rel.parent_id = parent.id', 'left');
        $this->db->join('product as child', 'child.id = rel.child_id', 'left');
        $this->db->where_in('parent.id', $result);

        if ($order == 'ASC') {
            $this->db->order_by('least_price', 'ASC');
        } else if ($order == 'DESC') {
            $this->db->order_by('least_price', 'DESC');
        }

        $this->db->group_by('pid');

        $rs = array();
        $rs = $this->db->get();

        if ($rs->num_rows()) {
            return $rs->num_rows();
        }
    }

    public function total_filter_products($out = false)
    {
        $config_products = array();
        $children = array();
        $non_children = array();
        $result = array();

        // Get id of config product for all children in $out.
        $rs = array();
        $rs = $this->db->distinct()
            ->select('parent_id')
            ->from('product_configurable_link')
            ->where_in('child_id', $out)
            ->get();

        if ($rs->num_rows()) {
            $rs = $rs->result_array();
            $config_products = array_column($rs, 'parent_id');
        }

        // Get id of all child products in general.
        $rs = array();
        $rs = $this->db->distinct()
            ->select('child_id')
            ->from('product_configurable_link')
            ->get();

        if ($rs->num_rows()) {
            $rs = $rs->result_array();
            $children = array_column($rs, 'child_id');
        }

        // Get id of all non-child products in $out.
        foreach ($out as $k => $v) {
            if (!in_array($v, $children)) {
                array_push($non_children, $v);
            }
        }

        // Put config and standard products in an array
        $result = $config_products;

        foreach ($non_children as $k => $v) {
            if (!in_array($v, $result)) {
                array_push($result, $v);
            }
        }
        $this->db->select('parent.id as pid, parent.*, min(child.price) as least_price');
        $this->db->from('product as parent');
        $this->db->join('product_configurable_link as rel', 'rel.parent_id = parent.id', 'left');
        $this->db->join('product as child', 'child.id = rel.child_id', 'left');
        $this->db->where_in('parent.id', $result);
        $this->db->group_by('pid');

        $rs = array();
        $rs = $this->db->get();
        if ($rs->num_rows()) {
            return $rs->result_array();
        }
    }

    public function count_products($category_id)
    {
        // Get id of all products which are children of any configurable product.
        $children = array();
        $rs = array();
        $rs = $this->db->distinct()
            ->select('child_id')
            ->from('product_configurable_link')
            ->join('product', 'product.id = product_configurable_link.child_id')
            ->where('product.quantity >', 0)
            ->get();

        if ($rs->num_rows()) {
            $rs = $rs->result_array();
            $children = array_column($rs, 'child_id');
        }
        if ($children) {
            // End - Get id of all products which are child of any product.
            // Get total number of products which are either configurable or standard but not child.
            $rs = array();
            $rs = $this->db->select('product.id')
                ->from('product')
                ->join('cat_prod', 'cat_prod.pid = product.id')
                ->where('cat_prod.cid', $category_id)
                ->where_not_in('product.id', $children)
                ->get();

            return $rs->num_rows();
        } else {
            return 0;
        }
        // End - Get number of products which are either configurable or standard but not child.
    }

    public function getParentSku($pid)
    {
        $rs = array();
        $rs = $this->db->distinct()
            ->select('product.sku')
            ->from('product')
            ->join('product_configurable_link', 'product_configurable_link.parent_id = product.id')
            ->where('product_configurable_link.child_id', $pid)
            ->get();
        if ($rs->num_rows() == 1) {
            return $rs->row_array();
        }
    }

    public function getBrochures($pid)
    {
        $this->db->select('p1.brochure');
        $this->db->from('product_brochures p1');
        $this->db->join('product_brochures_link p2', 'p2.bid = p1.id');
        $this->db->where('p2.pid', $pid);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Function by @Rav for Product Attribute values
    public function getFilteredProductAttributeValue($products)
    {

        $selected_min_price = $this->input->post('selected_min_price');
        $selected_max_price = $this->input->post('selected_max_price');

        $childIds_1 = [];
        $childIds_2;
        $configids = [];
        $finalPids = [];

        foreach ($products as $k => $v) {
            if ($v['type'] == 'config') {
                $configids[] = $v['product_id'];
            } else {
                $childIds_1[] = $v['product_id'];
            }
        }

        if ($configids) {

            $this->db->select('child_id');
            $this->db->where_in('parent_id', $configids);
            $queryRes = $this->db->get('product_configurable_link')->result_array();
            if ($queryRes) {
                $childIds_2 = array_column($queryRes, 'child_id');
            }
        }

        $finalPids = array_merge($childIds_1, $childIds_2);

        $res = $this->db->select('attribute_varchar.value, product.name')
            ->where("`br_attribute_varchar`.`value`!=''", false, false)
            ->where("product.price >=", $selected_min_price)
            ->where("product.price <=", $selected_max_price)
            ->where_in('attribute_varchar.pid', $finalPids)
            ->join('product', 'product.id = attribute_varchar.pid', 'LEFT')
            ->group_by('attribute_varchar.value')
            ->get('attribute_varchar')
            ->result_array();
        //e( $res );
        return $res;
    }

    public function brand_by_product($cid, $productIds = [])
    {
        if ($productIds) {
            $productIds = implode(',', $productIds);
            return $this->db->select('t1.*')
                ->from('brand t1')
                ->join('product t2', 't2.bid=t1.id')
                ->join('product_configurable_link t3', "t3.child_id = t2.id OR t2.id = t3.parent_id", 'left')
                ->where("t3.child_id IN ($productIds) OR t3.parent_id IN ($productIds) OR t3.parent_id IS NULL", null)
                ->where('is_active', 1)
                ->group_by('t1.id')
                ->get()->result_array();
        } else {
            return $this->db->select('t3.*')
                ->from('product t1')
                ->join('cat_prod t2', 't2.pid = t1.id')
                ->join('brand t3', 't3.id = t1.bid')
                ->where('t1.is_active', 1)
                ->where('t2.cid', $cid)
                ->group_by('t3.id')
                ->get()->result_array();
        }
    }

    public function getCategoryFiltersProducts($category_id, $attributes = array(), $extra = array())
    {
        // e($attributes,0);
        // e($extra);
        $product_ids_matching_option_criteria = $product_ids_matching_price_slider = array();
        $brands = $selected_min_price = $selected_max_price = 0;
        // e($extra);
        if (isset($extra['selected_min_price'])) {
            $selected_min_price = $extra['selected_min_price'];
        }

        if (isset($extra['selected_max_price'])) {
            $selected_max_price = $extra['selected_max_price'];
        }

        // Get Product Ids matching Price Slider Range.
        if ($selected_min_price || $selected_max_price) {
            // e("$selected_min_price || $selected_max_price");
            $rs = $this->db->select('product.id')
                ->from("product")
                ->join("cat_prod", "cat_prod.pid = product.id")
                ->where("price >=", $selected_min_price)
                ->where("price <=", $selected_max_price)
                ->where("cat_prod.cid =", $category_id)
                ->where("is_active =", 1)
                ->get();
            if ($rs->num_rows()) {
                $rs = $rs->result_array();
                $product_ids_matching_price_slider = array_column($rs, 'id');
            }
        }

        // Get Product ids matching options (Attribute Values like size color etc.)
        if (isset($attributes['undefined'])) {
            unset($attributes['undefined']);
        }

        if ($attributes) {
            $arr = array();
            foreach ($attributes as $k => $v) {
                if ($v) {
                    $this->db->select('attribute_varchar.pid as id');
                    $this->db->from('attribute_varchar');
                    $this->db->join('cat_prod', 'cat_prod.pid = attribute_varchar.pid');
                    $this->db->join('product', 'product.id = attribute_varchar.pid');
                    $this->db->where('product.is_active', 1);
                    $this->db->where('cat_prod.cid', $category_id);
                    $this->db->where('attr_id', $k);
                    $this->db->where_in('attribute_varchar.value', $v);
                    if ($arr) {
                        $this->db->where_in('attribute_varchar.pid', $arr);
                    }
                    $rs = $this->db->get();
                    if ($rs->num_rows()) {
                        $rs = $rs->result_array();
                        $arr = array_column($rs, 'id');
                    } else {
                        // if not records have been found.
                        $arr = array();
                    }
                }
            }
            // e(1);
            $product_ids_matching_option_criteria = $arr;
        }
        // e($product_ids_matching_option_criteria);

        $out = array();

        if ($product_ids_matching_price_slider && $product_ids_matching_option_criteria) {
            // e(1);
            $out = array_intersect($product_ids_matching_price_slider, $product_ids_matching_option_criteria);
        } elseif ($product_ids_matching_price_slider) {
            // e(2);
            $out = $product_ids_matching_price_slider;
        } elseif ($product_ids_matching_option_criteria) {
            // e(3);
            $out = $product_ids_matching_option_criteria;
        }
        if (!$out) {
            return false;
        }
        // e($out);

        $tmp = $this->db
            ->select('parent_id')
            ->from('product_configurable_link')
            ->where_in('child_id', $out)
            ->group_by('parent_id')
            ->get()->result_array();

        $tmp = array_column($tmp, 'parent_id');

        $out = array_unique(array_merge($tmp, $out), SORT_REGULAR);

        return $out;
    }

    public function getBrandFiltersProducts($bid, $attributes = array(), $extra = array())
    {
        $product_ids_matching_option_criteria = $product_ids_matching_price_slider = array();
        $brands = $selected_min_price = $selected_max_price = 0;

        if (isset($extra['selected_min_price'])) {
            $selected_min_price = $extra['selected_min_price'];
        }

        if (isset($extra['selected_max_price'])) {
            $selected_max_price = $extra['selected_max_price'];
        }

        $rs = $this->db->select('product.id')
            ->from("product")
            ->where("price >=", $selected_min_price)
            ->where("price <=", $selected_max_price)
            ->where("bid =", $bid)
            ->where("is_active =", 1)
            ->get();
        if ($rs->num_rows()) {
            $rs = $rs->result_array();
            $product_ids_matching_price_slider = array_column($rs, 'id');
        }

        // Get Product ids matching options (Attribute Values like size color etc.)
        if (isset($attributes['undefined'])) {
            unset($attributes['undefined']);
        }

        if ($attributes) {
            $arr = array();
            foreach ($attributes as $k => $v) {
                if ($v) {
                    $this->db->select('attribute_varchar.pid as id');
                    $this->db->from('attribute_varchar');
                    $this->db->join('product', 'product.id = attribute_varchar.pid');
                    $this->db->where('product.is_active', 1);
                    $this->db->where('product.bid', $bid);
                    $this->db->where('attr_id', $k);
                    $this->db->where_in('attribute_varchar.value', $v);
                    if ($arr) {
                        $this->db->where_in('attribute_varchar.pid', $arr);
                    }
                    $rs = $this->db->get();
                    if ($rs->num_rows()) {
                        $rs = $rs->result_array();
                        $arr = array_column($rs, 'id');
                    } else {
                        // if not records have been found.
                        $arr = array();
                    }
                }
            }
            $product_ids_matching_option_criteria = $arr;
        }
        $out = array();
        if ($product_ids_matching_price_slider && $product_ids_matching_option_criteria) {
            $out = array_intersect($product_ids_matching_price_slider, $product_ids_matching_option_criteria);
            if (!$out) {
                $out = $product_ids_matching_option_criteria;
            }
        } elseif ($product_ids_matching_price_slider) {
            // e(2);
            $out = $product_ids_matching_price_slider;
        } elseif ($product_ids_matching_option_criteria) {
            // e(3);
            $out = $product_ids_matching_option_criteria;
        }
        if (!$out) {
            return false;
        }

        $tmp = $this->db
            ->select('parent_id')
            ->from('product_configurable_link')
            ->where_in('child_id', $out)
            ->group_by('parent_id')
            ->get()->result_array();

        $tmp = array_column($tmp, 'parent_id');
        $out = array_unique(array_merge($tmp, $out), SORT_REGULAR);

        return $out;
    }

    public function getAttributeIdByName($name)
    {
        return $this->db->select('id,type')
            ->from('attribute')
            ->where('name', $name)
            ->get()->row_array();
    }

    public function getAttributeValueIdByName($name, $type)
    {
        // e($type);
        $this->db->select('id');
        if ($type == 'text') {
            $table = 'attribute_text';
            $field = 'text';
        } else {
            $table = 'attribute_option';
            $field = 'option';
        }
        $this->db->from($table);
        $tmp = $this->db
            ->where_in($field, $name)
            ->get()->result_array();
        return array_column($tmp, 'id');
    }

    public function fetchBranchByName($name, $select = "*")
    {
        return $this->db
            ->select($select)
            ->from('brand')
            ->where_in('name', $name)
            ->get()->result_array();
    }

    public function getProductBidAttributeSet($bid)
    {
        $this->db->select("id,attr_set_id");
        $this->db->from("product");
        $this->db->where("bid", $bid);
        $this->db->group_by("attr_set_id");
        return $this->db->get()->result_array();
    }

    function filter_products_brands($out)
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
        $CI->db->where_in('t1.id', $out);
        $CI->db->where('t1.is_active = 1');
        $CI->db->limit(16);
        $CI->db->order_by('t1.id', 'desc');
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

    public function fetchByIdCart($pid, $ignoreChild = false)
    {
        $user_id = $this->session->userdata('CUSTOMER_ID');
        if ($user_id) {
            $this->db->select('t1.*, t2.img, t2.imgalt,t3.discount, t3.special_price, t4.cid,t1.id as product_id, t8.name as bname, t9.name as cname');
        } else {

            $this->db->select('t1.*, t2.img, t2.imgalt, t4.cid,t1.id as product_id, t8.name as bname, t9.name as cname');
        }

        //$this->db->select('product_image.product_id AS p1, product_image.*, product.*, leadlabel');
        $this->db->from('product t1');
        $this->db->join('prod_img t2', 't1.id = t2.pid AND t2.main = 1', 'left');
        $this->db->join('cat_prod t4', 't1.id = t4.pid', 'left');
        if ($user_id) {
            $this->db->join('product_assignment t3', "t3.product_id = t1.id AND t3.user_id = $user_id", 'left');
        }
        //$this->db->join('review t4', 't1.id = t4.product_id AND t4.status = 1', 'left');
        //$this->db->join('leadtime', 'product.product_id = leadtime.product_id AND selected = 1', 'left');

        $this->db->join('brand t8', 't8.id = t1.bid', 'LEFT');
        $this->db->join('category t9', 't9.id = t4.cid', 'LEFT');

        /* if (!$ignoreChild) {
            $qu = "t1.id NOT IN (select pf.child_id from br_product_configurable_link as pf where pf.child_id != pf.parent_id)";
            $this->db->where($qu);
        } */
        $this->db->where('t1.is_active', 1);
        $this->db->where('t1.id', $pid)->limit(1);
        //echo $this->db->last_query();
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->row_array();
        }
        return false;
    }

    public function getCategoryFilteredProducts($category_id, $selected_attribute_options = [])
    {

        $product_ids_matching_option_criteria = array();

        // Get Product ids matching options
        if (isset($selected_attribute_options['undefined'])) {
            unset($selected_attribute_options['undefined']);
        }

        if ($selected_attribute_options) {
            $arr = array();
            if (!isset($my_arr)) {
                $my_arr = array();
            }
            foreach ($selected_attribute_options as $k => $v) {
                if ($v) {
                    $this->db->select('attribute_varchar.pid as id');
                    $this->db->from('attribute_varchar');
                    $this->db->join('cat_prod', 'cat_prod.pid = attribute_varchar.pid');
                    $this->db->join('product', 'product.id = attribute_varchar.pid');
                    $this->db->where('product.is_active', 1);
                    $this->db->where('cat_prod.cid', $category_id);
                    //                    $this->db->where('attr_id', $k);
                    $this->db->where('attribute_varchar.value', $v);
                    if ($arr) {
                        //                        $this->db->where_in('attribute_varchar.pid', $arr);
                    }
                    $rs = $this->db->get();
                    if ($rs->num_rows()) {
                        $rs = $rs->result_array();
                        $arr = array_column($rs, 'id');
                        if ($arr) {
                            foreach ($arr as $arr_item) {
                                array_push($my_arr, $arr_item);
                            }
                        }
                    } else {
                        $arr = array();
                    }
                }
            }

            $product_ids_matching_option_criteria = $my_arr;
        }

        $out = $product_ids_matching_option_criteria;
        if (!$out) {
            return false;
        }
        $out = array_unique($out, SORT_REGULAR);
        return $out;
    }
    function breadcrumbs($cid)
    {
        $arr = [];
        $str = '';

        while ($cid != 0) {
            $rs = [];
            $rs = $this->db->select('parent_id as id, name, uri')
                ->from('category')
                ->where('id', $cid)
                ->get();

            if ($rs->num_rows() == 1) {
                $rs = $rs->first_row('array');
                $cid = $rs['id'];

                $str = '<li><a href="' . base_url() . $rs['uri'] . '">' . $rs['name']  . '</a></li>';

                array_push($arr, $str);
            } else {
                $cid = 0;
            }
        }
        $arr = array_reverse($arr);

        if ($arr) {
            $str = implode(' ', $arr);
        }

        $str = '<li><a href="' . base_url() . '">Home</a></li>' . $str;

        return $str;
    }
}
