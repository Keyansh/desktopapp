<?php

class Checkoutmodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function addOrder($customer, $order_total) {

        extract($this->Cartmodel->variables());

        $this->load->helper('string');
        $order = array();
        $order['cus_order_number'] = $this->input->post('cus_order_num');
        $order['customer_id'] = $customer['customer_id'];
        $order['cart'] = base64_encode(serialize($this->cart->contents()));
        $order['order_num'] = date("ymd-His-") . rand(1000, 9999);
        $order['cart_total'] = $cart_total;
        $order['order_time'] = time();
        $order['confirmed'] = 0;
        $order['discount'] = '5.00';
        $order['shipping'] = '5';
        $order['order_total'] = $order_total;

        $order['status_updated_on'] = time();
        $order['status'] = 'New';

        //insert into database
        $this->db->insert('order', $order);
        $order_id = $this->db->insert_id();

        $data = array();
        $data['order_id'] = $order_id;
        $data['b_title'] = $this->input->post('title', TRUE);
        $data['b_first_name'] = $this->input->post('first_name');
        $data['b_last_name'] = $this->input->post('last_name');
        $data['b_address1'] = $this->input->post('address1');
        $data['b_address2'] = $this->input->post('address2');
        $data['b_city'] = $this->input->post('city');
        $data['b_county'] = $this->input->post('county');
        $data['b_postcode'] = $this->input->post('postcode');
        $data['b_phone'] = $this->input->post('phone');
        $data['email'] = $this->input->post('email');

        $data['s_title'] = $this->input->post('s_title');
        $data['s_first_name'] = $this->input->post('s_first_name');
        $data['s_last_name'] = $this->input->post('s_last_name');
        $data['s_address1'] = $this->input->post('s_address1');
        $data['s_address2'] = $this->input->post('s_address2');
        $data['s_city'] = $this->input->post('s_city');
        $data['s_county'] = $this->input->post('s_county');
        $data['s_postcode'] = $this->input->post('s_postcode');
        $data['s_phone'] = $this->input->post('s_phone');

        //print_r($data); exit();
        $this->db->insert('order_detail', $data);
        $order_id = $this->db->insert_id();

        foreach ($this->cart->contents() as $item) {

            $order_item = array();
            $order_item['product_id'] = $item['id'];
            $order_item['order_id'] = $order_id;
            $order_item['order_item_name'] = $item['name'];
            $order_item['order_item_qty'] = $item['qty'];
            $order_item['order_item_price'] = $item['price'];
            $order_item['order_item_options'] = base64_encode(serialize($item['options']));

            $status = $this->db->insert('order_item', $order_item);
            if (!$status) {
                $this->db->where('order_id', $order_id);
                $this->db->delete('order');

                $this->db->where('order_id', $order_id);
                $this->db->delete('order_item');
                return FALSE;
            }
        }

        //delete item from cart
        $this->cart->destroy();


        $response = array();
        $response = $data;
        $response['order_id'] = $order_id;
        $response['order'] = $order;
        return $response;
    }

    function orderConfirmed($sorder) {

        $this->load->library('email');
        $this->load->library('parser');
        if ($sorder['confirmed'] == 1)

        //Confirm the order
        $data = array();
        $data['confirmed'] = 1;
        $this->db->where('order_id', $sorder['order_id']);
        $this->db->update('order', $data);

        $cart = unserialize(base64_decode($sorder['cart']));

        //Send out email to store owner
        $order_details = array();
        $order_details['order'] = $sorder;
        $order_details['cart_contents'] = $cart;

        $emailData = array();
        $emailData['DATE'] = date("jS F, Y");
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
        $emailData['BASE_URL'] = base_url();
        $emailData['DATA'] = $order_details;


        $emailBody = $this->parser->parse('emails/admin-order-email', $emailData, TRUE);

        log_message($this->log_level, 'email body.here');
        log_message($this->log_level, 'email body.' . $emailBody);

        $this->email->initialize($this->config->item('EMAIL_CONFIG'));
        $this->email->from(DWS_EMAIL_NOREPLY, DWS_EMAIL_FROM);
        $this->email->to(DWS_EMAIL_ADMIN);

        //$this->email->bcc('js_thind@hotmail.com');
        $this->email->subject('New Order Placed');
        $this->email->message($emailBody);
        $status = $this->email->send();
        $emailData = array();
        $emailData['email_sent_successfully'] = $status;
        $emailData['title'] = "New Order Placed";
        $emailData['subject'] = "New Order Placed";
        $emailData['email_to'] = DWS_EMAIL_ADMIN;
        $emailData['email_body'] = html_escape($emailBody);
        $emailData['is_admin'] = 1;
        $this->db->insert("email_logs",$emailData);

        //Send out email to customer
        $emailData = array();
        $emailData['DATE'] = date("jS F, Y");
        $emailData['BASE_URL'] = base_url();
        $emailData['DATA'] = $order_details;

        $emailBody = $this->parser->parse('emails/customer-order-details', $emailData, TRUE);

        $this->email->initialize($this->config->item('EMAIL_CONFIG'));
        $this->email->from(DWS_EMAIL_NOREPLY, DWS_EMAIL_FROM);
        $this->email->to($sorder['email']);
        $this->email->subject('Order Placed Successfully');
        $this->email->message($emailBody);
        $status = $this->email->send();
        $emailData = array();
        $emailData['email_sent_successfully'] = $status;
        $emailData['title'] = "PLACED ORDER";
        $emailData['subject'] = "Order Placed Successfully";
        $emailData['email_to'] = $sorder['email'];
        $emailData['email_body'] = html_escape($emailBody);
        $this->db->insert("email_logs",$data);
    }

}

?>
