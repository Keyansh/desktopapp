<div class="col-md-12">

    <div class="content-box">
        <div class="mail-header clearfix row">
            <div class="col-md-8">
                <span class="mail-title">Profile: <?php echo $userprofile['first_name'] . " " . $userprofile['last_name']; ?></span>
            </div>
            <div class="col-md-4 text-right">
                <a href="user/" class="pull-right btn btn-primary">Manage Users</a>
            </div>
        </div>
    </div>
    <?php if ($profileconfig['type']) {?>
        <div class="example-box-wrapper">
            <ul class="list-group row list-group-icons">
                <?php
if (isset($profileconfig['configVars']['CREDIT'])) {
    ?>
                    <li class="col-md-4 active">
                        <a href="#tab-example-1" data-toggle="tab" class="list-group-item">
                            <i class="glyph-icon font-red icon-bullhorn"></i>
                            Credit
                        </a>
                    </li>
                <?php }?>
                <?php
if (isset($profileconfig['configVars']['MULTILOGIN'])) {
    ?>
                    <li class="col-md-4">
                        <a href="#tab-example-2" data-toggle="tab" class="list-group-item">
                            <i class="glyph-icon icon-dashboard"></i>
                            Multiple Logins
                        </a>
                    </li>
                <?php }?>
                <?php
if (isset($profileconfig['configVars']['MULTIDELADDRESS'])) {
    ?>
                    <li class="col-md-4">
                        <a href="#tab-example-3" data-toggle="tab" class="list-group-item">
                            <i class="glyph-icon font-primary icon-camera"></i>
                            Multiple Address
                        </a>
                    </li>
                <?php }?>
            </ul>
            <div class="tab-content">
                <?php
if (isset($profileconfig['configVars']['CREDIT'])) {
    ?>
                    <div class="tab-pane fade active in" id="tab-example-1">
                        <div class="col-md-12">
                            <div class="alert alert-success" id="creditassignmsg" style="display:none;"></div>
                        </div>

                        <div class="row">
                            <form action="" method="post" id="creditForm" name="creditForm">
                                <input type="hidden" name="user_id" id="user_id" value="<?php echo $userprofile['user_id']; ?>" />
                                <div class="col-md-12">
                                <div class="form-group clearfix">
                                    <label class="col-sm-3 control-label">Credit Limit</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="creditlimit" name="creditlimit" placeholder="Credit Limit" >
                                        <span class="custerror"></span>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-3 control-label">Can order above limit?</label>
                                    <div class="col-sm-6">
                                        <select name="limit_over" id="limit_over" class="form-control">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                        <span class="custerror"></span>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-sm-3 control-label">Credit Days</label>
                                    <div class="col-sm-6">
                                       <div class="input-prepend input-group">
                                        <span class="add-on input-group-addon">
                                            <i class="glyph-icon icon-calendar"></i>
                                        </span>
                                        <input type="text" name="daterangepicker-example" id="daterangepicker-example" class="form-control" value="">
                                        <span class="custerror"></span>
                                    </div>
                                    </div>
                                </div>

                                <!--<div class="form-group clearfix">
                                    <label class="col-sm-3 control-label">Notification of credit use after?</label>
                                    <div class="col-sm-6">
                                        <select name="notification" class="form-control">
                                            <option value="25">25%</option>
                                            <option value="50">50%</option>
                                            <option value="100">100%</option>
                                        </select>
                                        <span class="custerror"></span>
                                    </div>
                                </div>-->
                                    <div class="col-sm-12 center-content">
                                        <button type="submit" id="submitcredit" class="btn btn-primary">Save</button>
                                    </div>
                            </div>
                            </form>
                        </div>

                        <div class="row" style="margin-top:30px;">
                            <h3>Credit Assigned</h3>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th width="33%">Credit Limit</th>
                                        <th width="33%">Can order above limit?</th>
                                        <th width="33%">Credit Days</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
if ($assginedCredit) {
        foreach ($assginedCredit as $assignLIst) {
            ?>
                                        <tr>
                                            <td><?php echo $assignLIst['credit_limit']; ?></td>
                                            <td><?=($assignLIst['order_above_limit']) ? 'Yes' : 'No';?></td>
                                            <td class="center"><?php echo date('d/m/Y', strtotime($assignLIst['credit_startdate'])) . " - " . date('d/m/Y', strtotime($assignLIst['credit_lastdate'])); ?></td>
                                        </tr>
                                        <?php
}
    } else {?>
                                        <tr>
                                            <td colspan="3"><strong>No record found!</strong></td>
                                        </tr>
                                    <?php }
    ?>

                                </tbody>
                                </table>
                        </div>

                    </div>
                <?php }?>
                <?php
if (isset($profileconfig['configVars']['MULTILOGIN'])) {
    ?>
                    <div class="tab-pane fade" id="tab-example-2">
                        <div class="row">
                            <div class="example-box-wrapper">
                                <div class="alert alert-success" id="multiloginmsg" style="display:none;">

                                </div>
                                <div>
                                    <button class="btn btn-primary btn-md" id="multiloginajax">
                                        Add New
                                    </button>
                                </div>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th width="5%">#</th>
                                            <th width="20%">Full name</th>
                                            <th width="20%">Username</th>
                                            <th width="20%">Email</th>
                                            <th width="20%">Company Name</th>
                                            <th width="15%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
if ($logins) {
        foreach ($logins as $list) {
            ?>
                                                <tr id="row-<?php echo $list['user_id']; ?>">
                                                    <td><?php echo $list['user_id']; ?></td>
                                                    <td><?php echo $list['first_name'] . " " . $list['last_name']; ?></td>
                                                    <td><?php echo $list['username']; ?></td>
                                                    <td><?php echo $list['email']; ?></td>
                                                    <td><?php echo $list['company_name']; ?></td>
                                                    <td class="center">
                                                        <a href="javascript:void(0)" id="<?php echo $list['user_id']; ?>" class="editlogin">Edit</a> | <a href="javascript:void(0)" id="<?php echo $list['user_id']; ?>" class="dellogin">Delete</a>
                                                    </td>
                                                </tr>
                                                <?php
}
    } else {
        ?>
                                            <tr>
                                                <td colspan="6" class="center"><strong>No record found!</strong></td>
                                            </tr>
                                        <?php }
    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php }?>
                <?php
if (isset($profileconfig['configVars']['MULTIDELADDRESS'])) {
    ?>
                    <div class="tab-pane fade" id="tab-example-3">
                        <div class="row">
                            <div class="example-box-wrapper">
                                <div class="alert alert-success" id="multiaddressmsg" style="display:none;">

                                </div>
                                <div>
                                    <button class="btn btn-primary btn-md" id="multiaddressajax">
                                        Add New
                                    </button>
                                </div>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th width="20%">City</th>
                                            <th width="20%">County</th>
                                            <th width="20%">Country</th>
                                            <th width="15%">Phone</th>
                                            <th width="13%">Postcode</th>
                                            <th width="12%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
if ($logins) {
        foreach ($address as $addresslist) {
            ?>
                                                <tr id="row1-<?php echo $addresslist['user_address_id']; ?>">
                                                    <td><?php echo $addresslist['uadd_city']; ?></td>
                                                    <td><?php echo $addresslist['uadd_county']; ?></td>
                                                    <td><?php echo $addresslist['uadd_country']; ?></td>
                                                    <td><?php echo $addresslist['uadd_phone']; ?></td>
                                                    <td><?php echo $addresslist['uadd_post_code']; ?></td>
                                                    <td class="center">
                                                        <a href="javascript:void(0)" id="<?php echo $addresslist['user_address_id']; ?>" class="editmultiaddress">Edit</a> | <a href="javascript:void(0)" id="<?php echo $addresslist['user_address_id']; ?>" class="deladdrss">Delete</a>
                                                    </td>
                                                </tr>
                                                <?php
}
    } else {
        ?>
                                            <tr>
                                                <td colspan="6" class="center"><strong>No record found!</strong></td>
                                            </tr>
                                        <?php }
    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php }?>
            </div>
        </div>
    <?php }?>
