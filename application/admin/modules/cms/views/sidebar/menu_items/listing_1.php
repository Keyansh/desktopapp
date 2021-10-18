<h1><?php echo $menu_detail['menu_name']; ?></h1>
<div id="ctxmenu"><a href="menu/index/">Manage Menus</a> | <a href="menu_item/add/<?php echo $menu_detail['menu_id']; ?>">Add Page</a> | <a href="menu_item/addurl/<?php echo $menu_detail['menu_id']; ?>">Add URL</a> | <a href="menu_item/placeholder/<?php echo $menu_detail['menu_id']; ?>">Add Placeholder</a></div>
<?php $this->load->view('inc-messages');?>
<?php
if(count($menu_items) == 0) {
	$this->load->view('inc-norecords');
	return;
}
?>

<div id="menutree">
<?php echo $menutree; ?>
</div>
