<h1>Manage >> <?php echo $pricing_plan['pricing_plan']; ?> >>Prices</h1>
<div id="ctxmenu"><a href="pricing/plan/add/<?php echo $pricing_plan['pricing_plan_id']; ?>">Add Pricing Plan</a> | <a href="pricing_plans/index/">Manage Pricing Plans</a></div>
<?php $this->load->view('inc-messages'); ?>
<?php
if (count($plans) == 0) {
    $this->load->view('inc-norecords');
    return;
}
?>
<div class="tableWrapper">
    <table width="100%" border="0" cellpadding="2" cellspacing="0" class="grid">
        <tr>
            <th width="39%">Product Name</th>
            <th width="39%">Prices</th>
            <th width="39%">Action</th>

        </tr>
<?php foreach ($plans as $item) { ?>
            <tr class="<?php echo alternator('', 'alt'); ?>">
                <td><?php echo $item['product_name']; ?></td>
                <td><?php echo $item['product_price']; ?></td>
                <td><a href="pricing/plan/edit/<?php echo $item['product_pricing_id']; ?>">Edit</a> </td>
            </tr>
<?php } ?>
    </table>
</div>