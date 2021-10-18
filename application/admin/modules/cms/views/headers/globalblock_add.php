<script type="text/javascript">
var wysiwyg_elements = 'block_contents';
var TEMPLATE = '#block_template';
</script>
<?php
	global $DWS_MIN_JS_ARR, $DWS_JS_ARR, $DWS_MIN_CSS_ARR, $DWS_CSS_ARR;

	$DWS_MIN_CSS_ARR[] = 'css/page.css';
   
	$DWS_JS_ARR[] = 'js/tinymce/tiny_mce.js';
	$DWS_JS_ARR[] = 'js/tinymce/plugins/tinybrowser/tb_tinymce.js.php';
        $DWS_MIN_JS_ARR[] = 'js/site-editor.js';

	$DWS_JS_ARR[] = 'js/codemirror/lib/codemirror.js';
	$DWS_JS_ARR[] = 'js/codemirror/lib/util/formatting.js';
	$DWS_JS_ARR[] = 'js/codemirror/mode/css/css.js';
	$DWS_JS_ARR[] = 'js/codemirror/mode/xml/xml.js';
	$DWS_JS_ARR[] = 'js/codemirror/mode/javascript/javascript.js';
	$DWS_JS_ARR[] = 'js/codemirror/mode/htmlmixed/htmlmixed.js';
	$DWS_CSS_ARR[] = 'js/codemirror/lib/codemirror.css';

	//$DWS_JS_ARR[] = 'js/yetii.js';
	$DWS_JS_ARR[] = 'js/site-editor.js';
	//$DWS_JS_ARR[] = 'js/jstree/jquery.jstree.js';
	//$DWS_JS_ARR[] = 'js/site-pagetree.js';
	$DWS_JS_ARR[] = 'js/template.js';

?>
