<?php
// e($testimonials)
?>

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
    Manage Testimonials
    <a href="testimonial/add" class="pull-right btn btn-primary">Add Testimonial</a>
</h3>
<?php
$this->load->view('inc-messages');
if (count($testimonials) == 0) {
    $this->load->view('inc-norecords');
    echo "</div>";
    return;
}
?>
<table id="example" class="display" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th width="20%" style="color: black;">Name</th>
            <th style="color: black;">Testimonial</th>
            <th width="15%" style="color: black;">Actions</th>
        </tr>
    </thead>
    <tbody id="testimonial_tree">
        <?php
        foreach ($testimonials as $item) {
        ?>
            <tr id="testimonial_<?php echo $item['id']; ?>" style="cursor: move;">
                <td style="text-align:center;">
                    <?php echo $item['name'] ?>
                </td>
                <td>
                    <?php echo character_limiter(strip_tags($item['testimonial']), 100) ?>
                </td>
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
                    ?>
                    |
                    <a href="testimonial/edit/<?php echo $item['id']; ?>" class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Edit'><i class="glyph-icon icon-linecons-pencil"></i></a>
                    | <a href="testimonial/delete/<?php echo $item['id']; ?>" onclick="return confirm('Are you sure you want to delete this Testimonial ?');" class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Delete'><i class="glyph-icon icon-linecons-trash red-color"></i></a>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th>Name</th>
            <th>Testimonial</th>
            <th>Actions</th>
        </tr>
    </tfoot>
</table>

<script src="js/a_toggle.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-ui/js/jquery-ui.min.js"></script>

<script type="text/javascript">
    // $(document).ready(function() {
    $(document).on('click', '.toggle-status', function() {
        // $('.toggle-status').click(function() {
        var path = '<?php echo base_url() ?>testimonial/toggle';
        var id = $(this).attr('id');

        toggle_item(path, id);
    });
    // });
</script>
<script>
    $(document).ready(function($) {

        function postData(data) {
            $("#dialog-modal").dialog({
                height: 140,
                modal: true
            });
            $.post('testimonial/updateSortOrder', data, function(data) {
                $("#dialog-modal").dialog('close');
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
        $("#testimonial_tree").sortable(options);
    });
</script>