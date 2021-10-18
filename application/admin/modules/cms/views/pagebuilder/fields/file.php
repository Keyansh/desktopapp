<div class="file-uploader">
    <img class="avatarFile" src="<?php echo $field_value; ?>" alt="" id="avatar" style="">
    <input id="inputnk" type="file" class="form-control inputnkFile" name="<?php echo $field_data['name']; ?>">
    <input id="croppedimage" class="croppedimageFile" type="hidden" name="image" value="<?php echo $field_value; ?>">
    <span>
        Browse
        <i></i>
    </span>
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
        aspectRatio: 0,
        viewMode: 0,
        dragMode: 'none',
        crop: function(e){
            $('#cropperHeight').html(Math.round(e.detail.height)+'px');
            $('#cropperWidth').html(Math.round(e.detail.width)+'px');
        }
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
        }else {
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
                width: $('input[name="image_width"]').val() != 0 ? $('input[name="image_width"]').val() : 800,
                height:$('input[name="image_height"]').val() != 0 ? $('input[name="image_height"]').val() : 600,
                fillColor: 'white',
                imageSmoothingEnabled: false,
                imageSmoothingQuality: 'high'
            });
            initialAvatarURL = avatar.src;
            $(avatar).attr('src',canvas.toDataURL(fileMimeType));
            $(croppedImage).addClass('jjkk');
            $(croppedImage).val(canvas.toDataURL(fileMimeType));
        }
        
    });
    $modal.on('shown.bs.modal', function (e) {
        cropper = new Cropper(image, cropperOptions);
    });

    $modal.on('hidden.bs.modal', function (e) {
        cropper.destroy();
    });

    $('#myModalNK').on('hidden.bs.modal', function () {
        $('.modal-backdrop').removeClass('in');
        $('.modal-backdrop').css('z-index','0')
    });
</script>

