<div class="form-group clearfix file-uploader">
    <label class="col-sm-2 control-label">Listing Page image <span>*</span></label>
    <div class="col-sm-6">
        <img class="avatarFile" src="<?php echo $this->config->item('PROJECTS_IMAGE_URL') . $projects['projects_image']; ?>" alt="" id="avatar" style="">
        <input id="inputnk" type="file" class="form-control inputnkFile" name="">
        <input id="croppedimage" class="croppedimageFile" type="hidden" name="projects_image" value="<?php echo $projects['projects_image']; ?>">
    </div>
</div>

<div id="myModalNK" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" style="width: 800px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <img id="imagenk" class="img-responsive" src="https://avatars0.githubusercontent.com/u/3456749">
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

<script type="text/javascript">
    var cropper;
    var avatar;
    var image;
    var canvas;
    var input = document.querySelector('.inputnkFile');
    var avatar = document.querySelector('.avatarFile');
    var croppedImage = document.querySelector('.croppedimageFile');
    var image = document.getElementById('imagenk');
    var $modal = $('#myModalNK');
    var fileFormatType = '';
    var fileMimeType = '';
    var cropperOptions = {
        dragMode: 'move',
        aspectRatio: 2 / 3,
        autoCropArea: 0.65,
        restore: false,
        guides: false,
        center: false,
        highlight: true,
        cropBoxMovable: false,
        cropBoxResizable: false,
        toggleDragModeOnDblclick: false,
    };
    input.addEventListener('change', function(e) {
        avatar = $(this).prev('.avatarFile');
        croppedImage = $(this).next('.croppedimageFile');
        var files = e.target.files;
        var done = function(url) {
            input.value = '';
            image.src = url;
            $('#pageBuilderWidgetsModel').modal('hide');
            setTimeout(function() {
                $modal.modal('show');
            }, 400);

        };
        var reader;
        var file;
        var url;
        if (files && files.length > 0) {
            file = files[0];
            fileMimeType = file.type;
            $(this).parents('.file-uploader').find('span i').html(file.name);
            if (URL) {
                done(URL.createObjectURL(file));
            } else if (FileReader) {
                reader = new FileReader();
                reader.onload = function(e) {
                    done(reader.result);
                };
                reader.readAsDataURL(file);
            }
            $(avatar).show();
        } else {
            $(avatar).hide();
        }
    });

    document.getElementById('crop').addEventListener('click', function() {
        var initialAvatarURL;
        $modal.modal('hide');
        setTimeout(function() {
            $('#pageBuilderWidgetsModel').modal('show');
        }, 600);
        if (cropper) {
            canvas = cropper.getCroppedCanvas({
                width: 320,
                height: 400,
                fillColor: 'white',
                imageSmoothingEnabled: false,
                imageSmoothingQuality: 'high'
            });
            initialAvatarURL = avatar.src;
            $(avatar).attr('src', canvas.toDataURL(fileMimeType));
            $(croppedImage).val(canvas.toDataURL(fileMimeType));
        }

    });
    $modal.on('shown.bs.modal', function(e) {
        cropper = new Cropper(image, cropperOptions);
    });

    $modal.on('hidden.bs.modal', function(e) {
        cropper.destroy();
    });
</script>