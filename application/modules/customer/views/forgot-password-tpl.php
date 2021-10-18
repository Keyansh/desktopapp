<style>
.heading.forgot-password>p {
    text-align: center;
    padding: 0;
}
.new-pass {
    font-size: 34px !important;
    text-align: center !important;
    font-family: Roboto-Bold !important;
    color: #ff6c00 !important ;
    margin: 0 !important;
    padding-bottom: 20px!important;
}
#lostpasswd_frm {
    width: 55%;
    margin: auto;
    background: #E6E6E6;
    padding: 30px 20px;
    margin-top:35px;
}

 .fg-inner {
    width: 60% !important;
    margin: auto !important;
    padding-bottom: 15px !important;
}
.submit-sec{
    float:none;
}
#lostpasswd_frm .form-group.submit-sec.col-xs-12.col-sm-12.col-lg-12 {
    display: table;
    margin: auto;
    width: 100%;
    text-align: center;
}
 #password1,
 #password2 {
    height: 41px;
    border-radius: 0;
    font-size: 15px;
}
.for-get-pass{
    float: none !important;
    margin: auto !important;
    background: #ff6c00 !important;
    border-radius: 0 !important;
    padding: 5px 142px !important;
    font-size: 20px !important;
    font-family: Roboto-Regular !important;
    border: none !important;
    width:100%;
}
@media (min-width:767px){
    #lostpasswd_frm {
    width: 100%;
    margin: auto;
    background: #E6E6E6;
    padding: 5px;
    display: block;
}
.new-pass {
    font-size: 24px !important;
    padding-bottom: 10px !important;
}
.fg-inner {
    width: 100%;
}
.for-get-pass{
    float: none !important;
    margin: auto !important;
    background: #ff6c00 !important;
    border-radius: 0 !important;
    padding: 10px 20px !important;
    font-size: 20px !important;
}
}
</style>

<div class="site-form-outer col-xs-12 col-sm-12 col-lg-12 default-padding">
    <div id="loginbox" class="dis-tab">
        <div class="site-main-form-inner">
            <?php if ($type == 2) { ?>
                <div class="heading forgot-password">
                    <p>Reset Password</p>
                </div>
                <div class="site-main-form">
                    <p class="forgot-password-p"><span><strong><?php echo $msg; ?>.</strong></span></p>
                </div>
            <?php } else {
                ?>
                
                <div class="site-main-form">
                    <?php $this->load->view('inc-messages'); ?>
                    <form id="lostpasswd_frm" name="lostpasswd_frm" method="post"  enctype="multipart/form-data">
                    <div class="heading forgot-password">
                    <p class="new-pass">New Password</p>
                </div>
                        <div class="form-group input-box">
                            <div class="fg-inner">
                                <input name="password" type="password" class="form-control" id="password1" autocomplete="off" placeholder="Please enter new Password"/>

                            </div>
                        </div>
                        <div class="form-group input-box">
                            <div class="fg-inner">
                                <input name="confirm_password" type="password" class="form-control" id="password2" autocomplete="off" placeholder="Please enter Confirm Password"/>
                            </div>
                        </div>
                        <div class="form-group submit-sec col-xs-12 col-sm-12 col-lg-12">
                        <div class="fg-inner">
                            <input type="submit" class="btn btn-primary submit for-get-pass" value="Submit" />
                            </div>
                        </div>
                    </form>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
