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
                },

            ],
        });

    });
</script>
<h3 class="title-hero clearfix">
    Manage Project Type
    <a href="projecttype/add/" class="pull-right btn btn-primary">Add Project Type</a>
</h3>
<?php
$this->load->view('inc-messages');
if (count($projecttype) == 0) {
    $this->load->view('inc-norecords');
    echo "</div>";
    return;
}
?>
<table id="example" class="display" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th width="10%">#</th>
            <th width="20%">Name</th>
            <th width="10%">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1;
        foreach ($projecttype as $item) {
            // $imagPath = $this->config->item('BRAND_THUMBNAIL_URL') . $brand['image'];
        ?>
            <tr>
                <td><?= $i ?></td>
                <td><?= $item['name']; ?></td>
                <td width="10%">
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
                    ?>
                    |<a href="projecttype/edit/<?php echo $item['id']; ?>" class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Edit'><i class="glyph-icon icon-linecons-pencil"></i></a> |
                    <a href="projecttype/delete/<?php echo $item['id']; ?>" onclick="return confirm('Are you sure you want to Delete this Project Type ?');" class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Delete'><i class="glyph-icon icon-linecons-trash red-color"></i></a>
                </td>
            </tr>
        <?php $i++;
        } ?>
    </tbody>
    <tfoot>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th width="10%">Actions</th>
        </tr>
    </tfoot>
</table>
<script src="js/a_toggle.js"></script>

<script type="text/javascript">
    // $(document).ready(function() {
    $(document).on('click', '.toggle-status', function() {
        // $('.toggle-status').click(function() {
        var path = '<?php echo base_url() ?>projecttype/toggle';
        var id = $(this).attr('id');

        toggle_item(path, id);
    });
    // });
</script>