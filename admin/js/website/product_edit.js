jQuery(document).ready(function($) {
    function loadDynamicTabs() {
        $('#loading').show();
        $('.dynamic').remove();
        $("#tabs").tabs("refresh");
//        $('#tabs').block();

        var product_id = $('#product_id').val();

        var checked = []
        $("input[name='category_id[]']:checked").each(function()
        {
            checked.push(parseInt($(this).val()));
        });

        if (jQuery.isEmptyObject(checked)) {
            $('#tabs').unblock();
        }

        /*$.post(DWS_BASE_URL + 'catalog/ajax/attribute_tab/index/' + product_id, {checked: checked, current_url: DWS_TAB_CURRENT_URL}, function(data) {
            if (data.status == 1) {
                $('#tabs-nav').append(data.tabs);
                $("#tabs").append(data.tab_content);
                $(".cat_view").html(data.category);
                $("#tabs").tabs("refresh");
            }
            $('#loading').hide();
            $('#tabs').unblock();
        }, 'json');*/
        return false;
    }



    loadDynamicTabs();
    //#payment_from :input:not('.exclude')
    $('#addcatform').on('click', '.chk_product', function() {
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
        $.post('catalog/ajax/product/updateSortOrder', data, function(data) {
            $("#dialog-modal").dialog('close');

        });
    }

    var options = {
        containment: 'parent',
        opacity: 0.6,
        update: function(event, ui) {

            var data = $(this).sortable('serialize');
            postData(data);
        }
    };

    $("#menutree").sortable(options);
    //$( "#menutree ul" ).sortable(options);
    //$( "#menutree ul ul" ).sortable(options);
});
