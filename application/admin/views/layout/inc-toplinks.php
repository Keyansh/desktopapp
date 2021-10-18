<div id="mobile-navigation">
    <button id="nav-toggle" class="collapsed" data-toggle="collapse" data-target="#page-sidebar"><span></span></button>
    <a href="<?= base_url(); ?>" class="logo-content-small"></a>
</div>
<div id="header-logo" class="logo-bg">
    <a href="<?= base_url(); ?>" class="logo-content-big">
        <img src="<?= $this->config->item('CONTACT_US_FILE_URL') . DWS_LOGO ?>" alt="logo" class="img-responsive">
        <!--                            Monarch <i>UI</i>
        <span>The perfect solution for user interfaces</span>-->
    </a>
    <a href="<?= base_url(); ?>" class="logo-content-small">
        <img src="<?= $this->config->item('CONTACT_US_FILE_URL') . DWS_LOGO ?>" alt="logo" class="img-responsive">
        <!--                            Monarch <i>UI</i>
        <span>The perfect solution for user interfaces</span>-->
    </a>
    <a id="close-sidebar" href="#" title="Close sidebar">
        <i class="glyph-icon icon-angle-left"></i>
    </a>
</div>
<div id="header-nav-left"></div>

<div id="header-nav-right">
    <div class="dropdown" id="dashnav-btn">
        <?php if ($CI->getUser()) { ?>
            <a href="#" data-toggle="dropdown" data-placement="bottom" class="popover-button-header tooltip-button">
                <i class="glyph-icon icon-linecons-user"></i>
            </a>
            <div class="dropdown-menu float-right text-right">
                <div class="box-sm">
                    <div class="pad5T pad5B pad10L pad10R dashboard-buttons clearfix">
                        <a href="<?php echo base_url(); ?>user/dashboard/" class="btn vertical-button hover-blue-alt" title="">
                            <?php echo $CI->getUserFullName(); ?>
                        </a>
                        <a href="<?php echo base_url(); ?>user/dashboard/logout/" class="btn vertical-button hover-blue-alt" title="">
                            Logout
                        </a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>