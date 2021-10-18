<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Salesvault</title>
        <style type="text/css">
            <!--
            .style1 {
                font: 18px Arial, Helvetica, sans-serif;
                color: #1c7a91;
            }
            -->
        </style></head>

    <body>
        <div style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px">
            <p align="center">
                <span class="style1">Salesvault</span><br />
                Dated - {DATE}</p>
            <p>Dear Admin</p><br/>
            <p>Following products having quantity less than 5.:</p>
            <table width="100%" border="0" cellspacing="0" cellpadding="4" style="border: 1px solid #CCC;">
                <tr style="text-align:left; background-color:#CCC">
                    <th>Product Name</th>
                    <th>Quantity</th>
                </tr>
                <?php foreach ($PRODUCTS as $item) {
                    ?>

                    <tr>
                        <td><div class="product_name"><strong><?php echo $item['product_name']; ?></strong></div>	  	
                        </td>
                        <td><strong><?php echo $item['product_quantity']; ?></div>	  	
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </body>
</html>