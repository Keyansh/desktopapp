<?php

class Cartmodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function insertRecord($product, $cart_id = false, $config = 0) {
        $customer = array();
        $customer = $this->memberauth->checkAuth();

//        e($customer);
        $pack = false;
        $data = array();
        $CI = & get_instance();
        $CI->load->model('catalog/Productmodel');
        $CI->load->model('cms/Tiercmsmodel');

        if ($product['type'] == 'combo') {
            $pids = $this->input->post('pid');
            $qty = $this->input->post('quantity');

            if ($cart_id) {
                //Delete previous cart entry
                $entry = array();
                $entry['rowid'] = $cart_id;
                $entry['qty'] = 0;
                $rs = $this->cart->update($entry);
            }

            $i = 0;
            foreach ($pids as $pid) {
                $produc = $this->Productmodel->getDetails($pid);
             

                if (($produc['special_price']) > 0) {
                    $price = $produc['special_price'];
                } else if (!empty($produc['discount'])) {
                    $discount = ($produc['price'] * $produc['discount']) / 100;
                    $price = $produc['price'] - $discount;
                } else {
                    $price = $produc['price'];
                }

                $data['actual_price'] = $price;

                $tier = $this->Tiercmsmodel->tierPrice($pid, $qty[$i]);
             
                if($tier){
                    $price = $tier['tier_price'];
                    $data['tier_price'] = $price;
                }
              
                $data['id'] = $produc['id'];
                $data['qty'] = $qty[$i];
                $data['weight'] = $product['weight'];
                $data['price'] = $price;
                $data['name'] = $produc['name'];
                $data['img'] = $produc['img'];
                $data['is_taxable'] = $produc['is_taxable'];
                $cart_id = $this->cart->insert($data);
                $i++;
            }
        } else if ($config == 1) {

            //print_r(json_encode($product));

            if ($cart_id) {
                //Delete previous cart entry
                $entry = array();
                $entry['rowid'] = $cart_id;
                $entry['qty'] = 0;
                $rs = $this->cart->update($entry);
            }
            $product['id'] = $product['product_id'];
            $product['qty'] = $product['order_item_qty'];
            $product['weight'] = $product['weight'];
            $product['name'] = $product['order_item_name'];
            $product['price'] = $product['order_item_price'];
            $product['is_taxable'] = $product['is_taxable'];
//            e($product);

            $cart_id = $this->cart->insert($product);
            // e($cart_id);
            if ($customer) {
                self::addAbandonOrder($customer);
            }
            return $cart_id;
        } else {
            if ($cart_id) {
                //Delete previous cart entry
                $entry = array();
                $entry['rowid'] = $cart_id;
                $entry['qty'] = 0;
                $rs = $this->cart->update($entry);
            }
            // e($product);
            $product['id'] = $product['product_id'];
            $product['qty'] = $product['order_item_qty'];
            $product['name'] = $product['order_item_name'];
            $product['price'] = $product['order_item_price'];
            $product['is_taxable'] = $product['is_taxable'];
            $product['weight'] = $product['weight'];
            // e($product);
            $cart_id = $this->cart->insert($product);
            return $cart_id;
        }
    }

    function insertDiscountedRecord($product, $qty, $cart_id = false) {
        $CI = & get_instance();
        $CI->load->model('catalog/Productmodel');
        if ($cart_id) {
            //Delete previous cart entry
            $entry = array();
            $entry['rowid'] = $cart_id;
            $entry['qty'] = 0;
            $rs = $this->cart->update($entry);
        }
        $data = array();

        //$qty = $this->input->post('quantity', true);
        $product_discount = 0;
        $product_discount = $this->productDiscount($product, $qty);
        $option_price = 0;
        $option_pack = '';
        if ($this->input->post('option', true)) {
            $opt = $this->optionPrice($this->input->post('option', true));
            $option_price = $opt['price'];
            $option_pack = " &#40" . $opt['row_value'] . "&#41";
        }
        $product_price = $option_price + $product['product_price'];
        $product_discount = round(($product_price * $product_discount) / 100, 2);
        $product_price = $product_price - $product_discount;
        $options['weight'] = $product['weight'];
        $data['discount'] = $product_discount;
        $data['id'] = $product['product_id'];
        $data['qty'] = $qty;
        $data['weight'] = $options['weight'];
        $tierPrices = $this->getTierPriceByProductId($product['product_id'], $qty);
        if ($tierPrices) {
            $product_price = $tierPrices['price'];
        }
        if ($product['is_pack'] == "1") {
            $data['pack'] = 1;
            $data['pack_qty'] = $product['pack_qty'];
            $product_price = $product_price * $product['pack_qty'];
        }
        $data['price'] = $product_price;
        $data['name'] = $product['product_name'] . $option_pack;
        log_message('debug', 'insertDiscountedRecord Product price' . json_encode($product_price));
        log_message('debug', 'insertDiscountedRecord data ' . json_encode($data));
        $this->cart->insert($data);
    }

    function getTierPriceByProductId($id, $qty) {
        $tblPrefix = $this->db->dbprefix;
        $sql = 'SELECT * FROM ' . $tblPrefix . 'tier_prices where
				(  id = IFNULL((select min(id) from ' . $tblPrefix . 'tier_prices
						where cast(qty as signed) > ' . $qty . '
						AND product_id = ' . $id . ' ),
						(select max(id) from ' . $tblPrefix . 'tier_prices
						where cast(qty as signed) < ' . $qty . ' AND product_id = ' . $id . ' ))
				)';

        $res = $this->db->where('product_id', $id)->where('cast(qty as signed) < ' . $qty)
                        ->order_by('cast(qty as signed)', 'desc')->limit('1', '0')->get('tier_prices');

        if ($res->num_rows() > 0) {
            return $res->row_array();
        } else {
            return false;
        }
    }

    function optionPrice($option_id) {
        $this->db->select('price, row_value');
        $this->db->where('option_row_id', $option_id);
        $rs = $this->db->get('option_rows');
        return $rs->row_array();
    }

    function productDiscount($product, $qty = 1) {
        $CI = & get_instance();
        $CI->load->model('catalog/Productmodel');

        //Product specific discount
        $customer_id = $this->session->userdata('CUSTOMER_ID');
        $this->db->where('customer_id', $customer_id);
        $this->db->where('product_name', $product['product_name']);
        $this->db->where('active', 1);
        $product_rs = $this->db->get('customer_product_discount');


        if ($product_rs && $product_rs->num_rows() == 1) {
            $product_discount = $product_rs->row_array();
            return $product_discount['discount'];
        }

        $product_categories = $CI->Productmodel->getCategories($product['product_id']);
        //print_R($product_categories);
        //Quantity specific discount

        foreach ($product_categories as $category) {

            $this->db->from('customer_quantity_discount');
            $this->db->join('customer_category_discount', 'customer_category_discount.category_discount_id = customer_quantity_discount.category_discount_id');
            $this->db->where('customer_category_discount.category_id', $category['category_id']);
            $this->db->where('customer_category_discount.customer_id', $customer_id);
            $this->db->where('customer_quantity_discount.min_quantity <=', $qty);
            $this->db->where('customer_quantity_discount.max_quantity >=', $qty);
            $result = $this->db->get();

            if ($result && $result->num_rows() >= 1) {

                $quantity_discount = $result->row_array();
                return $quantity_discount['quantity_discount'];
            }
        }
//        echo "<pre>";
//print_r($product_categories);
//echo "</pre>";
        //Category specific discount

        $mainid = $this->getSubcategoryParentById($category['category_id']);

        foreach ($product_categories as $category) {

            $this->db->from('customer_category_discount');
            $this->db->where('category_id', $mainid);
            $this->db->where('active', 1);
            $this->db->where('customer_id', $customer_id);
            $result = $this->db->get();
//if($result->num_rows() > 0)
//{
//    echo $this->db->last_query().'<br>';
//}
            if ($result && $result->num_rows() >= 1) {

                $category_discount = $result->row_array();
                return $category_discount['discount'];
            }
        }


        //Customer specific discount
        $customer = array();
        $customer = $this->memberauth->checkAuth();

        return $customer['discount'];
    }

    function productDicountByID($product_id, $customer_id) {
        
    }

    function getSubcategoryParentById($id = "") {

        $this->db->where('category_id', $id);
        $res = $this->db->get('category');
        $result = $res->row_array();

        if ($result['depth'] > 0) {
            return $this->getSubcategoryParentById($result['parent_id']);
        } else {
            return $result['category_id'];
        }
    }

    //update Cart
    function updateRecord() {

        $CI = & get_instance();
        $CI->load->model('catalog/Productmodel');
        $CI->load->model('cms/Tiercmsmodel');
        //echo "here"; exit();
        $keys = $this->input->post('key', true);
        $quantity = $this->input->post('quantity', true);
        $productId = $this->input->post('product_id', true);
        $price = $this->input->post('price', true);
        $parent_price = $this->input->post('parent_price', true);

        //print_r($productId);

        $customer = array();
        $customer = $this->memberauth->checkAuth();

        $tier_pricing = array();
        $user_id = ($this->session->userdata('user_id')) ? $this->session->userdata('user_id') : 0;
        $profile_id = ($this->session->userdata('profile_id')) ? $this->session->userdata('profile_id') : 0;

        for ($i = 0; $i < count($keys); $i++) {
            $response = $this->Productmodel->getProductPrice($productId[$i], $user_id, $profile_id, $quantity[$i]);
//            e($response);
            $priceapply = ($parent_price[$i] > 0) ? $parent_price[$i] : $response['price'];
            $tier = $this->Tiercmsmodel->tierPrice($productId[$i], $quantity[$i]);
            if($tier){
                $priceapply = $tier['tier_price'];
                $response['tier_price'] =  $tier['tier_price'];
            }
            $data = array(
                'rowid' => $keys[$i],
                'qty' => $quantity[$i],
                'price' => ($response['is_offer_discount']) ? $response['is_offer_discount'] : $priceapply,
                'actual_price' => ($response['is_offer_discount']) ? $response['is_offer_discount'] : $response['actual_price'],
                'discounting_type' => $response['discounting_type'],
                'special_price_type' => $response['special_price_type'],
                'special_price' => $response['special_price'],
                'tier_price' => ($response['is_offer_discount']) ? $response['is_offer_discount'] : $response['tier_price'],
            );
            // e($data);
            $this->cart->update($data);
        }
    }

    //delete record from cart
    function deleteRecord($ctid) {
        $data = array();
        $data['rowid'] = $ctid;
        $data['qty'] = 0;
        $this->cart->update($data);
    }

    function variables($customer = false, $shipping_name = false, $shipping_type = false) {

        $cartItems = $this->cart->contents();
        $total_items = $this->cart->total_items();
        $shipping = 0.00;
        $shipping_vat = 0.00;
        $shippingArr = $this->calculate_shipping();
        $shipping_label= '';
        $shipping_type = $this->session->userdata('shipping_type');

        if(sizeof($shippingArr)){
            if($shippingArr['next_day_delivery'] == 0){
                    $shipping = $shippingArr['2days_postage'] ;
                    $shipping_vat =  number_format(($shippingArr['2days_postage'] * DWS_TAX / 100), 2);
                    $shipping_label = '( 2Days Postage )';
                    $shipping_type = '2days_postage';
            }else{
                if(empty($shipping_type) || $shipping_type == '2days_postage'){
                    $shipping = $shippingArr['2days_postage'] ;
                    $shipping_vat =  number_format(($shippingArr['2days_postage'] * DWS_TAX / 100), 2);
                    $shipping_label = '( 2Days Postage )';
                    $shipping_type = '2days_postage';
                }
                if($shipping_type == 'next_day_delivery'){
                    $shipping = $shippingArr['next_day_delivery'] ;
                    $shipping_vat =  number_format(($shippingArr['next_day_delivery'] * DWS_TAX / 100), 2);
                    $shipping_label = '( Next Day Delivery )';
                    $shipping_type = 'next_day_delivery';
                }
            }
        }

        //Totals
        $cart_total = $this->cart->total() ;

        $discount = 0;

        $vat = '0.00';

        $vat = $this->cart->total_vat() + $shipping_vat;

        $order_total = ($cart_total + $shipping + $vat);
        $variables = array();
        $variables['total_items'] = $total_items;
        $variables['cart_total'] = $cart_total;
        $variables['shipping'] = $shipping;
        $variables['shipping_type'] = $shipping_type;
        $variables['shipping_label'] = $shipping_label;
        $variables['shipping_vat'] = $shipping_vat;
        $variables['shippingArr'] = $shippingArr;
        $variables['vat'] = $vat;
        $variables['discount'] = $discount;
        $variables['order_total'] = $order_total;

        return $variables;
    }

    function minicart() {
        $variables = $this->variables();
        extract($variables);

        $inner = array();
        $inner['total_items'] = $total_items;
        $inner['cart_total'] = $cart_total;
        $inner['order_total'] = $order_total;

        return $this->load->view('cart/cart-mini', $inner, true);
    }

    function calculateShipping($zipcode_id = false, $prev_shipping = false) {
        $product_weight = 0;
        foreach ($this->cart->contents() as $item) {
            //$options = $this->cart->product_options($item['rowid']);
            $internal_weight = $item['qty'] * $item['weight'];
            $product_weight = $product_weight + $internal_weight;
        }

        //fetch the shipping base on product weight
        $rs = $this->db->select('ship.*, extra.shipping as main_charge, extra.weight_to as main_weight')
                ->from('shipping as ship')
                ->join('shipping as extra', 'ship.reference_shipping = extra.shipping_id ', 'LEFT')
                ->where('ship.weight_from <=', $product_weight)
                ->where('ship.shipping_zone_id', $zipcode_id)
                ->order_by('ship.weight_from', 'DESC ')
                ->limit(1)
                ->get();

        if ($rs->num_rows()) {
            $shipping = $rs->row_array();
            if (isset($shipping['main_weight']) && $shipping['main_weight'] && $product_weight > $shipping['main_weight']) {
                $weightCal = ($product_weight - $shipping['main_weight']) * $shipping['shipping'] + $shipping['main_charge'];
                return $weightCal;
            } else {
                return $shipping['shipping'];
            }
        }
        return $prev_shipping;
    }

    function getDetail($id) {
        $this->db->where('id', $id);
        $this->db->select('uri');
        $this->db->from('product');
        $rs = $this->db->get();
        return $rs->row_array();
    }

    function getPrice($id) {
        $this->db->select('price');
        $this->db->where('id', $id);
        $rs = $this->db->get('product');
        return $rs->row_array();
    }

    function getAbandonOrder($customerId, $sessionId) {
        $this->db->where('customer_id', $customerId);
        $this->db->where('session_id', $sessionId);
        $rs = $this->db->get('abandon_order');
        return $rs->row_array();
    }

    function addAbandonOrder($customer) {
//        e($this->session->all_userdata());
        $sessionId = session_id();
        $customerId = $customer['user_id'];
        $exitTempOrder = array();
        $exitTempOrder = self::getAbandonOrder($customerId, $sessionId);
        if ($exitTempOrder) {
            $this->db->where('order_id', $exitTempOrder['order_id']);
            $this->db->delete('abandon_order');

            $this->db->where('order_id', $exitTempOrder['order_id']);
            $this->db->delete('abandon_order_item');

            $temp = $this->cart->contents();
            if (empty($temp)) {
                return;
            }
        }
        $cart_variables = $this->variables();
        extract($cart_variables);

        $this->load->helper('string');
        $order = array();
        $extra_data = $this->variables();
        $order['customer_id'] = $customer['user_id'];
        $order['cart'] = base64_encode(serialize($this->cart->contents()));
        $order['order_num'] = date("ymd-His-") . rand(1000, 9999);
        $order['cart_total'] = $cart_total;
        $order['order_time'] = time();
        $order['confirmed'] = 0;
        $order['order_total'] = $order_total ;
        $order['vat_prct'] = floatval(DWS_TAX);
        $order['status_updated_on'] = time();
        $order['status'] = 'New';
        $order['credit'] = '0';
        $order['confirmed'] = '0';
        $order['subtotal'] = $cart_total;
        $order['shipping'] = ($shipping) ? $shipping : 0;
//        $order['discount'] = ($extra_data['discount']) ? $extra_data['discount'] : 0;
        $order['vat'] = $vat ? $vat: 0;
        $order['session_id'] = $sessionId;
        //insert into database

        $this->db->insert('abandon_order', $order);
        $order_id = $this->db->insert_id();

        if ($order_id) {
            foreach ($this->cart->contents() as $item) {
                $order_item = array();
                $order_item['product_id'] = $item['id'];
                $order_item['product_sku'] = $item['product_sku'];
                $order_item['order_id'] = $order_id;
                $order_item['order_item_name'] = $item['name'];
                $order_item['order_item_qty'] = $item['qty'];
                $order_item['order_item_price'] = $item['order_item_price'];
                $order_item['actual_price'] = $item['actual_price'];
                $order_item['parent_sku'] = $item['parent_sku'];
                $order_item['order_item_options'] = json_encode($item['order_item_options']);
                $order_item['order_item_orientation'] = isset($item['orientations']) ? json_encode($item['orientations']) : json_encode([]);
                $order_item['tier_price'] = ($item['tier_price']) ? $item['tier_price'] : 0.00;
                $order_item['special_price'] = ($item['special_price']) ? $item['special_price'] : 0.00;
                $order_item['discounting_type'] = $item['discounting_type'];
                $order_item['special_price_type'] = $item['special_price_type'];
                $status = $this->db->insert('abandon_order_item', $order_item);

                if (!$status) {
                    $this->db->where('order_id', $order_id);
                    $this->db->delete('abandon_order');

                    $this->db->where('order_id', $order_id);
                    $this->db->delete('abandon_order_item');
                    return FALSE;
                }
                //else{ echo "Bad Request"; exit; }
            }
        }
    }

    function calculate_shipping() {
        $weightTotal = $this->cart->total_weights();
        $rs = array();
        $rs = $this->db->select('*')
//        ->where(intval($weightTotal)." BETWEEN order_min_weight AND order_max_weight")
//        ->or_where('order_max_weight <=', intval($weightTotal))
        ->get('shipping_rules');
        // die($this->db->last_query());
        $shipping = array();
        if ($rs->num_rows()) {
            $rs = $rs->result_array();
            if(sizeof($rs)){
                foreach ($rs as $r){
                    if($r['order_min_weight'] <= $weightTotal && $r['order_max_weight'] >= $weightTotal){
                        $shipping = $r;
                    }
                    if($r['order_min_weight'] <= $weightTotal && $r['order_max_weight'] == '0'){
                        $shipping = $r;
                    }
                }
            }


        }
        return $shipping;
    }
    
    function save_enquiry(){
        $data = array();
        $data['name'] = $this->input->post('enquiry_name',true);
        $data['email'] = $this->input->post('enquiry_email',true);
        $data['enquiry'] = $this->input->post('enquiry_message',true);
        $data['phone'] = $this->input->post('phone',true);
        $data['user_id'] = $this->session->userdata('CUSTOMER_ID');
        $data['enquiry_cart'] = json_encode($this->cart->contents());
        $insert_id = $this->db->insert('checkout_enquiry', $data);
        if($insert_id){
            $emailData = array();
            $emailData['DATE'] = date("jS F, Y");
            $emailData['BASE_URL'] = base_url();
            $emailData['NAME'] = $this->input->post('enquiry_name', true);
            $emailData['EMAIL'] = $this->input->post('enquiry_email', true);
            $emailData['ENQUIRY'] = nl2br($this->input->post('enquiry_message', true));
            $emailData['DATA'] = json_decode($data['enquiry_cart'],true);
            $emailData['ADDRESS'] = DWS_ADDRESS;
            $emailData['ADMIN_PHONE'] = DWS_TELLNO;
            $emailData['IMG_URL'] = $this->config->item('PRODUCT_URL');
            
            $emailUser = $this->parser->parse('cart/emails/customer-enquiry-details', $emailData, true);
            $emailAdmin = $this->parser->parse('cart/emails/admin-enquiry-details', $emailData, true);
            
            //Admin email
            $config = array();
            $this->email->initialize($this->config->item('EMAIL_CONFIG'));
            $this->email->from(DWS_EMAIL_NOREPLY, DWS_EMAIL_FROM);
            $this->email->reply_to(DWS_EMAIL_REPLY_TO);
            $this->email->to(DWS_EMAIL_ADMIN);
            $this->email->subject('Product Enquiry');
            $this->email->message($emailAdmin);
            $status1 = $this->email->send();
            
            //User email
            $config = array();
            $this->email->initialize($this->config->item('EMAIL_CONFIG'));
            $this->email->from(DWS_EMAIL_NOREPLY, DWS_EMAIL_FROM);
            $this->email->reply_to(DWS_EMAIL_NOREPLY);
            $this->email->to($this->input->post('enquiry_email'));
            $this->email->subject('Product Enquiry');
            $this->email->message($emailUser);
            $status2 = $this->email->send();
            
            if ($status1 == true && $status2 == true) {
                $this->cart->destroy();
                return true;
            }else{
                return false;
            }
        }
        return false;
    }
    function deleteLog() {
        $id  = $this->session->userdata('CUSTOMER_ID');
        $date = date('Y-m-d');
        $this->db->where('created_by', $id);
        $this->db->where('comment', $date);
        $this->db->delete('logger');
    }
}

?>
