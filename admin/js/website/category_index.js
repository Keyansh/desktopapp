jQuery(document).ready(function($) {
    function postData(data) {
        $("#dialog-modal").dialog({
            height: 140,
            modal: true
        });
        $.post('catalog/ajax/category/updateSortOrder', data, function(data) {
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

    $("#pagetree").sortable(options);
    $("#pagetree ul").sortable(options);
    $("#pagetree ul ul").sortable(options);

});

