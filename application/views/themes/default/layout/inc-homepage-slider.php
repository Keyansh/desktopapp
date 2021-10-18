<div class="container-fluid">
    <div class="col-xs-12 site-slider padding-zero">
        <div class="owl-carousel owl-theme" id="main-slider">
            <?php foreach ($slides as $jasperItem) { ?>
                <div class="item">
                    <a href="<?= $jasperItem['link'] ? $jasperItem['link'] : 'javascript:void(0)' ?>" <?= $jasperItem['new_window'] == 1 && $jasperItem['link'] ? 'target="_blank"' : '' ?>>
                        <img src="<?= $this->config->item('SLIDESHOW_IMAGE_URL') . $jasperItem['slideshow_image']; ?>" alt="<?= $jasperItem['alt'] ?>" class="img-responsive" />
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
</div>