<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/widgets/datatable/datatable.css">
<script type="text/javascript" src="<?= base_url(); ?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable-tabletools.js"></script>

<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>js/bootstrap-datetimepicker.css">
<script src="<?= base_url(); ?>js/moment-with-locales.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>js/bootstrap-datetimepicker.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#example').DataTable({
//            processing: true,
//            serverSide: true,
//            ajax: 'order/server_side_dt/jsonOrders',
            autoWidth: true,
            bSort: false,
            columnDefs: [
                {
                    targets: [0, 1, 2, 3, 4],
                    orderable: false
                },
//                {
//                    'targets': [5],
//                    'className': 'dt-center',
//                    'render': function (data, type, full, meta) {
////                                return data;
//                        var classD = data == 1 ? 'icon-linecons-eye green-color' : 'icon-eye-slash red-color';
//                        return '<div class="page_item_options"><a><i pro_id=' + full[0] + ' class="edProduct glyph-icon ' + classD + '"></i></a></div>';
//                    }
//                },
//                {
//                    'targets': [6],
//                    'className': 'dt-center',
//                    'render': function (data, type, full, meta) {
////                                return data;
//                        return '<div class="page_item_options"><a href="order/edit/' + full[0] + '" class=""><i class="glyph-icon icon-linecons-pencil"></i></a> <a href="order/delete/' + full[0] + '" class=""><i class="glyph-icon icon-linecons-trash red-color"></i></a></div>';
//                    }
//                },
            ],
            pageLength: 20
        });

    });</script>
<div class="row">
    <div class="col-md-6">
        <h2>Manage Abandon Orders</h2>
    </div>    
</div>
<hr />
<?php
if(isset($orders)) {
    if (count($orders) == 0) {
        $this->load->view('inc-norecords');
        return;
    }
}
?>
<?php $this->load->view('inc-messages'); ?>
<table id="example" class="display" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>User</th>
            <th>Order Time</th>
            <th>Email</th>
            <th>Contact</th>
            <!--<th>Order Total</th>-->                      
            <th width="10%">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if(isset($orders)) {
            foreach ($orders as $order) { ?>
                <tr>
                    <td><?= $order['first_name'] . ' ' . $order['last_name']; ?></td>
                    <td><?= date('jS F, Y', $order['order_time']); ?></td>
                    <td><?= $order['email']; ?></td>
                    <td><?= $order['phone']; ?></td>
                    <!--<td><?//= DWS_CURRENCY_SYMBOL . $order['order_total']; ?></td>-->
                    <td width="10%">
                        <a oid="<?= $order['order_id']; ?>" class='setCrone tooltip-button' data-toggle='tooltip' data-placement='top' title='Email'><i class="glyph-icon icon-envelope-o"></i></a>&nbsp;&nbsp;
                        <a href="order/viewAbandonOrder/<?= $order['order_id']; ?>" class='tooltip-button' data-toggle='tooltip' data-placement='top' title='View'><i class="glyph-icon icon-eye green-color"></i></a>&nbsp;&nbsp;
                        <a href="order/deleteAbandonOrder/<?= $order['order_id']; ?>" class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Delete' onclick="return confirm('Are you sure you want to delete this Order?');"><i class="glyph-icon icon-trash-o red-color"></i></a>
                    </td>
                </tr>
            <?php }
        } ?>
    </tbody>
    <tfoot>
        <tr>
            <th>User</th>
            <th>Order Time</th>
            <th>Email</th>
            <th>Contact</th>
            <!--<th>Order Total</th>-->                      
            <th width="10%">Action</th>
        </tr>
    </tfoot>
</table>

<script type="text/javascript">
    $(document).ready(function () {
        $('.setCrone').on('click', function () {
            var oid = $(this).attr('oid');
            $('#aoid').val(oid);
            $('#cronModalbtn').trigger('click');
        });
        $(function () {
            $('#datetimepicker1').datetimepicker({
                minDate: new Date(),
                defaultDate: new Date(),
                format: 'YYYY-MM-DD HH:mm'
            });
        });
        $('#croneSend').on('click', function () {
            $(".error").hide();
            $.post("order/croneSave", $('#emailNotification').serialize(), function (data) {
                if (data.status == 'error') {
                    $(data.msg.slice(0, -1)).show();
                    return false;
                } else {
                    $("h4.modal-title").html(data.html).css('color', 'green');
                    $("#emailNotification")[0].reset();
                }
            }, "json");
        });
    });
</script>
<button type="button" id="cronModalbtn" data-toggle="modal" data-target="#cronModal" data-keyboard="false" data-backdrop="static" style="visibility: hidden;"></button>
<div id="cronModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Setup for email notification</h4>
            </div>
            <div class="modal-body">
                <form id="emailNotification">
                    <input type="hidden" name="aoid" value="" id="aoid"/>
                    <div class="form-group clearfix">
                        <label class="col-sm-4 control-label">Date/Time <span >*</span></label>
                        <div class="col-sm-8">
                            <div class='input-group date' id='datetimepicker1'>
                                <input type='text' name="date_time" class="form-control" value="<?= set_value('date_time'); ?>"/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                            <div class="datetimeerror error" style="display:none;color:red">Please choose date/time</div>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="col-sm-4 control-label">Template <span >*</span></label>
                        <div class="col-sm-8">
                            <select class="form-control" name="template_id" id="template_id">
                                <option value="">- Select -</option>
                                <?php
//                                foreach ($emailtemplate as $key => $value) {
                                echo '<option value="' . $emailtemplate['id'] . '">' . $emailtemplate['template_name'] . '</option>';
//                                }
                                ?>
                            </select>
                            <div class="templateerror error" style="display:none;color:red">Please select template</div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="croneSend">Submit</button>
                <button class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>   
</div>