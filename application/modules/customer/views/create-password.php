<style>
    .button-color{
        background:#ff6c00;
    }
</style>
<section id="single_product_col">
    <div class="container-fluid site-container null-padding">
        <div class="col-xs-12 product_main_div null-padding">
            <ul class="breadcrumb about_page">
                <li><a href="<?= base_url() ?>">Home</a></li>
                <li class="active"><a href="javascript:void(0)">Create Password</a></li>
            </ul>
        </div>
    </div>
</section>
<section class="bg-light-gray form-font" id="portfolio">
    <div class="container-fluid site-container">
        <div class="middle-container dashboard col-xs-12 col-sm-12 col-lg-12" id="middle-content-section">
            <div class="col-xs-12 col-sm-12 col-lg-12 dash-inn-right">
                <form id="create-passwd" action="" method="post" name="accountinfo" class="form-horizontal change-psw_form" autocomplete="off">
                    <div class="account-info-right-sidebar">
                        <div class="account-info-right-form">
                            <div class="col-lg-12 account-form-info">
                                <h1 class="right-top-heading"><i class="fa fa-key" aria-hidden="true"></i> Create Password </h1>
                                <div class="right-why-account-info-section">
                                    <span class="success-msz"></span>
                                </div>
                            </div>
                            <div class="account-form-edit">
                                <div class="col-xs-12 col-sm-12 col-lg-12 col-input-xs cp">
                                    <div class="form-group row">
                                        <div class="col-sm-12 null-padding">
                                            <input class="form-control" id="cho_newpassword" name="password" value="" type="password" placeholder="Password*">
                                        </div>
                                        <div class="password-err"></div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12 null-padding">
                                            <input class="form-control" id="cho_confirmpassword" name="confirmpassword" value="" type="password" placeholder="Confirm Password*">
                                        </div>
                                        <div class="password-new-err"></div>
                                    </div>
									<div class="form-group">
                                         <input id="checkbox-checked" style="width:auto;" type="checkbox">Show Password
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-lg-12 form-group-outer">
                                    <div class="form-group">
                                        <div class="col-xs-12 col-sm-12 col-lg-12 am-sub-btn null-padding">
                                            <input type="submit" name="myaccount" class="btn btn-lg reset-btn one-half-width-btn button-color" value="Submit" width="71" height="32" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    $("#create-passwd").submit(function (e) {
        e.preventDefault();
        var password = $('#cho_newpassword').val();
        if (password) {
            $('.password-err').html('');
        } else {
            $('.password-err').html('Please enter a password').css('color', 'red');
        }
        var new_password = $('#cho_confirmpassword').val();
        console.log(new_password);
        if (password == new_password && new_password) {
            $('.password-new-err').html('');
            $.post(DWS_BASE_URL + 'customer/login/save_password', {password: password, user_randon_string: '<?= $user_randon_string ?>'},
                    function (returnedData) {
                        var obj = JSON.parse(returnedData);
                        console.log(obj);
                        if (obj.status) {
                            $('.success-msz').html('password created successfully').css('color', 'green');
                            window.setTimeout(function () {
                                window.location.href = DWS_BASE_URL + 'customer/login';
                            }, 3000);
                        }
                    });
        } else {
            $('.password-new-err').html('Please enter correct password').css('color', 'red');
        }
    });
	  $(document).ready(function(){
        $('#checkbox-checked').click(function(){
            if($(this).prop("checked") == true){
                $('#cho_newpassword').attr("type","text");
				$('#cho_confirmpassword').attr("type","text");
            }
            else if($(this).prop("checked") == false){
                 $('#cho_newpassword').attr("type","password");
				 $('#cho_confirmpassword').attr("type","password");
            }
        });
    });
</script>
