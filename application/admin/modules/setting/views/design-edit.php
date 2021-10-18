<?php createDefaultCss(); ?>
<style>
    .row {
        display: flex;
        align-items: center;
    }
    .row-group {
        border-bottom: dashed 1px #bfbfbf;
        padding-bottom: 27px;
        margin-bottom: 15px;
    }
    .col-xs-12.col-sm-2 label {
        font-size: 15px;
        font-weight: bold;
    }
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
<h3 class="title-hero clearfix">
    Design Configuration
</h3>

<div class="panel">
    <div class="panel-body">
        <div class="example-box-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <?php $this->load->view('inc-messages'); ?>
                    <div style="float: left; width: 100%">
                        <?php //e($field_groups); ?>
                        <form action="setting/design" method="post">
                            <?php 
                            if(isset($field_groups) && $field_groups){ 
                                foreach($field_groups as $field_group){
                                    $field_groupArr = json_decode($field_group['field_json'], true);
                                    $field_contentArr = json_decode($field_group['config_json'], true);
                                ?>
                                <div class="row row-group">
                                    <div class="col-xs-12 col-sm-2">
                                        <label class="control-label"><?php echo $field_group['field_label']; ?></label>
                                    </div>
                                    <?php if(isset($field_groupArr) && $field_groupArr){ 
                                        foreach($field_groupArr['form'] as $field){
                                            $data['field_data'] = $field_group;
                                            $data['field'] = $field;
                                            $data['field_value'] = $field_contentArr;
                                        ?>
                                        <div class="col-xs-12 col-sm-3">
                                            <label class="control-label"><?php echo $field['label']; ?></label>
                                            <?php $this->load->view('setting/fields/'.$field['type'], $data); ?>
                                        </div>
                                        <?php }
                                        }
                                    ?>
                                </div>
                                <?php 
                                    }
                                } 
                            ?>
                            <div class="row form-group text-center">
                                <input style="margin: auto !important;" class="btn btn-primary btn-lg" type="submit" value="Update">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"></script>
<!-- <script>
    $(document).ready(function(){
        $('body').block({
                message: 'Processing...'
        });
        var dropdownHtml = '';
        $.ajax({
            url: "https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyBnY7IkcsTzm1punkjuOJnIMzes9-IZJZo ",
            type: "GET",
            success: function(res) { 
                $(res.items).each(function(index, item) {
                    var itemFiles = item.files;
                    var variantIndex = 0;
                    for (var key in itemFiles) {
                        if (itemFiles.hasOwnProperty(key)) {
                            var fontName = item.family + ' ' + item.variants[variantIndex];
                            var fontValue = itemFiles[key] + '_fam_'+ item.family + '_weg_' + item.variants[variantIndex];
                            dropdownHtml += '<option value="'+fontValue+'">'+fontName+'</option>';
                            variantIndex++;
                        }
                    }
                });
                $('.font-family').html(dropdownHtml);
                setTimeout(function(){
                    $(".font-family").each(function( index, field ) {
                        var selectedValue = $(field).attr('data-font-family');
                        $(field).find('option[value="'+selectedValue+'"]').prop('selected', true);
                    });
                    $('body').unblock();
                }, 600);
            }
        });
    });
</script> -->
