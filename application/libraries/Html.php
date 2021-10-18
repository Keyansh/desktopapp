<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Html {

    private $h_meta = array();

    function __construct() {
        log_message('debug', "HTML Class Initialized");
    }

    function menu($params) {
        $CI = & get_instance();
        return $CI->menumodel->menu($params);
    }
    
    //fetch bottom menus
    function bottom_menus($params) {
        $CI = & get_instance();
        return $CI->menumodel->bottom_menus($params);
    }

    function categorymenu() {
        $CI = & get_instance();
        return $CI->menumodel->categorymenu();
    }

    function addMeta($resource) {
        $this->h_meta[] = $resource;
    }

    function getMeta() {
        $CI = & get_instance();
        $file_name = $CI->router->class . '_' . $CI->router->method;

        $file_path = PATH_CURRENT_MODULE . "/views/meta/$file_name.php";
        if (file_exists($file_path)) {
            $CI->html->addMeta($CI->load->view("meta/" . $file_name, array(), TRUE));
        }

        foreach ($this->h_meta as $row) {
            echo $row . "\r\n";
        }
    }

    function getBodyClass() {
        $CI = & get_instance();

        return $CI->cmscore->getBodyClass();
    }

    //Function load includes
    function loadIncludes($location) {
        $CI = & get_instance();
        $CI->load->model('cms/Pagemodel');
        $CI->load->model('cms/Includemodel');

        $alias = $CI->cmscore->getPageAlias();

        $page = $CI->Pagemodel->getDetails($alias);
        if (!$page) {
            //$CI->http->show404();
            return false;
        }

        $includes = array();
        $include_id = array();
        $includes = $CI->Includemodel->fetchAllModules($page['page_id']);
        foreach ($includes as $include) {
            $include_id[] = $include['include_id'];
        }

        if (!$include_id) {
            return false;
        }

        $page_includes = array();
        $page_includes = $CI->Includemodel->getModules($include_id, $location);

        $output = '';
        foreach ($page_includes as $page_include) {
            $output.= "\r\n<!--{$page_include['include_name']} Starts -->\r\n";
            $output .= $page_include['include_content'];
            $output.= "\r\n<!--{$page_include['include_name']} Ends -->\r\n";
        }

        return $output;
    }

}

?>