<!--<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>-->
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<!--code-->
<link rel="stylesheet" href="css/country/intlInputPhone.min.css">
<link rel="stylesheet" href="<?= base_url() . '../css/min_spent.css' ?>">
<!--code-->
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

    .font {
        font-family: "Raleway", "Helvetica Neue", Helvetica, Arial, sans-serif;
    }

    .custom-radio {
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
    }

    .custom-radio input[type="radio"] {
        margin: 1px;
        position: absolute;
        z-index: 2;
        cursor: pointer;
        outline: none;
        opacity: 0;
        /* CSS hacks for older browsers */
        _noFocusLine: expression(this.hideFocus=true);
        -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
        filter: alpha(opacity=0);
        -khtml-opacity: 0;
        -moz-opacity: 0;
    }

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

    input:focus,
    select:focus,
    textarea:focus,
    button:focus {
        outline: none;
    }

    a:hover,
    a:focus,
    a {
        text-decoration: none;
        outline: none;
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
        cursor: pointer;
        height: 0;
        width: 0;
        pointer-events: none;
    }

    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 20px;
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
        /*border-bottom: 1px solid black;*/
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
        cursor: pointer;
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
        height: 20px !important;
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

    #customer-form .form-control {
        box-shadow: none;
        border-radius: 0;
        height: 44px;
    }

    .check-list-vertical li {
        margin: 10px 0 0px 0;
    }

    .percentage {
        border: none;
        background: transparent !important;
        cursor: unset !important;
        font-size: 20px;
    }

    .parent-cat-input-percentage {
        float: right;
    }

    @media(min-width:1500px) {
        .tabbable-panel.margin-tops4 {
            width: 70%;
        }
    }
