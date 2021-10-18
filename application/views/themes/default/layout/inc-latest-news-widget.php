

<?php if (isset($childCategories) && $childCategories) { ?>
    <div class="col-xs-12 null-padding">
        <div class="col-xs-12 common-heading-col">
            <p class="arrow-heading no-arrow">Browse by type</p>
        </div>
        <div class="col-xs-12 category-widget-main-col null-padding">
            <ul class="list-unstyled widget-category-list">
                <?php foreach ($childCategories as $childCategory_item) { ?>
                    <li>
                        <a href="<?php echo base_url() . $childCategory_item['uri']; ?>"><i class="fa fa-long-arrow-right" aria-hidden="true"></i> <?php echo $childCategory_item['name']; ?></a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
<?php } ?>

<?php if (isset($news_widget) && $news_widget) { ?>
    <div class="col-xs-12 null-padding">
        <div class="col-xs-12 common-heading-col">
            <p class="arrow-heading no-arrow">Latest News</p>
        </div>
        <div class="col-xs-12 news-widget-main-col">
            <div id="news-side-widget" class="owl-carousel owl-theme">
                <?php foreach ($news_widget as $latestNew) { ?>
                    <div class="item">
                        <div class="col-xs-12 news-widget-item null-padding">
                            <!-- <?php
                                    //$news_img = 'images/news-default.png';
                                    // if (file_exists($this->config->item('NEWS_IMAGE_PATH') . $latestNew['news_image']) && $latestNew['news_image']) {
                                    //      $news_img = $this->config->item('NEWS_IMAGE_URL') . $latestNew['news_image'];
                                    // }
                                    ?> -->
                            <?php $images = $latestNew['img'];
                            $news_img = 'images/news-default.png';
                            foreach ($images as $image) {
                                if ($image['main'] == 1) {
                                    $news_img = $this->config->item('NEWS_IMAGE_URL') . $image['img'];
                                }
                            }
                            ?>
                            <div class="news-widget-item-img-col">
                                <a href="news/details/<?php echo $latestNew['news_alias']; ?>">
                                    <img src="<?= $news_img ?>" alt="<?= $latestNew['news_title'] ?>" class="img-responsive">
                                </a>
                            </div>
                            <div class="news-widget-content-col">
                                <p class="news-widget-item-title">
                                    <?= $latestNew['news_title'] ?>
                                </p>
                                <p class="news-widget-item-cont">
                                    <?= word_limiter(strip_tags($latestNew['news_contents']), 8, '..'); ?>
                                </p>
                                <div class="news-widget-item-btn">
                                    <a href="news/details/<?php echo $latestNew['news_alias']; ?>">
                                        read more
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="news-widget-spacer">&nbsp;</div>

    <script>
        $(document).ready(function() {
            $('#news-side-widget').owlCarousel({
                loop: false,
                margin: 0,
                nav: true,
                dots: true,
                items: 1,
                autoplay: true,
            })
        });
    </script>
<?php } ?>

<?php if (isset($bannerBlocks) && $bannerBlocks) { ?>
    <div class="col-xs-12 side-banners-main-col null-padding">
        <?php foreach ($bannerBlocks as $bannerBlock_item) { ?>
            <?php if (isset($bannerBlock_item['block_image']) && $bannerBlock_item['block_image']) { ?>
                <div class="col-xs-12 side-single-banner-col null-padding">
                    <?php if (isset($bannerBlock_item['block_title']) && $bannerBlock_item['block_title']) { ?>
                        <div class="col-xs-12 common-heading-col null-padding">
                            <p class="arrow-heading no-arrow"><?php echo $bannerBlock_item['block_title']; ?></p>
                        </div>
                    <?php } ?>
                    <?php
                    $banner_link = $bannerBlock_item['link'] ? $bannerBlock_item['link'] : 'javascript:void';
                    $link_style = '';
                    if ($banner_link == 'javascript:void') {
                        $link_style = 'cursor: initial';
                    }
                    ?>
                    <a href="<?php echo $banner_link; ?>" style="<?php echo $link_style; ?>">
                        <img src="<?php echo $this->config->item('BLOCK_IMAGE_URL') . $bannerBlock_item['block_image']; ?>" class="img-responsive" />
                    </a>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
<?php } ?>