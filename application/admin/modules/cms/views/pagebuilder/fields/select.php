
<select name="<?php echo $field_data['name']; ?>" id="" class="form-control">
    <option value="">Select</option>
    <?php
    $i = 1;
    foreach ($field_data['options'] as $item) {
    ?>
        <!-- <option value="<?= $item['value'] ?>" <?php echo $field_value ==  $item['value'] ? 'selected' : '' ?> <?php echo isset($style_val_arr) && $style_val_arr[$field_data['name']] == $item['value'] ? 'selected' : ''; ?>><?= $item['label'] ?></option> -->
        <option value="<?= $item['value'] ?>" <?php echo $field_value ==  $item['value'] ? 'selected' : '' ?>><?= $item['label'] ?></option>
    <?php $i++;
    } ?>
</select>


<?php if ($field_data['name'] == 'link_type') { ?>
    <div class="inner-form-div" style="display: none;">
        <label for="">link item</label>
        <select name="" id="selectedLinkType" class="form-control" style="display: none;">
            <option value="">Select</option>
        </select>
        <input type="text" id="customfield" class="form-control" style="display:none">
        <input type="hidden" value="" name="link" class="linkvalue">
    </div>
    <script>
        $(document).on('change', "select[name='link_type']", function() {
            // $("select[name='link_type']").on('change', function() {

            var selectedValue = this.value;
            $('.linkvalue').val('');
            if (selectedValue == 'custom') {
                $('#customfield').css('display', 'block');
                $('#selectedLinkType').css('display', 'none');
                $('.inner-form-div').css({
                    'margin-top': '15px',
                    'display': 'block'
                });
            } else {
                $('#customfield').css('display', 'none');
                $.ajax({
                    url: '<?php echo base_url(); ?>cms/pagebuilder/getSelectedValueData',
                    type: "POST",
                    data: {
                        'selectedValue': selectedValue
                    },
                    success: function(data) {
                        var obj = jQuery.parseJSON(data);
                        console.log(data);
                        if (obj.success == true) {

                            $('#selectedLinkType').html(obj.content);
                            // $('.inner-form-div label').html(obj.linktype);
                            $('.inner-form-div').css({
                                'margin-top': '15px',
                                'display': 'block'
                            });
                            $('#selectedLinkType').css('display', 'block');
                        }
                    }
                });
            }
        });

        $("#selectedLinkType").on('change', function() {
            var finalValue = this.value;
            $('input[name="link"]').val(finalValue);
        });
        $(document).on('keyup', '#customfield', function(e) {
            var inputvalue = $(this).val();
            $('input[name="link"]').val(inputvalue);
        });
    </script>
<?php } ?>