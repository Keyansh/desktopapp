<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/widgets/datatable/datatable.css">
<script type="text/javascript" src="<?= base_url(); ?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable-tabletools.js"></script>
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
                    targets: [0, 1, 2, 3, 4, 5],
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
            pageLength: 15
        });

    });</script>
<div class="row">
    <div class="col-md-6">
        <h2>Manage Quotations</h2>
    </div>
    <div class="col-md-6">
        <div id="ctxmenu" class="pull-right">
            <a href="order/add" class="btn btn-primary">Add Quotation</a>
        </div>
    </div>
</div>
<hr />
<?php
if (count($quotations) == 0) {
    $this->load->view('inc-norecords');
    return;
}
?>
<?php $this->load->view('inc-messages'); ?>
<table id="example" class="display" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>User</th>
            <th>Quotations Number</th>
            <th>Quotations Time</th>
            <th>Quotations Total</th>
            <th>Status</th>            
            <th width="10%">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($quotations as $quotation) { ?>
            <tr>
                <td><?= $quotation['first_name'] . ' ' . $quotation['last_name']; ?></td>
                <td><?= $quotation['quotation_num']; ?></td>
                <td><?= date('jS F, Y', $quotation['created_on']); ?></td>
                <td><?= DWS_CURRENCY_SYMBOL . $quotation['quotation_total']; ?></td>
                <td><?= ($quotation['confirmed'] == 1) ? '<i class="glyph-icon icon-check-square-o green-color"></i>' : '<i class="glyph-icon icon-check-square-o"></i>'; ?></td>            
                <td width="10%">
                    <a href="order/view/<?= $quotation['id']; ?>" class='tooltip-button' data-toggle='tooltip' data-placement='top' title='View'><i class="glyph-icon icon-eye green-color"></i></a>&nbsp;&nbsp;
                    <a href="order/delete/<?= $quotation['id']; ?>" class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Delete' onclick="return confirm('Are you sure you want to delete this Quotation?');"><i class="glyph-icon icon-trash-o red-color"></i></a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <th>User</th>
            <th>Quotations Number</th>
            <th>Quotations Time</th>
            <th>Quotations Total</th>
            <th>Status</th>            
            <th width="10%">Action</th>
        </tr>
    </tfoot>
</table>
