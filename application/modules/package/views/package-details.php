<h1>Package: <?php echo $package['product_name']; ?></h1>
<div id="descriptions" style="float:none; width:auto;">
	<p align="justify"><?php echo $package['product_desc']; ?></p>

	<?php if ($products) { ?>
		<?php $this->load->view('inc-messages'); ?>
		<div id="bottom_box">
			<form action="package/index/<?php echo $package['product_alias']; ?>/<?php echo $cart_id; ?>" method="post" enctype="multipart/form-data" name="cart_frm" id="cart_frm">
			<h3 style="text-transform: none;">This package includes:</h3>
			<table width="100%" cellpadding="0" cellspacing="0" class="table_grid">
				<tbody>
					<tr>
						<th width="40%">Product</td>
						<th width="5%">Quantity</td>
						<th width="55%">&nbsp;</td>
					</tr>
					<?php foreach ($products as $product) { ?>
					<tr>
						<td><?php echo $product['product_name']; ?> - <?php echo $product['model_no']; ?></td>
						<td><?php echo $product['product_quantity']; ?></td>
						<td>
							<?php if ($product['product_extra_price'] != 0) { ?>
								Add additional <input type="text" name="<?php echo $product['product_id'];?>" value="0" size="4" style="width: 20px;" /> <?php echo $product['product_name']; ?> at <?php echo DWS_CURRENCY_SYMBOL . $product['product_extra_price']; ?> each
							<?php } ?>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
			<div style="clear: both"></div>
			<?php if ($this->memberauth->checkAuth()) { ?>
			<p class="price" style="float: left; margin-top: 15px;"><?php echo DWS_CURRENCY_SYMBOL . $package['product_unit_price']; ?></p>
			<p style="float: right; margin-top: 15px;"><input type="image" src="images/btn-buynow.gif" width="152" height="43" value="1" name="buy" /></p>
			<?php } ?>
			<div style="clear: both"></div>
			</form>
		</div>
	<?php } else {
	$this->load->view('inc-norecords');
	}?>
</div>
<div style="clear:both"></div>