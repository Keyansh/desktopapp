<section id="process-steps">
    <div class="container-fluid">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 process-steps-main-col">

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 process-steps-inner-col">

                <ul class="nav nav-tabs process-tabs nav-justified">
                    <li>
                        <a href="checkout">
                            <div class="tab-head">
                                <img src="images/tab1.png" class="img-responsive"/>
                            </div>
                            Cart
                        </a>
                    </li>
                    <li class="active">
                        <a href="checkout/login">
                            <div class="tab-head">
                                <img src="images/tab2.png" class="img-responsive"/>
                            </div>
                            Login
                        </a>
                    </li>
                    <li>
                        <a href="checkout/paymentreview">
                            <div class="tab-head">
                                <img src="images/tab3.png" class="img-responsive"/>
                            </div>
                            Payment
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <div class="tab-head">
                                <img src="images/tab4.png" class="img-responsive"/>
                            </div>
                            Confirm
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <!--Login Tab-->
                    <div id="login" class="tab-pane fade in active">
                        <div class="process-tabs-inner">
                            <div class="centered-fixed">
                                <div class="login-group">
                                    <?php $this->load->view('inc-messages'); ?>
                                    <p class="form-group-header">Login to Warwickshire Clothing</p>
                                    <ul class="list-inline social-login">
                                        <li>
                                            <a href="JavaScript:void(0);" onClick="FacebookLogin();
                                                    return false;"><img src="images/fb-login.png" class="img-responsive"/><span>Facebook</span></a>
                                        </li>
                                        <li><div class="g-signin2" data-onsuccess="onSignIn" id="customBtn"></div></li>
                                        <!--<li><a href="#"><img src="images/google-login.png" class="img-responsive"/><span>Google</span></a></li>-->
                                    </ul>
                                    <p class="login-p">Or Login with your Warwickshire account</p>
                                    <div class="form-group-col login-col">

                                        <form id="form1" name="form1" method="post" action="checkout/login">
                                            <div class="form-group">
                                                <input type="email" name="email" class="form-control" placeholder="Email"/>
                                            </div>  
                                            <div class="form-group">
                                                <input type="password" class="form-control" name="passwd" placeholder="Password"/>
                                                <a href="customer/forgotpass">Forgot Password?</a>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-info">Login</button>
                                            </div>
                                        </form>
                                        <div class="form-group signup">
                                            <p class="sign-up">New to Warwickshire? <a href="customer/register">Create Account</a></p>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <p>Note:- Signup Form  (This form will open on same page on click of create account link that is in login form</p>
                                <!--Signup Form  (This form will be opened on same page on click of create account link that is in login form )-->
                                <ol class="numbered-list">
                                    <!--1st Inputs-->
                                    <li class="number-li">
                                        <form id="registerForm">
                                            <div class="form-group-col">
                                                <!--Form group heading-->
                                                <p class="form-group-header">Create an account</p>
                                                <!--Input-->
                                                <div class="form-group">
                                                    <input type="text" name="first_name" class="form-control" placeholder="First Name"/>
                                                    <div class="fnameerror error" style="display:none;color:red">Please enter your first name</div>
                                                </div>  
                                                <!--Input-->
                                                <div class="form-group">
                                                    <input type="text" name="last_name" class="form-control" placeholder="Last Name"/>
                                                    <div class="lnameerror error" style="display:none;color:red">Please enter your last name</div>
                                                </div>
                                                <div class="form-group">
                                                    <input type="email" class="form-control" name="email" placeholder="Email"/>
                                                    <div class="emailerror error" style="display:none;color:red">Please enter your email</div>
                                                    <div class="validemailerror error" style="display:none;color:red">Please enter valid email</div>
                                                    <div class="existemailerror error" style="display:none;color:red">Email is already exist!</div>
                                                </div>  
                                                <!--Input-->
                                                <div class="form-group">
                                                    <input type="password" class="form-control" name="password" placeholder="Password"/>
                                                    <div class="passworderror error" style="display:none;color:red">Please enter your password</div>
                                                </div>
                                                <!--Input-->
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="phone" placeholder="Mobile number (For order status update)"/>
                                                    <div class="phoneerror error" style="display:none;color:red">Please enter your phone</div>
                                                </div>
                                                <!--Input-->
                                                <div class="form-group">
                                                    <ul class="list-inline gender-list">
                                                        <li><span class="label">I am:</span></li>
                                                        <li>
                                                            <label class="al-new-select">
                                                                <input type="radio" value="male" name="gender">
                                                                <span class="cstm-checkbox"><i class="fa fa-circle" aria-hidden="true"></i></span>
                                                                <span class="name"> Male</span>
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <label class="al-new-select">
                                                                <input type="radio" value="female" name="gender">
                                                                <span class="cstm-checkbox"><i class="fa fa-circle" aria-hidden="true"></i></span>
                                                                <span class="name"> Female</span>
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <label class="al-new-select">
                                                                <input type="radio" value="other" name="gender">
                                                                <span class="cstm-checkbox"><i class="fa fa-circle" aria-hidden="true"></i></span>
                                                                <span class="name"> Other</span>
                                                            </label>
                                                        </li>
                                                    </ul> 
                                                    <div class="gendererror error" style="display:none;color:red">Please select your gender</div>
                                                </div>
                                                <!--Input-->
                                                <div class="form-group">
                                                    <button type="button" id="regcont" class="btn btn-info">Register & Continue</button>
                                                </div>
                                            </div>
                                        </form>
                                    </li>
                                    <!--                                    2nd Inputs
                                                                        <li class="number-li">
                                                                            <form id="personalInformationForm">
                                                                                <div class="form-group-col">
                                                                                    Form group heading
                                                                                    <p class="form-group-header">Personal details</p>
                                                                                    Input
                                                                                    
                                                                                    Input
                                                                                    <div class="form-group">
                                                                                        <input type="text" name="job" class="form-control" placeholder="Job Title"/>
                                                                                    </div>
                                                                                    Input
                                                                                    <div class="form-group">
                                                                                        <input type="text" name="company_name" class="form-control" placeholder="Company Name"/>
                                                                                    </div>
                                                                                    Input
                                                                                    <div class="form-group">
                                                                                        <button type="button" id="regpers" class="btn btn-info">Continue</button>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </li>
                                                                        3rd Inputs
                                                                        <li class="number-li">
                                                                            <div class="form-group-col">
                                                                                Form group heading
                                                                                <p class="form-group-header">Billing address</p>
                                                                                Input
                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control" placeholder="First Name"/>
                                                                                </div>  
                                                                                Input
                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control" placeholder="Last Name"/>
                                                                                </div>
                                                                                Input
                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control" placeholder="Contact Number"/>
                                                                                </div>
                                                                                Input
                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control" placeholder="City"/>
                                                                                </div>
                                                                                Input
                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control" placeholder="Postcode"/>
                                                                                </div>
                                                                                Input
                                                                                <div class="form-group">
                                                                                    <textarea class="form-control" placeholder="Address"></textarea>
                                                                                </div>
                                                                                Input
                                                                                <div class="form-group">
                                                                                    <ul class="list-inline checkbox-list">
                                                                                        <li>
                                                                                            <label class="al-new-select">
                                                                                                <input type="checkbox">
                                                                                                <span class="cstm-checkbox"><i class="fa fa-check" aria-hidden="true"></i></span>
                                                                                                <span class="name">Join our newsletter - new stock alerts, sales etc.</span>
                                                                                            </label>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                                Input
                                                                                <div class="form-group">
                                                                                    <button type="button" class="btn btn-info">Submit</button>
                                                                                </div>
                                                                            </div>
                                                                        </li>-->
                                </ol>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>
</section>
<script src="http://connect.facebook.net/en_US/all.js"></script>
<script src="https://apis.google.com/js/platform.js" async defer></script>
<!--<meta name="google-signin-client_id" content="1094756415947-b97at9nr992du5bediakugojustefet7.apps.googleusercontent.com">-->
<meta name="google-signin-client_id" content="1094756415947-dgm678f2d05lb366ntqmg5d7p3ou2bo1.apps.googleusercontent.com">
<script>
                                                var returnUrl = '<?php echo $returnUrl; ?>';
                                                window.fbAsyncInit = function () {
                                                    FB.init({
                                                        appId: '1154942717882690',
                                                        cookie: true,
                                                        xfbml: true,
                                                        version: 'v2.7'
                                                    });
                                                };

                                                (function (d, s, id) {
                                                    var js, fjs = d.getElementsByTagName(s)[0];
                                                    if (d.getElementById(id))
                                                        return;
                                                    js = d.createElement(s);
                                                    js.id = id;
                                                    js.src = "//connect.facebook.net/en_US/sdk.js";
                                                    fjs.parentNode.insertBefore(js, fjs);
                                                }(document, 'script', 'facebook-jssdk'));

                                                function FacebookLogin() {
                                                    FB.login(function (response) {
                                                        if (response.authResponse) {
                                                            console.log('Welcome!  Fetching your information.... ');
                                                            FB.api('/me?scope=email&fields=last_name,first_name,email,gender', function (response) {
                                                                console.debug(response);
                                                                if (response.first_name != undefined)
                                                                {
                                                                    $.post("<?= base_url(); ?>customer/fb/fb_login/", "fname=" + response.first_name + "&lname=" + response.last_name + "&id=" + response.id + "&email=" + response.email + "&gender=" + response.gender + "&returnUrl=" + returnUrl, function (data) {
                                                                        if (data != null && data != "" && data.indexOf("redirect") > -1) {
                                                                            window.location = data.replace("redirect", "");
                                                                        } else {
                                                                            location.reload();
                                                                        }
                                                                    });
                                                                }
                                                            });
                                                        } else {
                                                            console.log('User cancelled login or did not fully authorize.');
                                                        }
                                                    });
                                                }




                                                function onSignIn(googleUser) {
                                                    var profile = googleUser.getBasicProfile();
                                                    if (profile) {
                                                        $.post("<?= base_url(); ?>customer/fb/google_login/", "name=" + profile.getName() + "&id=" + profile.getId() + "&email=" + profile.getEmail(), function (data) {
                                                            if (data != null && data != "" && data.indexOf("redirect") > -1) {
                                                                window.location = data.replace("redirect", "");
                                                            } else {
                                                                location.reload();
                                                            }
                                                        });
                                                    }
                                                    console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
                                                    console.log('Name: ' + profile.getName());
                                                    console.log('Image URL: ' + profile.getImageUrl());
                                                    console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
                                                }
                                                setTimeout(function () {
                                                    $('.abcRioButtonContents').find('span').first().text('GOOGLE');
                                                }, 300);

</script>