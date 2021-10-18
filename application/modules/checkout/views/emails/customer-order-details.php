<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="https://fonts.googleapis.com/css?family=Heebo:100,300,400,500,700,900" rel="stylesheet"> 
        <title>Document</title>
    </head>
    <body>
        <table style="border-collapse: collapse; background: #f3f3f3 url('{BASE_URL}images/email-table-bg-img.png') repeat scroll 0% 0%; margin: 0px auto; box-sizing: border-box; width: 100%;border-collapse: collapsed;">
            <tbody>
                <tr>
                    <td style="padding: 0 15px;">
                        <table style="width: 100%; border-collapse:collapse; width:1000px; margin:auto; background:#eff2f7;">
                            <tr>
                                <td>
                                    <table style="width: 1000px; margin: 40px auto; display:table; margin:auto; border-collapse:collapsed;">
                                        <tbody>
                                            <tr>
                                                <td style="border-top: 15px solid #34abb3; padding-bottom: 20px;">
                                                    <table style="width:100%; border:0; box-shadow:1px 3px 5px 3px #88888880;padding: 0px 40px 40px 40px; background:white;" >
                                                        <tr>
                                                            <td>
                                                                <table width="100%" border-collapse="collapsed" cellspacing="0" cellpadding="0">
                                                                    <tr>
                                                                        <td width="250">
                                                                            <table width="100%" border-collapse="collapsed"" cellspacing="0" cellpadding="0">
                                                                                
                                                                                <tr>
                                                                                    <td align="right" valign="middle"><table width="100%" border-collapse="collapsed" cellspacing="0" cellpadding="0">
                                                                                            <tr>
                                                                                                <td style=" text-align:center; font-size:28px; font-family: 'Heebo', sans-serif; font-weight:500; text-transform: capitalize; color: #34abb3; padding: 10px 25px 10px 25px;">
                                                                                                    <img width="200" src="<?= $this->config->item('CONTACT_US_FILE_URL') . DWS_LOGO ?>">
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td style=" text-align:center; font-size:28px; font-family: 'Heebo', sans-serif; font-weight:500; text-transform: capitalize; color: #34abb3; padding: 10px 25px 10px 25px;">
                                                                                                    New Order Placed
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                    <td width="100%" align="right">
                                                                                        <p style="  margin: -40px 0 0 0;padding-bottom:60px; font-family: 'Heebo', sans-serif; font-weight: 500; font-size:16px; text-transform:uppercasel">Dated: <span style="font-family: 'Heebo', sans-serif; font-weight: 300;">{DATE}</span></p>
                                                                                    </td>
                                                                                </tr>
                                                                                            <tr>
                                                                                                <td>
                                                                                                    <table style="width: 100%; border-collapse: collapse;">
                                                                                                        <!-- <tr>
                                                                                                            <td style="font-size: 15px;  font-family: 'Heebo', sans-serif; font-weight: 400; color: black; padding: 15px 0px;"></td>
                                                                                                        </tr> -->
                                                                                                        <tr>
                                                                                                            <td style="border-bottom: 4px solid #34abb3; " height="46" align="right" valign="middle"><table width="100%" border-collapse="collapsed"" cellspacing="0" cellpadding="0">
                                                                                                                    <tr>
                                                                                                                        <td width="100%" style="font-family:'Heebo', sans-serif; font-weight: 300; font-size: 16px;  "><span style=" display: inline-block; padding: 20px 0px 5px 0px; font-size: 24px;font-family: 'Heebo', sans-serif; font-weight: 700;color:#34abb3; ">Order Number : </span> <?php echo $DATA['order']['order_num']; ?></td>
                                                                                                                    </tr>
                                                                                                                </table>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    </table>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td align="center" valign="middle">
                                                                            <table width="100%" border-collapse="collapsed"" cellspacing="0" cellpadding="5" style="margin-top: 20px; border-collapse: collapse;">
                                                                                <tr style="font-family:'Myriad Pro', Helvetica, Arial, sans-serif; color:#68696a; font-size:16px;text-align: center; height: 35px;background: #e7e7e7 none repeat ; border-bottom:3px solid #ddd;">
                                                                                    <th style="padding: 10px 6px; font-family: 'Heebo', sans-serif; font-weight: 700; color: black; text-align: left;font-size:16px;" width="40%">Product</th>
                                                                                    <th style="padding: 10px 6px; font-family: 'Heebo', sans-serif; font-weight: 700; color: black; text-align: left;font-size:16px;" width="20%">SKU</th>
                                                                                    <th style="padding: 10px 6px; font-family: 'Heebo', sans-serif; font-weight: 700; color: black; border-left: none; font-size:16px;" width="10%">Quantity</th>
                                                                                    <th style="padding: 10px 6px; font-family: 'Heebo', sans-serif; font-weight: 700; color: black; border-left: none; font-size:16px;" width="10%">Unit Price</th>
