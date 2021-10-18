<link rel="stylesheet" href="<?php echo base_url(); ?>css/spectrum.css" />
<script src="<?php echo base_url(); ?>js/spectrum.js"></script>
<style>
    .sp-replacer {
        width: 100%;
        padding: 5px !important;
        height: 44px;
        border: solid 1px #c1c1c1 !important;
    }
    .sp-preview {
        width: 100% !important;
        height: 100% !important;
    }
    .sp-replacer .sp-dd {
        display: none;
    }
</style>

<?php
    $default_color = $field_data['name'] == 'background-color' ? 'transparent'  : '#333';
?>

<input type="text" name="<?php echo $device . $field_data['name']; ?>" id="" class="form-control custom_color_picker_<?php echo $device . $field_data['name']; ?>" value="<?php echo isset($style_val_arr) && $style_val_arr ? $style_val_arr[$device.$field_data['name']] : $default_color; ?>" />

<script>
    $(".custom_color_picker_<?php echo $device . $field_data['name']; ?>").spectrum({
        color: "<?php echo isset($style_val_arr) && $style_val_arr ? $style_val_arr[$device.$field_data['name']] : $default_color; ?>",
        showInput: true,
        allowEmpty:true,
        showAlpha: true,
        preferredFormat: "rgba",
        change: function(tinycolor) {
            $(this).val( tinycolor.toRgbString() );
        }
    });
</script>