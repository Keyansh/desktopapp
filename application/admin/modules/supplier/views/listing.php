<h1>Manage Suppliers</h1>
<div id="ctxmenu"><a href="supplier/add">Add Supplier</a></div>

<?php $this->load->view('inc-messages'); ?>

<?php
if (count($suppliers) == 0) {
    $this->load->view('inc-norecords');
    return;
}
?>

<div class="tableWrapper">
    <table width="100%" border="0" cellpadding="2" cellspacing="0">
        <tr>
            <th width="20%">Name</th>
            <th width="20%">Email</th>
            <th width="15%">Phone</th>
            <th width="25%">Address</th>
            <th width="15%">Action</th>
        </tr>
<?php foreach ($suppliers as $item) { ?>
            <tr class="<?php echo alternator('', 'alt') ?>">
                <td><?php echo $item['supplier_name']; ?></td>
                <td><?php echo $item['email']; ?></td>
                <td><?php echo $item['phone']; ?></td>
                <td><?php echo nl2br($item['address']); ?></td>

                <td><a href="supplier/edit/<?php echo $item['supplier_id']; ?>">Edit</a> | <a href="supplier/delete/<?php echo $item['supplier_id']; ?>" onclick="return confirm('Are you sure you want to delete this Supplier?');">Delete</a></td>
            </tr>
<?php } ?>
    </table>
</div>
<p align="center"><?php echo $pagination; ?></p>