<style type="text/css">
    #table-3 td {
        border: 1px solid #dfe8f1;
        padding: 8px 13px;
        font-size: 14px
    }

    .block-element {
        display: block;
        width: 100%
    }

    .list-inline.searchul {
        overflow: auto;
        max-height: 400px;
    }

    a {
        text-decoration: none !important
    }

    .panel-title .fa {
        margin: 0 6px 0 0;
        transition: .2s
    }

    .panel-default>.panel-heading {
        padding: 0
    }

    .panel-default>.panel-heading a {
        display: block;
        padding: 10px 15px
    }

    .fa.active {
        transform: rotate(90deg)
    }

    .panel-collapse .form-group {
        padding: 0
    }

    #button {
        padding: 10px 39px !important;
        margin-top: 16px
    }

    .middle-div #subcat .inner-ul-you-ma-8 {
        max-height: 400px;
        overflow: auto;
        padding: 0;
        border: none;
        margin: 0;
    }

    .border-add #subcat {
        border: 1px solid lightgray;
        padding: 0 10px 0px;
    }

    .margin-0 {
        margin: 0 !important
    }

    .tab-pane {
        padding-left: 0;
        padding-right: 0
    }

    .form-group.clearfix {
        padding: 0
    }

    .col-xs-12>.col-xs-12 {
        padding: 0
    }

    .col-xs-12.table-display-porp.row {
        margin-top: 20px
    }

    .col-xs-12.pdf-margin {
        margin-bottom: 15px
    }

    .accessory_quantity2 {
        width: 70px
    }

    .accessory_price2 {
        width: 70px
    }

    .nn-style-btn-pro-add {
        border: none;
        background: #495d80;
        color: #000;
        padding: 4px 13px
    }

    .brochureList label {
        cursor: pointer
    }

    .logo_location_custom_options li {
        list-style: none;
        margin-bottom: 9px;
        display: table;
        width: 100%;
    }

    .main-div #procat li,
    #subcat li {
        width: 100%;
        margin-bottom: 15px;
        list-style: none;
    }

    .main-div #procat li label,
    #subcat li label {
        width: 100%;
    }

    #mayalsolike {
        max-width: 80%;
    }

    .main-div .block-element {
        font-size: 18px;
        font-weight: bold;
        text-align: left;
        color: #263388;
    }

    .left-div .btn.dropdown-toggle.btn-default {
        height: 45px;
    }

    .middle-div .list-inline,
    #procat .list-inline {
        border-bottom: 1px solid lightgray;
        padding: 0 10px;
    }

    .sub-a-cat {
        display: inline-block;
        margin: auto;
        border: 1px solid lightgray;
        padding: 0px 20px 0 20px;
        background: #495d80;
        color: white;
        text-transform: capitalize;
    }

    .submit-sub-cat {
        text-align: center;
    }

    .sub-a-cat:hover {
        color: white;
    }

    .main-div {
        margin-bottom: 100px;
    }
</style>
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/widgets/datatable/datatable.css">
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable-bootstrap.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable-tabletools.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js"></script>
<script>
    function isNumberKeyFF(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            alert('Only numeric value allowed!');
            return false;
        } else {
            return true;
        }
    }
</script>
<script type="text/javascript">
    var selected_products = [];
    $(document).ready(function() {
        $('.datepicker').datepicker({
            minDate: 0,
            dateFormat: 'dd-mm-yy'
        });

        function stopPropagation(evt) {
            if (evt.stopPropagation !== undefined) {
                evt.stopPropagation();
            } else {
                evt.cancelBubble = true;
            }
        }
    });
</script>
<h3 class="title-hero clearfix">
    Add Product
    <a class="btn btn-primary pull-right margin-0" href="catalognew/product/index">Manage Products</a>
