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
                                                        <td style="text-align:center; font-family: 'Heebo', sans-serif; font-weight:500; font-size:15px; color: #909194; padding: 0px 10px 0px 0px; ">
                                                            <p style=" padding-bottom:15px;padding-top: 30px;"> Dated: {date}</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align:center; padding-top: 25px;  font-family: 'Heebo', sans-serif; font-weight: 500; font-size:35px; color:#060e9f;">
                                                            Register Successfully
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align:left; padding-top: 25px;  font-family: 'Heebo', sans-serif; font-weight: 500; font-size:19px; color:black;padding: 10px 10px;padding-bottom: 100px;padding-top: 50px;">
                                                            Your customer account has been created . Please wait until admin approve your account, this can take upto 24 hours. 
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td style="text-align:center; font-family: 'Heebo', sans-serif; font-weight: 500; font-size:16px; color:white; text-transform:capitalize;padding-top: 20px;background-color: #0810a0;">
                                                            {ADDRESS}
                                                            <p style="margin-top: 3px;padding-bottom: 20px;">Call us: {PHONE}</p>
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