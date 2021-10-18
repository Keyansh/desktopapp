<!--
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/interactions-ui/resizable.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/interactions-ui/draggable.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/interactions-ui/sortable.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/interactions-ui/selectable.js"></script>

<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/nestable/nestable.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/nestable/nestable-demo.js"></script>

<script type="text/javascript">
    $(function () {
        "use strict";
        $(".sortable-elements").sortable();

        "use strict";
        $(".column-sort").sortable({
            connectWith: ".column-sort"
        });
    });
</script>-->

<h3 class="title-hero clearfix">
    Manage Categories
    <a href="catalog/category/add/" class="pull-right btn btn-primary">Add Category</a>
</h3>
<?php
$this->load->view('inc-messages');
if (count($categories) == 0) {
    $this->load->view('inc-norecords');
    echo "</div>";
    return;
}
?>
<div class="panel">
    <div class="panel-body">
        <div class="example-box-wrapper">
            <!--            <menu id="nestable-menu">
                            <button type="button" class="btn btn-default" data-action="expand-all">Expand All</button>
                            <button type="button" class="btn btn-blue-alt" data-action="collapse-all">Collapse All</button>
                        </menu>-->

            <div class="cf clearfix nestable-lists">
                <div class="row">
                    <div class="col-md-12">
                        <div class="dd" id="nestable">
                            <?php echo $categorytree; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>