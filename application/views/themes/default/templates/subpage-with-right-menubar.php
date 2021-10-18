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
</head>

<body>
    <header id="header">
        <?php $this->load->view("themes/" . THEME . "/layout/inc-header.php"); ?>
    </header>

    <?php if (file_exists($this->config->item('PAGE_BANNER_PATH') . $page['page_banner']) && $page['page_banner']) { ?>
        <section id="page-banner-section">
            <div class="container-fluid">
                <div class="col-xs-12 null-padding">
                    <img src="<?php echo $this->config->item('PAGE_BANNER_URL') . $page['page_banner'] ?>" class="img-responsive" />
                </div>
            </div>
        </section>
    <?php } ?>

    <section id="single_product_col">
        <div class="container-fluid site-container">
            <div class="col-xs-12 product_main_div null-padding">
                <ul class="breadcrumb about_page">
                    <li><a href="<?= base_url() ?>">Home</a></li>
                    <li class="active"><a href="javascript:void(0)"><?= $page['title'] ?></a></li>
                </ul>
            </div>
            <div class="col-xs-12 subpage-with-sidebar null-padding">
                <div class="col-xs-12 col-sm-9 page-left-content-col cms-pages-main-col">
                    <div class="col-xs-12 common-heading-col">
                        <p class="arrow-heading"><?php echo $page['title']; ?></p>
                    </div>
                    <?php
                    if (isset($contents)) {
                        echo $contents;
                    }
                    ?>
                </div>
                <div class="col-xs-12 col-sm-3 page-rightbar">
                    <?php $this->load->view('themes/' . THEME . '/layout/inc-latest-news-widget'); ?>
                </div>
            </div>
        </div>
    </section>
    <section id="latest-project">
        <?php $this->load->view('themes/' . THEME . '/layout/inc-latest-projects'); ?>
    </section>

    <?php $this->load->view('themes/' . THEME . '/layout/inc-testimonals'); ?>

    <footer id="footer-section">
        <?php $this->load->view('themes/' . THEME . '/layout/inc-footer.php'); ?>
    </footer>
    <?php $this->load->view("themes/" . THEME . "/layout/inc-before-body-close.php"); ?>
</body>

</html>