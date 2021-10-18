<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/widgets/datatable/datatable.css">
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable-bootstrap.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable-tabletools.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#datatable-example').dataTable();
    });
</script>
<?php
if (count($users) == 0) {
    $this->load->view('inc-norecords');
    return;
}
?>
<h3 class="title-hero clearfix">
    Manage Users
    <?php if (curUsrId() == '1') { ?>
        <a href="user/add/" class="pull-right btn btn-primary">Add User</a>
    <?php } ?>
</h3>
<div class="panel">
    <div class="panel-body">
        <?php $this->load->view('inc-messages'); ?>
        <div class="example-box-wrapper">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatable-example">
                <thead>
                    <tr>
                        <th style="color: black;">#</th>
                        <th style="color: black;">Fullname</th>
                        <th style="color: black;">Company Name</th>
                        <th style="color: black;">Username</th>
                        <th style="color: black;">Email</th>
                        <th style="color: black;">Role</th>
                        <?php if (curUsrId() == '1') { ?>
                            <th style="color: black;">Action</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($users as $item) {
                        ?>
                        <tr class="<?php echo alternator('even', 'odd'); ?>">
                            <td><?= $i ?></td>
                            <td><?= $item['first_name'] . " " . $item['last_name'] ?></td>
                            <td><?= $item['company_name'] ?></td>
                            <td><?= $item['username']; ?></td>
                            <td><?= $item['email']; ?></td>
                            <td><?= $item['role']; ?></td>
                            <?php if (curUsrId() == '1') { ?>
                                <td class="al-edit-tab" width="13%">

                                    <a href="user/edit/<?php echo $item['user_id']; ?>" title="Edit" class="tooltip-button" data-toggle="tooltip" data-placement="top">
                                        <i class="fa fa-pencil"></i>
                                    </a>                                 
                                    <!-- <a href="product_allocation/assign/category/<?php echo $item['user_id']; ?>" title="Assign" class="tooltip-button" data-toggle="tooltip" data-placement="top">
                                        <i class="fa fa-users green-colors"></i>
                                    </a>    -->
                                    <!-- <a href="user/profile/index/<?php echo $item['user_id']; ?>" title="Manage" class="tooltip-button" data-toggle="tooltip" data-placement="top">
                                        <i class="fa fa-cogs" aria-hidden="true"></i>
                                    </a>   -->
                                    <?php if ($item['user_id'] > 1) { ?>
                                        <a href="user/delete/<?php echo $item['user_id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');" title="Delete" class="tooltip-button" data-toggle="tooltip" data-placement="top">
                                            <i class="fa fa-trash red-color"></i>
                                        </a>
                                    <?php } ?>                                   
                                </td>
                            <?php } ?>
                        </tr>
                        <?php
                        $i++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
