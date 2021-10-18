<h3 class="title-hero clearfix">
    Edit Slide
    <a href="homepage" class="pull-right btn btn-primary">Manage Slides</a>
</h3>
<div class="panel">
    <div class="panel-body">
        <div class="example-box-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <?php $this->load->view('inc-messages'); ?>
                    <form action="homepage/slide/edit/<?php echo $slideshowimage['slideshow_image_id']; ?>" method="post" enctype="multipart/form-data" name="addcatform" id="addcatform">
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Slide Show Image <span class="error">*</span></label>
                            <div class="col-sm-7">
                                <?php if ($slideshowimage['slideshow_image'] != '') { ?>
                                    <img src="<?php echo $this->config->item('SLIDESHOW_IMAGE_URL') . $slideshowimage['slideshow_image']; ?>" border="0" width="200px"/><br />
                                <?php } ?>
                                <input name="image" type="file" id="image" size="42" class="form-control" />
                                <br />
                                <small>Only .jgp,.gif,.png images allowed</small>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Alt</label>
                            <div class="col-sm-7">
                                <input type="text" name="alt" id="alt" class="form-control" size="35px" value="<?php echo set_value('alt', $slideshowimage['alt']); ?>">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Link</label>
                            <div class="col-sm-7">
                                <input type="text" name="link" id="link" class="form-control" size="35px" value="<?php echo set_value('link', $slideshowimage['link']); ?>">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Heading</label>
                            <div class="col-sm-7">
                                <input type="text" name="heading" class="form-control" value="<?php echo set_value('heading', $slideshowimage['heading']); ?>" />
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Tag Line</label>
                            <div class="col-sm-7">
                                <input type="text" name="tagline" class="form-control" value="<?php echo set_value('tagline', $slideshowimage['tagline']); ?>" />
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Price</label>
                            <div class="col-sm-7">
                                <input type="text" name="price" class="form-control" value="<?php echo set_value('price', $slideshowimage['price']); ?>" />
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">New Window </label>
                            <div class="col-sm-7">
                                <input type="radio" name="new_window" value="1" <?php echo set_radio("new_window", 1, ($slideshowimage['new_window'] == 1)); ?> />Yes
                                <input type="radio" name="new_window" value="0" <?php echo set_radio("new_window", '0', ($slideshowimage['new_window'] == 0)); ?> />No
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <!-- <label class="col-sm-2 control-label"></label> -->
                            <div class="col-sm-12" align='center'>
                                Fields marked with <span class="error">*</span> are required.<br />
                                <input name="v_image" type="hidden" id="v_image" value="1" />
                                
                                <?php if ($slideshowimage['active'] == 1) { ?>
                                    <input type="hidden" name="image_active" value="1"/>
                                <?php } else { ?>
                                    <input type="hidden" name="image_active" value="0"/>
                                <?php } ?>
                                    
                                <input type="submit" name="button" class="btn btn-primary" id="button" value="Update">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
