<link rel="stylesheet" href="<?= base_url(); ?>assets/widgets/dropzone/dropzone.css" />
<script src="<?= base_url() ?>assets/widgets/dropzone/dropzone.js"></script>
<script>
    $(document).ready(function () {
        Dropzone.autoDiscover = false;
        $("#my-dropzone").dropzone({
            addRemoveLinks: true,
            init: function () {
                // Hack: Add the dropzone class to the element
                $(this.element).addClass("dropzone");
                this.on("removedfile", function (file) {
                    if (file) {
                        $.ajax({
                            url: "catalog/ajax/product/delete",
                            type: "POST",
                            data: {"fileList": file.name}
                        });
                    }
                });
                this.on("addedfile", function (file) {
                    alt = file.alt == undefined ? "" : file.alt;
                    file._captionLabel = Dropzone.createElement("<input type='hidden' name='photo[]' value='" + file.name + "' >")
                    file._captionBox = Dropzone.createElement("<input type='hidden' class='productmain'  name='main[]' value='0' >");
                    file._captionRadio = Dropzone.createElement("<input type='radio' class='productradio' name='favradio'>");
                    file.previewElement.appendChild(file._captionLabel);
                    file.previewElement.appendChild(file._captionBox);
                    file.previewElement.appendChild(file._captionRadio);
                });
                this.on("sending", function (file, xhr, formData) {
                    formData.append('alt_text', file._captionBox.value);
                });
            },
            url: "catalog/ajax/product/upload"
        });
    });

    $(document).on('click', '.productradio', function () {
        $('.productmain').val('0');
        $(this).prev('.productmain').val('1');
    });
//    function attributes(cid, pid) {
    function attributes(aid,pid ,edit) {
//        $.getJSON('catalog/ajax/product/getcatattr/' + aid + '/' + pid, function (data) {
        $.getJSON('catalog/ajax/product/getattr_by_atrid/'+ aid + '/' + pid, function (data) {
            var ht = '';
            ht += '<table>';
            $.each(data, function (k, v) {
                if (!v.data) {
                    var attrvalue = '';
                } else {
                    var attrvalue = v.data;
                }
                if (v.type === 'dropdown') {
                    if ($.isEmptyObject(v[v.type]) == false) {
                        ht += '<div class="form-group clearfix">';
                        ht += '<label class="col-sm-2 control-label">' + v.label + '</label>';
                        ht += '<div class="col-sm-6">';
                        ht += '<select class="form-control" name="attribute' + v.attr_id + '" class="textfield width_auto" >';
                        ht += '<option value="">Select</optio>';
                        $.each(v[v.type], function (i, vv) {
                            ht += "<option value='" + vv.id + "'";
                            ht += attrvalue == vv.id ? 'selected' : '';
                            ht += ">" + vv.option + "</option>";
                        });
                        ht += '</select>';
                        ht += '</div>';
                        ht += '</div>';
                    }
                }
                if (v.type === 'radio') {
                    if ($.isEmptyObject(v[v.type]) == false) {
//                        ht += '<div class="form-group clearfix">';
//                        ht += '<label class="col-sm-2 control-label">' + v.label + '</label>';
//                        ht += '<div class="col-sm-6">';
//                        $.each(v[v.type], function (i, vv) {
//                            ht += '<label class="control-label" > <input ';
//                            ht += attrvalue == vv.id ? 'checked' : '';
//                            ht += ' type="radio" name="' + v.name + '" value="' + vv.id + '"> ' + vv.option + ' </label>';
//                        });
//                        ht += '</div>';
//                        ht += '</div>';
                          ht += '<div class="form-group clearfix">';
                        ht += '<label class="col-sm-2 control-label">' + v.label + '</label>';
                        ht += '<div class="col-sm-6">';
                        ht += '<select class="form-control" name="attribute' + v.attr_id + '" class="textfield width_auto" >';
                        ht += '<option value=" ">Select</optio>';
                        $.each(v[v.type], function (i, vv) {
                            ht += "<option value='" + vv.id + "'";
                            ht += attrvalue == vv.id ? 'selected' : '';
                            ht += ">" + vv.option + "</option>";
                        });
                        ht += '</select>';
                        ht += '</div>';
                        ht += '</div>';
                    }
                }
                if (v.type === 'varchar') {
                    ht += '<div class="form-group clearfix">';
                    ht += '<label class="col-sm-2 control-label">' + v.label + '</label>';
                    ht += '<div class="col-sm-6">';
                    ht += '<input class="form-control" value="' + attrvalue + '" type="text" name="' + v.name + '">';
                    ht += '</div>';
                    ht += '</div>';
                }
                if (v.type === 'text') {
                    ht += '<div class="form-group clearfix">';
                    ht += '<label class="col-sm-2 control-label">' + v.label + '</label>';
                    ht += '<div class="col-sm-6">';
                    ht += '<textarea  name="' + v.name + '" >' + attrvalue + '</textarea>';
                    ht += '</div>';
                    ht += '</div>';
                }
            }
            );
            ht += '</table>';
            $('.attradd').html(ht);
            
        });
    }


    function getpid() {
        var newstr;
        if (typeof (DWS_PRODUCT) == 'undefined') {
            newstr = '';
        } else {
            newstr = DWS_PRODUCT;
        }
        return newstr;
    }

    $("#cateAttributesID").on('change', '.att-chkbx', function (e) {
        if ($("#selectedProducts tbody tr").length > 0) {
//            $("#errorMessageDiv").html("Please remove the selected products to select/unselect other attributes.").show().delay(5000).fadeOut();
//            if ($(this).is(":checked")) {
//                $(this).attr("checked", false);
//            } else {
                $(this).attr("checked", true);
//            }

            //e.preventDefault();
            //e.stopPropagation();
            return false;
        }


    });

    var table = $('#example').DataTable({
        autoWidth: true,
        columnDefs: [
            {
                targets: [0, 1, 2, 3, 4],
                orderable: false
            },
            {"width": "10px", "targets": 0},
        ],
        pageLength: 20
    });

    $(document).ready(function () {
        var curCID = $('#category').val();
        $('#categoriesIds').children('option[value="' + curCID + '"]').attr('disabled', 'disabled');
    });
    
