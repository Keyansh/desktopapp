<select data-font-family="<?php echo isset($field_value[$field['name']]) && $field_value[$field['name']] ? $field_value[$field['name']] : ''; ?>" name="<?php echo $field_data['element'].'['.$field['name'].']' ?>" id="" class="form-control <?php echo $field['name']; ?>">
    <option value="">Select font</option>
</select>