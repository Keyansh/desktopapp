
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>New Order Placed</title>
	</head>

	<body>
		<div style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px;">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
				<tr>
					<td style="color:#000000; vertical-align:top; width:50%"><b>Order Placed Successfully</b><br /> <i>Dated: {DATE}</i></td>

				</tr>
			</table><br />
			<p>Your order has been placed successfully. See below for order details:</p>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="16%"><b>Order No.</b></td>
					<td width="84%">: <?php echo $DATA['order']['order_num']; ?></td>
				</tr>
				<tr>

					<td><b>Subtotal</b></td>
					<td>: <?php echo DWS_CURRENCY_SYMBOL . ' ' . $DATA['order']['cart_total']; ?></td>
				</tr>
				<tr>
					<td><b>Total</b></td>
					<td>: <?php echo DWS_CURRENCY_SYMBOL . ' ' . $DATA['order']['order_total']; ?></td>
				</tr>

				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
			</table>
			<table width="100%" border="0" cellspacing="0" cellpadding="4" style="border: 1px solid #CCC;">
				<tr style="text-align:left; background-color:#CCC">
					<th width="51%">Item</th>
					<th width="18%">Quantity</th>

					<th width="16%">Price</th>
					<th width="15%">Amount</th>
				</tr>
				<?php
				foreach ($DATA['cart_contents'] as $item) {	
					//$options =  base64_encode(serialize($item['options']));
					?>
					<tr>
						<td><?php
							echo $item['name'];/*
							if ($options) {
								?> (
								<?php
								foreach ($options as $key => $val) {
									$key = $this->Cartmodel->GetOptions($key);
									?>
									<?php if ($key != 'image') { ?>
										<span class="lg_text" style="color:#02A3C6;"><b><?php echo $key; ?>:</b> </span> <?php echo $val; ?>,
										<?php
									}
								}
								?> )
							<?php }*/ ?>

						</td>

						<td><?php echo $item['qty']; ?>&nbsp;</td>
						<td><?php echo DWS_CURRENCY_SYMBOL . ' ' . number_format($item['price'], 2); ?></td>
						<td><?php echo DWS_CURRENCY_SYMBOL . ' ' . number_format($item['price'] * $item['qty'], 2); ?>&nbsp;</td>
					</tr>
				<?php } ?>
			</table>
			<br />

		</div>
	</body>
</html>