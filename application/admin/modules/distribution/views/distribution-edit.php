<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<style>
    .select2 {
        width: 100% !important
    }
</style>
<h3 class="title-hero clearfix">
    Update distribution
    <a href="distribution" class="pull-right btn btn-primary">Manage distributions</a>
</h3>
<?php $this->load->view('inc-messages'); ?>
<div id="tabs">
    <div class="panel">
        <div class="panel-body">


            <form action="distribution/edit/<?php echo $distribution['id']; ?>" method="post" name="add_frm" enctype="multipart/form-data" id="add_frm">
                <div class="example-box-wrapper">
                    <div id="tabs-1" class="tab">
                        <div id="myTabContent" class="tab-content">
                            <div class="tab-pane fade active in" id="main">
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Name</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="distribution_name" value="<?php echo set_value('distribution_name', $distribution['distribution_name']); ?>" style="width:50%">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Address<span class="error">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="distribution_location" value="<?php echo set_value('distribution_location', $distribution['distribution_location']); ?>" style="width:50%">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Address 2</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="distribution_location_2" value="<?php echo set_value('distribution_location_2', $distribution['distribution_location_2']); ?>" style="width:99%">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Town/City<span class="error">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="distribution_city" value="<?php echo set_value('distribution_city', $distribution['distribution_city']); ?>" style="width:99%">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Postal Code<span class="error">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="distribution_pcode" value="<?php echo set_value('distribution_pcode', $distribution['distribution_pcode']); ?>" style="width:99%">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">County</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="distribution_county" value="<?php echo set_value('distribution_county', $distribution['distribution_county']); ?>" style="width:99%">
                                    </div>
                                </div>

                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Country<span class="error">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control shipping" name="distribution_country" id="distribution_country" placeholder="" value="UNITED KINGDOM" readonly="">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Email</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="distribution_email" value="<?php echo set_value('distribution_email', $distribution['distribution_email']); ?>" style="width:99%">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Phone</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="distribution_phone" value="<?php echo set_value('distribution_phone', $distribution['distribution_phone']); ?>" style="width:99%">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">latitude<span class="error">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control shipping" name="distribution_latitude" id="distribution_latitude" placeholder="" value="<?php echo set_value('distribution_latitude', $distribution['distribution_latitude']); ?>">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">longitude<span class="error">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control shipping" name="distribution_longitude" id="distribution_longitude" placeholder="" value="<?php echo set_value('distribution_longitude', $distribution['distribution_longitude']); ?>">
                                    </div>
                                </div>
                                <div class="form-group clearfix" style="display: none;">
                                    <label class="col-sm-2 control-label">Postcode to provide service</label>
                                    <div class="col-sm-6">
                                        <?php $getpostcodes = getpostcodes($distribution['id'])   ?>
                                        <select class="js-example-basic-multiple" name="states[]" multiple="multiple" width="100%">
                                            <?php foreach ($getpostcodes as $getpostcode) { ?>
                                                <option selected value="<?= $getpostcode['id'] ?>"><?= $getpostcode['postcode'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>


                            </div>
                            <p align="center"><input type="submit" name="button" id="button" value="Update" class="btn btn-lg btn-primary"></p>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        $(".js-example-basic-multiple").select2({
            ajax: {
                url: "<?= base_url() ?>distribution/postcodes",
                type: "post",
                dataType: 'json',
                delay: 250,
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
    });
</script>