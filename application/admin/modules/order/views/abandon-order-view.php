<div class="row">
    <div class="col-md-9">
        <h2>View Order - <?= $order['order_num']; ?></h2>
    </div>
    <div class="col-md-3">
        <div id="ctxmenu" class="pull-right">
            <a href="order/abandonorders" class="btn btn-primary"><i class="fa fa-bars" aria-hidden="true"></i> Manage Orders</a>
        </div>
    </div>
</div>
<hr />
<div class="col-lg-6 shipping-address">
    <h1>Client Detail</h1><br>
    <table class="table table-bordered">
        <thead>
            <tr>                                        
                <th align="left">First Name</th>
                <td align="left"><?= gp('first_name', $user_detail); ?></td>
            </tr>
            <tr>                                        
                <th align="left">Last Name</th>
                <td align="left"><?= gp('last_name', $user_detail); ?></td>
            </tr>
            <tr>                                        
                <th align="left">Address</th>
                <td align="left"><?= gp('uadd_address_01', $user_detail); ?></td>
            </tr>
            <tr>                                        
                <th align="left">City</th>
                <td align="left"><?= gp('uadd_city', $user_detail); ?></td>
            </tr>
            <tr>                                        
                <th align="left">County</th>
                <td align="left"><?= gp('uadd_county', $user_detail); ?></td>
            </tr>
            <tr>                                        
                <th align="left">Postcode</th>
                <td align="left"><?= gp('uadd_post_code', $user_detail); ?></td>
            </tr>
            <tr>                                        
                <th align="left">Phone No</th>
                <td align="left"><?= gp('uadd_phone', $user_detail); ?></td>
            </tr>
        </thead>
    </table>
</div>

<div class="col-lg-6 shipping-address">
    <h1>Shipping Address</h1><br>
    <table class="table table-bordered">
        <thead>
            <tr>                                        
                <th align="left">First Name</th>
                <td align="left"><?= gp('ship_fname', $user_detail); ?></td>
            </tr>
            <tr>                                        
                <th align="left">Last Name</th>
                <td align="left"><?= gp('ship_lname', $user_detail); ?></td>
            </tr>
            <tr>                                        
                <th align="left">Shipping Address</th>
                <td align="left"><?= gp('ship_address1', $user_detail); ?></td>
            </tr>
            <tr>                                        
                <th align="left">City</th>
                <td align="left"><?= gp('ship_city', $user_detail); ?></td>
            </tr>
            <tr>                                        
                <th align="left">County</th>
                <td align="left"><?= gp('ship_county', $user_detail); ?></td>
            </tr>
            <tr>                                        
                <th align="left">Postcode</th>
                <td align="left"><?= gp('ship_postcode', $user_detail); ?></td>
            </tr>
            <tr>                                        
                <th align="left">Phone No</th>
                <td align="left"><?= gp('ship_phone', $user_detail); ?></td>
            </tr>
        </thead>
    </table>
</div>
<div class="clearfix"></div>
<h1>Order Items</h1><br>
<table class="table table-bordered">
    <thead>
        <tr>                                        
            <th align="left">Product Name</th>
            <th align="left">Quantity </th>
            <th align="left">Unit Price </th>
            <th align="left">Subtotal</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($order_items as $content) { ?>
            <tr>
                <td><?= $content['order_item_name']; ?></td>
                <td><?= $content['order_item_qty']; ?></td>
                <td><?= DWS_CURRENCY_SYMBOL . ' ' . number_format($content['order_item_price'], 2); ?></td>
                <td><?= DWS_CURRENCY_SYMBOL . ' ' . number_format(($content['order_item_qty'] * $content['order_item_price']), 2); ?></td>
            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>                                        
            <th colspan="3" align="right">Subtotal</th>
            <th align="left"><?= DWS_CURRENCY_SYMBOL . ' ' . number_format($order['cart_total'], 2) ?></th>                                                    
        </tr>

        <tr>                                        
            <th colspan="3" align="right">VAT</th>
            <th align="left"><?= DWS_CURRENCY_SYMBOL . ' ' . number_format($order['vat'], 2) ?></th>                                                    
        </tr>
        <tr>                                        
            <th colspan="3" align="right">Grand Total</th>
            <th align="left"><?= DWS_CURRENCY_SYMBOL . ' ' . number_format($order['order_total'], 2) ?></th>                                                    
        </tr>
    </tfoot> 
</table>
<div class="">
    <?php
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
                    <a href="<?= $upload_path.$order_item['order_id'].'/product_images//'.$product_img ?>" download>Download Product Image</a>
                </div>

                <?php foreach ($orientations as $key => $orientation): ?>
                <div class="col-md-2">
                <?php
                    $tmp = explode('/',$orientation['img']);
                    $tmp = end($tmp);
                    ?>
                    <img class="center-block img-responsive" src="<?= $upload_path.$order_item['order_id'].'/logo_images//'.$tmp ?>">
                    <a href="<?= $upload_path.$order_item['order_id'].'/logo_images//'.$tmp ?>" download>Download Custom Image</a>
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
    ?>
</div>