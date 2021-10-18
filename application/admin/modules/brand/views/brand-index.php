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
                    targets: [0, 1, 2, 3],
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
//            pageLength: 20
        });

    });</script>
<h3 class="title-hero clearfix">
    Manage Brands
    <a href="brand/add/" class="pull-right btn btn-primary">Add Brand</a>
</h3>
<?php
$this->load->view('inc-messages');
if (count($brands) == 0) {
    $this->load->view('inc-norecords');
    echo "</div>";
    return;
}
?>
<table id="example" class="display" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th width="10%">#</th>
            <th width="20%">Brand Name</th>
            <!-- <th>Description</th>             -->
            <th width="10%">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($brands as $brand) { 
            $imagPath = $this->config->item('BRAND_THUMBNAIL_URL').$brand['image'];
            ?>
            <tr>
                <td><img src="<?= $imagPath; ?>" /></td>
                <td><?= $brand['name']; ?></td>                
                <!-- <td><?= substr($brand['description'],0,200); ?></td>             -->
                <td width="10%"><a href="brand/edit/<?php echo $brand['id']; ?>"  class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Edit'><i class="glyph-icon icon-linecons-pencil"></i></a> | <a href="brand/delete/<?php echo $brand['id']; ?>" onclick="return confirm('Are you sure you want to Delete this Brand ?');"  class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Delete'><i class="glyph-icon icon-linecons-trash red-color"></i></a></td>
            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <th>#</th>
            <th>Brand Name</th>
            <!-- <th>Description</th>             -->
            <th width="10%">Actions</th>
        </tr>
    </tfoot>
</table>