<input type="hidden" name="address_id" value="<?php echo $addressdata['user_address_id']; ?>" />
<div class="example-box-wrapper">
    <div class="form-group clearfix">
        <label class="col-sm-3 control-label">Address</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="<?php echo $addressdata['uadd_address_01']; ?>">
            <span class="custerror"></span>
        </div>
    </div>
    <div class="form-group clearfix">
        <label class="col-sm-3 control-label">Address 2</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="address2" name="address2" placeholder="Address 2" value="<?php echo $addressdata['uadd_address_02']; ?>">
            <span class="custerror"></span>
        </div>
    </div>

    <div class="form-group clearfix">
        <label class="col-sm-3 control-label">City</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="city" name="city" placeholder="City" value="<?php echo $addressdata['uadd_city']; ?>">
            <span class="custerror"></span>
        </div>
    </div>

    <div class="form-group clearfix">
        <label class="col-sm-3 control-label">County</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="county" name="county" placeholder="County" value="<?php echo $addressdata['uadd_county']; ?>">
            <span class="custerror"></span>
        </div>
    </div>

    <div class="form-group clearfix">
        <label class="col-sm-3 control-label">Country</label>
        <div class="col-sm-6">
            <?php
            $countries = getCountries();
            $countries = array_column($countries, 'nicename');
            $countries = array_combine($countries, $countries);
            echo form_dropdown('country', $countries, $addressdata['uadd_country'], ' class="form-control" ');
            ?>
            <span class="custerror"></span>
        </div>
    </div>

    <div class="form-group clearfix">
        <label class="col-sm-3 control-label">Post code</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="postcode" name="postcode" placeholder="Postcode" value="<?php echo $addressdata['uadd_post_code']; ?>">
            <span class="custerror"></span>
        </div>
    </div>

    <div class="form-group clearfix">
        <label class="col-sm-3 control-label">Phone</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" value="<?php echo $addressdata['uadd_phone']; ?>">
            <span class="custerror"></span>
        </div>
    </div>
</div>