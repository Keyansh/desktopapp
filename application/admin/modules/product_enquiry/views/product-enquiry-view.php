<h3 class="title-hero clearfix">
    View Enquiry
    <a href="product_enquiry" class="pull-right btn btn-primary">Manage Product Enquiries</a>
</h3>
<p style="text-align:center;"><?php echo date('M. d, Y', $enquiry['added_on']) ?></p>
<br>
<div class="panel">
    <div class="panel-body">
        <div class="example-box-wrapper">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered">
                <caption>Product Details:</caption>
                <tr>
                    <td width="15%">Product Name : </td>
                    <th><?= $product['name'] ?></th>
                </tr>
                <tr>
                    <td width="15%">Product SKU : </td>
                    <th><?= $product['sku'] ?></th>
                </tr>
            </table>
            <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered">
                <caption>Customer Details:</caption>
                <tr>
                    <td width="15%">Name : </td>
                    <th><?= $enquiry['fname'] . ' ' . $enquiry['lname']; ?></th>
                </tr>
                <tr>
                    <td>Email : </td>
                    <th><?= $enquiry['email']; ?></th>
                </tr>
                <tr>
                    <td>Phone : </td>
                    <th><?= $enquiry['phone']; ?></th>
                </tr>
                <tr>
                    <td>Message : </td>
                    <th><?= $enquiry['message']; ?></th>
                </tr>
            </table>
        </div>
    </div>
</div>
