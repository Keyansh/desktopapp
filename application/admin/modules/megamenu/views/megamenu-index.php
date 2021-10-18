<?php
    // e($menu);
    // e($sub_categories);
    // e($mapping);
?>

<div class="">
    <table class="nn-style-mega-menu-view table table-striped table-bordered">
        <tr>
            <th style="width:30%; text-align:center !important; color:black;" >Menu Item</th>
            <th style="width:30%; text-align:center !important; color:black;" >Category</th>
            <th style="text-align:center !important; color:black;">Action</th>
        </tr>
        <?php
            foreach($menu as $item) {
                $category_id = '';
                $megamenu_image_url = '';

                if($mapping) {
                    foreach($mapping as $x) {
                        if($item['menu_item_id'] == $x['menu_item_id']) {
                            $category_id = $x['category_id'];
                            if($x['image']) {
                                $megamenu_image_url = $this->config->item('MEGAMENU_URL') . $x['image'];
                            }
                        }
                    }
                }
                ?>
                <tr style="height:50px; text-align: center !important;">
                    <td id="<?php echo $item['menu_item_id']?>" class="menu-item" style="text-align: center !important; padding-top: 15px !important;"><?php echo $item['menu_item_name']?></td>
                    <td style="text-align: center !important;padding-top: 15px !important;">
                        <select class="select-ele" name="" >
                            <option selected="selected" disabled="disabled">Select category</option>
                            <?php
                                $flag = false;
                                foreach($sub_categories as $item2) {
                                    if($item2['id'] == $category_id) {
                                        ?>
                                            <option selected="selected" value="<?php echo $item2['id'] ?>"><?php echo $item2['name'] ?></option>
                                        <?php
                                    } else {
                                        ?>
                                            <option value="<?php echo $item2['id'] ?>"><?php echo $item2['name'] ?></option>
                                        <?php
                                    }
                                }
                            ?>
                        </select>
                    </td>
                    <td style="text-align: center !important;padding-top: 15px !important; ">
                        <?php
                            if($category_id != '') {
                                ?>
                                    <span id="<?php echo $item['menu_item_id'] ?>" class="unset" style="cursor:pointer;">Unset</span>
                                <?php
                            }
                        ?>
                    </td>
                </tr>
                <?php
            }
        ?>
    </table>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('.select-ele').change(function(data, status) {
            var menu_item_id = $(this).closest('td').prev('td').attr('id');
            var category_id = $(this).val();
            $.post('<?php echo base_url()?>megamenu/update',
            {
                menu_item_id : menu_item_id,
                category_id : category_id
            },
            function(data, status) {
                if(status == 'success') {
                    window.location.reload();
                }
            });
        });

        $('.unset').click(function(data, status) {
            var menu_item_id = $(this).attr('id');
            $.post('<?php echo base_url()?>megamenu/reset',
            {
                menu_item_id : menu_item_id
            },
            function(data, status) {
                if(data == 'done') {
                    window.location.reload();
                }
            });
        });

    });
</script>
