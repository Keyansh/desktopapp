<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>admin/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>admin/assets/widgets/datatable/datatable.css">
<script type="text/javascript" src="<?= base_url(); ?>admin/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>admin/assets/widgets/datatable/datatable-tabletools.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#example').DataTable({
            autoWidth: true,
            bSort: false,
           pageLength: 20
        });

    });</script>
<div class="heading-content-div">
    <p style="text-align: center;"><h1 style="font-size: 30px; color: #263388; text-align:center">Holds</h1></p>
</div>
<?php
$this->load->view('inc-messages');
if (count($getAllPdf) == 0) {
    $this->load->view('inc-norecords');
    echo "</div>";
    return; 
}
?>
<div style="max-width: 80%;margin: auto;padding: 25px;-webkit-box-shadow: -1px 3px 14px -1px rgba(0, 0, 0, 0.15);border-radius: 10px;">

<table id="example" class="display" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th width="10%">#</th>
            <th width="20%">Order number</th>
            <th width="10%">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1 ;foreach ($getAllPdf as $item) { 
            ?>
            <tr>
                <td><?= $i ?></td>
                <td><?= $item['order_number']; ?></td>                
                <td width="10%"><a href="downloads/edit/<?php echo $item['order_number']; ?>"  class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Edit'><i class="fa fa-edit"></i></a></td>
            </tr>
        <?php $i++; } ?>
    </tbody>
    <tfoot>
        <tr>
            <th>#</th>
            <th>Order number</th>
            <th width="10%">Actions</th>
        </tr>
    </tfoot>
</table>
</div>