</h3>
<div class="panel">
    <div class="panel-body">
        <?php $this->load->view('inc-messages'); ?>
        <form action="catalognew/product/add" method="post" enctype="multipart/form-data" name="addcatform" id="addcatform">
            <div class="example-box-wrapper">
                <ul id="myTab" class="nav clearfix nav-tabs">
                    <li class="active"><a href="#tabs-0" data-toggle="tab">Main</a></li>
                    <li><a href="#tabs-1" data-toggle="tab">Metadata</a></li>
                    <li id="attrHi"><a href="#tabs-2" data-toggle="tab">Attributes</a></li>
                    <li><a href="#tabs-3" data-toggle="tab">Images</a></li>
                    <li class="tabs-4"><a href="#tabs-4" data-toggle="tab">PDFs</a></li>
                    <li class="tabs-5"><a href="#tabs-5" data-toggle="tab">Bullet Points</a></li>
                    <li class="tabs-6"><a href="#tabs-6" data-toggle="tab">You may also like</a></li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="tabs-0">
                        <div class="form-group clearfix col-xs-12 col-sm-6">
                            <label class="col-sm-2 control-label block-element">Select Primary Category <span class="error">*</span></label>
                            <div class="col-sm-6 block-element"><?php echo form_dropdown('category_id', $categories, set_value('category_id'), ' class="form-control" id="category"'); ?></div>
                        </div>
                        <div class="form-group clearfix col-xs-12 col-sm-6">
                            <label class="col-sm-2 control-label block-element">Select Attribute Set <span class="error">*</span></label>
                            <div class="col-sm-6 block-element">
                                <select name="attrsetid" class="form-control" id="attribute_set">
                                    <option value="0"> - select - </option>
                                    <?php
                                    foreach ($attributes_sets as $setitem) {
                                        echo '<option value="' . $setitem['id'] . '"> ' . $setitem['name'] . ' </option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group clearfix col-xs-12">
                            <label class="col-sm-2 control-label block-element">Select Other Categories</label>
                            <div class="col-sm-6 block-element"><?php echo form_dropdown('categoriesIds[]', $catSecArray, set_value('categoriesIds[]'), ' class="form-control" id="categoriesIds" multiple'); ?></div>
                        </div>
                        <div class="form-group clearfix col-xs-12 col-sm-6">
                            <label class="col-sm-2 control-label block-element">Product Type <span class="error">*</span></label>
                            <div class="col-sm-6 block-element"><?php echo form_dropdown('type', $proType, set_value('type'), ' class="form-control proType" id="proType"'); ?></div>
                        </div>
                        <div class="form-group clearfix col-xs-12 col-sm-6">
                            <label class="col-sm-2 control-label block-element">Product Name <span class="error"> *</span></label>
                            <div class="col-sm-6 block-element"><input name="name" type="text" class="form-control" id="name" value="<?php echo set_value('name'); ?>" size="40"></div>
                        </div>
                        <div class="form-group clearfix col-xs-12 col-sm-6">
                            <label class="col-sm-2 control-label block-element">Product Alias (Will be auto-generated if left blank)</label>
                            <div class="col-sm-6 block-element"><input name="uri" type="text" class="form-control" id="uri" value="<?php echo set_value('uri'); ?>" size="40"></div>
                        </div>
                        <div class="form-group clearfix col-xs-12 col-sm-6">
                            <label class="col-sm-2 control-label block-element">SKU <small><span class="error">*</span></small></label>
                            <div class="col-sm-6 block-element"><input name="sku" type="text" class="form-control" id="sku" value="<?php echo set_value('sku'); ?>" size="40"></div>
                        </div>
                        <div class="form-group clearfix col-xs-12 col-sm-6">
                            <label class="col-sm-2 control-label block-element">(Excluding Vat) Price</label>
                            <div class="col-sm-6 block-element"><input name="price" type="text" class="form-control" id="price" value="<?php echo set_value('price'); ?>" size="40"></div>
                        </div>
                        <div class="form-group clearfix col-xs-12 col-sm-6">
                            <label class="col-sm-2 control-label block-element">Stock Quantity <small><span class="error">*</span></small></label>
                            <div class="col-sm-6 block-element"><input name="quantity" type="text" class="form-control" id="quantity" value="<?php echo set_value('quantity'); ?>" size="40"></div>
                        </div>
                        <!-- <div class="form-group clearfix col-xs-12 col-sm-6">
                            <label class="col-sm-2 control-label block-element">Line Drawing</label>
                            <div class="col-sm-6 block-element"><input name="line_drowing" type="file" class="form-control" value="<?php echo set_value('line_drowing'); ?>" size="40"></div>
                        </div> -->
                        <div class="col-xs-12">
                            <div class="col-xs-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title accordHeader">
                                            <a data-toggle="collapse" href="#brief-description">
                                                <i class="fa fa-caret-right" aria-hidden="true"></i>
                                                Brief Description
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="brief-description" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <div class="form-group clearfix col-xs-12">
                                                <label class="col-sm-2 control-label block-element">Brief Description</label>
                                                <div class="col-sm-12 block-element"><textarea name="brief_description" style="width: 100%;" class="form-control" id="brief_description"><?php echo set_value('brief_description'); ?></textarea></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="col-xs-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title accordHeader">
                                            <a data-toggle="collapse" href="#full-description">
                                                <i class="fa fa-caret-right" aria-hidden="true"></i>
                                                Product Information
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="full-description" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <div class="form-group clearfix col-xs-12">
                                                <label class="col-sm-2 control-label">Product Information</label>
                                                <div class="col-sm-12" style="display:table;"><textarea name="description" style="width:100%" class="form-control" id="description"><?php echo set_value('description'); ?></textarea></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="col-xs-12" style="padding: 0px;">

                            <div class="form-group clearfix col-xs-12 col-sm-3">
                                <label class="col-sm-2 control-label block-element">Is New</label>
                                <div class="col-sm-6 block-element">
                                    <input id='new-yes' type="radio" name="is_new" value="1" <?php echo set_radio('is_new', '1', TRUE); ?> /> Yes&nbsp;&nbsp;
                                    <input id='new-no' type="radio" name="is_new" value="0" <?php echo set_radio('is_new', '0'); ?> /> No
                                    <div class="new-div">
                                        <div>
                                            <span>New Start Date</span><input class="datepicker" data-date-format="dd/mm/yyyy" name="new_start_date">
                                        </div>
                                        <div>
                                            <span>New End Date</span><input class="datepicker" data-date-format="dd/mm/yyyy" name="new_end_date">
                                        </div>
                                    </div>
                                </div>
                            </div>




                        </div> -->
                    </div>
                    <div class="tab-pane fade" id="tabs-1">
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Meta Title<br /></label>
                            <div class="col-sm-6"><textarea name="meta_title" cols="40" rows="4" style="width:99%" class="form-control" id="meta_title"><?php echo set_value('meta_title'); ?></textarea></div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Meta Keywords<br /></label>
                            <div class="col-sm-6"><textarea name="meta_keywords" cols="40" rows="4" style="width:99%" class="form-control" id="meta_keywords"><?php echo set_value('meta_keywords'); ?></textarea></div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Meta Description<br /></label>
                            <div class="col-sm-6"><textarea name="meta_description" cols="40" rows="4" style="width:99%" class="form-control" id="meta_description"><?php echo set_value('meta_description'); ?></textarea></div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tabs-2">
                        <div class="attradd"></div>
                    </div>
                    <div class="tab-pane fade" id="tabs-3">
                        <div id="my-dropzone" class="dropzone dz-clickable ">
                            <div class="dz-default dz-message">
                                <span>Drop files here to upload</span>
                            </div>
                        </div>
                        <p class="text-center">Upload size around 513*548. Max upload size limit <?= ini_get('upload_max_filesize') ?> </p>
                    </div>
                    <div class="tab-pane fade clearfix" id="tabs-4">
                        <div class="error_messages"></div>
                        <div class=" col-xs-12 table-display-porp row">
                            <div class="col-xs-12 pdf-margin">
                                <div class="col-xs-2">Certification</div>
                                <div class="col-xs-10"><input type="file" name="certification"></div>
                            </div>
                            <div class="col-xs-12 pdf-margin">
                                <div class="col-xs-2">Datasheet</div>
                                <div class="col-xs-10"><input type="file" name="datasheet"></div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade clearfix" id="tabs-5">
                        <div class="error_messages"></div>
                        <div class="row">
                            <div class="form-group">
                                <ul class="list-group logo_location_custom_options">
                                </ul>
                            </div>
                            <div class="row">
                                <i class="fa fa-plus-square" style="font-size:30px;cursor:pointer;padding-left: 60px;" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tabs-6">
                        <div class="col-xs-12 main-div main-div-top">
                            <div class="form-group clearfix col-xs-12 col-sm-3">
                                <label class="col-sm-2 control-label block-element">Want to active</label>
                                <div class="col-sm-6 ">
                                    <input type="radio" name="is_like_active" value="1" <?php echo set_radio('is_like_active', '1'); ?> /> Yes&nbsp;&nbsp;
                                    <input type="radio" name="is_like_active" value="0" <?php echo set_radio('is_like_active', '0', TRUE); ?> /> No
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 main-div">
                            <div class="col-xs-4 left-div">
                                <label class="col-sm-2 control-label block-element">Select Category </label>
                                <select name="maya" id="mayalsolike" class="form-control col-xs-12 selectpicker" data-live-search="true" data-live-search-style="startsWith">
                                    <option value="">--select--</option>
                                    <?php foreach ($parentcat  as $item) { ?>
                                        <option value="<?= $item['id'] ?>"><?= $item['name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-xs-4 middle-div">
                                <div id="subcat"></div>
                            </div>
                            <div class="col-xs-4 right-div">
                                <div id="procat"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <p align="center">Fields marked with <span class="error">*</span> are required.</p>
            <p align="center" id="verify_submit"><input type="submit" name="button" id="button" value="Submit" class="btn btn-primary"></p>
            <input type="hidden" name="assign_product" value="" id="childPdField">
        </form>
    </div>
</div>

<script type="text/javascript">
    var selected_products = [];

    function inArray(needle, haystack) {
        var length = haystack.length;
        for (var i = 0; i < length; i++) {
            if (haystack[i] == needle)
                return true;
        }
        return false;
    }
    var $objDT = $("#datatable-example");

    function loadChildProductList() {
        var category_id = $("[name='category_id']").val(),
            type = $("[name='type']").val();
        if ((type != 'config') && (type != 'bundle')) {
            return;
        }
        $objDT.DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "catalog/ajax/product/childProducts/" + category_id + '/0',
                "type": "POST",
                "data": function(data) {
                    var selectedValues = [];
                    $(".all-checkbox").prop("checked", false)
                    jQuery("input[name='attributesList[]']:checked").each(function() {
                        var va = $(this).val();
                        selectedValues.push(va);
                    });
                    data.attrbs = selectedValues;
                    return data;
                }
            },
            createdRow: function(row, data, index) {
                $(row).attr('data-obj', JSON.stringify(data));
            },
            "columns": [{
                    "data": "checkbox",
                    render: function(data, type, row, meta) {
                        var is_selected = 0;
                        if (inArray(parseInt(row.id), selected_products)) {
                            is_selected = 1;
                        }
                        return '<input class="accessory-input-control accessory-price chpd" ' + (is_selected ? 'checked' : '') + ' data-id="' + row.id + '"  type="checkbox" value="' + row.id + '">';
                    },
                    "orderable": false,
                    "targets": [0]
                },
                {
                    "data": "sku"
                },
                {
                    "data": "name",
                    render: function(data, type, row, meta) {
                        return '<a href="catalognew/product/edit/' + row.id + '" target="_blank">' + row.name + '</a>';

                    }
                },
                {
                    "data": "attr_label"
                },
                {
                    "data": "price",
                    render: function(data, type, row, meta) {
                        return '<input type="text"  id="pro_price' + row.id + '" data-label="' + row.name + '" data-value="' + row.attr_id + '"  value="' + row.price + '" >';
                    }
                },
                {
                    "data": "quantity",
                    render: function(data, type, row, meta) {
                        return '<input id="pro_quantity' + row.id + '" type="text" data-label="' + row.name + '" data-value="' + row.attr_id + '"  value="' + row.quantity + '" >';
                    }
                },
                {
                    "data": "assign",
                    render: function(data, type, row, meta) {
                        return '<button data-label="' + row.name + '" data-id="' + row.id + '" data-value="' + row.attr_id + '" id="assign_product' + row.id + '" class="btn btn-primary bt-updch" type="button">Udpate</button>';
                        /*return '<button data-label="' + row.name + '" data-value="' + row.attr_id + '" id="assign_product' + row.id + '" class="btn btn-primary" type="button" onclick="checkAttribute(this)">Add</button>';*/
                    }
                }
            ]
        });

    }

    $objDT.on("click", ".bt-updch", function() {
        var id = $(this).attr("data-id");
        var pro_price = $("#pro_price" + id).val();
        var pro_quantity = $("#pro_quantity" + id).val();
    });

    $objDT.on("click", ".chpd", function() {
        var id = $(this).attr("data-id");
        if ($(this).is(":checked")) {
            selected_products.push(parseInt(id));
        } else {
            var index = selected_products.indexOf(parseInt(id));
            if (index > -1) {
                selected_products.splice(index, 1);
            }
        }
    });
    $objDT.on("click", ".all-checkbox", function() {
        var selectAll = false;
        if ($(this).is(":checked")) {
            selectAll = true;
        }
        $(".chpd").each(function() {
            var id = $(this).attr("data-id");
            if (selectAll) {
                var index = selected_products.indexOf(parseInt(id));
                if (index == -1) {
                    selected_products.push(parseInt(id));
                }
                $(this).prop("checked", true);
            } else {
                var index = selected_products.indexOf(parseInt(id));
                if (index > -1) {
                    selected_products.splice(index, 1);
                    $(this).prop("checked", false);
                }
            }
        });
    });

    $("#cateAttributesID_old").on("click", ".att-chkbx-a", function() {
        var txt;
        if (confirm("Are you sure this will require to reselect child products?")) {

        } else {
            return false;
        }
    });

    $(document).ready(function() {
        $("[name='type']").change(function() {
            var value = $(this).val();
            if (value == 'bundle') {
                $('.min_order_quantity').show();
                $('.tabs-5').show();
            } else {
                $('.min_order_quantity').hide();
                $('.tabs-5').hide();
            }
        });
        $("[name='category_id']").change(function(evt) {
            loadChildProductList();
        });
        $("[name='type']").change(function(evt) {
            loadChildProductList();
        });


        $("#addProductTier").click(function(event) {
            event.preventDefault();
            var tbody = $(this).parents("table").children("tbody");
            var tierRow = '<tr><td><input name="tier_min_qty[]" class="form-control" id="tier_min_qty" value="" size="40" type="text"></td><td><input name="tier_max_qty[]" class="form-control" id="tier_max_qty" value="" size="40" type="text"></td><td><input name="tier_product_price[]" class="form-control" id="tier_product_price" value="" size="40" type="number"></td><td><input name="tier_delivery[]" type="text" class="form-control" id="tier_delivery" size="40"></td><td><a href="javascript:void(0);" class="btn btn-danger" onclick="removeTier(this)" >Remove</a></td></tr>';
            tbody.append(tierRow);
        });



        $("#addTier").click(function(event) {
            var rowCount = $('.tr-count tr').length;
            if (rowCount == 1) {
                $('.addsavebtn').append('<button onclick="save_quantity_range()" class="btn btn-primary pull-right" id="saveTier">Save Quantity</button>');
            }
            event.preventDefault();
            var $wrObj = jQuery(".wrap_selects");
            var tbody = $(this).parents("table").children("tbody");
            var nextIndex = parseInt(parseInt($wrObj.attr("data-rows-index")) + 1);
            $wrObj.attr("data-rows-index", nextIndex);
            var tierRow = '<tr><td style="width:10%"><input name="" class="form-control quantity_range_from_unique first-input" value="" size="40" type="text"></td><td style="width:4%">to</td><td style="width:10%"><input class="form-control quantity_range second-input" value="" size="40" type="text"></td><td><a href="javascript:void(0);" class="btn btn-danger" onclick="removeTier(this)" >Remove</a></td></tr>';
            tbody.append(tierRow);
        });

        $(document).on('click', '.selAllProfile', function() {
            $(this).attr('selected', false);
            $(this).nextAll('option').attr('selected', true);
            $(this).nextAll('option').prop('selected', true);
        });

    });

    function removeTier(element) {
        console.log(element);
        $(element).parents("tr").remove();
        var rowCount = $('.tr-count tr').length;
        console.log(rowCount);
        if (rowCount == 1) {
            $('#saveTier').remove();
            $('#group-table').hide();
        }
        var remove_td = $(element).attr('remove_class');
        console.log('.' + remove_td);
        $('.' + remove_td).remove();
    }

    $("#selectedProducts").on("click", ".removeSelectedPrd", function() {
        var json = $(this).parents("tr").attr('data-obj');
        var $pdObj = JSON.parse(json);

        proDucts = "<tr class='childProd' data-obj='" + json + "'>";
        proDucts += '<td>' + $pdObj.sku + '</td>';
        proDucts += '<td>' + $pdObj.name + '</td>';
        proDucts += '<td>' + $pdObj.attr_label + '</td>';
        proDucts += '<td>' + $pdObj.price + '</td>';
        proDucts += '<td>' + $pdObj.quantity + '</td>';
        proDucts += '<td class="assign-btn"><button data-label="' + $pdObj.name + '" data-value="' + $pdObj.attr_id + '" class="btn btn-primary" type="button" onclick="checkAttribute(this)" >Add</button></td>';
        proDucts += '</tr>';
        $(this).parents("tr").remove();
        selected_products.splice(selected_products.indexOf($pdObj.pid), 1);
        jQuery("#datatable-example tbody").append(proDucts);
    });
