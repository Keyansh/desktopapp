<style>
@media (min-width:1500px){
    #add_frm {
	width: 70%;
	margin: auto;
}
}

</style>
<h3 class="title-hero clearfix">
    Add Customer Group
    <a href="profilegroup" class="pull-right btn btn-primary">Manage Customer Group</a>
</h3>
<div id="tabs">
    <div class="panel">
        <div class="panel-body">
            <?php $this->load->view('inc-messages'); ?>
            <form action="profilegroup/add" method="post" enctype="multipart/form-data" name="add_frm" id="add_frm">
                <div class="example-box-wrapper">
                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane fade active in" id="main">
                            <div class="form-group clearfix">
                                <label class="col-sm-2 control-label" style="text-align:center">Name<span class="error">*</span></label>
                                <div class="col-sm-6">
                                    <input name="group" type="text" class="form-control" value="<?php echo set_value('name'); ?>" size="40">
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <div class="col-sm-12" align="center">
                                    Fields marked with <span class="error">*</span> are required.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <p align="center"><input type="submit" name="button" id="button" value="Submit" class="btn btn-lg btn-primary"></p>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        "use strict";
        $('.bootstrap-datepicker').bsdatepicker({
            format: 'dd-mm-yyyy'
        });
    });
</script>