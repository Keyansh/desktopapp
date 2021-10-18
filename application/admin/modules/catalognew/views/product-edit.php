<style type="text/css">
    #table-3 td {
        border: 1px solid #dfe8f1;
        padding: 8px 13px;
        font-size: 14px
    }

    #loadergif {
        display: none
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
        padding: 0 10px 15px;
    }
    .list-inline.searchul {
	overflow: auto;
	max-height: 400px;
}
    #submitImageInfo {
        color: #fff;
        border: none;
        background: #333;
        padding: 6px 15px
    }

    .childProductAccordion .panel-title {
        font-size: 23px
    }

    .childProductAccordion .panel-title a {
        text-decoration: none !important;
        color: #333;
        display: block;
        padding: 10px 15px
    }

    .childProductAccordion .panel-title i {
        transition: .2s;
        margin: 0 0 0 8px
    }

    .childProductAccordion .panel-title i.rotate {
        transform: rotate(90deg)
    }

    .childProductAccordion .panel-heading {
        padding: 0
    }

    .cloneAdd.fixed {
        position: fixed;
        bottom: 195px !important;
        right: 32px !important;
        outline: 0 !important
    }

    .block-element {
        display: block;
        width: 100%
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

    .collapse.in,
    .tab-pane.active {
        display: table;
        width: 100%
    }

    #button {
        padding: 10px 39px !important;
        margin-top: 16px
    }

    .btn.pull-right {
        margin: 0 0 0 8px !important
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

    .input-trash-con {
        padding: 0
    }

    .input-trash-con strong {
        margin-right: 65px;
        min-width: 400px;
        display: inline-block
    }

    .input-trash-con .fa {
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

    .selected-pro-ul {
        padding: 10px 20px;
        margin: 0;
        border: 1px solid lightgray;
    }

    .selected-pro-ul li .removeproduct {
        display: inline-block;
        margin-left: 25px;
        color: red;
    }

    .selected-pro-ul li {
        list-style: none;
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
<script type="text/javascript">
    var selected_products = [<?php echo $child_ids ? implode(',', $child_ids) : ''; ?>];
    var selected_attrs = [<?php echo implode(',', $selected_attrs); ?>];

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

        var newStartDate = '<?php echo $product['new_start_date']; ?>';
        var newEndDate = '<?php echo $product['new_end_date']; ?>';

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

<h3 class="title-hero clearfix">
    Edit Product
    <a class="btn btn-primary pull-right" href="catalognew/product/index">Manage Products</a>
</h3>
<div class="panel">
    <div class="panel-body">
        <?php $this->load->view('inc-messages'); ?>
        <form action="catalognew/product/edit/<?php echo $product['id']; ?>" method="post" enctype="multipart/form-data" name="addcatform" id="addcatform">
            <div class="example-box-wrapper">
                <ul id="myTab" class="nav clearfix nav-tabs">
                    <li class="active"><a href="#tabs-0" data-toggle="tab">Main</a></li>
                    <li><a href="#tabs-1" data-toggle="tab">Metadata</a></li>
                    <li id="attrHi"><a href="#tabs-2" data-toggle="tab">Attributes</a></li>
                    <li><a href="#tabs-3" data-toggle="tab">Images</a></li>
                    <li class="tabs-4"><a href="#tabs-4" data-toggle="tab">PDFs</a></li>
                    <li><a href="#tabs-5" data-toggle="tab">Bullet Points</a></li>
                    <li class="tabs-6"><a href="#tabs-6" data-toggle="tab">You may also like</a></li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="tabs-0">
                        <div class="form-group clearfix col-xs-12 col-sm-6">
                            <label class="col-sm-2 control-label block-element">Select Category <span class="error">*</span></label>
                            <div class="col-sm-6 block-element"><?php echo form_dropdown('category_id', $categories, set_value('category_id', $procat['cid']), ' class="form-control" id="category" data-old="' . $procat['cid'] . '"'); ?></div>
                        </div>
                        <div class="form-group clearfix col-xs-12 col-sm-6">
                            <label class="col-sm-2 control-label block-element">Select Attribute Set <span class="error">*</span></label>
                            <div class="col-sm-6 block-element">
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
                        <div class="form-group clearfix col-xs-12">
                            <label class="col-sm-2 control-label block-element">Select Other Categories</label>
                            <div class="col-sm-6 block-element">
                                <select name="categoriesIds[]" class="form-control" id="categoriesIds" multiple>
                                    <?php
                                    foreach ($catSecArray as $catSecArr) {
                                        echo '<option value="' . $catSecArr['id'] . '" ' . (in_array($catSecArr['id'], $proSecCatKeys) ? 'selected="selected"' : '') . '>' . $catSecArr['name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group clearfix col-xs-12 col-sm-6">

                            <?php if ($product['type'] == 'config') {
                            ?>
                                <label class="col-sm-2 control-label block-element">Product Type</label>
                                <div class="col-sm-6 block-element"><strong class="form-control">&nbsp;Configurable</strong></div>
                                <input type="hidden" name="type" value="<?php echo $product['type']; ?>">
                            <?php
                            } elseif ($product['type'] == 'bundle') {
                            ?>
                                <label class="col-sm-2 control-label block-element">Product Type</label>
                                <div class="col-sm-6 block-element"><strong class="form-control">&nbsp;Bundle</strong></div>
                                <input type="hidden" name="type" value="<?php echo $product['type']; ?>">
                            <?php
                            } else {
                            ?>
                                <label class="col-sm-2 control-label block-element">Product Type <span class="error">*</span></label>
                                <div class="col-sm-6 block-element"><?php echo form_dropdown('type', $proType, set_value('type', $product['type']), ' class="form-control proType" id="proType"'); ?></div>
                            <?php }
                            ?>
                        </div>
                        <div class="form-group clearfix col-xs-12 col-sm-6">
                            <label class="col-sm-2 control-label block-element">Product Name <span class="error"> *</span></label>
                            <div class="col-sm-6 block-element"><input name="name" type="text" class="form-control" id="name" value="<?php echo set_value('name', $product['name']); ?>" size="40"></div>
                        </div>
                        <div class="form-group clearfix col-xs-12 col-sm-6">
                            <label class="col-sm-2 control-label block-element">Product URI (Will be auto-generated if left blank)</label>
                            <div class="col-sm-6 block-element"><input name="uri" type="text" class="form-control" id="uri" value="<?php echo set_value('uri', $product['uri']); ?>" size="40"></div>
                        </div>
                        <div class="form-group clearfix col-xs-12 col-sm-6">
                            <label class="col-sm-2 control-label block-element">SKU <small><span class="error">*</span></small></label>
                            <div class="col-sm-6 block-element"><input name="sku" type="text" class="form-control" id="sku" value="<?php echo set_value('sku', $product['sku']); ?>" size="40"></div>
                        </div>
                        <?php if (!empty($parent)) {
                        ?>
                            <div class="form-group clearfix col-xs-12 col-sm-6" style="display: none;">
                                <label class="col-sm-2 control-label block-element">Parent SKU </label>
                                <div class="col-sm-6 block-element"><input name="parent_sku" type="text" class="form-control" id="parent_sku" value="<?php echo $parent['sku']; ?>" size="40"></div>
                            </div>
                        <?php }
                        ?>
                        <div class="form-group clearfix col-xs-12 col-sm-6">
                            <label class="col-sm-2 control-label block-element">(Excluding Vat) Price</label>
                            <div class="col-sm-6 block-element">
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
                        <div class="form-group clearfix col-xs-12 col-sm-6">
                            <label class="col-sm-2 control-label block-element">Stock Quantity <small><span class="error">*</span></small></label>
                            <div class="col-sm-6 block-element"><input name="quantity" type="text" class="form-control" id="quantity" value="<?php echo set_value('quantity', $product['quantity']); ?>" size="40"></div>
                        </div>
                        <!-- <div class="form-group clearfix col-xs-12 col-sm-6">
                            <label class="col-sm-2 control-label block-element">Line Drawing</label>
                            <div class="col-xs-12 input-trash-con"><?php if ($product['line_drowing']) { ?><img src="<?= $this->config->item('LINE_DROWING_URL') . $product['line_drowing'] ?>" style="width:200px"> <?php } ?><?php if ($product['line_drowing']) { ?><i class="fa fa-trash" data-dbcol="line_drowing"></i><?php } ?></div>
                            <div class="col-sm-6 block-element"><input name="line_drowing" type="file" class="form-control" value="<?php echo set_value('quantity', $product['line_drowing']); ?>" size="40"></div>
                        </div> -->
                        <?php
                        $style = '';
                        if ($product['type'] != 'bundle') {
                            $style = 'display:none';
                        }
                        ?>
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
                                                <div class="col-sm-6 block-element"><textarea name="brief_description" style="height:100px; width: 100%;" class="form-control" id="brief_description"><?php echo set_value('brief_description', $product['brief_description']); ?></textarea></div>
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
                                                <label class="col-sm-2 control-label block-element">Product Information</label>
                                                <div class="col-sm-12 block-element"><textarea name="description" style="width:100%;" class="form-control" id="description"><?php echo set_value('description', $product['description']); ?></textarea></div>
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
                                    <input id='new-yes' type="radio" name="is_new" value="1" <?php echo set_radio('is_new', 1, ($product['is_new'] == 1)); ?> /> Yes&nbsp;&nbsp;
                                    <input id='new-no' type="radio" name="is_new" value="0" <?php echo set_radio('is_new', 0, ($product['is_new'] == 0)); ?> /> No
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




                        </div> -->

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
                        <p class="text-center">Upload size around 513*548. Max upload size limit <?= ini_get('upload_max_filesize') ?> </p>
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
                                                    <i class="fa fa-trash red" aria-hidden="true">remove</i>
                                                </div>
                                                <div title="main">
                                                    <i class="fa fa-star" aria-hidden="true">
                                                        <input type="radio" <?= ($img['main'] == 1) ? "checked='checked'" : ''; ?> name="mainimg" value="<?php echo $img['id']; ?>">
                                                    </i>
                                                </div>
                                            </div>
                                        </li>
                                    <?php
                                        // }
                                    }
                                    ?>
                                </ul>
                                <p class="image-sorting-text" style="color: #495d80;font-size: 18px;font-style: italic;"><span class="sortinText"></span><img id="loadergif" src="<?php echo base_url(); ?>img/loader-gif.gif" width="35px" /></p>
                                <button type="button" id="submitImageInfo">Update Image Info.</button>
                            <?php }
                            ?>

                        </div>
                    </div>
                    <div class="tab-pane fade clearfix" id="tabs-4">



                        <div class=" col-xs-12 table-display-porp row">
                            <div class="col-xs-12 pdf-margin">
                                <div class="col-xs-2">Certification</div>
                                <div class="col-xs-10">
                                    <div class="col-xs-12 input-trash-con"><strong><?= $product['certification'] ?></strong><?php if ($product['certification']) { ?><i class="fa fa-trash" data-dbcol="certification"></i><?php } ?></div>
                                    <input type="file" name="certification" value="<?php echo set_value('certification', $product['certification']); ?>">
                                </div>
                            </div>
                            <div class="col-xs-12 pdf-margin">
                                <div class="col-xs-2">Datasheet</div>
                                <div class="col-xs-10">
                                    <div class="col-xs-12 input-trash-con"> <strong><?= $product['datasheet'] ?></strong><?php if ($product['datasheet']) { ?><i class="fa fa-trash" data-dbcol="datasheet"></i><?php } ?></div>
                                    <input type="file" name="datasheet" value="<?php echo set_value('datasheet', $product['datasheet']); ?>">
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane fade clearfix" id="tabs-5">
                        <div class="error_messages"></div>
                        <div class="row">
                            <div class="form-group">
                                <ul class="logo_location_custom_options">
                                    <?php foreach ($bulletpoints as $option) {
                                    ?>
                                        <li class="">
                                            <div class="col-lg-10">
                                                <input name="bulletpoints[]" type="text" value="<?= $option['bullet_points']; ?>" class="form-control" required />
                                            </div>
                                            <div class="col-lg-2">
                                                <i class="fa fa-window-close fa-4 bulletpoints1" style="font-size:30px;cursor:pointer" aria-hidden="true"></i>
                                            </div>
                                        </li>
                                    <?php }
                                    ?>
                                </ul>
                            </div>
                            <div class="row">
                                <i class="fa fa-plus-square bulletpoints" style="font-size:30px;cursor:pointer;padding-left: 60px;" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tabs-6">
                        <div class="col-xs-12 main-div">
                            <div class="col-xs-12 is-active">
                                <div class="form-group clearfix col-xs-12 col-sm-3">
                                    <label class="col-sm-2 control-label block-element">Want to active</label>
                                    <div class="col-sm-6 ">
                                        <input type="radio" name="is_like_active" value="1" <?php echo set_radio('is_like_active', 1, ($product['is_like_active'] == 1)); ?> /> Yes&nbsp;&nbsp;
                                        <input type="radio" name="is_like_active" value="0" <?php echo set_radio('is_like_active', 0, ($product['is_like_active'] == 0)); ?> /> No
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 div-ul-sel">
                                <?php if ($sectedprod) { ?>
                                    <ul class="selected-pro-ul">
                                        <li class="selected-pro block-element">Selected Products</li>
                                        <?php foreach ($sectedprod as $item) { ?>
                                            <li>
                                                <span>Name : <?= $item['name']; ?> (<?= $item['sku']; ?>)</span> <i class="fa fa-trash removeproduct" data-dbcol="certification"></i>
                                                <input type="hidden" value="<?= $item['id']; ?>" name="productadd[]">
                                            </li>
                                        <?php } ?>
                                    </ul>
                                <?php } ?>
                            </div>

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
                    <p align="center">Fields marked with <span class="error">*</span> are required.</p>
                    <input type="hidden" name="assign_product" value="" id="childPdField">
                    <p align="center" id="verify_submit">
                        <button type="submit" name="button" id="button" value="save" class="btn btn-primary">
                            Save
                        </button>
                        <button type="submit" name="button" id="button" value="save_and_close" class="btn btn-primary">
                            Save and Close
                        </button>
                    </p>
                </div>
            </div>
        </form>
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
                            "url": "catalognew/ajax/product/childProducts/<?= $mainCategory['id'] . '/' . $product['id']; ?>",
                            "type": "POST",
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
                                    return '<a href="catalognew/product/edit/' + row.id + '" target="_blank">' + row.name + '</a>';

                                }
                            },
                            {
                                "data": "attr_label"
                            },
                            {
                                "data": "price",
                                render: function(data, type, row, meta) {
                                    return '<input name="child_product_price[' + row.id + ']" type="text" class="width70px" id="pro_price' + row.id + '" data-label="' + row.name + '" data-value="' + row.attr_id + '"  value="' + row.price + '" >';
                                }
                            },
                            {
                                "data": "quantity",
                                render: function(data, type, row, meta) {
                                    return '<input name="child_product_stock[' + row.id + ']" class="width100px" id="pro_quantity' + row.id + '" type="text" data-label="' + row.name + '" data-value="' + row.attr_id + '"  value="' + row.quantity + '" >';
                                }
                            },
                            {
                                "data": "assign",
                                render: function(data, type, row, meta) {
                                    return '<button onclick="location=\'<?php echo base_url(); ?>catalognew/product/edit/' + row.id + '\'" data-label="' + row.name + '" data-id="' + row.id + '" data-value="' + row.attr_id + '" id="assign_product' + row.id + '" class="btn btn-primary bt-updch" type="button">Udpate</button>';
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


            <?php endif; ?>

            $("#addProductTier").click(function(event) {
                event.preventDefault();
                var tbody = $(this).parents("table").children("tbody");
                var tierRow = '<tr><td><input name="tier_min_qty[]" class="form-control" id="tier_min_qty" value="" size="40" type="text"></td><td><input name="tier_max_qty[]" class="form-control" id="tier_max_qty" value="" size="40" type="text"></td><td><input name="tier_product_price[]" class="form-control" id="tier_product_price" value="" size="40" type="text"></td><td><input name="tier_delivery[]" type="text" class="form-control" id="tier_delivery" size="40"></td><td><a href="javascript:void(0);" class="btn btn-danger" onclick="removeTier(this)" >Remove</a></td></tr>';
                tbody.append(tierRow);
            });


            function removeTier(element) {
                $(element).parents("tr").remove();
                $("#proType").change(function() {
                    $('#category').trigger("change");
                });
            }
            <?php if ($product['type'] == 'config') : ?>
                jQuery(document).ready(function() {
                    $('#childPro').show();
                    $('#attrHi').hide();
                    $('#category').trigger("change");
                });
            <?php endif; ?>
            <?php if ($product['type'] == 'bundle') : ?>
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
                // $(document).on('click', '.fa-plus-square', function(e) {
                //     var html = '';
                //     html += '<li class="">';
                //     html += '<div class="col-lg-10">';
                //     html += '<input name="custom_option[logo_print_location][]" class="form-control"/>';
                //     html += '</div>';
                //     html += '<div class="col-lg-2">';
                //     html += '<i class="fa fa-window-close fa-4" style="font-size:30px;cursor:pointer" aria-hidden="true"></i>';
                //     html += '</div>';
                //     html += '</li>';
                //     $('.logo_location_custom_options').append(html);
                // });
                // $(document).on('click', '.fa-window-close', function(e) {
                //     $(this).parent().parent().remove();
                // });
            });
        </script>

        <script type="text/javascript">
            $(document).ready(function() {
                $(document).on('click', '.bulletpoints', function(e) {
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
                $(document).on('click', '.removeproduct', function(e) {
                    $(this).parent('li').remove();
                });
                var temp = '<?php echo $product['is_new']; ?>';

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

                $('.remove-pdf').click(function() {
                    var ele = $(this);

                    if (confirm('Are you sure to remove this PDF file ?')) {
                        $.post('catalognew/product/remove_pdf', {
                                product_id: '<?php echo $product['id']; ?>',
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
                    $.post('catalognew/product/add_accessory', {
                            config_product_id: '<?php echo $product['id']; ?>',
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
                        $.post('catalognew/product/remove_accessory', {
                                accessory_id: $(this).attr('data-accessory-id')
                            },
                            function(data, status) {
                                if (data) {
                                    $(ele).remove();
                                }
                            });
                    }
                });

                $(".input-trash-con .fa").click(function() {
                    var $t = $(this);
                    var dataval = $(this).attr("data-dbcol");
                    var pid = <?php echo $product['id']; ?>;

                    if (confirm('Are you sure to remove ?')) {

                        $.ajax({
                            url: "catalognew/product/delete_pdf",
                            method: "POST",
                            data: {
                                dataval: dataval,
                                pid: pid
                            },
                            success: function(result) {
                                alert("file removed");
                                $t.parent().find('strong').text('');
                                $t.parent().find('img').remove();
                                $t.remove();
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
                    var post_url = "catalognew/product/updateimagesortorder";
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
                        "url": "catalognew/ajax/product/non_config_products",
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

                $(document).on('click', '.childProductAccordion .panel-title a', function() {
                    $(this).find('.fa').toggleClass('rotate');
                });

            });
        </script>
        <script>
            $(document).ready(function() {
                var rowCount = $('.tr-count tr').length;
                if (rowCount > 1) {
                    $('.addsavebtn').append('<button onclick="save_quantity_range()" class="btn btn-primary pull-right" id="saveTier">Save Quantity</button>');
                }
                $(document).on('click', '#childPro', function(e) {
                    $(window).scroll(function() {
                        var divBox = $(document).find('#cateAttributesID').outerHeight() + $(document).find('.child-product-accordion').outerHeight() + 420;
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

                $(window).on('load', function() {
                    //do something
                    localStorage.clear();
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
                        // console.log(JSON.parse(localStorage.getItem("ProductsSku")) || {});
                        var cart = JSON.parse(localStorage.getItem("ProductsSku")) || {};
                        var j = 1;
                        $(".sku-field").each(function() {
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

                $('.accordHeader a').click(function() {
                    $(this).find('.fa').toggleClass('active');
                });

                $("#quantity_per_pack").keypress(function(e) {
                    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                        $("#errmsg").html("Digits Only").css('color', 'red').show().fadeOut("slow");
                        return false;
                    }
                });

                var is_offer = $('input[name=is_offer]:checked').val();
                if (is_offer == 1) {
                    $('#is_offer_discount').show();
                } else {
                    $('#is_offer_discount').hide();
                }
                $("input[name='is_offer']").click(function() {
                    var value = $(this).attr('value');
                    if (value == 1) {
                        $("input[name=is_offer_discount]").val('<?= $product['is_offer_discount'] ?>');
                        $('#is_offer_discount').show();
                    } else {
                        $("input[name=is_offer_discount]").val('');
                        $('#is_offer_discount').hide();
                    }
                });
            });

            $("#verify_submit").click(function(e) {
                var result = true;
                $('.quantity_range_from_unique').each(function() {
                    var quantity_range_value = $(this).val();
                    if (quantity_range_value) {
                        if ($.isNumeric(quantity_range_value)) {
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

            function save_quantity_range() {
                var jquery_array = <?php echo json_encode($jquery_array); ?>;
                var status = true;
                $('.quantity_range_from_unique').each(function() {
                    var qty = $(this).val();
                    if (qty) {
                        if ($.isNumeric(qty)) {
                            $(this).css('border-color', 'inherit');
                        } else {
                            alert('Please enter a numeric value for quantity column');
                            $(this).css('border-color', 'red');
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
                    $('.display-tr').show();
                    $(".append_td").find("td:gt(0)").remove();
                    $('.append_th').html('');
                    $("#addcatform").submit(function(e) {
                        e.preventDefault();
                    });
                    $('.append_th').html('<th style="text-align:center !important;">Groups</th>');
                    $('.tr-count tr').each(function() {
                        // console.log(this);
                        var first_input = $(this).children().find('.first-input').val();
                        var second_input = $(this).children().find('.second-input').val();
                        var btn_danger = $(this).children().find('.btn-danger');
                        if (first_input && second_input) {
                            var spaceless = 'class' + first_input + '-' + second_input;
                        } else if (first_input) {
                            var new_recent = clean(first_input);
                            var spaceless = 'class' + new_recent;
                        } else {

                        }

                        $(btn_danger).attr('remove_class', spaceless);
                        if (first_input) {
                            if (first_input && second_input) {
                                var main_class = 'class' + first_input + '-' + second_input;
                            } else if (first_input) {
                                var newone = clean(first_input);
                                var main_class = 'class' + newone;
                            } else {

                            }

                            var newMyText = main_class.replace(/ /g, '');
                            if (first_input && second_input) {
                                var input_exists = first_input + ' - ' + second_input;
                                var main_class1 = first_input + '-' + second_input;
                            } else if (first_input) {
                                var input_exists = first_input + '+';
                                var main_class1 = first_input;
                            } else {

                            }
                            $('.append_th').append('<th style="text-align:center !important;" class="' + newMyText + '">' + input_exists + '</th>');
                            $('.append_td').each(function(index) {
                                var group_id = $(this).attr('group_id'),
                                    optionIndex = main_class1.replace(/ /g, '');
                                if (jquery_array != false) {
                                    value = typeof jquery_array[group_id][optionIndex] == 'undefined' ? '' : jquery_array[group_id][optionIndex];
                                    $(this).append('<td style="text-align:center !important;" class="' + newMyText + '"><input value="' + value + '" name="quantity_range_value[' + group_id + '][]" class="quantity_range_value" style="width:auto;border:1px solid lightgrey;" type="text"><input name="quantity_range[' + group_id + '][]" value="' + optionIndex + '" type="hidden"></td>');
                                } else {
                                    $(this).append('<td style="text-align:center !important;" class="' + newMyText + '"><input name="quantity_range_value[' + group_id + '][]" class="quantity_range_value" style="width:auto;border:1px solid lightgrey;" type="text"><input name="quantity_range[' + group_id + '][]" value="' + optionIndex + '" type="hidden"></td>');
                                }
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
        <style>
            .width70px {
                width: 70px;
            }

            .width100px {
                width: 100px;
            }
        </style>

        <script>
            $('#removeStockStatusSelectionJK').click(function() {
                $('input[name="product_stock_status"]').prop('checked', false);
                $('input[name="product_stock_status"]').removeAttr('checked');
                $('input[name="product_stock_status"]').val(null);
            });
        </script>



        <script>
            $(document).ready(function() {


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

                $(document).on('keyup', '.right-div .input-search', function(e) {
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