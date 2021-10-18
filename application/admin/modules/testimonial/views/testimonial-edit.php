<h3 class="title-hero clearfix">
    Update Testimonial
    <a href="testimonial" class="pull-right btn btn-primary">Manage Testimonials</a>
</h3>
<?php $this->load->view('inc-messages'); ?>
<div id="tabs">
    <div class="panel">
        <div class="panel-body">

            <ul class="nav" id="tabs-nav">
                <!-- <li><a href="<?php echo current_url(); ?>#tabs-1">Main</a></li> -->
                <!-- <li><a href="<?php echo current_url(); ?>#tabs-2">Meta</a></li> -->
            </ul>
            <form action="testimonial/edit/<?php echo $testimonial['id']; ?>" method="post" name="add_frm" enctype="multipart/form-data" id="add_frm">
                <div class="example-box-wrapper">
                    <div id="tabs-1" class="tab">
                        <div id="myTabContent" class="tab-content">
                            <div class="tab-pane fade active in" id="main" style="padding-top: 20px;">
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Name<span class="error">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="name" value="<?php echo set_value('name', $testimonial['name']); ?>" style="width:50%">
                                    </div>
                                </div>
                                <!-- <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">URI Alias</label>
                                    <div class="col-sm-6">
                                        <input name="url_alias" type="text" class="form-control" id="url_alias" value="<?php echo set_value('url_alias', $testimonial['test_alias']); ?>" size="40">
                                        &nbsp;(Will be auto-generated if left blank)
                                    </div>
                                </div> -->
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Testimonial <span class="error">*</span></label>
                                    <div class="col-sm-6">
                                        <textarea name="testimonial" class="form-control editorWithFile" id="testimonial_editor" cols="37" rows="5" style="width: 99%;">
                                            <?php
                                            echo set_value('testimonial', $testimonial['testimonial']);
                                            ?>
                                        </textarea>
                                    </div>
                                </div>
                                <!-- <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Image</label>
                                    <div class="col-sm-6">
                                        <?php if ($testimonial['image']) {
                                        ?>
                                            <img style="width:120px;" class="img-responsive" src="<?php echo $this->config->item('TEST_IMAGE_URL') . $testimonial['image']; ?>" border="0" /><br />
                                        <?php }
                                        ?>
                                        <input type="file" class="form-control"  name="image">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Alt</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control"  name="alt" value="<?php echo set_value('alt', $testimonial['alt']); ?>" style="width:50%">
                                    </div>
                                </div> -->
                                <div class="form-group clearfix">
                                    <!-- <label class="col-sm-2 control-label">Address <span class="error">*</span></label> -->
                                    <label class="col-sm-2 control-label">Address</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="address" class="form-control" value="<?= set_value('address', $testimonial['address']); ?>">
                                    </div>
                                </div>
                                <!-- <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Show in Homepage</label>
                                    <div class="col-sm-6">
                                        <select name="show_in_homepage" class="form-control">
                                            <option value="1" <?= ($testimonial['show_in_homepage'] == 1) ? 'selected' : ''; ?>> Yes </option>
                                            <option value="0" <?= ($testimonial['show_in_homepage'] == 0) ? 'selected' : ''; ?>> No </option>
                                        </select>
                                    </div>
                                </div> -->
                            </div>
                            <p align="center"><input type="submit" name="button" id="button" value="Update" class="btn btn-lg btn-primary"></p>
                        </div>
                    </div>
                    <!-- <div id="tabs-2" class="tab">
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Browser Title</label>
                            <div class="col-sm-6">
                                <input name="browser_title" type="text" class="form-control" id="browser_title" value="<?php echo set_value('browser_title', $testimonial['browser_title']); ?>" size="40">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Meta Keywords</label>
                            <div class="col-sm-6">
                                <textarea name="meta_keywords" style="width:99%" class="form-control" id="meta_keywords"><?php echo set_value('meta_keywords', $testimonial['meta_keywords']); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Meta Description</label>
                            <div class="col-sm-6">
                                <textarea name="meta_description" style="width:99%" class="form-control" id="meta_description"><?php echo set_value('meta_description', $testimonial['meta_description']); ?></textarea>
                            </div>
                        </div>
                        <p align="center"><input type="submit" name="button" id="button" value="Submit" class="btn btn-lg btn-primary"></p>
                    </div> -->
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    var BASE_URL = DWS_SITE_URL + "./assets/"; // use your own base url
    tinymce.init({
        selector: ".editorWithFile",
        theme: "modern",
        // width: 680,
        height: 200,
        relative_urls: false,
        remove_script_host: false,
        // document_base_url: BASE_URL,
        plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
            "table contextmenu directionality emoticons paste textcolor responsivefilemanager code"
        ],
        toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect | fontsizeselect",
        toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code ",
        fontsize_formats: "8px 9px 10px 11px 12px 13px 14px 15px 16px 17px 18px 19px 20px 21px 22px 23px 24px 25px 26px 27px 28px 29px 30px 31px 32px 33px 34px 35px 36px 37px 38px 39px 40px 41px 42px 43px 44px 45px 46px 47px 48px 49px 50px 51px 52px 53px 54px 55px 56px 57px 58px 59px 60px",
        image_advtab: true,
        external_filemanager_path: BASE_URL + "./filemanager/",
        filemanager_title: "Media Gallery",
        external_plugins: {
            "filemanager": BASE_URL + "./filemanager/plugin.min.js"
        }
    });
</script>