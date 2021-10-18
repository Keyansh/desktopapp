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
    Manage Order status
    <a href="order/add_status" class="pull-right btn btn-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Status</a>
</h3>
<?php
$this->load->view('inc-messages');
if(isset($orderstatus)) {
    if (count($orderstatus) == 0) {
        $this->load->view('inc-norecords');
        echo "</div>";
        return;
    }
}
?>
<table id="example" class="display" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th width="10%">#</th>
            <th width="20%">Label</th>
            <th>Status</th>            
            <th width="10%">Actions</th>
        </tr>
    </thead>
    <tbody>

        <?php
        if(isset($orderstatus)) {
            foreach ($orderstatus as $item) { ?>
        <tr>
            <td><?= $item['id'] ?></td>
            <td><b><?php echo $item['label']; ?></b></td>
            <td><?php echo ($item['is_active'] == 1) ? 'Active' : 'Deactive'; ?></td>
            <td>
                <?php if ($item['is_active'] == 1) { ?>
                    <a href="order/disable_status/<?php echo $item['id']; ?>"class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Disable'><i class="glyph-icon icon-eye"></i></a>
                <?php } else { ?>
                    <a href="order/enable_status/<?php echo $item['id']; ?>"class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Enable'><i class="glyph-icon icon-eye-slash"></i></a>
                <?php } ?>
                | <a href="order/edit_status/<?php echo $item['id']; ?>"class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Edit'><i class="glyph-icon icon-linecons-pencil"></i></a>
            </td>
            <?php }
            } ?>
    </tbody>
    <tfoot>
        <tr>
            <th width="10%">#</th>
            <th width="20%">Label</th>
            <th>Status</th>            
            <th width="10%">Actions</th>
        </tr>
    </tfoot>
</table>