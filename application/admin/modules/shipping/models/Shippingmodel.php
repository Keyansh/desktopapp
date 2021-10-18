<?php

class Shippingmodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //function count all
    function countAll() {
        return $this->db->count_all('shipping');
    }

    //function listAll
    function listAll($offset, $limit) {
        $this->db->offset($offset);
        $this->db->limit($limit);

        $rs = $this->db->get('shipping');
        return $rs->result_array();
    }

    //function get details
    function detail($sid) {
        $this->db->where('shipping_id', $sid);
        $rs = $this->db->get('shipping');
        if ($rs->num_rows() == 1) {
            return $rs->row_array();
        }
        return FALSE;
    }

    //function insert record
    function insertRecord() {
        $data = array();
        $data['weight_from'] = $this->input->post('weight_from', TRUE);
        $data['weight_to'] = $this->input->post('weight_to', TRUE);
        $data['shipping'] = $this->input->post('shipping', TRUE);
        $data['s_active'] = '1';

        $this->db->insert('shipping', $data);
        return;
    }

    //function update record
    function updateRecord($shipping) {
        $data = array();
        $data['weight_from'] = $this->input->post('weight_from', TRUE);
        $data['weight_to'] = $this->input->post('weight_to', TRUE);
        $data['shipping'] = $this->input->post('shipping', TRUE);

        $this->db->where('shipping_id', $shipping['shipping_id']);
        $this->db->update('shipping', $data);
        return;
    }

    //function enable record
    function enableRecord($shipping) {
        $data = array();
        $data['s_active'] = 1;

        $this->db->where('shipping_id', $shipping['shipping_id']);
        $this->db->update('shipping', $data);
        return;
    }

    //function disable record
    function disableRecord($shipping) {
        $data = array();
        $data['s_active'] = 0;

        $this->db->where('shipping_id', $shipping['shipping_id']);
        $this->db->update('shipping', $data);
        return;
    }

    //function delete record
    function deleteRecord($shipping) {

        $this->db->where('shipping_id', $shipping['shipping_id']);
        $this->db->delete('shipping');
        return;
    }

}

?>