<!DOCTYPE html>
<html>
    <head>
        <title>Quotation confirmed successfully</title>
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
        <table style="border-collapse: collapse; background: #f3f3f3 url('<?= $BASE_URL; ?>images/email-table-bg-img.png') repeat scroll 0% 0%; margin: 0px auto; box-sizing: border-box; width: 62%;" border="0">
            <tbody>
                <tr>
                    <td style="padding: 0 15px;">
                        <table style="width: 100%;" border="0">
                            <tbody>
                                <tr>
                                    <td style="border-bottom: 2px dotted #A6A6A6; padding: 12px 0;"><a style="text-decoration: none; display: table; margin: 0 auto; outline: none;" href="#"><img style="height: auto; display: block; margin: 0 auto; max-width: 100%; outline: none;" src="<?= $this->config->item('CONTACT_US_FILE_URL') . DWS_LOGO ?>" width="605" height="94" /></a></td>
                                </tr>
                                <tr>
                                    <td class="padd-td" style="padding: 3% 7%;">
                                        <table style="width: 100%;" border="0">
                                            <tbody>
                                                <tr>
                                                    <td style="font-family: roboto; font-weight: 300; color: #333; font-size: 16px; padding: 0 5px 0 0;"><p style="margin: 0; line-height: normal; display: table; border-bottom: 2px dotted #A6A6A6; padding-bottom: 5px;"><?= $quotation['first_name'] . ' ' . $quotation['last_name']; ?> has confirmed their quotation under quotation number <b><?= $quotation['quotation_num'] ?></b></p></td>
                                                    <td style="font-family: roboto; font-weight: 300; color: #333; font-size: 14px;"><p style="margin: 0; display: table; line-height: normal;">Dated: <span>{DATE}</span></p></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 0; border-top: 2px dotted #A6A6A6;">
                                        <table style="font-family: roboto; font-weight: 300; text-align: center; font-size: 12px; color: #555555; width: 100%;" border="0">
                                            <tbody>
                                                <tr>
                                                    <td><p style="margin: 0 0 10px;">From: <span>Regent</span></p></td>
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
