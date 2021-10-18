<div id="left_column">
    <div id="side_top_bg">
        <h2><?php echo $category['category']; ?></h2>
    </div>
    <div id="sidenav">

        <?php if ($sub_categories)  ?>
        <ul>
            <?php foreach ($sub_categories as $row) { ?>
                <li><a href="catalog/<?php echo $row['category_alias']; ?>"><?php echo $row['category']; ?></a></li>
            <?php } ?>
        </ul>
        <?php ?>
    </div>
    <div id="side_bottom_bg"></div>
    <div class="fact_box">
        <h4>Bearing facts, help and info</h4>
        <?php
        $params = array(
            'menu_alias' => 'bearing_facts',
            'ul_format' => '{MENU}',
            'level_1_format' => '<a href="{HREF}" class="{CLASSES}" {ATTRIBUTES}>{LINK_NAME}</a>',
            'level_2_format' => '<a href="{HREF}" class="{CLASSES}" {ATTRIBUTES}>{LINK_NAME}</a>'
        );
        echo $CI->html->menu($params);
        ?>
    </div>
<!--    <div id="paypal"><img src="images/img-paypal.png" /></div>-->
    <div class="clearfix"></div>
    <!--    <div class="home_about_services_container">
            <ul class="leftbar_servies_quality_info_list" style="padding: 0;">
                <li><a href="#"> <img src="images/secuirty_info.png"></a></li>
                <li><a href="#"> <img src="images/services-abt-info.png"></a></li>
                <li><a href="#"> <img src="images/relocate-srv-info.png"></a></li>
            </ul>
        </div>-->
</div>
<div id="contents">
    <?php
    $cururi = uri_string();
    if ($cururi == 'catalog/services') {
        ?>
        <h1><?php echo $category['category']; ?></h1>
        <?php echo $category['category_desc']; ?>
        <p></p>
        <div id="select_product">
            <?php
            $i = 0;
            foreach ($sub_categories as $row) {
                $i++;
                ?>
                <div class="product<?php echo alternator("", " product_right", " product_right", " product_right"); ?>">
                    <div class="product_img">
                        <a href="catalog/<?php echo $row['category_alias']; ?>">
                            <img width="100" 
                                 src="<?php
                                 echo resize($this->config->item('CATEGORY_PATH') . $row['category_image'], 136, 144, 'category', $this->config->item('CATEGORY_PATH') . $row['category_image'], array('img_url' => 'images/logo.png', 'height' => 144, 'width' => 136, 'photoset_id' => 'logo')
                                 );
                                 ?>" alt="<?php echo $row['category']; ?>" />
                        </a></div>
                    <div class="product_text">
                        <h3><?php echo substr($row['category'], 0, 40) ?><?php echo (strlen($row['category']) > 40) ? '..' : "" ?></h3>
                        <p> <?php echo strip_tags(word_limiter($row['category_desc'], 20)); ?></p>
                    </div>
                    <div class="product_button">
                        <p><a href="catalog/<?php echo $row['category_alias']; ?>"><img src="images/readmore.png" /></a></p>
                    </div>
                </div>
                <?php
                if ($i % 4 == 0) {
                    echo '<div class="clear_both"></div>';
                }
                ?>
            <?php } ?>
        </div>


    <?php } else { ?>


        <h1><?php echo $category['category']; ?></h1>
        <?php echo character_limiter($category['category_desc'], 300); ?>
        <p></p>

        <p><strong>Please choose a category, or select a product from below to view.</strong></p>


        <div id="select_product">
            <?php
            $i = 0;
            foreach ($sub_categories as $row) {
                $i++;
                ?>
                <div class="product<?php echo alternator("", " product_right", " product_right", " product_right"); ?>">
                    <div class="product_img">
                        <a href="catalog/<?php echo $row['category_alias']; ?>">                            
                            <img width="100" 
                                 src="<?php
        echo resize($this->config->item('CATEGORY_PATH') . $row['category_image'], 100, 100, 'category'
                , $this->config->item('CATEGORY_PATH') . $row['category_image'], array('img_url' => 'images/logo.png',
            'height' => 100, 'width' => 100, 'photoset_id' => 'logo')
        );
                ?>" alt="<?php echo $row['category']; ?>" />
                        </a></div>
                    <div class="product_text">
                        <h3><?php echo substr($row['category'], 0, 40) ?><?php echo (strlen($row['category']) > 40) ? '..' : "" ?></h3>
                        <p> <?php echo strip_tags(word_limiter($row['category_desc'], 20)); ?></p>
                    </div>
                    <div class="product_button">
                        <p><a href="catalog/<?php echo $row['category_alias']; ?>"><img src="images/homepage/btn-view-products.png" /></a></p>
                    </div>
                </div>
                <?php
                if ($i % 4 == 0) {
                    echo '<div class="clear_both"></div>';
                }
                ?>
            <?php } ?>
        </div>
    <?php } ?>
</div>

