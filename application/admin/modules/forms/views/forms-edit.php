<h3 class="title-hero clearfix">
    Add Form
    <a href="forms" class="pull-right btn btn-primary">Manage Forms</a>
</h3>
<div class="panel">
    <div class="panel-body">
        <div class="example-box-wrapper">
            <ul id="myTab" class="nav clearfix nav-tabs">
                <li class="active"><a href="#main" data-toggle="tab">General</a></li>
                <li class=""><a href="#metadata" data-toggle="tab">Create Form</a></li>
            </ul>
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade active in" id="main">
                    <form action="forms/edit/<?php echo $form_details['id']; ?>" method="post" enctype="multipart/form-data" name="add_frm" id="add_frm">
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Title <span class="error">*</span></label>
                            <div class="col-sm-7">
                                <input name="form_title" type="text" class="form-control" id="form_title" value="<?php echo set_value('title', $form_details['form_title']); ?>" required />
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Send Email To User</label>
                            <div class="col-sm-7">
                                <ul class="list-inline custom-checkbox-list">
                                    <li>
                                        <label class="custom-check-field-label custom-radio-check">
                                            <input type="radio" name="send_email_to_user" value="1" <?php echo $form_details['send_email_to_user'] == 1 ? 'checked' : ''; ?> /> 
                                            <span class="box">
                                                <i class="fa fa-circle"></i>
                                            </span>
                                            <span class="text">Yes</span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="custom-check-field-label custom-radio-check">
                                            <input type="radio" name="send_email_to_user" value="0" <?php echo $form_details['send_email_to_user'] == 0 ? 'checked' : ''; ?> /> 
                                            <span class="box">
                                                <i class="fa fa-circle"></i>
                                            </span>
                                            <span class="text">No</span>
                                        </label>
                                    </li>
                                </ul>
                                <div class="col-xs-12 user-email-config" style="display: <?php echo $form_details['send_email_to_user'] == 1 ? 'block' : 'none;' ?>;">
                                    <div class="form-group">
                                        <label>Email From</label>
                                        <input class="form-control" type="email" name="user_email_from" value="<?php echo $form_details['user_email_from']; ?>">
                                        <p><small>Only single email can be used as "Email From"</small></p>
                                    </div>
                                    <div class="form-group">
                                        <label>Subject</label>
                                        <input class="form-control" type="text" name="user_email_subject" value="<?php echo $form_details['user_email_subject']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Email Body</label>
                                        <p><span style="color: red;">{EMAIL_LOGO}</span> : To display website logo.</p>
                                        <p><span style="color: red;">{FORM_DATA}</span> : To display form data submitted by user.</p>
                                        <textarea name="user_email_body" class="user_email_body"><?php echo $form_details['user_email_body']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Send Email To Admin</label>
                            <div class="col-sm-7">
                                <ul class="list-inline custom-checkbox-list">
                                    <li>
                                        <label class="custom-check-field-label custom-radio-check">
                                            <input type="radio" name="send_email_to_admin" value="1" <?php echo $form_details['send_email_to_admin'] == 1 ? 'checked' : '' ?> /> 
                                            <span class="box">
                                                <i class="fa fa-circle"></i>
                                            </span>
                                            <span class="text">Yes</span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="custom-check-field-label custom-radio-check">
                                            <input type="radio" name="send_email_to_admin" value="0" <?php echo $form_details['send_email_to_admin'] == 0 ? 'checked' : '' ?> /> 
                                            <span class="box">
                                                <i class="fa fa-circle"></i>
                                            </span>
                                            <span class="text">No</span>
                                        </label>
                                    </li>
                                </ul>
                                <div class="col-xs-12 admin-email-config" style="display: <?php echo $form_details['send_email_to_admin'] == 1 ? 'block' : 'none' ?>;">
                                    <div class="form-group">
                                        <label>Email From</label>
                                        <input class="form-control" type="email" name="admin_email_from" value="<?php echo $form_details['admin_email_from']; ?>">
                                        <p><small>Only single email can be used as "Email From".</small></p>
                                    </div>
                                    <div class="form-group">
                                        <label>Email To</label>
                                        <input class="form-control" type="email" name="admin_email_to" value="<?php echo $form_details['admin_email_to']; ?>">
                                        <p><small>To use multiple emails, separate emails with comma.</small></p>
                                    </div>
                                    <div class="form-group">
                                        <label>Subject</label>
                                        <input class="form-control" type="text" name="admin_email_subject" value="<?php echo $form_details['admin_email_subject']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Email Body</label>
                                        <p><span style="color: red;">{EMAIL_LOGO}</span> : To display website logo.</p>
                                        <p><span style="color: red;">{FORM_DATA}</span> : To display form data submitted by user.</p>
                                        <textarea name="admin_email_body" class="admin_email_body"><?php echo $form_details['admin_email_body']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p align="center"><input type="submit" name="button" id="button" value="Submit" class="btn btn-lg btn-primary"></p>
                    </form>
                </div>
                <div class="tab-pane fade" id="metadata">
                    <?php if(isset($fields) && $fields){ ?>
                        <div class="col-xs-12">
                            <p><label style="color: #5f5f5f;">Select from following fields</label>.</p>
                            <ul class="list-inline field-select-list">
                                <?php foreach($fields as $field){ ?>
                                    <li>
                                        <span class="field-selector" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#fieldModal" data-extra-fields='<?php echo json_encode($field); ?>'><?php echo $field['field_type']; ?></span>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    <?php } ?>
                    
                    <div id="field_tree" class="col-xs-12">
                        <div id="field_tree_inner">
                            <?php if(isset($assigned_fields) && $assigned_fields){ ?>
                                <ul id="form_tree" class="list-unstyled form-group-list">
                                    <?php foreach($assigned_fields as $assigned_field){ ?>
                                        <li id="field_<?php echo $assigned_field['id']; ?>">
                                            <div class="form-group">
                                                <div class="col-xs-12 col-sm-2">
                                                    <?php if($assigned_field['type'] != 'submit'){ ?>
                                                        <label><?php echo $assigned_field['label']; ?></label>
                                                    <?php } ?>
                                                </div>
                                                <div class="col-xs-12 col-sm-7">
                                                    <?php 
                                                        $inner = [];
                                                        $inner['field_data'] = $assigned_field;
                                                        echo $this->load->view('forms/fields/'.$assigned_field['type'], $inner);
                                                    ?>
                                                </div>
                                                <div class="col-xs-12 col-sm-3">
                                                    <ul class="list-inline field-action-list">
                                                        <li>
                                                            <i class="fa fa-arrows" title="Drag"></i>
                                                        </li>
                                                        <li>
                                                            <a class="delete-field" data-field-id="<?php echo $assigned_field['id']; ?>" href="#"><i class="fa fa-trash" title="Drag"></i></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                    <?php } ?>
                                </ul>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="fieldModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">Configure Field</h3>
            </div>
            <div class="modal-body">
                <form id="fieldForm">
                    <div class="alert fieldAlert" style="display: none;"></div>
                    <div class="form-container">
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-3">Name</label>
                            <div class="col-xs-12 col-sm-9">
                                <input class="form-control" type="text" name="label" id="">
                                <div class="sub-field">
                                    <ul class="list-inline">
                                        <li>
                                            <label>Use as label </label>
                                        </li>
                                        <li>
                                            <label class="custom-check-field-label">
                                                <input type="radio" name="display_label" value="1" checked /> 
                                                <span class="box">
                                                    <i class="fa fa-check"></i>
                                                </span>
                                                <span class="text">Yes</span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="custom-check-field-label">
                                                <input type="radio" name="display_label" value="0" /> 
                                                <span class="box">
                                                    <i class="fa fa-check"></i>
                                                </span>
                                                <span class="text">No</span>
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="form-group basic-field-group">
                            <label class="col-xs-12 col-sm-3">Default Value</label>
                            <div class="col-xs-12 col-sm-9">
                                <input class="form-control" type="text" name="default_value" id="">
                            </div>
                        </div>
                        <div class="form-group basic-field-group">
                            <label class="col-xs-12 col-sm-3">Placeholder text</label>
                            <div class="col-xs-12 col-sm-9">
                                <input class="form-control" type="text" name="placeholder" id="">
                            </div>
                        </div>
                        <div class="form-group basic-field-group">
                            <label class="col-xs-12 col-sm-3">Validations</label>
                            <div class="col-xs-12 col-sm-9">
                                <ul class="list-inline">
                                    <li>
                                        <label class="custom-check-field-label">
                                            <input type="checkbox" name="validations[]" value="valid_email" /> 
                                            <span class="box">
                                                <i class="fa fa-check"></i>
                                            </span>
                                            <span class="text">Email</span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="custom-check-field-label">
                                            <input type="checkbox" name="validations[]" value="numeric" /> 
                                            <span class="box">
                                                <i class="fa fa-check"></i>
                                            </span>
                                            <span class="text">Number</span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="custom-check-field-label">
                                            <input type="checkbox" name="validations[]" value="required" /> 
                                            <span class="box">
                                                <i class="fa fa-check"></i>
                                            </span>
                                            <span class="text">Required</span>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="form-button-container">
                        <input type="hidden" name="form_id" value="<?php echo $form_details['id']; ?>">
                        <input id="field_type" type="hidden" name="type" value="">
                        <button id="insertField" class="btn btn-primary" type="button">Insert Field</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"></script>
<script>
    $(document).ready(function(){
        $('.field-selector').click(function(){
            var extra_fields = '';
            var extra_field_html = '';
            var field_json = JSON.parse($(this).attr('data-extra-fields'));
            $('#field_type').val(field_json.field_type);
            
            if(field_json.field_type == 'submit' || field_json.field_type == 'captcha'){
                $('.basic-field-group').hide();
            }else{
                $('.basic-field-group').show();
            }
            if(field_json.extra_fields){
                extra_fields = JSON.parse(field_json.extra_fields);
                if(extra_fields.fields){
                    $(extra_fields.fields).each(function(inedex, single_field) {
                        console.log(single_field);
                        extra_field_html += '<div class="form-group extra-field-group">';
                        extra_field_html += '   <label class="col-xs-12 col-sm-3">'+single_field.label+'</label>';
                        extra_field_html += '   <div class="col-xs-12 col-sm-9">';
                        if(single_field.type == 'textarea'){
                            extra_field_html += '       <textarea class="form-control" name="'+single_field.name+'"></textarea>';
                        }else if(single_field.type == 'dropdown'){
                            extra_field_html += '       <select class="form-control" name="'+single_field.name+'">';
                            extra_field_html += '           <option>Select</option>';
                            extra_field_html += '       </select>';
                        }else{
                            extra_field_html += '       <input class="form-control" type="'+single_field.type+'" name="'+single_field.name+'" id="">';
                        }
                        extra_field_html += '   </div>';
                        extra_field_html += '</div>';
                    });
                    $('.form-container').append(extra_field_html);
                }
            }
        });
        $("#fieldModal").on("hidden.bs.modal", function () {
            $('.extra-field-group').remove();
        });
        $('#insertField').click(function(e){
            e.preventDefault();
            $('#fieldModal .modal-content').block({ message: "<h3>Processing...</h3>" });
            $('#myTabContent').block({ message: "<h3>Processing...</h3>" });
            var formdata = $("#fieldForm").serialize();
            console.log(formdata);
            $.ajax({
                url: "forms/saveFormField", 
                method: "POST",
                data: formdata,
                success: function(result){
                    var res = JSON.parse(result);
                    $('.fieldAlert').html(res.message);
                    if(res.success){
                        $('#fieldForm').trigger("reset");
                        $('#fieldModal').modal('hide');
                        $("#field_tree").load(location.href + " #field_tree_inner");
                        $('.fieldAlert').removeClass('alert-danger');
                        $('.fieldAlert').addClass('alert-success');
                    }else{
                        $('.fieldAlert').removeClass('alert-success');
                        $('.fieldAlert').addClass('alert-danger');
                    }
                    $('#fieldModal .modal-content').unblock();
                    $('#myTabContent').unblock();
                    $('.fieldAlert').show();
                    setTimeout(function(){
                        $('.fieldAlert').fadeOut();
                        $('.fieldAlert').html('');
                    },4000);
                }
            });
        });

        $(document).on('click','.delete-field', function(e){
            e.preventDefault();
            var field_id = $(this).attr('data-field-id');
            if(confirm('Are you sure! you want to delete this field?')){
                $('#myTabContent').block({ message: "<h3>Processing...</h3>" });
                $.ajax({
                    url: "forms/deleteFormField", 
                    method: "POST",
                    data: { field_id: field_id },
                    success: function(result){
                        var res = JSON.parse(result);
                        $("#field_tree").load(location.href + " #field_tree_inner");
                        $('#myTabContent').unblock();
                    }
                });
            }
        });

        $('input[name="send_email_to_user"]').change(function(){
            if($(this).val() == 1){
                $('.user-email-config').slideDown(300);
            }else{
                $('.user-email-config').slideUp(300);   
            }
        });

        $('input[name="send_email_to_admin"]').change(function(){
            if($(this).val() == 1){
                $('.admin-email-config').slideDown(300);
            }else{
                $('.admin-email-config').slideUp(300);   
            }
        });

        function postData(data) {
            $.post('forms/updateSortOrder', data, function(data) {
                $( "#dialog-modal" ).dialog('close');
            });
        }
        var options = {
            containment: 'parent',
            opacity: 0.6,
            update: function(event, ui) {
                var data = $(this).sortable('serialize');
                postData(data);
            }
        };
        $( "#form_tree" ).sortable(options);
    });
</script>
<script type="text/javascript">
    var BASE_URL = DWS_SITE_URL + "./assets/"; // use your own base url
    tinymce.init({
        selector: ".user_email_body, .admin_email_body",
        theme: "modern",
        height: 200,
        relative_urls: false,
        remove_script_host: false,
        // document_base_url: BASE_URL,
        plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
            "table contextmenu directionality emoticons paste textcolor responsivefilemanager code"
        ],
        toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect | fontsizeselect",
        toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code ",
        image_advtab: true,
        external_filemanager_path: BASE_URL + "./filemanager/",
        filemanager_title: "Media Gallery",
        external_plugins: {
            "filemanager": BASE_URL + "./filemanager/plugin.min.js"
        },
        fontsize_formats: "8px 9px 10px 11px 12px 13px 14px 15px 16px 17px 18px 19px 20px 21px 22px 23px 24px 25px 26px 27px 28px 29px 30px 31px 32px 33px 34px 35px 36px 37px 38px 39px 40px 41px 42px 43px 44px 45px 46px 47px 48px 49px 50px 51px 52px 53px 54px 55px 56px 57px 58px 59px 60px"
    });
</script>