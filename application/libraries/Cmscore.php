<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cmscore {

    private $page = false;
    private $page_blocks = false;
    private $global_blocks = false;
    private $body_class = '';
    
    function loadPage(&$CI, $alias_override = false) {
        $CI->load->model('cms/Pagemodel');
        $CI->load->library('Cart');
        $CI->load->helper('text');
        $CI->load->helper('url');

        //Language
        $lang = 'en';
        $lang_trigger = false;
        $lang_uri = $CI->uri->uri_string();
        if ($lang_uri) {
            $lang_arr = explode('/', $lang_uri);
            if (count($lang_arr) > 1) {
                $lang_code = $lang_arr[0];
                $CI->db->where('language_code', $lang_code);
                $rs = $CI->db->get('language');
                if ($rs->num_rows() == 1) {
                    $lang = $lang_code;
                    $lang_trigger = true;
                }
            }
        }

        //Page Alias
        $alias = 'homepage';

        $segment_1 = $CI->uri->uri_string();
        if ($segment_1) {
            if (!$lang_trigger) {
                $alias = $segment_1;
            } else {
                $lang_arr = explode('/', $lang_uri);
                $lang_arr = array_slice($lang_arr, 1);
                $alias = implode('/', $lang_arr);
            }
        }

        if ($alias_override) {
            $alias = $alias_override;
        }

        //$CI->setLanguage($lang);
        //Get Page Details
        $page = array();
        $page = $CI->Pagemodel->getDetails($alias, $lang);
        if (!$page) {
            $CI->http->show404();
            return false;
        }

        $CI->setPage($page);
        $this->page = $page;

        //Compiled blocks
        $compiled_blocks = $CI->Pagemodel->compiledBlocks($page);
        $this->page_blocks = $compiled_blocks;

        //fetch page languages
        $languages = array();
        $languages = $CI->Pagemodel->getAllLanguages($page, $lang);

        $breadcrumbs = array();
        $breadcrumbs = $CI->Pagemodel->breadcrumbs($page['page_id']);

        //Variables
        $inner = array();
        $inner['page'] = $page;
        $inner['breadcrumbs'] = $breadcrumbs;
        $inner['languages'] = $languages;
        $inner['compiled_blocks'] = $compiled_blocks;
        if ($page['front_modules']) {
            $modules = explode(',', $page['front_modules']);
            foreach ($modules as $page_module) {
                $CI->load->library("modules/page/" . $page_module, array('page' => $page));
                $module_name = "module_$page_module";
                $inner[$module_name] = $CI->$module_name;
            }
        }

        $compiledblocks = array();
        foreach ($compiled_blocks as $key => $val) {
            $inner[$key] = $val;
            if ($key == 'block_main')
                continue;
            $compiledblocks[] = $val;
        }
        $inner['compiledblocks'] = $compiledblocks;
		
        //File Name & File Path
        $file_name = str_replace('/', '_', $page['page_uri']);
        //e($file_name);

        //Meta
        $meta_file = "application/views/themes/" . THEME . "/meta/" . $file_name . ".php";
        if (file_exists($meta_file)) {
            $CI->html->addMeta($CI->load->view("themes/" . THEME . "/meta/cms/" . $file_name, array('page' => $page), TRUE));
        } else {
            $CI->html->addMeta($CI->load->view("themes/" . THEME . "/meta/default", array('page' => $page), TRUE));
        }

        //Assets
        if (file_exists("application/views/themes/" . THEME . "/headers/cms/" . $file_name . ".php")) {
            $CI->assets->loadFromFile("themes/" . THEME . "/headers/cms/" . $file_name);
        }

        //Load CMS Page specific inline data
        $CI->assets->loadInline($page);

        return array('inner' => $inner, 'page' => $page);
    }

    function block($alias) {
        if ($this->page_blocks && isset($this->page_blocks[$alias])) {
            return '<div class="block_wrapper page" data-alias="' . $alias . '" data-pageid="' . $this->page['page_id'] . '">' . $this->page_blocks[$alias] . '</div>';
        }
        return false;
    }

    function getPageAlias() {
        if ($this->page) {
            return str_replace('/', '_', $this->page['page_uri']);
        }
    }

    function getPageid() {
        if ($this->page) {
            return $this->page['page_id'];
        }
    }

    function setBodyClass($class) {
        $this->body_class .= " " . $class;
    }

    function getBodyClass() {
        return $this->body_class;
    }

}

?>
