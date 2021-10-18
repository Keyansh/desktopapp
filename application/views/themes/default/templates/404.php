<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">

<head>
    <?php $this->load->view('themes/' . THEME . '/layout/inc-analytic.php'); ?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php echo cms_meta_tags(); ?>
    <?php $this->load->view("themes/" . THEME . "/meta/meta_index.php"); ?>
    <base href="<?php echo cms_base_url(); ?>" />
    <?php
    $this->load->view("themes/" . THEME . "/headers/global.php");
    echo cms_head();
    echo cms_css();
    echo cms_js();
    $this->load->view("themes/" . THEME . "/layout/inc-before-head-close.php");
    ?>
    <style>
        #page-not-found-section .page-not-found-main-col img {
            max-width: 425px;
            margin: auto;
        }

        #page-not-found-section .page-not-found-main-col>a {
            font-size: 20px;
            color: black;
            background: #ff6c00;
            padding: 10px 50px;
            text-decoration: none;
        }

        #page-not-found-section .page-not-found-main-col {
            text-align: center;
            padding-bottom: 45px;
        }
    </style>
</head>

<body>

    <header id="header">
        <?php $this->load->view("themes/" . THEME . "/layout/inc-header.php"); ?>
    </header>
    <div class="wrapper">
        <section id="common-banner-section">
            <div class="container-fluid">
                <div class="common-banner-section col-xs-12 padding-zero">
                    <div class="common-inner-div">
                        <img src="images/default-wide.jpg" data-src="images/join-us-banner.jpg" alt="banner-alt" class="common-img img-responsive ">
                    </div>
                </div>
            </div>
        </section>
        <section id="single_product_col">
            <div class="container-fluid null-padding site-container">
                <div class="col-xs-12 product_main_div null-padding">
                    <ul class="breadcrumb about_page">
                        <li><a href="<?= base_url() ?>">Home</a></li>
                        <li class="active"><a href="javascript:void(0)"><?= $page['title'] ?></a></li>
                    </ul>
                </div>
                <div class="col-xs-12 about_us_content">
                    <?php // $this->cmscore->block('block_main'); 
                    ?>
                    <?php
                    if (isset($contents)) {
                        echo $contents;
                    }
                    ?>
                </div>
            </div>
        </section>
        <section id="latest-project">
            <?php $this->load->view('themes/' . THEME . '/layout/inc-latest-projects'); ?>
        </section>

        <?php $this->load->view('themes/' . THEME . '/layout/inc-testimonals'); ?>

    </div>
    <footer id="footer-section">
        <?php $this->load->view('themes/' . THEME . '/layout/inc-footer.php'); ?>
    </footer>
    <?php $this->load->view("themes/" . THEME . "/layout/inc-before-body-close.php"); ?>
</body>

</html>