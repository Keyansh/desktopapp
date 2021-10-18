<?php

class Planmodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //function get detail
    function getDetails($plan_id) {
        $this->db->select('*');
        $this->db->from('product_pricing');
        $this->db->where('product_pricing_id', intval($plan_id));
        $rs = $this->db->get();
        if ($rs->num_rows() == 1) {
            return $rs->row_array();
        }
        return false;
    }

    //function get detail
    function fetchPrice($pricing_id) {
        $this->db->select('*');
        $this->db->from('product_pricing');

        $this->db->where('pricing_plan_id', intval($pricing_id));
        $rs = $this->db->get();
        return $rs->result_array();
    }

    //list all Products
    function listAll() {
        $this->db->select('*');
        $this->db->from('product');
        $query = $this->db->get();
        return $query->result_array();
    }

    //list all surface type
    function listProductByPlan($pricing_id) {
        $this->db->select('*');
        $this->db->join('product', 'product_pricing.product_id = product.product_id');
        $this->db->where('product_pricing.pricing_plan_id', intval($pricing_id));
        $this->db->from('product_pricing');
        $query = $this->db->get();
        return $query->result_array();
    }

    //function insert records
    function insertRecord($products, $pricing_plan) {
        //delete all the prev product price of this plan

        $this->db->where('pricing_plan_id', $pricing_plan['pricing_plan_id']);
        $this->db->delete('product_pricing');

        foreach ($products as $item) {
            //$caseprice = $this->input->post('product_price_'.$item['product_id'].'_'.'case_price',true);
            $unitprice = $this->input->post('product_price_' . $item['product_id'] . '_' . 'unit_price', true);

            if ($unitprice) {
                $data = array();
                $data['pricing_plan_id'] = $pricing_plan['pricing_plan_id'];
                $data['product_id'] = $item['product_id'];
                $data['product_unit_price'] = $unitprice;
                $data['product_case_price'] = 0;
                $this->db->insert('product_pricing', $data);
            }
        }
    }

}

?>