</div>
<!--- Model to add new user -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><strong><?php echo $userprofile['first_name'] . " " . $userprofile['last_name']; ?></strong> >> New Login</h4>
                <div class="alert alert-success msg-success" style="display:none;">
                    <strong>Success!</strong> User successfully created.
                </div>
            </div>
            <form action="" method="post" name="myform" id="myform">
                <input type="hidden" name="user_id" id="user_id" value="<?php echo $userprofile['user_id']; ?>" />
                <input type="hidden" name="profile_id" id="profile_id" value="<?php echo $userprofile['profile_id']; ?>" />
                <div class="modal-body addNewUser">

                </div>

                <div class="modal-footer">
                    <button type="submit" id="save" value="1" class="btn btn-primary">Save</button>
                    <!--<button type="submit" id="saveandclose" value="2" class="btn btn-primary">Save & Close</button>-->
                </div>
            </form>
        </div>
    </div>
</div>
<!------ End here ---->

<!--- Model to Update new user -->
<div class="modal fade" id="myModalUserEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><strong>Update User</strong></h4>
                <div class="alert alert-success msg-success" style="display:none;">
                    <strong>Success!</strong> User successfully Updated.
                </div>
            </div>
            <form action="" method="post" name="userEditForm" id="userEditForm">
                <input type="hidden" name="user_id" id="user_id" value="<?php echo $userprofile['user_id']; ?>" />
                <input type="hidden" name="profile_id" id="profile_id" value="<?php echo $userprofile['profile_id']; ?>" />
                <div class="modal-body editsubuser">

                </div>
                <div class="modal-footer">
                    <button type="submit" id="UserEditsave" value="1" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- End -->


