<style>
    .table-heading {
        font-size: 20px;
        font-family: Roboto-Medium;
        color: #333;
        margin: 0 0 5px 0;
        text-align: left !important;
    }
</style>

<div class="row">
    <div class="col-md-9">
        <h2 style="font-family:arial;">Order No. &nbsp;<?php echo $order['order_num']; ?></h2>
        <br>
        <?php
        $x = explode(' ', $order['order_date']);
        $date_part = $x[0];
        $time_part = $x[1];
        $date_part = date("d/m/Y", strtotime($date_part));
        ?>

        <p style="font-size:16px;"><?php echo $date_part . '&nbsp&nbsp&nbsp&nbsp' . $time_part; ?></p>
    </div>
    <div class="col-md-3">
        <div id="ctxmenu" class="pull-right">
            <a href="order/allorders" class="btn btn-primary"><i class="fa fa-bars" aria-hidden="true"></i> Manage Orders</a>
        </div>
    </div>
</div>
<hr />

<div class="col-lg-6 shipping-address">
    <p class='table-heading'>Billing Details</p>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th align="left">First Name</th>
                <td align="left"><?php echo ucwords($order_detail['b_first_name']); ?></td>
            </tr>
            <tr>
                <th align="left">Last Name</th>
                <td align="left"><?php echo ucwords($order_detail['b_last_name']); ?></td>
            </tr>
            <tr>
                <th align="left">Email</th>
                <td align="left"><?php echo $order_detail['email']; ?></td>
            </tr>
            <tr>
                <th align="left">Phone</th>
                <td align="left"><?php echo ucwords($order_detail['b_phone']); ?></td>
            </tr>
            <tr>
                <th align="left">Address</th>
                <td align="left"><?php echo ucwords($order_detail['b_address1']); ?></td>
            </tr>
            <tr>
                <th align="left">City</th>
                <td align="left"><?php echo ucwords($order_detail['b_city']); ?></td>
            </tr>
            <tr>
                <th align="left">State</th>
                <td align="left"><?php echo ucwords($order_detail['b_county']); ?></td>
            </tr>
            <tr>
                <th align="left">Postcode</th>
                <td align="left"><?php echo ucwords($order_detail['b_postcode']); ?></td>
            </tr>
            <tr>
                <th align="left">Country</th>
                <td align="left"><?php echo ucwords($order_detail['b_country']); ?></td>
            </tr>
        </thead>
    </table>
</div>

<div class="col-lg-6 shipping-address">
    <p class='table-heading'>Shipping Details</p>
    <?php
    if (!$order_detail['s_first_name']) {
        ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th align="left">First Name</th>
                    <td align="left"><?php echo ucwords($order_detail['b_first_name']); ?></td>
                </tr>
                <tr>
                    <th align="left">Last Name</th>
                    <td align="left"><?php echo ucwords($order_detail['b_last_name']); ?></td>
                </tr>
                <tr>
                    <th align="left">Email</th>
                    <td align="left"><?php echo $order_detail['email']; ?></td>
                </tr>
                <tr>
                    <th align="left">Phone</th>
                    <td align="left"><?php echo ucwords($order_detail['b_phone']); ?></td>
                </tr>
                <tr>
                    <th align="left">Address</th>
                    <td align="left"><?php echo ucwords($order_detail['b_address1']); ?></td>
                </tr>
                <tr>
                    <th align="left">City</th>
                    <td align="left"><?php echo ucwords($order_detail['b_city']); ?></td>
                </tr>
                <tr>
                    <th align="left">State</th>
                    <td align="left"><?php echo ucwords($order_detail['b_county']); ?></td>
                </tr>
                <tr>
                    <th align="left">Postcode</th>
                    <td align="left"><?php echo ucwords($order_detail['b_postcode']); ?></td>
                </tr>
                <tr>
                    <th align="left">Country</th>
                    <td align="left"><?php echo ucwords($order_detail['b_country']); ?></td>
                </tr>
            </thead>
        </table>
        <?php
    } else {
        ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th align="left">First Name</th>
                    <td align="left"><?php echo ucwords($order_detail['s_first_name']) ?></td>
                </tr>
                <tr>
                    <th align="left">Last Name</th>
                    <td align="left"><?php echo ucwords($order_detail['s_last_name']) ?></td>
                </tr>
                <tr>
                    <th align="left">Email</th>
                    <td align="left"><?php echo $order_detail['email']; ?></td>
                </tr>
                <tr>
                    <th align="left">Phone</th>
                    <td align="left"><?php echo ucwords($order_detail['s_phone']); ?></td>
                </tr>
                <tr>
                    <th align="left">Address</th>
                    <td align="left"><?php echo ucwords($order_detail['s_address1']) ?></td>
                </tr>
                <tr>
                    <th align="left">City</th>
                    <td align="left"><?php echo ucwords($order_detail['s_city']) ?></td>
                </tr>
                <tr>
                    <th align="left">State</th>
                    <td align="left"><?php echo ucwords($order_detail['s_county']) ?></td>
                </tr>
                <tr>
                    <th align="left">Postcode</th>
                    <td align="left"><?php echo ucwords($order_detail['s_postcode']) ?></td>
                </tr>
                <tr>
                    <th align="left">Country</th>
                    <td align="left"><?php echo ucwords($order_detail['s_country']) ?></td>
                </tr>
            </thead>
        </table>
        <?php
    }
    ?>
