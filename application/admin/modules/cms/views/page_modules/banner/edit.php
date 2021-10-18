<table width="100%" border="0" cellspacing="0" cellpadding="2" class="formtable">
    <tr>
        <th width="15%">Main Banner</th>
        <td width="85%">
            <?php if ($banner['page_setting_value'] != '') { ?>
                <img src="<?php echo $this->config->item('PAGE_URL') . $banner['page_setting_value']; ?>" border="0" width="200" /><br/>
            <?php } ?>
            <input type="file" name="image" id="image" /><br />
            <small>Only .jgp,.gif,.png images allowed</small></td>
    </tr>
    <tr>
        <td><input type="hidden" name="image_v" id="image_v" value="1"></td>
        <td></td>
    </tr>
</table>