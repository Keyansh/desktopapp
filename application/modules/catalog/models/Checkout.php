<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Checkout extends Cms_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->load->library('session');
        $this->load->model('cart/Cartmodel');
        $this->load->model('Checkoutmodel');
        $this->load->model('customer/Customermodel');
        $this->load->library('Memberauth');
        $this->load->library('form_validation');
        $this->load->library('cart');



        if ($this->cart->total_items() == 0) {
            redirect('cart/cart/index/', "location");
            exit();
        }


        if (!$this->memberauth->checkAuth()) {
            $this->session->set_userdata('REDIR_URL', "checkout");
            redirect('customer/login', "location");
            exit();
        }

        $title = array();
        $title[''] = '--Select--';
        $title['mr'] = 'Mr';
        $title['mrs'] = 'Mrs';
        $title['mis'] = 'Mis';

        //Get customers Details
        $customer = array();
        $customer = $this->Customermodel->fetchByID($this->session->userdata('CUSTOMER_ID'));
        if (!$customer) {
            redirect('/customer/logout', "location");
            exit();
        }
//        echo "<pre>";
//        print_r($customer);
//        exit;
        //     print_r($_POST); exit;
        $this->form_validation->set_rules('title', 'Billing Title ', 'trim|required');
        $this->form_validation->set_rules('first_name', 'Billing First Name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'Billing Last Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|strtolower|valid_email');

        $this->form_validation->set_rules('address1', 'Billing Address 1', 'trim|required');
        $this->form_validation->set_rules('address2', 'Billing Address 2', 'trim');
        $this->form_validation->set_rules('city', 'Billing City', 'trim|required');
        $this->form_validation->set_rules('county', 'Billing county', 'trim|required');
        $this->form_validation->set_rules('phone', 'Billing Phone', 'trim|required|is_numeric');
        $this->form_validation->set_rules('postcode', 'Billing Post Code', 'trim|required');

        // shipping 

        $this->form_validation->set_rules('s_title', 'Shipping Title ', 'trim|required');
        $this->form_validation->set_rules('s_first_name', 'Shipping First Name', 'trim|required');
        $this->form_validation->set_rules('s_last_name', 'Shipping Last Name', 'trim|required');
        $this->form_validation->set_rules('s_address1', 'Shipping Address 1', 'trim|required');
        $this->form_validation->set_rules('s_address2', 'Shipping Address 2', 'trim');
        $this->form_validation->set_rules('s_city', 'Shipping City', 'trim|required');
        $this->form_validation->set_rules('s_county', 'Shipping county', 'trim|required');
        $this->form_validation->set_rules('s_phone', 'Shipping Phone', 'trim|required|is_numeric');
        $this->form_validation->set_rules('s_postcode', 'Shipping Post Code', 'trim|required');
        $this->form_validation->set_rules('cus_order_num', 'Order Number', 'trim|required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');


        $variables = $this->Cartmodel->variables();
        extract($variables);


        if ($this->form_validation->run() == FALSE) {
            //Render View
            $inner = array();

            $inner['customer'] = $customer;
            $inner['cart_total'] = $cart_total;
            $inner['title'] = $title;
//            $inner['shipping'] = $shipping;
            $inner['tax'] = $tax;
            $inner['discount'] = 0.00;
            $inner['order_total'] = $order_total;

            $this->html->addMeta($this->load->view("meta/checkout-index.php", $inner, TRUE));
            $shell = array();
            $shell['contents'] = $this->load->view('checkout-index', $inner, true);
            $this->load->view("themes/" . THEME . "/templates/subpage", $shell);
        } else {
//            $userorder = $this->Checkoutmodel->addOrder($customer, $order_total);
//            $this->session->set_userdata($userorder);
//            redirect("world/pay");
//            exit();
//            if ($_POST['worldpay']) {
//                 $order = $this->Checkoutmodel->addOrder($customer, $order_total);
//                 $this->session->set_userdata($order);
//                 redirect("world/pay");
//                exit();
//            } else {
//            print_r($customer); 
//            print_r($order_total);
//            exit;

            $order = $this->Checkoutmodel->addOrder($customer, $order_total);
//                echo '<pre>';
//                print_r($order); exit;
            redirect("checkout/payments/{$order['order']['order_num']}");
            exit();
//            }
        }
    }

    //Payment process
    function process() {

        $this->load->model('catalog/Productmodel');
        $this->load->model('catalog/Cartmodel');
        $this->load->model('catalog/Attributesmodel');
        $this->load->model('customer/Customermodel');
        $this->load->model('Checkoutmodel');
        $this->load->library('form_validation');
        $this->load->library('Memberauth');
        $this->load->library('cart');
        $this->load->library('parser');
        $this->load->library('email');

        if (!$this->memberauth->checkAuth()) {
            $this->session->set_userdata('REDIR_URL', "checkout");
            redirect('/customer/login', "location");
            exit();
        }


        //Get customers Details
        $customer = array();
        $customer = $this->Customermodel->fetchByID($this->session->userdata('CUSTOMER_ID'));
        if (!$customer) {
            redirect('/customer/logout', "location");
            exit();
        }

        $variables = $this->Cartmodel->variables();
        extract($variables);

        $order = $this->Checkoutmodel->addOrder($customer, $order_total);

        redirect("checkout/payments/{$order['order']['order_num']}");
        exit();
    }

    //Payment processing
    function payments($onum) {


        //$this->load->model('catalog/Productmodel');
        $this->load->model('Checkoutmodel');
        $this->load->model('customer/Ordermodel');
        $this->load->library('form_validation');
        $this->load->library('cart');
        //$this->assets->addFooterJS('js/payment.js');

        /* //check the customers login
          if (!$this->customerauth->checkAuth()) {
          $this->session->set_userdata('REDIR_URL', "success/");
          redirect('/customer/login', "location");
          exit();
          }
         */
        //fetch order details
        $order = array();
        $order = $this->Ordermodel->detail($onum);

//        $this->Checkoutmodel->orderConfirmed($order);

        if (!$order) {
            $this->utility->show404();
            return;
        }
// echo "<pre>";
//        print_r($order); exit;
        //render view
        $inner = array();
        $shell = array();
        $inner['order'] = $order;
        $this->assets->addFooterJS('js/payment.js', 200);
        $shell['contents'] = $this->load->view('checkout/order-processing', $inner, true);

        $this->load->view("themes/" . THEME . "/templates/subpage", $shell);
    }

    //function success
    function success($onum) {
        $this->load->model('customer/Ordermodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //fetch the order details
        $order = $this->Ordermodel->fetchDetails($onum);

        //render vierw
        $inner = array();

        $inner['order'] = $order;

        $shell = array();
        $shell['contents'] = $this->load->view('checkout/messages/checkout-succeeded', $inner, true);

        $this->load->view("themes/" . THEME . "/templates/subpage", $shell);
    }

    //function failed
    function failed() {
        $this->load->library('form_validation');
        $this->load->helper('form');

        //render vierw
        $inner = array();
//        $inner['resArray'] = $this->session->userdata('resArray');
//        $inner['title'] = 'Failed';

        $shell = array();
        $shell['contents'] = $this->load->view('payment/payment-cancel', $inner, true);
        $this->load->view("themes/" . THEME . "/templates/subpage", $shell);
    }

}

?>