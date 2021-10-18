<link href="<?= base_url(); ?>assets/helpers/cstyle.css" rel="stylesheet" type="text/css" />
<style>
    .wrapper.col-2 {
        display: inline-block;
        min-height: 256px;
        width: 100%;
    }

    .content {
        max-width: none;
        margin: 0;
        padding: 16px 6px;
        overflow: auto;
    }

    .wrapper.col-2 {
        min-height: 432px;
        padding-top: 0;
    }

    .graph-action {
        display: table;
        float: right;
    }

    ul.graph-actions>li {
        padding: 0px;
    }

    ul.graph-actions>li:first-child {
        padding: 0px 6px 0 0;
        position: relative;
        top: 1px;
        font-size: 15px;
        font-weight: bold;
    }

    .list-inline.graph-actions {
        text-align: right;
    }

    /*    .graph-action-col {
        padding: 0 13px 0 13px;
    }*/
    ul.graph-actions>li span {
        border-radius: 0;
    }



    .graph-actionss {
        background: #FAFCFE;
        height: 25px;
        position: relative;
        top: 23px;
        z-index: 1111111;
    }

    .graph-head {
        text-align: center;
    }


</style>
<div id="page-title">
    <!-- <h2 style="text-align: center;margin-top: 20px;font-size: 30px;">Dashboard</h2> -->
    <h2 style="text-align: center;margin-top: 20px;font-size: 35px;">welcome to consort hardware admin panel</h2>


    <!-- <div id="theme-options" class="admin-options"> <a href="javascript:void(0);" class="btn btn-primary theme-switcher tooltip-button" data-placement="left" title="Color schemes and layout options"> <i class="glyph-icon icon-linecons-cog icon-spin"></i> </a> <div id="theme-switcher-wrapper"> <div class="scroll-switcher"> <h5 class="header">Layout options</h5> <ul class="reset-ul"> <li> <label for="boxed-layout">Boxed layout</label> <input type="checkbox" data-toggletarget="boxed-layout" id="boxed-layout" class="input-switch-alt"> </li><li> <label for="fixed-header">Fixed header</label> <input type="checkbox" data-toggletarget="fixed-header" id="fixed-header" class="input-switch-alt"> </li><li> <label for="fixed-sidebar">Fixed sidebar</label> <input type="checkbox" data-toggletarget="fixed-sidebar" id="fixed-sidebar" class="input-switch-alt"> </li><li> <label for="closed-sidebar">Closed sidebar</label> <input type="checkbox" data-toggletarget="closed-sidebar" id="closed-sidebar" class="input-switch-alt"> </li></ul> <div class="boxed-bg-wrapper hide"> <h5 class="header"> Boxed Page Background <a class="set-background-style" data-header-bg="" title="Remove all styles" href="javascript:void(0);">Clear</a> </h5> <div class="theme-color-wrapper clearfix"> <h5>Patterns</h5> <a class="tooltip-button set-background-style pattern-bg-3" data-header-bg="pattern-bg-3" title="Pattern 3" href="javascript:void(0);">Pattern 3</a> <a class="tooltip-button set-background-style pattern-bg-4" data-header-bg="pattern-bg-4" title="Pattern 4" href="javascript:void(0);">Pattern 4</a> <a class="tooltip-button set-background-style pattern-bg-5" data-header-bg="pattern-bg-5" title="Pattern 5" href="javascript:void(0);">Pattern 5</a> <a class="tooltip-button set-background-style pattern-bg-6" data-header-bg="pattern-bg-6" title="Pattern 6" href="javascript:void(0);">Pattern 6</a> <a class="tooltip-button set-background-style pattern-bg-7" data-header-bg="pattern-bg-7" title="Pattern 7" href="javascript:void(0);">Pattern 7</a> <a class="tooltip-button set-background-style pattern-bg-8" data-header-bg="pattern-bg-8" title="Pattern 8" href="javascript:void(0);">Pattern 8</a> <a class="tooltip-button set-background-style pattern-bg-9" data-header-bg="pattern-bg-9" title="Pattern 9" href="javascript:void(0);">Pattern 9</a> <a class="tooltip-button set-background-style pattern-bg-10" data-header-bg="pattern-bg-10" title="Pattern 10" href="javascript:void(0);">Pattern 10</a> <div class="clear"></div><h5 class="mrg15T">Solids &amp;Images</h5> <a class="tooltip-button set-background-style bg-black" data-header-bg="bg-black" title="Black" href="javascript:void(0);">Black</a> <a class="tooltip-button set-background-style bg-gray mrg10R" data-header-bg="bg-gray" title="Gray" href="javascript:void(0);">Gray</a> <a class="tooltip-button set-background-style full-bg-1" data-header-bg="full-bg-1 fixed-bg" title="Image 1" href="javascript:void(0);">Image 1</a> <a class="tooltip-button set-background-style full-bg-2" data-header-bg="full-bg-2 fixed-bg" title="Image 2" href="javascript:void(0);">Image 2</a> <a class="tooltip-button set-background-style full-bg-3" data-header-bg="full-bg-3 fixed-bg" title="Image 3" href="javascript:void(0);">Image 3</a> <a class="tooltip-button set-background-style full-bg-4" data-header-bg="full-bg-4 fixed-bg" title="Image 4" href="javascript:void(0);">Image 4</a> <a class="tooltip-button set-background-style full-bg-5" data-header-bg="full-bg-5 fixed-bg" title="Image 5" href="javascript:void(0);">Image 5</a> <a class="tooltip-button set-background-style full-bg-6" data-header-bg="full-bg-6 fixed-bg" title="Image 6" href="javascript:void(0);">Image 6</a> </div></div><h5 class="header"> Header Style <a class="set-adminheader-style" data-header-bg="bg-gradient-9" title="Remove all styles" href="javascript:void(0);">Clear</a> </h5> <div class="theme-color-wrapper clearfix"> <h5>Solids</h5> <a class="tooltip-button set-adminheader-style bg-primary" data-header-bg="bg-primary font-inverse" title="Primary" href="javascript:void(0);">Primary</a> <a class="tooltip-button set-adminheader-style bg-green" data-header-bg="bg-green font-inverse" title="Green" href="javascript:void(0);">Green</a> <a class="tooltip-button set-adminheader-style bg-red" data-header-bg="bg-red font-inverse" title="Red" href="javascript:void(0);">Red</a> <a class="tooltip-button set-adminheader-style bg-blue" data-header-bg="bg-blue font-inverse" title="Blue" href="javascript:void(0);">Blue</a> <a class="tooltip-button set-adminheader-style bg-warning" data-header-bg="bg-warning font-inverse" title="Warning" href="javascript:void(0);">Warning</a> <a class="tooltip-button set-adminheader-style bg-purple" data-header-bg="bg-purple font-inverse" title="Purple" href="javascript:void(0);">Purple</a> <a class="tooltip-button set-adminheader-style bg-black" data-header-bg="bg-black font-inverse" title="Black" href="javascript:void(0);">Black</a> <div class="clear"></div><h5 class="mrg15T">Gradients</h5> <a class="tooltip-button set-adminheader-style bg-gradient-1" data-header-bg="bg-gradient-1 font-inverse" title="Gradient 1" href="javascript:void(0);">Gradient 1</a> <a class="tooltip-button set-adminheader-style bg-gradient-2" data-header-bg="bg-gradient-2 font-inverse" title="Gradient 2" href="javascript:void(0);">Gradient 2</a> <a class="tooltip-button set-adminheader-style bg-gradient-3" data-header-bg="bg-gradient-3 font-inverse" title="Gradient 3" href="javascript:void(0);">Gradient 3</a> <a class="tooltip-button set-adminheader-style bg-gradient-4" data-header-bg="bg-gradient-4 font-inverse" title="Gradient 4" href="javascript:void(0);">Gradient 4</a> <a class="tooltip-button set-adminheader-style bg-gradient-5" data-header-bg="bg-gradient-5 font-inverse" title="Gradient 5" href="javascript:void(0);">Gradient 5</a> <a class="tooltip-button set-adminheader-style bg-gradient-6" data-header-bg="bg-gradient-6 font-inverse" title="Gradient 6" href="javascript:void(0);">Gradient 6</a> <a class="tooltip-button set-adminheader-style bg-gradient-7" data-header-bg="bg-gradient-7 font-inverse" title="Gradient 7" href="javascript:void(0);">Gradient 7</a> <a class="tooltip-button set-adminheader-style bg-gradient-8" data-header-bg="bg-gradient-8 font-inverse" title="Gradient 8" href="javascript:void(0);">Gradient 8</a> </div><h5 class="header"> Sidebar Style <a class="set-sidebar-style" data-header-bg="" title="Remove all styles" href="javascript:void(0);">Clear</a> </h5> <div class="theme-color-wrapper clearfix"> <h5>Solids</h5> <a class="tooltip-button set-sidebar-style bg-primary" data-header-bg="bg-primary font-inverse" title="Primary" href="javascript:void(0);">Primary</a> <a class="tooltip-button set-sidebar-style bg-green" data-header-bg="bg-green font-inverse" title="Green" href="javascript:void(0);">Green</a> <a class="tooltip-button set-sidebar-style bg-red" data-header-bg="bg-red font-inverse" title="Red" href="javascript:void(0);">Red</a> <a class="tooltip-button set-sidebar-style bg-blue" data-header-bg="bg-blue font-inverse" title="Blue" href="javascript:void(0);">Blue</a> <a class="tooltip-button set-sidebar-style bg-warning" data-header-bg="bg-warning font-inverse" title="Warning" href="javascript:void(0);">Warning</a> <a class="tooltip-button set-sidebar-style bg-purple" data-header-bg="bg-purple font-inverse" title="Purple" href="javascript:void(0);">Purple</a> <a class="tooltip-button set-sidebar-style bg-black" data-header-bg="bg-black font-inverse" title="Black" href="javascript:void(0);">Black</a> <div class="clear"></div><h5 class="mrg15T">Gradients</h5> <a class="tooltip-button set-sidebar-style bg-gradient-1" data-header-bg="bg-gradient-1 font-inverse" title="Gradient 1" href="javascript:void(0);">Gradient 1</a> <a class="tooltip-button set-sidebar-style bg-gradient-2" data-header-bg="bg-gradient-2 font-inverse" title="Gradient 2" href="javascript:void(0);">Gradient 2</a> <a class="tooltip-button set-sidebar-style bg-gradient-3" data-header-bg="bg-gradient-3 font-inverse" title="Gradient 3" href="javascript:void(0);">Gradient 3</a> <a class="tooltip-button set-sidebar-style bg-gradient-4" data-header-bg="bg-gradient-4 font-inverse" title="Gradient 4" href="javascript:void(0);">Gradient 4</a> <a class="tooltip-button set-sidebar-style bg-gradient-5" data-header-bg="bg-gradient-5 font-inverse" title="Gradient 5" href="javascript:void(0);">Gradient 5</a> <a class="tooltip-button set-sidebar-style bg-gradient-6" data-header-bg="bg-gradient-6 font-inverse" title="Gradient 6" href="javascript:void(0);">Gradient 6</a> <a class="tooltip-button set-sidebar-style bg-gradient-7" data-header-bg="bg-gradient-7 font-inverse" title="Gradient 7" href="javascript:void(0);">Gradient 7</a> <a class="tooltip-button set-sidebar-style bg-gradient-8" data-header-bg="bg-gradient-8 font-inverse" title="Gradient 8" href="javascript:void(0);">Gradient 8</a> </div></div></div></div> -->

