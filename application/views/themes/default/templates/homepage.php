<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php echo cms_meta_tags(); ?>
    <?php $this->load->view('themes/' . THEME . '/meta/meta_index.php'); ?>
    <base href="<?php echo cms_base_url(); ?>" />
    <?php
    $this->load->view('themes/' . THEME . '/headers/global.php');
    echo cms_head();
    echo cms_css();
    echo cms_js();
    ?>
</head>


<body>
  
    <?php 
    $getDetails = '';
    $inner['projectsTypes'] = $projectsTypes;
    $inner['getDetails'] = $getDetails;
    $this->load->view('themes/' . THEME . '/layout/inc-mainview', $inner); ?>
</body>

</html>