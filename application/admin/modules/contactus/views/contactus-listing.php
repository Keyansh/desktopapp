<!-- <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/widgets/datatable/datatable.css">
<script type="text/javascript" src="<?= base_url(); ?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable-tabletools.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"></script>
<!-- <script type="text/javascript">
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
</script> -->
<h3 class="title-hero clearfix">
    Manage Address
    <!-- <a href="contactus/add" class="pull-right btn btn-primary">Add Address</a> -->
</h3>
<?php
$this->load->view('inc-messages');
if (count($contactus) == 0) {
    $this->load->view('inc-norecords');
    echo "</div>";
    return;
}
?>
<table id="example" class="display" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th width="20%" style="color: black;">Name</th>
            <th style="color: black;">Address</th>
            <th width="15%" style="color: black;">Actions</th>
        </tr>
    </thead>
    <tbody id="sorting-tree">
        <?php
        foreach ($contactus as $item) {
        ?>
            <tr id="contactus_<?php echo $item['id'] ?>">
                <td style="text-align:center;">
                    <?php echo $item['contactus_name'] ?>
                </td>
                <td>
                    <?php echo $item['contactus_location'] ?>
                </td>
                <td>
                    <?php
                    if ($item['active'] == 0) {
                    ?>
                        <!-- <span id="<?php echo $item['id'] ?>" class="toggle-status" style="color:green;cursor: pointer;">Enable</span> -->
                    <?php
                    } else {
                    ?>
                        <!-- <span id="<?php echo $item['id'] ?>" class="toggle-status" style="color:red;cursor: pointer;">Disable</span> -->
                    <?php
                    }
                    ?>
                    <!-- | -->
                    <a href="contactus/edit/<?php echo $item['id']; ?>" class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Edit'><i class="glyph-icon icon-linecons-pencil"></i></a>
                    | <a href="contactus/delete/<?php echo $item['id']; ?>" onclick="return confirm('Are you sure you want to delete this Address ?');" class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Delete'><i class="glyph-icon icon-linecons-trash red-color"></i></a>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th>Name</th>
            <th>Address</th>
            <th width="15%">Actions</th>
        </tr>
    </tfoot>
</table>

<script src="js/a_toggle.js"></script>

<script type="text/javascript">
    // $(document).ready(function() {
    // $(document).on('click', '.toggle-status', function() {
    // $('.toggle-status').click(function() {
    //     var path = '<?php echo base_url() ?>contactus/toggle';
    //     var id = $(this).attr('id');
    //     toggle_item(path, id);
    // });
    // });
</script>


<script>
    $(document).ready(function($) {

        function postData(data) {
            $('#example_wrapper').block({
                message: 'Updating the sort order...',
                css: {
                    border: 'none',
                    color: "white",
                    background: 'black'
                }
            });
            $.post('contactus/updateSortOrder', data, function(data) {
                $('#example_wrapper').unblock();
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
        $("#sorting-tree").sortable(options);
    });
</script>