<?php if ($val != '') { ?>
	<img src ="<?php echo $this->config->item('CONTACT_US_FILE_URL') . $val; ?>" width="230px" /><a href="setting/settings/remove_image/<?php echo $key ?>">Remove Image</a><br/>
<?php } ?>
<input name="<?php echo $key; ?>_FILE" type="file" class="textfield" id="<?php echo $key; ?>_FILE">&nbsp;<?php if ($comment) { ?><br/><?php echo $comment; ?><?php } ?></td>
