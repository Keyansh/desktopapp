<?php

class Tiermodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //Function Get Details Of Product
    function getDetails($pid) {
        $this->db->select('t1.*');
        $this->db->from('product p1');
        $this->db->join('tier_price t1', 't1.tier_product_id = p1.id');
        $this->db->where('t1.tier_product_id', intval($pid));
        //$this->db->group_by('t1.tier_product_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Function Get Details Of Product
    function getTierDetails($pid) {
        $this->db->select('t1.*');
        $this->db->from('product p1');
        $this->db->join('product_tier_price t1', 't1.tier_product_id = p1.id');
        $this->db->where('t1.tier_product_id', intval($pid));
        //$this->db->group_by('t1.tier_product_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //List All Product
    /* function listAll($offset = FALSE, $limit = FALSE) {
      $this->db->select('t1.*, t3.id as category_id, t3.name category_name');
      $this->db->from('product t1');
      $this->db->join('cat_prod t2', 't1.id = t2.pid');
      $this->db->join('category t3', 't3.id = t2.cid');
      if ($offset)
      $this->db->offset($offset);
      if ($limit)
      $this->db->limit($limit);
      $query = $this->db->get();
      //die($this->db->last_query());
      return $query->result_array();
      } */

    function quantity_range($pid) {
        $data = $this->db->select('*')
                        ->from('quantity_range')
                        ->where('pid', $pid)
                        ->get()->row_array();
        if ($data) {
            $result = $this->db->select('*')
                            ->from('quantity_range')
                            ->where('pid', $pid)
                            ->where('group_id', $data['group_id'])
                            ->get()->result_array();
            return $result;
        } else {
            return[];
        }
    }

}

?>
