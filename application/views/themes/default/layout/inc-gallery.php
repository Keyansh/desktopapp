<div class="container">

    <?php $gallerys = gallery();
    if ($gallerys) { ?>

        <div class="col-xs-12 homepage-gallery padding-zero">
            <p class="beauty-of-wood-title col-xs-12 padding-zero">
                Photo Gallery
            </p>
            <p class="our-resent-project col-xs-12 padding-zero">
                Our Recent Projects
            </p>
            <div class="gallery-img-main-div col-xs-12 padding-zero">
                <div id="home-page-gallery-slider" class="owl-carousel owl-theme">
                    <?php foreach ($gallerys as $gallery) { ?>
                        <div class="item">
                            <div class="col-xs-12 gallery-img-main-div-inner ">
                                <div class="gallery-img-div">
                                    <a data-fancybox="gallery" class="mag-glass" href="<?php echo $this->config->item('GALLERY_IMAGE_URL') . $gallery['image']; ?>"><i class="fa fa-search-plus" aria-hidden="true"></i>
                                    </a>
                                    <img src="<?php echo $this->config->item('GALLERY_IMAGE_URL') . $gallery['image']; ?>" alt="" class="img-responsive">
                                </div>
                                <p class="gallery-img-div-inner-title">
                                    <?php echo $gallery['project_name'] ?>
                                </p>
                                <p class="gallery-img-main-div-title">
                                    <?php echo $gallery['location'] ?>
                                </p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="home-page-product-btn-div gallery-btn-div">
                    <a href="<?= base_url() ?>gallery" class="common-btn">explore gallery<img src="images/button-arrow.png" alt="" class="btn-arrow"> </a>
                </div>
            </div>
        </div>
    <?php } ?>
</div>