<?php

class Wishlist_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function toggle() {
        $customer_id = $this->input->post('customer_id');
        $product_id = $this->input->post('product_id');
        $img = $this->input->post('data_product_img');

        $rs = $this->db->where('customer_id', $customer_id)
                ->where('product_id', $product_id)
                ->get('wishlist');

        if ($rs->num_rows() == 1) {
            $status = $this->db->where('customer_id', $customer_id)
                    ->where('product_id', $product_id)
                    ->delete('wishlist');
            return 'removed';
        } else {
            $data = array();
            $data['customer_id'] = $customer_id;
            $data['product_id'] = $product_id;
            if ($img) {
                $data['img'] = $img;
            }
            $data['added_on'] = time();
            $status = $this->db->insert('wishlist', $data);
            return 'added';
        }
    }

    function countAll($customer_id) {
        $rs = $this->db->from('wishlist')
                ->where('wishlist.customer_id', $customer_id)
                ->count_all_results();

        return $rs;
    }

    function listAll($customer_id, $offset = false, $limit = false) {
        if ($offset)
            $this->db->offset($offset);
        if ($limit)
            $this->db->limit($limit);
        $rs = $this->db->select('wishlist.id as id, wishlist.customer_id as customer_id, wishlist.product_id as product_id, wishlist.added_on as added_on, product.sku as sku, product.name as name, product.uri as uri, prod_img.img, prod_img.imgalt,product.type as type,product.price,product.srp_price')
                ->from('wishlist')
                ->join('user', 'user.user_id = wishlist.customer_id')
                ->join('product', 'product.id = wishlist.product_id')
                ->join('prod_img', 'prod_img.pid = product.id AND main = 1', "LEFT")
                ->where('wishlist.customer_id', $customer_id)
                ->get();

        if ($rs->num_rows()) {
            return $rs->result_array();
        } else {
            return false;
        }
    }

    function remove_item() {
        $wishlist_id = $this->input->post('wishlist_id');
//        e($wishlist_id);
        $status = $this->db->where('id', $wishlist_id)
                ->delete('wishlist');
        if ($status) {
            return 'removed';
        } else {
            return 'not removed';
        }
    }

    function remove_all_items() {
        $customer_id = $this->input->post('customer_id');
        $status = $this->db->where('customer_id', $customer_id)
                ->delete('wishlist');

        if ($status) {
            return 'removed';
        } else {
            return 'not removed';
        }
    }

}

// eof
