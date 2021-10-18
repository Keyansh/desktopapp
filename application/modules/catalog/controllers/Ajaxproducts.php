<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Ajaxproducts extends Cms_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->model('Productmodel');
    }

    function index() {
        $category_id = $this->input->post('category_id');
        $perpage = $this->input->post('perpage');
        $offset = $this->input->post('offset');
        $order = $this->input->post('order');

        // Get total number of products of this category.
        $total_products = 0;
        $total_products = $this->Productmodel->count_products($category_id);

        $products = array();
        $products = $this->Productmodel->listByCategory($category_id, $offset, $perpage, $order, $filteredProductIds = FALSE);

        $inner = array();
        $inner['total_products'] = $total_products;
        $inner['products'] = $products;
        $inner['perpage'] = $perpage;
        $inner['more_products'] = $total_products - ($offset + count($products));
        $inner['order'] = $order;

        $customer = array();
        $customer = $this->memberauth->checkAuth();

        if ($customer) {
            $inner['customer'] = $customer;
            $inner['wishlisted_products'] = wishlisted_products($customer['user_id']);
        }

        $page = array();
        $page = $this->load->view('filtered-products', $inner, true);

        echo $page;
    }
}

// end of file
