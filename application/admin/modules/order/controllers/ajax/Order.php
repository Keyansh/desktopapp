<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Order extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('text');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Ordermodel');
        $this->load->model('cart/Cartmodel');
        $this->load->library('cart');
        $this->is_admin_protected = TRUE;
    }

    function userProducts() {
        $this->cart->destroy();
        $response = array();
        $response['status'] = "";
        $response['html'] = "";

        $user_id = $this->input->post('userid');
        $pricelist = $this->input->post('pricelist');
        $tierprice = $this->input->post('tierprice');

        $products = array();
        $products = $this->Ordermodel->getUserProducts($user_id, $pricelist, $tierprice);
//        e($products);

        $response['status'] = 'success';
        if ($products) {
            $response['html'].='<table id="userAsignProList" class="display" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th style="text-align:center;">';
            if ($pricelist == 2) {
                $response['html'].='<input type="checkbox" id="proSelectAll" />';
            }
            $response['html'].='</th><th width="75"></th>                                                                   
                                        <th>Product Name</th>
                                        <th>Product SKU</th>
                                        <th>Product Price</th>                                                                              
                                    </tr>
                                </thead>';
            foreach ($products as $product) {
                if (!empty($product['img'])) {
                    $imageP = $this->config->item('PRODUCT_URL') . $product['img'];
                } else {
                    $imageP = 'images/no-image.jpg';
                }

                if (isset($product['special_price']) && ($product['special_price']) > 0) {
                    $price = $product['special_price'];
                } else if (!empty($product['discount'])) {
                    $discount = ($product['price'] * $product['discount']) / 100;
                    $price = $product['price'] - $discount;
                } else {
                    $price = $product['price'];
                }

                $response['html'] .= '<tr>                                        
                                        <td align="center">
                                        <input type="hidden" name="uid" value="' . $user_id . '" />
                                        <input type="hidden" name="pricelist" value="' . $pricelist . '" />
                                        <input type="hidden" name="tierprice" value="' . $tierprice . '" />
                                        <input type="checkbox" name="ids[]" value="' . $product['productId'] . '" class="productSelect"/></td>   
                                        <td><img src="'.$imageP.'" width="50"/></td>
                                        <td>' . $product['name'] . '</td>
                                        <td>' . $product['sku'] . '</td>
                                        <td>' . DWS_CURRENCY_SYMBOL . number_format($price, 2) . '</td>                                        
                                     </tr>';
            }
            $response['html'] .= '<tfoot>
                                    <tr>
                                        <th></th> 
                                        <th></th> 
                                        <th>Product Name</th>
                                        <th>Product SKU</th>
                                        <th>Product Price</th>                                                                            
                                    </tr>
                                </tfoot>
                            </table>';
        } else {
            $response['html'] = '<h3><small>No product assigned</small></h3>';
        }



        $response['userid'] = $user_id;
        $response['pricelist'] = $pricelist;
        $response['tierprice'] = $tierprice;
        echo json_encode($response);
    }

    function selectedProducts() {
//e($this->cart->contents());
        $response = array();
        $response['status'] = "";
        $response['html'] = "";

        $user_id = $this->input->post('uid');
        $pricelist = $this->input->post('pricelist');
        $tierprice = $this->input->post('tierprice');

        $variables = $this->Cartmodel->variables();

        extract($variables);

        $cartData = $this->cart->contents();

        $response['status'] = 'success';
//        echo '<pre>';
//        print_r($cartData);
//        exit;
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
                        $response['html'] .= $itemAttr['attribute_label'] . ' => ' . $itemAttr['value_label'] . '<br/>';
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

    function checkout() {
        $response = $inner = $customer = array();
        $response['status'] = "";
        $response['html'] = "";

        $user_id = $this->input->post('uid');

        $variables = $this->Cartmodel->variables();

        extract($variables);

        $cartData = $this->cart->contents();
        $customer = $this->Cartmodel->userByID($user_id);
        $extraData = $this->cart->extraData();
        $response['status'] = 'success';
        if ($cartData) {
            $inner['customer'] = $customer;
            $inner['cart_total'] = $subtotal;
            $inner['order_total'] = $order_total;
            $inner['vat'] = $vat;
            $quotation = $this->Ordermodel->addQuotation($customer, $subtotal, $order_total, $extraData);
            $inner['data'] = $quotation['quotationdata'];
            $response['html'] = $this->load->view('inc-checkout', $inner, TRUE);
        } else {
            $response['html'] = '<h3><small>No product</small></h3>';
        }


        echo json_encode($response);
    }

}

?>