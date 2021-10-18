<!DOCTYPE html>
<html>
    <head>
        <title>Brand me now | Quotation</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--FONTS-->
        <link href="https://fonts.googleapis.com/css?family=Roboto:300" rel="stylesheet">
        <style type="text/css">
            @import url('https://fonts.googleapis.com/css?family=Roboto:300');
            body{margin: 0 !important;padding: 0 !important;}
            @media (max-width:1199px){body > table{width: 70% !important;}.padd-td {padding-left: 5% !important;padding-right: 5% !important;}}
            @media (max-width:991px){body > table{width: 80% !important;}.padd-td {padding-left: 3% !important;padding-right: 3% !important;}}
            @media (max-width:767px){body > table{width: 100% !important;}.padd-td {padding-left: 2% !important;padding-right: 2% !important;}}
        </style>
    </head>
    <body style="margin: 0;padding: 0;box-sizing: border-box;background: #222222;">
        <table style="border-collapse: collapse; background: #f3f3f3 url('<?= $SITE_URL; ?>admin/images/email-table-bg-img.png') repeat scroll 0% 0%; margin: 0px auto; box-sizing: border-box; width: 62%;" border="0">
            <tbody>
                <tr>
                    <td style="padding: 0 15px;">
                        <table style="width: 100%;" border="0">
                            <tbody>
                                <tr>
                                    <td style="border-bottom: 2px dotted #A6A6A6; padding: 12px 0;"><a style="text-decoration: none; display: table; margin: 0 auto; outline: none;" href="#"><img style="height: auto; display: block; margin: 0 auto; max-width: 100%; outline: none;" src="<?= $SITE_URL; ?>upload/useruploads/images/logo.png" width="605" height="94" /></a></td>
                                </tr>
                                <tr>
                                    <td class="padd-td" style="padding: 3% 7%;">
                                        <table style="width: 100%;" border="0">
                                            <tbody>
                                                <tr>
                                                    <td style="font-family: roboto; font-weight: 300; color: #333; font-size: 16px; padding: 0 5px 0 0;"><p style="margin: 0; line-height: normal; display: table; border-bottom: 2px dotted #A6A6A6; padding-bottom: 5px;">Dear <?= $customer['first_name'] . ' ' . $customer['last_name']; ?>,<br />Your quotation is ready with required products. Please check detail and confirm for order.</p></td>
                                                    <td style="font-family: roboto; font-weight: 300; color: #333; font-size: 14px;"><p style="margin: 0; display: table; line-height: normal;">Dated: <span>{DATE}</span></p></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="padd-td" style="padding: 4% 7% 3%;">
                                        <table style="font-family: roboto; font-weight: 300; color: #333333; font-size: 14px; width: 100%; border: 1px solid">
                                            <thead>
                                                <tr>
                                                    <th align="left" style="padding: 3px 5px;">Product Name</th>
                                                    <th align="left" style="padding: 3px 5px;">Attributes </th>
                                                    <th align="left" style="padding: 3px 5px;">Quantity </th>
                                                    <th align="left" style="padding: 3px 5px;">Unit Price </th>
                                                    <th align="left" style="padding: 3px 5px;">Subtotal</th>
                                                    <th align="left" style="padding: 3px 5px;">Discount % </th>
                                                    <th align="left" style="padding: 3px 5px;">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($cart_content as $content) { ?>
                                                    <tr>
                                                        <td style="padding: 3px 5px;"><?= $content['quotation_item_name']; ?></td>
                                                        <td style="padding: 3px 5px;">
                                                            <?php
                                                            $prodAttr = json_decode($content['quotation_item_attr']);
                                                            foreach ($prodAttr as $prodAtt) {
                                                                echo $prodAtt->label . ' => ' . $prodAtt->value . '<br/>';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td style="padding: 3px 5px;"><?= $content['quotation_item_qty']; ?></td>
                                                        <td style="padding: 3px 5px;"><?= DWS_CURRENCY_SYMBOL . $content['quotation_item_price']; ?></td>
                                                        <td style="padding: 3px 5px;"><?= DWS_CURRENCY_SYMBOL . $content['quotation_item_subtotal']; ?></td>
                                                        <td style="padding: 3px 5px;"><?= $content['quotation_item_discount']; ?></td>
                                                        <td style="padding: 3px 5px;"><?= DWS_CURRENCY_SYMBOL . $content['quotation_item_total']; ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="5" align="right" style="padding: 3px 5px;">Subtotal</th>
                                                    <th align="left" style="padding: 3px 5px;"><?= DWS_CURRENCY_SYMBOL . $DATA['cart_total'] ?></th>
                                                </tr>
                                                <tr>
                                                    <th colspan="5" align="right" style="padding: 3px 5px;">Discount</th>
                                                    <th align="left" style="padding: 3px 5px;"><?= DWS_CURRENCY_SYMBOL . (($DATA['cart_total'] + $DATA['vat']) - $DATA['quotation_total']) ?></th>
                                                </tr>
                                                <tr>
                                                    <th colspan="5" align="right" style="padding: 3px 5px;">VAT</th>
                                                    <th align="left" style="padding: 3px 5px;"><?= DWS_CURRENCY_SYMBOL . $DATA['vat'] ?></th>
                                                </tr>
                                                <tr>
                                                    <th colspan="5" align="right" style="padding: 3px 5px;">Grand Total</th>
                                                    <th align="left" style="padding: 3px 5px;"><?= DWS_CURRENCY_SYMBOL . $DATA['quotation_total'] ?></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="padd-td" style="padding: 0% 7% 8%;"><p style="margin: 0; font-family: roboto; font-size: 13px; color: #444;">Please click on <a href="<?= $SITE_URL; ?>checkout/quotation/<?= $DATA['quotation_num'] ?>">Confirm</a> to complete your order</p></td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 0; border-top: 2px dotted #A6A6A6;">
                                        <table style="font-family: roboto; font-weight: 300; text-align: center; font-size: 12px; color: #555555; width: 100%;" border="0">
                                            <tbody>
                                                <tr>
                                                    <td><p style="margin: 0 0 10px;">From: <span>bigliving.co.uk</span></p></td>
                                                </tr>
                                                <tr>
                                                    <td><p style="margin: 0;">33 Hampton Street, Hockey, Birmingham, B19 3LS</p><p style="margin: 0;">Call us <span>+44 (121)2360482</span></p></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </body>
</html>
