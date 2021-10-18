<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    </head>
    <body>
        <table style="width: 1200px; margin: auto;">
            <tr>
                <td style="padding: 12px 0 0 0;">

                    <table width='100%' style="margin-bottom: 20px;">
                        <tr>
                            <td>
                                <img src="<?php echo base_url(); ?>images/logo.png" alt="Logo">
                            </td>
                            <td style='text-align: right;'>
                                <span style="font-size: 30px; text-align: right; font-family: 'Roboto', sans-serif; font-weight: 700; margin-bottom: 8px;">ORDER CONFIRMATION</span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table width='100%'>
                        <tr>
                            <td valign='top' style="font-family: 'Roboto', sans-serif; font-weight: 300; font-size: 20px;">
                                Consort hardware,<br>
                                <?= DWS_ADDRESS ?>
                            </td>
                            <td valign='top' align='right' style="font-family: 'Roboto', sans-serif; font-weight: 300; font-size: 20px;">
                                <p style="font-size: 23px; margin-top: 0px; text-transform: uppercase; font-family: 'Roboto', sans-serif; font-weight:500;">Order Details</p><br/>
                                <p style="margin-bottom: 0px;">Dear <?php echo ucwords($order_detail['b_first_name'] . ' ' . $order_detail['b_last_name']); ?>,</p>
                                <p style="margin: 0px;">Order No: <span style="font-family: 'Roboto', sans-serif; font-weight: 500;"><?php echo $order['order_num']; ?></span></p>
                                <p style="margin: 0px;">Dated: <?php echo date('d/m/Y', $order['order_time']); ?></p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table width='100%' style="margin-top: 25px; border: solid 1px #efefef; border-collapse: collapse; margin-bottom: 25px;">
                        <tr>
                            <td colspan='2' style="background: #efefef; padding: 15px 25px 15px 25px; font-size: 30px; font-family: 'Roboto', sans-serif; font-weight: 300;">Address Details</td>
                        </tr>
                        <tr>
                            <td style="padding: 25px 0 25px 25px; font-family: 'Roboto', sans-serif; font-weight: 300; border-right: solid 1px lightgrey; font-size: 20px;">
                                <p style="font-size: 23px; text-transform: uppercase; font-family: 'Roboto', sans-serif; font-weight: 700;">Billing address</p><br/>
                                <p style=" margin-bottom: 0px;">
                                    <span style="font-family: 'Roboto', sans-serif; font-weight: 500;"><?php echo ucwords($order_detail['b_first_name'] . ' ' . $order_detail['b_last_name']); ?></span> <br>
                                    <?php echo ucwords($order_detail['b_address1']); ?><br>
                                    <?php echo ucwords($order_detail['b_city']); ?><br>
                                    <?php echo ucwords($order_detail['b_postcode']); ?><br>
                                    <?php echo ucwords($order_detail['b_county']); ?><br>
                                    <?php echo ucwords($order_detail['b_country']); ?><br>
                                </p>
                                <p style="margin: 0px;"><?php echo $order_detail['b_phone']; ?></p>
                                <p style="margin: 0px;"><?php echo $order_detail['email']; ?></p>
                            </td>
                            <td style="padding: 25px 0 25px 25px; font-family: 'Roboto', sans-serif; font-weight: 300; font-size: 20px;">
                                <?php
                                if ($order_detail['s_first_name']) {
                                    ?>
                                    <p style="font-size: 23px; text-transform: uppercase; font-family: 'Roboto', sans-serif; font-weight: 700;">Shipping address</p><br/>
                                    <span style="font-family: 'Roboto', sans-serif; font-weight: 500;"><?php echo ucwords($order_detail['s_first_name'] . ' ' . $order_detail['s_last_name']); ?></span> <br>
                                    <?php echo ucwords($order_detail['s_address1']); ?><br>
                                    <?php echo ucwords($order_detail['s_city']); ?><br>
                                    <?php echo ucwords($order_detail['s_postcode']); ?><br>
                                    <?php echo ucwords($order_detail['s_county']); ?><br>
                                    <?php echo ucwords($order_detail['s_country']); ?><br>
                                    </p>
                                    <p style="margin: 0px;"><?php echo $order_detail['s_phone']; ?></p>
                                    <p style="margin: 0px;"><?php echo $order_detail['s_country']; ?></p>
                                    <?php
                                } else {
                                    ?>
                                    <p style="font-size: 23px; text-transform: uppercase; font-family: 'Roboto', sans-serif; font-weight: 700;">Shipping address</p><br/>
                                    <p style=" margin-bottom: 0px;">
                                        <span style="font-family: 'Roboto', sans-serif; font-weight: 500;"><?php echo ucwords($order_detail['b_first_name'] . ' ' . $order_detail['b_last_name']); ?></span> <br>
                                        <?php echo ucwords($order_detail['b_address1']); ?><br>
                                        <?php echo ucwords($order_detail['b_city']); ?><br>
                                        <?php echo ucwords($order_detail['b_postcode']); ?><br>
                                        <?php echo ucwords($order_detail['b_county']); ?><br>
                                        <?php echo ucwords($order_detail['b_country']); ?><br>
                                    </p>
                                    <p style="margin: 0px;"><?php echo $order_detail['b_phone']; ?></p>
                                    <p style="margin: 0px;"><?php echo $order_detail['email']; ?></p>
                                    <?php
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 9px 0 25px 25px; font-family: 'Roboto', sans-serif; font-weight: 300; border-right: solid 1px lightgrey; font-size: 18px;" valign="top">
                                <p style="font-size: 23px; text-transform: uppercase; font-family: 'Roboto', sans-serif; font-weight: 700;">SHIPPING METHOD:</p>
                                <p><span style="font-family: 'Roboto', sans-serif; font-weight: 400;">Shipping -</span> Shipping</p>
                            </td>
                            <td style="padding: 9px 0 25px 25px; font-family: 'Roboto', sans-serif; font-weight: 300; font-size: 18px;" valign="top">
                                <p style="font-size: 23px; text-transform: uppercase; font-family: 'Roboto', sans-serif; font-weight: 700;">PAYMENT METHOD:</p>
                                <p><span style="font-family: 'Roboto', sans-serif; font-weight: 400;">Payment -</span> <?php echo $order['payment_method']; ?></p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="padding-top : 25px; text-align: center; font-size: 30px; text-transform: uppercase; font-family: 'Roboto', sans-serif; font-weight: 700;">
                    Order Details
                </td>
            </tr>
            
            <tr>
                <td style="padding-top : 45px; font-size: 20px; text-transform: uppercase; font-family: 'Roboto', sans-serif; font-weight: 400;">
                    <br/>
                    <strong style="font-weight: bold;">Delivery Option:</strong> <?= $order['order_option_type'] ?>, &nbsp;&nbsp;&nbsp;&nbsp;
                    <strong style="font-weight: bold;">Delivery Day:</strong> <?= $order['order_option_day'] ?>
                </td>
            </tr>
            
            <tr>
                <td>
                    <table width='100%' style="border-collapse: collapse; margin: 5px 0 0px 0;">
                        <tr>
                            <th style="font-family: 'Roboto', sans-serif; text-align: left; background: #efefef; border: solid 1px lightgrey; font-size: 20px; padding: 12px 12px 12px 12px;">S.No</th>
                            <th style="font-family: 'Roboto', sans-serif; background: #efefef; border: solid 1px lightgrey; font-size: 20px; padding: 12px 12px 12px 12px;"> SKU</th>
                            <th style="font-family: 'Roboto', sans-serif; background: #efefef; border: solid 1px lightgrey; font-size: 20px; padding: 12px 12px 12px 12px;">Product</th>
                            <th style="font-family: 'Roboto', sans-serif; background: #efefef; border: solid 1px lightgrey; font-size: 20px; padding: 12px 12px 12px 12px;"> Item</th>
                            <th style="font-family: 'Roboto', sans-serif; background: #efefef; border: solid 1px lightgrey; font-size: 20px; padding: 12px 12px 12px 12px;">Qty.</th>
                            <th style="font-family: 'Roboto', sans-serif; background: #efefef; border: solid 1px lightgrey; font-size: 20px; padding: 12px 12px 12px 12px;">Pack</th>
                            <th style="font-family: 'Roboto', sans-serif; background: #efefef; border: solid 1px lightgrey; font-size: 20px; padding: 12px 12px 12px 12px;"> Unit cost</th>
                            <th style="font-family: 'Roboto', sans-serif; background: #efefef; border: solid 1px lightgrey; font-size: 20px; padding: 12px 12px 12px 12px;">Total Price</th>
                        </tr>

                        <?php
                        if ($order_items) {
                            $image_url = '';
                            $sn = 1;
                            foreach ($order_items as $item) {
                                $get_prod_img = get_prod_img($item['product_id']);
                                if ($get_prod_img) {
                                    $image_url = $this->config->item('PRODUCT_URL') . $get_prod_img['img'];
                                } else {
                                    $image_url = base_url() . "images/default_product_image.jpg";
                                }
                                ?>
                                <tr>
                                    <td style="font-family: 'Roboto', sans-serif; font-weight: 300; text-align: center; border: solid 1px lightgrey; font-size: 20px; padding: 12px 12px 12px 12px;"><?php echo $sn++; ?></td>
                                    <td style="font-family: 'Roboto', sans-serif; font-weight: 300; text-align: center; border: solid 1px lightgrey; font-size: 20px; padding: 12px 12px 12px 12px;"><?php echo $item['product_sku']; ?> </td>
                                    <td style="font-family: 'Roboto', sans-serif; font-weight: 300; text-align: center; border: solid 1px lightgrey; font-size: 20px; padding: 12px 12px 12px 12px;">
                                        <img src="<?php echo $image_url; ?>" style="width:100px;max-height:100px; padding: 7px 0px;">
                                    </td>
                                    <td style="font-family: 'Roboto', sans-serif; font-weight: 300; border: solid 1px lightgrey; font-size: 20px; padding: 12px 12px 12px 12px;"><?php echo $item['order_item_name']; ?></td>
                                    <td style="font-family: 'Roboto', sans-serif; font-weight: 300; text-align: center; border: solid 1px lightgrey; font-size: 20px; padding: 12px 12px 12px 12px;"><?php echo $item['order_item_qty']; ?></td>
                                    <td style="font-family: 'Roboto', sans-serif; font-weight: 300; border: solid 1px lightgrey; font-size: 20px; padding: 12px 12px 12px 12px;"><?php echo $item['pack']; ?></td>
                                    <td style="font-family: 'Roboto', sans-serif; font-weight: 300; text-align: center; border: solid 1px lightgrey; font-size: 20px; padding: 12px 12px 12px 12px;">£<?php echo number_format($item['order_item_price'], 2); ?></td>
                                    <td style="font-family: 'Roboto', sans-serif; font-weight: 300; text-align: center; border: solid 1px lightgrey; font-size: 20px; padding: 12px 12px 12px 12px;">£<?php echo number_format(($item['order_item_price'] * $item['order_item_qty']), 2); ?></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                        <tr>
                            <td style="text-align: right; padding-bottom: 32px; padding-top: 32px; padding-right: 25px;" colspan="8" align='right'>
                                <div style="float: right; padding: 20px 50px 0 0;">
                                    <?php
//                                    $vat = $order['subtotal'] * 20 / 120;
                                    $vat = $order['vat'];
                                    ?>
                                    <table style="">
                                        <tr>
                                            <th style="text-transform: uppercase; font-size: 20px; padding-right: 15px; font-family: 'Roboto', sans-serif; font-weight: 700; text-align: right; padding-bottom: 8px;">Subtotal:</th>
                                            <td style="font-size: 20px; font-family: 'Roboto', sans-serif; font-weight: 300; text-align: right; padding-bottom: 8px;">£<?php echo number_format($order['subtotal'], 2); ?></td>
                                        </tr>
                                        <tr>
                                            <th style="text-transform: uppercase; font-size: 20px; padding-right: 15px; font-family: 'Roboto', sans-serif; font-weight: 700; text-align: right; padding-bottom: 8px;">VAT (20%):</th>
                                            <td style="font-size: 20px; font-family: 'Roboto', sans-serif; font-weight: 300; text-align: right; padding-bottom: 8px;">£<?php echo number_format($vat, 2); ?></td>
                                        </tr>
                                        <tr>
                                            <th style="text-transform: uppercase; font-size: 20px; padding-right: 15px; font-family: 'Roboto', sans-serif; font-weight: 700; text-align: right; padding-bottom: 8px;">Subtotal Without VAT:</th>
                                            <td style="font-size: 20px; font-family: 'Roboto', sans-serif; font-weight: 300; text-align: right; padding-bottom: 8px;">£<?php echo number_format(($order['subtotal'] - $vat), 2); ?></td>
                                        </tr>
                                        <?php
                                        $grand_total = $order['order_total'];
//                                        if ($order['discount'] > 0) {
//                                            $subtotal_after_discount = $order['subtotal'] - $order['discount'];
//                                            $grand_total = ($order['order_total'] - $order['discount']);
//                                            
                                        ?>
<!--                                            <tr>
                                                <th style="text-transform: uppercase; font-size: 20px; padding-right: 15px; font-family: 'Roboto', sans-serif; font-weight: 700; text-align: right; padding-bottom: 8px;">Discount: </th>
                                                <td style="font-size: 20px; font-family: 'Roboto', sans-serif; font-weight: 700; text-align: right;">£//<?php echo number_format($order['discount'], 2); ?></td>
                                            </tr>
                                            <tr>
                                                <th style="text-transform: uppercase; font-size: 20px; padding-right: 15px; font-family: 'Roboto', sans-serif; font-weight: 700; text-align: right; padding-bottom: 8px;">Subtotal After Discount: </th>
                                                <td style="font-size: 20px; font-family: 'Roboto', sans-serif; font-weight: 700; text-align: right;">£//<?php echo number_format($subtotal_after_discount, 2); ?></td>
                                            </tr>-->
                                        //<?Php
//                                        } else {
//                                          
//                                        }
                                        ?>
                                        <tr>
<th style="text-transform: uppercase; font-size: 20px; padding-right: 15px; font-family: 'Roboto', sans-serif; font-weight: 700; text-align: right; padding-bottom: 8px;"><?php echo $order['order_option_type'] . ' Charges' ?>: </th>
<td style="font-size: 20px; font-family: 'Roboto', sans-serif; font-weight: 700; text-align: right;">£<?php echo number_format($order['delivery_collection_charges'], 2); ?></td>
</tr>
                                        <tr>
<th style="text-transform: uppercase; font-size: 20px; padding-right: 15px; font-family: 'Roboto', sans-serif; font-weight: 700; text-align: right; padding-bottom: 8px;">Shipping <?= $order['shipping_label']?>: </th>
<td style="font-size: 20px; font-family: 'Roboto', sans-serif; font-weight: 700; text-align: right;">£<?php echo number_format($order['shipping'], 2); ?></td>
</tr>
                                        <tr>
                                            <th style="text-transform: uppercase; font-size: 20px; padding-right: 15px; text-transform: uppercase; color: #e86f1e; font-family: 'Roboto', sans-serif; font-weight: 700; text-align: right;">Grand Total: </th>
                                            <td style="font-size: 20px; font-family: 'Roboto', sans-serif; font-weight: 700; text-align: right;">£<?php echo number_format(($grand_total), 2); ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <?php
        if (isset($page_counter)) {
            ?>
        <pagebreak></pagebreak>
        <?php
    }
    ?>
</body>
</html>
