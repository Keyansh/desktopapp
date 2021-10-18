<?php if(isset($field_data['options']) && $field_data['options']){ 
    $options = explode(',',$field_data['options']);
    ?>
    <select name="" id="" class="form-control">
        <option value="">Select</option>
        <?php foreach($options as $option){ ?>
            <option value="<?php echo $option ?>"><?php echo $option ?></option>
        <?php } ?>
    </select>
<?php } ?>