<style>
@media(min-width:1500px){
.div-width-half {
	width: 50%;
    float: left;
    margin-bottom:40px
}
.col-sm-6{
    width:60%
}
}

</style>

<h3 class="title-hero clearfix">
    Add Product Attributes
    <a href="catalog/attribute/index" class="pull-right btn btn-primary">Manage Attributes</a>
</h3>
<div class="panel">
    <div class="panel-body">
        <?php $this->load->view('inc-messages'); ?>
        <form action="catalog/attribute/add" method="post" enctype="multipart/form-data" name="addcatform" id="addcatform">
            <div class="example-box-wrapper">
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="main">
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Attribute Name <span class="error">*</span></label>
                            <div class="col-sm-6">
                                <input name="name" type="text" class="form-control" id="attribute_name" value="<?php echo set_value('attribute_name'); ?>" size="40" />
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Attribute Label <span class="error">*</span></label>
                            <div class="col-sm-6">
                                <input name="label" type="text" class="form-control" id="attribute_label" value="<?php echo set_value('attribute_label'); ?>" size="40" />
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Attribute Code <span class="error">*</span></label>
                            <div class="col-sm-6">
                                <input name="code" type="text" class="form-control" id="attribute_label" value="<?php echo set_value('attribute_label'); ?>" size="40" />
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Attribute Type <span class="error">*</span></label>
                            <div class="col-sm-6">
                                <?php
                                $attr_type = array('' => 'Select Type', 'checkbox' => 'Checkbox', 'dropdown' => 'Dropdown Menu');
                                echo form_dropdown('type', $attr_type, set_value('type'), ' class="form-control" id="type"');
                                ?>

                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Is Main <small></small><span class="error">*</span></label>
                            <div class="col-sm-6">
                                <input type="radio" name="is_main" value="0" checked> No
                                <input type="radio" name="is_main" value="1"> Yes
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">
                                Display attributes swatches on product listing <small></small><span class="error">*</span>
                            </label>
                            <div class="col-sm-6">
                                <input type="radio" name="for_swatches" value="0" checked> No
                                <input type="radio" name="for_swatches" value="1"> Yes
                                <br/>
                                <small style="color: red;">Only one attribute can be set as swatches display</small>
                            </div>
                        </div>
                        <div class="form-group clearfix" style="display: none;">
                            <label class="col-sm-2 control-label">Use for filter</label>
                            <div class="col-sm-6">
                                <input type="radio" name="for_layered" value="0" checked> No
                                <input type="radio" name="for_layered" value="1"> Yes
                            </div>
                        </div>
                        <div class="form-group clearfix" >
                            <label class="col-sm-2 control-label">FrontEnd View</label>
                            <div class="col-sm-6">
                                <input type="radio" name="front_view" value="list" checked> List
                                <input type="radio" name="front_view" value="dropdown"> Dropdown
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label"></label>
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
