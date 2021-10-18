<?php //e($address); 
?>
<style>
    #testimonals,
    #latest-project {
        display: none;
    }

    .contact-inner-div {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }
</style>
<section id="single_product_col">
    <div class="container-fluid site-container">
        <div class="col-xs-12 product_main_div null-padding">
            <ul class="breadcrumb about_page">
                <li><a href="<?= base_url() ?>">Home</a></li>
                <li class="active"><a href="javascript:void(0)"><?= $page['title'] ?></a></li>
            </ul>
        </div>
    </div>
</section>

<section id="contact-parent-div">
    <div class="container-fluid site-container">
        <div class="contact-parent-div col-xs-12 padding-zero">
            <div class="contact-inner-div col-xs-12">
                <?php if (DWS_CALL_CUSTOMER_SERVICE) { ?>
                    <div class="head-contact col-xs-12 col-sm-3">
                        <ul class="contact-div customer-list list-inline col-xs-12 padding-zero">
                            <li class="list-div col-xs-12 col-sm-3">
                                <img src="images/4.jpg" alt="logo" class="img-responsive con-img">
                            </li>
                            <li class="list-inner col-xs-12 col-sm-9">
                                <p class="cust-text">customer service</p>
                                <a href="tel:<?= DWS_CALL_CUSTOMER_SERVICE ?>" class="con-tel"><?= DWS_CALL_CUSTOMER_SERVICE ?></a>
                            </li>
                        </ul>

                    </div>
                <?php } ?>
                <div class="head-contact col-xs-12 col-sm-3">
                    <ul class="contact-div list-inline  col-xs-12 padding-zero">
                        <li class="list-div col-xs-12 col-sm-3">
                            <img src="images/3.jpg" alt="logo" class="img-responsive con-img">
                        </li>
                        <li class="list-inner col-xs-12 col-sm-9">
                            <p class="cust-text">Join our mailing list</p>
                            <form action="" id="newsletterbtm">
                                <span id="error" style="display:none;color:red;">Wrong email</span>
                                <input type="text" id="newsletteremail" class="simple_div form-control" name="email_newsletter" required placeholder="Enter you email here">
                                <button type="submit" class="send-div">Join Now</button>
                            </form>
                        </li>
                    </ul>

                </div>
                <div class="head-contact col-xs-12 col-sm-3">
                    <ul class="contact-div list-inline  col-xs-12 padding-zero">
                        <li class="list-div col-xs-12 col-sm-3">
                            <img src="images/2.jpg" alt="logo" class="img-responsive con-img">
                        </li>
                        <li class="list-inner col-xs-12 col-sm-9">
                            <p class="cust-text">Email us</p>
                            <p class="email-text">click a button to fill out a brief form to email us directly.</p>
                            <a href="mailto:<?= DWS_EMAIL_ADMIN ?>" class="send-div">Send Email</a>
                        </li>
                    </ul>

                </div>
                <div class="head-contact col-xs-12 col-sm-3">
                    <ul class="contact-div list-inline  col-xs-12 padding-zero">
                        <li class="list-div col-xs-12 col-sm-3">
                            <img src="images/1.jpg" alt="logo" class="img-responsive con-img">
                        </li>
                        <li class="list-inner col-xs-12 col-sm-9">
                            <p class="cust-text">Become a Distributor</p>
                            <p class="email-text">click a button to fill out a brief form to become a distributor.
                            </p>
                            <a href="mailto:<?= DWS_EMAIL_CUSTOMER_SERVICE ?>" class="send-div">Send Email</a>
                        </li>
                    </ul>

                </div>

            </div>
        </div>
    </div>
