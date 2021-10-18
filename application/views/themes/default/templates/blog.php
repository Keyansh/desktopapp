<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">

<head>
    <?php $this->load->view('themes/' . THEME . '/layout/inc-analytic.php'); ?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php
    if (isset($blog['browser_title'])) {
    ?>
        <title><?php echo $blog['browser_title']; ?></title>
        <?php if ($blog['meta_description']) { ?>
            <meta name="description" content="<?php echo htmlentities($blog['meta_description']); ?>" />
        <?php } ?>
        <?php if ($blog['meta_keywords']) { ?>
            <meta name="keywords" content="<?php echo htmlentities($blog['meta_keywords']); ?>" />
    <?php
        }
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
    $this->load->view("themes/" . THEME . "/layout/inc-before-head-close.php");
    ?>
</head>

<body>
    <?php $testimonialbanners = testimonialbanner(); ?>

    <header id="header">
        <?php $this->load->view("themes/" . THEME . "/layout/inc-header.php"); ?>
    </header>
    <div class="wapper">
        <?php
        if (isset($contents)) {
            echo $contents;
        }
        ?>
    </div>


    <footer id="footer-section">
        <?php $this->load->view('themes/' . THEME . '/layout/inc-footer.php'); ?>
    </footer>

    <?php $this->load->view("themes/" . THEME . "/layout/inc-before-body-close.php"); ?>
</body>

</html>