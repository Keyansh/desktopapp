function tier_model(elm) {
    var tier_quantity = $(elm).attr('tier_model_attr');
    $('#tier-model').modal('show');
    $('.tier_quantity').html(tier_quantity + '+');
    $('.tier_qty_val').val(tier_quantity);
    $(document).on("click", "#tier-submit-btn", function () {
//        var pattern2 = /^(?=.*[0-9])[ ()0-9]+$/;
        var tier_status = true;
        if ($('.tier-form-name').val() == '') {
            tier_status = false;
            $('.tier-form-name').css('border', '1px solid red');
        } else {
            $('.tier-form-name').css('border', '1px solid');
        }
        if ($('.tier-form-message').val() == '') {
            tier_status = false;
            $('.tier-form-message').css('border', '1px solid red');
        } else {
            $('.tier-form-message').css('border', '1px solid');
        }
        var phone = $('.tier-phone').val();
        var number = phone.replace(/ /g, '');
        if ($.isNumeric(number)) {
            $('.tier-phone').css('border', '1px solid');
        } else {
            tier_status = false;
            $('.tier-phone').css('border', '1px solid red');
        }
        var email = $('#tier-email').val();
        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (email.match(filter)) {
            $('#tier-email').css('border', '1px solid');
        } else {
            tier_status = false;
            $('#tier-email').css('border', '1px solid red');
        }
        console.log(tier_status);
        if (tier_status) {
            $.post(DWS_BASE_URL + "catalog/ajax/product/tier_email", {data: $('#tier-Form').serializeArray()}, function (response) {
                var obj = JSON.parse(response);
                if (obj.status) {
                    $('.status-msg').html('Enquiry successfully submitted').css('color', 'green');
                    document.getElementById("tier-Form").reset();
                    setTimeout(function () {
                        $('#tier-model').modal('hide');
                        $('.status-msg').html('');
                    }, 3000);
                } else {
                    $('.status-msg').html('Failed to submit').css('color', 'red');
                }
            });
        }
    });
}

function main_image() {
    var img_src = $('.desoslide-wrapper > img').attr('src');
    $('.sorce-image').attr('href', img_src);
//    $('#slideshow3_thumbs > li > a').each(function () {
//        var href = $(this).attr('href');
//        if (img_src != href) {
//            $('.append-content').append("<a onclick='main_image()' href='" + href + "' data-fancybox='gallery' class='pro-detail-img'></a>");
//        }
//    });
//    var count1 = $('.append-content > a').length;
//    var count2 = $('#slideshow3_thumbs > li').length;
//    console.log(count1);
//    console.log(count2);
//    if (count1 != count2) {
//        $('.append-content').html('');
//        $('.append-content').html("<a onclick='main_image()' href='" + img_src + "' data-fancybox='gallery' class='pro-detail-img sorce-image'></a>");
//        $('#slideshow3_thumbs > li > a').each(function () {
//            var href = $(this).attr('href');
//            if (img_src != href) {
//                $('.append-content').append("<a onclick='main_image()' href='" + href + "' data-fancybox='gallery' class='pro-detail-img'></a>");
//            }
//        });
//    }
}