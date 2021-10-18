<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/widgets/datatable/datatable.css">
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable-bootstrap.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable-tabletools.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#datatable-example').dataTable({
            columnDefs: [
                {
                    targets: [2],
                    orderable: false
                }
            ]
        });
    });
</script>
<h3 class="title-hero clearfix">
    Manage Events
    <a href="events/add" class="pull-right btn btn-primary">Add Event</a>
</h3>
<?php
if (count($events) == 0) {
    $this->load->view('inc-norecords');
    return;
}
?>

<div class="panel">
    <div class="panel-body">
        <?php $this->load->view('inc-messages'); ?>
        <div class="example-box-wrapper">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatable-example">
                <thead>
                    <tr>
                        <th>Event Name</th>
                        <th>Event Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($events as $item) { ?>
                        <tr>
                            <td><?php echo $item['name']; ?></td>
                            <td><?php echo $item['date_time']; ?></td>
                            <td>
                                <?php
                                $userId = curUsrId();
                                if (($item['created_by'] == $userId) || ($userId == '1') ) {
                                    ?>
                                    <a href="events/assign/<?php echo $item['id']; ?>" class="tooltip-button" data-toggle="tooltip" data-placement="top" title="" data-original-title="Assign"><i class="fa fa-users green-colors"></i></a>
                                    <a href="events/edit/<?php echo $item['id']; ?>" class="tooltip-button" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                                    <a href="events/delete/<?php echo $item['id']; ?>" class="tooltip-button" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="fa fa-trash red-color"></i></a>
                                    <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
