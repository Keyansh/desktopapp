<link rel="stylesheet" type="text/css" href="<?= base_url() . 'css/select2.min.css' ?>">
<h3 class="title-hero clearfix">
    Add Category Menu
    <div class="pull-right">
        <a href="cms/menu/index" class="btn btn-info" style="background: #495d80;">
            Manage Menus
        </a>
        <a href="cms/menu_item/index/<?php echo $menu_detail['menu_id']; ?>" class="btn btn-info" style="background: #495d80;">
            Manage Menu Items
        </a>
    </div>
</h3>

<div class="panel">
    <div class="panel-body">
        <div class="example-box-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <?php $this->load->view('inc-messages'); ?>
                    <form action="cms/menu_item/addurl/<?php echo $menu_detail['menu_id']; ?>" method="post" enctype="multipart/form-data" name="regFrm" id="regFrm">
                        <div class="form-group clearfix hide_for_cat">
                            <label class="col-sm-2 control-label">Category<span class="error">*</span></label>
                            <div class="col-sm-7">
                                <?php echo form_dropdown('category_id', $parent_menu, set_value('category_id'), ' class="form-control catchange"'); ?>
                            </div>
                        </div>
                        <div class="form-group clearfix subcat">
                            <label class="col-sm-2 control-label">Sub Categories</label>
                            <div id="append-select" class="col-sm-7">
                                <select name="sub_category[]" class="form-control js-data-example" multiple="multiple">
                                    <!--sub categories-->
                                </select>
                                <small>Please Select Maximum 8 Sub Categories</small>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Menu Item Name <span class="error">*</span></label>
                            <div class="col-sm-7">
                                <input name="menu_item_name" type="text" class="form-control" id="menu_item_name" value="<?php echo set_value('menu_item_name'); ?>" size="45" />
                            </div>
                        </div>
                        <div class="form-group clearfix hide_for_cat" style="display: none;">
                            <label class="col-sm-2 control-label">Menu Item Image <span class="error">*</span></label>
                            <div class="col-sm-7">
                                <input name="menu_item_image" type="file" class="form-control" size="45"/>
                                <small>allowed types (jpg|jpeg|gif|png) Size upload around 1900*550 Max file upload size <?= ini_get('upload_max_filesize') ?></small>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Open In New Window <span class="error" style="margin-left: -3px;">*</span></label>
                            <div class="col-sm-7">
                                <input name="new_window" type="radio" id="new_window" value="1" <?php echo set_radio('new_window', '1', TRUE); ?>  >
                                Yes
                                <input name="new_window" type="radio" id="new_window" value="0" <?php echo set_radio('new_window', '0'); ?> >
                                No
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-12" style="text-align: center;"> 
                                <input type="submit" name="button" id="button" class="btn btn-primary" value="Submit">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?= base_url() . 'js/select2.min.js' ?>" ></script>
<!--<script type="text/javascript" src="<?= base_url() . 'js/jscolor.js' ?>" ></script>-->
<script>
    $(document).ready(function () {
        $('.subcat').hide();
        $('.catchange').on('change', function () {
            var selected = this.value;
            if (selected != 0) {
                $('.subcat').show();
                $(".js-data-example").select2({
                    placeholder: "Select Sub Category",
                    allowClear: true,
                    ajax: {
                        url: DWS_BASE_URL + 'cms/menu_item/child_categories',
                        dataType: 'json',
                        delay: 100,
                        type: 'GET',
                        data: function (params) {
                            return {
                                q: params.term, // search term
                                cid: selected // search term
                            };
                        },
                        processResults: function (response) {
                            var arr = [];
                            $.each(response.data, function (index, value) {
                                arr.push({
                                    id: value.id,
                                    text: value.name
                                });
                            });
                            console.log(arr);
                            return {
                                results: arr
                            };
                        },
                        cache: true
                    },
                    escapeMarkup: function (markup) {
                        return markup;
                    },
                    minimumInputLength: 0
                });
            } else {
                $('.js-data-example').select2('val', '');
            }
        });

    });
    $(document).on('click', '.select2-selection__choice .select2-selection__choice__remove', function() {
        $(this).text(' ');
        var selectedValue = $(this).parents('.select2-selection__choice').text();
        var allOptions = $('#append-select > select option');
        $(allOptions).each(function(index, elem) {
            if ($(elem).text().trim() == selectedValue.trim()) {
                $(elem).remove();
            }
        });
    })
</script>