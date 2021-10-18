jQuery(document).ready(function ($) {
    $('#childPro').hide();
    $('#min-bundle-qty').hide();
    $('#attrHi').hide();
    function loadDynamicTabs() {
        $('#loading').show();
        $('.dynamic').remove();
        $("#tabs").tabs("refresh");
        //$('#tabs').block();

        var checked = []
        $("input[name='category_id[]']:checked").each(function ()
        {
            checked.push(parseInt($(this).val()));
        });

       /* $.post(DWS_BASE_URL + 'catalog/ajax/attribute_tab/add', {checked: checked, current_url: ''}, function (data) {
            if (data.status == 1) {
                $('#tabs-nav').append(data.tabs);
                $("#tabs").append(data.tab_content);
                $(".cat_view").html(data.category);
                $("#tabs").tabs("refresh");
            }
            $('#loading').hide();
            //$('#tabs').unblock();
        }, 'json');*/
        return false;
    }


    loadDynamicTabs();
    //#payment_from :input:not('.exclude')
    $('#addcatform').on('click', '.chk_product', function () {
        loadDynamicTabs();
    });
    /*$('.chk_product').click(function() {
     alert("Here");
     loadDynamicTabs();
     })*/


    function postData(data) {
        $("#dialog-modal").dialog({
            height: 140,
            modal: true
        });
        $.post('catalog/ajax/product/updateSortOrder', data, function (data) {
            $("#dialog-modal").dialog('close');

        });
    }

    var options = {
        containment: 'parent',
        opacity: 0.6,
        update: function (event, ui) {

            var data = $(this).sortable('serialize');
            postData(data);
        }
    };

    $("#menutree").sortable(options);
    //$( "#menutree ul" ).sortable(options);
    //$( "#menutree ul ul" ).sortable(options);
    $('.remove-image').click(function (elm) {
        // console.log(this);
        var cnf = confirm('Do you really want to remove this image?');
        if (!cnf)
            return;
        var img_id = $(this).attr('image-id'),
                url = base_url + 'catalog/ajax/images/remove'
                ;
        $.post(url, {img_id: img_id}, function (response) {
            response = JSON.parse(response);
            element = $('#product_image' + response.image);
            if (response.status) {
                $(element).parent().prev().remove();
                $(element).parent().remove();
            }
        });
    });
    
    $('.videoRemover').click(function (elm) {
        // console.log(this);
        var cnf = confirm('Do you really want to remove this video?');
        if (!cnf)
            return;
        var elemThis = $(this);
        var video_id = $(this).attr('data-video-id'),
            url = base_url + 'catalog/ajax/images/removeVideo';
        $.post(url, {video_id: video_id}, function (response) {
            response = JSON.parse(response);
            if (response.status) {
                elemThis.parents('li').remove();
            }
        });
    });

    $('.proType').on('change', function () {
        var typ = $(this).val();
        if (typ == 'standard') {
            $('#childPro').hide();
            $('#attrHi').show();
            $('#min-bundle-qty').hide();
        } else if ((typ == 'config') || (typ == 'combo')) {
            $('#childPro').show();
            $('#attrHi').hide();
            $('#min-bundle-qty').hide();
        } else if (typ == 'bundle') {
            $('#childPro').show();
            $('#attrHi').hide();
            $('#min-bundle-qty').show();
        }
    });

    var typid = $('.proType').val();
    if ((typid == 'config') || (typid == 'combo') || (typid == 'bundle')) {
        $('#attrHi').hide();
        $('#childPro').show();
    } else {
        $('#attrHi').show();

    }
});
