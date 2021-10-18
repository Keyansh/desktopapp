<h3 class="title-hero clearfix">
    <?php echo $pages['title']; ?> - Blocks <?php
    if ($pages['language_code'] != 'en') {
        echo '(' . $page_lang['language'] . ')';
    }
    ?>
    <div class="pull-right">
        <a href="cms/page" class="btn btn-info" style="background: #094e91;">
            Manage Pages
        </a>
        <a href="cms/page/edit/<?php echo $pages['page_id']; ?>" class="btn btn-info" style="background: #094e91;">
            Edit Page
        </a>
        <a href="cms/block/add/<?php echo $pages['page_id']; ?>" class="btn btn-info" style="background: #094e91;">
            Add Block
        </a>
        <?php if ($pages['language_code'] == 'en') { ?>
            <a href="cms/page/duplicate/<?php echo $pages['page_id']; ?>" class="btn btn-info" style="background: #094e91;">
                Duplicate Page
            </a>
        <?php } ?>
    </div>
</h3>

<div class="panel">
    <div class="panel-body">
        <div class="example-box-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <?php $this->load->view('inc-messages'); ?>
                    <?php
                    if (count($block) == 0) {
                        $this->load->view('inc-norecords');
                        echo "</div>";
                        return;
                    }
                    ?>
                    <ul id="pagetree">
                        <?php
                        foreach ($block as $item) {
                            $edit_href = 'cms/block/edit/' . $item['page_block_id'];
                            $ed_href = 'cms/block/ed/' . $item['page_block_id'];
                            $edicon = ($item['is_active']) ? '<i class="glyph-icon icon-eye green-color"></i>' : '<i class="glyph-icon icon-eye-slash"></i>';
                            ?>
                            <li id="block_<?php echo $item['page_block_id']; ?>">
                                <div class="page_item"> 
                                    <div class="page_item_name">
                                        <a href="<?php echo $edit_href; ?>"><?php echo $item['block_title']; ?></a>
                                    </div>
                                    <div class="page_item_options">
                                        <a href="<?php echo $ed_href; ?>" class='tooltip-button' data-toggle='tooltip' data-placement='top' title="Enable/Disable"><?= $edicon; ?></a>
                                        <a href="<?php echo $edit_href; ?>" class='tooltip-button' data-toggle='tooltip' data-placement='top' title="Edit"><i class="glyph-icon icon-linecons-pencil"></i></a>
                                        <a href="cms/block/delete/<?= $item['page_block_id']; ?>" onclick="return confirm('Are you sure you want to delete this Block?');" class='tooltip-button' data-toggle='tooltip' data-placement='top' title="Delete"><i class='glyph-icon icon-linecons-trash red-color'></i></a>
                                    </div>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="dialog-modal" title="Working">
    <p style="text-align: center; padding-top: 40px;">Updating the sort order...</p>
</div>