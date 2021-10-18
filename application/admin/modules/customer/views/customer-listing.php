<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/widgets/datatable/datatable.css">
<script type="text/javascript" src="<?= base_url(); ?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable-tabletools.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.table-bordered').dataTable({
            autoWidth: true,
            bSort: false,
            pageLength: 15
        });
    });
</script>
<h3 class="title-hero clearfix">
    Manage Customer
    <?php if (curUsrId() == '1') { ?>
        <!-- <a href="customer/customer_add/" class="pull-right btn btn-primary">Add Customer</a> -->
    <?php } ?>
</h3>
<?php
if (count($users) == 0) {
    $this->load->view('inc-norecords');
    return;
}
?>
<div class="panel">
    <div class="panel-body">
        <?php $this->load->view('inc-messages'); ?>
        <div class="example-box-wrapper">

            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#home">All Users</a></li>
                <li><a data-toggle="tab" href="#menu1">Active Users</a></li>
                <li><a data-toggle="tab" href="#menu2">Deactivated</a></li>
                <!-- <li><a data-toggle="tab" href="#menu3">Declined Users</a></li> -->
                <li><a data-toggle="tab" href="#menu4">Pending Users</a></li>
            </ul>

            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatable-example">
                        <thead>
                            <tr>
                                <th style="color: black;">#</th>
                                <th style="color: black;">Fullname</th>
                                <th style="color: black;">Company Name</th>
                                <th style="color: black;">Email</th>
                                <th style="color: black;">Location</th>
                                <th style="color: black;">Status</th>
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
                                    <td><?= $item['email']; ?></td>
                                    <td><?= $item['location']; ?></td>
                                    <td>
                                        <?php if ($item['user_is_active'] == 1) { ?>
                                            <span style="background-color: #22b14c;color: white;padding: 10px 10px;display: inline-block;min-width: 100px;text-align: center;">Activated</span>
                                        <?php } ?>
                                        <?php if (($item['user_is_active'] == 0) || ($item['user_is_active'] == 2)) { ?>
                                            <span style="background-color: #0b32ea;color: white;padding: 10px 10px;display: inline-block;min-width: 100px;text-align: center;">Deactivated</span>
                                        <?php } ?>
                                        <?php //if ($item['user_is_active'] == 2) { 
                                        ?>
                                        <!-- <span style="background-color: #ed1c24;color: white;padding: 10px 10px;display: inline-block;min-width: 100px;text-align: center;">Declined</span> -->
                                        <?php //} 
                                        ?>
                                        <?php if ($item['user_is_active'] == 3) { ?>
                                            <span style="background-color: yellow;color: black;padding: 10px 10px;display: inline-block;min-width: 100px;text-align: center;">Pending</span>
                                        <?php } ?>
                                    </td>
                                    <?php if (curUsrId() == '1') { ?>
                                        <td class="al-edit-tab" width="13%">
                                            <a href="customer/edit/<?php echo $item['customer_id']; ?>" title="Edit" class="tooltip-button" data-toggle="tooltip" data-placement="top">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <?php if ($item['customer_id'] > 1) { ?>
                                                <a href="customer/delete/<?php echo $item['customer_id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');" title="Delete" class="tooltip-button" data-toggle="tooltip" data-placement="top">
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
                <div id="menu1" class="tab-pane fade">
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatable-example">
                        <thead>
                            <tr>
                                <th style="color: black;">#</th>
                                <th style="color: black;">Fullname</th>
                                <th style="color: black;">Company Name</th>
                                <th style="color: black;">Email</th>
                                <th style="color: black;">Location</th>
                                <th style="color: black;">Status</th>
                                <?php if (curUsrId() == '1') { ?>
                                    <th style="color: black;">Action</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($users as $item) {
                                if ($item['user_is_active'] == 1) {
                            ?>
                                    <tr class="<?php echo alternator('even', 'odd'); ?>">
                                        <td><?= $i ?></td>
                                        <td><?= $item['first_name'] . " " . $item['last_name'] ?></td>
                                        <td><?= $item['company_name'] ?></td>
                                        <td><?= $item['email']; ?></td>
                                        <td><?= $item['location']; ?></td>
                                        <td>
                                            <?php if ($item['user_is_active'] == 1) { ?>
                                                <span style="background-color: #22b14c;color: white;padding: 10px 10px;display: inline-block;min-width: 100px;text-align: center;">Activated</span>
                                            <?php } ?>
                                            <?php if (($item['user_is_active'] == 0) || ($item['user_is_active'] == 2)) { ?>
                                                <span style="background-color: #0b32ea;color: white;padding: 10px 10px;display: inline-block;min-width: 100px;text-align: center;">Deactivated</span>
                                            <?php } ?>
                                            <!-- <?php if ($item['user_is_active'] == 2) { ?>
                                                <span style="background-color: #ed1c24;color: white;padding: 10px 10px;display: inline-block;min-width: 100px;text-align: center;">Declined</span>
                                            <?php } ?> -->
                                            <?php if ($item['user_is_active'] == 3) { ?>
                                                <span style="background-color: yellow;color: black;padding: 10px 10px;display: inline-block;min-width: 100px;text-align: center;">Pending</span>
                                            <?php } ?>
                                        </td>
                                        <?php if (curUsrId() == '1') { ?>
                                            <td class="al-edit-tab" width="13%">
                                                <a href="customer/edit/<?php echo $item['customer_id']; ?>" title="Edit" class="tooltip-button" data-toggle="tooltip" data-placement="top">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <?php if ($item['customer_id'] > 1) { ?>
                                                    <a href="customer/delete/<?php echo $item['customer_id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');" title="Delete" class="tooltip-button" data-toggle="tooltip" data-placement="top">
                                                        <i class="fa fa-trash red-color"></i>
                                                    </a>
                                                <?php } ?>
                                            </td>
                                        <?php } ?>
                                    </tr>
                            <?php
                                    $i++;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div id="menu2" class="tab-pane fade">
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatable-example">
                        <thead>
                            <tr>
                                <th style="color: black;">#</th>
                                <th style="color: black;">Fullname</th>
                                <th style="color: black;">Company Name</th>
                                <th style="color: black;">Email</th>
                                <th style="color: black;">Location</th>
                                <th style="color: black;">Status</th>
                                <?php if (curUsrId() == '1') { ?>
                                    <th style="color: black;">Action</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($users as $item) {
                                if (($item['user_is_active'] == 0) || ($item['user_is_active'] == 2)) {
                            ?>
                                    <tr class="<?php echo alternator('even', 'odd'); ?>">
                                        <td><?= $i ?></td>
                                        <td><?= $item['first_name'] . " " . $item['last_name'] ?></td>
                                        <td><?= $item['company_name'] ?></td>
                                        <td><?= $item['email']; ?></td>
                                        <td><?= $item['location']; ?></td>
                                        <td>
                                            <?php if ($item['user_is_active'] == 1) { ?>
                                                <span style="background-color: #22b14c;color: white;padding: 10px 10px;display: inline-block;min-width: 100px;text-align: center;">Activated</span>
                                            <?php } ?>
                                            <?php if (($item['user_is_active'] == 0) || ($item['user_is_active'] == 2)) { ?>
                                                <span style="background-color: #0b32ea;color: white;padding: 10px 10px;display: inline-block;min-width: 100px;text-align: center;">Deactivated</span>
                                            <?php } ?>
                                            <!-- <?php if ($item['user_is_active'] == 2) { ?>
                                                <span style="background-color: #ed1c24;color: white;padding: 10px 10px;display: inline-block;min-width: 100px;text-align: center;">Declined</span>
                                            <?php } ?> -->
                                            <?php if ($item['user_is_active'] == 3) { ?>
                                                <span style="background-color: yellow;color: black;padding: 10px 10px;display: inline-block;min-width: 100px;text-align: center;">Pending</span>
                                            <?php } ?>
                                        </td>
                                        <?php if (curUsrId() == '1') { ?>
                                            <td class="al-edit-tab" width="13%">
                                                <a href="customer/edit/<?php echo $item['customer_id']; ?>" title="Edit" class="tooltip-button" data-toggle="tooltip" data-placement="top">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <?php if ($item['customer_id'] > 1) { ?>
                                                    <a href="customer/delete/<?php echo $item['customer_id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');" title="Delete" class="tooltip-button" data-toggle="tooltip" data-placement="top">
                                                        <i class="fa fa-trash red-color"></i>
                                                    </a>
                                                <?php } ?>
                                            </td>
                                        <?php } ?>
                                    </tr>
                            <?php
                                    $i++;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div id="menu3" class="tab-pane fade">
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatable-example">
                        <thead>
                            <tr>
                                <th style="color: black;">#</th>
                                <th style="color: black;">Fullname</th>
                                <th style="color: black;">Company Name</th>
                                <th style="color: black;">Email</th>
                                <th style="color: black;">Location</th>
                                <th style="color: black;">Status</th>
                                <?php if (curUsrId() == '1') { ?>
                                    <th style="color: black;">Action</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($users as $item) {
                                if ($item['user_is_active'] == 2) {
                            ?>
                                    <tr class="<?php echo alternator('even', 'odd'); ?>">
                                        <td><?= $i ?></td>
                                        <td><?= $item['first_name'] . " " . $item['last_name'] ?></td>
                                        <td><?= $item['company_name'] ?></td>
                                        <td><?= $item['email']; ?></td>
                                        <td><?= $item['location']; ?></td>
                                        <td>
                                            <?php if ($item['user_is_active'] == 1) { ?>
                                                <span style="background-color: #22b14c;color: white;padding: 10px 10px;display: inline-block;min-width: 100px;text-align: center;">Activated</span>
                                            <?php } ?>
                                            <?php if (($item['user_is_active'] == 0) || ($item['user_is_active'] == 2)) { ?>
                                                <span style="background-color: #0b32ea;color: white;padding: 10px 10px;display: inline-block;min-width: 100px;text-align: center;">Deactivated</span>
                                            <?php } ?>
                                            <!-- <?php if ($item['user_is_active'] == 2) { ?>
                                                <span style="background-color: #ed1c24;color: white;padding: 10px 10px;display: inline-block;min-width: 100px;text-align: center;">Declined</span>
                                            <?php } ?> -->
                                            <?php if ($item['user_is_active'] == 3) { ?>
                                                <span style="background-color: yellow;color: black;padding: 10px 10px;display: inline-block;min-width: 100px;text-align: center;">Pending</span>
                                            <?php } ?>
                                        </td>
                                        <?php if (curUsrId() == '1') { ?>
                                            <td class="al-edit-tab" width="13%">
                                                <a href="customer/edit/<?php echo $item['customer_id']; ?>" title="Edit" class="tooltip-button" data-toggle="tooltip" data-placement="top">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <?php if ($item['customer_id'] > 1) { ?>
                                                    <a href="customer/delete/<?php echo $item['customer_id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');" title="Delete" class="tooltip-button" data-toggle="tooltip" data-placement="top">
                                                        <i class="fa fa-trash red-color"></i>
                                                    </a>
                                                <?php } ?>
                                            </td>
                                        <?php } ?>
                                    </tr>
                            <?php
                                    $i++;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div id="menu4" class="tab-pane fade">
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatable-example">
                        <thead>
                            <tr>
                                <th style="color: black;">#</th>
                                <th style="color: black;">Fullname</th>
                                <th style="color: black;">Company Name</th>
                                <th style="color: black;">Email</th>
                                <th style="color: black;">Location</th>
                                <th style="color: black;">Status</th>
                                <?php if (curUsrId() == '1') { ?>
                                    <th style="color: black;">Action</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($users as $item) {
                                if ($item['user_is_active'] == 3) {
                            ?>
                                    <tr class="<?php echo alternator('even', 'odd'); ?>">
                                        <td><?= $i ?></td>
                                        <td><?= $item['first_name'] . " " . $item['last_name'] ?></td>
                                        <td><?= $item['company_name'] ?></td>
                                        <td><?= $item['email']; ?></td>
                                        <td><?= $item['location']; ?></td>
                                        <td>
                                            <?php if ($item['user_is_active'] == 1) { ?>
                                                <span style="background-color: #22b14c;color: white;padding: 10px 10px;display: inline-block;min-width: 100px;text-align: center;">Activated</span>
                                            <?php } ?>
                                            <?php if (($item['user_is_active'] == 0) || ($item['user_is_active'] == 2)) { ?>
                                                <span style="background-color: #0b32ea;color: white;padding: 10px 10px;display: inline-block;min-width: 100px;text-align: center;">Deactivated</span>
                                            <?php } ?>
                                            <!-- <?php if ($item['user_is_active'] == 2) { ?>
                                                <span style="background-color: #ed1c24;color: white;padding: 10px 10px;display: inline-block;min-width: 100px;text-align: center;">Declined</span>
                                            <?php } ?> -->
                                            <?php if ($item['user_is_active'] == 3) { ?>
                                                <span style="background-color: yellow;color: black;padding: 10px 10px;display: inline-block;min-width: 100px;text-align: center;">Pending</span>
                                            <?php } ?>
                                        </td>
                                        <?php if (curUsrId() == '1') { ?>
                                            <td class="al-edit-tab" width="13%">
                                                <a href="customer/edit/<?php echo $item['customer_id']; ?>" title="Edit" class="tooltip-button" data-toggle="tooltip" data-placement="top">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <?php if ($item['customer_id'] > 1) { ?>
                                                    <a href="customer/delete/<?php echo $item['customer_id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');" title="Delete" class="tooltip-button" data-toggle="tooltip" data-placement="top">
                                                        <i class="fa fa-trash red-color"></i>
                                                    </a>
                                                <?php } ?>
                                            </td>
                                        <?php } ?>
                                    </tr>
                            <?php
                                    $i++;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
    </div>
</div>