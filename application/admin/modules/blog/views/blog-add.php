<h3 class="title-hero clearfix">
    Add Blog
    <a href="blog" class="pull-right btn btn-primary">Manage Blog</a>
</h3>
<div id="tabs">
    <div class="panel">
        <div class="panel-body">
            <?php $this->load->view('inc-messages'); ?>
            <ul class="nav" id="tabs-nav">
                <li><a href="<?php echo current_url(); ?>#tabs-1">Main</a></li>
                <li><a href="<?php echo current_url(); ?>#tabs-2">Meta</a></li>
            </ul>
            <form action="blog/add" method="post" enctype="multipart/form-data" name="add_frm" id="add_frm">
                <div id="tabs-1" class="tab">

                    <div class="example-box-wrapper">
                        <div id="myTabContent" class="tab-content">
                            <div class="tab-pane fade active in" id="main">
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Title <span class="error">*</span></label>
                                    <div class="col-sm-6">
                                        <input name="title" type="text" class="form-control" id="title" value="<?php echo set_value('title'); ?>" size="40">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">URI</label>
                                    <div class="col-sm-6">
                                        <input name="url_alias" type="text" class="form-control" id="url_alias" value="<?php echo set_value('url_alias'); ?>" size="40">
                                        &nbsp;(Will be auto-generated if left blank)
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Date <span class="error">*</span></label>
                                    <div class="col-sm-6">
                                        <div class="input-prepend input-group">
                                            <span class="add-on input-group-addon">
                                                <i class="glyph-icon icon-calendar"></i>
                                            </span>
                                            <input name="date" type="text" class="bootstrap-datepicker form-control" value="<?php echo set_value('date'); ?>" data-date-format="yyyy-mm-dd" autocomplete="off" required>
                                        </div>
                                        <!--<input name="date" type="text" class="form-control" id="date" value="<?php // echo set_value('date');    ?>" size="40">-->
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Name</label>
                                    <div class="col-sm-6">
                                        <input name="name" type="text" class="form-control" value="<?php echo set_value('name'); ?>" size="40">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Blog Image </label>
                                    <div class="col-sm-6">
                                        <input type="file" name="image" id="image" class="form-control"><small>Please upload size around 600 * 400</small>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Alt</label>
                                    <div class="col-sm-6">
                                        <input name="alt" type="text" class="form-control" value="<?php echo set_value('alt'); ?>" size="40">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Blog Description</label>
                                    <div class="col-sm-12" style="display: table;">
                                        <textarea name="contents" style="width:99%" class="form-control" id="contents"><?php echo set_value('contents'); ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <!-- <label class="col-sm-2 control-label"></label> -->
                                    <div class="col-sm-12" align="center">
                                        <input name="image_v" type="hidden" id="image_v" value="1">
                                        Fields marked with <span class="error">*</span> are required.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div id="tabs-2" class="tab">
                    <div class="form-group clearfix">
                        <label class="col-sm-2 control-label">Browser Title</label>
                        <div class="col-sm-6">
                            <input name="browser_title" type="text" class="form-control" id="browser_title" value="<?php echo set_value('browser_title'); ?>" size="40">
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="col-sm-2 control-label">Meta Keywords</label>
                        <div class="col-sm-6">
                            <textarea name="meta_keywords" style="width:99%" class="form-control" id="meta_keywords"><?php echo set_value('meta_keywords'); ?></textarea>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="col-sm-2 control-label">Meta Description</label>
                        <div class="col-sm-6">
                            <textarea name="meta_description" style="width:99%" class="form-control" id="meta_description"><?php echo set_value('meta_description'); ?></textarea>
                        </div>
                    </div>
                </div>
                <p align="center"><input type="submit" name="button" id="button" value="Submit" class="btn btn-lg btn-primary"></p>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        "use strict";
        $('.bootstrap-datepicker').bsdatepicker({
            format: 'dd-mm-yyyy'
        });
    });
</script>