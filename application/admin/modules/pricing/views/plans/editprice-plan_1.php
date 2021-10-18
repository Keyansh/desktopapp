<h1>Update Price</h1>
<div id="ctxmenu"><a href="pricing/plan/index/<?php echo $pricing_plan['pricing_plan_id']; ?>">Manage  Prices</a></div>
<?php $this->load->view('inc-messages'); ?>
<form action="pricing/plan/edit/<?php echo $pricing_plan['product_pricing_id']; ?>" method="post" enctype="multipart/form-data" name="addcatform" id="addcatform">
    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="formtable">

        <tr>
            <th width="26%">Product Price <span class="error">*</span></th>
            <td width="74%"><input name="pricing_plan" type="text" class="textfield" id="pricing_plan" value="<?php echo set_value('pricing_plan', $pricing_plan['product_price']); ?>" size="40" />
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><input type="hidden" name="product_pricing_id" id="product_pricing_id" value="<?php echo $pricing_plan['product_pricing_id']; ?>"><input type="submit" name="button" id="button" value="Submit"></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>Fields marked with <span class="error">*</span> are required.</td>
        </tr>
    </table>
</form>
