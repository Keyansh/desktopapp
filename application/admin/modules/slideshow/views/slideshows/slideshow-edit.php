<h3 class="title-hero clearfix">
    Edit Slideshow
    <a href="slideshow" class="pull-right btn btn-primary">Manage Slideshow</a>
</h3>
<div class="panel">
    <div class="panel-body">
        <div class="example-box-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <?php $this->load->view('inc-messages'); ?>
                    <form action="slideshow/edit/<?php echo $slideshow['slideshow_id']; ?>" method="post" enctype="multipart/form-data" name="addcatform" id="addcatform">
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Slideshow Title <span class="error">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" name="slideshow_title" id="slideshow_title" class="form-control" value="<?php echo set_value('slideshow_title', $slideshow['slideshow_title']); ?>">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-10 text-center">
                                Fields marked with <span class="error">*</span> are required.<br />
                                <input type="submit" name="button" class="btn btn-primary" id="upload_btn" value="Submit">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>