<style>
    #latest-project {
        display: none !important;
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>

<?php
$getproductMainImage = getproductMainImage(29);
// e($project);
?>
<section id="bredcrumbs">
    <div class=" container-fluid site-container">
        <div class="col-xs-12 product_main_div null-padding">
            <ul class="breadcrumb about_page">
                <li><a href="<?= base_url() ?>">Home</a></li>
                <li><a href="<?= base_url() . '/' . $page['page_alias'] ?>"><?= $page['title'] ?></a></li>
                <!-- <li><a href="<?= base_url() . '/' . $getProjectCategory['name'] ?>"><?= $getProjectCategory['name'] ?></a></li> -->
                <li class="active"><a href="javascript:void(0)"><?= $project['projects_title'] ?></a></li>
            </ul>
        </div>
    </div>

</section>

<style>
    #consort-project-div .img-outer-div-project a {
        position: absolute;
        height: 100%;
        width: 100%;
    }
</style>

<section id="project-detail-section">
    <div class="container-fluid site-container">
        <div class="col-xs-12 null-padding">
            <h1 class="hardware-common-heading">Projects</h1>
            <div class="project-detail-section col-xs-12 padding-zero">
                <div class="project-detail-inner-div col-xs-12 col-sm-6 padding-zero">
                    <div class="col-xs-12 sync-gallery padding-zero">
                        <div id="consort-project-div" class="owl-carousel owl-theme">
                            <?php if ($project['video_thumb']) { ?>
                                <div class="item ">
                                    <div class="img-outer-div-project-video-thumb iframe-thumb-projects">
                                        <img src="<?= resize($this->config->item('PROJECTS_IMAGE_PATH') . $project['video_thumb'], 666, 663, 'projects-img') ?>" alt="<?= $project['projects_title'] ?>" data-video-iframe="<?= $project['video_link'] ?>?autoplay=1" class="img-responsive">
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($project_img) { ?>
                                <?php foreach ($project_img as $item) { ?>
                                    <div class="item ">
                                        <div class="img-outer-div-project" style="background-image: url(<?= $this->config->item('PROJECTS_IMAGE_URL') . $item['img'] ?>);background-position: center;background-size: 200%;">
                                            <a data-fancybox="gallery" href="<?= $this->config->item('PROJECTS_IMAGE_URL') . $item['img'] ?>">
                                                <!-- <img src="<?= resize($this->config->item('PROJECTS_IMAGE_PATH') . $item['img'], 666, 663, 'projects-img') ?>" alt="<?= $project['projects_title'] ?>" class="img-responsive"> -->
                                            </a>
                                        </div>
                                    </div>
                                <?php }
                            } else {
                                ?>
                                <div class="item ">
                                    <div class="img-outer-div-project">
                                        <img src="images/img-default.jpg" alt="<?= $project['projects_title'] ?>" class="img-responsive">
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <?php if (count($project_img) > 1) { ?>
                            <div id="project-consort-list-div" class="owl-carousel owl-theme">
                                <?php if ($project['video_thumb']) { ?>
                                    <div class="item ">
                                        <div class="img-outer-div-project">
                                            <img src="<?= resize($this->config->item('PROJECTS_IMAGE_PATH') . $project['video_thumb'], 156, 156, 'projects-img') ?>" alt="<?= $project['projects_title'] ?>" class="img-responsive">
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if ($project_img) { ?>
                                    <?php foreach ($project_img as $item) { ?>
                                        <div class="item ">
                                            <div class="img-outer-div-project">
                                                <img src="<?= resize($this->config->item('PROJECTS_IMAGE_PATH') . $item['img'], 156, 156, 'projects-img') ?>" alt="<?= $project['projects_title'] ?>" class="img-responsive">
                                            </div>
                                        </div>
                                    <?php }
                                } else {
                                    ?>
                                    <div class="item ">
                                        <div class="img-outer-div-project">
                                            <img src="images/img-default.jpg" alt="<?= $project['projects_title'] ?>" class="img-responsive">
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <div class="project-detail-inner-text col-xs-12 col-sm-6">
                    <div class="project-detail-text col-xs-12 padding-zero">
                        <p class="hardware-consort-heading"><?= $project['projects_title'] ?></p>
                        <?php if ($project['short_contents']) { ?>
                            <div class="project-text-div"><?= $project['short_contents'] ?></div>
                            <?php if ($project['projects_contents']) { ?>
                                <a href="#projectDetailMainDiv" class="read-more-btn">read more</a>
                            <?php } ?>
                        <?php } ?>

                        <?php if ($projectDynamicFields) {
                            foreach ($projectDynamicFields as $item) { ?>
                                <div class="contrast-div">
                                    <p class="project-text-div" style="font-weight: 700;"><?= $item['fieldname'] ?></p>
                                    <p class="project-text-div"><?= $item['fieldvalue'] ?></p>
                                </div>
                        <?php }
                        } ?>
                    </div>

                    <div class="consort-slider-div col-xs-12 padding-zero">
                        <div class="consort-media-div col-xs-12 col-sm-6 padding-zero">
                            <?php $prevProject = previousProjct($project['projects_id'], $project['project_cat']);
                            if ($prevProject) { ?>
                                <a href="projects/details/<?= $prevProject['projects_alias'] ?>">
                                    <div class="consort-img-div">
                                        <?php $getMainImage = getMainImage($prevProject['projects_id']); ?>
                                        <img src="<?php echo $this->config->item('PROJECTS_IMAGE_URL') . $getMainImage['img']; ?>" alt="consort-alt" class="project-div img-responsive">
                                    </div>
                                    <p class="media-name"><?= $prevProject['projects_title'] ?></p>
                                    <div class="arrow-img-div">
                                        <img src="images/leftarrow.png" alt="" class="img-responsive">
                                    </div>
                                </a>
                            <?php } ?>
                        </div>
                        <div class="consort-media-div col-xs-12 col-sm-6 padding-zero">
                            <?php $forwordProject = forwardProject($project['projects_id'], $project['project_cat']);
                            // e($project);
                            if ($forwordProject) { ?>
                                <a href="projects/details/<?= $forwordProject['projects_alias'] ?>">
                                    <div class="consort-img-div">
                                        <?php $getMainImage = getMainImage($forwordProject['projects_id']); ?>
                                        <img src="<?php echo $this->config->item('PROJECTS_IMAGE_URL') . $getMainImage['img']; ?>" alt="consort-alt" class="project-div img-responsive">
                                    </div>
                                    <p class="media-name"><?= $forwordProject['projects_title'] ?></p>
                                    <div class="arrow-img-div">
                                        <img src="images/rightarrow.png" alt="" class="img-responsive">
                                    </div>
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php if ($project['projects_contents']) { ?>
    <section id="product-description">
        <div class="container-fluid site-container">
            <div class="product-description col-xs-12 padding-zero" id="projectDetailMainDiv">
                <p class="hardware-consort-heading-description">Project Description</p>
                <div class="product-desc-inner-div col-xs-12 padding-zero">
                    <!-- <?php // $project['short_contents'] 
                            ?> -->
                    <?= $project['projects_contents'] ?>
                </div>
            </div>
        </div>
    </section>
<?php } ?>

<?php if ($project['is_like_active'] == 1) { ?>
    <?php if ($getProductUsed) { ?>
        <section id="architectural-section">
            <div class="container-fluid site-container">
                <div class="architectural-section col-xs-12 padding-zero">
                    <p class="hardware-consort-heading">Products used in this project</p>
                    <div id="category-slider" class="owl-carousel owl-theme col-xs-12">
                        <?php foreach ($getProductUsed as $item) { ?>
                            <div class="item">
                                <div class="hardware-product-div">
                                    <?php if (!$this->session->userdata('CUSTOMER_ID')) { ?>
                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#logInPop">
                                        <?php } elseif ($this->session->userdata('CUSTOMER_ID')) { ?>
                                            <a href="<?= $item['uri'] ?>" class="userlog" data-type="product" data-id="<?php echo $item['id'] ?>">
                                            <?php } ?>

                                            <div class="hardware-inner-div">
                                                <?php
                                                $getproductMainImage = getproductMainImage($item['id']);
                                                if (file_exists($this->config->item('PRODUCT_PATH') . $getproductMainImage['img']) && $getproductMainImage['img']) {
                                                    $image_url = resize($this->config->item('PRODUCT_PATH') . $getproductMainImage['img'], 314, 419, 'product-listing-img');
                                                } else {
                                                    $image_url = resize(FCPATH . 'images/img-default.jpg', 314, 419, 'product-listing-img');
                                                }
                                                ?>
                                                <img src="<?= $image_url ?>" alt="banner-alt" class="img-responsive">
                                            </div>
                                            <p class="hardware-product-text"><?= $item['name'] ?></p>
                                            </a>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </section>
    <?php } ?>
<?php } ?>

<script>
    $(document).on('click', '.read-more-btn', function(e) {
        e.preventDefault();
        $('html, body').animate({
            scrollTop: $("#product-description").offset().top - 170
        }, 2000);
    })
    $(document).ready(function() {

        var sync1 = $("#consort-project-div");
        var sync2 = $("#project-consort-list-div");
        var slidesPerPage = 4; //globaly define number of elements per page
        var syncedSecondary = true;

        sync1.owlCarousel({
            items: 1,
            slideSpeed: 2000,
            nav: false,
            // autoplay: true,
            dots: false,
            loop: false,
            margin: 10,
            responsiveRefreshRate: 200,

        }).on('changed.owl.carousel', syncPosition);

        sync2
            .on('initialized.owl.carousel', function() {
                sync2.find(".owl-item").eq(0).addClass("current");
            })
            .owlCarousel({
                items: 4,
                dots: false,
                nav: false,
                smartSpeed: 200,
                slideSpeed: 500,
                margin: 10,
                slideBy: slidesPerPage, //alternatively you can slide by 1, this way the active slide will stick to the first item in the second carousel
                responsiveRefreshRate: 100
            }).on('changed.owl.carousel', syncPosition2);

        function syncPosition(el) {
            //if you set loop to false, you have to restore this next line
            var current = el.item.index;

            //if you disable loop you have to comment this block
            // var count = el.item.count - 1;
            // var current = Math.round(el.item.index - (el.item.count / 2) - .5);

            // if (current < 0) {
            //     current = count;
            // }
            // if (current > count) {
            //     current = 0;
            // }

            //end block

            sync2
                .find(".owl-item")
                .removeClass("current")
                .eq(current)
                .addClass("current");
            var onscreen = sync2.find('.owl-item.active').length - 1;
            var start = sync2.find('.owl-item.active').first().index();
            var end = sync2.find('.owl-item.active').last().index();

            if (current > end) {
                sync2.data('owl.carousel').to(current, 100, true);
            }
            if (current < start) {
                sync2.data('owl.carousel').to(current - onscreen, 100, true);
            }
        }

        function syncPosition2(el) {
            if (syncedSecondary) {
                var number = el.item.index;
                sync1.data('owl.carousel').to(number, 100, true);
            }
        }

        sync2.on("click", ".owl-item", function(e) {
            e.preventDefault();
            var number = $(this).index();
            sync1.data('owl.carousel').to(number, 300, true);
        });
    });


    $(document).ready(function() {
        $('#category-slider').owlCarousel({
            loop: false,
            nav: false,
            dots: false,
            items: 4,
            autoplay: true,
            margin: 10,
            autoplayTimeout: 5000,
        })

    });
    $('[data-fancybox="gallery"]').fancybox({
        loop: true,
    });
</script>






<script>
    $(document).on('click', '.iframe-thumb-projects', function() {
        var iframeSrc = $(this).find('img').attr('data-video-iframe');
        console.log(iframeSrc);
        $('#videoModel .videodata iframe').attr('src', iframeSrc);
        $('#videoModel').modal('show')
    })
    $(document).on('hidden.bs.modal', '#videoModel', function() {
        $('#videoModel .videodata iframe').attr('src', '');
    });
</script>