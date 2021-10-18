<h3 class="title-hero clearfix">
    View Enquiry
    <a href="enquiry" class="pull-right btn btn-primary">Manage Enquiries</a>
</h3>
<div class="panel">
    <div class="panel-body">
        <div class="example-box-wrapper">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered">
                <tr>
                    <td width="25%">Name : </td>
                    <th><?= $enquiry['name'] ?> <?= $enquiry['last_name']; ?></th>
                </tr>
                <tr>
                    <td>Email : </td>
                    <th><?= $enquiry['email']; ?></th>
                </tr>
                <tr>
                    <td>Contact : </td>
                    <th><?= $enquiry['telnumber'] ? $enquiry['telnumber'] : 'null' ?></th>
                </tr>
                <tr>
                    <td>Company : </td>
                    <th>
                        <?= $enquiry['company']; ?>
                    </th>
                </tr>
                <tr>
                    <td>Location : </td>
                    <th>
                        <?= $enquiry['location']; ?>
                    </th>
                </tr>
                <tr>
                    <td> Agree to be contacted by our team : </td>
                    <th><?= $enquiry['contact_by_team'] ? 'Yes' : 'NO'; ?></th>
                </tr>
                <tr>
                    <td>Agree to join our mailing list : </td>
                    <th><?= $enquiry['join_mail_list'] ? 'Yes' : 'NO'; ?></th>
                </tr>
            </table>
        </div>
    </div>
</div>