</section>
<?php if ($address) { ?>
    <style>
        .mainMapImg {
            pointer-events: none;
        }

        .product-to-view li {
            list-style: none;
        }
    </style>
    <section id="contact-iframe-section">
        <div class="container-fluid site-container">
            <div class="contact-iframe-section col-xs-12 padding-zero">
                <div class="contact-frame-div col-xs-12 padding-zero">
                    <div class="iframe_main">
                        <img src="images/map.jpg" alt="iframe-alt" class="iframe-img img-responsive mainMapImg">
                        <img src="images/location_icon.png" data-id="1" data-img="images/south-africa.jpg" alt="iframe-alt" class="location_icon-1 img-responsive">
                        <img src="images/location_icon.png" data-id="2" data-img="images/Philippines.jpg" alt="iframe-alt" class="location_icon-2 img-responsive">
                        <img src="images/location_icon.png" data-id="3" data-img="images/india.jpg" alt="iframe-alt" class="location_icon-3 img-responsive">
                        <img src="images/location_icon.png" data-id="4" data-img="images/pakistan.jpg" alt="iframe-alt" class="location_icon-4 img-responsive">
                        <img src="images/location_icon.png" data-id="5" data-img="images/Qatar.jpg" alt="iframe-alt" class="location_icon-5 img-responsive">
                        <img src="images/location_icon.png" data-id="6" data-img="images/dubai.jpg" alt="iframe-alt" class="location_icon-6 img-responsive">
                        <img src="images/location_icon.png" data-id="7" data-img="images/UK.jpg" alt="iframe-alt" class="location_icon-7 img-responsive">
                        <img src="images/location_icon.png" data-id="8" data-img="images/saudi-arabia.jpg" alt="iframe-alt" class="location_icon-8 img-responsive">

                    </div>
                </div>
            </div>
        </div>
    </section>


    <section id="conhardware-section">
        <div class="container-fluid site-container">
            <div class="conhardware-section col-xs-12 padding-zero">
                <div class="con-hard-main-div col-xs-12">
                    <?php foreach ($address as $item) { ?>
                        <div class="hard-con-inner col-xs-12 col-sm-3" data-id='<?= $item['data_id'] ?>'>
                            <div class="hard-inner col-xs-12">
                                <div class="location-text-div">
                                    <p class="hard-head"><?= $item['contactus_name'] ?></p>
                                </div>
                                <div class="trade-text">
                                    <p class="hard-text"><?= $item['contactus_location'] ?>
                                        <? //= $item['contactus_country'] 
                                        ?></p>
                                </div>

                                <div class="consort-mail-div">
                                    <?php $tel = explode(",", $item['contactus_phone']);
                                    foreach ($tel as $value) { ?>
                                        <p class="hard-text">Tel:<a href="tel:<?= $value ?>" class="hard-link"><?= $value ?></a></p>
                                    <?php } ?>
                                    <?php if ($item['contactus_fax']) { ?> <p class="hard-text">Fax:<a href="fax:<?= $item['contactus_fax'] ?>" class="hard-link"><?= $item['contactus_fax'] ?></a></p><?php } ?>
                                    <?php if ($item['contactus_email']) { ?><p class="hard-text">Email:<a href="mailto:<?= $item['contactus_email'] ?>" class="hard-link link-mail"><?= $item['contactus_email'] ?></a></p><?php } ?>
                                    <?php if ($item['contactus_web']) { ?> <p class="hard-text">Web:<a href="mailto:<?= $item['contactus_web'] ?>" class="hard-link link-mail" target="blank"><?= $item['contactus_web'] ?></a></p><?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
<?php } ?>



<section id="conhardware-section" style="display: none;">
    <div class="container-fluid site-container">
        <div class="conhardware-section col-xs-12 padding-zero">
            <div class="con-hard-main-div col-xs-12">

                <div class="hard-con-inner col-xs-12 col-sm-3" data-id="7">
                    <div class="hard-inner col-xs-12">
                        <div class="location-text-div">
                            <p class="hard-head">UK HEAD OFFICE</p>
                        </div>
                        <div class="trade-text">
                            <p class="hard-text">Consort Architectural Hardware Limited
                                25/31 Lower Loveday Street, Birmingham, B19 3SB
                                United Kingdom</p>
                        </div>

                        <div class="consort-mail-div">
                            <p class="hard-text">Tel:<a href="tel:+44 (0) 121 359 8189" class="hard-link">+44 (0) 121 359 8189</a></p>
                            <p class="hard-text">Fax:<a href="fax:+44 (0) 121 359 5172" class="hard-link">+44 (0) 121 359 5172</a></p>
                            <p class="hard-text">Email:<a href="mailto:info@consort-hw.com" class="hard-link link-mail">info@consort-hw.com</a></p>
                            <!-- <p class="hard-text">Web:<a href="mailto:<?= $item['contactus_web'] ?>" class="hard-link link-mail" target="blank"><?= $item['contactus_web'] ?></a></p> -->
                        </div>
                    </div>
                </div>
                <div class="hard-con-inner col-xs-12 col-sm-3" data-id="8">
                    <div class="hard-inner col-xs-12">
                        <div class="location-text-div">
                            <p class="hard-head">MIDDLE EAST HEAD OFFICE</p>
                        </div>
                        <div class="trade-text">
                            <p class="hard-text">Consort Middle East LLC (Dubai)
                                3903 – 3904 Mazaya Business Avenue, Tower BB2, JLT,
                                Dubai, United Arab Emirates, PO Box 19186</p>
                        </div>

                        <div class="consort-mail-div">
                            <p class="hard-text">Tel:<a href="tel:+971 (0) 4 446 0900" class="hard-link">+971 (0) 4 446 0900</a></p>
                            <p class="hard-text">Fax:<a href="fax:+971 (0) 4 446 0999" class="hard-link">+971 (0) 4 446 0999</a></p>
                            <p class="hard-text">Email:<a href="mailto:info@consortme.com" class="hard-link link-mail">info@consortme.com</a></p>
                            <!-- <p class="hard-text">Web:<a href="mailto:<?= $item['contactus_web'] ?>" class="hard-link link-mail" target="blank"><?= $item['contactus_web'] ?></a></p> -->
                        </div>
                    </div>
                </div>
                <div class="hard-con-inner col-xs-12 col-sm-3" data-id="1">
                    <div class="hard-inner col-xs-12">
                        <div class="location-text-div">
                            <p class="hard-head">SOUTH AFRICA</p>
                        </div>
                        <div class="trade-text">
                            <p class="hard-text">SA Hardware Traders (Pty) Ltd
                                Trading as: Consort SA
                                PO Box 174, Merrivale 3291, Kwa Zulu Natal, South Africa</p>
                        </div>

                        <div class="consort-mail-div">
                            <p class="hard-text">Tel:<a href="tel:+27 (0) 84 552 1070" class="hard-link">+27 (0) 84 552 1070</a></p>
                            <p class="hard-text">Fax:<a href="fax:+27 (0) 33 330 3109" class="hard-link">+27 (0) 33 330 3109</a></p>
                            <p class="hard-text">Email:<a href="mailto:info@consortsa.com" class="hard-link link-mail">info@consortsa.com</a></p>
                            <p class="hard-text">Web:<a href="www.consortsa.com>" class="hard-link link-mail" target="blank">www.consortsa.com</a></p>
                        </div>
                    </div>
                </div>
                <div class="hard-con-inner col-xs-12 col-sm-3" data-id="5">
                    <div class="hard-inner col-xs-12">
                        <div class="location-text-div">
                            <p class="hard-head">QATAR</p>
                        </div>
                        <div class="trade-text">
                            <p class="hard-text">Consort Trading WLL (Qatar)
                                Gate No. 3, Street No. 43 – Zone 57
                                Old Industrial Area – Al Kassarat Street, Doha, Qatar, PO Box 23300</p>
                        </div>

                        <div class="consort-mail-div">
                            <p class="hard-text">Tel:<a href="tel:+974 4472 6075" class="hard-link">+974 4472 6075</a></p>
                            <p class="hard-text">Fax:<a href="fax:+974 4472 6075" class="hard-link">+974 4472 6075</a></p>
                            <p class="hard-text">Email:<a href="mailto:qatar@consortme.com" class="hard-link link-mail">qatar@consortme.com</a></p>
                            <!-- <p class="hard-text">Web:<a href="www.consortsa.com>" class="hard-link link-mail" target="blank">www.consortsa.com</a></p> -->
                        </div>
                    </div>
                </div>
                <div class="hard-con-inner col-xs-12 col-sm-3" data-id="6">
                    <div class="hard-inner col-xs-12">
                        <div class="location-text-div">
                            <p class="hard-head">KINGDOM OF SAUDI ARABIA</p>
                        </div>
                        <div class="trade-text">
                            <p class="hard-text">Consort Middle East Limited (Riyadh, KSA)</p>
                        </div>

                        <div class="consort-mail-div">
                            <p class="hard-text">Tel:<a href="tel:+966 (0) 5434 12345" class="hard-link">+966 (0) 5434 12345</a></p>
                            <p class="hard-text">Tel:<a href="tel:+966 (0) 5697 17016" class="hard-link">+966 (0) 5697 17016</a></p>
                            <!-- <p class="hard-text">Fax:<a href="fax:+974 4472 6075" class="hard-link">+974 4472 6075</a></p> -->
                            <!-- <p class="hard-text">Email:<a href="mailto:qatar@consortme.com" class="hard-link link-mail">qatar@consortme.com</a></p> -->
                            <!-- <p class="hard-text">Web:<a href="www.consortsa.com>" class="hard-link link-mail" target="blank">www.consortsa.com</a></p> -->
                        </div>
                    </div>
                </div>
                <div class="hard-con-inner col-xs-12 col-sm-3" data-id="3">
                    <div class="hard-inner col-xs-12">
                        <div class="location-text-div">
                            <p class="hard-head">INDIA</p>
                        </div>
                        <div class="trade-text">
                            <p class="hard-text">Consort Hardware Private Limited
                                133, New Mangla Puri, M. G. Road New Delhi 110039, India</p>
                        </div>

                        <div class="consort-mail-div">
                            <p class="hard-text">Tel:<a href="tel:+91 9811 619 636" class="hard-link">+91 9811 619 636</a></p>
                            <p class="hard-text">Tel:<a href="tel:+ 011-4562 6900" class="hard-link">+ 011-4562 6900</a></p>
                            <!-- <p class="hard-text">Fax:<a href="fax:+974 4472 6075" class="hard-link">+974 4472 6075</a></p> -->
                            <!-- <p class="hard-text">Email:<a href="mailto:qatar@consortme.com" class="hard-link link-mail">qatar@consortme.com</a></p> -->
                            <!-- <p class="hard-text">Web:<a href="www.consortsa.com>" class="hard-link link-mail" target="blank">www.consortsa.com</a></p> -->
                        </div>
                    </div>
                </div>
                <div class="hard-con-inner col-xs-12 col-sm-3" data-id="2">
                    <div class="hard-inner col-xs-12">
                        <div class="location-text-div">
                            <p class="hard-head">PHILIPPINES </p>
                        </div>
                        <div class="trade-text">
                            <p class="hard-text">Consort Philippines Incorporated
                                Lot 1 Block 15 Oriol Street corner Swallow Drive Monteverde Royal Taytay Rizal 1920, Philippines</p>
                        </div>

                        <div class="consort-mail-div">
                            <p class="hard-text">Tel:<a href="tel:+632 8332 7627" class="hard-link">+632 8332 7627</a></p>
                            <!-- <p class="hard-text">Tel:<a href="tel:+ 011-4562 6900" class="hard-link">+ 011-4562 6900</a></p> -->
                            <!-- <p class="hard-text">Fax:<a href="fax:+974 4472 6075" class="hard-link">+974 4472 6075</a></p> -->
                            <!-- <p class="hard-text">Email:<a href="mailto:qatar@consortme.com" class="hard-link link-mail">qatar@consortme.com</a></p> -->
                            <!-- <p class="hard-text">Web:<a href="www.consortsa.com>" class="hard-link link-mail" target="blank">www.consortsa.com</a></p> -->
                        </div>
                    </div>
                </div>
                <div class="hard-con-inner col-xs-12 col-sm-3" data-id="4">
                    <div class="hard-inner col-xs-12">
                        <div class="location-text-div">
                            <p class="hard-head">PAKISTAN </p>
                        </div>
                        <div class="trade-text">
                            <p class="hard-text">Suite 301/302, Plot 186 C, Lane 3, Zulfiqar &
                                Al Murtaza Commercial, Phase VIII, DHA, Karachi 75500, Sindh, Pakistan.</p>
                        </div>

                        <div class="consort-mail-div">
                            <p class="hard-text">Tel:<a href="tel:+92 (0) 213 584 8614" class="hard-link">+92 (0) 213 584 8614</a></p>
                            <!-- <p class="hard-text">Tel:<a href="tel:+ 011-4562 6900" class="hard-link">+ 011-4562 6900</a></p> -->
                            <!-- <p class="hard-text">Fax:<a href="fax:+974 4472 6075" class="hard-link">+974 4472 6075</a></p> -->
                            <p class="hard-text">Email:<a href="mailto:info.pk@consortme.com" class="hard-link link-mail">info.pk@consortme.com</a></p>
                            <!-- <p class="hard-text">Web:<a href="www.consortsa.com>" class="hard-link link-mail" target="blank">www.consortsa.com</a></p> -->
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<script>
    $(document).on('click', '.iframe_main .img-responsive', function() {
        $('.hard-con-inner').removeClass('active');
        var locationData = $(this).attr('data-id');
        var locationImg = $(this).attr('data-img');
        $('.hard-con-inner[data-id=' + locationData + ']').addClass('active');
        $('.mainMapImg').attr('src', locationImg);
    })
</script>

<section id="form-section">
    <div class="container-fluid site-container">
        <div class="form-section col-xs-12 padding-zero">
            <h1 class="hard-form-heading">get in touch</h1>
            <?php $this->load->view('inc-messages'); ?>
            <form id="contact-form" name="form1" method="post" action="contact-us">
                <div class="form-inner-div col-xs-12">
                    <div class="form-inner-main-div col-xs-12">

                        <div class="simple-div col-xs-12 col-sm-5">
                            <li>
                                <label for="name">First name</label>
                                <input type="text" name="name" class="simple-text" value="<?= set_value('name'); ?>">
                            </li>
                        </div>
                        <div class="simple-div col-xs-12 col-sm-5">
                            <li>
                                <label for="name">Last name</label>
                                <input type="text" name="last_name" class="simple-text" value="<?= set_value('last_name'); ?>">
                            </li>
                        </div>

                        <div class="simple-div col-xs-12 col-sm-5">
                            <li>
                                <label for="email">Email</label>
                                <input type="text" name="email" class="simple-text" value="<?= set_value('email'); ?>">
                            </li>
                        </div>
                        <div class="simple-div col-xs-12 col-sm-5">
                            <li>
                                <label for="Contact Number">Contact number</label>
                                <input type="text" name="phone" class="simple-text" value="<?= set_value('phone'); ?>">
                            </li>
                        </div>
                    </div>

                    <div class="simple-div col-xs-12">
                        <li>
                            <label for="Company">Company</label>
                            <input type="text" name="company" class="simple-text" value="<?= set_value('company'); ?>">
                        </li>
                    </div>

                    <div class="message_div col-xs-12">
                        <li>
                            <label for="Message">Location</label>
                            <input type="text" name="location" class="simple-text" value="<?= set_value('location'); ?>">
                        </li>
                    </div>
                    <div class="contact-cstm-checkbox col-xs-12">
                        <label class="containerContact"> Agree to be contacted by our team
                            <input type="checkbox" value="1" name="contact_by_team" checked="checked">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="join-cstm-checkbox col-xs-12 form-group">
                        <label class="containerContact"> Agree to join our mailing list
                            <input type="checkbox" value="1" name="join_mail_list" checked="checked">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="recaptcha-form-div col-xs-12 form-group">
                        <div class="g-recaptcha cap-width-100" data-sitekey="<?= DWS_RECAPTCHA_SITE_KEY ?>"></div>
                    </div>
                    <div class="send-submit-div col-xs-12">
                        <li>
                            <button type="submit" class="send_div">Submit</button>
                        </li>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<div id="newsLetterPop" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <!-- <h4 class="modal-title" >.</h4> -->
            </div>
            <div class="modal-body">
                <div class="main-pop-up-div">
                    <p class="product-to-view"> loading.. </p>
                </div>
            </div>

        </div>

    </div>
</div>


<script>
    $("#newsletterbtm").submit(function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var inputval = $("#newsletteremail").val();
        var re = /([A-Z0-9a-z_-][^@])+?@[^$#<>?]+?\.[\w]{2,4}/.test(inputval);
        if (!re) {
            $('#error').show();
        } else {
            $('#error').hide();
            $.ajax({
                url: '<?php echo base_url(); ?>newsletter',
                type: "POST",
                data: $("#newsletterbtm").serialize(),
                success: function(data) {
                    var obj = JSON.parse(data);
                    if (obj['content']) {
                        $('#newsletteremail').val('');
                        $('#newsLetterPop .product-to-view').html(obj['content']);
                        $('#newsLetterPop').modal("show");
                        setTimeout(function() {
                            $('#newsLetterPop').modal("hide");
                            $('#newsLetterPop .product-to-view').html('loading..');
                        }, 3000);
                    } else {
                        if (obj['status'] == true) {
                            $('#newsletteremail').val('');
                            $('#newsLetterPop .product-to-view').html("Thankyou for joining our mailing list!");
                            $('#newsLetterPop').modal("show");
                            setTimeout(function() {
                                $('#newsLetterPop').modal("hide");
                                $('#newsLetterPop .product-to-view').html('loading..');
                            }, 3000);
                        } else {
                            alert("Error");
                        }
                    }
                }
            });
        }
    });
</script>