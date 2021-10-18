<link rel="stylesheet" href="<?= base_url() . '../css/min_spent.css' ?>">
<style>
    .heading4 {
        font-size: 18px;
        font-weight: 400;
        font-family: 'Lato', sans-serif;
        color: #111111;
        margin: 0px 0px 5px 0px;
    }

    .heading1 {
        font-size: 30px;
        line-height: 20px;
        font-family: 'Lato', sans-serif;
        text-transform: uppercase;
        color: #1b2834;
        font-weight: 900;
    }

    .content-quality {
        float: left;
        width: 193px;
    }

    .content-quality p {
        margin-left: 10px;
        font-family: 'Open Sans', sans-serif;
        font-size: 14px;
        font-weight: 600;
        line-height: 17px;
    }

    .content-quality p span {
        display: block;
    }

    .tabtop li a {
        font-family: 'Lato', sans-serif;
        font-weight: 700;
        color: #1b2834;
        border-radius: 0px;
        margin-right: 22.008px;
        border: 1px solid #ebebeb !important;
    }

    .tabtop li a:hover {
        color: #e31837 !important;
        text-decoration: none;
    }

    .tabtop .active a:hover {
        color: #fff !important;
    }

    .tabtop .active a {
        background-color: #e31837 !important;
        color: #FFF !important;
    }

    .thbada {
        padding: 10px 28px !important;
    }

    section p {
        font-family: 'Lato', sans-serif;
    }

    .tabsetting {
        display: none;
    }

    .services {
        background-color: #d4d4d4;
        min-height: 710px;
        padding: 65px 0 27px 0;
    }

    .services a:hover {
        color: #000;
    }

    .services h1 {
        margin-top: 0px !important;
    }

    .heading-container p {
        font-family: 'Lato', sans-serif;
        text-align: center;
        font-size: 16px !important;
        text-transform: uppercase;
    }

    /*my css*/
    .form-group {
        display: table;
        width: 100%;
    }

    input:focus,
    select:focus,
    textarea:focus,
    button:focus {
        outline: none;
    }

    a:focus,
    a {
        text-decoration: none;
    }

    .font {
        font-family: "Raleway", "Helvetica Neue", Helvetica, Arial, sans-serif;
    }

    /* .containernk {
        width: 25px;
        height: 16px;
        display: inline-block;
        position: relative;
        z-index: 1;
        top: 3px;
        background: url("../images/radio-hover.png") no-repeat;
    }

    .custom-radio:hover {
        background: url("../images/radio-hover.png") no-repeat;
    }

    .custom-radio.selected {
        background: url("../images/radio-selected.png") no-repeat;
    } */

    /* .custom-radio input[type="radio"] {
        margin: 1px;
        position: absolute;
        z-index: 2;
        cursor: pointer;
        outline: none;
        opacity: 0; */
    /* CSS hacks for older browsers */
    /* _noFocusLine: expression(this.hideFocus=true); */
    /* -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)"; */
    /* filter: alpha(opacity=0);
        -khtml-opacity: 0;
        -moz-opacity: 0;
    } */

    .user-field-border {
        border: none;
        border-bottom: 1px solid black;
        padding-left: 0px;
    }

    .next-button-class {
        border-radius: 15px;
        padding: 4px 30px 4px 30px;
    }

    .cat-listing {
        padding: 0px;
        border-bottom: 1px solid black;
        margin-top: 15px;
        font-family: "Raleway", "Helvetica Neue", Helvetica, Arial, sans-serif;
        font-weight: bolder;
    }

    .padd-0 {
        padding: 0px;
    }

    .scroll-div {
        height: 500px;
        overflow: scroll;
        overflow-x: hidden;
    }

    .heading-1 {
        font-size: 16px;
        padding: 0px 0px 25px 0px;
        color: inherit;
        font-weight: bolder;
    }

    .eight-col-row .inner {
        background: white;
        border-radius: 10px;
        min-height: 1px;
        box-shadow: 0px 15px 10px lightgrey;
        padding: 10px 15px;
        display: table;
        width: 100%;
        height: 100%;
    }

    .three-col-row .inner {
        background: white;
        border-radius: 10px;
        min-height: 1px;
        box-shadow: 0px 15px 10px lightgrey;
        margin-right: 10px;
        padding: 10px 15px;
        height: 100%;
    }

    .tab-inner-box {
        display: flex;
        flex-wrap: wrap;
    }

    .three-col-row {
        padding: 0;
    }

    /*code*/
    .container-t {
        border-bottom: 1px solid black;
        display: block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 12px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .container-t input {
        position: absolute;
        opacity: 0;
        height: 0;
        width: 0;
        pointer-events: none;
    }

    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 25px;
        width: 25px;
        background-color: #eee;
    }

    .container-t:hover input~.checkmark {
        background-color: #ccc;
    }

    .container-t input:checked~.checkmark {
        background-color: #495d80;
    }

    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    .container-t input:checked~.checkmark:after {
        display: block;
    }

    .container-t .checkmark:after {
        left: 9px;
        top: 5px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }

    /*child*/
    .child-container-t {
        display: block;
        position: relative;
        padding-left: 35px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .child-container-t input {
        position: absolute;
        opacity: 0;
        height: 0;
        width: 0;
    }

    .child-container-t:hover input~.checkmark {
        background-color: #ccc;
    }

    .child-container-t input:checked~.checkmark {
        background-color: #495d80;
    }

    .child-container-t input:checked~.checkmark:after {
        display: block;
    }

    .child-container-t .checkmark:after {
        left: 9px;
        top: 5px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }

    .parent-cat-input {
        width: 30px !important;
        position: relative !important;
        height: 25px !important;
        opacity: inherit !important;
        cursor: text !important;
        float: right !important;
    }

    .check-all-list {
        padding: 0px;
    }

    .check-all-list li {
        display: inline-block;
    }

    /*code*/
    /*child*/
    .child-container-tt {
        /*border-bottom: 1px solid black;*/
        display: block;
        position: relative;
        padding-left: 35px;
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .child-container-tt input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    .child-container-tt:hover input~.checkmark {
        background-color: #ccc;
    }

    .child-container-tt input:checked~.checkmark {
        background-color: #495d80;
    }

    .child-container-tt input:checked~.checkmark:after {
        display: block;
    }

    .child-container-tt .checkmark:after {
        left: 9px;
        top: 5px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }

    .user-active {
        padding: 0px;
        list-style: none;
    }

    .user-active li {
        display: inline-block;
    }

    .parent-cat-input-percentage {
        float: right;
    }

    .label-align {
        text-align: -webkit-auto !important;
    }

    .percentage {
        border: none;
        background: transparent !important;
        cursor: unset !important;
        font-size: 20px;
    }

    @media(min-width:1500px) {
        .form-group {
            width: 50%;
            float: left;
        }

        .form-horizontal .control-label {
            text-align: left;
        }
    }
</style>


<style>
    /* The container */
    .containernk {
        display: inline-block;
        position: relative;
        margin: 0 12px 12px 0;
        cursor: pointer;
        font-size: 15px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        background: #d9d7fd;
        padding: 0 10px;
    }


    .containernk input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    .containernk.active {
        color: white;
    }

    .containernk.r1.active {
        background-color: #22b14c;
    }

    .containernk.r2.active {
        background-color: #0b32ea;
    }

    .containernk.r3.active {
        background-color: #ed1c24;
    }
</style>


<!-- <div id="page-title">
    <h2>Edit Customer</h2>
    <p style="font-weight:bolder;">
        <a href="customer">
        Manage customers 
        </a>
    </p>
</div> -->
<h3 class="title-hero clearfix">
    Edit Customer
    <a href="customer" class="pull-right btn btn-primary">Manage customers</a>
</h3>
<div id="tabs">
    <div class="panel">
        <div class="panel-body">
            <ul class="nav nav-tabs tabtop  tabsetting">
                <li id="first" class="active"><a href="#tab_default_1" data-toggle="tab"></a></li>
                <li id="second"><a class="second" href="#tab_default_2" data-toggle="tab"></a></li>
                <li id="third"><a href="#tab_default_3" data-toggle="tab"></a></li>
                <li id="fourth"><a href="#tab_default_4" data-toggle="tab"></a></li>
            </ul>
            <div class="example-box-wrapper">
                <form action="" class="form-horizontal bordered-row" method="post" enctype="multipart/form-data" name="addcatform" id="customer-form">
                    <div class="tab-pane active fade in" id="tab_default_1">
                        <div class="heading-1">PERSONAL DETAILS</div>
                        <div class="col-xs-12" style="padding: 0;margin-left: -15px;">
                            <div class="col-xs-6" style="padding: 0;">
                                <label class="col-sm-2 control-label label-align">Account Status</label>
                                <div class="col-sm-6">
                                    <label class="containernk r1 <?= ($user['user_is_active'] == 1) ? 'active' : '' ?>">
                                        <input type="radio" name="user_is_active" value="1" <?= ($user['user_is_active'] == 1) ? 'checked' : '' ?>>
                                        <?= ($user['user_is_active'] == 1) ? 'Activated' : 'Activate' ?>
                                    </label>
                                    <label class="containernk r2 <?= ($user['user_is_active'] == 0) ? 'active' : '' ?>">
                                        <input type="radio" name="user_is_active" value="0" <?= ($user['user_is_active'] == 0) ? 'checked' : '' ?>>
                                        <?= ($user['user_is_active'] == 0) ? 'Deactivated' : 'Deactive' ?>
                                    </label>
                                    <label class="containernk r3 <?= ($user['user_is_active'] == 2) ? 'active' : '' ?>">
                                        <input type="radio" name="user_is_active" value="2" <?= ($user['user_is_active'] == 2) ? 'checked' : '' ?>>
                                        <?= ($user['user_is_active'] == 2) ? 'Declined' : 'Decline' ?>
                                    </label>
                                    <!-- <input type="radio" name="user_is_active" value="1" <? //= ($user['user_is_active'] == 1) ? 'checked' : '' 
                                                                                                ?>>Yes
                                <input type="radio" name="user_is_active" value="0" <? //= ($user['user_is_active'] == 0) ? 'checked' : '' 
                                                                                    ?>>No -->
                                </div>
                                <input type="hidden" name="user_flag" value="<?= $user['user_is_active'] ?>">
                            </div>
                        </div>
                        <!-- <div class="form-group">
                            <label class="col-sm-3 control-label label-align">Assign Group</label>
                            <div class="col-sm-6">
                                <?php echo form_dropdown('customer_group', $customer_groups, set_value('customer_group', $user['customer_group']), ' class="form-control assign-group"'); ?>
                            </div>
                        </div> -->
                        <!-- <div class="form-group">
                            <label class="col-sm-3 control-label label-align">Choose Profile</label>
                            <div class="col-sm-6">
                                <?php echo form_dropdown('role_id', $profilegroups, set_value('role_id', $user['role_id']), ' class="form-control"'); ?>
                            </div>
                        </div> -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label label-align">First Name</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control first-form" id="firstname" name="firstname" placeholder="First name" value="<?php echo set_value('firstname', $user['first_name']); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label label-align">Last Name</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control first-form" id="lastname" name="lastname" placeholder="Last name" value="<?php echo set_value('lastname', $user['last_name']); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label label-align">Email ID</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="first-form-email" name="email" placeholder="Email" value="<?php echo set_value('email', $user['email']); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label label-align">Phone</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control phone-custom" name="phone" placeholder="Phone Number" value="<?php echo set_value('phone', $user['phone']); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label label-align">Loaction</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control phone-custom" name="location" placeholder="Phone Number" value="<?php echo set_value('location', $user['location']); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label label-align">Company Name</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control phone-custom" name="company_name" placeholder="Company Name" value="<?php echo set_value('company_name', $user['company_name']); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label label-align">Profile Type</label>
                            <div class="col-sm-6">
                                <select name="profile_type" id="" class="form-control select-field" required>
                                    <option value="">Please select</option>
                                    <option <?= $user['profile_type'] == 1 ? "selected" : " " ?> value="1">Architects/ Designers</option>
                                    <option <?= $user['profile_type'] == 2 ? "selected" : " " ?> value="2">Contractor</option>
                                    <option <?= $user['profile_type'] == 3 ? "selected" : " " ?> value="3">Door Manufacturer</option>
                                    <option <?= $user['profile_type'] == 4 ? "selected" : " " ?> value="4">Distributor/Architectural Ironmonger</option>
                                    <option <?= $user['profile_type'] == 5 ? "selected" : " " ?> value="5">Joinery/ Interior fitout</option>
                                    <option <?= $user['profile_type'] == 6 ? "selected" : " " ?> value="6">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class=" col-xs-12 text-center">
                            <input id="form-submit" class="btn btn-primary" value="Submit" type="submit" readonly>
                        </div>
                        <!-- <div class="form-group">
                            <label class="col-sm-3 control-label label-align">City</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control " name="customer_city" value="<?php echo set_value('customer_city', $user['city']); ?>">
                            </div>
                        </div> -->
                        <!-- <div class="form-group">
                            <label class="col-sm-3 control-label label-align">Postcode</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control " name="customer_postcode" value="<?php echo set_value('customer_postcode', $user['postcode']); ?>">
                            </div>
                        </div> -->
                        <!--code-->
                        <!--                        <div style="text-transform:capitalize;padding:0px;" class="col-xs-12">
                                                    Select your minimum spent*
                                                </div>
                                                <div style="padding:0px;margin-top:20px" class="col-xs-12">
                                                    <label class="container-t-r prevent-checked-r">
                                                        <span style="line-height:17px;font-weight:bolder" class="no-cursor">
                                                            <div>Tier 1</div>
                                                            <div>£100 - £500</div>
                                                        </span>
                                                        <input value="100-500" class="BoxClass-r class-one-r" name="min_spent" type="checkbox" <?= ($user['min_spent'] == '100-500') ? 'checked' : '' ?>>
                                                        <span onclick="checked_toggle_r('.class-one-r')" class="checkmark-r"></span>
                                                    </label>
                                                    <label class="container-t-r prevent-checked-r">
                                                        <span style="line-height:17px;font-weight:bolder" class="no-cursor" >
                                                            <div>Tier 2</div>
                                                            <div>£500 - £1000</div>
                                                        </span>
                                                        <input value="500-1000" class="BoxClass-r class-two-r" name="min_spent" type="checkbox" <?= ($user['min_spent'] == '500-1000') ? 'checked' : '' ?>>
                                                        <span onclick="checked_toggle_r('.class-two-r')" class="checkmark-r"></span>
                                                    </label>
                                                    <label class="container-t-r prevent-checked-r">
                                                        <span style="line-height:17px;font-weight:bolder" class="no-cursor">
                                                            <div>Tier 3</div>
                                                            <div>£1000 - £2000</div>
                                                        </span>
                                                        <input value="1000-2000" class="BoxClass-r class-three-r" name="min_spent" type="checkbox" <?= ($user['min_spent'] == '1000-2000') ? 'checked' : '' ?> >
                                                        <span onclick="checked_toggle_r('.class-three-r')" class="checkmark-r"></span>
                                                    </label>
                                                    <label class="container-t-r prevent-checked-r">
                                                        <span style="line-height:17px;font-weight:bolder" class="no-cursor">
                                                            <div>Tier 4</div>
                                                            <div>£2000 - £5000</div>
                                                        </span>
                                                        <input value="2000-5000" class="BoxClass-r class-four-r" name="min_spent" type="checkbox" <?= ($user['min_spent'] == '2000-5000') ? 'checked' : '' ?> >
                                                        <span onclick="checked_toggle_r('.class-four-r')" class="checkmark-r"></span>
                                                    </label>
                                                    <label class="container-t-r prevent-checked-r">
                                                        <span style="line-height:17px;font-weight:bolder" class="no-cursor">
                                                            <div>Tier 5</div>
                                                            <div>£5000 + Above</div>
                                                        </span>
                                                        <input value="5000-above" class="BoxClass-r class-five-r" name="min_spent" type="checkbox" <?= ($user['min_spent'] == '5000-above') ? 'checked' : '' ?>>
                                                        <span onclick="checked_toggle_r('.class-five-r')" class="checkmark-r"></span>
                                                    </label>
                                                </div>-->
                        <!--code-->
                        <!-- <div style="float:right;" class="tab-pane active" id="tab1">
                            <a onclick="second_tab()" data-toggle="tab" class="btn btn-primary btnNext next-button-class">Next<i style="padding-left:10px;" class="fa fa-arrow-right" aria-hidden="true"></i></a>
                        </div> -->
                    </div>
                    <div class="tab-pane fade" id="tab_default_2">
                        <div class="heading-1">Add Company Details</div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label label-align">Company Name</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control second-form" id="companyname" name="companyname" placeholder="Company name" value="<?php echo set_value('companyname', $user['company_name']); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label label-align">Address</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control second-form" name="company_address" placeholder="Address" value="<?php echo set_value('company_address', $user['company_address']); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label label-align">Phone</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control phone-custom-two" name="company_phone" placeholder="Phone" value="<?php echo set_value('company_phone', $user['company_phone']); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label label-align">Postcode</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control second-form" name="company_postcode" placeholder="Postcode" value="<?php echo set_value('company_postcode', $user['company_postcode']); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label label-align">Email</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="company_email" name="company_email" placeholder="Email" value="<?php echo set_value('company_email', $user['company_email']); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label label-align">City</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="company_city" placeholder="City" value="<?php echo set_value('company_city', $user['company_city']); ?>">
                            </div>
                        </div>
                        <!-- <div class="form-group">
                            <label class="col-sm-3 control-label label-align">VAT number</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="company_vat" placeholder="VAT number" value="<?php echo set_value('company_vat', $user['company_vat']); ?>">
                            </div>
                        </div> -->
                        <div class="col-xs-12">
                            <div style="width:auto;display: table;float: left;">
                                <img onclick="prev_tab_1()" src="<?= base_url() . '../images/back_button.png' ?>">
                            </div>

                            <div style="float:right;" class="tab-pane active" id="tab1">
                                <a onclick="third_tab()" data-toggle="tab" class="btn btn-primary btnNext next-button-class">Next<i style="padding-left:10px;" class="fa fa-arrow-right" aria-hidden="true"></i></a>
                            </div>
                        </div>


                    </div>
                    <div class="tab-pane fade" id="tab_default_3">
                        <div class="heading-1">CREDIT AND PRICE LIST</div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label label-align">Types of Customer</label>
                            <div class="col-sm-6">
                                <input type="radio" name="cash_credit" value="Paygo" <?= ($user['cash_credit'] == 'Paygo' || !$user['cash_credit']) ? 'checked' : '' ?>>Pay as you go</br>
                                <input type="radio" name="cash_credit" value="credit" <?= ($user['cash_credit'] == 'credit') ? 'checked' : '' ?>>Credit
                            </div>
                        </div>
                        <!--                        <div class="form-group">
                                                    <label class="col-sm-3 control-label label-align">Catalouge</label>
                                                    <div class="col-sm-6">
                                                        <input class="category-trigger" type="radio" name="catalauge" value="all" checked>All</br> 
                                                        <input class="category-trigger" type="radio" name="catalauge" value="selective">Selective
                                                    </div>
                                                </div>-->
                        <div class="col-xs-12">
                            <div style="width:auto;display: table;float: left;">
                                <img onclick="prev_tab_2()" src="<?= base_url() . '../images/back_button.png' ?>">
                            </div>

                            <div style="float:right;" class="tab-pane active">
                                <a onclick="fourth_tab()" data-toggle="tab" class="btn btn-primary btnNext next-button-class">Next<i style="padding-left:10px;" class="fa fa-arrow-right" aria-hidden="true"></i></a>
                            </div>
                        </div>


                    </div>
                    <div class="tab-pane fade" id="tab_default_4">
                        <div class="heading-1">SELECT CATEGORIES</div>
                        <div class="col-sm-9">
                            <div class="inner">
                                <div class="scroll-div">
                                    <ul class="check-all-list">
                                        <li><input onclick="all_check()" name="ckbCheckAll" type="checkbox" id="ckbCheckAll" />Check all Categories</li>
                                    </ul>
                                    <?php
                                    $categories = categories();
                                    foreach ($categories as $cat) {
                                        $cat_parent_id = $cat['id'];
                                        $cat_child = cat_child($cat_parent_id);
                                        $checked_cat_ids = if_checked_cat_id($cat_parent_id, $user['user_id']);
                                    ?>
                                        <label class="container-t prevent-checked">
                                            <?= $cat['name'] ?>
                                            <input class="checkbox-class checkBoxClass toggle-class-<?= $cat_parent_id ?>" name="checkbox[<?= $cat_parent_id ?>][checked]" value="<?= $cat_parent_id ?>" type="checkbox" <?= ($checked_cat_ids['cat_id'] == $cat_parent_id) ? 'checked' : '' ?>>
                                            <span onclick="checked_toggle('<?= '.toggle-class-' . $cat_parent_id ?>', '<?= $cat_parent_id ?>')" class="checkmark"></span>
                                            <?php if ($cat_child) { ?>
                                                <a style="color:inherit;" href="javascript:void(0)">
                                                    <span class="span-plus" onclick="Append_item('<?= '#cat-parent-' . $cat_parent_id ?>')">+</span>
                                                </a>
                                            <?php } ?>
                                            <!--                                            <span class="parent-cat-input-percentage">%</span>
    <span><input onkeypress="return isNumberKey(event)" class="parent-cat-input input-amount-validation-<? //= $cat_parent_id 
                                                                                                        ?>" name="checkbox[<? //= $cat_parent_id 
                                                                                                                            ?>][amount]" type="text" value="<? //= $checked_cat_ids['category_discount'] 
                                                                                                                                                            ?>" ></span>-->
                                        </label>
                                        <?php
                                        if ($cat_child) {
                                            echo "<tree class='unique-hide' id='cat-parent-$cat_parent_id'>";
                                            foreach ($cat_child as $child) {
                                                $next_child_id = $child['id'];
                                                $cat_child_parent_child = cat_child($next_child_id);
                                                $checked_cat_ids = if_checked_cat_id($next_child_id, $user['user_id']);
                                        ?>
                                                <label style="margin-left:32px;" class="child-container-t prevent-checked">
                                                    <?= $child['name'] ?>
                                                    <input class="checkBoxClass toggle-class-<?= $next_child_id ?> checked-only-parent-<?= $cat_parent_id ?>" name="checkbox[<?= $next_child_id ?>][checked]" value="<?= $next_child_id ?>" <?php ?> type="checkbox" <?= ($checked_cat_ids['cat_id'] == $next_child_id) ? 'checked' : '' ?>>
                                                    <span onclick="checked_toggle('<?= '.toggle-class-' . $next_child_id ?>', '<?= $next_child_id ?>')" class="checkmark"></span>
                                                    <?php if ($cat_child_parent_child) { ?>
                                                        <a style="color:inherit;" href="javascript:void(0)">
                                                            <span onclick="Append_item('<?= '#cat-parent-' . $next_child_id ?>', '<?= $next_child_id ?>')">+</span>
                                                        </a>
                                                    <?php } ?>
                                                </label>
                                                <?php
                                                if ($cat_child_parent_child) {
                                                    echo "<tree class='unique-hide' id='cat-parent-$next_child_id'>";
                                                    foreach ($cat_child_parent_child as $cat_child_parent) {
                                                        $checked_cat_ids = if_checked_cat_id($cat_child_parent['id'], $user['user_id']);
                                                ?>
                                                        <label style="margin-left:65px;" class="child-container-tt prevent-checked">
                                                            <?= $cat_child_parent['name'] ?>
                                                            <input class="checkBoxClass toggle-class-<?= $cat_child_parent['id'] ?> checked-only-parent-<?= $next_child_id ?>" name="checkbox[<?= $cat_child_parent['id'] ?>][checked]" value="<?= $cat_child_parent['id'] ?>" type="checkbox" <?= ($checked_cat_ids['cat_id'] == $cat_child_parent['id']) ? 'checked' : '' ?>>
                                                            <span onclick="checked_toggle('<?= '.toggle-class-' . $cat_child_parent['id'] ?>', '<?= $cat_child_parent['id'] ?>')" class="checkmark"></span>
                                                        </label>
                                    <?php
                                                    }
                                                    echo '</tree>';
                                                }
                                            }
                                            echo '</tree>';
                                        }
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="col-xs-12">
                                <div style="width:auto;display: table;float: left;">
                                    <img onclick="prev_tab_3()" src="<?= base_url() . '../images/back_button.png' ?>">
                                </div>

                                <div class=" text-center">
                                    <input id="form-submit" class="btn btn-primary" value="Submit" readonly>
                                </div>
                            </div>

                            <div class="form-group">

                            </div>
                        </div>

                        <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                        <input type="hidden" name="user_randon_string" value="<?= $user['user_randon_string'] ?>">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $(document).on("submit", "#customer-form", function(e) {
            e.preventDefault();
            var submit_status = true;
            if (submit_status) {
                $.post(DWS_BASE_URL + 'customer/update', {
                        update_data: $('#customer-form').serialize()
                    },
                    function(returnedData) {
                        var response = JSON.parse(returnedData);
                        if (response.status) {
                            window.location.href = DWS_BASE_URL + "customer";
                        } else {
                            console.log('might be some validation error');
                        }
                    });
            }
        });

        // customRadio("type_of_customer");
        // customRadio("cash_credit");
        // customRadio("user_is_active");

        $('.prevent-checked').click(function(event) {
            var $checkbox = $(this);
            // Ensures this code runs AFTER the browser handles click however it wants.
            setTimeout(function() {
                $checkbox.removeAttr('checked');
            }, 0);
            event.preventDefault();
            event.stopPropagation();
        });
        //        code
        $(".phone-custom").on("change keyup", function() {
            var phone = $('.phone-custom').val();
            var number = phone.replace(/ /g, '');
            if ($.isNumeric(number)) {
                $('.phone-custom').css('border-color', '');
            } else {
                $('.phone-custom').css('border-color', 'red');
            }
        });
        $(".phone-custom-two").on("change keyup", function() {
            var phone = $('.phone-custom-two').val();
            var number = phone.replace(/ /g, '');
            //            var pattern2 = /^(?=.*[0-9])[ ()0-9]+$/;
            if ($.isNumeric(number)) {
                $('.phone-custom-two').css('border-color', '');
            } else {
                $('.phone-custom-two').css('border-color', 'red');
            }
        });
        //        code
    });


    // function customRadio(radioName) {
    //     var radioButton = $('input[name="' + radioName + '"]');
    //     $(radioButton).each(function() {
    //         $(this).wrap("<span class='custom-radio'></span>");
    //         if ($(this).is(':checked')) {
    //             $(this).parent().addClass("selected");
    //         }
    //     });
    //     $(radioButton).click(function() {
    //         if ($(this).is(':checked')) {
    //             $(this).parent().addClass("selected");
    //         }
    //         $(radioButton).not(this).each(function() {
    //             $(this).parent().removeClass("selected");
    //         });
    //     });
    // }

    $(document).on('click', '.containernk', function() {
        $('.containernk').removeClass('active');
        $(this).addClass('active');
    })
    $(".unique-hide").hide();

    function Append_item(elm_id, id) {
        $(elm_id).toggle();
        if ($('.toggle-class-' + id).is(':checked')) {
            var all_discount_val = $('.all-discount').val();
            var value_exists = $('.input-amount-validation-' + id).val();
            console.log(value_exists);
            if (!value_exists) {
                $('.input-amount-validation-' + id).val(all_discount_val);
                $('.value-only-parent-' + id).val(all_discount_val);
                $('.checked-only-parent-' + id).prop('checked', true);
            }
        } else {
            $('.input-amount-validation-' + id).val('');
            $('.value-only-parent-' + id).val('');
            $('.checked-only-parent-' + id).prop('checked', false);

        }
        console.log(elm_id);
    }
    // $('.span-plus').click(function(){
    $(".span-plus").on("click", function() {

        var text_v = $(this).text();
        if ($(this).parents('.container-t.prevent-checked').next('.unique-hide').css("display") == "none") {
            $(this).text("+");

        } else {
            $(this).text("-");

        }
    })

    function all_check() {
        var ckbCheckAll = $("input[name='ckbCheckAll']:checked").val();
        if (ckbCheckAll) {
            $(".checkBoxClass").prop('checked', true);
        } else {
            $(".checkBoxClass").prop('checked', false);
        }
    }

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 &&
            (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

    function checked_toggle(elm, parent_id) {
        console.log(elm);
        console.log(parent_id);
        var checkBoxes = $(elm);
        checkBoxes.prop("checked", !checkBoxes.prop("checked"));
        if ($(elm).is(':checked')) {
            var all_discount_val = $('.all-discount').val();
            $('.input-amount-validation-' + parent_id).val(all_discount_val);
            $('.value-only-parent-' + parent_id).val(all_discount_val);
            $('.checked-only-parent-' + parent_id).prop('checked', true);
        } else {
            $('.input-amount-validation-' + parent_id).val('');
            $('.value-only-parent-' + parent_id).val('');
            $('.checked-only-parent-' + parent_id).prop('checked', false);
        }
    }

    function second_tab() {
        var status2 = true;
        var current_email = '<?= $user['email'] ?>';
        $(".first-form").each(function() {
            var first_form = $(this).val();
            if (!first_form) {
                status2 = false;
                $(this).css('border-color', 'red');
            } else {
                $(this).css('border-color', '');
            }
        });
        var phone = $('.phone-custom').val();
        var number = phone.replace(/ /g, '');
        //        var pattern2 = /^(?=.*[0-9])[ ()0-9]+$/;
        //        if ($.isNumeric(number)) {
        //            $('.phone-custom').css('border-color', '');
        //        } else {
        //            $('.phone-custom').css('border-color', 'red');
        //            status2 = false;
        //        }
        //        console.log(status2);
        var email_val = $('#first-form-email').val();
        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (email_val != current_email) {
            if (email_val.match(filter)) {
                $.ajax({
                    type: 'POST',
                    url: DWS_BASE_URL + 'customer/get_user_emails',
                    async: false,
                    data: {
                        email: email_val
                    },
                    success: function(response) {
                        var obj = JSON.parse(response);
                        if (obj.result) {
                            alert('Email was already in use');
                            $('#first-form-email').css('border-color', 'red');
                            status2 = false;
                        } else {
                            $('#first-form-email').css('border-color', '');
                        }
                    }
                });
            } else {
                status2 = false;
                $('#first-form-email').css('border-color', 'red');
            }
        }
        console.log(status2);
        var select_group = $('.assign-group :selected').val();
        if (select_group == 0) {
            status2 = false;
            $('.assign-group').css('border-color', 'red');
        } else {
            $('.assign-group').css('border-color', '#dfe8f1');
        }
        if (status2) {
            $('.tabsetting a[href="#tab_default_2"]').tab('show');
        }
    }

    function third_tab() {
        var status = true;
        $(".phone-custom-two").on("change keyup", function() {
            var phone = $('.phone-custom-two').val();
            var number = phone.replace(/ /g, '');
            if ($.isNumeric(number)) {
                $('.phone-custom-two').css('border-color', '');
            } else {
                $('.phone-custom-two').css('border-color', 'red');
                status = false;
            }
        });

        $("#company_email").on("change keyup", function() {
            var company_email = $('#company_email').val();
            var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if (company_email.match(filter)) {
                $('#company_email').css('border-color', '#dfe8f1');
            } else {
                status = false;
                $('#company_email').css('border-color', 'red');
            }
        });

        console.log(status);
        if (status) {
            $('.tabsetting a[href="#tab_default_3"]').tab('show');
        }
    }

    function fourth_tab() {

        $('.tabsetting a[href="#tab_default_4"]').tab('show');
    }

    function prev_tab_3() {
        $('.tabsetting a[href="#tab_default_3"]').tab('show');
    }

    function prev_tab_2() {
        $('.tabsetting a[href="#tab_default_2"]').tab('show');
    }

    function prev_tab_1() {
        $('.tabsetting a[href="#tab_default_1"]').tab('show');
    }
</script>
<script type="text/javascript" src="<?= base_url() . '../js/min_spent.js' ?>"></script>