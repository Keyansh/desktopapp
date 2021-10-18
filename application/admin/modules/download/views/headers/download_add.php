<script type="text/javascript">
    var wysiwyg_elements = 'contents';
    var wysiwyg_theme = 'advanced';
</script>
<?php
global $DWS_MIN_JS_ARR, $DWS_JS_ARR, $DWS_MIN_CSS_ARR;

$DWS_MIN_CSS_ARR[] = 'css/page.css';

$DWS_JS_ARR[] = 'js/tinymce/tiny_mce.js';
$DWS_JS_ARR[] = 'js/tinymce/plugins/tinybrowser/tb_tinymce.js.php';
$DWS_JS_ARR[] = 'js/yetii.js';
$DWS_JS_ARR[] = 'js/site-editor.js';

$DWS_MIN_CSS_ARR[] = 'js/datepicker/css/smoothness/jquery-ui-1.8.15.custom.css';
$DWS_JS_ARR[] = 'js/datepicker/js/jquery-ui-1.8.15.custom.min.js';
$DWS_JS_ARR[] = 'js/news.js';
$DWS_JS_ARR[] = 'js/page.js';
?>

<style>
    .containerradio {
        display: inline-block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 12px;
        cursor: pointer;
        font-size: 14px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Hide the browser's default radio button */
    .containerradio input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    /* Create a custom radio button */
    .checkmarkradio {
        position: absolute;
        top: 50%;
        left: 0;
        height: 25px;
        width: 25px;
        background-color: #eee;
        border-radius: 50%;
        transform: translateY(-50%);
        border: 1px solid #263388;
    }

    /* On mouse-over, add a grey background color */
    .containerradio:hover input~.checkmarkradio {
        background-color: #ccc;
    }

    /* When the radio button is checked, add a blue background */
    .containerradio input:checked~.checkmarkradio {
        background-color: #263388;
    }

    /* Create the indicator (the dot/circle - hidden when not checked) */
    .checkmarkradio:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the indicator (dot/circle) when checked */
    .containerradio input:checked~.checkmarkradio:after {
        display: block;
    }

    /* Style the indicator (dot/circle) */

    /* Style the indicator (dot/circle) */
    .containerradio .checkmarkradio::after {
        top: 50%;
        left: 50%;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: white;
        transform: translate(-50%, -50%);
    }
</style>