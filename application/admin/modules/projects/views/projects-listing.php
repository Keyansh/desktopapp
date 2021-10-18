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
    Manage projects
    <a href="projects/add" class="pull-right btn btn-primary">Add projects</a>
</h3>
<?php
$this->load->view('inc-messages');
if (count($projects) == 0) {
    $this->load->view('inc-norecords');
    echo "</div>";
    return;
}
?>
<style>
    table.dataTable.hover tbody tr:hover,
    table.dataTable.display tbody tr:hover {
        background-color: #dfdfdf !important;
    }
</style>
<table id="example" class="display" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th width="10%">#</th>
            <th>projects Title</th>
            <th width="20%">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1;
        foreach ($projects as $item) { ?>
            <tr>
                <td><?= $i; ?></td>
                <td><?php echo $item['projects_title']; ?></td>
                <td>
                    <?php
                    if ($item['active'] == 0) {
                    ?>
                        <span id="<?php echo $item['projects_id'] ?>" class="toggle-status" style="cursor: pointer;color: green;">Enable</span>
                    <?php
                    } else {
                    ?>
                        <span id="<?php echo $item['projects_id'] ?>" class="toggle-status" style="cursor: pointer;color: red;">Disable</span>
                    <?php
                    }
                    ?>
                    |
                    <a href="projects/edit/<?php echo $item['projects_id']; ?>" class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Edit'><i class="glyph-icon icon-linecons-pencil"></i></a>
                    | <a href="projects/delete/<?php echo $item['projects_id']; ?>" onclick="return confirm('Are you sure you want to delete this projects?');" class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Delete'><i class="glyph-icon icon-linecons-trash red-color"></i></a>
                </td>
            <?php $i++;
        } ?>
    </tbody>
    <tfoot>
        <tr>
            <th>#</th>
            <th>projects Title</th>
            <th>Actions</th>
        </tr>
    </tfoot>
</table>




<script src="js/a_toggle.js"></script>

<script type="text/javascript">
    // $(document).ready(function() {
    $(document).on('click', '.toggle-status', function() {
        // $('.toggle-status').click(function() {
        var path = '<?php echo base_url() ?>projects/toggle';
        var id = $(this).attr('id');

        toggle_item(path, id);
    });
    // });
</script>