</script>
<script>
    $(document).ready(function() {
        $('.fa-plus-square').click(function(e) {
            var html = '';
            html += '<li class="">';
            html += '<div class="col-lg-10">';
            html += '<input name="bulletpoints[]" class="form-control" required/>';
            html += '</div>';
            html += '<div class="col-lg-2">';
            html += '<i class="fa fa-window-close fa-4 bulletpoints1" style="font-size:30px;cursor:pointer" aria-hidden="true"></i>';
            html += '</div>';
            html += '</li>';
            $('.logo_location_custom_options').append(html);
        });
        $(document).on('click', '.fa-window-close.bulletpoints1', function(e) {
            $(this).parent().parent().remove();
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.new-div').hide();
        $('#new-no').prop('checked', 'true');

        $('#new-yes').click(function() {
            $('.new-div').show();
        });

        $('#new-no').click(function() {
            $('.new-div').hide();
        });

        $('#pdf-input').change(function() {
            $('#pdf-upload-btn').trigger('click');
        });

        $('#pdf-upload-btn').on('click', function() {
            var file_data = $('#pdf-input').prop('files')[0];
            var filename = file_data.name;
            var form_data = new FormData();
            form_data.append('file', file_data);
            $.ajax({
                url: 'catalognew/product/upload_pdf',
                dataType: 'text',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function(php_script_response) {
                    var code = '<li>' + filename + '</li>';
                    $('#temp-pdf-ul').append(code);
                }
            });
        });

    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        var accessories = [];
        var item_id = 0;

        $("#add-accessory-table").on("click", ".add-access", function() {
            var aId = $(this).attr('data-id');
            var name = $(this).attr('data-name');
            var qty = $("#accessory_quantity" + aId).val();
            var accessory_price = $("#accessory_price" + aId).val();

            var obj = {
                id: item_id,
                product_id: aId,
                name: name,
                quantity: qty,
                price: accessory_price
            };

            var d_flag = false;
            $.each(accessories, function(index, element) {
                if (element.product_id == $('#non-config-products-select :selected').val()) {
                    d_flag = true;
                }
            });

            if (d_flag == false) {
                if (!obj.quantity) {
                    alert("Please enter valid quantity !");
                    $('#accessory-quantity').focus()
                } else if (obj.price == '' || obj.price < 1 || isNaN(Number(obj.price))) {
                    alert("Please enter valid quantity !");
                    $('#accessory-price').focus();
                } else {
                    item_id++;
                    accessories.push(obj);
                    var sn = accessories.length;
                    $('.accessories-row').remove();

                    $.each(accessories, function(index, item) {
                        var code = '';
                        code += '<tr class="accessories-row">';
                        code += '<td>' + sn + '</td>';
                        code += '<td>' + item.product_id + '</td>';
                        code += '<td>' + item.name + '</td>';
                        code += '<td>' + item.quantity + '</td>';
                        code += '<td>' + item.price + '</td>';
                        code += '<td><a href="#" class="remove-accessory-btn" data-accessory-id="' + item.id + '" onclick="return false;">Remove</a></td>';
                        code += '</tr>';
                        $('#current-accessories-head-tr').after(code);
                        sn--;
                    });
                    $('#accessories-input').val(JSON.stringify(accessories));
                }
            } else {
                alert('Duplicate ! This item is already added to accessores for this product.');
            }
        });

        $(document).on('click', '.remove-accessory-btn', function() {
            var accessory_id = $(this).attr('data-accessory-id');
            accessories.splice(accessory_id, 1);

            var temp = [];
            temp = accessories;

            $('.accessories-row').remove();
            item_id = 0;
            var sn = accessories.length;
            accessories = [];

            $.each(temp, function(index, item) {
                var obj = {
                    id: item_id,
                    product_id: item.product_id,
                    name: item.name,
                    quantity: item.quantity,
                    price: item.price
                };
                accessories.push(obj);
                var code = '';
                code += '<tr class="accessories-row">';
                code += '<td>' + sn + '</td>';
                code += '<td>' + item.product_id + '</td>';
                code += '<td>' + item.name + '</td>';
                code += '<td>' + item.quantity + '</td>';
                code += '<td>' + item.price + '</td>';
                code += '<td><a href="#" class="remove-accessory-btn" data-accessory-id="' + item_id + '" onclick="return false;">Remove</a></td>';
                code += '</tr>';
                $('#current-accessories-head-tr').after(code);
                item_id++;
                sn--;
            });
            console.log(accessories)
            $('#accessories-input').val(accessories);
        });
    });


    $(document).ready(function() {
        $('#add-accessory-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "catalog/ajax/product/non_config_products",
                "type": "POST",
            },
            "columns": [{
                    "data": "name"
                },
                {
                    "data": "price"
                },
                {
                    "data": "quantity",
                    render: function(data, type, row, meta) {
                        return '<input class="accessory-input-control accessory-quantity accessory_quantity2" id="accessory_quantity' + row.id + '" type="number" min="1" value="">';
                    }
                },
                {
                    "data": "price",
                    render: function(data, type, row, meta) {
                        return '<input class="accessory-input-control accessory-price accessory_quantity2" id="accessory_price' + row.id + '" type="text" min="1" value="">';
                    }
                },
                {
                    "data": "assign",
                    render: function(data, type, row, meta) {
                        return '<button id="add-accessory-btn' + row.id + '" data-id="' + row.id + '" data-name="' + row.name + '" class="add-access nn-style-btn-pro-add" type="button" name="button">Add</button>';
                    }
                }
            ]
        });


        jQuery("#addcatform").submit(function() {
            jQuery("#childPdField").val(selected_products.join());
        });

        $(window).on('load', function() {
            //do something
            localStorage.clear();
            console.log('here');

        });

        $(document).on('focusout', '.sku-field', function() {

            var productSku = $(this).val();
            // get the current cart, or an empty object if null
            var cart = JSON.parse(localStorage.getItem("ProductsSku")) || {};

            // update the cart by adding an entry or incrementing an existing one
            if (cart[productSku]) {
                $(this).prevAll('.skuerror').remove();
                $(this).before('<span class="skuerror" style="color:red; float: right;">Use unique SKU</span>');
                $(this).val("").css('border-color', 'red');
            } else {
                $(this).prevAll('.skuerror').remove();
                $(this).removeAttr("style")
                localStorage.clear();
                console.log(JSON.parse(localStorage.getItem("ProductsSku")) || {});
                var cart = JSON.parse(localStorage.getItem("ProductsSku")) || {};
                var j = 1;
                $(".sku-field").each(function() {
                    console.log(j);
                    j++;
                    var psku = $(this).val();
                    if (psku != '') {
                        cart[psku] = {
                            count: 1
                        };

                        // put the result back in localStorage
                        localStorage.setItem("ProductsSku", JSON.stringify(cart));
                    }

                });
            }

        });

        $(document).on('keydown', '.price-field', function(event) {
            if (event.shiftKey == true) {
                event.preventDefault();
            }

            if ((event.keyCode >= 48 && event.keyCode <= 57) ||
                (event.keyCode >= 96 && event.keyCode <= 105) ||
                event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 ||
                event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190 || event.keyCode == 110) {

            } else {
                event.preventDefault();
            }

            if ($(this).val().indexOf('.') !== -1 && event.keyCode == 190)
                event.preventDefault();
            //if a decimal has been added, disable the "."-button

        });

    });
