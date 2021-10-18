<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<?php echo $this->cms->getMeta(); ?>
<base href="<?php echo $this->cms->baseURL();?>" />
<?php
$this->load->view("headers/global");
echo $this->cms->getMetaIncludes();
echo $this->cms->getCSS();
echo $this->cms->getJS();
?>
<?php echo $this->cms->getCMSMeta(); ?>
<?php $this->load->view('layout/inc-before-head-close');?>
</head>

<body>
<!-- Main Page Structure -->
<div id="wrap">
  <!-- Top Right Links -->
  <?php if($this->memberauth->checkAuth()) {?>
  <ul class="toplinks">
    <?php $this->load->view('layout/inc-toplinks'); ?>
  </ul>
  <?php } ?>
  <!-- Control Panel Logo -->
  <div class="pageTop">
    <?php $this->load->view('layout/inc-header'); ?>
  </div>
  
  <div id="topmenu">
  <?php $this->load->view('layout/inc-topmenu'); ?>
  </div>
  
  <div class="clearfix"></div>
  <!-- Main Page Wrap -->
  <div id="page">
    <div class="pageContent">
      <div class="innerLeft">
        <?php echo  $content;?>
        <div class="clearfix"></div>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
  <div class="footer">
    <?php $this->load->view('layout/inc-footer');?>
  </div>
</div>

<?php $this->load->view('layout/inc-before-body-close');?>

</body>
</html>
