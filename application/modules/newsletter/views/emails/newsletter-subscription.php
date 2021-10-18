<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="https://fonts.googleapis.com/css?family=Heebo:100,300,400,500,700,900" rel="stylesheet"> 
        <title>Subscription</title>
    </head>
    <body>
        <table style="border-collapse: collapse;  margin: 0px auto; box-sizing: border-box; width: 1000px; border-collapse:collapsed;">
            <tbody>
                <tr> 
                    <td style="padding: 0 15px;">
                        <table style="border-collapse:collapse; width:100%; margin:auto; ">
                            <tr>
                                <td>
                                    <table style="width: 800px; margin: 40px auto; display:table; margin:auto; border-collapse:collapse;">
                                        <tbody>
                                            <tr>
                                                <td style="border-top: 15px solid #0810a0; padding-bottom: 20px;">
                                                    <table style="width:100%; border:0; box-shadow:1px 3px 5px 3px #88888880; padding: 20px 0px 0px 0px; background:white;" >
                                                       
                                                        <tr>
                                                            <td style="text-align:center;"><img width="200" src="<?= $this->config->item('CONTACT_US_FILE_URL') . DWS_FOOTER_LOGO ?>" alt="logo"/></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align:center; font-family: 'Heebo', sans-serif; font-weight: 400; font-size:22px; color:#333;"><span style="font-weight:700; color:#0810a0; font-size:30px; margin-top: 60px; display: inline-block;">Joined Mailing List </span></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align:center; font-family: 'Heebo', sans-serif; font-weight:500; font-size:15px; color: #909194; padding: 0px 0px 0px 0px; "><p style="text-align: center;">Dated: {DATE}</p></td>
                                                        </tr>
                                                        <!-- <tr>
                                                            <td style="text-align:center; font-family: 'Heebo', sans-serif; font-weight: 400; font-size:22px; color:#333;"><span style="font-weight:400; color:#0810a0; font-size:22px;">Dear Admin, </span></td>
                                                        </tr> -->
                                                        <tr>
                                                            <td style="text-align:center; font-family: 'Heebo', sans-serif; font-weight: 400; font-size:17px; color:#333; padding: 60px 0px 80px 0px; text-align: center; line-height: 22px;">The person having email address <a href="mailto:{EMAIL}">{EMAIL}</a>,  has joined the mailing list.</td>
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