<div id="ctxmenu" class="manage-by-me">
    <h1 class="title-hero clearfix pull-left">Import Data Base</h1>
    <a href="user/dashboard" class="pull-right btn btn-primary">Dashboard</a>
</div>
<?php $this->load->view('inc-messages'); ?>
<form action="" method="post" enctype="multipart/form-data" name="import">
    <br/><br/>
    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="formtable manage-by-me-table">
        <tr>
            <td width="21%" VALIGN="middle">
                <label class="control-label" style="font-weight: normal;">Import Type <span class="error">*</span></label>
            <td width="78%" VALIGN="middle">
                <select name="type" class="form-control">
                    <option value="1">Add Only</option>
                    <option value="2">Update Only</option>
                    <option value="3">Both</option>                    
                </select>
            </td>
        </tr>
        <tr>
            <td width="21%" VALIGN="middle">
                <label class="control-label" style="font-weight: normal;">CSV File <span class="error"> *</span></label></td>
            <td width="78%" VALIGN="middle">
                <input type="file" name="document" id="document" size="35" class="textfield form-control">
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center !important;">
                <br />
                <p style="text-align: center;">Fields marked with <span class="error">*</span> are required.</p>
                <input type="submit" name="button" class="btn btn-lg btn-primary" id="button" value="Submit" style="display: inline-block; text-align: center;">
            </td>
        </tr>
    </table>
</form>
