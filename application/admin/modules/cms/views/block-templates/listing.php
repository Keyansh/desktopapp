<h3 class="title-hero clearfix">
    Manage Block Templates
    <a href="cms/block_template/add" class="pull-right btn btn-primary">Add Block Template</a>
</h3>
<?php
$this->load->view('inc-messages');
if (count($templates) == 0) {
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
                                    <th>Template</th>
                                    <th style="width: 100px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($templates as $item) { ?>
                                    <tr>
                                        <td data-title="Template"><?php echo $item['block_template_name']; ?></td>
                                        <td data-title="Action"><a href="cms/block_template/edit/<?php echo $item['block_template_id']; ?>"  class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Edit'><i class="glyph-icon icon-linecons-pencil"></i></a> | <a href="cms/block_template/delete/<?php echo $item['block_template_id']; ?>" onclick="return confirm('Are you sure you want to delete this Template?');"  class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Delete'><i class="glyph-icon icon-linecons-trash red-color"></i></a>
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
<p style="text-align:center"><?php echo $pagination; ?></p>