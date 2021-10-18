<section id="single_product_col">
    <div class="container-fluid null-padding">
        <div class="col-xs-12 product_main_div null-padding">
            <ul class="breadcrumb about_page">
                <li><a href="<?= base_url() ?>">Home</a></li>
                <li class="active"><a href="javascript:void(0)"><?= $blog['blog_alias'] ?></a></li>
            </ul>
        </div>
    </div>
</section>
<div class="container-fluid">
    <div class="col-xs-12 blog_inner_left_col js-height null-padding">
        <div class="col-xs-12 BLOGS_col inner_blog-div">
            <?php
            $date_index = explode('-', $blog['blog_date']);
            $month = date("F", strtotime($blog['blog_date']));
            ?>
            <div class="col-xs-12 col-md-6 col-lg-6 col-sm-6 blog_left_part null-padding">
                <div class="col-xs-12 col-md-5 col-sm-5 col-lg-5 blog_LEFT null-padding">
                    <img class="img-responsive" src="<?= $this->config->item('BLOG_IMAGE_URL') . 'thumbnails/600-338/' . $blog['blog_image'] ?>" alt="<?= ($blog['alt']) ? $blog['alt'] : $blog['blog_title'] ?>">
                </div>
                <div class="col-xs-12 col-md-7 col-sm-7 col-lg-7 blog_RIGHT null-padding">
                    <p class="blog_inner_title"><?= $blog['blog_title'] ?></p>
                    <ul class="list-inline">
                        <li> <img src="images/icon(b).png" alt="loading"></li>																																								      <li> <?= $month . '  ' . $date_index[2] . '  ' . $date_index[0] ?> </li>
                        <li> <img src="images/icon(a).png" alt="loading"></li>
                        <li>
                            <?= $blog['name'] ?>
                        </li>
                    </ul>
                    <p>
                        <?= strip_tags(word_limiter($blog['blog_contents'], 100)) ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>