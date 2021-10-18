<h1>Edit Coupon</h1>
<div id="ctxmenu"><a href="coupon/index/">Manage Coupons</a></div>
<?php $this->load->view('inc-messages'); ?>
<form action="coupon/edit/<?php echo $coupon['coupon_id']; ?>" method="post" enctype="multipart/form-data" name="addcatform" id="addcatform">
    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="formtable">
        <tr>
            <td width="216"><strong>Coupon Title <span class="error"> *</span></strong></td>
            <td width="1093"><input name="coupon_title" type="text" class="textfield" id="coupon_title" value="<?php echo set_value('coupon_title', $coupon['coupon_title']); ?>" size="40"></td>
        </tr>
        <tr>
            <td><strong>Coupon Code </strong></td>
            <td><input name="coupon_code" type="text" class="textfield" id="coupon_code" value="<?php echo set_value('coupon_code', $coupon['coupon_code']); ?>" size="40" /></td>
        </tr>
        <tr>
            <td><strong>Coupon Value <span class="error"> *</span></strong></td>
            <td><input name="coupon_value" type="text" class="textfield" id="coupon_value" value="<?php echo set_value('coupon_value', $coupon['coupon_value']); ?>" size="40" /></td>
        </tr>
        <tr>
            <td><strong>Coupon Type <span class="error">*</span></strong></td>
            <td><?php echo form_dropdown('coupon_type', $coupon_type, set_value('coupon_type', $coupon['coupon_type']), ' class="textfield width_20"'); ?></td>
        </tr>

        <tr>
            <td><strong>Active From <span class="error"> *</span></strong></td>
            <td><input name="active_from" type="text" class="textfield cidate" readonly="readonly" id="active_from" value="<?php echo set_value('active_from', $coupon['active_from']); ?>" size="40" /></td>
        </tr>
        <tr>
            <td><strong>Active To <span class="error"> *</span></strong></td>
            <td><input name="active_to" type="text" class="textfield cidate" readonly="readonly" id="active_to" value="<?php echo set_value('active_to', $coupon['active_to']); ?>" size="40" /></td>
        </tr>

        <tr>
            <th><input type="hidden" name="coupon_id" id="coupon_id" value="<?php echo $coupon['coupon_id']; ?>" /></th>
            <td><input type="submit" name="button" id="button" value="Submit"></td>
        </tr>
        <tr>
            <th>&nbsp;</th>
            <td>Fields marked with <span class="error">*</span> are required.</td>
        </tr>
    </table>
</form>
