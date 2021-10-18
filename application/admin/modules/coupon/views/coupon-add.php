<h3 class="title-hero clearfix">
    Add Coupon
    <a href="coupon/index" class="pull-right btn btn-primary">Manage Coupons</a>
</h3>
<div class="panel">
    <div class="panel-body">
        <div class="example-box-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <?php $this->load->view('inc-messages'); ?>
                    <form action="coupon/add/" method="post" enctype="multipart/form-data" name="addcatform" id="addcatform">
                        <input type="hidden" id="profile" name="profile" value="0">
                        <!--                        <div class="form-group clearfix">
                                                    <label class="col-sm-2 control-label">Applicable on <span class="error"> *</span></label>
                                                    <div class="col-sm-7">
                        <?php //echo form_dropdown('profile', $profilegroups, set_value('Select Profile'), 'id="profile" class="form-control textfield width_auto"'); ?>
                                                    </div>
                                                </div>-->
                        <!--                        <div class="form-group clearfix userProfile">
                        
                                                </div>-->
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Coupon Title <span class="error"> *</span></label>
                            <div class="col-sm-7">
                                <input name="coupon_title" type="text" class="textfield form-control" id="coupon_title" value="<?php echo set_value('coupon_title'); ?>" size="40">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Coupon Code <span class="error"> *</span></label>
                            <div class="col-sm-7">
                                <input name="coupon_code" type="text" class="textfield form-control" id="coupon_code" value="<?php echo set_value('coupon_code'); ?>" size="40"/>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Redeem Type <span class="error"> *</span></label>
                            <div class="col-sm-7">
                                <?php
                                $redeem_type = array('first' => 'Current Purchase');
                                echo form_dropdown('redeem_type', $redeem_type, set_value('redeem_type'), ' id ="redeem_type" class="textfield width_auto form-control"');
                                ?>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Coupon On <span class="error"> *</span></label>
                            <div class="col-sm-7">
                                <?php
                                // $coupon_on = array('' => 'select', 'product' => 'Product', 'category' => 'Category', 'basket' => 'Basket');
                                $coupon_on = array('basket' => 'Basket');
                                echo form_dropdown('coupon_on', $coupon_on, set_value('coupon_on'), ' id ="coupon_on" class="textfield width_auto form-control"');
                                ?>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-7">
                                <div id="coupon_add_on"></div>
                            </div>
                        </div>
                        <div class="form-group clearfix coupon_type" style="display: block;">
                            <label class="col-sm-2 control-label">Coupon Type <span class="error">*</span></label>
                            <div class="col-sm-7">
                                <?php
                                $coupon_type = array('percentage' => 'Percentage');
                                echo form_dropdown('coupon_type', $coupon_type, set_value('coupon_type'), ' id ="offer_type" class="textfield width_auto form-control"');
                                ?>
                            </div>
                        </div>

                        <div class="form-group clearfix coupon_type_value" style="display: block;">
                            <label class="col-sm-2 control-label">Coupon Type Value <span class="error">*</span></label>
                            <div class="col-sm-7">
                                <input name="coupon_type_value" type="text" class="textfield form-control" id="" value="<?php echo set_value('coupon_type_value'); ?>" size="40" />
                            </div>
                        </div>
                        <!--
                        <div class="form-group clearfix min_order_value" style="display: none;">
                            <label class="col-sm-2 control-label">Minimum Basket Value</label>
                            <div class="col-sm-7">
                                <input name="min_basket_value" type="text" class="textfield form-control" id="min_basket_value" value="<?php echo set_value('min_basket_value'); ?>" size="40" />
                            </div>
                        </div>
                        -->
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Coupon Usage Term <span class="error">*</span></label>
                            <div class="col-sm-7">
                                <?php
                                $uses_term = array('' => 'Select Term', 'onetime' => 'One time only', 'day' => 'Day', 'week' => 'Week', 'month' => 'Month');
                                echo form_dropdown('uses_term', $uses_term, set_value('uses_term'), ' id ="uses_term" class="textfield width_auto form-control"');
                                ?>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Coupon Usage Limit</label>
                            <div class="col-sm-7">
                                <input name="uses_limit" type="number" class="textfield form-control" min="0" id="" value="<?php echo set_value('uses_limit'); ?>"/>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Active Date <span class="error"> *</span></label>
                            <div class="col-sm-7">
                                <input name="active_date" type="text" class="textfield cidate active_from form-control" id="active_from" value="<?php echo set_value('active_from'); ?>" size="40" readonly/>
                            </div>
                            <label class="col-sm-2 control-label">Expire Date <span class="error"> *</span></label>
                            <div class="col-sm-7">
                                <input name="expire_date" type="text" class="datepicker expire_date form-control" id="expire_date" value="<?php //echo set_value('active_to');          ?>" size="40" readonly/>
                            </div>
                        </div>

                        <div class="form-group clearfix">
                            <!-- <label class="col-sm-2 control-label"></label> -->
                            <div class="col-sm-12 " align="center">
                                Fields marked with <span class="error">*</span> are required.<br />
                                <input name="image_v" type="hidden" id="image_v" value="1">
                                <input type="submit" name="button" class="btn btn-primary" id="upload_btn" value="Submit" align="center">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var base_url = '<?= base_url(); ?>';
    var CATEGORY = JSON.parse('<?php echo addslashes(json_encode($category_options)); ?>');
    var USER_ID = '<?php echo isset($coupon['user_id']) ? $coupon['user_id'] : '' ?>';
    var cnt = 1;
    $(".active_from").datepicker({dateFormat: 'dd-mm-yy'});
    $(".expire_date").datepicker({dateFormat: 'dd-mm-yy'});
<?php $this->load->view('headers/coupon'); ?>
</script>   