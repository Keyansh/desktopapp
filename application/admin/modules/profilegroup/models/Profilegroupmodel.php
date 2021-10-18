<?php

class Profilegroupmodel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    //Get detail of News
    public function getdetails($nid) {
        $this->db->where('id', intval($nid));
        $query = $this->db->get('customer_group');
        if ($query->num_rows() == 1) {
            return $query->row_array();
        }
        return false;
    }

    //Count All News
    public function countAll() {
        $this->db->from('customer_group');
        return $this->db->count_all_results();
    }

    //list all News
    public function listAll($offset = false, $limit = false) {
        if ($offset) {
            $this->db->offset($offset);
        }
        if ($limit) {
            $this->db->limit($limit);
        }
        $rs = $this->db->get('customer_group');
        return $rs->result_array();
    }

    //insert record
    public function insertRecord() {
        $data = array();
        $data['group'] = $this->input->post('group');
        $status = $this->db->insert('customer_group', $data);
        return $status;
    }

    //update record
    public function updateRecord($customer_group) {
        $data = array();
        $data['group'] = $this->input->post('group', true);
        $this->db->where('id', $customer_group['id']);
        $status = $this->db->update('customer_group', $data);
        return $status;
    }

    //Function Delete Record
    public function deleteRecord($customer_group) {
        $this->db->where('id', $customer_group['id']);
        $this->db->delete('customer_group');
    }

}
