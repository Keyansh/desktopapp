<h1>Manage Wishlist</h1>
<?php
    $this->load->view('inc-messages');
?>
<?php
    if (count($wishlist) == 0) {
        $this->load->view('inc-norecords');
        return;
    }
?>

<br>
<div class="tableWrapper">
    <table width="100%" border="0" cellpadding="2" cellspacing="0" class="pad-table table border-table">
        <tr>
            <th style="color:black;" width="5%">SN</th>
            <th style="color:black;" width="20%">Customer Name</th>
            <th style="color:black;" width="30%">Email</th>
            <th style="color:black;" width="10%">Product SKU</th>
            <th style="color:black;" width="20%">Wished on</th>
        </tr>
        <?php
            if($wishlist) {
                $sn = 1;
                foreach($wishlist as $item) {
                    $customer_name = ucfirst($item['fname']) . ' ' . ucfirst($item['lname']);
                    ?>
                        <tr>
                            <td><?php echo $sn; ?></td>
                            <td><?php echo $customer_name ?></td>
                            <td><?php echo $item['email'] ?></td>
                            <td><?php echo $item['sku'] ?></td>
                            <td><?php echo date('M, d. Y h:i:sA', $item['added_on']) ?></td>
                        </tr>
                    <?php
                    $sn++;
                }
            }
        ?>
    </table>
</div>
<p align="center"><?php echo $pagination; ?></p>
