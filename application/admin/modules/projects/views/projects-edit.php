<script src="<?= base_url() ?>assets/ckeditor/ckeditor.js"></script>
<script src="<?= base_url() ?>assets/ckfinder/ckfinder.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js"></script>
<style>
    .main-div #procat li,
    #subcat li {
        width: 100%;
        margin-bottom: 15px;
        list-style: none;
    }

    .main-div #procat li label,
    #subcat li label {
        width: 100%;
    }

    #mayalsolike {
        max-width: 80%;
    }

    .main-div .block-element {
        font-size: 18px;
        font-weight: bold;
        text-align: left;
        color: #263388;
    }

    .left-div .btn.dropdown-toggle.btn-default {
        height: 45px;
    }

    .middle-div .list-inline,
    #procat .list-inline {
        border: 1px solid lightgray;
        padding: 0 10px;
    }

    .sub-a-cat {
        display: inline-block;
        margin: auto;
        border: 1px solid lightgray;
        padding: 0px 20px 0 20px;
        background: #495d80;
        color: white;
        text-transform: capitalize;
    }

    .submit-sub-cat {
        text-align: center;
    }

    .sub-a-cat:hover {
        color: white;
    }

    .selected-pro-ul {
        padding: 10px 20px;
        margin: 0;
        border: 1px solid lightgray;
    }

    .selected-pro-ul li .removeproduct {
        display: inline-block;
        margin-left: 25px;
        color: red;
        cursor: pointer;
    }

    .selected-pro-ul li {
        list-style: none;
    }

    .right-div .col-sm-2.control-label.block-element,
    .middle-div .col-sm-2.control-label.block-element,
    .left-div .col-sm-2.control-label.block-element {
        width: 100%;
    }

    .main-div {
        margin-bottom: 100px;
    }
</style>
<h3 class="title-hero clearfix">
    Update project
    <a href="projects" class="pull-right btn btn-primary">Manage Projects</a>
