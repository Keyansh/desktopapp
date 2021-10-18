<?php
$data_form_field = json_decode($element_style_fields,true) ;
$blockStyleContentArr = json_decode($block_style_content, true);

if ($data_form_field['form']) {  ?>
    <form action="" method="POST" enctype="multipart/form-data" id="pagebuilderElementStyledata">
        <input type="hidden" class="skip" value="<?= $element_id ?>" name="element_id">
        <input type="hidden" class="skip" value="<?= $page_id ?>" name="page_id">
        <input type="hidden" class="skip" value="<?= $row_id ?>" name="row_id">
        <input type="hidden" class="skip" value="<?= $column_id ?>" name="column_id">
        <input type="hidden" class="skip" value='<?= $element_alias ?>' name="element_alias">
        <div class="form-group col-xs-12 style-form-fields" style="padding: 0;">

            <div class="col-xs-12 style-tab-list">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#web_styles"><i class="fa fa-desktop" aria-hidden="true"></i></a></li>
                    <li><a data-toggle="tab" href="#tab_styles"><i class="fa fa-tablet" aria-hidden="true"></i></a></li>
                    <li><a data-toggle="tab" href="#mobile_styles"><i class="fa fa-mobile" aria-hidden="true"></i></a></li>
                </ul>
            </div>
            <div class="col-xs-12 style-tab-content">
                <div class="tab-content">

                    <?php 
                        $screens = ['web' => 'web_styles', 'tab' => 'tab_styles', 'mobile' => 'mobile_styles'];
                    ?>

                    <?php 
                    $i = 1;
                    foreach($screens as $device => $screen){ ?>

                        <div id="<?php echo $screen; ?>" class="tab-pane fade <?php echo $i == 1 ? 'in active' : ''; ?>">
                            <?php 
                                foreach($data_form_field['form'] as $itemFormField){ 
                                    $fieldData = [];
                                    $field_value = '';
                                    if(in_array($itemFormField['name'],array_keys($blockStyleContentArr))){
                                        $field_value = $blockStyleContentArr[$itemFormField['name']];
                                    }
                                    $fieldData['field_data'] = $itemFormField;
                                    $fieldData['field_value'] = $field_value;
                                    $fieldData['style_val_arr'] = $blockStyleContentArr;
                                    $fieldData['device'] = $device ? $device.'_' : '';
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
                                                        <input <?php if ($i == 1) { echo 'checked';}; ?> type="<?php echo $itemFormField['type']; ?>" name="<?= $itemFormField['name'] ?>" value="<?= $data['value'] ?>" style="top: 10px;">
                                                        <?= $data['label'] ?>
                                                    </label>
                                                </div>
                                            <?php $i++; } ?>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="form-group">
                                        <label><?php echo $itemFormField['label']; ?></label>
                                        <?php echo $this->load->view('cms/pagebuilder/fields/'.$itemFormField['type'], $fieldData); ?>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div>

                    <?php
                    $i++;
                 } ?>

                </div>
            </div>
            <div class="clearfix"></div>

        </div>
    </form>
<?php }  ?>