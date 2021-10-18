<h3 class="title-hero clearfix">
    Add Brand
    <a href="brand/" class="pull-right btn btn-primary">Manage Brands</a>
</h3>
<div class="panel">
    <div class="panel-body">
        <?php $this->load->view('inc-messages'); ?>
        <form action="brand/add/" method="post" enctype="multipart/form-data" name="addcatform" id="addcatform">
            <div class="example-box-wrapper">
                <ul id="myTab" class="nav clearfix nav-tabs">
                    <!-- <li class="active"><a href="#main" data-toggle="tab">Main</a></li> -->
                    <!-- <li class=""><a href="#metadata" data-toggle="tab">Metadata</a></li> -->
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="main">
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Name <span class="error">*</span></label>
                            <div class="col-sm-6">
                                <input name="name" type="text" class="form-control" id="name" value="<?php echo set_value('name'); ?>" size="40">
                            </div>
                        </div>
                        <!-- <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">URI</label>
                            <div class="col-sm-6">
                                <input name="uri" type="text" class="form-control" id="uri" value="<?php echo set_value('uri'); ?>" size="40">
                                &nbsp;(Will be auto-generated if left blank)
                            </div>
                        </div> -->
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Brand Logo <small><span class="error">*</span></small></label>
                            <div class="col-sm-6">
                                <input type="file" name="image" id="image" class="form-control" accept="image/x-png,image/gif,image/jpeg">
                                <small>Please upload size around 217*67</small>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Alt</label>
                            <div class="col-sm-6">
                                <input name="alt" type="text" class="form-control" value="<?php echo set_value('alt'); ?>" size="40">
                            </div>
                        </div>
                        <!--                        <div class="form-group clearfix">
                                                    <label class="col-sm-2 control-label">Brand Banner </label>
                                                    <div class="col-sm-6">
                                                        <input type="file" name="brand_banner" id="brand_banner" class="form-control">
                                                    </div>
                                                </div>-->
                        <!-- <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Brand Description</label>
                            <div class="col-sm-10">
                                <textarea name="description" style="width:99%" class="form-control" id="description"><?php echo set_value('description'); ?></textarea>
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
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Browser Title</label>
                            <div class="col-sm-10">
                                <input name="browser_title" type="text" class="form-control" id="browser_title" value="<?php echo set_value('browser_title'); ?>"  style="width:99%">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Meta Keywords</label>
                            <div class="col-sm-10">
                                <textarea name="meta_keywords" cols="40" rows="4" style="width:99%" class="form-control" id="category_meta_keywords"><?php echo set_value('meta_keywords'); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Meta Description</label>
                            <div class="col-sm-10">
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