<?php $listAllLatestProjects = listAllLatestProjects(); ?>
<?php if ($listAllLatestProjects) { ?>
    <div class="site-container">
        <div class="slider-main-div col-xs-12">
            <p class="latest-project-heading">Latest Projects</p>
            <div id="slider-latest-projects" class="owl-carousel owl-theme slider-navigation">
                <?php foreach ($listAllLatestProjects as $item) { ?>
                    <div class="item">
                        <div class="col-xs-12 projects-slider-item">
                            <a href="projects/details/<?php echo $item['projects_alias']; ?>" class="projects-slider-item-inner">
                                <div class="col-xs-12 col-sm-6 projects-slider-item-left">
                                    <?php $getMainImage = getMainImage($item['projects_id']); ?>
                                    <?php
                                    if (file_exists($this->config->item('PROJECTS_IMAGE_PATH') . $getMainImage['img']) && $getMainImage['img']) {
                                        $image_url = resize($this->config->item('PROJECTS_IMAGE_PATH') . $getMainImage['img'], 667, 667, 'project-listing-img');
                                    } else {
                                        $image_url = resize(FCPATH . 'images/default-square.jpg', 667, 667, 'project-listing-img');
                                    }
                                    ?>
                                    <div class="slider-content-main-div-img" style="background-image: url(<?php echo $image_url; ?>); background-position: center;background-size: 200%;">


                                        <!-- <img src="<?php //echo $image_url; ?>" alt="" class="img-responsive"> -->

                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 projects-slider-item-right">
                                    <div class="slider-content-main-div-content-left">
                                        <p class="projects-slider-heading">
                                            <?= $item['projects_title'] ?>
                                        </p>
                                        <div class="projects-slider-heading-disc">
                                            <?= strip_tags($item['short_contents']) ?>
                                        </div>
                                        <div class="project-content-inner-div">
                                            <?php $projectFields = projectDynamicFieldsInc($item['projects_id']);
                                            if ($projectFields) {
                                                foreach ($projectFields as $item1) { ?>

                                                    <div class="projects-con-inner-div">
                                                        <p class="con-title" style="font-weight: 700;"><?= $item1['fieldname'] ?></p>
                                                        <p class="con-title-1"><?= $item1['fieldvalue'] ?></p>
                                                    </div>

                                            <?php }
                                            } ?>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <script>
        $('#slider-latest-projects').owlCarousel({
            loop: true,
            margin: 3,
            nav: true,
            dots: false,
            autoplay: true,
            autoplayTimeout: 5000,
            responsive: {
                0: {
                    items: 1
                },
                768: {
                    items: 1
                },
                992: {
                    items: 1
                }
            }
        })
    </script>
<?php } ?>