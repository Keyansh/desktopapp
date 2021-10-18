<?php echo form_open('product_allocation/assign/product_list', 'id="sub-category-form"'); ?>
<div class="row">
    <div class="col-md-8">
        <?php if (isset($category_name['name'])) { ?>
            <h3 class="title-hero clearfix"><?php echo $category_name['name']; ?></h3>
        <?php } ?>       
        <?php
        if (isset($user_error)) {
            echo $user_error;
        }
        ?> 
    </div>
    <div class="col-md-4">
        <div class="form-group pull-right">
            <input type="checkbox" name="all" id="selectCategory" class="btn btn-primary"> Select All

        </div>
    </div>

</div>

<div class="panel">
    <div class="panel-body">

        <input type="hidden" name="parent_id" value="<?php echo isset($category_name['id']) ? $category_name['id'] : ''; ?>">
        <input type="hidden" name="user_id" value="<?php echo isset($user_id) ? $user_id : ''; ?>">
        <div class="row">
            <?php
            if (isset($sub_category)) {

                foreach ($sub_category as $category) {
                    ?>
                    <div class="col-md-4">
                        <label>
                            <input type="checkbox" name="sub-category[]" value="<?php echo isset($category['id']) ? $category['id'] : '' ?>" class="btn"><?php echo isset($category['name']) ? $category['name'] : ''; ?>
                        </label>                    
                    </div>
        <?php
    }
} else {
    echo "No sub category found!";
}
?>
        <input type="hidden" name="current_cat_id" value="<?= $current_cat_id ?>">
        </div> 
        <div class="row">
            <div class="col-md-12">
                <div class="form-group pull-right">
                    <input type="submit" name="assign-category" value="All Product Assignment" class="btn btn-primary">
                </div>
                <div class="form-group pull-right">
                    <input type="submit" name="assign-product" value="Manual Assignment" class="btn btn-primary">
                </div>
                <div class="form-group">
                    <a href = "javascript:void(0)" onclick="window.history.back();" class="btn btn-primary">Back </a>
                </div>  
            </div>
        </div>

    </div>
</div>
<?php echo form_close(); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#selectCategory").change(function () {
            $("input:checkbox").prop('checked', $(this).prop("checked"));
        });
    })
</script>