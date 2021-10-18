<?php

class Settingsmodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getAllConfig($group_id = false) {
        if ($group_id) {
            $this->db->where('config_group_id', $group_id);
        } else {
            $this->db->where('editable', 1);
        }
        $rs = $this->db->get('config');
        return $rs->result_array();
    }

    function getConfigByGroup($group_id) {
        $this->db->where('config_group_id', $group_id);
        $this->db->where('editable', 1);
        $rs = $this->db->get('config');
        return $rs->result_array();
    }

    function getByKey($key) {
        $this->db->where('config_key', $key);
        $this->db->where('editable', 1);
        $rs = $this->db->get('config');
        if ($rs->num_rows() == 1) {
            return $rs->row_array();
        }
    }

    function fetchConfigGroup($group_id) {
        $this->db->where('config_group_id', $group_id);
        $rs = $this->db->get('config_group');
        return $rs->result_array();
    }

    function getConfigGroups() {
        $rs = $this->db->get('config_group');
        return $rs->result_array();
    }

    function update($settings) {
        $config = array();
        $config['upload_path'] = $this->config->item('CONTACT_US_FILE_PATH');
        $this->load->library('upload', $config);

        foreach ($settings as $row) {
            //For WYSIWYG
            if ($this->input->post($row['config_key']) && $row['config_field_type'] == 'wysiwyg') {
                $data = array();
                $data['config_value'] = $this->input->post($row['config_key'], FALSE);
                $this->db->where('config_key', $row['config_key']);
                $this->db->update('config', $data);
                continue;
            }

            
            //For textfields,textarea,radio etc
            if ($this->input->post($row['config_key'], TRUE) !== FALSE && ($row['config_field_type'] != 'image')) {
                $data = array();
                $data['config_value'] = $this->input->post($row['config_key'], false);
                $this->db->where('config_key', $row['config_key']);
                $this->db->update('config', $data);
            }

            //For image and file uploads
            if ($row['config_field_type'] == 'image' || $row['config_field_type'] == 'file') {

                $fieldname = $row['config_key'] . "_FILE";
                
                if (isset($_FILES) && isset($_FILES[$fieldname]) && is_array($_FILES[$fieldname])) {
                    if(isset($_FILES[$fieldname]['name']) && $_FILES[$fieldname]['name']!=''){
                        $config = array();
                        $config['upload_path'] = $this->config->item('CONTACT_US_FILE_PATH');
                        $config['allowed_types'] = $row['config_field_options'];
                        $config['overwrite'] = FALSE;
                        $this->upload->initialize($config);
    
                        //Check for valid image upload
                        if ($_FILES[$fieldname]['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES[$fieldname]['tmp_name'])) {
                            if (!$this->upload->do_upload($fieldname)) {
                                show_error($this->upload->display_errors('<p class="err">', '</p>'));
                                return FALSE;
                            } else {
                                $upload_data = $this->upload->data();
    
                                $data = array();
                                $data['config_value'] = $upload_data['file_name'];
                                $this->db->where('config_key', $row['config_key']);
                                $this->db->update('config', $data);
    
                                $path = $this->config->item('CONTACT_US_FILE_PATH');
    
                                $filename = $path . $row['config_value'];
                                if (file_exists($filename)) {
                                    @unlink($filename);
                                }
                            }
                        }

                    }

                   
                }

            }
        }
    }

    function DeleteImage($setting) {

        $path = $this->config->item('CONTACT_US_FILE_PATH');
        $imagepath = $path . $setting['config_value'];

        if (file_exists($imagepath)) {
            @unlink($imagepath);
        }
        $data['config_value'] = '';
        //	  print_R($data); exit();
        $this->db->where('config_key', $setting['config_key']);
        $this->db->update('config', $data);
    }

}
