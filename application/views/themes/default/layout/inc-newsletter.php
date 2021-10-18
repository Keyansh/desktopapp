<div class="container-fluid ">
    <div class="col-xs-12 newsletter common-padding">
        <div class="left-sec inline-child">
            <p>
                Sign up to our <span class="news_sign"> newsletter &nbsp;&nbsp; </span>
                <span class="news_detail">…and receive
                    £20 coupon for your first shopping. </span>
            </p>
        </div>
        <div class="right-sec inline-child">
            <div class="form-group clear-parent">
                <input class="email-subscribe form-control" name="email" type="text" placeholder="Enter your email">
                <button type="submit" onclick="subscribe()" class="btn site-btn">Sign up</button>
                <div class="error error-ms-news-let"></div>
            </div>
        </div>
    </div>
</div>

<!--model-->
<div class="modal fade" id="Modal_subscribe" tabindex="-1" role="dialog" aria-labelledby="Modal_subscribeLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div style="background:#ff6c00;" class="modal-content">
            
            <div style="color:white;font-size: 20px;" class="modal-body text-center">
                Successfully Subscribed
            </div>
            
        </div>
    </div>
</div>
<!--model end-->
