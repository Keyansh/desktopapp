<h1>Add Show</h1>
<div id="ctxmenu"><a href="package/shows">Manage Shows</a></div>
<?php $this->load->view('inc-messages'); ?>
<form action="package/addshow" method="post" enctype="multipart/form-data" name="add_frm" id="add_frm">
    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="formtable">
        <tr>
            <th>Show Name <span class="error">*</span></th>
            <td><input name="show_name" type="text" class="textfield" id="show_name" value="<?php echo set_value('show_name'); ?>" size="40"></td>
        </tr>
        <tr>
            <th>Show URL Alias </th>
            <td><input name="show_uri_alias" type="text" class="textfield" id="show_uri_alias" value="<?php echo set_value('show_uri_alias'); ?>" size="40">
                &nbsp;(Will be auto-generated if left blank)</td>
        </tr>
        <tr>
            <th>Show Code <span class="error">*</span></th>
            <td><input name="show_code" type="text" class="textfield" id="show_code" value="<?php echo set_value('show_code'); ?>" size="40" /></td>
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