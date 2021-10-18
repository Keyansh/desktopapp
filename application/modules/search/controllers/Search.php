<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Search extends Cms_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Searchmodel');
        $this->load->model('cms/Pagemodel');
    }

    function index($keywords = false, $offset = 0)
    {
        $globalBlocks = array();
        $globalBlocks = $this->Pagemodel->getGlobalBlocks(0);
        $shell['globalBlocks'] = $globalBlocks;

        $inner = array();
        $shell['keywords'] = $this->input->post('keywords');
        $shell['cid'] = $this->input->post('category');
        $shell['meta_title'] = 'Search';
        $shell['contents'] = $this->load->view('search-result', $inner, true);
        $this->load->view("themes/" . THEME . "/templates/product", $shell);
    }

    function getProducts()
    {
        $page = 0;
        $keyWord = '';
        $perPage = 0;
        $offset = 0;
        $count = 0;
        $outputHtml = '';
        $page = $this->input->post('page', true);
        $keyWord = $this->input->post('keyWord', true);
        $category = $this->input->post('category', true);
        $perPage = $this->input->post('perPage', true);
        //get current starting point of records
        $offset = (($page - 1) * $perPage);
        //        if (!empty($page) && !empty($keyWord) && !empty($perPage)) {
        $products = array();
        $products = $this->Searchmodel->listAll($keyWord, $offset, $perPage, $category);

        $count = $this->Searchmodel->countAll($keyWord);

        if ($products) {
            $outputHtml .= "<div class='product-listing-section col-xs-12'>";
            foreach ($products as $product) {

                if (file_exists($this->config->item('PRODUCT_PATH') . $product['img']) && $product['img']) {
                    $image_url = resize($this->config->item('PRODUCT_PATH') . $product['img'], 314, 419, 'product-search');
                } else {
                    $image_url = resize(FCPATH . 'images/img-default.jpg', 314, 419, 'product-search');
                }
                $outputHtml .= "<div class='col-xs-12 col-sm-3 product-listing-item-div '>";
                $outputHtml .= "<div class='product-listing-img-div'>";
                if (!$this->session->userdata('CUSTOMER_ID')) {
                    $outputHtml .=   "<a href='javascript:void(0)'' data-toggle='modal' data-target='#logInPop'>";
                } elseif ($this->session->userdata('CUSTOMER_ID')) {
                    $outputHtml .= "<a href='{$product['uri']}' class='userlog' data-type='product' data-id='" . $product['product_id'] . "'>";
                }
                $outputHtml .= "<img class='img-responsive product-listing-img' src='$image_url' alt='{$product['imgalt']}'>";
                $outputHtml .= "</a>";
                $outputHtml .= "</div>";
                $outputHtml .= "<div class='products-descr_col'>";
                $outputHtml .= "<p class='product-listing-p'>";
                if (!$this->session->userdata('CUSTOMER_ID')) {
                    $outputHtml .=   "<a href='javascript:void(0)' class='product-listing-a' data-toggle='modal' data-target='#logInPop'>";
                } elseif ($this->session->userdata('CUSTOMER_ID')) {
                    $outputHtml .= "<a class='product-listing-a' href='{$product['uri']}'>";
                }
                $outputHtml .=  $product['name'];
                $outputHtml .=  "</a>";
                $outputHtml .= "</p>";
                $outputHtml .= "</div>";
                $outputHtml .= "</div>";
            }
            $outputHtml .= "</div>";
        } else {
            $outputHtml .= "<p style='color:#ff0000; font-size: 17px;' class='padding-bottom text-center'>Product not found!</p>";
        }

        $data = array();
        $data['html'] = $outputHtml;
        if ($count > $perPage) {
            if (!empty($products)) {
                $data['count'] = 1;
            } else {
                $data['count'] = 0;
            }
        } else {
            $data['count'] = 0;
        }
        echo json_encode($data);
    }
}

// End of search.php
