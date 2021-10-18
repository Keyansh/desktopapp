<?php if (function_exists('validation_errors') && validation_errors() != '') { ?>
<div class="error_div custom-erros alert alert-danger"><ul>
  <?php echo validation_errors();?>
</ul>
</div>
<?php } ?>

<?php if (isset($INFO) && ($INFO != '')) { ?>
<div class="info_div alert alert-info">
<b>Notice</b>:
<ul>
  <?php echo $INFO;?>
</ul>
</div>
<?php } ?>

<?php if (isset($SUCCESS) && ($SUCCESS != '')) { ?>
<div class="message_div alert alert-success">
<b>Success</b>:
<ul>
  <?php echo $SUCCESS;?>
</ul>
</div>
<?php } ?>

<?php
//e($ERROR);
if (isset($ERROR) && ($ERROR != '')) { ?>
<div class="error_div alert alert-danger">
<b>Error</b>:
<ul>
  <?php echo $ERROR;?>
</ul>
</div>
<?php } ?>

