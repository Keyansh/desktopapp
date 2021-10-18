<h3 class="title-hero clearfix">
    Edit Project Type
    <a href="projecttype/" class="pull-right btn btn-primary">Manage Project Type</a>
</h3>
<div class="panel">
    <div class="panel-body">
        <?php $this->load->view('inc-messages'); ?>
        <form action="projecttype/edit/<?= $projecttype['id']; ?>" method="post" enctype="multipart/form-data" name="addcatform" id="addcatform">
            <div class="example-box-wrapper">
                <ul id="myTab" class="nav clearfix nav-tabs">
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="main">
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Name <span class="error">*</span></label>
                            <div class="col-sm-6">
                                <input name="name" type="text" class="form-control" id="name" value="<?php echo set_value('name', $projecttype['name']); ?>" size="40">
                            </div>
                        </div>

                        <div class="form-group clearfix">
                            <!-- <label class="col-sm-2 control-label"></label> -->
                            <div class="col-sm-12" align="center">
                                <input name="image_v" type="hidden" id="image_v" value="1">
                                Fields marked with <span class="error">*</span> are required.
                            </div>
                        </div>
                    </div>

                    <p align="center"><input type="submit" name="button" id="button" value="Submit" class="btn btn-lg btn-primary"></p>
                </div>
            </div>
        </form>
    </div>
</div>