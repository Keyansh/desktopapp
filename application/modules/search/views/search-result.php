<section id="bredcrumbs">
    <div class=" container-fluid site-container">
        <div class="col-xs-12 product_main_div null-padding">
            <ul class="breadcrumb about_page">
                <li><a href="<?= base_url() ?>">Home</a></li>
                <li class="active"><a href="javascript:void(0)">Search</a></li>
            </ul>
        </div>
    </div>
</section>
<section id="product-listing-section">
    <div class="container-fluid site-container">
        <div class="fet-pro-inner col-sm-12 col-lg-12 search-main-col">
            <div class="row">
                <div class="col-md-1 pull-right">
                    <select name="showPerPage" class="form-control" id="showPerPage">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                        <option value="40">40</option>
                        <option value="50">50</option>
                    </select>
                </div>
            </div>
            <div class="f-products col-sm-12 col-lg-12 cateoryAjax searched-col">
                <!--products list here-->
            </div>
        </div>
    </div>

    <div align="center">
        <button id="load_more_button" class="btn btn-warning"><img width="30" src="images/ajax-loader.gif" class="animation_image" style="display: none;">Load More</button> <!-- load button -->
    </div>
</section>
<script type="text/javascript">
    var track_page = 1;
    var keyWord = '<?= $this->input->post('keywords'); ?>';
    var category = '<?= $this->input->post('category'); ?>';
    var perPage = $("#showPerPage").val();
    if (perPage != 0) {} else {
        perPage = 12;
    }

    $("#showPerPage").on('change', function(e) {
        track_page++;
        load_contents(track_page);
    });

    load_contents(track_page);

    $("#load_more_button").click(function(e) {
        track_page++;
        load_contents(track_page);
    });

    function load_contents(track_page) {
        $('.animation_image').show();

        $.post(DWS_BASE_URL + 'search/getProducts', {
            page: track_page,
            keyWord: keyWord,
            category: category,
            perPage: perPage
        }, function(data) {
            if (data.html != '') {
                $(".cateoryAjax").append(data.html);
            }
            if (data.count == 0) {
                $("#load_more_button").hide();
                $("#showPerPage").hide();
            } else {
                $("#load_more_button").show();
            }
            $('.animation_image').hide();

        }, 'JSON');
    }
</script>