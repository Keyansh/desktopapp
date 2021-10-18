<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/widgets/datatable/datatable.css">
<script type="text/javascript" src="<?= base_url(); ?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable-tabletools.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>js/bootbox.js"></script>
<script>
    $(document).ready(function () {
        //Initialize tooltips
        $('.nav-tabs > li a[title]').tooltip();

        //Wizard
        $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

            var $target = $(e.target);

            if ($target.parent().hasClass('disabled')) {
                return false;
            }
        });

        $("#userSel").click(function (e) {
            $(".error").hide();
            $.post("order/selectedUser", $("#user-selection").serialize(), function (dataPost) {
                if (dataPost.status == 'error') {
                    $(dataPost.msg.slice(0, -1)).show();
                    return false;
                } else {
                    $('.userAsignProList').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "ajax": {
                            "url": "order/server_side_dt/jsonProducts/",
                            "data": {userid: dataPost.userid, pricelist: dataPost.pricelist, tierprice: dataPost.tierprice},
                            "type": "POST"
                        },
                        "autoWidth": true,
                        "bSort": false,
                        "columnDefs": [
                            {
                                targets: [0, 1, 2, 3, 4],
                                orderable: false
                            },
                            {
                                'targets': [0],
                                'className': 'dt-center',
                                'render': function (data, type, full, meta) {
                                    return '<input type="hidden" name="uid" value="' + dataPost.userid + '" /><input type="hidden" name="pricelist" value="' + dataPost.pricelist + '" /><input type="hidden" name="tierprice" value="' + dataPost.tierprice + '" /><input type="checkbox" name="ids[]" value="' + full[0] + '" class="productSelect"/>';
                                }
                            },
                            {
                                'targets': [1],
                                'className': 'dt-center',
                                'render': function (data, type, full, meta) {
                                    if (data != '' && data != null) {
                                        return '<img src="../upload/products/' + data + '" width="50"/>';
                                    } else {
                                        return '<img src="images/no-image.jpg" width="50"/>';
                                    }
                                }
                            }
                        ],
                        "pageLength": 50
                    });
                    var $active = $('.wizard .nav-tabs li.active');
                    $active.next().removeClass('disabled');
                    nextTab($active);
                    if (dataPost.pricelist == '2') {
                        $('#selectAllCheckBox').html('<input type="checkbox" id="proSelectAll" />');
                    }
//                    $('#loading').show();
//                    $.post("order/ajax/order/userProducts", {userid: data.userid, pricelist: data.pricelist, tierprice: data.tierprice}, function (data1) {
//                        if (data1.status == 'error') {
//                            $(data1.msg.slice(0, -1)).show();
//                            return false;
//                        } else {
//                            $('#loading').hide();
//                            $('#userProList').html(data1.html);
//                            $('#userAsignProList').DataTable({
//                                autoWidth: false,
//                                bSort: false,
//                                columnDefs: [
//                                    {
//                                        targets: [0, 1, 2, 3,4],
//                                        orderable: false
//                                    },
//                                ],
//                                pageLength: 50
//                            });
//
//                            var $active = $('.wizard .nav-tabs li.active');
//                            $active.next().removeClass('disabled');
//                            nextTab($active);
//                        }
//                    }, "json");
                }
            }, "json");
        });

        $("#addSelPro").click(function (e) {
            $(".error").hide();
            $.post("order/selectedProduct", $("#product-selection").serialize(), function (data2) {
                if (data2.status == 'error') {
                    $("html,body").animate({scrollTop: 0}, "slow");
                    $(data2.msg.slice(0, -1)).show();
                    return false;
                } else {
                    var uid = data2.uid;
                    var pricelist = data2.pricelist;
                    var tierprice = data2.tierprice;
                    $.post("order/ajax/order/selectedProducts", {uid: uid, pricelist: pricelist, tierprice: tierprice}, function (data3) {
                        $('#cartProList').html(data3.html);
                        var $active = $('.wizard .nav-tabs li.active');
                        $active.next().removeClass('disabled');
                        nextTab($active);
                    }, "json");
                }
            }, 'json');
        });

        $(document).on('click', '.delprod', function (e) {
            var rowId = $(this).attr('rowid');
            var pricelist = $(this).attr('pricelist');
            var tierprice = $(this).attr('tierprice');
            var uid = $(this).attr('uid');
            bootbox.confirm("Are you sure? You want to delete the product?", function (result) {
                if (result === true) {
                    $.post("cart/delete", {rowId: rowId, pricelist: pricelist, tierprice: tierprice, uid: uid}, function (data4) {
                        $('#cartProList').html(data4.html);
                    }, "json");
                }
            });
        });

        $('#updateCart').on('click', function (e) {
            $.post("cart/update", $("#cartFrm").serialize(), function (data5) {
                if (data5.status == 'success') {
                    bootbox.alert("Cart updated successfully!");
                    $('#cartProList').html(data5.html);
                }
            }, "json");
        });

//        $("#saveContinue").click(function (e) {
//            var uid = $("input[name=uid]").val();
//            $.post("order/ajax/order/checkout", {uid: uid}, function (data6) {
//                $('#checkoutView').html(data6.html);
//                var $active = $('.wizard .nav-tabs li.active');
//                $active.next().removeClass('disabled');
//                nextTab($active);
//            }, "json");
//        });

        $("#saveInform").click(function (e) {
            var uid = $("input[name=uid]").val();
            $.post("order/ajax/order/checkout", {uid: uid}, function (data6) {
                $('#checkoutView').html(data6.html);
                var $active = $('.wizard .nav-tabs li.active');
                $active.next().removeClass('disabled');
                nextTab($active);
            }, "json");
        });
        $(".prev-step").click(function (e) {

            var $active = $('.wizard .nav-tabs li.active');
            prevTab($active);

        });

        $('#newUserAdd').on('click', function () {
            $(".error").hide();
            $.post("user/userAjax", $("#newUserAddform").serialize(), function (data) {
                if (data.status == 'error') {
                    $(data.msg.slice(0, -1)).show();
                    return false;
                } else {
                    $("#newUserAddform")[0].reset();
                    $('#userModal .closeM').trigger('click');
                    setTimeout(function () {
                        $('#userModalthank').modal('show');
                    }, 1000);
                    setTimeout(function () {
                        window.location = window.location;
                    }, 2000);
                }
            }, "json");
        });

        $(document).on('blur', '#globDiscount', function () {
            var disVal = $(this).val();
            if (disVal > 0) {
                $('.disc_textfield').val(disVal);
            }
        });
        $(document).on('change', '#proSelectAll', function () {
            var status = this.checked;
            $('.productSelect').each(function () {
                this.checked = status;
            });
        });
        $(document).on('change', '.productSelect', function () {
            if (this.checked == false) {
                $("#proSelectAll")[0].checked = false;
            }

            if ($('.productSelect:checked').length == $('.productSelect').length) {
                $("#proSelectAll")[0].checked = true;
            }
        });
    });
    function nextTab(elem) {
        $(elem).next().find('a[data-toggle="tab"]').click();
    }
    function prevTab(elem) {
        $(elem).prev().find('a[data-toggle="tab"]').click();
    }
</script>