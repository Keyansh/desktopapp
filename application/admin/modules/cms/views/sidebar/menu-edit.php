<h3 class="title-hero clearfix">
    Edit Sidebar Menu
    <a href="cms/sidebar" class="pull-right btn btn-primary">Manage Sidebar Menus</a>
</h3>
<div class="panel">
    <div class="panel-body">
        <div class="example-box-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <?php $this->load->view('inc-messages'); ?>
                    <form action="cms/sidebar/edit/<?php echo $menu['menu_id']; ?>" method="post" enctype="multipart/form-data" name="addcatform" id="addcatform">
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Menu Name <span class="error"> *</span></label>
                            <div class="col-sm-7">
                                <input name="menu_name" type="text" class="form-control" id="menu_name" value="<?php echo set_value('menu_name', $menu['menu_name']); ?>" size="40">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Display Name</label>
                            <div class="col-sm-7">
                                <input name="menu_title" type="text" class="form-control" id="menu_title" value="<?php echo set_value('menu_title', $menu['menu_title']); ?>" size="40">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <!-- <label class="col-sm-2 control-label"></label> -->
                            <div class="col-sm-12 text-center" align="center">
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