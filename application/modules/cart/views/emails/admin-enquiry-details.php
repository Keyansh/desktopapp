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
                                            <td style="border-top: 15px solid #0810a0; padding-bottom: 20px;">
                                                <table style="width:100%; border:0; box-shadow:1px 3px 5px 3px #88888880; background:white;">
                                                    <tr>
                                                        <td>
                                                            <table width="100%" border-collapse="collapsed" cellspacing="0" cellpadding="0">
                                                                <tr>
                                                                    <td width="250">
                                                                        <table width="100%" border-collapse="collapsed"" cellspacing=" 0" cellpadding="0">

                                                                            <tr>
                                                                                <td align="right" valign="middle">
                                                                                    <table width="100%" border-collapse="collapsed" cellspacing="0" cellpadding="0">
                                                                                        <tr>
                                                                                            <td style=" text-align:center; font-size:28px; font-family: 'Heebo', sans-serif; font-weight:500; text-transform: capitalize; color: #495d80; padding: 10px 25px 10px 25px;">
                                                                                                <img width="200" src="<?= $this->config->item('CONTACT_US_FILE_URL') . DWS_LOGO ?>">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td width="100%">
                                                                                                <p style="  margin: 10px 0 0 0;padding-bottom:30px; font-family: 'Heebo', sans-serif; font-weight: 500; font-size:16px; text-align:center">Dated: <span style="font-family: 'Heebo', sans-serif; font-weight: 300;">{DATE}</span></p>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td style=" text-align:center; font-size:28px; font-family: 'Heebo', sans-serif; font-weight:500; text-transform: capitalize; color: #0810a0; padding: 10px 25px 10px 25px;">
                                                                                                New Product Enquiry Received
                                                                                            </td>
                                                                                        </tr>

                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="center" valign="middle" style="padding: 30px 30px 60px 30px;">
                                                                        <table width="100%" border-collapse="collapsed" cellspacing="0" cellpadding="5" style="margin-top: 20px; border-collapse: collapse;">
                                                                            <tr style="font-family:'Myriad Pro', Helvetica, Arial, sans-serif; color:#68696a; font-size:16px;text-align: center; height: 35px;background: #e7e7e7 none repeat ; border-bottom:3px solid #ddd;">
                                                                                <th style="padding: 10px 6px; font-family: 'Heebo', sans-serif; font-weight: 700; color: black; text-align: left;font-size:16px;" width="40%">Product</th>
                                                                                <th style="padding: 10px 6px; font-family: 'Heebo', sans-serif; font-weight: 700; color: black; text-align: left;font-size:16px;" width="20%">SKU</th>
                                                                                <th style="padding: 10px 6px; font-family: 'Heebo', sans-serif; font-weight: 700; color: black; border-left: none; font-size:16px;" width="10%">Quantity</th>
                                                                            </tr>
                                                                            <?php
                                                                            foreach ($DATA as $item) {
                                                                            ?>
                                                                                <tr style="color:#68696a; font-size:16px;text-align: center;  height: 35px; background:#e7e7e7;">
                                                                                    <td width="" style="text-align: left;padding: 10px 6px; font-family: 'Heebo', sans-serif; font-weight: 400; font-size: 16px; color: #000;">
                                                                                        <?php
                                                                                        $img_url = '{BASE_URL}images/a1.jpg';
                                                                                        if ($item['img'] != '') {
                                                                                            $img_url = $IMG_URL . $item['img'];
                                                                                        }
                                                                                        ?>
                                                                                        <div class="col-xs-12" style="padding: 0;display: flex;flex-wrap: wrap;align-items: center;">
                                                                                            <div class="col-xs-3">
                                                                                                <img src="<?php echo $img_url; ?>" width="120" />
                                                                                            </div>
                                                                                            <div class="col-xs-8" style="padding-left: 10px;">
                                                                                                <?php echo $item['name']; ?>
                                                                                                <p>
                                                                                                    <?php
                                                                                                    $order_item_options = json_decode($item['order_item_options']);
                                                                                                    if (isset($order_item_options)) {
                                                                                                        if ($order_item_options) {
                                                                                                    ?>
                                                                                                            <?php
                                                                                                            foreach ($order_item_options as $key => $value) {

                                                                                                            ?>
                                                                                                                <span class="small-name">
                                                                                                                    <?php
                                                                                                                    echo str_replace("_", " ", $key) . ' : ' . $value;
                                                                                                                    ?>
                                                                                                                </span>
                                                                                                            <?php
                                                                                                            }
                                                                                                            ?>
                                                                                                    <?php
                                                                                                        }
                                                                                                    }
                                                                                                    ?>
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td width="" style="text-align: left;padding: 10px 6px; font-family: 'Heebo', sans-serif; font-weight: 400; font-size: 16px; color: #000;"><?php echo $item['product_sku']; ?></td>
                                                                                    <td width="" style="padding: 10px 6px; font-family: 'Heebo', sans-serif; font-weight: 400; font-size: 16px; color: #000;"><?php echo $item['qty']; ?></td>
                                                                                </tr>
                                                                            <?php } ?>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="3" style="text-align:center; font-family: 'Heebo', sans-serif; font-weight: 500; font-size:16px; color:white; text-transform:capitalize;padding-top: 20px;background-color: #0810a0;">
                                                                        {ADDRESS}
                                                                        <p style="margin-top: 3px;padding-bottom: 20px;">Call us: {ADMIN_PHONE}</p>
                                                                    </td>
                                                                </tr>

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