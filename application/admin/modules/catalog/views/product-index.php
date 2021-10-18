<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/widgets/datatable/datatable.css">
<script type="text/javascript" src="<?= base_url(); ?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable-tabletools.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var x = 0;
        $('#example thead tr#filterrow th').each(function () {
            x++;
            var title = $('#example thead th').eq($(this).index()).text();
            if ((x != 1) && (x != 6) && (x != 7)) {
                $(this).html('<input type="text" onclick="stopPropagation(event);" placeholder="Search ' + title + '" class="form-control"/>');
            }
        });
        var table = $('#example').DataTable({
            processing: true,
            serverSide: true,
            ajax: 'catalog/server_side_dt/jsonProducts/',
            autoWidth: true,
            autoWidth: true,
            bSort: true,
            aaSorting: [[0, 'desc']],
            columnDefs: [
            {
            targets: [1, 2, 3, 4, 5],
            orderable: false
            },
            {
            'targets': [0],
                    'className': 'dt-center',
                    'render': function (data, type, full, meta) {
                        return '<input type="checkbox" name="proIds[]" value="' + full[0] + '" class="proSelAll"/>';
                    }
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
                {
                    'targets': [5],
                    'className': 'dt-center',
                    'render': function (data, type, full, meta) {
//                        console.log(full);
//                                return data;
                        var classD = full[5] == 1 ? 'icon-linecons-eye green-color' : 'icon-eye-slash red-color';
                        return '<div class="page_item_options"><a><i pro_id=' + full[0] + ' class="edProduct glyph-icon ' + classD + '"></i></a> <a href="catalog/product/edit/' + full[0] + '" class=""><i class="glyph-icon icon-linecons-pencil"></i></a> <a onclick="return confirm(\'Are you sure you want to delete this product?\');" href="catalog/product/delete/' + full[0] + '" class=""><i class="glyph-icon icon-linecons-trash red-color"></i></a></div>';
                    }
                },
            ],
            pageLength: 20
        });
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
        $(document).on('change', '.proSelAll', function () {
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
            $.post("catalog/product/deleteAll", {pids: proIds}, function (data) {
                if (data == 1) {
                    window.location.reload();
                }
            });
        });
        $(document).on('click', '.edProduct', function () {
            var $parentThis = $(this);
            var pid = $(this).attr('pro_id');
//            console.log(pid);
            $.post("catalog/product/ed", {pid: pid}, function (data) {
//                console.log(data);
                if (data == 1) {
                    $parentThis.removeClass();
                    $parentThis.addClass('edProduct glyph-icon icon-linecons-eye green-color');
                } else if (data == 0) {
                    $parentThis.removeClass();
                    $parentThis.addClass('edProduct glyph-icon icon-eye-slash red-color');
                }
                return false;
            });
        });
    });</script>
<div class="row">
    <div class="col-md-6">
        <h1>Manage Products</h1>
    </div>
    <div class="col-md-6">
        <div id="ctxmenu" class="pull-right">
            <a href="catalog/product/add" class="btn btn-primary">Add Product</a>
        </div>
    </div>
</div>

<?php $this->load->view('inc-messages'); ?>
<?php
if (count($products) == 0) {
    $this->load->view('inc-norecords');
} else {
    ?>
    <table id="example" class="display jas-table" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th style="color:black;">#</th>
                <th style="color:black;">Name</th>
                <th width="15%" style="color:black;">SKU</th>
                <th width="15%" style="color:black;">Type</th>
                <th width="15%" style="color:black;">Price</th>
                <!--<th width="5%">E/D</th>-->
                <th width="10%" style="color:black;">Actions</th>
            </tr>
            <tr id="filterrow" >
                <th><input type="checkbox" name="proIds[]" id="proSelectAll" /></th>
                <th>Name</th>
                <th width="10%">SKU</th>
                <th width="10%">Type</th>
                <th width="15%">Price</th>
                <!--<th width="5%"></th>-->
                <th width="10%"></th>
            </tr>
        </thead>
    </table>
<?php } ?>

<?php if (count($products) > 0) { ?>
    <button class="btn btn-primary" id="delSlected">Delete Selected Products</button>
<?php } ?>
<style>
    #example_filter{display: none}
</style>