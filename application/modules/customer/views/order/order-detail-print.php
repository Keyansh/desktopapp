<div class="order_print" style="font-size:16px;">
	<strong>
		<p>Desktop Deli</p>
		<p>
			Company: <?php echo $order['company_name']; ?><br />
			Customer: <?php echo $order['first_name'] . ' ' . $order['last_name']; ?><br />
			Location: <?php echo $location['location_title']; ?><br />
			Delivery date: <?php echo cms_ustouk_date($order['delivery_date']); ?><br />
			Delivery time: <?php echo $location['location_delivery_time']; ?><br />
			Order No: <?php echo $order['order_num']; ?>
		</p>
	</strong>
</div>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="grid">
	<tr>
		<th width="50%"><b>Item</b></th>
		<th width="10%"><b>Qnty</b></th>
		<th width="20%"><b>Price</b></th>
		<th width="20%"><b>Subtotal</b></th>
	</tr>

	<?php foreach ($order_items as $item) { ?>
		<tr>
			<td><?php echo $item['order_item_name']; ?><?php echo $item['is_meal']?" - {$item['products']}":""; ?></td>
			<td><?php echo $item['order_item_qty']; ?></td>
			<td>&pound;<?php echo $item['order_item_price']; ?></td>
			<td>&pound;<?php echo number_format($item['order_item_qty'] * $item['order_item_price'], 2); ?></td>
		</tr>
	<?php } ?>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td style="border-top: 1px solid #000;"><b>&pound;<?php echo $order['cart_total']; ?></b></td>
	</tr>
</table>

<p>Thank you for your order</p>
