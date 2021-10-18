<h3 class="title-hero clearfix">
    Add News
    <a href="news" class="pull-right btn btn-primary">Manage News</a>
</h3>
<div class="panel">
    <div class="panel-body">
        <?php $this->load->view('inc-messages'); ?>
        <form action="news/add" method="post" enctype="multipart/form-data" name="add_frm" id="add_frm">
            <div class="example-box-wrapper">
                <ul id="myTab" class="nav clearfix nav-tabs">
                    <li class="active"><a href="#main" data-toggle="tab">Main</a></li>
                    <li><a href="#tabs-3" data-toggle="tab">Images</a></li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="main">
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Title <span class="error">*</span></label>
                            <div class="col-sm-6">
                                <input name="title" type="text" class="form-control" id="title" value="<?php echo set_value('title'); ?>" size="40">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">URI</label>
                            <div class="col-sm-6">
                                <input name="url_alias" type="text" class="form-control" id="url_alias" value="<?php echo set_value('url_alias'); ?>" size="40">
                                &nbsp;(Will be auto-generated if left blank)
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Date <span class="error">*</span></label>
                            <div class="col-sm-6">
                                <div class="input-prepend input-group">
                                    <span class="add-on input-group-addon">
                                        <i class="glyph-icon icon-calendar"></i>
                                    </span>
                                    <input name="date" type="text" class="bootstrap-datepicker form-control" value="<?php echo set_value('date'); ?>" data-date-format="yyyy-mm-dd">
                                </div>
                                <!--<input name="date" type="text" class="form-control" id="date" value="<?php // echo set_value('date'); 
                                                                                                            ?>" size="40">-->
                            </div>
                        </div>
                        <!-- <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">News Image </label>
                            <div class="col-sm-6">
                                <input type="file" name="image" id="image" class="form-control">
                            </div>
                        </div> -->

                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">News Description</label>
                            <div class="col-sm-10">
                                <textarea name="contents" style="width:99%" class="form-control" id="contents"><?php echo set_value('contents'); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-10">
                                <input name="image_v" type="hidden" id="image_v" value="1">
                                Fields marked with <span class="error">*</span> are required.
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tabs-3">
                        <div id="my-dropzone" class="dropzone dz-clickable ">
                            <div class="dz-default dz-message">
                                <span>Drop files here to upload</span>
                            </div>
                        </div>
                        <p class="text-center">Upload size around 513*548. Max upload size limit <?= ini_get('upload_max_filesize') ?> </p>
                    </div>
                    <p align="center"><input type="submit" name="button" id="button" value="Submit" class="btn btn-lg btn-primary"></p>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="<?= base_url() ?>assets/widgets/dropzone/dropzone.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(function() {
            "use strict";
            $('.bootstrap-datepicker').bsdatepicker({
                format: 'dd-mm-yyyy'
            });
        });
        Dropzone.autoDiscover = false;
        $("#my-dropzone").dropzone({
            addRemoveLinks: true,
            init: function() {
                // Hack: Add the dropzone class to the element
                $(this.element).addClass("dropzone");
                this.on("removedfile", function(file) {
                    if (file) {
                        $.ajax({
                            url: "news/deleteimg",
                            type: "POST",
                            data: {
                                "fileList": file.name
                            }
                        });
                    }
                });
                this.on("addedfile", function(file) {
                    alt = file.alt == undefined ? "" : file.alt;
                    file._captionLabel = Dropzone.createElement("<input type='hidden' name='image[]' value='" + file.name + "' >")
                    file._captionBox = Dropzone.createElement("<input type='hidden' class='productmain'  name='main[]' value='0' >");
                    file._captionRadio = Dropzone.createElement("<input type='radio' class='productradio' name='favradio'>");
                    file.previewElement.appendChild(file._captionLabel);
                    file.previewElement.appendChild(file._captionBox);
                    file.previewElement.appendChild(file._captionRadio);
                });
                this.on("sending", function(file, xhr, formData) {
                    formData.append('alt_text', file._captionBox.value);
                });
            },
            url: "<?php echo base_url(); ?>news/upload"
        });
        $(document).on('click', '.productradio', function() {
            $('.productmain').val('0');
            $(this).prev('.productmain').val('1');
        });
    });
</script>