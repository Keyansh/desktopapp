<h3 class="title-hero clearfix">
    Manage Global Blocks
    <a href="cms/globalblock/add" class="pull-right btn btn-primary" style="background: #094e91;color: black;">Add Global Block</a>
</h3>
<?php
$this->load->view('inc-messages');
if (count($global_blocks) == 0) {
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
                                    <th style="color: black;">Block Title</th>
                                    <th style="color: black;">Block Alias</th>
                                    <th style="width: 100px ; color: black;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($global_blocks as $item) { ?>
                                    <tr>
                                        <td data-title="Block Title"><?php echo $item['block_title']; ?></td>
                                        <td data-title="Block Alias"><?php echo $item['block_alias']; ?></td>
                                        <td data-title="Action"><a href="cms/globalblock/edit/<?= $item['block_id']; ?>"  class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Edit'><i class="glyph-icon icon-linecons-pencil"></i></a> | <a href="cms/globalblock/delete/<?= $item['block_id']; ?>" onclick="return confirm('Are you sure you want to delete this Template?');"  class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Delete'><i class="glyph-icon icon-linecons-trash red-color"></i></a>
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