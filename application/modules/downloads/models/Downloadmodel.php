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
        $this->db->from('order_hold');
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getDetails($id)
    {
        $this->db->select('*');
        $this->db->where('id', $id);
        $this->db->from('order_hold');
        $query = $this->db->get();
        return $query->row_array();
    }
}
