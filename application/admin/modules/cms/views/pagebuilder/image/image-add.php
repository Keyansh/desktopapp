<h1> Add <?php echo $block['block_title'];?> Image</h1>
<div id="ctxmenu"><a href="blockimage/index/<?php echo $block['page_block_id'];?>">Manage Blockimages</a> </div>
<?php $this->load->view('inc-messages');?>
<form action="blockimage/add/<?php echo $block['page_block_id'];?>" method="post" enctype="multipart/form-data" name="add_frm" id="add_frm">
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="formtable">
    <tr>
      <td>Block Image <small><span class="error">*</span></small></td>
      <td><input type="file" name="image" id="image" class="textfield"></td>
    </tr>
    <tr>
      <td><input name="v_image" type="hidden" id="v_image" value="1" /></td>
      <td><input type="submit" name="upload_btn" id="upload_btn" value="Upload"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Fields marked with <span class="error">*</span> are required.</td>
    </tr>
  </table>
</form>