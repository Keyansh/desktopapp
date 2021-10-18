<?php

class Product_enquiry_model extends CI_Model
{
    function __construct() {
        parent::__construct();
    }

    function getDetails($id) {
        $this->db->where('id', intval($id));
        $query = $this->db->get('product_enquiry');
        if ($query->num_rows() == 1)
            return $query->row_array();

        return FALSE;
    }

    function get_product_details($product_id) {
        $rs = $this->db->select('name, sku')
            ->where('id', $product_id)
            ->where('is_active', 1)
            ->get('product');

        if ($rs->num_rows() == 1) {
            return $rs->first_row('array');
        }

        return FALSE;
    }

    function listAll() {
        $rs = $this->db->order_by('added_on', 'desc')->get('product_enquiry');
        return $rs->result_array();
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('product_enquiry');
    }
}

// End of Product_enquiry_model.php
