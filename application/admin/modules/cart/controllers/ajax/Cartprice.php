<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cartprice extends Cms_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
    }

    function fetch_price() {
        $this->load->model('Productmodel');
        $this->load->model('cart/Cartmodel');


        $quantity = $this->input->post('quantity', true);
        $price = 0;



        $product_detail = array();
        $product_detail = $this->Productmodel->getDetails($this->input->post('pid', true));

        $product_price = $product_detail['product_price'] + $price;

        $product_price = $product_price * $quantity;

        // fetch discount 
        $discount = $this->Cartmodel->productDiscount($product_detail, $quantity);
        //print_R($discount); exit();

        $product_discount = round(($product_price * $discount) / 100, 2);
        $product_price = $product_price - $product_discount;
        // print_R($product_price); exit();

        $output = array();
        $output['price'] = $product_price;

        echo json_encode($output);
        exit();
        //echo "Done";
    }

}

?>