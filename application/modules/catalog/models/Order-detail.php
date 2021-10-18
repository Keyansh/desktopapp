<h1>Order Details - <?= $order['order_num']; ?></h1>
<div id="ctxmenu"><a href="order/index/">Manage Orders</a> </div>
<?php
$this->load->view('inc-messages');
if ($order['confirmed'] == 0) { ?>
    <p align="right">
        <!--If you have received payment for this order click on "Confirm Order" link.<br />-->
        <a href="order/confirm/<?php echo $order['order_id']; ?>"  onclick="return confirm('Are you sure you want to Dispatch this Order?');">Dispatch Order</a></p>
<?php } else { ?>
    <p align="right"><strong>Order Dispatched</strong></p>
<?php } ?>

<div style="width:48%; float:left; padding-right:10px">
    <h2>Billing Details</h2>
    <div class="tableWrapper">
        <table width="100%" border="0" cellspacing="0" cellpadding="3" class="grid">

            <tr>
                <td><strong>First Name</strong></td>
                <td><?php echo $order['b_first_name']; ?>&nbsp;</td>
            </tr>
            <tr>
                <td><strong>Last Name </strong></td>
                <td><?php echo $order['b_last_name']; ?>&nbsp;</td>
            </tr>
            <tr>
                <td><strong>Email</strong></td>
                <td><?php echo $order['email']; ?></td>
            </tr>
            <tr>
                <td><strong>Address 1</strong></td>
                <td><?php echo $order['b_address1']; ?>&nbsp;</td>
            </tr>
            <tr>
                <td><strong>Address 2</strong></td>
                <td><?php echo $order['b_address2']; ?>&nbsp;</td>
            </tr>
            <tr>
                <td><strong>Town/City </strong></td>
                <td><?php echo $order['b_city']; ?>&nbsp;</td>
            </tr>
            <tr>
                <td><strong>County </strong></td>
                <td><?php echo $order['b_county']; ?>&nbsp;</td>
            </tr>
            <tr>
                <td><strong>Postal Code </strong></td>
                <td><?php echo $order['b_postcode']; ?>&nbsp;</td>
            </tr>

            <tr>
                <td><strong>Mobile</strong></td>
                <td><?php echo $order['b_phone']; ?>&nbsp;</td>
            </tr>
        </table>
    </div>
</div>
<div style="width:48%; float:left">
    <h2>Shipping Details</h2>
    <div class="tableWrapper">
        <table width="100%" border="0" cellpadding="3" cellspacing="0" class="grid">

            <tr>
                <td><strong>First Name </strong></td>
                <td><?php echo $order['s_first_name']; ?> &nbsp;</td>
            </tr>
            <tr>
                <td><strong>Last Name </strong></td>
                <td><?php echo $order['s_last_name']; ?>&nbsp;</td>
            </tr>
            <tr>
                <td><strong>Address 1</strong></td>
                <td><?php echo $order['s_address1']; ?>&nbsp;</td>
            </tr>
            <tr>
                <td><strong>Address 2</strong></td>
                <td><?php echo $order['s_address2']; ?>&nbsp;</td>
            </tr>
            <tr>
                <td><strong>Town/City </strong></td>
                <td><?php echo $order['s_city']; ?>&nbsp;</td>
            </tr>
            <tr>
                <td><strong>County </strong></td>
                <td><?php echo $order['s_county']; ?>&nbsp;</td>
            </tr>
            <tr>
                <td><strong>Postal Code </strong></td>
                <td><?php echo $order['s_postcode']; ?>&nbsp;</td>
            </tr>

        </table>
    </div>
</div>
<div style="clear:both"></div>
<h2>Transaction Details</h2>
<div class="tableWrapper">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="grid">
<?php if ($order['confirmed'] == 1) { ?>
            <tr>
                <td width="26%">Transaction No.(Authcode)</td>
                <td width="74%">: <?php echo $order['transaction_no']; ?></td>
            </tr>
<?php } ?>
              <tr>
            <td width="26%">Customer Order No.</td>
            <td width="74%">: <?php echo $order['cus_order_number']; ?></td>
        </tr>
        <tr>
            <td width="26%">Order No.</td>
            <td width="74%">: <?php echo $order['order_num']; ?></td>
        </tr>
        <tr>

            <td>Cart Total</td>
            <td>: <?php echo DWS_CURRENCY_SYMBOL . $order['cart_total']; ?></td>
        </tr>
        <tr>
            <td>Discount</td>
            <td>: <?php echo DWS_CURRENCY_SYMBOL . $order['discount']; ?></td>
        </tr>
        <tr>
            <td><b>Order Total</b></td>
            <td>: <?php echo DWS_CURRENCY_SYMBOL . $order['order_total']; ?></td>
        </tr>
    </table>
</div>
<h2>Order Details</h2>
<div class="tableWrapper">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="grid">
        <tr>
            <th width="30%"><strong>Item</strong></th>
            <th width="30%"><strong>Quantity</strong></th>
            <th width="20%"><strong>Price</strong></th>
            <th width="20%"><strong>Amount</strong></th>
        </tr>
        <?php
        foreach ($order_items as $item) {
            $options = '';
            if ($item['order_item_options']) {
                $options = unserialize(base64_decode($item['order_item_options']));
            }
            ?>
            <tr>
                <td>
                    <div class="product_name"><strong><?php echo $item['order_item_name']; ?></strong></div>
                        <?php if ($options) { ?>
                        <div class="product_options">
                            <?php
                            foreach ($options as $key => $val) {
                                if (intval($key)) {
                                    ?>
                                    <span class="lg_text"><b><?php echo $attributes[$key]; ?>:</b> </span><?php echo $attribute_values[$val]; ?>
                                    <?php
                                }
                            }
                            ?>
                        </div>
    <?php } ?>
                </td>
                <td><?php echo $item['order_item_qty']; ?></td>
                <td><?php echo DWS_CURRENCY_SYMBOL . ' ' . number_format($item['order_item_price'], 2); ?></td>
                <td><?php echo DWS_CURRENCY_SYMBOL . ' ' . number_format($item['order_item_price'] * $item['order_item_qty'], 2); ?></td>

            </tr>
<?php } ?>
    </table>
</div>
