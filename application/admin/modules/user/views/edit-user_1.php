<h1>Edit <?= $user['username']; ?> Details</h1>
<div id="ctxmenu"><a href="user/">Manage Users</a></div>
<?php $this->load->view('inc-messages'); ?>

<div id="tabs">
    <ul class="nav" id="tabs-nav">
        <li><a href="#tabs-1">Details</a></li>
        <li><a href="#tabs-2">Permissions</a></li>
    </ul>

    <form action="user/edit/<?php echo $user['user_id']; ?>" method="post" enctype="multipart/form-data" name="form1" id="form1">
        <div id="tabs-1" class="tab">
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <tr>
                    <td width="20%">Username <span class="error">*</span></td>
                    <td width="80%"><input name="username" type="text" id="username" size="40" class="inputfield" value="<?= set_value('username', $user['username']); ?>"></td>
                </tr>
                <tr>
                    <td>Email <span class="error">*</span></td>
                    <td><input name="email" type="text" id="email" size="40" class="inputfield" value="<?= set_value('email', $user['email']); ?>"></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input name="passwd" type="password" id="passwd" size="40" class="inputfield"></td>
                </tr>
                <tr>
                    <td>Confirm Password</td>
                    <td><input name="passwd1" type="password" id="passwd1" size="40" class="inputfield"></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td><small>Fields mark with <span class="error">*</span> required</small></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td><input type="submit" name="button" id="button" value="Submit"></td>
                </tr>
            </table>
        </div>
        <div id="tabs-2" class="tab">
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <?php if ($user['user_id'] > 1) { ?>
                    <tr>
                        <td width="20%" style="vertical-align: top">Permissions</td>
                        <td width="80%"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                                <tr>
                                    <?php
                                    $total_permission = count($resources);
                                    $counter = 0;
                                    $columns = 1;
                                    $per_colum = ceil($total_permission / $columns);
                                    for ($i = 1; $i <= $columns; $i++) {
                                        ?>
                                        <td style="vertical-align:top"><?php
                                            for ($j = 1; $j <= $per_colum; $j++) {
                                                if ($counter >= $total_permission)
                                                    continue;
                                                $tmp = each($resources);
                                                $key = $tmp['key'];
                                                $val = $tmp['value'];
                                                echo form_checkbox('resource_id[]', $key, in_array($key, $current_permission) ? true : false) . ' ' . $val . '<br />';
                                                $counter++;
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
        <input type="hidden" name="user_id" id="user_id" value="<?php echo $user['user_id']; ?>">
    </form>

</div>
