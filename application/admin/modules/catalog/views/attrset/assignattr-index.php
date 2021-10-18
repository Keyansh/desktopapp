<!--<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">-->
<!--<link rel="stylesheet" href="/resources/demos/style.css">-->
<style>
    .atributes, .categories, .addattributes{float: left;}
    .atributes h4, .categories h4, .addattributes h4 {margin:20px 0 0 0;font-size:14px;}
    .menulinks, .attrcontainer {list-style-type:none;margin:0;padding:0;margin-bottom:10px; position:relative;float:left;width:170px;border:1px solid #DFDFDF;margin-right:0px;min-height:100px;}
    .menulinks li {margin:5px;padding:5px;width:150px;border:1px solid #ddd;background:#fff;cursor:pointer;}
    .attrcontainer li {margin:5px;padding:5px;width:150px;border:1px solid #ddd;background:#fffa90;cursor:pointer;}
    .remove-attr {float: right;}
    .menulinks li,
    .attrcontainer li {

        width: 98% !important;
        padding-left:10px;

    }
    .attrcontainer li {
        background:white;
        color:#495d80;
    }
    .menulinks, .attrcontainer {
        width: 100%;
    }
    .remove-attr {
        padding-top: 8px;
        font-size: 18px;
        padding-right: 7px;
    }
    .nn-style-btn-padding {
        margin-top: 25px;
    }
    .addattributes {
        float: left;
    }
</style>
<h3 class="title-hero clearfix">
    Assign Attributes to <?= $attrset['name']; ?>
    <a href="catalog/attrset" class="pull-right btn btn-primary">Manage Attribute Set</a>
</h3>

<div class="panel">
    <div class="panel-body">
        <h4 style="margin-bottom: 12px; font-family: Roboto-Medium;">
            Available Attributes
        </h4>
        <!-- <div class="atributes col-xs-6" style="max-height: 480px;overflow: scroll; width:300px"> -->
        <div class="atributes col-xs-6" style="max-height: 480px;overflow: auto; padding-left: 0px;">
            <ul class="menulinks">
                <?= $attributes; ?>
            </ul>
        </div>

        <div class="addattributes col-xs-6" style="padding-right: 0px;">
            <form method="post" action="catalog/attrset/attrassign/<?= $attrset['id']; ?>">
                <div class=""  style="max-height: 480px;overflow: auto;">
                    <ul class="attrcontainer">
                        <?= $assignedattr; ?>
                    </ul>
                </div>
                <div class="clearfix"></div>
                <input  type="submit" value="Assign Attribues" class="btn btn-primary nn-style-btn-padding"/>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script type="text/javascript">



    $(function () {

        $('.remove-attr').click(function () {
            $(this).parent('li').remove();
        });

        $(".menulinks li").draggable({
            connectToSortable: '.attrcontainer',
            helper: 'clone'
//    revertDuration: 0,
//    create: function () {
//var eq = $(this).index();
//$(this).attr('data-index', eq);
//    }
        });

        $(".attrcontainer").sortable({
            connectWith: '.attrcontainer',
            placeholder: "ui-state-highlight",
            receive: function (event, ui) {
                sortableIn = 1;
                var uiIndex = ui.item.attr('data-index');
                var item = $(this).find('[data-index=' + uiIndex + ']');
                if (item.length > 1) {
                    item.last().remove();
                }
            },
            over: function (e, ui) {
                sortableIn = 1;
            },
            out: function (e, ui) {
                sortableIn = 0;
            },
            beforeStop: function (e, ui) {
                if (sortableIn == 0) {
                    ui.item.remove();
                }
            },
            revert: true
        });

        $(".attrcontainer li").draggable({
            connectToSortable: '.attrcontainer',
            placeholder: "ui-state-highlight",
            revert: true
        });
    });

</script>