<?php

class Sidebarmodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function detail($mid) {
        $this->db->from('sidebar_menu');
        $this->db->where('menu_id', $mid);
        $rs = $this->db->get();
        if ($rs->num_rows() == 1) {
            return $rs->row_array();
        }
        return FALSE;
    }

    function countAll() {
        $this->db->from('sidebar_menu');
        return $this->db->count_all_results();
    }

    function listAll($offset = FALSE, $limit = FALSE) {
        if ($offset)
            $this->db->offset($offset);
        if ($limit)
            $this->db->limit($limit);

        $this->db->order_by('menu_alias', 'ASC');
        $rs = $this->db->get('sidebar_menu');
        return $rs->result_array();
    }

    function insertRecord() {
        $data = array();
        $data['menu_title'] = $this->input->post('menu_title', TRUE);
        $data['menu_name'] = $this->input->post('menu_name', TRUE);
        $data['menu_alias'] = url_title(strtolower($this->input->post('menu_name', TRUE)),'_');
        $this->db->insert('sidebar_menu', $data);
    }

    function updateRecord($menu) {
        $data = array();
        $data['menu_title'] = $this->input->post('menu_title', TRUE);
        $data['menu_name'] = $this->input->post('menu_name', TRUE);
        $data['menu_alias'] = url_title(strtolower($this->input->post('menu_name', TRUE)),'_');

        $this->db->where('menu_id', $menu['menu_id']);
        $this->db->update('sidebar_menu', $data);
        return;
    }

    function deleteRecord($menu) {
        $this->db->where('menu_id', $menu['menu_id']);
        $this->db->delete('sidebar_menu');

        $this->db->where('menu_id', $menu['menu_id']);
        $this->db->delete('sidebar_menu_item');
        return;
    }

}

?>