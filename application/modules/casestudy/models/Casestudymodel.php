<?php

class Casestudymodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //function get page details
    function getDetails($alias) {
        $this->db->from('casestudy');
        $this->db->where('url_alias', $alias);
        $rs = $this->db->get();
        if ($rs->num_rows() == 1) {
            return $rs->row_array();
        }
        return FALSE;
    }

    //function recent casestudies
    function listRecent($limit) {

        $this->db->order_by('added_on', 'DESC');
        $this->db->limit($limit);
        $rs = $this->db->get('casestudy');

        return $rs->result_array();
    }

    

    //Count All case studies
    function countAll() {
        $this->db->from('casestudy');
        return $this->db->count_all_results();
    }

    function listAll($offset = false, $limit = false) {
        if ($offset)
            $this->db->offset($offset);
        if ($limit)
            $this->db->limit($limit);

        $this->db->order_by('added_on', 'DESC');
        $query = $this->db->get('casestudy');
        return $query->result_array();
    }

    function countForSidebar() {
        $CI = & get_instance();
        if (isset($CI->details) && $CI->details) {
            $this->db->where('page_id', $CI->details['page_id']);
        } elseif ($CI->getPageID()) {
            $this->db->where('page_id', $CI->getPageID());
        } else {
            return 0;
        }

        $this->db->from('casestudy');
        return $this->db->count_all_results();
    }

    function listForSidebar($offset = false, $limit = false) {
        $CI = & get_instance();
        if (isset($CI->details) && $CI->details) {
            $this->db->where('page_id', $CI->details['page_id']);
        } elseif ($CI->getPageID()) {
            $this->db->where('page_id', $CI->getPageID());
        } else {
            return array();
        }

        if ($offset)
            $this->db->offset($offset);
        if ($limit)
            $this->db->limit($limit);

        $this->db->order_by('added_on', 'DESC');
        $query = $this->db->get('casestudy');
        return $query->result_array();
    }

}

?>
