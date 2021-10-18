<div class="row">
    <div class="col-md-9">
        <h2>View Quotation - <?= $quotation['quotation_num']; ?></h2>
    </div>
    <div class="col-md-3">
        <div id="ctxmenu" class="pull-right">
            <a href="order" class="btn btn-primary">Manage Quotations</a>
        </div>
    </div>
</div>
<hr />
<table class="table table-bordered">
    <thead>
        <tr>                                        
            <th align="left">Product Name</th>
            <th align="left">Attributes</th>
            <th align="left">Quantity </th>
            <th align="left">Unit Price </th>
            <th align="left">Subtotal</th>
            <th align="left">Discount % </th>
            <th align="left">Total</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($quotation_items as $content) { ?>
            <tr>
                <td><?= $content['quotation_item_name']; ?></td>
                <td>
                    <?php
                    $prodAttr = json_decode($content['quotation_item_attr']);
                    foreach ($prodAttr as $prodAtt) {
                        echo $prodAtt->attribute_label . ' => ' . $prodAtt->value_label . '<br/>';
                    }
                    ?>
                </td>
                <td><?= $content['quotation_item_qty']; ?></td>
                <td><?= DWS_CURRENCY_SYMBOL . ' ' . $content['quotation_item_price']; ?></td>
                <td><?= DWS_CURRENCY_SYMBOL . ' ' . $content['quotation_item_subtotal']; ?></td>
                <td><?= $content['quotation_item_discount']; ?></td>
                <td><?= DWS_CURRENCY_SYMBOL . ' ' . $content['quotation_item_total']; ?></td>
            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>                                        
            <th colspan="6" align="right">Subtotal</th>
            <th align="left"><?= DWS_CURRENCY_SYMBOL . ' ' . $quotation['cart_total'] ?></th>                                                    
        </tr>
        <tr>                                        
            <th colspan="6" align="right">Shipping</th>
            <th align="left"><?= DWS_CURRENCY_SYMBOL . ' ' . $quotation['shipping'] ?></th>
        </tr>
        <tr>                                        
            <th colspan="6" align="right">VAT</th>
            <th align="left"><?= DWS_CURRENCY_SYMBOL . ' ' . $quotation['vat'] ?></th>
        </tr>
        <tr>                                        
            <th colspan="6" align="right">Grand Total</th>
            <th align="left"><?= DWS_CURRENCY_SYMBOL . ' ' . $quotation['quotation_total'] ?></th>                                                    
        </tr>
    </tfoot> 
</table>
<?php if(!$quotation['confirmed']): ?>
<form method="POST" action="">
    <div class="pull-right">
        <input onclick="return confirm('Do you want convert this quotation to order?')" type="submit" name="approve_order" class="btn btn-primary" value="Approve Order"/>
    </div>    
</form>
<?php endif; ?>