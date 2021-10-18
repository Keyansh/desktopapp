<?php //e($blockData); 
?>
<section id="plus-section">
    <div class="container-fluid">
        <div class="plus-section col-xs-12">
            <?php foreach ($blockData['blockElement'] as $item1) {
                $style_str = '';
                if ($item1['element_alias'] == 'spacer') {
                    foreach (json_decode($item1['content_config'], true) as $property => $property_value) {
                        $style_str .= "$property: $property_value" . "px";
                    }
                }
            ?>
                <div style="<?php echo $style_str; ?>" class="cls_<?php echo $item1['id'] . $item1['row_id'] . $item1['page_id']; ?> <?php if (!$item1['element_id']) { ?> dottedline plus-main-div <?php } ?>  col-xs-12 <?= $blockData['layout_type'] ?>" data-page-id="<?= $item1['page_id'] ?>" data-block-id="<?= $item1['row_id'] ?>" data-element-id="<?= $item1['id'] ?>">
                    <?php if ($item1['element_id']) { ?>
                        <ul class="list-inline column-action-list rowColActionList">
                            <li class="text-li">
                                Column:
                            </li>
                            <li class="link-item">
                                <span class="edit-option" data-element='<?php echo json_encode(getPageBuilderElementById($item1['element_id'])); ?>' data-block-item='<?php echo json_encode($item1); ?>'><i class="fa fa-pencil"></i></span>
                            </li>
                            <li class="link-item">
                                <span class="column-delete" data-delete-type="column" data-page-id="<?= $item1['page_id'] ?>" data-row-id="<?= $item1['row_id'] ?>" data-column-id="<?= $item1['id'] ?>"><i class="fa fa-trash"></i></span>
                            </li>
                        </ul>

                        <?php if ($item1['element_alias'] == 'slider') {  ?>
                            <?php
                            $moduleConfig = json_decode($item1['content_config'], true);
                            if ($moduleConfig['slider_id'] == 'category' || $moduleConfig['slider_id'] == 'projects' || $moduleConfig['slider_id'] == 'product') {
                                $moduleConfig['element_table'] = $moduleConfig['slider_id'];
                            } else {
                                $moduleConfig['element_table'] = 'slideshow_image';
                            }
                            $moduleData = getModuleData($moduleConfig);
                            ?>
                            <?php if ($moduleConfig['slider_id'] == 'category') {
                                $moduleData1 = getModuleDatacategory($moduleConfig);
                            ?>

                                <div class="slider-main-div category-slider">
                                    <div id="slider-<?= $moduleConfig['slider_id'] . '-' . $item1['id'] ?>" class="owl-carousel owl-theme slider-navigation">
                                        <?php foreach ($moduleData1 as $moduleItem) { ?>
                                            <div class="item">
                                                <div class="col-xs-12 category-slider-item">
                                                    <a href="<?= $moduleItem['uri'] ?>" class="slider-content-main-div-tag">
                                                        <div class="slider-content-main-div-img">
                                                            <img src="<?php echo $this->config->item('CATEGORY_IMAGE_URL') . $moduleItem['image']; ?>" alt="" class="img-responsive">
                                                        </div>
                                                        <div class="slider-content-main-div-content">
                                                            <p><?= $moduleItem['name'] ?></p>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($moduleConfig['slider_id'] == 'projects') {  ?>
                                <div class="slider-main-div">
                                    <div id="slider-<?= $moduleConfig['slider_id'] . '-' . $item1['id'] ?>" class="owl-carousel owl-theme slider-navigation">
                                        <?php foreach ($moduleData as $moduleItem) { ?>
                                            <div class="item">
                                                <div class="col-xs-12 projects-slider-item">
                                                    <div class="col-xs-12 col-sm-6 projects-slider-item-left">
                                                        <div class="slider-content-main-div-img">
                                                            <?php $getMainImage = getMainImage($moduleItem['projects_id']); ?>
                                                            <img src="<?php echo $this->config->item('PROJECTS_IMAGE_URL') . $getMainImage['img']; ?>" alt="" class="img-responsive">
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-6 projects-slider-item-right">
                                                        <div class="slider-content-main-div-content-left">
                                                            <p class="projects-slider-heading">
                                                                <?= $moduleItem['projects_title'] ?>
                                                            </p>
                                                            <div class="projects-slider-heading-disc">
                                                                <?= strip_tags($moduleItem['short_contents']) ?>
                                                            </div>
                                                            <p class="con-title">
                                                                Architect:
                                                            </p>
                                                            <p class="con-title-1">
                                                                <?= $moduleItem['architect'] ?>
                                                            </p>
                                                            <p class="con-title-2">
                                                                Contractor:
                                                            </p>
                                                            <p class="con-title-3">
                                                                <?= $moduleItem['contractor'] ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($moduleConfig['slider_id'] == 'product') {  ?>
                                <div class="slider-main-div">
                                    <div id="slider-<?= $moduleConfig['slider_id'] . '-' . $item1['id'] ?>" class="owl-carousel owl-theme slider-navigation">
                                        <?php foreach ($moduleData as $moduleItem) { ?>
                                            <div class="item">
                                                <div class="slider-content-main-div">
                                                    <img src="<?php echo $this->config->item('SLIDESHOW_IMAGE_URL') . $moduleItem['slideshow_image']; ?>" alt="" class="img-responsive">
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php }  ?>
                            <?php if ($moduleConfig['slider_id'] != 'category' || $moduleConfig['slider_id'] != 'projects' || $moduleConfig['slider_id'] != 'product') { ?>
                                <div class="slider-main-div">
                                    <div id="slider-<?= $moduleConfig['slider_id'] . '-' . $item1['id'] ?>" class="owl-carousel owl-theme slider-navigation">
                                        <?php foreach ($moduleData as $moduleItem) { ?>
                                            <div class="item">
                                                <div class="slider-content-main-div">
                                                    <img src="<?php echo $this->config->item('SLIDESHOW_IMAGE_URL') . $moduleItem['slideshow_image']; ?>" alt="" class="img-responsive">
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                            <script>
                                $('#slider-<?= $moduleConfig['slider_id'] . '-' . $item1['id'] ?>').owlCarousel({
                                    loop: false,
                                    margin: 0,
                                    nav: false,
                                    dots: false,
                                    mouseDrag: false,
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
                            $this->load->view('../../../application/views/themes/default/layout/inc-dynamic-form', $data) ?>

                        <?php }  ?>
                        <?php if ($item1['element_alias'] == 'project') {  ?>

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
                                                <div class="col-xs-12 project-single-col ">
                                                    <div class="project-img-div">
                                                        <?php $image = getMainImage($innerItem['projects_id']);  ?>
                                                        <?php
                                                        $img = 'images/news-default.png';
                                                        if ($image) {
                                                            $img = $this->config->item('PROJECTS_IMAGE_URL') . $image['img'];
                                                        }
                                                        ?>
                                                        <img src="<?= $img ?>" alt="<?php echo $innerItem['projects_title']; ?>" class="img-responsive">
                                                    </div>
                                                    <p class="project-title">
                                                        <?php echo $innerItem['projects_title']; ?>
                                                    </p>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <script>
                                $('.projectSlider').owlCarousel({
                                    loop: false,
                                    margin: 0,
                                    nav: false,
                                    dots: false,
                                    mouseDrag: false,
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
                        <?php if ($item1['element_alias'] == 'new_arrivals') {  ?>
                            <?php
                            $moduleConfig = json_decode($item1['content_config'], true);
                            $productData = getNewArrivalsSelectedProduct($moduleConfig);
                            // e($productData)
                            ?>
                            <?php if ($productData) { ?>
                                <section id="arrivals-section" style="display: none;">
                                    <div class="container-fluid">
                                        <div class="arrivals-section col-xs-12 padding-zero">
                                            <div class="arrrivals-inner-div col-xs-12 padding-zero">
                                                <div class="arrivals-main-div col-xs-12 col-sm-6 padding-zero">
                                                    <a href="<?= $productData['0']['uri'] ?>">
                                                        <div class="arrivals-first-div col-xs-12">
                                                            <div class="arrivals-img-div">
                                                                <?php $image = getproductMainImage($productData['0']['id']);  ?>
                                                                <?php
                                                                $img = 'images/news-default.png';
                                                                if ($image) {
                                                                    $img = $this->config->item('PRODUCT_URL') . $image['img'];
                                                                }
                                                                ?>
                                                                <img src="<?= $img ?>" alt="arrivals-alt" class="arrivals-img img-responsive" style="max-width: 311px;">
                                                            </div>
                                                            <div class="arrivals-text-div col-xs-12 padding-zero">
                                                                <p class="arrivals-heading"><?= $productData['0']['name'] ?></p>
                                                                <div class="arrivals-text"><?= $productData['0']['brief_description'] ?></div>
                                                            </div>
                                                        </div>

                                                        <div class="consort-offer-div">
                                                            <p class="consort-news-div">new</p>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="arrivals-second-div col-xs-12 col-sm-6">
                                                    <?php if ($productData['1']) { ?>
                                                        <a href="<?= $productData['1']['uri'] ?>">
                                                            <div class="arrivals-inner-main col-xs-12 ">
                                                                <div class="arrivals-euro-div-inner col-xs-12 col-sm-6 padding-zero">
                                                                    <div class="arrivals-text-div col-xs-12 padding-zero">
                                                                        <p class="arrivals-heading"><?= $productData['1']['name'] ?></p>
                                                                        <div class="arrivals-text"><?= $productData['1']['brief_description'] ?></div>
                                                                    </div>
                                                                </div>
                                                                <div class="arrivals-euro-div col-xs-12 col-sm-6 padding-zero">
                                                                    <div class="arrivals-img-div">
                                                                        <?php $image = getproductMainImage($productData['1']['id']);  ?>
                                                                        <?php
                                                                        $img = 'images/news-default.png';
                                                                        if ($image) {
                                                                            $img = $this->config->item('PRODUCT_URL') . $image['img'];
                                                                        }
                                                                        ?>
                                                                        <img src="<?= $img ?>" alt="arrivals-alt" class="arrivals-img img-responsive" style="max-width: 172px;">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="consort-offer-div">
                                                                <p class="consort-news-div">new</p>
                                                            </div>
                                                        </a>
                                                    <?php } ?>
                                                    <?php if ($productData['2']) { ?>
                                                        <a href="<?= $productData['2']['uri'] ?>">
                                                            <div class="arrivals-inner-main col-xs-12 ">
                                                                <div class="arrivals-euro-div col-xs-12 col-sm-6 padding-zero">
                                                                    <div class="arrivals-img-div">
                                                                        <?php $image = getproductMainImage($productData['2']['id']);  ?>
                                                                        <?php
                                                                        $img = 'images/news-default.png';
                                                                        if ($image) {
                                                                            $img = $this->config->item('PRODUCT_URL') . $image['img'];
                                                                        }
                                                                        ?>
                                                                        <img src="<?= $img ?>" alt="arrivals-alt" class="arrivals-img img-responsive" style="max-width: 172px;">
                                                                    </div>
                                                                </div>
                                                                <div class="arrivals-euro-inner-div col-xs-12 col-sm-6 padding-zero">
                                                                    <div class="arrivals-text-div col-xs-12 padding-zero">
                                                                        <p class="arrivals-heading"><?= $productData['2']['name'] ?></p>
                                                                        <div class="arrivals-text"><?= $productData['2']['brief_description'] ?></div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="consort-offer-div">
                                                                <p class="consort-news-div">new</p>
                                                            </div>
                                                        </a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <section id="arrivals-section">
                                    <div class="container-fluid">
                                        <div class="arrivals-section col-xs-12 padding-zero">
                                            <div class="arrrivals-inner-div col-xs-12 padding-zero">
                                                <div class="arrivals-main-div col-xs-12 col-sm-6 padding-zero">
                                                    <?php if (!$this->session->userdata('CUSTOMER_ID')) { ?>
                                                        <a href="<?= $productData['0']['category_uri'] ?>">
                                                        <?php } elseif ($this->session->userdata('CUSTOMER_ID')) { ?>
                                                            <a href="<?= $productData['0']['uri'] ?>">
                                                            <?php } ?>
                                                            <div class="arrivals-first-div col-xs-12">
                                                                <div class="arrivals-img-div">
                                                                    <?php $image = getproductMainImage($productData['0']['id']);  ?>
                                                                    <?php
                                                                    $img = 'images/img-default.jpg';
                                                                    if ($image) {
                                                                        $img = $this->config->item('PRODUCT_URL') . $image['img'];
                                                                    }
                                                                    ?>
                                                                    <img src="<?= $img ?>" alt="arrivals-alt" class="arrivals-img img-responsive" style="width: 250px;">
                                                                </div>
                                                                <div class="arrivals-text-div col-xs-12 padding-zero">
                                                                    <p class="arrivals-heading"><?= $productData['0']['name'] ?></p>
                                                                    <div class="arrivals-text"><?= $productData['0']['brief_description'] ?></div>
                                                                </div>
                                                            </div>

                                                            <div class="consort-offer-div">
                                                                <p class="consort-news-div">new</p>
                                                            </div>
                                                            </a>
                                                </div>
                                                <div class="arrivals-second-div col-xs-12 col-sm-6">
                                                    <?php if (isset($productData['1'])) { ?>
                                                        <?php if (!$this->session->userdata('CUSTOMER_ID')) { ?>
                                                            <a href="<?= $productData['1']['category_uri'] ?>">
                                                            <?php } elseif ($this->session->userdata('CUSTOMER_ID')) { ?>
                                                                <a href="<?= $productData['1']['uri'] ?>">
                                                                <?php } ?>
                                                                <div class="arrivals-inner-main col-xs-12 ">
                                                                    <div class="arrivals-euro-div-inner col-xs-12 col-sm-6 padding-zero">
                                                                        <div class="arrivals-text-div col-xs-12 padding-zero">
                                                                            <p class="arrivals-heading"><?= $productData['1']['name'] ?></p>
                                                                            <div class="arrivals-text"><?= $productData['1']['brief_description'] ?></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="arrivals-euro-div col-xs-12 col-sm-6 padding-zero">
                                                                        <div class="arrivals-img-div">
                                                                            <?php $image = getproductMainImage($productData['1']['id']);  ?>
                                                                            <?php
                                                                            $img = 'images/img-default.jpg';
                                                                            if ($image) {
                                                                                $img = $this->config->item('PRODUCT_URL') . $image['img'];
                                                                            }
                                                                            ?>
                                                                            <img src="<?= $img ?>" alt="arrivals-alt" class="arrivals-img img-responsive" style="width: 250px;">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="consort-offer-div">
                                                                    <p class="consort-news-div">new</p>
                                                                </div>
                                                                </a>
                                                            <?php } ?>
                                                            <?php if (isset($productData['2'])) { ?>
                                                                <?php if (!$this->session->userdata('CUSTOMER_ID')) { ?>
                                                                    <a href="<?= $productData['2']['category_uri'] ?>">
                                                                    <?php } elseif ($this->session->userdata('CUSTOMER_ID')) { ?>
                                                                        <a href="<?= $productData['2']['uri'] ?>">
                                                                        <?php } ?>
                                                                        <div class="arrivals-inner-main col-xs-12 ">
                                                                            <div class="arrivals-euro-div col-xs-12 col-sm-6 padding-zero">
                                                                                <div class="arrivals-img-div">
                                                                                    <?php $image = getproductMainImage($productData['2']['id']);  ?>
                                                                                    <?php
                                                                                    $img = 'images/img-default.jpg';
                                                                                    if ($image) {
                                                                                        $img = $this->config->item('PRODUCT_URL') . $image['img'];
                                                                                    }
                                                                                    ?>
                                                                                    <img src="<?= $img ?>" alt="arrivals-alt" class="arrivals-img img-responsive" style="width: 250px;">
                                                                                </div>
                                                                            </div>
                                                                            <div class="arrivals-euro-inner-div col-xs-12 col-sm-6 padding-zero">
                                                                                <div class="arrivals-text-div col-xs-12 padding-zero">
                                                                                    <p class="arrivals-heading"><?= $productData['2']['name'] ?></p>
                                                                                    <div class="arrivals-text"><?= $productData['2']['brief_description'] ?></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="consort-offer-div">
                                                                            <p class="consort-news-div">new</p>
                                                                        </div>
                                                                        </a>
                                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            <?php }  ?>
                        <?php }  ?>

                        <?php
                        echo createElementHtml($item1['page_id'], $item1['row_id'], $item1['element_id'], $item1['content_config']);
                        ?>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
</section>