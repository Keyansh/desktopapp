<h1>Add Shipping</h1>
<div id="ctxmenu"><a href="shipping/weight_shipping/">Manage  Shipping</a></div>
<?php $this->load->view('inc-messages'); ?>
<form action="shipping/weight_shipping/add/" method="post" enctype="multipart/form-data" name="addcatform" id="addcatform">
    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="formtable">

        <tr>
            <td width="80"><strong>Weight From  <span class="error"> *</span></strong></td>
            <td width="620"><input name="weight_from" type="text" class="textfield" id="weight_from" value="<?= set_value('weight_from'); ?>" size="40"></td>
        </tr>
        <tr>
            <td><strong>Weight Range To <span class="error"> *</span></strong></td>
            <td><input name="weight_to" type="text" class="textfield" id="weight_to" value="<?= set_value('weight_to'); ?>" size="40" /></td>
        </tr>

        <tr>
            <td><strong>Shipping <span class="error">*</span></strong></td>
            <td><input name="shipping" type="text" class="textfield" id="shipping" value="<?= set_value('shipping'); ?>" size="40" /></td>
        </tr>
        <tr>
            <th>&nbsp;</th>
            <td><input type="submit" name="button" id="button" value="Submit"></td>
        </tr>
        <tr>
            <th>&nbsp;</th>
            <td>Fields marked with <span class="error">*</span> are required.</td>
        </tr>
    </table>
</form>
