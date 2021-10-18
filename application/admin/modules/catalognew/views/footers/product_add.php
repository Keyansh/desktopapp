<style>

    .btn.btn-primary.cloneMinus {

        color: black;
        background: grey !important;
        border-color: grey !important;

    }
    .clone-table td .btn {

        margin: 40px 0 0 0;
        height: 45px;
        outline: none !important;

    }
    .cloneAdd.fixed {
        position: fixed;
        bottom: 147px;
        right: 32px;
        z-index: 1;
    }
    .action-col {
        width: 46px;
    }
</style>
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
                            url: "catalognew/ajax/product/delete",
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
            url: "catalognew/ajax/product/upload"
        });
        
        
        $("#my-dropzone-video").dropzone({
            addRemoveLinks: true,
            init: function () {
                // Hack: Add the dropzone class to the element
                $(this.element).addClass("dropzone");
                this.on("removedfile", function (file) {
                    if (file) {
                        $.ajax({
                            url: "catalognew/ajax/product/deleteVideo",
                            type: "POST",
                            data: {"fileList": file.name}
                        });
                    }
                });
                this.on("addedfile", function (file) {
                    alt = file.alt == undefined ? "" : file.alt;
                    file._captionLabel = Dropzone.createElement("<input type='hidden' name='video[]' value='" + file.name + "' >")
//                    file._captionBox = Dropzone.createElement("<input type='hidden' class='productmain'  name='main[]' value='0' >");
//                    file._captionRadio = Dropzone.createElement("<input type='radio' class='productradio' name='favradio'>");
                    file.previewElement.appendChild(file._captionLabel);
//                    file.previewElement.appendChild(file._captionBox);
//                    file.previewElement.appendChild(file._captionRadio);
                });
                this.on("sending", function (file, xhr, formData) {
//                    formData.append('alt_text', file._captionBox.value);
                });
            },
            url: "catalognew/ajax/product/uploadVideo"
        });
        
        
    });
    $(document).on('click', '.productradio', function () {
        $('.productmain').val('0');
        $(this).prev('.productmain').val('1');
    });
