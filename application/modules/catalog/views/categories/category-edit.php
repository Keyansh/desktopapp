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
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Attribute Sets<span class="error">*</span></label>
                            <div class="col-sm-6">
                                <?php echo form_dropdown('attrset_id', $attrset, set_value('attrset_id', $current_category['attrset_id']), ' class="form-control" readonly'); ?>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Category <span class="error">*</span></label>
                            <div class="col-sm-6">
                                <input name="name" type="text" class="form-control" id="category" value="<?php echo set_value('name', $current_category['name']); ?>" size="40">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Category Alias</label>
                            <div class="col-sm-6">
                                <input name="uri" type="text" class="form-control" id="category_alias" value="<?php echo set_value('uri', $current_category['uri']); ?>" size="40">&nbsp;(Will be auto-generated if left blank)
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Category Image <small><span class="error">*</span></small></label>
                            <div class="col-sm-6">
                                <?php if ($current_category['image']) { ?>
                                    <img src="<?php echo $this->config->item('CATEGORY_THUMBNAIL_URL') . $current_category['image']; ?>" border="0" /><br />
                                <?php } ?>
                                <input name="image" type="file" id="image" size="35" class="form-control" />
                                <br />
                                <small>Only .jgp,.gif,.png images allowed</small>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Category Description</label>
                            <div class="col-sm-10">
                                <textarea name="description" cols="40" rows="4" style="width:99%" class="form-control" id="description"><?php echo set_value('descripton', $current_category['description']); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-10">
                                <input name="image_v" type="hidden" id="image_v" value="1">
                                Fields marked with <span class="error">*</span> are required.
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="metadata">
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Meta Title</label>
                            <div class="col-sm-7">
                                <input name="meta_title" type="text" class="form-control" id="meta_title" value="<?php echo set_value('meta_title', $current_category['meta_title']); ?>"  style="width:99%">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Meta Keywords</label>
                            <div class="col-sm-7">
                                <textarea name="meta_keywords" cols="40" rows="4" style="width:99%" class="form-control" id="category_meta_keywords"><?php echo set_value('meta_keywords', $current_category['meta_keywords']); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Meta Description</label>
                            <div class="col-sm-7">
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