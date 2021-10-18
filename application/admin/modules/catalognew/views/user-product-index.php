<style type="text/css">
    #table-3 td {
        border: 1px solid #DFE8F1;
        padding: 8px 13px;
        font-size: 14px;
    }
</style>
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/widgets/datatable/datatable.css">
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable-bootstrap.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable-tabletools.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var x = 0;
        $('#example thead tr#filterrow th').each(function () {
            x++;
            var title = $('#example thead th').eq($(this).index()).text();
            // if ((x != 5) && (x != 6)) {
                $(this).html('<input type="text" onclick="stopPropagation(event);" placeholder="Search ' + title + '" class="form-control"/>');
            // }
        });

        // DataTable
        // var table = $('#example').DataTable({
        //     autoWidth: true,
        //     bSort: false,
        //     columnDefs: [
        //         {
        //             targets: [0, 1, 2, 3],
        //             orderable: false
        //         },
        //     ],
        //     pageLength: 10
        // });
        var table = $('#example').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "catalognew/product/userProducts",
                "type": "POST",
            },
            "columnDefs": [
                {
                    "targets" : 4,
                    "orderable": false,
                    render: function(data, type, row, meta){
                        var price = parseFloat(row.pprice).toFixed(2),
                            special_price = parseFloat(row.sp).toFixed(2),
                                discount = parseFloat(row.dis).toFixed(2)
                        ;
                        // console.log(price +' '+special_price+' '+discount);
                        if(special_price > 0.00 && !isNaN(special_price)) {
                            return special_price;
                        }
                        else if(discount > 0.00 && !isNaN(discount)) {
                            var tmp = price * (discount / 100.00);
                            tmp = price - tmp;
                            return tmp.toFixed(2);
                        }
                        else {
                            return price;
                        }
                    }
                }
            ],
            "columns": [
                {
                    "data": "id",
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {"data": "pname"},
                {"data": "sku"},
                {"data": "type"},
                {"data": "pprice"},
                // {"data": "cname"},
                // {"data": "dis"},
                // {"data": "sp"},
            ]
        });

        // Apply the filter
        $("#example thead input").on('keyup', function () {
            table
                    .column($(this).parent().index() + ':visible')
                    .search(this.value)
                    .draw();
        });
        function stopPropagation(evt) {
            if (evt.stopPropagation !== undefined) {
                evt.stopPropagation();
            } else {
                evt.cancelBubble = true;
            }
        }

        //select all checkboxes
        $("#proSelectAll").change(function () {
            var status = this.checked;
            $('.proSelAll').each(function () {
                this.checked = status;
            });
        });

        $('.proSelAll').change(function () {
            if (this.checked == false) {
                $("#proSelectAll")[0].checked = false;
            }

            if ($('.proSelAll:checked').length == $('.proSelAll').length) {
                $("#proSelectAll")[0].checked = true;
            }
        });


        $('#delSlected').on('click', function () {
            var proIds = [];
            $('.proSelAll:checked').each(function () {
                proIds.push($(this).val());
            });
            $.post("catalognew/product/deleteAll", {pids: proIds}, function (data) {
                if (data == 1) {
                    window.location.reload();
                }
            });
        });
    });</script>
<div class="row">
    <div class="col-md-6">
        <h1>Manage Products</h1>
    </div>    
</div>

<?php $this->load->view('inc-messages'); ?>
    <table border="0" width="100%" class="table table-striped table-bordered" id="example">
        <thead>
            <tr>
                <th style="color:black;">#</th>            
                <th style="color:black;">Name</th>
                <th style="color:black;">Sku</th>
                <th style="color:black;">Type</th>
                <th style="color:black;">Price</th>
            </tr>
<!--             <tr id="filterrow">
                <th>Name</th>
                <th>Sku</th>
                <th>Type</th>
                <th>Price</th>
            </tr> -->
        </thead>
        <tbody>
        </tbody>
    </table>
