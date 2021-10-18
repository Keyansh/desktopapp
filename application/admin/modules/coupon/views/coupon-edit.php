<h3 class="title-hero clearfix">
    Edit Coupon
    <a href="coupon/index" class="pull-right btn btn-primary">Manage Coupons</a>
</h3>
<div class="panel">
    <div class="panel-body">
        <div class="example-box-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <?php $this->load->view('inc-messages'); ?>
                    <form action="coupon/edit/<?= $coupon['id'] ?>" method="post" enctype="multipart/form-data" name="addcatform" id="addcatform">
                        <input type="hidden" id="profile" name="profile" value="0">
<!--                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Applicable on <span class="error"> *</span></label>
                            <div class="col-sm-7">
                                <?php //echo form_dropdown('profile', $profilegroups, set_value('profile', $coupon['profile_id']), 'id="profile" class="textfield width_auto form-control"'); ?>
                            </div>
                        </div>-->
<!--                        <div class="form-group clearfix userProfile">

                        </div>-->
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Coupon Title <span class="error"> *</span></label>
                            <div class="col-sm-7">
                                <input name="coupon_title" type="text" class="textfield form-control" id="coupon_title" value="<?php echo set_value('coupon_title', $coupon['coupon_title']); ?>" size="40">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Coupon Code <span class="error"> *</span></label>
                            <div class="col-sm-7">
                                <input name="coupon_code" type="text" class="textfield form-control" id="coupon_code" value="<?php echo set_value('coupon_code', $coupon['coupon_code']); ?>" size="40" />
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Redeem Type <span class="error"> *</span></label>
                            <div class="col-sm-7">
                                <?php
                                $redeem_type = array('first' => 'Current Purchase');
                                echo form_dropdown('redeem_type', $redeem_type, set_value('redeem_type', $coupon['redeem_type']), ' id ="redeem_type" class="textfield width_auto form-control"');
                                ?>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Coupon On <span class="error"> *</span></label>
                            <div class="col-sm-7">
                                <?php
                                // $coupon_on = array('' => 'select', 'product' => 'Product', 'category' => 'Category', 'basket' => 'Basket');
                                $coupon_on = array('' => 'select', 'basket' => 'Basket');
                                echo form_dropdown('coupon_on', $coupon_on, set_value('coupon_on', $coupon['coupon_on']), ' id ="coupon_on" class="textfield width_auto form-control"');
                                ?>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-7">
                                <div id="coupon_add_on"></div>
                            </div>
                        </div>
                        <div class="form-group clearfix coupon_type" style="display: none;">
                            <label class="col-sm-2 control-label">Coupon Type <span class="error">*</span></label>
                            <div class="col-sm-7">
                                <?php
                                $coupon_type = array('percentage' => 'Percentage');
                                echo form_dropdown('coupon_type', $coupon_type, set_value('coupon_type', $coupon['coupon_type']), ' id ="offer_type" class="textfield width_auto form-control"');
                                ?>
                            </div>
                        </div>

                        <div class="form-group clearfix coupon_type_value" style="display: none;">
                            <label class="col-sm-2 control-label">Coupon Type Value <span class="error">*</span></label>
                            <div class="col-sm-7">
                                <input name="coupon_type_value" type="text" class="textfield form-control" id="" value="<?php echo set_value('coupon_type_value', $coupon['coupon_type_value']); ?>" size="40" />
                            </div>
                        </div>
                        <!--
                        <div class="form-group clearfix min_order_value" style="display: none;">
                            <label class="col-sm-2 control-label">Minimum Basket Value</label>
                            <div class="col-sm-7">
                                <input name="min_basket_value" type="text" class="textfield form-control" id="min_basket_value" value="<?php echo set_value('min_basket_value', $coupon['min_basket_value']); ?>" size="40" />
                            </div>
                        </div>
                        -->
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Coupon Usage Term <span class="error">*</span></label>
                            <div class="col-sm-7">
                                <?php
                                $uses_term = array('onetime' => 'One time only', 'day' => 'Day', 'week' => 'Week', 'month' => 'Month');
                                echo form_dropdown('uses_term', $uses_term, set_value('uses_term', $coupon['uses_term']), ' id ="uses_term" class="textfield width_auto form-control"');
                                ?>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Coupon Usage Limit</label>
                            <div class="col-sm-7">
                                <input name="uses_limit" type="number" class="textfield form-control" min="0" id="" value="<?php echo set_value('uses_limit', $coupon['uses_limit']); ?>"/>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Active Date <span class="error"> *</span></label>
                            <div class="col-sm-7">
                                <input name="active_date" type="text" class="textfield cidate form-control" readonly="readonly" id="active_date" value="<?php echo set_value('active_date', date("d-m-Y", strtotime($coupon['active_date']))); ?>" size="40" />
                            </div>
                            <label class="col-sm-2 control-label">Expire Date <span class="error"> *</span></label>
                            <div class="col-sm-7">
                                <input name="expire_date" type="text" class="textfield cidate form-control" readonly="readonly" id="expire_date" value="<?php echo set_value('expire_date', date("d-m-Y", strtotime($coupon['expire_date']))); ?>" size="40" />
                            </div>
                        </div>

                        <div class="form-group clearfix">
                            <!-- <label class="col-sm-2 control-label"></label> -->
                            <div class=" col-sm-12" align="center">
                                Fields marked with <span class="error">*</span> are required.<br />
                                <input name="image_v" type="hidden" id="image_v" value="1">
                                <input name="coupon_id" type="hidden" value="<?= $coupon_id ?>"/>
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
    var COUPONON = '<?php echo $coupon['coupon_on'] ?>';
    var COUPONID = '<?php echo $coupon['cpid'] ?>';
    var PROFILE_ID = '<?php echo $coupon['profile_id'] ?>';
    var USER_ID = '<?php echo isset($coupon['user_id']) ? $coupon['user_id'] : '' ?>';
    var catid = '<?php echo $coupon['category'] ?>';
    var CATEGORY = JSON.parse('<?php echo addslashes(json_encode($category_options)); ?>');
    var base_url = '<?= base_url(); ?>';
    var cnt = 1;
    var term = '<?php echo $coupon['uses_term'] ?>';

    if (term === 'onetime') {
        $('.uses_limit').hide();
    } else {
        $('.uses_limit').show();
    }
    if (COUPONON === 'product') {
        $.post('coupon/getCouponProduct/' + COUPONID, function (data) {
            var ht = "";
            $.each(data, function (k, v) {

                ht += addproduct(v);
            });
            // alert(ht);
            $('#coupon_add_on').html(ht);
        }, 'json');
        $('.coupon_type, .coupon_type_value, .min_order_value').hide();
    }

    if (COUPONON === 'category') {
        var ht = "";
        ht += '<div class="category">';
        ht += category(0, catid);
        ht += '</div>';
        $('#coupon_add_on').html(ht);
        $('.coupon_type, .coupon_type_value, .min_order_value').show();
    }

    if (COUPONON == 'basket') {
        $('.coupon_type, .coupon_type_value, .min_order_value').show();
    }
    if (PROFILE_ID) {
        getUser(PROFILE_ID);
    }

<?php $this->load->view('headers/coupon'); ?>
</script>