<!--                                                                                    <th style="padding: 10px 6px; font-family: 'Heebo', sans-serif; font-weight: 500; color: black; border-left: none; font-size:16px;" width="10%">Pack</th>-->
                                                                                    <th style="padding: 10px 6px; font-family: 'Heebo', sans-serif; font-weight: 700; color: black; border-left: none; font-size:16px;" width="10%">Value</th>
                                                                                </tr>
                                                                                <?php
                                                                                $grand_total = 0;
                                                                                foreach ($DATA['cart_contents'] as $item) {
                                                                                    ?>
                                                                                    <tr style="color:#68696a; font-size:16px;text-align: center;  height: 35px; background:#e7e7e7;">
                                                                                        <td width="" style="text-align: left;padding: 10px 6px; font-family: 'Heebo', sans-serif; font-weight: 400; font-size: 16px; color: #000;"><?php echo $item['name']; ?></td>
                                                                                        <td width="" style="text-align: left;padding: 10px 6px; font-family: 'Heebo', sans-serif; font-weight: 400; font-size: 16px; color: #000;"><?php echo $item['product_sku']; ?></td>
                                                                                        <td width="" style="padding: 10px 6px; font-family: 'Heebo', sans-serif; font-weight: 400; font-size: 16px; color: #000;"><?php echo $item['qty']; ?></td>
                                                                                        <td width="" style="padding: 10px 6px; font-family: 'Heebo', sans-serif; font-weight: 400; font-size: 16px; color: #000;"><?php echo DWS_CURRENCY_SYMBOL . ' ' . number_format($item['price'], 2); ?></td>
<!--                                                                                        <td width="" style="padding: 10px 6px; font-family: 'Heebo', sans-serif; font-weight: 400; font-size: 16px; color: #000;">-->
<!--                                                                                            --><?php
//                                                                                            $product_pack = product_pack($item['product_id']);
//                                                                                            if ($product_pack['quantity_per_pack']) {
//                                                                                                echo $product_pack['quantity_per_pack'];
//                                                                                            }
//                                                                                            ?>
<!--                                                                                        </td>-->
                                                                                        <td width="" style="padding: 10px 6px 10px 15px; font-family: 'Heebo', sans-serif; font-weight: 400; font-size: 16px; color: #000;"><?php
                                                                                            $grand_total = $grand_total + number_format($item['price'] * $item['qty'], 2);
                                                                                            echo DWS_CURRENCY_SYMBOL . ' ' . number_format($item['price'] * $item['qty'], 2);
                                                                                            ?>
                                                                                        </td>
                                                                                    </tr>
                                                                                <?php } ?>
<!--                                                                                <tr style="background: #f7f7f7; font-size:16px;text-align: left;">
<th colspan="3" abbr=""align="right"  style=" padding: 8px; color: black; font-family: 'Heebo', sans-serif; font-weight: 500; font-size: 16px;">Shipping Charge: </th>
<td align="right"  style=" padding: 8px; font-family: 'Heebo', sans-serif; font-weight: 500;font-size: 18px; color: black;"><?php // echo DWS_CURRENCY_SYMBOL . ' ' . $shipping;                                                                                                                                               ?> </td>
</tr>-->
<!-- <?php if($discount > 0): ?> -->
<tr style="background: #e7e7e7; font-size: 18px;text-align: left;">
                                                                                    <th colspan="4" align="right"  style=" padding: 8px; color: #000; font-family: 'Heebo', sans-serif; font-weight: 500; font-size: 16px;">Discount: </th>
                                                                                    <td align="right"  style=" padding: 8px; font-family: 'Heebo', sans-serif; font-weight: 500;font-size: 16px; color: #000; padding-right: 22px;">
                                                                                        <?php echo DWS_CURRENCY_SYMBOL . ' ' . $discount; ?>  </td>
                                                                                </tr>
