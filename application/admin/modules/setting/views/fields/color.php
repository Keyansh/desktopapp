<link rel="stylesheet" href="<?php echo base_url(); ?>css/spectrum.css" />
<script src="<?php echo base_url(); ?>js/spectrum.js"></script>
<input class="custom_color_picker<?php echo $field_data['id']; ?>" type="text" 
                    name="<?php echo $field_data['element'].'['.$field['name'].']' ?>" value="<?php echo isset($field_value[$field['name']]) && $field_value[$field['name']] ? $field_value[$field['name']] : 'transparent'; ?>">

<script>
    $(".custom_color_picker<?php echo $field_data['id']; ?>").spectrum({
        color: "<?php echo isset($field_value[$field['name']]) && $field_value[$field['name']] ? $field_value[$field['name']] : 'transparent'; ?>",
        showInput: true,
        allowEmpty:true,
        showAlpha: true,
        preferredFormat: "rgba",
        change: function(tinycolor) {
            $(this).val( tinycolor.toRgbString() );
        }
    });
</script>