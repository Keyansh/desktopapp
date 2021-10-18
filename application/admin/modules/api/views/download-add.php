<style>
    .label {
        cursor: pointer;
    }

    .progress {
        display: none;
        margin-bottom: 1rem;
    }

    .alert {
        display: none;
    }

    .img-container img {
        max-width: 100%;
    }
</style>
<h3 class="title-hero clearfix">
    Add PDF
    <a href="download" class="pull-right btn btn-primary">Manage PDF</a>
</h3>
<?php $this->load->view('inc-messages'); ?>
<div id="tabs">
    <div class="panel">
        <div class="panel-body">

            <form action="download/add" method="post" enctype="multipart/form-data" name="add_frm" id="add_frm">
                <div id="tabs-1" class="tab">

                    <div class="example-box-wrapper">
                        <div id="myTabContent" class="tab-content">
                            <div class="tab-pane fade active in" id="main">
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Name <span class="error">*</span></label>
                                    <div class="col-sm-6">
                                        <input name="title" type="text" class="form-control" id="title" value="<?php echo set_value('title'); ?>" size="40">
                                    </div>
                                </div>

                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Type <span class="error">*</span></label>
                                    <div class="col-sm-6">
                                        <select name="type" class="form-control" id="attribute_set">
                                            <option value=" "> - select - </option>
                                            <option value="brochures"> Brochures </option>
                                            <option value="price_lists"> Price Lists </option>

                                        </select>

                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">Icon </label>
                                    <div class="col-sm-6">
                                        <input type="file" name="image" id="image" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-2 control-label">PDF <span class="error">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="file" id="filesize" name="pdf_file" required>
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

                <p align="center"><input type="submit" name="button" id="button" value="Submit" class="btn btn-lg btn-primary"></p>
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
<link rel="stylesheet" href="<?= base_url() ?>css/cropper.css">
<script src="<?= base_url() ?>js/cropper.js"></script>


<div class="container">
    <label class="label" data-toggle="tooltip" title="Change your avatar">
        <img class="rounded" id="avatar" src="https://avatars0.githubusercontent.com/u/3456749?s=160" alt="avatar">
        <input type="file" class="sr-only" id="inputnk" name="image" accept="image/*">
    </label>

    <div class="alert" role="alert"></div>

    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <img id="imagenk" src="https://avatars0.githubusercontent.com/u/3456749">
                    </div>

                    <div class="btn-group">
                        <button type="button" class="btn btn-primary" data-method="rotate" data-option="-45" title="Rotate Left" onclick="cropper.rotate(-45)">
                            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.rotate(-45)">
                                <span class="fa fa-rotate-left"></span>
                            </span>
                        </button>
                        <button type="button" class="btn btn-primary" data-method="rotate" data-option="45" title="Rotate Right" onclick="cropper.rotate(45)">
                            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.rotate(45)">
                                <span class="fa  fa-rotate-right"></span>
                            </span>
                        </button>


                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="crop">Crop</button>
                </div>
            </div>

        </div>
    </div>


</div>
<script>
    var cropper;
    window.addEventListener('DOMContentLoaded', function() {
        var avatar = document.getElementById('avatar');
        var image = document.getElementById('imagenk');
        var input = document.getElementById('inputnk');
        var $modal = $('#myModal');
        var cropperOptions = {
            aspectRatio: 1,
            viewMode: 0,
        };

        input.addEventListener('change', function(e) {
            var files = e.target.files;
            var done = function(url) {
                input.value = '';
                image.src = url;
                $modal.modal('show');
            };
            var reader;
            var file;
            var url;


            if (files && files.length > 0) {
                file = files[0];

                if (URL) {
                    done(URL.createObjectURL(file));
                } else if (FileReader) {
                    reader = new FileReader();
                    reader.onload = function(e) {
                        done(reader.result);
                    };
                    reader.readAsDataURL(file);
                }
            }
        });

        $modal.on('shown.bs.modal', function() {
            cropper = new Cropper(image, cropperOptions);
        }).on('hidden.bs.modal', function() {
            cropper.destroy();
            cropper = null;
        });


        document.getElementById('crop').addEventListener('click', function() {
            var initialAvatarURL;
            var canvas;

            $modal.modal('hide');

            if (cropper) {
                canvas = cropper.getCroppedCanvas({
                    width: 260,
                    height: 260,
                    fillColor: 'yellow'
                });
                initialAvatarURL = avatar.src;
                avatar.src = canvas.toDataURL();
            }
        });
    });
</script>