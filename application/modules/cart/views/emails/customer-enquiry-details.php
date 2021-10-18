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
    <table style="border-collapse: collapse; background:  url('{BASE_URL}images/email-table-bg-img.png') repeat scroll 0% 0%; margin: 0px auto; box-sizing: border-box; width: 100%; border-collapse:collapsed;">
        <tbody>
            <tr>
                <td style="padding: 0 15px;">
                    <table style="width: 100%; border-collapse:collapse; width:1000px; margin:auto; ">
                        <tr>
                            <td>
                                <table style="width: 800px; margin: 40px auto; display:table; margin:auto; border-collapse:collapse;">
                                    <tbody>
                                        <tr>
                                            <td style="border-top: 15px solid #0810a0; padding-bottom: 20px;">
                                                <table style="width:100%; border:0; box-shadow:1px 3px 5px 3px #88888880; padding: 20px 0px 0px 0px; background:white;">

                                                    <tr>
                                                        <td style="text-align: center;"><img width="200" src="<?= $this->config->item('CONTACT_US_FILE_URL') . DWS_LOGO ?>" alt="logo" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="display: table; margin: auto; font-family: 'Heebo', sans-serif; font-weight:500; font-size:15px; color: #909194; padding: 10px 0px 10px 0px; ">Dated: {DATE}</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-transform: capitalize; padding: 20px 40px; font-family: 'Heebo', sans-serif; font-weight: 400; font-size:20px; color:#333;">
                                                            Dear {NAME}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="  padding: 0px 40px; font-family: 'Heebo', sans-serif; font-weight: 400; font-size:15px; color:#333; padding-bottom: 50px; ">
                                                            Thank you for sending your enquiry . A member of our team will contact you shortly
                                                        </td>
                                                    </tr>
                                                    <!-- <tr>
                                                        <td style=" padding: 10px 40px 0px; font-family: 'Heebo', sans-serif; font-weight: 400; font-size:15px; color:#333; ">
                                                            Your enquiry details:
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 10px 40px 0px;">
                                                            <table width="100%" style="border-collapse: collapse;">
                                                                <tr>
                                                                    <th style="text-align: left;border: solid 1px lightgrey; background-color: #efefef; padding: 10px; font-family: 'Heebo', sans-serif; font-weight: 400; font-size:15px;" width="160">Name</th>
                                                                    <td style="border: solid 1px lightgrey; padding: 10px; font-family: 'Heebo', sans-serif; font-weight: 400; font-size:15px;">{NAME}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th style="text-align: left;border: solid 1px lightgrey; background-color: #efefef; padding: 10px; font-family: 'Heebo', sans-serif; font-weight: 400; font-size:15px;" width="160">Email</th>
                                                                    <td style="border: solid 1px lightgrey; padding: 10px; font-family: 'Heebo', sans-serif; font-weight: 400; font-size:15px;">{EMAIL}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th style="text-align: left;border: solid 1px lightgrey; background-color: #efefef; padding: 10px; font-family: 'Heebo', sans-serif; font-weight: 400; font-size:15px;" width="160">Message/Query</th>
                                                                    <td style="border: solid 1px lightgrey; padding: 10px; font-family: 'Heebo', sans-serif; font-weight: 400; font-size:15px;">{ENQUIRY}</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr> -->
                                                
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