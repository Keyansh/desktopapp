<?php

class Userjourneymodel extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function listAll()
    {
        $this->db->order_by('id', 'DESC');
        $this->db->group_by(array("comment", "created_by"));
        $rs = $this->db->get('logger');
        return $rs->result_array();
    }

    function delete($id, $date)
    {
        $this->db->where('created_by', $id);
        $this->db->where('comment', $date);
        $this->db->delete('logger');
    }
}
