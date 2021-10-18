<h1>Pending Customer's Profile </h1>
<div id="ctxmenu"><a href="customer/pending">Manage Pending Customer</a></div>

<h2>Billing Details</h2>
<div class="tableWrapper">
    <table width="100%" border="0" cellspacing="0" cellpadding="3" class="grid">
        <tr>
            <td width="29%"><strong>Name</strong> </td>
            <td width="71%"><?php echo $customer['b_title'] . ' ' . $customer['b_first_name'] . ' ' . $customer['b_last_name']; ?></td>
        </tr>
        <tr>
            <td><strong>Email</strong></td>
            <td><?php echo $customer['email']; ?></td>
        </tr>
        <tr>
            <td><strong>Address 1</strong></td>
            <td><?php echo $customer['b_address1']; ?></td>
        </tr>
        <tr>
            <td><strong>Address 2</strong></td>
            <td><?php echo $customer['b_address2']; ?></td>
        </tr>
        <tr>
            <td><strong>Town/City</strong></td>
            <td><?php echo $customer['b_city']; ?></td>
        </tr>
        <tr>
            <td><strong>County</strong></td>
            <td><?php echo $customer['b_state']; ?></td>
        </tr>
        <tr>
            <td><strong>Postal Code </strong></td>
            <td><?php echo $customer['b_postcode']; ?></td>
        </tr>
        <tr>
            <td><strong>Phone</strong></td>
            <td><?php echo $customer['phone']; ?></td>
        </tr>
    </table>
</div>
<div style="clear: both"></div>
<h2>Approve Registration</h2>
<?php $this->load->view('inc-messages'); ?>
<div style="width:48%; float:left; padding-right:10px">
    <form action="customer/approve/<?php echo $customer['customer_id']; ?>" method="post" enctype="multipart/form-data" name="form1" id="form1">
        <div class="tableWrapper">
            <table width="100%" border="0" cellpadding="3" cellspacing="0" class="grid">
                <tr>
                    <th width="29%"  colspan="2"><h3>End User</h3></th>
                </tr>
                <tr>
                    <td width="29%"><strong>Pricing Plan<span class="error">*</span> </strong></td>
                    <td width="71%"><?php echo form_dropdown('pricing_plan_id', $pricing_plans, set_value('pricing_plan_id', $customer['pricing_plan_id']), ' class="textfield" id="property_type_id"'); ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>Fields marked with<span class="error">*</span> are required.</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td><input type="submit" name="button" id="button" value="Approve Registration"></td>
                </tr>
            </table>
        </div>
    </form>
</div>
