<style>
    .main-div #procat li,
    #subcat li {
        width: 100%;
        margin-bottom: 15px;
        list-style: none;
    }

    .main-div #procat li label,
    #subcat li label {
        width: 100%;
    }

    #mayalsolike {
        max-width: 80%;
    }

    .main-div .block-element {
        font-size: 18px;
        font-weight: bold;
        text-align: left;
        color: #263388;
    }

    .left-div .btn.dropdown-toggle.btn-default {
        height: 45px;
    }

    .middle-div .list-inline,
    #procat .list-inline {
        border: 1px solid lightgray;
        padding: 0 10px;
    }

    .sub-a-cat {
        display: inline-block;
        margin: auto;
        border: 1px solid lightgray;
        padding: 0px 20px 0 20px;
        background: #495d80;
        color: white;
        text-transform: capitalize;
    }

    .submit-sub-cat {
        text-align: center;
    }

    .sub-a-cat:hover {
        color: white;
    }

    .middle-div .col-sm-2.control-label.block-element {
        width: 100%;
    }

    .right-div .col-sm-2.control-label.block-element {
        width: 100%;
    }

    .main-div {
        margin-bottom: 100px;
    }
</style>
<h3 class="title-hero clearfix">
    Add Products
    <a href="projects" class="pull-right btn btn-primary">Manage Products</a>
</h3>
<div class="panel">
    <div class="panel-body">
        <?php $this->load->view('inc-messages'); ?>
        <form action="projects/add" method="post" enctype="multipart/form-data" name="add_frm" id="add_frm">
            <div class="example-box-wrapper">
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="main">
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Title <span class="error">*</span></label>
                            <div class="col-sm-6">
                                <input name="title" type="text" class="form-control" id="title" value="<?php echo set_value('title'); ?>" size="40">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Architect <span class="error">*</span></label>
                            <div class="col-sm-6">
                                <input name="architect" type="text" class="form-control" id="architect" value="<?php echo set_value('architect'); ?>" size="40">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Contractor <span class="error">*</span></label>
                            <div class="col-sm-6">
                                <input name="contractor" type="text" class="form-control" id="contractor" value="<?php echo set_value('contractor'); ?>" size="40">
                            </div>
                        </div>
                        <!-- <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">URI</label>
                            <div class="col-sm-6">
                                <input name="url_alias" type="text" class="form-control" id="url_alias" value="<?php echo set_value('url_alias'); ?>" size="40">
                                &nbsp;(Will be auto-generated if left blank)
                            </div>
                        </div> -->
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Category <span class="error">*</span></label>
                            <div class="col-sm-6">
                                <select name="project_cat" id="" class="form-control">
                                    <option value="">--select--</option>
                                    <?php foreach ($projecttype as $item) { ?>
                                        <option value="<?= $item['id'] ?>"><?= $item['name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <p align="center"><input type="submit" name="button" id="button" value="Submit" class="btn btn-lg btn-primary"></p>
                </div>
            </div>
        </form>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('.fa-plus-square').click(function(e) {
            var html = '';
            html += '<div class="form-group clearfix">';
            html += '<div class="col-lg-5">';
            html += '<input name="fieldname[]" class="form-control" placeholder="Name" required/>';
            html += '</div>';
            html += '<div class="col-lg-5">';
            html += '<input name="fieldvalue[]" class="form-control" placeholder="Value" required/>';
            html += '</div>';
            html += '<div class="col-lg-2">';
            html += '<i class="fa fa-window-close fa-4 fielddel" style="font-size:30px;cursor:pointer" aria-hidden="true"></i>';
            html += '</div>';
            html += '</div>';
            $('.fields-main-div').append(html);
        });
        $(document).on('click', '.fa-window-close.fielddel', function(e) {
            $(this).parent().parent().remove();
        });
    });
</script>