</div>

<hr />
<div class="col-lg-12 shipping-address">
    <p class='table-heading'>Device Detail</p>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th align="left">IP Address</th>
                <td align="left"><?php echo $order['ip']; ?></td>
            </tr>
            <tr>
                <th align="left">Agent</th>
                <td align="left"><?php echo $order['browser']; ?></td>
            </tr>
            <tr>
                <th align="left">Plateform</th>
                <td align="left"><?php echo $order['device']; ?></td>
            </tr>            
        </thead>
    </table>
</div>
<div class="clearfix"></div>
<br>
<div class="col-xs-12">
    <p class='table-heading'>Order Details</p>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th align="left">SN</th>
                <th align="left">Image</th>
                <th align="left">SKU</th>
                <th align="left">Name</th>
                <th align="left">Quantity </th>
                <th align="left">Unit Price </th>
<!--                <th align="left">Pack Pieces</th>-->
                <th align="left">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php $sn = 1; ?>
            <?php
            $image_url = '';
            foreach ($order_items as $content) {
                if (isset($content['images'][0])) {
                    $image_url = $this->config->item('PRODUCT_URL') . $content['images'][0];
                } else {
                    $image_url = "../images/resized/product_details/300_300/default_product_image.jpg";
                }
                ?>
                <tr>
                    <td><?= $sn++; ?></td>
                    <td>
                        <img src="<?php echo $image_url; ?>" alt="" style="width:100px;max-height:100px; padding: 7px 0px;">
                    </td>
                    <td><?= $content['product_sku']; ?></td>
                    <td><?= $content['order_item_name']; ?></td>
                    <td><?= $content['order_item_qty']; ?></td>
                    <td><?= DWS_CURRENCY_SYMBOL . ' ' . number_format($content['order_item_price'], 2); ?></td>
<!--                    <td>--><?//= $content['pack'] ?><!--</td>-->
                    <td><?= DWS_CURRENCY_SYMBOL . ' ' . number_format(($content['order_item_qty'] * $content['order_item_price']), 2); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<br>
<div class="col-xs-6">
    <p class='table-heading' style="text-align:center;">Order Status</p>
    <table class="table table-bordered">
        <tbody>
            <tr>
                <td width="200px">Set order status</td>
                <td>
                    <select name="order_status_update" id="order_status_update" class="form-control">
                        <option value="">Select Status</option>
                        <?php
                        if (!empty($order_status)) {
                            foreach ($order_status as $ostatus) {
                                $labrl_array = explode('_', $ostatus['label']);
                                $label_string = implode(" ", $labrl_array);
                                ?>
                                <option value="<?= $ostatus['label'] ?>" <?= ($ostatus['label'] == $order['status']) ? 'selected="selected"' : '' ?>><?= $label_string ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                    <input type="hidden" id="order_id" value="<?php echo $order['order_id']; ?>" />
                    <p id="statusMsg" style="color: green;"></p>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="col-xs-6">

    <div class="col-xs-12 col-lg-12 shipping-address" style="padding: 0px;">
        <p class='table-heading'>Delivery Options</p>
        <table class="table table-bordered">
            <tr>
                <th width="120">Option</th>
                <td><?= $order['order_option_type'] ?></td>
            </tr>
            <tr>
                <th><?= $order['order_option_type'] ?> Day</th>
                <td><?= $order['order_option_day'] ?></td>
            </tr>
        </table>
    </div>

    <?php
    $vat = $order['vat'];
    //  $vat = $order['subtotal'] * 20 / 120;
    $subtotal_without_vat = $order['subtotal'] - $vat;
    ?>
    <p class='table-heading' style="text-align:center;">Order Summary</p>
    <table class="table table-bordered">
        <tbody>
            <tr>
                <td colspan="3" align="right">Subtotal</td>
                <td align="left" style="text-align:right;"><?= DWS_CURRENCY_SYMBOL . number_format($order['subtotal'], 2) ?></th>
            </tr>
            <?php if($order['discount'] > 0): ?>
            <tr>
                <td colspan="3" align="right">Discount</td>
                <td align="left" style="text-align:right;"><?= DWS_CURRENCY_SYMBOL . number_format($order['discount'], 2) ?></th>
            </tr>
            <?php endif; ?>
            <tr>
                <td colspan="3" align="right">VAT</td>
                <td align="left" style="text-align:right;"><?= DWS_CURRENCY_SYMBOL . number_format($vat, 2) ?></th>
            </tr>
            <tr>
                <td colspan="3" align="right">Subtotal Without VAT</td>
                <td align="left" style="text-align:right;"><?= DWS_CURRENCY_SYMBOL . number_format($subtotal_without_vat, 2) ?></th>
            </tr>
            
            <tr>
                <td colspan="3">
                    <?php 
                        echo $order['order_option_type'] . ' charges';
                    ?>
                </td>
                <td>
                    <?= DWS_CURRENCY_SYMBOL . number_format($order['delivery_collection_charges'], 2); ?>
                </td>
            </tr>
            
            
            <?php
            $grand_total = $order['order_total'];
//            if ($order['discount'] > 0) {
            // $subtotal_after_discount = ($order['subtotal'] - ($order['subtotal'] * 20 / 120)) - $order['discount'];
            // $subtotal_after_discount += $subtotal_after_discount * 20 / 120;
//                $subtotal_after_discount = ($order['subtotal'] - $order['discount']);
//                $grand_total = ($order['order_total'] - $order['discount']);
            ?>
        <!--                <tr>
                            <td colspan="3" align="right">Discount</th>
                            <td align="left" style="text-align:right;"><?//= DWS_CURRENCY_SYMBOL . number_format($order['discount'], 2) ?></th>
                        </tr>
                        <tr>
                            <td colspan="3" align="right">Subtotal After Discount</td>
                            <td align="left" style="text-align:right;"><?//= DWS_CURRENCY_SYMBOL . number_format($subtotal_after_discount, 2) ?></th>
                        </tr>-->
            <?php
//            } else {
//                $grand_total = $order['order_total'];
//            }
            ?>
            <tr>
<td colspan="3" align="right">Shipping <?= $order['shipping_label']?></td>
<td align="left" style="text-align:right;"><?= DWS_CURRENCY_SYMBOL . number_format($order['shipping'], 2) ?></th>
</tr>
            <tr>
                <td colspan="3" align="right">Grand Total</td>
                <td align="left" style="text-align:right;"><?= DWS_CURRENCY_SYMBOL . number_format(($grand_total), 2) ?></th>
                <!--<td align="left" style="text-align:right;"><?= DWS_CURRENCY_SYMBOL . number_format(($grand_total - $order['shipping']), 2) ?></th>-->
            </tr>
        </tbody>
    </table>
</div>

<div class="container">
    <?php
    if (isset($orientations)) {
        $upload_path = $this->config->item('ORDER_URL');
        foreach ($order_items as $order_item):
            $images_rendered = [];
            $orientations = json_decode($order_item['order_item_orientation'], true);
            if ($orientations) {
                foreach ($orientations as $product_img => $orientations):
                    $images_rendered[] = $product_img;
                    ?>
                    <div class="col-md-4">
                        <img class="center-block img-responsive" src="<?= site_url('order/image/' . $order_item['order_item_id'] . '/' . $product_img) ?>">
                        <a href="<?= $upload_path . $order_item['order_id'] . '/product_images//' . $product_img ?>" download>Download Product Image</a>
                    </div>

                    <?php foreach ($orientations as $key => $orientation): ?>
                        <div class="col-md-2">
                            <?php
                            $tmp = explode('/', $orientation['img']);
                            $tmp = end($tmp);
                            ?>
                            <img class="center-block img-responsive" src="<?= $upload_path . $order_item['order_id'] . '/logo_images//' . $tmp ?>">
                            <a href="<?= $upload_path . $order_item['order_id'] . '/logo_images//' . $tmp ?>" download>Download Custom Image</a>
                        </div>
                    <?php endforeach; ?>
                    <?php
                endforeach;
            }
            foreach ($order_item['images'] as $image) {
                if (!in_array($image, $images_rendered)) {
                    ?>
                    <img src="<?= site_url('order/image/' . $order_item['order_item_id'] . '/' . $product_img) ?>">
                    <?php
                }
            }
        endforeach;
    }
    ?>
</div>


<script>
    $('#order_status_update').on('change', function () {
        var ostatus = $(this).val();
        var oid = $('#order_id').val();
        if (ostatus != '') {
            $.post('order/update_status', {ostatus: ostatus, oid: oid}, function (data) {
                data = JSON.parse(data);
                if (data.success == 'success') {
                    $('#statusMsg').html(data.msg);
                    $('#statusMsg').show();
                    setTimeout(function () {
                        $('#statusMsg').html('');
                        $('#statusMsg').hide();
                    }, 5000);
                }
            });
        }
    });
</script>