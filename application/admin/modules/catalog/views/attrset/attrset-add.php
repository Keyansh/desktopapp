<h3 class="title-hero clearfix">
    Add Attribute Set
    <a href="catalog/attrset/index" class="pull-right btn btn-primary">Manage Attribute Set</a>
</h3>
<div class="panel">
    <div class="panel-body">
        <div class="example-box-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <?php $this->load->view('inc-messages'); ?>
                    <form action="catalog/attrset/add" method="post" enctype="multipart/form-data" name="addcatform" id="addcatform">
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Attribute Set Name <span class="error">*</span></label>
                            <div class="col-sm-6">
                                <input name="name" type="test" id="name" value="<?php echo set_value('name'); ?>" class="textfield form-control" />
                            </div>
                        </div>
                        
                        <div class="form-group clearfix">
                            <!-- <label class="col-sm-2 control-label"></label> -->
                            <div class="col-sm-12 nn-style-fields-fill-cat">
                                Fields marked with <span class="error">*</span> are required.<br />
                                <input type="submit" name="button" class="btn btn-primary nn-style-fields-fill-cat" id="upload_btn" value="Submit" >
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    .nn-style-fields-fill-cat{
        text-align:center;
    }
    </style>