<div class="wizard">
    <div class="wizard-inner">
        <div class="connecting-line"></div>
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Step 1">
                    <span class="round-tab">
                        <i class="glyphicon glyphicon-user"></i>
                    </span>
                </a>
            </li>
            <li role="presentation" class="disabled">
                <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Step 2">
                    <span class="round-tab">
                        <i class="glyphicon glyphicon-list-alt"></i>
                    </span>
                </a>
            </li>
            <li role="presentation" class="disabled">
                <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Step 3">
                    <span class="round-tab">
                        <i class="glyphicon glyphicon-picture"></i>
                    </span>
                </a>
            </li>
            <li role="presentation" class="disabled">
                <a href="#complete" data-toggle="tab" aria-controls="complete" role="tab" title="Complete">
                    <span class="round-tab">
                        <i class="glyphicon glyphicon-ok"></i>
                    </span>
                </a>
            </li>
        </ul>
    </div>

    <div class="tab-content">
        <div class="tab-pane active" role="tabpanel" id="step1">
            <form name="user-selection" id="user-selection">
                <div class="form-group">
                    <div class="usererror error error1" style="display:none;">Please Select user</div>
                </div>
                <div class="form-group clearfix">
                    <label for="label" class="col-lg-2 col-sm-3">Select user<span>*</span></label>
                    <div class="col-lg-10 col-sm-9">
                        <select name="user" class="form-control">
                            <option value="0"> - select - </option>
                            <?php
                            foreach ($users as $user) {
                                echo '<option value="' . $user['user_id'] . '">' . $user['first_name'] . ' ' . $user['last_name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <label for="label" class="col-lg-2 col-sm-3">Price List</label>
                    <div class="col-lg-10 col-sm-9">
                        <select name="pricelist" class="form-control">
                            <option value="1"> Standard </option>
                            <option value="2"> Allocated </option>
                        </select>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <label for="label" class="col-lg-2 col-sm-3">Tier Price</label>
                    <div class="col-lg-10 col-sm-9">
                        <select name="tierprice" class="form-control">
                            <option value="0"> No </option>
                            <option value="1"> Yes </option>
                        </select>
                    </div>
                </div>
                <ul class="list-inline pull-right">
                    <li><button type="button" class="btn btn-primary" id="userSel">Save and continue</button></li>
                    <li><a class="btn btn-primary btn-md" data-toggle="modal" data-target="#userModal"> Add New User </a></li>
                </ul>
            </form>
        </div>
        <div class="tab-pane" role="tabpanel" id="step2">
            <h3>Select Product for Quick Order</h3>
            <form name="user-selection" id="product-selection">
                <div class="col-lg-12"><div class="producterror error error1" style="display:none;">Please Select product</div></div>
                <div class="col-lg-12 col-sm-12 col-xs-12" id="userProList">
                    <table id="userAsignProList-old" class="display userAsignProList" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th id="selectAllCheckBox"></th>
                                <th></th>
                                <th>Name</th>
                                <th>SKU</th>
                                <th>Price</th>
                            </tr>                            
                        </thead>
                    </table>
                </div>
                <div class="col-lg-12" style="margin-top: 20px">
                    <ul class="list-inline pull-right">
                        <li><button type="button" class="btn btn-default prev-step">Previous</button></li>
                        <li><button type="button" class="btn btn-primary" id="addSelPro">Save and continue</button></li>
                    </ul>
                </div>
            </form>
        </div>
        <div class="tab-pane" role="tabpanel" id="step3">
            <form id="cartFrm" name="cartFrm">
                <div class="col-lg-12 col-sm-12 col-xs-12" id="cartProList"></div>
                <ul class="list-inline pull-right">
                    <li><button type="button" class="btn btn-default prev-step">Previous</button></li>
                    <li><button type="button" class="btn btn-default" id="updateCart">Update</button></li>
                    <li><button type="button" class="btn btn-primary btn-info-full" id="saveInform">Save and Send Quotation</button></li>
                </ul>
            </form>
        </div>
        <div class="tab-pane" role="tabpanel" id="complete">
            <form name="checkout" id="checkoutForm">
                <div class="col-lg-12 col-sm-12 col-xs-12 padding-0" id="checkoutView"></div>
                <ul class="list-inline pull-right">
                    <!--<li><button type="button" class="btn btn-primary btn-info-full" id="saveInform">Save and Inform</button></li>-->
                </ul>
            </form>
        </div>
        <div class="clearfix"></div>
    </div>
</div>


<span data-toggle="modal" data-target="#userModalthank"></span>

<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close closeM" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Add User</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal bordered-row" id="newUserAddform">
                    <div class="form-group">
                        <div class="col-sm-6">
                            <label class="control-label">Profile</label>
                            <?php echo form_dropdown('profile_id', $profilegroups, set_value('profile_id'), ' class="form-control"'); ?>
                            <div class="profileerror error" style="display:none;color:red">Please select Profile</div>
                        </div>
                        <div class="col-sm-6">
                            <label class="control-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php echo set_value('username'); ?>">
                            <div class="usernameerror error" style="display:none;color:red">Please input Username</div>
                            <div class="userexisterror error" style="display:none;color:red">User already exist</div>
                        </div>                        
                    </div>
                    <div class="form-group">
                        <div class="col-sm-6">
                            <label class="control-label">Firstname</label>
                            <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First name" value="<?php echo set_value('firstname'); ?>">
                            <div class="firstnameerror error" style="display:none;color:red">Please input Firstname</div>
                        </div>
                        <div class="col-sm-6">
                            <label class="control-label">Lastname</label>
                            <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last name" value="<?php echo set_value('lastname'); ?>">
                            <div class="lastnameerror error" style="display:none;color:red">Please input Lastname</div>
                        </div>
                    </div>                   
                    <div class="form-group">
                        <div class="col-sm-6">
                            <label class="control-label">Company Name</label>
                            <input type="text" class="form-control" id="companyname" name="companyname" placeholder="Company name" value="<?php echo set_value('companyname'); ?>">
                            <div class="companynameerror error" style="display:none;color:red">Please input Company name</div>
                        </div>
                        <div class="col-sm-6">
                            <label class="control-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo set_value('email'); ?>">
                            <div class="emailerror error" style="display:none;color:red">Please input Email</div>
                            <div class="emailexisterror error" style="display:none;color:red">Email already exist</div>
                            <div class="invalidemailerror error" style="display:none;color:red">Invalid Email</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-6">
                            <label class="control-label">Password</label>
                            <input type="password" class="form-control" id="password" name="passwd" placeholder="Password" value="<?php echo set_value('passwd'); ?>">
                            <div class="passwderror error" style="display:none;color:red">Please input Password</div>
                        </div>
                        <div class="col-sm-6">
                            <label class="control-label">Confirm Password</label>
                            <input type="password" class="form-control" id="cpassword" name="passwd1" placeholder="Password" value="<?php echo set_value('passwd1'); ?>">
                            <div class="passwd1error error" style="display:none;color:red">Please input Confirm Password</div>
                            <div class="passwd2error error" style="display:none;color:red">Confirm Password not matched</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-6">
                            <label class="control-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="<?php echo set_value('address'); ?>">
                            <div class="addresserror error" style="display:none;color:red">Please input Address</div>
                        </div>
                        <div class="col-sm-6">
                            <label class="control-label">Address 2</label>
                            <input type="text" class="form-control" id="address2" name="address2" placeholder="Address 2" value="<?php echo set_value('address2'); ?>">
                            <div class="address2error error" style="display:none;color:red">Please input Address 2</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-6">
                            <label class="control-label">City</label>
                            <input type="text" class="form-control" id="city" name="city" placeholder="City" value="<?php echo set_value('city'); ?>">
                            <div class="cityerror error" style="display:none;color:red">Please input City</div>
                        </div>
                        <div class="col-sm-6">
                            <label class="control-label">County</label>
                            <input type="text" class="form-control" id="county" name="county" placeholder="County" value="<?php echo set_value('county'); ?>">
                            <div class="countyerror error" style="display:none;color:red">Please input County</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-6">
                            <label class="control-label">Country</label>
                            <input type="text" class="form-control" id="country" name="country" placeholder="country" value="United kingdom">
                            <?php
//                            $countries = getCountries();
//                            $countries = array_column($countries, 'nicename');
//                            $countries = array_combine($countries, $countries);
//                            echo form_dropdown('country', $countries, '', ' class="form-control" ');
                            ?>
                            <div class="countryerror error" style="display:none;color:red">Please select Country</div>
                        </div>
                        <div class="col-sm-6">
                            <label class="control-label">Post code</label>
                            <input type="text" class="form-control" id="postcode" name="postcode" placeholder="Postcode" value="<?php echo set_value('postcode'); ?>">
                            <div class="postcodeerror error" style="display:none;color:red">Please input Postcode</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-6">
                            <label class="control-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" value="<?php echo set_value('phone'); ?>">
                            <div class="phoneerror error" style="display:none;color:red">Please input Phone</div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="newUserAdd">Submit</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="userModalthank" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">User added</h4>
            </div>
            <div class="modal-body">
                <h2>New user added successfully.</h2>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>