<h1>Manage <?php echo $block['block_title'];?>images</h1>
<div id="ctxmenu"><a href="blockimage/add/<?php echo $block['page_block_id'];?>">Add BlockImage</a> &nbsp;|&nbsp; <a href="block/index/<?php echo $block['page_id'];?>">Manage Block</a>&nbsp;| &nbsp;<a href="page/index/">Manage Pages</a></div>
<?php if(count($block_images) == 0) { $this->load->view('inc-norecords'); } else {?>
<div class="tableWrapper">
<table width="100%" border="0" cellpadding="2" cellspacing="0">
<tr>
	
	<th width="73%">Block Image</th>
    <th width="27%">Action</th>
</tr>
</table>
<table id="table-3"  width="100%" border="0" cellpadding="2" cellspacing="0">
<?php foreach($block_images as $item) { ?>
    <tr id="<?php echo $item['block_image_id'];?>" class="<?php echo alternator('', '');?>">
    <td width="73%"><img src="<?php echo $this->config->item('BLOCK_IMAGE_URL').$item['block_image'];?>" border="0" /></td>
    <td width="27%"><a href="blockimage/edit/<?php echo $item['block_image_id'];?>">Edit</a> | <a href="blockimage/delete/<?php echo $item['block_image_id'];?>" onclick="return confirm('Are you sure you want to delete this Block Image?');">Delete</a></td>
    </tr>
 <?php } ?>
</table>
</div>
<?php } ?>