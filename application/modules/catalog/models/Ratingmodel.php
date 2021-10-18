<?php

class Ratingmodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //insert
    function insertRecord($customer) {
        
        $data = array();
        $data['product_id'] = $this->input->post('product_id');
        $data['customer_id'] = $customer['customer_id'];
        
        $data['summary'] = $this->input->post('summary');
        $data['review'] = $this->input->post('review');
        $data['rating'] = $this->input->post('rating');
        $data['status'] = 0;
        $this->db->insert('review', $data);
    }

    //insert
    function countCustomerReviews($custId, $prodId) {
        return $this->db->where('customer_id', $custId)
                        ->where('product_id', $prodId)
                        ->count_all_results('review');
    }

    function fetchRecord($prodId) {
        return $this->db->where('product_id', $prodId)->get('review')->result_array();
    }

//list all order
    function listAll($prodId, $offset = FALSE, $limit = FALSE) {
        if ($offset)
            $this->db->offset($offset);
        if ($limit)
            $this->db->limit($limit);

        $this->db->select('review.*,product.product_name,ifnull(concat(first_name," ", last_name),"Guest") as cust_name', false)
                ->where('review.product_id', $prodId)
                ->where('review.status', 1)
                ->from('review')
                ->join('product', 'review.product_id = product.product_id', 'left')
                ->join('customer', 'customer.customer_id= review.customer_id', 'left')
                ->order_by('review.id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function checkIp($productId) {
        $this->db->where('ip', $_SERVER['REMOTE_ADDR']);
        $this->db->where('product_id', $productId);
        $res = $this->db->get('review');
        //  echo $this->db->last_query();
        if ($res->num_rows() > 0) {
            return false;
        } else {
            return true;
        }
    }

}

?>