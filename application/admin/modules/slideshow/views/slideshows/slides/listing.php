<h3 class="title-hero clearfix">
    Manage <?php echo $slideshow['slideshow_title']; ?> Slides
    <div class="pull-right">
        <a href="slideshow" class="btn btn-primary">Manage Slide Show</a>
        <a href="slideshow/slide/add/<?php echo $slideshow['slideshow_id']; ?>" class="btn btn-primary">Add Slide</a>
    </div>
</h3>

<div class="panel">
    <div class="panel-body">
        <div class="example-box-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <?php echo $slidetree; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="dialog-modal" title="Working">
    <p style="text-align: center; padding-top: 40px;">Updating the sort order...</p>
</div>