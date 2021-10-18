<h1>Edit  <?php echo $pricing_plan['pricing_plan']; ?> Prices</h1>
<div id="ctxmenu"><a href="pricing/pricing_plans/index/">Manage Pricing Plans</a></div>
<?php $this->load->view('inc-messages'); ?>
<form action="pricing/plan/add/<?php echo $pricing_plan['pricing_plan_id']; ?>" method="post" enctype="multipart/form-data" name="addcatform" id="addcatform">
    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="formtable">
        <tr>
            <th width="50%">&nbsp;</th>
            <td width="50%"><h3>Price</h3></td>
            <!--<td width="50%"><h3>Unit Price</h3></td>
            <td width="30%"><h3>Case Price</h3></td>-->
        </tr>
        <?php
        foreach ($products as $item) {

            /* $case_price = '';
              if (isset($caseprices[$item['product_id']]['case_price'])) {
              $case_price = $caseprices[$item['product_id']]['case_price'];
              } */
            $unit_price = '';
            if (isset($unitprices[$item['product_id']]['unit_price'])) {
                $unit_price = $unitprices[$item['product_id']]['unit_price'];
            }
            ?>
            <tr>
                <th width="50%"><?php echo $item['product_name']; ?></th>
                <td width="50%"><input name="product_price_<?php echo $item['product_id']; ?>_<?php echo 'unit_price'; ?>" type="text" class="textfield" id="product_price_<?php echo $item['product_id']; ?>_<?php echo 'unit_price'; ?>" value="<?php echo set_value('product_price_' . $item['product_id'] . '_' . 'unit_price', $unit_price); ?>" size="40" /></td>
                <!--<td width="30%"><input name="product_price_<?php //echo $item['product_id'];   ?>_<?php //echo 'case_price';   ?>" type="text" class="textfield" id="product_price_<?php //echo $item['product_id'];   ?>_<?php //echo 'case_price';   ?>" value="<?php //echo set_value('product_price_'.$item['product_id'].'_'.'case_price',$case_price);   ?>" size="40" /></td>-->
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
