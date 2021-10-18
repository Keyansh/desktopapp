<style>
    .style-input-list > li {
        width: calc(100% / 4);
        margin-right: -4px;
    }
</style>
<form id="rowUpdaterForm">
    <!-- <div class="form-group">
        <label>Select Layout</label>
        <ul class="list-inline radio-ul">
            <li>
                <label><input type="radio" name="grid_layout_type" value="full_column" <?php echo $row_data['layout_type'] == 'full_column' ? 'checked' : ''; ?>> <span class="radio-icon a1"></span></label>
            </li>
            <li>
                <label><input type="radio" name="grid_layout_type" value="half_column" <?php echo $row_data['layout_type'] == 'half_column' ? 'checked' : ''; ?>> <span class="radio-icon a2"></span></label>
            </li>
            <li>
                <label><input type="radio" name="grid_layout_type" value="three_column" <?php echo $row_data['layout_type'] == 'three_column' ? 'checked' : ''; ?>> <span class="radio-icon a3"></span></label>
            </li>
            <li>
                <label><input type="radio" name="grid_layout_type" value="four_column" <?php echo $row_data['layout_type'] == 'four_column' ? 'checked' : ''; ?>> <span class="radio-icon a4"></span></label>
            </li>
            <li>
                <label><input type="radio" name="grid_layout_type" value="five_column" <?php echo $row_data['layout_type'] == 'five_column' ? 'checked' : ''; ?>> <span class="radio-icon a5"></span></label>
            </li>
            <li>
                <label><input type="radio" name="grid_layout_type" value="left_column" <?php echo $row_data['layout_type'] == 'left_column' ? 'checked' : ''; ?>> <span class="radio-icon a6"></span></label>
            </li>
            <li>
                <label><input type="radio" name="grid_layout_type" value="right_column" <?php echo $row_data['layout_type'] == 'right_column' ? 'checked' : ''; ?>> <span class="radio-icon a7"></span></label>
            </li>
            <li>
                <label><input type="radio" name="grid_layout_type" value="center_column" <?php echo $row_data['layout_type'] == 'center_column' ? 'checked' : ''; ?>> <span class="radio-icon a8"></span></label>
            </li>
        </ul>
    </div> -->
    <?php 
        $row_style = json_decode($row_data['style_config'], true);
    ?>
    <div class="form-group">
        <label>Padding</label>
        <ul class="list-inline style-input-list">
            <li><input class="form-control" type="text" name="padding[]" value="<?php echo isset($row_style) && $row_style ? $row_style['padding'][0] : 0; ?>" placeholder="Top"></li>
            <li><input class="form-control" type="text" name="padding[]" value="<?php echo isset($row_style) && $row_style ? $row_style['padding'][1] : 0; ?>" placeholder="Right"></li>
            <li><input class="form-control" type="text" name="padding[]" value="<?php echo isset($row_style) && $row_style ? $row_style['padding'][2] : 0; ?>" placeholder="Bottom"></li>
            <li><input class="form-control" type="text" name="padding[]" value="<?php echo isset($row_style) && $row_style ? $row_style['padding'][3] : 0; ?>" placeholder="Left"></li>
        </ul>
    </div>
    <div class="form-group">
        <label>Margin</label>
        <ul class="list-inline style-input-list">
            <li><input class="form-control" type="text" name="margin[]" value="<?php echo isset($row_style) && $row_style ? $row_style['margin'][0] : 0; ?>" placeholder="Top"></li>
            <li><input class="form-control" type="text" name="margin[]" value="<?php echo isset($row_style) && $row_style ? $row_style['margin'][1] : 0; ?>" placeholder="Right"></li>
            <li><input class="form-control" type="text" name="margin[]" value="<?php echo isset($row_style) && $row_style ? $row_style['margin'][2] : 0; ?>" placeholder="Bottom"></li>
            <li><input class="form-control" type="text" name="margin[]" value="<?php echo isset($row_style) && $row_style ? $row_style['margin'][3] : 0; ?>" placeholder="Left"></li>
        </ul>
    </div>
    <div class="form-group">
        <label>Full Width</label>
        <select name="full_width" id="" class="form-control">
            <option value="0" <?php echo $row_style['full_width'] == 0 ? 'selected' : '' ?>>No</option>
            <option value="1" <?php echo $row_style['full_width'] == 1 ? 'selected' : '' ?>>Yes</option>
        </select>
    </div>
    <div class="form-group">
        <label>Background Color</label>
        <input type="text" class="form-control jscolor" name="background_color" value="<?php echo isset($row_style['background_color']) && $row_style['background_color'] ? $row_style['background_color'] : ''; ?>" />
    </div>
    <div class="form-group">
        <label>Background Image</label>
        <div class="file-uploader">
            <?php 
                $image_val = isset($row_style) && $row_style ? $row_style['image'] : '';
            ?>
            <img src="<?php echo $image_val; ?>" alt="" id="row_bg_avatar" style="display: <?php echo $image_val != '' ? 'block' : 'none'; ?>;">
            <input id="row_bg_input" type="file" class="form-control" name="background_image">
            <input id="row_bg_croppedimage" type="hidden" name="image" value="<?php echo $image_val; ?>">
            <span>
                Browse
                <i></i>
            </span>
        </div>
    </div>
    <div class="form-group">
        <label>Background style</label>
        <select name="background_style" id="" class="form-control">
            <option value="cover" <?php echo $row_style['background_style'] == 'cover' ? 'selected' : ''; ?>>Cover The Box</option>
            <option value="contain" <?php echo $row_style['background_style'] == 'contain' ? 'selected' : ''; ?>>Contain In Box (Repeat)</option>
            <option value="100% 100%" <?php echo $row_style['background_style'] == '100% 100%' ? 'selected' : ''; ?>>Fill The Box (Strech)</option>
        </select>
    </div>  
    <div class="form-group text-right">
        <input type="hidden" name="page_id" value="<?php echo $page_id; ?>">
        <input type="hidden" name="row_id" value="<?php echo $row_id; ?>">
        <input type="submit" class="btn btn-primary" value="Update" />
    </div>
