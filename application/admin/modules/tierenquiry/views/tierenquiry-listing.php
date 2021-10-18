<?php $this->load->view('meta/tierenquiry_index'); ?>
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
            ],
            pageLength: 20
        });

    });</script>
<h3 class="title-hero clearfix">
    Manage Group Product Enquiry
</h3>
<?php
$this->load->view('inc-messages');
if (count($tier) == 0) {
    $this->load->view('inc-norecords');
    return;
}
?>
<table id="example" class="display" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th style="color: black;">Product Name</th>
            <th style="color: black;">Quantity</th>
            <th style="color: black;">Name</th>  
            <th style="color: black;">Email</th>  
            <th style="color: black;">Phone</th>  
            <th  style="color: black;">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tier as $item) { ?>
            <tr>
                <td><?= $item['tier_product'] ?></td>
                <td><?= $item['tier_qty']; ?></td>
                <td><?= $item['tier_name']; ?></td>
                <td><?= $item['tier_email']; ?></td>
                <td><?= $item['tier_phone']; ?></td>
                <td>
                    <a href="tierenquiry/view/<?= $item['id']; ?>"class='tooltip-button' data-toggle='tooltip' data-placement='top' title='View'><i class="glyph-icon icon-eye"></i></a>
                    | <a href="tierenquiry/delete/<?= $item['id']; ?>" onclick="return confirm('Are you sure you want to delete this ?');"  class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Delete'><i class="glyph-icon icon-linecons-trash red-color"></i></a>
                </td>
            <?php } ?>
    </tbody>
</table>