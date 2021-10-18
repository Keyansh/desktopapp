<?php

class Megamenu_model extends CI_Model
{
    function __construct() {
        parent::__construct();
    }

    function get_menus() {
        $rs = $this->db->select('menu_item.menu_item_id, menu_item.menu_item_name')
        ->from('menu')
        ->join('menu_item', 'menu_item.menu_id = menu.menu_id')
        ->where('menu.menu_alias', 'main_menu')
        ->order_by('menu_sort_order')
        ->get();

        if($rs->num_rows()) {
            return $rs->result_array();
        } else {
            return FALSE;
        }
    }

    function get_sub_categories() {
        $rs = $this->db->select('id, category.name')
        ->from('category')
        ->where('parent_id', '0')
        ->get();

        if($rs->num_rows()) {
            return $rs->result_array();
        } else {
            return FALSE;
        }
    }

    function get_mapping() {
        $rs = $this->db->get('megamenu');

        if($rs->num_rows()) {
            return $rs->result_array();
        } else {
            return FALSE;
        }
    }

    function update() {
        $menu_item_id = $this->input->post('menu_item_id');
        $category_id = $this->input->post('category_id');
        $added_on = time();
        $rs = $this->db->where('menu_item_id', $menu_item_id)->get('megamenu');

        if($rs->num_rows() == 1) {
            $this->db->set('category_id', $category_id)
            ->set('added_on', $added_on)
            ->where('menu_item_id', $menu_item_id)
            ->update('megamenu');
        } else {
            $data = array();
            $data['menu_item_id'] = $menu_item_id;
            $data['category_id '] = $category_id ;
            $data['added_on'] = $added_on;
            $this->db->insert('megamenu', $data);
        }
    }

    function reset() {
        $menu_item_id = $this->input->post('menu_item_id');
        $this->db->where('menu_item_id', $menu_item_id)
        ->delete('megamenu');

        if($this->db->affected_rows() == 1) {
            echo 'done';
        }
    }
}

// End of megamenu_model.php
