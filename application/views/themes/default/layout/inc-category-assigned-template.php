<?php //e($category); 
?>

<?php
$templateData = assigned_template($category['category_template']);
?>
<?php if (!$products && !$sub_categories) { ?>
    <div class="site-container">
        <p class="no-product-found">no product</p>
    </div>
<?php } ?>
<?php if (isset($sub_categories) && $sub_categories) { ?>
    <section id="category-list">
        <div class="container-fluid ">
            <div class="site-container">
                <h1 class="category-title"><?= $category['name'] ?></h1>
            </div>
            <?php
            $loop_flag = 0;
            $category_count = count($sub_categories);
            foreach ($templateData as $item) {
                $column_count = count($item['blockElement']);
                $sliced_array = array_slice($sub_categories, $loop_flag, $column_count);
                $loop_flag = $loop_flag + $column_count;
            ?>
                <div class="lazyload col-xs-12 my_page_grid ">
                    <div class="site-container">
                        <div class="col-xs-12 category-listing-inner-col null-padding ">
                            <?php
                            if ($sliced_array) {
                                foreach ($sliced_array as $subKey => $sub_categories_data) {
                                    if (file_exists($this->config->item('CATEGORY_PATH') . $sub_categories_data['image']) && $sub_categories_data['image']) {
                                        $image_url = resize($this->config->item('CATEGORY_PATH') . $sub_categories_data['image'], 294, 389, 'category-listing');
                                    } else {
                                        $image_url = resize(base_url() . 'images/img-default.jpg', 294, 389, 'category-listing');
                                    }
                            ?>
                                    <div class="col-xs-12 col-sm-6 single-category-col <?= $item['layout_type'] ?>">
                                        <a href="<?php echo base_url() . $sub_categories_data['uri'] ?>" class="userlog" data-type="category" data-id="<?php echo $sub_categories_data['id'] ?>">
                                            <div class="single-category-col-img-col">
                                                <img class=" img-responsive" class="" src="<?php echo $image_url ?>" alt="<?php echo $sub_categories_data['image_alt'] ?>">
                                            </div>
                                            <div class="single-category-col-descr-col">
                                                <p class="single-category-heading"><?php echo $sub_categories_data['name'] ?></p>
                                            </div>
                                        </a>
                                    </div>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            <?php
            } ?>
        </div>
    </section>
<?php } ?>

<?php if (isset($products) && $products) { ?>
    <section id="product-listing-section">
        <div class="container-fluid site-container">
            <h1 class="category-title"><?= $category['name'] ?></h1>
            <div class="col-xs-12 product-listing-section">
                <?php
                foreach ($products as $item) :
                    if (file_exists($this->config->item('PRODUCT_PATH') . $item['img']) && $item['img']) {
                        $image_url = resize($this->config->item('PRODUCT_PATH') . $item['img'], 304, 422, 'product-listing-img');
                    } else {
                        $image_url = resize(FCPATH . 'images/img-default.jpg', 304, 422, 'product-listing-img');
                    }
                ?>
                    <div class="col-xs-12  col-sm-3 product-listing-item-div ">
                        <div class="col-xs-12  inner_products null-padding">
                            <div class="product-listing-img-div">
                                <?php if (!$this->session->userdata('CUSTOMER_ID')) { ?>
                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#logInPop">
                                    <?php } elseif ($this->session->userdata('CUSTOMER_ID')) { ?>
                                        <a href="<?= base_url() . $item['uri']; ?>" class="userlog" data-type="product" data-id="<?php echo $item['product_id'] ?>">
                                        <?php } ?>
                                        <img class=" img-responsive product-listing-img" src="<?= $image_url ?>" alt="<?= $item['imgalt']; ?>">
                                        </a>

                            </div>
                            <p class="product-listing-p">
                                <?php if (!$this->session->userdata('CUSTOMER_ID')) { ?>
                                    <a href="javascript:void(0)" data-toggle="modal" class="product-listing-a" data-target="#logInPop">
                                    <?php } elseif ($this->session->userdata('CUSTOMER_ID')) { ?>
                                        <a class="product-listing-a" href="<?= base_url() . $item['uri']; ?>">
                                        <?php } ?>
                                        <?= $item['name']; ?>
                                        </a>
                            </p>
                        </div>
                    </div>

                <?php
                endforeach;
                ?>
            </div>
        </div>
    </section>
<?php
}
?>
<style>
    .pagination {
        display: flex;
        justify-content: end;
    }
</style>
<section id="pagination">
    <div class="container-fluid site-container">
        <?php if ($pagination) { ?>
            <div class="product_pagination list-page-pagination">
                <div class="col-xs-12 col-md-12 col-lg-12 col-sm-12  pro_pagination_right null-padding">
                    <p class="tot-pro-detal" id="displaying-records">
                        <?= "Displaying 1 -" . count($products) . ' ' . "of $pagination_data->total_rows products" ?>
                    </p>

                    <?= $pagination; ?>

                </div>
            </div>
        <?php } ?>
    </div>
</section>