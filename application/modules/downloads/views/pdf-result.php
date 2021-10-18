<style>
    .product-to-view {
        display: none;
    }
</style>
<section id="bredcrumbs">
    <div class=" container-fluid site-container">
        <div class="col-xs-12 product_main_div null-padding">
            <ul class="breadcrumb about_page">
                <li><a href="<?= base_url() ?>">Home</a></li>
                <li class="active"><a href="javascript:void(0)">Downloads</a></li>
            </ul>
        </div>
    </div>
</section>

<div class="heading-content-div">
    <p style="text-align: center;"><h1 style="font-size: 30px; color: #263388; text-align:center">Downloads</h1></p>
</div>

<?php if (count($getAllPdf) > 0) { ?>

    <section id="download">
        <div class="container-fluid site-container">
            <div class="col-xs-12 download ">
                <div class="col-xs-12 inner-download">
                    <?php foreach ($getAllPdf as $item) { ?>
                        <div class="download_main_info col-xs-12 col-sm-3 ">
                            <div class="download_inner col-xs-12">
                                <?php if ($item['display_login'] != 1) { ?>
                                    <?php if (!$this->session->userdata('CUSTOMER_ID')) { ?>
                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#logInPop">
                                        <?php  } elseif ($this->session->userdata('CUSTOMER_ID')) { ?>
                                            <a href="<?php echo $this->config->item('DOWNLOAD_PDF_URL') . $item['pdf']; ?>" target="_blank">
                                            <?php } ?>
                                        <?php } else { ?>
                                            <a href="<?php echo $this->config->item('DOWNLOAD_PDF_URL') . $item['pdf']; ?>" target="_blank">
                                            <?php }  ?>
                                            <div class="download_text">
                                                <ul class="images-ul">
                                                    <li>
                                                        <img src="images/Consort_Hardware.png" alt="download-image" class="img-responsive">
                                                    </li>
                                                    <li>
                                                        <img src="images/pdf-file-2.png" alt="download-image" class="img-responsive">
                                                    </li>
                                                </ul>
                                                <!-- <img src="<?php echo $this->config->item('DOWNLOAD_IMAGE_URL') . $item['icon']; ?>" alt="download-image" class="img-responsive"> -->
                                            </div>
                                            <div class="download-image-line"></div>
                                            <div class="download_head">
                                                <p class="download_name"> <?= $item['title'] ?></p>
                                            </div>
                                            </a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
<?php } else { ?>
    <p class="no-downloads">No Downloads</p>
<?php } ?>