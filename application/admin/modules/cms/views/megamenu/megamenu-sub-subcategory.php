<?php
$ci = &get_instance();
$ci->load->model('cms/megamenumodel');
$prevParent = $ci->megamenumodel->getSigleLevelParent($parentCategory);
?>

<h3 class="title-hero clearfix">
    Manage Menus
    <a href="cms/megamenu/subcategory/<?php echo $prevParent['parent_id'] ?>" class="pull-right btn btn-primary">Back to main menu</a>
</h3>
<?php
$this->load->view('inc-messages');
if (count($ActiveSubcategory) == 0) {
    $this->load->view('inc-norecords');
    echo "</div>";
    return;
}
?>


<div class="panel">
    <div class="panel-body">
        <div class="example-box-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <form action='cms/megamenu/sub_subcategory_add' method="post">
                        <input type="hidden" name='parentCategory' value='<?php echo $parentCategory ?>'>
                        <div class="remove-columns">
                            <table class="table table-bordered table-striped table-condensed cf">
                                <thead class="cf">
                                    <tr>
                                        <th style="color: black;">Menu</th>
                                        <th style="color: black;">Order</th>
                                        <th style="color: black;">Enable/Disable</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($ActiveSubcategory as $item) {
                                        $res = $ci->megamenumodel->getSubCategoryExistence($item['category_id']);
                                        ?>
                                        <tr>
                                            <td data-title="Menu">
                                                <?php echo $item['category']; ?>
                                                <input type='hidden' name='subcategory[]' value='<?php echo $item['category_id']; ?>'>
                                            </td>
                                            <?php if ($res['num_rows'] > 0) { ?>
                                                <td data-title="Order"><input type="text" name="order-<?php echo $item['category_id']; ?>" value='<?php echo $res['result']['order'] ?>' class="order-<?php echo $item['category_id']; ?> form-control" ></td>
                                                <td data-title="Enable/Disable">
                                                    <label>Enable <input type="radio" <?php
                                                        if ($res['result']['status'] == "1") {
                                                            echo "checked";
                                                        }
                                                        ?> name="status-<?php echo $item['category_id']; ?>"  class="unlockme" value='1' data-hide='<?php echo $item['category_id']; ?>' ></label>
                                                    <label>Disable <input type="radio" <?php
                                                        if ($res['result']['status'] == "0") {
                                                            echo "checked";
                                                        }
                                                        ?> name="status-<?php echo $item['category_id']; ?>"  class="unlockme" value='0' data-hide='<?php echo $item['category_id']; ?>' ></label>
                                                </td>
                                            <?php } else { ?>
                                                <td data-title="Order"><input type="text" disabled="" name="order-<?php echo $item['category_id']; ?>" class="order-<?php echo $item['category_id']; ?> form-control" ></td>
                                                <td data-title="Enable/Disable">
                                                    <label>Enable <input type="radio" name="status-<?php echo $item['category_id']; ?>"  class="unlockme" value='1' data-hide='<?php echo $item['category_id']; ?>' ></label>
                                                    <label>Disable <input type="radio" checked  name="status-<?php echo $item['category_id']; ?>"  class="unlockme" value='0' data-hide='<?php echo $item['category_id']; ?>' ></label>
                                                </td>
                                            <?php } ?>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <?php if (count($ActiveSubcategory) > 0) { ?>
                            <div class="text-center"><input type="submit" class="btn btn-primary" value="Add menu"></div>
                            <?php } ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>