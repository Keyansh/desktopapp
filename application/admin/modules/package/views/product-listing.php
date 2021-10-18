<h1>Manage Products for <?php echo $package['product_name']; ?> Package</h1>
<div id="ctxmenu"><a href="package/addproduct/<?php echo $package['product_id']; ?>">Add Product</a> | <a href="catalog/product/index/<?php echo $package['show_id']; ?>/<?php echo $package['product_type_id']; ?>">Manage Packages</a></div>

<?php $this->load->view('inc-messages'); ?>

<?php
if (count($products) == 0) {
    $this->load->view('inc-norecords');
    return;
}
?>

<div class="tableWrapper">
    <table width="100%" border="0" cellpadding="2" cellspacing="0">
        <tr>
            <th width="80%">Product Name</th>
            <th width="20%">Action</th>
        </tr>
        <?php foreach ($products as $item) { ?>
            <tr class="<?php echo alternator('', ''); ?>">
                <td><?php echo $item['product_name']; ?></td>
                <td><a href="package/editproduct/<?php echo $item['product_bundle_item_id']; ?>">Edit</a> | <a href="package/deleteproduct/<?php echo $item['product_bundle_item_id']; ?>" onclick="return confirm('Are you sure you want to delete this Product?');">Delete</a></td>
            <?php } ?>
    </table>
</div>