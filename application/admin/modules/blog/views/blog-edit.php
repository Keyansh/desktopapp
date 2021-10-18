<h3 class="title-hero clearfix">
    Update Blog
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
            <form action="blog/edit/<?php echo $blog['blog_id']; ?>" method="post" enctype="multipart/form-data" name="add_frm" id="add_frm">
                <div id="tabs-1" class="tab">
                    <div class="example-box-wrapper">
                        <div id="myTabContent" class="tab-content">
                            <div class="tab-pane fade active in" id="main">
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Title <span class="error">*</span></label>
                                    <div class="col-sm-6">
                                        <input name="title" type="text" class="form-control" id="title" value="<?php echo set_value('title', $blog['blog_title']); ?>" size="40">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">URI</label>
                                    <div class="col-sm-6">
                                        <input name="url_alias" type="text" class="form-control" id="url_alias" value="<?php echo set_value('url_alias', $blog['blog_alias']); ?>" size="40">
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
                                            <?php
                                            $date = date_create($blog['blog_date']);
                                            $date_val = date_format($date, 'd/m/Y');
                                            ?>
                                            <input name="date" type="text" class="bootstrap-datepicker form-control" value="<?php echo set_value('date', $date_val); ?>" data-date-format="dd-mm-yyyy" required>
                                        </div>
                                        <!--<input name="date" type="text" class="form-control" id="date" value="<?php // echo set_value('date');            ?>" size="40">-->
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Name</label>
                                    <div class="col-sm-6">
                                        <input name="name" type="text" class="form-control" value="<?php echo set_value('name', $blog['name']); ?>" size="40">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Blog Image </label>
                                    <div class="col-sm-6">
                                        <?php if ($blog['blog_image']) {
                                            ?>
                                            <img src="<?php echo $this->config->item('BLOG_THUMBNAIL_URL') . $blog['blog_image']; ?>" border="0" /><br />
                                        <?php }
                                        ?>
                                        <input type="file" name="image" id="image" class="form-control">
                                        <small>Please upload size around 600 * 400</small>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Alt</label>
                                    <div class="col-sm-6">
                                        <input name="alt" type="text" class="form-control" value="<?php echo set_value('alt', $blog['alt']); ?>" size="40">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Blog Description</label>
                                    <div class="col-sm-12">
                                        <textarea name="contents" style="width:99%" class="form-control" id="contents"><?php echo set_value('contents', $blog['blog_contents']); ?></textarea>
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
                            <input name="browser_title" type="text" class="form-control" id="browser_title" value="<?php echo set_value('browser_title', $blog['browser_title']); ?>" size="40">
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="col-sm-2 control-label">Meta Keywords</label>
                        <div class="col-sm-6">
                            <textarea name="meta_keywords" style="width:99%" class="form-control" id="meta_keywords"><?php echo set_value('meta_keywords', $blog['meta_keywords']); ?></textarea>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="col-sm-2 control-label">Meta Description</label>
                        <div class="col-sm-6">
                            <textarea name="meta_description" style="width:99%" class="form-control" id="meta_description"><?php echo set_value('meta_description', $blog['meta_description']); ?></textarea>
                        </div>
                    </div>
                </div>
                <p align="center"><input type="submit" name="button" id="button" value="Update" class="btn btn-lg btn-primary"></p>
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
<script type="text/javascript">
    $(document).ready(function () {
        $('#export-csv-btn').click(function () {
            var from_date = $('#from_date').val();
            var till_date = $('#till_date').val();

            $.post('order/export_orders_csv',
                    {
                        from_date: from_date,
                        till_date: till_date
                    },
                    function (data, status) {
                        if (data == 'no-data') {
                            $('#csv-download-link').hide(100, function () {
                                alert("No orders exist for given dates !");
                            });
                        } else {
                            data = JSON.parse(data);
                            if (data.report_file) {
                                $('#csv-download-link').attr('href', data.report_file).show();
                            }
                        }
                    });
        });
    });
</script>
