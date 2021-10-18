<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">

<head>
    <?php $this->load->view('themes/' . THEME . '/layout/inc-analytic.php'); ?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php echo cms_meta_tags(); ?>
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
    <header id="header-section">
        <?php $this->load->view("themes/" . THEME . "/layout/inc-header.php"); ?>
    </header>
    <div class="wrapper">
        <section id="common-banner-section">
            <div class="container-fluid">
                <div class="common-banner-section col-xs-12 padding-zero">
                    <div class="common-inner-div">
                        <?php if (isset($page['page_banner']) == '') { ?>
                            <img src="images/default-wide.jpg" data-src="images/join-us-banner.jpg" alt="banner-alt" class="common-img img-responsive ">
                        <?php } else { ?>
                            <img src="images/default-wide.jpg" data-src="<?php echo $this->config->item('PAGE_BANNER_URL') . $page['page_banner'] ?>" alt="banner-alt" class="common-img img-responsive ">
                        <?php } ?>
                    </div>
                </div>
            </div>
        </section>
        <!-- <section id="common-banner-section">
            <div class="container-fluid">
                <div class="common-banner-section col-xs-12 padding-zero">
                    <div class="common-inner-div">
                        <?php if ($page['page_banner'] == '') { ?>
                            <img src="images/default-wide.jpg" data-src="images/join-us-banner.jpg" alt="banner-alt" class="common-img img-responsive lazyload">
                        <?php } else { ?>
                            <img src="images/default-wide.jpg" data-src="<?php echo $this->config->item('PAGE_BANNER_URL') . $page['page_banner'] ?>" alt="banner-alt" class="common-img img-responsive lazyload">
                        <?php } ?>
                    </div>
                    <div class="common-banner-text-div col-xs-12">
                        <p class="common-banner-heading"><?= $page['title'] ?></p>
                        <p class="common-banner-text"><?= strip_tags(word_limiter($page['banner_heading'], 100)) ?></p>
                    </div>
                </div>
            </div>
        </section> -->

        <?php
        $sidebar_style = 'display: none;';
        $page_style = 'width: 100%;';
        $sidebar_layout = $page['sidebar_layout'];
        if ($page['page_template_id'] == 3) {
            $page_sidebar_width = $page['page_sidebar_width'];
            $page_style = 'width: calc(100% - ' . $page_sidebar_width . '%)';
            $sidebar_style = "width: $page_sidebar_width%;";
        }
        $sideMenus = json_decode($page['sidebar_menu_id'], true);
        ?>

        <section>
            <div class="container-fluid col-xs-12">

                <div id="page-sidebar-outter">
                    <div id="page-sidebar-template" class="col-xs-12 page-sidebar-template <?php echo $sidebar_layout; ?>">

                        <div class="page-sidebar-col" style="<?php echo $sidebar_style; ?>">
                            <div class="page-sidebar-inner">
                                <div class="page-menu-list">
                                    <?php if (isset($sideMenus) && $sideMenus) {
                                        foreach ($sideMenus as $sideMenuID) {
                                            $sideMenuData = getSideMenuById($sideMenuID);
                                    ?>
                                            <div class="single-menu-col">
                                                <div class="single-menu-head">
                                                    <p><?php echo $sideMenuData['menu_name']; ?></p>
                                                </div>
                                                <div class="single-menu-body">
                                                    <?php
                                                    $params = array(
                                                        'menu_alias' => $sideMenuData['menu_alias'],
                                                        'ul_format' => '<ul class="list-unstyled">{MENU}</ul>',
                                                        'level_1_format' => '<a class="dropdown-toggle "  href="{HREF}"{ADDITIONAL}>{LINK_NAME}</a>',
                                                        'level_2_format' => '<a class="dropdown-toggle " href="{HREF}"{ADDITIONAL}>{LINK_NAME}</a>',
                                                    );
                                                    echo cms_sidebar_menu($params);
                                                    ?>
                                                </div>
                                            </div>
                                    <?php }
                                    } ?>
                                </div>
                            </div>
                        </div>

                        <?php if (isset($page_blocks) && $page_blocks) { ?>
                            <div class="page-with-sidebar" style="<?php echo $page_style; ?>">
                                <?php foreach ($page_blocks as $item) {
                                    $row_style_str = '';
                                    $full_width_cls = '';
                                    $row_styles_config = json_decode($item['style_config'], true);
                                    if (isset($row_styles_config) && $row_styles_config['full_width']) {
                                        $full_width_cls = 'full-width-row';
                                    }
                                    if (isset($row_styles_config) && $row_styles_config['background_color']) {
                                        $row_style_str .= "background-color: " . $row_styles_config['background_color'];
                                    }
                                    if (isset($row_styles_config) && $row_styles_config['image']) {
                                        $bg_image = $row_styles_config['image'];
                                        if ($row_styles_config['background_style']) {
                                            $row_style_str .= "background-size: " . $row_styles_config['background_style'] . ";";
                                        }
                                    }
                                ?>

                                    <div data-src="<?php echo $bg_image; ?>" style="<?php echo $row_style_str; ?>" class="lazyload col-xs-12 my_page_grid <?php echo $full_width_cls; ?> cls_<?php echo $item['id'] . $item['page_id']; ?>">
                                        <div class="inner-container-fluid">
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
                                                    } ?>
                                                    <div style="<?php echo $style_str; ?>" class="cls_<?php echo $item1['id'] . $item1['row_id'] . $item1['page_id']; ?> <?php if (!$item1['element_id']) { ?> dottedline plus-main-div <?php } ?>  <?= $item['layout_type'] ?>">
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
                            </div>
                        <?php } ?>


                    </div>
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
    <?php $this->load->view('themes/' . THEME . '/layout/inc-before-body-close.php'); ?>
    <script>
        $('select#unique').on('change', function(e) {
            var Selectedval = $(this).val();
            e.preventDefault();
            $('.services-listing-inner').block({
                // message: '<h1>Processing...</h1>',
                css: {
                    textAlign: 'center',
                    color: '#fff',
                    border: '0px solid #aaa',
                    cursor: 'wait',
                    backgroundColor: 'transparent',
                }
            });
            if (Selectedval != 'all') {
                var filterurl = "<?php echo base_url() ?>servicesm?category=" + Selectedval;
            } else {
                var filterurl = "<?php echo base_url() ?>servicesm";
            }
            $.ajax({
                url: '<?php echo base_url(); ?>servicesm/ajaxdata',
                type: "POST",
                data: {
                    'Selectedval': Selectedval
                },
                success: function(data) {
                    var obj = JSON.parse(data);
                    if (obj.success == true) {
                        $('.services-listing-inner').html(obj.html);
                        window.history.replaceState({}, document.title, filterurl);
                    }

                }
            });
            $('.services-listing-inner').unblock();

        });
    </script>

    <!-- Modal -->
    <div id="frenchiseformmodel" class="modal fade franchise-model-div" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content curved-div">
                <div class="modal-header border-none">
                    <button type="button" class="close cross" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form class="col-xs-12 form-style-div" id="frenchiseform" enctype="multipart/form-data">
                        <div class="alert alert-danger" id="enquiryAlertfrenchise" style="display: none;"></div>
                        <p class="metting-heading">Enter your details for discovery meeting here</p>

                        <div class="simple-div col-xs-12 padding-zero">
                            <div class="simple-form-div col-xs-12 padding-zero">
                                <div class="simple-div  col-xs-12 padding-zero">
                                    <div class="simple-text col-xs-12 col-sm-4">
                                        <input type="text" name="name" class="simple-request form-control val-name input-field" placeholder="Name">
                                    </div>
                                    <div class="simple-text col-xs-12 col-sm-4">
                                        <input type="text" name="email" class="simple-request form-control val-email" placeholder="Email">
                                    </div>
                                    <div class="simple-text col-xs-12 col-sm-4">
                                        <input type="text" name="phone" class="simple-request form-control val-subject input-field" placeholder="Contact number">
                                    </div>
                                    <div class="simple-text col-xs-12 col-sm-4">
                                        <input type="text" name="postcode" class="simple-request form-control val-name input-field" placeholder="postcode">
                                    </div>
                                    <div class="simple-text col-xs-12 col-sm-4">
                                        <input type="text" name="website" class="simple-request form-control val-email" placeholder="Website">
                                    </div>
                                    <div class="simple-text business-div col-xs-12 col-sm-4">
                                        <input type="text" name="business_name" class="simple-request form-control val-email" placeholder="Business name">
                                    </div>
                                </div>
                                <div class="submit-div col-xs-12">
                                    <button type="submit" class="btn btn-default" class="read-btn" id="franchisesubmitbtn">submit</button>
                                    <button type="button" class="btn btn-default" id="franchiseclosebtn" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer border-none">

                </div>
            </div>
        </div>
    </div>

    <script>
        $("a[href$='franchise']").on('click', function(e) {
            e.preventDefault();
            $('#frenchiseformmodel').modal('show');
        });

        $(document).on("submit", "#frenchiseform", function(e) {
            e.preventDefault();
            var formData = new FormData($("#frenchiseform")[0]);

            $('#frenchiseformmodel .modal-content').block({
                message: '<div class="fieldLoader"></div>',
                css: {
                    textAlign: 'center',
                    color: '#fff',
                    border: '0px solid #aaa',
                    cursor: 'wait',
                    backgroundColor: 'transparent',
                }
            });

            $("#joinussubmitbtn").text("Processing..")
            $.ajax({
                url: '<?php echo base_url(); ?>joinus/frenchiseform',
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    var res = JSON.parse(data);
                    $("#joinussubmitbtn").text("Submit")
                    if (res.success) {
                        $('#enquiryAlertfrenchise').hide();
                        $('#frenchiseformmodel .modal-body').html(res.content);
                        setTimeout(function() {
                            $('#frenchiseformmodel').modal('hide');
                            location.reload();
                        }, 2000);
                    } else {
                        $('#enquiryAlertfrenchise').html(res.message);
                        $('#enquiryAlertfrenchise').show();
                    }
                    $('#frenchiseformmodel .modal-content').unblock();
                }
            });
        });
        var tagsArray = [];
        $(".packages-brands-div-inner").each(function() {
            var tags = $(this).attr('data-tags');

            if (tags != '') {
                tagsArray.push(tags);
            }

        });


        var arrayString = tagsArray.join();

        var finalArray = arrayString.split(',');
        var duplicateArray = finalArray.filter(function(item, i, orig) {
            return orig.indexOf(item, i + 1) === -1;
        });

        if (tagsArray.length > 0) {
            duplicateArray.forEach(function(item) {
                $('#tagsOnPackagePage').append('<li><span class="edge-btn">' + item + '</span></li>')
            });
        }
        $(document).on("click", "#tagsOnPackagePage .edge-btn", function(e) {
            e.preventDefault();
            $('#tagsOnPackagePage .edge-btn , #tagsOnPackagePage .all-packages').removeClass('active');
            $(this).addClass('active');
            $('.packages-brands-div-inner').block({
                message: ' ',
                css: {
                    textAlign: 'center',
                    color: '#fff',
                    border: '0px solid #aaa',
                    cursor: 'wait',
                    backgroundColor: 'transparent',
                }
            });


            var tagsText = $(this).text().toLowerCase();

            setTimeout(function() {
                $(".packages-brands-div-inner").filter(function() {
                    $(this).toggle($(this).attr('data-tags').toLowerCase().indexOf(tagsText) > -1)
                });
                $('.packages-brands-div-inner').unblock();
            }, 500);

        });
        $(document).on("click", "#tagsOnPackagePage .all-packages", function(e) {
            e.preventDefault();
            $('#tagsOnPackagePage .edge-btn').removeClass('active');
            $(this).addClass('active');
            $('.packages-brands-div-inner').block({
                message: ' ',
                css: {
                    textAlign: 'center',
                    color: '#fff',
                    border: '0px solid #aaa',
                    cursor: 'wait',
                    backgroundColor: 'transparent',
                }
            });
            setTimeout(function() {
                $('.packages-brands-div-inner').css('display', 'block');
                $('.packages-brands-div-inner').unblock();
            }, 500);

        });
    </script>




</body>

</html>