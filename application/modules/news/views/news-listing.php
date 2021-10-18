<section id="news-listing">
    <div class="container-fluid ">
        <div class="col-xs-12 news-listing">
            <div class="col-xs-12 product_main_div null-padding">
                <ul class="breadcrumb about_page">
                    <li><a href="<?= base_url() ?>">Home</a></li>
                    <li class="active"><a href="javascript:void(0)"><?= $page['title'] ?></a></li>
                </ul>
            </div>
            <div class="col-xs-12 list-main-div padding-zero ">
                <div class="col-xs-12 col-sm-8 left-part-list-news padding-zero ">
                    <div class="col-xs-12 common-heading-col">
                        <p class="arrow-heading">Latest News</p>
                    </div>
                    <div class="col-xs-12 news-main-col padding-zero ">
                        <?php
                        if (count($news) == 0) {
                            echo ("<p style='text-align:center'>No News</</p>");
                          
                        }
                        ?>

                        <?php

                        foreach ($news as $item) {
                            $news_date = strtotime($item['news_date']);
                        ?>

                            <div class="col-xs-12 news-single-col padding-zero ">
                                <div class="latest-news-img-div">

                                    <?php $images = $item['img'];
                                    $img = 'images/news-default.png';
                                    foreach ($images as $image) {
                                        if ($image['main'] == 1) {
                                            $img = $this->config->item('NEWS_IMAGE_URL') . $image['img'];
                                        } 
                                    }
                                    ?>

                                    <a href="news/details/<?php echo $item['news_alias']; ?>">
                                        <img src="<?= $img ?>" alt="<?php echo $item['news_title']; ?>" class="img-responsive">
                                    </a>
                                </div>
                                <p class="news-title"><a class="news-title" href="news/details/<?php echo $item['news_alias']; ?>"><?php echo $item['news_title']; ?></a></p>
                                <p class="news-date">
                                    <?php echo $item['news_date'] ?>
                                </p>
                                <div class="news-description">
                                    <?php echo word_limiter(strip_tags($item['news_contents'], 40)); ?>
                                </div>
                                <div class="news-read-more">
                                    <a class="read-more-btn" href="news/details/<?php echo $item['news_alias']; ?>">read more </a>
                                </div>
                            </div>

                        <?php } ?>

                        <div class="col-xs-12 pagination-col">
                            <p style="text-align:center"><?php echo $pagination; ?></p>
                        </div>

                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 right-part-list-news">
                    <?php $this->load->view("themes/" . THEME . "/layout/inc-latest-news-widget"); ?>
                </div>
            </div>


        </div>
    </div>
</section>