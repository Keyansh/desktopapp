<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<div class="container-fluid">
    <div class="col-xs-12 find-location padding-zero">
        <p class="find-location-title col-xs-12 padding-zero">Find your local select Consort hardware <span>Supplier</span></p>
        <div class=" col-xs-12 padding-zero find-location-text">
            <p>As one of the leading garage door companies, we manufacture all of our doors to fit your exact specification.</p>
            <p>
                Simply enter your postcode/town below and we will find the closest agent’s in your local area – who will come and give you a free, no-obligation quote.
            </p>

        </div>
        <div class=" col-xs-12 padding-zero find-location-input">
            <form action="" method="post" id="distributor">
                <div class="input-group col-xs-6">

                    <!-- <input type="text" class="form-control" placeholder="W1U7DD" id="txtSearch" name="keywords" required /> -->
                    <select class="js-example-basic-multiple form-control js-states selecthome" id="txtSearch" name="keywords" width="100%">
                        <option></option>
                    </select>
                    <div class="input-group-btn">
                        <button class="btn " type="submit">
                            <span>Find Supplier</span> <i class="fa fa-search" aria-hidden="true"></i>
                        </button>
                    </div>


                </div>
                <p class="enter-post-code col-xs-6">enter your post code here.</p>
            </form>
            <div class="col-xs-12 key-html-homepage">

            </div>
        </div>

    </div>
</div>


<script>
    $("#distributor").submit(function(e) {

        e.preventDefault();
        e.stopImmediatePropagation() |
            $(".input-group-btn button span").text("finding..")

        $.ajax({
            url: '<?php echo base_url(); ?>distributor/HomepageSuppliers',
            type: "POST",
            data: $("#distributor").serialize(),
            success: function(data) {
                $(".input-group-btn button span").text("Find Supplier");
                var res = data;
                $(".key-html-homepage").html(res);
                $('#txtSearch').val('');

            }
        });


    });
</script>
<script src="http://maps.google.com/maps/api/js?key=" type="text/javascript"></script>
<script>
    $(document).ready(function() {

        $(".js-example-basic-multiple").select2({
            ajax: {
                url: "<?= base_url() ?>distributor/postcodes",
                type: "post",
                dataType: 'json',
                delay: 250,
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            },
            // placeholder: "Enter a Post Code",
            // allowClear: true

        });


        $(document).on("click", ".lpr-directions", function() {
            // $('.lpr-directions').click(function() {
            var to_url = 'https://www.google.com/maps/dir';

            var directions_from = new google.maps.LatLng($(this).data('from-lat'), $(this).data('from-lng'));
            var directions_to = new google.maps.LatLng($(this).data('to-lat'), $(this).data('to-lng'));

            to_url += '/' + directions_from.lat() + ',' + directions_from.lng();
            to_url += '/' + directions_to.lat() + ',' + directions_to.lng();
            window.open(to_url, '_blank');
            return false;
        })
    });
</script>