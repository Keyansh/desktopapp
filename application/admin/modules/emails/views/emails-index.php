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
    Manage Email Templates
    <a href="emails/add" class="pull-right btn btn-primary">Add Email Templates</a>
</h3>
<?php
if (count($emails) == 0) {
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
                        <th style="color: black;">Template Name</th>
                        <th style="color: black;">Template Alias</th>
                        <th style="color: black;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($emails as $item) { ?>
                        <tr>
                            <td><?php echo $item['template_name']; ?></td>
                            <td><?php echo $item['template_alias']; ?></td>
                            <td>
                                <a href="emails/edit/<?php echo $item['id']; ?>" class="tooltip-button" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                                <a href="emails/delete/<?php echo $item['id']; ?>" class="tooltip-button" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="fa fa-trash red-color"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
