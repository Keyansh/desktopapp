<h3 class="title-hero clearfix">
    Add Top Category
    <div class="pull-right">
        <a href="homepage" class="btn btn-primary">Manage Top Categories</a>
    </div>
</h3>
<div class="panel">
    <div class="panel-body">
        <div class="example-box-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <?php $this->load->view('inc-messages'); ?>
                    <form action="homepage/topcat/add" method="post" enctype="multipart/form-data" name="add_frm" id="add_frm">
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Category <span class="error">*</span></label>
                            <div class="col-sm-10">
                                <select name="category" class="form-control" id="catid">
                                    <option value="">-Select Category-</option>
                                    <?php foreach ($categories as $category) { ?>
                                        <option value="<?= $category['id']; ?>"><?= $category['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Category Image <span class="error">*</span></label>
                            <div class="col-sm-10">
                                <input type="file" name="image" id="image" class="form-control">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Alt</label>
                            <div class="col-sm-10">
                                <input type="text" name="alt" id="alt" class="form-control" size="35px">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Price</label>
                            <div class="col-sm-10">
                                <input type="text" name="price" id="price" class="form-control" size="35px">
                            </div>
                        </div> 
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-10 text-center">
                                Fields marked with <span class="error">*</span> are required.<br />
                                <input name="v_image" type="hidden" id="v_image" value="1" />
                                <input type="submit" name="upload_btn" class="btn btn-primary" id="upload_btn" value="Submit">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<link href="js/select2.min.css" rel="stylesheet" />
<script src="js/select2.min.js"></script>
<script type="text/javascript">
    $('select').select2();
    $('#catid').on('change', function () {
        var catid = $('#catid').val();
//        alert(catid);
        if (catid) {
            $.post("homepage/topcat/CatProLowPrice", {cat_id: catid}, function (data) {
                if (data.price) {
                    $('#price').val(data.price);
                } else {
                    $('#price').val();
                }
            }, "json");
        }
    });
</script>