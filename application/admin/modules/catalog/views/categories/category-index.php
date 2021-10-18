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
<style>
    #expandAll {
        background: #495d80;
        color: black;
        height: 33px;
    }
    .minimizeBtn {
        float: left;
        background: 0 0;
        border: none;
        box-shadow: none;
        font-size: 16px;
        position: relative;
        top: -2px;
    }
    .categorySearch {
        background: #f9f9f9;
        width: 100%;
        float: right;
        margin-top: -47px;
        max-width: 48%;
    }
</style>

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
            <menu id="nestable-menu">
                <button type="button" class="btn btn-default nn-style-col-btn-style" id="expandAll" data-action="expand-all">Expand All</button>
            </menu>

            <div class="categorySearch">
                <input type="text" class="form-control categorySearchField" id="categorySearchField" placeholder="Search category..."/>
            </div>

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


<script>
    $(document).ready(function () {

        $("#categorySearchField").on("keyup", function () {

            $.ajax({
                url: "<?php echo base_url(); ?>catalog/category/categoryFilter",
                type: 'POST',
                data: {keyword: $(this).val()},
                success: function (result) {

                    $('#nestable').html(result);

                    if ($("#categorySearchField").val() == '') {

                        $(document).find('#pagetree > li > ul').addClass('ui-sortable');

                        var sibList = $(document).find('#pagetree > li > ul').prev('.page_item').find('.page_item_name');
                        var appendBtn = "<button type='button' class='minimizeBtn'>+</b>";
                        $(document).find(sibList).append(appendBtn);

                        $('.minimizeBtn').click(function () {
                            $(this).parents('.page_item').siblings('ul').toggleClass('showTree');
                            if ($(this).text() == '+') {
                                $(this).text('-');
                            } else {
                                $(this).text('+');
                            }
                        });

                        $('#expandAll').click(function () {
                            $('.minimizeBtn').text('-');
                            if ($(this).text() == 'Expand All') {
                                $('.page_item + ul').addClass('showTree');
                                $(this).text('Collapse All');
                            } else {
                                $('.page_item + ul').removeClass('showTree');
                                $('.minimizeBtn').text('+');
                                $(this).text('Expand All');
                            }
                        });
                    }

                }
            });
        });
    });
</script>
<script>
    $(document).ready(function () {

        var sibList = $('.ui-sortable').siblings('.page_item').find('.page_item_name');
        var appendBtn = "<button type='button' class='minimizeBtn'>+</b>";
        $(sibList).append(appendBtn);

        $('.minimizeBtn').click(function () {
            // alert('dsad');
            $(this).parents('.page_item').siblings('.ui-sortable').toggleClass('showTree');
            if ($(this).text() == '+') {
                $(this).text('-');
            } else {
                $(this).text('+');
            }

        });

        $('#expandAll').click(function () {

            $('.minimizeBtn').text('-');

            if ($(this).text() == 'Expand All') {
                $('.page_item + .ui-sortable').addClass('showTree');
                $(this).text('Collapse All');
            } else {
                $('.page_item + .ui-sortable').removeClass('showTree');
                $('.minimizeBtn').text('+');
                $(this).text('Expand All');
            }

        });


    })
</script>
