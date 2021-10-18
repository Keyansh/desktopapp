<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Design extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
    }

    function index() {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Designmodel');

        if (!$this->checkAccess('MANAGE_SETTINGS')) {
            $this->utility->accessDenied();
            return;
        }

        $field_groups = $this->Designmodel->getAllConfig();
        
        foreach($field_groups as $field_group){
            $group_arr = json_decode($field_group['field_json'], true);
            foreach($group_arr['form'] as $field){
                $field_name = $field['name'];
                $field_label = $field['label'];
                $this->form_validation->set_rules("$field_name", "$field_label", 'trim');
            }
        }
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $inner['field_groups'] = $field_groups;
            $page['content'] = $this->load->view('design-edit', $inner, TRUE);
            $this->load->view('shell', $page);
        }else{
            $this->Designmodel->update();
            $this->session->set_flashdata('SUCCESS', 'configuration_updated');
            redirect("setting/design/index", 'location');
            exit();
        }
    }

}

?>