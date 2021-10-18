<h1>Restore Snapshot</h1>
<div id="ctxmenu"><a href="cms/page">Manage Pages</a></div>
<?php $this->load->view('inc-messages'); ?>
<div style="float: left; width: 100%">
    <form action="cms/snapshots/restore/<?php echo $snapshot['page_save_log_id']; ?>" method="post" enctype="multipart/form-data" name="regFrm" id="regFrm">
        <h2 style=" padding-left: 10px; color: #ff0000;">Are you sure you want to restore this snapshot?</h2>
        <table width="100%" border="0" cellspacing="0" cellpadding="2" class="formtable">
            <tr>
                <th width="20%">Restore Revision <span class="error">*</span></th>
                <td width="80%">
                    <input type="radio" name="restore_revision" value="1" <?php echo set_radio("restore_revision", 1); ?> />Yes
                    <input type="radio" name="restore_revision" value="0" <?php echo set_radio("restore_revision", '0'); ?> />No
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td width="80%"><input type="submit" name="button" id="button" value="Submit"></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td width="80%">Fields marked with <span class="error">*</span> are required.</td>
            </tr>
        </table>
    </form>
</div>
</div>

