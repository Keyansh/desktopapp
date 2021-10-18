<h3 class="title-hero clearfix">
    Update Gallery
    <a href="gallery" class="pull-right btn btn-primary">Manage Gallery</a>
</h3>
<?php $this->load->view('inc-messages'); ?>
<div id="tabs">
    <div class="panel">
        <div class="panel-body">
        
         
            <form action="gallery/edit/<?php echo $gallery['id']; ?>" method="post" enctype="multipart/form-data" name="add_frm" id="add_frm">
                <div id="tabs-1" class="tab">
                    <div class="example-box-wrapper">
                        <div id="myTabContent" class="tab-content">
                            <div class="tab-pane fade active in" id="main">
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Project Name  <span class="error">*</span></label>
                                    <div class="col-sm-6">
                                        <input name="project_name" type="text" class="form-control" id="project_name" value="<?php echo set_value('project_name', $gallery['project_name']); ?>" size="40">
                                    </div>
                                </div>
                                
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Location</label>
                                    <div class="col-sm-6">
                                        <input name="location" type="text" class="form-control" value="<?php echo set_value('location', $gallery['location']); ?>" size="40">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Image </label>
                                    <div class="col-sm-6">
                                        <?php if ($gallery['image']) {
                                            ?>
                                            <img src="<?php echo $this->config->item('GALLERY_IMAGE_URL') . $gallery['image']; ?>" border="0" style="width: 300px;"/><br />
                                        <?php }
                                        ?>
                                        <input type="file" name="image" id="image" class="form-control">
                                        <small>Please upload size around 950 * 441</small>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Alt</label>
                                    <div class="col-sm-6">
                                        <input name="alt" type="text" class="form-control" value="<?php echo set_value('alt', $gallery['alt']); ?>" size="40">
                                    </div>
                                </div> 
                                <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Show in Homepage</label>
                            <div class="col-sm-6">
                                <select name="show_in_homepage" class="form-control">
                                    <option value="1" <?= ($gallery['show_in_homepage'] == 1) ? 'selected' : ''; ?>> Yes </option>
                                    <option value="0" <?= ($gallery['show_in_homepage'] == 0) ? 'selected' : ''; ?>> No </option>
                                </select>
                            </div>
                        </div>
                                
                                <div class="form-group clearfix">
                                    <!-- <label class="col-sm-2 control-label"></label> -->
                                    <div class="col-sm-12" align="center">
                                        <input name="image_v" type="hidden" id="image_v" value="1">
                                        Fields marked with <span class="error">*</span> are required.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               
                <p align="center"><input type="submit" name="button" id="button" value="Update" class="btn btn-lg btn-primary"></p>
            </form>
        </div>
    </div>
</div>

