<script src="<?= base_url() ?>assets/ckeditor/ckeditor.js"></script>
<script src="<?= base_url() ?>assets/ckfinder/ckfinder.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js"></script>
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

    .selected-pro-ul {
        padding: 10px 20px;
        margin: 0;
        border: 1px solid lightgray;
    }

    .selected-pro-ul li .removeproduct {
        display: inline-block;
        margin-left: 25px;
        color: red;
        cursor: pointer;
    }

    .selected-pro-ul li {
        list-style: none;
    }

    .right-div .col-sm-2.control-label.block-element,
    .middle-div .col-sm-2.control-label.block-element,
    .left-div .col-sm-2.control-label.block-element {
        width: 100%;
    }

    .main-div {
        margin-bottom: 100px;
    }
</style>
<h3 class="title-hero clearfix">
    Update Category
    <a href="projects" class="pull-right btn btn-primary">Manage Category</a>
</h3>
<div class="panel">
    <div class="panel-body">
        <?php $this->load->view('inc-messages'); ?>
        <form action="projects/edit/<?php echo $projects['projects_id']; ?>" method="post" enctype="multipart/form-data" name="add_frm" id="add_frm">
            <div class="example-box-wrapper">
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="main">
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Title <span class="error">*</span></label>
                            <div class="col-sm-6">
                                <input name="title" type="text" class="form-control" id="title" value="<?php echo set_value('title', $projects['projects_title']); ?>" size="40">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Mrp <span class="error">*</span></label>
                            <div class="col-sm-6">
                                <input name="mrprs" type="text" class="form-control" id="mrprs" value="<?php echo set_value('mrprs', $projects['mrprs']); ?>" size="40">
                            </div>
                        </div>
                        <!-- <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Contractor <span class="error">*</span></label>
                            <div class="col-sm-6">
                                <input name="contractor" type="text" class="form-control" id="contractor" value="<?php echo set_value('contractor', $projects['contractor']); ?>" size="40">
                            </div>
                        </div> -->
                        <!-- <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">URI</label>
                            <div class="col-sm-6">
                                <input name="url_alias" type="text" class="form-control" id="url_alias" value="<?php echo set_value('url_alias', $projects['projects_alias']); ?>" size="40">
                                &nbsp;(Will be auto-generated if left blank)
                            </div>
                        </div> -->
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Category <span class="error">*</span></label>
                            <div class="col-sm-6">
                                <select name="project_cat" id="" class="form-control">
                                    <option value="">--select--</option>
                                    <?php foreach ($projecttype as $item) { ?>
                                        <option <?php echo  $item['id'] == $projects['project_cat'] ? 'selected' : ' '  ?> value="<?= $item['id'] ?>"><?= $item['name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">TakeAway</label>
                            <div class="col-sm-6">
                                <input type="radio" name="takeAway" value="1" <?php echo set_radio('takeAway', 1, ($projects['takeAway'] == 1)); ?> />Yes
                                <input type="radio" name="takeAway" value="0" <?php echo set_radio('takeAway', 0, ($projects['takeAway'] == 0)); ?> />NO
                            </div>
                        </div>

                    </div>
                 
                    
                    
                    <p align="center"><input type="submit" name="button" id="button" value="Update" class="btn btn-lg btn-primary"></p>
                </div>
            </div>
        </form>
    </div>
</div>


