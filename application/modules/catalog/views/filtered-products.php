<?php
if (isset($products)) {
    foreach ($products as $item) :
        if (file_exists($this->config->item('PRODUCT_PATH') . $item['img']) && $item['img']) {
            $image_url = resize($this->config->item('PRODUCT_PATH') . $item['img'], 234, 250, 'product-listing-img');
        } else {
            $image_url = resize(FCPATH . 'images/a1.jpg', 234, 250, 'product-listing-img');
        }
        ?>
        <div class="col-xs-12 col-sm-3 inner_products-outer ">
            <div class="col-xs-12  inner_products null-padding">
                <div class="product_img-col">
                    <a href="<?= base_url() . $item['uri']; ?>">
                        <img class=" img-responsive inner_pro_img"   class="" src="<?= $image_url ?>" alt="<?= $item['imgalt']; ?>">
                    </a>
                </div>
                <div class="products-descr_col">
                    <p class="proheading-p">
                        <a class="product_heading" href="<?= base_url() . $item['uri']; ?>">    
                            <?= $item['name']; ?>
                        </a>
                    </p>
                    <p class="products-dec">
                        <?= word_limiter(strip_tags($item['description']), 6) ?>
                    </p> 
                    <?php if (isset($item['product_stock_status']) && $item['product_stock_status'] == 0) { ?>
                        <div class="cat-list-btn-div">
                            <a  href="javascript:void(0)" class="common-btn">
                                Out of Stock !
                            </a>
                        </div>
                    <?php } elseif (isset($item['product_stock_status']) && $item['product_stock_status'] == 1) { ?>
                        <div class="cat-list-btn-div">
                            <a  href="javascript:void(0)" class="common-btn">
                                Coming Soon !
                            </a>
                        </div>
                        <?php
                    } else {
                        if ($item['type'] == 'config') {
                            
                        } else {
                            if ($item['current_quantity'] <= 0) {
                                ?>
                                <div class="cat-list-btn-div">
                                    <a  href="javascript:void(0)" class="common-btn">
                                        Coming Soon !
                                    </a>
                                </div>
                                <?php
                            } else {
                                ?>
                                <div class="cat-list-btn-div">
                                    <a  href="<?= base_url() . $item['uri']; ?>" class="common-btn">
                                        Enquire now
                                    </a>
                                </div>

                                <?php
                            }
                        }
                    }
                    ?>   
                </div>
            </div>
        </div>

        <?php
    endforeach;
}
?>