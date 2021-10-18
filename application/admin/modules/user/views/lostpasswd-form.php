<h1>Retrieve Password</h1>
<p>Input your Username in the box below and we will send your password .</p>
<?php $this->load->view('inc-messages'); ?>
<form action="welcome/lostpasswd/" method="post" name="lpFrm" id="lpFrm">
    <table width="100%" border="0" cellspacing="0" cellpadding="2">
        <tr>
            <td width="12%">Username <span class="error"> *</span></td>
            <td width="88%"><input name="username" type="text" class="textfield" id="username" value="<?= set_value('username'); ?>" size="40"></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><small>Fields marked with <span class="error">*</span> are required.</small></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><input type="submit" name="button" id="button" value="Submit"></td>
        </tr>
    </table>
</form>