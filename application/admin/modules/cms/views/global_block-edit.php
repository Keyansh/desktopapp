<h3 class="title-hero clearfix">
    Edit Global Blocks 
    <div class="pull-right">
        <a href="cms/globalblock" class="btn btn-info" style="background: #094e91;color:black;">
            Manage Global Block
        </a>
    </div>
</h3>
<div class="panel">
    <div class="panel-body">
        <div class="example-box-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <?php $this->load->view('inc-messages'); ?>
                    <div id="tabs">
                        <ul class="nav" id="tabs-nav">
                            <li><a href="<?php echo current_url(); ?>#tabs-1">Main</a></li>
                            <li><a href="<?php echo current_url(); ?>#tabs-2">Template</a></li>
                        </ul>
                        <form action="cms/globalblock/edit/<?php echo $global_block['block_id']; ?>" method="post" enctype="multipart/form-data" name="add_frm" id="add_frm">
                            <div id="tabs-1" class="tab">
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Block Title <span class="error">*</span></label>
                                    <div class="col-sm-7">
                                        <input type="text" name="block_title" id="block_title" class="textfield" size="40" value="<?php echo set_value('block_title', $global_block['block_title']); ?>" />
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Block Alias <span class="error">*</span></label>
                                    <div class="col-sm-7">
                                        <input type="text" name="block_alias" id="block_alias" class="textfield" size="40" value="<?php echo set_value('block_alias', $global_block['block_alias']); ?>" />
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Block Link</label>
                                    <div class="col-sm-7">
                                        <input type="text" name="block_link" id="block_link" class="form-control" size="40" value="<?php echo set_value('block_link', $global_block['link']); ?>" />
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Block Image</label>
                                    <div class="col-sm-7">
                                        <?php if ($global_block['block_image']) { ?>
                                            <img src="<?php echo $this->config->item('BLOCK_IMAGE_URL') . $global_block['block_image']; ?>" border="0" width="100px" /><br />
                                        <?php } ?>
                                        <input name="image" type="file" id="image" size="30" class="form-control">  <br />
                                        <small>Only .jgp,.gif,.png images allowed</small> 
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Alt</label>
                                    <div class="col-sm-7">
                                        <input type="text" name="block_image_alt" id="block_image_alt" class="form-control" size="40 "value="<?php echo set_value('block_image_alt', $global_block['alt']); ?>">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Block Content</label>
                                    <div class="col-sm-12" style="display: table;">
                                        <textarea name="block_contents" class="textfield" id="block_contents" cols="45" rows="5"><?php echo set_value('block_contents', $global_block['block_contents']); ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div id="tabs-2" class="tab">
                                <div class="form-group clearfix">Please use replacer given: image src => {IMGSOURCE}, image alt => {IMGALT}, title => {TITLE}, content => {CONTENT}, link => {LINK} </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Block Template</label>
                                    <div class="col-sm-7">
                                        <textarea name="block_template" cols="0" rows="25" style="width:99%" class="textfield" id="block_template"><?php echo set_value('block_template', $global_block['block_template']); ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-sm-2 control-label"></label>
                                <div class="col-sm-12 text-center">
                                    Fields marked with <span class="error">*</span> are required. <br />
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