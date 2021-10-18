<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Wishlist extends Cms_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('Wishlist_model');
        $this->load->library('pagination');
    }

    function index($offset = 0) {
        $customer = array();
        $customer = $this->memberauth->checkAuth();

        $wishlist = array();
        $user_is_active_flag = false;

        if($customer['user_id']) {
            if($customer['user_is_active'] == 1) {
                $user_is_active_flag = true;
            }
        }

        $inner = array();
        $inner['customer'] = $customer;
        $inner['user_is_active_flag'] = $user_is_active_flag;

        if($user_is_active_flag) {
            $perpage = 10;
            $config['base_url'] = base_url() . "wishlist/index/";
            $config['uri_segment'] = 3;
            $config['total_rows'] = $this->Wishlist_model->countAll($customer['user_id']);
            $config['per_page'] = $perpage;
            $this->pagination->initialize($config);

            $wishlist = array();
            $wishlist = $this->Wishlist_model->listAll($customer['user_id'], $offset, $perpage);
//            e(lQ());
            $inner['wishlist'] = $wishlist;
            $inner['pagination'] = $this->pagination->create_links();
        }

        $globalBlocks = array();
        $globalBlocks = $this->Pagemodel->getGlobalBlocks(0);
        $shell['globalBlocks'] = $globalBlocks;

        $shell['contents'] = $this->load->view('wishlist-listing', $inner, true);
        $this->load->view("themes/" . THEME . "/templates/product", $shell);
    }

    function toggle() {
        echo $this->Wishlist_model->toggle();
    }

    function remove_item() {
        echo $this->Wishlist_model->remove_item();
    }

    function remove_all_items() {
        echo $this->Wishlist_model->remove_all_items();
    }
}
