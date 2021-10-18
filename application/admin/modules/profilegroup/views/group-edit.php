<style>
@media (min-width:1500px){
    #add_frm {
	width: 70%;
	margin: auto;
}
}

</style>
<h3 class="title-hero clearfix">
    Update Customer Group
    <a href="profilegroup" class="pull-right btn btn-primary">Manage Customer Group</a>
</h3>
<div id="tabs" class="">
    <div class="panel">
        <div class="panel-body">
            <?php $this->load->view('inc-messages'); ?>
            <form action="profilegroup/edit/<?php echo $profile_group['id']; ?>" method="post" enctype="multipart/form-data" name="add_frm" id="add_frm">
                <div class="example-box-wrapper">
                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane fade active in" id="main">
                            <div class="form-group clearfix">
                                <label class="col-sm-2 control-label" style="text-align:center">Name</label>
                                <div class="col-sm-6">
                                    <input name="group" type="text" class="form-control" value="<?php echo set_value('group', $profile_group['group']); ?>" size="40">
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <div class="col-sm-12" align="center">
                                    <input name="image_v" type="hidden" id="image_v" value="1">
                                    Fields marked with <span class="error">*</span> are required.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <p align="center"><input type="submit" name="button" id="button" value="Update" class="btn btn-lg btn-primary"></p>
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
<script type="text/javascript">
    $(document).ready(function () {
        $('#export-csv-btn').click(function () {
            var from_date = $('#from_date').val();
            var till_date = $('#till_date').val();

            $.post('order/export_orders_csv',
                    {
                        from_date: from_date,
                        till_date: till_date
                    },
                    function (data, status) {
                        if (data == 'no-data') {
                            $('#csv-download-link').hide(100, function () {
                                alert("No orders exist for given dates !");
                            });
                        } else {
                            data = JSON.parse(data);
                            if (data.report_file) {
                                $('#csv-download-link').attr('href', data.report_file).show();
                            }
                        }
                    });
        });
    });
</script>
