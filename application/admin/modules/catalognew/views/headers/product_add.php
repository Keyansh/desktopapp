<script type="text/javascript">
    var wysiwyg_elements = 'description,product_specifications,payment_delivery_options, dimensions, tags, brief_description,delivery_information,technical_specification,packaging';
    var wysiwyg_theme = 'advanced';
</script>

<?php
global $DWS_MIN_JS_ARR, $DWS_JS_ARR, $DWS_MIN_CSS_ARR;
$DWS_MIN_CSS_ARR[] = 'css/page.css';
$DWS_JS_ARR[] = 'js/tinymce/tiny_mce.js';
$DWS_JS_ARR[] = 'js/tinymce/plugins/tinybrowser/tb_tinymce.js.php';
$DWS_JS_ARR[] = 'js/lib/site-editor.js';
$DWS_MIN_JS_ARR[] = 'js/tab.js';
$DWS_MIN_JS_ARR[] = 'js/website/product.js';
/* $DWS_JS_ARR[] = 'assets/widgets/datepicker/datepicker.js'; */
?>
<style>
    .title-attribute {
        font-size: 25px;
        border-bottom: 1px solid rgba(0, 0, 0,0.4);
        padding: 0 !important;
        margin-bottom: 13px;
    }

    .attribute-main-div label.custom-check {
        width: auto;
        min-width: 200px;
        padding: 0 10px;
    }

    .title-attribute {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>