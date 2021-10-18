<h3 class="title-hero clearfix">
    Edit Block - <?php echo $block['block_title']; ?>
    <div class="pull-right">
        <a href="cms/page" class="btn btn-info" style="background: #094e91;">
            Manage Pages
        </a>
        <a href="cms/page/edit/<?php echo $pages['page_id']; ?>" class="btn btn-info" style="background: #094e91;">
            Edit Page
        </a>
        <a href="cms/block/index/<?php echo $pages['page_id']; ?>" class="btn btn-info" style="background: #094e91;">
            Manage Blocks
        </a>
        <a href="cms/block/add/<?php echo $pages['page_id']; ?>" class="btn btn-info" style="background: #094e91;">
            Add Block
        </a>
        <?php if ($pages['language_code'] == 'en') {?>
            <a href="cms/page/duplicate/<?php echo $pages['page_id']; ?>" class="btn btn-info" style="background: #094e91;">
                Duplicate Page
            </a>
        <?php }?>
    </div>
</h3>
<div class="panel">
    <div class="panel-body">
        <div class="example-box-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <?php $this->load->view('inc-messages');?>
                    <div id="tabs">
                        <ul class="nav" id="tabs-nav">
                            <li><a href="<?php echo current_url(); ?>#tabs-1">Main</a></li>
                            <li><a href="<?php echo current_url(); ?>#tabs-2">Block Image</a></li>
                        </ul>
                        <form action="cms/block/edit/<?php echo $block['page_block_id']; ?>" method="post" enctype="multipart/form-data" name="add_frm" id="add_frm">
                            <div id="tabs-1" class="tab">
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Block Title <span class="error">*</span></label>
                                    <div class="col-sm-7">
                                        <input type="text" name="block_title" id="block_title" class="form-control" size="40" value="<?php echo set_value('block_title', $block['block_title']); ?>" />
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Block Link</label>
                                    <div class="col-sm-7">
                                        <input type="text" name="block_link" id="block_link" class="form-control" size="40" value="<?php echo set_value('block_link', $block['block_link']); ?>" />
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Block Type</label>
                                    <div class="col-sm-7">
                                        <select name="block_type_id" class="form-control">
                                            <option>-select-</option>
                                            <?php foreach ($block_type as $key => $block_type) {?>
                                                <option value="<?=$key?>" <?=($block['block_type_id'] == $key) ? "selected=\"selected\"" : ""?>><?=$block_type?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Template <span class="error">*</span></label>
                                    <div class="col-sm-7">
                                        <?php echo form_dropdown('block_template_id', $block_template, set_value('block_template_id', $block['block_template_id']), ' class="form-control"'); ?>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Block Content</label>
                                    <div class="col-sm-12" style="display: table;">
                                        <textarea name="block_contents" class="form-control" id="block_contents" style="width:99%" cols="45" rows="5"><?php echo set_value('block_contents', $block['block_contents']); ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div id="tabs-2" class="tab">
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Block Image</label>
                                    <div class="col-sm-7">
                                        <?php if ($block['block_image']) {?>
                                            <img src="<?php echo $this->config->item('BLOCK_IMAGE_URL') . $block['block_image']; ?>" border="0" width="100px" /> &nbsp; <a onclick="return confirm('Are you sure to delete this ?')" href="cms/block/remove_image/<?php echo $block['page_block_id']; ?>">Remove Image</a><br />
                                        <?php }?>
                                        <input name="image" type="file" id="image" size="30" class="form-control">  <br />
                                        <small>Only .jgp,.gif,.png images allowed</small>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Alt</label>
                                    <div class="col-sm-7">
                                        <input type="text" name="block_image_alt" id="block_image_alt" class="form-control" size="40 "value="<?php echo set_value('block_image_alt', $block['block_image_alt']); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <div class="col-sm-12 text-center">
                                    Fields marked with <span class="error">*</span> are required. <br />
                                    <input name="v_image" type="hidden" id="v_image" value="1" />
                                    <input type="hidden" name="block_id" id="block_id" value="<?php echo $block['page_block_id']; ?>">

                                    <input type="submit" name="button" class="btn btn-primary" id="button" value="Submit">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>