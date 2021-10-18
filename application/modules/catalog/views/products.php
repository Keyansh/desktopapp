<style>
    .amount-div #amount{display:table;text-align:left;margin:auto;padding-top:15px;padding-bottom:10px}.amount-div #slider-range{margin-top:15px;margin-bottom:20px;height:8px;border:none;background-color:#e1e4e9}
</style>
<section id="single_product_col">
    <div class="container-fluid ">
        <div class="col-xs-12 product_main_div null-padding">
            <ul class="breadcrumb about_page">
                <li><a href="<?= base_url() ?>">Home</a></li>
                <?php if ($this->uri->segment(2)) { ?>
                    <li><a href="<?= $this->uri->segment(1) ?>"><?= $this->uri->segment(1) ?></a></li>
                <?php } ?>
                <li class="active"><a href="javascript:void(0)"><?= $category['name'] ?></a></li>
            </ul>
        </div>
    </div>

</section>

<section id="cat-list">
    <div class="container-fluid">
        <div class="col-xs-12 cat-list null-padding">

            <div class="col-xs-12 col-sm-9 cat-list_right-col ">
                <div class="col-xs-12 products_col null-padding">
                    <div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 products_left-col pro_full_width">

                        <div class="items_col">
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
                                <li class="grid-view-btn"><a href="#"><img src="images/g1.png" alt="loading"></a></li>
                                <li class="list-view-btn"><a href="#"><img src="images/g2.png" alt="loading"></a></li>
                            </ul>
                        </div>
                        <div class="col-xs-12 cat-listing-main-div">
                            <div class="col-xs-12 common-heading-col">
                                <p class="arrow-heading"><?= $category['name'] ?></p>
                            </div>
                            <div class="col-xs-12 products-listing-ajx">
                                <?php
                                if (isset($products)) {
                                    foreach ($products as $item) :
                                        if (file_exists($this->config->item('PRODUCT_PATH') . $item['img']) && $item['img']) {
                                            $image_url = resize($this->config->item('PRODUCT_PATH') . $item['img'], 300, 300, 'product-listing-img');
                                        } else {
                                            $image_url = resize(FCPATH . 'images/a1.jpg', 300, 300, 'product-listing-img');
                                        }
                                        $display_swatches = getProductAttrOptionSwatches($item['product_id']);
                                        ?>
                                        <div class="col-xs-12  col-sm-3 inner_products-outer ">
                                            <div class="col-xs-12  inner_products null-padding">
                                                <div class="product_img-col">
                                                    <a href="<?= base_url() . $item['uri']; ?>">
                                                        <img class=" img-responsive inner_pro_img"   class="" src="<?= $image_url ?>" alt="<?= $item['imgalt']; ?>">
                                                    </a>
                                                </div>
                                                <div class="products-descr_col">
                                                    <p class="proheading-p">
                                                        <a class="product_heading" href="<?= base_url() . $item['uri']; ?>">    
                                                            <?= $item['name']; ?>
                                                        </a>
                                                    </p>
                                                    <p class="products-dec">
                                                        <?= word_limiter(strip_tags($item['description']), 6) ?>
                                                    </p> 
                                                    <?php if (isset($display_swatches) && $display_swatches) { ?>
                                                        <div class="col-xs-12 product-assigned-swatches null-padding">
                                                            <ul class="list-inline">
                                                                <?php
                                                                $swatch_count = 0;
                                                                $total_swatches = 0;
                                                                foreach ($display_swatches as $display_swatches_item) {
                                                                    if (file_exists($this->config->item('ATTRIBUTE_OPTION_ICON_PATH') . $display_swatches_item['icon']) && $display_swatches_item['icon']) {
                                                                        $total_swatches++;
                                                                        if($swatch_count == 5){
                                                                            break;
                                                                        }else{
                                                                            $swatch_count++;
                                                                        }
                                                                        ?>
                                                                        <li>
                                                                            <img src="<?php echo $this->config->item('ATTRIBUTE_OPTION_ICON_URL') . $display_swatches_item['icon']; ?>" class="img-responsive" alt="<?php echo $display_swatches_item['option']; ?>" />
                                                                        </li>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                                        <?php 
                                                                            $more_swatches = $total_swatches - $swatch_count;
                                                                            if($more_swatches > 0){
                                                                        ?>
                                                                            <li>
                                                                                <?php echo '+'.str_replace('-','',$more_swatches) ; ?>
                                                                            </li>
                                                                        <?php } ?>
                                                            </ul>
                                                        </div>
        <?php } ?>
        <?php if (isset($item['product_stock_status']) && $item['product_stock_status'] == 0) { ?>
                                                        <div class="cat-list-btn-div">
                                                            <a  href="javascript:void(0)" class="common-btn">
                                                                Out of Stock !
                                                            </a>
                                                        </div>
        <?php } elseif (isset($item['product_stock_status']) && $item['product_stock_status'] == 1) { ?>
                                                        <div class="cat-list-btn-div">
                                                            <a  href="javascript:void(0)" class="common-btn">
                                                                Coming Soon !
                                                            </a>
                                                        </div>
                                                        <?php
                                                    } else {
                                                        if ($item['type'] == 'config') {
                                                            
                                                        } else {
                                                            if ($item['current_quantity'] <= 0) {
                                                                ?>
                                                                <div class="cat-list-btn-div">
                                                                    <a  href="javascript:void(0)" class="common-btn">
                                                                        Coming Soon !
                                                                    </a>
                                                                </div>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <div class="cat-list-btn-div">
                                                                    <a  href="<?= base_url() . $item['uri']; ?>" class="common-btn">
                                                                        <img src="images/listing-wish.png" class="img-responsive" /> Add to wishlist
                                                                    </a>
                                                                </div>

                                                                <?php
                                                            }
                                                        }
                                                    }
                                                    ?>   
                                                </div>
                                            </div>
                                        </div>

                                        <?php
                                    endforeach;
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-xs-12 category-description-page-col null-padding">
<?= $category['description'] ?>
                        </div>
                    </div>

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

            <div class="col-xs-12 col-sm-4 right-sidebar-col">
<?php $this->load->view('themes/' . THEME . '/layout/inc-latest-news-widget'); ?>
            </div>


            <!--            <div class="col-xs-12 col-sm-3 cat-list_left-col">
                            <div class="panel-group filter-list-accordion">
                                <div class="panel panel-default ">
                                    <div class="panel-heading different_pro_col">
                                        <h4 class="panel-title product_type">
                                            <a data-toggle="collapse" href="#category_filters">Fort Doors Product Range</a>
                                        </h4>
                                    </div>
                                    <div id="category_filters" class="panel-collapse collapse in">
                                        <div class="panel-body">
                                            <ul class="filter-custom-list">
<?php foreach ($all_parent_categories as $all_parent_category) { ?>
                                                        <li>
                                                            <div class="custom-checkbox">
                                                                <a href="<?php echo $all_parent_category['uri']; ?>" class="custom-category-link"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $all_parent_category['name']; ?></a>
                                                            </div>
                                                        </li>
<?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
            
            <?php
            if ($attribute_filter) {
                foreach ($attribute_filter as $k => $v) {
                    $attribute_name = attribute_label_by_id($k);
                    ?>
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">
                                                            <a data-toggle="collapse" href="#collapse<?php echo $k; ?>">
                                                                <p><?= ucwords($attribute_name); ?></p>
                                                            </a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapse<?php echo $k; ?>" class="panel-collapse collapse in">
                                                        <div class="panel-body">
                                                            <ul class="filter-custom-list">
                    <?php
                    foreach ($v as $k2 => $v2) {
                        $tmp_attributes = isset($selected_attributes[$k]) ? $selected_attributes[$k] : [];
                        $checked = "";
                        if (in_array($k2, $tmp_attributes)) {
                            $checked = "checked='checked'";
                        }
                        ?>
                                                                        <li>
                                                                            <label class="custom-checkbox">
                                                                                <i class="fa fa-angle-right" aria-hidden="true"></i>
                                                                                <span class="custom-label"><?= attribute_option_by_id($k2); ?></span>
                                                                                <input class="custom-input filter_attribute_option" type="checkbox" parent_name="<?= strtolower($attribute_name) ?>" attribute_name='<?= attribute_option_by_id($k2); ?>' attr-index="<?php echo $k ?>" autocomplete="off" data-attribute-id="<?= $k; ?>" <?= $checked ?> value="<?= $k2; ?>" />
                                                                                <span class="custom-box">
                                                                                    <i class="fa fa-check"></i>
                                                                                </span>
                                                                            </label>
                                                                        </li>
                        <?php
                    }
                    ?>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                    <?php
                }
            }
            ?>
            
                            </div> 
            
                            <div class="applyFilters">
                                <span><i class="fa fa-check-square-o"></i>Apply Filters</span>
                            </div>
                            <span class="close-btn-filter">close</span>
                        </div>-->
        </div>
    </div>
</section>






<!--shop by price-->
<link type="text/css" rel="stylesheet" href="<?= base_url() ?>css/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!--shop by price-->
<script src="http://malsup.github.io/jquery.blockUI.js"></script>
<script type="text/javascript">
    var category_id = '<?php echo $category['id']; ?>';
    var category_url = '<?= $category_url ?>';
    var category_alias = '<?= $category_alias ?>';
    var min = parseInt('<?php echo intval($category_price_range['min_price']); ?>');
    var max = parseInt('<?php echo intval($category_price_range['max_price']); ?>');
    var minslider = parseInt('<?php echo intval($price_slider['min']); ?>');
    var maxslider = parseInt('<?php echo intval($price_slider['max']); ?>');
    var urlParameters = {
        attributes: {},
        brands: [],
        perpage: 0,
        maxprice: maxslider ? maxslider : max,
        minprice: minslider ? minslider : min,
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
        if (!urlShouldChange)
            return;

        window.history.pushState('', '', category_url + URL);
        return URL;
    }

    $(document).ready(function () {
        var selected_min_price = 0;
        var selected_max_price = 0;
        var perPage = $('#perpagepro').val();
        var catURI = '<?php echo $this->uri->uri_string(); ?>';

        //Jaskaran filter code
        function custom_filter() {
            var selected_attribute_options = [];
            $(".filter_attribute_option:checked").each(function (index, elem) {
                selected_attribute_options.push($(elem).val());
            });

            $('.cat-list').block({
                message: '<h1>Processing...</h1>',
                css: {
                    textAlign: 'center',
                    color: '#fff',
                    border: '0px solid #aaa',
                    cursor: 'wait',
                    backgroundColor: 'transparent',
                }
            });

            $.post('catalog/filter/index/', {category_id, selected_attribute_options}, function (data, status) {
                var res = JSON.parse(data);
                if (res.html != '') {
                    $('.products-listing-ajx').html(res.html);
                    $("html, body").animate({scrollTop: 0}, 1000);
                }
                $('.cat-list').unblock();
            });

        }

        $('.filter-custom-list label.custom-checkbox').click(function (e) {
            e.preventDefault();
            if ($(this).find('.custom-input').is(':checked')) {
                $(this).find('.custom-input').prop('checked', false);
            } else {
                $(this).find('.custom-input').prop('checked', true);
            }
            custom_filter();
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
<script>
    gtag('event', 'view_item_list', {
        "items": <?php echo $jsonItemsArr; ?>
    });
</script>
