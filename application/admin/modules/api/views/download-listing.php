<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/widgets/datatable/datatable.css">
<script type="text/javascript" src="<?= base_url(); ?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable-tabletools.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#example').DataTable({
            autoWidth: true,
            bSort: false,
            columnDefs: [{
                targets: [0, 1, 2],
                orderable: false
            }, ],
            pageLength: 20
        });

    });
</script>
<h3 class="title-hero clearfix">
    Manage PDF
    <a href="download/add" class="pull-right btn btn-primary">Add PDF</a>
</h3>
<?php
$this->load->view('inc-messages');
if (count($download) == 0) {
    $this->load->view('inc-norecords');
    echo "</div>";
    return;
}
?>
<table id="example" class="display" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th style="color: black;" width="10%">#</th>
            <th style="color: black;" width="20%">PDF Name</th>
            <th style="color: black;" width="10%">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1;
        foreach ($download as $item) { ?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo $item['title']; ?></td>
                <td>
                    <?php
                    if ($item['active'] == 0) {
                    ?>
                        <span id="<?php echo $item['id'] ?>" class="toggle-status" style="cursor: pointer;color: green;">Enable</span>
                    <?php
                    } else {
                    ?>
                        <span id="<?php echo $item['id'] ?>" class="toggle-status" style="cursor: pointer;color: red;">Disable</span>
                    <?php
                    }
                    ?> |
                    <a href="download/edit/<?php echo $item['id']; ?>" class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Edit'><i class="glyph-icon icon-linecons-pencil"></i></a>
                    | <a href="download/delete/<?php echo $item['id']; ?>" onclick="return confirm('Are you sure you want to delete this PDF?');" class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Delete'><i class="glyph-icon icon-linecons-trash red-color"></i></a>
                </td>
                <?php $i++; ?>
            <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <th>#</th>
            <th>PDF Name</th>
            <th width="10%">Actions</th>
        </tr>
    </tfoot>
</table>
<script src="js/a_toggle.js"></script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
<script type="text/javascript">
    // $(document).ready(function() {
        $(document).on('click', '.toggle-status', function() {
            var path = '<?php echo base_url() ?>download/toggle';
            var id = $(this).attr('id');

            toggle_item(path, id);
        });
    // });
</script>