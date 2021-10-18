
<div class="gallery-image-full-container" id="gallery-image-index">
    <div class="gallery-top-heading-section">

        <h1>Add Image</h1>
        <div id="ctxmenu"> <i class="fa fa-picture-o"></i> <a href="gallery/image/index">Manage Images</a></div>


    </div>


    <div class="" style="width: 90%;margin-left: 20px;">
        <?php $this->load->view('inc-messages'); ?>

        <div class="tableWrapper">
            <form action="gallery/image/add" method="post" enctype="multipart/form-data" name="add_frm" id="add_frm">
                <?php echo form_hidden('pid', $pid); ?>
                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="formtable">
            <!--        <tr>
                        <th>Project <span class="error">*</span></th>
                        <td><?php //echo form_dropdown('parent_id', $parent, set_value('parent_id'), ' class="textfield"');    ?>
                        
                            <select class="textfield" name="project_id">
                                <option value="">-Select-</option>
                    <?php
//                    foreach($parent as $projects){
                    ?>
                                    <option value="<?php // echo $projects['page_id'];   ?>"><?php // echo $projects['title'];   ?></option>
                    <?php
//                    }
                    ?>
                            </select>
                        </td>
                    </tr>-->
                    <tr>
                        <th>Image<span class="error">*</span></th>
                        <td><input type="file" name="image" id="image"><br />
                            <small>Only .jgp,.gif,.png images allowed</small> </td>
                    </tr>
                    <tr>
                        <th>Image Title</th>
                        <td><input type="text" name="title" id="title"></td>
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