<?php //e($news)
?>

<section id="news-detail">
    <div class="container-fluid ">
        <div class="col-xs-12 news-detail">
            <div class="col-xs-12 product_main_div null-padding">
                <ul class="breadcrumb about_page">
                    <li><a href="<?= base_url() ?>">Home</a></li>
                    <li class="active"><a href="javascript:void(0)"><?= $news['news_title'] ?></a></li>
                </ul>
            </div>
            <div class="col-xs-12 list-main-div padding-zero ">
                <div class="col-xs-12 col-sm-8 left-part-list-news padding-zero ">
                    <div class="col-xs-12 common-heading-col">
                        <p class="arrow-heading"><?= $news['news_title'] ?></p>
                    </div>
                    <div class="col-xs-12 news-main-col padding-zero ">
                        <div class="news-detial-content"> <?php echo $news['news_contents']; ?></div>

                        <div class="col-xs-12 detail-news-img padding-zero ">
                            <div class="latest-news-img-div col-xs-12 padding-zero">
                                <?php if ($news_img) { ?>
                                    <div id="news1" class="owl-carousel owl-theme">
                                        <?php
                                        foreach ($news_img as $image) { ?>
                                            <div class="item">
                                                <img src="<?= $this->config->item('NEWS_IMAGE_URL') . $image['img'] ?>" alt="<?php echo $item['news_title']; ?>" class="img-responsive">
                                            </div>
                                        <?php }
                                        ?>
                                    </div>
                                    <div id="news2" class="owl-carousel owl-theme">
                                        <?php
                                        foreach ($news_img as $image) { ?>
                                            <div class="item">
                                                <img src="<?= $this->config->item('NEWS_IMAGE_URL') . $image['img'] ?>" alt="<?php echo $item['news_title']; ?>" class="img-responsive">
                                            </div>
                                        <?php }
                                        ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                    </div>
                    <div class="col-xs-12 back-to-news">
                        <ul class="list-inline back-to-news-ul">
                            <li>
                                <span>
                                    On <?= $news['news_date'] ?>
                                </span>
                                / Latest News / Leave a comment
                            </li>
                            <li>
                                <a class="back-to-news-a" href="news">Back to news</a>
                            </li>
                        </ul>
                    </div>
                    <?php if ($newsComments) { ?>
                        <div class="col-xs-12 comments-reply">
                            <?php foreach ($newsComments as $newsComment) { ?>
                                <div class="col-xs-12 comment-inner-div">
                                    <p class="come-name">
                                        <?= $newsComment['c_name'] ?>
                                    </p>
                                    <p class="come-come">
                                        <?= $newsComment['message'] ?>
                                    </p>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } else { ?>
                        <div class="col-xs-12 comments-reply">
                            <p>Not commented Yet</p>
                        </div>
                    <?php } ?>
                    <div class="col-xs-12 comment-sec">
                        <div class="col-xs-12 common-heading-col">
                            <p class="arrow-heading">Leave a reply</p>
                        </div>
                        <div class="form-comment-sec col-xs-12">
                            <div class="alert alert-danger" id="enquiryAlert" style="display: none;"></div>
                            <form action="" id="comment-form">
                                <div class="col-xs-12 form-group col-xs-4 form-input">
                                    <input type="text" name="c_name" placeholder="Name (required)" class="form-control">
                                    <input type="hidden" name="news_id" value="<?= $news['news_id'] ?>">
                                </div>
                                <div class="col-xs-12 form-group col-xs-4 form-input">
                                    <input type="text" name="c_mail" placeholder="Mail (will not be published) (required)" class="form-control">
                                </div>
                                <div class="col-xs-12 form-group col-xs-4 form-input">
                                    <input type="text" name="c_website" placeholder="Website" class="form-control">
                                </div>
                                <div class="col-xs-12 form-group  form-area">
                                    <textarea name="message" id="" cols="10" rows="5" placeholder="Your kind words for us"></textarea>
                                </div>
                                <div class="form-group col-xs-12">
                                    <div class="g-recaptcha cap-width-100" data-sitekey="<?= DWS_RECAPTCHA_SITE_KEY ?>"></div>
                                </div>
                                <div class="col-xs-12 form-btn">
                                    <button class="back-to-news-a" id="comment-btn" type="submit">Submit comment</button>
                                </div>
                            </form>
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



<script>
    $(document).ready(function() {

        var sync1 = $("#news1");
        var sync2 = $("#news2");
        var slidesPerPage = 4; //globaly define number of elements per page
        var syncedSecondary = true;

        sync1.owlCarousel({
            items: 1,
            slideSpeed: 2000,
            nav: true,
            autoplay: true,
            dots: false,
            loop: true,
            responsiveRefreshRate: 200,
        }).on('changed.owl.carousel', syncPosition);

        sync2
            .on('initialized.owl.carousel', function() {
                sync2.find(".owl-item").eq(0).addClass("current");
            })
            .owlCarousel({
                items: slidesPerPage,
                dots: false,
                nav: false,
                smartSpeed: 200,
                slideSpeed: 500,
                slideBy: slidesPerPage, //alternatively you can slide by 1, this way the active slide will stick to the first item in the second carousel
                responsiveRefreshRate: 100
            }).on('changed.owl.carousel', syncPosition2);

        function syncPosition(el) {
            //if you set loop to false, you have to restore this next line
            //var current = el.item.index;

            //if you disable loop you have to comment this block
            var count = el.item.count - 1;
            var current = Math.round(el.item.index - (el.item.count / 2) - .5);

            if (current < 0) {
                current = count;
            }
            if (current > count) {
                current = 0;
            }

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
</script>

<link type="text/css" rel="stylesheet" href="<?= base_url() ?>css/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!--shop by price-->
<script src="http://malsup.github.io/jquery.blockUI.js"></script>
<script>
    $("#comment-form").submit(function(e) {

        e.preventDefault();
        $('.form-comment-sec').block({
            message: '<h1>Processing...</h1>',
            css: {
                textAlign: 'center',
                color: '#fff',
                border: '0px solid #aaa',
                cursor: 'wait',
                backgroundColor: 'transparent',
            }
        });
        $("#comment-btn").text("Processing..")

        $.ajax({
            url: '<?php echo base_url(); ?>news/comment',
            type: "POST",
            data: $("#comment-form").serialize(),
            success: function(data) {
                var res = JSON.parse(data);
                $("#comment-btn").text("Submit comment")

                if (res.success) {
                    $('#enquiryAlert').hide();
                    window.location = res.redirect_url;
                } else {
                    $('#enquiryAlert').html(res.message);
                    $('#enquiryAlert').show();
                }
                $('.form-comment-sec').unblock();
            }
        });


    });
</script>