<!--- Model to add new Address -->
<div class="modal fade" id="myModalAddress" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><strong><?php echo $userprofile['first_name'] . " " . $userprofile['last_name']; ?></strong> >> New Address</h4>
                <div class="alert alert-success msg-success" style="display:none;">
                    <strong>Success!</strong> Address successfully created.
                </div>
            </div>
            <form action="" method="post" name="myformAddress" id="myformAddress">
                <input type="hidden" name="user_id" id="user_id" value="<?php echo $userprofile['user_id']; ?>" />
                <div class="modal-body modal-new-address">

                </div>

                <div class="modal-footer">
                    <button type="submit" id="save" value="1" class="btn btn-primary">Save</button>
                    <!--<button type="submit" id="saveandclose" value="2" class="btn btn-primary">Save & Close</button>-->
                </div>
            </form>
        </div>
    </div>
</div>
<!--- End --->

<!--- Model to Edit Address -->
<div class="modal fade" id="myModalEditAddress" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><strong>Update Address</strong></h4>
                <div class="alert alert-success msg-success" style="display:none;">
                    <strong>Success!</strong> Address successfully Updated.
                </div>
            </div>
            <form action="" method="post" name="myformAddressEdit" id="myformAddressEdit">
                <input type="hidden" name="user_id" id="user_id" value="<?php echo $userprofile['user_id']; ?>" />
                <div class="modal-body modal-new-address-edit">

                </div>

                <div class="modal-footer">
                    <button type="submit" id="addressEditsave" value="1" class="btn btn-primary">Save</button>
                    <!--<button type="submit" id="saveandclose" value="2" class="btn btn-primary">Save & Close</button>-->
                </div>
            </form>
        </div>
    </div>
</div>


