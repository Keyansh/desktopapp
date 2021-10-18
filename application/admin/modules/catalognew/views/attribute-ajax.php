<style>
    .clone-table td {
        padding: 0 10px;
        vertical-align: middle;
    }
    .clone-table td .btn {

        margin: 43px 0 0 0;

    }
    .clone-table input, .clone-table select {

        min-width: 164px;

    }
    .clone-table{
        position: relative;
    }
</style>
<div class="table-responsives">
    <div class="clone-table">  

<!--    <table width="100%" class="clone-table">
    <tr id="">
        <td>
            <label>SKU</label>
            <input type="text" name="childsku[0][]" placeholder="SKU" class="form-control sku-field req" />
        </td>
        <td>
            <label>QTY</label>
            <input type="text" name="childqty[0][]" placeholder="QTY" class="form-control qty-field req" onkeyup="if (/\D/g.test(this.value))
                        this.value = this.value.replace(/\D/g, '')" />
        </td>
        <td>
            <label>Price</label>
            <input type="text" name="childprice[0][]" placeholder="Price" class="form-control price-field req" />
        </td>
        <?php
        $i = 1;
        foreach ($data as $key => $val) {
            ?>

                    <td>
                        <input type="hidden" name="attribute[0][]" class="attr-field" value="<?php echo $val['id']; ?>" />
                        <label><?php echo $val['label']; ?></label>
                        <select class="form-control option-field req a1-<?php echo $i; ?>" name="options[0][]">
                            <option value="">-Select-</option>
            <?php
            if ($val['options']) {
                foreach ($val['options'] as $suboptions) {
                    ?>
                                                    <option value="<?php echo $suboptions['id']; ?>"><?php echo $suboptions['option']; ?></option>

                    <?php
                }
            }
            ?>
                        </select>
                    </td>
            <?php
            $i++;
        }
        ?>
        <td class="action-col">
            <button type="button" class="btn btn-primary cloneAdd">
                <i class="fa fa-plus"></i>
            </button>
        </td>
    </tr>
</table>-->

        <div class="col-xs-12 attribute-table-data">

            <div class="col-xs-12 col-sm-3 col small">
                <label>SKU</label>
                <input type="text" name="childsku[0][]" placeholder="SKU" class="form-control sku-field req" />
            </div>
            <div class="col-xs-12 col-sm-3 col small">
                <label>QTY</label>
                <input type="text" name="childqty[0][]" placeholder="QTY" class="form-control qty-field req" onkeyup="if (/\D/g.test(this.value))
                            this.value = this.value.replace(/\D/g, '')" />
            </div>
            <div class="col-xs-12 col-sm-3 col small">
                <label>Price</label>
                <input type="text" name="childprice[0][]" placeholder="Price" class="form-control price-field req" />
            </div>

            <?php
            $i = 1;
            foreach ($data as $key => $val) {
                ?>

                <div class="col-xs-12 col-sm-3 col">
                    <input type="hidden" name="attribute[0][]" class="attr-field" value="<?php echo $val['id']; ?>" />
                    <label><?php echo $val['label']; ?></label>
                    <select class="form-control option-field req a1-<?php echo $i; ?>" name="options[0][]">
                        <option value="">-Select-</option>
                        <?php
                        if ($val['options']) {
                            foreach ($val['options'] as $suboptions) {
                                ?>
                                <option value="<?php echo $suboptions['id']; ?>"><?php echo $suboptions['option']; ?></option>

                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
                <?php
                $i++;
            }
            ?>

            <div class="action-col">
                <button type="button" class="btn btn-primary cloneAdd">
                    <i class="fa fa-plus"></i>
                </button>
            </div>

        </div>

    </div>
</div>

