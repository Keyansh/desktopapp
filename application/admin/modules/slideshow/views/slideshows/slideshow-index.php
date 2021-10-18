<h3 class="title-hero clearfix">
    Manage Slideshow
    <a href="slideshow/slideshow/add" class="pull-right btn btn-primary">Add Slideshow</a>
</h3>
<?php
$this->load->view('inc-messages');
if (count($slideshows) == 0) {
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
                                    <th>Slideshow Name</th>
                                    <th style="width: 200px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($slideshows as $item) {
                                    $enable_disable_link = 'slideshow/disable/' . $item['slideshow_id'];
                                    $enable_disable_text = '<i class="glyph-icon icon-linecons-eye green-color"></i>';
                                    if ($item['active'] == 0) {
                                        $enable_disable_text = '<i class="glyph-icon icon-eye-slash red-color"></i>';
                                        $enable_disable_link = 'slideshow/enable/' . $item['slideshow_id'];
                                    }
                                    ?>
                                    <tr>
                                        <td data-title="Slideshow Name"><?php echo $item['slideshow_title']; ?></td>
                                        <td data-title="Action">
                                            <a href="slideshow/slide/index/<?php echo $item['slideshow_id']; ?>">Slides</a>
                                            <a href="<?php echo $enable_disable_link; ?>" onclick="return confirm('Are you sure you want to Enable/Disable this Slideshow?');"><?php echo $enable_disable_text; ?></a>
                                            <a href="slideshow/edit/<?php echo $item['slideshow_id']; ?>"  class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Edit'><i class="glyph-icon icon-linecons-pencil"></i></a>
                                            <a href="slideshow/delete/<?php echo $item['slideshow_id']; ?>" onclick="return confirm('Are you sure you want to delete this Slideshow?');" class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Delete'><i class="glyph-icon icon-linecons-trash red-color"></i></a>
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