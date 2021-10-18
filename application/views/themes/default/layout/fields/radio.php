<?php if(isset($field_data['options']) && $field_data['options']){ 
    $options = explode(',',$field_data['options']);
    ?>
    <ul class="list-inline">
        <?php foreach($options as $option){ ?>
            <li>
                <label class="custom-check-field-label">
                    <input type="radio" name="<?php echo $field_data['name']; ?>" value="<?php echo $option ?>" /> 
                    <span class="box">
                        <i class="fa fa-check"></i>
                    </span>
                    <span class="text"><?php echo $option ?></span>
                </label>
            </li>
        <?php } ?>
    </ul>
<?php } ?>
