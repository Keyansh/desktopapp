<h3 class="title-hero clearfix">
    Edit brochures
    <div class="pull-right">
        <a href="catalognew/product/brochures" class="btn btn-primary">Manage brochures</a>
    </div>
</h3>
<div class="panel">
    <div class="panel-body">
        <div class="example-box-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <?php $this->load->view('inc-messages'); ?>
                    <form action="catalognew/product/brochures_edit/<?php echo $brochure['id']; ?>" method="post" enctype="multipart/form-data" name="addcatform" id="addcatform">
                        <div class="form-group clearfix">
                            <label class="col-sm-2">Brochure <span class="error">*</span></label>
                            <div class="col-sm-10">
                                <?php if ($brochure['brochure'] != '') { ?>
                                    <a href="<?php echo $this->config->item('BROCHURES_URL') . $brochure['brochure']; ?>"><?= $brochure['brochure'] ?></a><br />
                                <?php } ?>
                                <input name="brochure" type="file" id="image" class="form-control" />
                            </div>
                        </div>

                        <div class="form-group clearfix">
                            <label class="col-sm-2"></label>
                            <div class="col-sm-10">
                                Fields marked with <span class="error">*</span> are required.<br />
                                <input name="v_image" type="hidden" id="v_image" value="1" />
                                <input type="submit" name="button" class="btn btn-primary" id="button" value="Update">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



