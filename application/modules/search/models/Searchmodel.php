<?php

class Searchmodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function countAll($search) {
        $this->db->select('*');
        $this->db->from('product');
        if ($search != '') {
            $this->db->where("(name LIKE '%$search%' OR  sku LIKE '%$search%')");
        }
        $this->db->where('is_active', 1);
        $qu = "product.id NOT IN (select pf.child_id from br_product_configurable_link as pf)";
        $this->db->where($qu);
        return $this->db->count_all_results();
    }

    function listAll($search, $offset = false, $limit = false, $cid) {
        if ($offset)
            $this->db->offset($offset);
        if ($limit)
            $this->db->limit($limit);

        $user_id = $this->session->userdata('CUSTOMER_ID');
        if ($user_id) {
            $this->db->select('t1.*,t1.id as product_id, IF(max(t7.quantity) > 0,max(t7.quantity),t1.quantity) as current_quantity, t3.*', FALSE);
        } else {
            $this->db->select('t1.*, t1.id as product_id,IF(max(t7.quantity) > 0,max(t7.quantity),t1.quantity) as current_quantity, t3.*', FALSE);
        }
        $this->db->select("(select COUNT(t8.parent_sku) from br_order_item t8 where t8.parent_sku = t1.sku) as salecount", false);
        $dbprefix = $this->db->dbprefix;
        $subquery = "(select price from " . $dbprefix . "product where id in (
        select child_id from " . $dbprefix . "product_configurable_link where parent_id = t1.id
        ) order by price limit 1) as least_price";
        $this->db->select($subquery, false);
        $this->db->from('product t1');
        $this->db->join('cat_prod t2', 't2.pid = t1.id');
        $this->db->join('prod_img t3', 't1.id = t3.pid AND t3.main = 1', 'left');
        $this->db->join('review t5', 't1.id = t5.product_id AND t5.status = 1', 'left');
        if ($user_id) {
            $this->db->join('product_assignment t4', "t4.product_id = t1.id AND t4.user_id = $user_id", 'left');
        }
        if ($search) {
            $result = str_replace(' ', '', $search);
            $mysql = "(REPLACE(t1.name,' ','') LIKE '%$result%' OR  t1.sku LIKE '%$result%')";
            $this->db->where("$mysql");
        }
        $this->db->join('product_configurable_link t6', 't6.parent_id = t1.id', 'left');
        $this->db->join('product t7', 't7.id = t6.child_id', 'left');

        $this->db->where('t1.is_active', 1);
        $qu = "t1.id NOT IN (select pf.child_id from br_product_configurable_link as pf)";
        $this->db->where($qu);
        if (DWS_SHOW_OUT_STOCK != 1) {
            $this->db->having('current_quantity >', 0);
        }
        $this->db->group_by('t1.id');
        $query = $this->db->get();
//        e($this->db->last_query());
        return $query->result_array();
    }

}
