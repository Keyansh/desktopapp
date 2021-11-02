<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php
    if (isset($meta_title)) {
    ?>
        <title><?php echo $meta_title; ?></title>
        <meta name="description" content="<?php echo $meta_title; ?>" />
    <?php
    } else {
        echo cms_meta_tags();
    }
    ?>
    <?php $this->load->view("themes/" . THEME . "/meta/meta_index.php"); ?>
    <base href="<?php echo cms_base_url(); ?>" />
    <?php
    $this->load->view("themes/" . THEME . "/headers/global.php");
    echo cms_head();
    echo cms_css();
    echo cms_js();
    ?>
</head>

<body>

    <div class="wrapper">
        
        <?php
        if (isset($contents)) {
            echo $contents;
        }
        ?>
      

    </div>
</body>

</html>