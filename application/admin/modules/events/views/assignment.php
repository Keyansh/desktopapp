<h3 class="title-hero clearfix">
    Assigning Users
    <a href="events" class="pull-right btn btn-primary">Manage Events</a>
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
        <form action="events/assign/<?= $eid; ?>" method="post" enctype="multipart/form-data" name="assignform" id="assignform">
            <div class="form-group clearfix">
                <ul class="list-inline">
                    <?php foreach ($users as $item) { ?>
                        <li class="col-lg-2">
                            <div class="text-center userList">
                                <label>
                                    <i class="fa fa-user-o fa-3x"></i>
                                    <input type="checkbox" name="users[]" value="<?php echo $item['user_id']; ?>" <?= (in_array($item['user_id'], $userIds) ? 'checked' : '') ?>/><br />
                                    <span><?php echo $item['first_name'] . ' ' . $item['last_name']; ?></span>
                                </label>
                            </div>

                        </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="form-group text-center clearfix">
                <input type="submit" name="button" id="button" value="Submit" class="btn btn-lg btn-primary">
            </div>
        </form>
    </div>
</div>
