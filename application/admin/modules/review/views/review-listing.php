<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/widgets/datatable/datatable.css">
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable-bootstrap.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable-tabletools.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#datatable-example').dataTable();
    });
</script>
<style>
    .nn-style-width-th.sorting {
        width: 86px !important;
    }
</style>
<?php
if (count($reviews) == 0) {
    $this->load->view('inc-norecords');
    return;
}
?>
<h3 class="title-hero clearfix">
    Manage Review
</h3>
<div class="panel">
    <div class="panel-body">
        <?php $this->load->view('inc-messages'); ?>
        <div class="example-box-wrapper">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatable-example">
                <thead>
                    <tr>
                        <th  style="color: black;">#</th>
                        <th style="width: 100px; color: black; width: 81px !important;" class="nn-style-width-th">Stars</th>
                        <!--<th style="color: black;">Summery</th>-->
                        <th style="color: black;">Review</th>
                        <th style="color: black;">Username</th>
                        <th style="color: black;">Product Name</th>
                        <th style="color: black; width:100px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($reviews as $item) {
                        ?>
                        <tr>
                            <td><?= $item['id'] ?></td>
                            <td>
                                <ul class="list-unstyled list-inline" style="margin: 0;">
                                    <?php
                                    for ($i = 1; $i <= $item['rate']; $i++) {
                                        echo '<li style="padding:0;"><img src="images/star-on.png" style="width: 16px;"/></li>';
                                    }
                                    ?>
                                </ul>
                            </td>
                            <!--<td><?//= $item['summery'] ?></td>-->
                            <td><?= $item['review']; ?></td>
                            <td><?= $item['name']; ?></td>
                            <td><?= $item['productname']; ?></td>
                            <td>
                                <a href="review/<?php echo $item['status'] == "1" ? "disable" : "enable" ?>/<?php echo $item['id']; ?>" class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Enable/Disable'><?php echo $item['status'] == "1" ? "<i class='glyph-icon icon-eye green-color'></i>" : "<i class='glyph-icon icon-eye-slash red-color'></i>" ?></a> 
                                <a href="review/delete/<?php echo $item['id']; ?>" onclick="return confirm('Are you sure you want to Delete this Review?');" class='tooltip-button' data-toggle='tooltip' data-placement='top' title="Delete"><i class='glyph-icon icon-linecons-trash red-color'></i></a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>