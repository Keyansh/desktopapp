<section id="single_product_col">
    <div class="container-fluid ">
        <div class="col-xs-12 product_main_div null-padding">
            <ul class="breadcrumb about_page">
                <li><a href="<?= base_url() ?>">Home</a></li>
                <li class="active"><a href="javascript:void(0)">Gallery</a></li>
            </ul>
        </div>
    </div>
</section>
<section id="single_product_col1">


<div class="container-fluid">
    <div class="col-xs-12 gallery-main-div">
        <div class="col-xs-12 gallery-main-div-inner padding-zero">
            <p class="galler-title">Gallery</p>
            <div class="col-xs-12 padding-zero col-sm-8 gallery-main-div-inner-left">
                
                        <div class="col-xs-12 gallery-img-main-div-inner">
                            <div class="gallery-img-div">


                                <!-- <?php 
                                foreach ($gallery as $value){   ?>
                                <a data-fancybox="gallery" class="mag-glass" href="<?php echo $this->config->item('GALLERY_IMAGE_URL') . $value['image']; ?>"><i
                                                        class="fa fa-search-plus" aria-hidden="true"></i>
                                </a>
                                    <?php } ?> -->

                                <img src="" alt="" class="img-responsive">
                            </div>
                            <p class="gallery-img-div-inner-title">
                            
                            </p>
                            <p class="gallery-img-main-div-title">
                            
                            </p>
                            <span class="owl-prev"></span>
                            <span class="owl-next"></span>
                        </div>
                    
            </div>
            <div class="col-xs-12  col-sm-4 gallery-main-div-inner-right">
                <div class="col-xs-12 gallery-main-div-inner-right-inner">
            <?php 
                    foreach ($gallery as $value){   ?>
                    <div class="col-xs-12 col-sm-4 thumbnil-img">
                        <img src="<?php echo 
                        resize($this->config->item('GALLERY_IMAGE_PATH') . $value['image'], 128, 60, 'gallery_images' );
                         ?>" alt="" class="img-responsive"
                         data-img-src="<?php echo
                                resize($this->config->item('GALLERY_IMAGE_PATH') . $value['image'], 953, 441, 'gallery_images' );
                                ?>"
                         data-project-name=" <?php echo $value['project_name'] ?>"       
                         data-project-location=" <?php echo $value['location'] ?>"       
                         >
                    </div>
                        <?php } ?>
            </div>
            </div>
        </div>
    </div>
</div>
</section>



<script>
$(document).ready(function() {

    
$(".gallery-main-div-inner-right-inner .thumbnil-img:nth-of-type(1) ").addClass("active");


        var bigimgactive = $(".gallery-main-div-inner-right-inner .thumbnil-img.active").find('.img-responsive').attr("data-img-src");
        var projectNameactive = $(".gallery-main-div-inner-right-inner .thumbnil-img.active").find('.img-responsive').attr("data-project-name");
        var projectLocationactive = $(".gallery-main-div-inner-right-inner .thumbnil-img.active").find('.img-responsive').attr("data-project-location");
      
      $(".gallery-img-div").find('.img-responsive').attr("src",bigimgactive);
      $(".gallery-img-main-div-inner").find('.gallery-img-div-inner-title').text(projectNameactive);
      $(".gallery-img-main-div-inner").find('.gallery-img-main-div-title').text(projectLocationactive);



    $(document).on("click",".thumbnil-img",function() {

        var bigimg = $(this).find('.img-responsive').attr("data-img-src");
        var projectName = $(this).find('.img-responsive').attr("data-project-name");
        var projectLocation = $(this).find('.img-responsive').attr("data-project-location");
        $(this).parents(".gallery-main-div-inner-right-inner").find('.active').removeClass("active");
      $(this).addClass("active");
      $(".gallery-img-div").find('.img-responsive').attr("src",bigimg);
      $(".gallery-img-main-div-inner").find('.gallery-img-div-inner-title').text(projectName);
      $(".gallery-img-main-div-inner").find('.gallery-img-main-div-title').text(projectLocation);

    });
    
    $(document).on("click",".gallery-main-div-inner-left .owl-next",function() {

        var bigimgactive = $(".gallery-main-div-inner-right-inner .thumbnil-img.active").next('.thumbnil-img').find('.img-responsive').attr("data-img-src");
        var projectNameactive = $(".gallery-main-div-inner-right-inner .thumbnil-img.active").next('.thumbnil-img').find('.img-responsive').attr("data-project-name");
        var projectLocationactive = $(".gallery-main-div-inner-right-inner .thumbnil-img.active").next('.thumbnil-img').find('.img-responsive').attr("data-project-location");
        $(".gallery-main-div-inner-right-inner .thumbnil-img.active").next('.thumbnil-img').addClass("active");
        $(".gallery-main-div-inner-right-inner .thumbnil-img.active").prevAll('.thumbnil-img').removeClass("active");
        

      $(".gallery-img-div").find('.img-responsive').attr("src",bigimgactive);
      $(".gallery-img-main-div-inner").find('.gallery-img-div-inner-title').text(projectNameactive);
      $(".gallery-img-main-div-inner").find('.gallery-img-main-div-title').text(projectLocationactive);

    });

    $(document).on("click",".gallery-main-div-inner-left .owl-prev",function() {

        var bigimgactive = $(".gallery-main-div-inner-right-inner .thumbnil-img.active").prev('.thumbnil-img').find('.img-responsive').attr("data-img-src");
        var projectNameactive = $(".gallery-main-div-inner-right-inner .thumbnil-img.active").prev('.thumbnil-img').find('.img-responsive').attr("data-project-name");
        var projectLocationactive = $(".gallery-main-div-inner-right-inner .thumbnil-img.active").prev('.thumbnil-img').find('.img-responsive').attr("data-project-location");
        $(".gallery-main-div-inner-right-inner .thumbnil-img.active").prev('.thumbnil-img').addClass("active");
        $(".gallery-main-div-inner-right-inner .thumbnil-img.active").nextAll('.thumbnil-img').removeClass("active");
        

      $(".gallery-img-div").find('.img-responsive').attr("src",bigimgactive);
      $(".gallery-img-main-div-inner").find('.gallery-img-div-inner-title').text(projectNameactive);
      $(".gallery-img-main-div-inner").find('.gallery-img-main-div-title').text(projectLocationactive);

    });

});

</script>
