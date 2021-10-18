<h1></h1>
<div id="ctxmenu"><a href="catalog/category/">Manage Categories</a> | <a href="catalog/category/category_delete/<?php echo $current_category['id'] ?>" onclick="return confirm('Are you sure you want to delete category and all its products?');">Delete Category</a></div>
<?php $this->load->view('inc-messages'); ?>
<h2>Select new category for current category's product</h2>
<form action="catalog/category/delete/<?php echo $current_category['id']; ?>" method="post" enctype="multipart/form-data" name="addcatform" id="addcatform">
    <table width="100%" border="0" cellspacing="0" cellpadding="2">
        <tr>
            <th>Select New Primary Category <span class="error"> *</span></th>
            <td><?php echo form_dropdown('id', $interested_in, set_value('id'), ' class="textfield"'); ?></td>
        </tr>
        <tr>
            <td></td>
            <td width="65%"><input type="submit" name="button" id="button" value="Submit"></td>
        </tr>
    </table>
</form>
<h2>Or Delete Category And All Its Products</h2>
<div class="tableWrapper">  
    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="formtable" id="">
        <tr>
            <th width="34%"><a href="catalog/category/category_delete/<?php echo $current_category['id'] ?>" onclick="return confirm('Are you sure you want to delete category and all its products?');">Delete Primary Category</a></th>
            <td width="66%"><input type="text" name="textfield" id="textfield" readonly="readonly" value="<?php echo $current_category['name']; ?>"></td>
        </tr>
        <tr>
            <th width="34%">&nbsp;</th>
            <td width="66%"></td>
        </tr>
    </table>
</div>