<h1>Manage Shows</h1>
<div id="ctxmenu"><a href="package/addshow">Add Show</a></div>

<?php $this->load->view('inc-messages'); ?>

<?php
if (count($shows) == 0) {
    $this->load->view('inc-norecords');
    return;
}
?>

<div class="tableWrapper">
    <table width="100%" border="0" cellpadding="2" cellspacing="0">
        <tr>
            <th width="80%">Show Name</th>
            <th width="20%">Action</th>
        </tr>
        <?php foreach ($shows as $item) { ?>
            <tr class="<?php echo alternator('', ''); ?>">
                <td><?php echo $item['show_name']; ?></td>
                <td><a href="package/editshow/<?php echo $item['show_id']; ?>">Edit</a> | <a href="package/deleteshow/<?php echo $item['show_id']; ?>" onclick="return confirm('Are you sure you want to delete this Show?');">Delete</a> | <a href="catalog/product/index/<?php echo $item['show_id']; ?>/2">Packages</a></td>
            <?php } ?>
    </table>
</div>