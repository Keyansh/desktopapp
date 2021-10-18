<?php $this->load->view('meta/tierenquiry_view'); ?>
<h3 class="title-hero clearfix">
    View Tier Product Enquiry
</h3>
<div>
    <a href="tierenquiry"><b>Manage Group Product Enquiry</b></a>
</div>
<div id="tabs">
    <div class="panel">
        <div class="panel-body">
            <form action="blog/edit/<?php echo $tier['blog_id']; ?>" method="post" enctype="multipart/form-data" name="add_frm" id="add_frm">
                <div id="tabs-1" class="tab">
                    <div class="example-box-wrapper">
                        <div id="myTabContent" class="tab-content">
                            <div class="tab-pane fade active in" id="main">
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label"><b>Product Name:</b></label>
                                    <div class="col-sm-6">
                                        <?= $tier['tier_product'] ?>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label"><b>Quantity:</b></label>
                                    <div class="col-sm-6">
                                        <?= $tier['tier_qty'] ?>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label"><b>Name:</b></label>
                                    <div class="col-sm-6">
                                        <?= $tier['tier_name'] ?>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label"><b>Email:</b></label>
                                    <div class="col-sm-6">
                                        <?= $tier['tier_email'] ?>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label"><b>Phone:</b></label>
                                    <div class="col-sm-6">
                                        <?= $tier['tier_phone'] ?>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label font-weight-bold"><b>Message:</b></label>
                                    <div class="col-sm-6">
                                        <?= $tier['tier_message'] ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
