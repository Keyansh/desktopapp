<h1>Change Password</h1>
<?php $this->load->view('inc-messages'); ?>
<form action="admin/changepassword/" method="post" enctype="multipart/form-data" name="form1" id="form1">
    <table width="100%" border="0" cellspacing="0" cellpadding="2">
        <tr>
            <th width="20%">Old Password <small><span class="error">*</span></small></th>
            <td width="80%"><input name="old_passwd" type="password" class="textfield" id="old_passwd" value="" size="40"></td>
        </tr>
        <tr>
            <th>Password <small><span class="error">*</span></small></th>
            <td><input name="passwd" type="password" class="textfield" id="passwd" value="" size="40"></td>
        </tr>
        <tr>
            <th>Confirm Password <small><span class="error">*</span></small></th>
            <td><input name="passwd1" type="password" class="textfield" id="passwd1" value="" size="40"></td>
        </tr>
        <tr>
            <td><input type="hidden" name="admin_id" id="admin_id" value="<?php echo $this->session->userdata('ADMIN_ID'); ?>"></td>
            <td><small>Fields marked with <span class="error">*</span> are required.</small></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><input type="submit" name="button" id="button" value="Submit"></td>
        </tr>
    </table>
</form>
