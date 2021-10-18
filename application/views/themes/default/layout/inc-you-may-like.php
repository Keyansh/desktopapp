<?php
$customer = $this->memberauth->checkAuth();
$top_rated_products = $relatedproducts;
?>
<?php if ($top_rated_products) { ?>
    <div class="container-fluid site-container">
        <div class="architectural-section col-xs-12 padding-zero">
            <p class="hardware-consort-heading ">You may also like</p>
            <div id="you-may-like-product" class="owl-carousel owl-theme col-xs-12">
                <?php
                foreach ($top_rated_products as $top_rated_product_else) :
                    if (file_exists($this->config->item('PRODUCT_PATH') . $top_rated_product_else['img']) && $top_rated_product_else['img']) {
                        $image_url = resize($this->config->item('PRODUCT_PATH') . $top_rated_product_else['img'], 300, 300, 'top-rated-products');
                    } else {
                        // $image_url = resize(FCPATH . 'images/a1.jpg', 300, 300, 'top-rated-products');
                        $image_url = resize(FCPATH . 'images/img-default.jpg', 314, 419, 'product-listing-img');
                    }
                ?>
                    <div class="item">
                        <div class="product-listing-item-div">
                            <?php if (!$this->session->userdata('CUSTOMER_ID')) { ?>
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#logInPop">
                                <?php } elseif ($this->session->userdata('CUSTOMER_ID')) { ?>
                                    <a href="<?= base_url() . $top_rated_product_else['uri'] ?>" class="userlog" data-type="product" data-id="<?php echo $top_rated_product_else['id'] ?>">
                                    <?php } ?>

                                    <div class="hardware-inner-div">
                                        <img src="<?= $image_url ?>" alt="<?= ($top_rated_product_else['imgalt']) ? $top_rated_product_else['imgalt'] : $top_rated_product_else['name'] ?>" class="img-responsive">
                                    </div>
                                    <p class="product-listing-a"><?= $top_rated_product_else['name'] ?></p>
                                    </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php } ?>