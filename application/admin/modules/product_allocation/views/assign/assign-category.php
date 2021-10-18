<?php
/* echo "<pre>";
  print_r($this->session->userdata('selected_category'));
  print_r($this->session->userdata('user_id'));
  echo "</pre>"; */
?>
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/widgets/datatable/datatable.css">
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable-bootstrap.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable-tabletools.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#datatable-example').dataTable();
    });
</script>
<?php
$form_attr = array(
    'name' => 'categoryform',
    "id" => "categoryform",
    'method' => 'post',
    'onsubmit' => 'return formSubmit(this)',
    'role' => 'form'
);

echo form_open('', $form_attr);
?>

<div class="row">
    <div class="col-md-12">
        <div class="form-group pull-right">
            <input type="submit" name="submit-category" value="Update" class="btn btn-primary">

            <input type="hidden" name="hiddSubCategory" value="<?php echo $subCategory; ?>">
            <input type="hidden" name="hiddUserID" value="<?php echo $user_id; ?>">

            <!-- <a href="product_allocation/assign/assigned_category" class="btn btn-primary">Assigned</a> -->

            <a href="user" class="btn btn-primary">Manage User</a>

            <input type="checkbox" name="all" id="productCategory" class="btn btn-primary"> Select All
        </div>
    </div>

</div>
<div class="row">
    <div class="col-md-12">
        <?php
        $category_names = false;
        if ($productAssigned) {
            $category_names = array_column($productAssigned, 'name');
            $category_names = implode(',', $category_names);
        }
        if ($category_names) {
            ?>
            <div class="alert alert-danger">
                <strong><?= $category_names ?>.</strong> Category will be overwritten after submittion.
            </div>
            <? } ?>
        </div>
    </div>
    <div class="panel">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-responsive" id="datatable-example">
                        <thead>
                            <tr>
                                <th style="color:black;">Sr.no.</th>
                                <th style="color:black;">Category Name</th>
                                <th style="color:black;">Discount <input type="text" name="discountAll" value="" style="width:40px;">%</th>
                                <th style="color:black;">Special Price</th>
                                <th style="color:black;">Select</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($categories as $category) { //e($categories); 
                                $i++;
                                ?>
                                <tr>
                            <input type="hidden" name="cid[<?= $category['id'] ?>]" value="<?= $category['id'] ?>">
                            <td><?= $i . '.' ?></td>
                            <td>
                                <?= $category['name'] ?>
                            </td>
                            <td><input type="text" name="discount[<?= $category['id'] ?>]" value="<?= $category['discount'] ?>" old-value="<?= $category['discount'] ?>" style="width:40px;"> %</td>
                            <td><input type="text" name="specialprice[<?= $category['id'] ?>]" value="<?= $category['special_price'] ?>" style="width:50px;"></td>
                            <td>
                                <input type="checkbox" <?= ($category['active']) ? "checked='true'" : ''; ?> name="select[<?= $category['id'] ?>]" value="<?= $category['id'] ?>" class="btn">
                            </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>

    <?php echo form_close(); ?>


<script type="text/javascript">
    function formSubmit(formId) {
        var theForm = document.getElementById(formId); // get the form
        var cb = formId.getElementsByTagName('input'); // get the inputs

        for (var i = 0; i < cb.length; i++) {
            if (cb[i].type == 'checkbox' && !cb[i].checked)  // if this is an unchecked checkbox
            {
                cb[i].value = 0; // set the value to "off"
                cb[i].checked = true; // make sure it submits
            }
        }
        return true;
    }
    $(document).ready(function () {
        $("#productCategory").change(function () {
            $("input:checkbox").prop('checked', $(this).prop("checked"));
        });

        $(document).on('change', '[name="discountAll"]', function () {
            var value = $(this).val();
            if (!$.isNumeric(value)) {
                return;
            }
            value = +value;
            $('[name^="discount"]').each(function () {
                if (value) {
                    $(this).val(value);
                } else {
                    $(this).val($(this).attr('old-value'));
                }
            });
        });
    });
</script>
