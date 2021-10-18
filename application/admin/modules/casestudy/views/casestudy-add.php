<h1>Add Case Study</h1>
<div id="ctxmenu"><a href="casestudy/">Manage Case Studies</a></div>
<?php $this->load->view('inc-messages'); ?>
<form action="casestudy/add" method="post" enctype="multipart/form-data" name="add_frm" id="add_frm">
    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="formtable">

        <tr>
            <th>Case Study Title <span class="error">*</span></th>
            <td><input name="title" type="text" class="textfield" id="title" value="<?php echo set_value('title'); ?>" size="40"></td>
        </tr>
        <tr>
            <th>URL Alias</th>
            <td><input name="url_alias" type="text" class="textfield" id="url_alias" value="<?php echo set_value('url_alias'); ?>" size="40">
                &nbsp;(Will be auto-generated if left blank)</td>
        </tr>
        <tr>
            <th>Image <small><span class="error">*</span></small></th>
            <td><input type="file" name="image" id="image"><br />
                <small>Only .jgp,.gif,.png images allowed</small> </td>
        </tr>
        <tr>
            <th>Description<span class="error">*</span></th>
            <td><textarea name="contents" cols="40" rows="4" style="width:99%" class="textfield" id="contents"><?php echo set_value('contents'); ?></textarea></td>
        </tr>
        <tr>
            <th><input name="v_image" type="hidden" id="v_image" value="1" /></th>
            <td><input type="submit" name="upload_btn" id="upload_btn" value="Submit"></td>
        </tr>
        <tr>
            <th>&nbsp;</th>
            <td  align="center">Fields marked with <span class="error">*</span> are required.</td>
        </tr>
    </table>
</form>