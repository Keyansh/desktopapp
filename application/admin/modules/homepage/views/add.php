<h3 class="title-hero clearfix">
    Select Offers
    <div class="pull-right">
        <a href="homepage" class="btn btn-primary">Manage Homepage Offers</a>
    </div>
</h3>
<div class="panel">
    <div class="panel-body">
        <div class="example-box-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <?php $this->load->view('inc-messages'); ?>
                    <form action="homepage/homeoffer/add" method="post" enctype="multipart/form-data" name="add_frm" id="add_frm">
                        <div class="form-group clearfix">
                            <div class="col-sm-12 comp-inner">                                
                                <ul class="list-inline">
                                    <?php foreach ($offers as $offer) { ?>
                                        <li>
                                            <label class="btn btn-default"><span class="img-responsive img-check"><?= $offer['name']; ?></span>
                                                <input type="checkbox" name="offerids[]" value="<?= $offer['id']; ?>" <?= (in_array($offer['id'], $selectedOffers) ? 'checked' : '') ?>>
                                            </label>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-10 text-center">
                                Fields marked with <span class="error">*</span> are required.<br />
                                <input type="submit" name="upload_btn" class="btn btn-primary" id="upload_btn" value="Submit">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .comp-inner .img:hover{
        border-color: #833264;
    }
</style>