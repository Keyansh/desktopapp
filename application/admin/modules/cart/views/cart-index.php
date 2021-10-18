<?php $cartItems = $this->cart->contents();
/*echo "<pre>";
print_r($cartItems);
echo "</pre>";
*/?>
<section id="cart-section">
    <div class="container">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 cart-main-col">
            <h2>Products In Your Cart</h2>
            <?php
            $this->load->view('inc-messages');
            if ($this->cart->total_items() == 0) {
                echo '<p>There are no items in your wish list.</p>';
                return;
            }
            ?>
            <form id="cartFrm" name="cartFrm" method="post" action="cart/update">
                <div class="table-responsive col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-zero">

                    <table class="cart-table" width="100%">
                        <tbody>
                            <tr>
                                <th>Product Name</th>
                                <th>Unit Price </th>
                                <th>Quantity </th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                            <?php
                            $cartItems  = $this->cart->contents();
                            foreach ($this->cart->contents() as $item) {
                                if(is_array($item))
                                {

                                    if (!empty($item['img'])) {
                                        $subcatimg = $this->config->item('PRODUCT_URL') . $item['img'];
                                    } else {
                                        $subcatimg = 'images/no-image.jpg';
                                    }
                                    $options = '';
                                    if ($this->cart->has_options($item['rowid'])) {
                                        $options = $this->cart->product_options($item['rowid']);
                                    }
                                    ?>

                                <tr>
                                    <td>
                                        <ul class="list-inline cart-table-ul">
                                            <li>
                                                <div class="td-img-col">
                                                    <img src="<?= $subcatimg; ?>" class="img-responsive" style="width: 50px">
                                                </div>
                                            </li>
                                            <li>
                                                <div class="td-text-col">
                                                    <?php
                                                    $this->load->model('cart/cartmodel');
                                                    $alias = $this->cartmodel->getDetail($item['id']);
                                                    ?>
                                                    <a class="cart-product-name" href="<?= base_url() . $alias['uri']; ?>"><?= $item['name']; ?></a>
                                                    <?php if ($options) {
                                                        ?> (
                                                        <?php foreach ($options as $key => $val) {
                                                            ?>
                                                            <?php if ($key) { ?>

                                                                <span class="lg_text"><b><?php echo $key; ?>:</b> </span> <?php echo $val; ?> 
                                                                <?php
                                                            }
                                                        }
                                                        ?> )
                                                    <?php } ?>
                                                    <?php echo $item['rowid']=='free'?$item['rowid']:'';?>
                                                </div>
                                            </li>
                                        </ul>
                                    </td>
                                    <td>
                                        <?php echo DWS_CURRENCY_SYMBOL; ?><?php echo $this->cart->format_number($item['price'])?$this->cart->format_number($item['price']):0; ?>
                                    </td>
                                    <td>
                                        <div class="input-group spinner">
                                        <?php 
                                            if($item['rowid']=='free')
                                            {
                                                echo $item['qty'];
                                        }
                                        else
                                            { 
                                        ?>
                                         <input name="quantity[]" type="number" class="qtn_textfield iqty form-control" id="quantity" value="<?php echo $item['qty']; ?>" size="3">
                                        <?php } ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php echo DWS_CURRENCY_SYMBOL; ?><?php echo $this->cart->format_number($item['price'] * $item['qty'])?$this->cart->format_number($item['price'] * $item['qty']):0; ?>
                                    </td>
                                    <td>
                                      <!--   <a href="cart/delete/<?php echo $item['rowid']; ?>" class="btn btn-info" onclick="return confirm('Are you sure you want to remove this item?');"><img src="images/cart-close.png"></a> -->
                                        <a href="javascript:void(0)" class="btn btn-info" onclick="deleteCartItem('<?php echo $item['rowid']; ?>','<?php echo $cartItems['coupon_code']?>')"><img src="images/cart-close.png"></a>
                                        <input name="key[]" type="hidden" id="key" value="<?php echo $item['rowid']; ?>" size="10">
                                        <input name="product_id[]" type="hidden" id="product_id" value="<?php echo $item['id']; ?>" size="10">
                                        <input name="price[]" type="hidden" id="price" value="<?php echo $item['price']; ?>" size="10">
                                    </td>
                                </tr>
                        <?php } 
                            
                            } 
                        ?>
                        </tbody>
                    </table>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-zero continue-cart-col">
                    <ul class="list-inline continue-cart-ul">
                        <li><a href="<?= base_url(); ?>"><button type="button" class="btn btn-primary">Continue Shopping</button></a></li>
                        <li><a href='cart/clearbasket'><button type="button" class="btn btn-primary">Clear Shopping Cart</button></a></li>
                        <li><input type="submit" class="btn btn-primary" value="Update Shopping Cart"></li>
                    </ul>
                </div>
            </form>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 total-table-col">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 total-table-coupon-col">
                    <div class="coupon-col">
                        <label class="col-md-12">Discount Codes</label>
                        <div class="input-group">
                            <input class="form-control coupon-input" placeholder="Enter your coupon code" type="text" value="<?php echo isset($cartItems['coupon_code'])?$cartItems['coupon_code']:''?>" <?php echo isset($cartItems['coupon_code'])?'readonly':'';?>>
                            <span class="input-group-btn">
                                <button class="btn btn-default apply-btn coupon-btn" type="button">Apply</button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 total-table-total-col">
                    <table class="total-table">
                        <tbody>
                            

                            <?php if(isset($cartItems['coupon_status'])){ ?>
                            <tr>
                                <td class="table-head-td"><?php echo $cartItems['coupon_status'];?></td>
                                <td><?php echo $cartItems['coupon_code'];?>&nbsp;<a href="javascript:void(0)" onclick="deleteCoupon('<?php echo $cartItems['coupon_code']?>')"><img src="images/cart-close.png"></a></td>
                            </tr>
                            <?php } ?>
                            
                         
                           
                            <tr>
                                <td class="table-head-td">Subtotal</td>
                                <td><?php echo DWS_CURRENCY_SYMBOL; ?> <?php echo $this->cart->format_number($cart_total); ?></td>
                            </tr>

                            <tr>
                                <td class="table-head-td">Vat</td>
                                <td><?php
                                    $vat = $order_total * (DWS_TAX / 100);
                                    echo DWS_CURRENCY_SYMBOL . ' ' . number_format($vat, 2);
                                    ?></td>
                            </tr>
                            <tr>
                                <td class="table-head-td">Grand Total </td>
                                <td><?php echo DWS_CURRENCY_SYMBOL; ?> <?php echo $this->cart->format_number($order_total + $vat); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-zero actions-col">
                <ul class="list-inline continue-cart-ul">
                    <li><a href="checkout" ><button type="button" class="btn btn-primary">Proceed to Checkout</button></a></li>
                </ul>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
