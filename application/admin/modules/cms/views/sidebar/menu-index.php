<h3 class="title-hero clearfix">
    Manage Sidebar Menus
    <a href="cms/sidebar/add/" class="pull-right btn btn-primary">Add Menu</a>
</h3>
<?php
$this->load->view('inc-messages');
if (count($menu) == 0) {
    $this->load->view('inc-norecords');
    echo "</div>";
    return;
}
?>

<div class="panel">
    <div class="panel-body">
        <div class="example-box-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <div class="remove-columns">
                        <table class="table table-bordered table-striped table-condensed cf">
                            <thead class="cf">
                                <tr>
                                    <th style="color: black;">Menu Alias</th>
                                    <th style="width: 200px; color: black;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($menu as $item) { ?>
                                    <tr>
                                        <td data-title="Menu Alias"><?php echo $item['menu_name']; ?></td>
                                        <td data-title="Action">
                                            <a href="cms/sidebar_menu_item/index/<?php echo $item['menu_id']; ?>">Menu Items</a> | 
                                            <a href="cms/sidebar/edit/<?php echo $item['menu_id']; ?>" class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Edit'><i class="glyph-icon icon-linecons-pencil"></i></a> | 
                                            <a href="cms/sidebar/delete/<?php echo $item['menu_id'] ?>" onclick="return confirm('Are you sure you want to Delete this Menu ?');"  class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Delete'><i class="glyph-icon icon-linecons-trash red-color"></i></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>