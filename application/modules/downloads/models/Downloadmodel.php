<?php

class Downloadmodel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllPdf()
    {
        $this->db->select('*');
        $this->db->from('download');
        $this->db->where('active', 1);
        $this->db->order_by('sort_order', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
}
