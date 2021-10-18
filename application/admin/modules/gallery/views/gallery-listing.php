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
                targets: [0, 1, 2, 3],
                orderable: false
            }, ],
            pageLength: 20
        });

    });
</script>
<h3 class="title-hero clearfix">
    Manage Gallery
    <a href="gallery/add" class="pull-right btn btn-primary">Add Gallery</a>
</h3>
<?php
$this->load->view('inc-messages');
if (count($gallery) == 0) {
    $this->load->view('inc-norecords');
    echo "</div>";
    return;
}
?>
<table id="example" class="display" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th style="color: black;" width="10%">#</th>
            <th style="color: black;" width="20%">Project Name</th>
            <th style="color: black;" width="10%">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($gallery as $item) { ?>
            <tr>
                <td><img src="<?php echo $this->config->item('GALLERY_IMAGE_URL') . $item['image']; ?>" width="75" /></td>
                <td><?php echo $item['project_name']; ?></td>
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
                    <a href="gallery/edit/<?php echo $item['id']; ?>" class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Edit'><i class="glyph-icon icon-linecons-pencil"></i></a>
                    | <a href="gallery/delete/<?php echo $item['id']; ?>" onclick="return confirm('Are you sure you want to delete this Gallery?');" class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Delete'><i class="glyph-icon icon-linecons-trash red-color"></i></a>
                </td>
            <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <th>#</th>
            <th>Project Name</th>
            <th width="10%">Actions</th>
        </tr>
    </tfoot>
</table>
<script src="js/a_toggle.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
    // $(document).ready(function() {
    $(document).on('click', '.toggle-status', function() {
        // $('.toggle-status').click(function() {
        var path = '<?php echo base_url() ?>gallery/toggle';
        var id = $(this).attr('id');

        toggle_item(path, id);
    });
    // });
</script>