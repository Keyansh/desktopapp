<div class="gallery-image-full-container" id="gallery-image-index">
    <div class="gallery-top-heading-section">

        <h1>Edit Image</h1>
        <div id="ctxmenu"> <i class="fa fa-picture-o"></i> <a href="gallery/image/index">Manage Images</a></div>
    </div>
    <?php $this->load->view('inc-messages'); ?>

    <div class="" style="width: 90%;margin-left: 20px;">
        <div class="tableWrapper">
            <form action="gallery/image/edit/<?php echo $img['image_id']; ?>/<?= $pid ?>" method="post" enctype="multipart/form-data" name="edit_frm" id="edit_frm">
                <?php echo form_hidden('pid', $pid); ?>
                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="formtable">
                    <tr>
                        <th>Image</th>
                        <td><?php if ($img['image']) { ?>
                                <img src="<?php echo $this->config->item('IMAGE_THUMBNAIL_URL') . $img['image']; ?>" border="0" width="100px" /> <br /><?php } ?>
                            <input type="hidden" name="img_name" value="<?php echo $img['image']; ?>" />
                            <input name="image" type="file" id="image" size="30" class="textfield">  <br />
                            <small>Only .jgp,.gif,.png images allowed</small> </td>
                    </tr>
                    <tr>
                        <th>Image Title<span class="error">*</span></th>
                        <td><input type="text" name="title" id="title" value="<?php echo set_value('title', $img['title']); ?>"></td>
                    </tr>
                    <tr>
                        <td><input name="v_image" type="hidden" id="v_image" value="1" /></td>
                        <td><input type="submit" name="upload_btn" id="upload_btn" value="Submit"></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>Fields marked with <span class="error">*</span> are required.</td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>