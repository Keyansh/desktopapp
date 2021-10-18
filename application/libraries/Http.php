<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Http {

    function __construct() {
        log_message('debug', "HTTP Class Initialized");
    }

    function isSSL() {
        $https = isset($_SERVER['HTTPS']) ? $_SERVER['HTTPS'] : 0;
        $https = strtolower($https);
        if (($https == 'on' || $https == 1)) {
            return true;
        }

        return false;
    }

    function baseURL() {
        $url = base_url();
        if ($this->isSSL()) {
            return str_replace('http://', 'https://', $url);
        }

        return $url;
    }

    function baseHost() {
        $url = $_SERVER['HTTP_HOST'];
        if ($this->isSSL()) {
            return "https://$url/";
        }

        return "http://$url/";
    }

    function baseURLNoSSL() {
        $url = $this->baseURL();
        return str_replace('https://', 'http://', $url);
    }

    function baseURLSSL() {
        $url = $this->baseURL();
        return str_replace('http://', 'https://', $url);
    }

    function isMobile() {
        $CI = & get_instance();
        return $CI->agent->is_mobile();
    }

    function show404($params = array()) {
        $CI = & get_instance();

        set_status_header('404');

        $CI->load->model('cms/Pagemodel');
        $page = $CI->Pagemodel->getDetails('404');
        if (!$page) {
            show_404();
        }
        $inner = array();
        $compiled_blocks = $CI->Pagemodel->compiledBlocks($page);
        $compiledblocks = array();
        foreach ($compiled_blocks as $key => $val) {
            $compiledblocks[] = $val;
            $inner[$key] = $val;
        }


        $inner['page'] = $page;
        $inner['compiledblocks'] = $compiledblocks;

        $file_name = str_replace('/', '_', $page['page_uri']);
        $file_path = "application/views/themes/" . THEME . "/cms/" . $file_name . ".php";
        if (file_exists($file_path)) {
            $shell['contents'] = $CI->load->view("themes/" . THEME . "/cms/" . $file_name, $inner, true);
        } else {
            $shell['contents'] = $CI->load->view("themes/" . THEME . "/cms/" . 'default', $inner, true);
        }
        $CI->load->view("themes/" . THEME . "/templates/{$page['template_alias']}", $shell);
    }

}

?>