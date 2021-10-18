<div class="tableWrapper">
    <table width="100%" border="0" cellpadding="2" cellspacing="0">
        <tr>
            <th width="40%">Name</th>
            <!--<th width="20%">Category</th>-->
            <th width="40%">Action</th>
        </tr>
    </table>
    <table id="table-3"  width="100%" border="0" cellpadding="2" cellspacing="0">
        <?php foreach ($products as $item) { ?>
            <tr id="<?php echo $item['id']; ?>" class="<?php echo alternator('', ''); ?>">
                <td width="40%"><?php echo $item['name']; ?></td>
                <!--<td width="20%"><?php // echo $item['category'];  ?></td>-->
                <td width="40%"><?php if ($item['is_active'] == 1) { ?><a href="catalognew/product/disable/<?php echo $item['id'] ?>" onclick="return confirm('Are you sure you want to Disable this Product?');">Disable</a><?php } else { ?><a href="catalognew/product/enable/<?php echo $item['product_id'] ?>" onclick="return confirm('Are you sure you want to Enable this Product?');">Enable</a><?php } ?> | <a href="catalog/images/index/<?php echo $item['id']; ?>">Manage Images</a> | <a href="catalognew/product/edit/<?php echo $item['id']; ?>">Edit</a> | <a href="catalognew/product/delete/<?php echo $item['id'] ?>" onclick="return confirm('Are you sure you want to Delete this Product?');">Delete</a>
                    <?php // if ($item['product_type_id'] == 1 || $item['product_type_id'] == 2) { ?> |
                    <!--<a href="package/products/<?php // echo $item['id'];  ?>">Bundled Items</a>-->
                    <?php // } ?>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>

