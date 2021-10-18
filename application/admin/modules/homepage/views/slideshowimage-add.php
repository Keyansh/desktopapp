<h3 class="title-hero clearfix">
    Add Slide
    <div class="pull-right">
        <a href="homepage" class="btn btn-primary">Manage Slides</a>
    </div>
</h3>
<div class="panel">
    <div class="panel-body">
        <div class="example-box-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <?php $this->load->view('inc-messages'); ?>
                    <form action="homepage/slide/add/<?php echo $slideshow['slideshow_id']; ?>" method="post" enctype="multipart/form-data" name="add_frm" id="add_frm">
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Slideshow Image <span class="error">*</span></label>
                            <div class="col-sm-7">
                                <input type="file" name="image" id="image" class="form-control">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Alt</label>
                            <div class="col-sm-7">
                                <input type="text" name="alt" id="alt" class="form-control" size="35px">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Link</label>
                            <div class="col-sm-7">
                                <input type="text" name="link" id="link" class="form-control" size="35px">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Heading</label>
                            <div class="col-sm-7">
                                <input type="text" name="heading" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Tag Line</label>
                            <div class="col-sm-7">
                                <input type="text" name="tagline" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Price</label>
                            <div class="col-sm-7">
                                <input type="text" name="price" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">New Window</label>
                            <div class="col-sm-7">
                                <input type="radio" name="new_window" value="1" <?php echo set_radio("new_window", 1, true); ?> />Yes
                                <input type="radio" name="new_window" value="0" <?php echo set_radio("new_window", 0); ?> />No
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <!-- <label class="col-sm-2 control-label"></label> -->
                            <div class="col-sm-12 " align="center">
                                Fields marked with <span class="error">*</span> are required.<br />
                                <input name="v_image" type="hidden" id="v_image" value="1" />
                                <input type="submit" name="upload_btn" class="btn btn-primary" id="upload_btn" value="Upload">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
