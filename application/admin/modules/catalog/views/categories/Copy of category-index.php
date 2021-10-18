<h1>Manage Categories</h1>
<div id="ctxmenu"><a href="catalog/category/add/">Add Category</a></div>
<?php $this->load->view('inc-messages'); ?>
<?php
if (count($categories) == 0) {
    $this->load->view('inc-norecords');
    return;
}
?>
<div class="tableWrapper">    
    <table width="100%" border="0" cellpadding="2" cellspacing="0" class="grid">
        <tr>
            <th width="35%">Category</th>
            <th width="35%">Category Alias</th>
            <th width="30%">Action</th>
        </tr>
        <?php foreach ($categories as $row) { ?>
            <tr class="<?php echo alternator('', 'alt') ?>">
                <td valign="top"><?php echo str_repeat('&nbsp;', ($row['depth']) * 8) . $row['category']; ?></td>
                <td valign="top"><?php echo $row['category_alias']; ?></td>
                <td><?php if ($row['c_active'] == 1) { ?><a href="catalog/category/disable/<?php echo $row['category_id'] ?>" onclick="return confirm('Are you sure you want to Disable this Category?');">Disable</a><?php } else { ?><a href="catalog/category/enable/<?php echo $row['category_id'] ?>" onclick="return confirm('Are you sure you want to Enable this Category?');">Enable</a><?php } ?>  | <a href="catalog/category/edit/<?php echo $row['category_id']; ?>">Edit</a> | <a href="catalog/category/delete/<?php echo $row['category_id']; ?>">Delete </a></td>
            </tr>
        <?php } ?>
    </table>
</div>
<p style="text-align:center"><?php echo $pagination; ?></p>
