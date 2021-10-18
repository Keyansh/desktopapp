<h1>Manage Images</h1>
<div id="ctxmenu"><a href="gallery/image/add">Upload Image</a></div>

<?php $this->load->view('inc-messages');?>

<?php if(count($images) == 0) { $this->load->view('inc-norecords'); return; }?>

<div class="tableWrapper">
	<div style="width: 110px; margin-right: 10px; margin-bottom: 10px; float: left">
<?php foreach($images as $item) { ?>
	
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		<tr>
			<td><div style="width: 100px; height: 100px; overflow: hidden"><img src="<?=$this->config->item('IMAGE_THUMBNAIL_URL').$item['image'];?>" border="0" width="100" /></div></td>
		</tr>
		<tr>
			<td style="text-align: right"><a href="gallery/image/delete/<?php echo $item['image_id'];?>" onclick="return confirm('Are you sure you want to delete this Image?');"><img src="images/icons/trash_green.png" /></a></td>
		</tr>
		</table>
	
 <?php } ?>
		</div>
	<div style="clear: both"></div>
</div>
<p align="center"><?php echo $pagination; ?></p>