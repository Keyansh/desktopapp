<h1>Edit  <?php echo $pricing_plan['pricing_plan']; ?> Prices</h1>
<div id="ctxmenu"><a href="pricing/pricing_plans/index/">Manage Pricing Plans</a></div>
<?php $this->load->view('inc-messages'); ?>
<form action="pricing/plan/add/<?php echo $pricing_plan['pricing_plan_id']; ?>" method="post" enctype="multipart/form-data" name="addcatform" id="addcatform">
    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="formtable">

        <?php
        foreach ($products as $item) {
            // print_r($products); 

            $delivery_price = '';
            if (isset($deliveryprices[$item['product_id']]['delivery_price'])) {
                $delivery_price = $deliveryprices[$item['product_id']]['delivery_price'];
            }
            $collection_price = '';
            if (isset($collectionprices[$item['product_id']]['collection_price'])) {
                $collection_price = $collectionprices[$item['product_id']]['collection_price'];
            }
            ?>
            <tr>
                <th width="30%"><?php echo $item['product_name'] . ' - ' . 'Delivery Price'; ?></th>
                <td width="30%"><input name="product_price_<?php echo $item['product_id']; ?>_<?php echo 'delivery_price'; ?>" type="text" class="textfield" id="product_price_<?php echo $item['product_id']; ?>_<?php echo 'delivery_price'; ?>" value="<?php echo set_value('product_price_' . $item['product_id'] . '_' . 'delivery_price', $delivery_price); ?>" size="40" /></td>
                <th width="20%">Collection Price:</th>
                <td width="30%"><input name="product_price_<?php echo $item['product_id']; ?>_<?php echo 'collection_price'; ?>" type="text" class="textfield" id="product_price_<?php echo $item['product_id']; ?>_<?php echo 'collection_price'; ?>" value="<?php echo set_value('product_price_' . $item['product_id'] . '_' . 'collection_price', $collection_price); ?>" size="40" /></td>
            </tr>

        <?php } ?>
        <tr>
            <td>&nbsp;</td>
            <td><input type="submit" name="button" id="button" value="Submit"></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>Fields marked with <span class="error">*</span> are required.</td>
        </tr>
    </table>
</form>
