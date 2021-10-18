<section id="single_product_col">
    <div class="container-fluid null-padding">
        <div class="col-xs-12 product_main_div null-padding">
            <ul class="breadcrumb about_page">
                <li><a href="<?= base_url() ?>">Home</a></li>
                <li class="active"><a href="javascript:void(0)"><?= $test['test_alias'] ?></a></li>
            </ul>
        </div>
    </div>
</section>
<div class="container-fluid">
    <div class="col-xs-12 blog_inner_left_col js-height null-padding">
        <div class="col-xs-12 BLOGS_col inner_blog-div">
            <div class="col-xs-12 col-md-6 col-lg-6 col-sm-6 blog_left_part null-padding">
                <div class="col-xs-12 col-md-5 col-sm-5 col-lg-5  null-padding">
                    <img class="img-responsive" src="<?= $this->config->item('TEST_IMAGE_URL') . $test['image'] ?>" alt="<?= ($test['alt']) ? $test['alt'] : $test['name'] ?>">
                </div>
                <div class="col-xs-12 col-md-7 col-sm-7 col-lg-7 blog_RIGHT null-padding">
                    <p class="blog_inner_title"><?= $test['name'] ?></p>
                    <ul class="list-inline">
                        <li> <img src="images/icon(b).png" alt="loading"></li>
                        <li>
                            <?= $test['address'] ?>
                        </li>
                        <li> <img src="images/icon(a).png" alt="loading"></li>
                        <li>
                            <?= $test['name'] ?>
                        </li>
                    </ul>
                    <p>
                        <?= $test['testimonial'] ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>