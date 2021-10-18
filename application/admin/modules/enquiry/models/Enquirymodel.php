<?php

class Enquirymodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //get detail
    function getDetails($id) {
        $this->db->where('id', intval($id));
        $query = $this->db->get('enquiry');
        if ($query->num_rows() == 1)
            return $query->row_array();

        return FALSE;
    }

    function listAll() {
        $this->db->order_by('id', 'desc');
        $rs = $this->db->get('enquiry');
        return $rs->result_array();
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('enquiry');
    }

    function listAllOffer() {
        $rs = $this->db->get('offer_request');
        return $rs->result_array();
    }

    //get detail
    function getofferdetails($id) {
        $this->db->where('id', intval($id));
        $query = $this->db->get('offer_request');
        if ($query->num_rows() == 1)
            return $query->row_array();

        return FALSE;
    }

    function deleteoffer($id) {
        $this->db->where('id', $id);
        $this->db->delete('offer_request');
    }

}

?>