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

        .containerContact {
            position: relative;
            padding-left: 35px;
            padding-bottom: 15px;
            cursor: pointer;
            font-size: 15px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            font-family: 'Heebo', sans-serif;
            display: block;
            pointer-events: none;
        }


        /* Hide the browser's default checkbox */

        .containerContact input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }


        /* Create a custom checkbox */

        .containerContact .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 25px;
            width: 25px;
            background-color: #eee;
        }


        /* On mouse-over, add a grey background color */

        .containerContact:hover input~.checkmark {
            background-color: #ccc;
        }


        /* When the checkbox is checked, add a blue background */

        .containerContact input:checked~.checkmark {
            background-color: #0810a0;
        }


        /* Create the checkmark/indicator (hidden when not checked) */

        .containerContact .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }


        /* Show the checkmark when checked */

        .containerContact input:checked~.checkmark:after {
            display: block;
        }


        /* Style the checkmark/indicator */

        .containerContact .checkmark:after {
            left: 9px;
            top: 5px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 3px 3px 0;
            -webkit-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            transform: rotate(45deg);
        }
    </style>
</head>

<body>
    <table style="border-collapse: collapse;" align="center">
        <tbody>
            <tr>
                <td>
                    <table style="width: 100%; border-collapse:collapse; width:800px;">
                        <tr>
                            <td>
                                <table style="width: 800px; margin: 40px auto; display:table; margin:auto; border-collapse:collapse;">
                                    <tbody>

                                        <tr>
                                            <td style="border-top: 15px solid #060e9f; padding-bottom: 0px;">
                                                <table style="width:100%; border:0; box-shadow:1px 3px 5px 3px #88888880; padding: 0px; background:white; ">

                                                    <tr>
                                                        <td colspan="2" style="text-align:center; padding: 25px 0px 20px 0px;"><img width="200" src="<?= $this->config->item('CONTACT_US_FILE_URL') . DWS_LOGO ?>" alt="logo"></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" style="padding:0; ">
                                                            <p style="margin: 0px 0px 40px 0px; padding: 0; text-align: center;text-transform:uppercasel; font-family: 'Heebo', sans-serif;">Dated:
                                                                <span style="display:inline-block;padding: 0px 0px;font-weight:400;padding-right: 15px;">{date}</span>

                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" style="padding: 0 0px;">
                                                            <table style="font-family: roboto; font-weight: 300; color: #333333; font-size: 14px; width: 100%; border-collapse:collapse;">
                                                                <tbody>

                                                                    <tr>
                                                                        <td colspan="3">
                                                                            <h1 style="color: #060e9f; text-align:center; text-transform:capitalize; font-size: 35px; font-weight:700; font-family: 'Heebo', sans-serif;margin-bottom: 50px;">
                                                                                New User Registered

                                                                            </h1>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width: 6%;">
                                                                            <p style="color:#060e9f; margin: 0; text-transform: capitalize; padding: 5px 0px;font-family: 'Heebo', sans-serif; font-weight: 500;font-size:16px; padding-left: 108px">
                                                                                Name
                                                                            </p>
                                                                        </td>
                                                                        <td style="width: 5%;">
                                                                            <p style="text-align:center; margin: 0;">
                                                                                :
                                                                            </p>
                                                                        </td>
                                                                        <td style="width: 89%;">
                                                                            <p style="padding: 5px 0px; font-family: 'Heebo', sans-serif; font-weight: 400; color:#333; font-size:16px; margin:0;">
                                                                                {first_name}
                                                                            </p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width: 6%;">
                                                                            <p style="color:#060e9f; margin: 0; text-transform: capitalize; padding: 5px 0px;font-family: 'Heebo', sans-serif; font-weight: 500;font-size:16px; padding-left: 108px">
                                                                                Name
                                                                            </p>
                                                                        </td>
                                                                        <td style="width: 5%;">
                                                                            <p style="text-align:center; margin: 0;">
                                                                                :
                                                                            </p>
                                                                        </td>
                                                                        <td style="width: 89%;">
                                                                            <p style="padding: 5px 0px; font-family: 'Heebo', sans-serif; font-weight: 400; color:#333; font-size:16px; margin:0;">
                                                                                {last_name}
                                                                            </p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width: 6%;">
                                                                            <p style="color: #060e9f; margin: 0; padding: 5px 0px; font-family: 'Heebo', sans-serif; font-weight: 500; font-size:16px; text-transform: capitalize; padding-left: 108px">
                                                                                Email
                                                                            </p>
                                                                        </td>
                                                                        <td style="width: 5%;">
                                                                            <p style="text-align:center; margin: 0;">
                                                                                :
                                                                            </p>
                                                                        </td>
                                                                        <td style="width: 89%;">
                                                                            <a href="mailto:{email}" style="padding: 5px 0px; font-family: 'Heebo', sans-serif; font-weight: 400; color:#0810a0; font-size:16px; margin:0;">
                                                                                {email}
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width: 6%;">
                                                                            <p style="color: #060e9f; margin: 0; padding: 5px 0px; font-family: 'Heebo', sans-serif; font-weight: 500; font-size:16px; text-transform: capitalize; padding-left: 108px">
                                                                                Phone
                                                                            </p>
                                                                        </td>
                                                                        <td style="width: 5%;">
                                                                            <p style="text-align:center; margin: 0;">
                                                                                :
                                                                            </p>
                                                                        </td>
                                                                        <td style="width: 89%;">
                                                                            <p style="padding: 5px 0px; font-family: 'Heebo', sans-serif; font-weight: 400; color:#333; font-size:16px; margin:0;">
                                                                                {PHONE}
                                                                            </p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width: 6%;">
                                                                            <p style="color: #060e9f; margin: 0; padding: 5px 0px; font-family: 'Heebo', sans-serif; font-weight: 500; font-size:16px; text-transform: capitalize; padding-left: 108px">
                                                                                Company
                                                                            </p>
                                                                        </td>
                                                                        <td style="width: 5%;">
                                                                            <p style="text-align:center; margin: 0;">
                                                                                :
                                                                            </p>
                                                                        </td>
                                                                        <td style="width: 89%;">
                                                                            <p style="padding: 5px 0px; font-family: 'Heebo', sans-serif; font-weight: 400; color:#333; font-size:16px; margin:0;">
                                                                                {company_name}
                                                                            </p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width: 6%;padding-bottom: 90px;">
                                                                            <p style="color: #060e9f; margin: 0; padding: 5px 0px; font-family: 'Heebo', sans-serif; font-weight: 500; font-size:16px; text-transform: capitalize; padding-left: 108px">
                                                                                Location
                                                                            </p>
                                                                        </td>
                                                                        <td style="width: 5%;padding-bottom: 90px;">
                                                                            <p style="text-align:center; margin: 0;">
                                                                                :
                                                                            </p>
                                                                        </td>
                                                                        <td style="width: 89%;padding-bottom: 90px;">
                                                                            <p style="padding: 5px 0px; font-family: 'Heebo', sans-serif; font-weight: 400; color:#333; font-size:16px; margin:0;">
                                                                                {location}
                                                                            </p>
                                                                        </td>
                                                                    </tr>

                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="3" style="text-align:center; font-family: 'Heebo', sans-serif; font-weight: 500; font-size:16px; color:white; text-transform:capitalize;padding-top: 20px;background-color: #0810a0;">
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