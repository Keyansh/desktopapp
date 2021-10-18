<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Includes {

    private $CI;
    private $page;
    private $module_name = 'includes';

    function __construct($params) {
        $this->CI = & get_instance();
        $this->page = $params['page'];
        $this->init();
    }

    function init() {
        $this->CI->load->model('Pagemodel');
        $crm_identifier = $this->CI->Pagemodel->getPageModuleSettings($this->page, 'includes');
        $module_name = "module_" . $this->module_name;
        $this->CI->$module_name = $crm_identifier;
    }

    function getName() {
        return $this->module_name;
    }

}

?>