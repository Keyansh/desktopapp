<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Checkout extends Cms_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('cart/Cartmodel');
        $this->load->model('Checkoutmodel');
        $this->load->model('customer/Customermodel');
        $this->load->model('customer/Ordermodel');
        $this->load->library('Memberauth');
        $this->load->library('form_validation');
        $this->load->library('cart');
        $this->load->library('parser');
        $this->load->library('email');
        $this->load->library('encrypt');
    }

    function email_check($str) {
        $this->db->where('email', $str);
        $query = $this->db->get('user');
        if ($query->num_rows() == 1) {
            $this->form_validation->set_message('email_check', 'Email already in use');
            return false;
        }
        return true;
    }

    function shipping(){
        if(isset($_POST['shipping_type'])){
            $this->session->set_userdata('shipping_type', $_POST['shipping_type']);
            echo 1;
        }else{
            echo 0;
        }
    }

    function index($guest = false) {
        $this->http->show404();
        return;
        $this->load->model('catalog/Productmodel');
        $this->load->model('cms/Pagemodel');
        if ($this->cart->total_items() == 0) {
            redirect('cart/index/', "location");
            exit();
        }
        $customer = array();
        $customer = $this->memberauth->checkAuth();

        $this->form_validation->set_rules('fname', 'Delivery First Name', 'trim|required');
        $this->form_validation->set_rules('lname', 'Delivery Last Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Delivery Email', 'trim|required');

        if ($guest) {
            $this->form_validation->set_rules('email', 'Email', 'trim|required|strtolower|valid_email|callback_email_check');
        } else {
            $this->form_validation->set_rules('email', 'Email', 'trim|required|strtolower|valid_email');
        }

        $this->form_validation->set_rules('phone', 'Delivery Phone', 'trim|required|is_numeric');
        $this->form_validation->set_rules('address', 'Delivery Address', 'trim|required');
        $this->form_validation->set_rules('city', 'Delivery City', 'trim|required');
        $this->form_validation->set_rules('postcode', 'Delivery Post Code', 'trim|required');
        $this->form_validation->set_rules('county', 'Delivery county', 'trim|required');
        $this->form_validation->set_rules('country', 'Delivery country', 'trim|required');

        // If Shipping Address is Different
        $ship_to_same_address = $this->input->post('ship_to_same_address');

        if (!$ship_to_same_address) {
            $this->form_validation->set_rules('shipping_fname', 'Billing First Name', 'trim|required');
            $this->form_validation->set_rules('shipping_lname', 'Billing Last Name', 'trim|required');
            $this->form_validation->set_rules('shipping_email', 'Billing Email', 'trim|required');

            if ($guest) {
                $this->form_validation->set_rules('shipping_email', 'Billing Email', 'trim|required|strtolower|valid_email|callback_email_check');
            } else {
                $this->form_validation->set_rules('shipping_email', 'Billing Email', 'trim|required|strtolower|valid_email');
            }

            $this->form_validation->set_rules('shipping_phone', 'Billing Phone', 'trim|required|is_numeric');
            $this->form_validation->set_rules('shipping_address', 'Billing Address 1', 'trim|required');
            $this->form_validation->set_rules('shipping_city', 'Billing City', 'trim|required');
            $this->form_validation->set_rules('shipping_postcode', 'Billing Post Code', 'trim|required');
            $this->form_validation->set_rules('shipping_county', 'Billing county', 'trim|required');
            $this->form_validation->set_rules('shipping_country', 'Billing country', 'trim|required');
            // End
        }

//        $this->form_validation->set_rules('delivery_charge', 'Shipping Method', 'trim|required');
        $this->form_validation->set_rules('payment_method', 'Payment Method', 'trim|required');
//        $this->form_validation->set_rules('card_num', 'Card Number', 'trim');
//        $this->form_validation->set_rules('name_on_card', 'Name on Card', 'trim');
//        $this->form_validation->set_rules('card_expiry', 'Card Expiry Date', 'trim');
//        $this->form_validation->set_rules('card_cvv', 'card CVV', 'trim');

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        $variables = $this->Cartmodel->variables();
        extract($variables);
//        e($variables);
        $shippingCost = 0;
        if (isset($variables['shipping']) && $variables['shipping']) {
            $shippingCost = $variables['shipping'];
        }

        if ($this->form_validation->run() == FALSE) {
            $jsonItemsArr = array();
            $contents = $this->cart->contents();
            if(!empty($contents)){
                $x = 1;
                foreach ($contents as $key => $content) {
                    $product = $this->Productmodel->fetchByIdCart($content['product_id']);
                    $quantity = $content['qty'];
                    $jsonItem['id'] = $product['id'];
                    $jsonItem['name'] = $product['name'];
                    $jsonItem['list_name'] = "Search Results";            
                    $jsonItem['brand'] = $product['bname'];
                    $jsonItem['category'] = $product['cname'];
                    $jsonItem['variant'] = "";            
                    $jsonItem['list_position'] = $x;
                    $jsonItem['quantity'] = $quantity;
                    $jsonItem['price'] = $product['price'];
                    $x++;
                    $jsonItemsArr[] = $jsonItem;
                }    
            }
            
            $inner = array();
            $inner['customer'] = $customer;
            $inner['cart_total'] = $cart_total;
            $inner['order_total'] = $order_total;
            $inner['vat'] = $vat;
            $inner['temp_post_fields'] = array();
            $inner['guest_customer'] = array();
            $inner['json_item'] = json_encode($jsonItemsArr);
            $this->html->addMeta($this->load->view("meta/checkout_index.php", $inner, TRUE));
            $shell = array();

            $templete = "";

            if ($guest) {
                $templete = 'checkout-index';
            } else {
                if ($customer) {
                    $templete = 'checkout-index';
                } else {
                    if ($this->session->flashdata('checkout-login')) {
                        $templete = 'checkout-index';
                    } else {
                        $session['REDIR_URL'] = "checkout";
                        $this->session->set_userdata($session);
                        $templete = 'checkout-index';
                        // $templete = 'checkout-preindex';
                    }
                }
            }

            $globalBlocks = array();
            $globalBlocks = $this->Pagemodel->getGlobalBlocks(0);
            $inner['globalBlocks'] = $globalBlocks;

            $inner['cart_contents'] = $this->cart->contents();
            $inner['variables'] = $this->Cartmodel->variables();
//            $this->cart->extraData($shippingCost);
            $shell['contents'] = $this->load->view($templete, $inner, true);
            $this->load->view("themes/" . THEME . "/templates/product", $shell);
        } else {            
            if (!$customer) {
                $customer = array();
                $customer['customer_id'] = $this->Customermodel->insertGuest();
                $customer = $this->Customermodel->fetchByID($customer['customer_id']);
            }
            $order = $this->Checkoutmodel->addOrder($customer, $order_total);
            if($this->input->post('payment_method') == 'paypal' ){
                if ($this->input->post('pay_by_phone') == 1) {
                    redirect("checkout/payment/success/{$order['order']['order_num']}");
                } else {
                    $this->session->set_userdata(array('LastOrderDetails' => $order));
                    redirect("checkout/payments/{$order['order']['order_num']}");
                }
            }
            if($this->input->post('payment_method') == 'stripe' ){
                redirect("checkout/stripe/st_process/" . $order['order']['order_num']);
            }else{
                redirect("checkout");
            }

            exit();
        }
    }

    function testemail() {
        $this->http->show404();
        return;
        $this->load->model('Checkoutmodel');
        $this->load->model('customer/Ordermodel');
        $this->load->library('parser');
        $this->load->library('email');
        $order = $this->Ordermodel->fetchById('53');
        $cart_content = $this->Checkoutmodel->OrderedItem('53');
        $orderdata['DATA'] = $order;
        $orderdata['cart_content'] = $cart_content;
        $emailBody = $this->parser->parse('emails/admin-order-email', $orderdata, TRUE);
        // print_r($emailBody);
        // die();
        $this->email->initialize($this->config->item('EMAIL_CONFIG'));
        $this->email->from(DWS_EMAIL_NOREPLY, DWS_EMAIL_FROM);
        $emailarray = array();
        //$emailarray[] = DWS_EMAIL_ADMIN;
        $emailarray[] = "rohit@multichannelcreative.co.uk";
        $this->email->to('devrohit46@gmail.com');

        //$this->email->bcc('js_thind@hotmail.com');
        $this->email->subject('New Order Placed');
        $this->email->message($emailBody);
        $this->email->send();
    }

    //Payment process
    function process() {
        $this->http->show404();
        return;
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
        $this->http->show404();
        return;
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
//e($order);
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
//        echo ($order['order_total']);
//        die();
//        $this->assets->addFooterJS('js/payment.js', 200);
        $shell['contents'] = $this->load->view('checkout/order-processing', $inner, true);

        $this->load->view("themes/" . THEME . "/templates/default", $shell);
    }

    //function success
    function success($onum, $stwo = false) {
        $this->http->show404();
        return;
        $this->load->model('customer/Ordermodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        log_message('debug', json_encode($_POST));
        log_message('debug', json_encode($_GET));
        //fetch the order details
        $order = $this->Ordermodel->fetchDetails($onum);

        //render vierw
        $inner = array();

        $inner['order'] = $order;
        $inner['stwo'] = $stwo;
        $shell = array();
        $shell['contents'] = $this->load->view('checkout/checkout-succeeded', $inner, true);

        $this->load->view("themes/" . THEME . "/templates/subpage", $shell);
    }

    //function failed
    function failed() {
        $this->http->show404();
        return;
        $this->load->library('form_validation');
        $this->load->helper('form');
        //render vierw
        $inner = array();
        $inner['resArray'] = $this->session->userdata('resArray');
        $inner['title'] = 'Failed';

        $shell = array();
        $shell['contents'] = $this->load->view('checkout/payment-failed', $inner, true);
        $this->load->view("themes/" . THEME . "/templates/subpage", $shell);
    }

    function getProAttr() {
        $this->load->model('catalog/Productmodel');
        $this->load->model('catalog/Attributesmodel');
        $pro_id = $this->input->post('parent_product');
        $attr_id = $this->input->post('attr_id');
        $childProducts = $this->Productmodel->ChildProducts($pro_id);
        foreach ($childProducts as $childProduct) {
            $attributes[$childProduct['id']] = $this->Attributesmodel->fetchByProductID($childProduct['id']);
        }
        $attrArray = array();
        foreach ($attributes as $productA) {
            foreach ($productA as $valA) {
                if (!isset($attrArray[$valA['label']]) || !in_array($valA['option'], $attrArray[$valA['label']])) {
                    $attrArray[$valA['label']][$valA['value']] = $valA['option'];
                }
            }
        }
        e($attrArray);
        if ($attrArray) {
            $inner['attrArray'] = $attrArray;
        }
    }

    function quotation($qnum) {
        $this->http->show404();
        return;
        $this->load->model('Checkoutmodel');
        $this->load->library('form_validation');

        /* //check the customers login
          if (!$this->customerauth->checkAuth()) {
          $this->session->set_userdata('REDIR_URL', "success/");
          redirect('/customer/login', "location");
          exit();
          }
         */
        //fetch order details
        $quotation = array();
        $quotation = $this->Checkoutmodel->quotation($qnum);
//        e($quotation);

        if (!$quotation) {
            $this->utility->show404();
            return;
        }

        //render view
        $inner = array();
        $shell = array();
        $inner['quotation'] = $quotation;
        if ($quotation['confirmed'] == 0) {
            $this->Checkoutmodel->quotationConfirm($quotation);
            $shell['contents'] = $this->load->view('checkout/quotation/quotation-succeeded', $inner, true);
        } else {
            $shell['contents'] = $this->load->view('checkout/quotation/quotation-failed', $inner, true);
        }
        $this->load->view("themes/" . THEME . "/templates/default", $shell);
    }

    //***************************Validation Functions Start ****************************************************************
    function login_check($str) {
        $this->load->library('encrypt');

        $this->db->where('email', $this->input->post('email', TRUE));
        $this->db->where('user_is_active', 1);
        $query = $this->db->get('user');


        if ($query->num_rows() == 1) {

            $row = $query->row_array();

            if ($this->encrypt->decode($row['passwd']) === $this->input->post('passwd', TRUE)) {
                return true;
            }
        }

        $this->form_validation->set_message('login_check', 'Login failed');
        return false;
    }

    //*****************************Validation Functions End ********************************************************************

    function login() {
        $this->load->model('Customermodel');
        $this->load->model('cart/Cartmodel');
        $this->load->library('form_validation');
        $this->load->library('email');
        $this->load->library('parser');
        $this->load->helper('form');
        $this->load->helper('text');
        $this->load->library('cart');

        if ($this->cart->total_items() == 0) {
            redirect('cart/index/', "location");
            exit();
        }

        $customer = array();
        $customer = $this->memberauth->checkAuth();
        if ($customer) {
            redirect("/checkout/paymentreview/");
            exit();
        }
        //Get Page Details
        //validation check

        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('passwd', 'Password', 'trim|required|callback_login_check');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();

            $shell = array();
            $shell['contents'] = $this->load->view('login-form', $inner, true);
            $this->load->view("themes/" . THEME . "/templates/default", $shell);
        } else {
            $this->db->where('email', $this->input->post('email', true));
            $rs = $this->db->get('user');
            // e($rs->row_array());
            if ($rs->num_rows() == 1) {
                $customer = $rs->row_array();
                $x = $this->cart->contents();
                if (!empty($x)) {
                    $this->Cartmodel->addAbandonOrder($customer);
                }


                $session = $customer;
                $session['CUSTOMER_ID'] = $customer['user_id'];
                $session['LOGIN_EMAIL'] = $customer['email'];
                $this->session->set_userdata($session);
                // e($session,0);
                // e($this->session->all_userdata());
                if ($this->session->userdata('REDIR_URL') == "") {
                    redirect("checkout/paymentreview");
                    exit();
                } else {
                    $url = $this->session->userdata('REDIR_URL');
                    $this->session->unset_userdata('REDIR_URL');
                    header("location: " . base_url() . "$url");
                    exit();
                }
            }
            redirect("/checkout/login/");
            exit();
        }
    }

    function paymentreview() {
//        $this->load->library('session');
        $this->load->model('cart/Cartmodel');
        $this->load->model('Checkoutmodel');
        $this->load->model('customer/Customermodel');
        $this->load->model('customer/Ordermodel');
        $this->load->library('Memberauth');
        $this->load->library('form_validation');
        $this->load->library('cart');
        $this->load->library('parser');
        $this->load->library('email');
        $this->load->library('encrypt');

        // e($this->session->all_userdata());

        if ($this->cart->total_items() == 0) {
            redirect('cart/index/', "location");
            exit();
        }


        $customer = array();
        $customer = $this->memberauth->checkAuth();
//        e($customer);
        if (!$customer && !$guest) {
//            $this->session->set_userdata('REDIR_URL', "checkout");
            redirect('checkout/login', "location");
            exit();
        }

        if ($customer) {
            $x = $this->cart->contents();
            if (!empty($x)) {
                $this->Cartmodel->addAbandonOrder($customer);
            }
        }

        $title = array();
        $title[''] = '--Select--';
        $title['mr'] = 'Mr';
        $title['mrs'] = 'Mrs';
        $title['miss'] = 'Miss';

        //Get customers Details
//        $this->form_validation->set_rules('title', 'Billing Title ', 'trim|required');
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
//        if ($guest) {
//            $this->form_validation->set_rules('email', 'Email', 'trim|required|strtolower|valid_email|callback_email_check');
//        } else {
//            $this->form_validation->set_rules('email', 'Email', 'trim|required|strtolower|valid_email');
//        }

        $this->form_validation->set_rules('address1', 'Billing Address', 'trim|required');
        $this->form_validation->set_rules('city', 'Billing City', 'trim|required');
        $this->form_validation->set_rules('phone', 'Billing Phone', 'trim|required|is_numeric');
        $this->form_validation->set_rules('postcode', 'Billing Post Code', 'trim|required');
        $this->form_validation->set_rules('county', 'Billing county', 'trim|required');

        // shipping
//        $this->form_validation->set_rules('s_title', 'Shipping Title ', 'trim|required');
        $this->form_validation->set_rules('s_first_name', 'Shipping First Name', 'trim|required');
        $this->form_validation->set_rules('s_last_name', 'Shipping Last Name', 'trim|required');
        $this->form_validation->set_rules('s_address1', 'Shipping Address', 'trim|required');
        $this->form_validation->set_rules('s_city', 'Shipping City', 'trim|required');
        $this->form_validation->set_rules('s_phone', 'Shipping Phone', 'trim|required|is_numeric');
        $this->form_validation->set_rules('s_postcode', 'Shipping Post Code', 'trim|required');

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        //$this->assets->addFooterJS('js/website/checkout.js', 150);
        $variables = $this->Cartmodel->variables();

        extract($variables);
        if ($this->form_validation->run() == FALSE) {

            //Render View
            $inner = array();
//            $inner['delivery_details'] = $this->utility->getDeliveryDet();
//            $inner['delivery_index'] = $this->session->userdata('delivery_index');
            $inner['customer'] = $customer;
            $inner['cart_total'] = $cart_total;
            $inner['title'] = $title;
//            $inner['delivery_charge'] = $delivery_charge;
//            $inner['shipping'] = $shipping;
//            $inner['tax'] = $tax;
//            $inner['discount'] = 0.00;
            $inner['order_total'] = $order_total;
            $inner['vat'] = $vat;
//            $inner['vat_order_total'] = $vat_order_total;
//            $inner['countries'] = $countries;
            $inner['temp_post_fields'] = array();
            $inner['customer'] = array();
            $inner['guest_customer'] = array();
            $this->html->addMeta($this->load->view("meta/checkout-index.php", $inner, TRUE));
            $shell = array();

            $templete = 'payment';
            if ($guest) {
                if ($this->session->userdata('temp_post_fields') && is_array($this->session->userdata('temp_post_fields'))) {
                    $inner['guest_customer'] = $this->session->userdata('temp_post_fields');
                }
                $templete = 'checkout-guest';
                $inner['temp_post_fields'] = array('title', 'first_name', 'last_name', 'email', 'address1', 'address2',
                    'city', 'county', 'postcode', 'country', 'phone', 's_title', 's_first_name', 's_last_name', 's_email', 's_address1', 's_address2',
                    's_city', 's_county', 's_postcode', 's_country', 's_phone');
            }
            $inner['customer'] = $customer;
            // e($templete);
            $inner['extra_data'] = $this->cart->extraData();
            $shell['contents'] = $this->load->view($templete, $inner, true);
            $this->load->view("themes/" . THEME . "/templates/default", $shell);
        } else {
            if ($guest) {
                $customer = array();
                $customer['customer_id'] = $this->Customermodel->insertGuest();
                $customer = $this->Customermodel->fetchByID($customer['customer_id']);
            }

            $order = $this->Checkoutmodel->addOrder($customer, $order_total);
            if ($this->input->post('pay_by_phone') == 1) {
                redirect("checkout/success/{$order['order']['order_num']}/ph");
            } else {
                $this->session->set_userdata(array('LastOrderDetails' => $order));
                redirect("checkout/payments/{$order['order']['order_num']}");
            }
            exit();
        }
    }

    function paymentredirect($guest = false) {
        $this->load->library('session');
        $this->load->model('cart/Cartmodel');
        $this->load->model('Checkoutmodel');
        $this->load->model('customer/Customermodel');
        $this->load->model('customer/Ordermodel');
        $this->load->library('Memberauth');
        $this->load->library('form_validation');
        $this->load->library('cart');
        $this->load->library('parser');
        $this->load->library('email');
        $this->load->library('encrypt');

        // e($this->session->all_userdata());

        if ($this->cart->total_items() == 0) {
            redirect('cart/index/', "location");
            exit();
        }

        $customer = array();
        $customer = $this->memberauth->checkAuth();

        //$this->assets->addFooterJS('js/website/checkout.js', 150);
        $variables = $this->Cartmodel->variables();

        extract($variables);

        if ($guest) {
            $customer = array();
            $customer['customer_id'] = $this->Customermodel->insertGuest();
            $customer = $this->Customermodel->fetchByID($customer['customer_id']);
        }

        $order = $this->Checkoutmodel->addOrder($customer, $order_total);
        if ($this->input->post('pay_by_phone') == 1) {
            redirect("checkout/success/{$order['order']['order_num']}/ph");
        } else {
            $this->session->set_userdata(array('LastOrderDetails' => $order));
            redirect("checkout/
            /{$order['order']['order_num']}");
        }
        exit();
    }

}

?>
