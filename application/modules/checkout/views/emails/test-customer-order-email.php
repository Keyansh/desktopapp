

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title> New Account Order Placed</title>
    </head>

    <body>
        <div style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px">
            <p align="center"><span style="font: 18px Arial, Helvetica, sans-serif;">Lof- New Order Placed</span><br />
                <span style="font-size:10px">Dated - {DATE}</span></p>
            <table width="100%" border="0" cellpadding="2" cellspacing="0">
                <tr>
                    <td colspan="2">
                        <b>Dear <?= $DATA['s_first_name'].' '.$DATA['s_last_name']?> your order is placed, please wait for dispatched.</b>
                    </td>
                </tr>
                <tr>
                    <td valign="top"><strong>Order Details</strong></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td width="16%"><b>Order No.</b></td>
                    <td width="84%">: <?php echo $DATA['order_num']; ?></td>
                </tr>
                <tr>

                    <td><b>Subtotal</b></td>
                    <td>: <?php echo DWS_CURRENCY_SYMBOL . ' ' . $DATA['cart_total']; ?></td>
                </tr>
                <tr>
                    <td><b>Total</b></td>
                    <td>: <?php echo DWS_CURRENCY_SYMBOL . ' ' . $DATA['order_total']; ?></td>
                </tr>

                <tr>
                    <td valign="top">&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td valign="top"><strong>Delivery Address</strong></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td width="20%" valign="top">First Name</td>
                    <td width="80%"><?php echo $DATA['s_first_name'] ?></td>
                </tr>
                <tr>
                    <td valign="top">Last Name</td>
                    <td><?php echo $DATA['s_last_name'] ?></td>
                </tr>
                <tr>
                    <td valign="top">Street 1</td>
                    <td><?php echo $DATA['s_address1'] ?></td>
                </tr>
                <tr>
                    <td valign="top">Street 2</td>
                    <td><?php echo $DATA['s_address2'] ?></td>
                </tr>
                <tr>
                    <td valign="top">City</td>
                    <td><?php echo $DATA['s_city'] ?></td>
                </tr>
                <tr>
                    <td valign="top">State</td>
                    <td><?php echo $DATA['s_county'] ?></td>
                </tr>
                <tr>
                    <td valign="top">ZIP Code</td>
                    <td><?php echo $DATA['s_postcode'] ?></td>
                </tr>
                <tr>
                    <td valign="top">Phone</td>
                    <td><?php echo $DATA['s_phone'] ?></td>
                </tr><tr>
                    <td valign="top">Email</td>
                    <td><?php echo $DATA['email'] ?></td>
                </tr>
                <tr>
                    <td valign="top">&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="4" style="border: 1px solid #CCC;">
                <tr style="text-align:left; background-color:#CCC">
                    <th width="30%">Item</th>
                    <th width="20%">Item Name</th>
                    <th width="15%">Quantity</th>
                    <th width="17%">Price</th>
                    <th width="18%">Amount</th>
                </tr>
                <?php
                foreach ($cart_content as $item) {
                    ?>
                    <tr>
                        <td><?php
                            echo $item['order_item_qty'];
                            ?>

                        </td>
                        <td><?php echo $item['order_item_name']; ?> </td>
                        <td><?php echo $item['order_item_qty']; ?>&nbsp;</td>
                        <td><?php echo DWS_CURRENCY_SYMBOL . ' ' . number_format($item['order_item_price'], 2); ?></td>
                        <td><?php echo DWS_CURRENCY_SYMBOL . ' ' . number_format($item['order_item_price'] * $item['order_item_qty'], 2); ?>&nbsp;</td>

                    </tr>
                <?php } ?>
            </table>

        </div>
    </body>
</html>
