jQuery(document).ready(function($) {
	$('.message_div').hide();
	$("#main_test_page, #control_page, #test_pages, #pages_list").sortable({
		connectWith: ".connectedSortable",
	}).disableSelection();

	$('#submit').click(function() {
		var data = [];
		$('#test_pages li').each(function() {
			data.push($(this).attr("id"));
		});
		
		$.post('split_test/ajax/split_test/updateTestPages', {'test_id': $('#test_id').val(), 'page_id': data, 'main_test_page_id':$('#main_test_page li').attr("id"), 'control_page_id':$('#control_page li').attr("id")}, function(data) {
			$('.message_div').show();
			$('.message_div .message').html('<b>Success</b>:<ul>Pages Updated Successfully.</ul>');
		});
		
		
	});
	
	 $( "#main_test_page" ).on( "sortreceive", function(event, ui) {
        if($("#main_test_page li").length > 1){
            $(ui.sender).sortable('cancel');
        }		
    });
	
	$( "#control_page" ).on( "sortreceive", function(event, ui) {
        if($("#control_page li").length > 1){
            $(ui.sender).sortable('cancel');
        }
    });
});