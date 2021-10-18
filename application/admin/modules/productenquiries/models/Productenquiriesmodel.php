<?php

class Productenquiriesmodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //get detail
    function getDetails($id) {
        $this->db->where('id', intval($id));
        $query = $this->db->get('checkout_enquiry');
        if ($query->num_rows() == 1)
            return $query->row_array();

        return FALSE;
    }

    function listAll() {
        $this->db->order_by('id', 'desc');
        $rs = $this->db->get('checkout_enquiry');
        return $rs->result_array();
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('checkout_enquiry');
    }

}

?>