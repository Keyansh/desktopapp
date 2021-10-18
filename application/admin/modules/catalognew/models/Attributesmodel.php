<?php

class Attributesmodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //function get deatails of attributes
    function getDetails($aid) {
        $this->db->select('*');
        $this->db->from('attribute');
        $this->db->where('id', intval($aid));
        $rs = $this->db->get();
        if ($rs->num_rows() == 1) {
            return $rs->row_array();
        }
        return false;
    }
    
     function getAttributebyName($name) {
        $this->db->select('*');
        $this->db->from('attribute_set');
        $this->db->where('name', $name);
        $rs = $this->db->get();
        if ($rs->num_rows() == 1) {
            return $rs->row_array();
        }
        return false;
    }

    //count all product attributes
    function countAll() {
        $this->db->select('*');
        $this->db->from('attribute');
//        $this->db->where('id', intval($attrid));
        return $this->db->count_all_results();
    }

    //list all product attributes
    function listAll() {
        $query = $this->db->get('attribute');
        return $query->result_array();
    }

    //function insert records
    function insertRecord() {
        $data = array();
        $data['name'] = $this->input->post('name', true);
        $data['label'] = $this->input->post('label', true);
        $data['code'] = $this->input->post('code', true);
        $data['type'] = $this->input->post('type', true);
        $data['is_main'] = $this->input->post('is_main', true);
        //$data['defaultShow'] = $this->input->post('default', true);
        $this->db->insert('attribute', $data);
    }

    //function update records
    function updateRecord($attributes) {
        $data = array();

        $data['name'] = $this->input->post('name', true);
        $data['label'] = $this->input->post('label', true);
        $data['code'] = $this->input->post('code', true);
        $data['type'] = $this->input->post('type', true);
        //$data['defaultShow'] = $this->input->post('default', true);
        $data['is_main'] = $this->input->post('is_main', true);
        $data['for_details'] = $this->input->post('for_details', true);
        $this->db->where('id', $attributes['id']);
        $this->db->update('attribute', $data);
        return;
    }

    //Function Delete Record
    function deleteRecord($attributes) {
        //delete attribute in attribute value table
        $this->db->where('id', $attributes['id']);
        $this->db->delete('attribute_value');

        //delete attribute in product attributes table
        $this->db->where('id', $attributes['id']);
        $this->db->delete('product_attribute');

        //delete attribute
        $this->db->where('id', $attributes['id']);
        $this->db->delete('attribute');
        return;
    }

    //list all attributes
    function fetchAttributes($offset = FALSE, $limit = FALSE) {
        if ($offset)
            $this->db->offset($offset);
        if ($limit)
            $this->db->limit($limit);

        $this->db->select('*');
        $this->db->from('attribute');
        $this->db->join('product_attribute', 'product_attribute.id = attribute.id');
        //$this->db->join('attribute_value', 'attribute_value.attributes_id = attributes.attributes_id');

        $query = $this->db->get();
        return $query->result_array();
    }

    //list all attributes
    function listOptions() {

        $this->db->select('*');
        $this->db->from('attribute_option');
        //$this->db->join('attribute', 'attributes.attributes_id = attributes_value.attributes_id');
        //$this->db->where('attribute_value_id', $attributes['attribute_value_id']);
        $query = $this->db->get();
        return $query->result_array();
    }

    //return attributes assigned to attribute set
    function getAttributes($aSid=0){
        $result = $this->db
        ->select('t2.*')
        ->from('attr_attrset t1')
        ->join('attribute t2','t1.attr_id=t2.id')
        ->where('t1.set_id',$aSid)
        ->get()->result_array()
        ;
        return $result;
    }

    //Delete by product ID
    function deleteByID($pid) {
        $this->db->where('pid', $pid);
        $this->db->delete('attribute_varchar');
    }

}

?>
