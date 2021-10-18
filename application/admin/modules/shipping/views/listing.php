<h1>Manage Shipping</h1>
<div id="ctxmenu"><a href="shipping/weight_shipping/add/">Add Shipping</a></div>

<?php $this->load->view('inc-messages'); ?>

<?php
if (count($shippings) == 0) {
    $this->load->view('inc-norecords');
    return;
}
?>

<div class="tableWrapper">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="grid">
        <tr>
            <th width="23%">Weight From</th>
            <th width="32%">Weight To</th>
            <th width="30%">Shipping</th>
            <th width="15%">Action</th>
        </tr>
<?php foreach ($shippings as $item) { ?>
            <tr class="<?php echo alternator('', 'alt'); ?>">
                <td><?php echo $item['weight_from']; ?></td>
                <td><?php echo $item['weight_to']; ?></td>
                <td><?php echo $item['shipping']; ?></td>
                <td> <a href="shipping/weight_shipping/edit/<?php echo $item['shipping_id']; ?>">Edit</a> | <a href="shipping/weight_shipping/delete/<?php echo $item['shipping_id']; ?>" onclick="return confirm('Are you sure you want to delete this Shipping?');">Delete</a></td>
            </tr>
<?php } ?>
    </table>
</div>

<p style="text-align:center"><?php echo $pagination; ?></p>