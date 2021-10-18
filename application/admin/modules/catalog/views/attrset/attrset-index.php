<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/widgets/datatable/datatable.css">
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable-bootstrap.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable-tabletools.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#datatable-example').dataTable();
    });
</script>
<h3 class="title-hero clearfix">
    Manage Attributes Set
    <a href="catalog/attrset/add" class="pull-right btn btn-primary">Add Attribute Set</a>
</h3>
<?php

if (count($attrset) == 0) {
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
                        <th style="color:black;">Attributes set Name</th>
                        <th style="color:black;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($attrset as $item) { ?>
                        <tr class="<?php echo alternator('odd', 'even'); ?>">
                            <td><?php echo $item['name']; ?></td>
                            <td><a href="catalog/attrset/assign/<?php echo $item['id']; ?>">Assign Attributes</a> | <a href="catalog/attrset/edit/<?php echo $item['id']; ?>">Edit</a>| <a href="catalog/attrset/delete/<?php echo $item['id']; ?>">Delete</a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
