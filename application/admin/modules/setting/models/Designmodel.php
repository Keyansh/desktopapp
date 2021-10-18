<?php

class Designmodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getAllConfig() {
        $this->db->order_by('sort_order','ASC');
        $rs = $this->db->get('design_config');
        return $rs->result_array();
    }

    function update(){
        $post = $this->input->post();
        $data = array();
        foreach($post as $key => $item){
            $item1 = [];
            foreach($item as $sub_key => $sub_item){
                $sub_key = explode('_',$sub_key);
                $unit_name = $sub_key[1] == 'percent' ? '%' : $sub_key[1];
                $item1[$sub_key[0]] = $sub_item.''.$unit_name;
            }
            $data['config_json'] = json_encode($item1);
            $this->db->where('element',$key);
            $this->db->update('design_config', $data);
        }
        return true;
    }

}
