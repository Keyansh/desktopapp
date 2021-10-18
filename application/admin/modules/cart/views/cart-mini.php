
<a href="cart" style ="color:black">
<h5>Shopping Basket</h5>
<table width="100%" border="0" cellspacing="0" cellpadding="3">
    <tr>
        <?php if ($total_items == 0) { ?>
            <td colspan="2">No items are in the basket.</td>
        <?php } else { ?>
            <td colspan="2"><?php echo $total_items; ?> items are in the basket.</td>
        <?php } ?>
    </tr>
    <tr>
        <td width="69%"><strong>TOTAL: <?php echo $total_items; ?> items</strong></td>
        <td width="31%"><strong><?php echo DWS_CURRENCY_SYMBOL; ?><?php echo $order_total; ?></strong></td>
    </tr>
</table>
</a>