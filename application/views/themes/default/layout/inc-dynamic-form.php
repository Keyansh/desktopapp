
<?php
$page_form = getPageFormById($data->content);
if ($page_form) {
    $page_form = $page_form['form'];
}
?>

<?php if (isset($page_form) && $page_form) { ?>
    <div class="my-form-col">
        <div class="form-header">
            <p><?php echo $page_form['form_title']; ?></p>
        </div>
        <?php if (isset($page_form['fields']) && $page_form['fields']) { ?>
            <form class="myForm" action="" method="POST">
                <div class="myFormAlert alert" style="display: none;"></div>
                <input type="hidden" name="form_id" value="<?php echo $page_form['id']; ?>">
                <input type="hidden" name="form_json" value='<?php echo json_encode($page_form); ?>'>
                <?php foreach ($page_form['fields'] as $field) { ?>
                    <div class="form-group">
                        <?php if ($field['label'] != '' && $field['type'] != 'submit') {
                            if ($field['display_label'] == 1) {
                        ?>
                                <label><?php echo $field['label']; ?></label>
                        <?php
                            }
                        } ?>
                        <?php
                        $field_inner = [];
                        $field_inner['field_data'] = $field;
                        $adminUrl = '';
                        if (strpos(base_url(), '/admin') !== false) {
                            $adminUrl = '../../../application/views/';
                        }
                        echo $this->load->view($adminUrl . 'themes/' . THEME . '/layout/fields/' . $field['type'], $field_inner);
                        ?>
                        <?php
                        $multiple_arr = '';
                        if ($field['type'] == 'checkbox') {
                            $multiple_arr = 'arr_';
                        }
                        ?>
                        <input type="hidden" name="<?php echo $multiple_arr . $field['name'] . '_validation'; ?>" value='<?php echo $field["validations"]; ?>'>
                    </div>
                <?php } ?>
            </form>
        <?php } ?>
    </div>
<?php } ?>

<script>
    $(document).ready(function() {
        $(document).on('submit', '.myForm', function(e) {
            e.preventDefault();
            $('body').block({
                message: '<h2>Processing...</h2>'
            });
            var formData = new FormData($(this)[0]);
            var elemThis = $(this);
            $.ajax({
                url: "cms/myForm",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(result) {
                    var formAlert = elemThis.find('.myFormAlert');
                    formAlert.html(result.message);
                    if (result.success) {
                        formAlert.removeClass('alert-danger');
                        formAlert.addClass('alert-success');
                        elemThis.trigger('reset');
                    } else {
                        formAlert.removeClass('alert-success');
                        formAlert.addClass('alert-danger');
                    }
                    $('body').unblock();
                    formAlert.show();
                }
            });
        });
    });
</script>