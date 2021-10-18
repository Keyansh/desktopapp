<section id="breadcrumb">
    <div class="container-fluid site-container">
        <div class="col-xs-12 product_main_div null-padding">
            <ul class="breadcrumb about_page">
                <li><a href="<?= base_url() ?>">Home</a></li>
                <li class="active"><a href="javascript:void(0)"><?= $page['title'] ?></a></li>
            </ul>
        </div>
    </div>
</section>

<?php //e($project); 
?>
<section id="project-listing">
    <div class="container-fluid site-container">
        <div class="col-xs-12 project-listing padding-zero">
            <div class="col-xs-12 list-main-div padding-zero ">
                <div class="col-xs-12 project-listing-main-col padding-zero ">
                    <?php
                    foreach ($project as $item) {
                    ?>
                        <p class="prject-category-title">
                            <?= $item['name'] ?>
                        </p>

                        <div class="owl-carousel owl-theme projects">
                            <?php
                            foreach ($item['project'] as $innerItem) {
                            ?>
                                <div class="item">
                                    <div class="col-xs-12 project-single-col padding-zero ">
                                        <a href="project/details/<?php echo $innerItem['projects_alias']; ?>">
                                            <div class="project-img-div">
                                                <?php $image = getMainImage($innerItem['projects_id']);  ?>
                                                <?php
                                                $img = 'images/news-default.png';
                                                if ($image) {
                                                    $img = $this->config->item('PROJECTS_IMAGE_URL') . $image['img'];
                                                }
                                                ?>
                                                <img src="<?= $img ?>" alt="<?php echo $innerItem['projects_title']; ?>" class="img-responsive">
                                            </div>
                                            <p class="project-title">
                                                <?php echo $innerItem['projects_title']; ?>
                                            </p>
                                        </a>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
    $('.projects').owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 5
            }
        }
    })
</script>