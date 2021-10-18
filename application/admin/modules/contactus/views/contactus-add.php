<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<style>
    .select2 {
        width: 100% !important
    }
</style>
<h3 class="title-hero clearfix">
    Add Address
    <a href="contactus" class="pull-right btn btn-primary">Manage Address</a>
</h3>
<?php $this->load->view('inc-messages'); ?>
<div id="tabs">

    <div class="panel">
        <div class="panel-body">

            <form action="contactus/add" method="post" name="add_frm" id="add_frm" enctype="multipart/form-data">
                <div class="example-box-wrapper">
                    <div id="tabs-1" class="tab">
                        <div id="myTabContent" class="tab-content">
                            <div class="tab-pane fade active in" id="main">
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Name <span class="error">*</span> </label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="contactus_name" value="<?php echo set_value('contactus_name'); ?>" style="width:99%">
                                    </div>
                                </div> 
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Address <span class="error">*</span></label>
                                    <div class="col-sm-6">
                                        <textarea name="contactus_location" class="form-control" id="" cols="30" rows="4"><?php echo set_value('contactus_location'); ?> </textarea>
                                        <!-- <input type="text" class="form-control" name="contactus_location" value="<?php echo set_value('contactus_location'); ?>" style="width:99%"> -->
                                    </div>
                                </div>
                                <!-- <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Address 2</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="contactus_location_2" value="<?php echo set_value('contactus_location_2'); ?>" style="width:99%">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Town/City<span class="error">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="contactus_city" value="<?php echo set_value('contactus_city'); ?>" style="width:99%">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Postal Code<span class="error">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="contactus_pcode" value="<?php echo set_value('contactus_pcode'); ?>" style="width:99%">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">County</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="contactus_county" value="<?php echo set_value('contactus_county'); ?>" style="width:99%">
                                    </div>
                                </div> -->

                                <!-- <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Country <span class="error">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control shipping" name="contactus_country" id="contactus_country" placeholder="" value="<?php echo set_value('contactus_country'); ?>" >
                                    </div>
                                </div> -->
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Email </label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control shipping" name="contactus_email" id="contactus_email" placeholder="" value="<?php echo set_value('contactus_email'); ?>">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Website</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control shipping" name="contactus_web" id="contactus_web" placeholder="" value="<?php echo set_value('contactus_web'); ?>">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label"> Telephone </label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control shipping" name="contactus_phone" id="contactus_phone" placeholder="" value="<?php echo set_value('contactus_phone'); ?>">
                                    <small>To add multiple telephone numbers use " , " Example => (987654321,987654321) </small>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Fax </label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control shipping" name="contactus_fax" id="contactus_fax" placeholder="" value="<?php echo set_value('contactus_fax'); ?>">
                                    </div>
                                </div>
                              
                                <div class="form-group clearfix">
                                    <div class="col-sm-12" align="center">
                                        Fields marked with <span class="error">*</span> are required.
                                    </div>
                                </div>
                            </div>
                            <p align="center"><input type="submit" name="button" id="button" value="Submit" class="btn btn-lg btn-primary"></p>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>