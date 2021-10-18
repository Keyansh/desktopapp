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
    Manage Attributes
    <a href="catalog/attribute/add" class="pull-right btn btn-primary">Add Attribute</a>
</h3>
<?php
if (count($attributes) == 0) {
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
                        <th style="color:black;">Attributes Name</th>
                        <th style="color:black;">Attributes Label</th>
                        <th style="color:black;">Attributes type</th>
                        <th style="color:black;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($attributes as $item) { ?>
                        <tr class="<?php echo alternator('odd', 'even'); ?>">
                            <td><?php echo $item['name']; ?></td>
                            <td><?php echo $item['label']; ?></td>
                            <td><?php echo ucfirst($item['type']); ?></td>
                            <td>
                                <a href="catalog/attribute/edit/<?php echo $item['id']; ?>">Edit</a>
                                <?php
                                if ($item['type'] == 'radio' || $item['type'] == 'dropdown') {
                                    echo '| <a href="catalog/attribute_option/index/' . $item['id'] . '">Attribute Options</a> ';
                                }
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
