<div class="container-fluid">
    <div class="col-xs-12 brochure padding-zero">
        <div class="col-xs-12 col-sm-5 left-part-brochure">
            <p class="b-20-20">
                <span>2020</span>
                Brochure
            </p>
            <p class="text-20-20">
                Lorem ipsum dolor sit amet, consectetur adipisicing
                elit, sed do eiusmod tempor incididunt ut labore.</p>
            <div class="btn-20-20">
            <?php  $BrochureHeader = BrochureHeader(); if($BrochureHeader){?>
            <a href="<?= $this->config->item('DOWNLOAD_PDF_URL') . $BrochureHeader['pdf']; ?>" target="_blank" class="btn-20-20-1">Download Brochure</a>
            <?php }?>
            <?php  $PricelistHeader = PricelistHeader(); if($PricelistHeader){?>
            <a href="<?= $this->config->item('DOWNLOAD_PDF_URL') . $PricelistHeader['pdf']; ?>" target="_blank" class="btn-20-20-2">Download Pricelist</a>
            <?php }?>
            
            </div>
        </div>



    </div>
</div>