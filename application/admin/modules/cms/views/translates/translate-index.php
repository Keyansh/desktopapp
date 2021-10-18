<h1><?php echo $page['title'];?> - Translations</h1>
<?php $sess = array();
	  $sess['PREVIOUS_PAGE'] = $page['page_id'];
	  $this->session->set_userdata($sess);
?>
<div id="ctxmenu"><a href="cms/page/index/">Manage Pages</a> | <a href="cms/page/edit/<?php echo $page['page_id'];?>">Edit Page</a> | <a href="cms/block/index/<?php echo $page['page_id']; ?>">Manage Blocks</a> <?php if($page['language_code'] == 'en') { ?>| <a href="cms/page/duplicate/<?php echo $page['page_id']; ?>">Duplicate Page</a><?php } ?>
   | <a href="cms/snapshots/index/<?php echo $page['page_id']; ?>">Page Snapshots</a> <?php if(!empty($languages)) { foreach($languages as $item) { if(!array_key_exists($item['language_code'], $pages)) { ?>| <a href="cms/translate/add/<?php echo $item['language_code'];?>/<?php echo $page['page_id'];?>">Add <?php echo $item['language'];?> Page</a> <?php  } } } ?>
</div>
<?php $this->load->view('inc-messages');?>
<div class="tableWrapper">
<?php
	if(count($pages_translate) == 0) {
		$this->load->view('inc-norecords');
		echo "</div>";
		return;
	} ?>
    <table width="100%" border="0" cellpadding="2" cellspacing="0" class="grid">
      <tr>
          <th width="40%">Page Title</th>
          <th width="40%">Page Language</th>
        <th width="20%">Action</th>
      </tr>
		<?php foreach($pages_translate as $row) { ?>
        <tr class="<?php echo alternator('','alt')?>">
            <td><?php echo  $row['title'];?></td>
            <td><?php echo  $row['native_name'];?></td>
            <td><a href="cms/block/index/<?php echo $row['page_id'];?>">Manage Blocks</a> | <a href="cms/page/edit/<?php echo $row['page_id'];?>/1">Edit</a> | <a href="cms/translate/delete/<?php echo $page['page_id'];?>/<?php echo $row['page_id'];?>" onclick="return confirm('Are you sure you want to delete this Page Version?');">Delete</a>
            </td>
        </tr>
		<?php } ?>
    </table>
</div>