<h3 class="title-hero clearfix">
    Edit - "<?= $page_details['title']; ?>"
    <div class="pull-right">
        <a href="cms/page" class="btn btn-info" style="background: #094e91;">
            Manage Pages
        </a>
        <a href="cms/block/index/<?php echo $page_details['page_id']; ?>" class="btn btn-info" style="background: #094e91;">
            Manage Blocks
        </a>
        <?php if ($page_details['language_code'] == 'en') { ?>
            <a href="cms/page/duplicate/<?php echo $page_details['page_id']; ?>" class="btn btn-info" style="background: #094e91;">
                Duplicate Page
            </a>
        <?php } ?>
    </div>
</h3>
<div class="panel">
    <div class="panel-body">
        <div class="example-box-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <?php $this->load->view('inc-messages'); ?>
                    <div style="float: left; width: 100%">
                        <div id="tabs">
                            <ul class="nav" id="tabs-nav">
                                <li><a href="<?php echo current_url(); ?>#tabs-1">Main</a></li>
                                <li><a href="<?php echo current_url(); ?>#tabs-2">Metadata</a></li>
                                <!-- <li><a href="<?php echo current_url(); ?>#tabs-3">brands</a></li> -->
                                <?php foreach ($modules as $module) { ?>
                                    <li><a href="<?php echo current_url(); ?>#tabs-<?php echo url_title(strtolower($this->$module->getName())); ?>"><?php echo $this->$module->getName(); ?></a></li>
                                <?php } ?>
                            </ul>
                            <form action="cms/page/edit/<?php echo $page_details['page_id']; ?>/<?php echo $target; ?>" method="post" enctype="multipart/form-data" name="regFrm" id="regFrm">
                                <div id="tabs-1" class="tab">
                                    <div class="form-group clearfix">
                                        <label class="col-sm-2 control-label">Page Title <span class="error">*</span></label>
                                        <div class="col-sm-7">
                                            <input type="text" name="title" id="title" class="form-control" value="<?php echo set_value('title', $page_details['title']); ?>" size="40">
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label class="col-sm-2 control-label">Page Template <span class="error">*</span></label>
                                        <div class="col-sm-7">
                                            <?php echo form_dropdown('page_template_id', $page_template, set_value('page_template_id', $page_details['page_template_id']), ' class="form-control"'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label class="col-sm-2 control-label">Parent Page</label>
                                        <div class="col-sm-7">
                                            <?php echo form_dropdown('parent_id', $parent, set_value('parent_id', $page_details['parent_id']), ' class="form-control"'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label class="col-sm-2 control-label">Page Banner</label>
                                        <div class="col-sm-7">
                                            <?php if ($page_details['page_banner']) { ?>
                                                <img src="<?php echo $this->config->item('PAGE_BANNER_URL') . $page_details['page_banner']; ?>" style="width: 150px;" /><br />
                                            <?php } ?>
                                            <input name="page_banner" type="file" id="page_banner" size="35" class="form-control" />
                                            <small>Only .jgp,.gif,.png images allowed & Please upload size around 659 * 471</small>
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label class="col-sm-2 control-label">Alt</label>
                                        <div class="col-sm-7">
                                            <input type="text" name="alt" class="form-control" value="<?php echo set_value('alt', $page_details['alt']); ?>" size="40">
                                        </div>
                                    </div>
                                    <!-- <div class="form-group clearfix">
                                        <label class="col-sm-2 control-label">Page Type</label>
                                        <div class="col-sm-7">
                                            <select name="page_type" id="" class="form-control">
                                                <option value="">--select--</option>
                                                <option <?php echo $page_details['page_type'] == 'normal_page' ? 'selected' : '' ?> value="normal_page">Normal Page</option>
                                                <option <?php echo $page_details['page_type'] == 'system_page' ? 'selected' : '' ?> value="system_page">System Page</option>
                                            </select>
                                        </div>
                                    </div> -->
                                    <div class="form-group clearfix">
                                        <label class="col-sm-2 control-label">Contents</label>
                                        <div class="col-sm-12" style="display: table;">
                                            <textarea name="contents" cols="37" rows="5" style="width:99%" class="form-control editorWithFile" id="contents"><?php echo set_value('contents', $page_details['block_contents']); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label class="col-sm-2 control-label">Banner Heading</label>
                                        <div class="col-sm-12" style="display: table;">
                                            <textarea name="banner_heading" cols="37" rows="5" style="width:99%" class="form-control editorWithFile" id="banner_heading"><?php echo set_value('banner_heading', $page_details['banner_heading']); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div id="tabs-2" class="tab">
                                    <div class="form-group clearfix">
                                        <label class="col-sm-2 control-label">Page URI</label>
                                        <div class="col-sm-7">
                                            <?php if ($page_details['language_code'] != 'en') { ?>
                                                <input type="hidden" name="page_uri" id="page_uri" value="<?php echo $page_details['page_uri']; ?>">
                                                <?php echo $page_details['page_uri']; ?>
                                            <?php } else { ?>
                                                <input name="page_uri" type="text" class="form-control" id="page_uri" value="<?php echo set_value('page_uri', $page_details['page_uri']); ?>" size="40">
                                                &nbsp;(Will be auto-generated if left blank)
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label class="col-sm-2 control-label">Browser Title</label>
                                        <div class="col-sm-7">
                                            <input name="browser_title" type="text" class="form-control" id="browser_title" value="<?php echo set_value('browser_title', $page_details['browser_title']); ?>" size="40">
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label class="col-sm-2 control-label">Meta Keywords</label>
                                        <div class="col-sm-7">
                                            <textarea name="meta_keywords" cols="40" rows="4" class="form-control" style="width:99%" id="meta_keywords"><?php echo set_value('meta_keywords', $page_details['meta_keywords']); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label class="col-sm-2 control-label">Meta Description</label>
                                        <div class="col-sm-7">
                                            <textarea name="meta_description" cols="40" rows="4" class="form-control" id="meta_description" style="width:99%"><?php echo set_value('meta_description', $page_details['meta_description']); ?></textarea>
                                        </div>
                                    </div>
                                    <!-- <div class="form-group clearfix">
                                        <label class="col-sm-2 control-label">Additional Header Contents</label>
                                        <div class="col-sm-7">
                                            <textarea name="before_head_close" cols="40" rows="4" class="form-control" id="before_head_close" style="width:99%"><?php echo set_value('before_head_close', $page_details['before_head_close']); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label class="col-sm-2 control-label">Additional Footer Contents</label>
                                        <div class="col-sm-7">
                                            <textarea name="before_body_close" cols="40" rows="4" style="width:99%" class="form-control" id="before_body_close"><?php echo set_value('before_body_close', $page_details['before_body_close']); ?></textarea>
                                        </div>
                                    </div> -->
                                </div>
                                <!-- <div id="tabs-3" class="tab">
                                    <div class="form-group clearfix">
                                        <label class="col-sm-2 control-label">Brands</label>
                                        <div class="col-sm-7">
                                            <?php echo form_dropdown('brand_id', $brands, set_value('id', $page_details['brand_id']), ' class="form-control"'); ?>
                                        </div>
                                    </div>
                                </div> -->
                                <?php foreach ($modules as $module) { ?>
                                    <div id="tabs-<?php echo url_title(strtolower($this->$module->getName())); ?>" class="tab">
                                        <?php echo $this->$module->editView(); ?>
                                    </div>
                                <?php } ?>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label"></label>
                                    <div class="col-sm-12 text-center">
                                        <input type="hidden" name="page_id" id="page_id" value="<?php echo $page_details['page_id']; ?>">
                                        <input type="hidden" name="language_code" id="language_code" value="<?php echo $page_details['language_code']; ?>">
                                        <input name="v_image" type="hidden" id="v_image" value="1" />
                                        <input type="hidden" name="menu_title" id="menu_title" value="<?php echo $page_details['menu_title']; ?>">
                                        <input type="hidden" name="show_in_menu" id="show_in_menu" value="<?php echo $page_details['show_in_menu']; ?>">
                                        <input type="submit" name="button" id="button" class="btn btn-primary" value="Save">&nbsp;<input type="submit" name="button" class="btn btn-primary" id="button" value="Save and close">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
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