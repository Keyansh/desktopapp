<h1>Add Supplier</h1>
<div id="ctxmenu"><a href="supplier/">Manage Suppliers</a></div>
<?php $this->load->view('inc-messages'); ?>
<form action="supplier/add" method="post" enctype="multipart/form-data" name="add_frm" id="add_frm">
    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="formtable">
        <tr>
            <th>Supplier Name <span class="error">*</span></th>
            <td><input name="supplier_name" type="text" class="textfield" id="supplier_name" value="<?php echo set_value('supplier_name'); ?>" size="50"></td>
        </tr>
        <tr>
            <th>Email </th>
            <td><input name="email" type="text" class="textfield" id="email" value="<?php echo set_value('email'); ?>" size="50" /></td>
        </tr>
        <tr>
            <th>Phone</th>
            <td><input name="phone" type="text" class="textfield" id="phone" value="<?php echo set_value('phone'); ?>" size="50" /></td>
        </tr>
        <tr>
            <th>Address</th>
            <td><textarea name="address" cols="40" rows="3" style="width:60%" class="textfield" id="address"><?php echo set_value('address'); ?></textarea></td>
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