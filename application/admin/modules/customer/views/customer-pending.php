<h1>Manage Pending Customers</h1>
<?php $this->load->view('inc-messages'); ?>
<div align="center">
    <form action="customer/pending" method="post" enctype="multipart/form-data" name="filter_frm" id="filter_frm">
        <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
            <tr style="text-align:left">
                <td width="45%"><strong>Search By Name & Email:</strong>&nbsp;&nbsp;<input name="search" type="text" id="search" size="25" value="<?php echo $keywords ?>" class="textfield"></td>
                <td width="55%"><input type="submit" name="button" id="button" value="Filter"></td>
            </tr>
        </table>
    </form>
</div>
<?php
if (count($customers) == 0) {
    $this->load->view('inc-norecords');
} else {
    ?>
    <div class="tableWrapper">
        <table width="100%" border="0" cellpadding="2" cellspacing="0" class="grid">
            <tr>
                <th width="29%">Customer Name</th>
                <th width="29%">Email</th>
                <th width="14%">Phone</th>
                <th width="17%">Action</th>
            </tr>
    <?php foreach ($customers as $item) { ?>
                <tr class="<?php echo alternator('', 'alt') ?>">
                    <td valign="top"><?php echo $item['b_first_name'] . ' ' . $item['b_last_name']; ?></td>
                    <td><?php echo $item['email']; ?></td>
                    <td><?php echo$item['phone']; ?></td>
                    <td><a href="customer/approve/<?php echo $item['customer_id']; ?>">Approve</a> |<a href="customer/edit/<?php echo $item['customer_id']; ?>">Edit</a> | <a href="customer/delete/<?php echo $item['customer_id'] ?>" onclick="return confirm('Are you sure you want to Delete this Customer Profile?');">Delete</a></td>
                </tr>
    <?php } ?>
        </table>
    </div>
    <p style="text-align:center"><?php echo $pagination; ?></p>
<?php } ?>