</form>

<!-- <script src="<?php echo base_url(); ?>js/jscolor.js"></script> -->

<script type="text/javascript">
    var cropper;
    var avatar = document.getElementById('row_bg_avatar');
    var image = document.getElementById('imagenk');
    var input = document.getElementById('row_bg_input');
    var $modal = $('#myModalNK');
    var fileFormatType = '';
    var fileMimeType = '';
    var cropperOptions = {
        aspectRatio: 0,
        viewMode: 0,
        dragMode: 'none',
        crop: function(e){
            // $('#cropperHeight').html(Math.round(e.detail.height)+'px');
            // $('#cropperWidth').html(Math.round(e.detail.width)+'px');
        }
    };
    input.addEventListener('change', function(e) {

        var files = e.target.files;
        var done = function(url) {
            input.value = '';
            image.src = url;
            // $('#pageBuilderWidgetsModel').modal('hide');
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
            $('.file-uploader span i').html(file.name);
            if (URL) {
                done(URL.createObjectURL(file));
            } else if (FileReader) {
                reader = new FileReader();
                reader.onload = function(e) {
                    done(reader.result);
                };
                reader.readAsDataURL(file);
            }
            $('#row_bg_avatar').show();
        }else {
            $('#row_bg_avatar').hide();
        }
    });
    
    document.getElementById('crop').addEventListener('click', function() {
        var initialAvatarURL;
        var canvas;
        $modal.modal('hide');
        setTimeout(function() {
            // $('#pageBuilderWidgetsModel').modal('show');
        }, 600);
        if (cropper) {
            canvas = cropper.getCroppedCanvas({
                // width: 1900,
                // height: 800,
                fillColor: 'white',
                imageSmoothingEnabled: false,
                imageSmoothingQuality: 'high'
            });
            initialAvatarURL = avatar.src;
            avatar.src = canvas.toDataURL(fileMimeType);
            $('#row_bg_croppedimage').val(canvas.toDataURL(fileMimeType));
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