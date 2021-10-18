<h3 class="title-hero clearfix">
    Product Assign
    <!--<a href="catalog/category/" class="pull-right btn btn-primary">Manage Category</a>-->
</h3>

<div class="panel panel-default">
    <div class="panel-body">
        <?php $this->load->view('inc-messages'); ?>
        <!--<form action="catalog/cost/" method="post" name="cost-form" id="cost-form">-->
          <?php echo form_open('catalog/cost','id="cost-form"'); ?>   
            <div class="col-md-3">
                <!-- Categor List -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading"><label>CATEGORY LIST</label></div>
                            <div class="panel-body">
                                <?php

                                ?>
                                
                            </div><!-- ./ end panel-body -->
                        </div><!-- ./ end panel panel-default-->
                    </div><!-- ./ endcol-lg-6 col-lg-offset-3 -->
                </div><!-- ./ end row -->
                
            </div>
            <div class="col-md-9">
                <div class="panel panel-default">                  
                    <div class="panel-heading"><label>PRODUCT LIST</label></div>
                    <div class="panel-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="color:black;">Select</th>
                                    <th style="color:black;">Product Name</th>
                                    <th style="color:black;">Product Image</th>
                                    <th style="color:black;">SKU</th>
                                    <th style="color:black;">Price</th>
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
<script type="text/javascript">
$(document).ready(function(){            
    var multisidetabs=(function(){
        var opt,parentid,
        vars={
        listsub:'.list-sub',
        showclass:'mg-show'
        },
        test=function(){
            console.log(parentid);
        },
        events = function(){
            $(parentid).find('a').on('click',function(ev){                
                ev.preventDefault();
                var atag = $(this), childsub = atag.next(vars.listsub);
                //alert(atag.text());
                //console.log(atag.text());
                if(childsub && opt.multipletab == true){
                    //alert(opt.multipletab);
                    if(childsub.hasClass(vars.showclass)){
                        childsub.removeClass(vars.showclass).slideUp(500);
                    }else{
                        childsub.addClass(vars.showclass).slideDown(500);
                    }
                  }
                if(childsub && opt.multipletab == false){
                    //alert(opt.multipletab);
                    childsub.siblings(vars.listsub).removeClass(vars.showclass).slideUp(500);
                    if(childsub.hasClass(vars.showclass)){
                        childsub.removeClass(vars.showclass).slideUp(500);
                    }else{
                        childsub.addClass(vars.showclass).slideDown(500);
                   }
                }
            });
            },
            init=function(options){//initials
                if(options){
                    opt = options;
                    parentid = '#'+options.id;
                    //test();
                    events();
                }else{ alert('no options'); }
            }
                return {init:init};
    })();
            
    multisidetabs.init({
        "id":"mg-multisidetabs",
        "multipletab":false
    });
            
})
</script>