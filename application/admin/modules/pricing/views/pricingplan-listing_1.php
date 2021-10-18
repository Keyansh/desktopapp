<h1>Manage Pricing Plans</h1>
<div id="ctxmenu"><a href="pricing/pricing_plans/add/">Add Pricing Plan</a></div>
<?php $this->load->view('inc-messages'); ?>
<?php
if (count($pricing_plans) == 0) {
    $this->load->view('inc-norecords');
    return;
}
?>
<div class="tableWrapper">
    <table width="100%" border="0" cellpadding="2" cellspacing="0" class="grid">
        <tr>
            <th width="39%">Pricing Plan</th>
            <th width="19%">Action</th>
        </tr>
<?php foreach ($pricing_plans as $item) { ?>
            <tr class="<?php echo alternator('', 'alt'); ?>">
                <td><?php echo $item['pricing_plan']; ?></td>
                <td><a href="pricing/plan/add/<?php echo $item['pricing_plan_id']; ?>">Set Prices</a> <?php if ($item['editable'] == 1) { ?>| <a href="pricing/pricing_plans/edit/<?php echo $item['pricing_plan_id']; ?>">Edit</a> | <a href="pricing/pricing_plans/delete/<?php echo $item['pricing_plan_id']; ?>" onclick="return confirm('Are you sure you want to delete this Pricing Plan?');">Delete</a><?php } ?></td>
            </tr>
<?php } ?>
    </table>
</div>
<p style="text-align:center"><?php echo $pagination; ?></p>
