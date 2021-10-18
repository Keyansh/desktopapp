<?php
if ($trending_categories) {
    ?>
    <div class="container-fluid">
        <div class="col-xs-12 products_col">
            <div class="col-xs-12 null-padding">
                <p class="offer_heading">SHOP BY CATEGORIES</p>
            </div>
            <div class="col-xs-12 pop-cat-main-div">
                <?php
                foreach ($trending_categories as $item):
                    if (file_exists($this->config->item('CATEGORY_PATH') . $item['category']['image']) && $item['category']['image']) {
                        $cat_img = resize($this->config->item('CATEGORY_PATH') . $item['category']['image'], 180, 192, 'category-image');
                    } else {
                        $cat_img = resize(FCPATH . 'images/a1.jpg', 180, 192, 'category-image');
                    }
                    ?>
                    <div class="col-xs-12 col-sm-4 pop-cat-inner">
                        <div class="img-div left-pop-div col-xs-6">
                            <a href="<?= base_url() . $item['category']['uri'] ?>">
                                <img src="<?= $cat_img ?>" alt="<?= ($item['category']['image_alt']) ? $item['category']['image_alt'] : $item['category']['name'] ?>" class="img-responsive">
                            </a>
                        </div>
                        <div class="col-xs-6 right-pop-div">
                            <p class="pop-tit-home">
                                <a class="category_heading" href="<?= base_url() . $item['category']['uri'] ?>">
                                    <?= $item['category']['name']; ?>
                                </a>
                            </p>
                            <ul class="ul-pop-home">
                                <?php
                                if ($item['sub_categories']) {
                                    foreach ($item['sub_categories'] as $subitem) {
                                        ?>
                                        <li><a href="<?= base_url() . $subitem['uri']; ?>"><?= $subitem['name']; ?></a></li>
                                        <?php
                                    }
                                }
                                ?>
                                <li><a class="seeall-a" href="<?= base_url() . $item['category']['uri'] ?>">see all</a></li>
                            </ul>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php
}
?>