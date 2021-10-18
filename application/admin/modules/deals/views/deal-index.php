<h1>Manage Coupons</h1>
<div id="ctxmenu"><a href="coupon/add">Add Coupon</a></div>
<?php $this->load->view('inc-messages'); ?>
<?php
if (count($coupon) == 0) {
    $this->load->view('inc-norecords');
} else {
    ?>
    <div class="tableWrapper">
        <table width="100%" border="0" cellpadding="2" cellspacing="0">
            <tr>
                <th width="20%"><a href="coupon/index/coupon_title/<?php echo ($sortby == 'coupon_title') ? $toggle_direction : 'asc'; ?>">Coupon Name</a></th>
                <th width="20%">Coupon Code</th>
                <th width="15%">Coupon Value</th>
                <th width="15%">Coupon Type</th>
                <th width="10%"><a href="coupon/index/active_to/<?php echo ($sortby == 'active_to') ? $toggle_direction : 'asc'; ?>">Expire Date</a></th>
                <th width="20%">Action</th>
            </tr>

    <?php foreach ($coupon as $item) {
        ?>
                <tr <?php if ($item['coupon_active'] == 0) { ?> style="background-color:#DFFFDF" <?php } ?> id="<?php echo $item['coupon_id']; ?>" class="<?php echo alternator('', 'alt'); ?>">
                    <td width="20%"><?php echo $item['coupon_title']; ?></td>
                    <td width="20%" valign="top"><?php echo $item['coupon_code']; ?></td>
                    <td width="15%"><?php echo ($item['coupon_type'] == 'Percentage') ? $item['coupon_value'] . '%' : '$' . $item['coupon_value']; ?></td>
                    <td width="15%"><?php echo $item['coupon_type']; ?></td>
                    <td width="15%" valign="top"><?php echo $item['active_to']; ?></td>
                    <td width="20%" valign="top"><a href="coupon/edit/<?= $item['coupon_id']; ?>">Edit</a> | <a href="coupon/delete/<?= $item['coupon_id']; ?>" onclick="return confirm('Are you sure you want to delete this Coupon?');">Delete</a> |
                        <?php if ($item['coupon_active'] == '0') { ?>
                            <a href="coupon/enable/<?= $item['coupon_id']; ?>" onclick="return confirm('Are you sure you want to Activate this Coupon?');">Enable</a>
                        <?php } else { ?>
                            <a href="coupon/disable/<?= $item['coupon_id']; ?>" onclick="return confirm('Are you sure you want to Deactivate this Coupon?');">Disable</a>
                <?php } ?></td>
                </tr>
    <?php } ?>
        </table>
    </div>
<?php } ?>
