<?php

$DWS_TINYBROWSER_PATH = $this->config->item('UPLOAD_PATH') . 'main_site';
$DWS_TINYBROWSER_URL = 'upload/main_site/useruploads/';
?>
<script type="text/javascript">
	var TEMPLATE = '#page_template';
</script>
<?php

global $DWS_MIN_JS_ARR, $DWS_JS_ARR, $DWS_MIN_CSS_ARR, $DWS_CSS_ARR;

$DWS_JS_ARR[] = 'js/tinymce/tiny_mce.js';
$DWS_JS_ARR[] = "js/tinymce/plugins/tinybrowser/tb_tinymce.js.php?DWS_PATH=$DWS_TINYBROWSER_PATH&DWS_URL=$DWS_TINYBROWSER_URL";
$DWS_JS_ARR[] = 'js/settings-editor.js';
$DWS_MIN_JS_ARR[] = 'js/website/settings.js';
?>
