<h1>Manage <?php echo $category['category']; ?> >> Fields</h1>
<div id="ctxmenu"><a href="catalog/additional_fields/add/<?php echo $category['category_id']; ?>">Add Field</a> | <a href="catalog/category/index">Manage Categories</a></div>
<?php $this->load->view('inc-messages'); ?>
<?php
if (count($fields) == 0) {
    $this->load->view('inc-norecords');
    return;
}
?>
<div class="tableWrapper">    
    <table width="100%" border="0" cellpadding="2" cellspacing="0" class="grid">
        <tr>
            <th width="37%">Field Name</th>
            <th width="19%">Action</th>
        </tr>
        <?php foreach ($fields as $row) { ?>
            <tr class="<?php echo alternator('', 'alt') ?>">
                <td valign="top"><?php echo $row['field_name']; ?></td>
                <td><a href="catalog/additional_fields/edit/<?php echo $row['additional_field_id']; ?>">Edit</a> | <a href="catalog/additional_fields/delete/<?php echo $row['additional_field_id']; ?>" onclick="return confirm('Are you sure you want to delete this Field?');">Delete</a></td>
            </tr>
        <?php } ?>
    </table>
</div>

