<h3 class="title-hero clearfix">
    Add Form
    <a href="forms" class="pull-right btn btn-primary">Manage Forms</a>
</h3>
<div class="panel">
    <div class="panel-body">
        <?php $this->load->view('inc-messages'); ?>
        <form action="forms/add" method="post" enctype="multipart/form-data" name="add_frm" id="add_frm">
            <div class="example-box-wrapper">
                <ul id="myTab" class="nav clearfix nav-tabs">
                    <li class="active"><a href="#main" data-toggle="tab">General</a></li>
                    <li class=""><a href="#metadata" data-toggle="tab">Create Form</a></li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="main">
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Title <span class="error">*</span></label>
                            <div class="col-sm-6">
                                <input name="title" type="text" class="form-control" id="title" value="<?php echo set_value('title'); ?>" required />
                            </div>
                        </div>
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
                    </div>
                    <p align="center"><input type="submit" name="button" id="button" value="Submit" class="btn btn-lg btn-primary"></p>
                </div>
            </div>
        </form>
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
                    <div class="form-container">
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-3">Label</label>
                            <div class="col-xs-12 col-sm-9">
                                <input class="form-control" type="text" name="label" id="">
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
                                            <input type="checkbox" name="validations[]" value="email" /> 
                                            <span class="box">
                                                <i class="fa fa-check"></i>
                                            </span>
                                            <span class="text">Email</span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="custom-check-field-label">
                                            <input type="checkbox" name="validations[]" value="number" /> 
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
                        <button id="insertField" class="btn btn-primary" type="button">Insert Field</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('.field-selector').click(function(){
            var extra_fields = '';
            var extra_field_html = '';
            var field_json = JSON.parse($(this).attr('data-extra-fields'));
            if(field_json.field_type == 'submit'){
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
                        extra_field_html += '       <input class="form-control" type="'+single_field.type+'" name="'+single_field.name+'" id="">';
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
            var formdata = $("#fieldForm").serializeArray();
            var data = {};
            $(formdata ).each(function(index, obj){
                data[obj.name] = obj.value;
            });
            console.log(data);
        });
    });
</script>
