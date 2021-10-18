<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Utility {

    var $CI;

    function __construct() {
        $this->CI = & get_instance();
        log_message('debug', "Utility Class Initialized");
    }

    function show404($params = array()) {
        $this->CI->load->model('cms/Pagemodel');
        $this->CI->load->helper('text');

        set_status_header('404');

        $alias = '404';
        //Get Page Details
        $page = array();
        $page = $this->CI->Pagemodel->getDetails($alias);
        $this->CI->setPage($page);

        //Compiled blocks
        $compiled_blocks = array();
        $compiled_blocks = $this->CI->Pagemodel->compiledBlocks($page);

        $breadcrumbs = array();
        $breadcrumbs = $this->CI->Pagemodel->breadcrumbs($page['page_id']);

        $inner = array();
        $shell = array();
        $inner['page'] = $page;
        $inner['breadcrumbs'] = $breadcrumbs;
        foreach ($compiled_blocks as $key => $val) {
            $inner[$key] = $val;
        }

        $file_name = str_replace('/', '_', $page['page_uri']);
        $file_path = "application/views/themes/" . THEME . "/cms/" . $file_name . ".php";
        if (file_exists($file_path)) {
            $shell['contents'] = $this->CI->load->view("themes/" . THEME . "/cms/" . $file_name, $inner, true);
        } else {
            $shell['contents'] = $this->CI->load->view("themes/" . THEME . "/cms/" . 'default', $inner, true);
        }


        // $globalBlocks = array();
        // $globalBlocks = $this->Pagemodel->getGlobalBlocks(0);
        // $shell['globalBlocks'] = $globalBlocks;

        $this->CI->load->view("themes/" . THEME . "/templates/{$page['template_alias']}", $shell);
    }

    function accessDenied() {
        $inner = array();
        $page = array();
        $page['title'] = 'Access Denied';
        $page['contents'] = $this->CI->load->view('pages/access-denied', $inner, true);
        $this->CI->load->view('shell', $page);
    }

    function showMessage($title, $message) {
        $inner = array();
        $page = array();
        $inner['title'] = $title;
        $inner['message'] = $message;
        $page['contents'] = $this->CI->load->view('themes/' . DWS_THEME . '/pages/message', $inner, true);
        $this->CI->load->view('themes/' . DWS_THEME . '/shell', $page);
    }

    function getDeliveryDet() {
        return array(
            'title' => 'In terms of delivery we\'re going to charge the following:',
            'options' => array(
//                array('text' => 'Under 1Kg Next Day', 'val' => '6.50'),
//                array('text' => 'Between 1 & 5Kg', 'val' => '8.50'),
//                array('text' => 'Between 5 & 10Kg', 'val' => '10.00'),
//                array('text' => 'Over 30Kg', 'val' => '25.00'),
//                array('text' => 'Next day before 12 Carrier Service', 'val' => '15.00'),
//                array('text' => 'Next day before 10AM Carrier Service', 'val' => '20.00'),
//                array('text' => 'Saturday AM Carrier Service', 'val' => '25.00')
//
                //Updated by @Rav on 8March 2016
                array('text' => 'No Carrier Service', 'val' => '0.00'),
                array('text' => '1-2 Day Carrier Service', 'val' => '6.50'),
                array('text' => 'Next Day Carrier Service', 'val' => '9.50'),
                array('text' => 'Next day before 12 Carrier Service', 'val' => '15.00'),
                array('text' => 'Next day before 10AM Carrier Service', 'val' => '20.00'),
                array('text' => 'Saturday AM Carrier Service', 'val' => '25.00'),
                array('text' => 'Heavy Item Charge (Over 25Kg)', 'val' => '8.50'),
                array('text' => 'Free Delivery Service within a 50 mile radius', 'val' => '0.00')
            )
        );
    }

    function getDeliveryOptVal($index) {
        // $value = array('6.50','8.50', '10.00', '25.00', '15.00','20.00','25.00');
        //Updated by @Rav on 8March 2016
        $value = array('0', '6.50', '9.50', '15.00', '20.00', '25.00', '8.50', '0.00');
        return $value[$index];
    }

    function getDeliveryOptText($index) {
        $value = array('Next Day', 'Pre-12.00am: Mainland UK', 'Pre-10.30am: Mainland UK', 'Saturday AM Carrier Service');
        return $value[$index];
    }

}

?>
