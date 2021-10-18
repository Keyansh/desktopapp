<h1>Add Package</h1>
<div id="ctxmenu"><a href="package">Manage Packages</a></div>
<?php $this->load->view('inc-messages'); ?>
<form action="package/add" method="post" enctype="multipart/form-data" name="add_frm" id="add_frm">
    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="formtable">
        <tr>
            <th>Package Name <span class="error">*</span></th>
            <td><input name="package_name" type="text" class="textfield" id="package_name" value="<?php echo set_value('package_name'); ?>" size="40"></td>
        </tr>
        <tr>
            <th>Package URL Alias </th>
            <td><input name="package_uri_alias" type="text" class="textfield" id="package_uri_alias" value="<?php echo set_value('package_uri_alias'); ?>" size="40">
                &nbsp;(Will be auto-generated if left blank)</td>
        </tr>
        <tr>
            <th>Package Price <span class="error">*</span></th>
            <td><input name="package_price" type="text" class="textfield" id="package_price" value="<?php echo set_value('package_price'); ?>" size="40" /></td>
        </tr>
        <tr>
            <th>Package Description </th>
            <td><textarea name="package_desc" class="textfield" id="package_desc" cols="140" rows="6" ><?php echo set_value('package_desc'); ?></textarea></td>
        </tr>
        <tr>
            <th><input name="show_id" type="hidden" class="textfield" id="show_id" value="<?php echo $show['show_id']; ?>" size="40" /></th>
            <td><input type="submit" name="upload_btn" id="upload_btn" value="Submit"></td>
        </tr>
        <tr>
            <th>&nbsp;</th>
            <td>Fields marked with <span class="error">*</span> are required.</td>
        </tr>
    </table>
</form>