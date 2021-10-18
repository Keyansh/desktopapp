<?php foreach ($includes as $key => $val) { ?>
    <div class="tableWrapper">
        <h2><?php echo $key; ?></h2>
        <table width="100%" border="0" cellspacing="0" cellpadding="4" class="formtable_grid">
            <?php foreach ($val as $row) { ?>
                <tr>                                    
                    <td width="30%"><?php echo $row['include_name']; ?></td>
                    <td width="70%">
                        <?php if (in_array($row['include_id'], $page_includes)) { ?><a href="cms/page/disable_include/<?php echo $page_details['page_id'] . '/' . $row['include_id'] . '/' . $target; ?>"><img src="images/Aqua-Ball-Red-icon.png" /></a><?php } else { ?><a href="cms/page/enable_include/<?php echo $page_details['page_id'] . '/' . $row['include_id'] . '/' . $target; ?>"><img src="images/Aqua-Ball-Green-icon.png" /></a><?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <div style="clear: both; padding-top: 20px;"></div>
<?php } ?>