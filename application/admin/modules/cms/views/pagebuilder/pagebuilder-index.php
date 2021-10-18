<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() . 'css/select2.min.css' ?>">
<!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script type="text/javascript" src="<?= base_url() . 'js/select2.min.js' ?>"></script>
<style>
    .page-sidebar-template.right-side {
        flex-direction: row-reverse;
    }

    .black-btn {
        background: #333 !important;
        border-color: #333 !important;
    }

    .select2-container {
        width: 100% !important;
    }
</style>
<h3 class="title-hero clearfix">
    <?php echo $pages['title']; ?> - Pagebuilder
    <div class="pull-right">
        <?php if ($pageTemplates) { ?>
            <a href="#" class="btn btn-info black-btn" data-toggle="modal" data-target="#templateAssignModal">Assign Template</a>
        <?php } ?>
        <?php if (count($block) > 0) { ?>
            <a href="#" class="btn btn-info black-btn" data-toggle="modal" data-target="#pageTemplateModal">Save As Template</a>
        <?php } ?>
        <a href="cms/page" class="btn btn-info">Manage Pages</a>
        <a id="layout-selection-btn" href="javascript:void(0)" class="btn btn-info layout-selector-btn" data-toggle="modal">Add Row</a>
        <a id="publish-btn" href="javascript:void(0)" class="btn btn-info publishbtn" style="position: absolute;top: -52px;right: 91px;border: 2px dotted black !important;background-color: black !important;padding: 4px 30px;font-size: 18px;z-index: 9999;">Publish</a>
        <a href="#" class="btn btn-info black-btn" data-toggle="modal" data-target="#sidebarModal">Manage Sidebar</a>
    </div>
</h3>

<?php
$sidebar_style = 'display: none;';
$page_style = 'width: 100%;';
$sidebar_layout = $pages['sidebar_layout'];
if ($pages['page_template_id'] == 3) {
    $page_sidebar_width = $pages['page_sidebar_width'];
    $page_style = 'width: calc(100% - ' . $page_sidebar_width . '%)';
    $sidebar_style = "width: $page_sidebar_width%;";
}
?>

