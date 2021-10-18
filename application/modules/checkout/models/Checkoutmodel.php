<?php

class Checkoutmodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function checkCustomerOrder($cid) {
        $this->db->where('customer_id', $cid);
        $this->db->limit(1);
        return $this->db->get('order')->row_array();
    }

    function addOrder($customer, $order_total, $strip = 0) {



        $customer_status = customer($customer);
        $variables = $this->Cartmodel->variables();
        extract($variables);

        $this->load->helper('string');
        $order = array();
        $order['customer_id'] = $customer['user_id'];
        $order['cart'] = base64_encode(serialize($this->cart->contents()));
        $order['order_num'] = date("ymd-His-") . rand(1000, 9999);
        $order['cart_total'] = $variables['cart_total'];
        $order['order_time'] = time();
        $order['confirmed'] = 0;
        $order['order_total'] = $variables['order_total'];
        $order['vat_prct'] = floatval(DWS_TAX);
        $order['status_updated_on'] = time();
//        code
        if (isset($customer_status['cash_credit'])) {
            if ($customer_status['cash_credit'] == 'credit') {
                $order['status'] = 'Approval_pending';
            } else {
                $order['status'] = 'New';
            }
        } else {
            $order['status'] = 'New';
        }


//        code

        $order['credit'] = '0';
        $order['confirmed'] = '0';
        $order['subtotal'] = $variables['cart_total'];
        $order['shipping'] = $variables['shipping'];
        $order['shipping_vat'] = $variables['shipping_vat'];
        $order['shipping_label'] = $variables['shipping_label'];
        $order['shipping_type'] = $variables['shipping_type'];
        $order['discount'] = '0';
        $order['vat'] = ($variables['vat'])?$variables['vat']:0;

        $ua = $this->getBrowser();
        $browser = $ua['name'] . " " . $ua['version'];

        $order['screen_size'] = $this->input->post('screen_size');
        $order['browser'] = $browser;
        $order['ip'] = $_SERVER['REMOTE_ADDR'];

        $device = '';
        $device = $this->get_device();
        $order['device'] = $device;



        $order['delivery_charge'] = '0.00';
        $order['payment_method'] = $this->input->post('payment_method');
        if($strip != 0){
            $order['transaction_no'] = $strip['balance_transaction'];
            $order['is_paid'] = $strip['paid'];
            $order['confirmed'] = 1;
            $order['payment_response'] = json_encode($strip);
        }
        $extraData = $this->cart->extraData();
        $order['coupon_code'] = $this->session->userdata('discount_coupon');
        $order['discount'] = $extraData['total_discounted_amount'];
        
        $this->db->insert('order', $order);
        $order_id = $this->db->insert_id();

        $data = array();
        $data['order_id'] = $order_id;

        $data['b_first_name'] = $this->input->post('fname');
        $data['b_last_name'] = $this->input->post('lname');
        $data['b_address1'] = $this->input->post('address');
        $data['b_city'] = $this->input->post('city');
        $data['b_county'] = $this->input->post('county');
        $data['b_postcode'] = $this->input->post('postcode');
        $data['b_phone'] = $this->input->post('phone');
        $data['email'] = $this->input->post('email');
        $data['b_country'] = $this->input->post('country');

        $data['s_first_name'] = $this->input->post('shipping_fname');
        $data['s_last_name'] = $this->input->post('shipping_lname');
        $data['s_address1'] = $this->input->post('shipping_address');
        $data['s_city'] = $this->input->post('shipping_city');
        $data['s_county'] = $this->input->post('shipping_county');
        $data['s_postcode'] = $this->input->post('shipping_postcode');
        $data['s_phone'] = $this->input->post('shipping_phone');
        $data['s_country'] = $this->input->post('shipping_country');

        $this->db->insert('order_detail', $data);
        $order_detail_id = $this->db->insert_id();

        $this->saveImagesAndOrientations($order_id);

        foreach ($this->cart->contents() as $item) {
            if(is_array($item)){
        //            code
                $item_pack = product_pack($item['product_id']);
        //            code
                $order_item = array();
                $order_item['product_id'] = $item['id'];
                $order_item['product_sku'] = $item['product_sku'];
                $order_item['order_id'] = $order_id;
                $order_item['order_item_name'] = $item['name'];
                $order_item['order_item_qty'] = $item['qty'];
                $order_item['order_item_price'] = $item['price'];
                $order_item['actual_price'] = $item['actual_price'];
                $order_item['parent_sku'] = $item['parent_sku'];
                $order_item['order_item_options'] = json_encode($item['order_item_options']);
                $order_item['order_item_orientation'] = isset($item['orientations']) ? json_encode($item['orientations']) : json_encode([]);
                $order_item['tier_price'] = ($item['tier_price']) ? $item['tier_price'] : 0.00;
                $order_item['special_price'] = ($item['special_price']) ? $item['special_price'] : 0.00;
                $order_item['discounting_type'] = $item['discounting_type'];
                $order_item['special_price_type'] = $item['special_price_type'];
                if ($item_pack) {
                    $order_item['pack'] = $item_pack['quantity_per_pack'];
                }
                $status = $this->db->insert('order_item', $order_item);

                if (!$status) {
                    $this->db->where('order_id', $order_id);
                    $this->db->delete('order');

                    $this->db->where('order_id', $order_id);
                    $this->db->delete('order_item');
                    return FALSE;
                }
            }
        }

        //delete item from cart
        $this->cart->destroy();
        $this->session->unset_userdata('delivery_charge');
        $this->session->unset_userdata('discount_type', 'percentage');
        $this->session->unset_userdata('discount_amount', $coupon_type_value);
        $this->session->unset_userdata('discount_coupon', $coupon['coupon_code']);


        $response = array();
        $response = $data;
        $response['order_id'] = $order_id;
        $response['order'] = $order;
        return $response;
    }

    function saveImagesAndOrientations($order_id) {
        $contents = $this->cart->contents();
        foreach ($contents as $order) {
            $path = $this->config->item('ORDER_PATH') . $order_id;
            $product_images = $this->config->item('ORDER_PATH') . $order_id . '/product_images';
            $logo_images = $this->config->item('ORDER_PATH') . $order_id . '/logo_images';
            if (!file_exists($path)) {
                @mkdir($path);
                @mkdir($product_images);
                @mkdir($logo_images);
            }
            if (isset($order['orientations']) && $order['orientations']) {
                $orientations = $order['orientations'];
                foreach ($orientations as $product_image => $orientation) {
                    $product = $this->config->item('PRODUCT_PATH') . $product_image;
                    $product_images = $this->config->item('ORDER_PATH') . $order_id . '/product_images//' . $product_image;
                    $logo_images = $this->config->item('ORDER_PATH') . $order_id . '/logo_images//';
                    if (file_exists($product) && !file_exists($product_images)) {
                        copy($product, $product_images);
                    }
                    foreach ($orientation as $orientation) {
                        $img = $orientation['img'];
                        $img = explode('/', $img);
                        $img = end($img);
                        $img = $logo_images . $img;
                        if (!file_exists($img)) {
                            copy($orientation['img'], $img);
                        }
                    }
                }
            }
        }
    }

    function getcountryname($iso) {
        return $this->db->where("iso", $iso)->get("br_country")->row_array();
    }

    function OrderedItem($Oid) {
        $this->db->where('order_id', $Oid);
        return $this->db->get('order_item')->result_array();
    }

    function orderConfirmed($sorder) {

        $this->load->library('email');
        $this->load->library('parser');
        $this->load->model('customer/Ordermodel');

        $sorder = $this->Ordermodel->detail($sorder['order_num']);
        // e($sorder);
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
        $s_country = $b_country = '';
        $b_country = $this->getcountryname($sorder['b_country']);
        if ($sorder['s_first_name']) {
            $s_country = $this->getcountryname($sorder['s_country']);
            $s_country = $s_country['nicename'];
        }
//        e(lQ());
//        e($sorder);
        $emailData = array();
        $emailData['discount'] = $sorder['discount'];
        $emailData['DATE'] = date("jS F, Y");
        $emailData['BASE_URL_LOGO'] = base_url() . 'images/logo.png';
        $emailData['S_FIRSTNAME'] = $sorder['s_first_name'];
        $emailData['S_LASTNAME'] = $sorder['s_last_name'];
        $emailData['S_STREET'] = $sorder['s_address1'];
        $emailData['B_PHONE'] = $sorder['b_phone'];
        $emailData['S_STREET2'] = '';
        $emailData['S_CITY'] = $sorder['s_city'];
        $emailData['S_COUNTY'] = $sorder['s_county'];
        $emailData['S_COUNTRY'] = $s_country;
        $emailData['S_POSTCODE'] = $sorder['s_postcode'];
        $emailData['S_PHONE'] = $sorder['s_phone'];
        $emailData['EMAIL'] = $sorder['email'];
        $emailData['B_FIRSTNAME'] = $sorder['b_first_name'];
        $emailData['B_LASTNAME'] = $sorder['b_last_name'];
        $emailData['B_STREET'] = $sorder['b_address1'];
        $emailData['B_STREET2'] = '';
        $emailData['B_CITY'] = $sorder['b_city'];
        $emailData['B_COUNTY'] = $sorder['b_county'];
        $emailData['B_COUNTRY'] = $b_country['nicename'];
        $emailData['S_PHONE'] = $sorder['s_phone'];
        $emailData['B_POSTCODE'] = $sorder['b_postcode'];
        $emailData['delivery_charge'] = $sorder['delivery_charge'];
        $emailData['shipping'] = $sorder['shipping'];
        $emailData['shipping_label'] = $sorder['shipping_label'];
        if ($sorder['coupon_code'] && $sorder['discounted_amount'] != '') {
            $emailData['order_total'] = $sorder['order_total'] - $sorder['discounted_amount'];
        } else {
            $emailData['order_total'] = $sorder['order_total'];
        }
        $emailData['vat'] = $sorder['vat'];
        $emailData['vat_order_total'] = $sorder['vat_order_total'];
        $emailData['BASE_URL'] = base_url();
        $emailData['C_CODE'] = $this->session->userdata('CUSTOMER_CODE');
        $emailData['DATA'] = $order_details;
        $emailData['ADDRESS'] = DWS_ADDRESS;
        $emailData['PHONE'] = DWS_TELLNO;
//        e($order_details);
        $emailBody = $this->parser->parse('checkout/emails/customer-order-details', $emailData, TRUE);
//        e($emailBody, 0);
        $this->email->initialize($this->config->item('EMAIL_CONFIG'));
        $this->email->from(DWS_EMAIL_NOREPLY, DWS_EMAIL_FROM);
        $emailarray = array();
        $emailarray[] = DWS_EMAIL_ADMIN;
        $this->email->to(DWS_EMAIL_ADMIN);
        $this->email->subject('New Order Placed');
        $this->email->message($emailBody);
        $this->email->send();
        //Send out email to customer
        // $emailData = array();
        $emailData['DATE'] = date("jS F, Y");
        $emailData['BASE_URL'] = base_url();
        $emailData['DATA'] = $order_details;
        $emailBody = $this->parser->parse('checkout/emails/email_to_customer', $emailData, TRUE);
//        e($emailBody);
        $this->email->initialize($this->config->item('EMAIL_CONFIG'));
        $this->email->from(DWS_EMAIL_NOREPLY);
        $this->email->to($sorder['email']);
        $this->email->subject('Order Placed Successfully');
        $this->email->message($emailBody);
        $status = $this->email->send();
        $emailData = array();
        $emailData['user_id'] = 0;
        $emailData['email_sent_successfully'] = $status;
        $emailData['title'] = "Customer Order";
        $emailData['subject'] = "Order Placed Successfully";
        $emailData['email_to'] = $sorder['email'];
        $emailData['email_body'] = html_escape($emailBody);
        $this->db->insert("email_logs", $emailData);
    }

    function vat($price_without_vat) {

        $vat = DWS_VAT; // define what % vat is

        $price = $vat * ($price_without_vat / 100); // work out the amount of vat

        $price_with_vat = round($price, 2); // round to 2 decimal places

        return $price_with_vat;
    }

    function ListAllCountry() {
        $rs = $this->db->get('country');
        return $rs->result_array();
    }

    function quotation($qnum) {
        $this->db->select('t1.*,t2.first_name, t2.last_name');
        $this->db->from('quotation t1');
        $this->db->join('user t2', 't2.user_id = t1.customer_id');
        $this->db->where('t1.quotation_num', $qnum);
        $rs = $this->db->get();
        if ($rs->num_rows() == 1) {
            return $rs->row_array();
        }
    }

    function quotationConfirm($quotation) {
        $this->load->library('email');
        $this->load->library('parser');

        $data = array();
        $data['confirmed'] = 1;
        $this->db->where('quotation_num', $quotation['quotation_num']);
        $this->db->update('quotation', $data);

        $emailData = array();
        $emailData['DATE'] = date("jS F, Y");
        $emailData['BASE_URL'] = base_url();
        $emailData['quotation'] = $quotation;
        $emailBody = $this->parser->parse('emails/admin-quotation-confirm', $emailData, TRUE);
//e($emailBody);
        $this->email->initialize($this->config->item('EMAIL_CONFIG'));
        $this->email->from(DWS_EMAIL_NOREPLY);
        $this->email->to(DWS_EMAIL_ADMIN);
        $this->email->subject('Quotation confirmed successfully');
        $this->email->message($emailBody);
        $status = $this->email->send();
    }

    function getBrowser() {
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version = "";

        //First get the platform?
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        } elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }

        // Next get the name of the useragent yes seperately and for good reason
        if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        } elseif (preg_match('/Firefox/i', $u_agent)) {
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
        } elseif (preg_match('/Chrome/i', $u_agent)) {
            $bname = 'Google Chrome';
            $ub = "Chrome";
        } elseif (preg_match('/Safari/i', $u_agent)) {
            $bname = 'Apple Safari';
            $ub = "Safari";
        } elseif (preg_match('/Opera/i', $u_agent)) {
            $bname = 'Opera';
            $ub = "Opera";
        } elseif (preg_match('/Netscape/i', $u_agent)) {
            $bname = 'Netscape';
            $ub = "Netscape";
        }

        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .
                ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // we have no matching number just continue
        }

        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
                $version = $matches['version'][0];
            } else {
                $version = $matches['version'][1];
            }
        } else {
            $version = $matches['version'][0];
        }

        // check if we have a number
        if ($version == null || $version == "") {
            $version = "?";
        }

        return array(
            'userAgent' => $u_agent,
            'name' => $bname,
            'version' => $version,
            'platform' => $platform,
            'pattern' => $pattern
        );
    }

    function get_device() {
        include 'Mobile_Detect.php';
        $detect = new Mobile_Detect;
        $deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
        return $deviceType;
    }

}

?>
