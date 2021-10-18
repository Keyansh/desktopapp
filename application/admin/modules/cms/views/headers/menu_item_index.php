<script>
     var DWS_MENU_ID =  <?php echo $menu_detail['menu_id'];?>
</script>
<?php
	global $DWS_MIN_JS_ARR, $DWS_JS_ARR, $DWS_MIN_CSS_ARR;

    $DWS_MIN_CSS_ARR[] = 'css/menutree.css';

	$DWS_JS_ARR[] = 'js/lib/jquery.ui.nestedSortable.js';
	$DWS_JS_ARR[] = 'js/website/menu.js';

?>
