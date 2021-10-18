<h1>Edit <?php echo $field['category']; ?></h1>
<div id="ctxmenu"><a href="catalog/category/">Manage Categories</a> | <a href="catalog/additional_fields/index/<?php echo $field['category_id']; ?>">Manage <?php echo $field['category']; ?> Fields</a> </div>
<?php $this->load->view('inc-messages'); ?>

<form action="catalog/additional_fields/edit/<?php echo $field['additional_field_id']; ?>" method="post" enctype="multipart/form-data" name="addcatform" id="addcatform">

    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="formtable">

        <tr>
            <th width="177"><b>Field Name <span class="error"> *</span></b></th>
            <td width="773"><input name="field_name" type="text" class="textfield" id="field_name" value="<?php echo set_value('field_name', $field['field_name']); ?>" size="40"></td>
        </tr>

        <tr>
            <td>&nbsp;<input name="image_v" type="hidden" id="image_v" value="1"></td>
            <td  align="center">Fields marked with <span class="error">*</span> are required.</td>
        </tr>
    </table>


    <p align="center"><input type="submit" name="button" id="button" value="Submit"></p>
</form>