<?php endif; ?>
<tr style="background: #e7e7e7; font-size: 18px;text-align: left;">
                                                                                    <th colspan="4" align="right"  style=" padding: 8px 28px 8px 8px; color: #000; font-family: 'Heebo', sans-serif; font-weight: 500; font-size: 16px;">VAT: </th>
                                                                                    <td align="right"  style=" padding: 8px; font-family: 'Heebo', sans-serif; font-weight: 500;font-size: 16px; color: #000; padding-right: 22px;">
                                                                                        <?php echo DWS_CURRENCY_SYMBOL . ' ' . $vat; ?>  </td>
                                                                                </tr>
                                                                                <tr style=" font-size: 18px;text-align: left; background:#e7e7e7;">
                                                                                    <th colspan="4" align="right"  style=" padding: 8px; color: #000; font-family: 'Heebo', sans-serif; font-weight: 500; font-size: 16px;">Shipping <?php echo $shipping_label ?>: </th>
                                                                                    <td align="right"  style=" padding: 8px; font-family: 'Heebo', sans-serif; font-weight: 500;font-size: 16px; color: #000; padding-right: 22px;">
                                                                                        <?php echo DWS_CURRENCY_SYMBOL . ' ' . $shipping; ?>  </td>
                                                                                </tr>
                                                                                <?php
                                                                                if ($DATA['order']['coupon_code'] != '') {
                                                                                    ?>
                                                                                                                                                                                                                <!--                                                                                    <tr style="background: #f7f7f7; font-size: 18px;text-align: left;">
                                                                                                                                                                                                                                                                                                        <th colspan="4" align="right"  style=" padding: 8px; color: #000; font-family: 'Heebo', sans-serif; font-weight: 500; font-size: 16px;">Coupon Code: </th>
                                                                                                                                                                                                                                                                                                        <td align="right"  style=" padding: 8px; font-family: 'Heebo', sans-serif; font-weight: 500; color: #000; font-size: 16px; padding-right: 18px;">
                                                                                    <?php // echo $DATA['order']['coupon_code'];  ?> </td>
                                                                                                                                                                                                                                                                                                    </tr>      -->
                                                                                <?php }
                                                                                ?>
                                                                                <?php
                                                                                if ($DATA['order']['discounted_amount'] != '') {
                                                                                    ?>
                                                                                                                                                                                                                <!--                                                                                    <tr style="background: #f7f7f7; font-size:16px;text-align: left;">
                                                                                                                                                                                                                                                                                                        <th colspan="3" align="right"  style=" padding: 8px; color: #000; font-family: 'Heebo', sans-serif; font-weight: 500;font-size: 16px;">Coupon Discount: </th>
                                                                                                                                                                                                                                                                                                        <td align="right"  style=" padding: 8px; font-family: 'Heebo', sans-serif; font-weight: 500; color: #000; font-size: 16px;padding-right: 18px;">
                                                                                    <?php // echo DWS_CURRENCY_SYMBOL . ' ' . $DATA['order']['discounted_amount'];  ?> </td>
                                                                                                                                                                                                                                                                                                    </tr>      -->
                                                                                <?php }
                                                                                ?>
                                                                                <tr style="background: #e7e7e7; color:#000; font-size:16px;text-align: left;">
                                                                                    <th colspan="4" align="right"  style="padding: 7px; color: 000; background: #e7e7e7; font-family: 'Heebo', sans-serif; font-weight: 500; font-size: 16px;">Grand Total:</th>
                                                                                    <td align="right"  style="padding: 7px; font-family: 'Heebo', sans-serif; font-weight: 500; color: #000; background: #e7e7e7; font-size: 16px;padding-right: 22px;"><?php echo DWS_CURRENCY_SYMBOL . ' ' . number_format(($order_total), 2) ?>  </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td colspan="4" align="center" valign="middle" style="padding: 5px 0px;">
                                                                                        <table width="100%" border-collapse="collapsed"" cellspacing="0" cellpadding="0" style="margin: 32px 0 20px;">
                                                                                            <tr>
                                                                                                <td width="50%" align="left" style="line-height: 22px;" >
                                                                                                    <font style="text-transform:uppercase;">
                                                                                                    <span style="font-family: 'Heebo', sans-serif; font-weight: 500;  font-size: 20px; display: table; margin-bottom: 15px; color: #000;border-bottom: 1px solid #000;">BILLING Address: </span>
                                                                                                    </font>
                                                                                                </td>
                                                                                                <td width="50%" align="left" style="line-height: 22px;" >
                                                                                                    <font style="text-transform:uppercase;">
                                                                                                    <span style="font-family: 'Heebo', sans-serif; font-weight: 500; font-size: 20px; display: table; margin-bottom: 15px; color: #000;border-bottom: 1px solid #000;">SHIPPING ADDRESS : </span>
                                                                                                    </font>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td width="15%" align="left" style="line-height: 22px;">
                                                                                                    <font style="font-family: 'Heebo', sans-serif; font-weight: 400; font-size: 15px; text-transform:capitalize; color: #000; margin-right:10px">

                                                                                                    <span><?= $B_FIRSTNAME . " " . $B_LASTNAME ?></span>
                                                                                                    </font>
                                                                                                </td>
                                                                                                <td width="15%" align="left" style="line-height: 22px;">
                                                                                                    <font style="font-family: 'Heebo', sans-serif; font-weight: 400; font-size: 15px; text-transform:capitalize; color: #000; margin-right:10px">
                                                                                                    <?php
                                                                                                    if ($S_FIRSTNAME == '' && $S_LASTNAME == '') {
                                                                                                        $S_FIRSTNAME = $B_FIRSTNAME;
                                                                                                        $S_LASTNAME = $B_LASTNAME;
                                                                                                    }
                                                                                                    ?>
                                                                                                    <span><?= $S_FIRSTNAME . " " . $S_LASTNAME ?></span>
                                                                                                    </font>
                                                                                                </td>
                                                                                            </tr>

                                                                                            <tr>
                                                                                                <td width="15%" align="left" style="line-height: 22px;">
                                                                                                    <font style="font-family: 'Heebo', sans-serif; font-weight: 400; font-size: 15px; text-transform:capitalize; color: #000; margin-right:10px">

                                                                                                    <span><?= $B_CITY; ?></span>
                                                                                                    </font>
                                                                                                </td>
                                                                                                <td width="15%" align="left" style="line-height: 22px;">
                                                                                                    <font style="font-family: 'Heebo', sans-serif; font-weight: 400; font-size: 15px; text-transform:capitalize; color: #000; margin-right:10px">
                                                                                                    <?php
                                                                                                    if ($S_CITY == '') {
                                                                                                        $S_CITY = $B_CITY;
                                                                                                    }
                                                                                                    ?>
                                                                                                    <span><?= $S_CITY; ?></span>
                                                                                                    </font>
                                                                                                </td>
                                                                                            <tr>
                                                                                                <td width="15%" align="left" style="line-height: 22px;">
                                                                                                    <font style="font-family: 'Heebo', sans-serif; font-weight: 400; font-size: 15px; text-transform:capitalize; color: #000; margin-right:10px">

                                                                                                    <span><?= $B_COUNTY; ?></span>
                                                                                                    </font>
                                                                                                </td>
                                                                                                <td width="15%" align="left" style="line-height: 22px;">
                                                                                                    <font style="font-family: 'Heebo', sans-serif; font-weight: 400; font-size: 15px; text-transform:capitalize; color: #000; margin-right:10px">
                                                                                                    <?php
                                                                                                    if ($S_COUNTY == '') {
                                                                                                        $S_COUNTY = $B_COUNTY;
                                                                                                    }
                                                                                                    ?>
                                                                                                    <span><?= $S_COUNTY; ?></span>
                                                                                                    </font>
                                                                                                </td>
                                                                                            </tr>
                                                                                </tr>

                                                                                <tr>
                                                                                    <td width="15%" align="left" style="line-height: 22px;">
                                                                                        <font style="font-family: 'Heebo', sans-serif; font-weight: 400; font-size: 15px; text-transform:capitalize; color: #000; margin-right:10px">

                                                                                        <span><?= $B_POSTCODE; ?></span>
                                                                                        </font>
                                                                                    </td>
                                                                                    <td width="15%" align="left" style="line-height: 22px;">
                                                                                        <font style="font-family: 'Heebo', sans-serif; font-weight: 400; font-size: 15px; text-transform:capitalize; color: #000; margin-right:10px">
                                                                                        <?php
                                                                                        if ($S_POSTCODE == '') {
                                                                                            $S_POSTCODE = $B_POSTCODE;
                                                                                        }
                                                                                        ?>
                                                                                        <span><?= $S_POSTCODE; ?></span>
                                                                                        </font>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td width="15%" align="left" style="line-height: 22px;">
                                                                                        <font style="font-family: 'Heebo', sans-serif; font-weight: 400; font-size: 15px; text-transform:capitalize; color: #000; margin-right:10px">

                                                                                        <span><?= $B_STREET; ?></span>
                                                                                        </font>
                                                                                    </td>
                                                                                    <td width="15%" align="left" style="line-height: 22px;">
                                                                                        <font style="font-family: 'Heebo', sans-serif; font-weight: 400; font-size: 15px; text-transform:capitalize; color: #000; margin-right:10px">
                                                                                        <?php
                                                                                        if ($S_STREET == '') {
                                                                                            $S_STREET = $B_STREET;
                                                                                        }
                                                                                        ?>
                                                                                        <span><?= $S_STREET; ?></span>
                                                                                        </font>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td width="15%" align="left" style="line-height: 22px;">
                                                                                        <font style="font-family: 'Heebo', sans-serif; font-weight: 400; font-size: 15px; text-transform:capitalize; color: #000; margin-right:10px">

                                                                                        <span><?= $B_COUNTRY; ?></span>
                                                                                        </font>
                                                                                    </td>
                                                                                    <td width="15%" align="left" style="line-height: 22px;">
                                                                                        <font style="font-family: 'Heebo', sans-serif; font-weight: 400; font-size: 15px; text-transform:capitalize; color: #000; margin-right:10px">
                                                                                        <?php
                                                                                        if ($S_COUNTRY == '') {
                                                                                            $S_COUNTRY = $B_COUNTRY;
                                                                                        }
                                                                                        ?>
                                                                                        <span><?= $S_COUNTRY; ?></span>
                                                                                        </font>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td  width="15%" align="left" style="line-height: 22px;">
                                                                                        <font style="font-family: 'Heebo', sans-serif; font-weight: 400; font-size: 15px; text-transform:capitalize; color: #000; margin-right:10px">

                                                                                        <span><?= $B_PHONE; ?></span>
                                                                                        </font>
                                                                                    </td>
                                                                                    <td width="15%" align="left" style="line-height: 22px;">
                                                                                        <font style="font-family: 'Heebo', sans-serif; font-weight: 400; font-size: 15px; text-transform:capitalize; color: #000; margin-right:10px">
                                                                                        <?php
                                                                                        if ($S_PHONE == '') {
                                                                                            $S_PHONE = $B_PHONE;
                                                                                        }
                                                                                        ?>
                                                                                        <span><?= $S_PHONE; ?></span>
                                                                                        </font>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-bottom: 20px;">
                                                                <table style="width: 100%;border-collapse: collapse;">
                                                                    <tr>
                                                                        <td style="text-align:left; font-family: 'Heebo', sans-serif; font-weight: 400; font-size:15px; color:#000; text-transform:capitalize;"><?= $ADDRESS ?>S K Building
Birchall Street
Digbeth
Birmingham
B12 0RP</td>

<td style="text-align:right; font-family: 'Heebo', sans-serif; font-weight: 400; font-size:15px; color:#000; text-transform:capitalize;">Call us: <?= $PHONE ?>0121 667 8312</td>
                                                                    </tr>
                                                                  
                                                                       
                                                                    
                                                                </table>
                                                            </td>
                                                        </tr>

                                                        <!-- <tr>
                                                            <td style=" padding: 15px 0px 0px 0px; font-size: 15px;  font-family: 'Heebo', sans-serif; font-weight: 400; color: #000;">
                                                                Keep Shopping!
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style=" text-transform:capitalize;font-size: 15px;  font-family: 'Heebo', sans-serif; font-weight: 400; color: #000; padding-bottom: 50px;">
                                                                Consort hardware
                                                            </td>
                                                        </tr> -->
                                                        
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                           
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </body>
</html>