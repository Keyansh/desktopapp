<?php
if ($home_categories) {
    ?>
    <div class="container-fluid">
        <div class="col-xs-12 home-page-product padding-zero">
            <p class="latest-news-title">
                Browse garage doors by<span> category</span>
            </p>
            <div class="col-xs-12 cat-content">
                <p>Garage doors, made by UK manufacturer Consort hardware, combine high quality and stylish design. As an innovative garage door manufacturer our products are made with a high attention to detail.</p>
                <p>Browse our 2019 range of Steel Up and Over, Side Hinged, GRP and Timber garage doors using the links below or you can download our latest catalogue.</p>
            </div>

            <div class=" col-xs-12 cat-div-home-page-inner">
                <?php
                foreach ($home_categories as $item) :
                    if (file_exists($this->config->item('CATEGORY_PATH') . $item['image']) && $item['image']) {
                        $cat_img = resize($this->config->item('CATEGORY_PATH') . $item['image'], 752, 525, 'category-image');
                    } else {
                        $cat_img = resize(FCPATH . 'images/a1.jpg', 752, 525, 'category-image');
                    }
                    $display_swatches = getProductAttrOptionSwatches_fromCategory($item['id']);
                    ?>
                    <div class="col-xs-12 home-page-product-outer">
                        <div class="col-xs-12 col-sm-6 home-page-product-outer-left">
                            <div class="home-page-product-img-div">
                                <a href="<?= base_url() . $item['uri'] ?>">
                                    <img src="<?= $cat_img ?>" alt="<?= ($item['image_alt']) ? $item['image_alt'] : $item['name'] ?>" class="img-responsive">
                                </a>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 home-page-product-outer-right">
                            <p class="home-page-product-title">
                                <?= $item['name']; ?>
                            </p>
                            <p class="home-page-product-text">
                                <?= word_limiter(strip_tags($item['description']), 20, '..'); ?>
                            </p>
                            <?php if (isset($display_swatches) && $display_swatches) { 
                                $swatchAttribute = getSwatchAttribute();
                                ?>
                                <div class="col-xs-12 product-assigned-swatches large-swatch-list null-padding">
                                    <p><?php echo $swatchAttribute['label']; ?> options</p>
                                    <ul class="list-inline">
                                        <?php
                                        foreach ($display_swatches as $display_swatches_item) {
                                            if (file_exists($this->config->item('ATTRIBUTE_OPTION_ICON_PATH') . $display_swatches_item['icon']) && $display_swatches_item['icon']) {
                                                
                                                ?>
                                                <li>
                                                    <img src="<?php echo $this->config->item('ATTRIBUTE_OPTION_ICON_URL') . $display_swatches_item['icon']; ?>" class="img-responsive" alt="<?php echo $display_swatches_item['option']; ?>" />
                                                </li>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>
                            <?php } ?>
                            <div class="home-page-product-btn-div">
                                <a href="<?= base_url() . $item['uri'] ?>" class="common-btn">View Product</a>
                            </div>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>




    <?php
}
?>