$(document).ready(function(){
    $(".coupon-btn").on("click",function(){
        var cpCode = $(".coupon-input").val();
        var list = '';
        if(cpCode != ''){
            $.get('coupon/check_coupon/'+ cpCode, function(data){
                if(data != ''){
                    //alert(data.result);
                    //alert((JSON.stringify(data, null, 4)));
                    location.reload(); 
                }
                },'JSON'
            );
        }
        else{
            alert('Please enter coupon code!');
        }
    });  

    
});

function deleteCartItem(ctid, cpcode = ''){
    if(confirm('Are you sure you want to remove this item?')  == true)
    {
        $.get('cart/delete/'+ ctid, function(data){
                if(data!=''){
                    alert('Wish list Item Deleted');
                    if(cpcode != ''){
                        $.get('coupon/del_coupon/'+ cpcode, function(data){
                            if(data != ''){
                                //alert(data);
                                //alert((JSON.stringify(data, null, 4)));
                                location.reload();
                            }
                            },'JSON'
                        );
                    }
                    else{
                       location.reload();  
                    }
                      
                    
                    
                } 

            }
        );
        
    }
}

function deleteCoupon(cpcode = ''){
    if(confirm('Are you sure you want to remove this item?')  == true)
    {

        $.get('coupon/del_exist_coupon/'+ cpcode, function(data){
            if(data != ''){
                //alert(data);
                //alert((JSON.stringify(data, null, 4)));
                location.reload();
                }
            },'JSON'
        );
        
    }
}

</script>