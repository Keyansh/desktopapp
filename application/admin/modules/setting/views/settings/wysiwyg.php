

<textarea name="<?php echo $key; ?>" id="<?php echo $key; ?>" rows="5" style="width:95%" class="textfield mceEditor"><?php echo set_value("$key", $val); ?></textarea> &nbsp;<?php if($comment) { ?><?php echo $comment;?><?php } ?>