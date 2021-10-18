<h3 class="title-hero clearfix">TOP Categories</h3>
<?php if(isset($userNotExist)){ ?>
    <?php echo $userNotExist; ?>
<?php } ?>
<p></p>
<div class="panel">
    <div class="panel-body">
       <div class="row">
            <?php 
                if(isset($categories))
                {
                    foreach ($categories as $category) 
                    {
                        if(isset($user_id))
                        {
                        ?>
                            <div class="col-md-4">
                                <div class="thumbnail">                        
                                    <a href="product_allocation/assign/sub_category/<?php echo $user_id.'/'.$category['id']; ?>"><img src="<?php echo $this->config->item('CATEGORY_IMAGE_URL').$category['image']?>" alt="<?php echo $category['name']?>" class="img-responsive">
                                    <div class="caption">
                                        <?php if(isset($category['name'])) { ?>
                                            <h4><?php echo $category['name'];?></h4>
                                        <?php } ?>                                        
                                    </div>
                                    </a>
                                </div>
                            </div>
            <?php       }                      
                    }
                }
                else
                {
                    echo "Category not found!";
                }
            ?>
            
            
       </div> 
    </div>
</div>