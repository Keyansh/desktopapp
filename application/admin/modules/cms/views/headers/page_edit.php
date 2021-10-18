<?php $this->load->view('headers/page_add'); ?>
<script type="text/javascript">
    DWS_TAB = <?php echo $tab; ?>;
    var DWS_PAGE_ID = <?php echo $page_details['page_id']; ?>
</script>
<?php
global $DWS_MIN_JS_ARR, $DWS_JS_ARR, $DWS_MIN_CSS_ARR, $DWS_CSS_ARR;
$DWS_MIN_CSS_ARR[] = 'css/menutree.css';
$DWS_CSS_ARR[] = 'js/colorbox/skin_4/colorbox.css';

$DWS_JS_ARR[] = 'js/lib/jquery.cookie.js';
$DWS_JS_ARR[] = 'js/lib/jquery.ui.nestedSortable.js';
$DWS_JS_ARR[] = 'js/colorbox/jquery.colorbox.js';
$DWS_JS_ARR[] = 'js/website/widgets.js';
$DWS_JS_ARR[] = 'js/website/module_overlay.js';
?>