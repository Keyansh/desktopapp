<?php
echo "<pre>";
//print_r($product_list);
echo "</pre>";
?>
<h3 class="title-hero clearfix">
    Product Assignment
    <!--<a href="catalog/category/" class="pull-right btn btn-primary">Manage Category</a>-->
</h3>

<div class="panel panel-default">
    <div class="panel-body">
        <?php $this->load->view('inc-messages'); ?>
        <!--<form action="catalog/cost/" method="post" name="cost-form" id="cost-form">-->
          <?php echo form_open('catalog/cost','id="cost-form"'); ?>   
            <div class="col-md-3">
                <div class="panel panel-default">                
                    <div class="panel-heading"><label>USER LIST</label></div>
                    <div class="panel-body user-btn" style="padding:0;">
                        <div>
                            <?php if(isset($user_list)) {?>
                            <div class="btn-group" data-toggle="buttons">
                                <?php
                                foreach ($user_list as $user) {
                                ?>
                                <label class="btn btn-lg well" style="margin:0;width:100%;">
                                  <input name="user_id" type="radio" value="<?php echo $user['user_id']; ?>" onclick="userProductAssignedList()">
                                  <?php echo $user['first_name']." ".$user['last_name'];?>
                                </label>
                                <?php } ?>
                            </div>
                            <?php } else { ?>
                            <label>No users found!</label>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                
                
            </div>
            <div class="col-md-9">
                <div class="panel panel-default">                  
                    <div class="panel-heading"><label>PRODUCT LIST</label></div>
                    <div class="panel-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Select</th>
                                    <th>Product Name</th>
                                    <th>Product Image</th>
                                    <th>SKU</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(isset($product_list)) {?>
                                <?php
                                foreach ($product_list as $product) {
                                ?>  
                                <tr>

                                    <td>
                                        <input  type="checkbox" name="product[product_id][]" value="<?php echo $product['id'];?>" >
                                        <input type="hidden" name="product[product_hid_id][]" value="<?php echo $product['id'];?>" >
                                    </td>
                                    <td><label><?php echo $product['name'];?></label></td>                                    
                                    <td><img src="<?php echo $this->config->item('PRODUCT_URL') . $product['img']; ?>" class="thumbnail" width="150" /></td>
                                    <td><input type="text" name="product[sku][]" class="form-control"></td>
                                    <td><input type="text" name="product[price][]" class="form-control"></td>
                                </tr>
                                <?php } ?>
                                <?php } else { ?>
                                    <tr>
                                        <td>No Product found!</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group pull-right">
                    <input type="submit" name="submit" value="Assign Products" class="btn btn-primary"> 
                </div>
            </div>

                
            

        <?php echo form_close(); ?>       
        <!--</form>-->
    </div>
</div>

<script type="text/javascript">
$('.btn-group').button();
var checkboxes = document.getElementsByTagName('input');
</script>