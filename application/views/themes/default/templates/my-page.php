<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">

<head>
    <?php $this->load->view('themes/' . THEME . '/layout/inc-analytic.php'); ?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php
    if (isset($meta_title)) {
    ?>
        <title><?php echo $meta_title; ?></title>
        <meta name="description" content="<?php echo $meta_title; ?>" />
    <?php
    } else {
        echo cms_meta_tags();
    }
    ?>
    <?php $this->load->view('themes/' . THEME . '/meta/meta_index.php'); ?>
    <base href="<?php echo cms_base_url(); ?>" />
    <?php
    $this->load->view('themes/' . THEME . '/headers/global.php');
    echo cms_head();
    echo cms_css();
    echo cms_js();
    $this->load->view('themes/' . THEME . '/layout/inc-before-head-close.php');
    ?>
    <style>
        .home-page-header {
            margin-top: 40px;
            margin-bottom: -268px;
        }

        #header_section {
            padding: 0;
        }

        .spacer-column {
            display: none;
        }

        @media(max-width:767px) {
            .home-page-header {
                margin-top: 0;
                margin-bottom: 0;
            }
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
                    <h1 style="display:none"><?= $page['title'] ?></h1>
                        <?php if (isset($page['page_banner']) == '') { ?>
                            <img src="images/default-wide.jpg" data-src="images/join-us-banner.jpg" alt="banner-alt" class="common-img img-responsive ">
                        <?php } else { ?>
                            <img src="images/default-wide.jpg" data-src="<?php echo $this->config->item('PAGE_BANNER_URL') . $page['page_banner'] ?>" alt="banner-alt" class="common-img img-responsive ">
                        <?php } ?>
                    </div>
                </div>
            </div>
        </section>
        <section id="bredcrumbs">
            <div class=" container-fluid site-container">
                <div class="col-xs-12 product_main_div null-padding">
                    <ul class="breadcrumb about_page">
                        <li><a href="<?= base_url() ?>">Home</a></li>
                        <?= breadcrumb_navigation()  ?>
                    </ul>
                </div>
            </div>
        </section>
        <?php if (isset($category) && $category) { ?>
            <?php $this->load->view('themes/' . THEME . '/layout/inc-category-assigned-template'); ?>
        <?php } ?>

        <?php if (isset($page_blocks) && $page_blocks) { ?>
            <section>


                <div class="container-fluid ">
                    <!-- <div class="inner-container-fluid"> -->

                    <?php foreach ($page_blocks as $item) {
                        $row_style_str = '';
                        $full_width_cls = '';
                        $bg_image = '';
                        $row_styles_config = json_decode($item['style_config'], true);
                        if (isset($row_styles_config) && $row_styles_config['full_width']) {
                            $full_width_cls = 'full-width-row';
                        }
                        if (isset($row_styles_config) && $row_styles_config['background_color']) {
                            $row_style_str .= "background-color: " . $row_styles_config['background_color'];
                        }
                        if (isset($row_styles_config) && $row_styles_config['image']) {
                            // $row_style_str = "background-image: url(".$row_styles_config['image'].");";
                            $bg_image = $row_styles_config['image'];
                            if ($row_styles_config['background_style']) {
                                $row_style_str .= "background-size: " . $row_styles_config['background_style'] . ";";
                            }
                        }
                    ?>


                        <div data-src="<?php echo $bg_image; ?>" style="<?php echo $row_style_str; ?>" class="lazyload col-xs-12 my_page_grid <?php echo $full_width_cls; ?> cls_<?php echo $item['id'] . $item['page_id']; ?>">
                            <div class="site-container">
                                <?php if ($item['element_config']) { ?>
                                    <?php
                                    $moduleData = [];
                                    $moduleData['module_item'] = $item;
                                    $this->load->view('themes/' . THEME . '/layout/inc-module-layout', $moduleData);
                                    ?>
                                <?php } else { ?>

                                    <?php foreach ($item['blockElement'] as $item1) {
                                        $style_str = '';
                                        if ($item1['element_alias'] == 'spacer') {
                                            foreach (json_decode($item1['content_config'], true) as $property => $property_value) {
                                                $style_str .= "$property: $property_value" . "px";
                                            }
                                        }
                                    ?>
                                        <div style="<?php echo $style_str; ?>" class="cls_<?php echo $item1['id'] . $item1['row_id'] . $item1['page_id']; ?> <?php if (!$item1['element_id']) { ?> dottedline plus-main-div <?php } ?>  <?= $item['layout_type'] ?>">
                                            <?php if ($item1['element_alias'] == 'slider') {  ?>
                                                <?php
                                                $moduleConfig = json_decode($item1['content_config'], true);
                                                $moduleConfig['element_table'] = 'slideshow_image';

                                                $moduleData = getModuleData($moduleConfig);

                                                ?>
                                                <div class="slider-main-div">
                                                    <div id="slider-<?= $moduleConfig['slider_id'] . '-' . $item1['id'] ?>" class="owl-carousel owl-theme slider-navigation">
                                                        <?php foreach ($moduleData as $moduleItem) { ?>
                                                            <div class="item">
                                                                <div class="slider-content-main-div">
                                                                    <a href="<?= $moduleItem['link'] ? $moduleItem['link'] : 'javascript:void(0)' ?>" <?= $moduleItem['new_window'] == 1 && $moduleItem['link'] ? 'target="_blank"' : '' ?>>
                                                                        <img src="<?php echo $this->config->item('SLIDESHOW_IMAGE_URL') . $moduleItem['slideshow_image']; ?>" alt="" class="img-responsive">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <script>
                                                    $('#slider-<?= $moduleConfig['slider_id'] . '-' . $item1['id'] ?>').owlCarousel({
                                                        loop: <?php echo  $moduleConfig['loop'] ? $moduleConfig['loop'] : 'false' ?>,
                                                        margin: 0,
                                                        nav: <?php echo  $moduleConfig['nav'] ? $moduleConfig['nav'] : 'false' ?>,
                                                        dots: <?php echo  $moduleConfig['dots'] ? $moduleConfig['dots'] : 'false' ?>,
                                                        responsive: {
                                                            0: {
                                                                items: <?= $moduleConfig['display_on_mobile'] ?>
                                                            },
                                                            768: {
                                                                items: <?= $moduleConfig['display_on_tablets'] ?>
                                                            },
                                                            992: {
                                                                items: <?= $moduleConfig['display_on_web'] ?>
                                                            }
                                                        }
                                                    })
                                                </script>
                                            <?php }  ?>
                                            <?php if ($item1['element_alias'] == 'form') {  ?>
                                                <?php $data['data'] = json_decode($item1['content_config']);
                                                $this->load->view('themes/default/layout/inc-dynamic-form', $data) ?>
                                            <?php }  ?>
                                            <?php if ($item1['element_alias'] == 'project') {  ?>
                                                <style>
                                                    #latest-project {
                                                        display: none;
                                                    }
                                                </style>
                                                <div class="col-xs-12 project-listing-main-col padding-zero ">
                                                    <?php
                                                    $moduleConfig = json_decode($item1['content_config'], true);
                                                    $project =  listAllProjects();
                                                    foreach ($project as $item12) {
                                                    ?>
                                                        <p class="prject-category-title">
                                                            <?= $item12['name'] ?>
                                                        </p>

                                                        <div class="owl-carousel owl-theme projectSlider">
                                                            <?php
                                                            foreach ($item12['project'] as $innerItem) {
                                                            ?>
                                                                <div class="item">
                                                                    <div class=" project-single-col  ">
                                                                        <a href="projects/details/<?php echo $innerItem['projects_alias']; ?>">
                                                                            <div class="project-img-div">
                                                                                <?php //$image = getMainImage($innerItem['projects_id']);  
                                                                                ?>
                                                                                <?php $image = $innerItem['projects_image'];  ?>
                                                                                <?php
                                                                                $img = 'images/news-default.png';
                                                                                if ($image) {
                                                                                    $img = $this->config->item('PROJECTS_IMAGE_URL') . $image;
                                                                                }
                                                                                ?>
                                                                                <img src="<?= $img ?>" alt="<?php echo $innerItem['projects_title']; ?>" class="img-responsive">
                                                                            </div>
                                                                            <p class="project-title">
                                                                                <?php echo $innerItem['projects_title']; ?>
                                                                            </p>
                                                                        </a>
                                                                    </div>

                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                <script>
                                                    $('.projectSlider').owlCarousel({
                                                        loop: <?php echo  $moduleConfig['loop'] ? $moduleConfig['loop'] : 'false' ?>,
                                                        margin: 3,
                                                        nav: true,
                                                        dots: false,
                                                        responsive: {
                                                            0: {
                                                                items: <?= $moduleConfig['display_on_mobile'] ?>
                                                            },
                                                            768: {
                                                                items: <?= $moduleConfig['display_on_tablets'] ?>
                                                            },
                                                            992: {
                                                                items: <?= $moduleConfig['display_on_web'] ?>
                                                            }
                                                        }
                                                    })
                                                </script>
                                            <?php }  ?>
                                            <?php if ($item1['element_id']) { ?>
                                                <?php
                                                echo createElementHtml1($item1['page_id'], $item1['row_id'], $item1['element_id'], $item1['content_config']);
                                                ?>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>

                                <?php } ?>

                            </div>
                        </div>

                    <?php } ?>

                    <!-- </div> -->
                </div>
            </section>
        <?php } ?>
        <section id="latest-project">
            <?php $this->load->view('themes/' . THEME . '/layout/inc-latest-projects'); ?>
        </section>

        <?php $this->load->view('themes/' . THEME . '/layout/inc-testimonals'); ?>

    </div>
    <footer id="footer-section">
        <?php $this->load->view('themes/' . THEME . '/layout/inc-footer.php'); ?>
    </footer>
    <?php $this->load->view('themes/' . THEME . '/layout/inc-before-body-close.php'); ?>
</body>

</html>