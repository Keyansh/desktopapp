<h3 class="title-hero clearfix">
    Update News
    <a href="news" class="pull-right btn btn-primary">Manage News</a>
</h3>
<div class="panel">
    <div class="panel-body">
        <?php $this->load->view('inc-messages'); ?>
        <form action="news/edit/<?php echo $news['news_id']; ?>" method="post" enctype="multipart/form-data" name="add_frm" id="add_frm">
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
                                <input name="title" type="text" class="form-control" id="title" value="<?php echo set_value('title', $news['news_title']); ?>" size="40">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">URI</label>
                            <div class="col-sm-6">
                                <input name="url_alias" type="text" class="form-control" id="url_alias" value="<?php echo set_value('url_alias', $news['news_alias']); ?>" size="40">
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
                                    <input name="date" type="text" class="bootstrap-datepicker form-control" value="<?php echo set_value('date', $news['news_date']); ?>" data-date-format="yyyy-mm-dd">
                                </div>
                                <!--<input name="date" type="text" class="form-control" id="date" value="<?php // echo set_value('date');
                                                                                                            ?>" size="40">-->
                            </div>
                        </div>
                        <!-- <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">News Image </label>
                            <div class="col-sm-6">
                                <?php if ($news['news_image']) {
                                ?>
                                    <img src="<?php echo $this->config->item('NEWS_THUMBNAIL_URL') . $news['news_image']; ?>" border="0" /><br />
                                <?php
                                } ?>
                                <input type="file" name="image" id="image" class="form-control">
                            </div>
                        </div> -->

                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">News Description</label>
                            <div class="col-sm-10">
                                <textarea name="contents" style="width:99%" class="form-control" id="contents"><?php echo set_value('contents', $news['news_contents']); ?></textarea>
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
                        <div class="product_images">
                            <?php
                            if ($news_img) {
                            ?>
                                <div class="clearfix notesforsortorder">Note :- Press update button for update the images information </div>
                                <ul class='multiple-images list-inline ' id="images-sorting">
                                    <?php
                                    foreach ($news_img as $img) {
                                        $path = $this->config->item('NEWS_IMAGE_PATH') . $img['img'];
                                    ?>
                                        <li id="img_<?php echo $img['id']; ?>">
                                            <div class="img-top">
                                                <img class="brandImageSection" style="width:100px" src="<?php echo $this->config->item('NEWS_IMAGE_URL') . $img['img']; ?>" border="0" />
                                            </div>

                                            <div class="img-bot">
                                                <div class="remove-image" style="cursor:pointer" image-id=<?php echo $img['id']; ?> id="product_image<?php echo $img['id']; ?>" href="escort/remove_image/<?php echo $img['id']; ?>" title="remove">
                                                    <i class="fa fa-trash red" aria-hidden="true">remove</i></div>
                                                <div title="main">
                                                    <i class="fa fa-star" aria-hidden="true">
                                                        <input type="radio" <?= ($img['main'] == 1) ? "checked='checked'" : ''; ?> name="mainimg" value="<?php echo $img['id']; ?>">
                                                    </i>
                                                </div>
                                            </div>
                                        </li>
                                    <?php

                                    }
                                    ?>
                                </ul>
                                <button type="button" id="submitImageInfo">Update Image Info.</button>
                            <?php }
                            ?>

                        </div>
                        <p class="text-center">Upload size around 513*548. Max upload size limit <?= ini_get('upload_max_filesize') ?> </p>
                    </div>
                    <p align="center"><input type="submit" name="button" id="button" value="Update" class="btn btn-lg btn-primary"></p>
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

        $(document).on('click', '.remove-image', function(elm) {
            var cnf = confirm('Do you really want to remove this image?');
            if (!cnf)
                return;
            var img_id = $(this).attr('image-id'),
                url = base_url + 'news/remove';
            $.post(url, {
                img_id: img_id
            }, function(response) {
                $("#images-sorting").load(location.href + " #images-sorting");
            });
        });
        $(document).on('click', '#submitImageInfo', function(elm) {

            var radiobtn = $('input[name=mainimg]:checked', '#images-sorting').val();
            var news_id = <?php echo $news['news_id']; ?>;
            url = base_url + 'news/updateMain';
            $.post(url, {
                radiobtn: radiobtn,
                news_id : news_id
            }, function(response) {
                $("#images-sorting").load(location.href + " #images-sorting");
            });
        });

    });
</script>