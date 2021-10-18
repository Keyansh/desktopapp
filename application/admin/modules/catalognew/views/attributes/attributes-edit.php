<h3 class="title-hero clearfix">
    Edit Product Attributes
    <a href="catalog/attribute/index" class="pull-right btn btn-primary">Manage Attributes</a>
</h3>
<div class="panel">
    <div class="panel-body">
        <?php $this->load->view('inc-messages'); ?>
        <form action="catalog/attribute/edit/<?php echo $attributes['id']; ?>" method="post" enctype="multipart/form-data" name="addcatform" id="addcatform">
            <div class="example-box-wrapper">
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="main">
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Attribute Name <span class="error">*</span></label>
                            <div class="col-sm-6">
                                <input name="name" type="text" class="form-control" id="attribute_name" value="<?php echo set_value('name', $attributes['name']); ?>" size="40" />
                                <small>(For internal reference only)</small>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Attribute Label <span class="error">*</span></label>
                            <div class="col-sm-6">
                                <input name="label" type="text" class="form-control" id="attribute_label" value="<?php echo set_value('label', $attributes['label']); ?>" size="40" />
                                <small>(Will be displayed on the store)</small>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Attribute Code <span class="error">*</span></label>
                            <div class="col-sm-6">
                                <input name="code" type="text" class="form-control" id="attribute_label" value="<?php echo set_value('code', $attributes['code']); ?>" size="40" />
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Attribute Type <span class="error">*</span></label>
                            <div class="col-sm-6">
                                <?php
                                  $attr_type = array('' => 'Select Type', 'radio' => 'Radio Buttons', 'dropdown' => 'Dropdown Menu', 'varchar' => 'Varchar', 'text' => 'Textarea');
                                echo form_dropdown('type', $attr_type, set_value('type', $attributes['type']), ' class="form-control" id="type"');
                                ?>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Is Main <small></small><span class="error">*</span></label>
                            <div class="col-sm-6">
                                <input type="radio" name="is_main" value="0" <?= ($attributes['is_main'] == 0) ? 'checked': ''; ?>> No
                                <input type="radio" name="is_main" value="1" <?= ($attributes['is_main'] == 1) ? 'checked': ''; ?>> Yes
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">For Details (<small>For Show on detail page</small>)<span class="error">*</span></label>
                            <div class="col-sm-6">
                                <input type="radio" name="for_details" value="0" <?= ($attributes['for_details'] == 0) ? 'checked': ''; ?>> No
                                <input type="radio" name="for_details" value="1" <?= ($attributes['for_details'] == 1) ? 'checked': ''; ?>> Yes
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
