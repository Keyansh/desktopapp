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
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="main">
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Title <span class="error">*</span></label>
                            <div class="col-sm-6">
                                <input name="form_title" type="text" class="form-control" id="form_title" value="<?php echo set_value('title'); ?>" required />
                            </div>
                        </div>
                    </div>
                    <p align="center"><input type="submit" name="button" id="button" value="Submit" class="btn btn-lg btn-primary"></p>
                </div>
            </div>
        </form>
    </div>
</div>
