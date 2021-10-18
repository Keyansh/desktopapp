<style>
    #find-location {
        display:none
}
</style>
<section id="single_product_col">
    <div class="container-fluid ">
        <div class="col-xs-12 product_main_div null-padding">
            <ul class="breadcrumb">
                <li><a href="<?=base_url()?>">Home</a></li>
                <li class="active"><a href="javascript:void(0)">Distributor Locator</a></li>
            </ul>
        </div>
    </div>
</section>



<section id="distributor">
    <div class="container-fluid">
        <?php foreach ($blocks as $block) {if ($block['type'] == 'distributor-block') {?>
                <?=$block['content']?>
        <?php }}?>
    </div>
</section>

<section id="distributor-search">
    <div class="container-fluid">
        <div class="distributor-search col-xs-12 null-padding">
            <form action="distributor" method="post">
      

        <div class="input-group col-xs-6 ">
                <input type="text" class="form-control" placeholder="Enter a Post Code" id="txtSearch" value="<?=$keywords?>" name="keywords" required/>
            <div class="input-group-btn">
                <button class="common-btn" type="submit">
                        Find Distributor
                </button>
            </div>
        </div>
        </form>
        </div>
    </div>
</section>



<section id="distributor-center">
    <div class="container-fluid">
        <div class="distributor-center col-xs-12 null-padding">
        <?php if (isset($search_result)) {?>
            <?php if ($search_result) {?>
            <div class="col-xs-12 map-address">
                <?php foreach ($search_result as $iteam) {?>
                    <div class="map-address-inner">
                    <p class="map-title">
                    <?=$iteam['distribution_name']?>
                    </p>
                    <p class="address-map-text">
                        <?=$iteam['distribution_location']?><br>
                        <?=$iteam['distribution_location_2']?>
                    </p>
                    <p class="map-city">
                    <?=$iteam['distribution_city']?> <?=$iteam['distribution_county']?> <?=$iteam['distribution_pcode']?><br>
                    <?=$iteam['distribution_country']?>
                    </p>
                    </div>
                <?php }?>
                </div>
                <script src="http://maps.google.com/maps/api/js?key=AIzaSyCPWcygHBvCxccKLseEjB7s9XCAzmxhO1I" type="text/javascript"></script>
                <div id="map" style="width: 100%; height: 700px;"></div>
                <?php } else {?>
                    <p class="no-record">no record found</p>
                <?php }?>
                <?php } ?>
        </div>
    </div>
</section>



<script type="text/javascript">
var locations = [

                <?php foreach ($search_result as $iteam) {?>
                    ['<?=$iteam['distribution_name']?>', <?=$iteam['distribution_latitude']?>, <?=$iteam['distribution_longitude']?>, 1],
                <?php }?>

            ];


    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 10,
      center: new google.maps.LatLng(52.476246, -1.869564),
      mapTypeId: 'roadmap'
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    for (i = 0; i < locations.length; i++) {
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map
      });

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][0]);
          infowindow.open(map, marker);
        }
      })(marker, i));
    }
  </script>







