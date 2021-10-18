<?php
$moduleConfig = json_decode($module_item['element_config'], true);
$relation = '';
$collage_type = '';
$portfolio_list = '';
if ($moduleConfig['element_table'] == 'portfolio_list') {
    $moduleConfig['element_table'] = 'portfolio';
    $portfolio_list = 'portfolio_list';
}

if ($moduleConfig['element_table'] == 'portfolio' && $moduleConfig['element_table'] != 'collage' && $portfolio_list == '') {

    $relation = 'portfolio_category';
} else if ($moduleConfig['element_table'] == 'collage') {
    $relation = '';
    $collage_type = $moduleConfig['element_table'];
    $moduleConfig['element_table'] = $moduleConfig['collage_type'];
}

$moduleData = getModuleData($moduleConfig, $relation);
// e($moduleConfig);

?>
<?php if (isset($moduleData) && $moduleData) { ?>
    <div class="container-fluid">

        <?php if ($moduleConfig['element_table'] == 'services' && $collage_type != 'collage') { ?>
            <div class="services-listing-inner col-xs-12 padding-zero">
                <?php foreach ($moduleData as $moduleItem) { ?>
                    <div class="services-inner-div col-xs-12 <?php echo $module_item['layout_type']; ?>">
                        <a href="services/<?php echo $moduleItem['url_alias']; ?>">
                            <?php if ($moduleConfig['display_image'] == 'yes') { ?>
                                <div class="services-img-div">
                                    <img src="images/default-wide.jpg" data-src="<?php echo $this->config->item('SERVICES_IMAGE_URL') . $moduleItem['image'] ?>" alt="<?php echo $moduleItem['img_alt'] ?>" class="service-img img-responsive lazyload">
                                </div>
                            <?php } ?>
                            <div class="image-hover-div col-xs-12 padding-zero">
                                <ul class="images-div list-inline">
                                    <li class="services-img-heading"><?php echo $moduleItem['title'] ?></li>
                                    <?php if ($moduleConfig['word_count'] && $moduleConfig['word_count'] > 0) {
                                        $descContent = word_limiter($moduleItem['contents'], $moduleConfig['word_count'], '');
                                    ?>
                                        <li style="display: block; width: 100%;"><?php echo $descContent; ?></li>
                                    <?php }
                                    ?>
                                </ul>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
        <?php } else if ($moduleConfig['element_table'] == 'news' && $collage_type != 'collage') { ?>
            <?php foreach ($moduleData as $moduleItem) {
                $date_index = explode('-', $moduleItem['news_date']);
            ?>
                <div class="news-half-inner-div col-xs-12 <?php echo $module_item['layout_type']; ?>">
                    <?php if ($moduleConfig['display_image'] == 'yes') { ?>
                        <div class="news-img-inner">
                            <img src="images/default-wide.jpg" data-src="<?php echo $this->config->item('NEWS_IMAGE_URL') . $moduleItem['news_image'] ?>" alt="" class="news-img img-responsive lazyload">
                        </div>
                    <?php } ?>
                    <div class="easy-news-inner col-xs-12 padding-zero">
                        <div class="news-main-text">
                            <p class="news-day-text"><?php echo $date_index[0]; ?> <sup class="news-month-text"><?= date('M', $moduleItem['news_date']) ?></sup></p>
                            <p class="news-neque-heading"><?php echo $moduleItem['news_title']; ?></p>
                            <p class="news-neque-text">
                                <?php
                                $descContent = $moduleItem['news_contents'];
                                if ($moduleConfig['word_count'] && $moduleConfig['word_count'] > 0) {
                                    $descContent = word_limiter($moduleItem['news_contents'], $moduleConfig['word_count'], '');
                                }
                                echo $descContent;
                                ?>
                            </p>
                            <a href="<?php echo $moduleItem['news_alias']; ?>" class="read-more-btn">read more</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } else if ($moduleConfig['element_table'] == 'portfolio' && $collage_type != 'collage' && $portfolio_list != 'portfolio_list') { ?>
            <div class="featured-text line-color-div3 col-xs-12">

                <ul class="nav nav-tabs main-featured-links">
                    <li class="active"><a data-toggle="tab" href="#all_projects">all projects</a></li>
                    <?php foreach ($moduleData as $moduleItem) {
                        if (count($moduleItem['sub_items'])) {
                    ?>
                            <li><a data-toggle="tab" href="#<?php echo str_replace(" ", "_", $moduleItem['title']); ?>"><?php echo $moduleItem['title']; ?></a></li>
                    <?php
                        }
                    } ?>
                </ul>

                <div class="tab-content col-xs-12">


                    <div id="all_projects" class="tab-pane fade active in featured-links col-xs-12">
                        <div class="full-fledge-item col-xs-12">
                            <?php foreach ($moduleData as $moduleItem) { ?>
                                <?php foreach ($moduleItem['sub_items'] as $moduleSubItem) { ?>
                                    <div class="item-img col-xs-12 <?php echo $module_item['layout_type']; ?>">
                                        <div class="item-inner col-xs-12">
                                            <a href="<?php echo $this->config->item('PORTFOLIO_IMAGE_URL') . $moduleSubItem['image']; ?>" data-fancybox="gallery">
                                                <img src="images/default-wide.jpg" data-src="<?php echo $this->config->item('PORTFOLIO_IMAGE_URL') . $moduleSubItem['image']; ?>" alt="" class="img-responsive lazyload">
                                            </a>
                                            <a href="<?php echo $this->config->item('PORTFOLIO_IMAGE_URL') . $moduleSubItem['image']; ?>" class="featured-read-btn" data-fancybox="gallery">
                                                <div class="doublecolor-btn">
                                                    <div class="hover-color-div col-xs-12">
                                                        <div class="web-text col-xs-12 col-sm-10">
                                                            <p class="web-text"><?php echo strip_tags($moduleSubItem['contents']); ?></p>
                                                            <p class="easy-text-hover"><?php echo $moduleSubItem['title']; ?></p>
                                                        </div>
                                                        <div class="right-arrow col-xs-12 col-sm-2">
                                                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>


                    <?php foreach ($moduleData as $moduleItem) { ?>
                        <div id="<?php echo str_replace(" ", "_", $moduleItem['title']); ?>" class="tab-pane fade featured-links col-xs-12">

                            <div class="full-fledge-item col-xs-12">

                                <?php foreach ($moduleItem['sub_items'] as $moduleSubItem) { ?>
                                    <div class="item-img col-xs-12 <?php echo $module_item['layout_type']; ?>">
                                        <div class="item-inner col-xs-12">
                                            <a href="<?php echo $this->config->item('PORTFOLIO_IMAGE_URL') . $moduleSubItem['image']; ?>" data-fancybox="gallery">
                                                <img src="images/default-wide.jpg" data-src="<?php echo $this->config->item('PORTFOLIO_IMAGE_URL') . $moduleSubItem['image']; ?>" alt="" class="img-responsive lazyload">
                                            </a>
                                            <a href="<?php echo $this->config->item('PORTFOLIO_IMAGE_URL') . $moduleSubItem['image']; ?>" class="featured-read-btn" data-fancybox="gallery">
                                                <div class="doublecolor-btn">
                                                    <div class="hover-color-div col-xs-12">
                                                        <div class="web-text col-xs-12 col-sm-10">
                                                            <p class="web-text"><?php echo strip_tags($moduleSubItem['contents']); ?></p>
                                                            <p class="easy-text-hover"><?php echo $moduleSubItem['title']; ?></p>
                                                        </div>
                                                        <div class="right-arrow col-xs-12 col-sm-2">
                                                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                <?php } ?>

                            </div>

                        </div>
                    <?php } ?>

                </div>

            </div>
        <?php } else if ($collage_type == 'collage') { ?>
            <div class="gg-box">
                <?php foreach ($moduleData as $moduleItem) {
                    $imagePath = '';
                    $imageItem = '';
                    $imageTitle = '';
                    $imageLink = '';
                    if ($moduleConfig['element_table'] == 'services') {
                        $imagePath = $this->config->item('SERVICES_IMAGE_URL') . $moduleItem['image'];
                        $imageTitle = $moduleItem['title'];
                        $imageLink = 'services/' . $moduleItem['url_alias'];
                    } else if ($moduleConfig['element_table'] == 'news') {
                        $imagePath = $this->config->item('NEWS_IMAGE_URL') . $moduleItem['news_image'];
                        $imageTitle = $moduleItem['news_title'];
                        $imageLink = 'news/' . $moduleItem['news_alias'];
                    }
                ?>
                    <div class="gg-element">
                        <a href="<?php echo $imageLink; ?>">
                            <img src="<?php echo $imagePath; ?>">
                            <p class="design-text"><?php echo $imageTitle; ?></p>
                        </a>
                    </div>
                <?php } ?>
            </div>
        <?php } else if ($moduleConfig['element_table'] == 'portfolio' && $portfolio_list == 'portfolio_list') {  ?>
            <div class="services-listing-inner col-xs-12 padding-zero">
                <?php foreach ($moduleData as $moduleItem) { ?>
                    <div class="services-inner-div col-xs-12 <?php echo $module_item['layout_type']; ?>">
                        <a href="portfolio/<?php echo $moduleItem['alias']; ?>">
                            <?php if ($moduleConfig['display_image'] == 'yes') { ?>
                                <div class="services-img-div">
                                    <img src="images/default-wide.jpg" data-src="<?php echo $this->config->item('PORTFOLIO_IMAGE_URL') . $moduleItem['image'] ?>" alt="<?php echo $moduleItem['img_alt'] ?>" class="service-img img-responsive lazyload">
                                </div>
                            <?php } ?>
                            <div class="image-hover-div col-xs-12 padding-zero">
                                <ul class="images-div list-inline">
                                    <li class="services-img-heading"><?php echo $moduleItem['title'] ?></li>
                                    <?php if ($moduleConfig['word_count'] && $moduleConfig['word_count'] > 0) {
                                        $descContent = word_limiter($moduleItem['contents'], $moduleConfig['word_count'], '');
                                    ?>
                                        <li style="display: block; width: 100%;"><?php echo $descContent; ?></li>
                                    <?php }
                                    ?>
                                </ul>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
        <!-- <?php } else if ($moduleConfig['element_table'] == 'slideshow_image') {  ?>

            <div class="slider-main-div">
                <div id="slider-<?= $moduleConfig['slider_id'] ?>" class="owl-carousel owl-theme slider-navigation">
                    <?php foreach ($moduleData as $moduleItem) { ?>
                        <div class="item">
                            <div class="slider-content-main-div">
                                <img src="<?php echo $this->config->item('SLIDESHOW_IMAGE_URL') . $moduleItem['slideshow_image']; ?>" alt="" class="img-responsive">
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <script>
                $('#slider-<?= $moduleConfig['slider_id'] ?>').owlCarousel({
                    loop: true,
                    margin: 0,
                    nav: true,
                    responsive: {
                        0: {
                            items: <?= $moduleConfig['display_on_mobile'] ?>
                        },
                        768: {
                            items: <?= $moduleConfig['display_on_tablets'] ?>
                        },
                        992: {
                            items: <?= $moduleConfig['display_on_web'] ?>
                        }
                    }
                })
            </script> -->
        <?php }  ?>

        <link rel="stylesheet" href="<?php echo base_url(); ?>css/grid-gallery.min.css">
        <script src="<?php echo base_url() ?>js/grid-gallery.min.js"></script>
    </div>
<?php } ?>