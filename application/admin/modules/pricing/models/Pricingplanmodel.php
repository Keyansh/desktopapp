<?php

class Pricingplanmodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getDetails($plan_id) {
        $this->db->select('*');
        $this->db->from('pricing_plan');
        //$this->db->join('product_pricing','pricing_plan.pricing_plan_id = product_pricing.pricing_plan_id','LEFT');
        $this->db->where('pricing_plan_id', intval($plan_id));
        $rs = $this->db->get();
        if ($rs->num_rows() == 1) {
            return $rs->row_array();
        }
        return false;
    }

    function countAll() {
        $this->db->select('*');
        $this->db->from('pricing_plan');
        return $this->db->count_all_results();
    }

    function listAll($offset = FALSE, $limit = FALSE) {
        if ($offset)
            $this->db->offset($offset);
        if ($limit)
            $this->db->limit($limit);

        $this->db->select('*');
        $this->db->from('pricing_plan');
        $query = $this->db->get();
        return $query->result_array();
    }

    //function insert records
    function insertRecord() {
        $data = array();
        $data['pricing_plan'] = $this->input->post('pricing_plan', true);

        $this->db->insert('pricing_plan', $data);
        $last_id = $this->db->insert_id();

        $dis_per = $this->input->post('discount', true);
        $prod_pricing = array();
        $pricing = array();
        $this->db->where('pricing_plan_id', '1');
        $rs = $this->db->get('product_pricing');
        $prod_pricing = $rs->result_array();
        foreach ($prod_pricing as $item) {
            $pricing['product_id'] = $item['product_id'];
            $pricing['pricing_plan_id'] = $last_id;

            $unit_act_price = $item['product_unit_price'];
            $unit_discount = $unit_act_price * ($dis_per / 100);
            $unit_price = $unit_act_price - $unit_discount;
            $pricing['product_unit_price'] = $unit_price;

            /* $case_act_price = $item['product_case_price'];
              $case_discount = $case_act_price * ($dis_per / 100);
              $case_price = $case_act_price - $case_discount;
              $pricing['product_case_price'] = $case_price; */
            $pricing['product_case_price'] = 0;

            $this->db->insert('product_pricing', $pricing);
        }
    }

    //function update records
    function updateRecord($pricing_plan) {
        $data = array();
        $data['pricing_plan'] = $this->input->post('pricing_plan', true);

        $this->db->where('pricing_plan_id', $pricing_plan['pricing_plan_id']);
        $this->db->update('pricing_plan', $data);
    }

    //Function Delete Record
    function deleteRecord($pricing_plan) {
        $this->db->where('pricing_plan_id', $pricing_plan['pricing_plan_id']);
        $this->db->delete('pricing_plan');

        $this->db->where('pricing_plan_id', $pricing_plan['pricing_plan_id']);
        $this->db->delete('product_pricing');
    }

}

?>