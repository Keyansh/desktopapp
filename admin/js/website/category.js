jQuery(document).ready(function($) {
	function postData(data) {
        $( "#dialog-modal" ).dialog({
            height: 140,
            modal: true
        });
        $.post('catalog/ajax/category/updateSortOrder', data, function(data) {
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

    $( "#pagetree" ).sortable(options);
    $( "#pagetree ul" ).sortable(options);
    $( "#pagetree ul ul" ).sortable(options);
	});
	
   /* function postData(data) {	
        arraied = $('#pagetree').nestedSortable('serialize', {startDepthCount: 0});

        $("#dialog-modal").dialog({
            height: 140,
            modal: true
        });
        $.post('catalog/ajax/category/update', arraied, function(data) {
            $("#dialog-modal").dialog('close');       
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

    $('#pagetree').nestedSortable({
        disableNesting: 'no-nest',
        forcePlaceholderSize: true,
        handle: 'div',
        helper: 'clone',
        items: 'li',
        listType: 'ul',
        opacity: .6,
        placeholder: 'placeholder',
        revert: 250,
        tabSize: 25,
        tolerance: 'pointer',
        toleranceElement: '> div',
        update: function(event, ui) {
            var data = $(this).sortable('serialize');
            postData(data);
        }
    });*/
