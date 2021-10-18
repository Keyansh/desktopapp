<section id="single_product_col">
    <div class="container-fluid null-padding">
        <div class="col-xs-12 product_main_div null-padding">
            <ul class="breadcrumb about_page">
                <li><a href="<?= base_url() ?>">Home</a></li>
                <li class="active"><a href="javascript:void(0)">Wishlist</a></li>
            </ul>
        </div>
    </div>
</div>
</section>
<section id="different_products">
    <div class="container-fluid">
        <div class="col-xs-12 different-product-col">
            <div class="col-xs-12 col-md-2 col-sm-2 col-lg-2 different_pro_left-col wishlist_column">
                <div class="product_type">
                    <p>my account</p>
                    <div class="diff_types">
                        <ul class="list-unstyled wishlist_ul">
                            <li><a href="<?= base_url() . 'customer/order' ?>">My Orders</a></li>
                            <li><a href="<?= base_url() . 'customer/myaccount' ?>">Account Info</a></li>
                            <li><a href="<?= base_url() . 'customer/login' ?>"> Logout</a></li>
                        </ul>
                    </div>

                </div>

            </div>
            <div class="col-xs-12 col-md-10 col-sm-10 col-lg-10 different_pro_right-col wishlist_col">
                <div class="col-xs-12   wishlist-section">
                    <section id="top_rated_products">
                        <div class="container-fluid">
                            <div class="col-xs-12  null-padding">
                                <div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 ">
                                    <div class="common_headline_div">
                                        <p class="common-heading">My Wishlist</p>
                                    </div>
                                    <?php
                                    if (!$user_is_active_flag) {
                                        ?>
                                        <p class="sibn-p-w">Please sign-in to check your wishlist.</p>
                                        <?php
                                    } else {
                                        $customer_name = ucfirst($customer['first_name']) . ' ' . ucfirst($customer['last_name']);
                                        $sn = 1;
                                        $total_items = count($wishlist);
                                        if (!$wishlist) {
                                            ?>
                                            <p class="empty-wl">Dear <b><?= $customer_name ?></b>, your wishlist is empty !</p>
                                            <?php
                                        } else if ($wishlist) {
                                            $table_of_four = array();
                                            $table_of_odd = array();
                                            $odd_num = -1;
                                            ?>
                                            <p class="hi-wl">Hi <b><?= $customer_name ?></b>, you have <span id="total-items"><b><?= $total_items ?></b></span><b>item(s)</b> in your wishlist.</p>
                                            <?php
//                                            e($wishlist);
                                            foreach ($wishlist as $key => $item) :
                                                $odd_num += 4;
                                                $table_of_odd[] = $odd_num;
                                                if ($key == 0) {
                                                    $table_of_four[] = $key;
                                                } else {
                                                    $table_of_four[] = ($key * 4);
                                                }
                                                if (in_array($key, $table_of_four)) {
                                                    echo ' <div class="col-xs-12 top-products null-padding">';
                                                }
                                                $url_alias = base_url() . $item['uri'];
                                                if ($item['img']) {
                                                    if (file_exists($this->config->item('PRODUCT_PATH') . $item['img'])) {
                                                        $image_url = $this->config->item('PRODUCT_URL') . $item['img'];
                                                    } else {
                                                        $image_url = base_url() . 'images/a1.jpg';
                                                    }
                                                } else {
                                                    $img_in_wishlist = img_in_wishlist($item['product_id']);
                                                    if ($img_in_wishlist['img']) {
                                                        $image_url = $this->config->item('PRODUCT_URL') . $img_in_wishlist['img'];
                                                    } else {
                                                        $image_url = base_url() . "images/a1.jpg";
                                                    }
                                                }
                                                $pPrice = 0;
                                                if ($item['price'] > 0) {
                                                    $pPrice = $item['price'];
                                                } else {
                                                    $pPrice = get_least_child_price($item['product_id']);
                                                }
                                                ?>
                                                <div id="wishlist-id-<?= $item['id'] ?>" class="col-xs-12 col-md-3 col-lg-3 col-sm-3 inner_products null-padding">
                                                    <div class="inner_pro_images">
                                                        <span data-wishlist-id="<?= $item['id'] ?>" class="delete_icon remove-wishlist-item">
                                                            <img style="position:absolute;left:12px;top: 8px;" class="img-responsive" src="<?= base_url() . 'images/del_icon.png' ?>">
                                                        </span>
                                                        <a href="<?= base_url() . $item['uri'] ?>">
                                                            <img class="img-responsive inner_pro_img" src="<?= $image_url ?>" alt="<?= $item['imgalt'] ?>">
                                                        </a>
                                                    </div>
                                                    <p class="product_heading"><?= $item['name'] ?></p>
                                                    <p class="product_price">
                                                        <?php
                                                        if ($this->session->userdata('CUSTOMER_ID')) {
                                                            echo '<tree class="your_price">Price </tree>' . DWS_CURRENCY_SYMBOL . ' ' . number_format($pPrice, 2);
                                                        }
                                                        ?>
                                                    </p>
                                                    <ul class="list-inline">
                                                        <li><a class="common_button" href="<?= base_url() . $item['uri'] ?>">MOVE TO BAG</a></li>
                                                    </ul>
                                                </div>
                                                <?php
                                                if (in_array($key, $table_of_odd)) {
                                                    echo '</div>';
                                                }
                                            endforeach;
                                            ?>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</section>
<!--my code-->
<script type="text/javascript">
    $(document).ready(function () {
        $('.remove-wishlist-item').click(function () {
            if (confirm('Are you sure to remove this item from your wishlist ?')) {
                var current_element = $(this);
                var wishlist_id = current_element.attr('data-wishlist-id');
                var path = '<?= base_url() ?>wishlist/remove_item';

                $.post(path,
                        {
                            wishlist_id: wishlist_id
                        }, function (data, status) {
                    if (data == 'removed') {
                        var remove_elm = current_element.parent().parent().attr('id');
                        console.log(remove_elm);
                        $('#' + remove_elm).remove();
//                        current_element.closest('tr').remove();
                        var total_items = Number($('#total-items').text());
                        total_items--;
                        $('#total-items').text(total_items);
                    }
                });
            }
        });
        $('#remove-all-items').click(function () {
            if (confirm('Are you sure to remove all items from your wishlist ?')) {
                var path = '<?php echo base_url() ?>wishlist/remove_all_items';
                $.post(path,
                        {
                            customer_id: '<?= $customer["user_id"] ?>'
                        },
                        function (data, status) {
                            if (data == 'removed') {
                                $('#total-items').text(0);
                                $('#wishlist-table').remove();
                            }
                        });
            }
        });
    });
</script>
