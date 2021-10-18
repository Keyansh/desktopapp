<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/widgets/datatable/datatable.css">
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable-bootstrap.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable-tabletools.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#datatable-example').dataTable();
    });
</script>
<h3 class="title-hero clearfix text-center">
    <a href="catalog/attribute/index" class="btn btn-primary pull-left">Manage Attribute</a>
    Attribute Options: <?php echo $attributes['name']; ?>
    <a href="catalog/attribute_option/add/<?php echo $attributes['id']; ?>" class="pull-right btn btn-primary">Add Attribute Option</a>
</h3>
<?php
if (count($attributes_value) == 0) {
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
                        <th>Attributes Value</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($attributes_value as $row) { ?>
                        <tr class="<?php echo alternator('even', 'old') ?>">
                            <td valign="top"><?php echo $row['option']; ?></td>
                            <td valign="top"><a href="catalog/attribute_option/edit/<?php echo $row['id']; ?>">Edit</a> <a href="catalog/attribute_option/delete/<?php echo $row['id']; ?>">Delete</a> </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>