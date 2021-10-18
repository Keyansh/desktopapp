 
<h1>Cost Log</h1>
<div id="ctxmenu"><a href="catalog/cost">Manage cost</a> | <a href="catalog/cost/history">Cost Log</a></div>
<?php $this->load->view('inc-messages'); ?>
<div class="tableWrapper">
    <table width="100%" border="0" cellpadding="2" cellspacing="0">
        <tr>
            <th width="20%" class="border">Category Name</th>
            <th width="20%" class="border">Price</th>
            <th width="20%" class="border">Date</th>
        </tr>
        <?php foreach ($historylog as $history){?>
        <tr>
            <td><?=$history['category'];?></td>
            <td><?=$history['pricing'];?>%</td>
            <td><?=date('d F Y', $history['added_on']);?></td>
        </tr>
        <?php }?>
    </table>
    <p style="text-align:center"><?php echo $pagination; ?></p>
</div>
