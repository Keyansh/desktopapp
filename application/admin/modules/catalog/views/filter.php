<style type="text/css">
    #table-3 td {
        border: 1px solid #DFE8F1;
        padding: 8px 13px;
        font-size: 14px;
    }
</style>
<div class="row">
    <div class="col-md-6">
        <h1>Manage Products</h1>
    </div>
    <div class="col-md-6">
        <div id="ctxmenu" class="pull-right">
            <a href="catalog/product/add" class="btn btn-primary">Add Product</a>
            <a href="catalog/product/filter" class="btn btn-success">View All</a>
        </div>
    </div>
</div>

<?php $this->load->view('inc-messages'); ?>

<p>&nbsp;</p>
<?php echo validation_errors(); ?>
<?php 
$attributes = array('name' => 'productFilter', 'method' => 'post');

echo form_open('catalog/product/index', $attributes);

?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-12">
                    <h4>Search Filter</h4>                
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <input type="text" name="pname" class="form-control" value="<?php echo set_value('pname');?>" placeholder="Product Name">
                    </div>
                 </div>
                 <div class="col-md-3">

                    <div class="form-group">
                        <input type="text" name="cname" class="form-control" value="<?php echo set_value('cname');?>" placeholder="Category Name">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <input type="text" name="sku" class="form-control" value="<?php echo set_value('sku');?>" placeholder="sku">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                         <input type="text" name="price" class="form-control" value="<?php echo set_value('price');?>" placeholder="Price">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <?php 
                        $options = array(
                                        ''=>'Select status',
                                        '0'=> 'Enabled',
                                        '1'=> 'Disabled',
                                        );
                        echo form_dropdown('status', $options, set_value('status'), 'class="form-control"');

                        ?>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <input type="text" name="from" id="from" class="form-control from" value="<?php echo set_value('from');?>" placeholder="From">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <input type="text" name="to" id="to" class="form-control to" value="<?php echo set_value('to');?>" placeholder="To">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <input type="submit" name="filter" class="btn btn-primary" value="Filter">

                    </div>
                </div>
            </div>
        </div>
    </div>
</form>        
<?php echo $pagination;?>
<?php
if (count($products) == 0) {

    $this->load->view('inc-norecords');
} else {
    ?>
    <div class = "tableWrapper">        
        <table id = "table-3" width = "100%" border = "0" cellpadding = "2" cellspacing = "0" class="table-striped">
            <?php foreach ($products as $item) {
                ?>
                <tr id="<?php echo $item['id']; ?>" class="<?php echo alternator('', ''); ?>">
                    <td width="40%"><?php echo $item['name']; ?></td>
                    <td width="20%"><?php echo $item['category_name']; ?></td>
                    <td width="40%">
                        <?php if ($item['is_active'] == 1) { ?>
                            <a href="catalog/product/disable/<?php echo $item['id'] ?>" onclick="return confirm('Are you sure you want to Disable this Product?');">Disable</a>
                        <?php } else { ?>
                            <a href="catalog/product/enable/<?php echo $item['id'] ?>" onclick="return confirm('Are you sure you want to Enable this Product?');">Enable</a>
                        <?php } ?>
                        | <a href="catalog/product/edit/<?php echo $item['id']; ?>">Edit</a>
                        | <a href="catalog/product/delete/<?php echo $item['id'] ?>" onclick="return confirm('Are you sure you want to Delete this Product?');">Delete</a>

                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
<?php } ?>
<script type="text/javascript">
    $("#from").datepicker({ dateFormat: 'yy-mm-dd' });
    $("#to").datepicker({ dateFormat: 'yy-mm-dd' });
</script>