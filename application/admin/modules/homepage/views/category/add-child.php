<h3 class="title-hero clearfix">
    Add Child Category
    <div class="pull-right">
        <a href="homepage" class="btn btn-primary">Manage Home Categories</a>
    </div>
</h3>
<div class="panel">
    <div class="panel-body">
        <div class="example-box-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <?php $this->load->view('inc-messages'); ?>
                    <form action="homepage/category/addChild/<?= $category['id'] ?>" method="post" enctype="multipart/form-data" name="add_frm" id="add_frm">
                        <div class="col-md-12">
                            <h3 style="display: inline-block; border-bottom: 1px solid #ddd; margin-bottom: 10px;padding: 10px 0;">Select Category</h3>
                            <div class="form-group clearfix">
                                <label class="col-sm-2 control-label">Category <span class="error">*</span></label>
                                <div class="col-sm-10">
                                    <select name="category" class="form-control" id="catid" required>
                                        <option value="">-Select Category-</option>
                                        <?php foreach ($childCats as $childCat) { ?>
                                            <option value="<?= $childCat['id']; ?>"><?= $childCat['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-sm-2 control-label">Category Image <span class="error">*</span></label>
                                <div class="col-sm-10">
                                    <input type="file" name="image" id="image" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-sm-2 control-label">Alt</label>
                                <div class="col-sm-10">
                                    <input type="text" name="alt" id="alt" class="form-control" size="35px">
                                </div>
                            </div>  
                            <div class="form-group clearfix">
                                <label class="col-sm-2 control-label">Description</label>
                                <div class="col-sm-10">
                                    <textarea name="description" id="description" class="form-control"></textarea>
                                </div>
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
</script>