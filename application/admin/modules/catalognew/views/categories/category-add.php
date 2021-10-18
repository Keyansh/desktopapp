<link rel="stylesheet" type="text/css" href="<?= base_url() ?>plugins/image-resizer/croppic.css"/>

<script type="text/javascript">
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
    Add Categories
    <a href="catalog/category/" class="pull-right btn btn-primary">Manage Category</a>
</h3>
<div class="panel">
    <div class="panel-body">
        <?php $this->load->view('inc-messages'); ?>
        <form action="catalog/category/add/" method="post" enctype="multipart/form-data" name="addcatform" id="addcatform">
            <div class="example-box-wrapper">
                <ul id="myTab" class="nav clearfix nav-tabs">
                    <li class="active"><a href="#main" data-toggle="tab">Main</a></li>
                    <li class=""><a href="#metadata" data-toggle="tab">Metadata</a></li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="main">
                        <input name="parent_id" type="hidden" class="form-control" id="parent_id" value="0" size="40">
                        <div class="form-group clearfix">
                            <label class="col-sm-4 control-label">Parent Category <span class="error">*</span></label>
                            <div class="col-sm-6">
                                <?php echo form_dropdown('parent_id', $parent, set_value('parent_id'), ' class="form-control"'); ?>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-4 control-label">Name <span class="error">*</span></label>
                            <div class="col-sm-6">
                                <input name="name" type="text" class="form-control" id="name" value="<?php echo set_value('name'); ?>" size="40">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-4 control-label">URI</label>
                            <div class="col-sm-6">
                                <input name="uri" type="text" class="form-control" id="uri" value="<?php echo set_value('uri'); ?>" size="40">
                                &nbsp;(Will be auto-generated if left blank)
                            </div>
                        </div>

                        <div class="form-group clearfix">
                            <label class="col-sm-4 control-label">Category Menu Image</label>
                            <div class="col-sm-6">
                                <input type="file" name="icon" class="form-control">
                            </div>
                        </div>

                        <div class="form-group clearfix">
                            <label class="col-sm-4 control-label">Category Image</label>
                            <div class="col-sm-6">
                                <input type="file" name="image" class="form-control">
                            </div>
                        </div>

                        <div class="form-group clearfix">
                            <label class="col-sm-4 control-label">Category Image Alt</label>
                            <div class="col-sm-6">
                                <input type="text" name="image_alt" class="form-control" value="<?php echo set_value('image_alt') ?>">
                            </div>
                        </div>

                        <div class="form-group clearfix">
                            <label class="col-sm-4 control-label">Category Banner</label>
                            <div class="col-sm-6">
                                <input type="file" name="banner" class="form-control">
                            </div>
                        </div>

                        <div class="form-group clearfix">
                            <label class="col-sm-4 control-label">Category Banner Alt</label>
                            <div class="col-sm-6">
                                <input type="text" name="banner_alt" class="form-control" value="<?php echo set_value('banner_alt') ?>">
                            </div>
                        </div>

                        <div class="form-group clearfix">
                            <label class="col-sm-4 control-label">Banner Title</label>
                            <div class="col-sm-6">
                                <input name="banner_title" type="text" class="form-control" id="banner_title" value="<?php echo set_value('banner_title'); ?>" size="40">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-4 control-label">Banner Content</label>
                            <div class="col-sm-6">
                                <textarea name="banner_content" type="text" class="form-control" id="banner_content"><?php echo set_value('banner_content'); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-4 control-label">Short Description</label>
                            <div class="col-sm-6">
                                <textarea name="short_description"  class="form-control" id="short_description"><?php echo set_value('short_description'); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-4 control-label">Category Description</label>
                            <div class="col-sm-12">
                                <textarea name="description" style="width:99%" class="form-control" id="description"><?php echo set_value('description'); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-4 control-label">Category Bottom Description</label>
                            <div class="col-sm-12">
                                <textarea name="bottom_description" style="width:99%" class="form-control" id="bottom_description"><?php echo set_value('bottom_description'); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-4 control-label">Show in Megamenu</label>
                            <div class="col-sm-6">
                                <select name="show_in_menu" class="form-control">
                                    <option value="1"> Yes </option>
                                    <option value="0"> No </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-4 control-label">Show as Child-category</label>
                            <div class="col-sm-6">
                                <select name="show_as_child" class="form-control">
                                    <option value="1"> Yes </option>
                                    <option value="0"> No </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-4 control-label">Featured</label>
                            <div class="col-sm-6">
                                <select name="featured" class="form-control">
                                    <option value="1"> Yes </option>
                                    <option value="0"> No </option>
                                </select>
                            </div>
                        </div>
                         <div class="form-group clearfix">
                            <label class="col-sm-4 control-label">Show in Homepage</label>
                            <div class="col-sm-6">
                                <select name="show_in_homepage" class="form-control">
                                    <option value="1"> Yes </option>
                                    <option value="0"> No </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-4 control-label">Is New</label>
                            <div class="col-sm-6">
                                <input id='new-yes' type="radio" name="is_new" value="1" <?php echo set_radio('is_new', '1', TRUE); ?> />Yes
                                <input id='new-no' type="radio" name="is_new" value="0" <?php echo set_radio('is_new', '0'); ?> />NO
                                <div class="new-div">
                                    <div>
                                        <span>New Start Date</span><input class="datepicker" data-date-format="mm/dd/yyyy" name="new_start_date">
                                    </div>
                                    <div>
                                        <span>New End Date</span><input class="datepicker" data-date-format="mm/dd/yyyy" name="new_end_date">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group clearfix">
                            <!-- <label class="col-sm-4 control-label"></label> -->
                            <div class="col-sm-12 nn-style-fields-fill-cat">
                                <input name="image_v" type="hidden" id="image_v" value="1">
                                Fields marked with <span class="error nn-style-error-col">*</span> are required.
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="metadata">
                        <div class="form-group clearfix">
                            <label class="col-sm-4 control-label">Meta Title</label>
                            <div class="col-sm-8">
                                <input name="meta_title" type="text" class="form-control" id="meta_title" value="<?php echo set_value('meta_title'); ?>"  style="width:99%">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-4 control-label">Meta Keywords</label>
                            <div class="col-sm-8">
                                <textarea name="meta_keywords" cols="40" rows="4" style="width:99%" class="form-control" id="category_meta_keywords"><?php echo set_value('meta_keywords'); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-4 control-label">Meta Description</label>
                            <div class="col-sm-8">
                                <textarea name="meta_description" cols="40" rows="4" style="width:99%" class="form-control" id="category_meta_desc"><?php echo set_value('meta_description'); ?></textarea>
                            </div>
                        </div>
                    </div>
                    <p align="center"><input type="submit" name="button" id="button" value="Submit" class="btn btn-lg btn-primary"></p>
                </div>
            </div>
        </form>
    </div>
</div>

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
    });
</script>
<style>
    .nn-style-fields-fill-cat {
    text-align: center;
}
.nn-style-error-col {
    color: #495d80;
}
    </style>