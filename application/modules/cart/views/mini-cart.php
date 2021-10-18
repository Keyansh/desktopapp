<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 product-details-table-col">
    <?php if (!empty($tempData)) { ?>
        <div class="product-selected-col">
            <p class="selected-product-p"></p>
            <?php
            if (!empty($tempData)) {
                ?>
                <form name="add_to_cart" method="post" action="" id="add_to_cart">

                    <table width="100%" class="selected-product-table">

                        <?php
                        foreach ($tempData as $product_id => $sessItems) {
                            ?>
                            <tr>
                                <?php
                                foreach ($sessItems['attributes'] as $sessAttr) {
                                    // if($sessAttr['attribute_label'] != 'Color') {
                                    ?>
                                    <td>
                                        <p><?php echo $sessAttr['attribute_label']; ?>: <span><?php echo $sessAttr['value_label']; ?></span></p>
                                    </td>
                                    <?php
                                    // }
                                }
                                ?> 
                                <td>
                                    <div class="forms-group">
                                        <ul class="list-inline">
                                            <li>Qty:</li>
                                            <li>
                                                <div class="input-group number-spinner table-spinner">
                                                    <input class="form-control text-center" value="<?php echo $sessItems['qty']; ?>" type="text" name="quantity[<?= $pid ?>][<?= $product_id ?>]">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default action-btn" data-dir="dwn"><span class="fa fa-minus"></span></button>
                                                    </span>
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default action-btn" data-dir="up"><span class="fa fa-plus"></span></button>
                                                    </span>
                                                </div>
                                            </li>
                                        </ul>  

                                    </div>
                                </td>
                                <td>
                                    <p>&pound; <?php echo $sessItems['price']; ?></p>
                                </td>
                                <td>

                                    <button type="button" class="btn btn-info delete-btn" 
                                            onclick="deleteMiniCartItem('<?= $pid ?>', '<?= $product_id ?>')">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </button>
                                </td>
                            </tr> 
                            <?php ?>

                            <?php
                        }
                    }
                    ?>


                </table>
                <input type="hidden" name="ptype" value="config">
                <input type="hidden" name="config_product_id" value="<?= $pid; ?>">
                <input type="button" name="updateminicart" value="Update" onclick="updateMiniCart()" class="btn btn-info table-cart-btn">
                <input type="submit" name="addcart" value="Add To Cart" class="btn btn-info table-cart-btn">
            </form>

        </div>

    <?php } ?>            
</div>
