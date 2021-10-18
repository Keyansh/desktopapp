<h1>Add Product for <?php echo $package['product_name']; ?> Package</h1>
<div id="ctxmenu"><a href="package/products/<?php echo $package['product_id']; ?>">Manage Products for <?php echo $package['product_name']; ?> Package</a></div>
<?php $this->load->view('inc-messages'); ?>
<form action="package/addproduct/<?php echo $package['product_id']; ?>" method="post" enctype="multipart/form-data" name="add_frm" id="add_frm">
    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="formtable">
        <tr>
            <th>Product <span class="error">*</span></th>
            <td><?php echo form_dropdown('product_id', $products, set_value('product_id'), 'class="textfield" id="product_id"'); ?></td>
        </tr>
        <tr>
            <th>Quantity <span class="error">*</span></th>
            <td><input name="product_quantity" type="text" class="textfield" id="product_quantity" value="<?php echo set_value('product_quantity'); ?>" size="40"></td>
        </tr>
        <tr>
            <th>Extra Price </th>
            <td><input name="product_extra_price" type="text" class="textfield" id="product_extra_price" value="<?php echo set_value('product_extra_price'); ?>" size="40" /></td>
        </tr>
        <tr>
            <th>&nbsp;</th>
            <td><input type="submit" name="upload_btn" id="upload_btn" value="Submit"></td>
        </tr>
        <tr>
            <th>&nbsp;</th>
            <td>Fields marked with <span class="error">*</span> are required.</td>
        </tr>
    </table>
</form>