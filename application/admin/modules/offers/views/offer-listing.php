<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/widgets/datatable/datatable.css">
<script type="text/javascript" src="<?= base_url(); ?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable-tabletools.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#example').DataTable({
            autoWidth: true,
//            bSort: false,
            columnDefs: [
                {
                    targets: [4],
                    orderable: false
                },
            ],
            pageLength: 20
        });

    });</script>
<h3 class="title-hero clearfix">
    Manage Offers
    <a href="offers/add" class="pull-right btn btn-primary">Add Offer</a>
</h3>
<?php
$this->load->view('inc-messages');
if (count($offers) == 0) {
    $this->load->view('inc-norecords');
    echo "</div>";
    return;
}
?>
<table id="example" class="display table table-bordered" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th style="color: black;">Offer Title</th>
            <th style="color: black;">Applicable From</th>
            <th style="color: black;">Applicable To</th>
            <th style="color: black;">Price</th>
            <th style="color: black;" width="101px">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($offers as $item) {
            $assign_href = 'offers/assign/' . $item['id'];
            $del_href = 'offers/delete/' . $item['id'];
            $edit_href = 'offers/edit/' . $item['id'];
            if ($item['is_active'] == 1) {
                $link_href = 'offers/disable/' . $item['id'];
                $link_name = '<i class="glyph-icon icon-eye green-color"></i>';
            } else {
                $link_href = 'offers/enable/' . $item['id'];
                $link_name = '<i class="glyph-icon icon-eye-slash"></i>';
            }
            ?>
            <tr>
                <td><?php echo $item['name']; ?></td>
                <td><?php echo $item['start_on']; ?></td>
                <td><?php echo $item['end_on']; ?></td>
                <td><?php echo $item['price']; ?></td>
                <td class="menu_item_options">
                    <a href="<?php echo $assign_href; ?>"class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Assign'><i class="glyph-icon icon-list-ul"></i></a>
                    <a href="<?php echo $link_href; ?>"class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Enable/Disable'><?php echo $link_name; ?></a>
                    <a href="<?php echo $edit_href; ?>"class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Edit'><i class="glyph-icon icon-linecons-pencil"></i></a>
                    <a href="<?php echo $del_href; ?>" onclick="return confirm('Are you sure you want to delete this Offer?');"  class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Delete'><i class="glyph-icon icon-linecons-trash red-color"></i></a>
                </td>
            <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <th>Offer Title</th>
            <th>Applicable From</th>
            <th>Applicable To</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
    </tfoot>
</table>