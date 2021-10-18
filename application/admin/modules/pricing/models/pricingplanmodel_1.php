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