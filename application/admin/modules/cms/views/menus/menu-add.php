<h3 class="title-hero clearfix">
    Add Menu
    <a href="cms/menu" class="pull-right btn btn-primary">Manage Menus</a>
</h3>
<div class="panel">
    <div class="panel-body">
        <div class="example-box-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <?php $this->load->view('inc-messages'); ?>
                    <form action="cms/menu/add" method="post" enctype="multipart/form-data" name="addcatform" id="addcatform">
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Menu Name <span class="error"> *</span></label>
                            <div class="col-sm-7">
                                <input name="menu_name" type="text" class="form-control" id="menu_name" value="<?php echo set_value('menu_name'); ?>" size="40">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Display Name</label>
                            <div class="col-sm-7">
                                <input name="menu_title" type="text" class="form-control" id="menu_title" value="<?php echo set_value('menu_title'); ?>" size="40">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Menu Alias</label>
                            <div class="col-sm-7">
                                <input name="menu_alias" type="text" class="form-control" id="menu_alias" value="<?php echo set_value('menu_alias'); ?>" size="40">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <!-- <label class="col-sm-2 control-label"></label> -->
                            <div class="col-sm-12 text-center">
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