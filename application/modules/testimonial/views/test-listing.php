<style>
    .test-ul {
        list-style: none;
        padding: 30px;
        text-align: center;
        display: flex;
        flex-wrap: wrap;
        /* justify-content: center; */
        align-items: center;
        flex-direction: column;
        height: 100%;
        border-radius: 10px;
        box-shadow: 0px 0 15px #efefef;
    }

    .test_content p {
        font-size: 18px;
        padding: 26px 0px 0px 0px;
    }

    .test_desc {
        font-size: 16px;
        padding: 5px 0px;
        font-style: italic;
        color: #5c5c5c;
        line-height: 28px;
    }

    .test_content span {
        font-size: 17px;
        text-transform: capitalize;
        padding-top: 0;
        margin-top: 0;
        display: inline-block;
        color: #70b712;
        letter-spacing: 0.7px;
    }

    #testimonals {
        display: none;
    }
    #latest-project {
	margin-bottom: 60px;
}
</style>

<section id="single_product_col">
    <div class="container-fluid site-container">
        <div class="col-xs-12 product_main_div">
            <ul class="breadcrumb about_page">
                <li><a href="<?= base_url() ?>">Home</a></li>
                <li class="active"><a href="javascript:void(0)">Testimonials</a></li>
            </ul>
        </div>
    </div>
</section>

<div class="heading-content-div"><p style="text-align: center;"><h1 style="font-size: 30px; color: #263388;text-align:center">Testimonails</h1></p></div>


<section id="single_product_col1">
    <div class="container-fluid site-container">

        <div class="col-xs-12 testimonial_main_div">
            <div class="col-xs-12  testimonial_main_div-left padding-zero">

                <?php
                $imageP = '';
                foreach ($testimonial as $value) {
                ?>
                    <div class="col-xs-12 col-sm-6 testimonial_div">
                        <ul class="test-ul">
                            <li class="img-smile">
                                <img src="images/test-smile.png" alt="" class="img-responsive">
                            </li>
                            <li class="test_desc">
                                <?= $value['testimonial'] ?>
                            </li>

                            <li>
                                <a style="color:inherit;">
                                    <p><?= $value['name']; ?></p>
                                </a>
                                <span>
                                    <?= $value['address']; ?>
                                </span>

                            </li>

                        </ul>
                    </div>

                <?php } ?>

            </div>

        </div>
</section>