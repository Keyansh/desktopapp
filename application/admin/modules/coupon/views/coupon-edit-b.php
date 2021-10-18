<h1>Edit Coupon</h1>
<div id="ctxmenu"><a href="coupon/index">Manage Coupons</a></div>
<?php $this->load->view('inc-messages'); ?>
<form action="coupon/edit/<?php echo $coupon['id']; ?>" method="post" enctype="multipart/form-data" name="addcatform" id="addcatform">
    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="formtable">
        <tr>
            <td width="20%"><strong>Coupon Title <span class="error"> *</span></strong></td>
            <td width="80%"><input name="coupon_title" type="text" class="textfield" id="coupon_title" value="<?php echo set_value('coupon_title', $coupon['coupon_title']); ?>" size="40"></td>
        </tr>
        <tr>
            <td><strong>Coupon Code <span class="error">*</span></strong></td>
            <td><input name="coupon_code" type="text" class="textfield" id="coupon_code" value="<?php echo set_value('coupon_code', $coupon['coupon_code']); ?>" size="40" /></td>
        </tr>

        
        <tr>
            <td><strong>Active From <span class="error"> *</span></strong></td>
            <td><input name="active_date" type="text" class="textfield cidate" readonly="readonly" id="active_date" value="<?php echo set_value('active_date', $coupon['active_date']); ?>" size="40" /></td>
        </tr>
        
        <tr>
            <td><strong>Expire Date <span class="error"> *</span></strong></td>
            <td><input name="expire_date" type="text" class="textfield cidate" readonly="readonly" id="expire_date" value="<?php echo set_value('expire_date', $coupon['expire_date']); ?>" size="40" /></td>
        </tr>

        <tr>
            <td><strong>Minimum Order Value </strong></td>

            <td><input name="min_basket_value" type="text" class="textfield" id="min_basket_value" value="<?php echo set_value('min_basket_value', $coupon['min_basket_value']); ?>" size="40" /></td>
        </tr>
        <tr>

            <th><input type="hidden" name="id" id="coupon_id" value="<?php echo $coupon['id']; ?>" /></th>
            <td><input type="submit" name="button" id="button" value="Submit"></td>
        </tr>
        <tr>
            <th>&nbsp;</th>
            <td>Fields marked with <span class="error">*</span> are required.</td>
        </tr>
    </table>
</form>

