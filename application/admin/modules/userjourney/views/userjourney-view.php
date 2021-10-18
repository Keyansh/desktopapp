<style>
    .parent-div-user {
        border: 1px solid lightgray;
        margin-bottom: 15px;
        padding: 20px;
    }

    .main-title {
        border-bottom: 1px solid #495d80;
        font-size: 25px;
        padding: 0;
        padding-bottom: 10px;
        text-transform: capitalize;
        color: #263388;
        margin-bottom: 10px;
    }

    .pro-title {
        margin-top: 10px;
        font-size: 15px;
    }

    .inner-div-main {
        margin-bottom: 30px;
    }

    .listing-div {
        display: flex;
        flex-wrap: wrap;
    }
</style>
<h3 class="title-hero clearfix">
    View User journey
    <a href="userjourney" class="pull-right btn btn-primary">Manage User journey</a>
</h3>
<div class="panel">
    <div class="panel-body">
        <div class="example-box-wrapper">
            <?php $categoryAvaliable = getData('logger', array('comment' => $date, 'created_by' => $id, 'type' => 'category'));
            if ($categoryAvaliable) : ?>
                <div class="col-xs-12 parent-div-user">
                    <p class="col-xs-12 main-title">category</p>
                    <div class="col-xs-12 listing-div">
                        <?php
                         asort($userjourney);
                        foreach ($userjourney as $item) :
                            if ($item['type'] == 'category') :
                        ?>
                                <div class="col-xs-2 inner-div-main">
                                    <?php $categoryData = getData('category', 'id', $item['type_id']);
                                    if ($this->config->item('CATEGORY_IMAGE_URL') . $categoryData['image']) {
                                        $image_url = $this->config->item('CATEGORY_IMAGE_URL') . $categoryData['image'];
                                    } else {
                                        $image_url = 'images/img-default.jpg';
                                    }
                                    ?>
                                    <div class="img-div">
                                        <img src="<?= $image_url ?>" class="img-responsive" alt="" style="max-width:230px">
                                    </div>
                                    <p class="pro-title"><?= $categoryData['name'] ?></p>
                                </div>
                        <?php endif;
                        endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            <?php $productAvaliable = getData('logger', array('comment' => $date, 'created_by' => $id, 'type' => 'product'));
            if ($productAvaliable) : ?>
                <div class="col-xs-12 parent-div-user">
                    <p class=" col-xs-12 main-title">product</p>
                    <div class="col-xs-12 listing-div">
                        <?php foreach ($userjourney as $item) :
                            if ($item['type'] == 'product') :
                        ?>
                                <?php $productData = getData('product', 'id', $item['type_id']);

                                $productImage = getData('prod_img', array('pid' => $productData['id'], 'main' => 1));
                                if ($productImage) {
                                    $image_url = $this->config->item('PRODUCT_URL') . $productImage['img'];
                                } else {
                                    $image_url = 'images/img-default.jpg';
                                }
                                ?>
                                <div class="col-xs-2 inner-div-main">
                                    <div class="img-div">
                                        <img src="<?= $image_url ?>" class="img-responsive" alt="" style="max-width:230px">
                                    </div>

                                    <p class="pro-title"><?= $productData['name'] ?></p>
                                </div>
                        <?php endif;
                        endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>