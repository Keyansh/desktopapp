<h1>Import Data Base</h1>
<div id="ctxmenu"><a href="user/dashboard">Dashboard</a></div>
<?php $this->load->view('inc-messages'); ?>
<form action="import/categories/" method="post" enctype="multipart/form-data" name="addcatform" id="addcatform">
    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="formtable">
        <tr>
            <th width="130">Section</th>
            <td width="605">Categories</td>
        </tr>
        <tr>
            <th>CSV File <span class="error"> *</span></th>
            <td><input type="file" name="document" id="document" size="35" class="textfield">
                <br />
                <small><strong>Only .csv file allowed</strong></small></td>
        </tr>
        <tr>
            <td><input name="document_v" type="hidden" id="document_v" value="1"></td>
            <td><input type="submit" name="button" id="button" value="Submit"></td>
        </tr>
        <tr>
            <td></td>
            <td style="text-align: center !important;">Fields marked with <span class="error">*</span> are required.</td>
        </tr>
    </table>
</form>
