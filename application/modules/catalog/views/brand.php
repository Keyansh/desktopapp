<section id="single_product_col">
    <div class="container-fluid null-padding">
        <div class="col-xs-12 product_main_div null-padding">
            <ul class="breadcrumb about_page">
                <li><a href="<?= base_url() ?>">Home</a></li>
                <li class="active"><a href="javascript:void(0)"><?= $brand['name'] ?></a></li>
            </ul>
        </div>
    </div>
</section>
<section id="different_products">
    <div class="container-fluid">
        <div class="col-xs-12 different-product-col">
            <div class="col-xs-12 col-md-2 col-sm-2 col-lg-2 different_pro_left-col">
                <?php
                if ($attribute_filter) {
                    foreach ($attribute_filter as $k => $v) {
                        ?>
                        <div class="product_type">
                            <?php $attribute_name = attribute_label_by_id($k); ?>
                            <p><?= ucwords($attribute_name); ?></p>
                            <div class="diff_types">
                                <?php
                                foreach ($v as $k2 => $v2) {
                                    $tmp_attributes = isset($selected_attributes[$k]) ? $selected_attributes[$k] : [];
                                    $checked = "";
                                    if (in_array($k2, $tmp_attributes)) {
                                        $checked = "checked='checked'";
                                    }
                                    ?>
                                    <label class="pro_name">
                                        <span class="attribute-option-anchor"><?= attribute_option_by_id($k2); ?></span>
                                        <input parent_name="<?= strtolower($attribute_name) ?>" attribute_name="<?= attribute_option_by_id($k2); ?>" name="option_checkbox" attr-index="<?php echo $k ?>" autocomplete="off" class="attribute-option" data-attribute-id="<?= $k; ?>" type="checkbox" <?= $checked ?> value="<?= $k2; ?>">
                                        <span class="checkmark"></span>
                                    </label>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
            <div class="col-xs-12 col-md-10 col-sm-10 col-lg-10 different_pro_right-col">
                <section id="top_rated_products">
                    <div class="container-fluid">
                        <div class="col-xs-12 products_col null-padding">
                            <div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 products_left-col pro_full_width">
                                <div class="common_headline_div">
                                    <p class="common-heading">
                                        Brand
                                        <span>
                                            <img src="<?= resize($this->config->item('BRAND_IMAGE_PATH') . $brand['image'], 217, 60, 'brand-image') ?>" class="" alt="<?= $brand['alt'] ?>"  title="<?= $brand['name'] ?>" >
                                        </span>
                                    </p>
                                </div>
                                <div style="display:block" class="items_col">
                                    <ul class="list-inline">
                                        <li>show<span>
                                                <select id="perpagepro">
                                                    <option value="15">15</option>
                                                    <option value="20">20</option>
                                                    <option value="30">30</option>
                                                    <option value="48">48</option>
                                                </select>
                                            </span>
                                        </li>
                                        <li>per page </li>
                                        <li class="filter_button">
                                            <button type="button" class="cat-filter-btn">
                                                <i class="fa fa-filter"></i>
                                                <span>Filter</span>
                                            </button>

                                        </li>
                                    </ul>
                                    <ul class="list-inline">
                                        <li>View <span>as</span></li>
                                        <li class="grid-view-btn active"><a href="#"><img src="images/g1.png" alt="loading"></a></li>
                                        <li class="list-view-btn"><a href="#"><img src="images/g2.png" alt="loading"></a></li>
                                    </ul>
                                </div>

                                <?php
                                if (isset($products)) {
                                    $table_of_four = array();
                                    $table_of_odd = array();
                                    $odd_num = -1;
                                    echo ' <div id="products-div">';
                                    foreach ($products as $key => $item) :
//                                        dynamic condition
                                        $odd_num += 4;
                                        $table_of_odd[] = $odd_num;
                                        if ($key == 0) {
                                            $table_of_four[] = $key;
                                        } else {
                                            $table_of_four[] = ($key * 4);
                                        }
//                                        dynamic condition
                                        if (file_exists($this->config->item('PRODUCT_PATH') . $item['img']) && $item['img']) {
                                            $image_url = resize($this->config->item('PRODUCT_PATH') . $item['img'], 234, 250, 'product-listing-img');
                                        } else {
                                            $image_url = resize(FCPATH . 'images/a1.jpg', 234, 250, 'product-listing-img');
                                        }

                                        if (in_array($key, $table_of_four)) {
                                            echo '<div class="col-xs-12 top-products null-padding">';
                                        }
                                        ?>
                                        <div class="col-xs-12 col-md-3 col-lg-3 col-sm-3 inner_products null-padding">
                                            <div class="product_img-col">
                                                <a href="<?= base_url() . $item['uri']; ?>">
                                                    <img class=" img-responsive inner_pro_img" class="" src="<?= $image_url ?>" alt="<?= $item['imgalt']; ?>">
                                                </a>
                                            </div>
                                            <div class="products-descr_col">
                                                <p class="product_heading-sku"><?= $item['sku']; ?></p>
                                                <p class="proheading-p">
                                                    <a class="product_heading" href="<?= base_url() . $item['uri']; ?>">    
                                                        <?= $item['name']; ?>
                                                    </a>
                                                </p>
                                                <?php
                                                $product_price = 0;
                                                if ($item['price'] > 0) {
                                                    $product_price = $item['price'];
                                                } else {
                                                    $product_price = $item['least_price'];
                                                }
                                                ?>
                                                <p class="product_price product-new-css">
                                                    <?php
                                                    if ($this->session->userdata('SELECTED_VAT') == 'exclusive_vat') {
                                                        if ($item['is_offer_discount']) {
                                                            echo '<tree class="your_price"></tree>' . DWS_CURRENCY_SYMBOL . number_format($item['is_offer_discount'], 2);
                                                            echo '<span class="strip-price">' . DWS_CURRENCY_SYMBOL . number_format($product_price, 2) . '</span><br>';
                                                            echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format(($item['is_offer_discount'] + $item['is_offer_discount'] * DWS_TAX / 100), 2) . ' ' . 'Inc. VAT)</span>';
                                                        } else {
                                                            echo '<tree class="strip-price"></tree>' . DWS_CURRENCY_SYMBOL . number_format($product_price, 2) . '<br>';
                                                            echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format(($product_price + $product_price * DWS_TAX / 100), 2) . ' ' . 'Inc. VAT)</span>';
                                                        }
                                                    } elseif ($this->session->userdata('SELECTED_VAT') == 'inclusive_vat') {
                                                        if ($item['is_offer_discount']) {
                                                            echo '<tree class="your_price"></tree>' . DWS_CURRENCY_SYMBOL . number_format(($item['is_offer_discount'] + $item['is_offer_discount'] * DWS_TAX / 100), 2);
                                                            echo '<span class="strip-price">' . DWS_CURRENCY_SYMBOL . number_format($product_price, 2) . '</span><br>';
                                                            echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format($item['is_offer_discount'], 2) . ' ' . 'Excl. VAT)</span>';
                                                        } else {
                                                            echo '<tree class="strip-price"></tree>' . DWS_CURRENCY_SYMBOL . number_format(($product_price + $product_price * DWS_TAX / 100), 2) . '<br>';
                                                            echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format($product_price, 2) . ' ' . 'Excl. VAT)</span>';
                                                        }
                                                    } else {
                                                        if ($item['is_offer_discount']) {
                                                            echo '<tree class="your_price"></tree>' . DWS_CURRENCY_SYMBOL . number_format($item['is_offer_discount'], 2);
                                                            echo '<span class="strip-price">' . DWS_CURRENCY_SYMBOL . number_format($product_price, 2) . '</span><br>';
                                                            echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format(($item['is_offer_discount'] + $item['is_offer_discount'] * DWS_TAX / 100), 2) . ' ' . 'Inc. VAT)</span>';
                                                        } else {
                                                            echo '<tree class="strip-price"></tree>' . DWS_CURRENCY_SYMBOL . number_format($product_price, 2) . '<br>';
                                                            echo '<span style="color:#999999" class="your_price">(' . DWS_CURRENCY_SYMBOL . number_format(($product_price + $product_price * DWS_TAX / 100), 2) . ' ' . 'Inc. VAT)</span>';
                                                        }
                                                    }
                                                    ?>
                                                </p>
                                                <?php
                                                $avgrate = 0;
                                                $avgrate = review_rate($item['product_id']);
                                                if ($avgrate) {
                                                    ?>
                                                    <ul class="list-inline star_ul_icons product-list-start-ul">
                                                        <?php
                                                        if ($avgrate > 0) {
                                                            for ($i = 0; $i < $avgrate; $i++) {
                                                                ?>
                                                                <li><img class="star-icon" src="images/star-on.png" alt="star-on"></li>
                                                                <?php
                                                            }
                                                            for ($i = $avgrate; $i < 5; $i++) {
                                                                ?>
                                                                <li><img class="star-icon" src="images/star-off.png" alt="star-off"></li>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </ul>
                                                <?php } ?>
                                                <ul class="list-inline product-list-page-btn-ul">
                                                    <?php
                                                    if ($item['type'] == 'config') {
                                                        if (isset($item['product_id']) && $item['product_id']) {
                                                            if (!child_stock($item['product_id'])) {
                                                                ?>
                                                                <li><a class="common_button product-list-page-btn" href="javascript:void(0)">Out of Stock !</a></li>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <li><a class="common_button product-list-page-btn addBtn" href="<?= base_url() . $item['uri']; ?>">View</a></li>
                                                                <?php
                                                            }
                                                        }
                                                    } else {
                                                        if ($item['current_quantity'] <= 0) {
                                                            ?>
                                                            <li><a class="common_button product-list-page-btn" href="javascript:void(0)">Out of Stock !</a></li>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <li><a class="common_button product-list-page-btn addBtn" href="<?= base_url() . $item['uri']; ?>">View</a></li>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                    <li>
                                                        <a data-fancybox="" href="<?= $image_url ?>">
                                                            <i class="fa fa-search" aria-hidden="true"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <?php
                                        if (in_array($key, $table_of_odd)) {
                                            echo '</div>';
                                        }
                                    endforeach;
                                    echo '</div>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </section>
                <?php if ($pagination) { ?>
                    <div class="product_pagination list-page-pagination">
                        <div class="col-xs-12 col-md-12 col-lg-12 col-sm-12  pro_pagination_right null-padding">
                            <p class="tot-pro-detal" id="displaying-records">
                                <?= "Displaying 1 -" . count($products) . ' ' . "of $pagination_data->total_rows products" ?>
                            </p>
                            <ul class="pagination">
                                <div class="ajaxPagination">
                                    <?= $pagination; ?>
                                </div>
                            </ul>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="http://malsup.github.io/jquery.blockUI.js"></script>
<script type="text/javascript">
    var brand_alias = '<?= $brand['alias'] ?>';
    var urlParameters = {
        attributes: {},
        brands: [],
        perpage: 0,
        page: 1
    };
</script>

<script type="text/javascript">
    function changeTheUrl() {
        var urlShouldChange = false;
        var URL = '';
        if (Object.keys(urlParameters.attributes).length) {
            for (x in urlParameters.attributes)
                URL += "~" + x + "-" + urlParameters.attributes[x].join(',');
            urlShouldChange = true;
        }
        if (urlParameters.brands.length) {
            URL += "~brands-" + urlParameters.brands.join(',');
            urlShouldChange = true;
        }
        if (typeof urlParameters.maxprice == 'string' && typeof urlParameters.minprice == 'string') {
            URL += "~maxprice-" + urlParameters.maxprice + "~minprice-" + urlParameters.minprice;
            urlShouldChange = true;
        }
        if (urlParameters.perpage) {
            URL += "~perpage-" + urlParameters.perpage;
            urlShouldChange = true;
        }
        if (urlParameters.page > 1) {
            URL += "~page-" + urlParameters.page;
            urlShouldChange = true;
        }
        // console.log(URL);
        if (!urlShouldChange)
            return;

        window.history.pushState('', '', brand_alias + URL);
        return URL;
    }

    $(document).ready(function () {
        var selected_min_price = 0;
        var selected_max_price = 0;

        function filter(parameter) {
            if (parameter) {
                var no_offset = parameter;
            } else {
                var no_offset = '';
            }
            var price = "";
            var flag = 0;
            // Scan attributes
            var options = "";
            var flag = 0;
            $('.attribute-option').each(function (index, element) {
                if ($(element).prop('checked') == true) {
                    if (flag == 1) {
                        options += ',';
                    }
                    options += $(element).val();
                    flag = 1;
                }
            });
            urlParameters.attributes = {};
            urlParameters.brands = [];
            $('.attribute-option').each(function (index, element) {
                if (!$(this).hasClass('brand-option') && $(this).is(':checked')) {
                    if (typeof urlParameters.attributes[ $(this).attr('parent_name') ] == 'undefined')
                        urlParameters.attributes[ $(this).attr('parent_name') ] = Array();
                    urlParameters.attributes[ $(this).attr('parent_name') ].push($(this).attr('attribute_name'));
                } else if ($(this).hasClass('brand-option') && $(this).is(':checked')) {
                    urlParameters.brands.push($(this).attr('brand_name'));
                }
            });

            var url = brand_alias + changeTheUrl();

            $('body').block({
                message: 'please wait...',
                css: {
                    textAlign: 'center',
                    color: '#fff',
                    border: '0px solid #aaa',
                    cursor: 'wait',
                    backgroundColor: 'transparent'
                }
            });

            $.post('catalog/filter/brand/' + url,
                    {
                        bid: '<?= $brand["id"] ?>',
                        price: price,
                        options: options,
                        selected_min_price: selected_min_price,
                        selected_max_price: selected_max_price,
                        url: url,
                        brand_alias: brand_alias,
                        no_offset: no_offset
                    },
                    function (data, status) {
                        if (data) {
                            var re_data = data;
                        } else {
                            var re_data = '{"html":"<div>No records</div>"}';
                        }
                        data = JSON.parse(re_data);
                        console.log(data);
                        if (data.html == "<div>No records</div>")
                        {
                            $('#products-div').empty();
                            $('#displaying-records').empty();
                            $('body').unblock();
                        } else {
                            $('.ajaxPagination').html('');
                            $('#products-div').empty();
                            $('#displaying-records').empty();

                            $('.ajaxPagination').html(data.pagination);
                            $('#displaying-records').html(data.displaying_records);
                            $('#products-div').html(data.html);
                            $("HTML, BODY").animate({scrollTop: 0}, 1000);
                            $('body').unblock();
                        }
                    });
        }

        var bid = '<?php echo $brand['id'] ?>';

        $('.price-option-anchor').click(function (e) {
            e.preventDefault();
            $(this).prev().trigger('click');
        });

        $('.attribute-option-anchor').click(function (e) {
            e.preventDefault();
            $(this).prev().trigger('click');
        });

        $('.attribute-option').click(function () {
            filter();
        });

        $('#low-btn').click(function () {
            filter('low');
        });

        $('#high-btn').click(function () {
            filter('high');
        });

        $('#perpagepro').on('change', function () {
            var perPage = $('#perpagepro').val();
            urlParameters.perpage = perPage;
            filter('low', 0, perPage);
        });
        $(document).on('click', '.ajaxPagination a', function (e) {
            e.preventDefault();
            var objProp = $(this);
            var perpage = objProp.prop('href').split('/').pop();
            var perpage1 = objProp.prop('href').split('~page-').pop();
            var perPage = $('#perpagepro').val();
            var currentPage = +objProp.html();
            if (isNaN(currentPage))
                return;
            urlParameters.page = perpage1;
            filter("false", perpage, perPage);
        });
    });

</script>
