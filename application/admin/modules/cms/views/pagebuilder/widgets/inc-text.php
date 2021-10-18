form json for form field 

{
  "form": [
    {
      "label": "Title",
      "name": "displaytitle",
      "type": "radio",
      "options": [
        {
          "lable": "Yes",
          "value": "yes"
        },
        {
          "lable": "No",
          "value": "no"
        }
      ]
    },
    {
      "label": "Title Position",
      "name": "position",
      "type": "radio",
      "options": [
        {
          "lable": "Left",
          "value": "left"
        },
        {
          "lable": "Center",
          "value": "center"
        },
        {
          "lable": "Right",
          "value": "right"
        }
      ]
    },
    {
      "label": "Title Tag type ",
      "name": "titletype",
      "type": "radio",
      "options": [
        {
          "lable": "P",
          "value": "p"
        },
        {
          "lable": "H1",
          "value": "h1"
        },
        {
          "lable": "H2",
          "value": "h2"
        },
        {
          "lable": "H3",
          "value": "h3"
        },
        {
          "lable": "H4",
          "value": "h4"
        },
        {
          "lable": "H5",
          "value": "h5"
        }
      ]
    },
    {
      "label": "Font Size",
      "name": "fontsize",
      "type": "text",
      "file_count": "1"
    },
    {
      "label": "Padding",
      "name": "padding[]",
      "type": "text",
      "file_count": "4"
    },
    {
      "label": "Margin",
      "name": "margin[]",
      "type": "text",
      "file_count": "4"
    }
  ]
}


<section style="display: none;">




    <!-- slider -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

    <style>
        .slider-navigation {
            position: relative;
        }

        .slider-navigation .owl-prev {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);

        }

        .slider-navigation .owl-next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            right: 10px;

        }

        .slider-navigation .owl-next span,
        .slider-navigation .owl-prev span {
            font-size: 50px;
            line-height: normal;
        }
    </style>

    <!-- video -->

    <style>
        .iframe-thumb {
            position: relative;
        }

        .iframe-thumb::after {
            content: '\f04b';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 40px;
            font-family: FontAwesome;
            border: 3px solid black;
            border-radius: 50%;
            line-height: 22px;
            height: 80px;
            width: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            pointer-events: none;
        }
    </style>



    <script>
        $(document).on('click', '.iframe-thumb', function() {
            $(this).css('display', 'none');
            var iframeSrc = $(this).find('img').attr('data-video-iframe');
            $(this).parent('.video-main-div').find('iframe').attr('src', iframeSrc);
            $(this).parent('.video-main-div').find('.iframe-div').css('display', 'block');
        })
    </script>

    <!-- tabs -->

    <div class="tabs-main-div">

        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
            <li><a data-toggle="tab" href="#menu1">Menu 1</a></li>
            <li><a data-toggle="tab" href="#menu2">Menu 2</a></li>
        </ul>

        <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
                <h3>HOME</h3>
                <p>Some content.</p>
            </div>
            <div id="menu1" class="tab-pane fade">
                <h3>Menu 1</h3>
                <p>Some content in menu 1.</p>
            </div>
            <div id="menu2" class="tab-pane fade">
                <h3>Menu 2</h3>
                <p>Some content in menu 2.</p>
            </div>
        </div>

    </div>




    <!-- accordion -->



    <div class="accordion-main-div">
        <div class="panel-group" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                            Collapsible Group 1</a>
                    </h4>
                </div>
                <div id="collapse1" class="panel-collapse collapse in">
                    <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                        sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad
                        minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
                        commodo consequat.</div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
                            Collapsible Group 2</a>
                    </h4>
                </div>
                <div id="collapse2" class="panel-collapse collapse">
                    <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                        sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad
                        minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
                        commodo consequat.</div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
                            Collapsible Group 3</a>
                    </h4>
                </div>
                <div id="collapse3" class="panel-collapse collapse">
                    <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                        sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad
                        minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
                        commodo consequat.</div>
                </div>
            </div>
        </div>

    </div>



    <!-- usp -->


</section>


<!-- template with side bar -->






<!-- module element list html  -->


<div class="common-element-main-div" style="display: none;">
    <div class="col-xs-12 common-element-inner-div">
        <a href="#">
            <div class="image-div">
                <img src="" alt="" class="img-responsive">
            </div>
            <p class="common-title">
                common title
            </p>
            <div class="common-description">
                <p>
                    Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                    Quas rem eum nesciunt cumque possimus
                    suscipit illum praesentium nisi iure expedita ex consectetur
                    provident natus, omnis accusantium aliquid corporis iusto sapiente?</p>
            </div>
        </a>
    </div>
</div>

<!-- module element detail html  -->


<div class="common-element-detail-main-div" style="display: none;">
    <div class="col-xs-12 common-detail-element-inner-div">
        <div class="image-div">
            <img src="" alt="" class="img-responsive">
        </div>
        <p class="common-detail-title">
            common title
        </p>
        <div class="common-detail-description">
            <p>
                Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                Quas rem eum nesciunt cumque possimus
                suscipit illum praesentium nisi iure expedita ex consectetur
                provident natus, omnis accusantium aliquid corporis iusto sapiente?</p>
        </div>
    </div>
</div>