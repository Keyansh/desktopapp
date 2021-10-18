<table width="100%" border="0" cellspacing="0" cellpadding="0" align="left">
    <tr>
        <th>Cart Total:</th>
        <td width="24%"><?php echo DWS_CURRENCY_SYMBOL; ?> <?php echo $this->cart->format_number($cart_total); ?></td> 
    </tr>
    <?php if ($discount) { ?>
        <tr>
            <td>Discount:</td>
            <td><?php echo DWS_CURRENCY_SYMBOL; ?> <?php echo $this->cart->format_number($discount); ?></td>
        </tr>
    <?php } ?>                            
    <tr>
        <th>Carriage Charge:</th>
        <td><?php echo DWS_CURRENCY_SYMBOL; ?> <?php echo $this->cart->format_number($delivery_charge); ?></td>
    </tr>
    <tr>
        <th>Shipping Charge:</th>
        <td><?php echo DWS_CURRENCY_SYMBOL; ?> <?php echo $this->cart->format_number($shipping); ?></td>
    </tr>                           
    <tr>
        <th>Total (Exclusive Vat):</th>
        <td><strong><?php echo DWS_CURRENCY_SYMBOL; ?> <?php echo $this->cart->format_number($order_total); ?></strong></td>
    </tr>
    <tr>
        <th>VAT:</th>
        <td><?php echo DWS_CURRENCY_SYMBOL; ?> <?php echo $this->cart->format_number($vat); ?></td>
    </tr>
    <tr>
        <th>Total (Inclusive Vat <?php echo DWS_VAT . '%' ?>):</th>
        <td><strong><?php echo DWS_CURRENCY_SYMBOL; ?> <?php echo $vat_order_total; ?></strong></td>
    </tr>
</table> 
