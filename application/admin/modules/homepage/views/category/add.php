<h3 class="title-hero clearfix">
    Choose Categories
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
                    <form action="homepage/category/add" method="post" enctype="multipart/form-data" name="add_frm" id="add_frm">
                        <div class="col-md-12">
                            <h3 style="display: inline-block; border-bottom: 1px solid #ddd; margin-bottom: 10px;padding: 10px 0;">Select Main Category</h3>
                            <div class="form-group clearfix">
                                <label class="col-sm-2 control-label">Category <span class="error">*</span></label>
                                <div class="col-sm-10">
                                    <select name="category" class="form-control" id="catid" required>
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
                                    <input type="file" name="image" id="image" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-sm-2 control-label">Alt</label>
                                <div class="col-sm-10">
                                    <input type="text" name="alt" id="alt" class="form-control" size="35px">
                                </div>
                            </div>   
                        </div>
                        <div class="col-md-12">
                            <h3 style="border-bottom: 1px solid #ddd; margin-bottom: 10px;padding: 10px 0;">Select Child Categories <span class="btn btn-primary pull-right" id="newChild">Add Child</span></h3>
                            <div class="form-group clearfix" id="formGroup"></div>                            
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
    var childGlobal = '';
    $('#catid').on('change', function () {
        $('.childCats').remove();
        var catid = $('#catid').val();
        if (catid) {
            $.post("homepage/category/childCats", {cat_id: catid}, function (data) {
                if (data.childCats) {
                    childGlobal = data.childCats;
                    var childs = '';
                    for (var i = 0; i < data.childCats.length; i++) {
                        childs += '<option value="' + data.childCats[i].id + '">' + data.childCats[i].name + '</option>';
                    }
                    var markup = '<div class="col-sm-6 childCats">  <span class="deleterow">X</span><select name="childcat[]" class="form-control" required> <option value="">-Select Category-</option> ' + childs + ' </select> <br/><br/> <input type="file" name="imageChild[]" id="image" class="form-control" required> <br/> <input type="text" name="altChild[]" id="alt" class="form-control" size="35px" placeholder="Alt"> <br/> <textarea name="descriptionChild[]" class="form-control" placeholder="Description"></textarea> </div>';
                    $("#formGroup").after(markup);
                    $('select').select2();
                }
            }, "json");
        }
    });


    $("#newChild").on('click', function () {
        var childs1 = '';
        for (var i = 0; i < childGlobal.length; i++) {
            childs1 += '<option value="' + childGlobal[i].id + '">' + childGlobal[i].name + '</option>';
        }
        var markup1 = '<div class="col-sm-6 childCats"> <span class="deleterow">X</span><select name="childcat[]" class="form-control" required> <option value="">-Select Category-</option> ' + childs1 + ' </select> <br/><br/> <input type="file" name="imageChild[]" id="image" class="form-control" required> <br/> <input type="text" name="altChild[]" id="alt" class="form-control" size="35px" placeholder="Alt"> <br/> <textarea name="descriptionChild[]" class="form-control" placeholder="Description"></textarea> </div>';
        $(".childCats:last").after(markup1);
        $('select').select2();
    });

    $(document).on('click', '.deleterow', function () {
        $(this).closest(".childCats").remove();
    });

</script>
<style>
    .deleterow {
        background: red none repeat scroll 0 0;
        border-radius: 20%;
        color: #fff;
        cursor: pointer;
        font-size: 10px;
        font-weight: bold;
        padding: 1px 6px 3px;
        float: right;
        text-align: center;
    }
    .childCats{
        margin-bottom: 20px;
    }
</style>