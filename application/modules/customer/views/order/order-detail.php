<?php
// e($enquiryDetails);
?>
<section id="single_product_col">
    <div class="container-fluid site-container null-padding">
        <div class="col-xs-12 product_main_div null-padding">
            <ul class="breadcrumb about_page">
                <li><a href="<?= base_url() ?>">Home</a></li>
                <li class="active"><a href="javascript:void(0)">Detail</a></li>
            </ul>
        </div>
    </div>
</section>
<section class="bg-light-gray" id="portfolio">
    <div class="container-fluid site-container">
        <div class="middle-container dashboard col-xs-12 col-sm-12 col-lg-12" id="middle-content-section">
            <?php $this->load->view('navigation'); ?>
            <div class="col-xs-12 col-sm-9 col-lg-9 dash-inn-right">
                <h1>Order - Details</h1>
                <table width="100%" border="1" cellspacing="0" cellpadding="0" class="grid common-tb table table-bordered">
                    <tr>
                        <th width="30%">Date</th>
                        <td width="70%"><?= date("d-m-Y", strtotime($enquiryDetails['created_at'])); ?></td>

                    </tr>
                    <tr>
                        <th>Name</th>
                        <td><?php echo $enquiryDetails['name']; ?></td>
                    </tr>
                    <tr>
                        <th>Email :</th>
                        <td><?php echo $enquiryDetails['email']; ?></td>
                    </tr>
                    <tr>
                        <th>Phone Number:</th>
                        <td><?php echo $enquiryDetails['phone']; ?></td>
                    </tr>
                    <tr>
                        <th>Enquiry Message:</th>
                        <td><?php echo $enquiryDetails['enquiry'] ?></td>
                    </tr>
                </table>
                <div class="order" style="width: 100%;display: none;">
                    <div class="biling" style="width: 50%; float: left;">
                        <h3>Billing Details</h3>
                        <table width="100%" border="1" cellspacing="0" cellpadding="0" class="grid common-tb table table-bordered">
                            <tr>
                                <th width="30%">Name:</th>
                                <td width="70%"><?php echo $order['b_first_name'] . ' ' . $order['b_last_name']; ?>&nbsp;</td>
                            </tr>
                            <tr>
                                <th>Address 1:</th>
                                <td><?php echo $order['b_address1']; ?>&nbsp;</td>
                            </tr>
                            <tr>
                                <th>Town/City:</th>
                                <td><?= $order['b_city']; ?>&nbsp;</td>
                            </tr>
                            <tr>
                                <th>State:</th>
                                <td><?php echo $order['b_county']; ?>&nbsp;</td>
                            </tr>
                            <tr>
                                <th>Post Code:</th>
                                <td><?php echo $order['b_postcode']; ?>&nbsp;</td>
                            </tr>
                            <tr>
                                <th>&nbsp;</th>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                    </div>

                    <?php
                    if ($order['s_first_name']) {
                    ?>
                        <div class="shipping" style="width: 50%; float: left;">
                            <h3>Shipping Details</h3>
                            <table width="100%" border="0" cellpadding="3" cellspacing="0" class="grid common-tb table table-bordered">
                                <tr>
                                    <th width="30%">Address 1:</th>
                                    <td width="70%"><?php echo $order['s_address1']; ?>&nbsp;</td>
                                </tr>
                                <tr>
                                    <th>Town/City:</th>
                                    <td><?php echo $order['s_city']; ?>&nbsp;</td>
                                </tr>
                                <tr>
                                    <th>State:</th>
                                    <td><?php echo $order['s_county']; ?>&nbsp;</td>
                                </tr>
                                <tr>
                                    <th>Post Code:</th>
                                    <td><?php echo $order['s_postcode']; ?>&nbsp;</td>
                                </tr>
                                <tr>
                                    <th>Phone:</th>
                                    <td><?php echo $order['s_phone']; ?>&nbsp;</td>
                                </tr>
                                <tr>
                                    <th>&nbsp;</th>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="biling" style="width: 50%; float: left;">
                            <h3>Shipping Details</h3>
                            <table width="100%" border="1" cellspacing="0" cellpadding="0" class="grid common-tb table table-bordered">
                                <tr>
                                    <th width="30%">Name:</th>
                                    <td width="70%"><?php echo $order['b_first_name'] . ' ' . $order['b_last_name']; ?>&nbsp;</td>
                                </tr>
                                <tr>
                                    <th>Address 1:</th>
                                    <td><?php echo $order['b_address1']; ?>&nbsp;</td>
                                </tr>
                                <tr>
                                    <th>Town/City:</th>
                                    <td><?= $order['b_city']; ?>&nbsp;</td>
                                </tr>
                                <tr>
                                    <th>State:</th>
                                    <td><?php echo $order['b_county']; ?>&nbsp;</td>
                                </tr>
                                <tr>
                                    <th>Post Code:</th>
                                    <td><?php echo $order['b_postcode']; ?>&nbsp;</td>
                                </tr>
                                <tr>
                                    <th>&nbsp;</th>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                        </div>
                        <!--                        <div class="shipping" style="width: 50%; float: left;">
                                                                        <h3>Shipping Details</h3>
                                                                        <p>Same as Billing Address</p>
                                                                    </div>-->
                    <?php
                    }
                    ?>
                </div>
                <h3 class="t3-order" style="clear:both;">Item Details</h3>
                <table width="100%" border="1" cellpadding="0" cellspacing="0" class="table item-detail table table-bordered common-tb">
                    <tr>
                        <th>Date</th>
                        <th>Product</th>
                        <th>SKU</th>
                        <th>Action</th>
                    </tr>


                    <?php
                    $products = json_decode($enquiryDetails['enquiry_cart'], true);
                    foreach ($products as $item) {
                    ?>
                        <tr>
                            <td><?= date("d-m-Y", strtotime($enquiryDetails['created_at'])); ?></td>
                            <td>
                                <?php
                                $img_url = 'images/a1.jpg';
                                if ($item['img']) {
                                    $img_url = $this->config->item('PRODUCT_URL') . $item['img'];
                                }
                                ?>
                                <img src="<?php echo $img_url; ?>" width="120" />
                                <?php echo $item['name']; ?>
                            </td>
                            <td><?php echo $item['product_sku']; ?></td>
                            <td>
                                <?php $getProductDetails = getProductDetails($item['product_id']); ?>
                                <a href="<?php echo base_url() . $getProductDetails['uri']; ?>" class="btn btn-primary" target="_blank">View product</a>
                            </td>
                        </tr>
                    <?php } ?>



                    <?php foreach ($order_items as $item) {
                    ?>
                        <tr>
                            <td><?php echo $item['order_item_name']; ?></td>
                            <td><?php echo $item['order_item_qty']; ?></td>
                            <td><?php echo DWS_CURRENCY_SYMBOL . ' ' . $item['order_item_price']; ?></td>
                            <td><?php echo $item['pack']; ?></td>
                            <td><?php echo DWS_CURRENCY_SYMBOL . ' ' . number_format($item['order_item_qty'] * $item['order_item_price'], 2); ?></td>
                        </tr>
                    <?php }
                    ?>
                </table>
            </div>
        </div>
    </div>
</section>