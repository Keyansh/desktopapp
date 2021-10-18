<?php
$itemFormFields = json_decode($element_item_fields, true);
$blockItemContentArr = json_decode($block_item_content, true);
$blockStyleContentArr = json_decode($block_style_content, true);
?>

<?php // if ($itemFormFields) { 
?>
<form action="" method="POST" enctype="multipart/form-data" id="pagebuilderElementformdata">
    <div class="form-group static-form-fields">

        <input type="hidden" class="skip" value="<?= $element_id ?>" name="element_id">
        <input type="hidden" class="skip" value="<?= $page_id ?>" name="page_id">
        <input type="hidden" class="skip" value="<?= $row_id ?>" name="row_id">
        <input type="hidden" class="skip" value="<?= $column_id ?>" name="column_id">
        <input type="hidden" class="skip" value='<?= $element_alias ?>' name="element_alias">
        <input type="hidden" class="skip" value="<?= $element_table ?>" name="element_table">
        <?php if ($element_alias == 'slider') { ?>
            <div class="form-group">
                <label>Slider Name</label>
                <select name="slider_id" id="slider_id" class="form-control">
                    <?php $sliderList = getAllsliders(); ?>
                    <?php foreach ($sliderList as $item) { ?>
                        <option <?php echo $blockItemContentArr['slider_id'] == $item['slideshow_id'] ? 'selected' : ''; ?> value="<?= $item['slideshow_id'] ?>"><?= $item['slideshow_title'] ?></option>
                    <?php } ?>
                    <option <?php echo $blockItemContentArr['slider_id'] == 'category' ? 'selected' : ''; ?> value="category">Category</option>
                    <!-- <option <?php echo $blockItemContentArr['slider_id'] == 'projects' ? 'selected' : ''; ?> value="projects">Projects</option> -->
                    <!-- <option <?php // echo $blockItemContentArr['slider_id'] == 'product' ? 'selected' : ''; 
                                    ?> value="product">Product</option> -->
                </select>
            </div>
            <div class="form-group" id="selectsection">
                <select class="js-example-basic-multiple form-control" name="moduledata[]" id="moduledata" multiple="multiple">

                </select>
            </div>
            <?php $seleledData = json_encode($blockItemContentArr['moduledata']) ?>
            <script>
                var addedValue = '<?php echo $seleledData ?>';
                $('#selectsection').css('display', 'none');
                $('#moduledata').html('');
                $(document).ready(function() {
                    $(".js-example-basic-multiple").select2();
                    $(".js-example-basic-multiple").on("select2:select", function(evt) {
                        var element = evt.params.data.element;
                        var $element = $(element);
                        $element.detach();
                        $(this).append($element);
                        $(this).trigger("change");
                    });
                });
                $(document).on('change', "#slider_id", function() {
                    $('#selectsection').css('display', 'none');
                    $('#moduledata').html('');
                    var selectedValue = this.value;
                    if (selectedValue == 'category' || selectedValue == 'projects' || selectedValue == 'product') {
                        $('#selectsection').css('display', 'block');
                        $.ajax({
                            url: '<?php echo base_url(); ?>cms/pagebuilder/getModelData',
                            type: "POST",
                            data: {
                                'selectedValue': selectedValue,
                                'addedValue': addedValue
                            },
                            success: function(data) {
                                var obj = jQuery.parseJSON(data);
                                if (obj.success == true) {
                                    $('#moduledata').html(obj.content);
                                }
                            }
                        });
                    }
                });
            </script>
        <?php } ?>
        <?php if ($element_alias == 'new_arrivals') { ?>
            <div class="form-group">
                <label>Products</label>
                <select class="js-example-basic-multiple form-control" name="productdata[]" id="productdata" multiple="multiple">
                    <?php $getAllProduct = getAllProduct(); ?>
                    <?php $seleledData = $blockItemContentArr['productdata']; ?>
                    <?php foreach ($getAllProduct as $item) { ?>
                        <option <?php echo in_array($item['id'], $seleledData) ? 'selected' : '' ?> value="<?= $item['id'] ?>"><?= $item['name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <script>
                $(document).ready(function() {
                    $('.js-example-basic-multiple').select2();
                });
            </script>
        <?php } ?>
        <?php if ($element_alias == 'form') { ?>
            <div class="form-group">
                <label>Select Form</label>
                <select name="content" id="" class="form-control">
                    <?php $getAllForms = getAllForms(); ?>
                    <?php foreach ($getAllForms as $item) { ?>
                        <option <?php echo $blockItemContentArr['content'] == $item['id'] ? 'selected' : ''; ?> value="<?= $item['id'] ?>"><?= $item['form_title'] ?></option>
                    <?php } ?>
                </select>
            </div>
        <?php } ?>
        <?php
        foreach ($itemFormFields['form'] as $itemFormField) {
            $fieldData = [];
            $field_value = '';
            if (in_array($itemFormField['name'], array_keys($blockItemContentArr))) {
                $field_value = $blockItemContentArr[$itemFormField['name']];
                $fieldData['field_value'] = $field_value;
            }
            $fieldData['field_data'] = $itemFormField;
            $fieldData['style_field'] = $blockStyleContentArr;
        ?>

            <?php if ($itemFormField['type'] == 'checkbox' || $itemFormField['type'] == 'radio') { ?>
                <div class="form-group col-xs-12 formgroupcss">
                    <label><?= $itemFormField['label'] ?></label>
                    <div class="col-xs-12 radiobtncss">
                        <?php
                        $i = 1;
                        foreach ($itemFormField['options'] as $data) {
                        ?>
                            <div class="radio">
                                <label>
                                    <input <?php if ($i == 1) {
                                                echo 'checked';
                                            }; ?> type="<?php echo $itemFormField['type']; ?>" name="<?= $itemFormField['name'] ?>" value="<?= $data['value'] ?>" style="top: 10px;">
                                    <?= $data['label'] ?>
                                </label>
                            </div>
                        <?php $i++;
                        } ?>
                    </div>
                </div>
            <?php } else { ?>

                <?php if ($itemFormField['type'] == 'file') { ?>
                    <div class="form-group">
                        <label><?php echo $itemFormField['label']; ?> Width</label>
                        <input type="text" name="image_width" class="form-control" value="0" />
                    </div>
                    <div class="form-group">
                        <label><?php echo $itemFormField['label']; ?> Height</label>
                        <input type="text" name="image_height" class="form-control" value="0" />
                    </div>
                <?php } ?>
                <div class="form-group">
                    <?php if ($itemFormField['type'] != 'hidden') { ?>
                        <label><?php echo $itemFormField['label']; ?></label>
                    <?php } ?>
                    <?php echo $this->load->view('cms/pagebuilder/fields/' . $itemFormField['type'], $fieldData); ?>
                </div>
            <?php } ?>
        <?php } ?>



        <?php if ($element_table != '' && $element_table != 'collage' && $element_alias != 'slider') { ?>
            <div class="form-group">
                <label>Select Layout</label>
                <ul class="list-inline radio-ul">
                    <li>
                        <label><input type="radio" name="grid_layout_type" value="full_column" checked=""> <span class="radio-icon a1"></span></label>
                    </li>
                    <li>
                        <label><input type="radio" name="grid_layout_type" value="half_column"> <span class="radio-icon a2"></span></label>
                    </li>
                    <li>
                        <label><input type="radio" name="grid_layout_type" value="three_column"> <span class="radio-icon a3"></span></label>
                    </li>
                    <li>
                        <label><input type="radio" name="grid_layout_type" value="four_column"> <span class="radio-icon a4"></span></label>
                    </li>
                    <li>
                        <label><input type="radio" name="grid_layout_type" value="five_column"> <span class="radio-icon a5"></span></label>
                    </li>
                    <li>
                        <label><input type="radio" name="grid_layout_type" value="left_column"> <span class="radio-icon a6"></span></label>
                    </li>
                    <li>
                        <label><input type="radio" name="grid_layout_type" value="right_column"> <span class="radio-icon a7"></span></label>
                    </li>
                    <li>
                        <label><input type="radio" name="grid_layout_type" value="center_column"> <span class="radio-icon a8"></span></label>
                    </li>
                </ul>
            </div>
        <?php } ?>
    </div>
</form>
<?php // } 
?>