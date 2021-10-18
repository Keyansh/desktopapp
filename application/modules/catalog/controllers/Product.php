<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Product extends Cms_Controller {

    public function index($alias = false) {
        // e($_POST);
        $this->load->model('Productmodel');
        $this->load->model('Categorymodel');
        $this->load->model('Attributesmodel');
        $this->load->model('cart/Cartmodel');
        $this->load->model('cms/Tiercmsmodel');
        $this->load->model('rating/Ratingmodel');
        $this->load->library('pagination');
        $this->load->helper('text');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('string');

        //Fetch Product Details
        $product = array();
        $ptype = $this->input->post('ptype');

        if ($ptype == "config") {
            $product = $this->Productmodel->fetchByAlias($alias, true);
        } else {
            $product = $this->Productmodel->fetchByAlias($alias);
        }
        if (!$product) {
            $this->utility->show404();
            return;
        }

        //        if (($product['type'] == 'combo') || ($product['type'] == 'config')) {
//            $this->form_validation->set_rules("pids", 'Product ID', 'trim');
//            $this->form_validation->set_rules("quantitys", 'Product Quantity', 'trim');
//        } else {
//            $this->form_validation->set_rules("pid", 'Product Name', 'trim|required');
//            $min = $product['moq'];
//            $this->form_validation->set_rules("quantity", 'Product Quantity', "trim|min_length[$min]|required");
//        }
//
//        $this->form_validation->set_error_delimiters('<li>', '</li>');

        $customer = array();
        $customer = $this->memberauth->checkAuth();

            $pids = array();
            $qty = array();
            $confiProdduct = array();
            $conf_tier_pricing = array();
            $result = array();
            $image = '';
            $rs = '';

            // Configurable Products Add to cart
            $a = $this->input->post('ptype');
            $b = $this->input->post('config_product_id');
            $c = $this->input->post('quantity');
            if ($a == 'config' && !empty($b) && !empty($c)) {
                $pid = $this->input->post('config_product_id');
                $qty = $this->input->post('quantity');

                $products = $this->session->userdata("CONFIG_PRODUCT_ID");

                if ($products) {
                    
                    $tmp_products = $products[$pid];

                    foreach ($tmp_products as $pid2 => $value) {
                        if (isset($value['type'])) {
                            $confiProdduct = array();
                            $images = $this->Productmodel->getImages($pid2);
                            if (empty($images)) {
                                $images = $this->Productmodel->getparentconfig($pid2);
                            }
                            $image = '';
                            foreach ($images as $tmp) {
                                $image = $tmp['img'];
                            }
                            $confiProdduct['img'] = $image;
                            $confiProdduct['product_type'] = 'config';
                            $confiProdduct['type'] = $value['type'];
                            $confiProdduct['parent_sku'] = $value['parent_sku'];
                            $confiProdduct['parent_price'] = $value['parent_price'];
                            $confiProdduct['order_item_options'] = $value['attributes'];
                            $confiProdduct['order_item_qty'] = $value['qty'];
                            $confiProdduct['product_id'] = $value['product_id'];
                            $confiProdduct['product_sku'] = $value['product_sku'];
                            $confiProdduct['order_item_name'] = $value['product_name'];
                            $confiProdduct['order_item_desc'] = $value['product_desc'];
                            $confiProdduct['order_item_price'] = $value['price'];
                            $confiProdduct['actual_price'] = $value['actual_price'];
                            $confiProdduct['discounting_type'] = $value['discounting_type'];
                            $confiProdduct['special_price_type'] = $value['special_price_type'];
                            $confiProdduct['special_price'] = $value['special_price'];
                            $confiProdduct['tier_price'] = $value['tier_price'];
                            $confiProdduct['is_taxable'] = $value['is_taxable'];
                            $rs[] = $this->Cartmodel->insertRecord($confiProdduct, false, 1);
                        }
                    }

                    if ($products[$pid]) {
                        unset($products[$pid]);
                    }
                    $this->session->set_userdata("CONFIG_PRODUCT_ID", $products);
                }

                if (!empty($rs)) {
                    $imgBox = '';
                    $cartCnt = '';
                    //$htmlCont = '<span><h4><strong>Product Added!</strong></h4></span>';
                    $htmlCont = '<ul style="padding:0px;list-style:none;" class="config-notfy">';

                    foreach ($rs as $ds) {
                        if ($ds['img'] != '') {
//                            e($ds);
                            $image = "images/default_product_image.jpg";
                            if (file_exists($this->config->item('PRODUCT_PATH') . $ds['img'])) {
                                $image = $this->config->item('PRODUCT_URL') . $ds['img'];
                            }
                            $imgBox = '<img src="' . $image . '" width="30" height="30">';
                        } else {
                            $image = "images/a1.jpg";
                            $imgBox = '<img src="' . $image . '" width="30" height="30">';
                        }

                        $htmlCont .= '<li style="color:black;"><div style="display: inline-block;"><span data-notify="icon">' . $imgBox . '</span><span data-notify="title">' . $ds['name'] . '</span><span data-notify="message">Product Added!</span></div></li>';
                    }

                    $htmlCont .= '</ul>';

                    $result['notifyHTML'] = $htmlCont;

                    $cartCnt = $this->cart->total_items();

                    $result['cartCnt'] = $cartCnt;

                    echo json_encode($result);
                }
            } else {
                // Add Accessories to Cart
                $accessories = $this->input->post('accessories');

                $this->load->model('cart/Cartmodel');
                $accessories_arr = array();
                $accessories_arr = $this->get_accessories($accessories);

                if ($accessories_arr) {
                    foreach ($accessories_arr as $k => $v) {
                        $tmp = [];
                        $tmp['id'] = $v['product_id'];
                        $tmp['product_sku'] = $v['product_sku'];
                        $tmp['qty'] = $v['quantity'];
                        $tmp['name'] = $v['name'];
                        $tmp['price'] = $v['quantity'] * $v['price'];
                        $tmp['actual_price'] = $tmp['price'];
                        $tmp['is_taxable'] = $v['is_taxable'];
                        $tmp['main_product_id'] = $v['config_product_id'];
                        $cart_id = $this->cart->insert($tmp);
                    }
                }
                // e($this->session->all_userdata());
                $user_id = ($this->session->userdata('CUSTOMER_ID')) ? $this->session->userdata('CUSTOMER_ID') : 0;
                $role_id = ($this->session->userdata('ROLE_ID')) ? $this->session->userdata('ROLE_ID') : 0;
                $quantity = $this->input->post('quantity');

                $response = $this->Productmodel->getProductPrice($product['id'], $user_id, $role_id, $quantity);
            //    e($response);
                if ($ptype == 'config') {
                    $pidC = $this->input->post('pid');
                    $images = $this->Productmodel->getImages($pidC);
                } else {
                    $images = $this->Productmodel->getImages($product['id']);
                }
                $parent_sku = $this->Productmodel->getParentSku($product['id']);
                $image = '';
                foreach ($images as $tmp) {
                    $image = $tmp['img'];
                }
                $tmp = [];
                $tmp['type'] = $product['type'];
                $tmp['moq'] = $product['moq'];
                $tmp['img'] = $image;
                $tmp['parent_sku'] = $parent_sku['sku'];
                $tmp['order_item_options'] = '';
                $tmp['order_item_qty'] = $quantity;
                $tmp['weight'] = $product['weight'];
                $tmp['product_id'] = $product['id'];
                $tmp['product_sku'] = $product['sku'];
                $tmp['is_taxable'] = $product['is_taxable'];
                $tmp['order_item_name'] = $product['name'];
                $description = strip_tags($product['description']);
                $tmp['order_item_desc'] = substr($description, 0, 250);
                $tmp['order_item_price'] = ($response['is_offer_discount']) ? $response['is_offer_discount'] : $response['price'];
                $tmp['actual_price'] = ($response['is_offer_discount']) ? $response['is_offer_discount'] : $response['actual_price'];
                $tmp['discounting_type'] = $response['discounting_type'];
                $tmp['special_price_type'] = $response['special_price_type'];
                $tmp['special_price'] = $response['special_price'];
                $tmp['tier_price'] = ($response['is_offer_discount']) ? $response['is_offer_discount'] : $response['tier_price'];
                // e($tmp);
                $tmp['price'] = $product['price'];
                $tmp['actual_price'] = $product['price'];

                $t = $this->Productmodel->getProductPrice($product['id'], $user_id, $role_id, $quantity);
                if ($t) {
                    $tmp['order_item_price'] = ($t['is_offer_discount']) ? $t['is_offer_discount'] : $t['price'];
                    $tmp['discounting_type'] = $t['discounting_type'];
                    $tmp['special_price_type'] = $t['special_price_type'];
                    $tmp['special_price'] = $t['special_price'];
                    $tmp['tier_price'] = ($t['is_offer_discount']) ? $t['is_offer_discount'] : $t['tier_price'];
                }


                $tier = $this->Tiercmsmodel->tierPrice($product['id'], $quantity);
                if($tier){
                    
                    $tmp['price'] = $tier['tier_price'];
                    $tmp['tier_price'] =$tier['tier_price'];
                    $tmp['order_item_price'] =$tier['tier_price'];
                }
                $postData =  $_POST;
                unset($postData['pid']);
                unset($postData['cid']);
                unset($postData['quantity']);
                $tmp['order_item_options'] = json_encode($postData);
// e($tmp);
                $rs = $this->Cartmodel->insertRecord($tmp);
                $cartCnt = '';

                if (!empty($rs)) {
                    $jsonItem['id'] = $product['id'];
                    $jsonItem['name'] = $product['name'];
                    $jsonItem['list_name'] = "Search Results";            
                    $jsonItem['brand'] = $product['bname'];
                    $jsonItem['category'] = $product['cname'];
                    $jsonItem['variant'] = "";            
                    $jsonItem['list_position'] = $this->cart->total_items();
                    $jsonItem['quantity'] = $quantity;
                    $jsonItem['price'] = $product['price'];
                    $tier = $this->Tiercmsmodel->tierPrice($product['id'], $quantity);
                    if($tier){
                        $jsonItem['price'] = $tier['tier_price'];
                        $jsonItem['tier_price'] =$tier['tier_price'];
                    }
                    $result['cart'] = $rs;
                    $image = "images/a1.jpg";
                    $imgBox = '';
                    // if (isset($rs['img'])) {
                    if ($rs['img']) {
                        if (file_exists($this->config->item('PRODUCT_PATH') . $rs['img'])) {
                            $image = $this->config->item('PRODUCT_URL') . $rs['img'];
                        }
                        // $imgType = "image";
                    // $imgBox = '<img src="' . $image . '" width="30" height="30">';
                    }
                    $imgType = "image";
                    $imgBox = '<img src="' . $image . '" width="30" height="30">';
// e($imgBox);
                    $htmlCont = '<ul style="padding:0px;list-style:none;" class="config-notfy">';
                    $htmlCont .= '<li style="color:black;"><div style="display: inline-block;"><span data-notify="icon">' . $imgBox . '</span><span data-notify="title">' . $rs['name'] . '</span><span data-notify="message"> Product Added!</span></div></li>';
                    $htmlCont .= '</ul>';
                    $result['notifyHTML'] = $htmlCont;

                    $result['cartItem']['options'] = array("icon" => $image, "title" => $rs['name'], "message" => "(Product Added)");
                    $result['cartItem']['settings'] = array("icon_type" => 'image', "type" => "info", "delay" => 3000);
                    $cartCnt = $this->cart->total_items();
                    $result['cartCnt'] = $cartCnt;
                    $result['jsonItem'] = json_encode($jsonItem);
                    $result['cart_total_price'] = '£' . number_format($this->session->userdata['cart_contents']['subtotal'], 2);
                    echo json_encode($result);
                }
            }
    }

    public function getProductShippingFreight($productId = null, $product_weight = null, $shiping_zipcode = null) {
        $freight = 0.00;
        if ($shiping_zipcode && $productId) {
            if (!$product_weight || intval($product_weight) == 0) {
                $product_weight = 0.00;
                $rstSet = $this->db->select('weight')
                        ->from('product')
                        ->where('product_id', $productId)
                        ->get();
                if ($rstSet->num_rows()) {
                    $rstSetArr = $rstSet->row_array();
                    $product_weight = $rstSetArr['weight'];
                }
            }

            $frieghtSet = $this->db->select('freight.*')
                            ->from('shipping_zone_zipcode as zip')
                            ->join('shipping as freight', 'freight.shipping_zone_id=zip.shipping_zone_id', 'LEFT')
                            ->where('zip.zipcode', $shiping_zipcode)
                            ->or_where('freight.weight_from >=', $product_weight)
                            ->where('freight.weight_to <=', $product_weight)->get();
            if ($frieghtSet->num_rows()) {
                $rieghtSetArr = $frieghtSet->row_array();
                $freight = $rieghtSetArr['shipping'];
            }
        }
        return $freight;
    }

    public function addreview() {
        $customer = array();
        $customer = $this->memberauth->checkAuth();

        if (!$customer) {
            echo json_encode(array('url' => '/customer/login/'));
            exit();
        }

        $this->load->helper('text');
        $this->load->model('Ratingmodel');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('summary', 'Summary cannot be blank', 'trim|required');
        $this->form_validation->set_rules('review', 'Review cannot be blank', 'trim|required');
        $this->form_validation->set_rules('palias', 'Product is not present', 'trim|required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == true) {
            $this->Ratingmodel->insertRecord($customer);
        }
        echo json_encode(array('url' => 'catalog/product/index/' . $this->input->post('palias')));
        exit();
    }

    public function get_accessories($arr) {
        $rs = array();
        $rs = $this->db->select('accessories.*, product.sku as product_sku, product.type as type, product.name as name, product.is_taxable as is_taxable')
                ->from('accessories')
                ->join('product', 'product.id = accessories.product_id')
                ->where_in('accessories.id', $arr)
                ->get();

        if ($rs->num_rows()) {
            return $rs->result_array();
        }

        return false;
    }

}
