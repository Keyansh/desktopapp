<style>
    hr {
        margin-top: 10px;
        margin-bottom: 10px;
    }
</style>
<h3 class="title-hero clearfix">
    View Enquiry
    <a href="productenquiries" class="pull-right btn btn-primary">Manage Enquiries</a>
</h3>
<div class="panel">
    <div class="panel-body">
        <div class="example-box-wrapper">
            <h2>Customer Details</h2>
            <hr />
            <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered">
                <tr>
                    <th width="15%">Name : </th>
                    <td><?= $enquiry['name']; ?></td>
                </tr>
                <tr>
                    <th width="15%">Email : </th>
                    <td><?= $enquiry['email']; ?></td>
                </tr>
                <tr>
                    <th width="15%">Query/Message : </th>
                    <td><?= $enquiry['enquiry']; ?></td>
                </tr>
                <tr>
                    <th width="15%">Added On : </th>
                    <td><?= date("d F Y", strtotime($enquiry['created_at'])); ?></td>
                </tr>
            </table>
        </div>

        <div class="example-box-wrapper">
            <h2>Product Details</h2>
            <hr />
            <?php
            $products = json_decode($enquiry['enquiry_cart'], true);
            //            ee($products);
            ?>
            <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered">
                <tr>
                    <th>Product</th>
                    <th>SKU</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>
                <?php
                foreach ($products as $item) {
                ?>
                    <tr>
                        <td>
                            <?php
                            $img_url = 'images/a1.jpg';
                            if ($item['img']) {
                                $img_url = $this->config->item('PRODUCT_URL') . $item['img'];
                            }
                            ?>
                            <div class="col-xs-12" style="padding: 0;display: flex;flex-wrap: wrap;align-items: center;">
                                <div class="col-xs-3">
                                    <img src="<?php echo $img_url; ?>" width="120" />
                                </div>
                                <div class="col-xs-8">
                                    <?php echo $item['name']; ?>
                                    <p>
                                        <?php
                                        $order_item_options = json_decode($item['order_item_options']);
                                        if (isset($order_item_options)) {
                                            if ($order_item_options) {
                                        ?>
                                                <?php
                                                foreach ($order_item_options as $key => $value) {

                                                ?>
                                                    <span class="small-name">
                                                        <?php
                                                        echo str_replace("_", " ", $key) . ' : ' . $value;
                                                        ?>
                                                    </span>
                                                <?php
                                                }
                                                ?>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td><?php echo $item['product_sku']; ?></td>
                        <td>
                            <?php
                            echo $item['qty'];
                            ?>
                        </td>
                        <td>
                            <a href="<?php echo base_url() . 'catalognew/product/edit/' . $item['product_id']; ?>" class="btn btn-primary" target="_blank">View product</a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>

    </div>
</div>