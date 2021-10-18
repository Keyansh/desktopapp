<?php $testimonials = testimonial(); ?>
<?php if ($testimonials) { ?>
    <section id="testimonals">
        <div class="container">


            <div class="col-xs-12 customer-testimonals padding-zero">
                <p class="beauty-of-wood-title col-xs-12 padding-zero" style="color:#fff">
                    What our clients say!
</p>
                <div class="col-xs-12 padding-zero testimonials-quorts-img">
                    <img src="images/double-uotes.png" alt="" class="img-responsive">
                </div>
                <div class="col-xs-12 testimonials-main-div padding-zero">
                    <div id="testimonials" class="owl-carousel owl-theme">
                        <?php foreach ($testimonials as $testimonial) { ?>
                            <div class="item">
                                <div class="col-xs-12 padding-zero testimonials-main-div-inner ">
                                    <p class="testimonials-text">
                                        <?php echo strip_tags($testimonial['testimonial']) ?>
                                    </p>
                                    <div class="test-qourt-line">
                                        <span></span>
                                    </div>
                                    <p class="text-qort-name">
                                        <?php echo $testimonial['name'] ?>
                                    </p>
                                    <p class="text-qort-name-address">
                                        <?php echo $testimonial['address'] ?>
                                    </p>
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                </div>
            </div>

        </div>
    </section>
    <script>
        $(document).ready(function() {
            $('#testimonials').owlCarousel({
                loop: true,
                dots: false,
                items: 1,
                nav: true,
                autoplay: true,
                autoplayTimeout: 5000
            })
        })
    </script>
<?php } ?>