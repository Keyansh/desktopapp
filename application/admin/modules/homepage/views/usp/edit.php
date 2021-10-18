<h3 class="title-hero clearfix">
    Edit USP
    <div class="pull-right">
        <a href="homepage" class="btn btn-primary">Manage USP</a>
    </div>
</h3>
<div class="panel">
    <div class="panel-body">
        <div class="example-box-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <?php $this->load->view('inc-messages'); ?>
                    <form action="homepage/usp/edit/<?= $usp['usp_id'] ?>" method="post" enctype="multipart/form-data" name="add_frm" id="add_frm">
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">USP Icon <span class="error">*</span></label>
                            <div class="col-sm-10">
                                <?php if ($usp['usp_image'] != '') { ?>
                                    <img src="<?php echo $this->config->item('USP_IMAGE_URL') . $usp['usp_image']; ?>" border="0"/><br />
                                <?php } ?>
                                <input type="file" name="image" id="image" class="form-control">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Alt</label>
                            <div class="col-sm-10">
                                <input type="text" name="alt" id="alt" class="form-control" size="35px" value="<?php echo set_value('alt', $usp['alt']); ?>">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Content <span class="error">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" name="content" id="content" class="form-control" size="35px" value="<?php echo set_value('content', $usp['content']); ?>">
                            </div>
                        </div>

                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-10 text-center">
                                Fields marked with <span class="error">*</span> are required.<br />
                                <input name="v_image" type="hidden" id="v_image" value="1" />
                                <input type="submit" name="upload_btn" class="btn btn-primary" id="upload_btn" value="Submit">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>