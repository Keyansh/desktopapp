<h3 class="title-hero clearfix">
    Manage Menus
</h3>
<?php
$this->load->view('inc-messages');
if (count($ActiveCategories) == 0) {
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
                                    <th style="color: black;">Menu</th>
                                    <th style="width: 165px ;color: black;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($ActiveCategories as $item) { ?>
                                    <tr>
                                        <td data-title="Menu"><?php echo $item['category']; ?></td>
                                        <td data-title="Action"><a href="cms/megamenu/subcategory/<?php echo $item['category_id']; ?>">Menu Items</a> </td>
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