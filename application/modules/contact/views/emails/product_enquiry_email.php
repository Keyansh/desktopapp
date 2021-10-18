<!DOCTYPE html>
<html>
    <head>
        <title>Product Enquiry</title>
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:100,300,400,400i,500,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Manuale" rel="stylesheet">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body style='margin:auto;'>

        <table style=' width: 971px; padding: 0px 20px; margin: auto; border-top: 6px solid #495d80;'>
            <tr>
                <td>
                    <table width='100%'>
                        <tr>
                            <td>
                                <table width='100%' style='padding: 10px 0px; margin: auto;background: white;border-radius: 6px;'>
                                    <tr>
                                        <td>
                                            <table width='100%'>
                                                <tr>
                                                    <td><img src="<?= $this->config->item('CONTACT_US_FILE_URL') . DWS_LOGO ?>" alt="" style='display: block;'/></td>
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
                <td style="font-family: Source Sans Pro;margin: 4% 0 3%;padding: 20px 50px 70px; background-image: url(images/background-img.png);background-repeat: no-repeat; background-size: cover;">
                    <table width="100%">
                        <tr>
                            <td>
                                <table width='100%' style="margin-bottom: 25px;">
                                    <tr>
                                        <td style="font-size: 40px; color: #495d80;font-family: 'Manuale', serif; font-weight: 400;" width="70%">Product Enquiry</td>
                                        <td width="30%" style="font-size: 20px;color: #511C6C;text-align: right; font-family: 'Manuale', serif; font-weight: 400; font-size: 18px;">{DATE}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td width="100%">
                                <table width='100%' style="font-family:Raleway;color: #484848;font-size: 18px;">
                                    <tr>
                                        <td width="16%" style="padding-bottom:7px; font-family: 'Roboto', sans-serif; font-weight: 400; font-size: 16px;">Name</td>
                                        <td width="7%">-</td>
                                        <td style="font-family: 'Roboto', sans-serif; font-weight: 400; font-size: 14px;">{NAME}</td>
                                    </tr>
                                    <tr>
                                        <td width="16%" valign="top" style="padding-bottom:7px; font-family: 'Roboto', sans-serif; font-weight: 400; font-size: 16px;">Email</td>
                                        <td width="7%" valign="top">-</td>
                                        <td valign="top" style="font-family: 'Roboto', sans-serif; font-weight: 400; font-size: 14px;">{EMAIL}</td>
                                    </tr>
                                    <tr>
                                        <td width="16%" style="padding-bottom:7px; font-family: 'Roboto', sans-serif; font-weight: 400; font-size: 16px;">Phone</td>
                                        <td width="7%">-</td>
                                        <td style="font-family: 'Roboto', sans-serif; font-weight: 400; font-size: 14px;">{PHONE}</td>
                                    </tr>
                                    <tr>
                                        <td  valign="top" width="16%" style="padding-bottom:7px; font-family: 'Roboto', sans-serif; font-weight: 400; font-size: 16px;">Massage</td>
                                        <td  valign="top" width="7%">-</td>
                                        <td  valign="top" style="letter-spacing: normal;font-family: 'Roboto', sans-serif; font-weight: 400; font-size: 14px; padding-right: 70px;">
                                            {MESSAGE}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="position: relative;">
                    <table width="100%">
                        <tr>
                            <td style="text-align: right;">
                                <div style="position: absolute; bottom: -30px; right: 0px; width: 20%; float: right;">
                                    <img src="images/chair-pic.png">
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>


    </body>
</html>