</style>
<!--home-content-top starts from here-->
<section class="home-content-top">
    <div class="container-fluid">
        <!--our-quality-shadow-->
        <div class="clearfix"></div>
        <div class="tabbable-panel margin-tops4 ">
            <div class="tabbable-line">
                <ul class="nav nav-tabs tabtop  tabsetting">
                    <li id="first" class="active"><a href="#tab_default_1" data-toggle="tab"></a></li>
                    <li id="second"><a class="second" href="#tab_default_2" data-toggle="tab"></a></li>
                    <li id="third"><a href="#tab_default_3" data-toggle="tab"></a></li>
                    <li id="fourth"><a href="#tab_default_4" data-toggle="tab"></a></li>
                </ul>
                <div class="tab-content margin-tops">
                    <p style="font-weight:bolder;">
                        <a style="color:inherit" href="customer">
                            Manage customers
                        </a>
                    </p>
                    <form id="customer-form" action="" method="post">
                        <div class="tab-pane active fade in" id="tab_default_1">
                            <div class="tab-inner-box">
                                <div class="col-md-3 three-col-row">
                                    <div class="heading-1">CREATE CUSTOMER</div>
                                    <div class="inner">
                                        <div class="form-group">
                                            <label class="font">TYPES OF CUSTOMER</label>
                                            <div class="col-sm-12 padd-0">
                                                <ul class="list-unstyled check-list-vertical">
                                                    <li>
                                                        <input attr_val="Retail" class="" value="<?= RETAIL ?>" type="radio" name="type_of_customer" checked="checked">Retail<br>
                                                    </li>
                                                    <li>
                                                        <input attr_val="Wholesale" class="" value="<?= WHOLESALE ?>" type="radio" name="type_of_customer">Wholesale<br>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="error-customer"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8 eight-col-row">
                                    <div class="heading-1">PERSONAL DETAILS</div>
                                    <div class="inner">
                                        <!--                                        <div class="form-group">
                                                                                    <div class="col-sm-12">
                                                                                        <ul class="user-active">
                                                                                            <li><input value="1" type="radio" name="user_is_active" checked="checked">Active</li>
                                                                                            <li style="padding-left:30px;" ><input value="0" type="radio" name="user_is_active">Non active</li>
                                                                                        </ul>
                                                                                    </div>
                                                                                </div>-->
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <input class="name-value first-form form-control user-field-border text-capitalize" type="text" name="first_name" placeholder="First Name">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <input class="name-value first-form form-control user-field-border last-name-value text-capitalize" type="text" name="last_name" placeholder="Last Name">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <input class="address-value form-control user-field-border text-capitalize" type="text" name="customer_address" placeholder="Address">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <input class="form-control user-field-border text-capitalize" type="text" name="customer_city" placeholder="City">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <input class=" form-control user-field-border text-capitalize" type="text" name="customer_postcode" placeholder="Postcode">
                                            </div>
                                        </div>
                                        <!--phone plug in-->
                                        <div class="form-group personal-number">
                                            <div class="col-sm-12">
                                                <div class="input-phone"></div>
                                            </div>
                                        </div>
                                        <!--phone plug in-->
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <input id="first-form-email" class="form-control user-field-border" type="email" name="customer_email" placeholder="Email">
                                            </div>
                                        </div>
                                        <!--code r-->
                                        <!--                                        <div style="font-weight: 700;text-transform:capitalize;" class="col-xs-12">
                                                                                    Select your minimum spent*
                                                                                </div>
                                                                                <div style="padding-top:20px;" class="col-xs-12">
                                                                                    <label class="container-t-r prevent-checked-r">
                                                                                        <span class="no-cursor" >
                                                                                            <div>Tier 1</div>
                                                                                            <div>£100 - £500</div>
                                                                                        </span>
                                                                                        <input value="100-500" class="BoxClass-r class-one-r" name="min_spent" type="checkbox" checked>
                                                                                        <span onclick="checked_toggle_r('.class-one-r')" class="checkmark-r"></span>
                                                                                    </label>
                                                                                    <label class="container-t-r prevent-checked-r">
                                                                                        <span class="no-cursor" >
                                                                                            <div>Tier 2</div>
                                                                                            <div>£500 - £1000</div>
                                                                                        </span>
                                                                                        <input value="500-1000" class="BoxClass-r class-two-r" name="min_spent" type="checkbox">
                                                                                        <span onclick="checked_toggle_r('.class-two-r')" class="checkmark-r"></span>
                                                                                    </label>
                                                                                    <label class="container-t-r prevent-checked-r">
                                                                                        <span class="no-cursor">
                                                                                            <div>Tier 3</div>
                                                                                            <div>£1000 - £2000</div>
                                                                                        </span>
                                                                                        <input value="1000-2000" class="BoxClass-r class-three-r" name="min_spent" type="checkbox">
                                                                                        <span onclick="checked_toggle_r('.class-three-r')" class="checkmark-r"></span>
                                                                                    </label>
                                                                                    <label class="container-t-r prevent-checked-r">
                                                                                        <span class="no-cursor">
                                                                                            <div>Tier 4</div>
                                                                                            <div>£2000 - £5000</div>
                                                                                        </span>
                                                                                        <input value="2000-5000" class="BoxClass-r class-four-r" name="min_spent" type="checkbox">
                                                                                        <span onclick="checked_toggle_r('.class-four-r')" class="checkmark-r"></span>
                                                                                    </label>
                                                                                    <label class="container-t-r prevent-checked-r">
                                                                                        <span class="no-cursor">
                                                                                            <div>Tier 5</div>
                                                                                            <div>£5000 + Above</div>
                                                                                        </span>
                                                                                        <input value="5000-above" class="BoxClass-r class-five-r" name="min_spent" type="checkbox">
                                                                                        <span onclick="checked_toggle_r('.class-five-r')" class="checkmark-r"></span>
                                                                                    </label>
                                                                                </div>-->
                                        <!--code r-->
                                        <div style="float:right;" class="tab-pane active" id="tab1">
                                            <a onclick="second_tab()" data-toggle="tab" class="btn btn-primary btnNext next-button-class">Next<i style="padding-left:10px;" class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="tab_default_2">
                            <div class="tab-inner-box">
                                <div class="col-md-3 three-col-row">
                                    <div class="heading-1">CREATE CUSTOMER</div>
                                    <div class="inner">
                                        <label><i style="color: #495d80;" style="color: #495d80;" class="fa fa-user" aria-hidden="true"></i><span style="padding-left:5px;">
                                                <tag class="customer"></tag> customer
                                            </span></label><br>
                                        <label>
                                            <i style="color: #495d80;" class="fa fa-map-marker" aria-hidden="true"></i>
                                            <span style="padding-left:5px;">
                                                <tag class="name"></tag>
                                                <tag class="last_name"></tag>
                                            </span>
                                            <p class="address" style="padding-left:16px;font-weight:lighter;"></p>
                                            <p class="address-city" style="padding-left:16px;font-weight:lighter;"></p>
                                            <p class="address-postcode" style="padding-left:16px;font-weight:lighter;"></p>
                                            <p class="phone" style="margin-top:-5px;padding-left:16px;font-weight:lighter;"></p>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-8 eight-col-row">
                                    <div class="heading-1">Add Company Details</div>
                                    <div class="inner">
                                        <!--code-->
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <input onclick="change_address(this)" class="" type="checkbox"><span style="padding-left:10px;">Address same as customer</span>
                                            </div>
                                        </div>
                                        <!--code-->
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <input class="comp-name-value second-form form-control user-field-border text-capitalize" type="text" name="company_name" placeholder="Company Name">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <input class="comp-addr-value second-form form-control user-field-border text-capitalize" type="text" name="company_address" placeholder="Address">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <input class="second-form form-control user-field-border text-capitalize" type="text" name="company_city" placeholder="City">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <input class="second-form form-control user-field-border text-capitalize" type="text" name="company_postcode" placeholder="Postcode">
                                            </div>
                                        </div>
                                        <div class="form-group company-number">
                                            <div class="col-sm-12">
                                                <div class="input-phone"></div>
                                            </div>
                                        </div>
                                        <!--                                        <div class="form-group">
                                                                                    <div class="col-sm-12">
                                                                                        <input class="comp-phn-value form-control user-field-border" type="text" name="company_phone" placeholder="Phone">
                                                                                    </div>
                                                                                </div>-->
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <input id="company_email" class="form-control user-field-border" type="email" name="company_email" placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <input class="comp-vat-value form-control user-field-border text-capitalize" type="text" name="company_vat" placeholder="VAT number">
                                            </div>
                                        </div>
                                        <ul class="list-inline">
                                            <li style="float:left">
                                                <a href="#tab_default_1" data-toggle="tab" class="btn btnNext previous-one">
                                                    <img src="<?= base_url() . '../images/back_button.png' ?>">
                                                </a>
                                            </li>
                                            <li style="float:right;">
                                                <div class="tab-pane active" id="tab1">
                                                    <a onclick="third_tab()" data-toggle="tab" class="btn btn-primary btnNext next-button-class">Next<i style="padding-left:10px;" class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab_default_3">
                            <div class="tab-inner-box">
                                <div class="col-md-3 three-col-row">
                                    <div class="heading-1">CREATE CUSTOMER</div>
                                    <div class="inner">
                                        <label><i style="color: #495d80;" class="fa fa-user" aria-hidden="true"></i><span style="padding-left:5px;">
                                                <tag class="customer"></tag> customer
                                            </span></label><br>
                                        <label>
                                            <i style="color: #495d80;" class="fa fa-map-marker" aria-hidden="true"></i>
                                            <span style="padding-left:5px;">
                                                <tag class="name"></tag>
                                                <tag class="last_name"></tag>
                                            </span>
                                            <p class="address" style="padding-left:16px;font-weight:lighter;"></p>
                                            <p class="address-city" style="padding-left:16px;font-weight:lighter;"></p>
                                            <p class="address-postcode" style="padding-left:16px;font-weight:lighter;"></p>
                                            <p class="phone" style="margin-top:-5px;padding-left:16px;font-weight:lighter;"></p>
                                        </label>
                                        <div style="clear:both;"></div>
                                        <label class="comp-hide">
                                            <i style="color: #495d80;" class="fa fa-bandcamp" aria-hidden="true"></i>
                                            <span style="padding-left:5px;">
                                                <tag class="name-comp"></tag>
                                            </span>
                                            <p class="comp-address" style="padding-left:16px;font-weight:lighter;"></p>
                                            <p class="comp-city" style="padding-left:18px;font-weight:lighter;"></p>
                                            <p class="comp-postcode" style="padding-left:18px;font-weight:lighter;"></p>
                                            <p class="comp-phone" style="margin-top:-5px;padding-left:16px;font-weight:lighter;"></p>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-8 eight-col-row">
                                    <div class="heading-1">CREDIT AND PRICE LIST</div>
                                    <div class="inner">
                                        <div class="form-group">
                                            <label class="col-sm-4">Types of Customer</label>
                                            <input value="Paygo" class="" type="radio" name="cash_credit" checked>Pay as you go
                                            <input value="credit" class="" type="radio" name="cash_credit">Credit
                                            <div class="cash_credit_err"></div>
                                        </div>
                                        <div class="form-group hide-this-tab">
                                            <label class="col-sm-4">Catalouge</label>
                                            <input value="all" class="" type="radio" name="catalauge" checked>All
                                            <input value="selective" class="" type="radio" name="catalauge">Selective
                                            <div class="catalauge_err"></div>
                                        </div>
                                        <!--                                        <div class="form-group hide-this-tab">
                                                                                    <label class="col-sm-4">Discount Rate</label>
                                                                                    <input value="same" class="" type="radio" name="dis_allocation" checked>Same
                                                                                    <input value="variable" class="" type="radio" name="dis_allocation">Variable
                                                                                    <div class="dis_all_err"></div>
                                                                                </div>-->
                                        <!--code-->
                                        <!--                                        <div class="form-group">
                                                                                    <label class="col-sm-3 control-label label-align">Check To assign Zero discount</label>
                                                                                    <div class="col-sm-6">
                                                                                        <label class="container-pool">
                                                                                            <input name="not_assign_discount" class="not_assign_discount" value="1" type="checkbox">
                                                                                            <span class="checkmark-pool"></span>
                                                                                        </label>
                                                                                    </div>
                                                                                </div>-->
                                        <!--code-->
                                        <ul class="list-inline">
                                            <li style="float:left">
                                                <a href="#tab_default_2" data-toggle="tab" class="btn btnNext previous-two">
                                                    <img src="<?= base_url() . '../images/back_button.png' ?>">
                                                </a>
                                            </li>
                                            <li class="hide-this-tab" style="float:right;">
                                                <div style="float:right;" class="tab-pane active">
                                                    <a onclick="fourth_tab()" data-toggle="tab" class="btn btn-primary btnNext next-button-class">Next<i style="padding-left:10px;" class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                                </div>
                                            </li>
                                            <li class="show-submit-button" style="float:right;">
                                                <div class="tab-pane active" id="tab1">
                                                    <div id="form-submit" class="btn btn-primary btnNext next-button-class">Submit</div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab_default_4">
                            <div class="tab-inner-box">
                                <div class="col-md-3 three-col-row">
                                    <div class="heading-1">CREATE CUSTOMER</div>
                                    <div class="inner">
                                        <label><i style="color: #495d80;" class="fa fa-user" aria-hidden="true"></i><span style="padding-left:5px;">
                                                <tag class="customer"></tag> customer
                                            </span></label><br>
                                        <label>
                                            <i style="color: #495d80;" class="fa fa-map-marker" aria-hidden="true"></i>
                                            <span style="padding-left:5px;">
                                                <tag class="name"></tag>
                                                <tag class="last_name"></tag>
                                            </span>
                                            <p class="address" style="padding-left:16px;font-weight:lighter;"></p>
                                            <p class="address-city" style="padding-left:16px;font-weight:lighter;"></p>
                                            <p class="address-postcode" style="padding-left:16px;font-weight:lighter;"></p>
                                            <p class="phone" style="margin-top:-5px;padding-left:16px;font-weight:lighter;"></p>
                                        </label>
                                        <div style="clear:both;"></div>
                                        <label class="comp-hide">
                                            <i style="color: #495d80;" class="fa fa-bandcamp" aria-hidden="true"></i>
                                            <span style="padding-left:5px;">
                                                <tag class="name-comp"></tag>
                                            </span>
                                            <p class="comp-address" style="padding-left:18px;font-weight:lighter;"></p>
                                            <p class="comp-city" style="padding-left:18px;font-weight:lighter;"></p>
                                            <p class="comp-postcode" style="padding-left:18px;font-weight:lighter;"></p>
                                            <p class="comp-phone" style="margin-top:-5px;padding-left:18px;font-weight:lighter;"></p>
                                        </label>
                                        <div style="clear:both;"></div>
                                        <label>
                                            <i style="color: #495d80;" class="fa fa-credit-card" aria-hidden="true"></i>
                                            <span style="padding-left:5px;">Customer Type: <tag class="name-credit"></tag></span><br>
                                            <p style=";padding-left:20px;font-weight:lighter;padding-top:0px;padding-bottom: 3px;">Catalague: <tree class="catalogue-class"></tree>
                                            </p>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-8 eight-col-row">
                                    <div class="heading-1">SELECT CATEGORIES</div>
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
                                            ?>
                                                <label class="container-t prevent-checked">
                                                    <?= $cat['name'] ?>
                                                    <input class="checkbox-class checkBoxClass toggle-class-<?= $cat_parent_id ?>" name="checkbox[<?= $cat_parent_id ?>][checked]" value="<?= $cat_parent_id ?>" type="checkbox">
                                                    <span onclick="checked_toggle('<?= '.toggle-class-' . $cat_parent_id ?>', '<?= $cat_parent_id ?>')" class="checkmark"></span>
                                                    <?php if ($cat_child) { ?>
                                                        <a style="color:inherit;" href="javascript:void(0)">
                                                            <span class="span-plus" onclick="Append_item('<?= '#cat-parent-' . $cat_parent_id ?>')">+</span>
                                                        </a>
                                                    <?php } ?>
                                                </label>
                                                <?php
                                                if ($cat_child) {
                                                    echo "<tree class='unique-hide' id='cat-parent-$cat_parent_id'>";
                                                    foreach ($cat_child as $child) {
                                                        $next_child_id = $child['id'];
                                                        $cat_child_parent_child = cat_child($next_child_id)
                                                ?>
                                                        <label style="margin-left:32px;" class="child-container-t prevent-checked">
                                                            <?= $child['name'] ?>
                                                            <input class="checkBoxClass toggle-class-<?= $next_child_id ?> checked-only-parent-<?= $cat_parent_id ?>" name="checkbox[<?= $next_child_id ?>][checked]" value="<?= $next_child_id ?>" type="checkbox">
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
                                                        ?>
                                                                <label style="margin-left:65px;" class="child-container-tt prevent-checked">
                                                                    <?= $cat_child_parent['name'] ?>
                                                                    <input class="checkBoxClass toggle-class-<?= $cat_child_parent['id'] ?> checked-only-parent-<?= $next_child_id ?> checked-only-parent-<?= $cat_parent_id ?>" name="checkbox[<?= $cat_child_parent['id'] ?>][checked]" value="<?= $cat_child_parent['id'] ?>" type="checkbox">
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
                                        <ul class="list-inline">
                                            <li style="float:left">
                                                <a href="#tab_default_3" data-toggle="tab" class="btn btnNext previous-three">
                                                    <img src="<?= base_url() . '../images/back_button.png' ?>">
                                                </a>
                                            </li>
                                            <li style="float:right;">
                                                <div style="float:right" class="tab-pane active" id="tab1">
                                                    <div id="form-submit" class="btn btn-primary btnNext next-button-class">Submit</div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--model-->
    <style>
        .modal-backdrop {
            opacity: 0 !important;
        }
    </style>
    <div class="modal" id="myModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <p style="color:green;font-size: 20px;">Customer successfully created</p>
                </div>
            </div>
        </div>
    </div>
    <!--model-->
</section>

<script>
    $(document).ready(function() {
        //        code
        $('.show-submit-button').hide();
        if ($('.not_assign_discount').is(':checked')) {
            $('.show-submit-button').show();
            $('.hide-this-tab').hide();
        }
        $(".not_assign_discount").change(function() {
            if (this.checked) {
                $('.show-submit-button').show();
                $('.hide-this-tab').hide();
            } else {
                $('.show-submit-button').hide();
                $('.hide-this-tab').show();
            }
        });
        //        code
        $(document).on("click", ".previous-three", function() {
            $('.tabsetting a[href="#tab_default_3"]').tab('show');
        });
        $(document).on("click", ".previous-two", function() {
            $('.tabsetting a[href="#tab_default_2"]').tab('show');
        });
        $(document).on("click", ".previous-one", function() {
            $('.tabsetting a[href="#tab_default_1"]').tab('show');
        });
        $('input[type=radio][name=cash_credit]').change(function() {
            if (this.value == 'Paygo') {
                $('.credit-fields').hide();
                $('.remove-class').removeClass("fourth-form");
            } else if (this.value == 'credit') {
                $('.credit-fields').show();
                $('.remove-class').addClass("fourth-form");
            }
        });

        $(document).on("click", "#form-submit", function() {
            var submit_status = true;
            var let_discount_validation = true;
            if (let_discount_validation) {
                $(".checkBoxClass").each(function() {
                    if ($(this).is(":checked")) {
                        var id = $(this).attr('value');
                        $('.input-amount-validation-' + id).css('border-color', 'inherit');
                    } else {
                        var id = $(this).attr('value');
                        $('.input-amount-validation-' + id).css('border-color', 'inherit');
                    }
                });
            }
            if (submit_status) {
                $.post(DWS_BASE_URL + 'customer/insert', {
                        data: $('#customer-form').serialize()
                    },
                    function(returnedData) {
                        var response = JSON.parse(returnedData);
                        console.log(response);
                        if (response.status) {
                            $('#myModal').modal('show');
                            setTimeout(function() {
                                $('#myModal').modal('hide');
                                window.location.href = DWS_BASE_URL + "customer";
                            }, 3000);
                        } else {
                            console.log('might be some validation error');
                        }
                    });
            }
        });
        customRadio("type_of_customer");
        customRadio("cash_credit");
        customRadio("catalauge");
        customRadio("user_is_active");

    });

    function second_tab() {
        var status2 = true;
        $(".first-form").each(function() {
            var first_form = $(this).val();
            if (!first_form) {
                status2 = false;
                $(this).css('border-color', 'red');
            } else {
                $(this).css('border-color', 'inherit');
            }
        });

        //        var phone = $('.phone-custom').val();
        //        var number = phone.replace(/ /g, '');
        //        if ($.isNumeric(number)) {
        //            $('.phone-custom').css('border-color', '');
        //        } else {
        //            $('.phone-custom').css('border-color', 'red');
        //            status2 = false;
        //        }
        //        checked = $(".BoxClass-r:checked").length;
        //        if (!checked) {
        //            alert("You must check at least one checkbox.");
        //            status2 = false;
        //        }
        //        console.log(status2);
        var email_val = $('#first-form-email').val();
        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
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
                        $('#first-form-email').css('border-color', 'inherit');
                    }
                }
            });
        } else {
            status2 = false;
            $('#first-form-email').css('border-color', 'red');
        }

        var attr_val = $("input[name='type_of_customer']:checked").attr('attr_val');
        $('.customer').html(attr_val);
        var name_val = $('.name-value').val();
        $('.name').html(name_val);
        //        code
        var last_name_val = $('.last-name-value').val();
        $('.last_name').html(' ' + last_name_val);
        $('.address-city').html($("input[name=customer_city]").val());
        $('.address-postcode').html($("input[name=customer_postcode]").val());
        //        code
        var address_val = $('.address-value').val();
        $('.address').html(address_val);
        var phone_val = $('.phone-value').val();
        $('.phone').html(phone_val);

        if (status2) {
            $('.tabsetting a[href="#tab_default_2"]').tab('show');
        }
    }

    function third_tab() {
        var status = true;
        //        $(".second-form").each(function () {
        //            var first_form = $(this).val();
        //            if (!first_form) {
        //                status = false;
        //                $(this).css('border-color', 'red');
        //            } else {
        //                $(this).css('border-color', 'inherit');
        //            }
        //        });

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
                $('#company_email').css('border-color', 'inherit');
            } else {
                status = false;
                $('#company_email').css('border-color', 'red');
            }
        });

        console.log(status);
        var comp_name_val = $('.comp-name-value').val();
        $('.name-comp').html(comp_name_val);
        var comp_addr_val = $('.comp-addr-value').val();
        $('.comp-address').html(comp_addr_val);
        //        code
        $('.comp-city').html($("input[name=company_city]").val());
        $('.comp-postcode').html($("input[name=company_postcode]").val());
        //        code
        var comp_phn_val = $('.company-phone').val();
        $('.comp-phone').html(comp_phn_val);
        var comp_vat_val = $('.comp-vat-value').val();
        $('.comp-vat').html(comp_vat_val);
        if (!$('.phone-custom-two').val()) {
            $('.comp-hide').hide();
        }
        if (status) {
            $('.tabsetting a[href="#tab_default_3"]').tab('show');
        }
    }

    function fourth_tab() {
        var status = true;
        $(".fourth-form").each(function() {
            var first_form = $(this).val();
            if (!first_form) {
                status = false;
                $(this).css('border-color', 'red');
            } else {
                $(this).css('border-color', 'inherit');
            }
        });
        var cash_credit = $("input[name='cash_credit']:checked").val();
        if (!cash_credit) {
            status = false;
            $('.cash_credit_err').html('Please at least one').css('color', 'red');
        } else {
            $('.cash_credit_err').html('');
        }
        var dis_allocation = $("input[name='dis_allocation']:checked").val();
        var catalauge = $("input[name='catalauge']:checked").val();
        if (!catalauge) {
            status = false;
            $('.catalauge_err').html('Please at least one').css('color', 'red');
        } else {
            if (catalauge == 'all') {
                $(".checkBoxClass").prop('checked', true);
            } else {
                $(".checkBoxClass").prop('checked', false);
            }
            $('.catalauge_err').html('');
        }
        //        var dis_all = $("input[name='dis_allocation']:checked").val();
        //        if (!dis_all) {
        //            status = false;
        //            $('.dis_all_err').html('Please at least one').css('color', 'red');
        //        } else {
        //            $('.dis_all_err').html('');
        //        }
        //        code
        //        if (catalauge == 'all' && dis_all == 'same') {
        //            $('.scroll-div').hide();
        //            $('.show-discount-same').show();
        //        } else {
        //            $('.scroll-div').show();
        //            $('.show-discount-same').hide();
        //        }
        //        code
        console.log(status);
        $('.catalogue-class').html(catalauge);
        $('.name-credit').html(cash_credit);
        var credit_limit_val = $('.credit-limit-val').val();
        $('.credit-limit').html(credit_limit_val);
        var period_days = $('.period_days').val();
        $('.credit-days').html(period_days);
        if (status) {
            $('.tabsetting a[href="#tab_default_4"]').tab('show');
        }
    }

    function customRadio(radioName) {
        var radioButton = $('input[name="' + radioName + '"]');
        $(radioButton).each(function() {
            $(this).wrap("<span class='custom-radio'></span>");
            if ($(this).is(':checked')) {
                $(this).parent().addClass("selected");
            }
        });
        $(radioButton).click(function() {
            if ($(this).is(':checked')) {
                $(this).parent().addClass("selected");
            }
            $(radioButton).not(this).each(function() {
                $(this).parent().removeClass("selected");
            });
        });
    }

    $(".unique-hide").hide();

    function Append_item(elm_id, id) {
        $(elm_id).toggle();
        if ($('.toggle-class-' + id).is(':checked')) {
            var all_discount_val = $('.all-discount').val();
            $('.input-amount-validation-' + id).val(all_discount_val);
            $('.value-only-parent-' + id).val(all_discount_val);
            $('.checked-only-parent-' + id).prop('checked', true);
        } else {
            $('.input-amount-validation-' + id).val('');
            $('.value-only-parent-' + id).val('');
            $('.checked-only-parent-' + id).prop('checked', false);
        }
        console.log(elm_id);
    }
    $(".span-plus").on("click", function() {

        var text_v = $(this).text();
        if ($(this).parents('.container-t.prevent-checked').next('.unique-hide').css("display") == "none") {
            $(this).text("+");

        } else {
            $(this).text("-");

        }
    })

    function phone_validate(phno) {
        var regexPattern = new RegExp(/^[0-9-+]+$/); // regular expression pattern
        return regexPattern.test(phno);
    }

    function all_check() {
        var ckbCheckAll = $("input[name='ckbCheckAll']:checked").val();
        if (ckbCheckAll) {
            $(".checkBoxClass").prop('checked', true);
        } else {
            $(".checkBoxClass").prop('checked', false);
        }
    }

    //    function all_discount() {
    //        var apply_all = $("input[name='apply_all']:checked").val();
    //        if (apply_all) {
    //            var all_discount = $('.all-discount').val();
    //            $(".checkBoxClass").each(function () {
    //                if ($(this).is(":checked")) {
    //                    var id = $(this).attr('value');
    //                    $('.input-amount-validation-' + id).val(all_discount);
    //                } else {
    //                    var id = $(this).attr('value');
    //                    $('.input-amount-validation-' + id).val('');
    //                }
    //            });
    //        } else {
    //            $(".checkBoxClass").each(function () {
    //                if ($(this).is(":checked")) {
    //                    var id = $(this).attr('value');
    //                    $('.input-amount-validation-' + id).val('');
    //                }
    //            });
    //        }
    //    }

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 &&
            (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
</script>

<script src="js/country/intlInputPhone.min.js"></script>
<script>
    $(document).ready(function() {
        $('.personal-number .input-phone').intlInputPhone();
        $('.company-number .input-phone').intlInputPhone();

        $('.company-number .input-phone .form-control').removeClass('phone-custom');
        $('.company-number .input-phone .form-control').addClass('phone-custom-two');

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
            //            var pattern2 = /^(?=.*[0-9])[ ()0-9]+$/;
            if ($.isNumeric(number)) {
                $('.phone-custom').css('border-color', '');
            } else {
                $('.phone-custom').css('border-color', 'red');
            }
        });
        $(".phone-custom-two").on("change keyup", function() {
            var phone = $('.phone-custom-two').val();
            var number = phone.replace(/ /g, '');
            if ($.isNumeric(number)) {
                $('.phone-custom-two').css('border-color', '');
            } else {
                $('.phone-custom-two').css('border-color', 'red');
            }
        });
        //        code
    });

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

    function change_address(elm) {
        if ($(elm).is(':checked')) {
            var customer_address = $("input[name=customer_address]").val();
            var customer_city = $("input[name=customer_city]").val();
            var customer_postcode = $("input[name=customer_postcode]").val();
            var customer_phone = $(".phone-custom").val();
            var customer_email = $("input[name=customer_email]").val();
            $("input[name=company_address]").val(customer_address);
            $("input[name=company_city]").val(customer_city);
            $("input[name=company_postcode]").val(customer_postcode);
            $(".phone-custom-two").val(customer_phone);
            $("input[name=company_email]").val(customer_email);
        } else {
            $("input[name=company_address]").val('');
            $("input[name=company_city]").val('');
            $("input[name=company_postcode]").val('');
            $(".phone-custom-two").val('');
            $("input[name=company_email]").val('');
        }
    }
</script>
<script type="text/javascript" src="<?= base_url() . '../js/min_spent.js' ?>"></script>