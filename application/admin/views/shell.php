<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <?php echo cms_meta_tags(); ?>
        <base href="<?php echo cms_base_url(); ?>" />
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?= base_url(); ?>assets/images/icons/apple-touch-icon-144-precomposed.png"/>
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?= base_url(); ?>assets/images/icons/apple-touch-icon-114-precomposed.png"/>
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?= base_url(); ?>assets/images/icons/apple-touch-icon-72-precomposed.png"/>
        <link rel="apple-touch-icon-precomposed" href="<?= base_url(); ?>assets/images/icons/apple-touch-icon-57-precomposed.png"/>
        <link rel="shortcut icon" href="<?= $this->config->item('CONTACT_US_FILE_URL') . DWS_FAV_ICON ?>"/>

        <?php
        $this->load->view("headers/global");
        echo cms_head();
        echo cms_css();
        echo cms_js();
        ?>
        <?php $this->load->view('layout/inc-before-head-close'); ?>

        <style>
            .spinner{margin:0;width:70px;height:18px;margin:-35px 0 0 -9px;position:absolute;top:50%;left:50%;text-align:center}.spinner > div{width:18px;height:18px;background-color:#333;border-radius:100%;display:inline-block;-webkit-animation:bouncedelay 1.4s infinite ease-in-out;animation:bouncedelay 1.4s infinite ease-in-out;-webkit-animation-fill-mode:both;animation-fill-mode:both}.spinner .bounce1{-webkit-animation-delay:-.32s;animation-delay:-.32s}.spinner .bounce2{-webkit-animation-delay:-.16s;animation-delay:-.16s}@-webkit-keyframes bouncedelay{0%,80%,100%{-webkit-transform:scale(0.0)}40%{-webkit-transform:scale(1.0)}}@keyframes bouncedelay{0%,80%,100%{transform:scale(0.0);-webkit-transform:scale(0.0)}40%{transform:scale(1.0);-webkit-transform:scale(1.0)}}
            /*            .background_image{
                            background-image: url('../images/customer-background.png') !important;
                            background-repeat:no-repeat !important;
                        }*/
        </style>

    </head>
    <body>
        <script type="text/javascript">
            var base_url = '<?php echo base_url(); ?>';
        </script>
        <div id="sb-site">
            <div id="loading">
                <div class="spinner">
                    <div class="bounce1"></div>
                    <div class="bounce2"></div>
                    <div class="bounce3"></div>
                </div>
            </div>
            <div id="page-wrapper">
                <div id="page-header" class="bg-gradient-9">
                    <?php $this->load->view('layout/inc-toplinks'); ?>
                </div>
                <div id="page-sidebar">
                    <?php $this->load->view('layout/inc-leftmenu'); ?>
                </div>
                <div id="page-content-wrapper">
                    <div id="page-content">
                        <div class="container-fluid">
                            <?php echo $content; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('layout/inc-before-body-close'); ?>
        <?= cms_footer(); ?>

    </body>
</html>
