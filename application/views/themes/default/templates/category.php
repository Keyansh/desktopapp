<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
    <head>
        <?php $this->load->view('themes/' . THEME . '/layout/inc-analytic.php'); ?>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <?php
        if (!cms_meta_tags()) {
            ?>
            <title><?php
                if (isset($meta_title)) {
                    echo $meta_title;
                }
                ?></title>
            <meta name="description" content="<?php
            if (isset($meta_description)) {
                echo htmlentities($meta_description);
            }
            ?>" />
            <meta name="keywords" content="<?php
            if ($meta_keyword) {
                echo htmlentities($meta_keyword);
            }
            ?>" />
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
        $this->load->view("themes/" . THEME . "/layout/inc-before-head-close.php");
        ?>
    </head>
    <body>
        <header id="header">
            <?php $this->load->view("themes/" . THEME . "/layout/inc-header.php"); ?>
        </header>
        <?php
        if (isset($contents)) {
            echo $contents;
        }
        ?>
      
    
        <footer id="footer-section">
            <?php $this->load->view('themes/' . THEME . '/layout/inc-footer.php'); ?>
        </footer>
        <?php $this->load->view("themes/" . THEME . "/layout/inc-before-body-close.php"); ?>
    </body>
</html>
