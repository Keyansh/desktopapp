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
            if ((x != 1) && (x != 2) && (x != 7)) {
                $(this).html('<input type="text" onclick="stopPropagation(event);" placeholder="Search ' + title + '" class="form-control"/>');
            }
        });
        var table = $('#example').DataTable({
            processing: true,
            serverSide: true,
            ajax: 'catalognew/server_side_dt/jsonStockProducts/',
            autoWidth: true,
            bSort: true,
            aaSorting: [[0, 'desc']],
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id', 'prd_'+aData[0]);
            },
            columnDefs: [
                {
                    targets: [1, 2, 3, 4, 5, 6],
                    orderable: false
                },
                {
                    'targets': [0],
                    'className': 'dt-center',
                    'render': function (data, type, full, meta) {
                        return '<input type="checkbox" name="proIds[]" value="' + full[0] + '" class="proSelAll"/>';
                    }
                },
                {
                    'targets': [1],
                    'className': 'dt-center',
                    'render': function (data, type, full, meta) {
                        var prodImage = '';
                        if (full[1] == '') {
                            prodImage = '../images/default.jpg';
                        } else {
                            prodImage = '../upload/products/' + full[1];
                        }
                        return '<img src="' + prodImage + '" class="img-responsive"/>';
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
                    'targets': [6],
                    'className': 'dt-center',
                    'render': function (data, type, full, meta) {
//                                return data;
                        var classD = full[6] == 1 ? 'icon-linecons-eye green-color' : 'icon-eye-slash red-color';
                        return '<div class="page_item_options"><a><i pro_id=' + full[0] + ' class="edProduct glyph-icon ' + classD + '"></i></a> <a href="catalognew/product/edit/' + full[0] + '" class=""><i class="glyph-icon icon-linecons-pencil"></i></a> <a onclick="return confirm(\'Are you sure you want to delete this product?\');" href="catalognew/product/delete/' + full[0] + '" class=""><i class="glyph-icon icon-linecons-trash red-color"></i></a></div>';
                    }
                },
            ],
            "lengthMenu": [10, 20, 50, 100, "All"],
            iDisplayLength: 20
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
//            console.log(pid);
            $.post("catalognew/product/ed", {pid: pid}, function (data) {
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
    });
</script>

<style>
    h1{
        margin-bottom: 25px;
    }
    #example_length {
        margin-bottom: 15px;
    }
    .img-responsive {
        max-width: 70px;
    }
    .input-th:after{
        display: none !important;
    }
    .input-th{
        pointer-events: none;
    }
    .td input{
        cursor: pointer;
    }
</style>

<div class="row">
    <div class="col-md-6">
        <h1>Manage out of stock products</h1>
    </div>
<!--    <div class="col-md-6">-->
<!--        <div id="ctxmenu" class="pull-right">-->
<!--            <a href="catalognew/product/add" class="btn btn-primary">Add Product</a>-->
<!--        </div>-->
<!--    </div>-->
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
                <th style="color:black;">Image</th>
                <th style="color:black;">Name</th>
                <th width="15%" style="color:black;">SKU</th>
                <th width="15%" style="color:black;">Type</th>
                <th width="15%" style="color:black;">Price</th>
                <!--<th width="5%">E/D</th>-->
                <th width="10%" style="color:black;">Actions</th>
            </tr>
            <tr id="filterrow" >
                <th class="input-th"><input type="checkbox" name="proIds[]" id="proSelectAll" /></th>
                <th></th>
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
<script>
    $(document).ready(function () {
        $('#page-sidebar').addClass('barActive');
        $('#page-content').addClass('barPageActive');
        $('.collapseBtn .fa').toggleClass('fa-chevron-left fa-chevron-right');
    });
</script>

<div id="dialog-modal" title="Working">
    <p style="text-align: center; padding-top: 40px;">Updating the sort order...</p>
</div>

<script type="text/javascript" src="js/ui/js/jquery-ui-1.8.5.custom.min.js"></script>
<script type="text/javascript"> 

    $(document).ready(function($) {

        function postData(data) {

            $( "#dialog-modal" ).dialog({
                height: 140,
                modal: true
            });

            $.post('catalognew/product/updatePrdJkSortOrder', data, function(data) {
                $( "#dialog-modal" ).dialog('close');
            });
        }

        var options = {
            containment: 'parent',
            opacity: 0.6,
            update: function(event, ui) {
                var data = $(this).sortable('serialize');
                postData(data);
            }
        };

        $( "#example tbody" ).sortable(options);
    });
    
</script>

