<!DOCTYPE html>
<html>
    <head>
        <title>Brand me now | Offer</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--FONTS-->
        <link href="https://fonts.googleapis.com/css?family=Muli:300,400,700|Roboto:300,400,500" rel="stylesheet">

        <style type="text/css">
            @import url('https://fonts.googleapis.com/css?family=Muli:300,400,700|Roboto:300,400,500');
            body{margin: 0 !important;padding: 0 !important;}
            @media (max-width:1199px){body > table{width: 70% !important;}}
            @media (max-width:991px){body > table{width: 80% !important;}}
            @media (max-width:767px){body > table{width: 100% !important;}}
        </style>
    </head>
    <!--<body style="margin: 0 !important;padding: 0 !important;box-sizing: border-box;background: #222222;">-->
    <body style="margin: 0 !important;padding: 0 !important;">
        <table style="border-collapse: collapse; background: #f3f3f3 url('{BASE_URL}images/email-table-bg-img.png') repeat scroll 0% 0%; margin: 0px auto; box-sizing: border-box; width: 100%;" border="0">
            <tbody>
                <tr>
                    <td style="padding: 0 15px;">
                        <table style="width: 100%;" border="0">
                            <tbody>
                                <tr>
                                    <td style="border-bottom: 2px dotted #A6A6A6; padding: 12px 0;">
                                        <a style="text-decoration: none; display: table; margin: 0 auto; outline: none;" href="#"><img style="height: auto; display: block; margin: 0 auto; max-width: 100%; outline: none;" src="{BASE_URL}upload/useruploads/images/logo.png" width="605" height="94" /></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="padd-td" style="padding: 3% 7%;">
                                        <table style="width: 100%;" border="0">
                                            <tbody>
                                                <tr>
                                                    <td style="font-family: roboto; font-weight: 300; color: #333; font-size: 16px; padding: 0 5px 0 0;">
                                                        <p style="margin: 0; line-height: normal; display: table; border-bottom: 2px dotted #A6A6A6; padding-bottom: 5px;">Dear Admin,<br />
                                                            The person having email address <b>{EMAIL}</b> ,has requested for offer. Person detail is below :-</p>
                                                    </td>
                                                    <td style="font-family: roboto; font-weight: 300; color: #333; font-size: 14px;">
                                                        <p style="margin: 0; display: table; line-height: normal;">Dated: <span>{DATE}</span></p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="padd-td" style="padding: 4% 7% 3%;">
                                        <table style="font-family: roboto; font-weight: 300; color: #333333; font-size: 14px; width: 100%;" border="0">
                                            <tbody>
                                                <tr>
                                                    <td style="width: 15%;" valign="top">
                                                        <p style="background-color: #dbe59c; color: #636746; margin: 0; padding: 5px 15px;">First Name :</p>
                                                    </td>
                                                    <td style="width: 85%;" valign="top">
                                                        <p style="background-color: #dbe59c; color: #636746; margin: 0 0 0 15px; padding: 5px 15px;">{FNAME}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 15%;" valign="top">
                                                        <p style="background-color: #dbe59c; color: #636746; margin: 0; padding: 5px 15px;">Last Name :</p>
                                                    </td>
                                                    <td style="width: 85%;" valign="top">
                                                        <p style="background-color: #dbe59c; color: #636746; margin: 0 0 0 15px; padding: 5px 15px;">{LNAME}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 15%;" valign="top">
                                                        <p style="background-color: #dbe59c; color: #636746; margin: 0; padding: 5px 15px;">Email :</p>
                                                    </td>
                                                    <td style="width: 85%;" valign="top">
                                                        <p style="background-color: #dbe59c; color: #636746; margin: 0 0 0 15px; padding: 5px 15px;">{EMAIL}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 15%;" valign="top">
                                                        <p style="background-color: #dbe59c; color: #636746; margin: 0; padding: 5px 15px;">Contact :</p>
                                                    </td>
                                                    <td style="width: 85%;" valign="top">
                                                        <p style="background-color: #dbe59c; color: #636746; margin: 0 0 0 15px; padding: 5px 15px;">{CONTACT}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 15%;" valign="top">
                                                        <p style="background-color: #dbe59c; color: #636746; margin: 0; padding: 5px 15px;">Message :</p>
                                                    </td>
                                                    <td style="width: 85%;" valign="top">
                                                        <p style="background-color: #dbe59c; color: #636746; margin: 0 0 0 15px; padding: 5px 15px 5%;">{MESSAGE}</p>
                                                    </td>
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
                                                    <td>
                                                        <p style="margin: 0 0 10px;">From: <span>Consort hardware</span></p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p style="margin: 0;">33 Hampton Street, Hockey, Birmingham, B19 3LS</p>
                                                        <p style="margin: 0;">Call us <span>+44 (121)2360482</span></p>
                                                    </td>
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
