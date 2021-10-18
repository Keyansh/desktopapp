<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cart extends Cms_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function add($ajax = false)
    {

        $this->load->library('cart');
        $this->load->library('form_validation');
        $this->load->model('Cartmodel');
        $this->load->model('catalog/Productmodel');

        //Get product details
        $product = array();
        $product = $this->Productmodel->getDetails($this->input->post('pid', TRUE));
        if (!$product) {
            $this->utility->show404();
            return;
        }
        $this->Cartmodel->insertRecord($product);
        $this->session->set_userdata('delivery_charge', $this->utility->getDeliveryOptVal(0));
        $this->session->set_userdata('delivery_index', 0);

        if (!$ajax) {
            redirect("cart");
            exit();
        }

        $output = array();
        $output['status'] = 1;
        $output['cart'] = $this->Cartmodel->minicart();
        echo json_encode($output);
        exit();
    }

    function addDiscountedCart($pid = false, $qty = false)
    {
        if (!$pid || !$qty) {
            redirect("cart");
            exit();
        }

        $this->load->library('cart');
        $this->load->library('form_validation');
        $this->load->model('Cartmodel');
        $this->load->model('catalog/Productmodel');

        //Get product details
        $product = array();
        $product = $this->Productmodel->getDetails($pid);

        if (!$product) {
            $this->utility->show404();
            return;
        }


        //        if ($this->input->post('quantity', true)) {
        //            $quantity = intval($this->input->post('quantity', true));
        //        } else {
        //            $quantity = 1;
        //        }


        $this->Cartmodel->insertDiscountedRecord($product, $qty);
        $this->session->set_userdata('delivery_charge', $this->utility->getDeliveryOptVal(0));
        $this->session->set_userdata('delivery_index', 0);
        /*
          if (!$ajax) {
          redirect("cart");
          exit();
          }
         */
        $output = array();
        $output['status'] = 1;
        $output['cart'] = $this->Cartmodel->minicart();
        //        echo json_encode($output);
        //        exit();
    }

    function minicart()
    {
        $this->load->library('cart');
        $this->load->model('Cartmodel');
        echo $this->Cartmodel->minicart();
    }

    function clearbasket()
    {
        $this->load->library('cart');
        $this->load->model('Cartmodel');
        $this->cart->destroy();

        $customer = array();
        $customer = $this->memberauth->checkAuth();
        if ($customer) {
            $this->Cartmodel->addAbandonOrder($customer);
        }

        redirect('cart');

        $inner = array();
        $shell = array();
        $shell['contents'] = $this->load->view('cart-index', $inner, true);
        $this->load->view("themes/" . THEME . "/templates/default", $shell);
    }

    function e($print, $off = 1)
    {
        echo "<pre>";
        print_r($print);
        echo "</pre>";
        if (!$off) {
            die();
        }
    }

    function LoopProductsToDiscount()
    {
        $cartData = $this->cart->contents();
        foreach ($cartData as $item) {
            self::addDiscountedCart($item['id'], $item['qty']);
        }
    }

    //View cart
    function index()
    {
        $this->load->model('Cartmodel');
        $this->load->model('catalog/Categorymodel');
        $this->load->model('catalog/Productmodel');
        $this->load->library('cart');
        $this->load->library('form_validation');

        $variables = $this->Cartmodel->variables();
        extract($variables);

        //        $cartData = $this->cart->contents();
        //        $extraData = $this->cart->extraData($variables['shipping']);

        $inner = $shell = array();
        //        $inner['cart_total'] = $cart_total;
        //        $inner['extra_data'] = $extraData;
        //        $inner['order_total'] = $order_total;
        //        $inner['vat'] = $vat;
        //        $inner['shipping'] = $shipping;
        $inner['variables'] = $this->Cartmodel->variables();
        $inner['extra_data'] = $this->cart->extraData();
        //        $globalBlocks = $this->Pagemodel->getGlobalBlocks(0);
        // $inner['globalBlocks'] = $globalBlocks;
        $inner['not_show_menu'] = 1;
        $shell['meta_title'] = 'Wish list';
        $shell['contents'] = $this->load->view('cart-index', $inner, true);
        $this->load->view("themes/" . THEME . "/templates/product", $shell);
    }

    //Update cart
    function update($target = false)
    {
        $this->load->library('cart');
        $this->load->model('Cartmodel');
        $this->load->model('coupon/couponmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        $keys = $this->input->post('key', true);
        $name = $this->input->post('name', true);
        $quantity = $this->input->post('quantity', true);
        $moq = $this->input->post('moq', true);
        for ($i = 0; $i < count($keys); $i++) {
            if ($moq[$i] > $quantity[$i]) {
                $this->session->set_flashdata('error', $name[$i] . ' minimum quantity not less then ' . $moq[$i]);
                redirect("cart");
                exit;
            }
        }
        $this->Cartmodel->updateRecord();
        $this->session->set_flashdata('SUCCESS', 'cart_updated');
        // $delivery = $this->input->post('delivery');
        // $this->session->set_userdata('delivery_charge', $this->utility->getDeliveryOptVal($delivery));
        // $this->session->set_userdata('delivery_index', $delivery);

        $customer = array();
        $customer = $this->memberauth->checkAuth();
        //        if ($customer) {
        //            $this->Cartmodel->addAbandonOrder($customer);
        //        }
        $this->session->set_flashdata('SUCCESS', 'cart_updated');
        redirect("cart");
        exit();
    }

    //Update cart
    //    function updateCheckoutCart($target = false) {
    //
    //        $array_items = array('delivery_charge' => '', 'delivery_index' => '');
    //        $this->session->unset_userdata($array_items);
    //
    //        $this->load->library('cart');
    //        $this->load->model('Cartmodel');
    //        $this->load->library('form_validation');
    //        $this->load->helper('form');
    //        $this->Cartmodel->updateRecord();
    //
    //
    //        $delivery = $this->input->post('delivery');
    //        $this->session->set_userdata('delivery_charge', $this->utility->getDeliveryOptVal($delivery));
    //        $this->session->set_userdata('delivery_index', $delivery);
    ////                echo "<pre>";
    ////                print_r($this->session->userdata);
    ////                exit;
    //        //
    //        $this->session->set_flashdata('SUCCESS', 'cart_updated');
    //        if ($target == 2) {
    //            $temp_post_fields = array();
    //            $temp_post_fields['title'] = $this->input->post('title');
    //            $temp_post_fields['first_name'] = $this->input->post('first_name');
    //            $temp_post_fields['last_name'] = $this->input->post('last_name');
    //            $temp_post_fields['email'] = $this->input->post('email');
    //            $temp_post_fields['address1'] = $this->input->post('address1');
    //            $temp_post_fields['address2'] = $this->input->post('address2');
    //            $temp_post_fields['city'] = $this->input->post('city');
    //            $temp_post_fields['county'] = $this->input->post('county');
    //            $temp_post_fields['postcode'] = $this->input->post('postcode');
    //            $temp_post_fields['country'] = $this->input->post('country');
    //            $temp_post_fields['phone'] = $this->input->post('phone');
    //            $temp_post_fields['s_title'] = $this->input->post('s_title');
    //            $temp_post_fields['s_first_name'] = $this->input->post('s_first_name');
    //            $temp_post_fields['s_last_name'] = $this->input->post('s_last_name');
    //            $temp_post_fields['s_email'] = $this->input->post('s_email');
    //            $temp_post_fields['s_address1'] = $this->input->post('s_address1');
    //            $temp_post_fields['s_address2'] = $this->input->post('s_address2');
    //            $temp_post_fields['s_city'] = $this->input->post('s_city');
    //            $temp_post_fields['s_county'] = $this->input->post('s_county');
    //            $temp_post_fields['s_postcode'] = $this->input->post('s_postcode');
    //            $temp_post_fields['s_country'] = $this->input->post('s_country');
    //            $temp_post_fields['s_phone'] = $this->input->post('s_phone');
    //            $this->session->unset_userdata('temp_post_fields');
    //            $this->session->set_userdata('temp_post_fields', $temp_post_fields);
    //            redirect("/checkout/index/1");
    //        } else {
    //            redirect("/checkout");
    //        }
    //        exit();
    //    }

    function delete($rowid, $status = false)
    {
        $this->load->library('cart');
        $this->load->library('form_validation');
        $this->load->model('Cartmodel');
        $this->load->model('catalog/Productmodel');

        $itArr = explode('-', $rowid);
        $result = array();
        $product = array();
        $product = $this->Productmodel->fetchByIdCart($itArr[1]);
        $contents = $this->cart->contents();
        $quantity = $contents[$itArr[0]]['qty'];

        $jsonItem['id'] = $product['id'];
        $jsonItem['name'] = $product['name'];
        $jsonItem['list_name'] = "Search Results";
        $jsonItem['brand'] = $product['bname'];
        $jsonItem['category'] = $product['cname'];
        $jsonItem['variant'] = "";
        $jsonItem['list_position'] = $this->cart->total_items();
        $jsonItem['quantity'] = $quantity;
        $jsonItem['price'] = $product['price'];

        $this->Cartmodel->deleteRecord($itArr[0]);

        $customer = array();
        $customer = $this->memberauth->checkAuth();
        if ($customer) {
            $this->Cartmodel->addAbandonOrder($customer);
        }

        $result['jsonItem'] = json_encode($jsonItem);
        echo json_encode($result);
        /*  $this->session->set_flashdata('SUCCESS', 'cart_deleted');
          redirect("cart");
          exit(); */
    }

    function remove($parent_id, $child_id)
    {
        $all_mini_cart_items = $this->session->userdata('CONFIG_PRODUCT_ID');
        if (isset($all_mini_cart_items[$parent_id][$child_id])) {
            unset($all_mini_cart_items[$parent_id][$child_id]);
        }
        $this->session->set_userdata('CONFIG_PRODUCT_ID', $all_mini_cart_items);
        $return['status'] = true;
        echo json_encode($return);
    }

    function minicartview($pid)
    {
        $inner['tempData'] = isset($this->session->userdata["CONFIG_PRODUCT_ID"][$pid]) ? $this->session->userdata["CONFIG_PRODUCT_ID"][$pid] : array();
        $inner['pid'] = $pid;
        $content = $this->load->view('mini-cart', $inner, true);
        echo $content;
    }

    function updateMiniCart()
    {
        $quanties = $this->input->post('quantity');
        $this->load->model('catalog/productmodel');
        $all_mini_cart_items = $this->session->userdata("CONFIG_PRODUCT_ID");
        foreach ($quanties as $pid1 => $values) {
            foreach ($values as $pid2 => $quantity) {
                if (isset($all_mini_cart_items[$pid1][$pid2])) {
                    $item = $all_mini_cart_items[$pid1][$pid2];
                    $user_id = ($this->session->userdata('user_id')) ? $this->session->userdata('user_id') : 0;
                    $profile_id = ($this->session->userdata('profile_id')) ? $this->session->userdata('profile_id') : 0;
                    $response = $this->productmodel->getProductPrice($item['product_id'], $user_id, $profile_id, $quantity);
                    $all_mini_cart_items[$pid1][$pid2]['qty'] = $quantity;
                    $all_mini_cart_items[$pid1][$pid2]['price'] = $response['price'];
                }
            }
        }
        $this->session->set_userdata("CONFIG_PRODUCT_ID", $all_mini_cart_items);
        $return['status'] = true;
        echo json_encode($return);
    }

    function test()
    {
        $this->cart->applyCouponCode();
    }

    function coupon_delete()
    {
        $response = ['status' => true, 'message' => 'Coupon code removed.'];
        $this->session->unset_userdata('discount_coupon');
        $this->session->unset_userdata('discount_amount');
        $this->session->unset_userdata('discount_type');
        $this->cart->_save_cart();

        $data = json_decode($this->updatedCart(), true);
        $response['data'] = $data['data'];
        $response['html'] = $data['html'];
        die(json_encode($response));
    }

    function coupon()
    {
        $today = date('Y-m-d');
        $coupon = $this->input->post('coupon');
        $emailId = $this->input->post('emailId');
        $customer_id = null;
        $customer = $this->db->select('user_id,email')->where('email', $emailId)->from('user')->get()->row_array();
        if ($customer) {
            $customer_id = $customer['user_id'];
        }
        $response = ['status' => false, 'message' => ''];
        $coupon = $this->db->from('coupon')
            ->where('coupon_code', $coupon)
            ->where("'$today' >= active_date", null, false)
            ->where("'$today' <= expire_date", null, false)
            ->get()->row_array();
        if (!$coupon) {
            $response['message'] = 'Coupon code does not exists or expired.';
            die(json_encode($response));
        }
        $uses_term = $coupon['uses_term'];
        $uses_limit = $coupon['uses_limit'];
        if ($uses_term == 'day' && $customer) {
            $this->db->select('count(order_id) as count')
                ->from('order')
                ->where("DATE_FORMAT(order_date,'%Y-%m-%d') = '$today'", null, false)
                ->where('coupon_code', $coupon['coupon_code'])
                ->where('is_paid', 1);
            if ($customer_id) {
                $this->db->where('customer_id', $customer_id);
            }
            $timesCouponUsed = $this->db->get()->row_array();
            $timesCouponUsed = $timesCouponUsed ? $timesCouponUsed['count'] : 0;
            if ($uses_limit <= $timesCouponUsed) {
                $response['message'] = 'You have already used this coupon.';
                die(json_encode($response));
            }
        } elseif ($uses_term == 'week' && $customer) {
            $this->db->select('count(order_id) as count')
                ->from('order')
                ->where("week(order_date) = week(now())", null, false)
                ->where('coupon_code', $coupon['coupon_code'])
                ->where('is_paid', 1);
            if ($customer_id) {
                $this->db->where('customer_id', $customer_id);
            }
            $timesCouponUsed = $this->db->get()->row_array();
            $timesCouponUsed = $timesCouponUsed ? $timesCouponUsed['count'] : 0;
            if ($uses_limit <= $timesCouponUsed) {
                $response['message'] = 'You have already used this coupon.';
                die(json_encode($response));
            }
        } elseif ($uses_term == 'month' && $customer) {
            $this->db->select('count(order_id) as count')
                ->from('order')
                ->where("year(order_date) = year(now())", null, false)
                ->where('coupon_code', $coupon['coupon_code'])
                ->where('is_paid', 1);
            if ($customer_id) {
                $this->db->where('customer_id', $customer_id);
            }
            $timesCouponUsed = $this->db->get()->row_array();
            $timesCouponUsed = $timesCouponUsed ? $timesCouponUsed['count'] : 0;
            if ($uses_limit <= $timesCouponUsed) {
                $response['message'] = 'You have already used this coupon.';
                die(json_encode($response));
            }
        } elseif ($uses_term == 'onetime' && $customer) {
            $this->db->select('count(order_id) as count')
                ->from('order')
                ->where('coupon_code', $coupon['coupon_code'])
                ->where('is_paid', 1);
            if ($customer_id) {
                $this->db->where('customer_id', $customer_id);
            }
            $timesCouponUsed = $this->db->get()->row_array();
            $timesCouponUsed = $timesCouponUsed ? $timesCouponUsed['count'] : 0;
            if ($timesCouponUsed > 0) {
                $response['message'] = 'You have already used this coupon.';
                die(json_encode($response));
            }
        }
        $coupon_type = $coupon['coupon_type'];
        $coupon_type_value = $coupon['coupon_type_value'];
        switch ($coupon_type) {
            case 'percentage':
                $this->session->set_userdata('discount_type', 'percentage');
                break;
            default:
                $response = ['status' => true, 'message' => 'Please enter a valid coupon code.'];
                break;
        }
        $this->session->set_userdata('discount_amount', $coupon_type_value);
        $this->session->set_userdata('discount_coupon', $coupon['coupon_code']);
        $result = $this->cart->applyCouponCode();
        if ($result) {
            $data = json_decode($this->updatedCart(), true);
            $response = ['status' => true, 'message' => 'Coupon Applied.', 'data' => $data['data'], 'html' => $data['html']];
        }
        die(json_encode($response));
    }

    function updatedCart()
    {
        $this->load->model('Cartmodel');
        $extraData = $this->cart->extraData();
        $variables = $this->Cartmodel->variables();
        $data = array(
            'subtotal' => number_format($variables['cart_total'], 2),
            'discount' => isset($extraData['total_discounted_amount']) && $extraData['total_discounted_amount'] > 0 ? $extraData['total_discounted_amount'] : 0.00,
            'tax' => number_format($variables['vat'], 2),
            'shipping_label' => $variables['shipping_label'],
            'shipping_amount' => number_format($variables['shipping'], 2),
            'grand_total' => number_format($variables['order_total'], 2)
        );
        $response = ['status' => true, 'data' => $data];
        $inner = array('cart_contents' => $this->cart->contents());
        $response['html'] = $this->load->view('checkout/review-layout', $inner, true);
        return json_encode($response);
    }
    public function valid_phone()
    {
        $value = $this->input->post('phone');
        $stripped = str_replace(' ', '', $value);
        if (!is_numeric($stripped)) {
            $this->form_validation->set_message('valid_phone', 'Please enter valid phone number');
            return false;
        } else {
            return true;
        }
    }
    function saveEnquiry()
    {
        $this->load->model('Cartmodel');
        $this->load->library('form_validation');
        $this->load->library('email');
        $this->load->library('parser');

        $this->form_validation->set_rules('enquiry_name', 'Name', 'required');
        $this->form_validation->set_rules('enquiry_email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('enquiry_message', 'Message/Query', 'required');
        $this->form_validation->set_rules('phone', 'phone', 'trim|required|callback_valid_phone');
        $secret = DWS_RECAPTCHA_SECRET_KEY;
        $captcha = $this->input->post('g-recaptcha-response');
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
        $response = json_decode($response);
        if (!$response->success) {
            $this->form_validation->set_rules('g-recaptcha-response', 'Captcha', 'trim|required');
        }
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            echo json_encode(['success' => false, 'message' => $errors]);
            exit;
        } else {
            $insert = $this->Cartmodel->save_enquiry();
            if ($insert) {
                $this->Cartmodel->deleteLog();
                $redirect_url = base_url('cart/success');
                echo json_encode(['success' => true, 'redirect_url' => $redirect_url]);
            } else {
                $redirect_url = base_url('cart/failed');
                echo json_encode(['success' => true, 'redirect_url' => $redirect_url]);
            }
        }
    }

    function success()
    {
        $inner = array();
        $shell = array();
        $shell['contents'] = $this->load->view("enquiry-success", $inner, TRUE);
        $this->load->view("themes/" . THEME . "/templates/default", $shell);
    }

    function failed()
    {
        $inner = array();
        $shell = array();
        $shell['contents'] = $this->load->view("enquiry-failed", $inner, TRUE);
        $this->load->view("themes/" . THEME . "/templates/default", $shell);
    }
}
