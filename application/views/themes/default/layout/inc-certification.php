<?php
$certification = certification();
if ($certification) {
?>
    <div class="container-fluid ">
        <div class="site-container">
            <div class="brand-list-sec col-xs-12">
                <!-- <div id="certification-slide" class="owl-carousel owl-theme"> -->
                <?php foreach ($certification as $item) { ?>
                    <!-- <div class="item"> -->
                    <div class="col-xs-12 certification-img">
                        <img data-src="<?= $this->config->item('BRAND_IMAGE_URL') . $item['image'] ?>" alt="<?= $item['name'] ?>" class="img-responsive lazy" title="<?= $item['name'] ?>">
                    </div>
                    <!-- </div> -->
                <?php } ?>
                <!-- </div> -->
            </div>
        </div>
    </div>
<?php } ?>

<script>
    $(document).ready(function() {
        $('#certification-slide').owlCarousel({
            loop: false,
            dots: false,
            items: 4,
            nav: false,
            autoplay: false,
            autoplayTimeout: 5000,
            autoplayHoverPause: false,
        })
    })
</script>