<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/widgets/datatable/datatable.css">
<script type="text/javascript" src="<?= base_url(); ?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable-tabletools.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#example').DataTable({
            autoWidth: true,
            bSort: false,
            columnDefs: [
                {
                    targets: [0, 1, 2, 3],
                    orderable: false
                },
            ],
            pageLength: 20
        });

    });</script>
    <style>
    @media(min-width:1500px){
        #example_wrapper{
/* width:70%; */
        }
    }
    
    </style>
<h3 class="title-hero clearfix">
    Manage Customer Group
    <a href="profilegroup/add" class="pull-right btn btn-primary">Add Customer Group</a>
</h3>
<?php
$this->load->view('inc-messages');
if (count($profile_group) == 0) {
    $this->load->view('inc-norecords');
    echo "</div>";
    return;
}
?>
<table id="example" class="display table-width-set" cellspacing="0">
    <thead>
        <tr>
            <th style="color: white;" width="10%">#</th>
            <th style="color: white;" width="20%">Group</th>
            <th style="color: white;">Date</th>            
            <th  style="color: white;" width="10%">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        foreach ($profile_group as $item) {
            $i++;
            ?>
            <tr>
                <td width="75"/><?= $i ?></td>
                <td><?php echo $item['group']; ?></td>
                <td>
                    <?php
                    $newDate = date("d-m-Y", strtotime($item['addedon']));
                    echo $newDate;
                    ?>
                </td>
                <td>
                    <a href="profilegroup/edit/<?php echo $item['id']; ?>"class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Edit'><i class="glyph-icon icon-linecons-pencil"></i></a>
                    | <a href="profilegroup/delete/<?php echo $item['id']; ?>" onclick="return confirm('Are you sure you want to delete this group?');"  class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Delete'><i class="glyph-icon icon-linecons-trash red-color"></i></a>
                </td>
            <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <th>#</th>
            <th>Group</th>
            <th>Date</th>            
            <th width="10%">Actions</th>
        </tr>
    </tfoot>
</table>