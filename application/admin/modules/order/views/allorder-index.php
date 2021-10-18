<style>
    .border-table th:last-child, .border-table td:last-child {
        /*width: 39px !important;*/
        text-align: center;
    }

    .first-th {
        width: 20px !important;
    }
    table.dataTable tfoot th, table.dataTable tfoot td {
        padding: 10px 12px 6px 12px !important;
    }
</style>
<?php
// ee($orders);
?>
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/widgets/datatable/datatable.css">
<script type="text/javascript" src="<?= base_url(); ?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable-tabletools.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#example').DataTable({
            autoWidth: true,
            bSort: false,
            columnDefs: [
                {
                    targets: [0, 1, 2, 3, 4, 5, 6],
                    orderable: false
                },
            ],
//            pageLength: 20,
            aLengthMenu: [[25, 50, 75, -1], [25, 50, 75, "All"]],
            iDisplayLength: 25
        });

    });</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('.datepicker').datepicker({maxDate: 0, dateFormat: 'dd/mm/yy'});

        function stopPropagation(evt) {
            if (evt.stopPropagation !== undefined) {
                evt.stopPropagation();
            } else {
                evt.cancelBubble = true;
            }
        }
    });
</script>

<div class="row">
    <div class="col-md-6">
        <h2>Manage Orders</h2>
    </div>
</div>

<div class="" style="float:right; display: block; width: 100%; text-align: right; margin-top: -39px;">
    <div>
        <ul class='list-inline export-list'>
            <li class='csv-ex'>
                Export CSV
            </li>
            <li>
                <span>From</span>
            </li>
            <li>
                <input id='from_date' class="datepicker form-control" data-date-format="dd/mm/yyyy" name="from_date">
            </li>
            <li>
                <span>Till</span>
            </li>
            <li>
                <input id='till_date' class="datepicker form-control" data-date-format="dd/mm/yyyy" name="till_date">
            </li>
            <li style='padding-right: 0px;'>
                <button id='export-csv-btn' class='btn btn-link' type="button" name="button" style="color:black;">Export</button>
                <a id="csv-download-link" href="" hidden="hidden">Download CSV</a>
            </li>
        </ul>
    </div>
</div>
<br><br>

<hr />

