<?php
$this->load->view('inc-messages');
?>
<h3 class="title-hero clearfix">
    Manage <?php echo @$slideshow['slideshow_title']; ?> Homepage Slides
    <div class="pull-right">
        <a href="homepage/slide/add/1" class="btn btn-primary">Add Slide</a>
    </div>
</h3>

<div class="panel homepagemodule">
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

<!-- <h3 class="title-hero clearfix">
    Manage USP's
    <div class="pull-right">
        <a href="homepage/usp/add" class="btn btn-primary">Add USP</a>
    </div>
</h3> -->

<!-- <div class="panel homepagemodule">
    <div class="panel-body">
        <div class="example-box-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <?php //echo $usptree; ?>
                </div>
            </div>
        </div>
    </div>
</div> -->

<!-- <h3 class="title-hero clearfix">
    Manage Top Categories
    <div class="pull-right">
        <a href="homepage/topcat/add" class="btn btn-primary">Add Category</a>
    </div>
</h3> -->

<!-- <div class="panel homepagemodule">
    <div class="panel-body">
        <div class="example-box-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <?php //echo $topcattree; ?>
                </div>
            </div>
        </div>
    </div>
</div> -->

<!-- <h3 class="title-hero clearfix">
    Manage Offers
    <div class="pull-right">
        <a href="homepage/homeoffer/add" class="btn btn-primary">Select Offers</a>
    </div>
</h3>

<div class="panel homepagemodule">
    <div class="panel-body">
        <div class="example-box-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <?php echo $offertree; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<h3 class="title-hero clearfix">
    Manage Home Categories
    <div class="pull-right">
        <a href="homepage/category/add" class="btn btn-primary">Select Categories</a>
    </div>
</h3>

<div class="panel homepagemodule">
    <div class="panel-body">
        <div class="example-box-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <?php //echo $homecatTree; ?>
                </div>
            </div>
        </div>
    </div>
</div> -->

<div id="dialog-modal" title="Working">
    <p style="text-align: center; padding-top: 40px;">Updating the sort order...</p>
</div>

<script>
    $("a#example1").fancybox({
        'titleShow': false
    });
    $('.editCat').on('click', function () {
        var cid = $(this).attr('cid');
        var imgsrc = "<?= $this->config->item('HOMECATEGORY_IMAGE_URL') ?>";
        $.post("homepage/category/getDetailAjax", {cat_id: cid}, function (data) {
            if (data.catDetail) {
                $('#editModal #catId').val(data.catDetail.id);
                $('#editModal #childName').html(data.catDetail.name);
                $('#editModal #alt').val(data.catDetail.alt);
                $('#editModal #description').val(data.catDetail.description);
                $("#childImage").attr("src", imgsrc + '/' + data.catDetail.image);
                $("#editChildCat").attr("action", 'homepage/category/edit/' + data.catDetail.id);

                console.log(data.catDetail);
                $('.editModalPop').trigger('click');
            }
        }, "json");
    });
//    $(document).on('click', '#submitChild', function () {
//        $(".error").hide();
//        $.post("homepage/category/updateAjax", $("#editChildCat").serialize(), function (data) {
//            if (data.status == 'error') {
//                $(data.msg.slice(0, -1)).show();
//                return false;
//            } else {
//                $('#childImage').hide();
//                $('#editModal #childName').html(data.html);
//                $("#editChildCat")[0].reset();
//            }
//        }, "json");
//    });
</script>

<button type="button" class="editModalPop" data-toggle="modal" data-target="#editModal" style="visibility: hidden;"></button>

<div id="editModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form name="editChildCat" id="editChildCat" method="post" enctype="multipart/form-data" action="homepage/category/edit">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="childName">Modal Header</h4>
                </div>
                <div class="modal-body">
                    <img src="" id="childImage" width="100"/>
                    <input name="image" id="image" class="form-control" required type="file"><br />
                    <input name="alt" id="alt" class="form-control" size="35px" placeholder="Alt" type="text">
                    <div class="alterror error" style="display:none;color:red">Please enter alt</div> <br />
                    <textarea name="description" id="description" class="form-control" placeholder="Description"></textarea>
                    <div class="descriptionerror error" style="display:none;color:red">Please enter description</div>
                    <input type="hidden" name="catid" id="catId" value="" />
                </div>
                <div class="modal-footer">
                    <button type="submit" id="submitChild" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>

    </div>
</div>
