<?php

class Cartmodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function insertRecord($uid, $pricelist, $tierprice, $cart_id = false) {
//       e($product);
        $pack = false;
        $data = array();
        $this->load->model('catalog/Productmodel');
        $this->load->library('cart');


        $pids = $this->input->post('ids');
//e($pids);
        if ($cart_id) {
            //Delete previous cart entry
            $entry = array();
            $entry['rowid'] = $cart_id;
            $entry['qty'] = 0;
            $rs = $this->cart->update($entry);
        }

        $i = 0;
        foreach ($pids as $pid) {
            $produc = $this->Productmodel->getDetails($pid, $uid, $pricelist, $tierprice);
//e($produc);
            if (isset($produc['special_price']) && ($produc['special_price']) > 0) {
                $price = $produc['special_price'];
            } else if (!empty($produc['discount'])) {
                $discount = ($produc['price'] * $produc['discount']) / 100;
                $price = $produc['price'] - $discount;
            } else {
                $price = $produc['price'];
            }

            $data['id'] = $produc['id'];
            $data['qty'] = 1;

            $data['price'] = $price;
            $data['discount'] = 0;
            $data['name'] = $produc['name'];
            $data['img'] = $produc['img'];
            $data['is_taxable'] = $produc['is_taxable'];
            $data['attributes'] = $this->Productmodel->getAttrDetail($produc['id']);
            $cart_id = $this->cart->insert($data);
            $i++;
        }
        return $cart_id;
    }

    //update Cart
    function updateRecord() {
        $CI = & get_instance();
        $CI->load->model('catalog/Productmodel');
        $CI->load->model('order/Ordermodel');

        $keys = $this->input->post('key', true);
        $quantity = $this->input->post('quantity', true);
        $productId = $this->input->post('product_id', true);
        $price = $this->input->post('price', true);
        $discount = $this->input->post('discount', true);
        $uid = $this->input->post('uid', true);
        $pricelist = $this->input->post('pricelist', true);
        $tierprice = $this->input->post('tierprice', true);

//        echo '<pre>';
//        print_r($_POST);
//        exit;
        for ($i = 0; $i < count($keys); $i++) {
//            $product = $CI->Productmodel->getDetails($productId[$i]);
            $product = $this->Productmodel->getDetails($productId[$i], $uid, $pricelist, $tierprice);
            if (isset($product['special_price']) && ($product['special_price']) > 0) {
                $price[$i] = $product['special_price'];
            } else if (!empty($product['discount'])) {
                $discountp = ($product['price'] * $product['discount']) / 100;
                $price[$i] = $product['price'] - $discountp;
            } else {
                $price[$i] = $product['price'];
            }

            $tierPrices = '';
            if ($tierprice == 1) {
                $tierPrices = $this->Ordermodel->productTierCal($uid, $productId[$i]);
                if (!empty($tierPrices)) {
                    foreach ($tierPrices as $key => $tierPrice) {
                        if ($quantity[$i] >= $key) {
                            $price[$i] = $tierPrice;
                            break;
                        }
                    }
                }
            }


            $data = array(
                'rowid' => $keys[$i],
                'qty' => $quantity[$i],
                'discount' => $discount[$i],
                'price' => $price[$i],
            );
//e($data);
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
        $this->load->library('cart');
        $total_items = $this->cart->total_items();
        $subtotal = $this->cart->subtotal();
        $vatIs = '0.00';
        $cartItems = $this->cart->contents();
        foreach ($cartItems as $cartItem) {
            if ($cartItem['is_taxable'] == 1) {
                $vatIs+=number_format($cartItem['subtotal'] * (DWS_TAX / 100), 2);
            }
        }
        //Totals
        $cart_total = $this->cart->total();
        $order_total = $cart_total;

        //customer discount
//        $discount = 0;
        //Tax
        $tax = 0;

        //$tax = round(($order_total * (DWS_TAX / 100)), 2);
        $order_total = $order_total + $vatIs;

        // fetch shipping  zone on zipcode basis 
        $shipping = 0.00;

        if (empty($shipping)) {
            $shipping = 0.00;
        }

        //$shipping = $this->Cartmodel->calculateShipping($customer);        
        $variables = array();
//        $variables['tax'] = $tax;
//        $variables['delivery_charge'] = $this->session->userdata('delivery_charge');
        $variables['total_items'] = $total_items;
        $variables['cart_total'] = $cart_total;
        $variables['subtotal'] = $subtotal;
//        $variables['shipping'] = $shipping ? $shipping : 0.00;
//        $order_total = ($order_total + $shipping + floatval($variables['delivery_charge']));
        $variables['order_total'] = $order_total;
        $variables['vat'] = $vatIs;
//        $variables['vat'] = $order_total * DWS_VAT / 100;
//        $variables['vat_order_total'] = $order_total + ($order_total * (DWS_VAT / 100));
//        echo "<pre>"; print_r($variables); exit;

        return $variables;
//        echo json_encode($variables);
//        exit;
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

    function userByID($cid) {
        $this->db->select('*');
        $this->db->join('user_address', 'user_address.user_id_fk = user.user_id', 'LEFT');
        $this->db->where('user_id', $cid);
        $rs = $this->db->get('user');
        if ($rs->num_rows() == 1) {
            return $rs->row_array();
        }
        return false;
    }

}

?>
