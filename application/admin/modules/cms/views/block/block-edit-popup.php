<?php
$this->load->view('inc-messages');
//print_r($this->config->item('BLOCK_THUMBNAIL_URL').$block['image']); exit();
?>
<div style="float: left; width: 100%">
    <div id="tabs">
        <ul class="nav" id="tabs-nav">
            <li><a href="<?php echo current_url();?>#tabs-1">Main</a></li>
            <li><a href="<?php echo current_url();?>#tabs-2">Block Image</a></li>
        </ul>
        <form action="cms/block/edit_popup/<?php echo $block['page_id']; ?>/<?php echo $block['block_alias']; ?>" method="post" enctype="multipart/form-data" name="add_frm" id="add_frm">
            <div id="tabs-1" class="tab">
                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="formtable">
                    <tr>
                        <th width="15%">Block Title <span class="error">*</span></th>
                        <td width="80%"><input type="text" name="block_title" id="block_title" class="textfield" size="40" value="<?php echo set_value('block_title', $block['block_title']); ?>" /></td>
                    </tr>
                    <tr>
                        <th>Block Alias <span class="error">*</span></th>
                        <td><input type="text" name="block_alias" id="block_alias" class="textfield" size="40" value="<?php echo set_value('block_alias', $block['block_alias']); ?>" /></td>
                    </tr>
                    <tr>
                        <th> Link</th>
                        <td><input type="text" name="block_link" id="block_link" class="textfield" size="40 "value="<?php echo set_value('block_link', $block['block_link']); ?>"></td>
                    </tr>

                    <tr>
                        <th>Template<span class="error">*</span></th>
                        <td><?php echo form_dropdown('block_template_id', $block_template, set_value('block_template_id', $block['block_template_id']), ' class="textfield"'); ?></td>
                    </tr>
                    <tr>
                        <th>Block Content</th>
                        <td><textarea name="block_contents" class="textfield" id="block_contents" cols="45" rows="5"><?php echo set_value('block_contents', $block['block_contents']); ?></textarea></td>
                    </tr>
                    <tr>
                        <td><input name="v_image" type="hidden" id="v_image" value="1" /><input type="hidden" name="block_id" id="block_id" value="<?php echo $block['page_block_id']; ?>"></td>

                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>Fields marked with <span class="error">*</span> are required.</td>
                    </tr>
                </table>
            </div>
            <div id="tabs-2" class="tab">
                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="formtable">
                    <tr>
                        <th width="15%">Block Image</th>
                        <td width="80%"><?php if ($block['block_image']) { ?>
                                <img src="<?php echo $this->config->item('BLOCK_IMAGE_URL') . $block['block_image']; ?>" border="0" width="100px" /> &nbsp; <a href="cms/block/remove_image/<?php echo $block['page_block_id']; ?>">Remove Image</a><br /><?php } ?>
                            <input name="image" type="file" id="image" size="30" class="textfield">  <br />
                            <small>Only .jgp,.gif,.png images allowed</small> </td>
                    </tr>

                    <tr>
                        <th>Alt</th>
                        <td><input type="text" name="block_image_alt" id="block_image_alt" class="textfield" size="40 "value="<?php echo set_value('block_image_alt', $block['block_image_alt']); ?>"></td>
                    </tr>
                </table>
            </div>


            <p style="text-align:center"><input type="submit" name="submit_button" id="submit_button" value="Submit"></p>
        </form>
    </div>
</div>