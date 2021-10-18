<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>consort template</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<style>
    body {
        margin: 0px;
        font-weight: 400;
        font-family: 'Poppins', sans-serif;
    }

    .category-class {
        width: 30.7%;
        float: left;
        padding: 10px 7px;
    }

    .news-category {
        width: 22.1%;
        float: left;
        padding: 2px 8px;
    }
</style>

<body>

    <table style="width:600px;margin:auto;background: #fafafa;border-collapse: collapse;">
        <tr>
            <td>
                <table style="width:100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 20px 0;">
                            <div>
                                <img src="<?= $this->config->item('CONTACT_US_FILE_URL') . DWS_LOGO ?>" alt="header-logo" style="display: block;margin: auto;" class="img-responsive" />
                            </div>
                        </td>

                    </tr>

                    <tr>
                        <td style="padding: 0; width: 100%;">
                            <div>
                                <img src="{BASE_URL}images/news-bg-1.jpg" alt="news-bg" style="padding: 0;width: 100%;" class="img-responsive">
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td>
                <table style="width:100%">

                    <tr>
                        <td style="padding: 20px 20px 0 30px">
                            <?php foreach ($CATEGORY as $item) : ?>
                                <div class="category-class">
                                    <a href="{SITE_URL}<?= $item['uri'] ?>" style="text-decoration: none;">
                                        <?php
                                        if ($item['image']) {
                                            $image_url = $this->config->item('CATEGORY_IMAGE_URL') . $item['image'];
                                        } else {
                                            $image_url = '{BASE_URL}images/img-default.jpg';
                                        }
                                        ?>
                                        <img src="<?= $image_url ?>" alt="product-alt" style="width: 100%;" class="img-responsive">

                                        <p style="font-size: 18px;line-height: 24px;color: #263388;font-weight: 500; width:100%;margin-top: 0;margin-bottom: 0;font-family: 'Poppins', sans-serif;">
                                            <?= $item['name'] ?>
                                        </p>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
        <tr>
            <td>
                <a href="{SITE_URL}ironmongery" style="margin: auto;display: table; margin-bottom: 40px;margin-top: 30px;"> <img src="{BASE_URL}images/complete range.png" alt="btn-logo"></a>
            </td>
        </tr>
        <tr>
            <td style="width: 100%;">
                <img src="{BASE_URL}images/news-bg-2.jpg" alt="news-bg" style="width: 100%;" class="img-responsive">
            </td>
        </tr>
        <tr>
            <td>
                <table style="width:100%;border-collapse: collapse;">
                    <tr>
                        <td>
                            <p style="font-family: 'Poppins', sans-serif;font-size: 22px;line-height: 25px;color: #000;font-weight: 500;width: 100%;text-align: center;margin-top: 30px;margin-bottom: 30px;">
                                Products you were also interested in...</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="padding: 0 20px;">
                <table style="width:100%;border-collapse: collapse;">
                    <tr style="width:100%">
                        <td>
                            <?php foreach ($PRODUCT as $item) : ?>
                                <div class="news-category">
                                    <a href="{SITE_URL}<?= $item['uri'] ?>" style="text-decoration: none;">
                                        <?php
                                        if ($item['product_image']['img']) {
                                            $image_url = $this->config->item('PRODUCT_URL') . $item['product_image']['img'];
                                        } else {
                                            $image_url = '{BASE_URL}images/img-default.jpg';
                                        }

                                        ?>
                                        <div style="border: 1px solid #aeaeae">
                                            <img src="<?= $image_url ?>" alt="news-cat" style="margin: auto;display: table;max-width: 100%;" class="img-responsive">
                                        </div>
                                        <p style="font-size: 15px;line-height: 35px;color: #000;font-weight: 400;margin-top: 0;font-family: 'Poppins', sans-serif;">
                                            <?= $item['name'] ?></p>
                                    </a>
                                </div>
                            <?php endforeach ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>



        <tr style="background-image: url({BASE_URL}images/footer-bg.png);background-repeat: no-repeat;background-size: 100% 100%;">
            <td>
                <table style="width:600px; border-collapse: collapse;">

                    <tr>
                        <td>
                            <div>
                                <img src="{BASE_URL}images/line.png" alt="line-alt" style="margin:auto;display: table;padding-top: 16px;" class="img-responsive">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="font-size: 22px;line-height: 25px;color: #000;font-weight: 300;font-style: italic;text-align: center;margin-bottom: 0;margin-top: 30px;font-family: 'Poppins', sans-serif;">
                                Looking for some other stuff?</p>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <p style="text-align: center;margin-bottom: 0;font-size: 18px;line-height: 30px; color: #000;margin-top: 8px;font-family: 'Poppins', sans-serif;">
                                Call us <a href="tel:{ADMIN_PHONE}" style="font-size: 18px;line-height: 30px;color: #000;text-decoration: none;">{ADMIN_PHONE}</a></p>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <p style="text-align: center;margin-top: 0;font-size: 18px;line-height: 30px; color: #000; font-family: 'Poppins', sans-serif;">
                                or drop us email <a href="{EMAIL_ADMIN}" style="font-size: 18px;line-height: 30px;color: #263388;">{EMAIL_ADMIN}</a>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div style="margin-bottom: 15px;margin: auto; display: table;">
                                <a href="{SITE_URL}contact-us"> <img src="{BASE_URL}images/contact button.png" alt="range-alt" style="margin-bottom: 30px;margin-top: 30px;display: table;" class="img-responsive"></a>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div>
                                <ul style="display: flex;flex-wrap: wrap;align-items: center;justify-content: center;width: 100%;padding-left: 0;">
                                    <?php if (DWS_FACEBOOK_ACCOUNT) { ?>
                                        <li style="list-style-type: none;">
                                            <a href="<?= DWS_FACEBOOK_ACCOUNT ?>" style="background: #424242;padding: 11px 11px;margin: 5px 8px;border-radius: 25px;width: 16px;text-align: center;font-size: 15px;color: #fff;text-decoration: none;" class="fa fa-facebook"></a>
                                        </li>
                                    <?php } ?>
                                    <?php if (DWS_INSTAGRAM_ACCOUNT) { ?>
                                        <li style="list-style-type: none;">
                                            <a href="<?= DWS_INSTAGRAM_ACCOUNT ?>" style="background: #424242;padding:11px 11px;margin: 5px 8px;border-radius: 25px;width: 16px;text-align: center;font-size: 15px;color: #fff;text-decoration: none;" class="fa fa-instagram"></a>
                                        </li>
                                    <?php } ?>
                                    <?php if (DWS_TWITTER_ACCOUNT) { ?>
                                        <li style="list-style-type: none;">
                                            <a href="<?= DWS_TWITTER_ACCOUNT ?>" style="background: #424242;padding: 11px 11px;margin: 5px 8px;border-radius: 25px;width: 16px;text-align: center;font-size: 15px;color: #fff;text-decoration: none;" class="fa fa-twitter"></a>
                                        </li>
                                    <?php } ?>
                                    <?php if (DWS_LINKEDIN_ACCOUNT) { ?>
                                        <li style="list-style-type: none;">
                                            <a href="<?= DWS_LINKEDIN_ACCOUNT ?>" class="fa fa-linkedin" style="color: #fff;text-decoration: none;background: #424242;padding: 11px 11px;margin: 5px 8px;border-radius: 25px;width: 16px;text-align: center;font-size: 15px;"></a>
                                        </li>
                                    <?php } ?>
                                    <?php if (DWS_PINTEREST_ACCOUNT) { ?>
                                        <li style="list-style-type: none;">
                                            <a href="<?= DWS_PINTEREST_ACCOUNT ?>" class="fa fa-pinterest" style="color: #fff;text-decoration: none;background: #424242;padding: 11px 11px;margin: 5px 8px;border-radius: 25px;width: 16px;text-align: center;font-size: 15px;"></a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>

</html>