<script type="text/javascript">

    $(document).ready(function (e) {

        $("#multiloginajax").click(function () {
            $.ajax({
                url: "<?php echo base_url() ?>user/addSubUserAjax",
                type: "POST",
                dataType: "json",
                data: $('#myform').serialize(),
                success: function (data) {
                    if (data.response == 'false') {
                        console.log('Not loaded');
                        //console.log(data.errors);
                    } else {
                        $(".addNewUser").html(data.userhtml);
                        $('#myModal').modal('show');
                    }
                },
                error: function (error) {
                    console.log("Error:");
                    console.log(error);
                }
            });

        });

        $('.editlogin').click(function () {
            var id = $(this).attr("id");
            $.ajax({
                url: "<?php echo base_url() ?>user/editSubUser",
                type: "POST",
                dataType: "json",
                data: "id=" + id,
                success: function (data) {
                    if (data.type == 'false') {
                        console.log('Error Found');
                    } else {
                        $(".editsubuser").html(data.userhtml);
                        $('#myModalUserEdit').modal('show');

                    }
                },
                error: function (error) {
                    console.log("Error:");
                    console.log(error);
                }
            });

        });

        $('#myform').submit(function (ev) {
            ev.preventDefault();
            $.ajax({
                url: "<?php echo base_url() ?>user/addSubUser",
                type: "POST",
                dataType: "json",
                data: $('#myform').serialize(),
                success: function (data) {
                    if (data.response == 'false') {
                        $.each(data.customerror, function (key, val) {
                            //console.log(key+val);
                            $(".msg-success").hide();
                            if (val == '') {
                                $('#' + key).closest(".form-group").removeClass("has-error");
                                $('#' + key).next(".custerror").html("").hide();
                            } else {
                                $('#' + key).closest(".form-group").addClass("has-error");
                                $('#' + key).next(".custerror").html(val).show();
                            }

                        });
                        //console.log(data.errors);
                    } else {
                        $(".form-group").removeClass("has-error");
                        $(".custerror").html("").hide();
                        $(".msg-success").show();
                        $('#myform')[0].reset();
                        setTimeout(
                                function ()
                                {
                                    $(".close").trigger("click");
                                    location.reload();
                                }, 2000);
                        //window.location.reload();
                    }
                },
                error: function (error) {
                    console.log("Error:");
                    console.log(error);
                }
            });
        });

        $('#userEditForm').submit(function (ev) {
            ev.preventDefault();
            $.ajax({
                url: "<?php echo base_url() ?>user/modifySubUser",
                type: "POST",
                dataType: "json",
                data: $('#userEditForm').serialize(),
                success: function (data) {
                    if (data.response == 'false') {
                        $.each(data.customerror, function (key, val) {
                            console.log(key + val);
                            $(".msg-success").hide();
                            if (val == '') {
                                $('#' + key).closest(".form-group").removeClass("has-error");
                                $('#' + key).next(".custerror").html("").hide();
                            } else {
                                $('#' + key).closest(".form-group").addClass("has-error");
                                $('#' + key).next(".custerror").html(val).show();
                            }

                        });
                        //console.log(data.errors);
                    } else {
                        $(".form-group").removeClass("has-error");
                        $(".custerror").html("").hide();
                        $(".msg-success").show();
                        $('#userEditForm')[0].reset();
                        setTimeout(
                                function ()
                                {
                                    $(".close").trigger("click");
                                    location.reload();
                                }, 2000);
                        //window.location.reload();
                    }
                },
                error: function (error) {
                    console.log("Error:");
                    console.log(error);
                }
            });
        });

        $('.dellogin').click(function () {
            var id = $(this).attr("id");
            if (confirm("Are you sure you want to delete this?")) {
                $.ajax({
                    url: "<?php echo base_url() ?>user/delSubUser",
                    type: "POST",
                    dataType: "json",
                    data: "id=" + id,
                    success: function (data) {
                        if (data.type == 'false') {
                            console.log('Error Found');
                        } else {
                            $("#multiloginmsg").html(data.msg).show().delay(5000).fadeOut();
                            $("table tr#row-" + data.rowid).remove();
                        }
                    },
                    error: function (error) {
                        console.log("Error:");
                        console.log(error);
                    }
                });
            } else {
                return false;
            }
        });



        $("#multiaddressajax").click(function () {
            $.ajax({
                url: "<?php echo base_url() ?>user/addAddressAjax",
                type: "POST",
                dataType: "json",
                data: "",
                success: function (data) {
                    if (data.response == 'false') {
                        console.log('Not loaded');
                        //console.log(data.errors);
                    } else {
                        $(".modal-new-address").html(data.userhtml);
                        $('#myModalAddress').modal('show');
                    }
                },
                error: function (error) {
                    console.log("Error:");
                    console.log(error);
                }
            });

        });

        $('.editmultiaddress').click(function () {
            var id = $(this).attr("id");
            $.ajax({
                url: "<?php echo base_url() ?>user/getAddressAjax",
                type: "POST",
                dataType: "json",
                data: "id=" + id,
                success: function (data) {
                    if (data.type == 'false') {
                        console.log('Error Found');
                    } else {
                        $(".modal-new-address-edit").html(data.userhtml);
                        $('#myModalEditAddress').modal('show');

                    }
                },
                error: function (error) {
                    console.log("Error:");
                    console.log(error);
                }
            });

        });

        $('#myformAddress').submit(function (ev) {
            ev.preventDefault();
            $.ajax({
                url: "<?php echo base_url() ?>user/addUserAddress",
                type: "POST",
                dataType: "json",
                data: $('#myformAddress').serialize(),
                success: function (data) {
                    if (data.response == 'false') {
                        $.each(data.customerror, function (key, val) {
                            //console.log(key+val);
                            $(".msg-success").hide();
                            if (val == '') {
                                $('#' + key).closest(".form-group").removeClass("has-error");
                                $('#' + key).next(".custerror").html("").hide();
                            } else {
                                $('#' + key).closest(".form-group").addClass("has-error");
                                $('#' + key).next(".custerror").html(val).show();
                            }

                        });
                        //console.log(data.errors);
                    } else {
                        $(".form-group").removeClass("has-error");
                        $(".custerror").html("").hide();
                        $(".msg-success").show();
                        $('#myformAddress')[0].reset();
                        setTimeout(
                                function ()
                                {
                                    $(".close").trigger("click");
                                    location.reload();
                                }, 2000);
                        //window.location.reload();
                    }
                },
                error: function (error) {
                    console.log("Error:");
                    console.log(error);
                }
            });
        });

        $('#myformAddressEdit').submit(function (ev) {
            ev.preventDefault();
            $.ajax({
                url: "<?php echo base_url() ?>user/updateUserAddress",
                type: "POST",
                dataType: "json",
                data: $('#myformAddressEdit').serialize(),
                success: function (data) {
                    if (data.response == 'false') {
                        $.each(data.customerror, function (key, val) {
                            //console.log(key+val);
                            $(".msg-success").hide();
                            if (val == '') {
                                $('#' + key).closest(".form-group").removeClass("has-error");
                                $('#' + key).next(".custerror").html("").hide();
                            } else {
                                $('#' + key).closest(".form-group").addClass("has-error");
                                $('#' + key).next(".custerror").html(val).show();
                            }

                        });
                        //console.log(data.errors);
                    } else {
                        $(".form-group").removeClass("has-error");
                        $(".custerror").html("").hide();
                        $(".msg-success").show();
                        $('#myformAddressEdit')[0].reset();
                        setTimeout(
                                function ()
                                {
                                    $(".close").trigger("click");
                                    location.reload();
                                }, 2000);
                        //window.location.reload();
                    }
                },
                error: function (error) {
                    console.log("Error:");
                    console.log(error);
                }
            });
        });

        $('.deladdrss').click(function () {
            var id = $(this).attr("id");
            if (confirm("Are you sure you want to delete this?")) {
                $.ajax({
                    url: "<?php echo base_url() ?>user/delMultiAddress",
                    type: "POST",
                    dataType: "json",
                    data: "id=" + id,
                    success: function (data) {
                        if (data.type == 'false') {
                            console.log('Error Found');
                        } else {
                            $("#multiaddressmsg").html(data.msg).show().delay(5000).fadeOut();
                            $("table tr#row1-" + data.rowid).remove();
                        }
                    },
                    error: function (error) {
                        console.log("Error:");
                        console.log(error);
                    }
                });
            } else {
                return false;
            }
        });

        $('#creditForm').submit(function(e){
            e.preventDefault();
            $.ajax({
                url: "<?php echo base_url() ?>user/assignCredit",
                type: "POST",
                dataType: "json",
                data: $('#creditForm').serialize(),
                success: function (data) {
                    if (data.response == 'false') {
                        $.each(data.customerror, function (key, val) {
                            //console.log(key+val);
                            $(".msg-success").hide();
                            if (val == '') {
                                $('#' + key).closest(".form-group").removeClass("has-error");
                                $('#' + key).next(".custerror").html("").hide();
                            } else {
                                $('#' + key).closest(".form-group").addClass("has-error");
                                $('#' + key).next(".custerror").html(val).show();
                            }

                        });
                        //console.log(data.errors);
                    } else {
                        $("#creditassignmsg").html(data.msg).show().delay(5000).fadeOut();
                        $('#creditForm')[0].reset();
                        setTimeout(
                            function ()
                            {
                                location.reload();
                            }, 2000);
                    }
                },
                error: function (error) {
                    console.log("Error:");
                    console.log(error);
                }
            });
        });

    });

