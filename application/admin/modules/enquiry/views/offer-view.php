<h3 class="title-hero clearfix">
    View Offer Enquiry
    <a href="enquiry/offer" class="pull-right btn btn-primary">Manage Offer Enquiries</a>
</h3>
<div class="panel">
    <div class="panel-body">
        <div class="example-box-wrapper">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered">
                <tr>
                    <td>Offer : </td>
                    <th><?= $enquiry['subject']; ?></th>
                    <td>Name : </td>
                    <th><?= $enquiry['first_name'].' '.$enquiry['last_name']; ?></th>
                </tr>
                <tr>
                    <td>Email : </td>
                    <th><?= $enquiry['email']; ?></th>
                    <td>Contact : </td>
                    <th><?= $enquiry['contact']; ?></th>
                </tr>
                <tr>
                    <th colspan="4">Message : <br /><br /><?= $enquiry['message']; ?></th>
                </tr>
            </table>
        </div>
    </div>
</div>