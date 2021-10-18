<h3 class="title-hero clearfix">
    Edit certification
    <a href="certification/" class="pull-right btn btn-primary">Manage certification</a>
</h3>
<div class="panel">
    <div class="panel-body">
        <?php $this->load->view('inc-messages'); ?>
        <form action="certification/edit/<?= $certification['id']; ?>" method="post" enctype="multipart/form-data" name="addcatform" id="addcatform">
            <div class="example-box-wrapper">

                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="main">
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Name <span class="error">*</span></label>
                            <div class="col-sm-6">
                                <input name="name" type="text" class="form-control" id="name" value="<?php echo set_value('name', $certification['name']); ?>" size="40">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Certification Logo <small><span class="error">*</span></small></label>
                            <div class="col-sm-6">
                                <?php if ($certification['image']) { ?>
                                    <img src="<?php echo $this->config->item('BRAND_THUMBNAIL_URL') . $certification['image']; ?>" border="0" /><br />
                                <?php } ?>
                                <input name="image" type="file" id="image" size="35" class="form-control" accept="image/x-png,image/gif,image/jpeg"/>
                                <small>Please upload size around 217*67</small>
                                <br />
                                <small>Only .jgp,.gif,.png images allowed</small>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Alt</label>
                            <div class="col-sm-6">
                                <input name="alt" type="text" class="form-control" value="<?php echo set_value('alt', $certification['alt']); ?>" size="40">
                            </div>
                        </div>

                        <div class="form-group clearfix">
                            <div class="col-sm-12" align="center">
                                <input name="image_v" type="hidden" id="image_v" value="1">
                                Fields marked with <span class="error">*</span> are required.
                            </div>
                        </div>
                    </div>

                    <p align="center"><input type="submit" name="button" id="button" value="Submit" class="btn btn-lg btn-primary"></p>
                </div>
            </div>
        </form>
    </div>
</div>