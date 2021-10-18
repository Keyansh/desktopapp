<h1>Add Pricing Plan</h1>
<div id="ctxmenu"><a href="pricing/pricing_plans/">Manage Pricing Plan</a></div>
<?php $this->load->view('inc-messages'); ?>
<form action="pricing/pricing_plans/add/" method="post" enctype="multipart/form-data" name="addcatform" id="addcatform">
    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="formtable">
        <tr>
            <th width="26%">Pricing plan <span class="error">*</span></th>
            <td width="74%"><input name="pricing_plan" type="text" class="textfield" id="pricing_plan" value="<?php echo set_value('pricing_plan'); ?>" size="40" /></td>
        </tr>
        <tr>
            <th width="26%">Discount (%) <span class="error">*</span></th>
            <td width="74%"><input name="discount" type="text" class="textfield" id="discount" value="<?php echo set_value('discount', 0); ?>" size="10" /></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><input type="submit" name="button" id="button" value="Submit"></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>Fields marked with <span class="error">*</span> are required.</td>
        </tr>
    </table>
</form>
