<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Background_image {

    private $CI;
    private $page;
    private $module_name = 'background_image';

    function __construct($params) {
        $this->CI = & get_instance();
        $this->page = $params['page'];
        $this->init();
    }

    function init() {
        $this->CI->load->model('Pagemodel');
        $background_image = $this->CI->Pagemodel->getPageModuleSettings($this->page, 'background_image');
        $module_name = "module_" . $this->module_name;
        $this->CI->$module_name = $background_image;
    }

    function getName() {
        return $this->module_name;
    }

}

?>