<?php

class Wishlist_model extends CI_Model
{
    function __construct() {
        parent::__construct();
    }

    function countAll() {
        $this->db->from('wishlist');
        return $this->db->count_all_results();
    }

    function listAll($offset = FALSE, $limit = FALSE) {
        if ($offset)
            $this->db->offset($offset);
        if ($limit)
            $this->db->limit($limit);

        $this->db->select('wishlist.customer_id as customer_id, wishlist.product_id as product_id, wishlist.added_on as added_on, user.first_name as fname, user.last_name as lname, user.email as email, product.sku as sku');
        $this->db->from('wishlist');        
        $this->db->join('user', 'user.user_id = wishlist.customer_id');
        $this->db->join('product', 'product.id = wishlist.product_id');
        $rs = $this->db->get();
        return $rs->result_array();
    }
}

// End of wishlist_model.php
