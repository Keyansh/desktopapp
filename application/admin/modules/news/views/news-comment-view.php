<?php //e($commentdetails)?>
<h3 class="title-hero clearfix">
    View Comments
    <a href="news/ViewComments/<?= $commentdetails['news_id']; ?>" class="pull-right btn btn-primary">Manage Comments</a>
</h3>
<div class="panel">
    <div class="panel-body">
        <div class="example-box-wrapper">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered">
                <tr>
                    <td width="15%">Name : </td>
                    <th><?= $commentdetails['c_name']; ?></th>
                </tr>
                <tr>
                    <td>Email : </td>
                    <th><?= $commentdetails['c_mail']; ?></th>
                </tr>
                
                <tr>
                    <td>comment : </td>
                    <th><?= $commentdetails['message']; ?></th>
                </tr>
            </table>
        </div>
    </div>
</div>