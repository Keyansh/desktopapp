<style>
    .style-input-list>li {
        width: calc(100% / 4);
        margin-right: -4px;
    }
</style>

<?php
$style = '';
$input_count = 1;
if (isset($field_data['inputs']) && $field_data['inputs'] > 1) {
    $input_count = count($field_data['inputs']);
    $style = "width:calc(80% /  $input_count) !important; float: left;";
}
?>

<?php if ($input_count > 1) { ?>
    <div class="clearfix">
        <ul class="list-inline style-input-list">
            <?php foreach($field_data['inputs'] as $key => $field_input){ 
                $gen_name = $field_input['name'];
                if($field_input['unit']){
                    $unit_val = $field_input['unit'] ? '_'.$field_input['unit'] : '';
                    $gen_name = $gen_name. $unit_val;
                }
                $gen_name = $device . $gen_name;
                $style_field_value = isset($style_val_arr[$gen_name]) && $style_val_arr[$gen_name] ? $style_val_arr[$gen_name] : $field_input['default_value'];
                ?>
                <li>
                    <label><?php echo $field_input['placeholder']; ?></label>
                    <input type="text" class="form-control" name="<?php echo $device . $field_input['name'] . '_' . $field_input['unit']; ?>" placeholder="<?php echo $field_input['placeholder']; ?>" value="<?php echo $style_field_value; ?>" style="">
                </li>
            <?php } ?>
        </ul>
    </div>
<?php } else { ?>
    <input type="text" class="form-control" name="<?php echo $field_data['name']; ?>" value="<?php echo $field_value ? $field_value : $field_data['default_value'] ?>" style="<?php echo $style; ?> margin-right: 7px;">
<?php } ?>