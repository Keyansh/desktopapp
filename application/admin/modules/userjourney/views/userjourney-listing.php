<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/widgets/datatable/datatable.css">
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable-bootstrap.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable-tabletools.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.table-bordered').dataTable({});
    });
</script>
<style>
    .example-box-wrapper #myTab>li a {
        background-color: #ffffff;
        color: #263388;
        border: 1px solid #dfe8f1;
    }

    .example-box-wrapper #myTab>li a:hover {
        background: #263388 !important;
        border-color: #263388 !important;
        color: white !important
    }
</style>
<?php
if (count($userjourney) == 0) {
    $this->load->view('inc-norecords');
    return;
}
?>
<h3 class="title-hero clearfix">
    Manage User journey
</h3>
<div class="panel">
    <div class="panel-body">
        <?php $this->load->view('inc-messages'); ?>
        <div class="example-box-wrapper">
            <ul id="myTab" class="nav clearfix nav-tabs">
                <li class="active"><a href="#main" data-toggle="tab">Recent user journey</a></li>
                <li><a href="#tabs-3" data-toggle="tab">User already contacted</a></li>
            </ul>
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade active in" id="main">
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatable-example">
                        <thead>
                            <tr>
                                <th style="color:black;">#</th>
                                <th style="color:black;">Date</th>
                                <th style="color:black;">Name</th>
                                <th style="color:black;">Email</th>
                                <th style="color:black;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = '';
                            // function cmp($a, $b)
                            // {
                            //     return strcmp($a->name, $b->name);
                            // }

                            // usort($userjourney, "cmp");

                            foreach ($userjourney as $item) {
                                if ($item['email_status'] == '0') :
                                    $i++;

                            ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td><?= date("d-m-Y", strtotime($item['comment'])); ?></td>
                                        <?php $userData = getData('user', 'user_id', $item['created_by']) ?>
                                        <td><?= $userData['first_name'] . ' ' . $userData['last_name']; ?></td>
                                        <td><?= $userData['email']; ?></td>
                                        <td>
                                            <a href="userjourney/view/<?php echo $item['created_by'] . '/' . $item['comment']; ?>" class='tooltip-button' data-toggle='tooltip' data-placement='top' title='View'><i class='glyph-icon icon-eye '></i></a>
                                            <a href="userjourney/delete/<?php echo $item['created_by'] . '/' . $item['comment']; ?>" onclick="return confirm('Are you sure you want to Delete?');" class='tooltip-button' data-toggle='tooltip' data-placement='top' title="Delete"><i class='glyph-icon icon-linecons-trash '></i></a>
                                            <a href="3" class="userlogemail tooltip-button" data-user-id="<?php echo $item['created_by'] ?>" data-date="<?php echo $item['comment'] ?>" data-toggle='tooltip' data-placement='top' title="Email"><i class='glyph-icon glyphicon-envelope'></i></a>
                                        </td>
                                    </tr>
                            <?php
                                endif;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="tabs-3">
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatable-example">
                        <thead>
                            <tr>
                                <th style="color:black;">#</th>
                                <th style="color:black;">Date</th>
                                <th style="color:black;">Name</th>
                                <th style="color:black;">Email</th>
                                <th style="color:black;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = '';

                            foreach ($userjourney as $item) {
                                if ($item['email_status'] == 1) :
                                    $i++;

                            ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td><?= date("d-m-Y", strtotime($item['comment'])); ?></td>
                                        <?php $userData = getData('user', 'user_id', $item['created_by']) ?>
                                        <td><?= $userData['first_name'] . ' ' . $userData['last_name']; ?></td>
                                        <td><?= $userData['email']; ?></td>
                                        <td>
                                            <a href="userjourney/view/<?php echo $item['created_by'] . '/' . $item['comment']; ?>" class='tooltip-button' data-toggle='tooltip' data-placement='top' title='View'><i class='glyph-icon icon-eye '></i></a>
                                            <a href="userjourney/delete/<?php echo $item['created_by'] . '/' . $item['comment']; ?>" onclick="return confirm('Are you sure you want to Delete?');" class='tooltip-button' data-toggle='tooltip' data-placement='top' title="Delete"><i class='glyph-icon icon-linecons-trash '></i></a>
                                        </td>
                                    </tr>
                            <?php
                                endif;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    $(document).on('click', '.userlogemail', function(e) {
        e.preventDefault();
        var userId = $(this).attr('data-user-id');
        var dataDate = $(this).attr('data-date');
        $.ajax({
            type: 'POST',
            url: "<?= base_url() ?>userjourney/triggerEmail",
            data: {
                'userId': userId,
                'dataDate': dataDate,
            },
            success: function(data) {
                var obj = jQuery.parseJSON(data);
                alert(obj['content']);
                location.reload();
            }
        });
    });
</script>