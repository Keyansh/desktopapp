<?php

class Reviewmodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //get detail
    function getDetails($rid) {
        $this->db->where('id', intval($rid));
        $query = $this->db->get('review');
        if ($query->num_rows() == 1)
            return $query->row_array();

        return FALSE;
    }

    //Count All Reviews
    function countAll() {
        $this->db->from('review');
        return $this->db->count_all_results();
    }

    //List all Reviews
    function listAll($offset = FALSE, $limit = FALSE) {
        if ($offset)
            $this->db->offset($offset);
        if ($limit)
            $this->db->limit($limit);
        $this->db->select('t1.*, t2.name as productname');
        $this->db->from('review t1');
        $this->db->join('product t2', 't2.id = t1.product_id');
        $this->db->order_by('id', 'desc');
        $rs = $this->db->get();
        return $rs->result_array();
    }

    function enable($reviewId) {
        $this->db->where('id', $reviewId);
        $data['status'] = 1;
        $this->db->update('review', $data);
    }

    function disable($reviewId) {
        $this->db->where('id', $reviewId);
        $data['status'] = 0;
        $this->db->update('review', $data);
    }

    function delete($reviewId) {
        $this->db->where('id', $reviewId);
        $data['status'] = 0;
        $this->db->delete('review');
    }

}

?>