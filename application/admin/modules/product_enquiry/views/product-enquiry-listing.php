<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/widgets/datatable/datatable.css">
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable-bootstrap.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable-tabletools.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#datatable-example').dataTable({
            "aaSorting": [[ 3, 'dsec' ]]
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
    Manage Product Enquiries
</h3>
<div class="panel">
    <div class="panel-body">
        <?php $this->load->view('inc-messages'); ?>
        <div class="example-box-wrapper">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatable-example">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th id="date-th">Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($enquiries as $item) {
                        ?>
                        <tr>
                            <td><?php echo $item['fname'] . ' ' . $item['lname'] ?></td>
                            <td><?php echo $item['email'] ?></td>
                            <td><?php echo $item['phone'] ?></td>
                            <td><?php echo date('M. d, Y', $item['added_on']) ?></td>
                            <td>
                                <a href="product_enquiry/view/<?php echo $item['id']; ?>" class='tooltip-button' data-toggle='tooltip' data-placement='top' title='View'><i class='glyph-icon icon-eye green-color'></i></a>
                                <a href="product_enquiry/delete/<?php echo $item['id']; ?>" onclick="return confirm('Are you sure you want to Delete this enquiry?');" class='tooltip-button' data-toggle='tooltip' data-placement='top' title="Delete"><i class='glyph-icon icon-linecons-trash red-color'></i></a>
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
