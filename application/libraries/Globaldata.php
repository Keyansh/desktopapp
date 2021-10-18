<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Globaldata {

    var $CI;
    var $GET = array();

    function __construct() {
        $this->CI = & get_instance();
        log_message('debug', "Metautils Class Initialized");
        $this->load_data();
    }

    function load_data() {
        //Informational Messages
        $info = '';
        $info_key = $this->CI->session->flashdata('INFO');
        if ($info_key) {
            $this->CI->lang->load('info', 'english');
            $info = $this->CI->lang->line($info_key);
            $this->CI->load->vars(array('INFO' => $info));
        }

        //Error Messages
        $error = '';
        $error_key = $this->CI->session->flashdata('ERROR');
        if ($error_key) {
            $this->CI->lang->load('error', 'english');
            $error = $this->CI->lang->line($error_key);
            $this->CI->load->vars(array('ERROR' => $error));
        }

        //Success Messages
        $success = '';
        $success_key = $this->CI->session->flashdata('SUCCESS');
        if ($success_key) {
            $this->CI->lang->load('success', 'english');
            $success = $this->CI->lang->line($success_key);
            $this->CI->load->vars(array('SUCCESS' => $success));
        }

        //Pseudo GET Array
        $query_string = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
        if ($query_string && !is_null($query_string)) {
            $GET = array();
            parse_str($query_string, $GET);
            $this->GET = $GET;
        }

        //Get config settings
        $rs = $this->CI->db->get('config');
        foreach ($rs->result_array() as $row) {
            define('DWS_' . $row['config_key'], $row['config_value']);
        }
        $this->CI->load->model('catalog/categorymodel');
        //$categories = array();
        //$categories = $this->CI->Categorymodel->getPrimaryCategories();

        $segment_1 = $this->CI->uri->segment(1);
        $segment_2 = $this->CI->uri->segment(2);
        $current_category = '';
        if ($segment_1 == 'catalog' && $segment_2 == 'category') {
            $current_category = $this->CI->uri->segment(3);
        }
        $ul = $this->CI->categorymodel->getCategories($current_category, 0);
        $this->CI->load->vars(array('LEFT_CATEGORIES' => $ul));
        //tweet
        //Blog Feed
//        $this->CI->load->driver('cache', array('adapter' => 'file'));
//        $feed = $this->CI->cache->get('blog_feed');
//        $rss = new DOMDocument();
//        if (!$feed) {
//            $rss->load('http://thirdelementblog.wordpress.com/feed/');
//            $this->CI->cache->save('blog_feed', $rss->saveXML(), 43200);
//        } else {
//            $rss->loadXML($feed);
//        }
//
//        $feed = array();
//        foreach ($rss->getElementsByTagName('item') as $node) {
//            $desc = str_replace('&#160;', '', $node->getElementsByTagName('description')->item(0)->nodeValue);
//            $desc = str_replace('&nbsp;', ' ', $desc);
//            $item = array(
//                'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
//                'desc' => $desc,
//                'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
//                'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue,
//            );
//            array_push($feed, $item);
//        }
//        $this->CI->load->vars(array('BLOG_FEED' => $feed));

        $this->CI->load->model('cms/pagemodel');
        //$this->CI->load->driver('cache');
//        $tweet = $this->CI->Pagemodel->recentTweets('homepage_twitter_feed', DWS_TWITTER_ACCOUNT, 3);
//        $this->CI->load->vars(array('TWEETS' => $tweet));


        $global_blocks = array();
        $this->CI->load->model('cms/pagemodel');
        $global_blocks = $this->CI->pagemodel->getGlobalBlocks();
//        e($global_blocks);
        foreach ($global_blocks as $key => $block) {
            $this->CI->load->vars(array($key => $block));
        }
    }

    function get_packages() {
        $this->CI->load->model('package/Packagemodel');

        //fetch all packages
        $packages = array();
        $packages = $this->CI->Packagemodel->listAllPackages();
        return $packages;
    }

}

?>
