<h3 class="title-hero clearfix text-center">
    <a href="catalog/attribute/index" class="btn btn-primary pull-left">Manage Attribute</a>
    Add Attribute Option
    <a href="catalog/attribute_option/index/<?php echo $attributes['id']; ?>" class="pull-right btn btn-primary">Manage Attribute Options</a>
</h3>

<div class="panel">
    <div class="panel-body">
        <?php $this->load->view('inc-messages'); ?>
        <form action="catalog/attribute_option/add/<?php echo $attributes['id']; ?>" method="post" enctype="multipart/form-data" name="addcatform" id="addcatform">
            <div class="example-box-wrapper">
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="main">
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Attribute Option <span class="error">*</span></label>
                            <div class="col-sm-6">
                                <input name="option" type="text" class="form-control" id="attribute_option" value="<?php echo set_value('option'); ?>" size="40" />
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Icon</label>
                            <div class="col-sm-6">
                                <input name="icon" type="file" class=""/>
                            </div>
                        </div>         
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Additional Info</label>
                            <div class="col-sm-6">
                                <input name="additional_info" type="text" class="form-control" id="additional_info" value="<?php echo set_value('additional_info'); ?>" size="40" />
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <!-- <label class="col-sm-2 control-label"></label> -->
                            <div class="col-sm-12" align="center">
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