<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Heebo:100,300,400,500,700,900" rel="stylesheet">
    <title>Activation Email</title>
</head>

<body>
    <table style="border-collapse: collapse; margin: 0px auto; box-sizing: border-box; width: 100%; border-collapse:collapsed;">
        <tbody>
            <tr>
                <td style="padding: 0 15px;">
                    <table style="width: 100%; border-collapse:collapse; width:1000px; margin:auto; ">
                        <tr>
                            <td>
                                <table style="width: 800px; margin: 40px auto; display:table; margin:auto; border-collapse:collapse;">
                                    <tbody>
                                        <tr>
                                            <td style="border-top: 15px solid #060e9f; padding-bottom: 20px;">
                                                <table style="width:100%; border:0; box-shadow:1px 3px 5px 3px #88888880; padding: 40px 0px 0px 0px; background:white;">

                                                    <tr>
                                                        <td style="text-align:center;"><img width="200" src="<?= $this->config->item('CONTACT_US_FILE_URL') . DWS_LOGO ?>" alt="logo" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align:center; font-family: 'Heebo', sans-serif; font-weight:500; font-size:15px; color: #909194; padding: 0px 10px 0px 0px;">
                                                            <p style="margin-top:15px; padding-bottom:25px;"> Dated: {DATE}</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align:center; padding-top: 0;  font-family: 'Heebo', sans-serif; font-weight: 500; font-size:30px; color:#0810a0;">
                                                            Account Approved
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style=" padding: 0px 40px; font-family: 'Heebo', sans-serif; font-weight: 400; font-size:18px; color:#333; text-align:left;padding-top: 30px;">
                                                            Congratulations, your account has been approved!
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="   padding: 0px 40px; font-family: 'Heebo', sans-serif; font-weight: 400; font-size:18px; color:#333; text-align:left;padding-top: 10px;padding-bottom: 60px;">
                                                            Your account at <a href="<?= $this->config->item('site_url') ?>" target="blank" style="color: #0810a0;"><?= $this->config->item('site_url') ?></a> has been approved . You may now login and place orders.
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