</script>
<script>
    $(document).ready(function() {
        $(document).on('click', '#childPro', function(e) {
            $(window).scroll(function() {
                var divBox = $(document).find('#cateAttributesID').outerHeight() + 420;
                if ($(window).scrollTop() > divBox) {
                    $(document).find('.cloneAdd').addClass('fixed');
                } else {
                    $(document).find('.cloneAdd').removeClass('fixed');
                }
            });
        });

        $(document).on('click', '.saveAttr', function() {
            var clonedTableFirstRow = $(document).find('.clone-table');
        });

        $('.accordHeader a').click(function() {
            $(this).find('.fa').toggleClass('active');
        });

        $("#quantity_per_pack").keypress(function(e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                $("#errmsg").html("Digits Only").css('color', 'red').show().fadeOut("slow");
                return false;
            }
        });

        $("#verify_submit").click(function(e) {
            var result = true;
            $('.quantity_range_from_unique').each(function() {
                var tier_qty = $(this).val();
                if (tier_qty) {
                    if ($.isNumeric(tier_qty)) {
                        $(this).css('border-color', 'inherit');
                    } else {
                        alert('Please enter a numeric value for quantity column');
                        result = false;
                        $(this).css('border-color', 'red');
                        e.preventDefault();
                    }
                } else {
                    result = false;
                    $(this).css('border-color', 'red');
                    e.preventDefault();
                }
            });
            $('.quantity_range_value').each(function() {
                var quantity_range_value = $(this).val();
                if (quantity_range_value) {
                    $(this).css('border-color', 'inherit');
                } else {
                    result = false;
                    $(this).css('border-color', 'red');
                    e.preventDefault();
                }
            });
            if ($("input[name='is_offer']:checked").val() == 1) {
                if ($.isNumeric($("input[name='is_offer_discount']").val())) {
                    $("input[name='is_offer_discount']").css('border', '1px solid inherit');
                } else {
                    $("input[name='is_offer_discount']").css('border', '1px solid red');
                    alert('Please enter numeric value for offer discount');
                    result = false;
                    e.preventDefault();
                }
            } else {
                $("input[name='is_offer_discount']").css('border', '1px solid inherit');
            }
            if (result) {
                document.getElementById("addcatform").submit();
            }
        });

        $('#is_offer_discount').hide();
        $("input[name='is_offer']").click(function() {
            var value = $(this).attr('value');
            if (value == 1) {
                $('#is_offer_discount').show();
            } else {
                $('#is_offer_discount').hide();
            }
        });
    });

    function save_quantity_range() {
        var status = true;
        $('.quantity_range_from_unique').each(function() {
            var qty = $(this).val();
            if (qty) {
                if ($.isNumeric(qty)) {
                    $(this).css('border-color', 'inherit');
                } else {
                    alert('Please enter a numeric value for quantity column');
                    status = false;
                    $("#addcatform").submit(function(e) {
                        e.preventDefault();
                    });
                }
            } else {
                $(this).css('border-color', 'red');
                status = false;
                $("#addcatform").submit(function(e) {
                    e.preventDefault();
                });
            }
        });
        if (status) {
            $(".append_td").find("td:gt(0)").remove();
            $('.append_th').html('');
            $("#addcatform").submit(function(e) {
                e.preventDefault();
            });
            $('.append_th').html('<th style="text-align:center !important;">Groups</th>');
            $('.tr-count tr').each(function() {
                console.log($(this).children());
                var first_input = $(this).children().find('.first-input').val();
                var second_input = $(this).children().find('.second-input').val();
                var btn_danger = $(this).children().find('.btn-danger');
                if (first_input && second_input) {
                    var final_rem_class = 'class' + first_input + '-' + second_input;
                } else if (first_input) {
                    var final_rem_class = clean('class' + first_input);
                } else {

                }
                $(btn_danger).attr('remove_class', final_rem_class);
                if (first_input && second_input) {
                    var final_class = 'class' + first_input + '-' + second_input;
                    var final_label = first_input + '-' + second_input;
                    var correct_quantity_range = first_input + '-' + second_input;
                } else if (first_input) {
                    var final_class = clean(first_input);
                    var final_label = first_input + '+';
                    var correct_quantity_range = first_input;
                } else {

                }
                if (first_input) {
                    $('.append_th').append('<th style="text-align:center !important;" class="' + final_class + '">' + final_label + '</th>');
                    $('.append_td').each(function() {
                        var group_id = $(this).attr('group_id');
                        $(this).append('<td style="text-align:center !important;" class="' + final_class + '"><input name="quantity_range_value[' + group_id + '][]" class="quantity_range_value" style="width:auto;border:1px solid lightgrey;" type="text"><input name="quantity_range[' + group_id + '][]" value="' + correct_quantity_range + '" type="hidden"></td>');
                    });
                }
            });
            $('#group-table').show();
        }
    }

    function clean(str) {
        var result = str.replace(/ /g, '');
        var trimStr = result.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');
        return trimStr;
    }
