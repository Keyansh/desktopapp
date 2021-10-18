<?php $headerFooter = header_and_footer(); ?>
<?php if ($headerFooter['footer_style'] == '1') { ?>
    <div class="container-fluid footer-1-main-div">
        <div class="footer-section">
            <div class="site-container">

                <div class="parent-service col-xs-12 col-sm-3">
                    <img src="<?= $this->config->item('CONTACT_US_FILE_URL') . DWS_FOOTER_LOGO ?>" alt="footer-logo" class="img-responsive">
                    <p class="footer-text"><?= DWS_COMON_BLOCK ?></p>
                </div>

                <div class="info-parent  col-xs-12 col-sm-3 ">
                    <p class="footer-text-title">
                        Quick link
                    </p>
                    <div class="services-links1 services-links">
                        <?php
                        $params = array(
                            'menu_alias' => 'footer-menu',
                            'ul_format' => '<ul class="list-unstyled">{MENU}</ul>',
                            'level_1_format' => '<a class="service1" href="{HREF}"{ADDITIONAL}>{LINK_NAME}</a>',
                            'level_2_format' => '<a class="service1" href="{HREF}"{ADDITIONAL}>{LINK_NAME}</a>',
                        );
                        echo cms_menu($params);
                        ?>
                    </div>
                </div>


                <div class=" col-xs-12 col-sm-3">
                    <p class="footer-text-title">
                        About us
                    </p>
                    <div class="services-links3 services-links">
                        <?php
                        $params = array(
                            'menu_alias' => 'about-us',
                            'ul_format' => '<ul class="list-unstyled">{MENU}</ul>',
                            'level_1_format' => '<a class="service1" href="{HREF}"{ADDITIONAL}>{LINK_NAME}</a>',
                            'level_2_format' => '<a class="service1" href="{HREF}"{ADDITIONAL}>{LINK_NAME}</a>',
                        );
                        echo cms_menu($params);
                        ?>
                    </div>
                </div>

                <div class=" col-xs-12 col-sm-3">
                    <div class="services-links3 services-links">
                        <div class="services-links1 services-links">
                            <p class="footer-text-title">
                                Social Media
                            </p>
                            <ul class="footer-social-ul list-inline">
                                <?php if (DWS_FACEBOOK_ACCOUNT) { ?>
                                    <li class="social-link">
                                        <a href="<?= DWS_FACEBOOK_ACCOUNT ?>">
                                            <i class="fa fa-facebook" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (DWS_TWITTER_ACCOUNT) { ?>
                                    <li class="social-link">
                                        <a href="<?= DWS_TWITTER_ACCOUNT ?>">
                                            <i class="fa fa-twitter" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (DWS_LINKEDIN_ACCOUNT) { ?>
                                    <li class="social-link">
                                        <a href="<?= DWS_LINKEDIN_ACCOUNT ?>">
                                            <i class="fa fa-linkedin" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (DWS_INSTAGRAM_ACCOUNT) { ?>
                                    <li class="social-link">
                                        <a href="<?= DWS_INSTAGRAM_ACCOUNT ?>">
                                            <i class="fa fa-instagram" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (DWS_PINTEREST_ACCOUNT) { ?>
                                    <li class="social-link">
                                        <a href="<?= DWS_PINTEREST_ACCOUNT ?>">
                                            <i class="fa fa-pinterest" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="last-text col-xs-12 col-sm-12 padding-zero">
            <div class="last-text-inner">
                <div class="last-text-left col-xs-12 ">
                    All rights reserved. Terms and Conditions Apply.
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($headerFooter['footer_style'] == '2') { ?>
    <div class="container-fluid footer-2-mai-div">
        <div class="footer-inner-first">
            <div class="footer1 site-container padding-zero">
                <div class="col-xs-12 col-sm-3 fa1">
                    <div class="footer-img">
                        <img src="<?= $this->config->item('CONTACT_US_FILE_URL') . DWS_FOOTER_LOGO ?>" alt="footer-logo" class="img-responsive">
                    </div>
                    <div class="footer-content">
                        <?= DWS_COMON_BLOCK ?>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3 fb1">
                    <div class="col-xs-12 fb1-inner">
                        <p class="footer-text-title">
                            About us
                        </p>
                        <div class="footer-menu">
                            <?php
                            $params = array(
                                'menu_alias' => 'about-us',
                                'ul_format' => '<ul class="list-unstyled about-us-footer-menu">{MENU}</ul>',
                                'level_1_format' => '<a class="service1" href="{HREF}"{ADDITIONAL}>{LINK_NAME}</a>',
                                'level_2_format' => '<a class="service1" href="{HREF}"{ADDITIONAL}>{LINK_NAME}</a>',
                            );
                            echo cms_menu($params);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3 fc1">
                    <div class="col-xs-12 fc1-inner">
                        <p class="footer-text-title">
                            Contact
                        </p>

                        <div class="contect-info">
                            <ul class="footer-info list-inline">
                                <?php if (DWS_ADDRESS) { ?>
                                    <li class="footer-info-a">
                                        <?= DWS_ADDRESS ?>
                                    </li>
                                <?php } ?>
                                <?php if (DWS_TELLNO) { ?>
                                    <li class="footer-info-b">
                                        <a href="tel:<?= DWS_TELLNO ?>"><?= DWS_TELLNO ?></a>
                                    </li>
                                <?php } ?>
                                <?php if (DWS_EMAIL_ADMIN) { ?>
                                    <li class="footer-info-c">
                                        <a href="mailto:<?= DWS_EMAIL_ADMIN ?>"><?= DWS_EMAIL_ADMIN ?></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3 fd1">
                    <div class="col-xs-12 fd1-inner">
                        <p class="footer-text-title">
                            Social Media
                        </p>
                        <div class="footer-media">
                            <ul class="footer-social-ul list-inline">
                                <?php if (DWS_FACEBOOK_ACCOUNT) { ?>
                                    <li class="social-link">
                                        <a href="<?= DWS_FACEBOOK_ACCOUNT ?>">
                                            <i class="fa fa-facebook" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (DWS_TWITTER_ACCOUNT) { ?>
                                    <li class="social-link">
                                        <a href="<?= DWS_TWITTER_ACCOUNT ?>">
                                            <i class="fa fa-twitter" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (DWS_LINKEDIN_ACCOUNT) { ?>
                                    <li class="social-link">
                                        <a href="<?= DWS_LINKEDIN_ACCOUNT ?>">
                                            <i class="fa fa-linkedin" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (DWS_INSTAGRAM_ACCOUNT) { ?>
                                    <li class="social-link">
                                        <a href="<?= DWS_INSTAGRAM_ACCOUNT ?>">
                                            <i class="fa fa-instagram" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (DWS_PINTEREST_ACCOUNT) { ?>
                                    <li class="social-link">
                                        <a href="<?= DWS_PINTEREST_ACCOUNT ?>">
                                            <i class="fa fa-pinterest" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-inner-two">
            <div class="footer-inner-two-inner inner-container-fluid">
                <p class="footer-text-align">All rights reserved. Terms and Conditions Apply.</p>
            </div>
        </div>
    </div>

<?php } ?>



<?php if ($headerFooter['footer_style'] == '3') { ?>

    <div class="footer-section footer-3-main-div">
        <div class="site-container">
            <div class="col-xs-12 footer-3-inner-div padding-zero">
                <div class="parent-service col-xs-12 col-sm-3">
                    <img src="<?= $this->config->item('CONTACT_US_FILE_URL') . DWS_FOOTER_LOGO ?>" alt="footer-logo" class="img-responsive">
                    <?php if (DWS_ADDRESS) { ?>
                        <div class="footer-3-address">
                            <?= DWS_ADDRESS ?>
                        </div>
                    <?php } ?>
                   
                </div>
                <div class=" col-xs-12 col-sm-3">
                    <p class="footer-text-title">
                        About us
                    </p>
                    <div class="services-links3 services-links">
                        <?php
                        $params = array(
                            'menu_alias' => 'about-us',
                            'ul_format' => '<ul class="list-unstyled">{MENU}</ul>',
                            'level_1_format' => '<a class="service1" href="{HREF}"{ADDITIONAL}>{LINK_NAME}</a>',
                            'level_2_format' => '<a class="service1" href="{HREF}"{ADDITIONAL}>{LINK_NAME}</a>',
                        );
                        echo cms_menu($params);
                        ?>
                    </div>
                </div>
                <div class="download-links-text-div col-xs-12 col-sm-3">
                    <div class="services-links3 services-links">
                        <div class="services-links1 services-links">
                            <!-- <p class="footer-text-title">
                                PROJECTS
                            </p> -->
                            <div class="services-links1 services-links">
                                <?php
                                $params = array(
                                    'menu_alias' => 'projects',
                                    'ul_format' => '<ul class="list-unstyled">{MENU}</ul>',
                                    'level_1_format' => '<a class="service1" href="{HREF}"{ADDITIONAL}>{LINK_NAME}</a>',
                                    'level_2_format' => '<a class="service1" href="{HREF}"{ADDITIONAL}>{LINK_NAME}</a>',
                                );
                                echo cms_menu($params);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="info-parent  col-xs-12 col-sm-3 mobile-footer">
                    <!-- <p class="footer-text-title" style="color: transparent;opacity: 0;">
                        Quick link
                    </p>
                    <div class="services-links1 services-links">
                        <?php
                        $params = array(
                            'menu_alias' => 'product-range-2',
                            'ul_format' => '<ul class="list-unstyled">{MENU}</ul>',
                            'level_1_format' => '<a class="service1" href="{HREF}"{ADDITIONAL}>{LINK_NAME}</a>',
                            'level_2_format' => '<a class="service1" href="{HREF}"{ADDITIONAL}>{LINK_NAME}</a>',
                        );
                        echo cms_menu($params);
                        ?>
                    </div> -->
                    <ul class="footer-3-social-ul list-inline">
                        <?php if (DWS_FACEBOOK_ACCOUNT) { ?>
                            <li class="social-link">
                                <a href="<?= DWS_FACEBOOK_ACCOUNT ?>">
                                    <img src="images/fbfooter.png" class="img-responsive" alt="facebook">
                                </a>
                            </li>
                        <?php } ?>
                        <?php if (DWS_TWITTER_ACCOUNT) { ?>
                            <li class="social-link">
                                <a href="<?= DWS_TWITTER_ACCOUNT ?>">
                                    <img src="images/twitterfooter.png" class="img-responsive" alt="twitter">
                                </a>
                            </li>
                        <?php } ?>
                        <?php if (DWS_LINKEDIN_ACCOUNT) { ?>
                            <li class="social-link">
                                <a href="<?= DWS_LINKEDIN_ACCOUNT ?>">
                                    <img src="images/linkedInfooter.png" class="img-responsive" alt="linked in">
                                </a>
                            </li>
                        <?php } ?>
                        <?php if (DWS_INSTAGRAM_ACCOUNT) { ?>
                            <li class="social-link">
                                <a href="<?= DWS_INSTAGRAM_ACCOUNT ?>">
                                    <img src="images/instafooter.png" class="img-responsive" alt="instagram">
                                </a>
                            </li>
                        <?php } ?>
                        <?php if (DWS_PINTEREST_ACCOUNT) { ?>
                            <li class="social-link">
                                <a href="<?= DWS_PINTEREST_ACCOUNT ?>">
                                    <img src="images/pintrestfooter.png" class="img-responsive" alt="pinterest">
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="info-parent  col-xs-12 col-sm-3 ">
                    <!-- <p class="footer-text-title">
                        PRODUCT RANGE
                    </p> -->
                    <div class="services-links1 services-links">
                        <?php
                        $params = array(
                            'menu_alias' => 'product-range',
                            'ul_format' => '<ul class="list-unstyled">{MENU}</ul>',
                            'level_1_format' => '<a class="service1" href="{HREF}"{ADDITIONAL}>{LINK_NAME}</a>',
                            'level_2_format' => '<a class="service1" href="{HREF}"{ADDITIONAL}>{LINK_NAME}</a>',
                        );
                        echo cms_menu($params);
                        ?>
                    </div>
                </div>

                
                
            </div>
        </div>
    </div>
    <div class="last-text col-xs-12 col-sm-12 footer-3-inner-div-last-main">
        <div class="site-container">
            <div class="last-text-left footer-3-inner-div-last col-xs-12 ">
                © 2017-<?= date('Y') ?> Consort LTD. Trademarks and brands are the property of their respective owners
            </div>
        </div>
    </div>

<?php } ?>

<style>
    .video-player-col+iframe,
    .play-video-btn iframe {
        display: none;
    }
</style>
<div id="videoModel" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="videodata">
                    <iframe class="responsive-iframe" src=""></iframe>
                </div>
            </div>
        </div>

    </div>
</div>

<div id="logInPop" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">
                <div class="main-pop-up-div">
                    <p class="product-to-view">To view Product </p>
                    <p class="already-view">Please <a class="login-pop-link" href="customer/login">Login</a> if you are already a member or <a class="register-pop-link" href="customer/register">Signup </a> now</p>
                </div>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div> -->
        </div>

    </div>
</div>
<div id="searchModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <form id="search_key" action="search" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn btn-default common-btn popup-close-div" data-dismiss="modal">x</button>
                    <p> Search</p>
                </div>
                <div class="modal-body">
                    <div class="header-search">
                        <div class="inner clear-parent">
                            <input type="text" class="form-control textfiled_search" placeholder="Search name, product, code..." id="keyword_string" value="<?= $keywords ?>" name="keywords" type="text" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-default common-btn "> submit</button>

                </div>
            </div>
        </form>
    </div>

</div>
<script>
    $(window).ready(function() {
        setTimeout(function() {
            $(".loader-footer").hide();
        }, 1000);
    });
</script>

<?php if ($this->session->userdata('CUSTOMER_ID')) : ?>
    <script>
        $(document).on('click', '.userlog', function(e) {
            e.preventDefault();
            var id = $(this).attr('data-id');
            var type = $(this).attr('data-type');
            var link = $(this).attr('href');
            $.ajax({
                type: 'POST',
                url: "<?= base_url() ?>cms/userlog",
                data: {
                    'id': id,
                    'type': type,
                },
                success: function(data) {
                    window.location.replace(link);
                }
            });
        });
    </script>
<?php endif ?>