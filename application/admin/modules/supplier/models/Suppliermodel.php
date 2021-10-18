<?php

class Suppliermodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //Get detail of distributor
    function getdetails($s_id) {
        $this->db->where('supplier_id', intval($s_id));
        $query = $this->db->get('supplier');
        if ($query->num_rows() == 1) {
            return $query->row_array();
        }
        return false;
    }

    //Count All distributors
    function countAll() {
        $this->db->from('supplier');
        return $this->db->count_all_results();
    }

    //list all distributors
    function listAll($offset = FALSE, $limit = FALSE) {
        if ($offset)
            $this->db->offset($offset);
        if ($limit)
            $this->db->limit($limit);
        $this->db->order_by('supplier_id', "ASC");
        $rs = $this->db->get('supplier');
        return $rs->result_array();
    }

    //insert record
    function insertRecord() {
        $data = array();
        $data['supplier_name'] = $this->input->post('supplier_name', true);
        $data['email'] = $this->input->post('email', true);
        $data['address'] = $this->input->post('address', true);
        $data['phone'] = $this->input->post('phone', true);
        $data['added_on'] = time();
        $data['s_active'] = 1;

        $this->db->insert('supplier', $data);
        return;
    }

    //update record
    function updateRecord($supplier) {

        $data['supplier_name'] = $this->input->post('supplier_name', true);
        $data['email'] = $this->input->post('email', true);
        $data['address'] = $this->input->post('address', true);
        $data['phone'] = $this->input->post('phone', true);


        $this->db->where('supplier_id', $supplier['supplier_id']);
        $this->db->update('supplier', $data);
        return;
    }

    //Function Delete Record
    function deleteRecord($supplier) {
        $this->db->where('supplier_id', $supplier['supplier_id']);
        $this->db->delete('supplier');
    }

}

?>