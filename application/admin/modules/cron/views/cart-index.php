<table style="font-family: roboto; font-weight: 300; color: #333333; font-size: 14px; width: 100%;" border="0">
    <thead>
        <tr>                                        
            <th align="left">Product Name</th>
            <th align="left">Quantity </th>
            <th align="left">Unit Price </th>
            <th align="left">Subtotal</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orderitems as $content) { ?>
            <tr>
                <td><?= $content['order_item_name']; ?></td>
                <td><?= $content['order_item_qty']; ?></td>
                <td><?= DWS_CURRENCY_SYMBOL . ' ' . number_format($content['order_item_price'], 2); ?></td>
                <td><?= DWS_CURRENCY_SYMBOL . ' ' . number_format(($content['order_item_qty'] * $content['order_item_price']), 2); ?></td>
            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>                                        
            <th colspan="3" align="right">Subtotal</th>
            <th align="left"><?= DWS_CURRENCY_SYMBOL . ' ' . number_format($orderdetail['cart_total'], 2) ?></th>                                                    
        </tr>

        <tr>                                        
            <th colspan="3" align="right">VAT</th>
            <th align="left"><?= DWS_CURRENCY_SYMBOL . ' ' . number_format($orderdetail['vat'], 2) ?></th>                                                    
        </tr>
        <tr>                                        
            <th colspan="3" align="right">Grand Total</th>
            <th align="left"><?= DWS_CURRENCY_SYMBOL . ' ' . number_format($orderdetail['order_total'], 2) ?></th>                                                    
        </tr>
    </tfoot> 
</table>