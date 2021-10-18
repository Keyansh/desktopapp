jQuery(document).ready(function($) {
  
        
    function postData(data) {
        $("#dialog-modal").dialog({
            height: 140,
            modal: true
        });
        $.post('cms/ajax/block/updateSortOrder', data, function(data) {
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
	
//    $( "#tabs" ).tabs({
//        selected: DWS_TAB
//    });

	
});