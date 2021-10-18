<?php

class Ordermodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function allQuotations() {
        $this->db->select('t1.*, t2.first_name, t2.last_name');
        $this->db->from('quotation t1');
        $this->db->join('user t2', 't2.user_id = t1.customer_id');
        $rs = $this->db->get();
        if ($rs->num_rows() > 0) {
            return $rs->result_array();
        }
    }

    function productImages($pid) {
        return $this->db
                        ->where('pid', $pid)
                        ->get('prod_img')
                        ->result_array();
    }

    function userList() {
        $this->db->where('username !=', 'admin');
        $query = $this->db->get('user');
        return $query->result_array();
    }

    function userName($user_id) {
        return $this->db->select('first_name,last_name')
                        ->where('user_id', $user_id)
                        ->get('user')->row_array();
    }

    function setUserSession() {
        $user_id = $this->input->post('user');
        $price_list = $this->input->post('price_list');
        $tier_price = $this->input->post('price_tier');
        $user_name = self::userName($user_id);

        $username = $user_name['first_name'] . ' ' . $user_name['last_name'];
        $this->session->set_userdata('QUICK_ORDER_FOR_ID', $user_id);
        $this->session->set_userdata('QUICK_ORDER_PRICE_LIST', $price_list);
        $this->session->set_userdata('QUICK_ORDER_TIER_PRICE', $tier_price);
        $this->session->set_userdata('QUICK_ORDER_FOR_NAME', $username);
    }

    function getUserProducts($user_id, $pricelist, $tierprice) {
        if ($pricelist == 2) {
            $this->db->select('t1.id as productId,t1.*,t3.*,t4.discount, t4.special_price');
        } else {
            $this->db->select('t1.id as productId,t1.*,t3.*');
        }
        $this->db->from('product t1');
        $this->db->join('prod_img t3', 't1.id = t3.pid AND t3.main = 1', 'left');
        if ($pricelist == 2) {
            $this->db->join('product_assignment t4', "t4.product_id = t1.id AND t4.user_id = $user_id");
        }
//        $qu = "t1.is_active = 1 AND t1.id NOT IN (select pf.child_id from br_product_configurable_link as pf)";
//        $this->db->where($qu);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result_array();
    }

    function productTier($uid, $pid) {
        $userInfo = self::getProfileGroup($uid);
        $profile_id = $userInfo['profile_id'];
        $this->db->where('tier_product_id', $pid);
        $this->db->where('tier_profile_id', $profile_id);
        $query = $this->db->get('tier_price');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    function productTierCal($uid, $pid) {
        $tierP = array();
        $userInfo = self::getProfileGroup($uid);
        $profile_id = $userInfo['profile_id'];
        $this->db->select('tier_qty,tier_price');
        $this->db->where('tier_product_id', $pid);
        $this->db->where('tier_profile_id', $profile_id);
        $this->db->order_by('tier_qty', 'DESC');
        $query = $this->db->get('tier_price');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $item) {
                $tierP[$item['tier_qty']] = $item['tier_price'];
            }
            return $tierP;
        }
    }

    function getProfileGroup($uid) {
        return $this->db
                        ->where('user_id', $uid)
                        ->get('user')->row_array();
    }

    function addQuotation($customer, $subtotal, $order_total, $extraData) {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('string');
        $this->load->library('encrypt');
        $this->load->library('parser');
        $this->load->library('email');

        $cart_variables = $this->Cartmodel->variables();
        extract($cart_variables);
//e($cart_variables);
        $order = array();
//        e($customer);
        $order['customer_id'] = $customer['user_id'];
        $order['quotation_num'] = date("ymd-His-") . rand(1000, 9999);
        $order['cart'] = base64_encode(serialize($this->cart->contents()));
        $order['cart_total'] = $subtotal;
        $order['created_on'] = time();
        $order['confirmed'] = 0;
        $order['vat'] = $vat;
        $order['shipping'] = $extraData['shipping'];
        $order['quotation_total'] = $order_total + $order['shipping'];
        $order['vat_prct'] = defined('DWS_TAX') ? DWS_TAX : 0.00;

        //insert into database
        $this->db->insert('quotation', $order);
        $quotation_id = $this->db->insert_id();


        foreach ($this->cart->contents() as $item) {
            $vat1 = '0.00';
            $qtyTot = ($item['price'] * $item['qty']);
            $subTot = ($qtyTot - ($qtyTot * $item['discount'] / 100));
            if ($item['is_taxable'] == 1) {
                $vat1 = number_format($subTot * (DWS_TAX / 100), 2);
            }
            $order_item = array();
            $order_item['product_id'] = $item['id'];
            $order_item['quotation_id'] = $quotation_id;
            $order_item['quotation_item_name'] = $item['name'];
            $order_item['quotation_item_qty'] = $item['qty'];
            $order_item['quotation_item_price'] = $item['price'];
            $order_item['quotation_item_subtotal'] = $item['subtotal'];
            $order_item['quotation_item_discount'] = $item['discount'];
            $order_item['quotation_item_total'] = $subTot;
            $order_item['quotation_item_attr'] = json_encode($item['attributes']);
            $order_item['vat'] = $vat1;
            if ($vat > 0) {
                $order_item['quotation_item_total'] = $subTot + $vat1;
            } else {
                $order_item['quotation_item_total'] = $subTot;
            }
//e($order_item);
            $status = $this->db->insert('quotation_item', $order_item);

            if (!$status) {
                $this->db->where('id', $quotation_id);
                $this->db->delete('quotation');

                $this->db->where('quotation_id', $quotation_id);
                $this->db->delete('quotation_item');
                return FALSE;
            }
            //else{ echo "Bad Request"; exit; }
        }

        //delete item from cart
        // $this->cart->destroy(); //un comment this line

        $status = false;

        $quotationdetail = $this->fetchById($quotation_id);
        $cart_content = $this->OrderedItem($quotation_id);

        $emailData['DATE'] = date("jS F, Y");
        $emailData['SITE_URL'] = $this->config->item('site_url');
        $emailData['customer'] = $customer;
        $emailData['DATA'] = $quotationdetail;
        $emailData['cart_content'] = $cart_content;


        $emailBody = $this->parser->parse('order/emails/user-information', $emailData, TRUE);
//e($emailBody);
        $this->email->initialize($this->config->item('EMAIL_CONFIG'));
        $this->email->from(DWS_EMAIL_NOREPLY, DWS_EMAIL_FROM);
        $this->email->to($customer['email']);
        $this->email->subject('Quotation from Bigliving');
        $this->email->message($emailBody);
        $status = $this->email->send();

        // $status = TRUE;
        $response = array();
        if ($status) {
            $response['status'] = 'success';
            $response['customer'] = $customer;
            $response['quotationdata'] = $quotationdetail;
            $response['html'] = 'Quotation sent successfully';
        } else {
            $response['status'] = 'error';
            $response['quotationdata'] = '';
            $response['html'] = 'Quotation sent failed';
        }
        return $response;
    }

    function fetchById($quotation_id) {
        $this->db->where('id', $quotation_id);
        $query = $this->db->get('quotation');
        if ($query->num_rows() == 1) {
            return $query->row_array();
        }
    }

    function OrderedItem($quotation_id) {
        $this->db->where('quotation_id', $quotation_id);
        $query = $this->db->get('quotation_item');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    function deleteRecord($qid) {
        $this->db->where('id', $qid);
        $this->db->delete('quotation');

        $this->db->where('quotation_id', $qid);
        $this->db->delete('quotation_item');
    }

    function allorders() {
        $this->db->select('t1.*, t2.first_name, t2.last_name, sagepay_payments.status as sagepay_status, sagepay_payments.TxAuthNo, sagepay_payments.VPSTxId');
        $this->db->from('order t1');
        $this->db->join('user t2', 't2.user_id = t1.customer_id', 'left');
        $this->db->join('sagepay_payments', 'sagepay_payments.VendorTxCode = t1.order_num', 'left');
        $this->db->order_by('order_date', 'DESC');
        $rs = $this->db->get();

        if ($rs->num_rows() > 0) {
            return $rs->result_array();
        }
    }

    function all_orders($filter = 0, $filter1 = 0) {
        $this->db->select('t1.*, t2.first_name, t2.last_name');
        $this->db->from('order t1');
        $this->db->join('user t2', 't2.user_id = t1.customer_id', 'left');
//        $this->db->join('sagepay_payments', 'sagepay_payments.VendorTxCode = t1.order_num', 'left');
        $this->db->order_by('order_id', 'DESC');
        $rs = $this->db->get();

        $out = array();
        $out['filter'] = $filter;
        $out['filter1'] = $filter1;
        $out['orders'] = array();

        if ($rs->num_rows() > 0) {
            $rs = $rs->result_array();
            $arr = $arr1 = array();

            if ($filter == 0) {
                $arr = $rs;
            } else if ($filter == 1) {
                foreach ($rs as $item) {
                    if ($item['is_paid'] == 1 || $item['TxAuthNo'] != 0) {
                        array_push($arr, $item);
                    }
                }
            } else if ($filter == 2) {
                foreach ($rs as $item) {
                    if ($item['is_paid'] == 0 && $item['TxAuthNo'] == 0) {
                        array_push($arr, $item);
                    }
                }
            }
            foreach ($arr as $ite) {
                if ($ite['status'] == $filter1) {
                    array_push($arr1, $ite);
                }
            }
//            ee($filter1);
            if ($filter1 != '0') {
                $out['orders'] = $arr1;
            } else {
                $out['orders'] = $arr;
            }
        }

        return $out;
    }

    function latest_ten_orders() {
        $this->db->select('t1.*, t2.first_name, t2.last_name');
        $this->db->from('order t1');
        $this->db->join('user t2', 't2.user_id = t1.customer_id', 'left');
        $this->db->limit(10);
        $this->db->order_by('order_date', 'DESC');
        $rs = $this->db->get();
        if ($rs->num_rows() > 0) {
            return $rs->result_array();
        }
    }

    function orderById($oid) {
        $this->db->where('order_id', $oid);
        $query = $this->db->get('order');
        if ($query->num_rows() == 1) {
            return $query->row_array();
        }
    }

    function orderItemById($oid) {
        $this->db->where('order_id', $oid);
        $query = $this->db->get('order_item');
        return $query->result_array();
    }

    function orderItemByItemId($id) {
        $this->db->where('order_item_id', $id);
        $query = $this->db->get('order_item');
        return $query->row_array();
    }

    function deleteOrderRecord($oid) {
        $this->db->where('order_id', $oid);
        $this->db->delete('order');

        $this->db->where('order_id', $oid);
        $this->db->delete('order_item');

        $this->db->where('order_id', $oid);
        $this->db->delete('order_detail');
    }

    function orderDetailById($id) {
        $row = $this->db
                        ->from('order_detail')
                        ->where('order_id', $id)
                        ->get()->row_array()
        ;
        return $row;
    }

    function convertQuotationToOrder($quotation, $quotation_items) {
        $order = [
            'customer_id' => $quotation['customer_id'],
            'order_num' => date("ymd-His-") . rand(1000, 9999),
            'cart' => $quotation['cart'],
            'cart_total' => $quotation['quotation_total'],
            'order_total' => $quotation['quotation_total'],
            'vat_prct' => $quotation['vat_prct'],
            'vat' => $quotation['vat'],
            'order_time' => time(),
            'status' => 'NEW',
            'shipping' => $quotation['shipping'],
            'subtotal' => $quotation['cart_total'],
            'order_date' => date('Y-m-d h:i:s')
        ];
        $this->db->insert('order', $order);
        $order_id = $this->db->insert_id();
        foreach ($quotation_items as $quotation_item) {
            $product = $this->db->from('product')->where('id', $quotation_item['product_id'])->get()->row_array();
            $tmp = [
                'product_id' => $quotation_item['product_id'],
                'order_id' => $order_id,
                'product_sku' => $product['sku'],
                'order_item_name' => $product['name'],
                'order_item_desc' => substr(strip_tags($product['description']), 0, 250),
                'order_item_options' => $quotation_item['quotation_item_attr'],
                'order_item_qty' => $quotation_item['quotation_item_qty'],
                'order_item_price' => $quotation_item['quotation_item_price'],
            ];
            $order_items[] = $tmp;
        }
        $this->db->insert_batch('order_item', $order_items);
        $user = $this->Cartmodel->userByID($quotation['customer_id']);
        $address = [
            'order_id' => $order_id,
            'email' => $user['email'],
            'phone' => $user['uadd_phone'],
            'b_title' => '',
            'b_first_name' => '',
            'b_last_name' => '',
            'b_address1' => '',
            'b_address2' => '',
            'b_city' => '',
            's_title' => '',
            's_first_name' => $user['ship_fname'] ? $user['ship_fname'] : $user['first_name'],
            's_last_name' => $user['ship_lname'] ? $user['ship_lname'] : $user['last_name'],
            's_address1' => $user['ship_address1'] ? $user['ship_address1'] : $user['uadd_address_01'],
            's_address2' => $user['ship_address2'] ? $user['ship_address2'] : $user['uadd_address_02'],
            's_city' => $user['ship_city'] ? $user['ship_city'] : $user['uadd_city'],
            's_county' => $user['ship_county'] ? $user['ship_county'] : $user['uadd_county'],
            's_postcode' => $user['ship_postcode'] ? $user['ship_postcode'] : $user['uadd_post_code'],
            's_phone' => $user['ship_phone'] ? $user['ship_phone'] : $user['uadd_phone'],
        ];
        $this->db->insert('order_detail', $address);
        $this->db->where('id', $quotation['id']);
        $this->db->update('quotation', ['confirmed' => 1]);

        // generate pdf
        $order = $this->Ordermodel->orderById($order_id);
        $mailcontent = $this->invoicemodel->generateInvoice($order['order_num']);

        // mail the invoice
        $this->mailConvertedOrder($user, $mailcontent);

        return $order_id;
    }

    function mailConvertedOrder($user, $mailcontent) {
        $filepath = $this->config->item('INVOICE_PATH') . $mailcontent['filename'];
        $this->email->initialize($this->config->item('EMAIL_CONFIG'));
        $this->email->from(DWS_EMAIL_NOREPLY, DWS_EMAIL_FROM);
        $this->email->reply_to(DWS_EMAIL_REPLY_TO);
        $this->email->to($user['email']);
        $this->email->subject("Your quotation is converted to Order");
        $this->email->message($mailcontent['content']);
        if ($mailcontent['filename']) {
            $this->email->attach($filepath);
        }
        $this->email->send();
    }

    function allAbandonOrder() {
        $this->db->select('t1.*, t2.first_name, t2.last_name, t2.email, t2.phone');
        $this->db->from('abandon_order t1');
        $this->db->join('user t2', 't2.user_id = t1.customer_id');
        $this->db->order_by('order_date', 'DESC');
        $rs = $this->db->get();
        if ($rs->num_rows() > 0) {
            return $rs->result_array();
        }
    }

    function abandonOrderById($oid) {
        $this->db->where('order_id', $oid);
        $query = $this->db->get('abandon_order');
        if ($query->num_rows() == 1) {
            return $query->row_array();
        }
    }

    function abandonOrderItemById($oid) {
        $this->db->where('order_id', $oid);
        $query = $this->db->get('abandon_order_item');
        return $query->result_array();
    }

    function abandonUserDetailById($order) {
        $this->db->select('*');
        $this->db->from('user t1');
        $this->db->join('user_address t2', 't2.user_id_fk = t1.user_id', 'LEFT');
        $this->db->where('t1.user_id', $order['customer_id']);
        $query = $this->db->get();
        return $query->row_array();
    }

    function deleteAbandonOrderRecord($oid) {
        $this->db->where('order_id', $oid);
        $this->db->delete('abandon_order');

        $this->db->where('order_id', $oid);
        $this->db->delete('abandon_order_item');
    }

    function emailTemplate() {
        $this->db->select('id,template_name');
        $this->db->where('template_alias', 'abandon-cart');
        $query = $this->db->get('email_templates');
        return $query->row_array();
    }

    function insertCroneRecord() {
        $datetime = $this->input->post('date_time');
        $data['oid'] = $this->input->post('aoid');
        $data['date_time'] = $datetime;
        $data['template_id'] = $this->input->post('template_id');
        $data['added_on'] = time();

        $this->db->insert('crondata', $data);
    }

    function listNotificationData() {
        $this->db->select('t1.*, t2.body_content');
        $this->db->from('crondata  t1');
        $this->db->join('email_templates t2', 't2.id = t1.template_id');
        $this->db->where('t1.email_sent', 0);
        $this->db->where('t1.date_time <= ', date('Y-m-d h:i'));
        $rs = $this->db->get();
//        ee($this->db->last_query());
        if ($rs->num_rows() > 0) {
            return $rs->result_array();
        }
    }

    function allOrderDetail($oid) {
        $this->db->select('t1.*, t2.email');
        $this->db->from('abandon_order t1');
        $this->db->join('user t2', 't2.user_id = t1.customer_id');
        $this->db->where('t1.order_id', $oid);
        $rs = $this->db->get();
        if ($rs->num_rows() == 1) {
            return $rs->row_array();
        }
    }

    function allOrderItems($oid) {
        $this->db->select('*');
        $this->db->from('abandon_order_item');
        $this->db->where('order_id', $oid);
        $rs = $this->db->get();
        if ($rs->num_rows() > 0) {
            return $rs->result_array();
        }
    }

    function updateCronData($oid) {
        $data['email_sent'] = 1;
        $this->db->where('oid', $oid);
        $this->db->update('crondata', $data);
    }

    function listAllStatus($is_active = FALSE) {
        $this->db->select('*');
        $this->db->from('order_status');
        if ($is_active) {
            $this->db->where('is_active', 1);
        }
        $rs = $this->db->get();
        if ($rs->num_rows() > 0) {
            return $rs->result_array();
        }
    }

    function insertStatusRecord() {
        $data = array();
        $data['label'] = $this->input->post('label', true);
        $data['is_active'] = $this->input->post('is_active', true);
        $data['addedon'] = time();
        $this->db->insert('order_status', $data);
    }

    function getstatusdetails($id) {
        $this->db->where('id', intval($id));
        $query = $this->db->get('order_status');
        if ($query->num_rows() == 1) {
            return $query->row_array();
        }
        return false;
    }

    function updateStatusRecord($status) {
        $data = array();
        $data['label'] = $this->input->post('label', true);
        $data['is_active'] = $this->input->post('is_active', true);
        $data['updatedon'] = time();
        $this->db->where('id', $status['id']);
        $this->db->update('order_status', $data);
    }

}

?>
