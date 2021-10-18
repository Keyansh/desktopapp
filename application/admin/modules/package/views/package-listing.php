<h1>Manage <?php echo $show['show_name']; ?> Packages</h1>
<div id="ctxmenu"><a href="package/add/<?php echo $show['show_id']; ?>">Add Package</a></div>

<?php $this->load->view('inc-messages'); ?>

<?php
if (count($packages) == 0) {
    $this->load->view('inc-norecords');
    return;
}
?>

<div class="tableWrapper">
    <table width="100%" border="0" cellpadding="2" cellspacing="0">
        <tr>
            <th width="80%">Package Name</th>
            <th width="20%">Action</th>
        </tr>
        <?php foreach ($packages as $item) { ?>
            <tr class="<?php echo alternator('', ''); ?>">
                <td><?php echo $item['package_name']; ?></td>
                <td><a href="package/edit/<?php echo $item['package_id']; ?>">Edit</a> | <a href="package/delete/<?php echo $item['package_id']; ?>" onclick="return confirm('Are you sure you want to delete this Package?');">Delete</a> | <a href="package/products/<?php echo $item['package_id']; ?>">Products</a></td>
            <?php } ?>
    </table>
</div>
<p align="center"><?php echo $pagination; ?></p>