//    function attributes(cid, pid) {
    function attributes(aid, pid, edit) {
//        $.getJSON('catalognew/ajax/product/getcatattr/' + aid + '/' + pid, function (data) {
        $.getJSON('catalognew/ajax/product/getattr_by_atrid/' + aid + '/' + pid, function (data) {
            var ht = '';
            ht += '<table>';
            $.each(data, function (k, v) {
                var assigned_options = v.checked_options;
                var assigned_option_ids = [];
                if(assigned_options){
                    var output = assigned_options.map(function(obj) {
                        return Object.keys(obj).sort().map(function(key) { 
                            assigned_option_ids.push(obj.value);
                        });
                    });
                }
                
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
                if (v.type === 'checkbox') {
                    if ($.isEmptyObject(v[v.type]) == false) {
                        ht += '<div class="form-group clearfix attribute-main-div">';
                        ht += '<div class="col-xs-12 title-attribute">';
                        ht += '<label class="col-sm-2 control-label" style="padding:0">' + v.label + '</label>';
                        ht += '<div class="col-xs-4 search-attribut-div">';
                        ht += '<input type="text" placeholder="Search..." class="form-control input-search-attri">';
                        ht += '</div>';
                       
                        ht += '</div>';
                        ht += '<div class="col-sm-12" style="padding:0">';
                        ht += '<div name="attribute' + v.attr_id + '" class="textfield width_auto" >';
                        $.each(v[v.type], function (i, vv) {
                            ht += "<label class='custom-check'><input type='checkbox' name='attribute" + v.attr_id + "[]' value='" + vv.id + "'";
                            ht += assigned_option_ids.includes(vv.id) ? 'checked' : '';
                            ht += "><span class='box-custom-check'><i class='fa fa-check'></i></span><span class='name'>" + vv.option + "</span></label>";
                        });
                        ht += '</div>';
                        ht += '</div>';
                        ht += '</div>';
                    }
                }
                if (v.type === 'radio') {
                    if ($.isEmptyObject(v[v.type]) == false) {
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

        var count = 0;
        $(document).on('click', '.cloneAdd', function (e) {
            e.preventDefault();
            var flag = true;
            $('.req').each(function (index, obj) {
                
                $(this).removeAttr("style");
                if ($(this).val() == '') {
                    $(this).css('border-color', 'red');
                    flag = false;
                }
            });
            if (flag) {

                count++;
                var clone = $(this).parents('.attribute-table-data').clone();
                $(clone).find('.cloneAdd').remove();
                $(clone).find('.action-col').append('<button type="button" class="btn btn-primary cloneMinus">X</button>');
                $(this).parents('.clone-table').append(clone);
                $(this).parents('.attribute-table-data').find('.cloneMinus').remove();
                $(document).find('.clone-table .attribute-table-data:last-child').find('.sku-field').removeAttr("name").attr('name', 'childsku[' + count + '][]').val("");
                $(document).find('.clone-table .attribute-table-data:last-child').find('.qty-field').removeAttr("name").attr('name', 'childqty[' + count + '][]');
                $(document).find('.clone-table .attribute-table-data:last-child').find('.price-field').removeAttr("name").attr('name', 'childprice[' + count + '][]');
                $(document).find('.clone-table .attribute-table-data:last-child').find('.attr-field').removeAttr("name").attr('name', 'attribute[' + count + '][]');
                $(document).find('.clone-table .attribute-table-data:last-child').find('.option-field').removeAttr("name").attr('name', 'options[' + count + '][]');
                var k = 1;
                $(document).find('.clone-table .attribute-table-data:last-child').find('.option-field').each(function (index, val) {
                    var newCount = count + 1;
                    $(document).find('.clone-table .attribute-table-data:last-child').find(val).removeClass("a1-" + k);
                    $(document).find('.clone-table .attribute-table-data:last-child').find(val).addClass('cuscls');
                    $(document).find('.clone-table .attribute-table-data:last-child').find(val).addClass('a' + newCount + "-" + k);
                    $(document).find('.clone-table .attribute-table-data:last-child').find(val).attr("data-row", newCount + "-" + k);
                    k = k + 1;
                });
            }


        });
        $(document).on('click', '.cloneMinus', function (e) {
            e.preventDefault();
            $(this).parents('.attribute-table-data').remove();
        });
        $(document).on('change', '.cuscls', function () {
            var val = $(this).val();
            var str = $(this).data("row");
            var strArr = str.split("-");
            var row = strArr[0];
            var col = strArr[1];
            var totalOptions = $(document).find('.clone-table .attribute-table-data:last-child').find('.option-field').length;
            totalOptions = parseInt(totalOptions);
            //Get Current Row values
            var x;
            var currentValue = '';
            for (x = 1; x <= totalOptions; x++) {
                currClassname = "a" + row + "-" + x;
                if ($("." + currClassname).length > 0) {
                    var crValue = $('.' + currClassname).val();
                    currentValue += "-" + crValue;
                }
            }
            var rowcount = parseInt(row);
            var i;
            var flag = true
            for (i = rowcount - 1; i >= 0; i--) {
                var j;
                var valStr = '';
                for (j = 1; j <= totalOptions; j++) {
                    classname = "a" + i + "-" + j;
                    if ($("." + classname).length > 0) {
                        var exValue = $('.' + classname).val();
                        valStr += "-" + exValue;
                    }
                }


                if (valStr) {
                    if (currentValue == valStr) {
                        flag = false;
                    }
                }
            }
            $(this).removeAttr("style");
            if (!flag) {
                $(this).css('border-color', 'red');
                $(this).prop('selectedIndex', 0);
            }

        });
        var curCID = $('#category').val();
        $('#categoriesIds').children('option[value="' + curCID + '"]').attr('disabled', 'disabled');
        $(document).on('click', '.saveAttr', function () {
            //alert('1');
            var idSelector = function () {
                return this.value;
            };
            var attrids = $(":checkbox:checked").map(idSelector).get();
            var dataString = 'id=' + attrids;
            if (attrids) {

                $.ajax({
                    type: 'POST',
                    data: dataString,
                    dataType: 'JSON',
                    url: 'catalognew/ajax/product/getAttributeOptions',
                    success: function (data) {
                        if (data.type == '1') {
                            $('.selectedAttrlist').html(data.content);
                        }
                    }
                });
            }


        });

    });
//    $(document).on('change', '#category', function () {
    $(document).on('change', '#attribute_set', function () {
        var attr_id = $(this).val();
        var cat_id = $('#category').val(); //added for cid
        $('#categoriesIds').children('option').removeAttr('disabled');
        $('#categoriesIds').children('option[value="' + cat_id + '"]').attr('disabled', 'disabled');
        attributes(attr_id, getpid());
        editCatId = $(this).attr("data-old");
        if (editCatId != "" && $(this).val() != editCatId) {
            $("#selectedProducts tbody").html("");
        }
        var pdID = '<?php echo isset($product['id']) ? $product['id'] : 0; ?>';
        //alert("catid "+cat_id +" pid" + pdID);      
        $.post(DWS_BASE_URL + 'catalognew/ajax/product/catProduct', {catId: attr_id, PID: pdID}, function (data) {
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
/* if (isset($selChildProducts) && !empty($selChildProducts)) {
  foreach ($selChildProducts as $pdObj) {
  ?>
  jQuery("#rowC-<?php echo $pdObj['pid']; ?>").remove();
  <?php
  }
  //echo '$("#datatable-example").dataTable().draw();';
  } */
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

