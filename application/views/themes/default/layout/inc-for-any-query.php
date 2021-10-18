<div class="container-fluid">
    <div class="col-xs-12 for-any-query padding-zero">
        <div class="col-xs-12 col-sm-5 left-part-query"> 
            <div class="col-xs-12 left-part-query-inner">
            <div class="alert alert-danger" id="enquiryAlert" style="display: none;"></div>
                <form action="" id="for-query">
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" placeholder="Name*">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="phone" placeholder="Phone number*">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="email" placeholder="Email*">
                    </div>

                    <div class="form-group">
                        <textarea  id="" cols="30" rows="10" name="message" placeholder="Message*"></textarea>
                    </div>
                    <div class="form-group">
                        <div class="g-recaptcha cap-width-100" data-sitekey="<?= DWS_RECAPTCHA_SITE_KEY ?>"></div>
                    </div>
                    <input type="hidden" name="homepage" value="1">
                    <div class="form-group">
                        <button type="submit" id="submit-ing">Submit for Call back</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-xs-12 col-sm-7 right-part-query">
            <iframe src="https://www.youtube.com/embed/y2QFFastvRA?feature=oembed" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="" width="100%" height="450px" frameborder="0"></iframe>
        </div>


    </div>
</div>

<link type="text/css" rel="stylesheet" href="<?= base_url() ?>css/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!--shop by price-->
<script src="http://malsup.github.io/jquery.blockUI.js"></script>
<script>
    $("#for-query").submit(function(e) {

        e.preventDefault();
        $('.left-part-query-inner').block({
            message: '<h1>Processing...</h1>',
            css: {
                textAlign: 'center',
                color: '#fff',
                border: '0px solid #aaa',
                cursor: 'wait',
                backgroundColor: 'transparent',
            }
        });
            $("#submit-ing").text("Processing..")

        $.ajax({
            url: '<?php echo base_url(); ?>contact',
            type: "POST",
            data: $("#for-query").serialize(),
            success: function(data) {
                var res = JSON.parse(data);
                $("#submit-ing").text("Submit for Call back")
                
                if(res.success){
                    $('#enquiryAlert').hide();
                    window.location = res.redirect_url;
                }else{
                    $('#enquiryAlert').html(res.message);
                    $('#enquiryAlert').show();
                }
                $('.left-part-query-inner').unblock();


            }
        });


    });
</script>