</div>

<div class="row">




    <div class="col-xs-12 dashboard">
        <ul class="dashboard-ul" style="display: none;">
            <li>
                <div class="icon-wrapper">
                    <div class="icon-top">
                        <i class="fa fa-2x fa-stack-exchange"></i>
                        <br>
                        Manage Categories
                    </div>
                    <div class="icon-below">
                        <div class="icon-below-left">
                            <a href="catalog/category/"><i class="fa fa-list"></i> Manage</a>
                        </div>
                        <div class="icon-below-right">
                            <a href="catalog/category/add/"><i class="fa fa-plus"></i> Add New</a>
                        </div>
                        <div style="clear: both"></div>
                    </div>
                </div>
            </li>
            <li>
                <div class="icon-wrapper">
                    <div class="icon-top">
                        <i class="fa fa-2x fa-stack-exchange"></i>
                        <br>
                        Manage Certifications
                    </div>
                    <div class="icon-below">
                        <div class="icon-below-left">
                            <a href="certification/"><i class="fa fa-list"></i> Manage</a>
                        </div>
                        <div class="icon-below-right">
                            <a href="certification/add/"><i class="fa fa-plus"></i> Add New</a>
                        </div>
                        <div style="clear: both"></div>
                    </div>
                </div>
            </li>
            <li>
                <div class="icon-wrapper">
                    <div class="icon-top">
                        <i class="fa fa-2x fa-list"></i>
                        <br>
                        Manage Attributes
                    </div>
                    <div class="icon-below">
                        <div class="icon-below-left">
                            <a href="catalog/attribute/"><i class="fa fa-list"></i> Manage</a>
                        </div>
                        <div class="icon-below-right">
                            <a href="catalog/attribute/add/"><i class="fa fa-plus"></i> Add New</a>
                        </div>
                        <div style="clear: both"></div>
                    </div>
                </div>
            </li>
            <li>
                <div class="icon-wrapper">
                    <div class="icon-top">
                        <i class="fa fa-2x fa-bars"></i>
                        <br>
                        Manage Attribute Set
                    </div>
                    <div class="icon-below">
                        <div class="icon-below-left">
                            <a href="catalog/attrset/"><i class="fa fa-list"></i> Manage</a>
                        </div>
                        <div class="icon-below-right">
                            <a href="catalog/attrset/add/"><i class="fa fa-plus"></i> Add New</a>
                        </div>
                        <div style="clear: both"></div>
                    </div>
                </div>
            </li>
            <li>
                <div class="icon-wrapper">
                    <div class="icon-top">
                        <i class="fa fa-2x fa-coffee"></i>
                        <br>
                        Manage Products
                    </div>
                    <div class="icon-below">
                        <div class="icon-below-left">
                            <a href="catalognew/product/"><i class="fa fa-list"></i> Manage</a>
                        </div>
                        <div class="icon-below-right">
                            <a href="catalognew/product/add/"><i class="fa fa-plus"></i> Add New</a>
                        </div>
                        <div style="clear: both"></div>
                    </div>
                </div>
            </li>
            <li>
                <div class="icon-wrapper">
                    <div class="icon-top">
                        <i class="fa fa-2x fa-coffee"></i>
                        <br>
                        Manage Projects
                    </div>
                    <div class="icon-below">
                        <div class="icon-below-left">
                            <a href="projects"><i class="fa fa-list"></i> Manage</a>
                        </div>
                        <div class="icon-below-right">
                            <a href="projects/add/"><i class="fa fa-plus"></i> Add New</a>
                        </div>
                        <div style="clear: both"></div>
                    </div>
                </div>
            </li>
            <li>
                <div class="icon-wrapper">
                    <div class="icon-top">
                        <i class="fa fa-2x fa-coffee"></i>
                        <br>
                        Manage Download
                    </div>
                    <div class="icon-below">
                        <div class="icon-below-left">
                            <a href="download"><i class="fa fa-list"></i> Manage</a>
                        </div>
                        <div class="icon-below-right">
                            <a href="download/add/"><i class="fa fa-plus"></i> Add New</a>
                        </div>
                        <div style="clear: both"></div>
                    </div>
                </div>
            </li>
            <li>
                <div class="icon-wrapper">
                    <div class="icon-top">
                        <i class="fa fa-2x fa-coffee"></i>
                        <br>
                        Manage Projects Type
                    </div>
                    <div class="icon-below">
                        <div class="icon-below-left">
                            <a href="projecttype"><i class="fa fa-list"></i> Manage</a>
                        </div>
                        <div class="icon-below-right">
                            <a href="projecttype/add/"><i class="fa fa-plus"></i> Add New</a>
                        </div>
                        <div style="clear: both"></div>
                    </div>
                </div>
            </li>
            <!-- <li>
                <div class="icon-wrapper">
                    <div class="icon-top">
                        <i class="fa fa-2x fa-coffee"></i>
                        <br>
                        Manage Address
                    </div>
                    <div class="icon-below">
                        <div class="icon-below-left">
                            <a href="contactus"><i class="fa fa-list"></i> Manage</a>
                        </div>
                        <div class="icon-below-right">
                            <a href="contactus/add/"><i class="fa fa-plus"></i> Add New</a>
                        </div>
                        <div style="clear: both"></div>
                    </div>
                </div>
            </li> -->
            <li>
                <div class="icon-wrapper">
                    <div class="icon-top">
                        <i class="fa fa-2x fa-users"></i>
                        <br>
                        Manage Newsletter
                    </div>
                    <div class="icon-below">
                        <div class="icon-below-full">
                            <a href="newsletter"><i class="fa fa-wrench"></i> Manage</a>
                        </div>

                        <div style="clear: both"></div>
                    </div>
                </div>
            </li>
            <li>
                <div class="icon-wrapper">
                    <div class="icon-top">
                        <i class="fa fa-2x fa-desktop"></i>
                        <br>
                        Manage Forms
                    </div>
                    <div class="icon-below">
                        <div class="icon-below-left">
                            <a href="forms"><i class="fa fa-list"></i> Manage Forms</a>
                        </div>
                        <div class="icon-below-right">
                            <a href="forms/submissions"><i class="fa fa-plus"></i> Submissions</a>
                        </div>
                        <div style="clear: both"></div>
                    </div>
                </div>
            </li>
            <li>
                <div class="icon-wrapper">
                    <div class="icon-top">
                        <i class="fa fa-2x fa-desktop"></i>
                        <br>
                        Manage Slider
                    </div>
                    <div class="icon-below">
                        <div class="icon-below-left">
                            <a href="slideshow"><i class="fa fa-list"></i> Manage</a>
                        </div>
                        <div class="icon-below-right">
                            <a href="slideshow/add/"><i class="fa fa-plus"></i> Add New</a>
                        </div>
                        <div style="clear: both"></div>
                    </div>
                </div>
            </li>

            <li>
                <div class="icon-wrapper">
                    <div class="icon-top">
                        <i class="fa fa-2x fa-users"></i>
                        <br>
                        Manage Contact Enquiries
                    </div>
                    <div class="icon-below">
                        <div class="icon-below-full">
                            <a href="enquiry"><i class="fa fa-wrench"></i> Manage</a>
                        </div>

                        <div style="clear: both"></div>
                    </div>
                </div>
            </li>
            <li>
                <div class="icon-wrapper">
                    <div class="icon-top">
                        <i class="fa fa-2x fa-users"></i>
                        <br>
                        Manage Product Enquiries
                    </div>
                    <div class="icon-below">
                        <div class="icon-below-full">
                            <a href="productenquiries"><i class="fa fa-wrench"></i> Manage</a>
                        </div>

                        <div style="clear: both"></div>
                    </div>
                </div>
            </li>
            <!-- <li>
                <div class="icon-wrapper">
                    <div class="icon-top">
                        <i class="fa fa-2x fa-users"></i>
                        <br>
                        Manage Header and Footer
                    </div>
                    <div class="icon-below">
                        <div class="icon-below-full">
                            <a href="headerandfooter"><i class="fa fa-wrench"></i> Manage</a>
                        </div>

                        <div style="clear: both"></div>
                    </div>
                </div>
            </li> -->
            <li>
                <div class="icon-wrapper">
                    <div class="icon-top">
                        <i class="fa fa-2x fa-users"></i>
                        <br>
                        Manage Testimonials
                    </div>
                    <div class="icon-below">
                        <div class="icon-below-left">
                            <a href="testimonial"><i class="fa fa-list"></i> Manage</a>
                        </div>
                        <div class="icon-below-right">
                            <a href="testimonial/add"><i class="fa fa-plus"></i> Add New</a>
                        </div>
                        <div style="clear: both"></div>
                    </div>
                </div>
            </li>
            <li>
                <div class="icon-wrapper">
                    <div class="icon-top">
                        <i class="fa fa-desktop fa-2x"></i>
                        <br>
                        Manage Menus
                    </div>
                    <div class="icon-below">
                        <div class="icon-below-left">
                            <a href="cms/menu"><i class="fa fa-list"></i> Manage</a>
                        </div>
                        <div class="icon-below-right">
                            <a href="cms/menu/add"><i class="fa fa-plus"></i> Add</a>
                        </div>
                        <div style="clear: both"></div>
                    </div>
                </div>
            </li>
            <li>
                <div class="icon-wrapper">
                    <div class="icon-top">
                        <i class="fa fa-cog fa-2x"></i>
                        <br>
                        Manage Config
                    </div>
                    <div class="icon-below">
                        <div class="icon-below-full">
                            <a href="setting/settings"><i class="fa fa-wrench"></i> Manage</a>
                        </div>

                        <div style="clear: both"></div>
                    </div>
                </div>
            </li>
            <li>
                <div class="icon-wrapper">
                    <div class="icon-top">
                        <i class="fa fa-cog fa-2x"></i>
                        <br>
                        Design Config
                    </div>
                    <div class="icon-below">
                        <div class="icon-below-full">
                            <a href="setting/design"><i class="fa fa-wrench"></i> Manage</a>
                        </div>

                        <div style="clear: both"></div>
                    </div>
                </div>
            </li>
            <li>
                <div class="icon-wrapper">
                    <div class="icon-top">
                        <i class="fa fa-cog fa-2x"></i>
                        <br>
                        Manage CMS
                    </div>
                    <div class="icon-below">
                        <div class="icon-below-full">
                            <a href="cms/page"><i class="fa fa-wrench"></i> Manage </a>
                        </div>

                        <div style="clear: both"></div>
                    </div>
                </div>
            </li>
            <li>
                <div class="icon-wrapper">
                    <div class="icon-top">
                        <i class="fa fa-cog fa-2x"></i>
                        <br>
                        Manage System Pages
                    </div>
                    <div class="icon-below">
                        <div class="icon-below-full">
                            <a href="cms/page/systemPages"><i class="fa fa-wrench"></i> Manage </a>
                        </div>

                        <div style="clear: both"></div>
                    </div>
                </div>
            </li>


        </ul>
    </div>