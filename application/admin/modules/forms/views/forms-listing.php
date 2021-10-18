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
    Manage Forms
    <a href="forms/add" class="pull-right btn btn-primary">Add New</a>
</h3>

<?php
$this->load->view('inc-messages');
if (count($forms) == 0) {
    $this->load->view('inc-norecords');
    echo "</div>";
    return;
}
?>

<table id="example" class="display" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th width="">Title</th>
            <th width="15%">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($forms as $item) { ?>
            <tr>
                <td>
                    <?php echo $item['form_title']; ?>
                </td>
                <td>
                    <a href="forms/edit/<?php echo $item['id']; ?>">Edit</a> |
                    <a href="#">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

