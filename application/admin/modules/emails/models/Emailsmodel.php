<?php

class Emailsmodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //function get deatails of email_templatess
    function getDetails($aid) {
        $this->db->select('*');
        $this->db->from('email_templates');
        $this->db->where('id', intval($aid));
        $rs = $this->db->get();
        if ($rs->num_rows() == 1) {
            return $rs->row_array();
        }
        return false;
    }

    //count all product email_templatess
    function countAll() {
        $this->db->select('*');
        $this->db->from('email_templates');
        return $this->db->count_all_results();
    }

    //list all product email_templatess
    function listAll() {
        $query = $this->db->get('email_templates');
        return $query->result_array();
    }

    //function insert records
    function insertRecord() {
        $data = array();
        $data['template_name'] = $this->input->post('template_name', true);

        if ($this->input->post('template_alias', TRUE) == '') {
            $data['template_alias'] = $this->_slug($this->input->post('template_name', TRUE));
        } else {
            $data['template_alias'] = url_title(strtolower($this->input->post('template_alias', TRUE)));
        }

        $data['body_content'] = $this->input->post('contents', FALSE);
//        $data['footer_content'] = $this->input->post('footer_contents', true);
//        $data['template_for'] = $this->input->post('template_for', true);
        $data['created_on'] = time();

        //upload image
//        $config['upload_path'] = $this->config->item('EMAIL_LOGO_PATH');
//        $config['allowed_types'] = '*';
//        $config['overwrite'] = FALSE;
//        $this->load->library('upload', $config);
//        if (count($_FILES) > 0) {
//            //Check for valid image upload
//            if ($_FILES['template_header']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['template_header']['tmp_name'])) {
//
//                if (!$this->upload->do_upload('template_header')) {
//                    show_error($this->upload->display_errors('<p class="err">', '</p>'));
//                    return FALSE;
//                } else {
//                    $upload_data = $this->upload->data();
//                    $data['header_content'] = $upload_data['file_name'];
//                }
//            }
//        }

        $this->db->insert('email_templates', $data);
    }

    //function update records
    function updateRecord($email_templates) {
        $data = array();
        $data['template_name'] = $this->input->post('template_name', true);

        if ($this->input->post('template_alias', TRUE) == '') {
            $data['template_alias'] = $this->_slug($this->input->post('template_name', TRUE));
        } else {
            $data['template_alias'] = url_title(strtolower($this->input->post('template_alias', TRUE)));
        }

        $data['body_content'] = $this->input->post('contents', FALSE);
//        $data['footer_content'] = $this->input->post('footer_contents', true);
//        $data['template_for'] = $this->input->post('template_for', true);

        //upload image
//        $config['upload_path'] = $this->config->item('EMAIL_LOGO_PATH');
//        $config['allowed_types'] = '*';
//        $config['overwrite'] = FALSE;
//        $this->load->library('upload', $config);
//        if (count($_FILES) > 0) {
//            //Check for valid image upload
//            if ($_FILES['template_header']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['template_header']['tmp_name'])) {
//
//                if (!$this->upload->do_upload('template_header')) {
//                    show_error($this->upload->display_errors('<p class="err">', '</p>'));
//                    return FALSE;
//                } else {
//                    $upload_data = $this->upload->data();
//                    $data['header_content'] = $upload_data['file_name'];
//                }
//            }
//        }

        $this->db->where('id', $email_templates['id']);
        $this->db->update('email_templates', $data);
        return;
    }

    //Function Delete Record	
    function deleteRecord($emailtemplate) {
        
        $path = $this->config->item('EMAIL_LOGO_PATH');
        $filename = $path . $emailtemplate['header_content'];
        if (file_exists($filename)) {
            @unlink($filename);
        }
        $this->db->where('id', $emailtemplate['id']);
        $this->db->delete('email_templates');
        return;
    }

    //function slug
    function _slug($templatetitle) {
        $template_title = ($templatetitle) ? $templatetitle : '';

        $replace_array = array('.', '*', '/', '\\', '"', '\'', ',', '{', '}', '[', ']', '(', ')', '~', '`');

        $slug = $template_title;
        $slug = trim($slug);
        $slug = str_replace($replace_array, "", $slug);
        //.,*,/,\,",',,,{,(,},)[,]
        $slug = url_title($slug, 'dash', true);
        $this->db->limit(1);
        $this->db->where('template_alias', $slug);
        $rs = $this->db->get('email_templates');
        if ($rs->num_rows() > 0) {
            $suffix = 2;
            do {
                $slug_check = false;
                $alt_slug = substr($slug, 0, 200 - (strlen($suffix) + 1)) . "-$suffix";
                $this->db->limit(1);
                $this->db->where('template_alias', $alt_slug);
                $rs = $this->db->get('email_templates');
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