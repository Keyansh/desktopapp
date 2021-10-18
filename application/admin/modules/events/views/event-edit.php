<?php
$datetime = explode('/', $event['date_time']);
$eDate = $datetime[0];
$eTime = $datetime[1];
?>
<h3 class="title-hero clearfix">
    Edit Event "<?= $event['name']; ?>"
    <a href="events/index" class="pull-right btn btn-primary">Manage Events</a>
</h3>
<div class="panel">
    <div class="panel-body">
        <?php $this->load->view('inc-messages'); ?>
        <form action="events/edit/<?= $event['id'] ?>" method="post" enctype="multipart/form-data" name="editeventform" id="editeventform">
            <div class="example-box-wrapper">
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="main">
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Event Name <span class="error">*</span></label>
                            <div class="col-sm-5">
                                <input name="event_name" type="text" class="form-control" id="event_name" value="<?php echo set_value('event_name', $event['name']); ?>" size="40" />
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Date/Time <span class="error">*</span></label>
                            <div class="col-sm-2">
                                <input name="date" type="text" class="form-control bootstrap-datepicker" id="date" data-date-format="dd-mm-yy" value="<?php echo set_value('date', $eDate); ?>" size="40" />
                            </div>
                            <div class="col-sm-1 text-center" style="font-size: 20px"> / </div>
                            <div class="col-sm-2">
                                <input name="time" type="text" class="form-control timepicker-example" id="time" value="<?php echo set_value('time', $eTime); ?>" size="40" />
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label">Contents</label>
                            <div class="col-sm-10">
                                <textarea name="contents" cols="37" rows="5" style="width:99%" class="form-control"id="contents"><?php echo set_value('contents', $event['description']); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-6">
                                Fields marked with <span class="error">*</span> are required.
                                <p><input type="submit" name="button" id="button" value="Submit" class="btn btn-lg btn-primary"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