//    $(document).on('change', '#category', function () {
    $(document).on('change', '#attribute_set', function () {
        var attr_id = $(this).val();
        var cat_id =  $('#category').val(); //added for cid
        $('#categoriesIds').children('option').removeAttr('disabled');
        $('#categoriesIds').children('option[value="' + cat_id + '"]').attr('disabled', 'disabled');
        attributes(attr_id,getpid());
        editCatId = $(this).attr("data-old");
        if (editCatId != "" && $(this).val() != editCatId) {
            $("#selectedProducts tbody").html("");
        }
        var pdID = '<?php echo isset($product['id']) ? $product['id'] : 0; ?>';
        //alert("catid "+cat_id +" pid" + pdID);      
        $.post(DWS_BASE_URL + 'catalog/ajax/product/catProduct', {catId: attr_id, PID: pdID}, function (data) {
            console.log(data.status1);
            console.log(data.catAttributes);
            if (data.status1 == 1) {
                $(".cateAttributes").html(data.catAttributes);
            }
            if (data.status2 == 1) {
                $(".childprod").html(data.product);
                var x = 0;
                $('#example thead tr#filterrow th').each(function () {
                    x++;
                    var title = $('#example thead th').eq($(this).index()).text();
                    if ((x != 4) && (x != 5) && (x != 6) && (x != 3)) {
                        $(this).html('<input type="text" onclick="stopPropagationInner(event);" placeholder="Search ' + title + '" class="form-control"/>');
                    }
                });
                var table = $('#example').DataTable({
                    autoWidth: true,
                    columnDefs: [
                        {
                            targets: [0, 1, 2, 3, 4],
                            orderable: false
                        },
                        {"width": "10px", "targets": 0},
                    ],
                    pageLength: 20
                });
                // Apply the filter
                $("#example thead input").on('keyup change', function () {
                    table
                            .column($(this).parent().index() + ':visible')
                            .search(this.value)
                            .draw();
                });
<?php
/*if (isset($selChildProducts) && !empty($selChildProducts)) {
    foreach ($selChildProducts as $pdObj) {
        ?>
                        jQuery("#rowC-<?php echo $pdObj['pid']; ?>").remove();
        <?php
    }
    //echo '$("#datatable-example").dataTable().draw();';
}*/
?>
            }
        }, 'json');
    });
    function stopPropagationInner(evt) {
        if (evt.stopPropagation !== undefined) {
            evt.stopPropagation();
        } else {
            evt.cancelBubble = true;
        }

    }
   <?php /* function checkAttribute(data) {
        var labelVal = $(data).attr('data-label');
        var val = $(data).attr('data-value');
        var selectedAttIDs = val.split(",");
        var checkedIDs = $("#cateAttributesID input:checkbox:checked").map(function () {
            return $(this).val();
        }).get();
        //console.log(selectedAttIDs);
        //console.log(checkedIDs);
        var diff = [];
        if (selectedAttIDs.length >= checkedIDs.length) {
            diff = selectedAttIDs.filter(function (x) {
                return checkedIDs.indexOf(x) < 0
            });
        }
        else {
            diff = checkedIDs.filter(function (x) {
                return selectedAttIDs.indexOf(x) < 0
            });
        }
        if (diff.length > 0) {
            $("#errorMessageDiv").html("<strong>Cannot add this!</strong> Some of the attributes are not assigned to this product.").show().delay(5000).fadeOut();
        }
        else {
            var json = $(data).parents("tr").attr('data-obj');
            var $pdObj = JSON.parse(json);

            var proDucts = "<tr data-obj='" + json + "'>";
            proDucts += '<td>' + $pdObj.sku + '</td>';
            proDucts += '<td>' + $pdObj.name + '</td>';
            proDucts += '<td>' + $pdObj.price + '</td>';
            proDucts += '<td>' + $pdObj.quantity + '<input type="hidden" name="assign_product[]" value="' + $pdObj.id + '"></td>';
            proDucts += '<td><button type="button" class="btn btn-primary removeSelectedPrd" type="button">Remove</button></td>';
            proDucts += '</tr>';
            jQuery("#selectedProducts").append(proDucts);
            $(data).parents("tr").remove();
            selected_products.push($pdObj.id);
            /*$("#example").fnClearTable( 0 );
             $("#example").fnDraw();
             */
            //alert(TabelData);

            /* $("#datatable-example").dataTable().draw();

        }
        /*$.ajax({
         method: "POST",
         url: "some.php",
         data: { name: "John", location: "Boston" }
         }).done(function( msg ) {
         alert( "Data Saved: " + msg );
         });*/

        /*var difference = arr_diff(checkedIDs,selectedAttIDs);
         console.log(difference);*/

    /*}*/ ?>
    function arr_diff(a1, a2) {

        var a = [], diff = [];

        for (var i = 0; i < a1.length; i++) {
            a[a1[i]] = true;
        }

        for (var i = 0; i < a2.length; i++) {
            if (a[a2[i]]) {
                delete a[a2[i]];
            } else {
                a[a2[i]] = true;
            }
        }
        for (var k in a) {
            diff.push(k);
        }
        return diff;
    }

</script>
