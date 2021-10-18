<style>

</style>
<section id="single_product_col">
    <div class="container-fluid site-container null-padding">
        <div class="col-xs-12 product_main_div null-padding">
            <ul class="breadcrumb about_page">
                <li><a href="<?= base_url() ?>">Home</a></li>
                <li class="active"><a href="javascript:void(0)">My Enquiry</a></li>
            </ul>
        </div>
    </div>
</section>
<section class="bg-light-gray form-font" id="portfolio">
    <div class="container-fluid site-container">
        <div class="middle-container dashboard col-xs-12 col-sm-12 col-lg-12" id="middle-content-section">
            <!--    <div class="row">-->
            <?php $this->load->view('navigation'); ?>
            <div class="col-xs-12 col-sm-9 col-lg-9 dash-inn-right">
                <h1 class="right-top-heading"><i class="fa fa-files-o" aria-hidden="true"></i> My Enquiry</h1>
                <?php // $this->load->view('ctx-menu'); 
                ?>
                <?php
                $this->load->view('inc-messages');
                if (count($orders) == 0 && count($ordersEnquiry) == 0) {
                    echo '<p>You have not submitted any enquiries so far!</p>';
                } else {
                ?>
                    <?php if ($orders) { ?>
                        <div class="my-order-p">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered common-tb">
                                <thead>
                                    <tr>
                                        <th>Order No.</th>
                                        <th>Order Total</th>
                                        <th>Order Date</th>
                                        <th>Payment Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($orders as $item) { ?>
                                        <tr>
                                            <td><?php echo $item['order_num']; ?></td>
                                            <td><?php echo DWS_CURRENCY_SYMBOL . ' ' . number_format(($item['order_total']), 2); ?></td>
                                            <td><?php echo date('d-m-Y h:i:s', strtotime($item['order_date'])) ?></td>
                                            <td><?php echo $item['is_paid'] == 1 ? "Paid" : "Unpaid"; ?></td>
                                            <td><a href="customer/order/details/<?php echo $item['order_num']; ?>">Details</a>
                                                <!--| <a href="customer/order/reorder/<?php // echo $item['order_num'];                                                 
                                                                                        ?>" >Reorder</a>-->
                                            </td>
                                        </tr>
                                    <?php } ?>

                                </tbody>
                            </table>
                        </div>

                    <?php } ?>
                    <?php if ($ordersEnquiry) { ?>
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered">
                            <tr>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Enquiry Message</th>
                                <th>Action</th>
                            </tr>
                            <?php
                            foreach ($ordersEnquiry as $item1) {
                                // e($item1); 
                                $products = json_decode($item1['enquiry_cart'], true);

                            ?>
                                <tr>
                                    <td><?= date("d-m-Y", strtotime($item1['created_at'])); ?></td>
                                    <td>
                                        <!-- <?php
                                        $img_url = 'images/a1.jpg';
                                        if ($item['img']) {
                                            $img_url = $this->config->item('PRODUCT_URL') . $item['img'];
                                        }
                                        ?>
                                        <img src="<?php echo $img_url; ?>" width="120" /> -->
                                        <?php echo $item1['name']; ?>
                                    </td>
                                    <td><?php echo word_limiter($item1['enquiry'],4); ?></td>
                                    <td>
                                        <?php $getProductDetails = getProductDetails($item['product_id']); ?>
                                        <a href="customer/order/enquiryDetails/<?php echo $item1['id']; ?>" class="btn btn-primary" target="_blank">View Details</a>
                                    </td>
                                </tr>
                                <!-- <?php
                                foreach ($products as $item) {
                                ?>
                                    <tr>
                                        <td><?= date("d-m-Y", strtotime($item1['created_at'])); ?></td>
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
                                            <a href="customer/order/enquiryDetails/<?php echo $item1['id']; ?>" class="btn btn-primary" target="_blank">View Details</a>
                                        </td>
                                    </tr>
                                <?php } ?> -->

                            <?php } ?>
                        </table>
                    <?php } ?>


                <?php } ?>
                <ul class="pagination pagination-sm">
                    <?php echo $pagination; ?>
                </ul>
            </div>
            <!--</div>-->
        </div>
    </div>
</section>