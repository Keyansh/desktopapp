<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="https://fonts.googleapis.com/css?family=Heebo:100,300,400,500,700,900" rel="stylesheet"> 
        <title>New Enquiry</title>
        <style>
            .ii a[href] {
                color: #333;
                text-decoration: none;
            }
        </style>
    </head>
    <body>
        <table style="border-collapse: collapse; background: #f3f3f3 url('lofdirect/lofdirect/lofdirect/{BASE_URL}images/email-table-bg-img.png') repeat scroll 0% 0%; margin: 0px auto; box-sizing: border-box; width: 100%; border-collapse:collapse;">
            <tbody>
                <tr>
                    <td style="padding: 0 15px;">
                        <table style="width: 100%; border-collapse:collapse; width:1000px; margin:auto; background:#eff2f7;">
                            <tr>
                                <td>
                                    <table style="width: 800px; margin: 40px auto; display:table; margin:auto; border-collapse:collapse;">
                                        <tbody>
                                            <tr>
                                                <td style="padding:0px 0px 12px 0px;">
                                                    <table style="width: 100%; border-collapse:collapsed;">
                                                        <tr>
                                                            <td style="width:50%; padding:0px;">
                                                            </td>
                                                            <td style="width:50%; float: right;padding:0;">
                                                                <p style="margin: 30px 0px 0px 0px; padding: 0; text-align: right;">
                                                                    <span style="display:inline-block;padding: 0px 0px;font-weight:bolder;">{DATE}</span>
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="border-top: 15px solid #ff6c00; padding-bottom: 20px;">
                                                    <table style="width:100%; border:0; box-shadow:1px 3px 5px 3px #88888880; padding: 0px 0px 50px 0px; background:white;" >
                                                        <tr>
                                                            <td style="display: table; margin: auto; padding: 40px 0px 20px 0px;"><img width="200" src="<?php echo base_url(); ?>images/logo.png" alt="logo"></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding: 0% 10%;">
                                                                <table style="font-family: roboto; font-weight: 300; color: #333333; font-size: 14px; width: 100%; border-collapse:collapsed;">
                                                                    <tbody>

                                                                        <tr>
                                                                            <td colspan = "2">
                                                                                <h1 style="color: #ff6c00; text-align:center; text-transform:capitalize; font-size: 28px; font-weight:700; font-family: 'Heebo', sans-serif;">New Enquiry</h1> 
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="width: 25%;">
                                                                                <p style="color:#ff6c00; margin: 0; text-transform: capitalize; padding: 5px 15px;font-family: 'Heebo', sans-serif; font-weight: 500;font-size:16px;">
                                                                                    Product Name
                                                                                </p>
                                                                            </td>
                                                                            <td style="width: 75%;">
                                                                                <p style="padding: 5px 15px; font-family: 'Heebo', sans-serif; font-weight: 500; color:#333; font-size:16px;">
                                                                                    <span style="padding-right:50px;padding-left:50px">:</span>{tier_product}
                                                                                </p>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <p style="color: #ff6c00; margin: 0; padding: 5px 15px; font-family: 'Heebo', sans-serif; font-weight: 500; font-size:16px; text-transform: capitalize;">
                                                                                    Quantity
                                                                                </p>
                                                                            </td>
                                                                            <td>
                                                                                <p style="padding: 5px 15px; font-family: 'Heebo', sans-serif; font-weight: 500; color:#333; font-size:16px;">
                                                                                    <span style="padding-right:50px;padding-left:50px">:</span>{tier_qty}+
                                                                                </p>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <p style="color: #ff6c00; margin: 0; padding: 5px 15px; font-family: 'Heebo', sans-serif; font-weight: 500; font-size:16px; text-transform: capitalize;">
                                                                                    Name 
                                                                                </p>
                                                                            </td>
                                                                            <td>
                                                                                <p style="padding: 5px 15px; font-family: 'Heebo', sans-serif; font-weight: 500; color:#333; font-size:16px;">
                                                                                    <span style="padding-right:50px;padding-left:50px">:</span>{tier_name}
                                                                                </p>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <p style="color: #ff6c00; margin: 0; padding: 5px 15px; font-family: 'Heebo', sans-serif; font-weight: 500; font-size:16px; text-transform: capitalize;">
                                                                                    Email 
                                                                                </p>
                                                                            </td>
                                                                            <td>
                                                                                <p style="padding: 5px 15px; font-family: 'Heebo', sans-serif; font-weight: 500; color:#333; font-size:16px;">
                                                                                    <span style="padding-right:50px;padding-left:50px">:</span>{tier_email}
                                                                                </p>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <p style="color: #ff6c00; margin: 0; padding: 5px 15px; font-family: 'Heebo', sans-serif; font-weight: 500; font-size:16px; text-transform: capitalize;">
                                                                                    Phone 
                                                                                </p>
                                                                            </td>
                                                                            <td>
                                                                                <p style="padding: 5px 15px; font-family: 'Heebo', sans-serif; font-weight: 500; color:#333; font-size:16px;">
                                                                                    <span style="padding-right:50px;padding-left:50px">:</span>{tier_phone}
                                                                                </p>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <p style="color: #ff6c00; margin: 0; padding: 5px 15px; font-family: 'Heebo', sans-serif; font-weight: 500; font-size:16px; text-transform: capitalize;">
                                                                                    Message 
                                                                                </p>
                                                                            </td>
                                                                            <td>
                                                                                <p style="padding: 5px 15px; font-family: 'Heebo', sans-serif; font-weight: 500; color:#333; font-size:16px;">
                                                                                    <span style="padding-right:50px;padding-left:50px">:</span>{tier_message}
                                                                                </p>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style=" padding-top: 60px; display: table; margin: auto; font-family: 'Heebo', sans-serif; font-weight: 500; font-size: 15px; color: #333;">
                                                                Regards,
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="display: table; margin: auto; font-family: 'Heebo', sans-serif; font-weight: 500; font-size: 15px; color: #333;">
                                                                <a style="color:inherit;" href="<?= base_url() ?>">Consort hardware</a>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table style="width: 100%;border-collapse: collapse;">
                                                        <tr>
                                                            <td style="margin:auto; display:table; font-family: 'Heebo', sans-serif; font-weight: 500; font-size:16px; color:black; text-transform:capitalize;">{ADDRESS}</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="margin:auto; display:table; font-family: 'Heebo', sans-serif; font-weight: 500; font-size:16px; color:black; text-transform:capitalize;">Call us: {ADMIN_PHONE}</td>
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

