<style type="text/css">
    #table-3 td {
        border: 1px solid #DFE8F1;
        padding: 8px 13px;
        font-size: 14px;
    }
</style>

<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/widgets/datatable/datatable.css">
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable-bootstrap.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable-tabletools.js"></script>

<script type="text/javascript">
    var selected_products = [];
    $(document).ready(function () {
        $('.datepicker').datepicker({minDate: 0, dateFormat: 'dd-mm-yy'});

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
    <a href="catalog/product/index">Manage Products</a>
</h3>
<div class="panel">
    <div class="panel-body">
        <?php $this->load->view('inc-messages'); ?>
        <form action="catalog/product/add" method="post" enctype="multipart/form-data" name="addcatform" id="addcatform">
            <div class="example-box-wrapper">
                <ul id="myTab" class="nav clearfix nav-tabs">
                    <li class="active"><a href="#tabs-0" data-toggle="tab">Main</a></li>
                    <li><a href="#tabs-1" data-toggle="tab">Metadata</a></li>
                    <li id="attrHi"><a href="#tabs-2" data-toggle="tab">Attributes</a></li>
                    <li><a href="#tabs-3" data-toggle="tab">Images</a></li>
                    <li id="childPro"><a href="#tabs-4" data-toggle="tab">Child Product</a></li>
                    <li class="tabs-5" style="display:none"><a href="#tabs-5" data-toggle="tab">Custom Options</a></li>
                    <li class="tabs-6"><a href="#tabs-6" data-toggle="tab">PDFs</a></li>
                    <li class="tabs-7"><a href="#tabs-7" data-toggle="tab">Accessories</a></li>
                    <li class="tabs-8"><a href="#tabs-8" data-toggle="tab">Brochures</a></li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="tabs-0">
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Select Primary Category <span class="error">*</span></label>
                            <div class="col-sm-6"><?php echo form_dropdown('category_id', $categories, set_value('category_id'), ' class="form-control" id="category"'); ?></div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Select Attribute Set <span class="error">*</span></label>
                            <div class="col-sm-6">
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
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Select Other Categories</label>
                            <div class="col-sm-6"><?php echo form_dropdown('categoriesIds[]', $catSecArray, set_value('categoriesIds[]'), ' class="form-control" id="categoriesIds" multiple'); ?></div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Product Type <span class="error">*</span></label>
                            <div class="col-sm-6"><?php echo form_dropdown('type', $proType, set_value('type'), ' class="form-control proType" id="proType"'); ?></div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Select Brand</label>
                            <div class="col-sm-6">
                                <select name="brand_id" class="form-control" id="brand_id">
                                    <option value="0"> - select - </option>
                                    <?php
                                    foreach ($brands as $brand) {
                                        echo '<option value="' . $brand['id'] . '"> ' . $brand['name'] . ' </option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Product Name <span class="error"> *</span></label>
                            <div class="col-sm-6"><input name="name" type="text" class="form-control" id="name" value="<?php echo set_value('name'); ?>" size="40"></div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Product Alias</label>
                            <div class="col-sm-6"><input name="uri" type="text" class="form-control" id="uri" value="<?php echo set_value('uri'); ?>" size="40">&nbsp;(Will be auto-generated if left blank)</div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">SKU <small><span class="error">*</span></small></label>
                            <div class="col-sm-6"><input name="sku" type="text" class="form-control" id="sku" value="<?php echo set_value('sku'); ?>" size="40"></div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Price </label>
                            <div class="col-sm-6"><input name="price" type="text" class="form-control" id="price" value="<?php echo set_value('price'); ?>" size="40"></div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Manufacturer's Suggested Retail Price</label>
                            <div class="col-sm-6"><input name="srp_price" type="text" class="form-control" id="srp_price" value="<?php echo set_value('srp_price'); ?>" size="40"></div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Tier Price <small><span class="error"></span></small></label>
                            <div class="col-sm-6">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Profile Group</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="wrap_selects" data-rows-index="0">
                                        <tr>
                                            <td>
                                                <select name="tier_profgroup[]" id="tier_profgroup" class="form-control" width="40">
                                                    <option value="0" class="selAllProfile">All</option>
                                                    <?php
                                                    if ($profileGroup) {
                                                        foreach ($profileGroup as $v) {
                                                            ?>
                                                            <option value="<?php echo $v['id'] ?>"><?php echo $v['profile_name'] ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                            <td>
                                                <input name="tier_qty[]" type="text" class="form-control" id="tier_qty" value="<?php echo set_value('price'); ?>" size="20">
                                            </td>
                                            <td>
                                                <input name="tier_price[]" type="text" class="form-control" id="tier_price" value="<?php echo set_value('price'); ?>" size="40">
                                            </td>
                                            <td>
                                                <a href="javascript:void(0);" class="fa fa-trash-o delete-icon" onclick="removeTier(this)" ></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4">
                                                <button class="btn btn-primary pull-right" id="addTier">Add Tier</button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>


                            </div>
                        </div>
                        <div class="form-group clearfix" id="min-bundle-qty">
                            <label class="col-sm-2 control-label">Bundle Quantity </label>
                            <div class="col-sm-6"><input name="bundle_qty" type="text" class="form-control" id="bundle_qty" value="<?php echo set_value('bundle_qty'); ?>" size="40"><small>Only numbers e.g. 0,10,100 etc.</small></div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Quantity <small><span class="error">*</span></small></label>
                            <div class="col-sm-6"><input name="quantity" type="text" class="form-control" id="quantity" value="<?php echo set_value('quantity'); ?>" size="40"></div>
                        </div>

                        <!-- <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Set Up Cost <small><span class="error"></span></small></label>
                            <div class="col-sm-6"><input name="set_up_cost" type="text" class="form-control" id="quantity" value="<?php echo set_value('set_up_cost') ?>" size="40"></div>
                        </div> -->

                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Alert Quantity <small><span class="error">*</span></small></label>
                            <div class="col-sm-6"><input name="alert_qty" type="text" class="form-control" id="alert_qty" value="<?php echo set_value('alert_qty'); ?>" size="40"></div>
                        </div>
                        <div class="form-group clearfix min_order_quantity" style="display:none">
                            <label class="col-sm-2 control-label">Minimum Order Quantity</label>
                            <div class="col-sm-6"><input name="min_order_quantity" type="number" class="form-control" id="min_order_quantity" value="<?php echo set_value('min_order_quantity'); ?>" size="40"></div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Brief Description</label>
                            <div class="col-sm-6"><textarea name="brief_description" cols="40" class="form-control" id="brief_description"><?php echo set_value('brief_description'); ?></textarea></div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Full Description</label>
                            <div class="col-sm-12" style="display:table;"><textarea name="description" style="width:99%" class="form-control" id="description"><?php echo set_value('description'); ?></textarea></div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Product Dimensions</label>
                            <div class="col-sm-12" style="display:table;"><textarea name="dimensions" style="width:99%" class="form-control"><?php echo set_value('dimensions'); ?></textarea></div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Product Tags</label>
                            <div class="col-sm-12" style="display:table;"><textarea name="tags" style="width:99%" class="form-control"><?php echo set_value('tags'); ?></textarea></div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Product Specifications</label>
                            <div class="col-sm-12" style="display:table;"><textarea name="product_specifications" style="width:99%" class="form-control" id="product_specifications"><?php echo set_value('product_specifications'); ?></textarea></div>
                        </div>
                        <!-- <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Payment and Delivery Options</label>
                            <div class="col-sm-6"><textarea name="payment_delivery_options" style="width:99%" class="form-control" id="payment_delivery_options"><?php echo set_value('payment_delivery_options'); ?></textarea></div>
                        </div> -->
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Is Featured</label>
                            <div class="col-sm-6">
                                <input type="radio" name="is_featured" value="1" <?php echo set_radio('is_featured', '1'); ?> />Yes
                                <input type="radio" name="is_featured" value="0" <?php echo set_radio('is_featured', '0', TRUE); ?> />NO
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Is New</label>
                            <div class="col-sm-6">
                                <input id='new-yes' type="radio" name="is_new" value="1" <?php echo set_radio('is_new', '1', TRUE); ?> />Yes
                                <input id='new-no' type="radio" name="is_new" value="0" <?php echo set_radio('is_new', '0'); ?> />NO
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
                        <!-- <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Is Bespoke</label>
                            <div class="col-sm-6">
                                <input type="radio" name="is_bespoke" value="1" <?php //echo set_radio('is_bespoke', '1');              ?> />Yes
                                <input type="radio" name="is_bespoke" value="0" <?php //echo set_radio('is_bespoke', '0');              ?> />NO
                            </div>
                        </div> -->
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Is Taxable</label>
                            <div class="col-sm-6">
                                <input type="radio" name="is_taxable" value="1" <?php echo set_radio('is_taxable', '1', TRUE); ?> />Yes
                                <input type="radio" name="is_taxable" value="0" <?php echo set_radio('is_taxable', '0'); ?> />NO
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Product Price is</label>
                            <div class="col-sm-6">
                                <input type="radio" name="inc_or_exl_tax" value="1" <?php echo set_radio('inc_or_exl_tax', 1, true); ?> /> Including Tax
                                <input type="radio" name="inc_or_exl_tax" value="2" <?php echo set_radio('inc_or_exl_tax', 2); ?> /> Not Including Tax
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tabs-1">
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Meta Title<br/></label>
                            <div class="col-sm-6"><textarea name="meta_title" cols="40" rows="4" style="width:99%" class="form-control" id="meta_title"><?php echo set_value('meta_title'); ?></textarea></div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Meta Keywords<br/></label>
                            <div class="col-sm-6"><textarea name="meta_keywords" cols="40" rows="4" style="width:99%" class="form-control" id="meta_keywords"><?php echo set_value('meta_keywords'); ?></textarea></div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Meta Description<br/></label>
                            <div class="col-sm-6"><textarea name="meta_description" cols="40" rows="4" style="width:99%" class="form-control" id="meta_description"><?php echo set_value('meta_description'); ?></textarea></div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tabs-2">
                        <div class="attradd"></div>
                    </div>
                    <div class="tab-pane fade" id="tabs-3">
                        <div id="my-dropzone" class="dropzone dz-clickable " >
                            <div class="dz-default dz-message">
                                <span>Drop files here to upload</span>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade clearfix" id="tabs-4">
                        <div class="error_messages"></div>
                        <div class="cateAttributes" id="cateAttributesID"></div>
                        <div class="childprod">
                            <div class="page-header">
                                <h2>Child Products</h2>
                            </div>
                            <table class="table table-bordered table-responsive" id="datatable-example" class="table table-bordered table-responsive">
                                <thead>
                                    <tr>
                                        <th style="color:black;"><input type="checkbox" class="all-checkbox" value="1" name="" /></th>
                                        <th style="color:black;">SKU</th>
                                        <th style="color:black;">Name</th>
                                        <th style="color:black;">Assigned Attributes</th>
                                        <th style="color:black;">Price</th>
                                        <th style="color:black;">Stock</th>
                                        <th style="color:black;">Assign</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade clearfix" id="tabs-5">
                        <div class="error_messages"></div>
                        <div class="row">
                            <div class="form-group">
                                <label class="form-label">Logo Print Locations</label>
                                <ul class="list-group logo_location_custom_options">
                                </ul>
                            </div>
                            <div class="row">
                                <i class="fa fa-plus-square" style="font-size:30px;cursor:pointer" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade clearfix" id="tabs-6">
                        <div class="error_messages"></div>
                        <div class="row">
                            <input id="pdf-input" name="pdf" type="file" accept="application/pdf" />
                            <input id="pdf-upload-btn" type="hidden" value="Upload" />
                        </div>
                        <div class="temp-pdf-div">
                            <p>Your PDFs</p>
                            <ul id='temp-pdf-ul'>

                            </ul>
                        </div>
                    </div>
                    <div class="tab-pane fade clearfix" id="tabs-7">
                        <div class="error_messages"></div>
                        <div class="row">                              
                            <table class="table table-bordered table-responsive" id='add-accessory-table' class="table table-bordered table-responsive" style="width:100%">
                                <thead>
                                    <tr>
                                        <th style="color:black;">Accessory</th>
                                        <th style="color:black;">Product Price</th>
                                        <th style="color:black;">Quantity</th>
                                        <th style="color:black;">Unit Price</th>
                                        <th style="color:black;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>

                            <?php /* <table id='add-accessory-table'>
                              <tr>
                              <th>Select Accessory</th>
                              <th>Product Price</th>
                              <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                              <th>Quantity</th>
                              <th>Unit Price</th>
                              <th></th>
                              </tr>
                              <tr>
                              <td>
                              <select id='non-config-products-select' class="accessory-name" name="">
                              <option selected="selected" disabled="disabled">Select Product ...</option>
                              <?php
                              foreach ($non_config_products as $k => $v) {
                              ?>
                              <option readonly data-name="<?php echo $v['name'] ?>" data-price="<?php echo $v['price'] ?>" value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
                              <?php
                              }
                              ?>
                              </select>
                              </td>
                              <td>
                              <input class='accessory-input-control' id='accessory-current-price' type="text" value="">
                              </td>
                              <td></td>
                              <td>
                              <input class='accessory-input-control' id='accessory-quantity' type="number" min="1" value="">
                              </td>
                              <td>
                              <input class='accessory-input-control' id='accessory-price' type="text" value="">
                              </td>
                              <td>
                              <button id='add-accessory-btn' type="button" name="button">Add Accessory</button>
                              </td>
                              </tr>
                              </table> */ ?>

                        </div>
                        <br><br>

                        <p>Accessories</p>
                        <div class="current-accessories-div">
                            <table>
                                <tr id="current-accessories-head-tr">
                                    <th>SN</th>
                                    <th>Product Id</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Action</th>
                                </tr>
                                <?php
                                if ($accessories) {
                                    $sn = 1;
                                    foreach ($accessories as $k => $v) {
                                        ?>
                                        <tr class='accessories-row'>
                                            <td><?php echo $sn ?></td>
                                            <td><?php echo $v['product_id'] ?></td>
                                            <td><?php echo $v['name'] ?></td>
                                            <td><?php echo $v['quantity'] ?></td>
                                            <td><?php echo $v['price'] ?></td>
                                            <td>
                                                <a href="#" class="remove-accessory-btn" data-accessory-id="<?php echo $v['id'] ?>" onclick="return false;">Remove</a>
                                            </td>
                                        </tr>
                                        <?php
                                        $sn++;
                                    }
                                }
                                ?>
                            </table>
                            <input id="accessories-input" type="hidden" name="accessories" value="">
                        </div>
                    </div>
                    <div class="tab-pane fade clearfix" id="tabs-8">
                        <p>Select Brochures</p>
                        <?php if (!empty($brochures)) { ?>
                            <ul class="list-inline brochureList">
                                <?php foreach ($brochures as $brochure) { ?>
                                <li class="col-lg-4 col-sm-4 col-xs-12"><label><input type="checkbox" name="brochures[]" value="<?= $brochure['id'] ?>"><?= $brochure['brochure'] ?></label></li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <p align="center">Fields marked with <span class="error">*</span> are required.</p>
            <p align="center"><input type="submit" name="button" id="button" value="Submit" class="btn btn-primary"></p>
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
                /*dataSrc: function (json) {
                 var rows = [];
                 for (var i = 0; i < json.data.length; i++) {
                 if (selected_products.indexOf(json.data[i].id) == -1) {
                 rows.push(json.data[i]);
                 }
                 }
                 return rows;
                 },*/
                "data": function (data) {
                    var selectedValues = [];
                    $(".all-checkbox").prop("checked", false)
                    jQuery("input[name='attributesList[]']:checked").each(function () {
                        var va = $(this).val();
                        selectedValues.push(va);
                    });
                    data.attrbs = selectedValues;
                    return data;
                }
            },
            createdRow: function (row, data, index) {
                $(row).attr('data-obj', JSON.stringify(data));
            },
            "columns": [
                {
                    "data": "checkbox",
                    render: function (data, type, row, meta) {
                        var is_selected = 0;
                        if (inArray(parseInt(row.id), selected_products)) {
                            is_selected = 1;
                        }
                        return '<input class="accessory-input-control accessory-price chpd" ' + (is_selected ? 'checked' : '') + ' data-id="' + row.id + '"  type="checkbox" value="' + row.id + '">';
                    },
                    "orderable": false,
                    "targets": [0]
                },
                {"data": "sku"},
                {
                    "data": "name",
                    render: function (data, type, row, meta) {
                        return '<a href="catalog/product/edit/' + row.id + '" target="_blank">' + row.name + '</a>';

                    }
                },
                {"data": "attr_label"},
                {
                    "data": "price",
                    render: function (data, type, row, meta) {
                        return '<input type="text"  id="pro_price' + row.id + '" data-label="' + row.name + '" data-value="' + row.attr_id + '"  value="' + row.price + '" >';
                    }
                },
                {"data": "quantity",
                    render: function (data, type, row, meta) {
                        return '<input id="pro_quantity' + row.id + '" type="text" data-label="' + row.name + '" data-value="' + row.attr_id + '"  value="' + row.quantity + '" >';
                    }
                },
                {
                    "data": "assign",
                    render: function (data, type, row, meta) {
                        return '<button data-label="' + row.name + '" data-id="' + row.id + '" data-value="' + row.attr_id + '" id="assign_product' + row.id + '" class="btn btn-primary bt-updch" type="button">Udpate</button>';
                        /*return '<button data-label="' + row.name + '" data-value="' + row.attr_id + '" id="assign_product' + row.id + '" class="btn btn-primary" type="button" onclick="checkAttribute(this)">Add</button>';*/
                    }
                }
            ]
        });

    }

    $objDT.on("click", ".bt-updch", function () {
        var id = $(this).attr("data-id");
        var pro_price = $("#pro_price" + id).val();
        var pro_quantity = $("#pro_quantity" + id).val();
        /*$.post('catalog/product/chld_update', {
         product_id: id,
         price:pro_price,
         quantity:pro_quantity
         },
         function (data, status) {
         
         });*/
    });

    $objDT.on("click", ".chpd", function () {
        var id = $(this).attr("data-id");
        if ($(this).is(":checked")) {
            selected_products.push(parseInt(id));
        }
        else {
            var index = selected_products.indexOf(parseInt(id));
            if (index > -1) {
                selected_products.splice(index, 1);
            }
        }
    });
    $objDT.on("click", ".all-checkbox", function () {
        var selectAll = false;
        if ($(this).is(":checked")) {
            selectAll = true;
        }
        $(".chpd").each(function () {
            var id = $(this).attr("data-id");
            if (selectAll) {
                var index = selected_products.indexOf(parseInt(id));
                if (index == -1) {
                    selected_products.push(parseInt(id));
                }
                $(this).prop("checked", true);
            }
            else {
                var index = selected_products.indexOf(parseInt(id));
                if (index > -1) {
                    selected_products.splice(index, 1);
                    $(this).prop("checked", false);
                }
            }
        });
    });

    $("#cateAttributesID").on("click", ".att-chkbx-a", function () {
        var txt;
        if (confirm("Are you sure this will require to reselect child products?")) {
            selected_products = [];
            $objDT.DataTable().ajax.reload();
        } else {
            return false;
        }
    });

    $(document).ready(function () {
        $("[name='type']").change(function () {
            var value = $(this).val();
            if (value == 'bundle') {
                $('.min_order_quantity').show();
                $('.tabs-5').show();
            }
            else {
                $('.min_order_quantity').hide();
                $('.tabs-5').hide();
            }
        });
        $("[name='category_id']").change(function (evt) {
            loadChildProductList();
        });
        $("[name='type']").change(function (evt) {
            loadChildProductList();
        });

        $("#addTier").click(function (event) {
            event.preventDefault();
            var $wrObj = jQuery(".wrap_selects");
            var tbody = $(this).parents("table").children("tbody");
            var nextIndex = parseInt(parseInt($wrObj.attr("data-rows-index")) + 1);
            $wrObj.attr("data-rows-index", nextIndex);
            var tierRow = '<tr><td><select name="tier_profgroup[]" id="tier_profgroup" class="form-control"><option class="selAllProfile" value="0">All</option>' + '<?php
                        if ($profileGroup) {
                            foreach ($profileGroup as $k) {
                                ?><option value="<?php echo $k['id']; ?>"><?php echo $k['profile_name']; ?></option><?php
                            }
                        }
                        ?>' + '</select></td><td><input name="tier_qty[]" class="form-control" id="tier_qty" value="" size="40" type="text"></td><td><input name="tier_price[]" class="form-control" id="tier_price" value="" size="40" type="text"></td><td><a href="javascript:void(0);" class="btn btn-danger" onclick="removeTier(this)" >Remove</a></td></tr>';

                                    tbody.append(tierRow);
                                    //alert($(this).parents("table").children("tbody").html());
                                });

                                $(document).on('click', '.selAllProfile', function () {
                                    $(this).attr('selected', false);
                                    $(this).nextAll('option').attr('selected', true);
                                    $(this).nextAll('option').prop('selected', true);
                                });

                            });

                            function removeTier(element) {
                                //alert($(element).parents("tr").html());
                                $(element).parents("tr").remove();
                            }
                            $("#selectedProducts").on("click", ".removeSelectedPrd", function () {
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
                                // $("#datatable-example").dataTable().draw();
                            });

</script>
<script>
    $(document).ready(function () {
        $('.fa-plus-square').click(function (e) {
            var html = '';
            html += '<li class="">';
            html += '<div class="col-lg-10">';
            html += '<input name="custom_option[logo_print_location][]" class="form-control"/>';
            html += '</div>';
            html += '<div class="col-lg-2">';
            html += '<i class="fa fa-window-close fa-4" style="font-size:30px;cursor:pointer" aria-hidden="true"></i>';
            html += '</div>';
            html += '</li>';
            $('.logo_location_custom_options').append(html);
        });
        $(document).on('click', '.fa-window-close', function (e) {
            $(this).parent().parent().remove();
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('.new-div').hide();
        $('#new-no').prop('checked', 'true');

        $('#new-yes').click(function () {
            $('.new-div').show();
        });

        $('#new-no').click(function () {
            $('.new-div').hide();
        });

        $('#pdf-input').change(function () {
            $('#pdf-upload-btn').trigger('click');
        });

        $('#pdf-upload-btn').on('click', function () {
            var file_data = $('#pdf-input').prop('files')[0];
            var filename = file_data.name;
            var form_data = new FormData();
            form_data.append('file', file_data);
            $.ajax({
                url: 'catalog/product/upload_pdf',
                dataType: 'text',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function (php_script_response) {
                    var code = '<li>' + filename + '</li>';
                    $('#temp-pdf-ul').append(code);
                }
            });
        });

    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        var accessories = [];
        var item_id = 0;

        /*$('#non-config-products-select').change(function() {
         $('#accessory-current-price').val($('#non-config-products-select :selected').attr('data-price'));
         $('#accessory-quantity').focus();
         $('#accessory-quantity, #accessory-price').val('');
         });*/

        $("#add-accessory-table").on("click", ".add-access", function () {
            var aId = $(this).attr('data-id');
            var name = $(this).attr('data-name');
            var qty = $("#accessory_quantity" + aId).val();
            var accessory_price = $("#accessory_price" + aId).val();

            var obj = {id: item_id,
                product_id: aId,
                name: name,
                quantity: qty,
                price: accessory_price
            };

            var d_flag = false;
            $.each(accessories, function (index, element) {
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

                    $.each(accessories, function (index, item) {
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

        $(document).on('click', '.remove-accessory-btn', function () {
            var accessory_id = $(this).attr('data-accessory-id');
            accessories.splice(accessory_id, 1);

            var temp = [];
            temp = accessories;

            $('.accessories-row').remove();
            item_id = 0;
            var sn = accessories.length;
            accessories = [];

            $.each(temp, function (index, item) {
                var obj = {id: item_id, product_id: item.product_id, name: item.name, quantity: item.quantity, price: item.price};
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


    $(document).ready(function () {
        $('#add-accessory-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "catalog/ajax/product/non_config_products",
                "type": "POST",
                /*dataSrc: function (json) {
                 con
                 var rows = [];
                 for (var i = 0; i < json.data.length; i++) {
                 rows.push(json.data[i]);
                 }
                 return rows;
                 },*/
            },
            //createdRow: function (row, data, index) {
            //$(row).attr('data-obj', JSON.stringify(data));
            //},
            "columns": [
                {"data": "name"},
                {"data": "price"},
                {
                    "data": "quantity",
                    render: function (data, type, row, meta) {
                        return '<input class="accessory-input-control accessory-quantity accessory_quantity2" id="accessory_quantity' + row.id + '" type="number" min="1" value="">';
                    }
                },
                {
                    "data": "price",
                    render: function (data, type, row, meta) {
                        return '<input class="accessory-input-control accessory-price accessory_quantity2" id="accessory_price' + row.id + '" type="text" min="1" value="">';
                    }
                },
                {
                    "data": "assign",
                    render: function (data, type, row, meta) {
                        return '<button id="add-accessory-btn' + row.id + '" data-id="' + row.id + '" data-name="' + row.name + '" class="add-access nn-style-btn-pro-add" type="button" name="button">Add</button>';
                    }
                }
            ]
        });


        jQuery("#addcatform").submit(function () {
            jQuery("#childPdField").val(selected_products.join());
        });
    });
</script>
<style>
    .accessory_quantity2{
        width:70px;
    }
    .accessory_price2{
        width:70px;
    }
    .nn-style-btn-pro-add{
        border: none;
        background: #495d80;
        color: black;
        padding: 4px 13px;
    }
    .brochureList label {cursor: pointer;}
</style>