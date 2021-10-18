<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cart extends Admin_Controller {

    function __construct() {
        parent::__construct();
    }

    function add($ajax = false) {

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

    //Update cart
    function update($target = false) {

        $this->load->library('cart');
        $this->load->model('Cartmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
//        echo '<pre>';
//        print_r($_POST);
//        exit;
        $this->Cartmodel->updateRecord();

        $user_id = $this->input->post('uid');
        $pricelist = $this->input->post('pricelist');
        $tierprice = $this->input->post('tierprice');
        $discount = $this->input->post('discount');

        $response = array();
        $response['status'] = "";
        $response['html'] = "";

        $variables = $this->Cartmodel->variables();

        extract($variables);

        $cartData = $this->cart->contents();
//        echo '<pre>';
//        print_r($cartData);
//        exit;
        $response['status'] = 'success';

        if ($cartData) {
            $response['html'].='<table id="cartProductList" class="table table-stripped" width="100%" cellspacing="0">
                                <thead><tr>                                        
                                        <th>Product Name</th>
                                        <th>Attributes</th>
                                        <th width="10%">Quantity </th>
                                        <th>Unit Price </th>
                                        <th width="10%">Discount <input type="text" id="globDiscount">% </th>
                                        <th>Subtotal</th>
                                        <th></th>
                                    </tr></thead>';
            $response['html'].='<tbody>';
            foreach ($cartData as $item) {

                if (!empty($item['img'])) {
                    $subcatimg = $this->config->item('PRODUCT_URL') . $item['img'];
                } else {
                    $subcatimg = 'images/no-image.jpg';
                }
                $tierPrices = '';
                if ($tierprice == 1) {
                    $tierPrices = $this->Ordermodel->productTier($user_id, $item['id']);
                }

                $response['html'] .= '<tr>                                        
                                        <td>' . $item['name'];
                if (!empty($tierPrices)) {
                    foreach ($tierPrices as $tierPrice) {
                        $response['html'] .= '<br /><small> > Buy ' . $tierPrice['tier_qty'] . ' and price for 1 will be ' . DWS_CURRENCY_SYMBOL . $tierPrice['tier_price'] . '</small>';
                    }
                }
                $qtyTot = ($item['price'] * $item['qty']);
                $subTot = ($qtyTot - ($qtyTot * $item['discount'] / 100));
                $response['html'] .= '</td><td>';
                if ($item['attributes']) {
                    foreach ($item['attributes'] as $itemAttr) {
                        $response['html'] .= $itemAttr['label'] . ' => ' . $itemAttr['value'] . '<br/>';
                    }
                }
                $response['html'] .= '</td>
                                        <td align="center"><input name="quantity[]" type="number" class="qtn_textfield iqty form-control" id="quantity" value="' . $item['qty'] . '" size="3" min="1"></td>
                                        <td>' . DWS_CURRENCY_SYMBOL . (!empty($this->cart->format_number($item['price'])) ? $this->cart->format_number($item['price']) : 0 ) . '</td>
                                        <td align="center"><input name="discount[]" type="number" class="disc_textfield form-control" value="' . $item['discount'] . '" size="3" min="0"></td>
                                        <td>' . DWS_CURRENCY_SYMBOL . ($this->cart->format_number($subTot)) . '</td>
                                        <td><i class="fa fa-trash delprod" rowId = "' . $item['rowid'] . '" pricelist="' . $pricelist . '" tierprice="' . $tierprice . '" uid ="' . $user_id . '"></i>
                                            <input name="key[]" type="hidden" id="key" value="' . $item['rowid'] . '" size="10">
                                            <input name="product_id[]" type="hidden" id="product_id" value="' . $item['id'] . '" size="10">
                                            <input name="price[]" type="hidden" id="price" value="' . $item['price'] . '" size="10">
                                            <input type="hidden" name="uid" value="' . $user_id . '">
                                            <input type="hidden" name="pricelist" value="' . $pricelist . '">
                                            <input type="hidden" name="tierprice" value="' . $tierprice . '"></td>    
                                     </tr>';
            }
            $response['html'].='</tbody>';
            $response['html'] .= '<tfoot><tr>                                        
                                        <th>Product Name</th>
                                        <th>Attributes</th>
                                        <th width="10%">Quantity </th>
                                        <th>Unit Price </th>
                                        <th width="10%">Discount % </th>
                                        <th>Subtotal</th>
                                        <th></th>
                                    </tr></tfoot>
                            </table>';
        } else {
            $response['html'] = '<h3><small>No product assigned</small></h3>';
        }



        echo json_encode($response);
//	$delivery = $this->input->post('delivery');
//	$this->session->set_userdata('delivery_charge', $this->utility->getDeliveryOptVal($delivery));
//	$this->session->set_userdata('delivery_index', $delivery);
//        $this->session->set_flashdata('SUCCESS', 'cart_updated');
//        redirect("cart");
//        exit();
    }

    function delete($status = false) {
        $ctid = $this->input->post('rowId');
        $this->load->library('cart');
        $this->load->library('form_validation');
        $this->load->model('Cartmodel');
        $this->load->model('order/Ordermodel');

        $this->Cartmodel->deleteRecord($ctid);

        $response = array();
        $response['status'] = "";
        $response['html'] = "";
        $user_id = $this->input->post('uid');
        $pricelist = $this->input->post('pricelist');
        $tierprice = $this->input->post('tierprice');


        $variables = $this->Cartmodel->variables();

        extract($variables);

        $cartData = $this->cart->contents();
//        echo '<pre>';
//        print_r($cartData);
//        exit;

        $response['status'] = 'success';

        if ($cartData) {
            $response['html'].='<table id="cartProductList" class="table table-stripped" width="100%" cellspacing="0">
                                <thead><tr>                                        
                                        <th>Product Name</th>
                                        <th>Attributes</th>
                                        <th width="10%">Quantity </th>
                                        <th>Unit Price </th>
                                        <th width="10%">Discount <input type="text" id="globDiscount">% </th>
                                        <th>Subtotal</th>
                                        <th></th>
                                    </tr></thead>';
            $response['html'].='<tbody>';
            foreach ($cartData as $item) {

                if (!empty($item['img'])) {
                    $subcatimg = $this->config->item('PRODUCT_URL') . $item['img'];
                } else {
                    $subcatimg = 'images/no-image.jpg';
                }
                $tierPrices = '';
                if ($tierprice == 1) {
                    $tierPrices = $this->Ordermodel->productTier($user_id, $item['id']);
                }

                $response['html'] .= '<tr>                                        
                                        <td>' . $item['name'];
                if (!empty($tierPrices)) {
                    foreach ($tierPrices as $tierPrice) {
                        $response['html'] .= '<br /><small> > Buy ' . $tierPrice['tier_qty'] . ' and price for 1 will be ' . DWS_CURRENCY_SYMBOL . $tierPrice['tier_price'] . '</small>';
                    }
                }
                $qtyTot = ($item['price'] * $item['qty']);
                $subTot = ($qtyTot - ($qtyTot * $item['discount'] / 100));

                $response['html'] .= '</td><td>';
                if ($item['attributes']) {
                    foreach ($item['attributes'] as $itemAttr) {
                        $response['html'] .= $itemAttr['label'] . ' => ' . $itemAttr['value'] . '<br/>';
                    }
                }
                $response['html'] .= '</td>
                                        <td align="center"><input name="quantity[]" type="number" class="qtn_textfield iqty form-control" id="quantity" value="' . $item['qty'] . '" size="3" min="1"></td>
                                        <td>' . DWS_CURRENCY_SYMBOL . (!empty($this->cart->format_number($item['price'])) ? $this->cart->format_number($item['price']) : 0 ) . '</td>                                        
                                        <td align="center"><input name="discount[]" type="number" class="disc_textfield form-control" value="' . $item['discount'] . '" size="3" min="0"></td>
                                        <td>' . DWS_CURRENCY_SYMBOL . ($this->cart->format_number($subTot)) . '</td>
                                        <td><i class="fa fa-trash delprod" rowId = "' . $item['rowid'] . '" pricelist="' . $pricelist . '" tierprice="' . $tierprice . '" uid ="' . $user_id . '"></i>
                                            <input name="key[]" type="hidden" id="key" value="' . $item['rowid'] . '" size="10">
                                            <input name="product_id[]" type="hidden" id="product_id" value="' . $item['id'] . '" size="10">
                                            <input name="price[]" type="hidden" id="price" value="' . $item['price'] . '" size="10">
                                            <input type="hidden" name="uid" value="' . $user_id . '">
                                            <input type="hidden" name="pricelist" value="' . $pricelist . '">
                                            <input type="hidden" name="tierprice" value="' . $tierprice . '"></td>    
                                     </tr>';
            }
            $response['html'].='</tbody>';
            $response['html'] .= '<tfoot><tr>                                        
                                        <th>Product Name</th>
                                        <th>Attributes</th>
                                        <th width="10%">Quantity </th>
                                        <th>Unit Price </th>
                                        <th width="10%">Discount % </th>
                                        <th>Subtotal</th>
                                        <th></th>
                                    </tr></tfoot>
                            </table>';
        } else {
            $response['html'] = '<h3><small>No product assigned</small></h3>';
        }



        echo json_encode($response);
    }

}

?>
