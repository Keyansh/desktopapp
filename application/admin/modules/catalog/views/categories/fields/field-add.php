<h1>Add <?php echo $category['category']; ?> Field</h1>
<div id="ctxmenu"><a href="catalog/category/index/">Manage Categories</a> | <a href="catalog/additional_fields/index/<?php echo $category['category_id']; ?>">Manage <?php echo $category['category']; ?> Fields</a></div>
<?php $this->load->view('inc-messages'); ?>

<form action="catalog/additional_fields/add/<?php echo $category['category_id']; ?>" method="post" enctype="multipart/form-data" name="addcatform" id="addcatform">

    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="formtable">

        <tr>
            <th width="178"><b>Field Name <span class="error"> *</span></b></th>
            <td width="772"><input name="field_name" type="text" class="textfield" id="field_name" value="<?php echo set_value('field_name'); ?>" size="40"></td>
        </tr>
        <tr>
            <td><input name="image_v" type="hidden" id="image_v" value="1">
            </td>

        </tr>
    </table>

    <p align="center"><input type="submit" name="button" id="button" value="Submit"></p>
</form>

