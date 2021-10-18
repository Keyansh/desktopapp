<?php

class Blocktemplatemodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //List All templates
    function listAll($offset = FALSE, $limit = FALSE) {
        if ($offset)
            $this->db->offset($offset);
        if ($limit)
            $this->db->limit($limit);

        $this->db->from('page_block_template');
        $this->db->order_by('block_template_id', 'ASC');
        $rs = $this->db->get();
        return $rs->result_array();
    }

    function countAll() {
        $this->db->from('page_block_template');
        return $this->db->count_all_results();
    }

    //Get template details
    function fetchByID($tid) {
        $this->db->select('*');
        $this->db->from('page_block_template');
        $this->db->where('block_template_id', intval($tid));
        $rs = $this->db->get();
        if ($rs->num_rows() == 1)
            return $rs->row_array();

        return FALSE;
    }

    function insertRecord() {
        $data = array();

        $data['block_template_name'] = $this->input->post('template_name', TRUE);
        if ($this->input->post('template_alias', TRUE)) {
            $data['block_template_alias'] = $this->input->post('template_alias', TRUE);
        } else {
            $data['block_template_alias'] = $this->_slug($this->input->post('template_name', TRUE));
        }
        $data['block_template_contents'] = $this->input->post('template_contents', FALSE);

        $this->db->insert('page_block_template', $data);
    }

    //update record
    function updateRecord($template) {
        $data = array();

        $data['block_template_name'] = $this->input->post('template_name', TRUE);

        //template alias
        if ($this->input->post('template_alias', TRUE)) {
            $data['block_template_alias'] = $this->input->post('template_alias', TRUE);
        } else {
            $data['block_template_alias'] = $this->_slug($this->input->post('template_name', TRUE));
        }

        $data['block_template_contents'] = $this->input->post('template_contents', FALSE);

        $this->db->where('block_template_id', $template['block_template_id']);
        $this->db->update('page_block_template', $data);
    }

    //delete records
    function deleteRecord($template) {
        $this->db->where('block_template_id', $template['block_template_id']);
        $this->db->delete('page_block_template');
    }

    function _slug($tname) {
        $template_name = ($tname) ? $tname : '';

        $replace_array = array('.', '*', '/', '\\', '"', '\'', ',', '{', '}', '[', ']', '(', ')', '~', '`', '#');

        $slug = $template_name;
        $slug = trim($slug);
        $slug = str_replace($replace_array, "", $slug);
        $slug = url_title($slug, 'dash', true);

        $this->db->limit(1);
        $this->db->where('block_template_alias', $slug);
        $rs = $this->db->get('page_block_template');
        if ($rs->num_rows() > 0) {
            $suffix = 2;
            do {
                $slug_check = false;
                $alt_slug = substr($slug, 0, 200 - (strlen($suffix) + 1)) . "-$suffix";
                $this->db->limit(1);
                $this->db->where('block_template_alias', $alt_slug);
                $rs = $this->db->get('page_block_template');
                if ($rs->num_rows() > 0)
                    $slug_check = true;
                $suffix++;
            }while ($slug_check);
            $slug = $alt_slug;
        }

        return $slug;
    }

}

?>
