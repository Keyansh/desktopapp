<h3 class="title-hero clearfix">
    Edit URL Link
    <div class="pull-right">
        <a href="cms/sidebar/index" class="btn btn-info" style="background: #ffd32c;">
            Manage Sidebar Menus
        </a>
        <a href="cms/sidebar_menu_item/index/<?php echo $menu_item['menu_id']; ?>" class="btn btn-info" style="background: #ffd32c;">
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
                    <form action="cms/sidebar_menu_item/update_url/<?php echo $menu_item['menu_item_id']; ?>" method="post" enctype="multipart/form-data" name="regFrm" id="regFrm">
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Parent</label>
                            <div class="col-sm-7">
                                <?php echo form_dropdown('parent_id', $parent_menu, set_value('parent_id', $menu_item['parent_id']), ' class="form-control"'); ?>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">URL <span class="error">*</span></label>
                            <div class="col-sm-7">
                                <input name="url" type="text" class="form-control" id="url" value="<?php echo set_value('url', $menu_item['url']); ?>" size="45" />
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Menu Item Name <span class="error">*</span></label>
                            <div class="col-sm-7">
                                <input name="menu_item_name" type="text" class="form-control" id="menu_item_name" value="<?php echo set_value('menu_item_name', $menu_item['menu_item_name']); ?>" size="45" />
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Open In New Window <span class="error" style="margin-left: -3px;">*</span></label>
                            <div class="col-sm-7">
                                <input name="new_window" id="new_window" type="radio" value="1"  checked="checked"<?php echo set_radio('new_window', '1'); ?> <?php echo ($menu_item['new_window'] == '1') ? 'checked="checked"' : ''; ?>/>Yes
                                <input type="radio" id="new_window" name="new_window" value="0"  <?php echo set_radio('new_window', '1'); ?> <?php echo ($menu_item['new_window'] == '0') ? 'checked="checked"' : ''; ?> /> No 
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-12 text-center">
                                <input type="submit" name="button" id="button" class="btn btn-primary" value="Submit">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>