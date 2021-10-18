<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Topbearing {

    private $module_name = 'topbearing';

    function __construct($params = array()) {
        $this->init();
    }

    function init() {
        $CI = & get_instance();
        $module_name = "module_" . $this->module_name;
        $CI->$module_name = $this;
    }

    function headerCategoriesMenu() {
        $CI = & get_instance();
        $CI->load->model('catalog/Categorymodel');

        $ul = $CI->Categorymodel->categoriesTree(0);
        echo $ul;
//        exit;
    }

    function headerCategoriesMenuCsv() {
        $CI = & get_instance();
        $CI->load->model('catalog/Categorymodel');

        $ul = $CI->Categorymodel->categoriesTree(0);
        echo $ul;
//        exit;
    }
    
    function getName() {
        return $this->module_name;
    }

    function miniCart() {
        $CI = & get_instance();
        $CI->load->library('cart');
        $CI->load->model('cart/Cartmodel');
        return $CI->Cartmodel->minicart();
    }

}

?>
