<link href="<?= base_url() ?>assets/widgets/chosen/chosen.css" rel="stylesheet">
<script src="<?= base_url() ?>assets/widgets/chosen/chosen.js"></script>
<h3 class="title-hero clearfix">
    Assign Offer
    <a href="offers" class="pull-right btn btn-primary">Manage Offers</a>
</h3>
<div class="panel">
    <div class="panel-body">
        <?php $this->load->view('inc-messages'); ?>
        <form action="offers/assign/<?= $offer['id'] ?>" method="post" enctype="multipart/form-data" name="add_frm" id="add_frm">
            <div class="example-box-wrapper">
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="main_ad">
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label"> Assign To <span class="error">*</span></label>
                            <div class="col-sm-10">
                                <select name="assigntype" class="form-control" id="assigntype">
                                    <option value="">-Select Assign Type-</option>
                                    <option value="1">Categories</option>
                                    <option value="2">Products</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group clearfix wrap-sub-cat" id="catslist">
                            <label class="col-sm-2 control-label">Categories <span class="error">*</span></label>
                            <div class="col-sm-10">
                                <select name="category[]" size="5" data-placeholder="Choose Category" class="parent_cats form-control">
                                    <?php
                                    foreach ($categories as $cat) {
                                        echo '<option value="' . $cat['id'] . '" >';
                                        echo $cat['name'];
                                        echo '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group clearfix" id="subcatslist"></div>
                        <div class="form-group clearfix" id="prodslist">
                            <label class="col-sm-2 control-label">Products <span class="error">*</span></label>
                            <div class="col-sm-10">
                                <select name="product[]" multiple="multiple" size="5" data-placeholder="Choose Product" class="chosen-select form-control">
                                    <?php
                                    foreach ($products as $prod) {
                                        echo '<option value="' . $prod['id'] . '">';
                                        echo $prod['name'];
                                        echo '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-10">
                                <input name="image_v" type="hidden" id="image_v" value="1">
                                Fields marked with <span class="error">*</span> are required.
                            </div>
                        </div>
                    </div>                    
                    <p align="center"><input type="submit" name="button" id="button" value="Submit" class="btn btn-lg btn-primary"></p>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(".chosen-select").chosen();
    $('#catslist,#prodslist').hide();
    $('#assigntype').on('change', function () {
        $(".chosen-select").val('').trigger("chosen:updated");
        var atype = $(this).val();
        if (atype == 1) {
            $('#catslist').show();
            $('#prodslist').hide();
        }
        else {
            $('#catslist').hide();
            $('#prodslist').show();
        }
    });
    $(document).on('change', '.parent_cats', function () {
        var parentVals = $(this).val();
        $(this).parents('.wrap-sub-cat').nextAll('.wrap-sub-cat').remove();
        if (parentVals) {
            $.post('offers/childList', {cat_ids: parentVals}, function (data) {
                if (data.childCats) {
                    var childs = '';
                    for (var i = 0; i < data.childCats.length; i++) {
                        childs += '<option value="' + data.childCats[i].id + '" class="' + ((jQuery.inArray(data.childCats[i].parent_id == parentVals)) ? 'pcategory' : 'pchild') + '">' + data.childCats[i].name + '</option>';
                    }
                    var markup = '<div class="form-group clearfix wrap-sub-cat"><label class="col-sm-2 control-label"></label><div class="col-sm-10"><select name="category[]" multiple="multiple" size="5" data-placeholder="Choose Category" class="parent_cats sub-cat-drop form-control">' + childs + '</select></div></div>';
                    $("#subcatslist").before(markup);
                }
            }, "json");
        }
    });
</script>
<style>
    .pcategory{font-weight: bold;}
    .pchild{padding-left: 25px !important;}
</style>