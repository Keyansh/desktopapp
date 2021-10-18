<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script type="text/javascript">
    var DWS_BASE_URL = '<?php echo base_url(); ?>';
</script>
<?php $siteColor = getsitecolor();
$mainColor = json_decode($siteColor['config_json']);

?>
<style>
    :root {
        --blue: <?= $mainColor->color ?>;
    }
</style>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<?php
global $DWS_MIN_JS_ARR, $DWS_MIN_CSS_ARR, $DWS_JS_ARR, $DWS_CSS_ARR;

$DWS_MIN_CSS_ARR[] = 'css/bootstrap.min.css';

// $DWS_MIN_CSS_ARR[] = 'css/slider/owl.theme.default.css';
$DWS_MIN_CSS_ARR[] = 'css/styleForm.css';
// $DWS_MIN_CSS_ARR[] = 'css/font-awesome.min.css';
// $DWS_MIN_CSS_ARR[] = 'css/font-awesome.css';
// $DWS_MIN_CSS_ARR[] = 'css/fancybox.css';
// $DWS_MIN_CSS_ARR[] = 'css/style_b.css';

// $DWS_MIN_CSS_ARR[] = 'css/main.css';
// $DWS_MIN_CSS_ARR[] = 'css/style.css';
// $DWS_MIN_CSS_ARR[] = 'css/default_theme.css';
// $DWS_MIN_CSS_ARR[] = 'css/my_theme.css';
// $DWS_MIN_CSS_ARR[] = 'css/default_css.css';
// $DWS_MIN_CSS_ARR[] = 'css/responsive.css';
// $DWS_MIN_CSS_ARR[] = 'css/responsive1.css';

// $DWS_MIN_JS_ARR[] = 'js/jquery.js';
// $DWS_MIN_JS_ARR[] = 'js/bootstrap.js';
// $DWS_MIN_JS_ARR[] = 'js/bootstrap-clockpicker.min.js';
// $DWS_MIN_JS_ARR[] = 'js/jqueryuiblock.js';
// $DWS_MIN_JS_ARR[] = 'js/jquery.fancybox.min.js';
// $DWS_MIN_JS_ARR[] = 'js/grid-gallery.min.js';
// $DWS_MIN_JS_ARR[] = 'js/owl.js';
// $DWS_MIN_JS_ARR[] = 'js/jquery.lazy.min.js';
// $DWS_MIN_JS_ARR[] = 'js/main.js';

//$DWS_MIN_JS_ARR[] = 'js/jquery-min.js';
?>