<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Includes {

    private $CI;
    private $page;
    private $module_alias = 'includes';
    private $module_name = 'Includes';

    function __construct($params) {
        $this->CI = & get_instance();
        $this->page = $params['page'];
        $this->init();
    }

    function init() {
        $this->CI->load->library('form_validation');
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

        //Fetch page includes
        $page_includes = array();
        $this->CI->db->where('page_id', $this->page['page_id']);
        $rs = $this->CI->db->get('page_include');
        foreach ($rs->result_array() as $item) {
            $page_includes[] = $item['include_id'];
        }

        //Fetch page includes
        $includes = array();
        $query = $this->CI->db->get('include');
        foreach ($query->result_array() as $page_include) {
            $includes[$page_include['include_location']][] = $page_include;
        }
        $inner = array();
        $inner['page'] = $this->page;
        $inner['page_includes'] = $page_includes;
        $inner['includes'] = $includes;

        return $this->CI->load->view('cms/page_modules/includes/listing', $inner, true);
    }

    function actionAdd() {
        echo "add";
    }

    function actionUpdate() {
        $this->CI->load->model('cms/Pagemodel');
        $page = $this->page;
    }

}

?>