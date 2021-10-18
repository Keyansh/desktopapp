<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Payment extends Cms_Controller {

    private $debug = TRUE;
    private $log_level = 'error';
    private $sandbox = TRUE;

    function __construct() {
        parent::__construct();
    }

    function index() {
        error_log("Start Validatiing \n\n", 3, "my-errors.log");

        error_log(print_r($_REQUEST,TRUE), 3, "my-errors.log");

        if (!$this->verify_ipn()) {
            return;
        }

        if ($_POST['receiver_email'] != DWS_PAYPAL) {
            if ($this->debug)
                log_message($this->log_level, "Receiver Email ({$_POST['receiver_email']}) didn't match client's PayPal ID " . DWS_PAYPAL);
            return;
        }

        log_message($this->log_level, "Order Detail: executing proccess");

        $this->process();
    }

    function verify_ipn() {


        if (count($_POST) == 0) {
            if ($this->debug)
                log_message($this->log_level, "Direct Access to IPN script");
            return false;
        }

        //Build up verification request
        $req = 'cmd=_notify-validate';
        $original = '';
        foreach ($_POST as $ipnkey => $ipnval) {
            $original .= "$ipnkey=$ipnval&";
            $ipnval = str_replace("\n", "\r\n", $ipnval);
            $ipnval = stripslashes($ipnval);
            $req .= '&' . $ipnkey . '=' . ($ipnval);
        }

        //Initialize Curl and Send verification request
        $ch = curl_init();
        if (DWS_DEMO_MODE == '1') {

            curl_setopt($ch, CURLOPT_URL, "https://www.sandbox.paypal.com/cgi-bin/webscr");
            //curl_setopt($ch, CURLOPT_URL, "http://www.belahost.com/pp/");
        } else {
            curl_setopt($ch, CURLOPT_URL, "https://www.paypal.com/cgi-bin/webscr");
        }
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        $ret = curl_exec($ch);
        if ($this->debug)
            log_message($this->log_level, "IPN Response: $ret");

        //Invalid IPN
        if (strcmp($ret, "VERIFIED") != 0) {
            if ($this->debug) {
                log_message($this->log_level, "Failed to verify IPN. See next two lines for details.");
                log_message($this->log_level, "IPN Received: $original");
                log_message($this->log_level, "IPN Sent: $req");
            }
            curl_close($ch);
            return false;
        }

        //fclose($clog);
        curl_close($ch);

        return true;
    }

    private function process() {
        $this->load->model('customer/Ordermodel');
        $this->load->model('Checkoutmodel');
        $this->load->library('parser');
        $this->load->library('email');

        log_message($this->log_level, "Order Detail: start of proccess");

        //if ($_POST['payment_status'] != 'Completed')
        //    return;

        log_message($this->log_level, "Order Detail: After complete");
        log_message($this->log_level, "Order id: " . $_POST['custom']);


        //Fetch order details
        $order = array();
        $order = $this->Ordermodel->fetchById($_POST['custom']);
        log_message($this->log_level, "Order id: " . serialize($order));

        //insert trasection id

        log_message($this->log_level, "transcation id: " . $_POST['txn_id']);
        $data = array();
        $data['transaction_no'] = $_POST['txn_id'];
        $this->db->where('order_id', $order['order_id']);
        $data['is_paid'] = 1;
        $data['confirmed'] = 1;
        $this->db->update('order', $data);


        if (!$order) {
            if ($this->debug)
                log_message($this->log_level, 'Invalid order_id:' . $_POST['custom']);
            return;
        }


        //Verify amount
        if (!$this->input->post('amount') || $this->input->post('amount') != $order['amount']) {
            if ($this->debug)
                log_message($this->log_level, 'Amount posted by MB does not match Ordered amount: ' . $this->input->post('amount') . "==" . $order['amount']);
            //return;
        }

        if (!$_POST['mc_gross'] || $_POST['mc_gross'] != $order['amount']) {
            if ($this->debug)
                log_message($this->log_level, 'Amount posted by MB does not match Ordered amount: ' . $this->input->post('amount') . "==" . $order['amount']);
            //return;
        }

        $order_details = serialize($order);

        log_message($this->log_level, "Order Detail: $order_details");

        $this->Checkoutmodel->orderConfirmed($order);
    }

    //function cancel
    function cancel() {
        //render view
        $inner = array();
        $shell = array();

        $shell['contents'] = $this->load->view("payment/payment-cancel", $inner, TRUE);
        //$this->load->view('themes/'.DWS_THEME.'/shell', $shell);
        $this->load->view("themes/" . THEME . "/templates/subpage", $shell);
    }

    //function success
    function success($order_num) {
        //Render view
        $this->load->model('Checkoutmodel');
        $this->load->model('customer/Ordermodel');

        $inner = array();
        $shell = array();
        log_message('debug', json_encode($_POST));
        log_message('debug', json_encode($_GET));
        $orderDet = $this->Ordermodel->detail($order_num);
//        echo "<pre>"; print_R($orderDet); exit;
        /*
         * $session_id = $this->session->userdata('LastOrderDetails');
         * if(!empty($session_id)){
         * }
         * */
        if ($orderDet) {
            // Adjust stock quantity
            if (isset($orderDet['order_id'])) {
                $this->manage_stock($orderDet['order_id']);
                // $this->send_emails($orderDet);
            }

            $customer = array();
            $customer = $this->memberauth->checkAuth();
            $inner['customer'] = $customer;
//            $this->Checkoutmodel->orderConfirmed($orderDet);
//            $this->session->unset_userdata('LastOrderDetails');
//            e(44);
           redirect("checkout/payment/orderplaced");
        } else {
            $this->utility->show404();
            return;
        }
    }
    function orderplaced(){
        $this->load->model('catalog/Productmodel');
        $orderData = $jsonItemsArr = $orderDetail = $orderItems = array();
        $orderData = $this->session->userdata('LastOrderDetails');        
        if(!empty($orderData)){
            $orderDetail = $orderData['order'];            
            $orderItems = $this->db->select('*')->from('order_item')->where('order_id', $orderData['order_id'])->get()->result_array();
            if(!empty($orderItems)){
                $x = 1;
                foreach ($orderItems as $key => $content) {                    
                    $product = $this->Productmodel->fetchByIdCart($content['product_id']);                    
                    $quantity = $content['order_item_qty'];
                    $price = $content['order_item_price'];
                    $jsonItem['id'] = $product['id'];
                    $jsonItem['name'] = $product['name'];
                    $jsonItem['list_name'] = "Search Results";            
                    $jsonItem['brand'] = $product['bname'];
                    $jsonItem['category'] = $product['cname'];
                    $jsonItem['variant'] = "";            
                    $jsonItem['list_position'] = $x;
                    $jsonItem['quantity'] = $quantity;
                    $jsonItem['price'] = $price;
                    $x++;
                    $jsonItemsArr[] = $jsonItem;
                }    
            }            
        }
        $this->session->unset_userdata('LastOrderDetails');
        $inner = $shell = array();
        $inner['orderDetail'] = $orderDetail;        
        $inner['jsonitems'] = json_encode($jsonItemsArr);        
        $this->html->addMeta($this->load->view("meta/payment_success.php", $inner, TRUE));
        $shell['contents'] = $this->load->view("payment/payment-success", $inner, TRUE);
        $this->load->view("themes/" . THEME . "/templates/default", $shell);

    }
    function manage_stock($order_id = 0) {
        $rs = $this->db->select('order_item.product_id, order_item.order_item_qty')
            ->from('order_item')
            ->join('order', 'order.order_id = order_item.order_id')
            ->where('order.order_id', $order_id)
            ->get();

        if ($rs->num_rows()) {
            $rs = $rs->result_array();

            foreach ($rs as $item) {
                $rs2 = array();
                $rs2 = $this->db->select('quantity')
                    ->from('product')
                    ->where('id', $item['product_id'])
                    ->get();

                if ($rs2->num_rows() == 1) {
                    $r = $rs2->first_row('array');

                    $current_quantity = $r['quantity'];
                    $new_quantity = $current_quantity - $item['order_item_qty'];

                    $this->db->set('quantity', $new_quantity)
                    ->where('id', $item['product_id'])
                    ->update('product');
                }
            }
        }
    }

    function send_emails($sorder) {
        $this->load->model('Checkoutmodel');
        $this->load->library('email');
        $this->load->library('parser');

        // Send email to customer.
        $emailData = array();
        $emailData['DATE'] = date("jS F, Y");
        $emailData['ORDER_REF'] = $sorder['order_ref'];
        $emailData['ORDER_NUM'] = $sorder['order_num'];
        $emailData['S_FIRSTNAME'] = $sorder['s_first_name'];
        $emailData['S_LASTNAME'] = $sorder['s_last_name'];
        $emailData['S_STREET'] = $sorder['s_address1'];
        $emailData['S_STREET2'] = $sorder['s_address2'];
        $emailData['S_CITY'] = $sorder['s_city'];
        $emailData['S_COUNTY'] = $sorder['s_county'];
        $emailData['S_POSTCODE'] = $sorder['s_postcode'];
        $emailData['S_PHONE'] = $sorder['s_phone'];
        $emailData['EMAIL'] = $sorder['email'];
        $emailData['B_FIRSTNAME'] = $sorder['b_first_name'];
        $emailData['B_LASTNAME'] = $sorder['b_last_name'];
        $emailData['B_STREET'] = $sorder['b_address1'];
        $emailData['B_STREET2'] = $sorder['b_address2'];
        $emailData['B_CITY'] = $sorder['b_city'];
        $emailData['B_COUNTY'] = $sorder['b_county'];
        $emailData['B_POSTCODE'] = $sorder['b_postcode'];
        $emailData['B_PHONE'] = $sorder['phone'];
        $emailData['delivery_charge'] = $sorder['delivery_charge'];
        $emailData['shipping'] = $sorder['shipping'];
        $emailData['order_total'] = $sorder['order_total'];
        $emailData['vat'] = $sorder['vat'];
        $emailData['vat_order_total'] = $sorder['vat_order_total'];
        $emailData['BASE_URL'] = base_url();
        $emailData['C_CODE'] = "";
// e($emailData);
        $items = array();
        $items = $this->order_items($sorder['order_id']);
        $emailData['items'] = $items;
        $emailBody = '';
        $emailBody = $this->load->view('emails/email_to_customer', $emailData, TRUE);
// e($emailBody);
        $this->email->initialize($this->config->item('EMAIL_CONFIG'));
        $this->email->from(DWS_EMAIL_NOREPLY, DWS_EMAIL_FROM);
        $this->email->to($sorder['email']);
        $this->email->subject('Your Order Details');
        $this->email->message($emailBody);
        $status = $this->email->send();

        //Send email to admin
        $emailData = array();
        $emailData = array();
        $emailData['DATE'] = date("jS F, Y");
        $emailData['ORDER_REF'] = $sorder['order_ref'];
        $emailData['ORDER_NUM'] = $sorder['order_num'];
        $emailData['S_FIRSTNAME'] = $sorder['b_first_name'];
        $emailData['S_LASTNAME'] = $sorder['b_last_name'];
        $emailData['S_STREET'] = $sorder['b_address1'];
        $emailData['S_STREET2'] = $sorder['b_address2'];
        $emailData['S_CITY'] = $sorder['b_city'];
        $emailData['S_COUNTY'] = $sorder['b_county'];
        $emailData['S_POSTCODE'] = $sorder['b_postcode'];
        $emailData['S_PHONE'] = $sorder['b_phone'];
        $emailData['EMAIL'] = $sorder['email'];
        $emailData['B_FIRSTNAME'] = $sorder['b_first_name'];
        $emailData['B_LASTNAME'] = $sorder['b_last_name'];
        $emailData['B_STREET'] = $sorder['b_address1'];
        $emailData['B_STREET2'] = $sorder['b_address2'];
        $emailData['B_CITY'] = $sorder['b_city'];
        $emailData['B_COUNTY'] = $sorder['b_county'];
        $emailData['B_POSTCODE'] = $sorder['b_postcode'];
        $emailData['delivery_charge'] = $sorder['delivery_charge'];
        $emailData['shipping'] = $sorder['shipping'];
        $emailData['order_total'] = $sorder['order_total'];
        $emailData['vat'] = $sorder['vat'];
        $emailData['vat_order_total'] = $sorder['vat_order_total'];
        $emailData['BASE_URL'] = base_url();
        $emailData['C_CODE'] = "";
        $emailData['DATE'] = date("jS F, Y");
        $emailData['BASE_URL'] = base_url();
        $emailData['items'] = $items;
// e($emailData);
        $emailBody = '';
        // $emailBody = $this->parser->parse('emails/email_to_admin', $emailData, TRUE);
        $emailBody = $this->load->view('emails/email_to_admin', $emailData, TRUE);
// e($emailBody);
        $this->email->initialize($this->config->item('EMAIL_CONFIG'));
        $this->email->from(DWS_EMAIL_NOREPLY);
        $this->email->to(DWS_EMAIL_ADMIN);
        $this->email->subject('New Order');
        $this->email->message($emailBody);
        $status = $this->email->send();
    }

    function order_items($order_id) {
        $items = array();
        $rs = $this->db->select('t1.*, t2.img as product_image')
            ->from('order_item t1')
            ->join('prod_img t2', 't2.pid = t1.product_id AND t2.main = 1','left')
            ->where('t1.order_id', $order_id)
            ->get();

        if ($rs->num_rows()) {
            $rs = $rs->result_array();
            return $rs;
        }

        return FALSE;
    }

    function testOrder( $order_num = '' ){
        $order_num = '180103-090325-9101';
        $this->load->model('Checkoutmodel');
        $this->load->model('customer/Ordermodel');

        $inner = array();
        $shell = array();
        $orderDet = $this->Ordermodel->detail($order_num);
        if ($orderDet) {
            // Adjust stock quantity
            if (isset($orderDet['order_id'])) {
                $this->manage_stock($orderDet['order_id']);
                // $this->send_emails($orderDet);
            }

            $customer = array();
            $customer = $this->memberauth->checkAuth();
            $inner['customer'] = $customer;
            $this->Checkoutmodel->orderConfirmed( $orderDet );
            e( 1 );
            $sorder = $orderDet;
            $this->load->library('email');
            $this->load->library('parser');
            $data = array();
            $status = false;
            $data['confirmed'] = 1;
            //$data['transaction_no'] = $this->input->post('txn_id');
            $this->db->where('order_id', $sorder['order_id']);
            $this->db->update('order', $data);

    //        $cart = unserialize(base64_decode($sorder['order']['cart']));
            $cart = unserialize(base64_decode($sorder['cart']));

            //Send out email to store owner
            $order_details = array();
            $order_details['order'] = $sorder;
    //        $order_details['order'] = $sorder;
            $order_details['cart_contents'] = $cart;

            $emailData = array();
            $emailData['DATE'] = date("jS F, Y");
            $emailData['S_FIRSTNAME'] = $sorder['s_first_name'];
            $emailData['S_LASTNAME'] = $sorder['s_last_name'];
            $emailData['S_STREET'] = $sorder['s_address1'];
            $emailData['S_STREET2'] = '';
            $emailData['S_CITY'] = $sorder['s_city'];
            $emailData['S_COUNTY'] = $sorder['s_county'];
            $emailData['S_POSTCODE'] = $sorder['s_postcode'];
            $emailData['S_PHONE'] = $sorder['s_phone'];
            $emailData['EMAIL'] = $sorder['email'];
            $emailData['B_FIRSTNAME'] = $sorder['b_first_name'];
            $emailData['B_LASTNAME'] = $sorder['b_last_name'];
            $emailData['B_STREET'] = $sorder['b_address1'];
            $emailData['B_STREET2'] = '';
            $emailData['B_CITY'] = $sorder['b_city'];
            $emailData['B_COUNTY'] = $sorder['b_county'];
            $emailData['B_POSTCODE'] = $sorder['b_postcode'];
            $emailData['delivery_charge'] = $sorder['delivery_charge'];
            $emailData['shipping'] = $sorder['shipping'];
            $emailData['order_total'] = $sorder['order_total'];
            $emailData['vat'] = $sorder['vat'];
            $emailData['vat_order_total'] = $sorder['vat_order_total'];

            $emailData['BASE_URL'] = base_url();
            $emailData['C_CODE'] = $this->session->userdata('CUSTOMER_CODE');
            $emailData['DATA'] = $order_details;
            $emailBody = $this->parser->parse('emails/customer-order-details', $emailData, TRUE);

            $this->email->initialize($this->config->item('EMAIL_CONFIG'));
            $this->email->from(DWS_EMAIL_NOREPLY, DWS_EMAIL_FROM);
            $emailarray = array();
            $emailarray[] = DWS_EMAIL_ADMIN;
            $this->email->to(DWS_EMAIL_ADMIN);
            $this->email->subject('New Order Placed');
            $this->email->message($emailBody);
            //Send out email to customer
            // $emailData = array();
            $emailData['DATE'] = date("jS F, Y");
            $emailData['BASE_URL'] = base_url();
            $emailData['DATA'] = $order_details;
            $emailBody = $this->parser->parse('emails/customer-order-details', $emailData, TRUE);
            e( $emailBody );
        } else {
            $this->utility->show404();
            return;
        }
    }
}

?>