<?php
$sideMenus1 = json_decode($pages['sidebar_menu_id'], true);
?>
<div id="page-sidebar-outter">
    <div id="page-sidebar-template" class="col-xs-12 page-sidebar-template <?php echo $sidebar_layout; ?>">
        <div class="page-sidebar-col" style="<?php echo $sidebar_style; ?>">
            <div class="page-sidebar-inner">
                <ul class="list-inline">
                    <li>
                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#sideMenuModal">Add menu list</a>
                    </li>
                </ul>
                <div class="page-menu-list">
                    <?php if (isset($sideMenus1) && $sideMenus1) {
                        foreach ($sideMenus1 as $sideMenuID) {
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
                                        'ul_format' => '<ul class="">{MENU}</ul>',
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
        <div class="page-with-sidebar" style="<?php echo $page_style; ?>">
            <div class="panel">
                <div class="panel-body">
                    <div class="example-box-wrapper">
                        <div class="row">
                            <div class="col-md-12 norecord">
                                <?php $this->load->view('inc-messages'); ?>

                                <ul id="row_tree">
                                    <?php
                                    if (count($block) == 0) {
                                        echo "<p style='text-align: center; padding: 20px; font-size: 18px;'><a href='javascript:void(0)' class='layout-selector-btn'><i class='fa fa-plus'></i> Build Your Page.</a></p>";
                                    } else {
                                        // e($block);
                                    ?>
                                        <?php foreach ($block as $item) {
                                            $row_style_str = '';
                                            $full_width_cls = '';
                                            $row_styles_config = json_decode($item['style_config'], true);
                                            if (isset($row_styles_config) && $row_styles_config['full_width']) {
                                                $full_width_cls = 'full-width-row';
                                            }
                                            if (isset($row_styles_config) && $row_styles_config['background_color']) {
                                                $row_style_str = "background-color: " . $row_styles_config['background_color'];
                                            }
                                            $bg_image = '';
                                            if (isset($row_styles_config) && $row_styles_config['image']) {
                                                $row_style_str = "background-image: url(" . $row_styles_config['image'] . ");";
                                                if ($row_styles_config['background_style']) {
                                                    $row_style_str .= "background-size: " . $row_styles_config['background_style'] . ";";
                                                }
                                            }
                                        ?>
                                            <li style="<?php echo $row_style_str; ?>" id="<?php echo $item['id']; ?>" class="<?php echo $full_width_cls; ?> cls_<?php echo $item['id'] . $item['page_id']; ?>">
                                                <ul class="list-inline row-action-list rowColActionList">
                                                    <li class="text-li">
                                                        Row:
                                                    </li>
                                                    <li>
                                                        <span class="row-edit-option" data-page-id="<?= $item['page_id'] ?>" data-row-id="<?= $item['id'] ?>"><i class="fa fa-pencil"></i></span>
                                                    </li>
                                                    <li>
                                                        <span class="column-delete" data-delete-type="row" data-page-id="<?= $item['page_id'] ?>" data-row-id="<?= $item['id'] ?>"><i class="fa fa-trash"></i></span>
                                                    </li>
                                                </ul>
                                                <?php
                                                if ($item['element_config']) {
                                                    $data['module_item'] = $item;
                                                    echo $this->load->view('pagebuilder/widgets/inc-module-layout', $data);
                                                } else {
                                                    $data['blockData'] = $item;
                                                    echo $this->load->view('pagebuilder/widgets/inc-defaulthtml', $data, true);
                                                }
                                                ?>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('pagebuilder/modals/pagebuilder-modals'); ?>

<div id="pagebuilder-overlay" style="display: none;"></div>

<script src="<?php echo base_url(); ?>js/jquery.lazy.min.js"></script>
<script>
    $(function() {
        $('.lazyload').Lazy();
    });
</script>

<script>
    function showOverlay() {
        $('#pagebuilder-overlay').fadeIn();
    }

    function hideOverlay() {
        $('#pagebuilder-overlay').fadeOut();
    }

    $(document).ready(function() {
        $(".menu-selector").select2();

        $('#page-sidebar').toggleClass('barActive');
        $('#page-content-wrapper #page-content').toggleClass('barPageActive');
        $('.collapseBtn .fa').toggleClass('fa-chevron-left fa-chevron-right');

        $(document).on('click', '.layout-selector-btn', function(e) {
            e.preventDefault();
            showOverlay();
            $('#rowLayoutSelector').addClass('layoutSelectionActive');
        });

        $('#close-rowLayoutSelector').click(function(e) {
            e.preventDefault();
            hideOverlay();
            $('#rowLayoutSelector').removeClass('layoutSelectionActive');
        });

        $("#listsearch").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#pageBuilderOptionList li").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        $("#pageBuilderOptionList li").on("click", function() {
            $('body').block({
                message: 'Processing...'
            });
            var elementJSON = JSON.parse($(this).attr('data-element-item'));
            var myKeyVals = {
                'page_id': $(this).attr('data-page-id'),
                'row_id': $(this).attr('data-row-id'),
                'column_id': $(this).attr('data-column-id'),
                'element_id': elementJSON.id,
                'element_alias': elementJSON.element_alias,
                'element_style_fields': elementJSON.element_style_fields,
                'element_item_fields': elementJSON.element_form_fields,
                'element_table': elementJSON.element_type_table
            };

            $.ajax({
                type: 'POST',
                url: "<?= base_url() ?>cms/pagebuilder/pageBuilderView",
                data: myKeyVals,
                success: function(data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.success == true) {
                        if (obj.itemForm == '\r\n' || obj.itemForm == '') {
                            $('#pageBuilderWidgetsModel a[href="#menu1"]').hide();
                            $('#pageBuilderWidgetsModel a[href="#home"]').trigger('click');
                        } else {
                            $('#pageBuilderWidgetsModel a[href="#menu1"]').show();
                        }
                        if (obj.configForm == '\r\n' || obj.configForm == '') {
                            $('#pageBuilderWidgetsModel a[href="#home"]').hide();
                        } else {
                            $('#pageBuilderWidgetsModel a[href="#home"]').show();
                        }
                        $('#loaddata').html(obj.configForm);
                        $('#loadelementform').html(obj.itemForm);
                    }
                    $('body').unblock();
                }
            });

            $('#pageBuilderElementsModel').modal('hide');
            setTimeout(function() {
                $('#pageBuilderWidgetsModel').modal('show');
            }, 400);
        });

        $(document).on("click", ".plus-main-div", function() {
            var block_id = $(this).data('block-id');
            var element_id = $(this).data('element-id');
            $('#pageBuilderOptionList li').attr('data-row-id', block_id);
            $('#pageBuilderOptionList li').attr('data-column-id', element_id);
            $('#pageBuilderElementsModel').modal('show');
        });

        $(document).on('click', '.column-delete', function() {
            if (confirm('Are you sure! you want to remove this item?')) {
                var id_config = {
                    page_id: $(this).attr('data-page-id'),
                    row_id: $(this).attr('data-row-id'),
                    column_id: $(this).attr('data-column-id'),
                    delete_type: $(this).attr('data-delete-type')
                }
                $.ajax({
                    type: 'POST',
                    url: "<?= base_url() ?>cms/pagebuilder/updateRowColumns",
                    data: id_config,
                    success: function(data) {
                        $("#row_tree").load(location.href + " #row_tree");
                    }
                });
            }
        });

        $(document).on("click", ".edit-option", function() {
            var blockItemJSON = JSON.parse($(this).attr('data-block-item'));
            var elementJSON = JSON.parse($(this).attr('data-element'));
            var myKeyVals = {
                'page_id': blockItemJSON.page_id,
                'row_id': blockItemJSON.row_id,
                'column_id': blockItemJSON.id,
                'element_id': blockItemJSON.element_id,
                'element_alias': elementJSON.element_alias,
                'element_style_fields': elementJSON.element_style_fields,
                'element_item_fields': elementJSON.element_form_fields,
                'block_item_content': blockItemJSON.content_config,
                'block_style_content': blockItemJSON.style_config,
                'element_table': elementJSON.element_type_table
            };
            $.ajax({
                type: 'POST',
                url: "<?= base_url() ?>cms/pagebuilder/pageBuilderView",
                data: myKeyVals,
                success: function(data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.success == true) {
                        $('#loaddata').html(obj.configForm);
                        $('#loadelementform').html(obj.itemForm);
                        $('#slider_id').trigger("change");
                    }
                }
            });

            $('#pageBuilderElementsModel').modal('hide');
            setTimeout(function() {
                $('#pageBuilderWidgetsModel').modal('show');
            }, 400);
        });

        $(document).on('click', '.row-edit-option', function() {
            var rowConfig = {
                page_id: $(this).attr('data-page-id'),
                row_id: $(this).attr('data-row-id')
            };

            $('#rowUpdate').modal('show');

            $.ajax({
                type: 'POST',
                url: "<?= base_url() ?>cms/pagebuilder/rowUpdateView",
                data: rowConfig,
                success: function(data) {
                    var rowResponse = JSON.parse(data);
                    if (rowResponse.view && rowResponse.view != '') {
                        $('#rowUpdate .modal-body').html(rowResponse.view);
                    }
                    // $('#rowUpdate').modal('hide');
                }
            });
        });



        $(document).on('submit', '#rowUpdaterForm', function(e) {
            e.preventDefault();
            $('#rowUpdate .modal-content').block({
                message: 'Processing...'
            });
            var rowForm = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: "<?= base_url() ?>cms/pagebuilder/rowUpdate",
                data: rowForm,
                success: function(data) {
                    var rowResponse = JSON.parse(data);
                    $('#rowUpdate').modal('hide');
                    $("#row_tree").load(location.href + " #row_tree");
                    $('#rowUpdate .modal-content').unblock();
                }
            });
        });

        function itemAjaxCall(ajaxURL, formData) {
            $.ajax({
                url: '<?php echo base_url(); ?>cms/pagebuilder/' + ajaxURL,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    $('#pageBuilderWidgetsModel .modal-content').unblock();
                    var obj = jQuery.parseJSON(data);
                    if (obj.success == true) {
                        $('body').block({
                            message: 'Processing...'
                        });
                        $("#row_tree").load(location.href + " #row_tree");
                        $('form').each(function() {
                            this.reset()
                        });
                        $("#loadelementform").html(" ");
                        $("#loaddata").html(" ");
                        $('#enquiryAlert').html(' ');
                        $('#enquiryAlert').hide();
                        $('#pageBuilderWidgetsModel').modal('hide');
                        $('body').unblock();
                    }
                    if (obj.success == false) {
                        $('#enquiryAlert').html(obj.message);
                        $('#enquiryAlert').show();
                    }
                }
            });
        }

        $(document).on("click", "#submitformdataWidgets", function(e) {
            e.preventDefault();
            $('#pageBuilderWidgetsModel .modal-content').block({
                message: 'Processing...'
            });
            var block_element_type = $('input[name="element_alias"]').val();

            var formData = new FormData($("#pagebuilderElementformdata")[0]);
            var styleData = new FormData($("#pagebuilderElementStyledata")[0]);

            if (block_element_type == 'banner' || block_element_type == 'image') {
                formData.append('file', $('#pagebuilderElementformdata input[type=file]')[0].files[0]);
            }
            // tinyMCE.triggerSave();
            itemAjaxCall('pagebuilderElementformdata', formData);
            setTimeout(function() {
                itemAjaxCall('pagebuilderElementStyledata', styleData);
            }, 500);


        });

        $(document).on("submit", "#insertRowAndColumnForm", function(e) {
            e.preventDefault();
            $('body').block({
                message: 'Processing...'
            });
            $.ajax({
                url: '<?php echo base_url(); ?>cms/pagebuilder/insertRowAndColumnForm',
                type: "POST",
                data: $("#insertRowAndColumnForm").serialize(),
                success: function(data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.success == true) {
                        $("#row_tree").load(location.href + " #row_tree");
                        $(".norecord .error").remove();
                        $("#insertRowAndColumnForm")[0].reset();
                        hideOverlay();
                        $('#rowLayoutSelector').removeClass('layoutSelectionActive');
                    }
                    $('body').unblock();
                }
            });
        });

        $(document).on("click", ".close-btn-disable", function(e) {
            e.preventDefault();
            $("#pagebuilderElementformdata")[0].reset();
            $("#loadelementform").html(" ");
            $("#loaddata").html(" ");
            $('#enquiryAlert').html(' ');
            $('#enquiryAlert').hide();
            $(".nextmenu a").trigger("click");
            $('#pageBuilderWidgetsModel').modal('hide');
        });

        $(document).on("keypress", ".div-sec-input input", function(e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                alert('only Number')
                return false;
            }
        });

        var options = {
            placeholder: "ui-state-highlight",
            update: function(event, ui) {
                $('.example-box-wrapper').block({
                    message: 'Updating the sort order...',
                    css: {
                        border: 'none',
                        color: "white",
                        background: 'transparent'
                    }
                });
                data: $(this).sortable("serialize"),
                    $.ajax({
                        url: "<?php echo base_url() ?>cms/pagebuilder/updateSortOrder",
                        type: 'POST',
                        data: {
                            order: $("#row_tree").sortable('toArray'),
                        },
                        success: function(data) {
                            console.log("true");
                            $('.example-box-wrapper').unblock();

                        }
                    });
            }
        };
        $("#row_tree").sortable(options);

        $('#sidebarForm').submit(function(e) {
            e.preventDefault();

            $('body').block({
                message: 'Processing...'
            });
            var formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: "<?= base_url() ?>cms/page/updatePageSidebar",
                data: formData,
                success: function(data) {
                    $('body').unblock();
                    location.reload();
                }
            });
        });

        $('#sideMenuForm').submit(function(e) {
            e.preventDefault();
            $('#sideMenuModal .modal-content').block({
                message: 'Processing...'
            });
            var formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: "<?= base_url() ?>cms/pagebuilder/addSideMenulist",
                data: formData,
                success: function(data) {
                    $('#sideMenuModal .modal-content').unblock();
                    location.reload();
                }
            });
        });

        $(document).on('submit', '#pageTemplateForm', function(e) {
            e.preventDefault();
            $('#pageTemplateModal .modal-content').block({
                message: 'Processing...'
            });
            var formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: "<?= base_url() ?>cms/pagebuilder/savePageTemplate",
                data: formData,
                success: function(obj) {
                    $('#templateAlert').html(obj.message);
                    if (obj.success == true) {
                        $('#templateAlert').removeClass('alert-danger');
                        $('#templateAlert').addClass('alert-success');
                        $('#pageTemplateForm').trigger('reset');
                        setTimeout(function() {
                            $('#templateAlert').hide();
                            location.reload();
                        }, 1000);
                    } else {
                        $('#templateAlert').removeClass('alert-success');
                        $('#templateAlert').addClass('alert-danger');
                    }
                    $('#pageTemplateModal .modal-content').unblock();
                    $('#templateAlert').show();
                }
            });
        });

        $(document).on('submit', '#templateAssignForm', function(e) {
            e.preventDefault();
            if (confirm('Assigning template will rebuild this page. Are you sure you want to continue?')) {
                $('#templateAssignModal .modal-content').block({
                    message: 'Processing...'
                });
                var formData = $(this).serialize();
                $.ajax({
                    type: 'POST',
                    url: "<?= base_url() ?>cms/pagebuilder/assignPageTemplate",
                    data: formData,
                    success: function(obj) {
                        $('#templateAssignAlert').html(obj.message);
                        if (obj.success == true) {
                            $('#templateAssignAlert').removeClass('alert-danger');
                            $('#templateAssignAlert').addClass('alert-success');
                            setTimeout(function() {
                                $('#templateAssignAlert').hide();
                                location.reload();
                            }, 1000);
                        }
                        $('#templateAssignModal .modal-content').unblock();
                        $('#templateAssignAlert').show();
                    }
                });
            }
        });

    });
    $(document).on('click', '#publish-btn', function() {
        $.ajax({
            type: 'POST',
            url: "<?= base_url() ?>cms/pagebuilder/PublishPage",
            data: {
                'pagid': <?= $pages['page_id']  ?>
            },
            success: function(data) {
                alert('page is published');
                location.reload();
            }
        });
    });
</script>