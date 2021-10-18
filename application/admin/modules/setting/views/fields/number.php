<?php 
    $style_unit = '';
    if($field['unit']){
        $style_unit = $field['unit'];
    }
    $field_value = isset($field_value[$field['name']]) && $field_value[$field['name']] ? str_replace(['px','%'],'',$field_value[$field['name']]) : '';
?>

<input class="form-control" type="number" name="<?php echo $field_data['element'].'['.$field['name'].'_'.$style_unit.']' ?>" 
onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;" value="<?php echo $field_value; ?>">

<script>
    window.onload = () => {
    const myInput = document.querySelector('input[type="number"]');
    myInput.onpaste = e => e.preventDefault();
    }
</script>