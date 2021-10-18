<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Core {

    var $GET = array();
    var $native_modules = array();
    var $native_plugins = array();
    private $page = false;

    function __construct() {
        $this->_initialize_core();
    }

    function _initialize_core() {
        $CI = & get_instance();
        define('PATH_MODULES', realpath(APPPATH . '/modules/'));
        define('PATH_CURRENT_MODULE', realpath(APPPATH . '/views/' . $CI->router->directory . '../'));
        define('PATH_PLUGINS', APPPATH . 'plugins/');
        define('PATH_EXTENSIONS', APPPATH . 'extensions/');
        define('PATH_THEMES', APPPATH . 'views/themes/');
//        define('THEME', 'default');
        define('CMS_USE_PAGE_URI', TRUE);

        // Load DB and set DB preferences
        $CI->load->database();
        $CI->db->db_debug = TRUE;

        //Core libraries
        $CI->load->library('session');
        $CI->load->library('user_agent');


        //Helpers
        $CI->load->helper('url');
        $CI->load->helper('text');
        $CI->load->helper('image');
        $CI->load->helper('cms');
        $CI->load->helper('form');

        //DWS Libraries
        $CI->load->library('globaldata');
        $CI->load->library('utility');
        $CI->load->library('cart');
        $CI->load->library('http');
        $CI->load->library('assets/assets');
        $CI->load->library('html');
        $CI->load->library('cmscore');
        $CI->load->library('splittestcore');
        $CI->load->library('Memberauth');

        $CI->config->load('custom-config');

        $CI->load->vars(array('CI' => $CI));

        $file_name = $CI->router->class . '_' . $CI->router->method;
        $file_path = PATH_CURRENT_MODULE . "/views/headers/$file_name.php";
        if (file_exists($file_path)) {
            $CI->assets->loadFromFile("headers/" . $file_name);
        }

        //Load global modules
        $rs = $CI->db->get('module');
        foreach ($rs->result_array() as $module) {
            $CI->load->library("modules/global/" . $module['module_alias']);
        }
    }

    function setPage($page) {
        $this->page = $page;
    }

    function getPage() {
        return $this->page;
    }

}

?>