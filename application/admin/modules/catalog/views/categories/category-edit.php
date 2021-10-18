<?php
// e($current_category);
?>

<link rel="stylesheet" type="text/css" href="<?= base_url() ?>plugins/image-resizer/croppic.css" />

<script type="text/javascript">
    $(document).ready(function() {
        // Set New start and end date code begins here
        $('.datepicker').datepicker({
            minDate: 0,
            dateFormat: 'dd-mm-yy'
        });

        var newStartDate = '<?php echo $current_category["new_start_date"] ?>';
        var newEndDate = '<?php echo $current_category["new_end_date"] ?>';

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
<style>
    @media(min-width:1500px) {
        .form-group.clearfix.div-width-half {
            width: 50%;
            float: left;
            margin-bottom: 40px
        }

        .meta-title-width {
            min-width: auto !important;
            width: 12.5%;
        }

        .col-sm-2.control-label.banner-width {
            min-width: 12.5% !important;
            width: auto;
        }

        .width-input-field {
            width: 91%;
        }
    }
</style>
<h3 class="title-hero clearfix">
    Edit Categories
    <a href="catalog/category/" class="pull-right btn btn-primary">Manage Category</a>
</h3>
<div class="panel">
    <div class="panel-body">
        <?php $this->load->view('inc-messages'); ?>
        <form action="catalog/category/edit/<?php echo $current_category['id']; ?>" method="post" enctype="multipart/form-data" name="addcatform" id="addcatform">
            <div class="example-box-wrapper">
                <ul id="myTab" class="nav clearfix nav-tabs">
                    <li class="active"><a href="#main" data-toggle="tab">Main</a></li>
                    <li class=""><a href="#metadata" data-toggle="tab">Metadata</a></li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="main">
                        <input name="parent_id" type="hidden" class="form-control" id="parent_id" value="0" size="40">
                        <div class="form-group clearfix div-width-half">
                            <label class="col-sm-2 control-label">Parent Category <span class="error">*</span></label>
                            <div class="col-sm-6">
                                <?php echo form_dropdown('parent_id', $parent, set_value('parent_id', $current_category['parent_id']), ' class="form-control"'); ?>
                            </div>
                        </div>

                        <div class="form-group clearfix div-width-half">
                            <label class="col-sm-2 control-label">Category Name <span class="error">*</span></label>
                            <div class="col-sm-6">
                                <input name="name" type="text" class="form-control" id="category" value="<?php echo set_value('name', $current_category['name']); ?>" size="40">
                            </div>
                        </div>

                        <div class="form-group clearfix div-width-half">
                            <label class="col-sm-2 control-label">Category Alias</label>
                            <div class="col-sm-6">
                                <input name="uri" type="text" class="form-control" id="category_alias" value="<?php echo set_value('uri', $current_category['uri']); ?>" size="40">
                            </div>
                        </div>

                        <!--                        <div class="form-group clearfix">
                                                    <label class="col-sm-2 control-label">Category Menu Image </label>
                                                    <div class="col-sm-6">
                        <?php
                        //                                if ($current_category['icon']) {
                        ?>
                                                            <img src="<?php // echo $this->config->item('CATEGORY_ICON_URL') . $current_category['icon'];                       
                                                                        ?>" />
                                                            <br />
                        <?php
                        //                                }
                        ?>
                                                        <input name="icon" type="file" id="icon" size="35" class="form-control" />
                                                    </div>
                                                </div>-->

                        <div class="form-group clearfix div-width-half">
                            <label class="col-sm-2 control-label">Category Image</label>
                            <div class="col-sm-6">
                                <?php
                                if ($current_category['image']) {
                                ?>
                                    <img src="<?php echo $this->config->item('CATEGORY_IMAGE_URL') . $current_category['image']; ?>" style="width:150px;height:100px;" />
                                    <a onclick="return confirm('Are you sure to remove this image ?')" href="<?= base_url() . 'catalog/category/remove_cat_img/' . $current_category['id'] ?>">remove image</a>
                                    <br />
                                <?php
                                }
                                ?>
                                <input type="file" name="image" class="form-control">
                                <small>Upload size around 304*401 & max file size limit <?= ini_get('upload_max_filesize') ?></small>
                            </div>
                        </div>

                        <div class="form-group clearfix div-width-half">
                            <label class="col-sm-2 control-label">Category Image Alt</label>
                            <div class="col-sm-6">
                                <input type="text" name="image_alt" class="form-control" value="<?php echo set_value('image_alt', $current_category['image_alt']) ?>">
                            </div>
                        </div>

                        <div class="form-group clearfix div-width-half">
                            <label class="col-sm-4 control-label">Category Banner</label>
                            <div class="col-sm-6">
                                <?php if (file_exists($this->config->item('CATEGORY_BANNER_PATH') . $current_category['category_banner']) && $current_category['category_banner']) { ?>
                                    <img src="<?php echo $this->config->item('CATEGORY_BANNER_URL') . $current_category['category_banner'] ?>" width="120" />
                                <?php } ?>
                                <input type="file" name="banner" class="form-control">
                            </div>
                        </div>
                        <div class="form-group clearfix div-width-half">
                            <label class="col-sm-2 control-label">Category Template</label>
                            <div class="col-sm-6">
                                <select name="category_template" id="" class="form-control">
                                    <!-- <option <?php echo $current_category['category_template'] == 'default' ? 'selected' : '' ?> value="default">Default</option> -->
                                    <?php foreach (listAllPageTemplates() as $item) { ?>
                                        <option <?php echo $current_category['category_template'] == $item['id'] ? 'selected' : '' ?> value="<?= $item['id'] ?>"><?= $item['template_name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <!-- <div class="form-group clearfix div-width-half div-width-half">
                            <label class="col-sm-2 control-label">Category Banner Alt</label>
                            <div class="col-sm-6">
                                <input type="text" name="banner_alt" class="form-control" value="<?php echo set_value('banner_alt', $current_category['banner_alt']) ?>">
                            </div>
                        </div> -->

                        <!-- <div class="form-group clearfix div-width-half">
                            <label class="col-sm-2 control-label">Banner Title</label>
                            <div class="col-sm-6">
                                <input name="banner_title" type="text" class="form-control" id="banner_title" value="<?php echo set_value('banner_title', $current_category['banner_title']); ?>" size="40">
                            </div>
                        </div> -->
                        <!-- <div class="form-group clearfix">
                            <label class="col-sm-2 control-label banner-width">Banner Content</label>
                            <div class="col-sm-6 banner-width-input">
                                <textarea name="banner_content" type="text" class="form-control" id="banner_content"><?php echo set_value('banner_content', $current_category['banner_content']); ?></textarea>
                            </div>
                        </div> -->
                        <!-- <div class="form-group clearfix ">
                            <label class="col-sm-2 control-label banner-width">Short Description</label>
                            <div class="col-sm-6 banner-width-input">
                                <textarea name="short_description"  class="form-control" id="short_description"><?php echo set_value('short_description', $current_category['short_description']); ?></textarea>
                            </div>
                        </div> -->
                        <div class="form-group clearfix">
                            <label class="col-sm-12 control-label">Category Description</label>
                            <div class="col-sm-12">
                                <textarea name="description" cols="40" rows="4" class="form-control" id="description"><?php echo set_value('descripton', $current_category['description']); ?></textarea>
                            </div>
                        </div>
                        <!-- <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Category Bottom Description</label>
                            <div class="col-sm-12">
                                <textarea name="bottom_description"  class="form-control" id="bottom_description"><?php echo set_value('bottom_description', $current_category['bottom_description']); ?></textarea>
                            </div>
                        </div> -->
                        <!-- <div class="form-group clearfix div-width-half">
                            <label class="col-sm-2 control-label">Show in Megamenu</label>
                            <div class="col-sm-6">
                                <select name="show_in_menu" class="form-control">
                                    <option value="1" <?= ($current_category['show_in_menu'] == 1) ? 'selected' : ''; ?>> Yes </option>
                                    <option value="0" <?= ($current_category['show_in_menu'] == 0) ? 'selected' : ''; ?>> No </option>
                                </select>
                            </div>
                        </div> -->
                        <!-- <div class="form-group clearfix div-width-half">
                            <label class="col-sm-2 control-label">Show as Child-category</label>
                            <div class="col-sm-6">
                                <select name="show_as_child" class="form-control">
                                    <option value="1" <?= ($current_category['show_as_child'] == 1) ? 'selected' : ''; ?>> Yes </option>
                                    <option value="0" <?= ($current_category['show_as_child'] == 0) ? 'selected' : ''; ?>> No </option>
                                </select>
                            </div>
                        </div> -->
                        <!-- <div class="form-group clearfix div-width-half">
                            <label class="col-sm-2 control-label">Featured</label>
                            <div class="col-sm-6">
                                <select name="featured" class="form-control">
                                    <option value="1" <?= ($current_category['featured'] == 1) ? 'selected' : ''; ?>> Yes </option>
                                    <option value="0" <?= ($current_category['featured'] == 0) ? 'selected' : ''; ?>> No </option>
                                </select>
                            </div>
                        </div> -->
                        <!-- <div class="form-group clearfix div-width-half">
                            <label class="col-sm-2 control-label">Show in Homepage</label>
                            <div class="col-sm-6">
                                <select name="show_in_homepage" class="form-control">
                                    <option value="1" <?= ($current_category['show_in_homepage'] == 1) ? 'selected' : ''; ?>> Yes </option>
                                    <option value="0" <?= ($current_category['show_in_homepage'] == 0) ? 'selected' : ''; ?>> No </option>
                                </select>
                            </div>
                        </div> -->
                        <!-- <div class="form-group clearfix div-width-half">
                            <label class="col-sm-2 control-label">Is New</label>
                            <div class="col-sm-6">
                                <input id='new-yes' type="radio" name="is_new" value="1" <?php echo set_radio('is_new', 1, ($current_category['is_new'] == 1)); ?> />Yes
                                <input id='new-no' type="radio" name="is_new" value="0" <?php echo set_radio('is_new', 0, ($current_category['is_new'] == 0)); ?> />NO
                                <div class="new-div">
                                    <div class="">
                                        <span>New Start Date</span><input id="new_start_date" class="datepicker" data-date-format="dd/mm/yyyy" name="new_start_date">
                                    </div>
                                    <div class="">
                                        <span style="display:inline-block;width:110px;">New End Date</span><input id="new_end_date" class="datepicker" data-date-format="/dd/mm/yyyy" name="new_end_date">
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <div class="form-group clearfix">
                            <!-- <label class="col-sm-2 control-label"></label> -->
                            <div class="col-sm-12" align="center">
                                <input name="image_v" type="hidden" id="image_v" value="1">
                                Fields marked with <span class="error">*</span> are required.
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="metadata">
                        <div class="form-group clearfix ">
                            <label class="col-sm-2 control-label meta-title-width">Meta Title</label>
                            <div class="col-sm-10">
                                <input name="meta_title" type="text" class="form-control" id="meta_title" value="<?php echo set_value('meta_title', $current_category['meta_title']); ?>" style="width:99%">
                            </div>
                        </div>
                        <div class="form-group clearfix div-width-half">
                            <label class="col-sm-2 control-label">Meta Keywords</label>
                            <div class="col-sm-7 width-input-field">
                                <textarea name="meta_keywords" cols="40" rows="4" style="width:99%" class="form-control" id="category_meta_keywords"><?php echo set_value('meta_keywords', $current_category['meta_keywords']); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group clearfix div-width-half">
                            <label class="col-sm-2 control-label">Meta Description</label>
                            <div class="col-sm-7 width-input-field">
                                <textarea name="meta_description" cols="40" rows="4" style="width:99%" class="form-control" id="category_meta_desc"><?php echo set_value('meta_description', $current_category['meta_description']); ?></textarea>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="" id="category_id" value="<?php echo $current_category['id']; ?>" />
                    <input type="hidden" name="current_parent_id" id="current_parent_id" value="<?php echo $current_category['parent_id']; ?>" />
                    <p align="center"><input type="submit" name="button" id="button" value="Submit" class="btn btn-lg btn-primary"></p>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        var temp = '<?php echo $current_category["is_new"] ?>';

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
    });
</script>