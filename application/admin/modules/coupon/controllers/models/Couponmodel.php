<?php

class Couponmodel extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    //get details of coupon
    function detail($cid) {
        $this->db->where('coupon_id', $cid);
        $rs = $this->db->get('coupon');
        if ($rs->num_rows() == 1) {
            return $rs->row_array();
        }
        return FALSE;
    }

    //count all coupon
    function countAll() {
        $this->db->from('coupon');
        return $this->db->count_all_results();
    }

    //list all coupon
    function listAll($sortby, $direction, $offset = false, $limit = false) {
        if ($offset)
            $this->db->offset($offset);
        if ($limit)
            $this->db->limit($limit);

        $this->db->order_by($sortby, $direction);
        $rs = $this->db->get('coupon');
        return $rs->result_array();
    }

    function listAllCompanies() {
        $rs = $this->db->get('company');
        return $rs->result_array();
    }

    //function to insert record
    function insertRecord() {

        $data = array();
        $data['coupon_title'] = $this->input->post('coupon_title', TRUE);
        $data['coupon_code'] = $this->input->post('coupon_code', TRUE);
        $data['coupon_value'] = $this->input->post('coupon_value', TRUE);
        $data['coupon_type'] = $this->input->post('coupon_type', TRUE);
        $data['minimum_order_value'] = $this->input->post('minimum_order_value', TRUE);
		$data['one_time_use'] = $this->input->post('one_time_use', TRUE);

        $data['company_id'] = $this->input->post('company_id');

        $data['coupon_uses'] = 0;
        //$data['coupon_description'] = $this->input->post('coupon_description', TRUE);
        $data['active_from'] = $this->input->post('active_from', TRUE);
        $data['active_to'] = $this->input->post('active_to', TRUE);
        $data['coupon_active'] = '1';
        $data['coupon_added'] = time();

        //print_r($data);exit();
        $this->db->insert('coupon', $data);
    }

    function updateRecord($coupon) {
        //print_R( $this->input->post('bundle_discount', TRUE));EXIT();
        $data = array();

        $data['coupon_title'] = $this->input->post('coupon_title', TRUE);
        $data['coupon_code'] = $this->input->post('coupon_code', TRUE);
        $data['coupon_value'] = $this->input->post('coupon_value', TRUE);
        $data['coupon_type'] = $this->input->post('coupon_type', TRUE);
        $data['active_from'] = $this->input->post('active_from', TRUE);
        $data['active_to'] = $this->input->post('active_to', TRUE);
        $data['minimum_order_value'] = $this->input->post('minimum_order_value', TRUE);
		$data['one_time_use'] = $this->input->post('one_time_use', TRUE);

        $data['company_id'] = $this->input->post('company_id');

        $this->db->where('coupon_id', $coupon['coupon_id']);
        $this->db->update('coupon', $data);
    }

    //function to enable record
    function enableRecord($coupon) {
        $data = array();

        $data['coupon_active'] = 1;

        $this->db->where('coupon_id', $coupon['coupon_id']);
        $this->db->update('coupon', $data);
    }

    //function to disable record
    function disableRecord($coupon) {
        $data = array();

        $data['coupon_active'] = 0;

        $this->db->where('coupon_id', $coupon['coupon_id']);
        $this->db->update('coupon', $data);
    }

    //delete record
    function deleteRecord($coupon) {

        $this->db->where('coupon_id', $coupon['coupon_id']);
        $this->db->delete('coupon');
    }

}

?>