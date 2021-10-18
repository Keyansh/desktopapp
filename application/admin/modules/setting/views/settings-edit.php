<h3 class="title-hero clearfix">
    Edit Config Settings
</h3>


<div class="panel">
    <div class="panel-body">
        <div class="example-box-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <?php $this->load->view('inc-messages'); ?>
                    <div style="float: left; width: 100%">
                        <div id="tabs">
                            <ul class="nav" id="tabs-nav">
                                <?php
                                $i = 0;
                                foreach ($groups as $group) {
                                    $i++;
                                    ?>
                                    <?php if (isset($settings[$group['config_group_id']])) { ?>
                                        <li><a href="<?php echo current_url(); ?>#tabs-<?php echo $i; ?>"><?php echo $group['config_group']; ?></a></li>
                                    <?php } ?>
                                <?php } ?>
                            </ul>
                            <form action="setting/settings/index/<?php echo $group_id; ?>" method="post" enctype="multipart/form-data" name="addcatform" id="addcatform">
                                <?php
                                $i = 0;
                                foreach ($groups as $group) {
                                    $i++;
                                    if (isset($settings[$group['config_group_id']])) {
                                        ?>
                                        <div id="tabs-<?php echo $i; ?>" class="tab">
                                            <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="formtable">
                                                <?php
                                                foreach ($settings[$group['config_group_id']] as $row) {

                                                    $key = $row['config_key'];
                                                    $label = $row['config_label'];
                                                    $val = $row['config_value'];
                                                    $field_type = $row['config_field_type'];
                                                    $field_options = $row['config_field_options'];
                                                    $comment = $row['config_comments'];
                                                    ?>
                                                    <div class="form-group clearfix">
                                                        <label class="col-sm-2 control-label"><?php echo $label; ?></label>
                                                        <div class="col-sm-7">
                                                            <?php include("settings/$field_type.php"); ?>
                                                        </div>
                                                    </div>
                                                <?php } ?> 
                                            </table>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label"></label>
                                    <div class="col-sm-10 text-center">
                                        <input type="submit" name="button" class="btn btn-primary" id="button" value="Submit">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>