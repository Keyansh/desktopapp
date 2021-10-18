<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/widgets/datatable/datatable.css">
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable-bootstrap.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable-tabletools.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#datatable-example').dataTable({
            //            "aaSorting": [[1, 'desc']]
        });
    });
</script>

<?php
$this->load->view('inc-messages');
if (count($newsComments) == 0) {
    $this->load->view('inc-norecords');
    echo "</div>";
    return;
}
?>
<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatable-example">
    <thead>
        <tr>
            <th width="10%">#</th>
            <th width="20%">Name</th>
            <th>Email</th>
            <th width="20%">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1;
        foreach ($newsComments as $item) { ?>
            <tr>
                <td><?= $i; ?></td>
                <td><?php echo $item['c_name']; ?></td>
                <td><?php echo $item['c_mail']; ?></td>
                <td>
                    <?php
                    if ($item['active'] == 0) {
                    ?>
                        <span id="<?php echo $item['id'] ?>" class="toggle-status" style="cursor: pointer;color: green;">Enable</span>
                    <?php
                    } else {
                    ?>
                        <span id="<?php echo $item['id'] ?>" class="toggle-status" style="cursor: pointer;color: red;">Disable</span>
                    <?php
                    }
                    ?>
                    |
                    <a href="news/commentView/<?php echo $item['id']; ?>" class='tooltip-button' data-toggle='tooltip' data-placement='top' title='View'><i class="glyph-icon icon-linecons-eye  "></i></a>|
                    <a href="news/commentDelete/<?php echo $item['id']; ?>/<?php echo $item['news_id']; ?>" onclick="return confirm('Are you sure you want to delete this Comment?');" class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Delete'><i class="glyph-icon icon-linecons-trash red-color"></i></a>
                </td>
            <?php $i++;
        } ?>
    </tbody>
    <tfoot>
        <tr>
            <th width="10%">#</th>
            <th width="20%">Name</th>
            <th>Email</th>
            <th width="20%">Actions</th>
        </tr>
    </tfoot>
</table>




<script src="js/a_toggle.js"></script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->

<script type="text/javascript">
    // $(document).ready(function() {
    $(document).on('click', '.toggle-status', function() {
        // $('.toggle-status').click(function() {
        var path = '<?php echo base_url() ?>news/commenttoggle';
        var id = $(this).attr('id');

        toggle_item(path, id);
    });
    // });
</script>