<h1>Edit <?php echo $block['block_title'];?>image</h1>
<div id="ctxmenu"><a href="blockimage/index/<?php echo $block['page_block_id'];?>">Manage Blockimages</a> &nbsp;|&nbsp; <a href="block/index/<?php echo $block['page_id'];?>">Manage Block</a></div>
<?php $this->load->view('inc-messages');?>
<form action="blockimage/edit/<?=$block_image['block_image_id'];?>" method="post" enctype="multipart/form-data" name="addcatform" id="addcatform">
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="formtable">
    <tr>
      <td><b>Block Image<span class="error">*</span></b></td>
     <td><img src="<?php echo $this->config->item('BLOCK_IMAGE_URL').$block_image['block_image'];?>" border="0" /><br /> 
           <input name="image" type="file" id="image" size="35" class="textfield" />
           <br />
           <small>Only .jgp,.gif,.png images allowed</small> </td>
    </tr>
    <tr>
      <td><b><input name="v_image" type="hidden" id="v_image" value="1" /></b></td>
      <td><input type="submit" name="button" id="button" value="Submit"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Fields marked with <span class="error">*</span> are required.</td>
    </tr>
  </table>
</form>
