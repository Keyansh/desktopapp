<h3 class="title-hero clearfix">
    Update PDF
    <a href="download" class="pull-right btn btn-primary">Manage PDF</a>
</h3>
<?php $this->load->view('inc-messages'); ?>
<div id="tabs">
    <div class="panel">
        <div class="panel-body">


            <form action="download/edit/<?php echo $download['id']; ?>" method="post" enctype="multipart/form-data" name="add_frm" id="add_frm">
                <div id="tabs-1" class="tab">
                    <div class="example-box-wrapper">
                        <div id="myTabContent" class="tab-content">
                            <div class="tab-pane fade active in" id="main">
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Name <span class="error">*</span></label>
                                    <div class="col-sm-6">
                                        <input name="title" type="text" class="form-control" id="title" value="<?php echo set_value('title', $download['title']); ?>" size="40">
                                    </div>
                                </div>

                                <!-- <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Type <span class="error">*</span></label>
                                    <div class="col-sm-6">
                                        <select name="type" class="form-control" id="attribute_set">
                                            <option value=" "> - select - </option>
                                            <option value="brochures" <?php if ($download['type'] == 'brochures') {
                                                                            echo ('selected');
                                                                        } ?>> Brochures </option>
                                            <option value="price_lists" <?php if ($download['type'] == 'brochures') {
                                                                            echo ('price_lists');
                                                                        } ?>> Price Lists </option>

                                        </select>

                                    </div>
                                </div> -->
                                <!-- <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Image </label>
                                    <div class="col-sm-6">
                                        <?php if ($download['icon']) {  ?>
                                            <img src="<?php echo $this->config->item('DOWNLOAD_IMAGE_URL') . $download['icon']; ?>" border="0" style="width: 40px;" /><br />
                                        <?php }
                                        ?>
                                        <input type="file" name="image" id="image" class="form-control">

                                    </div>
                                </div> -->

                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">PDF <span class="error">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="file" id="filesize" name="pdf_file">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Available for not logged in users ? </label>
                                    <div class="col-sm-6">
                                        <label class="containerradio"> Yes
                                            <input type="radio" <?= $download['display_login'] == 1 ? 'checked' : ''  ?> name="display_login" value="1">
                                            <span class="checkmarkradio"></span>
                                        </label> <span style="padding: 0 12px;">/</span>
                                        <label class="containerradio">No
                                            <input type="radio" name="display_login" value="0" <?= $download['display_login'] == 0 ? 'checked' : ''  ?>>
                                            <span class="checkmarkradio"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <div class="col-sm-12" align="center">
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

<script>
    //binds to onchange event of your input field
    $('#filesize').bind('change', function() {

        //this.files[0].size gets the size of your file.
        var mbdata = this.files[0].size / 1024 / 1024;
        if (mbdata.toFixed(2) > 15) {
            alert("Max allowed size 15mb");
            $('#filesize').val(" ");
        }

    });
</script>