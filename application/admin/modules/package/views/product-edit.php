<h1>Edit Product</h1>
<div id="ctxmenu"><a href="package/products/<?php echo $pack_product['product_id']; ?>">Manage Products</a></div>
<?php $this->load->view('inc-messages'); ?>
<form action="package/editproduct/<?php echo $pack_product['product_bundle_item_id']; ?>" method="post" enctype="multipart/form-data" name="add_frm" id="add_frm">
    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="formtable">
        <tr>
            <th>Product <span class="error">*</span></th>
            <td><?php echo form_dropdown('bundled_item_id', $products, set_value('product_id', $pack_product['bundled_item_id']), 'class="textfield" id="bundled_item_id"'); ?></td>
        </tr>
        <tr>
            <th>Quantity <span class="error">*</span></th>
            <td><input name="product_quantity" type="text" class="textfield" id="product_quantity" value="<?php echo set_value('product_quantity', $pack_product['product_quantity']); ?>" size="40"></td>
        </tr>
        <tr>
            <th>Extra Price </th>
            <td><input name="product_extra_price" type="text" class="textfield" id="product_extra_price" value="<?php echo set_value('product_extra_price', $pack_product['product_extra_price']); ?>" size="40" /></td>
        </tr>
        <tr>
            <th>&nbsp;</th>
            <td><input type="submit" name="upload_btn" id="upload_btn" value="Update"></td>
        </tr>
        <tr>
            <th>&nbsp;</th>
            <td>Fields marked with <span class="error">*</span> are required.</td>
        </tr>
    </table>
</form>