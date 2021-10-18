<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/widgets/datatable/datatable.css">
<script type="text/javascript" src="<?= base_url(); ?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable-tabletools.js"></script>
<div class="col-md-6" style="margin:2% 0px;">
    <h3>Manage <b><?= ($category) ? $category['name'] : ''; ?></b> Products</h3>
</div>
<div class="col-md-12">
    <?php $this->load->view('inc-messages'); ?>
    <?php
    if (count($products) == 0) {
        $this->load->view('inc-norecords');
    } else {
        ?>
        <table id="cproductstable" class="display jas-table" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th style="color:black;">#</th>
                    <th style="color:black;">Name</th>
                    <th width="15%" style="color:black;">SKU</th>
                    <th width="15%" style="color:black;">Type</th>
                    <th width="15%" style="color:black;">Price</th>
                    <th width="10%" style="color:black;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($products) {
                    foreach ($products as $key => $value) {
                        ?>
                        <tr role="row">
                            <td class="dt-center">
                                <input name="proIds[]" value="0" class="proSelAll" type="checkbox">
                            </td>
                            <td><?php echo $value['name']; ?></td>
                            <td><?php echo $value['sku']; ?></td>
                            <td><?php echo $value['type']; ?></td>
                            <td><?php echo $value['price']; ?></td>
                            <td class=" dt-center">
                                <div class="page_item_options">
                                    <?php
                                    $classD = $value['is_active'] == 1 ? 'icon-linecons-eye green-color' : 'icon-eye-slash red-color';
                                    ?>
                                    <a><i pro_id="<?php echo $value['pid']; ?>" class="edProduct glyph-icon <?php echo $classD; ?>"></i></a>
                                    <a href="catalog/product/edit/<?php echo $value['pid']; ?>" class="">
                                        <i class="glyph-icon icon-linecons-pencil"></i>
                                    </a> 
                                    <a onclick="return confirm('Are you sure you want to delete this product?');" href="catalog/product/delete/<?php echo $value['pid']; ?>" class="">
                                        <i class="glyph-icon icon-linecons-trash red-color"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
    <?php } ?>
</div>
<style>
    #example_filter{display: none}
</style>
<script type="text/javascript">
    $(document).ready(function () {
        $('#cproductstable').DataTable();
        $(document).on('click', '.edProduct', function () {
            var $parentThis = $(this);
            var pid = $(this).attr('pro_id');
            $.post("catalog/product/ed", {pid: pid}, function (data) {
                if (data == 1) {
                    $parentThis.removeClass();
                    $parentThis.addClass('edProduct glyph-icon icon-linecons-eye green-color');
                } else if (data == 0) {
                    $parentThis.removeClass();
                    $parentThis.addClass('edProduct glyph-icon icon-eye-slash red-color');
                }
                return false;
            });
        });
    });
</script>