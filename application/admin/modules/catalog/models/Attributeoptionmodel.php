<?php

class Attributeoptionmodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //function get details of options
    function details($av_id) {
        $this->db->select('*');
        $this->db->from('attribute_option');
        $this->db->where('id', intval($av_id));
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row_array();
        }
        return false;
    }

    //Count All Product
    function countAll($aid) {
        $this->db->from('attribute_option');
        $this->db->where('attr_id', intval($aid));
        return $this->db->count_all_results();
    }

    //List All Product
    function listAll($aid, $offset = false, $limit = false) {
        if ($offset)
            $this->db->offset($offset);
        if ($limit)
            $this->db->limit($limit);

        $this->db->from('attribute_option');
        $this->db->where('attr_id', intval($aid));
        $query = $this->db->get();
        return $query->result_array();
    }

    //function insert record
    function insertRecord($attributes) {
        $data = array();
        $data['attr_id'] = intval($attributes['id']);
        $data['icon'] = $this->getIcon('icon');
        $data['option'] = $this->input->post('option', true);
        $data['additional_info'] = $this->input->post('additional_info', true);
        $this->db->insert('attribute_option', $data);
        return;
    }

    //get option icon
    function getIcon($name) {
        $config['upload_path'] = $this->config->item('ATTRIBUTE_OPTION_ICON_PATH');
        $config['allowed_types'] = 'gif|jpg|png';
        $config['overwrite'] = FALSE;
        $this->load->library('upload', $config);
        if (count($_FILES) > 0) {
            if ($_FILES[$name]['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES[$name]['tmp_name'])) {
                if (!$this->upload->do_upload($name)) {
                    show_error($this->upload->display_errors('<p class="err">', '</p>'));
                    return FALSE;
                } else {
                    $upload_data = $this->upload->data();
                    return $upload_data['file_name'];
                }
            }
        }
    }

    //update record
    function updateRecord($attributes_option) {
        $data = array();
        $data['option'] = $this->input->post('option', true);
        $data['additional_info'] = $this->input->post('additional_info', true);
        if ($icon = $this->getIcon('icon')) {
            $data['icon'] = $icon;
        }
        $this->db->where('id', $attributes_option['id']);
        $this->db->update('attribute_option', $data);
    }

    //function delete record
    function deleteRecord($attribute_value) {
        //delete from the attribute_value 
        $this->db->where('id', $attribute_value['id']);
        $this->db->delete('attribute_option');
        return;
    }

    //function delete record
    function deleteIcon($id) {
        $data['icon'] = '';
        $this->db->where('id', $id);
        return $this->db->update('attribute_option', $data);
    }

    //function delete record
    function deleteAttrOpt($id) {
        //delete from the attribute_value 
        $this->db->where('id', $id);
        $this->db->delete('attribute_option');

        $this->db->where('value', $id);
        $this->db->delete('attribute_varchar');
        return;
    }

}

?>