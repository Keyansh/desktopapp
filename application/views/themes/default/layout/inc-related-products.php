<?php
$customer = $this->memberauth->checkAuth();
// $top_rated_products = top_rated_products();
$top_rated_products = $relatedproducts;
?>
<?php if ($top_rated_products) { ?>
    <div class="container-fluid">
        <div class="col-xs-12 products_col">
            <div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 products_left-col pro_full_width">
                <div class="common_headline_div">
                    <p class="common-heading">You may also like</p>
                </div>
                <div class="col-xs-12 top-products null-padding">
                    <div class="owl-carousel owl-theme" id="top_product_slides">
                        <?php
                        foreach ($top_rated_products as $top_rated_product_else):
                            if (file_exists($this->config->item('PRODUCT_PATH') . $top_rated_product_else['img']) && $top_rated_product_else['img']) {
                                $image_url = resize($this->config->item('PRODUCT_PATH') . $top_rated_product_else['img'], 248, 264, 'top-rated-products');
                            } else {
                                $image_url = resize(FCPATH . 'images/a1.jpg', 248, 264, 'top-rated-products');
                            }
                            ?>
                            <div class="item">
                                <div class="col-xs-12 item-inner">
                                    <div class="col-xs-12  inner_products">
                                        <div class="product_img-col">
                                            <a href="<?= base_url() . $top_rated_product_else['uri'] ?>">
                                                <img src="<?= $image_url ?>" class="img-responsive" alt="<?= ($top_rated_product_else['imgalt']) ? $top_rated_product_else['imgalt'] : $top_rated_product_else['name'] ?>">
                                            </a>
                                        </div>
                                        <div class="products-descr_col">
                                            <p class="product_heading">
                                                <a style="color:inherit;" href="<?= base_url() . $top_rated_product_else['uri'] ?>">
                                                    <?= $top_rated_product_else['name'] ?>
                                                </a>
                                            </p>
                                        </div>
                                        <p class="products-dec">
                                            <?= word_limiter(strip_tags($top_rated_product_else['description']), 6) ?>
                                        </p>
                                        <div class="cat-list-btn-div">
                                            <a  href="<?= base_url() . $top_rated_product_else['uri']; ?>" class="common-btn">
                                            explore<img src="images/button-arrow.png" alt="" class="btn-arrow">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

