<h3 class="title-hero clearfix">
    Manage brochures
    <a href="catalog/product/brochures_add" class="pull-right btn btn-primary">Add brochures</a>
</h3>
<?php
$this->load->view('inc-messages');
if (count($brochures) == 0) {
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
                                    <th>Brochure Name</th>
                                    <th style="width: 200px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($brochures as $item) {
                                    ?>
                                    <tr>
                                        <td data-title="Slideshow Name"><?php echo $item['brochure']; ?></td>
                                        <td data-title="Action">
                                            <a href="catalog/product/brochures_edit/<?php echo $item['id']; ?>"  class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Edit'><i class="glyph-icon icon-linecons-pencil"></i></a>
                                            <a href="catalog/product/brochures_delete/<?php echo $item['id']; ?>" onclick="return confirm('Are you sure you want to delete this Brochure?');" class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Delete'><i class="glyph-icon icon-linecons-trash red-color"></i></a>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-12 pagination text-center"><?= $pagination ?></div>
            </div>
        </div>
    </div>
</div>