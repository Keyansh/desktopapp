<h3 class="title-hero clearfix">
    Add brochures
    <div class="pull-right">
        <a href="catalog/product/brochures" class="btn btn-primary">Manage brochures</a>
    </div>
</h3>
<div class="panel">
    <div class="panel-body">
        <div class="example-box-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <?php $this->load->view('inc-messages'); ?>
                    <form action="catalog/product/brochures_add" method="post" enctype="multipart/form-data" name="add_frm" id="add_frm">
                        <div class="form-group clearfix">
                            <label class="col-sm-2">Brochures <span class="error">*</span></label>
                            <div class="col-sm-10">
                                <input type="file" name="brochure[]" multiple="" id="image" class="form-control">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2"></label>
                            <div class="col-sm-10">
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