<h1>Manage Case Studies</h1>
<div id="ctxmenu"><a href="casestudy/add">Add Case Study</a></div>

<?php $this->load->view('inc-messages'); ?>

<?php
if (count($casestudies) == 0) {
    $this->load->view('inc-norecords');
    return;
}
?>

<div class="tableWrapper">
    <table width="100%" border="0" cellpadding="2" cellspacing="0">
        <tr>
            <th width="90%">Case Study Title</th>
            <th width="10%">Action</th>
        </tr>
<?php foreach ($casestudies as $item) { ?>
            <tr class="<?php echo alternator('', ''); ?>">
                <td><?php echo $item['title']; ?></td>
                <td><a href="casestudy/edit/<?php echo $item['casestudy_id']; ?>">Edit</a> | <a href="casestudy/delete/<?php echo $item['casestudy_id']; ?>" onclick="return confirm('Are you sure you want to delete this Case Study?');">Delete</a></td>
<?php } ?>
    </table>
</div>