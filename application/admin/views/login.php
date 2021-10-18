<!DOCTYPE html>
<html lang="en">

<head>
    <title>Welcome To Admin Panel</title>
    <base href="<?php echo base_url(); ?>" />
    <!-- Stylesheet -->
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="css/login.css" type="text/css" media="screen" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="<?= $this->config->item('CONTACT_US_FILE_URL') . DWS_FAV_ICON ?>" />
    <!--[if lte IE 6]>
        <link rel="stylesheet" type="text/css" href="css/css_iehacks.css" />
        <![endif]-->
    <!--[if lte IE 7]>
        <link rel="stylesheet" type="text/css" href="css/css_ie7hacks.css" />
        <![endif]-->

    <!-- Meta Tags -->
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
</head>

<body id="loginform" class="outer-wrapper">
    <div class="inner-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <div class="col-lg-offset-2 col-sm-offset-2 col-lg-8 col-sm-8 col-xs-12">
                        <div id="wrap">
                            <div class="clearfix"></div>
                            <div id="page" class="back-ground-col">
                                <div class="pageTop ">
                                    <img src="<?= $this->config->item('CONTACT_US_FILE_URL') . DWS_LOGO ?>" alt="logo" class="img-responsive">
                                    <!-- <span>LOG IN TO ADMIN PANEL</span> -->
                                </div>
                                <div class="pageContent clearfix">
                                    <div class="admin-login-form-section">
                                        <?php $this->load->view('inc-messages'); ?>
                                        <form action="<?= base_url(); ?>welcome/index/" method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <!-- <label for="username" class="username-label">Username</label> -->
                                                <input type="text" name="username" id="username" class="form-control manualcss focus" placeholder="Username">
                                            </div>
                                            <div class="form-group">
                                                <!-- <label for="password" class="username-label">Password</label> -->
                                                <input type="password" name="passwd" id="password" class="form-control manualcss focus" placeholder="Password">
                                                <label for="remember-me" class="retr username-label"><a href="<?= base_url(); ?>welcome/lostpasswd/">Forgot your password?</a></label>
                                            </div>
                                            <div class="form-group col-xs-12" style="padding:0px">
                                                <!-- <label for="password">Please type the letter from the image</label> -->
                                                <div class="col-lg-6 col-sm-6 col-xs-12 " style="padding-left:0px">
                                                    <div class="captcha-image"><?= $captcha['image']; ?></div>
                                                </div>
                                                <div class="col-xs-6" style="padding-right:0px"><input type="text" name="captcha" id="captcha" class="form-control manualcss focus" autocomplete="off" placeholder="Captcha"></div>

                                            </div>
                                            <div class="form-group col-xs-12" style="margin-top: 10px; padding:0px">

                                                <div class=" col-xs-12 " style="padding:0px">
                                                    <input type="hidden" name="captcha-val" value="<?= $captcha['word']; ?>">
                                                    <input type="submit" name="submit" class="btn btn-primary btn-block pull-right btn-log-in" value="Login">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="js/jquery.js"></script>
        <script>
            $(document).ready(function() {
                $('.focus').focusin(function() {
                    $('.admin-logo').css('animation-play-state', 'running');
                });
                $('.focus').focusout(function() {
                    $('.admin-logo').css('animation-play-state', 'paused');
                });
            });
        </script>
</body>

</html>