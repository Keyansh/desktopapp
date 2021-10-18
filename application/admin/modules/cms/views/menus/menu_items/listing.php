<h3 class="title-hero clearfix">
    <?php echo $menu_detail['menu_name']; ?>
    <div class="pull-right">
        <a href="cms/menu/index" class="btn btn-info" style="background: #094e91;">
            Manage Menus
        </a>
        <a href="cms/menu_item/add/<?php echo $menu_detail['menu_id']; ?>" class="btn btn-info" style="background: #094e91;">
            Add Page
        </a>
        <a href="cms/menu_item/insert_url/<?php echo $menu_detail['menu_id']; ?>" class="btn btn-info" style="background: #ffd32c;">
            Add URL
        </a>
        <a href="cms/menu_item/addurl/<?php echo $menu_detail['menu_id']; ?>" class="btn btn-info" style="background: #094e91;">
            Add Category Menu
        </a>
        <a href="cms/menu_item/placeholder/<?php echo $menu_detail['menu_id']; ?>" class="btn btn-info" style="background: #094e91;">
            Add Placeholder
        </a>
    </div>
</h3>
<div class="panel">
    <div class="panel-body">
        <div class="example-box-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <?php $this->load->view('inc-messages'); ?>
                    <?php
                    if (count($menu_items) == 0) {
                        $this->load->view('inc-norecords');
                        return;
                    }
                    ?>
                    <?php echo $menutree; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="dialog-modal" title="Working">
    <p style="text-align: center; padding-top: 40px;">Updating the sort order...</p>
</div>