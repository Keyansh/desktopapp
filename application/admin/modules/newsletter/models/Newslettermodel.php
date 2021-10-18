<?php

class Newslettermodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function delete($id) {
        $this->db->where('id', $id);
        $status = $this->db->delete('newsletter');
        if ($status) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function listAll() {
        return $this->db->select('*')
                        ->from('newsletter')
                        ->order_by('id', 'desc')
                        ->group_by('email')
                        ->get()->result_array();
    }

}

?>