jQuery(document).ready(function() {
    jQuery('ul.sf-menu').superfish({
        autoArrows: true   //fasle to disable generation of arrow mark-up
    });

    $('.tableWrapper tr').hover(
            function() {
                $(this).addClass('row_hover');
            },
            function() {
                $(this).removeClass('row_hover');
            }
    );
});