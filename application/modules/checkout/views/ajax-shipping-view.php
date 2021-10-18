
<table width="100%" cellpadding="0" cellspacing="0">
    <tbody>
        <tr>
            <td align="right" valign="top">
<!--
                <b>Cart Total</b><br>
-->
                <b>Carriage Charges</b><br>
                <b>Shipping Charges</b><br>               
                <b>Total (Exclusive Vat):</b><br>
                <b> VAT </b><br>                              
                <span><b> Total (inc VAT)</b></span>
                <!--<span><b>Final Order Total</b></span>-->
            </td>
            <td align="right" valign="top">
                <?php
                //~ echo DWS_CURRENCY_SYMBOL . $cart_total,'<br/>';
                echo DWS_CURRENCY_SYMBOL . $this->cart->format_number($delivery_charge),'<br/>';
                $ship = $this->cart->format_number($shipping);
                if (!$ship) { $ship = '0.00'; }
                echo DWS_CURRENCY_SYMBOL . $ship,'<br/>';
                echo DWS_CURRENCY_SYMBOL . $this->cart->format_number($order_total),'<br/>';
                echo DWS_CURRENCY_SYMBOL . $vat,'<br/>';
                echo '<strong>'.DWS_CURRENCY_SYMBOL . $this->cart->format_number($vat_order_total),'</strong><br/>';
                ?>
            </td>
        </tr>
    </tbody>
</table>
