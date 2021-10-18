<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//used for the partner label
class Crm_identifier {

    private $CI;
    private $page;
    private $module_alias = 'crm_identifier';
    private $module_name = 'CRM Identifier';

    function __construct($params) {
        $this->CI = & get_instance();
        $this->page = $params['page'];
        $this->init();
    }

    function init() {
        $this->CI->load->library('form_validation');
        $this->CI->form_validation->set_rules('crm_identifier', 'CRM Identifier', 'trim');
    }

    function getName() {
        return $this->module_name;
    }

    function getAlias() {
        return $this->module_alias;
    }

    function addView() {
        return "add";
    }

    //function to edit record
    function editView() {
        $this->CI->load->library('form_validation');
        $this->CI->load->helper('form');
        $this->CI->load->model('cms/Pagemodel');

        $crm_identifier = array();
        $crm_identifier = $this->CI->Pagemodel->getModuleData($this->page['page_id'], $this->getAlias(), 'crm_identifier');

        $inner['crm_identifier'] = $crm_identifier;
        return $this->CI->load->view('cms/page_modules/' . $this->getAlias() . '/edit', $inner, true);
    }

    function actionAdd() {
        echo "add";
    }

    //update at partner end
    function actionUpdate() {
        $this->CI->load->model('cms/Pagemodel');

        $page = $this->page;

        //delete the previos data if any
        $this->CI->db->where('page_id', $page['page_id']);
        $this->CI->db->where('module_name', $this->getAlias());
        $this->CI->db->delete('page_data');

        //insert new data
        $data = array();
        $data['page_setting'] = "crm_identifier";
        $data['module_name'] = $this->getAlias();
        $data['page_setting_value'] = $this->CI->input->post("crm_identifier", true);
        $data['page_id'] = $page['page_id'];
        $this->CI->db->insert('page_data', $data);
    }

    function actionDelete() {
        $this->CI->load->model('cms/Pagemodel');
        $page = $this->page;

        //delete the previos data if any
        $this->CI->db->where('page_id', $page['page_id']);
        $this->CI->db->where('module_name', $this->getAlias());
        $this->CI->db->delete('page_data');
    }

}

?>