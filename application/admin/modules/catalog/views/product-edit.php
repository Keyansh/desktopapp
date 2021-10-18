<?php
// e($product);
?>
<style type="text/css">
    #table-3 td {
        border: 1px solid #DFE8F1;
        padding: 8px 13px;
        font-size: 14px;
    }

    #loadergif {
        display: none;
    }

    #submitImageInfo {
        color: #fff;
        border: none;
        background: #333;
        padding: 6px 15px;
    }
</style>
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/widgets/datatable/datatable.css">
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable-bootstrap.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable-tabletools.js"></script>
<script type="text/javascript">
    var selected_products = [<?php echo implode(",", $child_ids); ?>];
    var selected_attrs = [<?php echo implode(",", $selected_attrs); ?>];



    function inArray(needle, haystack) {
        var length = haystack.length;
        for (var i = 0; i < length; i++) {
            if (haystack[i] == needle)
                return true;
        }
        return false;
    }

    $(document).ready(function() {
        // Set New start and end date code begins here
        $('.datepicker').datepicker({
            minDate: 0,
            dateFormat: 'dd-mm-yy'
        });

        var newStartDate = '<?php echo $product["new_start_date"] ?>';
        var newEndDate = '<?php echo $product["new_end_date"] ?>';

        $('#new_start_date').datepicker('setDate', newStartDate);
        $('#new_end_date').datepicker('setDate', newEndDate);

        // End

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
    Edit Product
    <a href="catalog/product/index">Manage Products</a>
</h3>
<div class="panel">
    <div class="panel-body">
        <?php $this->load->view('inc-messages'); ?>

        <form action="catalog/product/edit/<?php echo $product['id']; ?>" method="post" enctype="multipart/form-data" name="addcatform" id="addcatform">


            <div class="example-box-wrapper">
                <ul id="myTab" class="nav clearfix nav-tabs">
                    <li class="active"><a href="#tabs-0" data-toggle="tab">Main</a></li>
                    <li><a href="#tabs-1" data-toggle="tab">Metadata</a></li>
                    <li id="attrHi"><a href="#tabs-2" data-toggle="tab">Attributes</a></li>
                    <li><a href="#tabs-3" data-toggle="tab">Images</a></li>
                    <li id="childPro"><a href="#tabs-4" data-toggle="tab">Child Product</a></li>
                    <?php
                    if ($product['type'] == 'bundle')
                        $style = "";
                    else
                        $style = "display:none";
                    ?>
                    <li style="<?= $style ?>"><a href="#tabs-5" data-toggle="tab">Custom Options</a></li>
                    <li class="tabs-6"><a href="#tabs-6" data-toggle="tab">PDFs</a></li>
                    <?php
                    if (isset($non_config_products) && $non_config_products) {
                    ?>
                        <li class="tabs-7"><a href="#tabs-7" data-toggle="tab">Accessories</a></li>
                    <?php
                    }
                    ?>
                    <li class="tabs-8"><a href="#tabs-8" data-toggle="tab">Brochures</a></li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="tabs-0">
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Select Category <span class="error">*</span></label>
                            <div class="col-sm-6"><?php echo form_dropdown('category_id', $categories, set_value('category_id', $procat['cid']), ' class="form-control" id="category" data-old="' . $procat['cid'] . '"'); ?></div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Select Attribute Set <span class="error">*</span></label>
                            <div class="col-sm-6">
                                <select name="attrsetid" class="form-control" id="attribute_set">
                                    <option value="0"> - select - </option>
                                    <?php
                                    foreach ($attributes_sets as $setitem) {
                                        $selectedText = '';
                                        if ($setitem['id'] == $product['attr_set_id']) {
                                            $selectedText = 'selected=""';
                                        }
                                        echo '<option value="' . $setitem['id'] . '" ' . $selectedText . '> ' . $setitem['name'] . ' </option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Select Other Categories</label>
                            <div class="col-sm-6">
                                <select name="categoriesIds[]" class="form-control" id="categoriesIds" multiple>
                                    <?php
                                    foreach ($catSecArray as $catSecArr) {
                                        echo '<option value="' . $catSecArr['id'] . '" ' . (in_array($catSecArr['id'], $proSecCatKeys) ? 'selected="selected"' : '') . '>' . $catSecArr['name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group clearfix">

                            <?php if ($product['type'] == "config") { ?>
                                <label class="col-sm-2 control-label">Product Type</label>
                                <div class="col-sm-6"><strong class="form-control">&nbsp;Configurable</strong></div>
                                <input type="hidden" name="type" value="<?php echo $product['type']; ?>">
                            <?php } elseif ($product['type'] == "bundle") { ?>
                                <label class="col-sm-2 control-label">Product Type</label>
                                <div class="col-sm-6"><strong class="form-control">&nbsp;Bundle</strong></div>
                                <input type="hidden" name="type" value="<?php echo $product['type']; ?>">
                            <?php } else { ?>
                                <label class="col-sm-2 control-label">Product Type <span class="error">*</span></label>
                                <div class="col-sm-6"><?php echo form_dropdown('type', $proType, set_value('type', $product['type']), ' class="form-control proType" id="proType"'); ?></div>
                            <?php } ?>

                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Select Brand</label>
                            <div class="col-sm-6">
                                <select name="brand_id" class="form-control" id="brand_id">
                                    <option value="0"> - select - </option>
                                    <?php foreach ($brands as $brand) { ?>
                                        <option value="<?= $brand['id'] ?>" <?= ($product['bid'] == $brand['id']) ? 'selected' : '' ?>> <?= $brand['name'] ?> </option>
                                    <?php }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Product Name <span class="error"> *</span></label>
                            <div class="col-sm-6"><input name="name" type="text" class="form-control" id="name" value="<?php echo set_value('name', $product['name']); ?>" size="40"></div>
                        </div>

                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Product URI</label>
                            <div class="col-sm-6"><input name="uri" type="text" class="form-control" id="uri" value="<?php echo set_value('uri', $product['uri']); ?>" size="40">&nbsp;(Will be auto-generated if left blank)</div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">SKU <small><span class="error">*</span></small></label>
                            <div class="col-sm-6"><input name="sku" type="text" class="form-control" id="sku" value="<?php echo set_value('sku', $product['sku']); ?>" size="40"></div>
                        </div>
                        <?php if (!empty($parent)) { ?>
                            <div class="form-group clearfix">
                                <label class="col-sm-2 control-label">Parent SKU </label>
                                <div class="col-sm-6"><input name="parent_sku" type="text" class="form-control" id="parent_sku" value="<?php echo $parent['sku']; ?>" size="40"></div>
                            </div>
                        <?php } ?>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Price </label>
                            <div class="col-sm-6">
                                <?php
                                if ($product['price'] > 0) {
                                ?>
                                    <input name="price" type="text" class="form-control" id="price" value="<?php echo set_value('price', $product['price']); ?>" size="40">
                                <?php
                                } else {
                                ?>
                                    <input name="price" type="text" class="form-control" id="price" value="0" size="40">
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                        if ($product['type'] = "config") {
                            //                            e($least_price);
                        ?>
                            <div class="form-group clearfix">
                                <label class="col-sm-2 control-label">Least price <small><span class="error">*</span></small></label>
                                <div class="col-sm-6">
                                    <input name="least_price" type="text" class="form-control" id="sku" value="<?php echo set_value('least_price', $least_price); ?>" size="40">
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-sm-2 control-label"></label>
                                <div class="col-sm-6">
                                    <input type="checkbox" name="is_change_price_for_child" value="1"><label>Will price change for standard's?</label>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Manufacturer's Suggested Retail Price</label>
                            <div class="col-sm-6"><input name="srp_price" type="text" class="form-control" id="srp_price" value="<?php echo set_value('srp_price', $product['srp_price']); ?>" size="40"></div>
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
                                    <tbody>
                                        <?php
                                        if ($editProfiles) {
                                            foreach ($editProfiles as $key => $value) {
                                        ?>
                                                <tr>
                                                    <td>
                                                        <select name="tier_profgroup[]" id="tier_profgroup" class="form-control" width="40">
                                                            <option value="0" <?= ($value['tier_profile_id'] == 0) ? 'selected' : '' ?>>All</option>
                                                            <?php
                                                            if ($profileGroup) {
                                                                foreach ($profileGroup as $v) {
                                                            ?>
                                                                    <option value="<?php echo $v['id'] ?>" <?php echo ($v['id'] == $value['tier_profile_id']) ? 'selected' : '' ?>><?php echo $v['profile_name'] ?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>

                                                    </td>

                                                    <td>
                                                        <input name="tier_qty[]" type="text" class="form-control" id="tier_qty" value="<?php echo set_value('tier_qty', $value['tier_qty']); ?>" size="20">
                                                    </td>
                                                    <td>
                                                        <input name="tier_price[]" type="text" class="form-control" id="tier_price" value="<?php echo set_value('tier_price', $value['tier_price']); ?>" size="40">
                                                        <input name="tier_id[]" type="hidden" value="<?php echo set_value('tier_id', $value['tier_id']); ?>">
                                                    </td>
                                                    <td>
                                                        <a href="javascript:void(0);" class="fa fa-trash-o delete-icon" onclick="removeTier(this)"></a>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <tr>
                                                <td>
                                                    <select name="tier_profgroup[]" id="tier_profgroup" class="form-control" width="40">
                                                        <option value="0">All</option>
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
                                                    <a href="javascript:void(0);" class="btn btn-danger" onclick="removeTier(this)">Remove</a>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
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
                            <div class="col-sm-6"><input name="bundle_qty" type="text" class="form-control" id="bundle_qty" value="<?php echo set_value('bundle_qty', $product['bundle_qty']); ?>" size="40"><small>Only numbers e.g. 0,10,100 etc.</small></div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Quantity <small><span class="error">*</span></small></label>
                            <div class="col-sm-6"><input name="quantity" type="text" class="form-control" id="quantity" value="<?php echo set_value('quantity', $product['quantity']); ?>" size="40"></div>
                        </div>

                        <!-- <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Set Up Cost <small><span class="error"></span></small></label>
                            <div class="col-sm-6"><input name="set_up_cost" type="text" class="form-control" id="quantity" value="<?php echo set_value('set_up_cost', $product['set_up_cost']); ?>" size="40"></div>
                        </div> -->

                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Alert Quantity <small><span class="error">*</span></small></label>
                            <div class="col-sm-6"><input name="alert_qty" type="number" class="form-control" id="alert_qty" value="<?php echo set_value('alert_qty', $product['alert_qty']); ?>" size="40"></div>
                        </div>

                        <?php
                        $style = '';
                        if ($product['type'] != 'bundle') {
                            $style = 'display:none';
                        }
                        ?>
                        <div class="form-group clearfix" style="<?= $style ?>">
                            <label class="col-sm-2 control-label">Minimum Order Quantity</label>
                            <div class="col-sm-6"><input name="min_order_quantity" type="number" class="form-control" id="min_order_quantity" value="<?php echo set_value('min_order_quantity', $product['min_order_quantity']); ?>" size="40"></div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Brief Description</label>
                            <div class="col-sm-6"><textarea name="brief_description" style="width:99%;height:100px;" class="form-control" id="brief_description"><?php echo set_value('brief_description', $product['brief_description']); ?></textarea></div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Full Description </label>
                            <div class="col-sm-12"><textarea name="description" style="width:99%;" class="form-control" id="description"><?php echo set_value('description', $product['description']); ?></textarea></div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Product Dimensions</label>
                            <div class="col-sm-12"><textarea name="dimensions" style="width:99%" class="form-control"><?php echo set_value('dimensions', $product['dimensions']); ?></textarea></div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Product Tags</label>
                            <div class="col-sm-12"><textarea name="tags" style="width:99%" class="form-control"><?php echo set_value('tags', $product['tags']); ?></textarea></div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Product Specifications</label>
                            <div class="col-sm-12">
                                <textarea name="product_specifications" style="width:99%;height:100px;" class="form-control" id="brief_description"><?php echo set_value('product_specifications', $product['product_specifications']); ?></textarea>
                            </div>
                        </div>
                        <!-- <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Payment and Delivery Options</label>
                            <div class="col-sm-6">
                                <textarea name="payment_delivery_options" style="width:99%;height:100px;" class="form-control" id="payment_delivery_options"><?php echo set_value('payment_delivery_options', $product['payment_delivery_options']); ?></textarea>
                            </div>
                        </div> -->
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Is Featured</label>
                            <div class="col-sm-6">
                                <input type="radio" name="is_featured" value="1" <?php echo set_radio('is_featured', 1, ($product['is_featured'] == 1)); ?> />Yes
                                <input type="radio" name="is_featured" value="0" <?php echo set_radio('is_featured', 0, ($product['is_featured'] == 0)); ?> />NO
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Is New</label>
                            <div class="col-sm-6">
                                <input id='new-yes' type="radio" name="is_new" value="1" <?php echo set_radio('is_new', 1, ($product['is_new'] == 1)); ?> />Yes
                                <input id='new-no' type="radio" name="is_new" value="0" <?php echo set_radio('is_new', 0, ($product['is_new'] == 0)); ?> />NO
                                <div class="new-div">
                                    <div class="">
                                        <span>New Start Date</span><input id="new_start_date" class="datepicker" data-date-format="dd/mm/yyyy" name="new_start_date">
                                    </div>
                                    <div class="">
                                        <span style="display:inline-block;width:110px;">New End Date</span><input id="new_end_date" class="datepicker" data-date-format="/dd/mm/yyyy" name="new_end_date">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Is Bespoke</label>
                            <div class="col-sm-6">
                                <input type="radio" name="is_bespoke" value="1" <?php //echo set_radio('is_bespoke', 1, ($product['is_bespoke'] == 1));                                                                           
                                                                                ?> />Yes
                                <input type="radio" name="is_bespoke" value="0" <?php //echo set_radio('is_bespoke', 0, ($product['is_bespoke'] == 0));                                                                           
                                                                                ?> />NO

                            </div>
                        </div> -->
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Is Taxable</label>
                            <div class="col-sm-6">
                                <input type="radio" name="is_taxable" value="1" <?php echo set_radio('is_taxable', 1, ($product['is_taxable'] == 1)); ?> />Yes
                                <input type="radio" name="is_taxable" value="0" <?php echo set_radio('is_taxable', 0, ($product['is_taxable'] == 0)); ?> />NO
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Product Price is</label>
                            <div class="col-sm-6">
                                <input type="radio" name="inc_or_exl_tax" value="1" <?php echo set_radio('inc_or_exl_tax', 1, ($product['inc_or_exl_tax'] == 1)); ?> /> Including Tax
                                <input type="radio" name="inc_or_exl_tax" value="2" <?php echo set_radio('inc_or_exl_tax', 2, ($product['inc_or_exl_tax'] == 2)); ?> /> Not Including Tax
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tabs-1">

                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Meta Title<br /></label>
                            <div class="col-sm-6"><textarea name="meta_title" cols="40" rows="4" style="width:99%" class="form-control" id="meta_title"><?php echo set_value('meta_title', $product['meta_title']); ?></textarea></div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Meta Keywords<br /></label>
                            <div class="col-sm-6"><textarea name="meta_keywords" cols="40" rows="4" style="width:99%" class="form-control" id="meta_keywords"><?php echo set_value('meta_keywords', $product['meta_keywords']); ?></textarea></div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Meta Description<br /></label>
                            <div class="col-sm-6"><textarea name="meta_description" cols="40" rows="4" style="width:99%" class="form-control" id="meta_descriptoin"><?php echo set_value('meta_descriptoin', $product['meta_description']); ?></textarea></div>
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

                        <div class="product_images">
                            <?php
                            if ($proimg) {
                            ?>
                                <div class="clearfix notesforsortorder">Note :- Press update button for update the images information and sorting order.</div>
                                <ul class='multiple-images list-inline ' id="images-sorting">
                                    <?php
                                    foreach ($proimg as $img) {
                                        $path = $this->config->item('PRODUCT_PATH') . $img['img'];
                                    ?>
                                        <li id="img_<?php echo $img['id']; ?>">
                                            <div class="img-top">
                                                <img class="brandImageSection" style="width:100px" src="<?php echo $this->config->item('PRODUCT_URL') . $img['img']; ?>" border="0" />
                                            </div>
                                            <div class="clearfix">
                                                <input type="text" class="pimagesort" data-iid="<?php echo $img['id']; ?>" data-pid="<?php echo $product['id']; ?>" name="ImgSortOrder[<?php echo $img['id']; ?>][]" placeholder="sort order" style="width:100px" value="<?= ($img['sort_order']) ? $img['sort_order'] : ''; ?>"><br>
                                                <!--<input type="text" data-iid="<?php echo $img['id']; ?>" data-pid="<?php echo $product['id']; ?>"  name="Imgdesc[<?php echo $img['id']; ?>][]" placeholder="description" style="width:100px" value="<?= ($img['desc']) ? $img['desc'] : ''; ?>">-->
                                                <textarea name="Imgdesc[<?php echo $img['id']; ?>][]" class="Imgdesc" data-iid="<?php echo $img['id']; ?>" data-pid="<?php echo $product['id']; ?>" rows="2" cols="10" placeholder="Describe img desc..."><?= ($img['desc']) ? $img['desc'] : ''; ?></textarea>
                                            </div>
                                            <div class="img-bot">
                                                <div class="remove-image" style="cursor:pointer" image-id=<?php echo $img['id']; ?> id="product_image<?php echo $img['id']; ?>" href="escort/remove_image/<?php echo $img['id']; ?>" title="remove">
                                                    <i class="fa fa-trash red" aria-hidden="true">remove</i></div>
                                                <div title="main">
                                                    <i class="fa fa-star" aria-hidden="true">
                                                        <input type="radio" <?= ($img['main'] == 1) ? "checked='checked'" : '' ?> name="mainimg" value="<?php echo $img['id']; ?>">
                                                    </i></div>
                                                <!--
                                                <div class="edit-image" vid="<?php echo $img['visible']; ?>"  eid="<?php echo $product['id']; ?>" id="<?php echo $img['id']; ?>" href="escort/edit_image/<?php echo $img['id']; ?>" title="Edit">
                                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                </div>
                                                <div class="visible-image" id="<?php echo $img['id']; ?>" href="escort/visible_image/<?php echo $img['id']; ?>" ><?= $img['visible'] == 1 ? ' <i class="fa fa-eye green" aria-hidden="true"></i>' : '<i class="fa fa-eye" aria-hidden="true"></i>'; ?></div>
                                                <div class="favrate-image" eid="<?php echo $product['id']; ?>" id="<?php echo $img['id']; ?>" href="escort/favrate_image/<?php echo $img['id']; ?>" title="Favourite">
                                                <?php
                                                if ($img['main'] == 1) {
                                                    echo '<i class="fa fa-star green" aria-hidden="true">*</i>';
                                                } else {
                                                    echo '<i class="fa fa-star" aria-hidden="true"></i>';
                                                }
                                                ?></div>
                                                <div class="CatImageList " eid="<?php echo $product['id']; ?>" id="<?php echo $img['id']; ?>"  title="Category Image Listing"><i class="fa fa-list" aria-hidden="true"></i></div>
                                                -->
                                            </div>
                                        </li>
                                    <?php
                                        // }
                                    }
                                    ?>
                                </ul>
                                <p class="image-sorting-text" style="color: #495d80;font-size: 18px;font-style: italic;"><span class="sortinText"></span><img id="loadergif" src="<?php echo base_url(); ?>img/loader-gif.gif" width="35px" /></p>
                                <button type="button" id="submitImageInfo">Update Image Info.</button>
                            <?php } ?>

                        </div>
                    </div>
                    <div class="tab-pane fade clearfix" id="tabs-4">
                        <div class="error_messages"></div>
                        <div class="cateAttributes" id="cateAttributesID"></div>

                        <div class="childprod">
                            <div class="page-header">
                                <h2>Child Products (<?= !empty($child_ids) ? count($child_ids) : '0'; ?>)</h2>
                            </div>
                            <table class="table table-bordered table-responsive" id="datatable-example" class="table table-bordered table-responsive">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" class="all-checkbox" value="1" name="" /></th>
                                        <th style="color:black;">SKU</th>
                                        <th style="color:black;">Name</th>
                                        <th style="color:black;">Assigned Attributes </th>
                                        <th style="color:black;">Price</th>
                                        <th style="color:black;">Stock</th>
                                        <th style="color:black;">Assign</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <?php /* <div class="childprodsd">
                          <?php
                          if ($prosiblings) {
                          foreach ($prosiblings as $prosibling) {
                          if ($prochild) {
                          echo '<div class="col-lg-3 childProd"><label><input type="checkbox" name="childProduct[]"' . (in_array($prosibling['id'], $prochild) ? 'checked="checked"' : '') . ' value="' . $prosibling['id'] . '">  ' . $prosibling['name'] . '</label></div>';
                          } else {
                          echo '<div class="col-lg-3 childProd"><label><input type="checkbox" name="childProduct[]" value="' . $prosibling['id'] . '">  ' . $prosibling['name'] . '</label></div>';
                          }
                          }
                          }
                          ?>
                          </div> */ ?>
                    </div>
                    <div class="tab-pane fade clearfix" id="tabs-5">
                        <div class="error_messages"></div>
                        <div class="row">
                            <div class="form-group">
                                <label class="form-label">Logo Print Locations</label>
                                <ul class="logo_location_custom_options">
                                    <?php foreach ($custom_options as $option) { ?>
                                        <li class="">
                                            <div class="col-lg-10">
                                                <input name="custom_option[logo_print_location][]" type="text" value="<?= $option['value'] ?>" class="form-control" />
                                                <input name="logo_print_location[]" value="<?= $option['id'] ?>" type="hidden" />
                                            </div>
                                            <div class="col-lg-2">
                                                <i class="fa fa-window-close fa-4" style="font-size:30px;cursor:pointer" aria-hidden="true"></i>
                                            </div>
                                        </li>
                                    <?php } ?>
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
                                <?php
                                if (isset($pdfs)) {
                                    if ($pdfs) {
                                        foreach ($pdfs as $item) {
                                ?>
                                            <li><?php echo $item['pdf'] ?>
                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                <span id="<?php echo $item['id'] ?>" class="remove-pdf">&times;</span>
                                            </li>
                                <?php
                                        }
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <?php
                    if (isset($non_config_products) && $non_config_products) {
                    ?>
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
                                    <?php /* <tr>
                                      <td>
                                      <input id="non-config-products-select"/>

                                      <?php /*<select id='non-config-products-select' class="accessory-name" name="">
                                      <option selected="selected" disabled="disabled">Select Product ...</option> */ ?>
                                    <?php
                                    /* foreach ($non_config_products as $k => $v) {
                                      ?>
                                      <option data-name="<?php echo $v['name'] ?>" data-price="<?php echo $v['price'] ?>" value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
                                      <?php
                                      } */
                                    ?>
                                    <?php /* </select> */ ?>
                                    <?php /*        <input id='config-pd-id' type="hidden" value="">
                                      </td>
                                      <td>
                                      <input class='accessory-input-control' readonly id='accessory-current-price' type="text" value="">
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
                                      </tr> */ ?>
                                </table>
                            </div>
                            <br><br>
                            <p>Accessories</p>
                            <div class="current-accessories-div">
                                <table>
                                    <tr id="current-accessories-head-tr">
                                        <th style="color:black;">SN</th>
                                        <th style="color:black;">Product Id</th>
                                        <th style="color:black;">Product Name</th>
                                        <th style="color:black;">Quantity</th>
                                        <th style="color:black;">Unit Price</th>
                                        <th style="color:black;">Action</th>
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
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                    <div class="tab-pane fade clearfix" id="tabs-8">
                        <p>Select Brochures</p>
                        <?php if (!empty($brochures)) { ?>
                            <ul class="list-inline brochureList">
                                <?php foreach ($brochures as $brochure) { ?>
                                    <li class="col-lg-4 col-sm-4 col-xs-12"><label><input type="checkbox" name="brochures[]" value="<?= $brochure['id'] ?>" <?= !empty($selectedbrochures) ? (in_array($brochure['id'], $selectedbrochures)) ? 'checked' : '' : '' ?>><?= $brochure['brochure'] ?></label></li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </div>
                    <p align="center">Fields marked with <span class="error">*</span> are required.</p>
                    <input type="hidden" name="assign_product" value="" id="childPdField">
                    <p align="center"><input type="submit" name="button" id="button" value="Submit" class="btn btn-primary"></p>
        </form>
    </div>
</div>
<?php
// e($product,0);
// e($mainCategory);
?>
<script type="text/javascript">
    <?php if (($product['type'] == 'config') || ($product['type'] == 'bundle')) : ?>
        var $objDT = $("#datatable-example");
        $(document).ready(function() {
            $("#cateAttributesID").on("click", ".att-chkbx-a", function() {
                var txt;
                if (confirm("Are you sure this will require to reselect child products?")) {
                    selected_products = [];
                    $objDT.DataTable().ajax.reload();
                } else {
                    return false;
                }
            });
        });

        function callDT() {
            $objDT.DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "catalog/ajax/product/childProducts/<?= $mainCategory['id'] . '/' . $product['id'] ?>",
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
                    "data": function(data) {
                        $(".all-checkbox").prop("checked", false);
                        var selectedValues = [];
                        if (selected_attrs.length > 0) {
                            selectedValues = selected_attrs;
                            selected_attrs = [];
                        } else {
                            jQuery("input[name='attributesList[]']:checked").each(function() {
                                var va = $(this).val();
                                selectedValues.push(va);
                            });
                        }
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
                            return '<a href="catalog/product/edit/' + row.id + '" target="_blank">' + row.name + '</a>';

                        }
                    },
                    {
                        "data": "attr_label"
                    },
                    {
                        "data": "price",
                        render: function(data, type, row, meta) {
                            return '<input type="text" class="width70px" id="pro_price' + row.id + '" data-label="' + row.name + '" data-value="' + row.attr_id + '"  value="' + row.price + '" >';
                        }
                    },
                    {
                        "data": "quantity",
                        render: function(data, type, row, meta) {
                            return '<input class="width100px" id="pro_quantity' + row.id + '" type="text" data-label="' + row.name + '" data-value="' + row.attr_id + '"  value="' + row.quantity + '" >';
                        }
                    },
                    {
                        "data": "assign",
                        render: function(data, type, row, meta) {
                            return '<button data-label="' + row.name + '" data-id="' + row.id + '" data-value="' + row.attr_id + '" id="assign_product' + row.id + '" class="btn btn-primary bt-updch" type="button">Udpate</button>';
                            /*return '<button data-label="' + row.name + '" data-value="' + row.attr_id + '" id="assign_product' + row.id + '" class="btn btn-primary" type="button" onclick="checkAttribute(this)">Add</button>';*/
                        }
                    }
                ],
                "pageLength": 100
            });
        }
        callDT();
        $objDT.on("click", ".bt-updch", function() {
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

        $objDT.on("click", ".chpd", function() {
            var id = $(this).attr("data-id");
            //console.log(selected_products);
            if ($(this).is(":checked")) {
                selected_products.push(parseInt(id));
            } else {
                var index = selected_products.indexOf(parseInt(id));
                if (index > -1) {
                    selected_products.splice(index, 1);
                }
            }
            //console.log(selected_products);
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


    <?php endif; ?>
    $("#addTier").click(function(event) {
        event.preventDefault();

        var tbody = $(this).parents("table").children("tbody");

        var tierRow = '<tr><td><select name="tier_profgroup[]" id="tier_profgroup" class="form-control"><option value="">Select Profile</option><option value="0">All</option>' + '<?php if ($profileGroup) { foreach ($profileGroup as $k) { ?><option value="<?php echo $k['id']; ?>"><?php echo $k['profile_name']; ?></option><?php } } ?>' + '</select></td><td><input name="tier_qty[]" class="form-control" id="tier_qty" value="" size="40" type="text"></td><td><input name="tier_price[]" class="form-control" id="tier_price" value="" size="40" type="text"></td><td><a href="javascript:void(0);" class="btn btn-danger" onclick="removeTier(this)" >Remove</a></td></tr>';

        tbody.append(tierRow);
        //alert($(this).parents("table").children("tbody").html());
    });


    function removeTier(element) {
        //alert($(element).parents("tr").html());
        $(element).parents("tr").remove();
    }

    /*$("#selectedProductss").on("click", ".removeSelectedPrd", function () {
     var json = $(this).parents("tr").attr('data-obj');
     var $pdObj = JSON.parse(json);
     
     proDucts = "<tr id='rowC-" + $pdObj.pid + "' class='childProd' data-obj='" + json + "'>";
     proDucts += '<td>' + $pdObj.sku + '</td>';
     proDucts += '<td><a href="catalog/product/edit/' + $pdObj.id + '">' + $pdObj.name + '</a></td>';
     proDucts += '<td>' + $pdObj.attr_label + '</td>';
     proDucts += '<td>' + $pdObj.price + '</td>';
     proDucts += '<td>' + $pdObj.quantity + '</td>';
     proDucts += '<td class="assign-btn"><button data-label="' + $pdObj.name + '" data-value="' + $pdObj.attr_id + '" class="btn btn-primary" type="button" onclick="checkAttribute(this)" >Add</button></td>';
     proDucts += '</tr>';
     $(this).parents("tr").remove();
     selected_products.splice(selected_products.indexOf($pdObj.pid), 1);
     jQuery("#datatable-example tbody").append(proDucts);
     $("#datatable-example").dataTable().draw();
     });*/



    $("#proType").change(function() {
        $('#category').trigger("change");
    });

    <?php if ($product['type'] == "config") : ?>
        jQuery(document).ready(function() {
            $('#childPro').show();
            $('#attrHi').hide();
            $('#category').trigger("change");
        });
    <?php endif; ?>
    <?php if ($product['type'] == "bundle") : ?>
        jQuery(document).ready(function() {
            $('#childPro').show();
            $('#attrHi').hide();
            $('#category').trigger("change");
            $('#min-bundle-qty').show();
        });
    <?php endif; ?>

    $(document).ready(function() {
        $("[name='type']").change(function() {
            var value = $(this).val();
            if (value == 'bundle') {
                $('.tabs-5').show();
            } else {
                $('.tabs-5').hide();
            }
        });

        $('.fa-plus-square').click(function(e) {
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
        $(document).on('click', '.fa-window-close', function(e) {
            $(this).parent().parent().remove();
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        var temp = '<?php echo $product["is_new"] ?>';

        if (temp == 0) {
            $('.new-div').hide();
            $('#new-no').prop('checked', 'true');
        } else {
            $('.new-div').show();
            $('#new-yes').prop('checked', 'true');
        }

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
                url: 'catalog/product/upload_pdf',
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

        $('.remove-pdf').click(function() {
            var ele = $(this);

            if (confirm('Are you sure to remove this PDF file ?')) {
                $.post('catalog/product/remove_pdf', {
                        product_id: '<?php echo $product["id"] ?>',
                        id: $(this).attr('id')
                    },
                    function(data, status) {
                        if (data == 1) {
                            $(ele).parent().remove();
                        }
                    });
            }
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $("#add-accessory-table").on("click", ".add-access", function() {
            var aId = $(this).attr('data-id');
            var qty = $("#accessory_quantity" + aId).val();
            var accessory_price = $("#accessory_price" + aId).val();
            $.post('catalog/product/add_accessory', {
                    config_product_id: '<?php echo $product["id"] ?>',
                    id: aId,
                    quantity: qty,
                    price: accessory_price
                },
                function(data, status) {
                    if (data) {
                        if (data == 'duplicate') {
                            alert('This accessory already exist !');
                        } else if (data == 'no-input') {
                            alert('Invalid Input !');
                        } else if (data == 'error') {
                            alert('Error in processing request. Please try later !');
                        } else {
                            var accessories = JSON.parse(data);
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
                            $("#accessory_quantity" + aId).val('');
                            $("#accessory_price" + aId).val('');
                        }
                    }
                });
        });

        $(document).on('click', '.remove-accessory-btn', function() {
            var ele = $(this).closest('tr');

            if (confirm('Are you sure to remove this accessory ?')) {
                $.post('catalog/product/remove_accessory', {
                        accessory_id: $(this).attr('data-accessory-id')
                    },
                    function(data, status) {
                        if (data) {
                            $(ele).remove();
                        }
                    });
            }
        });

        $('#submitImageInfo').on("click", function(e) {
            var mainArray = [];
            var imgDesc = [];
            $(".pimagesort").each(function() {
                mainArray.push({
                    'image_id': $(this).attr("data-iid"),
                    'pid': $(this).attr("data-pid"),
                    'sort_order': $(this).val()
                });
            });


            $(".Imgdesc").each(function(i, h) {
                imgDesc.push({
                    'image_id': $(this).attr("data-iid"),
                    'pid': $(this).attr("data-pid"),
                    'desc': $(this).val()
                });
            });

            var pid = $(".pimagesort").attr("data-pid");
            var post_url = "catalog/product/updateimagesortorder";
            $("#loadergif").show();
            $.ajax({
                url: post_url,
                type: "POST",
                data: {
                    pid: pid,
                    sort_order: mainArray,
                    imgDesc: imgDesc
                }
            }).done(function(response) { //
                if (response == 1) {
                    $(".sortinText").text("Sorting and description updated successfully!");
                    $("#loadergif").hide();
                    setTimeout(function() {
                        $(".sortinText").text("");
                    }, 3000);
                } else {
                    $("#loadergif").hide();
                }
            });
        });
        $("#proType").trigger("change"); // use this for solve the issue child product in standard
    });
    $(document).ready(function() {
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
            "columns": [{
                    "data": "name"
                },
                {
                    "data": "price"
                },
                {
                    "data": "quantity",
                    render: function(data, type, row, meta) {
                        return '<input class="accessory-input-control accessory-quantity" id="accessory_quantity' + row.id + '" type="number" min="1" value="">';
                    }
                },
                {
                    "data": "price",
                    render: function(data, type, row, meta) {
                        return '<input class="accessory-input-control accessory-price" id="accessory_price' + row.id + '" type="text" min="1" value="">';
                    }
                },
                {
                    "data": "assign",
                    render: function(data, type, row, meta) {
                        return '<button id="add-accessory-btn' + row.id + '" data-id="' + row.id + '" class="add-access" type="button" name="button">Add</button>';
                    }
                }
            ]
        });

        jQuery("#addcatform").submit(function() {
            jQuery("#childPdField").val(selected_products.join());
        });
    });
</script>
<style>
    .width70px {
        width: 70px;
    }

    .width100px {
        width: 100px;
    }
</style>