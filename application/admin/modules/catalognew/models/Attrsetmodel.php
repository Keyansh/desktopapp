<?php

class Attrsetmodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //function add attributes
    function addAttr($asid) {
        $this->db->delete('attr_attrset', array('set_id' => $asid));
        $attrids = $_POST['attrids'];
        foreach ($attrids as $attrid) {
            $data = array();
            $data['set_id'] = $asid;
            $data['attr_id'] = $attrid;
            $this->db->insert('attr_attrset', $data);
        }
        return TRUE;
    }

//    //function give category top parent id
//    function getParentCat($cid) {
//        $this->db->select('id, parent_id');
//        $this->db->from('category');
//        $this->db->where('id', intval($cid));
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            $cat = $query->row_array();
//            if ($cat['parent_id'] == 0) {
//                return $cat['id'];
//            } else {
//                return self::getParentCat($cat['parent_id']);
//            }
//        }
//    }
//
//    //function get only top parent category assigned attribute
//    function getCatParentAttr($cid) {
//        $catid = self::getParentCat($cid);
//        return self::getAssignAttr($catid);
//    }
    //function get category assigned attribute
    function getAssignAttr($sid) {
        $this->db->select('t2.*');
        $this->db->from('attr_attrset t1');
        $this->db->join('attribute t2', 't1.attr_id=t2.id', 'left');
        $this->db->where('t1.set_id', intval($sid));
        $this->db->order_by('t2.name');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //function get all attributes
    function getAllAttr() {
        $this->db->select('*');
        $this->db->from('attribute');
        $this->db->order_by('name');
        $query = $this->db->get();
        return $query->result_array();
    }

    //function get all attributes
    function getAllAttrSet() {
        $query = $this->db->get('attribute_set');
        return $query->result_array();
    }

    function getAttrSet($asid) {
        $query = $this->db->where('id', $asid)->get('attribute_set');
        return $query->row_array();
    }

//function Add records
    function insertRecord() {
        $data = array();
        $data['name'] = $this->input->post('name', true);
        $this->db->insert('attribute_set', $data);
    }

//function update records
    function updateRecord($attrset) {
        $data = array();

        $data['name'] = $this->input->post('name', true);
        $data['updated_on'] = date('Y-m-d h:i:s');
        $this->db->where('id', $attrset['id']);
        $this->db->update('attribute_set', $data);
        return;
    }

}

?>
