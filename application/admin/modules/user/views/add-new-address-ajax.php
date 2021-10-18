<div class="example-box-wrapper">
    <div class="form-group clearfix">
        <label class="col-sm-3 control-label">Address</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="address" name="address" placeholder="Address">
            <span class="custerror"></span>
        </div>
    </div>
    <div class="form-group clearfix">
        <label class="col-sm-3 control-label">Address 2</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="address2" name="address2" placeholder="Address 2">
            <span class="custerror"></span>
        </div>
    </div>

    <div class="form-group clearfix">
        <label class="col-sm-3 control-label">City</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="city" name="city" placeholder="City">
            <span class="custerror"></span>
        </div>
    </div>

    <div class="form-group clearfix">
        <label class="col-sm-3 control-label">County</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="county" name="county" placeholder="County">
            <span class="custerror"></span>
        </div>
    </div>

    <div class="form-group clearfix">
        <label class="col-sm-3 control-label">Country</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="country" name="country" placeholder="country" value="United kingdom">
            <?php
//            $countries = getCountries();
//            $countries = array_column($countries, 'nicename');
//            $countries = array_combine($countries, $countries);
//            echo form_dropdown('country', $countries, '', ' class="form-control" ');
            ?>
            <span class="custerror"></span>
        </div>
    </div>

    <div class="form-group clearfix">
        <label class="col-sm-3 control-label">Post code</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="postcode" name="postcode" placeholder="Postcode">
            <span class="custerror"></span>
        </div>
    </div>

    <div class="form-group clearfix">
        <label class="col-sm-3 control-label">Phone</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" >
            <span class="custerror"></span>
        </div>
    </div>
</div>