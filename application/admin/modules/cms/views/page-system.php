<?php

global $DWS_MIN_JS_ARR, $DWS_JS_ARR, $DWS_MIN_CSS_ARR;
$DWS_MIN_CSS_ARR[] = 'css/pagetree.css';

$DWS_JS_ARR[] = 'js/website/page-v2.js';
?>

<h3 class="title-hero clearfix">
    Manage Pages
    <a href="cms/page/add" class="pull-right btn btn-primary">Add Page</a>
</h3>
<?php
$this->load->view('inc-messages');
if (count($pages) == 0) {
    $this->load->view('inc-norecords');
    echo "</div>";
    return;
}
?>

<div class="panel">
    <div class="panel-body">
        <div class="example-box-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <?php echo $pagetree; ?>
                </div>
            </div>
        </div>
    </div>
</div>
