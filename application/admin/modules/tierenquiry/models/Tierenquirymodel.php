<?php

class tierenquirymodel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    //Get detail of News
    public function getdetails($nid) {
        $this->db->where('id', intval($nid));
        $query = $this->db->get('tier_enquiry');
        if ($query->num_rows() == 1) {
            return $query->row_array();
        }

        return false;
    }

    //Count All News
    public function countAll() {
        $this->db->from('tier_enquiry');
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
        $this->db->order_by('id', 'desc');
        $rs = $this->db->get('tier_enquiry');
        return $rs->result_array();
    }

    //Function Delete Record
    public function deleteRecord($tier_enquiry) {
        $this->db->where('id', $tier_enquiry['id']);
        $this->db->delete('tier_enquiry');
    }

}
