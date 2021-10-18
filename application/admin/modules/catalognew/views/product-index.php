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
            if ((x != 1) && (x != 5) && (x != 6) && (x != 7)) {
                $(this).html('<input type="text" onclick="stopPropagation(event);" placeholder="Search ' + title + '" class="form-control"/>');
            }
        });
        var table = $('#example').DataTable({
            processing: true,
            serverSide: true,
            ajax: 'catalognew/server_side_dt/jsonProducts/',
            autoWidth: true,
            bSort: false,
            columnDefs: [
                {
                    targets: [0, 1, 2, 3, 4, 5, 6],
                    orderable: false
                },
                {
                    'targets': [0],
                    'className': 'dt-center',
                    'render': function (data, type, full, meta) {
                        // return '<input type="checkbox" name="proIds[]" value="' + full[0] + '" class="proSelAll"/>';
                        return '';
                    }
                },
                {
                    'targets': [5],
                    'className': 'dt-center',
                    'render': function (data, type, full, meta) {
//                                return data;
                        var classD = data == 1 ? 'icon-linecons-eye green-color' : 'icon-eye-slash red-color';
                        return '<div class="page_item_options"><a><i pro_id=' + full[0] + ' class="edProduct glyph-icon ' + classD + '"></i></a></div>';
                    }
                },
                {
                    'targets': [7],
                    'className': 'dt-center',
                    'render': function (data, type, full, meta) {
//                                return data;
                        return '<div class="page_item_options"><a href="catalognew/product/edit/' + full[0] + '" class=""><i class="glyph-icon icon-linecons-pencil"></i></a> <span data-id="' + full[0] + '" class="remove-product" style="cursor:pointer;"><i class="glyph-icon icon-linecons-trash red-color"></i></span></div>';
                    }
                },
            ],
            pageLength: 20,
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id', 'pid_'+aData[0]);
            }
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
            $.post("catalognew/product/deleteAll", {pids: proIds}, function (data) {
                if (data == 1) {
                    window.location.reload();
                }
            });
        });
        $(document).on('click', '.edProduct', function () {
            var $parentThis = $(this);
            var pid = $(this).attr('pro_id');
            console.log(pid);
            $.post("catalognew/product/ed", {pid: pid}, function (data) {
                if (data == 1) {
                    $parentThis.removeClass();
                    $parentThis.addClass('edProduct glyph-icon icon-linecons-eye green-color');
                } else if(data == 0) {
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
            <a href="catalognew/product/add" class="btn btn-primary">Add Product</a>
        </div>
        
        <div id="ctxmenu" class="pull-right">
            <a href="catalognew/product/exportstock" class="btn btn-primary">Export Stock</a>
        </div>
    </div>
</div>

<?php $this->load->view('inc-messages'); ?>
<?php
if (count($products) == 0) {
    $this->load->view('inc-norecords');
} else {
    ?>
    <table id="example" class="display border-table" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>SKU</th>
                <th>Type</th>
                <th>Price</th>
                <th width="5%">E/D</th>
                <th width="5%">Stock</th>
                <th width="10%">Actions</th>
            </tr>
            <tr id="filterrow">
                <!-- <th><input type="checkbox" name="proIds[]" id="proSelectAll" /></th> -->
                <th></th>
                <th>Name</th>
                <th>SKU</th>
                <th>Type</th>
                <th></th>
                <th width="5%"></th>
                <th></th>
                <th width="10%"></th>
            </tr>
        </thead>
    </table>
<?php } ?>

<!-- <?php if (count($products) > 0) { ?>
    <button class="btn btn-primary" id="delSlected">Delete Selected Products</button>
<?php } ?> -->

<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', '.remove-product', function() {
            if (confirm("Are you sure to remove this product ?")) {
                window.location.href = "catalognew/product/delete/" + $(this).attr('data-id');
            }
        });
        $("table#example tbody").sortable({
            containment: 'parent',
            opacity: 0.6,
            update: function(event, ui) {
                var data = $(this).sortable('serialize');
                $.post('catalognew/product/updateProduct_SortOrder', data, function(data) {
                    $( "#dialog-modal" ).dialog('close');
                });
            }
        });
    });
</script>