</script>


<!-- Bootstrap Datepicker -->

<!--<link rel="stylesheet" type="text/css" href="../../assets/widgets/datepicker/datepicker.css">-->
<script type="text/javascript" src="<?php echo base_url() ?>assets/widgets/datepicker/datepicker.js"></script>
<script type="text/javascript">
    /* Datepicker bootstrap */

    $(function() { "use strict";
        $('.bootstrap-datepicker').bsdatepicker({
            format: 'dd-mm-yyyy'
        });
    });

</script>

<!-- jQueryUI Datepicker -->

<!--<link rel="stylesheet" type="text/css" href="../../assets/widgets/datepicker-ui/datepicker.css">-->
<script type="text/javascript" src="<?php echo base_url() ?>assets/widgets/datepicker-ui/datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/widgets/datepicker-ui/datepicker-demo.js"></script>

<!-- Bootstrap Daterangepicker -->

<!--<link rel="stylesheet" type="text/css" href="../../assets/widgets/daterangepicker/daterangepicker.css">-->
<script type="text/javascript" src="<?php echo base_url() ?>assets/widgets/daterangepicker/moment.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/widgets/daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/widgets/daterangepicker/daterangepicker-demo.js"></script>

<!-- Bootstrap Timepicker -->

<!--<link rel="stylesheet" type="text/css" href="../../assets/widgets/timepicker/timepicker.css">-->
<script type="text/javascript" src="<?php echo base_url() ?>assets/widgets/timepicker/timepicker.js"></script>
<script type="text/javascript">

    /* Timepicker */

    $(function() { "use strict";
        $('.timepicker-example').timepicker();
    });
</script>