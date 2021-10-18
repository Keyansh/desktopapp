<style>
    .modal-header .close {
        color: #ff6c00;
        /* z-index: 1111111; */
        opacity: 1;
        position: fixed;
        right: -9px;
        top: -9px;
        border: 1px solid black;
        width: 25px;
        height: 25px;
        border-radius: 47px;
        background-color: black;
    }
</style>

<div id="review-model" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body clearfix">
                <form name="form" id="addReviewForm" class="addReviewForm">
                    <div class="inner-form col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label for="rate">Rating Star <span class="required">*</span></label>
                            <div id="default" class="defaultstar" style="margin: 0;"></div>
                            <div class="ratingerror error" style="display:none;color:red">Please select rate</div>
                        </div>
                    </div>
                    <div class="inner-form col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="name">
                                    <div class="nameerror error" style="display:none;color:red">Please enter your name</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="review">Review<span class="required">*</span></label>
                                    <textarea class="form-control" name="review" rows="6"></textarea>
                                    <div class="reviewerror error" style="display:none;color:red">Please enter your review</div>
                                </div>
                            </div>
                        </div>
                        <div class="ratingResponse" style="color: green">
                        </div>
                        <div class="row">
                            <div class="col-md-12" id="reviewSubmit">
                                <?php if ((isLogged()) && (checkReviewedUser($this->session->userdata('CUSTOMER_ID'), $product['id']))) { ?>
                                    <button style="background-color:#ff6c00;border:none; color:black;" type="button" class="btn btn-block disabled">You have already reviewed</button>
                                <?php } else if ((isLogged()) && (!checkReviewedUser($this->session->userdata('CUSTOMER_ID'), $product['id']))) { ?>
                                    <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                                    <input type="hidden" name="user_id" value="<?= $this->session->userdata['CUSTOMER_ID']; ?>">
                                    <button id="review-submit-btn" type="button" class="btn btn-primary btn-block ReviewB nn-style-btn-pro-css">Submit</button>
                                    <?php
                                } else {
                                    ?>
                                    <button style="background-color:#ff6c00;border:none; color:black;" type="button" class="btn btn-block disabled">Please login to review</button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div style="padding: 15px 30px;" class="modal-footer">
                <button style="background: #ff6c00;border-color: transparent; text-transform: capitalize;" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<div id="Modal-thanks" class="modal fade in" role="dialog" style="display: none; padding-right: 15px;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div style="padding:18px 0px 18px 0px;text-align:center;">
                <button type="button" class="close" data-dismiss="Modal-thanks">×</button>
                <h4 style="color:green;">Thanks for rating this product. Please wait for approval.</h4>
            </div>
        </div>
    </div>
</div>

<div class="clearfix"></div>

<div id="tier-model" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 style="margin:0;line-height: 1.42857143;">Contact us</h4>
            </div>
            <div class="modal-body clearfix">
                <form name="form" id="tier-Form" class="addReviewForm">
                    <input type="hidden" name="user_id" value="<?= $this->session->userdata('CUSTOMER_ID') ?>">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <input class="tier_qty_val" type="hidden" name="tier_qty" value="">
                    <input type="hidden" name="tier_product" value="<?= $product['name'] ?>">
                    <div class="inner-form col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Product Name:</label><span><?= $product['name'] ?></span></br>
                                    <label>Quantity:</label><span class="tier_quantity"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Name<span class="required">*</span></label>
                                    <input class="tier-form-name" type="text" name="tier_name">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Email<span class="required">*</span></label>
                                    <input id="tier-email" type="email" name="tier_email">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Phone<span class="required">*</span></label>
                                    <input class="tier-phone" type="text" name="tier_phone">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Message<span class="required">*</span></label>
                                    <textarea class="form-control tier-form-message" name="tier_message" rows="6"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="ratingResponse" style="color: green">
                        </div>
                        <div class="row">
                            <div class="col-md-12" id="reviewSubmit">
                                <div class="status-msg"></div>
                                <button style="background:#ff6c00" id="tier-submit-btn" type="button" class="btn btn-block nn-style-btn-pro-css">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>