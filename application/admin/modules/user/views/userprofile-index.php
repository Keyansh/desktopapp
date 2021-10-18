<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/widgets/datatable/datatable.css">
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable-bootstrap.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable-tabletools.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
//        $('#datatable-example').dataTable();
    });
</script>
<?php
if (count($userprofile) == 0) {
    $this->load->view('inc-norecords');
    return;
}
?>
<h3 class="title-hero clearfix">
    Manage Profile Groups
    <a href="user/userprofile/add/" class="pull-right btn btn-primary">Add Profile Group</a>
</h3>
<div class="panel">
    <div class="panel-body">
        <?php $this->load->view('inc-messages'); ?>
        <div class="example-box-wrapper">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatable-example">
                <thead>
                    <tr>
                        <th>Profile</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($userprofile as $list) {
                        $restRict = array(1, 2, 3);
                        ?>
                        <tr class="<?php echo alternator('even', 'odd'); ?>">
                            <td><?= $list['profile_name']; ?></td>
                            <td><?= ($list['is_active']) ? 'Active' : 'De-activated'; ?></td>
                            <td>
                                <a href="user/userprofile/profileconfig/<?php echo $list['id']; ?>" title="Config"><i class='glyph-icon icon-cogs green-color'></i></a>
                                <?php if (!in_array($list['id'], $restRict)) { ?>
                                    | <a href="user/userprofile/edit/<?php echo $list['id']; ?>" title="Edit"><i class='glyph-icon icon-pencil'></i></a>
                                    | <a href="user/userprofile/delete/<?php echo $list['id']; ?>" onclick="return confirm('Are you sure you want to delete this?');" title="Delete"><i class='glyph-icon icon-trash red-color'></i></a>
                                    <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>