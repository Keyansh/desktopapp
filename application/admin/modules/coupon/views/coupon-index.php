<h3 class="title-hero clearfix">
    Manage Coupons
    <a href="coupon/add" class="pull-right btn btn-primary">Add Coupon</a>
</h3>
<?php
$this->load->view('inc-messages');
if (count($coupon) == 0) {
    $this->load->view('inc-norecords');
    echo "</div>";
    return;
}
?>

<div class="panel">
    <div class="panel-body">
        <div class="example-box-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <div class="remove-columns">
                        <table class="table table-bordered table-striped table-condensed cf">
                            <thead class="cf">
                                <tr>
                                    <th width="20%" style="color: black;"><a href="coupon/index/coupon_title/<?php echo ($sortby == 'coupon_title') ? $toggle_direction : 'asc'; ?>" style="text-decoration: none;color: black;">Coupon Name</a></th>
                                    <th width="20%" style="color: black;">Coupon Code</th>
                                    <th width="15%" style="color: black;">Coupon On</th>
                                    <th width="15%" style="color: black;"><a href="coupon/index/expire_date/<?php echo ($sortby == 'expire_date') ? $toggle_direction : 'asc'; ?>" style="text-decoration: none;color: black;">Expires Date</a></th>
                                    <th width="20%" style="color: black;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($coupon as $item) {
                                    ?>
                                    <tr <?php if ($item['coupon_active'] == 0) { ?> style="background-color:#DFFFDF" <?php } ?> id="<?php echo $item['id']; ?>" class="<?php echo alternator('', 'alt'); ?>">
                                        <td width="20%"><?php echo $item['coupon_title']; ?></td>
                                        <td width="20%" valign="top"><?php echo $item['coupon_code']; ?></td>
                                        <td width="15%"><?php echo $item['coupon_on']; ?></td>

                                        <td width="15%" valign="top"><?php echo $item['expire_date']; ?></td>
                                        <td width="20%" valign="top">
                                            <?php if ($item['coupon_active'] == '0') { ?>
                                                <a href="coupon/enable/<?= $item['id']; ?>" onclick="return confirm('Are you sure you want to Activate this Coupon?');"><i class="glyph-icon icon-eye-slash red-color"></i></a>
                                            <?php } else { ?>
                                                <a href="coupon/disable/<?= $item['id']; ?>" onclick="return confirm('Are you sure you want to Deactivate this Coupon?');"><i class="glyph-icon icon-linecons-eye green-color"></i></a>
                                            <?php } ?>
                                            <a href="coupon/edit/<?= $item['id']; ?>"><i class="glyph-icon icon-linecons-pencil"></i></a> <a href="coupon/delete/<?= $item['id']; ?>" onclick="return confirm('Are you sure you want to delete this Coupon?');"><i class="glyph-icon icon-linecons-trash red-color"></i></a> 
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination"><?= $pagination ?></div>
                </div>
            </div>
        </div>
    </div>
</div>