<?php
$customer = array();
$customer = $this->memberauth->checkAuth();

if (isset($keywords)) {
    $keywords = $keywords;
} else {
    $keywords = '';
}
?>
<?php $headerFooter = header_and_footer(); ?>


<?php if ($headerFooter['header_style'] == '1') { ?>
    <div id="header-section" class="header-1">
        <div class="container-fluid inner-container-fluid site-container">
            <div class="header-section col-xs-12 padding-zero">
                <div class="header-main col-xs-12 ">
                    <a href="<?= base_url() ?>"><img src="<?= $this->config->item('CONTACT_US_FILE_URL') . DWS_LOGO ?>" alt="logo" class="header-logo img-responsive"></a>
                </div>
                <div class="header-inner-div col-xs-12 ">
                    <div class="header-top col-xs-12">
                        <div class="header-left-div col-xs-12 ">
                            <?php
                            $params = array(
                                'menu_alias' => 'header-menu',
                                'ul_format' => '<ul class="header-navbar list-inline line-div">{MENU}</ul>',
                                'level_1_format' => '<a class="dropdown-toggle home-link "  href="{HREF}"{ADDITIONAL}>{LINK_NAME}</a>',
                                'level_2_format' => '<a class="dropdown-toggle " href="{HREF}"{ADDITIONAL}>{LINK_NAME}</a>',
                            );
                            echo cms_menu($params);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($headerFooter['header_style'] == '2') { ?>
    <div class="header-2">
        <div class="container-fluid site-container inner-container-fluid">
            <div class="header-section-2 col-xs-12">
                <div class="logo-main-div col-xs-12 col-sm-3">
                    <a href="<?= base_url() ?>">
                        <img src="<?= $this->config->item('CONTACT_US_FILE_URL') . DWS_FOOTER_LOGO ?>" alt="Logo" class="main-logo">
                    </a>
                </div>
                <div class="header-inner-div-2 col-xs-12">
                    <div class="header-top-2 col-xs-12">
                        <div class="header-left-div-2  col-xs-12">
                            <?php
                            $params = array(
                                'menu_alias' => 'header-menu',
                                'ul_format' => '<ul class="header-navbar list-inline ">{MENU}</ul>',
                                'level_1_format' => '<a class="dropdown-toggle home-link "  href="{HREF}"{ADDITIONAL}>{LINK_NAME}</a>',
                                'level_2_format' => '<a class="dropdown-toggle " href="{HREF}"{ADDITIONAL}>{LINK_NAME}</a>',
                            );
                            echo cms_menu($params);
                            ?>
                        </div>
                        <div class="header-right-div-2  col-xs-12">
                            <ul class="header-nav-number">
                                <li>
                                    <a href="tel:<?= DWS_TELLNO ?>" class="tel-link like-link">
                                        <img src="images/mob.png" alt="tel-alt" class="mob-img">
                                        <?= DWS_TELLNO ?> </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($headerFooter['header_style'] == '3') { ?>
    <div class="header-3">
        <div class="header-3-top">
            <div class="container-fluid site-container">
                <div class="header-top-inner col-xs-12 padding-zero">
                    <ul class="header-bar list-inline">
                        <li class="mail-link-div">
                            <a href="mailto:<?= DWS_EMAIL_ADMIN ?>" class="mail-link"><i class="fa fa-envelope-o mail-icon" aria-hidden="true"></i> Email: <?= DWS_EMAIL_ADMIN ?></a>
                        </li>
                        <li class="login-div">
                            <?php
                            if ($customer['user_id'] && $customer['user_is_active']) {
                            ?>
                                <a class="login-text" href="customer/dashboard">
                                    <!-- <i class="fa fa-sign-in" aria-hidden="true" title="Logged in"></i> -->
                                    <i class="log-ou-hom">Welcome <?= $customer['last_name'] ?></i>
                                </a>
                            <?php
                            } else {
                            ?>
                                <a href="customer/login" class="login-text"><img class="img-responsive" src="images/lock.png" alt="lock">
                                    Login</a>
                            <?php
                            }
                            ?>
                            <?php
                            if ($customer['user_id'] && $customer['user_is_active']) {
                            ?>
                                <a class="login-text" href="customer/logout">
                                    <i class="fa fa-sign-in" aria-hidden="true" title="Logged in"></i>
                                    <i class="log-ou-hom">Logout</i>
                                </a>
                            <?php
                            } else {
                            ?>
                                <a href="customer/register" class="login-text"><img class="img-responsive" src="images/profile.png" alt="lock">
                                    Register</a>
                            <?php
                            }
                            ?>

                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container-fluid site-container">
            <div class="header-section col-xs-12 padding-zero">
                <div class="header-bottom-inner col-xs-12 padding-zero">
                    <div class="nav-logo-outer col-xs-12 col-sm-3 padding-zero">
                        <a href="<?= base_url() ?>"> <img class="header-logo" src="<?= $this->config->item('CONTACT_US_FILE_URL') . DWS_LOGO ?>" alt="logo"></a>
                    </div>
                    <div class="nav-bottom col-xs-12 col-sm-9 padding-zero menu-close">
                        <div class="menu-changes-icon">
                            <div class="menu-bars"><span></span> <span></span> <span></span></div>
                            <?php
                            $params = array(
                                'menu_alias' => 'header-menu',
                                'ul_format' => '<ul class="header-wishlist-div list-inline line-div">{MENU}</ul>',
                                'level_1_format' => '<a class="dropdown-toggle home-link "  href="{HREF}"{ADDITIONAL}>{LINK_NAME}</a>',
                                'level_2_format' => '<a class="dropdown-toggle " href="{HREF}"{ADDITIONAL}>{LINK_NAME}</a>',
                            );
                            echo cms_menu($params);
                            ?>
                        </div>
                        <ul class="list-inline menu-left-header">
                            <li><a href="cart" class="wish-rate"><img src="images/wishlist.png" alt="wish-alt" class="wishlist-img"> <span class="wish-div">Wishlist (<span class="count-of-wishlist"><?= count($this->cart->contents()) ?></span>)</span> </a></li>
                            <li>
                                <img class="header-search-img img-responsive" src="images/search.jpg" data-toggle="modal" data-target="#searchModal" alt="lock">
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>





<div class="icon-bar">
    <?php if (DWS_FACEBOOK_ACCOUNT) { ?>
        <a href="<?= DWS_FACEBOOK_ACCOUNT ?>" target="_blank" class="facebook"><i class="fa fa-facebook"></i></a>
    <?php } ?>
    <?php if (DWS_TWITTER_ACCOUNT) { ?>
        <a href="<?= DWS_TWITTER_ACCOUNT ?>" target="_blank" class="twitter"><i class="fa fa-twitter"></i></a>
    <?php } ?>
    <?php if (DWS_LINKEDIN_ACCOUNT) { ?>
        <a href="<?= DWS_LINKEDIN_ACCOUNT ?>" target="_blank" class="linkedin"><i class="fa fa-linkedin"></i></a>
    <?php } ?>
    <?php if (DWS_INSTAGRAM_ACCOUNT) { ?>
        <a href="<?= DWS_INSTAGRAM_ACCOUNT ?>" target="_blank" class="instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a>
    <?php } ?>
    <?php if (DWS_PINTEREST_ACCOUNT) { ?>
        <a href="<?= DWS_PINTEREST_ACCOUNT ?>" target="_blank" class="pinterest"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
    <?php } ?>
</div>

<script>
    // var CURRENT_URL = '<?= current_url() ?>';
    // $(function() {
    //     var url = window.location.pathname,
    //         urlRegExp = new RegExp(url.replace(/\/$/, '') + "$");
    //     $('.header-wishlist-div > li > a').each(function() {
    //         if (urlRegExp.test(this.href.replace(/\/$/, ''))) {
    //             if (DWS_BASE_URL != CURRENT_URL) {
    //                 $(this).addClass('active');
    //             }
    //         }
    //     });
    // });

    $(document).ready(function() {
        if ($(window).width() > 768) {
            if ($(".header-wishlist-div li .catmenu-menu")) {
                $('.catmenu-menu').parent('li').addClass('iconhover');
            }
        }
        if ($(window).width() < 768) {

            var appendBtn = "<span class='minimizeBtn'>+</span>";
            var sibList = $('.dropdown').find('.catmenu-menu').parent('li').append(appendBtn);
            $('.minimizeBtn').click(function(e) {
                e.stopPropagation();
                $(this).parent('.dropdown').find('.catmenu-menu').toggleClass('active');
                if ($(this).text() == '+') {
                    $(this).text('-');
                } else {
                    $(this).text('+');
                    // $(this).parents(".tree-ul-li").siblings().find('active').removeClass("active");
                    $(this).parents(".tree-ul-li").find('.tree-ul-li').removeClass("active");
                    $(this).parents(".tree-ul-li").find('.tree-ul-li').find('.minimizeBtn').text('+');
                }
            });

        }
    })
</script>
<script>
    var url = window.location.href;
    $(function() {
        urlRegExp = new RegExp(url.replace(/\/$/, '') + "$"); // create regexp to match current url pathname and remove trailing slash if present as it could collide with the link in navigation in case trailing slash wasn't present there
        // now grab every link from the navigation
        $('.header-wishlist-div > li > a').each(function() {
            // and test its normalized href against the url pathname regexp
            if (urlRegExp.test(this.href.replace(/\/$/, ''))) {
                var elm = $(this).parent();
                if (url != DWS_BASE_URL) {
                    $(elm).addClass('active');
                }
            }
        });
    });

    $(window).scroll(function() {
        var scroll = $(window).scrollTop();

        if (scroll >= 128) {
            $("#header").addClass("headerSticky");
        } else {
            $("#header").removeClass("headerSticky");
        }
    });
</script>

<script>
    $(".menu-bars").click(function() {
        $('.nav-bottom').toggleClass("menu-open menu-close");
    });
</script>