<?php $this->load->view('inc-messages'); ?>
<table id="example" class="display border-table" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th class="first-th">
                <button id='download-multiple-pdf-btn' type="button" class="btn btn-primary" name="button" title="Download Order PDF of Selected Orders">
                    <i class="fa fa-download" aria-hidden="true"></i>
                </button>
            </th>
            <th width='13%'>User</th>
            <th width='15%'>Order Number</th>
            <th width='15%'>Order Time</th>
            <th>Order Total</th>
            <th>
                Payment Status
                <select class="status-select" name="">
                    <option value="0">All</option>
                    <option value="1">Paid</option>
                    <option value="2">Unpaid</option>
                </select>
            </th>
            <th>
                Order Status
                <select class="order-status-select" name="">
                    <option value="0">All</option>
                    <?php
                    if (!empty($order_status)) {
                        foreach ($order_status as $ostatus) {
                            $labrl_array = explode('_', $ostatus['label']);
                            $label_string = implode(" ", $labrl_array);
                            echo '<option value="' . $ostatus['label'] . '">' . $label_string . '</option>';
                        }
                    }
                    ?>
                </select>
            </th>
            <th>Transaction No.</th>
            <th style="" width="">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($orders['orders']) {
            foreach ($orders['orders'] as $order) {
                ?>
                <tr>
                    <td>
                        <input class='select-box' type="checkbox" name="" value="<?php echo $order['order_id']; ?>">
                    </td>
                    <td>
                        <?php
                        if ($order['first_name'] == '0') {
                            echo "Guest User";
                        } else {
                            echo $order['first_name'] . ' ' . $order['last_name'];
                        }
                        ?>
                    </td>
                    <td><?= $order['order_num']; ?></td>
                    <td><?= date('jS F, Y', $order['order_time']); ?></td>
                    <td>
                        <?php
//                        echo number_format(($order['order_total'] - $order['shipping']), 2);
                        echo number_format(($order['order_total']), 2);
                        ?>
                    </td>
                    <td>
                        <?php
                        if ($order['confirmed'] == 1) {
                            ?>
                            <span class="green-color">Paid</span>
                            <?php
                        } else {
                            ?>
                            <span class="red-color">Unpaid</span>
                            <?php
                        }
                        ?>
                    </td>
                    <td>
                        <select class="order_status_update form-control" oid="<?= $order['order_id'] ?>">
                            <option value="">-Select-</option>
                            <?php
                            if (!empty($order_status)) {
                                foreach ($order_status as $ostatus) {
                                    $labrl_array = explode('_', $ostatus['label']);
                                    $label_string = implode(" ", $labrl_array);
                                    ?>
                                    <option value="<?php echo $ostatus['label'] ?>" <?= ($ostatus['label'] == $order['status']) ? 'selected="selected"' : '' ?>><?= $label_string ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                        <p class="statusMsg" style="color: green;"></p>
                    </td>
                    <td>
                        <?php
                        echo $order['transaction_no'];
                        ?>
                    </td>
                    <td width="">
                        <a href="order/viewOrder/<?= $order['order_id']; ?>" class='tooltip-button' data-toggle='tooltip' data-placement='top' title='View'><i class="glyph-icon icon-eye"></i></a>&nbsp;&nbsp;
                        <a target="_blank" href="invoice/order_pdf/<?= $order['order_id']; ?>"><i class="fa fa-download" aria-hidden="true"></i></a>
                        &nbsp;
                        <a href="order/deleteOrder/<?= $order['order_id']; ?>" class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Delete' onclick="return confirm('Are you sure you want to delete this Order?');"><i class="glyph-icon icon-trash-o red-color"></i></a>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th></th>
            <th>User</th>
            <th>Order Number</th>
            <th>Order Time</th>
            <th>Order Total</th>
            <th>Status</th>
            <th>Order Status</th>
            <th>Transaction No.</th>
            <th width="10%">Action</th>
        </tr>
    </tfoot>
</table>

<script type="text/javascript">
    $(document).ready(function () {
        $('#export-csv-btn').click(function () {
            var from_date = $('#from_date').val();
            var till_date = $('#till_date').val();
            var orderStatus = $('.order-status-select').val();

            $.post('order/export_orders_csv',
                    {
                        from_date: from_date,
                        till_date: till_date,
                        order_status: orderStatus
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

<script type="text/javascript">
    $(document).ready(function () {
        $('#download-multiple-pdf-btn').click(function () {
            var arr = [];

            $('.select-box:checked').each(function (index, element) {
                arr.push($(this).val());
            });

            $.post('order/multi_order_pdf',
                    {
                        arr: JSON.stringify(arr)
                    },
                    function (data, status) {
                        window.location.href = 'order/multi_order_pdf_download';
                    });
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $(".status-select").val(<?php echo $orders['filter']; ?>);
        $('.status-select').change(function () {
            window.location.href = "order/allorders/" + $('.status-select').find(":selected").val() + '/' + $('.order-status-select').find(":selected").val();
        });
        $(".order-status-select").val('<?php echo $orders['filter1']; ?>');

        $(document).on('change', '.order-status-select', function () {
            window.location.href = "order/allorders/" + $('.status-select').find(":selected").val() + '/' + $('.order-status-select').find(":selected").val();
        });
    });
</script>
<script>
    $('.order_status_update').on('change', function () {
        var parentTD = $(this).parent('td');
        var ostatus = $(this).val();
        var oid = $(this).attr('oid');
        if (ostatus != '') {
            $.post('order/update_status', {ostatus: ostatus, oid: oid}, function (data) {
                data = JSON.parse(data);
                if (data.success == 'success') {
                    parentTD.find('.statusMsg').html(data.msg);
                    parentTD.find('.statusMsg').show();
                    setTimeout(function () {
                        parentTD.find('.statusMsg').html('');
                        parentTD.find('.statusMsg').hide();
                    }, 5000);
                }
            });
        }
    });
</script>
<style>
    .border-table tr:first-child th{
        line-height: 20px;
    }
    .border-table td{
        line-height: 20px;
    }
</style>

<script>
    $(document).ready(function () {
        $('#page-sidebar').addClass('barActive');
        $('#page-content').addClass('barPageActive');
        $('.collapseBtn .fa').toggleClass('fa-chevron-left fa-chevron-right');
    });
</script>

