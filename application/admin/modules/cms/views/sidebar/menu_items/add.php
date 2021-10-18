<h3 class="title-hero clearfix">
    Add Page
    <div class="pull-right">
        <a href="cms/sidebar/index" class="btn btn-info" style="background: #094e91;">
            Manage Sidebar Menus
        </a>
        <a href="cms/sidebar_menu_item/index/<?php echo $menu_detail['menu_id']; ?>" class="btn btn-info" style="background: #094e91;">
            Manage Menu Items
        </a>
    </div>
</h3>

<div class="panel">
    <div class="panel-body">
        <div class="example-box-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <?php $this->load->view('inc-messages'); ?>
                    <form action="cms/sidebar_menu_item/add/<?php echo $menu_detail['menu_id']; ?>" method="post" enctype="multipart/form-data" name="regFrm" id="regFrm">
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Parent</label>
                            <div class="col-sm-7">
                                <?php echo form_dropdown('parent_id', $parent_menu, set_value('parent_id'), ' class="form-control"'); ?>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Page <span class="error">*</span></label>
                            <div class="col-sm-7">
                                <?php echo form_dropdown('page_id', $pages, set_value('page_id'), ' class="form-control"'); ?>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Menu Item Name <span class="error">*</span></label>
                            <div class="col-sm-7">
                                <input name="menu_item_name" type="text" class="form-control" id="menu_item_name" value="<?php echo set_value('menu_item_name'); ?>" size="45" />
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-12 text-center">
                                <input type="submit" name="button" class="btn btn-primary" id="button" value="Submit">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>