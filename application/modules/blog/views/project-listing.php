<section id="single_product_col">
    <div class="container-fluid null-padding">
        <div class="col-xs-12 product_main_div null-padding">
            <ul class="breadcrumb about_page">
                <li><a href="<?= base_url() ?>">Home</a></li>
                <li class="active"><a href="javascript:void(0)">Blog</a></li>
            </ul>
        </div>
    </div>
</section>
<div class="container-fluid">
    <div class="col-xs-12 blog_inner_left_col js-height null-padding">
        <div class="col-xs-12 BLOGS_col inner_blog-div">
            <?php
            if ($blog) {
                foreach ($blog as $value):
                    $date_index = explode('-', $value['blog_date']);
                    $month = date("F", strtotime($value['blog_date']));
                    ?>
                    <div class="col-xs-12 col-md-6 col-lg-6 col-sm-6 blog_left_part null-padding">
                        <div class="col-xs-12 col-md-5 col-sm-5 col-lg-5 blog_LEFT null-padding">
                            <a href="<?= base_url() . 'blog/details/' . $value['blog_alias'] ?>">
                                <img class="img-responsive" src="<?= $this->config->item('BLOG_IMAGE_URL') . 'thumbnails/600-338/' . $value['blog_image'] ?>" alt="<?= ($value['alt']) ? $blog['alt'] : $blog['blog_title'] ?>">
                            </a>
                        </div>
                        <div class="col-xs-12 col-md-7 col-sm-7 col-lg-7 blog_RIGHT null-padding">
                            <a href="<?= base_url() . 'blog/details/' . $value['blog_alias'] ?>">
                                <p class="blog_inner_title"><?= $value['blog_title'] ?></p>
                            </a>
                            <ul class="list-inline">
                                <li> <img src="images/icon(b).png" alt="loading"></li>																																								      <li> <?= $month . '  ' . $date_index[2] . '  ' . $date_index[0] ?> </li>
                                <li> <img src="images/icon(a).png" alt="loading"></li>
                                <li>
                                    <?= $value['name'] ?>
                                </li>
                            </ul>
                            <p>
                                <?= strip_tags(word_limiter($value['blog_contents'], 100)) ?>
                            </p>
                        </div>
                    </div>
                    <?php
                endforeach;
                echo $pagination;
            } else {
                echo '<p style="color:red;text-align:center;">No records</p>';
            }
            ?>
        </div>
    </div>
</div>
<!--<style>
    .disabled {
        pointer-events: none;
        cursor: default;
    }
</style>
<script>
    $(document).ready(function () {
        $('.disabled').click(function (e) {
            e.preventDefault();
        })
    });
</script>
<script>
    $('.search-blog-btn').click(function (e) {
        e.preventDefault();
        var value = $('.search-blog').val();
        if (value == '') {
            $('.error').html("Please Enter Keyword");
            return;
        }

        $.ajax({
            url: "blog/ajaxform",
            type: "POST",
            data: {value: value},
            cache: false,
            success: function (data) {
                $("#service-container").html(data);
            }
        });
    })
    var track_page = 1;

    $(document).on('click', '.ajaxPagination a', function (e) {
        var objProp = $(this);
        track_page++;
        e.preventDefault();
        var perpage = objProp.prop('href').split('/').pop();

        $('.animation_image').show();
        var viewP = $('.view-change-ul button.active').attr('vald');
        $.post(DWS_BASE_URL + 'cms/blog/productByAjax/' + perpage, {page: track_page, perPage: 7, offset: perpage}, function (data) {
            if (data.html != '') {
                console.log(data.pagination);

                $('.ajaxPagination').html(' ');
                $(".cateoryAjax").html(' ');
                $('.ajaxPagination').html(data.pagination);
                $(".cateoryAjax").append(data.html);
            }
        }, 'JSON');
//            }
    });

</script>-->