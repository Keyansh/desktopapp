<link rel="stylesheet" type="text/css" href="<?= base_url() ?>plugins/image-resizer/croppic.css"/>
<h3 class="title-hero clearfix">
    New Ad Banner
    <a href="<?php echo base_url() ?>adbanner" class="pull-right btn btn-primary">Manage Ad Banners</a>
</h3>
<div class="panel">
    <div class="panel-body">
        <?php $this->load->view('inc-messages'); ?>
        <form action="adbanner/add" method="post" enctype="multipart/form-data" name="add_frm" id="add_frm">
            <div class="example-box-wrapper">
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="main">

                        <div class="form-group clearfix">
                            <label class="col-sm-3 control-label">Image <span class="error">*</span></label>
                            <div class="col-sm-6">
                                <div id="cropContainerMinimal" style="width:408px;height:224px;">
                                </div>
                            </div>
                        </div>

                        <div class="form-group clearfix">
                            <label class="col-sm-3 control-label">Alt <span class="error">*</span></label>
                            <div class="col-sm-6">
                                <input name="alt" type="text" class="form-control" value="<?php echo set_value('alt'); ?>">
                            </div>
                        </div>

                        <div class="form-group clearfix">
                            <label class="col-sm-3 control-label">Button Link</label>
                            <div class="col-sm-6">
                                <input name="link" type="text" class="form-control" value="<?php echo set_value('link'); ?>" size="40">
                            </div>
                        </div>

                        <div class="form-group clearfix">
                            <label class="col-sm-3 control-label">Heading <span class="error">*</span></label>
                            <div class="col-sm-6">
                                <input name="heading" type="text" class="form-control" value="<?php echo set_value('heading'); ?>">
                            </div>
                        </div>

                        <div class="form-group clearfix">
                            <label class="col-sm-3 control-label">Description</label>
                            <div class="col-sm-9">
                                <textarea name="description"  class="form-control" id="description"><?php echo set_value('description'); ?></textarea>
                            </div>
                        </div>

                        <div class="form-group clearfix">
                            <!-- <label class="col-sm-3 control-label"></label> -->
                            <div class="col-sm-12">
                                <input name="image_v" type="hidden" id="image_v" value="1">
                                Fields marked with <span class="error">*</span> are required.
                            </div>
                        </div>
                    </div>
                    <p align="center"><input type="submit" name="button" id="button" value="Submit" class="btn btn-lg btn-primary"></p>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="<?= base_url() ?>plugins/image-resizer/croppic.js"></script>
<script type="text/javascript">
    $(document).ready(function()
    {
        var pp = {
            uploadUrl: DWS_BASE_URL + 'adbanner/adbanner/imgsave',
            cropUrl: DWS_BASE_URL + 'adbanner/adbanner/imgcrop',
            cropData: {
                "cropH": '224',
                "cropW": '408'
            },
            modal: false,
            doubleZoomControls: false,
            rotateControls: false,
            loaderHtml: '<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
            onBeforeImgUpload: function () {
                console.log('onBeforeImgUpload')
            },
            onAfterImgUpload: function () {
                console.log('onAfterImgUpload')
            },
            onImgDrag: function () {
                console.log('onImgDrag')
            },
            onImgZoom: function () {
                console.log('onImgZoom')
            },
            onBeforeImgCrop: function () {
                console.log('onBeforeImgCrop')
            },
            onAfterImgCrop: function () {
                console.log('onAfterImgCrop')
            },
            onReset: function () {
                console.log('onReset')
            },
            onError: function (errormessage) {
                console.log('onError:' + errormessage)
            }
        }
        var cropContaineroutput = new Croppic('cropContainerMinimal', pp);
    });
</script>
