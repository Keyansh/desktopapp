<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Order extends Cms_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index($offset = 0)
    {
        //        $this->load->model('cms/Templatemodel');
        $this->load->model('Ordermodel');
        $this->load->library('pagination');
        $this->load->helper('text');
        $this->load->model('Customermodel');
        $this->load->model('cart/Cartmodel');

        //Check for customer login
        if (!$this->memberauth->checkAuth()) {
            redirect("/customer/login/");
            exit();
        }

        //Get customers Details
        $customer = array();
        $customer = $this->Customermodel->fetchByID($this->session->userdata('CUSTOMER_ID'));
        if (count($customer) == 0) {
            redirect('/customer/logout/', "location");
            exit();
        }

        //setup Pagination
        $perpage = 10;
        $config = array();
        $config['base_url'] = base_url() . "customer/order/index/";
        $config['uri_segment'] = 4;
        $config['total_rows'] = $this->Ordermodel->countAll($customer);
        $config['per_page'] = $perpage;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a><b>';
        $config['cur_tag_close'] = '</a></b></li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';


        $this->pagination->initialize($config);

        $orders = array();
        $orders = $this->Ordermodel->listAll($customer, $offset, $perpage);
        $ordersEnquiry = array();
        $ordersEnquiry = $this->Ordermodel->listAllEnquiry($customer['user_id'], $offset, $perpage);
        // e($ordersEnquiry);
        //        $availableoffers = array();
        //        $availableoffers = $this->Cartmodel->availableOffers();
        //        $customer_stars = $this->Cartmodel->getCustomerStars();
        //Render View
        $inner = array();
        $shell = array();
        $inner['customer'] = $customer;
        $inner['orders'] = $orders;
        $inner['ordersEnquiry'] = $ordersEnquiry;
        //        $inner['availableoffers'] = $availableoffers;
        //        $inner['customer_stars'] = $customer_stars;
        $inner['pagination'] = $this->pagination->create_links();
        $shell['contents'] = $this->load->view("order/order-index", $inner, true);
        $this->load->view("themes/" . THEME . "/templates/product", $shell);
    }

    //Order Details
    function details($onum)
    {

        //      $this->load->model('cms/Templatemodel');
        $this->load->model('Ordermodel');
        $this->load->model('Customermodel');
        $this->load->library('pagination');
        $this->load->helper('text');
        //Check for customer login
        if (!$this->memberauth->checkAuth()) {
            redirect("/customer/login/");
            exit();
        }

        //Get customers Details
        $customer = array();
        $customer = $this->Customermodel->fetchByID($this->session->userdata('CUSTOMER_ID'));
        if (count($customer) == 0) {
            redirect('/customer/logout/', "location");
            exit();
        }

        //get order details
        $order = array();
        $order = $this->Ordermodel->fetchByOrderNum($onum);
        $vat_Value = $this->vat($order['cart_total']);

        if (!$order) {
            $this->utility->show404();
            return;
        }

        //get order items
        $order_items = array();
        $order_items = $this->Ordermodel->listOrderItems($order['order_id']);

        //check customer see own order
        if ($customer['user_id'] != $order['customer_id']) {
            redirect('/customer/logout/', "location");
            exit();
        }

        //render view
        $inner = array();
        $inner['order'] = $order;
        $inner['vat_val'] = $vat_Value;
        $inner['order_items'] = $order_items;
        $inner['customer'] = $customer;

        $shell['contents'] = $this->load->view("order/order-detail", $inner, true);
        $this->load->view("themes/" . THEME . "/templates/product", $shell);
    }

    // Calculate vat value

    function vat($price_without_vat)
    {

        // $vat = DWS_VAT; // define what % vat is

        // $price = $vat * ($price_without_vat / 100); // work out the amount of vat

        // $price_with_vat = round($price, 2); // round to 2 decimal places

        // return $price_with_vat;
    }

    function printer($onum)
    {
        $this->load->model('cms/Templatemodel');
        $this->load->model('Ordermodel');
        $this->load->model('Customermodel');
        $this->load->library('pagination');
        $this->load->helper('text');

        //Check for customer login
        if (!$this->memberauth->checkAuth()) {
            redirect("/customer/login");
            exit();
        }

        //Get customers Details
        $customer = array();
        $customer = $this->Customermodel->fetchByID($this->session->userdata('CUSTOMER_ID'));
        if (count($customer) == 0) {
            redirect('/customer/logout');
            exit();
        }

        //get order details
        $order = array();
        $order = $this->Ordermodel->fetchByOrderNum($onum);
        if (!$order) {
            $this->utility->show404();
            return;
        }


        //get order items
        $order_items = array();
        $order_items = $this->Ordermodel->listOrderItems($order['order_id']);

        //check customer see own order
        if ($customer['customer_id'] != $order['customer_id']) {
            redirect('/customer/logout');
            exit();
        }

        //print_r($order);
        //render view
        $inner = array();
        $inner['order'] = $order;
        $inner['order_items'] = $order_items;
        $inner['customer'] = $customer;

        $shell['contents'] = $this->load->view("order/order-detail-print", $inner, true);
        $html = $this->load->view("themes/" . THEME . "/templates/print", $shell, true);

        echo $html;
        exit();

        include(APPPATH . '/libraries/Pdface.php');
        $pdface = new Pdface('BUQSASSAZZ3JHL8Y', '3SbNm6WX');
        $options = array();
        $options['width'] = '4in';
        $pdface->setOptions($options);
        $response = $pdface->htmlToPdf($html);

        echo $html;

        echo $pdface->ERROR_MESSAGE;

        file_put_contents('print.pdf', $response);
    }

    function reorder($onum = 0)
    {
        $this->load->model('Ordermodel');
        $this->load->model('Customermodel');
        $this->load->library('pagination');
        $this->load->helper('text');

        //get order details
        $order = array();
        $order = $this->Ordermodel->fetchByOrderNum($onum);
        if (!$order) {
            $this->utility->show404();
            return;
        }

        //get order items
        $order_items = array();
        $order_items = $this->Ordermodel->listOrderItems($order['order_id']);

        foreach ($order_items as $item) {
            $this->db->where('product_id', $item['product_id']);
            $rs = $this->db->get('product');
            $product = $rs->row_array();


            $data = array();
            $options = array();

            //add interval time
            $data['id'] = $item['product_id'];
            $data['qty'] = $item['order_item_qty'];
            $data['name'] = $item['order_item_name'];
            $data['price'] = $product['product_price'];
            $data['is_meal'] = $item['is_meal'];
            $data['options'] = $options;

            $this->cart->insert($data);
        }

        redirect('checkout');
        exit();
    }

    function updateOrderRef()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('order_reference', 'Order name should be less then 20 chars', 'required|trim|max_length[20]');
        if ($this->form_validation->run() == FALSE) {
            $this->form_validation->set_message('error', 'ref_length_20');
            redirect('customer/order');
            exit;
        }
        $orderRef = $this->input->post('order_reference', true);
        if ($orderRef) {
            $order_id = $this->input->post('order_id', true);

            $data = array();
            $data['order_ref'] = $orderRef;

            $this->db->where('order_id', $order_id)
                ->update('order', $data);
        }
        redirect('customer/order');
        exit;
    }

    //Order Details
    function enquiryDetails($enum)
    {

        $this->load->model('Ordermodel');
        $this->load->model('Customermodel');
        $this->load->library('pagination');
        $this->load->helper('text');
        //Check for customer login
        if (!$this->memberauth->checkAuth()) {
            redirect("/customer/login/");
            exit();
        }

        //Get customers Details
        $customer = array();
        $customer = $this->Customermodel->fetchByID($this->session->userdata('CUSTOMER_ID'));
        if (count($customer) == 0) {
            redirect('/customer/logout/', "location");
            exit();
        }

        //get order details
        $enquiryDetails = array();
        $enquiryDetails = $this->Ordermodel->enquiryDetails($enum);

        if (!$enquiryDetails) {
            $this->utility->show404();
            return;
        }

       

        //render view
        $inner = array();
        $inner['enquiryDetails'] = $enquiryDetails;
        $inner['customer'] = $customer;

        $shell['contents'] = $this->load->view("order/order-detail", $inner, true);
        $this->load->view("themes/" . THEME . "/templates/product", $shell);
    }
}
