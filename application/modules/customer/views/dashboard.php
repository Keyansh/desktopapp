<style>
    .user-imgdata img {
        border-radius: 50%;
        width: 102px;
        margin: auto;
    }
</style>
<section id="single_product_col">
    <div class="container-fluid site-container null-padding">
        <div class="col-xs-12 product_main_div null-padding">
            <ul class="breadcrumb about_page">
                <li><a href="<?= base_url() ?>">Home</a></li>
                <li class="active"><a href="javascript:void(0)">Dashboard</a></li>
            </ul>
        </div>
    </div>
</div>
</section>
<section id="different_products">
    <div class="container-fluid site-container">
        <div class="col-xs-12 different-product-col">
            <?php $this->load->view('navigation'); ?>
            <div class="col-xs-12 col-md-10 col-sm-10 col-lg-10 different_pro_right-col wishlist_col">
                <div class="col-xs-12  different_pro_right-col wishlist-section">
                    <section id="top_rated_products">
                        <div class="container-fluid">
                            <div class="col-xs-12 products_col null-padding">
                                <div class="text-center site-font">
                                    <div class="user-imgdata">
                                        <img src="images/u-default.png" class="img-responsive"/>
                                        <!-- <p>Welcome <span><?= $customer['first_name'] . ' ' . $customer['last_name']; ?></span></p> -->
                                    </div>
                                    <h1 class="after-registration">Welcome <?php echo $customer['first_name'] . ' ' . $customer['last_name']; ?></h1>
                                    <p class="after-registration-text">Welcome to your customer area. Use menu to navigate around.</p>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</section>
