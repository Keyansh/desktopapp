<h1>Manage Snapshots</h1>
<div id="ctxmenu"><a href="cms/page">Manage Pages</a>  | <a href="cms/page/edit/<?php echo $page_details['page_id']; ?>">Edit Page</a> | <a href="cms/block/index/<?php echo $page_details['page_id']; ?>">Manage Blocks</a>
    <?php if ($page_details['language_code'] == 'en') { ?>| <a href="cms/translate/index/<?php echo $page_details['page_id']; ?>">Translate</a><?php } ?> | <a href="cms/snapshots/index/<?php echo $page_details['page_id']; ?>">Page Snapshots</a></div>
<?php
if (empty($snapshots)) {
    $this->load->view('inc-norecords');
} else {
    $this->load->view('inc-messages');
    ?>
    <div class="tableWrapper">
        <table width="100%" border="0" cellpadding="2" cellspacing="0" class="grid">
            <tr>

                <th width="40%">Snapshots Date/time</th>
                <th width="40%">Author</th>
                <th width="20%">Action</th>
            </tr>
            <?php 
            $counter = 0;
            foreach ($snapshots as $item) { 
                $counter++;?>
                <tr  class="<?php echo alternator('', 'alt'); ?>">
                    <td><?php echo date('j F Y - H:i:s', $item['page_save_time']); ?>&nbsp; <?php if($counter == 1) { ?>[Current Version]<?php }?></td>
                    <td><?php echo ucfirst(strtolower($item['username']));?></td>
                    <td><?php if($counter != 1) { ?><a href="cms/snapshots/restore/<?php echo $item['page_save_log_id']; ?>">Restore</a><?php } ?> </td>
                </tr>
            <?php } ?>
        </table>
    </div>
<?php } ?>