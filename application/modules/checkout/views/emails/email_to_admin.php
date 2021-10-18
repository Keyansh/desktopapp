<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title> New Account Order Placed</title>
    </head>

    <body>
        <div style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px">
            <p align="center"><span style="font: 18px Arial, Helvetica, sans-serif;">Lof - New Order Placed</span><br />
                <span style="font-size:10px">Dated - <?php echo $DATE ?></span></p>
            <table width="100%" border="0" cellpadding="2" cellspacing="0">
                <tr>
                    <td valign="top"><strong>Order Details</strong></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td width="16%"><b>Order No.</b></td>
                    <td width="84%">: <?php echo $ORDER_NUM; ?></td>
                </tr>
                <tr>

                    <td><b>Total</b></td>
                    <td>: <?php echo DWS_CURRENCY_SYMBOL . ' ' . $order_total; ?></td>
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
                    <td width="80%"><?= $B_FIRSTNAME ?></td>
                </tr>
                <tr>
                    <td valign="top">Last Name</td>
                    <td><?= $B_LASTNAME ?></td>
                </tr>
                <tr>
                    <td valign="top">Street 1</td>
                    <td><?php echo $B_STREET ?></td>
                </tr>
                <tr>
                    <td valign="top">Street 2</td>
                    <td><?php echo $B_STREET2 ?></td>
                </tr>
                <tr>
                    <td valign="top">City</td>
                    <td><?= $B_CITY; ?></td>
                </tr>
                <tr>
                    <td valign="top">State</td>
                    <td><?php echo $DATA['s_county'] ?></td>
                </tr>
                <tr>
                    <td valign="top">ZIP Code</td>
                    <td><?php echo $S_POSTCODE ?></td>
                </tr>
                <tr>
                    <td valign="top">Phone</td>
                    <td><?php echo $S_PHONE ?></td>
                </tr><tr>
                    <td valign="top">Email</td>
                    <td><?php echo $EMAIL ?></td>
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
                    if ($items) {
                        foreach ($items as $k => $v) {
                            ?>
                                <tr style="font-family:'Myriad Pro', Helvetica, Arial, sans-serif; color:#68696a; font-size:16px;text-align: center;  height: 35px;">
                                    <td>
                                      <?php if($v['product_image'] && file_exists($this->config->item('PRODUCT_URL') . $v['product_image'])) : ?>
                                        <img src="<?php echo $this->config->item('PRODUCT_URL') . $v['product_image']; ?>" style="width: 60%" />
                                      <?php endif; ?>
                                    </td>
                                    <td width=""><?php echo $v['order_item_name']; ?></td>
                                    <td width=""><?php echo $v['order_item_qty']; ?></td>
                                    <td width=""><?php echo DWS_CURRENCY_SYMBOL . ' ' . number_format($v['order_item_price'], 2); ?></td>
                                    <td width=""><?php
                                        $grand_total = $grand_total + number_format($v['order_item_price'] * $v['order_item_qty'], 2);
                                        echo DWS_CURRENCY_SYMBOL . ' ' . number_format($v['order_item_price'] * $v['order_item_qty'], 2);
                                        ?></td>
                                </tr>
                            <?php
                        }
                    }
                ?>
            </table>

        </div>
    </body>
</html>
