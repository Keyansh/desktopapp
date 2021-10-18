<div class="gallery-image-full-container" id="gallery-image-index">
    <div class="gallery-top-heading-section">
        <h1> Manage Images </h1>
        <div id="ctxmenu"><i class="fa fa-file-image-o"></i> <a href="gallery/image/add/<?= $images[0]['category_id'] ?>">Upload Image</a></div>

        <?php
        if (count($images) == 0) {
            $this->load->view('inc-norecords');
        } else {
            ?>
        </div>
        <div class="" style="width: 90%;margin-left: 20px;">
            <div class="tableWrapper">
                <div class="main_action" style="padding-bottom:20px;">
                    <div class="category_name" style="float:left; padding-left:15px; font-size:12px; font-weight:bold;">Images</div>
                    <div class="action" style="float:right; padding-right:30px; font-size:12px; font-weight:bold">Action</div>
                </div>
                <ul id="pagetree">
                    <?php
                    if ($images) {
                        foreach ($images as $item) {
                            $del_href = 'gallery/image/delete/' . $item['image_id'] . '/' . $item['category_id'];
                            ?>

                            <li id="image_<?php echo $item['image_id']; ?>">
                                <div class="page_item"><div class="page_item_name"><img src="<?= $this->config->item('IMAGE_THUMBNAIL_URL') . $item['image']; ?>" border="0" width="100" /></div>
                                    <div class="page_item_name"><?php echo $item['title']; ?></div>    
                                    <div class="page_item_options"> <a href="<?php echo $del_href; ?>" onclick="return confirm('Are you sure you want to delete this Image?');">Delete</a></div></div>
                            </li>
                            <?php
                        }
                    } else {
                        ?>
                        <p style="text-align: center">No record found</p>
                    <?php } ?>
                </ul>
            </div>  
        <?php } ?>
        <div id="dialog-modal" title="Working">
            <p style="text-align: center; padding-top: 40px;">Updating the sort order...</p>
        </div>

    </div>
</div>