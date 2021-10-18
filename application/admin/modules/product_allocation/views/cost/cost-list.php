 
<h1>Cost Log</h1>
<div id="ctxmenu"><a href="catalog/cost">Manage cost</a> | <a href="catalog/cost/history">Cost Log</a></div>
<?php $this->load->view('inc-messages'); ?>
<div class="tableWrapper">
    <table width="100%" border="0" cellpadding="2" cellspacing="0">
        <tr>
            <th width="20%" class="border">Category Name</th>
            <th width="20%" class="border">Price</th>
            <th width="20%" class="border">Date</th>
            <th width="20%" class="border">Action</th>
        </tr>
        <?php foreach ($costlog as $cost) { ?>
            <tr>
                <td><?= $cost['category']; ?></td>
                <td><?= $cost['pricing']; ?>%</td>
                <td><?= date('d/m/Y', $cost['discount_added_on']); ?></td>
                <td><?php if ($cost['active'] == 1) { ?> <a href="catalog/cost/action/<?php echo  $cost['category_id'] . '_0'; ?>" onclick="return confirm('Are you sure you want to Hold this price?');">Hold</a> <?php } else { ?><a href="catalog/cost/action/<?php echo $cost['category_id'] . '_1'; ?>" onclick="return confirm('Are you sure you want to Un Hold this Price?');">Un hold</a> <?php } ?> </td>
                </tr>
            <?php } ?>
        </table>
        <p style="text-align:center"><?php echo $pagination; ?></p>
</div>