</h3>
<div class="panel">
    <div class="panel-body">
        <?php $this->load->view('inc-messages'); ?>
        <form action="projects/edit/<?php echo $projects['projects_id']; ?>" method="post" enctype="multipart/form-data" name="add_frm" id="add_frm">
            <div class="example-box-wrapper">
                <ul id="myTab" class="nav clearfix nav-tabs">
                    <li class="active"><a href="#main" data-toggle="tab">Main</a></li>
                    <li><a href="#tabs-3" data-toggle="tab">Images</a></li>
                    <li class="tabs-6"><a href="#tabs-4" data-toggle="tab">Product used</a></li>
                    <li><a href="#tabs-5" data-toggle="tab">Video</a></li>
                    <li><a href="#tabs-7" data-toggle="tab">Fields</a></li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="main">
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Title <span class="error">*</span></label>
                            <div class="col-sm-6">
                                <input name="title" type="text" class="form-control" id="title" value="<?php echo set_value('title', $projects['projects_title']); ?>" size="40">
                            </div>
                        </div>
                        <!-- <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Architect <span class="error">*</span></label>
                            <div class="col-sm-6">
                                <input name="architect" type="text" class="form-control" id="architect" value="<?php echo set_value('architect', $projects['architect']); ?>" size="40">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Contractor <span class="error">*</span></label>
                            <div class="col-sm-6">
                                <input name="contractor" type="text" class="form-control" id="contractor" value="<?php echo set_value('contractor', $projects['contractor']); ?>" size="40">
                            </div>
                        </div> -->
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">URI</label>
                            <div class="col-sm-6">
                                <input name="url_alias" type="text" class="form-control" id="url_alias" value="<?php echo set_value('url_alias', $projects['projects_alias']); ?>" size="40">
                                &nbsp;(Will be auto-generated if left blank)
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Project Type</label>
                            <div class="col-sm-6">
                                <select name="project_cat" id="" class="form-control">
                                    <option value="">--select--</option>
                                    <?php foreach ($projecttype as $item) { ?>
                                        <option <?php echo  $item['id'] == $projects['project_cat'] ? 'selected' : ' '  ?> value="<?= $item['id'] ?>"><?= $item['name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <?php $this->load->view("cropimage"); ?>

                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Short Description</label>
                            <div class="col-sm-10">
                                <textarea cols="80" class="ckeditor" name="short_contents" rows="10">
                                <?php echo set_value('short_contents', $projects['short_contents']); ?>
                            </textarea>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Full Description</label>
                            <div class="col-sm-10">
                                <textarea cols="80" class="ckeditor" name="contents" rows="10">
                                <?php echo set_value('contents', $projects['projects_contents']); ?>
                            </textarea>
                            </div>
                        </div>
                        <div class="col-xs-12 is-active">
                            <div class="form-group clearfix col-xs-12">
                                <label class="col-sm-2 control-label block-element">New</label>
                                <div class="col-sm-6 ">
                                    <input type="radio" name="homepage_active" value="1" <?php echo set_radio('homepage_active', 1, ($projects['homepage_active'] == 1)); ?> /> Yes&nbsp;&nbsp;
                                    <input type="radio" name="homepage_active" value="0" <?php echo set_radio('homepage_active', 0, ($projects['homepage_active'] == 0)); ?> /> No
                                </div>
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
                            if ($projects_img) {
                            ?>
                                <div class="clearfix notesforsortorder">Note :- Press update button for update the images information </div>
                                <ul class='multiple-images list-inline ' id="images-sorting">
                                    <?php
                                    foreach ($projects_img as $img) {
                                        $path = $this->config->item('PROJECTS_IMAGE_PATH') . $img['img'];
                                    ?>
                                        <li id="img_<?php echo $img['id']; ?>">
                                            <div class="img-top">
                                                <img class="brandImageSection" style="width:100px" src="<?php echo $this->config->item('PROJECTS_IMAGE_URL') . $img['img']; ?>" border="0" />
                                            </div>

                                            <div class="img-bot">
                                                <div class="remove-image" style="cursor:pointer" image-id=<?php echo $img['id']; ?> id="product_image<?php echo $img['id']; ?>" href="escort/remove_image/<?php echo $img['id']; ?>" title="remove">
                                                    <i class="fa fa-trash red" aria-hidden="true">remove</i>
                                                </div>
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
                    <div class="tab-pane fade" id="tabs-4">
                        <div class="col-xs-12 main-div">
                            <div class="col-xs-12 is-active">
                                <div class="form-group clearfix col-xs-12">
                                    <label class="col-sm-2 control-label block-element">Want to active</label>
                                    <div class="col-sm-6 ">
                                        <input type="radio" name="is_like_active" value="1" <?php echo set_radio('is_like_active', 1, ($projects['is_like_active'] == 1)); ?> /> Yes&nbsp;&nbsp;
                                        <input type="radio" name="is_like_active" value="0" <?php echo set_radio('is_like_active', 0, ($projects['is_like_active'] == 0)); ?> /> No
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 div-ul-sel">
                                <?php if ($sectedprod) { ?>
                                    <ul class="selected-pro-ul">
                                        <li class="selected-pro block-element">Selected Products</li>
                                        <?php foreach ($sectedprod as $item) { ?>
                                            <li>
                                                <span>Name : <?= $item['name']; ?> (<?= $item['sku']; ?>)</span> <i class="fa fa-trash removeproduct" data-dbcol="certification"></i>
                                                <input type="hidden" value="<?= $item['id']; ?>" name="productadd[]">
                                            </li>
                                        <?php } ?>
                                    </ul>
                                <?php } ?>
                            </div>

                            <div class="col-xs-4 left-div">



                                <label class="col-sm-2 control-label block-element">Select Category </label>
                                <select name="maya" id="mayalsolike" class="form-control col-xs-12 selectpicker" data-live-search="true" data-live-search-style="startsWith">
                                    <option value="">--select--</option>
                                    <?php foreach ($parentcat  as $item) { ?>
                                        <option value="<?= $item['id'] ?>"><?= $item['name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-xs-4 middle-div">
                                <div id="subcat"></div>
                            </div>
                            <div class="col-xs-4 right-div">
                                <div id="procat"></div>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="tabs-5">
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Video Thumb</label>
                            <div class="col-sm-6">
                                <div class="col-xs-12 input-trash-con"><?php if ($projects['video_thumb']) { ?><img src="<?= $this->config->item('PROJECTS_IMAGE_URL') . $projects['video_thumb'] ?>" style="width:200px"> <?php } ?><?php if ($projects['video_thumb']) { ?><i class="fa fa-trash" data-dbcol="video_thumb"></i><?php } ?></div>
                                <div class="col-sm-6 block-element"><input name="video_thumb" type="file" class="form-control" value="<?php echo set_value('video_thumb', $projects['video_thumb']); ?>" size="40"></div>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Video Link</label>
                            <div class="col-sm-6">
                                <input name="video_link" type="text" class="form-control" id="video_link" value="<?php echo set_value('video_link', $projects['video_link']); ?>" size="40">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tabs-7">
                        <div class="col-xs-12 pluse-icon"><i class="fa fa-plus-square" style="font-size:30px;cursor:pointer;padding-left: 30px;" aria-hidden="true"></i></div>
                        <div class="col-xs-12 fields-main-div">
                            <?php foreach ($projectDynamicFields as $item) { ?>
                                <div class="form-group clearfix">
                                    <div class="col-lg-5">
                                        <input name="fieldname[]" class="form-control" placeholder="Name" value="<?= $item['fieldname'] ?>" required />
                                    </div>
                                    <div class="col-lg-5">
                                        <input name="fieldvalue[]" class="form-control" placeholder="Value" value="<?= $item['fieldvalue'] ?>" required />
                                    </div>
                                    <div class="col-lg-2">
                                        <i class="fa fa-window-close fa-4 fielddel" style="font-size:30px;cursor:pointer" aria-hidden="true"></i>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
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
                            url: "projects/deleteimg",
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
            url: "<?php echo base_url(); ?>projects/upload"
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
                url = base_url + 'projects/remove';
            $.post(url, {
                img_id: img_id
            }, function(response) {
                $("#images-sorting").load(location.href + " #images-sorting");
            });
        });
        $(document).on('click', '#submitImageInfo', function(elm) {

            var radiobtn = $('input[name=mainimg]:checked', '#images-sorting').val();
            var projects_id = <?php echo $projects['projects_id']; ?>;
            url = base_url + 'projects/updateMain';
            $.post(url, {
                radiobtn: radiobtn,
                projects_id: projects_id
            }, function(response) {
                $("#images-sorting").load(location.href + " #images-sorting");
            });
        });

    });
</script>
<script>
    var editor = CKEDITOR.replace('ckeditor');
    CKFinder.setupCKEditor(editor);
</script>
<script>
    setTimeout(function() {
        $('.message_div').hide();
    }, 2000);
    $(document).on('click', '.removeproduct', function(e) {
        $(this).parent('li').remove();
    });
    $(document).on('change', '#mayalsolike', function() {
        var selcted_option = $(this).val();
        $.post('catalognew/product/getchildcat', {
            'selcted_option': selcted_option
        }, function(data) {
            var decode = jQuery.parseJSON(data);

            if (decode['subcat']) {
                $('#procat').html('');
                $('.middle-div').addClass('col-xs-4');
                $('#subcat').html(decode['subcat']);
            }
            if (decode['products']) {
                $('#subcat').html('');
                $('.middle-div').removeClass('col-xs-4');
                $('#procat').html(decode['products']);
            }
            if (decode['noproduct']) {
                $('#procat').html('');
                $('#subcat').html(decode['noproduct']);
            }
            console.log("true");
        });
    });
    $(document).on('click', '.submit-sub-cat .sub-a-cat', function(e) {
        e.preventDefault();
        var subcatlist = [];
        $("#subcat input:checked").each(function() {
            subcatlist.push($(this).val());
        });
        $.ajax({
            url: "catalognew/product/catGetProducts",
            type: 'POST',
            data: {
                subcat_id: subcatlist,
            },
            success: function(data) {
                var decode = jQuery.parseJSON(data);

                if (decode['products']) {
                    $('#procat').html(decode['products']);
                }
            }
        });
    });

    $(document).on('click', '.input-trash-con .fa', function() {

        var $t = $(this);
        var dataval = $(this).attr("data-dbcol");
        var projects_id = <?php echo $projects['projects_id']; ?>;

        if (confirm('Are you sure to remove ?')) {

            $.ajax({
                url: "projects/deleteVideoThumb",
                method: "POST",
                data: {
                    dataval: dataval,
                    projects_id: projects_id
                },
                success: function(result) {
                    alert("file removed");
                    $t.parent().find('strong').text('');
                    $t.parent().find('img').remove();
                    $t.remove();
                }
            });

        }

    });
</script>
<script>
    $(document).ready(function() {
        $('.fa-plus-square').click(function(e) {
            var html = '';
            html += '<div class="form-group clearfix">';
            html += '<div class="col-lg-5">';
            html += '<input name="fieldname[]" class="form-control" placeholder="Name" required/>';
            html += '</div>';
            html += '<div class="col-lg-5">';
            html += '<input name="fieldvalue[]" class="form-control" placeholder="Value" required/>';
            html += '</div>';
            html += '<div class="col-lg-2">';
            html += '<i class="fa fa-window-close fa-4 fielddel" style="font-size:30px;cursor:pointer" aria-hidden="true"></i>';
            html += '</div>';
            html += '</div>';
            $('.fields-main-div').append(html);
        });
        $(document).on('click', '.fa-window-close.fielddel', function(e) {
            $(this).parent().parent().remove();
        });
    });
</script>