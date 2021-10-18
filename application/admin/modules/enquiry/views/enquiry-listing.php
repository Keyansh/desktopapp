<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/widgets/datatable/datatable.css">
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable-bootstrap.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable-tabletools.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#datatable-example').dataTable({
//            "aaSorting": [[1, 'desc']]
        });
    });
</script>
<?php
if (count($enquiries) == 0) {
    $this->load->view('inc-norecords');
    return;
}
?>
<h3 class="title-hero clearfix">
    Manage Contact enquiries
</h3>
<div class="panel">
    <div class="panel-body">
        <?php $this->load->view('inc-messages'); ?>
        <div class="example-box-wrapper">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatable-example">
                <thead>
                    <tr>
                        <th style="color:black;">#</th>
                        <th style="color:black;">Date/Time</th>
                        <th style="color:black;">Name</th>
                        <th style="color:black;">Email</th>
                        <th style="color:black;">Contact No.</th>
                        <th style="color:black;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = '';
                    foreach ($enquiries as $item) {
                        $i++;
                        ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= date("d-m-Y, h:i A", strtotime($item['addedon'])); ?></td>
                            <td><?= $item['name']; ?></td>
                            <td><?= $item['email']; ?></td>
                            <td><?= $item['telnumber']; ?></td>
                            <td>
                                <a href="enquiry/view/<?php echo $item['id']; ?>" class='tooltip-button' data-toggle='tooltip' data-placement='top' title='View'><i class='glyph-icon icon-eye green-color'></i></a>
                                <a href="enquiry/delete/<?php echo $item['id']; ?>" onclick="return confirm('Are you sure you want to Delete this enquiry?');" class='tooltip-button' data-toggle='tooltip' data-placement='top' title="Delete"><i class='glyph-icon icon-linecons-trash red-color'></i></a>
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
