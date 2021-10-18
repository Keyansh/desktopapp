<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cron extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
    }

    function index() {
        $this->load->model('catalog/Productmodel');
        $this->load->library('email');
        $this->load->library('parser');
        $this->load->helper('form');
        $this->load->helper('text');

        //Fetch Product Having Quantity Less Than Five
        $products = array();
        $products = $this->Productmodel->listProductByQuantity();
        if ($products) {
            $emailData = array();
            $emailData['DATE'] = date("jS F, Y");
            $emailData['PRODUCTS'] = $products;
            $emailBody = $this->parser->parse('emails/product-quantity', $emailData, TRUE);

            $config = array();
            $this->email->initialize($this->config->item('EMAIL_CONFIG'));

            $this->email->from(DWS_EMAIL_NOREPLY, DWS_EMAIL_FROM);
            $this->email->reply_to(DWS_EMAIL_REPLY_TO);
            $this->email->to(DWS_EMAIL_ADMIN);
            $this->email->subject('Notification Regarding Product Quantities');
            $this->email->message($emailBody);
            $this->email->send();
        }
    }

    function abandoncartnotification() {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        $this->load->model('order/Ordermodel');
        $this->load->library('email');
        $this->load->library('parser');
        $this->load->helper('form');
        $this->load->helper('text');

        //Fetch abandoncarts
        $abandoncarts = $orderdetail = $orderitems = $inner = array();
        $abandoncarts = $this->Ordermodel->listNotificationData();
//        ee($abandoncarts);

        if ($abandoncarts) {
            foreach ($abandoncarts as $abandoncart) {
                $orderdetail = $this->Ordermodel->allOrderDetail($abandoncart['oid']);
                $orderitems = $this->Ordermodel->allOrderItems($abandoncart['oid']);

                $inner['orderdetail'] = $orderdetail;
                $inner['orderitems'] = $orderitems;
//ee($inner);
                $emailData = array();
                $emailData['{DATE}'] = date("jS F, Y");
                $emailData['{BASE_URL}'] = base_url();

                $emailData['{CONTENT}'] = $this->load->view('cart-index', $inner, TRUE);
                $emailContent['EMAIL_CONTENT'] = str_replace(array_keys($emailData), array_values($emailData), $abandoncart['body_content']);
                $emailBody = $this->parser->parse('emails/abandon-notification', $emailContent, TRUE);
//                ee($emailBody);

                $config = array();
                $this->email->initialize($this->config->item('EMAIL_CONFIG'));

                $this->email->from(DWS_EMAIL_NOREPLY, DWS_EMAIL_FROM);
                $this->email->reply_to(DWS_EMAIL_REPLY_TO);
                $this->email->to($orderdetail['email']);
                $this->email->subject('Notification Regarding Abandon Cart');
                $this->email->message($emailBody);
                $status = $this->email->send();
//                ee($status);
                if ($status) {
                    $this->Ordermodel->updateCronData($abandoncart['oid']);
                }
            }
        }
    }

}

?>