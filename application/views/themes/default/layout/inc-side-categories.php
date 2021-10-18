<?php

if ($trending_categories) {
    ?>
    <div class="container-fluid">
        <div class="color-product-section col-xs-12 padding-zero">
            <?php foreach (array_chunk($trending_categories, 2) as $main_key => $item) {
                ?>
                <div class="skin-parent-div col-xs-12 padding-zero">
                    <?php
                    foreach (array_chunk($trending_categories, 2) as $key => $items) {
                        $color_key =  ($main_key * 2 + $key);

                        if ($key == 0) {
                            $offset = 'col-xs-offset-2';
                        } else {
                            $offset = '';
                        }

                        if ($color_key == 0) {
                            $skincare = 'skincare-div1';
                            $icon = 'images/three.png';
                            $icon_alt = 'icon1';
                        } elseif ($color_key == 1) {
                            $skincare = 'skincare-div2';
                            $icon = 'images/one.png';
                            $icon_alt = 'icon2';
                        } elseif ($color_key == 2) {
                            $skincare = 'skincare-div3';
                            $icon = 'images/two.png';
                            $icon_alt = 'icon3';
                        } else {
                            $skincare = 'skincare-div4';
                            $icon = 'images/four.png';
                            $icon_alt = 'icon4';
                        }

                        $data = $items[$main_key];
                        ?>
                        <div class="<?= $skincare  ?> skin-div col-xs-6 padding-zero <?= $offset ?>" style="background:<?= $data['category']['category_color'];?> !important">
                            <div class="skin-logo-img">
                                <img src="<?= $icon ?>" alt="<?= $icon_alt ?>" class="shape-img">
                            </div>
                            <div class="skin-main-div">
                                <p class="skin-heading"> <?= $data['category']['name']; ?></p>
                                <p class="skin-text">
                                    <?= strip_tags(word_limiter($data['category']['description'], 12))   ?>
                                </p>
                                <a href="<?= base_url() . $data['category']['uri'] ?>" class="explore-div1 explore-div">Explore More</a>
                            </div>
                        </div>
                    <?php   } ?>
                </div>
            <?php  } ?>
        </div>
    </div>
    <?php
} ?>