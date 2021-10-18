    <h1>Order No. <?php echo $order['order_num'];?></h1>
	<p>
		<strong><?php echo $order['company_name'];?></strong><br />
		<?php echo $order['company_address'];?><br />
		Ph: <?php echo $order['company_phone'];?>
	</p>
    <div class="hr_line"></div>
    <div class="detail_bg">
        <div class="billing_detail">
			<h2>Billing Details</h2>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="grid">
                <tr>
                    <td width="20%">Address 1:</td>
                    <td width="80%"><?php echo $order['billing_address1']; ?>&nbsp;</td>
                </tr>
                <tr>
                    <td>Address 2:</td>
                    <td><?php echo $order['billing_address2']; ?>&nbsp;</td>
                </tr>
                <tr>
                    <td>Town/City:</td>
                    <td><?= $order['billing_city']; ?>&nbsp;</td>
                </tr>
                <tr>
                    <td>State:</td>
                    <td><?php echo $order['billing_state']; ?>&nbsp;</td>
                </tr>
                <tr>
                    <td>Zip Code:</td>
                    <td><?php echo $order['billing_zipcode']; ?>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </div>
		
        <div class="billing_detail" style="margin-right:0px">
			<h2>Delivery Details</h2>
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="grid">
                <tr>
                    <td width="20%">Address 1:</td>
                    <td width="80%"><?php echo $order['delivery_address1']; ?>&nbsp;</td>
                </tr>
                <tr>
                    <td>Address 2:</td>
                    <td><?php echo $order['delivery_address2']; ?>&nbsp;</td>
                </tr>
                <tr>
                    <td>Town/City:</td>
                    <td><?php echo $order['delivery_city']; ?>&nbsp;</td>
                </tr>
                <tr>
                    <td>State:</td>
                    <td><?php echo $order['delivery_state']; ?>&nbsp;</td>
                </tr>
                <tr>
                    <td>Zip Code:</td>
                    <td><?php echo $order['delivery_zipcode']; ?>&nbsp;</td>
                </tr>
                <tr>
                    <td>Phone:</td>
                    <td><?php echo $order['delivery_phone']; ?>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </div>
        <div style="clear:both"></div>
    </div>
	
    <div class="hr_line"></div>
	<h2>Item Details</h2>
    
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="grid">
        <tr>
            <th width="41%" ><b>Item</b></th>
            <th width="30%" ><b>Quantity</b></th>
            <th width="29%" ><b>Price</b></th>
        </tr>

        <?php foreach ($order_items as $item) { ?>
                <tr>
                    <td>
                        <div class="product_name"><?php echo $item['order_item_name']; ?></div></td>
                    <td><?php echo $item['order_item_qty']; ?></td>
                    <td>&pound;<?php echo $item['order_item_price']; ?></td>
                </tr>
            <?php 
        } ?>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<th>&nbsp</th>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><b>&pound;<?php echo $order['cart_total']; ?></b></td>
				</tr>
    </table>

