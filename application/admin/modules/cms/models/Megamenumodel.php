<?php

class Megamenumodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getActiveParentCategories() {
        $this->db->where('active', 1);
        $this->db->where('parent_id', 0);
        $res = $this->db->get('category');
        if ($res->num_rows() > 0) {
            return $res->result_array();
        }
    }

    function getActiveSubcategoryByParent($parent, $depth) {
        $this->db->where('parent_id', $parent);
        $this->db->where('c_active', 1);
        $this->db->where('depth', $depth);
        $res = $this->db->get('category');
        if ($res->num_rows() > 0) {
            return $res->result_array();
        }
    }

    function getSubCategoryExistence($id) {
        $this->db->select('id,order,status');
        $this->db->where('sub_cat_id', $id);
        $this->db->where('status', 1);
        $res = $this->db->get('megamenu');
        return array('num_rows' => $res->num_rows(), 'result' => $res->row_array());
    }

    function getSubCategoryExistenceWithParent($id, $parentId) {
        $this->db->select('id');
        $this->db->where('sub_cat_id', $id);
        $this->db->where('parent_id', $parentId);
        $res = $this->db->get('megamenu');
        if ($res->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function insertSubCategory($data) {
        $this->db->insert('megamenu', $data);
    }

    function updateSubCategory($data) {
        $this->db->where('sub_cat_id', $data['sub_cat_id']);
        $this->db->update('megamenu', $data);
    }

    function getSigleLevelParent($id) {
        $this->db->select('parent_id');
        $this->db->where('category_id', $id);
        return $this->db->get('category')->row_array();
    }

}
