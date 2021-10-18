$(document).ready(function() {

    $("#pagetree").bind("loaded.jstree", function(event, data) {
        $("#pagetree").jstree("open_all");
    });
    $("#pagetree").bind("refresh.jstree", function(event, data) {
        $("#pagetree").jstree("open_all");
    });

    $("#pagetree").bind("move_node.jstree", function(event, data) {
        //alert(data.args);
        var obj = jQuery.jstree._reference('#pagetree')._get_move();
        var page_id = obj.o.attr('rel');
        var sort_order = obj.cp;

        $.post('pageajax/sortorder/' + page_id, {sort_order: sort_order}, function(data) {
            jQuery.jstree._reference('#pagetree').refresh();
        }, "html");
    });



    $("#pagetree").jstree({
        "core": {
            "html_titles": true,
            "animation": 100
        },
        "html_data": {
            "ajax": {
                "url": DWS_BASE_URL + "pageajax/index/",
                "data": function(n) {
                    return {};
                }
            }
        },
        "themes": {
            "theme": "default",
            "icons": false,
            "dots": true
        },
        "crrm": {
            "move": {
                "check_move": function(m) {
                    var p = this._get_parent(m.o);
                    if (!p)
                        return false;
                    p = p == -1 ? this.get_container() : p;
                    if (p === m.np)
                        return true;
                    if (p[0] && m.np[0] && p[0] === m.np[0])
                        return true;
                    return false;
                }
            }
        },
        "dnd": {
            "drop_finish": function(data) {
                alert("Droped: " + data.o.attr('rel') + " on node: " + data.r.attr('id'));
            }
        },
        "plugins": ["themes", "html_data", "crrm", "dnd", "cookies"]
    });
});