</script>
<script>
    $(document).ready(function() {
        $('.datepicker').datepicker({
            maxDate: 0,
            dateFormat: 'dd/mm/yy'
        });

        $(document).on('change', '#mayalsolike', function() {
            var selcted_option = $(this).val();
            $.post('catalognew/product/getchildcat', {
                'selcted_option': selcted_option
            }, function(data) {
                var decode = jQuery.parseJSON(data);

                if (decode['subcat']) {
                    $('#procat').html('');
                    $('.middle-div').addClass('col-xs-4');
                    $('.middle-div').addClass('border-add');
                    $('#subcat').html(decode['subcat']);
                }
                if (decode['products']) {
                    $('#subcat').html('');
                    $('.middle-div').removeClass('col-xs-4');
                    $('.middle-div').removeClass('border-add');
                    $('#procat').html(decode['products']);
                }
                if (decode['noproduct']) {
                    $('#procat').html('');
                    $('#subcat').html(decode['noproduct']);
                }
                console.log("true");
            });
        });
        $(document).on('click', '.submit-sub-cat .sub-a-cat', function(e) {
            e.preventDefault();
            var subcatlist = [];
            $("#subcat input:checked").each(function() {
                subcatlist.push($(this).val());
            });
            $.ajax({
                url: "catalognew/product/catGetProducts",
                type: 'POST',
                data: {
                    subcat_id: subcatlist,
                },
                success: function(data) {
                    var decode = jQuery.parseJSON(data);

                    if (decode['products']) {
                        $('#procat').html(decode['products']);
                    }
                }
            });
        });

        $(document).on('keyup', '.input-search', function(e) {
            var input, filter, ul, li, a, i, txtValue;
            input = $(this);
            filter = $(this).val().toUpperCase();
            ul = $(this).parents('.searchul');
            li = $(this).parents('.searchul').find('li');
            for (i = 0; i < li.length; i++) {
                a = li[i].getElementsByClassName("name")[0];

                txtValue = a.textContent || a.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = "";
                } else {
                    li[i].style.display = "none";
                }
            }
        });

        $(document).on('keyup', '.input-search-attri', function(e) {
            var input, filter, ul, li, a, i, txtValue;
            input = $(this);
            filter = $(this).val().toUpperCase();
            ul = $(this).parents('.attribute-main-div');
            li = $(this).parents('.attribute-main-div').find('.custom-check');
            for (i = 0; i < li.length; i++) {
                a = li[i].getElementsByClassName("name")[0];

                txtValue = a.textContent || a.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = "";
                } else {
                    li[i].style.display = "none";
                }
            }
        });
        $(document).on('keyup', '.input-car-product .input-search', function(e) {
            var input, filter, ul, li, a, i, txtValue;
            input = $(this);
            filter = $(this).val().toUpperCase();
            ul = $(this).parents('#subcat');
            li = $(this).parents('#subcat').find('.custom-check');
            for (i = 0; i < li.length; i++) {
                a = li[i].getElementsByClassName("name")[0];

                txtValue = a.textContent || a.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = "";
                } else {
                    li[i].style.display = "none";
                }
            }
        });

    });
</script>