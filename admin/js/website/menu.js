jQuery(document).ready(function($) {

    function postData(data) {
		//arraied = $('#menutree').nestedSortable('serialize', {startDepthCount: 0});

		$( "#dialog-modal" ).dialog({
			height: 140,
			modal: true
		});

		$.post('cms/ajax/menuitem/updateSortOrder', data, function(data) {
			$( "#dialog-modal" ).dialog('close');
            //alert(data);
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

	$( "#menutree" ).sortable(options);
	//$( "#menutree ul" ).sortable(options);
	//$( "#menutree ul ul" ).sortable(options);
});